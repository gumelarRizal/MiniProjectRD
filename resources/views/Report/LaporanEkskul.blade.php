@extends('Layouts.MainLayouts')

@section('title')
    <h1>{{$pages}}</h1>
@endsection

@push('page-style')
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
@endpush

@section('content')
<div class="card">
    <div class="row">
        <div class="col-12">
            <div class="card-body">
                <form id="form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Pilih Kelas</label>
                                <select class="form-control" name="kelas" id="kelas" placeholder="Pilih Kelas">
                                    <option value="">--Pilih--</option>
                                    @foreach ($kelas as $item)
                                      <option value="<?php echo $item->kelas; ?>">
                                        <?php echo $item->kelas; ?>
                                      </option>
                                    @endforeach
                                  </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Download</button>
                            </div>
                        </div>
                    </div>  
                </form>
                
                {{-- <table id="table-data" class="display table table-striped table-hover" width="100%">
                    <thead>
                        <tr>
                            <th data-orderable="false">#</th>
                            <th data-orderable="true" data-data="nama_ekskul">Ekskul</th>
                            <th data-orderable="true" data-data="jumlah_pendaftar">Jumlah Pendaftar</th>
                        </tr>
                    </thead>
                </table> --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
@endsection

@push('page-scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"></script> --}}
@endpush

@push('after-script')
    <script>
        function setTableData() {
            var reqOrder = [[1, 'asc']];
            var reqData = null;
            var colDef = [
                
            ];

            tableData = setDataTable('#table-data', "{{url('report/read')}}", colDef, reqData, reqOrder);
        }

        $(document).ready(function () {
            setTableData();
        });

        $('#form-data').validate({
            rules: {
                kelas: {required: true}
            },
            submitHandler: function(form) {
                let kelas = $("#kelas").val();
                let url = "{{ route('laporan_ekskul.export', ':kelas') }}";
                url = url.replace(':kelas', kelas);
                document.location.href=url;
                // ajaxData("{{ url('report') }}/exportToExcel", new FormData(form), null, true);
            }
        });

        // var ctx = document.getElementById('myChart').getContext('2d');
        // var myChart = new Chart(ctx, {
        //     type: 'bar',
        //     data: {
        //         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        //         datasets: [{
        //             label: '# of Votes',
        //             data: [12, 19, 3, 5, 2, 3],
        //             backgroundColor: [
        //                 'rgba(255, 99, 132, 0.2)',
        //                 'rgba(54, 162, 235, 0.2)',
        //                 'rgba(255, 206, 86, 0.2)',
        //                 'rgba(75, 192, 192, 0.2)',
        //                 'rgba(153, 102, 255, 0.2)',
        //                 'rgba(255, 159, 64, 0.2)'
        //             ],
        //             borderColor: [
        //                 'rgba(255, 99, 132, 1)',
        //                 'rgba(54, 162, 235, 1)',
        //                 'rgba(255, 206, 86, 1)',
        //                 'rgba(75, 192, 192, 1)',
        //                 'rgba(153, 102, 255, 1)',
        //                 'rgba(255, 159, 64, 1)'
        //             ],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });
    </script>
@endpush