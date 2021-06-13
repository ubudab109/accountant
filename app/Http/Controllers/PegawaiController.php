<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Alert;
use Exception;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    public $model;

    public function __construct(Pegawai $model)
    {
        $this->model = $model;
    }


    public function getPegawai(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->model->all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('id_pegawai', function ($row) {
                    return $row->id_pegawai;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                <a href="javascript:void(0)" class="edit btn btn-success btn-sm" onClick="show(' . $row->id . ')" data-toggle="modal" data-target="#edit">Edit</a>
                <a href="javascript:void(0)" onClick="destroy(' . $row->id . ')" class="delete btn btn-danger btn-sm">Hapus</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'id_pegawai'])
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
        return view('pages.pegawai');
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
            'id_pegawai' => 'required',
            'nama_pegawai' => 'required',
            'jabatan' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        if ($validate->fails()) {
            Alert::error('Gagal', 'Silahkan isi semua form');
            return redirect()->back()->withErrors('Data Harus Diisi Semua')->withInput();
        }
        DB::beginTransaction();
        try {
            $input = $request->all();
            $this->model->create($input);
            Alert::success('Sukses', 'Data Berhasil Ditambah');
            DB::commit();
            return redirect()->back();
        } catch (Exception $err) {
            Alert::error('Gagal', 'ID Pegawai Sudah Tersedia');
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
        return $this->model->find($id);
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
        $validate = Validator::make($request->all(), [
            'id_pegawai' => 'required',
            'nama_pegawai' => 'required',
            'jabatan' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'jumlah_cuti' => 'nullable',
        ]);

        if ($validate->fails()) {
            Alert::error('Gagal', 'Silahkan isi semua form');
            return redirect()->back()->withErrors('Data Harus Diisi Semua')->withInput();
        }
        DB::beginTransaction();
        try {
            $input = $request->all();
            $this->model->find($id)->update($input);
            Alert::success('Sukses', 'Data Berhasil Diubah');
            DB::commit();
            return redirect()->back();
        } catch (Exception $err) {
            Alert::error('Gagal', 'ID Pegawai Sudah Tersedia');
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
            $this->model->find($id)->delete();
            DB::commit();
            return true;
        } catch (Exception $err) {
            DB::rollback();
            return false;
        }
    }
}
