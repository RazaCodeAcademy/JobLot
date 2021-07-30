<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function list()
    {
        $liveJobs = DB::table('jobs')->where('status','=',1)->where('approval_status','=',1)->count();
        $totalJobs = DB::table('jobs')->get();
        $totalCandidateJobsApplied = DB::table('candidate_applied_jobs')->count();
        $liveAppliedCandidateJobs = DB::table('candidate_applied_jobs')->count();
        $employers = DB::table('model_has_roles')->select('model_id')->where('role_id','=','2')->get();
        $candidates = DB::table('model_has_roles')->select('model_id')->where('role_id','=','3')->get();
        $countries = DB::table('countries')->get();

        return view('backend.pages.statistics.view',compact('liveJobs','totalJobs','totalCandidateJobsApplied','liveAppliedCandidateJobs','employers','candidates','countries'));
    }

    public function filterCountry(Request $request)
    {
        if ($request->country_id == 0)
        {
            $liveJobs = DB::table('jobs')->where('status','=',1)->where('approval_status','=',1)->count();
            $totalJobs = DB::table('jobs')->count();
            $totalCandidateJobsApplied = DB::table('candidate_applied_jobs')->count();
            $liveAppliedCandidateJobs = DB::table('candidate_applied_jobs')->count();
            $candidates = DB::table('model_has_roles')->select('model_id')->where('role_id','=','3')->count();
            $employers = DB::table('model_has_roles')->select('model_id')->where('role_id','=','2')->count();

            $data = [$liveJobs,$totalJobs,$totalCandidateJobsApplied,$liveAppliedCandidateJobs,$candidates,$employers];

            return response()->json(['values'=>$data]);
        }

        else
        {
            $liveJobs = DB::table('jobs')->where('status','=',1)->where('approval_status','=',1)->where('job_location', $request->country_id)->count();
            $totalJobs = DB::table('jobs')->where('job_location', $request->country_id)->count();
            $totalCandidateJobsApplied = DB::table('candidate_applied_jobs')
                ->join('jobs','candidate_applied_jobs.job_id','=','jobs.id')
                ->where('jobs.job_location','=',$request->country_id)
                ->count();
            $liveAppliedCandidateJobs = DB::table('candidate_applied_jobs')
                ->join('jobs','candidate_applied_jobs.job_id','=','jobs.id')
                ->where('jobs.job_location','=',$request->country_id)
                ->count();

            $candidates = DB::table('model_has_roles')
                ->join('users','model_has_roles.model_id','=','users.id')
                ->join('candidate_personal_informations','model_has_roles.model_id','=','candidate_personal_informations.user_id')
                ->where('model_has_roles.role_id','=',3)
                ->where('candidate_personal_informations.nationality','=',$request->country_id)
                ->count();

            $employers = DB::table('model_has_roles')
                ->join('users','model_has_roles.model_id','=','users.id')
                ->where('model_has_roles.role_id','=',2)
                ->where('users.country_name','=',$request->country_id)
                ->count();

            $data = [$liveJobs,$totalJobs,$totalCandidateJobsApplied,$liveAppliedCandidateJobs,$candidates,$employers];

            return response()->json(['values'=>$data]);
        }

    }
}
