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
                    <div class="panel-heading acl_heading_left">Menus</div>
                    <div class="panel-heading"><a href="{{URL::to('/menus/create')}}" class="acl_heading_right">Create New Menu</a></div>
                    <br/> </div>

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="resource-name">Menu Name</th>
                                <th class="resource-name">Sub Menu Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($menues as $menu)
                                <tr>
                                    <td>{{$menu->menu_name}}(<a href="{{URL::to('menus/edit/'.$menu->id)}}">Edit</a>)</td>
                                    <?php $subs = \App\Menu::where('parent_id','=',$menu->id)->where('type','=',2)->get();?>
                                    <td>
                                        @foreach($subs as $sub)
                                            {{$sub->menu_name}}(<a href="{{URL::to('menus/edit/'.$sub->id)}}">Edit</a>),
                                        @endforeach
                                    </td>
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


