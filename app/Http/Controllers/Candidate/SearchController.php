<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search()
    {
        $countries = DB::table('countries')->get();
        $industries = DB::table('employee_bussiness_categories')->get();
        $companies = DB::table('users')
            ->select('users.name as name')
            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->where('model_has_roles.role_id','=', 2)
            ->get();

        return view('candidates.pages.search.search', compact('countries','industries','companies'));
    }

    public function jobs(Request $request)
    {
        // return $request->all();
        if ($request->country_id != null && $request->industry_id != null && $request->company_name != null)
        {
            $request->industry_id;
            $countries = DB::table('countries')->get();
            $industries = DB::table('employee_bussiness_categories')->get();
            $companies = DB::table('users')
                ->select('users.name as name')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->where('model_has_roles.role_id','=', 2)
                ->get();

            $jobs = DB::table('jobs')
                ->select( 'jobs.id as job_id','jobs.job_location as job_location','jobs.title as title','jobs.slug as slug',
                    'jobs.description as description','jobs.date as date','jobs.endingDate as endingDate',
                    'jobs.category as category','users.avatar as avatar','users.category as user_category')
                ->join('users','jobs.user_id','=','users.id')
                ->where('jobs.status', '=',1)
                ->where('jobs.approval_status', '=',1)
                ->whereDate('jobs.date','<=', Carbon::now())
                ->whereDate('jobs.endingDate','>=', Carbon::now())
                ->where('jobs.job_location', '=',$request->country_id)
                ->where('jobs.category','=', $request->industry_id)
                ->where('users.name', 'like', '%' . $request->company_name . '%')
                ->orderBy('jobs.created_at', 'DESC')
                ->get();

            $countryId = $request->country_id;
            $industryId = $request->industry_id;
            $companyName = $request->company_name;

            return view('candidates.pages.search.search',compact('jobs', 'countries','industries','companies','companyName','industryId','countryId'));

        }

        elseif ($request->country_id != null && $request->industry_id != null && $request->company_name == null)
        {
            $countries = DB::table('countries')->get();
            $industries = DB::table('employee_bussiness_categories')->get();
            $companies = DB::table('users')
                ->select('users.name as name')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->where('model_has_roles.role_id','=', 2)
                ->get();

            $jobs = DB::table('jobs')
                ->select( 'jobs.id as job_id','jobs.job_location as job_location','jobs.title as title','jobs.slug as slug',
                    'jobs.description as description','jobs.date as date','jobs.endingDate as endingDate',
                    'jobs.category as category','users.avatar as avatar','users.category as user_category')
                ->join('users','jobs.user_id','=','users.id')
                ->where('jobs.status', '=',1)
                ->where('jobs.approval_status', '=',1)
                ->whereDate('jobs.date','<=', Carbon::now())
                ->whereDate('jobs.endingDate','>=', Carbon::now())
                ->where('jobs.job_location', '=',$request->country_id)
                ->where('jobs.category','=', $request->industry_id)
                ->orderBy('jobs.created_at', 'DESC')
                ->get();

            $countryId = $request->country_id;
            $industryId = $request->industry_id;
            $companyName = $request->company_name;

            return view('candidates.pages.search.search',compact('jobs', 'countries','industries','companies','companyName','industryId','countryId'));

        }

        elseif ($request->country_id != null && $request->industry_id == null && $request->company_name == null)
        {
            $countries = DB::table('countries')->get();
            $industries = DB::table('employee_bussiness_categories')->get();
            $companies = DB::table('users')
                ->select('users.name as name')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->where('model_has_roles.role_id','=', 2)
                ->get();

            $jobs = DB::table('jobs')
                ->select( 'jobs.id as job_id','jobs.job_location as job_location','jobs.title as title','jobs.slug as slug',
                    'jobs.description as description','jobs.date as date','jobs.endingDate as endingDate',
                    'jobs.category as category','users.avatar as avatar','users.category as user_category')
                ->join('users','jobs.user_id','=','users.id')
                ->where('jobs.status', '=',1)
                ->where('jobs.approval_status', '=',1)
                ->whereDate('jobs.date','<=', Carbon::now())
                ->whereDate('jobs.endingDate','>=', Carbon::now())
                ->where('jobs.job_location', '=',$request->country_id)
                ->orderBy('jobs.created_at', 'DESC')
                ->get();

            $countryId = $request->country_id;
            $industryId = $request->industry_id;
            $companyName = $request->company_name;

            return view('candidates.pages.search.search',compact('jobs', 'countries','industries','companies','companyName','industryId','countryId'));

        }

        elseif ($request->country_id == null && $request->industry_id == null && $request->company_name == null)
        {
            $countries = DB::table('countries')->get();
            $industries = DB::table('employee_bussiness_categories')->get();
            $companies = DB::table('users')
                ->select('users.name as name')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->where('model_has_roles.role_id','=', 2)
                ->get();

            $jobs = DB::table('jobs')
                ->select( 'jobs.id as job_id','jobs.job_location as job_location','jobs.title as title','jobs.slug as slug',
                    'jobs.description as description','jobs.date as date','jobs.endingDate as endingDate',
                    'jobs.category as category','users.avatar as avatar','users.category as user_category')
                ->join('users','jobs.user_id','=','users.id')
                ->where('jobs.status', '=',1)
                ->where('jobs.approval_status', '=',1)
                ->whereDate('jobs.date','<=', Carbon::now())
                ->whereDate('jobs.endingDate','>=', Carbon::now())
                ->orderBy('jobs.created_at', 'DESC')
                ->get();

            // $data = view('candidates.pages.search.search-jobs',compact('jobs'))->render();
            // return response()->json(['options'=>$data]);

            $countryId = $request->country_id;
            $industryId = $request->industry_id;
            $companyName = $request->company_name;

            return view('candidates.pages.search.search',compact('jobs', 'countries','industries','companies','companyName','industryId','countryId'));

        }

        elseif ($request->country_id != null && $request->industry_id == null && $request->company_name != null)
        {
            $countries = DB::table('countries')->get();
            $industries = DB::table('employee_bussiness_categories')->get();
            $companies = DB::table('users')
                ->select('users.name as name')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->where('model_has_roles.role_id','=', 2)
                ->get();

            $jobs = DB::table('jobs')
                ->select( 'jobs.id as job_id','jobs.job_location as job_location','jobs.title as title','jobs.slug as slug',
                    'jobs.description as description','jobs.date as date','jobs.endingDate as endingDate',
                    'jobs.category as category','users.avatar as avatar','users.category as user_category')
                ->join('users','jobs.user_id','=','users.id')
                ->where('jobs.status', '=',1)
                ->where('jobs.approval_status', '=',1)
                ->whereDate('jobs.date','<=', Carbon::now())
                ->whereDate('jobs.endingDate','>=', Carbon::now())
                ->where('jobs.job_location', '=',$request->country_id)
                ->where('users.name', 'like', '%' . $request->company_name . '%')
                ->orderBy('jobs.created_at', 'DESC')
                ->get();

            $countryId = $request->country_id;
            $industryId = $request->industry_id;
            $companyName = $request->company_name;

            return view('candidates.pages.search.search',compact('jobs', 'countries','industries','companies','companyName','industryId','countryId'));

        }

        elseif ($request->country_id == null && $request->industry_id != null && $request->company_name != null)
        {
            $countries = DB::table('countries')->get();
            $industries = DB::table('employee_bussiness_categories')->get();
            $companies = DB::table('users')
                ->select('users.name as name')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->where('model_has_roles.role_id','=', 2)
                ->get();

            $jobs = DB::table('jobs')
                ->select( 'jobs.id as job_id','jobs.job_location as job_location','jobs.title as title','jobs.slug as slug',
                    'jobs.description as description','jobs.date as date','jobs.endingDate as endingDate',
                    'jobs.category as category','users.avatar as avatar','users.category as user_category')
                ->join('users','jobs.user_id','=','users.id')
                ->where('jobs.status', '=',1)
                ->where('jobs.approval_status', '=',1)
                ->whereDate('jobs.date','<=', Carbon::now())
                ->whereDate('jobs.endingDate','>=', Carbon::now())
                ->where('jobs.category','=', $request->industry_id)
                ->where('users.name', 'like', '%' . $request->company_name . '%')
                ->orderBy('jobs.created_at', 'DESC')
                ->get();

            $countryId = $request->country_id;
            $industryId = $request->industry_id;
            $companyName = $request->company_name;

            return view('candidates.pages.search.search',compact('jobs', 'countries','industries','companies','companyName','industryId','countryId'));

        }

        elseif ($request->country_id == null && $request->industry_id == null && $request->company_name != null)
        {
            $countries = DB::table('countries')->get();
            $industries = DB::table('employee_bussiness_categories')->get();
            $companies = DB::table('users')
                ->select('users.name as name')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->where('model_has_roles.role_id','=', 2)
                ->get();

            $jobs = DB::table('jobs')
                ->select( 'jobs.id as job_id','jobs.job_location as job_location','jobs.title as title','jobs.slug as slug',
                    'jobs.description as description','jobs.date as date','jobs.endingDate as endingDate',
                    'jobs.category as category','users.avatar as avatar','users.category as user_category')
                ->join('users','jobs.user_id','=','users.id')
                ->where('jobs.status', '=',1)
                ->where('jobs.approval_status', '=',1)
                ->whereDate('jobs.date','<=', Carbon::now())
                ->whereDate('jobs.endingDate','>=', Carbon::now())
                ->where('users.name', 'like', '%' . $request->company_name . '%')
                ->orderBy('jobs.created_at', 'DESC')
            //    ->paginate(2);
                ->get();

            $countryId = $request->country_id;
            $industryId = $request->industry_id;
            $companyName = $request->company_name;

            return view('candidates.pages.search.search',compact('jobs', 'countries','industries','companies','companyName','industryId','countryId'));

        //    $data = view('candidates.pages.search.search-jobs',compact('jobs'))->render();
        //    return response()->json(['options'=>$data]);

        }

        elseif ($request->country_id == null && $request->industry_id != null && $request->company_name == null)
        {
            $countries = DB::table('countries')->get();
            $industries = DB::table('employee_bussiness_categories')->get();
            $companies = DB::table('users')
                ->select('users.name as name')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->where('model_has_roles.role_id','=', 2)
                ->get();

            $jobs = DB::table('jobs')
                ->select( 'jobs.id as job_id','jobs.job_location as job_location','jobs.title as title','jobs.slug as slug',
                    'jobs.description as description','jobs.date as date','jobs.endingDate as endingDate',
                    'jobs.category as category','users.avatar as avatar','users.category as user_category')
                ->join('users','jobs.user_id','=','users.id')
                ->where('jobs.status', '=',1)
                ->where('jobs.approval_status', '=',1)
                ->whereDate('jobs.date','<=', Carbon::now())
                ->whereDate('jobs.endingDate','>=', Carbon::now())
                ->where('jobs.category','=', $request->industry_id)
                ->orderBy('jobs.created_at', 'DESC')
                ->get();

            $countryId = $request->country_id;
            $industryId = $request->industry_id;
            $companyName = $request->company_name;

            return view('candidates.pages.search.search',compact('jobs', 'countries','industries','companies','companyName','industryId','countryId'));

        }

    }
}
