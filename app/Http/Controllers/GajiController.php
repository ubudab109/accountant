<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Alert;
use Exception;
use Illuminate\Support\Facades\DB;

class GajiController extends Controller
{

    public $model;

    public function __construct(Gaji $model)
    {
        $this->model = $model;
    }


    public function getReportGaji(Request $request)
    {
        if ($request->ajax()) {
            $gaji = $this->model->when($request->startDate && $request->endDate, function ($query) use ($request) {
                $query->whereBetween('tanggal', [$request->startDate, $request->endDate]);
            });

            $data = $gaji->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('pegawai', function ($row) {
                    return $row->pegawai->id_pegawai . ' | ' . $row->pegawai->nama_pegawai;
                })
                ->editColumn('gaji_pokok', function ($row) {
                    return rupiah($row->gaji_pokok);
                })
                ->editColumn('potongan', function ($row) {
                    return rupiah($row->potongan);
                })
                ->editColumn('bonus', function ($row) {
                    return rupiah($row->bonus);
                })
                ->editColumn('total_gaji', function ($row) {
                    return rupiah($row->total_gaji);
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" onClick="destroy(' . $row->id . ')" class="delete btn btn-danger btn-sm">Hapus</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'pegawai', 'gaji_pokok', 'potongan', 'bonus', 'total_gaji'])
                ->make(true);
        }

        return view('pages.report-gaji');
    }


    public function getGaji(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->model->all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('pegawai', function ($row) {
                    return $row->pegawai->id_pegawai . ' | ' . $row->pegawai->nama_pegawai;
                })
                ->editColumn('gaji_pokok', function ($row) {
                    return rupiah($row->gaji_pokok);
                })
                ->editColumn('potongan', function ($row) {
                    return rupiah($row->potongan);
                })
                ->editColumn('bonus', function ($row) {
                    return rupiah($row->bonus);
                })
                ->editColumn('total_gaji', function ($row) {
                    return rupiah($row->total_gaji);
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" onClick="destroy(' . $row->id . ')" class="delete btn btn-danger btn-sm">Hapus</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'pegawai', 'gaji_pokok', 'potongan', 'bonus', 'total_gaji'])
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
        return view('pages.gaji');
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
            'kode_gaji' => 'required',
            'tanggal' => 'required',
            'kode_pegawai' => 'required',
            'gaji_pokok' => 'required|numeric',
            'potongan' => 'nullable|numeric',
            'bonus' => 'nullable|numeric',
            'total_gaji' => 'nullable',
        ]);




        if ($validate->fails()) {
            Alert::error('Gagal', 'Silahkan isi semua form');
            return redirect()->back()->withInput();
        }

        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['total_gaji'] = $request->gaji_pokok - $request->potongan + $request->bonus;
            $this->model->create($input);
            Alert::success('Sukses', 'Data Berhasil Ditambah');
            DB::commit();
            return redirect()->back();
        } catch (Exception $err) {
            Alert::error('Gagal', 'Nomor Gaji Sudah Tersedia');
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
