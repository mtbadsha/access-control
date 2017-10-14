@extends('layouts.layout')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header acl_page_header">RoleWise Menu</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row" >
    <div class="col-md-6 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Create Permission</div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{URL::to('/post_permission')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="col-md-3 control-label">Select Role Name</label>
                        <div class="col-md-6">
                            <select class="form-control" name="role_id" style="text-align: left" required>
                                <option value="">Select Role</option>
                                @foreach($role as $r)
                                <option value="{{$r->id}}">{{$r->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group" >
                        <div class="col-md-12"><label  style="text-align: left" class="col-md-4 control-label">Select Menu Name</label></div>
                        <div class="col-md-12"></div>
                        <?php $i = 0; ?>
                        @foreach($menu as $m)
                        <?php $i++; ?>
                        <div class="col-md-12">

                            <div class="col-md-4 bold" style="text-align: left;">
                                <input type="checkbox" name="menu<?php echo $i; ?>"  value="{{$m->id}}"/>
                                <label style="text-weight: bold">{{$m->menu_name}}</label>
                            </div>
                            <div class="col-md-6">
                                <?php $subs = \App\Menu::where('type', '=', 2)->where('parent_id', '=', $m->id)->get(); ?>
                                <?php $j = 0; ?>
                                @foreach($subs as $sub)
                                <?php $j++; ?>
                                <input type="checkbox" name="sub_menu<?php echo $i . $j ?>"  value="{{$sub->id}}"/>
                                {{$sub->menu_name}}
                                @endforeach

                            </div>
                            <br><hr>
                        </div>
                        @endforeach
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
