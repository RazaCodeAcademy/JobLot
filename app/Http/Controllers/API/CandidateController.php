<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Candidate;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use App\Models\User;

class CandidateController extends Controller
{
    public $successStatus = 200;

    public function candidate_personal_detail(request $request){

        $roles = auth()->user()->roles()->pluck('name');
        $nationality = $request->input('nationality');
        $current_country = $request->input('current_country');
        $country_of_interest = $request->input('country_of_interest');
        $language = $request->input('language');
        $interested_in_fields = $request->input('interested_in_fields');
        $photo = $request->input('photo');

        //        $currentfield = $request->input('currentfield');
        //        $countryinterest = $request->input('countryinterest');
        //        $interestedindustries = $request->input('interestedindustries');
        //        $currentskills = $request->input('currentskills');

        // $loggedUserId = $_GET['id'];
        //print_r($roles[0] ); die();
        if ($roles[0] != 'Candidate') {

            return view('404', compact("roles"));
        }else{

            $getUserId = auth()->user()->roles()->pluck('model_id');
            $lastAddedUser = DB::table('users')->orderBy('id', 'DESC')->first();
            $data = array(


                "nationality"=>$nationality,
                "current_country"=>$current_country,
                "country_of_interest"=>$country_of_interest,
                "language"=>$language,
                "interested_in_fields"=>$interested_in_fields,
                'photo' => $photo,
                "user_id"=>$lastAddedUser->id

            );

            $rules = [
                'nationality'=>'required'
            ];
            $customs = [
                'nationality' => 'Reqired Field.'
            ];
            $validator = Validator::make($data, $rules, $customs);

            if ($validator->fails()) {

                return redirect()->back()->with('errors', 'Data Not Valid');

            }else{

                DB::table('candidate_personal_informations')->insert($data);
            }
            return response()->json(['success' => 'Candidate Personal Information Saved Successfully.' ], $this->successStatus);
        }
    }

    public function candidate_education_insert(request $request){
        $roles = auth()->user()->roles()->pluck('name');

        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{
            $getUserId = auth()->user()->roles()->pluck('model_id');

            $data = array(
                'field_of_study' => $request->field_of_study,
                'degree' => $request->degree,
                'institution' => $request->institution,
                'starting_date' => $request->starting_date,
                'ending_date' => $request->ending_date,
                'description' => $request->description,
                'user_id' => $getUserId[0]
            );

            $rules = [
                'field_of_study'=>'required',
                'institution'=>'required',
                'degree'=>'required',
                'starting_date'=>'required',
                'ending_date'=>'required',
                // 'description'=>'required',
            ];

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->messages()->first()], 401);
            }
            else{
                DB::table('candidate_educations')->insert($data);
            }

            return response()->json(['success' => 'Candidate Education Inserted Successfully.', $roles[0] ], $this->successStatus);
        }
    }

    public function candidate_experience_insert(request $request){
        $roles = auth()->user()->roles()->pluck('name');

        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{
            $getUserId = auth()->user()->roles()->pluck('model_id');

            $data = array(
                'company' => $request->company,
                'company_location' => $request->company_location,
                'position' => $request->position,
                'experience_starting_date' => $request->experience_starting_date,
                'experience_ending_date' => $request->experience_ending_date,
                'experience_description' => $request->experience_description,
                'user_id' => $getUserId[0]
            );

            $rules = [
                'company'=>'required',
                'position'=>'required',
                'company_location'=>'required',
                'experience_starting_date'=>'required',
                'experience_ending_date'=>'required',
                // 'experience_description'=>'required',
            ];

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->messages()->first()], 401);
            }
            else{
                DB::table('candidate_experiences')->insert($data);
            }

            return response()->json(['success' => 'User Experience Saved Successfully.', $roles[0] ], $this-> successStatus);
        }
    }

    public function candidate_education_list(request $request){
            $roles = auth()->user()->roles()->pluck('name');
            if ($roles[0] != 'Candidate') {
                return response()->json(['error'=>'Unauthorised'], 401);
            }else{
                $getUserId = auth()->user()->roles()->pluck('model_id');
                $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

                //$educationGet = DB::table('education')->select()->where('userid', $getUserId[0])->first();
                $getEducationalData = DB::table('candidate_educations')->select()->where('user_id', $getUserId[0])->get();
                // DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
                // print_r($dataGet);
            // return view('some-view')->with('users', $users);
                // return response()->json(['success'=>$success], $this-> successStatus);

                return response()->json(['profile' => $dataGet, 'education' => $getEducationalData, $roles[0] ], $this-> successStatus);
            }

    }

    public function candidate_experience_list(request $request){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'Candidate') {
            return view('404', compact("roles"));
        }else{
            $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

            //$educationGet = DB::table('education')->select()->where('userid', $getUserId[0])->first();
            $getExperienceData = DB::table('candidate_experiences')->select()->where('user_id', $getUserId[0])->get();
            // DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
            // print_r($dataGet);
        // return view('some-view')->with('users', $users);
            // return response()->json(['success'=>$success], $this-> successStatus);

            return response()->json(['profile' => $dataGet, 'experience' => $getExperienceData, $roles[0] ], $this-> successStatus);
        }
    }

    public function list_of_jobs(){
        $roles = auth()->user()->roles()->pluck('name');
            if ($roles[0] != 'Candidate') {
            return view('404', compact("roles"));
        }else{
            $getJobsList = DB::table('jobs as J')
            ->select(
            'J.id as id',
            'U.id as user_id',
            'J.title',
            'J.status',
            'U.category',
            'J.job_location',
            'J.candidate_location',
            'J.candidate_nationality',
            'J.type',
            'J.career_level',
            'J.experience',
            'J.salary',
            'J.qualification',
            'J.gender',
            'J.vacancy',
            'J.date',
            'J.endingDate',
            'J.description',
            'J.responsibilities',
            'J.education',
            'J.benefits',
            'J.country',
            'J.city',
            'J.zip_code',
            'J.your_location',
            'J.pin_location',
            'J.companyName',
            'J.webAddress',
            'J.companyProfile',
            'J.agreement',
            'J.count',
            'J.created_at',
            'J.updated_at',
            'U.name',
            'U.email',
            'U.companyEmail',
            'U.avatar',
            'U.companyname',
            'U.country_name',
            'U.city_name',
            'U.phoneNo',
            'U.contactPersonName',
            'U.companyPhoneNo',
            'U.companyWebAddress',
            'U.address',
            'U.aboutus',
            'U.videolink',
            'U.image',
            'U.facebooklink',
            'U.twitterlink',
            'U.goooglelink',


            )
            ->join('users as U', 'J.user_id', '=', 'U.id')
            ->get();
            count($getJobsList);
            return response()->json(['jobs' => $getJobsList], $this->successStatus);
        }
    }

    public function get_single_job_info(request $request){
        $rolesid = auth()->user()->roles()->pluck('id');
        $getUserId = auth()->user()->roles()->pluck('model_id');
        $getUserId[0];
        $vacancyid = $request->jobid;
        $single_job = DB::table('jobs')->select()->where('id', $vacancyid)->get();
        return response()->json(['single_job' => $single_job, $rolesid[0] ], $this-> successStatus);
    }

    public function countries(){
        $rolesid = auth()->user()->roles()->pluck('model_id');
        $countriesList = DB::table('countries')->get();
        return response()->json(['countries' => $countriesList], $this-> successStatus);
    }

    public function nationalities(){
        $rolesid = auth()->user()->roles()->pluck('model_id');
        $nationalitiesList = DB::table('nationalities')->get();
        return response()->json(['nationalities' => $nationalitiesList], $this-> successStatus);
    }

    public function candidate_all_information(Request $request){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{
            $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();


            if(empty($dataGet)){
                return response()->json(['error'=>'User Does Not Exist.'], 401);
            }


            $getEducationalData = DB::table('candidate_educations')->select()->where('user_id', $getUserId[0])->get();
            $getExperienceData = DB::table('candidate_experiences')->select()->where('user_id', $getUserId[0])->get();
            $getPersonalInformationData = DB::table('candidate_personal_informations')->select()->where('user_id', $getUserId[0])->get();
            $profileImage = $dataGet->avatar;
            return response()->json(['profile_image' => $profileImage ,'educations' => $getEducationalData, 'experiences' => $getExperienceData, 'personal_information' => $getPersonalInformationData, $roles[0] ], $this-> successStatus);

        }
    }

    public function candidate_applied_vacancies(Request $request){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{
            $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();


            if(empty($dataGet)){
                return response()->json(['error'=>'User Does Not Exist.'], 401);
            }


            $appliedJobsIds = DB::table('candidate_applied_jobs')->select()->where('user_id', $getUserId[0])->pluck('job_id');
            $appliedJobs = DB::table('jobs')->whereIn('id', $appliedJobsIds)->get();

            return response()->json(['appliedJobs' => $appliedJobs, $roles[0] ], $this-> successStatus);

        }
    }

    public function candidate_delete_applied_vacancies(Request $request){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{

            $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

            if(empty($dataGet)){
                return response()->json(['error'=>'User Does Not Exist.'], 401);
            }

            $rules = [
                'job_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->messages()->first()], 401);
            }

            $appliedJobs = DB::table('candidate_applied_jobs')
            ->where('user_id', $getUserId[0])
            ->where('job_id',$request->job_id)
            ->get();

            if(count($appliedJobs) == 0){
                return response()->json(['error'=>'Job Does Not Exist.'], 401);
            }

            $appliedJobs = DB::table('candidate_applied_jobs')
            ->where('user_id', $getUserId[0])
            ->where('job_id',$request->job_id)
            ->delete();

            return response()->json(['message' => "Deleted Successfully", $roles[0] ], $this-> successStatus);

        }
    }

    public function candidate_update_personal_information(Request $request){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{

            $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

            if(empty($dataGet)){
                return response()->json(['error'=>'User Does Not Exist.'], 401);
            }

            $rules = [
                'firstName' => 'required|string',
                'lastName' => 'required|string',
                'full_name' => 'required|string',
                'father_name' => 'required|string',
                'mother_name' => 'required|string',
                'DOB' => 'required|string',
                'nationality' => 'required',
                'gender' => 'required',
                'maritalStatus' => 'required',
                'dependents' => 'required',
                'age' => 'required|string',
                'address' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->messages()->first()], 401);
            }

            $personalInformation = DB::table('candidate_personal_informations')
            ->where('user_id', $getUserId[0])
            ->first();

            if(empty($personalInformation) || $personalInformation==null || $personalInformation==""){
                $userData = DB::table('candidate_personal_informations')->insert(array(
                    'firstName' => $request->firstName,
                    'user_id' => $getUserId[0],
                    'lastName' => $request->lastName,
                    'full_name' => $request->full_name,
                    'father_name' => $request->father_name,
                    'mother_name' => $request->mother_name,
                    'DOB' => $request->DOB,
                    'nationality' => $request->nationality,
                    'gender' => $request->gender,
                    'maritalStatus' => $request->maritalStatus,
                    'dependents' => $request->dependents,
                    'age' => $request->age,
                    'address' => $request->address
                ));
                return response()->json(['message' => "Created Successfully", $roles[0] ], $this-> successStatus);
            }
            else{
                $userData = DB::table('candidate_personal_informations')->select()->where('user_id', $getUserId[0])->update(array(
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'full_name' => $request->full_name,
                    'father_name' => $request->father_name,
                    'mother_name' => $request->mother_name,
                    'DOB' => $request->DOB,
                    'nationality' => $request->nationality,
                    'gender' => $request->gender,
                    'maritalStatus' => $request->maritalStatus,
                    'dependents' => $request->dependents,
                    'age' => $request->age,
                    'address' => $request->address
                ));
                return response()->json(['message' => "Updated Successfully", $roles[0] ], $this-> successStatus);
            }

        }
    }

    public function candidate_update_education(Request $request){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{

            $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

            if(empty($dataGet)){
                return response()->json(['error'=>'User Does Not Exist.'], 401);
            }

            $rules = [
                'title' => 'required|string',
                'institution' => 'required|string',
                'period' => 'required|string',
                'description' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->messages()->first()], 401);
            }

            $educationInformation = DB::table('candidate_educations')
            ->where('user_id', $getUserId[0])
            ->first();

            if(empty($educationInformation) || $educationInformation==null ){
                return response()->json(['error'=>'Error While Updating'], 401);
            }

            $userData = DB::table('candidate_educations')->select()->where('user_id', $getUserId[0])->update(array(
                'title' => $request->title,
                'institution' => $request->institution,
                'period' => $request->period,
                'description' => $request->description,
            ));


            return response()->json(['message' => "Updated Successfully", $roles[0] ], $this-> successStatus);

        }
    }

    public function candidate_delete_education(Request $request){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{

            $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

            if(empty($dataGet)){
                return response()->json(['error'=>'User Does Not Exist.'], 401);
            }

            $rules = [
                'education_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->messages()->first()], 401);
            }

            $educationInformation = DB::table('candidate_educations')
            ->where('id', $request->education_id)
            ->where('user_id', $getUserId[0])
            ->first();

            if(empty($educationInformation) || $educationInformation==null ){
                return response()->json(['error'=>'Error While Deleting'], 401);
            }

            DB::table('candidate_educations')
            ->where('id', $request->education_id)
            ->where('user_id', $getUserId[0])
            ->delete();

            return response()->json(['message' => "Deleted Successfully", $roles[0] ], $this-> successStatus);

        }
    }

    public function candidate_update_experience(Request $request){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{

            $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

            if(empty($dataGet)){
                return response()->json(['error'=>'User Does Not Exist.'], 401);
            }

            $rules = [
                'title' => 'required|string',
                'company' => 'required|string',
                'period' => 'required|string',
                'description' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->messages()->first()], 401);
            }

            $experienceInformation = DB::table('candidate_experiences')
            ->where('user_id', $getUserId[0])
            ->first();

            if(empty($experienceInformation) || $experienceInformation==null ){
                return response()->json(['error'=>'Error While Updating'], 401);
            }

            $userData = DB::table('candidate_experiences')->select()->where('user_id', $getUserId[0])->update(array(
                'title' => $request->title,
                'company' => $request->company,
                'period' => $request->period,
                'description' => $request->description,
            ));


            return response()->json(['message' => "Updated Successfully", $roles[0] ], $this-> successStatus);

        }
    }

    public function candidate_delete_experience(Request $request){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{

            $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

            if(empty($dataGet)){
                return response()->json(['error'=>'User Does Not Exist.'], 401);
            }

            $rules = [
                'experience_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->messages()->first()], 401);
            }

            $experienceInformation = DB::table('candidate_experiences')
            ->where('id', $request->experience_id)
            ->where('user_id', $getUserId[0])
            ->first();

            if(empty($experienceInformation) || $experienceInformation==null ){
                return response()->json(['error'=>'Error While Deleting'], 401);
            }

            DB::table('candidate_experiences')
            ->where('id', $request->experience_id)
            ->where('user_id', $getUserId[0])
            ->delete();

            return response()->json(['message' => "Deleted Successfully", $roles[0] ], $this-> successStatus);

        }
    }

    public function candidate_search_jobs(Request $request){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{

            $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

            if(empty($dataGet)){
                return response()->json(['error'=>'User Does Not Exist.'], 401);
            }

            $rules = [
                'category' => 'required',
                'job_location' => 'required',
                'career_level' => 'required',
                'qualification' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->messages()->first()], 401);
            }

            $jobs = DB::table('jobs')
            ->where('category', $request->category)
            ->where('job_location', $request->job_location)
            ->where('career_level', $request->career_level)
            ->where('qualification', $request->qualification)
            ->get();


            return response()->json(['jobs' => $jobs, $roles[0] ], $this-> successStatus);

        }
    }

    public function apply_job(Request $request){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{

            $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

            if(empty($dataGet)){
                return response()->json(['error'=>'User Does Not Exist.'], 401);
            }

            $rules = [
                'job_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->messages()->first()], 401);
            }

            $dataCheck = DB::table('candidate_applied_jobs')->select()->where('user_id', $getUserId)->where('job_id', $request->job_id)->first();
            $jobstatus = DB::table('jobs')->select()->where('id', $request->job_id)->first();

            if(isset($dataCheck)){
                return response()->json(['error'=>'You have already applied for this job!'], 401);
            }
            elseif ($jobstatus->status != 'Active')
            {
                return response()->json(['error'=>'You cannot apply to this job because it is disabled!'], 401);

            }
            else{

                // return $request->job_id;

                DB::table('candidate_applied_jobs')->Insert(array(
                    'user_id' => $dataGet->id,
                    'job_id' => $request->job_id,
                    'status' => '',
                ));

            }



            return response()->json(['message' => "Applied Succesfully", $roles[0] ], $this-> successStatus);

        }
    }

    public function skills(){
        $rolesid = auth()->user()->roles()->pluck('model_id');
        $skillsList = DB::table('skills')->get();
        return response()->json(['skills' => $skillsList], $this-> successStatus);
    }

    public function degree_list(){
        $degreeList = DB::table('job_qualifications')->get();
        return response()->json(['degrees' => $degreeList], $this-> successStatus);
    }

    public function candidate_update_about(Request $request){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{

            $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

            if(empty($dataGet)){
                return response()->json(['error'=>'User Does Not Exist.'], 401);
            }

            return $request->all();


            $rules = [
                'location' => 'required|string',
                'nationality' => 'required|string',
                'country_of_interest' => 'required|min:1',
                'languages' => 'required|min:1',
                'skills' => 'required|min:1',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->messages()->first()], 401);
            }

            // return $request->all();

            $aboutInformation = DB::table('candidate_abouts')
            ->where('user_id', $getUserId[0])
            ->first();

            $personalInformation = DB::table('candidate_personal_informations')
            ->where('user_id', $getUserId[0])
            ->first();

            $languages = implode(',', $request->languages);
            $listCountries = implode(',', $request->country_of_interest);

            if(empty($aboutInformation) || $aboutInformation==null || $aboutInformation==""){
                $userData = DB::table('candidate_abouts')->insert(array(
                    'location' => $request->location,
                    'country_of_interest' => $listCountries,
                    'language' => $languages,
                ));
            }
            else{
                $userData = DB::table('candidate_abouts')->select()->where('user_id', $getUserId[0])->update(array(
                    'location' => $request->location,
                    'country_of_interest' => $listCountries,
                    'language' => $languages,
                ));
            }

            if(empty($personalInformation) || $personalInformation==null || $personalInformation==""){
                $userData = DB::table('candidate_personal_informations')->insert(array(
                    'nationality' => $request->nationality,
                ));
            }
            else{
                $userData = DB::table('candidate_personal_informations')->select()->where('user_id', $getUserId[0])->update(array(
                    'nationality' => $request->nationality,
                ));
            }

            if( $request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $path = public_path(). '/images/';
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);
                $avatar  = $filename;


                DB::table('users')->where('id', $getUserId[0])->update(array(
                    'avatar' => $avatar,
                ));
            }

            if($request->has('skills')){
                DB::table('candidate_skills')
                ->where('user_id', $getUserId[0])
                ->delete();

                foreach ($request->skills as $key => $value) {
                    DB::table('candidate_skills')->insert(array(
                        'user_id' => $getUserId[0],
                        'skill' => $value
                    ));
                }
            }

            return response()->json(['message' => "Updated Succesfully", $roles[0] ], $this-> successStatus);

        }
    }

    public function candidate_job_preference(Request $request){
        // return $request->all();
        $roles = auth()->user()->roles()->pluck('name');

        if ($roles[0] != 'Candidate') {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
        else{
            $getUserId = auth()->user()->roles()->pluck('model_id');

            $rules = [
                'location' => 'required|integer',
                'field_of_expertise' => 'required',
                'country_of_interest' => 'required',
                'language'=> 'required',
                'nationality' => 'required|required',
                'firstName' => 'required',
                'lastName' => 'required',
                'avatar' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->messages()->first()], 401);
            }
            else{

                if(isset($request->field_of_expertise)){
                    $fieldOfExpertise = implode(',' , $request->field_of_expertise);
                }
                else{
                    $fieldOfExpertise = null;
                }

                if(isset($request->country_of_interest)){
                    $countryOfInterest = implode(',' , $request->country_of_interest);
                }
                else{
                    $countryOfInterest = null;
                }

                if(isset($request->language)){
                    $language = implode(',' , $request->language);
                }
                else{
                    $language = null;
                }

                $aboutData = DB::table('candidate_abouts')->where('user_id', $getUserId[0])->first();
                
                if(empty($aboutData)){
                    DB::table('candidate_abouts')->insert([
                        'user_id' => $getUserId[0],
                        'location' => $request->location,
                        'field_of_expertise' => $fieldOfExpertise,
                        'country_of_interest' => $countryOfInterest,
                        'language' => $language,
                    ]);
                }
                else{
                    DB::table('candidate_abouts')->where('user_id', $getUserId[0])->update([
                        'user_id' => $getUserId[0],
                        'location' => $request->location,
                        'field_of_expertise' => $fieldOfExpertise,
                        'country_of_interest' => $countryOfInterest,
                        'language' => $language,
                    ]);
                }

                $personalData = DB::table('candidate_personal_informations')->where('user_id', $getUserId[0])->first();

                if(empty($personalData)){
                    DB::table('candidate_personal_informations')->insert([
                        'user_id' => $getUserId[0],
                        'firstName' => $request->firstName,
                        'lastName' => $request->lastName,
                        'nationality' => $request->nationality,
                    ]);
                }
                else{
                    DB::table('candidate_personal_informations')->where('user_id', $getUserId[0])->update([
                        'user_id' => $getUserId[0],
                        'firstName' => $request->firstName,
                        'lastName' => $request->lastName,
                        'nationality' => $request->nationality,
                    ]);
                }

                if( $request->hasFile('avatar')) {
                    $image = $request->file('avatar');
                    $path = public_path(). '/images/';
                    $filename = time() . '.' . $image->getClientOriginalExtension();
                    $image->move($path, $filename);
                    $avatar  = $filename;
        
                    DB::table('users')->where('id', $getUserId[0])->update(array(
                        'avatar' => $avatar,
                    ));
                }
            }

            return response()->json(['success' => 'User Information Saved Successfully.', $roles[0] ], $this-> successStatus);
        }
    }

    public function languages(){
        $languageList = DB::table('languages')->get();
        return response()->json(['languages' => $languageList], $this-> successStatus);
    }

    public function business_categories(){
        $categoriesList = DB::table('employee_bussiness_categories')->get();
        return response()->json(['bussiness_categories' => $categoriesList], $this-> successStatus);
    }

}


?>
