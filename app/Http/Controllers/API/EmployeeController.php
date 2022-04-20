<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use models
use App\Models\Job;
use App\Models\EmployeeAppliedJob;
use App\Models\EmployeeExperience;
use App\Models\User;

// use facades
use Auth;

class EmployeeController extends Controller
{
    public function apply_job(Request $request )
    {
        $appliedJob = New EmployeeAppliedJob();
        $appliedJob->user_id = Auth::user()->id;
        $appliedJob->job_id = $request->job_id;
        $appliedJob->status = '1';
        $appliedJob->save();

        $job = Job::find($request->job_id);

        notifications(
            $job->id, 
            $job->employer_id, 
            EmployeeAppliedJob::class, 
            "applied on job ". $job->title ." at: (". date('d-M-y') .")"
        );

        return response()->json([
            'appliedJob' => $appliedJob,
        ], 200);
    }

    public function applied_jobs_list()
    {
        $user = Auth::user();
        $appliedJob = EmployeeAppliedJob::where('user_id', $user->id)->pluck('job_id');
        $jobs = Job::orderBy('id', 'DESC')->whereIn('id', $appliedJob->toArray())->get();
        foreach ($jobs as $job) {
            $job->applied = 1;
        }
        return response()->json([
            'applied_jobs_list' => $jobs,
        ], 200);
    }

    public function add_experience(Request $request)
    {
        $data = [
            'user_id' => user()->id,
            'title' => $request->title,
            'company' => $request->company,
            'period' => $request->period,
            'description' => $request->description,
        ];

        $experience = EmployeeExperience::create($data);

        if (!empty($experience)) {
            return response()->json([
                'success' => true,
                'message' => 'experience added successfuly!',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'something went wrong please try again!',
        ], 400);
    }

    public function get_experience(Request $request)
    {
        $user = null;
        if(!empty($request->user_id)){
            $user = User::find($request->user_id);
        }else{
            $user = user();
        }

        return response()->json([
            'count' => count($user->get_experiences),
            'experiences' => $user->get_experiences,
        ], 200);
       
    }

    public function search_job(Request $request){
        $jobs = Job::where(function ($query) use($request){
            return $query->where('title', 'LIKE', '%'.$request->search.'%')
            ->orWhere('comp_name', 'LIKE', '%'.$request->search.'%')
            ->orWhere('job_type', 'LIKE', '%'.$request->search.'%')
            ->orWhere('job_qualification', 'LIKE', '%'.$request->search.'%');
        })->get();

        return response()->json([
            'count' => count($jobs),
            'jobs' => $jobs,
        ], 200);
    }

    public function search_chat_list(Request $request){
        $jobs = Job::where(function ($query) use($request){
            return $query->where('title', 'LIKE', '%'.$request->search.'%')
            ->orWhere('comp_name', 'LIKE', '%'.$request->search.'%')
            ->orWhere('job_type', 'LIKE', '%'.$request->search.'%')
            ->orWhere('job_qualification', 'LIKE', '%'.$request->search.'%');
        })->get();

        return response()->json([
            'count' => count($jobs),
            'jobs' => $jobs,
        ], 200);
    }

} 