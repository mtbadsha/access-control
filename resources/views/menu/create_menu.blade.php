@extends('layouts.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header acl_page_header">Menus</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Menu</div>
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

                        <form class="form-horizontal" role="form" method="POST" action="{{URL::to('/post_create_menu')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Menu Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="menu_name" value="{{ old('menu_name') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Route Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="route_name" value="{{ old('route_name') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Parent Menu</label>
                                <div class="col-md-6">
                                    <select type="text" class="form-control" name="parent_id" >
                                        <option value="">No Parent Menu</option>
                                        @foreach($menu as $m)
                                        <option value={{$m->id}}>{{$m->menu_name}}</option>
                                        @endforeach
                                    </select>
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
