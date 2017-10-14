<?php namespace App\Http\Controllers;

class NotificationController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function notifications()
    {
        $notifications = \App\Notification::orderBy('id','DESC')->get();
        return View('notification.notification')->with('notifications',$notifications);
    }

    public function notification_individual($id)
    {
        $input['viewed'] = 'true';
        $not = \App\Notification::where('id','=',$id)->first();
        if($not->viewed=='false') {
            \App\Notification::where('id', '=', $id)->update($input);
        }
        $notification = \App\Notification::where('id','=',$id)->first();
        return View('notification.notification_individual')->with('notification',$notification);
    }


}
