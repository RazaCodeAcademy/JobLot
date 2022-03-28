<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();

       return view('backend.pages.contacts.index')->with(compact('contacts'));
    }

    public function deletecontact(Request $request){
        
        $contact = Contact::where('id',$request->id)->first();

        if(empty($contact)) {
            return response()->json(['status' => 0]);
        }

        $contact->delete();

        return response()->json(['status' => 1]);
    }
}
