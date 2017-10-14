@extends('layouts.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header acl_page_header">Users</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Edit User</div>
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
            @if($user!=null)
            <form class="form-horizontal" role="form" method="POST" action="{{URL::to('/edit_user')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label class="col-md-4 control-label">Name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="name" value="{{$user->user_name}}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">E-Mail Address</label>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="{{$user->email}}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Local ID</label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="local_id" value="{{$user->local_id}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Global ID</label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="global_id" value="{{$user->global_id}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">IsActive</label>
                    <div class="col-md-6">
                        <select type="text" class="form-control" name="is_active" required>
                            @if($user->isactive==1)
                            <option value="1">Is Active</option>
                            <option value="0">Not Active</option>
                            @else
                                <option value="0">Not Active</option>
                                <option value="1">Is Active</option>
                            @endif
                        </select>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{ $user->id}}">
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
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
