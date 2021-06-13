@extends('layouts.master')

@section('content')
<div class="row">
    @php
        $pegawai = \App\Models\Pegawai::all();
    @endphp
    <div class="col-12">
        <div class="card">
            <div class="card-title text-center">
                <h3>Absen Pegawai</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4 p-2">
                      <select id="pegawai_id" class="form-control">
                        <option selected disabled>Pilih Pegawai...</option>
                        @foreach ($pegawai as $item)
                            <option value="{{$item->id_pegawai}}">{{$item->id_pegawai}} | {{$item->nama_pegawai}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-4 p-2">
                        <input type="date" id="tgl_rekap" name="tgl_rekap" class="form-control">
                      </div>
                    <div class="form-group col-md-4 p-2 mr-4">
                        <button type="submit" id="btn-hadir" class="btn btn-primary btn-sm mr-4">Hadir</button>
                        <button type="submit" id="btn-sakit" class="btn btn-primary btn-sm">Sakit</button>
                        <button type="submit" id="btn-cuti" class="btn btn-primary btn-sm">Cuti</button>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <hr />
                    <div class="table-responsive">
                        <table id="absensi" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Tanggal Rekap</th>
                                <th>Pegawai</th>
                                <th>Hadir</th>
                                <th>Sakit</th>
                                <th>Cuti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(() => {
            var table = $("#absensi").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('absen.list')}}",
                columns: [
                    {data:'tgl_rekap',name:'tgl_rekap'},
                    {data:'pegawai',name:'pegawai'},
                    {data:'hadir',name:'hadir'},
                    {data:'sakit',name:'sakit'},
                    {data:'cuti',name:'cuti'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ],
            })


        $("#btn-hadir").on('click',((e) => {
            e.preventDefault();
            var pegawai = document.getElementById('pegawai_id').value;
            var date = document.getElementById('tgl_rekap').value;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('absen.store')}}",
                type: 'POST',
                data: {
                    id_pgw: pegawai,
                    tgl_rekap: date,
                    hadir: 1
                },
                success: function (res) {
                    swal({
                        title: "Sukses!",
                        text: "Data Berhasil Ditambah!",
                        icon: "success",
                    }).then((value) => {
                        table.draw();
                        document.getElementById('pegawai_id').value = '';
                        document.getElementById('tgl_rekap').value = ''
                    });
                },
                error: function (res) {
                    swal({
                        title: "Gagal",
                        text: "Silahkan ulangi!",
                        icon: "error",
                    }).then((value) => {
                        table.draw()
                    });
                }

            })
        }));

        $("#btn-sakit").on('click',((e) => {
            e.preventDefault();
            var pegawai = document.getElementById('pegawai_id').value;
            var date = document.getElementById('tgl_rekap').value;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('absen.store')}}",
                type: 'POST',
                data: {
                    id_pgw: pegawai,
                    tgl_rekap: date,
                    sakit: 1
                },
                success: function (params) {
                    swal({
                        title: "Sukses!",
                        text: "Data Berhasil Ditambah!",
                        icon: "success",
                    }).then((value) => {
                        table.draw();
                        document.getElementById('pegawai_id').value = '';
                        document.getElementById('tgl_rekap').value = ''
                    });
                },
                error: function (params) {
                    swal({
                        title: "Gagal",
                        text: "Silahkan ulangi!",
                        icon: "error",
                    }).then((value) => {
                        table.draw()
                    });
                }

            })
        }));

        $("#btn-cuti").on('click',((e) => {
            e.preventDefault();
            var pegawai = document.getElementById('pegawai_id').value;
            var date = document.getElementById('tgl_rekap').value;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('absen.store')}}",
                type: 'POST',
                data: {
                    id_pgw: pegawai,
                    tgl_rekap: date,
                    cuti: 1
                },
                success: function (res) {
                    if(!res){
                        swal({
                            title: "Gagal!",
                            text: "Sisa Cuti Pegawai Sudah Habis!",
                            icon: "error",
                        })
                    }else{
                        swal({
                            title: "Sukses!",
                            text: "Data Berhasil Ditambah!",
                            icon: "success",
                        }).then((value) => {
                            table.draw();
                            document.getElementById('pegawai_id').value = '';
                            document.getElementById('tgl_rekap').value = ''
                        });
                    }
                },
                error: function (res) {
                    swal({
                        title: "Gagal",
                        text: "Silahkan ulangi!",
                        icon: "error",
                    }).then((value) => {
                        table.draw()
                    });
                }

            })
        }));
    });
    </script>
    <script>
        function destroy(id){
            swal({
                    title: "Anda yakin ingin menghapus data absensi ini?",
                    text: "Saat terhapus, data tidak bisa dikembalikan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var url = '{{ route("absen.delete", ":id") }}';
                        url = url.replace(':id', id );
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: url,
                            success: function (data) {
                                swal({
                                    title: "Sukses!",
                                    text: "Data Berhasil Dihapus!",
                                    icon: "success",
                                }).then((value) => {
                                    location.reload()
                                });
                            },
                            error: function (data){
                                swal({
                                    title: "Gagal",
                                    text: "Silahkan ulangi!",
                                    icon: "danger",
                                });
                            }
                        });
                    } else {
                        return false;
                    }
                });
        }
    </script>
@endsection
