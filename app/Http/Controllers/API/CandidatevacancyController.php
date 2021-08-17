<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Candidate;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class CandidatevacancyController extends Controller
{
    public $successStatus = 200;

    public function dashboardcandidateAPI(){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
           $getUserId = auth()->user()->roles()->pluck('model_id');
           $dataGet = DB::table('vacancy')->select( 'vacancy.title','users.name', 'vacancy.created_at', 'vacancy.ended_at', 'vacancy.id AS VID', 'users.id', 'vacancy.employementtype', 'vacancy.views_count', 'vacancy.industry', 'vacancy.applies', 'vacancy.starred', 'vacancy.remaining', 'vacancy.description', 'vacancy.basicqualification', 'vacancy.preferredqualification', 'vacancy.senioritylevel')->join('users', 'vacancy.userid', '=', 'users.id')->get();
        //   $success['title'] = $dataGet[0];
        //   foreach($dataGet as $dataGet1){

        //       $success = $dataGet1;
        //         //echo response()->json(['success'=>$success], $this-> successStatus);
        //   }
            $success = $dataGet;

             return response()->json(['success'=>$success], $this-> successStatus);
        }
    }

     public function defaultVacanciesList(){
        // $roles = auth()->user()->roles()->pluck('name');
        // $getUserId = auth()->user()->roles()->pluck('model_id');
           $dataGet = DB::table('vacancy')->select( 'vacancy.title','users.name', 'vacancy.created_at', 'vacancy.ended_at', 'vacancy.id AS VID', 'users.id', 'vacancy.employementtype', 'vacancy.views_count', 'vacancy.industry', 'vacancy.applies', 'vacancy.starred', 'vacancy.remaining', 'vacancy.description', 'vacancy.basicqualification', 'vacancy.preferredqualification', 'vacancy.senioritylevel')->join('users', 'vacancy.userid', '=', 'users.id')->get();
        //   $success['title'] = $dataGet[0];
        //   foreach($dataGet as $dataGet1){

        //       $success = $dataGet1;
        //         //echo response()->json(['success'=>$success], $this-> successStatus);
        //   }
            $success = $dataGet;

             return response()->json(['success'=>$success], $this-> successStatus);
    }

    public function personalInformation(){
        $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
           $getUserId = auth()->user()->roles()->pluck('model_id');
           $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();
           $getCountiresList = DB::table('country')->select()->get();
        //   $educationGet = DB::table('education')->select()->where('userid', $getUserId[0])->first();
        //   $interestGet = DB::table('interest')->select()->where('userid', $getUserId[0])->first();
        //   $getEducationalData = DB::table('education')->select()->where('userid', $getUserId[0])->get();
        //   $getExperienceData = DB::table('experience')->select()->where('userid', $getUserId[0])->get();
            // DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
            // print_r($dataGet);
        // return view('some-view')->with('users', $users);
            // return response()->json(['success'=>$success], $this-> successStatus);
            return response()->json(['success' => $dataGet, $roles[0] ], $this-> successStatus);
            // return view('candidate/profile', compact("roles", "dataGet", "educationGet", "getCountiresList", "getEducationalData", "getExperienceData", "interestGet") );
        }
    }

    public function editPersonalInformation(request $request){
        $roles = auth()->user()->roles()->pluck('name');
        $inputCountry = $request->input('inputCountry');
        $inputZip = $request->input('inputZip');
        $inputAddress1 = $request->input('inputAddress1');
        $inputAddress2 = $request->input('inputAddress2');
        $inputUsername = $request->input('inputUsername');
        $inputMobile = $request->input('inputMobile');
        $inputEmail = $request->input('inputEmail');
        $inputState = $request->input('inputState');
        $inputCurrentPosition = $request->input('currentposition');
        $inputPasswordOld = '';
        $inputPasswordOld = '';
        if($request->input('inputPasswordOld') != '' && $request->input('inputPasswordNew') != ''){
            $inputPasswordOld = $request->input('inputPasswordOld');
            $inputPasswordNew = $request->input('inputPasswordNew');
        }
        // $joindate = $request->input('cboJoinDate');
        // $educationallevel = $request->input('cboEducationalLevel');
        // $description = $_POST['txtDescription'];
        // $basicqualification = $request->input('txtBasicQualification');
        // $preferredqualification = $request->input('txtPreferredQualification');
        // $loggedUserId = $_GET['id'];
         if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
            $getUserId = auth()->user()->roles()->pluck('model_id');
            if($inputPasswordOld != '' && $inputPasswordNew != ''){
                $inputPasswordNew = bcrypt($inputPasswordNew);
                $dataUpdate = DB::table('users')->where('id', $getUserId[0])->update(array(
                    'country'=>$inputCountry,
                    "zip"=>$inputZip,
                    "address1"=>$inputAddress1,
                    "address2"=>$inputAddress2,
                    'username'=>$inputUsername,
                    "mobile"=>$inputMobile,
                    "state"=>$inputState,
                    // "email"=>$inputEmail,
                    "password"=>$inputPasswordNew
                ));
            }else{
                $dataUpdate = DB::table('users')->where('id', $getUserId[0])->update(array(
                    'country'=>$inputCountry,
                    "zip"=>$inputZip,
                    "address1"=>$inputAddress1,
                    "address2"=>$inputAddress2,
                    'username'=>$inputUsername,
                    "state"=>$inputState,
                    "mobile"=>$inputMobile
                    // "email"=>$inputEmail
                ));
            }


            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

        //    DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
        //    print_r($dataGet);
            return response()->json(['success' => $dataGet, $roles[0] ], $this-> successStatus);
        // return view('some-view')->with('users', $users);
            // return view('candidate/profile', compact("roles", "dataGet") );
        }
    }

    // edit personal education

     public function editPersonalInterest(request $request){
        $roles = auth()->user()->roles()->pluck('name');
        $currentfield = $request->input('currentfield');
        $countryinterest = $request->input('countryinterest');
        $interestedindustries = $request->input('interestedindustries');
        $currentskills = $request->input('currentskills');
        $inerestID = $request->input('interestID');
        if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
            $getUserId = auth()->user()->roles()->pluck('model_id');

            $dataUpdate = DB::table('interest')->where('userid', $getUserId[0])->where('id', $inerestID)->update(array(
                    "currentfield"=>$currentfield,
                    "countryinterest"=>$countryinterest,
                    "interestedindustries"=>$interestedindustries,
                    "currentskills"=>$currentskills,
                    // "userid"=>$lastAddedUser->id
                ));


            $dataGet = DB::table('interest')->select()->where('id', $inerestID)->first();

        //    DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
        //    print_r($dataGet);
            return response()->json(['success' => $dataGet, $roles[0] ], $this-> successStatus);
        // return view('some-view')->with('users', $users);
            // return view('candidate/profile', compact("roles", "dataGet") );
        }
    }



    public function addPersonalEducation(request $request){
        $roles = auth()->user()->roles()->pluck('name');

        $inputLevel = $request->input('inputLevel');
        $inputSchoolUni = $request->input('inputSchoolUni');
        $inputyearFrom = $request->input('inputyearFrom');
        $inputYearTo = $request->input('inputYearTo');
        $country = $request->input('country');

        // $loggedUserId = $_GET['id'];
         if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
            $getUserId = auth()->user()->roles()->pluck('id');
            $lastAddedUser = DB::table('users')->orderBy('id', 'DESC')->first();
            $data = array(
                'level'=>$inputLevel,
                "school"=>$inputSchoolUni,
                "fromyear"=>$inputyearFrom,
                "toyear"=>$inputYearTo,
                "country"=>$country,
                "userid"=>$lastAddedUser->id,
                "status"=>1
                // "email"=>$inputEmail
            );
            $rules = [
                'school'=>'required'
                     ];
            $customs = [
                'school' => 'Reqired Field.'
                       ];
            $validator = Validator::make($data, $rules, $customs);
            if ($validator->fails()) {
                return redirect()->back()->with('errors', 'Data Not Valid');

              // return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }else{
                DB::table('education')->insert($data);
            }
            $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

        //    DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
        //    print_r($dataGet);

        // return view('some-view')->with('users', $users);
        // $this->profile();
             //return view('candidate/profile', compact("roles", "dataGet") );
            //  return $this->profile();
            return response()->json(['success' => $dataGet, $roles[0] ], $this-> successStatus);
            //  return back()->with('success','Education updated successfully!');
        }
    }

    public function addPersonalInterest(request $request){
        $roles = auth()->user()->roles()->pluck('name');

        $currentfield = $request->input('currentfield');
        $countryinterest = $request->input('countryinterest');
        $interestedindustries = $request->input('interestedindustries');
        $currentskills = $request->input('currentskills');

        // $loggedUserId = $_GET['id'];
         if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
            $getUserId = auth()->user()->roles()->pluck('model_id');
            $lastAddedUser = DB::table('users')->orderBy('id', 'DESC')->first();
            $data = array(


                "currentfield"=>$currentfield,
                "countryinterest"=>$countryinterest,
                "interestedindustries"=>$interestedindustries,
                "currentskills"=>$currentskills,
                "userid"=>$lastAddedUser->id
              //  "status"=>1
                // "email"=>$inputEmail
            );




            $rules = [
                'currentfield'=>'required'
                     ];
            $customs = [
                'currentfield' => 'Reqired Field.'
                       ];
            $validator = Validator::make($data, $rules, $customs);

            if ($validator->fails()) {

                return redirect()->back()->with('errors', 'Data Not Valid');

              // return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }else{

                DB::table('interest')->insert($data);
            }
            //$dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

        //    DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
        //    print_r($dataGet);

        // return view('some-view')->with('users', $users);
        // $this->profile();
             //return view('candidate/profile', compact("roles", "dataGet") );
            //  return $this->profile();
             return response()->json(['success' => 'User Interest Saved Successfully.' ], $this-> successStatus);
             //return back()->with('success','Experience updated successfully!');
        }
    }

    public function addPersonalExperience(request $request){
        $roles = auth()->user()->roles()->pluck('name');

        $inputExpIndustry = $request->input('inputExpIndustry');
        $inputExpCompany = $request->input('inputExpCompany');
        $inputExpFromYear = $request->input('inputExpFromYear');
        $inputExpToYear = $request->input('inputExpToYear');
        $inputExpCountry = $request->input('inputExpCountry');
        $inputExpSeniorityLevel = $request->input('inputExpSeniorityLevel');
        $inputExpEmploymentType = $request->input('inputExpEmploymentType');
        $inputExpSkills = $request->input('inputExpSkills');

        // $loggedUserId = $_GET['id'];
         if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
            $getUserId = auth()->user()->roles()->pluck('model_id');
            $lastAddedUser = DB::table('users')->orderBy('id', 'DESC')->first();
            $data = array(


                "industry"=>$inputExpIndustry,
                "company"=>$inputExpCompany,
                "fromyear"=>$inputExpFromYear,
                "toyear"=>$inputExpToYear,
                "country"=>$inputExpCountry,
                "level"=>$inputExpSeniorityLevel,
                "employementtype"=>$inputExpEmploymentType,
                "skills"=>$inputExpSkills,
                "userid"=>$lastAddedUser->id,
                "status"=>1
                // "email"=>$inputEmail
            );
            $rules = [
                'industry'=>'required'
                     ];
            $customs = [
                'industry' => 'Reqired Field.'
                       ];
            $validator = Validator::make($data, $rules, $customs);
            if ($validator->fails()) {
                return redirect()->back()->with('errors', 'Data Not Valid');

              // return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }else{
                DB::table('experience')->insert($data);
            }
            // $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

        //    DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
        //    print_r($dataGet);

        // return view('some-view')->with('users', $users);
        // $this->profile();
             //return view('candidate/profile', compact("roles", "dataGet") );
            //  return $this->profile();
             return response()->json(['success' => 'User Experience Saved Successfully.', $roles[0] ], $this-> successStatus);
             //return back()->with('success','Experience updated successfully!');
        }
    }

    public function editPersonalEducation(request $request){
        $roles = auth()->user()->roles()->pluck('name');
        $inputLevel = $request->input('inputLevel');
        $inputSchoolUni = $request->input('inputSchoolUni');
        $inputyearFrom = $request->input('inputyearFrom');
        $inputYearTo = $request->input('inputYearTo');
        $country = $request->input('country');
        $educationID = $request->input('id');

         if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
            $getUserId = auth()->user()->roles()->pluck('model_id');

            $dataUpdate = DB::table('education')->where('userid', $getUserId[0])->where('id', $educationID)->update(array(
                    'level'=>$inputLevel,
                "school"=>$inputSchoolUni,
                "fromyear"=>$inputyearFrom,
                "toyear"=>$inputYearTo,
                "country"=>$country,

                "status"=>1
                ));


            // $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

        //    DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
        //    print_r($dataGet);
            return response()->json(['success' => 'User Education Saved Successfully.', $roles[0] ], $this-> successStatus);
        // return view('some-view')->with('users', $users);
            // return view('candidate/profile', compact("roles", "dataGet") );
        }
    }

    public function editPersonalExperience(request $request){
        $roles = auth()->user()->roles()->pluck('name');

        $inputExpIndustry = $request->input('industry');
        $inputExpCompany = $request->input('company');
        $inputExpFromYear = $request->input('fromyear');
        $inputExpToYear = $request->input('toyear');
        $inputExpCountry = $request->input('country');
        $inputExpSeniorityLevel = $request->input('level');
        $inputExpEmploymentType = $request->input('employementtype');
        $inputExpSkills = $request->input('skills');
        $experienceID = $request->input('id');

         if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
            $getUserId = auth()->user()->roles()->pluck('model_id');

                $dataUpdate = DB::table('experience')->where('userid', $getUserId[0])->where('id', $experienceID)->update(array(
                  "industry"=>$inputExpIndustry,
                "company"=>$inputExpCompany,
                "fromyear"=>$inputExpFromYear,
                "toyear"=>$inputExpToYear,
                "country"=>$inputExpCountry,
                "level"=>$inputExpSeniorityLevel,
                "employementtype"=>$inputExpEmploymentType,
                "skills"=>$inputExpSkills,
                "status"=>1
                ));



            // $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

        //    DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
        //    print_r($dataGet);
            return response()->json(['success' => 'User Experience Saved Successfully.', $roles[0] ], $this-> successStatus);
        // return view('some-view')->with('users', $users);
            // return view('candidate/profile', compact("roles", "dataGet") );
        }
    }

    public function allPersonInformation(){
           $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
           $getUserId = auth()->user()->roles()->pluck('model_id');
           $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();
           $getCountiresList = DB::table('country')->select()->get();
          $educationGet = DB::table('education')->select()->where('userid', $getUserId[0])->first();
          $interestGet = DB::table('interest')->select()->where('userid', $getUserId[0])->first();
          $getInterests = DB::table('interest')->select()->where('userid', $getUserId[0])->first();
          $getEducationalData = DB::table('education')->select()->where('userid', $getUserId[0])->get();
          $getExperienceData = DB::table('experience')->select()->where('userid', $getUserId[0])->get();
            // DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
            // print_r($dataGet);
        // return view('some-view')->with('users', $users);
            // return response()->json(['success'=>$success], $this-> successStatus);
            return response()->json(['profile' => $dataGet, 'interests' => $getInterests, 'education' => $getEducationalData, 'experience' => $getExperienceData, $roles[0] ], $this-> successStatus);
            // return view('candidate/profile', compact("roles", "dataGet", "educationGet", "getCountiresList", "getEducationalData", "getExperienceData", "interestGet") );
        }
    }

    public function updateInterestAPI(request $request){
        $roles = auth()->user()->roles()->pluck('name');
        $currentfield = $request->input('currentfield');
        $countryinterest = $request->input('countryinterest');
        $interestedindustries = $request->input('interestedindustries');
        $currentskills = $request->input('currentskills');
        $inerestID = $request->input('interestID');
        if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
            $getUserId = auth()->user()->roles()->pluck('model_id');

            $dataUpdate = DB::table('interest')->where('userid', $getUserId[0])->where('id', $inerestID)->update(array(
                    "currentfield"=>$currentfield,
                    "countryinterest"=>$countryinterest,
                    "interestedindustries"=>$interestedindustries,
                    "currentskills"=>$currentskills,
                    // "userid"=>$lastAddedUser->id
                ));


            $dataGet = DB::table('interest')->select()->where('id', $inerestID)->first();

        //    DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
        //    print_r($dataGet);
            return response()->json(['success' => $dataGet, $roles[0] ], $this-> successStatus);
        // return view('some-view')->with('users', $users);
            // return view('candidate/profile', compact("roles", "dataGet") );
        }
    }


    public function getVacancydetail(request $request){
                $rolesid = auth()->user()->roles()->pluck('id');
        $getUserId = auth()->user()->roles()->pluck('model_id');
        $getUserId[0];
        $vacancyid = $request->vacancyid;
        //$data=array('userid'=>$getUserId[0],"vacancyid"=>$vacancyid,"status"=>'1');
        // $dataCheck = DB::table('job_users')->select()->where('userid', $getUserId[0])->where('vacancyid', $vacancyid)->first();
        $dataGet = DB::table('vacancy')->select()->where('id', $vacancyid)->get();
        // if(isset($dataCheck)){
        //     return back()->with('warning','You have already applied for this job!');
        // }else{
        //     DB::table('job_users')->insert($data);

        //     DB::table('vacancy')->where('id', $vacancyid)->update(array(
        //         'applies'=> DB::raw('applies+1')
        //     ));
        //     return back()->with('success','Job Applied successfully!');
        // }
        return response()->json(['vacancy' => $dataGet, $rolesid[0] ], $this-> successStatus);
    }

    public function getUserExperience(request $request){
           $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
           $getUserId = auth()->user()->roles()->pluck('model_id');
        //   $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();
        //   $getCountiresList = DB::table('country')->select()->get();
        //   $educationGet = DB::table('education')->select()->where('userid', $getUserId[0])->first();
        //   $interestGet = DB::table('interest')->select()->where('userid', $getUserId[0])->first();
        //   $getInterests = DB::table('interest')->select()->where('userid', $getUserId[0])->get();
        //   $getEducationalData = DB::table('education')->select()->where('userid', $getUserId[0])->get();
          $getExperienceData = DB::table('experience')->select()->where('userid', $getUserId[0])->get();
            // DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
            // print_r($dataGet);
        // return view('some-view')->with('users', $users);
            // return response()->json(['success'=>$success], $this-> successStatus);
            return response()->json(['experience' => $getExperienceData, $roles[0] ], $this-> successStatus);
            // return view('candidate/profile', compact("roles", "dataGet", "educationGet", "getCountiresList", "getEducationalData", "getExperienceData", "interestGet") );
        }
    }

    public function getAppliedJobsInfo(){
         $roles = auth()->user()->roles()->pluck('name');
        if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
           $getUserId = auth()->user()->roles()->pluck('model_id');
            $dataCheck = DB::table('job_users')->select()->join('vacancy','vacancy.id','=','job_users.vacancyid')->where('job_users.userid', $getUserId[0])->get();
            return response()->json(['appliedvacancy' => $dataCheck, $roles[0] ], $this-> successStatus);

        }
    }

    public function countrieslist(){
        $dataCheck  = DB::table('country')->select()->get();
        return response()->json(['countries' => $dataCheck ], $this-> successStatus);

    }

    public function deleteEducation(request $request){
       // $res=User::where('id',$id)->delete();

        $roles = auth()->user()->roles()->pluck('name');

        $educationID = $request->input('id');

         if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
            $getUserId = auth()->user()->roles()->pluck('model_id');

            $dataUpdate = DB::table('education')->where('id', $educationID)->delete();


            // $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

        //    DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
        //    print_r($dataGet);
            return response()->json(['success' => 'Selected educaion infromation is removed..'], $this-> successStatus);
        // return view('some-view')->with('users', $users);
            // return view('candidate/profile', compact("roles", "dataGet") );
        }

    }

    public function deleteExperience(request $request){
          $roles = auth()->user()->roles()->pluck('name');

        $experienceID = $request->input('id');

         if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
            $getUserId = auth()->user()->roles()->pluck('model_id');

            $dataUpdate = DB::table('experience')->where('id', $experienceID)->delete();


            // $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

        //    DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
        //    print_r($dataGet);
            return response()->json(['success' => 'Selected experience infromation is removed..'], $this-> successStatus);
        // return view('some-view')->with('users', $users);
            // return view('candidate/profile', compact("roles", "dataGet") );
        }
    }

     public function deleteVacancy(request $request){
          $roles = auth()->user()->roles()->pluck('name');

        $selectedID = $request->input('id');

         if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{
            $getUserId = auth()->user()->roles()->pluck('model_id');

            $dataUpdate = DB::table('job_users')->where('vrid', $selectedID)->delete();


            // $dataGet = DB::table('users')->select()->where('id', $getUserId[0])->first();

        //    DB::table('users')->select('users.id','users.name','profiles.photo')->join('profiles','profiles.id','=','users.id')->where(['something' => 'something', 'otherThing' => 'otherThing'])->get();
        //    print_r($dataGet);
            return response()->json(['success' => 'Selected vacancy infromation is removed..'], $this-> successStatus);
        // return view('some-view')->with('users', $users);
            // return view('candidate/profile', compact("roles", "dataGet") );
        }
    }

    public function applyforjobAPI(request $request){
        $rolesid = auth()->user()->roles()->pluck('id');
        $getUserId = auth()->user()->roles()->pluck('model_id');
        $getUserId[0];
        $vacancyid = $request->input('id');
        $data=array('userid'=>$getUserId[0],"vacancyid"=>$vacancyid,"status"=>'1');
        $dataCheck = DB::table('job_users')->select()->where('userid', $getUserId[0])->where('vacancyid', $vacancyid)->first();

        if(isset($dataCheck)){
            // return back()->with('warning','You have already applied for this job!');
            return response()->json(['success' => 'You have already applied for this job!'], $this-> successStatus);

        }else{
            DB::table('job_users')->insert($data);

            DB::table('vacancy')->where('id', $vacancyid)->update(array(
                'applies'=> DB::raw('applies+1')
            ));
            // return back()->with('success','Job Applied successfully!');
            return response()->json(['success' => 'THe job has been applied.'], $this-> successStatus);
        }
    }

    public function searchVacancyAPI(request $request){
        $rolesid = auth()->user()->roles()->pluck('id');
        $roles = auth()->user()->roles()->pluck('name');
        $vacancySearch = $request->input('search');

        if ($roles[0] != 'candidate') {
            return view('404', compact("roles"));
        }else{

            $getUserId = auth()->user()->roles()->pluck('model_id');
            $getUserId[0];
            $vacancyTitle = $request->input('title');
           // $data=array('userid'=>$getUserId[0],"vacancyid"=>$vacancyid,"status"=>'1');
            $dataGet = DB::table('vacancy')->select()->where('title', 'like', "%{$vacancySearch}%")->orWhere('industry', 'like', "%{$vacancySearch}%")->orWhere('educationallevel', 'like', "%{$vacancySearch}%")->orWhere('tagsandskills', 'like', "%{$vacancySearch}%")->orWhere('description', 'like', "%{$vacancySearch}%")->orWhere('nationality', 'like', "%{$vacancySearch}%")->orWhere('employementtype', 'like', "%{$vacancySearch}%")->orWhere('gender', 'like', "%{$vacancySearch}%")->get();
            $success = $dataGet;

             return response()->json(['success'=>$success], $this-> successStatus);
        }

        // if(isset($dataCheck)){
        //     return back()->with('warning','You have already applied for this job!');
        // }else{
        //     DB::table('job_users')->insert($data);

        //     DB::table('vacancy')->where('id', $vacancyid)->update(array(
        //         'applies'=> DB::raw('applies+1')
        //     ));
        //     // return back()->with('success','Job Applied successfully!');
        //     return response()->json(['success' => 'THe job has been applied.'], $this-> successStatus);
        // }
    }



}
