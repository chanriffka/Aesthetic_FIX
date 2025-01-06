<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    public function index()
    {
        $messages = ContactUs::all();
        return view('admin.contact-us', compact('messages'));
    }

    public function show($id)
    {
        $message = ContactUs::find($id);

        if($message == null) {
            return redirect()->back()->withErrors(['message'=>'Message not found']);
        }

        return view('admin.contact-us-view', compact('message'));
    }

    public function update($id)
    {
        $message = ContactUs::find($id);

        if($message == null) {
            return redirect()->back()->withErrors(['message'=>'Message not found']);
        }

        if($message->STATUS == 0) {
            $message->STATUS = 1;
        } else {
            $message->STATUS = 0;
        }

        $message->save();

        return redirect()->back()->with('status','Message #'.$message->CONTACT_US_ID.' is has been updated!');
    }
}
