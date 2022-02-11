<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use models
use App\Models\Job;
use App\Models\EmployeeAppliedJob;

// use facades
use Auth;

class JobController extends Controller
{
    public function all_job()
    {
        $user = Auth::user();
        $jobs = Job::orderBy('id', 'DESC')->get();

        $appliedJob = EmployeeAppliedJob::where('user_id', $user->id)->pluck('job_id');

        foreach ($jobs as $job) {
            if(in_array($job->id, $appliedJob->toArray())){
                $job->applied = 1;
            }else{
                $job->applied = 0;
            }
        }

        return response()->json([
            'count' => count($jobs),
            'all_jobs' => $jobs,
        ], 200);
    }

    public function employee_saved_job(Request $request){
        $user = Auth::user();
        $user->saved_jobs()->attach($request->job_id);

        // Notification($shortListedApplicants->id, EmployeeShortListed::class);
       
        return response()->json([
            'saved_jobs' => $user->saved_jobs,
        ], 200);
    }

    public function employee_get_saved_job(Request $request){
        $user = Auth::user();
        if(count($user->saved_jobs) > 0){
            return response()->json([
                'saved_jobs' => $user->saved_jobs,
            ], 200);
        }
        return response()->json([
            'error' => "there is no saved job for the user",
        ], 200);
    }
}
