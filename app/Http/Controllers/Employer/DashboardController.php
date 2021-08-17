<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = DB::table('users')->find(auth()->user()->id);

        $user_application_id = DB::table('users')
        ->join('jobs','users.id','=','jobs.user_id')
        ->join('candidate_applied_jobs','jobs.id','=','candidate_applied_jobs.job_id')
        ->where('users.id', $user->id)
        ->get();

        $jobs = DB::table('jobs')->select()->where('user_id', $user->id)->orderBy('id', 'desc')->get();
        $liveJobs = DB::table('jobs')->where('user_id', $user->id)->where('status', '=', 1)->where('approval_status', '=', 1)->count();
        $jobCount = DB::table('employee_packages')
        ->where('user_id', $user->id)
        ->where('status', 1)
        ->first();

        $count = count($user_application_id);

        $totalJobCount = 0;

        foreach ($jobs as $item) {
            $totalJobCount = $item->count + $totalJobCount;
        }

        return view('employer.pages.dashboard.dashboard', compact('user','count','jobs', 'totalJobCount','liveJobs','jobCount'));
    }
}
