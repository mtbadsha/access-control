<?php namespace App\Http\Controllers;

class MessageController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function messages()
    {
        $messages = \App\Message::orderBy('id','DESC')->get();
        return View('message.message')->with('messages',$messages);
    }

    public function message_individual($id)
    {
        $input['viewed'] = 'true';
        $not = \App\Message::where('id','=',$id)->first();
        if($not->viewed=='false') {
            \App\Message::where('id', '=', $id)->update($input);
        }
        $message = \App\Message::where('id','=',$id)->first();
        return View('message.message_individual')->with('message',$message);
    }


}
