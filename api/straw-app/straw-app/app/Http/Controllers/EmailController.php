<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $data['title'] = "This is Test Mail Tuts Make";
 
        Mail::send('emails.email', $data, function($message) {
 
            $message->to('bawa_d@ymail.com', 'Deepak Bawa')
 
                ->subject('Laravel Make Mail');
        });

        // Mail::to( 'bawa_d@ymail.com', 'Deepak Bawa' )->subject('Laravel Make Mail');
 
        if (Mail::failures()) {
          //  return response()->Fail('Sorry! Please try again latter');
          die('eror');
         }else{
          //  return response()->success('Great! Successfully send in your mail');
          die('success');
         }
    }
}