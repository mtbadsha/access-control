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
                    <div class="panel-heading acl_heading_left">RoleWise Menu</div>
                    <div class="panel-heading"><a href="{{URL::to('/permission')}}"  class="acl_heading_right">Assign New Menu To Rule</a></div>
                    <br/>  </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th class="resource-name">Role Name</th>
                                    <th class="resource-name">Menu Name</th>
                                    <th class="resource-link" style="width: 10%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissions as $permission)
                                    <tr>
                                        <?php $role = \App\Role::where('id','=',$permission->role_id)->first();?>
                                        <td>
                                            @if($role!=null)
                                                {{$role->role_name}}
                                            @endif
                                        </td>
                                        <?php $pers = \App\Permission::where('role_id','=',$permission->role_id)->get();?>

                                        <td>
                                            @foreach($pers as $per)
                                                <?php $menu = \App\Menu::where('id','=',$per->menu_id)->where('type','=',1)->first();?>
                                                @if($menu!=null)
                                                    {{$menu->menu_name}}&#40;

                                                    @foreach($pers as $prr)
                                                        <?php $menu_2 = \App\Menu::where('id', '=', $prr->menu_id)->where('parent_id', '=', $per->menu_id)->where('type', '=', 2)->first();?>
                                                        @if($menu_2!="")
                                                            {{$menu_2->menu_name}},
                                                        @endif
                                                    @endforeach
                                                    &#41;,
                                                @endif
                                            @endforeach
                                        </td>
                                            <td><a href="edit_menu_assign_to_role/{{$permission->role_id}}">Edit</a></td>
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

