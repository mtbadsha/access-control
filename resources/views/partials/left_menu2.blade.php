@if(Auth::user())

    <div class="sidebar-nav navbar-collapse">

        <?php
        $role_main = \App\UserRole::where('user_id', '=', Auth::user()->id)->get();
        $left_menu = array();

        foreach($role_main as $r)
            {
                $menu_role = \App\Permission::where('role_id','=',$r->role_id)->get();


                foreach($menu_role as $mr)
               {
                   if(!in_array($mr->menu_id, $left_menu)){
                       $left_menu[] = $mr->menu_id;
                   }

                    }
            }
            $c = count($left_menu);

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
                @if($c!=0)
                    @for($i=0;$i<$c;$i++)
                        <?php $menu_main = \App\Menu::where('id', '=', $left_menu[$i])->where('type', '=', 1)->first();?>
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
                                        @for($j=0;$j<$c;$j++)
                                            <?php $menu_2 = \App\Menu::where('id', '=',$left_menu[$j])->where('parent_id', '=', $menu_main->id)->where('type', '=', 2)->first();?>
                                            @if($menu_2!="")
                                                <li>
                                                    <a href="{{URL::to($menu_2->route_name)}}">{{$menu_2->menu_name}}</a>
                                                </li>
                                            @endif
                                        @endfor
                                    </ul>
                                @endif
                            </li>

                        @endif
                    @endfor

                @endif

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
@endif
