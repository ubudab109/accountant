<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailJurnal;
use App\Models\Jurnal;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Alert;
use Exception;
use Illuminate\Support\Facades\DB;


class JurnalController extends Controller
{

    public $model, $detail;

    public function __construct(Jurnal $model, DetailJurnal $detail)
    {
        $this->model = $model;
        $this->detail = $detail;
    }

    public function getReportJurnal(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->detail->with('jurnal:no_jurnal,tanggal')->select('no_jurnal', DB::raw('sum(kredit) as total_kredit, sum(debit) as total_debit'))->when($request->startDate && $request->endDate, function ($query) use ($request) {
                $query->whereHas('jurnal', function ($jurnal) use ($request) {
                    $jurnal->whereBetween('tanggal', [$request->startDate, $request->endDate]);
                });
            })->groupBy('no_jurnal')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('total_kredit', function ($row) {
                    return rupiah($row->total_kredit);
                })
                ->editColumn('total_debit', function ($row) {
                    return rupiah($row->total_debit);
                })
                ->editColumn('tanggal', function ($row) {
                    return $row->jurnal->tanggal;
                })
                ->rawColumns(['total_kredit', 'total_debit'])
                ->make(true);
        }

        return view('pages.report-jurnal');
    }


    public function getJurnal(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->detail->with('jurnal')->with('akun')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('akun', function ($row) {
                    return $row->no_akun . ' | ' . $row->akun->nama_akun;
                })
                ->editColumn('kredit', function ($row) {
                    return rupiah($row->kredit);
                })
                ->editColumn('debit', function ($row) {
                    return rupiah($row->debit);
                })
                ->editColumn('date', function ($row) {
                    return $row->jurnal->tanggal;
                })
                ->editColumn('keterangan', function ($row) {
                    return $row->jurnal->keterangan;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" onClick="destroy(' . $row->id . ')" class="delete btn btn-danger btn-sm">Hapus</a>';
                    return $actionBtn;
                })
                ->rawColumns(['akun', 'kredit', 'debit', 'date', 'keterangan', 'action'])
                ->make(true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.jurnal');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'no_jurnal' => 'required',
            'tanggal' => 'required',
            'kode_gaji' => 'required',
            'keterangan' => 'nullable',
            'akun' => 'required|array',
        ]);

        if ($validate->fails()) {
            Alert::error('Gagal', 'Silahkan isi semua form');
            return redirect()->back()->withInput();
        }

        DB::beginTransaction();
        try {
            $input = $request->all();
            $jurnal = $this->model->create($input);
            foreach ($request->akun as $key => $value) {
                $dataDetail = [
                    'no_jurnal' => $jurnal->no_jurnal,
                    'no_akun' => $request->akun[$key]['no_akun'],
                    'kredit' => $request->akun[$key]['kredit'],
                    'debit' => $request->akun[$key]['debit'],
                ];
                $jurnal->detailJurnal()->create($dataDetail);
            }
            Alert::success('Sukses', 'Data Berhasil Ditambah');
            DB::commit();
            return redirect()->back();
        } catch (Exception $err) {
            Alert::error('Gagal', 'Silahkan Periksa Inputan Data');
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->detail->find($id)->delete();
            DB::commit();
            return true;
        } catch (Exception $err) {
            DB::rollBack();
            return false;
        }
    }
}
