<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use models
use App\Models\Job;
use App\Models\EmployeeAppliedJob;
use App\Models\EmployeeExperience;
use App\Models\User;
use App\Models\SavedJob;

// use facades
use Auth;
use DB;

class EmployeeController extends Controller
{
    public function apply_job(Request $request )
    {
        $appliedJob = New EmployeeAppliedJob();
        $appliedJob->user_id = Auth::user()->id;
        $appliedJob->job_id = $request->job_id;
        $appliedJob->status = '1';
        $appliedJob->save();

        user()->saved_jobs()->detach($request->job_id);

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
        $appliedJob = EmployeeAppliedJob::orderBy('created_at', 'DESC')->where('user_id', $user->id)->pluck('job_id');
        $jobs = formatJob($appliedJob);
        $jobs = getJob($jobs, $user->id);
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
    
    public function remove_experience(Request $request)
    {
        $user = user();
        $experience = EmployeeExperience::where('id', $request->id)
        ->where('user_id', $user->id)
        ->first();

        if(!empty($experience)){
            $experience->delete();
            return response()->json([
                'success' => true,
                'message' => "User experience deleted successfuly!",
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => "User experience not deleted please try again!",
        ], 200);
       
    }

    public function search_job(Request $request){
        $latitude = user()->latitude;
        $longitude = user()->longitude;
        $distance = $request->distance;
        $city = $request->city;
        
        $jobs_array = [];
        
        $jobs = Job::where(function ($query) use($request){
            return $query->where('title', 'LIKE', '%'.$request->search.'%')
            ->orWhere('comp_name', 'LIKE', '%'.$request->search.'%')
            ->orWhere('job_type', 'LIKE', '%'.$request->search.'%')
            ->orWhere('job_qualification', 'LIKE', '%'.$request->search.'%');
        })->get();

        if(!empty($distance)){
            foreach($jobs as $job){
                $user = User::find($job->employer_id);
                $user = $user->select("*", DB::raw("3959 * acos(cos(radians(" . $latitude . "))
                        * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
                        + sin(radians(" .$latitude. ")) * sin(radians(latitude)) <= ".$distance.") AS distance"));
                $user = $user->first();
    
                if(!empty($user)){
                    array_push($jobs_array, $job);
                }
            }
        }

        if(!empty($city)){
            foreach($jobs as $job){
                $user = User::where(function ($query) use($city){
                    return $query->where('city_name', 'LIKE', '%'.$city.'%');
                })->where('id', $job->employer_id)->first();
                
                if(!empty($user)){
                    array_push($jobs_array, $job);
                }
            }
        }

        return response()->json([
            'count' => count($jobs_array),
            'jobs' => $jobs_array,
        ], 200);
    }
    public function delete_saved_jobs(Request $request){
        $saved_job = SavedJob::where([['job_id', $request->job_id], ['user_id', user()->id]])->first();
        if($saved_job->delete()){
            return response()->json([
                'success' => true,
                'message' => 'Saved Job has been deleted successfuly!'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong please try again!'
        ], 400);
    }

    public function delete_applied_jobs(Request $request){
        $applied_job = EmployeeAppliedJob::where([['job_id', $request->job_id], ['user_id', user()->id]])->first();
        if($applied_job->delete()){
            return response()->json([
                'success' => true,
                'message' => 'Applied Job has been deleted successfuly!'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong please try again!'
        ], 400);
    }

} 