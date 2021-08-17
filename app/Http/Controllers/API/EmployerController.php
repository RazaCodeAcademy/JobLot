<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class EmployerController extends Controller
{
    public function businessCategories(){

        $businessCategories = DB::table('employee_bussiness_categories')->orderBy('id', 'DESC')->get();

        return response()->json([
            'businessCategories' => $businessCategories,
        ], 401);
    }

    public function states(){

        $states = DB::table('cities')->orderBy('id', 'DESC')->get();

        return response()->json([
            'states' => $states,
        ], 401);
    }
}
