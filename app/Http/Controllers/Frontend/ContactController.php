<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use Model
use App\Models\Contact;
use Mail;
class ContactController extends Controller
{
     // Create Contact Form
   public function contact_us()
   {
      return view('frontend.pages.footer_pages.contact_us');
   }

   public function ContactUsForm(Request $request) {
      // Form validation
      $this->validate($request, [
         'name' => 'required',
         'email' => 'required|email',
         'subject'=>'required',
         'msg' => 'required'
      ]);
      $contact = new Contact;
      $contact->name = $request->name;
      $contact->email = $request->email;
      $contact->subject = $request->subject;
      $contact->msg = $request->msg;

      $contact->save();
       \Mail::send('frontend.pages.email.mail',
         array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'subject' => $request->get('subject'),
            'msg' => $request->get('msg'),
         ), function($message) use ($request)
         {
         $message->from($request->email);
         $message->to('nabeelshahbaz190@gmail.com');
      });
      return back()->with('success', 'We have received your message and would like to thank you for writing to us.');
  }
}
