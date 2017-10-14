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
                    <div class="panel-heading acl_heading_left">All Notifications</div>
                    <br/> </div>

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="resource-name">Title</th>
                                <th class="resource-name">Description</th>
                                <th  class="resource-name"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notifications as $notification)
                                <tr>
                                    <td>{{$notification->title}}</td>
                                    <td>{{substr($notification->description,0,60)}}..</td>
                                    <td><a href="{{URL::to('notification/'.$notification->id)}}">Details</a></td>
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
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true,
                "lengthMenu": [[10, 25, 50,500,2000,10000,50000, -1], [10, 25, 50,500,2000,10000,50000, "All"]]
            });
        });
    </script>
@endsection

