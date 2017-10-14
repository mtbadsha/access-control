@extends('layouts.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header acl_page_header">Roles</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">Edit Role</div>
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
                @if($role!=null)
            <form class="form-horizontal" role="form" method="POST" action="{{URL::to('/edit_role')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $role->id}}">

                <div class="form-group">
                    <label class="col-md-4 control-label">Role Name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="role_name" value="{{$role->role_name}}" required>
                    </div>
                </div>
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
