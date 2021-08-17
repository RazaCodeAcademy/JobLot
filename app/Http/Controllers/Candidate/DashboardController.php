<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $cv = DB::table('cv_counters')->select('count')->where('user_id', Auth::user()->id)->first();

        $appliedJobs = DB::table('candidate_applied_jobs')
            ->join('jobs','candidate_applied_jobs.job_id','=','jobs.id')
            ->where('candidate_applied_jobs.user_id', Auth::user()->id)
            ->orderBy('candidate_applied_jobs.id', 'desc')
            ->get();

        $candidateInfos = DB::table('candidate_abouts')
            ->where('user_id', Auth::user()->id)
            ->first();

        $countryOfInterest = explode(',', $candidateInfos->country_of_interest);
        $fieldOfExpertise = explode(',', $candidateInfos->field_of_expertise);

        $experiences = DB::table('candidate_experiences')
            ->where('user_id', Auth::user()->id)
            ->get();

        $total = 0;
        $matchedJobs = array();

        if (count($experiences)>0)
        {
            foreach ($experiences as $key=>$value)
            {
                $datetime1 = Carbon::createFromDate($value->experience_starting_date);
                $datetime2 = Carbon::createFromDate($value->experience_ending_date);
                $intervals[] = $datetime1->diffInDays($datetime2);
            }

            foreach ($intervals as $key => $value)
            {
                $total += $value;
            }

            if ($total <= 365)
            {
                $matchedJobs = DB::table('jobs')
                    ->where([
                        ['status', '=', 1],
                        ['approval_status', '=', 1],
                        ['date', '<=', Carbon::now()],
                        ['endingDate', '>=', Carbon::now()],
                    ])->where(function ($query) use ($candidateInfos,$countryOfInterest,$fieldOfExpertise) {
                        $query->orwhere('job_location', $candidateInfos->location)
                            ->orWhereIn('job_location', $countryOfInterest)
                            ->orWhereIn('category', $fieldOfExpertise)
                            ->orwhere('gender', $candidateInfos->gender)
                            ->orwhere('experience', '=', 2)
                            ->orwhere('qualification', $candidateInfos->qualification);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->get();
            }
            elseif($total > 365 && $total <= 730)
            {
                $matchedJobs = DB::table('jobs')
                    ->where([
                        ['status', '=', 1],
                        ['approval_status', '=', 1],
                        ['date', '<=', Carbon::now()],
                        ['endingDate', '>=', Carbon::now()],
                    ])->where(function ($query) use ($candidateInfos,$countryOfInterest,$fieldOfExpertise) {
                        $query->orwhere('job_location', $candidateInfos->location)
                            ->orWhereIn('job_location', $countryOfInterest)
                            ->orWhereIn('category', $fieldOfExpertise)
                            ->orwhere('gender', $candidateInfos->gender)
                            ->orwhere('experience', '=', 3)
                            ->orwhere('qualification', $candidateInfos->qualification);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->get();

            }
            elseif($total > 730 && $total <= 1095)
            {
                $matchedJobs = DB::table('jobs')
                    ->where([
                        ['status', '=', 1],
                        ['approval_status', '=', 1],
                        ['date', '<=', Carbon::now()],
                        ['endingDate', '>=', Carbon::now()],
                    ])->where(function ($query) use ($candidateInfos,$countryOfInterest,$fieldOfExpertise) {
                        $query->orwhere('job_location', $candidateInfos->location)
                            ->orWhereIn('job_location', $countryOfInterest)
                            ->orWhereIn('category', $fieldOfExpertise)
                            ->orwhere('gender', $candidateInfos->gender)
                            ->orwhere('experience', '=', 4)
                            ->orwhere('qualification', $candidateInfos->qualification);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->get();
            }
            elseif($total > 1095 && $total <= 1460)
            {
                $matchedJobs = DB::table('jobs')
                    ->where([
                        ['status', '=', 1],
                        ['approval_status', '=', 1],
                        ['date', '<=', Carbon::now()],
                        ['endingDate', '>=', Carbon::now()],
                    ])->where(function ($query) use ($candidateInfos,$countryOfInterest,$fieldOfExpertise) {
                        $query->orwhere('job_location', $candidateInfos->location)
                            ->orWhereIn('job_location', $countryOfInterest)
                            ->orWhereIn('category', $fieldOfExpertise)
                            ->orwhere('gender', $candidateInfos->gender)
                            ->orwhere('experience', '=', 5)
                            ->orwhere('qualification', $candidateInfos->qualification);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->get();
            }
            elseif($total > 1460 && $total <= 1825)
            {
                $matchedJobs = DB::table('jobs')
                    ->where([
                        ['status', '=', 1],
                        ['approval_status', '=', 1],
                        ['date', '<=', Carbon::now()],
                        ['endingDate', '>=', Carbon::now()],
                    ])->where(function ($query) use ($candidateInfos,$countryOfInterest,$fieldOfExpertise) {
                        $query->orwhere('job_location', $candidateInfos->location)
                            ->orWhereIn('job_location', $countryOfInterest)
                            ->orWhereIn('category', $fieldOfExpertise)
                            ->orwhere('gender', $candidateInfos->gender)
                            ->orwhere('experience', '=', 6)
                            ->orwhere('qualification', $candidateInfos->qualification);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->get();
            }
            elseif($total > 1825)
            {
                $matchedJobs = DB::table('jobs')
                    ->where([
                        ['status', '=', 1],
                        ['approval_status', '=', 1],
                        ['date', '<=', Carbon::now()],
                        ['endingDate', '>=', Carbon::now()],
                    ])->where(function ($query) use ($candidateInfos,$countryOfInterest,$fieldOfExpertise) {
                        $query->orwhere('job_location', $candidateInfos->location)
                            ->orWhereIn('job_location', $countryOfInterest)
                            ->orWhereIn('category', $fieldOfExpertise)
                            ->orwhere('gender', $candidateInfos->gender)
                            ->orwhere('experience', '=', 7)
                            ->orwhere('qualification', $candidateInfos->qualification);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->get();
            }
        }

        else{
            $matchedJobs = DB::table('jobs')
                ->where([
                    ['status', '=', 1],
                    ['approval_status', '=', 1],
                    ['date', '<=', Carbon::now()],
                    ['endingDate', '>=', Carbon::now()],
                ])->where(function ($query) use ($candidateInfos,$countryOfInterest,$fieldOfExpertise) {
                    $query->orwhere('job_location', $candidateInfos->location)
                        ->orWhereIn('job_location', $countryOfInterest)
                        ->orWhereIn('category', $fieldOfExpertise)
                        ->orwhere('gender', $candidateInfos->gender)
                        ->orwhere('qualification', $candidateInfos->qualification);
                })
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        return view('candidates.pages.dashboard.dashboard', compact('cv','appliedJobs', 'matchedJobs'));
    }

}