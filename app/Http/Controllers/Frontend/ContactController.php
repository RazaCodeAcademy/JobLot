<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact_us()
   {
      return view('frontend.pages.footer_pages.contact_us');
   }
}
