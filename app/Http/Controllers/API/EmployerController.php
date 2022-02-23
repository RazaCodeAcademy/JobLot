<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use facades
use DB;
use Auth;

// use models
use App\Models\Job;
use App\Models\User;
use App\Models\EmployeeAppliedJob;
use App\Models\ShortListedCandidate;
use App\Models\EmployeeShortListed;
use App\Models\EmployeeSavedListed;

class EmployerController extends Controller
{
    public function businessCategories(){

        $businessCategories = DB::table('employee_bussiness_categories')->orderBy('id', 'DESC')->get();

        return response()->json([
            'businessCategories' => $businessCategories,
        ], 200);
    }

    public function states(){

        $states = DB::table('cities')->orderBy('id', 'DESC')->get();

        return response()->json([
            'states' => $states,
        ], 200);
    }

    public function jobList(){

        $jobs = Job::where('employer_id', Auth::id())->orderBy('id', 'DESC')->get();
        return response()->json([
            'jobs' => $jobs,
        ], 200);
    }

    public function latestJobs(Request $request ){

        $job = Job::where('employer_id', Auth::id())->orderBy('id', 'DESC')->first();
        $applied = EmployeeAppliedJob::where('job_id', $request->id)->count();
        $shortListed = EmployeeShortListed::where('job_id', $request->id)->count();
        

        return response()->json([
            'job' => $job,
            'total_applied' => $applied,
            'total_short_listed' => $shortListed,
        ], 200);
    }

    public function selectedJobs(Request $request ){
       
        $selectedJob = Job::find($request->id);
        $applied = EmployeeAppliedJob::where('job_id', $request->id)->count();
        $shortListed = EmployeeShortListed::where('job_id', $request->id)->count();
        
        return response()->json([
            'selectedJob' => $selectedJob,
            'total_applied' => $applied,
            'total_short_listed' => $shortListed,
        ], 200);
    }

    public function appliedJobs(Request $request ){

        $appliedJob = EmployeeAppliedJob::find($request->id);
        
        return response()->json([
            'appliedJob' => $appliedJob,
        ], 200);
    }
   
    public function singleJobAplicantList(Request $request)
    {
        // return $request->job_id;
        $singleJobAplicantList = EmployeeAppliedJob::where('job_id', $request->job_id)->pluck('user_id');
        $singleJobAplicantList = User::whereIn('id', $singleJobAplicantList->toArray())->get();

        // get user is applied on job shortlisted and savedlisted
        $singleJobAplicantList = getUser($singleJobAplicantList, $request->job_id);

        return response()->json([
            'singleJobAplicantList' => $singleJobAplicantList,
        ], 200);
    }
    public function filter_applicants(Request $request)
    {
        $request->experience = $request->experience ?? 0;

        // get job list
        if($request->job_id == 0){
            // get all job list
            $job_ids = Job::where([
                ['employer_id',Auth::id()],
                ['job_type',$request->job_type],
            ])->pluck('id');
        }else{
            // get a specific job
            $job_ids = Job::where([
                ['employer_id',Auth::id()],
                ['id',$request->job_id],
                ['job_type',$request->job_type],
            ])->pluck('id');
        }

        // created a requested date
        $date = date('Y-m-d H:i:s',strtotime($request->date));

        // pluck employee ids who are applied on filterd job
        $user_ids = EmployeeAppliedJob::whereIn('job_id', $job_ids)->pluck('user_id');

        // get employee data
        $users = User::whereIn('id', $user_ids)
                ->whereHas('get_experiences', function($query) use($request){
                    return $query->where('period', '<=', $request->experience);
                });

        // get employees nearby
        $filterApplicants = $this->near_by_applicants($users, $request->distance);

        // get user is applied on job shortlisted and savedlisted
        $filterApplicants = getUser($filterApplicants, $request->job_id);

        // return response after filterize employees
        return response()->json([
            'count' => count($filterApplicants),
            'filterApplicants' => $filterApplicants,
        ], 200);
    }

    public function search_applicants(Request $request)
    {
        if($request->search == ''){
            return response()->json([
                'count' => 0,
                'employees' => [],
            ], 200);
        }

        $users = User::whereHas('roles', function($query){
            return $query->where('name', 'employee');
        })->where(function ($query) use($request){
                return $query->where('first_name', 'LIKE', '%'.$request->search.'%')
                ->orWhere('last_name', 'LIKE', '%'.$request->search.'%')
                ->orWhere('email', 'LIKE', '%'.$request->search.'%');
            });

        // get employees nearby
        $employees = $this->near_by_applicants($users);

        // get user is applied on job shortlisted and savedlisted
        $employees = getUser($employees, $request->job_id);

        return response()->json([
            'count' => count($employees),
            'employees' => $employees,

        ], 200);
    }

    // search nearby applicants
    public function near_by_applicants($users, $distance=20)
    {
        $latitude = user()->latitude;
        $longitude = user()->longitude;

        $users  =   $users->select("*", DB::raw("3959 * acos(cos(radians(" . $latitude . "))
                    * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
                    + sin(radians(" .$latitude. ")) * sin(radians(latitude)) <= ".$distance.") AS distance"));
        return      $users->orderBy('distance', 'asc')->get();
    }
     
    public function addToShortListEmployee(Request $request)
    {
        $shortListedApplicants = New EmployeeShortListed();
        $shortListedApplicants->user_id = $request->user_id;
        $shortListedApplicants->job_id = $request->job_id;
        $shortListedApplicants->status = '1';
        $shortListedApplicants->save();

        $userSaved = EmployeeSavedListed::where([
            ['user_id', $request->user_id], 
            ['job_id', $request->job_id]
        ])->first();
        if(!empty($userSaved)){
            $userSaved->delete();
        }

        notifications(
            $request->job_id,
            $shortListedApplicants->user_id, 
            EmployeeShortListed::class, 
            "shortlisted to you at: (". date('d-M-y') .")"
        );

        return response()->json([
            'shortListedApplicants' => $shortListedApplicants,
        ], 201);
    }
     
    public function addToSaveListEmployee(Request $request)
    {
        $savedListedApplicants = New EmployeeSavedListed();
        $savedListedApplicants->user_id = $request->user_id;
        $savedListedApplicants->job_id = $request->job_id;
        $savedListedApplicants->status = '1';
        $savedListedApplicants->save();

        notifications(
            $request->job_id,
            $savedListedApplicants->user_id, 
            EmployeeSavedListed::class, 
            "saved to you at: (". date('d-M-y') .")"
        );

        return response()->json([
            'savedListedApplicants' => $savedListedApplicants,
        ], 201);
    }

    public function shortListed(Request $request)
    {
        $user = Auth::user();
        $shortListed = EmployeeShortListed::where('job_id', $request->job_id)->pluck('user_id');
        $shortListed = User::whereIn('id', $shortListed)->get();

        return response()->json([
            'shortListed' => $shortListed,
        ], 200);
    }

    public function savedListed(Request $request)
    {
        $user = Auth::user();
        $savedListed = EmployeeSavedListed::where('job_id', $request->job_id)->pluck('user_id');
        $savedListed = User::whereIn('id', $savedListed)->get();

        return response()->json([
            'savedListed' => $savedListed,
        ], 200);
    }

    public function removeShortListed(Request $request)
    {
        $shortListedApplicants = EmployeeShortListed::where([['job_id', $request->job_id], ['user_id', $request->user_id]])->first();

        if(!empty($shortListedApplicants)){
            $shortListedApplicants->delete();
            return response()->json([
                'success' => true,
                'message' => 'User has been removed from shostlist successfuly!'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong please try again!'
        ], 400);
    }

    public function removeSaveListed(Request $request)
    {
        $saveListedApplicants = EmployeeSavedListed::where([['job_id', $request->job_id], ['user_id', $request->user_id]])->first();

        if(!empty($saveListedApplicants)){
            $saveListedApplicants->delete();
            return response()->json([
                'success' => true,
                'message' => 'User has been removed from savelist successfuly!'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong please try again!'
        ], 400);
    }
}
