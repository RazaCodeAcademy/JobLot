<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function carrer()
   {
      return view('frontend.pages.footer_pages.carrer');
   }
}
