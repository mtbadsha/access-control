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
                <div class="panel-heading acl_heading_left">Upload Employee</div>
                <div class="panel-heading"><a href="{{URL::to('/forecastemployee/new')}}" class="acl_heading_right">Upload Employee Date</a></div>
                <br/> </div>

            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th class="resource-name">Local Id</th>
                                <th class="resource-name">Global Id</th>
                                <th class="resource-name">Division Name</th>
                                <th class="resource-name">Department Name</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $data)
                            <tr>
                                <td>{{$data->local_id}}</td>
                                <td>{{$data->global_id}}</td>
                                <td>{{$data->div_name}}</td>
                                <td>{{$data->dept_name}}</td>                                
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


