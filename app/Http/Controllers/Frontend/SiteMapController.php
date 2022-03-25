<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteMapController extends Controller
{
    public function site_map()
   {
      return view('frontend.pages.footer_pages.site_map');
   }
}
