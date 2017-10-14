@extends('layouts.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Roles</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Role Assign to User</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($user_name!=null)
                        <form class="form-horizontal" role="form" method="POST" action="{{URL::to('/edit_role_assign_to_user')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="user_id" value="{{ $user_name->id}}">

                            <div class="form-group">

                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="col-md-12"> <label class="col-md-12 control-label">{{$user_name->user_name}}</label> </div>
                                        <div class="col-md-12"> <label class="col-md-12 control-label">Local ID: {{$user_name->local_id}}</label> </div>
                                        <div class="col-md-12"> <label class="col-md-12 control-label">Global ID: {{$user_name->global_id}}</label> </div>
                                        <div class="col-md-12"> <label class="col-md-12 control-label">{{$user_name->email}}</label> </div>
                                    </div>
                                <div class="col-md-6">

                                        <?php $i=1;?>
                                        <?php $j=1; $max = sizeof($user_roles);?>
                                    @foreach($roles as $role)
                                                <div class="col-md-4">
                                            <?php $j=1; ?>
                                        @foreach($user_roles as $user_role)

                                            <?php if($role->id==$user_role->role_id){?>
                                        <input type="checkbox" checked name="role_name[]"  value="{{$role->id}}"/>
                                              <?php  $j = $j+1;?>
                                            <?php break;
                                                }
                                                else if($j==$max){
                                                ?>
                                                <input type="checkbox" name="role_name[]"  value="{{$role->id}}"/>
                                            <?php }
                                                $j = $j+1;?>
                                    @endforeach
                                                {{$role->role_name}}
                                            </div>
                                        @endforeach
                                </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-6">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
