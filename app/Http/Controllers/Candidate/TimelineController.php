<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimelineController extends Controller
{
    public function timeline()
    {
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

        if (count($experiences) > 0)
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
                    ->paginate(6);
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
                    ->paginate(6);

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
                    ->paginate(6);
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
                    ->paginate(6);
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
                    ->paginate(6);
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
                    ->paginate(6);
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
                ->paginate(6);
        }

        return view('candidates.pages.timeline.timeline', compact('matchedJobs'));
    }

    public function applyjob($id, $user_id)
    {
        $dataCheck = DB::table('candidate_applied_jobs')->where('user_id', Auth::user()->id)->where('job_id', $id)->first();

        if(isset($dataCheck)){
            return back()->with('error','You have already applied for this job!');
        }

        $cvCount = DB::table('candidate_applied_jobs')->where('employer_id', $user_id)->count();
        $employerPackage = DB::table('employee_packages')->where('user_id', $user_id)->first();

        if(!empty($employerPackage)){
            if ($cvCount >= $employerPackage->cv_limit)
            {
                return back()->with('error','Cannot apply Cv limit for posted job has reached!');
            }
        }

        DB::table('candidate_applied_jobs')->Insert(array(
            'user_id' => Auth::user()->id,
            'job_id' => $id,
            'employer_id' => $user_id,
            'application_status' => 'Pending',
        ));

        return redirect()->route('candidateDashboard')->with('success','Applied Successfully');
    }

    public function unapplyJob(Request $request)
    {
        $dataCheck = DB::table('candidate_applied_jobs')->where('job_id', $request->id)->first();

        if(!isset($dataCheck)){
            return response()->json(['status' => 0]);
        }

        DB::table('candidate_applied_jobs')
            ->where('job_id', $request->id)
            ->delete() ;

        return response()->json(['status' => 1]);
    }

    public function job_details($slug)
    {
        $job = DB::table('jobs')->where('slug', $slug)->first();

        if(empty($job)){
            return back()->with('error','Not Found.');
        }

        DB::table('jobs')->where('slug', $slug)->increment('count', 1);

        return view('candidates.pages.jobDetails.jobDetail', compact('job'));
    }

    public function employer_profile($id)
    {
        $employer = DB::table('users')
            ->where('id',decrypt($id))
            ->first();

        return view('candidates.pages.employerProfile.profile', compact('employer'));
    }
}
