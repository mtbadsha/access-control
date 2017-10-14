<?php namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class UserManagementController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function registration()
    {
        return View('auth.register');
    }

    public function postRegistration()
    {
        //return Input::all();

        $user = new \App\User();
        $user->user_name = Input::get('name');
        $user->email = Input::get('email');
        $user->local_id = Input::get('local_id');
        $user->global_id = Input::get('global_id');
        $user->isactive = Input::get('is_active');
        $user->password = Hash::make(Input::get('password'));
        $password = Input::get('password');
        $confirm = Input::get('password_confirmation');
        if($password==$confirm){
            $user->save();
            return Redirect::to('/users');
        }
        return Redirect::back();
    }

    public function listOfUser()
    {
        $users = User::all();
        return View('auth.list_of_user')->with('users',$users);
    }
    public function edit_user($id)
    {
        $user = \App\User::where('id','=',$id)->first();
        if($user!=null)
        return View('auth.edit_user')->with('user',$user);
        else
            return Redirect::to('users/create');
    }

    public function edit_user2()
    {
        //return Input::all();
        $input['user_name'] = Input::get('name');
        $input['email'] = Input::get('email');
        $input['local_id'] = Input::get('local_id');
        $input['global_id'] = Input::get('global_id');
        $input['isactive'] = Input::get('is_active');
        \App\User::where('id','=',Input::get('id'))->update($input);
        return Redirect::to('users');
    }

    public function reset_password($id)
    {
        return View('auth.reset_password')->with('id',$id);
    }

    public function post_reset_password()
    {
        //return Input::all();

        $new_password = Input::get('new_password');
        $confirm_new_password = Input::get('confirm_new_password');
        if($new_password==$confirm_new_password)
        {

                $input['password'] = Hash::make($new_password);
                \App\User::where('id','=',Input::get('id'))->update($input);
        }
        return Redirect::to('users');
    }
}
