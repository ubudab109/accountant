<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Alert;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Absensi;
use App\Models\Pegawai;

class AbsensiController extends Controller
{

    public $model;

    public function __construct(Absensi $model)
    {
        $this->model = $model;
    }


    public function getAbsensi(Request $request)
    {
        $data = $this->model->with('pegawai:id_pegawai,nama_pegawai')->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('pegawai', function ($row) {
                    return $row->id_pgw . ' | ' . $row->pegawai->nama_pegawai;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" onClick="destroy(' . $row->id . ')" class="delete btn btn-danger btn-sm">Hapus</a>';
                    return $actionBtn;
                })
                ->rawColumns(['akun', 'kredit', 'debit', 'date', 'keterangan', 'action'])
                ->make(true);
        }
    }


    public function getReportAbsensi(Request $request)
    {

        if ($request->ajax()) {
            $absen = $this->model->with('pegawai:id_pegawai,nama_pegawai')->select('tgl_rekap', 'id_pgw', DB::raw('sum(hadir) as total_hadir, sum(sakit) as total_sakit, sum(cuti) as total_cuti',));

            $absen->when($request->startDate && $request->endDate, function ($query) use ($request) {
                $query->whereBetween('tgl_rekap', [$request->startDate, $request->endDate]);
            });

            $data = $absen->groupBy('id_pgw')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('pegawai', function ($row) {
                    return $row->id_pgw . ' | ' . $row->pegawai->nama_pegawai;
                })
                ->rawColumns(['pegawai'])
                ->make(true);
        }
        return view('pages.report-absen');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.rekap-absen');
    }

    public function reportAbsensi()
    {
        return view('pages.report-absen');
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
            'tgl_rekap' => 'required',
            'id_pgw' => 'required',
            'hadir' => 'nullable|numeric',
            'sakit' => 'nullable|numeric',
            'cuti' => 'nullable|numeric'
        ]);

        if ($validate->fails()) {
            return response()->json(false);
        }



        DB::beginTransaction();
        try {
            $input = $request->all();
            if ($request->cuti) {
                $pegawai = Pegawai::where('id_pegawai', $request->id_pgw)->first();
                $jumlahCuti = $pegawai->jumlah_cuti - $request->cuti;
                if ($request->cuti > $pegawai->jumlah_cuti) {
                    return response()->json(false);
                }
                $pegawai->update(['jumlah_cuti' => $jumlahCuti]);
            }
            $this->model->create($input);
            DB::commit();
            return response()->json(true);
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(false);
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
        DB::beginTransaction();
        try {
            $this->model->find($id)->delete();
            DB::commit();
            return true;
        } catch (Exception $err) {
            DB::rollback();
            return false;
        }
    }
}
