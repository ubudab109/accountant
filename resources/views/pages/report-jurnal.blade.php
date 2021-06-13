@extends('layouts.master')

@section('content')
@php
    $pegawai = \App\Models\Pegawai::all();
@endphp
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row input-daterange">
                        <div class="col-md-4">
                            <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
                        </div>
                        <div class="col-md-4">
                            <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                            <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
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
                        <table id="jurnal" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Nomor Jurnal</th>
                                <th>Tanggal</th>
                                <th>Total Kredit</th>
                                <th>Total Debit</th>
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
            $('.input-daterange').datepicker({
                todayBtn:'linked',
                format:'yyyy-mm-dd',
                autoclose:true
            });

            load_data();


            function load_data(from_date = '', to_date = '') {
                $("#jurnal").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('jurnal.report-list')}}",
                    data:{startDate:from_date, endDate:to_date}
                },
                columns: [
                    {data:'no_jurnal',name:'no_jurnal'},
                    {data:'tanggal',name:'tanggal'},
                    {data:'total_kredit',name:'total_kredit'},
                    {data:'total_debit',name:'total_debit'},
                ],
                dom: 'Bfrtip',
                    buttons : [
                                {
                                    extend:'csv',
                                    title: `Jurnal - ${ourDateNow()}`,
                                    exportOptions: {
                                        columns: [ 0, 1, 2, 3 ]
                                    }
                                },
                                {
                                    extend: 'excel',
                                    title: `Jurnal - ${ourDateNow()}`,
                                    exportOptions: {
                                        columns: [ 0, 1, 2, 3 ]
                                    }
                                },
                    ],
            })
            }

            $('#filter').click(function(){
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if(from_date != '' &&  to_date != ''){
                    $('#jurnal').DataTable().destroy();
                    load_data(from_date, to_date);
                }
                else{
                    alert('Both Date is required');
                }
            });

            $('#refresh').click(function(){
                $('#from_date').val('');
                $('#to_date').val('');
                $('#jurnal').DataTable().destroy();
                load_data();
            });
        });
    </script>
@endsection
