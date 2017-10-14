@extends('layouts.layout')
@section('header')
    <link href="{{URL::asset('layouts/bower_components/datatables/media/css/jquery.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12">
           <br>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-heading acl_heading_left">User Wise Role</div>
                    <div class="panel-heading"><a href="{{URL::to('/role_assign_to_user')}}"  class="acl_heading_right">Assign Role To User</a></div>
                    <br/> </div>
                    <div class="panel-body">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th class="resource-name">User Name</th>
                                    <th class="resource-name">Role Name</th>
                                    <th class="resource-link" style="width: 10%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user_roles as $user_role)
                                    <tr>
                                        <?php $user_r = \App\User::where('id','=',$user_role->user_id)->first();?>
                                        <td>
                                            @if($user_r!=null)
                                                {{$user_r->user_name}}
                                            @endif
                                        </td>
                                        <?php $pers = \App\UserRole::where('user_id','=',$user_role->user_id)->get();?>

                                        <td>
                                            @foreach($pers as $per)
                                                <?php $role_n = \App\Role::where('id','=',$per->role_id)->first();?>
                                                @if($role_n!=null)
                                                    {{$role_n->role_name}},
                                                @endif
                                            @endforeach
                                        </td>
                                        <td><a href="role_assign_to_user_edit/{{$user_role->user_id}}">Edit</a></td>
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


