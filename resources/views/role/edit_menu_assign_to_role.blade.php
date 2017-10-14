@extends('layouts.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header acl_page_header">RoleWise Menu</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Permission</div>
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

                    <form class="form-horizontal" role="form" method="POST" action="{{URL::to('/edit_menu_assign_to_role')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="role_id" value="{{ $role->id}}">
                        <div class="form-group col-md-12">
                            <label class="col-md-4 control-label">Role Name:</label>
                            <label class="col-md-6 control-label" style="text-align: left">{{$role->role_name}}</label>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12"><label class="col-md-4 control-label">Select Menu Name</label></div>
                            <div class="col-md-12"><br/></div>


                                    <?php $k=1;?>
                                    <?php $l=1; $max = sizeof($menu_roles);?>
                                        <?php $i=0;?>
                                    @foreach($menu as $m)
                                        <?php $i++;?>
                                <div class="col-md-12">
                                    <div class="col-md-4"  style="text-align: right">
                                        <?php $k=1; ?>
                                        @foreach($menu_roles as $menu_role)
                                            <?php if($m->id==$menu_role->menu_id){?>
                                            <input type="checkbox" checked name="menu<?php echo $i;?>"  value="{{$m->id}}"/>
                                            <?php  $k = $k+1;?>
                                            <?php break;
                                            }
                                            else if($k==$max){
                                            ?>
                                            <input type="checkbox" name="menu<?php echo $i;?>"  value="{{$m->id}}"/>
                                            <?php }
                                            $k = $k+1;?>
                                        @endforeach
                                        {{$m->menu_name}}

                                    </div>
                                    <div class="col-md-6">
                                        <?php $subs = \App\Menu::where('type','=',2)->where('parent_id','=',$m->id)->get();?>
                                        <?php $j=0;?>
                                        @foreach($subs as $sub)
                                            <?php $j++;$l=1;?>

                                                    @foreach($menu_roles as $menu_rol)
                                                        <?php if($sub->id==$menu_rol->menu_id){?>
                                                        <input type="checkbox" checked name="sub_menu<?php echo $i.$j?>"  value="{{$sub->id}}""/>
                                                        <?php  $l = $l+1;?>
                                                        <?php break;
                                                        }
                                                        else if($l==$max){
                                                        ?>
                                                        <input type="checkbox" name="sub_menu<?php echo $i.$j?>"  value="{{$sub->id}}"/>
                                                        <?php }
                                                        $l = $l+1;?>
                                                    @endforeach
                                                    {{$sub->menu_name}}

                                        @endforeach

                                    </div>

                                </div>
                                    @endforeach

                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
