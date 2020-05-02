<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Guest Operations
    |--------------------------------------------------------------------------
    */

    public function sendRequest(Request $request){
        Mail::send('support.contact_email',
            array(
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'msg' => $request->input('message'),
            ), function($message) use ($request)
            {
                $message->from('regi.muci@fshnstudent.info');
                $message->subject('e-Bio Store Support');
                $message->to('regi.muci@fshnstudent.info');
            });

        return back()->with('status', 'Thank you for contact us!');
    }
}
