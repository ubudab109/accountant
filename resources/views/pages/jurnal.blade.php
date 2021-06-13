@extends('layouts.master')

@section('content')
@php
    $gaji = \App\Models\Gaji::all();
    $akun = \App\Models\Akun::count();
    $dataAkun = \App\Models\Akun::all();
@endphp
    <div class="row">
        <div class="col-12">
            {{--  MODAL TAMBAH JURNAL --}}
            <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jurnal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="{{ route('jurnal.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <input type="text" class="form-control" id="no_jurnal" required placeholder="Nomor Jurnal..." name="no_jurnal">
                        </div>

                        <div class="form-group mb-2">
                            <input type="date" class="form-control" id="tanggal" placeholder="Tanggal Jurnal" name="tanggal">
                        </div>

                        <div class="form-group mb-2">
                            <select name="kode_gaji" class="form-control" id="kode_gaji" required>
                                <option disabled selected>Pilih Bukti Transaksi</option>
                                    @foreach ($gaji as $item)
                                        <option value="{{$item->kode_gaji}}">{{$item->kode_gaji}}</option>
                                    @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <textarea class="form-control" id="keterangan" placeholder="Keterangan (Kosongkan jika tidak ada keterangan)" name="keterangan"></textarea>
                        </div>

                        <hr />
                        @for ($i = 0; $i < $akun; $i++)
                            <input type="checkbox" class="form-checkbox" id="check-{{$i}}" onClick="activeForm({{$i}})"/>
                            <div class="row align-items-center">
                                <div class="form-group col-md-4">
                                    <select id="no_akun[{{$i}}]" disabled name="akun[{{$i}}][no_akun]" class="form-control">
                                    <option selected disabled>Kode Akun | Nama Akun</option>
                                    @foreach ($dataAkun as $item)
                                        <option value="{{$item->no_akun}}">{{$item->no_akun}} | {{$item->nama_akun}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="sr-only" for="kredit[]">Name</label>
                                    <input type="number" disabled class="form-control" id="kredit[{{$i}}]" name="akun[{{$i}}][kredit]" placeholder="Jumlah Kredit (Berikan 0 Jika Tidak Ada)">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="sr-only" for="debit[{{$i}}]">Name</label>
                                    <input type="number" disabled class="form-control" id="debit[{{$i}}]" name="akun[{{$i}}][debit]" placeholder="Jumlah Debit (Berikan 0 Jika Tidak Ada)">
                                </div>
                            </div>
                        @endfor


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
                        <button class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#tambah"> Tambah Jurnal </button>
                    </div>
                    <hr />
                    <div class="table-responsive">
                        <table id="jurnal" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Nomor Jurnal</th>
                                <th>Akun</th>
                                <th>Kredit</th>
                                <th>Debit</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
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
            var table = $("#jurnal").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('jurnal.list')}}",
                columns: [
                    {data:'no_jurnal',name:'no_jurnal'},
                    {data:'akun',name:'akun'},
                    {data:'kredit',name:'kredit'},
                    {data:'debit',name:'debit'},
                    {data:'keterangan',name:'keterangan'},
                    {data:'date',name:'date'},
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
    <script type="text/javascript">
        function activeForm(id){
            if(document.getElementById(`check-${id}`).checked == true){
                console.log('checed')
                document.getElementById(`no_akun[${id}]`).disabled = false;
                document.getElementById(`kredit[${id}]`).disabled = false;
                document.getElementById(`debit[${id}]`).disabled = false;
            }else{
                document.getElementById(`no_akun[${id}]`).disabled = true;
                document.getElementById(`kredit[${id}]`).disabled = true;
                document.getElementById(`debit[${id}]`).disabled = true;
            }
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
                        var url = '{{ route("jurnal.delete", ":id") }}';
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
