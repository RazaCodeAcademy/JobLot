<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
   public function about_us()
   {
      return view('frontend.pages.footer_pages.about_us');
   }
}
