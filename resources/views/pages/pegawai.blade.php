@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            {{--  MODAL TAMBAH PEGAWAI --}}
            <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('pegawai.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="id-pegawai">ID Pegawai</label>
                            <input type="text" class="form-control" id="id-pegawai" required placeholder="ID Pegawai..." name="id_pegawai">
                        </div>

                        <div class="form-group mb-2">
                            <label for="nama-pegawai">Nama Pegawai</label>
                            <input type="text" class="form-control" id="nama-pegawai" required placeholder="Nama Pegawai..." name="nama_pegawai">
                        </div>

                        <div class="form-group mb-2">
                            <label for="jabatan-pegawai">Jabatan Pegawai</label>
                            <input type="text" class="form-control" id="jabatan-pegawai" required placeholder="Jabatan Pegawai..." name="jabatan">
                        </div>

                        <div class="form-group mb-2">
                            <label for="alamat">Alamat Pegawai</label>
                            <textarea class="form-control" id="alamat" required placeholder="Alamat Pegawai" name="alamat"></textarea>
                        </div>


                        <div class="form-group mb-2">
                            <label for="nomor-telepon">Telepon Pegawai</label>
                            <input type="number" class="form-control" id="nomor-telepon" required placeholder="Telepon Pegawai..." name="telepon">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
                </div>
                </div>
            </div>
            {{-- END --}}

            {{-- MODAL EDIT PEGAWAI --}}
            <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form id="edit_pegawai">
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <input type="hidden" name="id" id="id_pgw">
                            <label for="id-pegawai-edit">ID Pegawai</label>
                            <input type="text" class="form-control" id="id-pegawai-edit" required placeholder="ID Pegawai..." name="id_pegawai">
                        </div>

                        <div class="form-group mb-2">
                            <label for="nama-pegawai-edit">Nama Pegawai</label>
                            <input type="text" class="form-control" id="nama-pegawai-edit" required placeholder="Nama Pegawai..." name="nama_pegawai">
                        </div>

                        <div class="form-group mb-2">
                            <label for="jabatan-pegawai-edit">Jabatan Pegawai</label>
                            <input type="text" class="form-control" id="jabatan-pegawai-edit" required placeholder="Jabatan Pegawai..." name="jabatan">
                        </div>

                        <div class="form-group mb-2">
                            <label for="alamat-edit">Alamat Pegawai</label>
                            <textarea class="form-control" id="alamat-edit" required placeholder="Alamat Pegawai" name="alamat"></textarea>
                        </div>


                        <div class="form-group mb-2">
                            <label for="nomor-telepon-edit">Telepon Pegawai</label>
                            <input type="number" class="form-control" id="nomor-telepon-edit" required placeholder="Telepon Pegawai..." name="telepon">
                        </div>

                        <div class="form-group">
                            <label for="jumlah-cuti-edit">Jumlah Cuti Pegawai Pegawai</label>
                            <input type="number" class="form-control" id="jumlah-cuti-edit" required placeholder="Jumlah Cuti..." name="telepon">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                </form>
                </div>
                </div>
            </div>
            {{-- END --}}
            <div class="card">
                <div class="card-body">
                    <div class="d-flex ml-2">
                        <button class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#tambah"> Tambah Pegawai </button>
                    </div>
                    <hr />
                    <div class="table-responsive">
                        <table id="pegawai" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID Pegawai</th>
                                <th>Nama Pegawai</th>
                                <th>Jabatan</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Jumlah Cuti</th>
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
            var table = $("#pegawai").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('pegawai.list')}}",
                columns: [
                    {data:'id_pegawai',name:'id_pegawai'},
                    {data:'nama_pegawai',name:'nama_pegawai'},
                    {data:'jabatan',name:'jabatan'},
                    {data:'alamat',name:'alamat'},
                    {data:'telepon',name:'telepon'},
                    {data:'jumlah_cuti',name:'jumlah_cuti'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ],
            })
        });
    </script>
    <script>
        function show(id){
            var url = '{{ route("pegawai.show", ":id") }}';
                url = url.replace(':id', id );
                $.ajax({
                    type: "get",
                    url: url,
                    success: function (data) {
                        var res = data;
                        document.getElementById('id_pgw').value = res.id;
                        document.getElementById('id-pegawai-edit').value = res.id_pegawai;
                        document.getElementById('nama-pegawai-edit').value = res.nama_pegawai;
                        document.getElementById('jabatan-pegawai-edit').value = res.jabatan;
                        document.getElementById('alamat-edit').value = res.alamat;
                        document.getElementById('nomor-telepon-edit').value = res.telepon;
                        document.getElementById('jumlah-cuti-edit').value = res.jumlah_cuti;

                    },
                });
            }

        function destroy(id){
            swal({
                    title: "Anda yakin ingin menghapus data pegawai ini?",
                    text: "Saat terhapus, data tidak bisa dikembalikan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var url = '{{ route("pegawai.delete", ":id") }}';
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
                                    icon: "error",
                                });
                            }
                        });
                    } else {
                        return false;
                    }
                });
        }

        $("#edit_pegawai").on('submit',(e) => {
            e.preventDefault();
            var id = document.getElementById('id_pgw').value;
            var id_pgw = document.getElementById('id-pegawai-edit').value;
            var nama = document.getElementById('nama-pegawai-edit').value;
            var jabatan = document.getElementById('jabatan-pegawai-edit').value;
            var alamat = document.getElementById('alamat-edit').value;
            var telepon = document.getElementById('nomor-telepon-edit').value;
            var url = '{{ route("pegawai.update", ":id") }}';
                url = url.replace(':id', id );
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: url,
                    data:{
                        id_pegawai: id_pgw,
                        jabatan: jabatan,
                        alamat: alamat,
                        telepon: telepon,
                        nama_pegawai: nama,
                    },
                    success: function (data) {
                        swal({
                            title: "Sukses!",
                            text: "Data Berhasil Diubah!",
                            icon: "success",
                        }).then((value) => {
                            location.reload()
                        });
                    },
                    error: function (data){
                        swal({
                            title: "Gagal",
                            text: "Periksa Inputan!",
                            icon: "error",
                        });
                    }
                });
        });


    </script>
@endsection
