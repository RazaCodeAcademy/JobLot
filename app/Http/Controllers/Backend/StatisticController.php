<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use facades here
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// use models here
use App\Models\Job;
use App\Models\EmployeeAppliedJob;
use App\Models\Country;
use App\Models\ModelHasRole;
use App\Models\User;

class StatisticController extends Controller
{
    public function list()
    {
        $liveJobs = Job::where('status', 1)->where('job_approval','=',1)->count();
        $totalJobs = Job::all();
        $liveAppliedCandidateJobs = EmployeeAppliedJob::all()->count();
        $employers = ModelHasRole::select('model_id')->where('role_id','=','2')->get();
        $candidates = ModelHasRole::select('model_id')->where('role_id','=','3')->get();
        $employers = User::whereIn('id',$employers->pluck('model_id'))->get();
        return view('backend.pages.statistics.view',compact('liveJobs','totalJobs','liveAppliedCandidateJobs','employers','candidates'));
    }

    public function filterCountry(Request $request)
    {
        if ($request->country_id == 0)
        {
            $liveJobs = DB::table('jobs')->where('status','=',1)->where('job_approval','=',1)->count();
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
            $liveJobs = DB::table('jobs')->where('status','=',1)->where('job_approval','=',1)->where('job_location', $request->country_id)->count();
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

    public function statisticsFilters(Request $request){
        $data = [];

        // filter by all jobs
        if($request->filter_type == 'all-jobs'){
            $data = $this->filter_byAllJobs();
        }

        // filter by acitve jobs
        if($request->filter_type == 'active-jobs'){
            $data = $this->filter_byActiveJobs();
        }

        // filter by date
        if($request->filter_type == 'date'){
            $data = $this->filter_byDate($request->filter_by);
        }

        // filter by day
        if($request->filter_type == 'day'){
            $data = $this->filter_byDay($request->filter_by);
        }

        return response()->json($data);
    }

    public function filter_byAllJobs()
    {
       
        $liveJobs = Job::where('status', 1)->count();
        $totalJobs = Job::all()->count();
        $liveAppliedCandidateJobs = EmployeeAppliedJob::all()->count();
        $employers = ModelHasRole::select('model_id')->where('role_id','=','2')->get();
        $candidates = ModelHasRole::select('model_id')->where('role_id','=','3')->count();
        $employers = User::whereIn('id',$employers->pluck('model_id'))->count();

        return [
            'liveJobs' => $liveJobs,
            'totalJobs' => $totalJobs,
            'liveAppliedCandidateJobs' => $liveAppliedCandidateJobs,
            'employers' => $employers,
            'candidates' => $candidates,
        ];
    }

    public function filter_byActiveJobs()
    {
        $liveJobs = Job::where('status', 1)->where('job_approval', 1)->count();
        $totalJobs = Job::all()->count();
        $liveAppliedCandidateJobs = EmployeeAppliedJob::all()->count();
        $employers = ModelHasRole::select('model_id')->where('role_id','=','2')->get();
        $candidates = ModelHasRole::select('model_id')->where('role_id','=','3')->get();
        $employers = User::whereIn('id',$employers->pluck('model_id'))->where('status', 1)->count();
        $candidates = User::whereIn('id',$candidates->pluck('model_id'))->where('status', 1)->count();

        return [
            'liveJobs' => $liveJobs,
            'totalJobs' => $totalJobs,
            'liveAppliedCandidateJobs' => $liveAppliedCandidateJobs,
            'employers' => $employers,
            'candidates' => $candidates,
        ];
    }

    public function filter_byDate($filter_by)
    {
        $date = Carbon::parse($filter_by);
        $liveJobs = Job::whereDate('created_at', $date)->count();
        $totalJobs = Job::whereDate('created_at', $date)->count();
        $liveAppliedCandidateJobs = EmployeeAppliedJob::whereDate('created_at', $date)->count();
        $employers = ModelHasRole::select('model_id')->where('role_id','=','2')->get();
        $candidates = ModelHasRole::select('model_id')->where('role_id','=','3')->get();
        $employers = User::whereIn('id',$employers->pluck('model_id'))->whereDate('created_at', $date)->count();
        $candidates = User::whereIn('id',$candidates->pluck('model_id'))->whereDate('created_at', $date)->count();

        return [
            'liveJobs' => $liveJobs,
            'totalJobs' => $totalJobs,
            'liveAppliedCandidateJobs' => $liveAppliedCandidateJobs,
            'employers' => $employers,
            'candidates' => $candidates,
        ];
    }

    public function filter_byDay($filter_by)
    {
        $date = Carbon::now()->subDays($filter_by);
        $liveJobs = Job::whereDate('created_at', '>=', $date)->count();
        $totalJobs = Job::whereDate('created_at', '>=', $date)->count();
        $liveAppliedCandidateJobs = EmployeeAppliedJob::whereDate('created_at', '>=', $date)->count();
        $employers = ModelHasRole::select('model_id')->where('role_id','=','2')->get();
        $candidates = ModelHasRole::select('model_id')->where('role_id','=','3')->get();
        $employers = User::whereIn('id',$employers->pluck('model_id'))->whereDate('created_at', '>=', $date)->count();
        $candidates = User::whereIn('id',$candidates->pluck('model_id'))->whereDate('created_at', '>=', $date)->count();

        return [
            'liveJobs' => $liveJobs,
            'totalJobs' => $totalJobs,
            'liveAppliedCandidateJobs' => $liveAppliedCandidateJobs,
            'employers' => $employers,
            'candidates' => $candidates,
        ];
    }
}
