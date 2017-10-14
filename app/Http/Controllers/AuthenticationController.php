<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class AuthenticationController extends Controller {

    public function login()
    {
        return View('auth.login');
    }

    public function postLogin()
    {
        $input = Input::all();
        //return $input;
        $attempt = Auth::attempt([
            'email'=>$input['email'],
            'password' => $input['password'],
            'isactive' => 1
        ]);
        if($attempt) return Redirect::intended('/');
        return Redirect::back();
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/login');
    }

    public function change_password()
    {
        return View('auth.change_password');
    }

    public function ajaxpass()
    {
        $password = Input::get('password');
        if (Hash::check($password, Auth::user()->password))
        {
            $pass = 'true';
        }
        else
        {
            $pass = 'false';
        }
        return Response::json($pass);
    }

    public function post_change_password()
    {
        //return Input::all();
        $old_password = Input::get('old_password');
        $new_password = Input::get('new_password');
        $confirm_new_password = Input::get('confirm_new_password');
        if($new_password==$confirm_new_password)
        {
            //return Auth::user()->password;
            if (Hash::check($old_password, Auth::user()->password))
            {
                
                $input['password'] = Hash::make($new_password);
                \App\User::where('id','=',Auth::user()->id)->update($input);
                \App\lib\utility::addNotification('Password Changed', "You have changed your password", Auth::user()->global_id);
            }else{
                \App\lib\utility::addNotification('Password Changed Failed', "You have entered wrong password during password change.", Auth::user()->global_id);
                return Redirect::back()->with('message','Old Password does not match');
            }
        }
        return Redirect::to('/');
    }
}
