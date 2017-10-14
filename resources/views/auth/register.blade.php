@extends('layouts.layout')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header acl_page_header">Users</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-md-7 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">Create User</div>
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

                <form class="form-horizontal" role="form" method="POST" action="{{URL::to('/registration')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="col-md-4 control-label">Name</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">E-Mail Address</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        </div>
                    </div>

<!--                    <div class="form-group">
                        <label class="col-md-4 control-label">Local ID</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" name="local_id" value="{{ old('local_id') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Global ID</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" name="global_id" value="{{ old('global_id') }}">
                        </div>
                    </div>-->

                    <div class="form-group">
                        <label class="col-md-4 control-label">IsActive</label>
                        <div class="col-md-6">
                            <select type="text" class="form-control" name="is_active" required>
                                <option value="1">Is Active</option>
                                <option value="0">Not Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Confirm Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
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
