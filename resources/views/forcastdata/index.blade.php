@extends('layouts.layout')
@section('header')
<link href="{{URL::asset('layouts/bower_components/datatables/media/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <br/>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-heading acl_heading_left">Forecast Details</div>
                <div class="panel-heading"><a href="{{URL::to('/forcastdata/new')}}" class="acl_heading_right">Upload Forecast Date</a></div>
                <br/> </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="resource-name">Forecast Year</th>
                                <th class="resource-name">Organization Name</th>
                                <th class="resource-name">Organization Type</th>
                                <th class="resource-name">A</th>
                                <th class="resource-name">B</th>
                                <th class="resource-name">C</th>
                                <th class="resource-name">D</th>
                                <th class="resource-name">E</th>
                                <th class="resource-name">F</th>
                                <th class="resource-name">G App</th>
                                <th class="resource-name">G Full </th>
                                <th class="resource-name">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forcast_data as $data)
                            <tr>
                                <td>{{$data->forcust_year}}</td>                                
                                <td>{{$data->organization_name}}</td>
                                <td>{{$data->organization_type}}</td>
                                <td>{{$data->band_a}}</td>
                                <td>{{$data->band_b}}</td>
                                <td>{{$data->band_c}}</td>
                                <td>{{$data->band_d}}</td>
                                <td>{{$data->band_e}}</td>
                                <td>{{$data->band_f}}</td>
                                <td>{{$data->band_g_app}}</td>
                                <td>{{$data->band_g_full}}</td>
                                <td>{{$data->total}}</td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
@endsection
@section('footer')

<script src="{{URL::to('layouts/bower_components/DataTables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::to('layouts/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
$(document).ready(function () {
    $('#dataTables-example').DataTable({
        responsive: true,
        sortable: false,
        "lengthMenu": [[10, 25, 50, 500, 2000, 10000, 50000, -1], [10, 25, 50, 500, 2000, 10000, 50000, "All"]]
    });
});
</script>
@endsection


