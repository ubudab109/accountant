@extends('layouts.master')

@section('content')
@php
    $pegawai = \App\Models\Pegawai::all();
@endphp
    <div class="row">
        <div class="col-12">
            {{--  MODAL TAMBAH GAJI --}}
            <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Gaji</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('gaji.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <input type="text" class="form-control" required placeholder="Kode Gaji..." name="kode_gaji">
                        </div>

                        <div class="form-group mb-2">
                            <input type="date" class="form-control" required placeholder="Tanggal Gaji..." name="tanggal">
                        </div>

                        <div class="form-group mb-2">
                            <select class="form-control" name="kode_pegawai" required>
                                <option value="" selected disabled>Pilih Pegawai</option>
                                @foreach ($pegawai as $item)
                                    <option value="{{$item->id_pegawai}}">{{$item->id_pegawai}} | {{$item->nama_pegawai}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <input type="number" class="form-control" required placeholder="Gaji Pokok..." name="gaji_pokok" required>
                        </div>

                        <div class="form-group mb-2">
                            <input type="number" class="form-control" required placeholder="Potongan (Berikan 0 Jika Tidak Ada)..." name="potongan">
                        </div>

                        <div class="form-group mb-2">
                            <input type="number" class="form-control" required placeholder="Bonus (Berikan 0 Jika Tidak Ada)..." name="bonus">
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

            <div class="card">
                <div class="card-body">
                    <div class="d-flex ml-2">
                        <button class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#tambah"> Tambah Gaji </button>
                    </div>
                    <hr />
                    <div class="table-responsive">
                        <table id="gaji" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Kode Gaji</th>
                                <th>Tanggal Gaji</th>
                                <th>Pegawai</th>
                                <th>Gaji Pokok</th>
                                <th>Potongan</th>
                                <th>Bonus</th>
                                <th>Total Gaji</th>
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
            var table = $("#gaji").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('gaji.list')}}",
                columns: [
                    {data:'kode_gaji',name:'kode_gaji'},
                    {data:'tanggal',name:'tanggal'},
                    {data:'pegawai',name:'pegawai'},
                    {data:'gaji_pokok',name:'gaji_pokok'},
                    {data:'potongan',name:'potongan'},
                    {data:'bonus',name:'bonus'},
                    {data:'total_gaji',name:'total_gaji'},
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

        function destroy(id){
            swal({
                    title: "Anda yakin ingin menghapus data gaji ini?",
                    text: "Saat terhapus, data tidak bisa dikembalikan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var url = '{{ route("gaji.delete", ":id") }}';
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
    </script>
@endsection
