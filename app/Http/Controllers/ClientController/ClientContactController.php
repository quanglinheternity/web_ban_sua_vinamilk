<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Mail\ThankYouEmail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Mail;

class ClientContactController extends Controller
{
    public function index(){
        return view('client.contact');
    }
    public function sendContact(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'message' => 'required|string',

        ]);
         // Gửi email (sẽ không thực sự gửi, chỉ ghi vào log)
        Mail::to($request->email)->send(new ThankYouEmail($request->name));
        Contact::create($request->all());
        // dd($request->all());
        return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ sớm trả lời bạn.');

    }
}
