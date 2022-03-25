<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class EmployeeController extends Controller
{
    public function list()
    {
        $employees = User::whereHas(
            'roles', function($q){
                $q->where('role_id', '3');
            })->orderby('created_at','desc')->where('status', 1)->with('country')->get();

        // $date = \Carbon\Carbon::today()->subDays(5);
        // $activeUsers = DB::table('active_users')->where('date','>=',$date)->count();

        return view('backend.pages.employee.list', compact('employees'));

    }
}
