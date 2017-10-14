@if(Auth::user())

<div class="sidebar-nav navbar-collapse">

    <?php $role_main = \App\UserRole::where('user_id', '=', Auth::user()->id)->first();
    if ($role_main != null && $role_main != "") {
        $permission_main = \App\Permission::where('role_id', '=', $role_main->role_id)->get();
    } else {
        $permission_main = null;
    }

    ?>
    <ul class="nav" id="side-menu">
        @if(Auth::user()->id==1)
        <li><a href="#"><i class="fa fa-dashboard fa-fw"></i> Admin   <span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <li><a href="{{URL::to('/users')}}"><i class="fa fa-dashboard fa-fw"></i> User</a></li>
                <li><a href="{{URL::to('/menus')}}"><i class="fa fa-dashboard fa-fw"></i> Menu</a></li>
                <li><a href="{{URL::to('/roles')}}"><i class="fa fa-dashboard fa-fw"></i> Role</a></li>
                <li><a href="{{URL::to('/menu_assign_to_role_list')}}"><i class="fa fa-dashboard fa-fw"></i> RoleWise Menu</a></li>
                <li><a href="{{URL::to('/role_assign_to_user_list')}}"><i class="fa fa-dashboard fa-fw"></i> Role Assign To User</a></li>
            </ul>

        </li>
        @endif
        @if($permission_main!=null)
            @foreach($permission_main as $pr)
                <?php $menu_main = \App\Menu::where('id', '=', $pr->menu_id)->where('type', '=', 1)->first();?>
                @if($menu_main!="")
                    <li>
                        @if($menu_main->route_name=="#")
                            <a href="{{URL::to($menu_main->route_name)}}">{{$menu_main->menu_name}}
                                <span class="fa arrow"></span>
                            </a>
                        @else
                            <a href="{{URL::to($menu_main->route_name)}}">{{$menu_main->menu_name}}</a>
                        @endif
                        @if($menu_main->route_name=="#")
                            <ul class="nav nav-second-level">
                                @foreach($permission_main as $prr)
                                    <?php $menu_2 = \App\Menu::where('id', '=', $prr->menu_id)->where('parent_id', '=', $menu_main->id)->where('type', '=', 2)->first();?>
                                    @if($menu_2!="")
                                        <li>
                                            <a href="{{URL::to($menu_2->route_name)}}">{{$menu_2->menu_name}}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>

                @endif
            @endforeach
            <li>
{{--test menu--}}
                <a href="#">Excel and PDF
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                            <li>
                                <a href="{{URL::to('excel_out')}}">Excel Out</a>
                            </li>
                    <li>
                        <a href="{{URL::to('excel_test')}}">Excel Import</a>
                    </li>
                    <li>
                        <a href="{{URL::to('pdf')}}" target="_blank">PDF Create</a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>

</div>
<!-- /.sidebar-collapse -->
@endif
