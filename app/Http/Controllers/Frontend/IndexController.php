<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(){
        $timeCheck = Carbon::now();
        $locations = DB::table('countries')->get();
        $active_jobs = DB::table('jobs') ->where('status', '=', 1)->where('approval_status', '=', '1')->whereDate('date','<=', Carbon::now())->whereDate('endingDate','>=', Carbon::now())->count();
        $total_jobs = DB::table('jobs') ->where('approval_status', '=', 1)->whereDate('date','<=', Carbon::now())->whereDate('endingDate','>=', Carbon::now())->orderBy('id','DESC')->get();
        $job_categories = DB::table('employee_bussiness_categories')->get();
        $total_candidates = DB::table('model_has_roles')->where('role_id', '=',3)->count();
        $total_companies_count = DB::table('model_has_roles')->where('role_id', '=',2)->count();
        $total_companies = DB::table('model_has_roles')->where('role_id', '=',2)->get();
        $totalCvs = DB::table('candidate_applied_jobs')->count();

        return view('frontend.pages.index', compact('job_categories','locations','active_jobs','total_jobs','total_candidates','total_companies_count','total_companies','timeCheck', 'totalCvs'));
    }

    public function job_details($slug){
        $job = DB::table('jobs')->select()->where('slug', $slug)->first();

        if (empty($job)) {
            return redirect()->back();
        }

        $user = DB::table('users')->select()->where('id', $job->user_id)->first();

        DB::table('jobs')->where('id', $job->id)->update(array(
            'count' => $job->count + 1 ,
        ));

        $timeCheck = Carbon::now();
        $locations = DB::table('countries')->get();
        $job_categories = DB::table('employee_bussiness_categories')->get();

        return view('frontend.pages.job_details',compact('job','user', 'locations', 'job_categories', 'timeCheck'));
    }

    public function job_search(Request $request){
        // return $request->all();
        $keyword = $request->keyword;

        $searchQuery = DB::table('jobs')->where('status', '=',1)
        ->where('approval_status', '=', 1)
        ->whereDate('date','<=', Carbon::now())
        ->whereDate('endingDate', '>=', Carbon::now())
        ->where(function($query) use($keyword){
            return $query->where('title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('title_ar', 'LIKE', '%' . $keyword . '%');
        });

        if($request->location != null){
            $searchQuery->where('job_location', $request->location);
        }

        if($request->category != null){
            $searchQuery->where('category', $request->category);
        }

        $total_jobs = $searchQuery->get();

        return view('frontend.pages.job_filter',compact('total_jobs'));
    }

    public function countryJobs($id){

        $total_jobs = DB::table('jobs')->where('status', '=',1)
        ->where('approval_status', '=', 1)
        ->whereDate('date','<=', Carbon::now())
        ->whereDate('endingDate', '>=', Carbon::now())
        ->where('job_location', $id)
        ->get();

        return view('frontend.pages.job_filter',compact('total_jobs'));
    }

    public function categoryJobs($id){

        $total_jobs = DB::table('jobs')->where('status', '=',1)
        ->where('approval_status', '=', 1)
        ->whereDate('date','<=', Carbon::now())
        ->whereDate('endingDate', '>=', Carbon::now())
        ->where('category', $id)
        ->get();

        return view('frontend.pages.job_filter',compact('total_jobs'));
    }

    public function addLanguage(){
        session()->put('language', true);
        return redirect()->back();
    }

    public function removeLanguage(){
        session()->forget('language');
        return redirect()->back();
    }
}