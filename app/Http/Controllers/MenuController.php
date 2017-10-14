<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class MenuController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function create_menu() {
        $menu = \App\Menu::where('type', '=', 1)->get();
        return View('menu.create_menu')->with('menu', $menu);
    }

    public function post_create_menu() {
        //return Input::all();
        $parent_id = Input::get('parent_id');
        if ($parent_id != null) {
            $menu = new \App\Menu();
            $menu->menu_name = Input::get('menu_name');
            $menu->route_name = Input::get('route_name');
            $menu->type = 2;
            $menu->parent_id = $parent_id;
            $menu->save();
        } else {
            $menu = new \App\Menu();
            $menu->menu_name = Input::get('menu_name');
            $menu->route_name = Input::get('route_name');
            $menu->type = 1;
            $menu->save();
        }
        return Redirect::to('/menus');
    }

    public function listOFMenu() {
        $menues = \App\Menu::where('type', '=', 1)->get();
        return View('menu.list_of_menu')->with('menues', $menues);
    }

    public function edit_menu($id) {
        $menus = \App\Menu::where('id', '=', $id)->first();
        if ($menus != null)
            return View('menu.edit_menu')->with('menus', $menus);

        return Redirect::back();
    }

    public function edit_menu2() {
        //return Input::all();
        // $count = Input::get('i');
        $input['menu_name'] = Input::get('menu_name');
        $input['route_name'] = Input::get('route_name');
        $input['parent_id'] = Input::get('parent_id');
        $id = Input::get('id');
        \App\Menu::where('id', '=', $id)->update($input);

        return Redirect::to('menus');
    }

}
