@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            {{--  MODAL TAMBAH AKUN --}}
            <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('akun.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" required placeholder="Nomor Akun..." name="no_akun">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" required placeholder="Nama Akun..." name="nama_akun">
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

            {{-- MODAL EDIT AKUN --}}
            <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form id="edit_akun">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id_akun">
                            <input type="text" class="form-control" id="no_akun" required placeholder="Nomor Akun..." name="no_akun">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" id="nama_akun" required placeholder="Nama Akun..." name="nama_akun">
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
                        <button class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#tambah"> Tambah Akun </button>
                    </div>
                    <hr />
                    <div class="table-responsive">
                        <table id="akun" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Nomor Akun</th>
                                <th>Nama Akun</th>
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
            var table = $("#akun").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('akun.list')}}",
                columns: [
                    {data:'no_akun',name:'no_akun'},
                    {data:'nama_akun',name:'nama_akun'},
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
            var url = '{{ route("akun.show", ":id") }}';
                url = url.replace(':id', id );
                $.ajax({
                    type: "get",
                    url: url,
                    success: function (data) {
                        var res = data;
                        document.getElementById('id_akun').value = res.id;
                        document.getElementById('no_akun').value = res.no_akun;
                        document.getElementById('nama_akun').value = res.nama_akun;
                    },
                });
            }

        function destroy(id){
            swal({
                    title: "Anda yakin ingin menghapus data akun ini?",
                    text: "Saat terhapus, data tidak bisa dikembalikan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var url = '{{ route("akun.delete", ":id") }}';
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

        $("#edit_akun").on('submit',(e) => {
            e.preventDefault();
            var id = document.getElementById('id_akun').value;
            var no_akun = document.getElementById('no_akun').value;
            var nama_akun = document.getElementById('nama_akun').value;
            var url = '{{ route("akun.update", ":id") }}';
                url = url.replace(':id', id );
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: url,
                    data:{
                        no_akun: no_akun,
                        nama_akun: nama_akun,
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
