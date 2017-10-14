<?php namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function create_role()
   {
       return View('role.create_role');
   }

    public function post_create_role()
    {
        //return Input::all();
        $role =new \App\Role();
        $role->role_name  = Input::get('role_name');
        $role->save();
        return Redirect::to('roles');
    }

    public function listOFRule()
    {
        $roles = \App\Role::all();
        return View('role.list_of_role')->with('roles',$roles);
    }

    public function edit_role($id)
    {
        $role = \App\Role::where('id','=',$id)->first();
        if($role!=null)
            return View('role.edit_role')->with('role',$role);
        else
            return Redirect::to('create_role');
    }

    public function edit_role2()
    {
        //return Input::all();
        $input['role_name'] = Input::get('role_name');
        \App\Role::where('id','=',Input::get('id'))->update($input);
        return Redirect::to('roles');
    }

    public function permission()
    {
        $role = \App\Role::all();
        $menu = \App\Menu::where('type','=',1)->get();
        return View('role.permission')->with('role',$role)->with('menu',$menu);
    }

    public function post_permission()
    {
        //return Input::all();

        $role_id = Input::get('role_id');
        for ($i=1; $i < 100; $i++) {
            $sub=Input::get('menu' . $i);
            if ($sub!=null) {
                $permission = new \App\Permission();
                $permission->role_id = $role_id;
                $permission->menu_id = $sub;
                $per = \App\Permission::where('role_id','=',Input::get('role_id'))->where('menu_id','=',$sub)->first();
                if($per==null)
                {
                    $permission->save();
                }
                for($j=1;$j<10;$j++)
                {
                    $submenu=Input::get('sub_menu' . $i.$j);
                    //return $submenu;
                    if ($submenu!=null) {
                        $permission2 = new \App\Permission();
                        $permission2->role_id = $role_id;
                        $permission2->menu_id = $submenu;
                        $per2 = \App\Permission::where('role_id', '=', Input::get('role_id'))->where('menu_id', '=', $submenu)->first();
                        if ($per2 == null) {
                            $permission2->save();
                        }
                    }
                }
            }
        }


        return Redirect::to('menu_assign_to_role_list');
    }

    public function role_assign_to_user()
    {
        $role = \App\Role::all();
        $user = \App\User::where('id', '!=', Auth::user()->id)->get();
        return View('role.role_assign_to_user')->with('role',$role)->with('user',$user);
    }

    public function post_role_to_user()
    {
        //return Input::all();
        $user = Input::get('user');
        $role = Input::get('role');
        $users = explode(", ", $user);
        $roles = explode(", ", $role);
        //return $users;
        $c1 = count($users);
        $c2= count($roles);
        for($i=0;$i<$c1;$i++)
        {
            $user_name = \App\User::where('user_name','=',$users[$i])->first();
            if($user_name!=null&&$user_name!="") {

                for ($j = 0; $j < $c2; $j++) {
                    $role_name = \App\Role::where('role_name','=',$roles[$j])->first();
                    if($role_name!=null&&$role_name!="") {
                        $user_role = new \App\UserRole();
                        $user_role->role_id = $role_name->id;
                        $user_role->user_id = $user_name->id;
                        $per = \App\UserRole::where('role_id', '=', $role_name->id)->where('user_id', '=', $user_name->id)->first();
                        if ($per== "") {
                            $user_role->save();
                        }

                    }
                }

            }
        }

        return Redirect::to('role_assign_to_user_list');
    }

    public function menu_assign_to_role_list()
    {
        $permissions  = \App\Permission::groupBy('role_id')->get();
        return View('role.menu_assign_to_role_list')->with('permissions',$permissions);
    }

    public function role_assign_to_user_list()
    {
        $user_roles  = \App\UserRole::groupBy('user_id')->get();
        return View('role.role_assign_to_user_list')->with('user_roles',$user_roles);
    }

    public function edit_role_assign_to_user($id)
    {
        $user_roles  = \App\UserRole::where('user_id','=',$id)->get();
        $user_name = \App\User::where('id','=',$id)->first();

        $roles = \App\Role::all();
        return View('role.edit_role_assign_to_user')->with('user_roles',$user_roles)->with('roles',$roles)->with('user_name',$user_name);
    }

    public function edit_role_assign_to_user2()
    {
        //return Input::all();
        $user_id = Input::get('user_id');
        $role_names = Input::get('role_name');
        $count = count($role_names);
        $user_role = \App\UserRole::where('user_id','=',$user_id)->get();
        if($user_role!="[]")
        {
            \App\UserRole::where('user_id','=',$user_id)->delete();
        }

        for($i=0;$i<$count;$i++)
        {


                $new_user_role = new \App\UserRole();
                $new_user_role->role_id = $role_names[$i];
                $new_user_role->user_id = $user_id;
                $new_user_role->save();

        }

        return Redirect::to('role_assign_to_user_list');
    }

    public function edit_menu_assign_to_role($id)
    {
        $menu_roles  = \App\Permission::where('role_id','=',$id)->get();

        $role = \App\Role::where('id','=',$id)->first();

        $menu = \App\Menu::where('type','=',1)->get();
        if($role!=null&&$role!="")
        return View('role.edit_menu_assign_to_role')->with('role',$role)->with('menu',$menu)->with('menu_roles',$menu_roles);

        return Redirect::back();
    }

    public function edit_menu_assign_to_role2()
    {
        //return Input::all();
        $role_id = Input::get('role_id');
        $menu_role = \App\Permission::where('role_id','=',$role_id)->get();
        if($menu_role!="[]")
        {
            \App\Permission::where('role_id','=',$role_id)->delete();
        }
        for ($i=1; $i < 100; $i++) {
            $sub=Input::get('menu' . $i);
            if ($sub!=null) {
                $permission = new \App\Permission();
                $permission->role_id = $role_id;
                $permission->menu_id = $sub;
                $per = \App\Permission::where('role_id','=',$role_id)->where('menu_id','=',$sub)->first();
                if($per==null)
                {
                    $permission->save();
                }
                for($j=1;$j<10;$j++)
                {
                    $submenu=Input::get('sub_menu' . $i.$j);
                    //return $submenu;
                    if ($submenu!=null) {
                        $permission2 = new \App\Permission();
                        $permission2->role_id = $role_id;
                        $permission2->menu_id = $submenu;
                        $per2 = \App\Permission::where('role_id', '=', $role_id)->where('menu_id', '=', $submenu)->first();
                        if ($per2 == null) {
                            $permission2->save();
                        }
                    }
                }
            }
        }


        return Redirect::to('menu_assign_to_role_list');
    }
}
