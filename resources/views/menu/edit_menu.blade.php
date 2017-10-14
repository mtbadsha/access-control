@extends('layouts.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header acl_page_header">Menus</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if($menus!=null)

        <form class="form-horizontal" role="form" method="POST" action="{{URL::to('/edit_menu')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $menus->id}}">

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Menu</div>
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

                        <div class="form-group">
                            <label class="col-md-4 control-label">Menu Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="menu_name" value="{{ $menus->menu_name }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Route Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="route_name" value="{{ $menus->route_name}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Parent Menu</label>
                            <div class="col-md-6">
                                <?php $menu = \App\Menu::where('type','=',1)->get();?>
                                <select type="text" class="form-control" name="parent_id">
                                    @if($menus->parent_id==0)
                                    <option value="">No Parent Menu</option>
                                    @foreach($menu as $m)
                                        <option value={{$m->id}}>{{$m->menu_name}}</option>
                                    @endforeach
                                    @else
                                        <?php $parent_id = \App\Menu::where('id','=',$menus->parent_id)->first();?>
                                            <option value="{{$parent_id->id}}">{{$parent_id->menu_name}}</option>
                                            <option value="">No Parent Menu</option>
                                        @foreach($menu as $m)
                                            @if($parent_id->id!=$m->id)
                                            <option value={{$m->id}}>{{$m->menu_name}}</option>
                                                @endif
                                        @endforeach
                                        @endif

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
        </form>
    @endif
@endsection
