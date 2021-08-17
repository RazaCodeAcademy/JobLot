<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResumeController extends Controller
{
    public function create()
    {
        $countries = DB::table('countries')->get();
        $nationalities = DB::table('nationalities')->get();
        $genders = DB::table('job_genders')->get();
        $maritalStatus = DB::table('candidate_marital_status')->get();
        $categories = DB::table('employee_bussiness_categories')->get();
        $careerLevels = DB::table('job_career_levels')->select()->get();
        $salaries = DB::table('job_salary_ranges')->get();
        $degreeLevels = DB::table('job_qualifications')->get();
        $languages = DB::table('languages')->get();
        $personalInfo = DB::table('candidate_personal_informations')->where('user_id', Auth::user()->id)->first();
        $professionalInfo = DB::table('candidate_abouts')->where('user_id', Auth::user()->id)->first();
        $educationInfos = DB::table('candidate_educations')->where('user_id', Auth::user()->id)->get();
        $experienceInfos = DB::table('candidate_experiences')->where('user_id', Auth::user()->id)->get();
        $portfolios = DB::table('candidate_portfolios')->where('user_id', Auth::user()->id)->get();
        $candidate_skills = DB::table('candidate_skills')->where('user_id', Auth::user()->id)->first();
        $skills = DB::table('skills')->get();

        $currencies = DB::table('package_currencys')->get();

        return view('candidates.pages.resume.create',
            compact('countries','genders','maritalStatus','categories','careerLevels', 'nationalities',
                            'salaries','degreeLevels','languages','personalInfo','professionalInfo',
                            'educationInfos','experienceInfos','candidate_skills','skills', 'portfolios', 'currencies'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'firstName' => 'string|max:255|required',
            'lastName' => 'string|max:255|required',
            'about' => 'string|required',
            'DOB' => 'required|date',
            'nationality' => 'required',
            'gender' => 'required',
            'maritalStatus' => 'required',
            'address' => 'required',
            'phoneNo' => 'required',
            'field_of_expertise' => 'required',
            'location' => 'required',
            'country_of_interest' => 'required',
            'career_level' => 'required',
            'qualification' => 'required',
            'language' => 'required',
            'starting_date' => 'date',
            'ending_date' => 'date|after_or_equal:starting_date',
            'experience_starting_date' => 'date',
            'experience_ending_date' => 'date|after_or_equal:experience_starting_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // return $request->all();

        if($request->has('candidate_educations')){
            for ($i = 0; $i < count($request->candidate_educations); $i++)
            {
                if(isset($request->candidate_educations[$i]['ending_date']))
                {
                    $check  = $request->candidate_educations[$i]['starting_date'] <= $request->candidate_educations[$i]['ending_date'];
    
                    if ($check == false) {
                        return redirect()->back()->with('error','Check TO DATE FIELD in Education part, should be greater than FROM DATE FIELD');
                    }
                }
            }
        }

        if($request->has('candidate_experiences')){
            for ($i = 0; $i < count($request->candidate_experiences); $i++)
            {
                if (isset($request->candidate_experiences[$i]['experience_ending_date']))
                {
                    $check  = $request->candidate_experiences[$i]['experience_starting_date'] <= $request->candidate_experiences[$i]['experience_ending_date'];
    
                    if ($check == false) {
                        return redirect()->back()->with('error','Check TO DATE FIELD in Experience part, should be greater than FROM DATE FIELD');
                    }
                }
            }
        }

        $personalCheck = DB::table('candidate_personal_informations')->where('user_id', Auth::user()->id)->first();

        if (isset($personalCheck)){
            DB::table('candidate_personal_informations')
                ->where('user_id', $personalCheck->user_id)
                ->update([
                    'firstName' => $request->input(['firstName']),
                    'lastName' => $request->input(['lastName']),
                    'DOB' => $request->input(['DOB']),
                    'nationality' => $request->input(['nationality']),
                    'gender' => $request->input(['gender']),
                    'maritalStatus' => $request->input(['maritalStatus']),
                    'address' => $request->input(['address']),
                ]);
        }
        else{
            DB::table('candidate_personal_informations')
                ->insert([
                    'user_id' => Auth::user()->id,
                    'firstName' => $request->input(['firstName']),
                    'lastName' => $request->input(['lastName']),
                    'DOB' => $request->input(['DOB']),
                    'nationality' => $request->input(['nationality']),
                    'gender' => $request->input(['gender']),
                    'maritalStatus' => $request->input(['maritalStatus']),
                    'address' => $request->input(['address']),
                ]);
        }

        DB::table('users')
        ->where('id', Auth::user()->id)
        ->update([
            'phoneNo' => $request->input(['phoneNo']),
            'phoneNo2' => $request->input(['phoneNo2']),
            'companyPhoneNo' => $request->input(['companyPhoneNo']),
        ]);

        $professionalInfoCheck = DB::table('candidate_abouts')->where('user_id', Auth::user()->id)->first();

        $countryOfInterest  = implode(',', $request->input(['country_of_interest']));
        $fieldOfExperts  = implode(',', $request->input(['field_of_expertise']));

        if(isset($professionalInfoCheck)){
            $languages = implode(',', $request->input(['language']));
            DB::table('candidate_abouts')
            ->where('user_id', $professionalInfoCheck->user_id)
            ->update([
                'field_of_expertise' => $fieldOfExperts,
                'location' => $request->input(['location']),
                'about' => $request->input(['about']),
                'country_of_interest' => $countryOfInterest,
                'career_level' => $request->input(['career_level']),
                'salary' => $request->input(['salary']),
                'expected_salary' => $request->input(['expected_salary']),
                'current_currency' => $request->input(['current_currency']),
                'expected_currency' => $request->input(['expected_currency']),
                'qualification' => $request->input(['qualification']),
                'language' => $languages,
            ]);
        }
        else{
            $languages = implode(',', $request->input(['language']));
            DB::table('candidate_abouts')
            ->insert([
                'user_id' => Auth::user()->id,
                'field_of_expertise' => $fieldOfExperts,
                'location' => $request->input(['location']),
                'about' => $request->input(['about']),
                'country_of_interest' => $countryOfInterest,
                'career_level' => $request->input(['career_level']),
                'salary' => $request->input(['salary']),
                'expected_salary' => $request->input(['expected_salary']),
                'qualification' => $request->input(['qualification']),
                'language' => $languages,
            ]);
        }

        DB::table('candidate_educations')
        ->where('user_id', Auth::user()->id)
        ->delete();

        if($request->qualification != 1){
            if($request->has('candidate_educations')){
                for ($i = 0; $i < count($request->candidate_educations); $i++)
                {
                    if (isset($request->candidate_educations[$i]['ending_date']))
                    {
                        DB::table('candidate_educations')
                            ->insert([
                                'user_id' => Auth::user()->id,
                                'degree' => $request->candidate_educations[$i]['degree'],
                                'field_of_study' => $request->candidate_educations[$i]['field_of_study'],
                                'institution' => $request->candidate_educations[$i]['institution'],
                                'starting_date' => $request->candidate_educations[$i]['starting_date'],
                                'ending_date' => $request->candidate_educations[$i]['ending_date'],
                                'description' => $request->candidate_educations[$i]['description'],
                            ]);
                    }
                    else{
                        DB::table('candidate_educations')
                            ->insert([
                                'user_id' => Auth::user()->id,
                                'degree' => $request->candidate_educations[$i]['degree'],
                                'field_of_study' => $request->candidate_educations[$i]['field_of_study'],
                                'institution' => $request->candidate_educations[$i]['institution'],
                                'starting_date' => $request->candidate_educations[$i]['starting_date'],
                                'ending_date' => null,
                                'description' => $request->candidate_educations[$i]['description'],
                            ]);
                    }
        
                }
            }
        }

        DB::table('candidate_experiences')
        ->where('user_id', Auth::user()->id)
        ->delete();

        if($request->has('candidate_experiences')){
            for ($i = 0; $i < count($request->candidate_experiences); $i++)
            {
                if (isset($request->candidate_experiences[$i]['experience_ending_date']))
                {
                    DB::table('candidate_experiences')
                        ->insert([
                            'user_id' => Auth::user()->id,
                            'company' => $request->candidate_experiences[$i]['company'],
                            'company_location' => $request->candidate_experiences[$i]['company_location'],
                            'position' => $request->candidate_experiences[$i]['position'],
                            'experience_starting_date' => $request->candidate_experiences[$i]['experience_starting_date'],
                            'experience_ending_date' => $request->candidate_experiences[$i]['experience_ending_date'],
                            'experience_description' => $request->candidate_experiences[$i]['experience_description'],
                        ]);
                }
                else{
                    DB::table('candidate_experiences')
                        ->insert([
                            'user_id' => Auth::user()->id,
                            'company' => $request->candidate_experiences[$i]['company'],
                            'company_location' => $request->candidate_experiences[$i]['company_location'],
                            'position' => $request->candidate_experiences[$i]['position'],
                            'experience_starting_date' => $request->candidate_experiences[$i]['experience_starting_date'],
                            'experience_ending_date' => null,
                            'experience_description' => $request->candidate_experiences[$i]['experience_description'],
                        ]);

                }

            }
        }

        DB::table('candidate_portfolios')
        ->where('user_id', Auth::user()->id)
        ->delete();
        
        if ($request->has('candidate_portfolios')){
            for ($i = 0; $i < count($request->candidate_portfolios); $i++)
            {
                if (isset($request->candidate_portfolios[$i]['title']) && isset($request->candidate_portfolios[$i]['link']))
                {
                    DB::table('candidate_portfolios')
                        ->insert([
                            'user_id' => Auth::user()->id,
                            'title' => $request->candidate_portfolios[$i]['title'],
                            'link' => $request->candidate_portfolios[$i]['link'],
                        ]);
                }
            }
        }

        $skillsInfoCheck = DB::table('candidate_skills')->where('user_id', Auth::user()->id)->first();

        $skills = ($request->skills != null) ? implode(',', $request->skills) : '';

        if (isset($skillsInfoCheck)){
            DB::table('candidate_skills')
                ->where('user_id', $skillsInfoCheck->user_id)
                ->update([
                    'skill' => $skills,
                ]);
        }
        else{
            DB::table('candidate_skills')
                ->insert([
                    'user_id' => Auth::user()->id,
                    'skill' => $skills,
                ]);
        }

        if($request->hasFile('profile_avatar')) {
            $image = $request->file('profile_avatar');
            $path = public_path(). '/images/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);
            $avatar  = $filename;

            DB::table('users')->where('id', Auth::user()->id)->update(array(
                'avatar' => $avatar,
            ));
        }

        return redirect()->route('candidateDashboard')->with('success', 'Resume updated successfully!');
    }
}
