<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CandidateRegistrationController extends Controller
{
    public function registerView(Request $request)
    {
        // session()->forget('candidateSessionData');
        $nationality = DB::table('nationalities')->get();
        $locations = DB::table('countries')->get();
        $countryOfInterest = DB::table('countries')->get();
        $countries = DB::table('countries')->get();
        $genders = DB::table('job_genders')->get();
        $fields = DB::table('employee_bussiness_categories')->get();
        $qualifications = DB::table('job_qualifications')->get();

        return view('candidates.pages.registration.registration',
            compact('nationality','fields','genders', 'locations','countryOfInterest','qualifications','countries'));
    }

    public function register(Request $request)
    {
        $email = DB::table('users')->where('email' , $request->email)->first();

        if(isset($email))
        {
            $isAvailable = false;

            return response()->json(['valid' => $isAvailable]);
        }
        else{
            $isAvailable = true;

            return response()->json(['valid' => $isAvailable]);
        }
    }

    public function candidateData(Request $request)
    {
            $data = array();

            if ($request->stepId == 3)
            {
                if($request->qualification != 1){
                    if($request->education_present == 0){
                        $check  = $request->starting_date <= $request->ending_date;

                        if ($check == false) {
                            return response()->json(['status' => 0]);
                        }
                    }
                }
                $checkExperience  = $request->experience_starting_date <= $request->experience_ending_date;

                if($request->experience_present == 0){
                    if ($checkExperience === false) {
                        return response()->json(['status' => 2]);
                    }
                }

            }

            $data['email'] = $request->email;
            $data['phone'] = $request->phone;

            if ($request->nationality != null && $request->gender != null ){

                $nationality = DB::table('countries')->where('id', $request->nationality)->pluck('name');
                $gender = DB::table('job_genders')->where('id', $request->gender)->pluck('type');
            }
            else{
                $nationality = '';
                $gender = '';
            }

            if ($request->field_of_expertise != null && $request->country_of_interest != null && $request->location != null){

                $fieldOfStudy = DB::table('employee_bussiness_categories')->whereIn('id', $request->field_of_expertise)->get();
                $interestCountry = DB::table('countries')->whereIn('id', $request->country_of_interest)->get();
                $location = DB::table('countries')->where('id', $request->location)->pluck('name');
            }
            else{
                $fieldOfStudy = array();
                $interestCountry = array();
                $location = '';
            }

            $data['firstName'] = $request->firstName;
            $data['lastName'] = $request->lastName;
            $data['DOB'] = $request->DOB;

            if (isset($nationality) && isset($gender))
            {
                $data['nationality'] = $nationality;
                $data['gender'] = $gender;
            }
            else{
                $data['nationality'] = $request->nationality;
                $data['gender'] = $request->gender;
            }
            if (isset($location))
            {
                $data['location'] = $location;
            }
            else{
                $data['location'] = $request->location;
            }
            if (count($fieldOfStudy) > 0 && count($interestCountry) > 0 ){

                $data['field_of_expertise'] = $fieldOfStudy;
                $data['fieldOfStudyData'] = $request->field_of_expertise;

                $data['interestCountry'] = $interestCountry;
                $data['interestCountryData'] = $request->country_of_interest;
            }
            else{
                $data['field_of_expertise'] = $fieldOfStudy;
                $data['interestCountry'] = $interestCountry;
            }

            if ($request->company_location != null ){

                $companyLocation = DB::table('countries')->where('id', $request->company_location)->pluck('name');
            }
            else{
                $companyLocation = '';
            }

            if ($request->qualification != null ){

                $qualification = DB::table('job_qualifications')->where('id', $request->qualification)->pluck('name');
            }
            else{
                $qualification = '';
            }

            if (isset($qualification))
            {
                $data['qualification'] = $qualification;
            }
            else{
                $data['qualification'] = $request->qualification;
            }

            $data['description'] = $request->description;
            $data['starting_date'] = $request->starting_date;
            $data['ending_date'] = ($request->education_present == 1) ? null : $request->ending_date;
            $data['company'] = $request->company;


            $data['no_experience'] = $request->no_experience;

            if (isset($companyLocation))
            {
                $data['company_location'] = $companyLocation;
            }
            else{
                $data['company_location'] = $request->company_location;
            }

            $data['position'] = $request->position;
            $data['experience_description'] = $request->experience_description;

            $data['experience_starting_date'] = $request->experience_starting_date;
            $data['experience_ending_date'] = ($request->experience_present == 1) ? null : $request->experience_ending_date;

            session()->put('candidateSessionData', $data);

            // return session()->get('candidateSessionData');
            return response()->json(['status' => 1]);
    }

    public function store(Request $request)
    {
        $id =   DB::table('users')->insertGetId([
                    'name' => $request['firstName'].' '.$request['lastName'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'phoneNo' => $request['phone'],
                ]);

        DB::table('active_users')->insert([
            'user_id' => $id,
            'model_id' => 3,
            'date' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        $data1=array('role_id'=>'3',"model_type"=>'App\Models\User',"model_id"=>$id);
        DB::table('model_has_roles')->insert($data1);


        DB::table('candidate_personal_informations')
            ->insert([
                'user_id' => $id,
                'firstName' => $request->input(['firstName']),
                'lastName' => $request->input(['lastName']),
                'gender' => $request->input(['gender']),
                'DOB' => $request->input(['DOB']),
                'nationality' => $request->input(['nationality']),
            ]);
        $fieldOfExpertise = implode(',',session()->get('candidateSessionData')['fieldOfStudyData']);
        $countryOfInterest = implode(',',session()->get('candidateSessionData')['interestCountryData']);

        DB::table('candidate_abouts')
            ->insert([
                'user_id' => $id,
                'field_of_expertise' => $fieldOfExpertise,
                'location' => $request->input(['location']),
                'country_of_interest' => $countryOfInterest,
                'qualification' => $request->input(['qualification']),
            ]);

        if($request->has('educationPresent')){
            $educationEndingDate = $request->input(['ending_date']);
        }
        else{
            $educationEndingDate = null;
        }

        if($request->qualification != 1){
            DB::table('candidate_educations')
            ->insert([
                'user_id' => $id,
                'degree' => $request->input(['qualification']),
                'field_of_study' => $request->input(['field_of_study']),
                'institution' => $request->input(['institution']),
                'starting_date' => $request->input(['starting_date']),
                'ending_date' => $educationEndingDate,
                'description' => $request->input(['description']),
            ]);
        }

        if(!$request->has('noExperience')){
            if($request->has('experiencePresent')){
                $experienceEndingDate = null;
            }
            else{
                $experienceEndingDate = $request->input(['experience_ending_date']);
            }

            DB::table('candidate_experiences')
            ->insert([
                'user_id' => $id,
                'company' => $request->input(['company']),
                'company_location' => $request->input(['company_location']),
                'position' => $request->input(['position']),
                'experience_description' => $request->input(['experience_description']),
                'experience_starting_date' => $request->input(['experience_starting_date']),
                'experience_ending_date' => $experienceEndingDate,
            ]);
        }
        session()->forget('candidateSessionData');

        return redirect()->route('login')->with('success','Registered successfully login to continue!');

    }
}
