<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function Sodium\increment;
use PDF;
use App;
use Carbon\Carbon;

class JobController extends Controller
{
    public function create()
    {
        $countries = DB::table('countries')->get();
        $salaries = DB::table('job_salary_ranges')->get();
        $qualifications = DB::table('job_qualifications')->get();
        $experiences = DB::table('job_experiences')->get();
        $candidateLocations = DB::table('job_candidate_locations')->get();
        $categories = DB::table('employee_bussiness_categories')->get();
        $skills = DB::table('skills')->get();
        $nationalities = DB::table('nationalities')->select()->get();
        $careerLevels = DB::table('job_career_levels')->select()->get();
        $jobTypes = DB::table('job_types_tables')->get();

        if(auth()->user()->free_jobs > 0){
            return view('employer.pages.manageJobs.create', compact('countries','salaries','qualifications',
                'experiences','candidateLocations','categories','skills','nationalities','careerLevels','jobTypes'));
        }

        $exist = 0;

        $record =  DB::table('employee_packages')
        ->where('user_id', Auth::user()->id)
        ->where('status', 1)
        ->first();

        if(!empty($record)){
            $exist = 1;
        }


        if($exist == 0){
            return redirect()->route('purchase')->with('error','Please purchase a package before posting a job.');
        }
        else
        {
            if($record->jobs_count >= $record->jobs_limit){
                return redirect()->route('purchase')->with('error','You have reached your job posting limit, Please Update your Package.');
            }
        }

        return view('employer.pages.manageJobs.create', compact('countries','salaries','qualifications',
                          'experiences','candidateLocations','categories','skills','nationalities','careerLevels'));
    }

    public function saveJob(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'string|max:255|required',
            'title_ar' => 'string|max:255|required',
            'salary' => 'required',
            'job_location' => 'required',
            'candidate_nationality' => 'required',
            'qualification' => 'required',
            'career_level' => 'required',
            'experience' => 'required',
            'type' => 'required',
            'skills' => 'required',
            'gender' => 'required',
            'candidate_location' => 'required',
            'category' => 'required',
            'date' => 'required|date',
            // 'endingDate' => 'required|date|after_or_equal:date',
            'description' => 'required',
            'responsibilities' => 'required',
            'education' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if(auth()->user()->free_jobs <= 0){
            $exist = 0;

            $record =  DB::table('employee_packages')
            ->where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->first();

            if(!empty($record)){
                $exist = 1;
            }

            if($exist == 0){
                return redirect()->route('purchase')->with('error','Please purchase a package before posting a job.');
            }
            else{
                if($record->jobs_count >= $record->jobs_limit){
                    return redirect()->route('purchase')->with('error','You have reached your job posting limit, Please Update your Package.');
                }
            }
        }

        $skills = implode(',', $request->skills);

        $jobId = DB::table('jobs')->insertGetId(array(
            'user_id' => Auth::user()->id,
            'status' => 1,
            'approval_status' => 0,
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'salary' => $request->salary,
            'job_location' => $request->job_location,
            'city' => $request->city_id,
            'candidate_nationality' => $request->candidate_nationality,
            'qualification' => $request->qualification,
            'career_level' => $request->career_level,
            'experience' => $request->experience,
            'type' => $request->type,
            'skills' => $skills,
            'gender' => $request->gender,
            'candidate_location' => $request->candidate_location,
            'category' => $request->category,
            'date' => $request->date,
            'endingDate' => Carbon::createFromDate($request->date)->addMonths(1)->format('Y-m-d'),
            'description' => $request->description,
            'responsibilities' => $request->responsibilities,
            'education' => $request->education,
        ));

        DB::table('jobs')->where('id', $jobId)->update([
            'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title))).$jobId,
        ]);

        if(auth()->user()->free_jobs <= 0){
            DB::table('employee_packages')->where('id', $record->id)->update(array(
                'jobs_count' => $record->jobs_count + 1,
            ));
        }

        if(auth()->user()->free_jobs > 0){
            DB::table('users')->where('id', auth()->user()->id)->update([
                'free_jobs' => auth()->user()->free_jobs - 1,
            ]);
        }

        return redirect()->route('manageJobs')->with('success','Job posted wait for admin response');
    }

    public function manageJob()
    {
        $jobs = DB::table('jobs')->where('user_id', Auth::user()->id)->orderBy('id','DESC')->paginate(6);

        return view('employer.pages.manageJobs.manageJobs', compact('jobs'));
    }

    public function viewJob($id)
    {
        $skills = DB::table('skills')->get();
        $job = DB::table('jobs')->where('id', decrypt($id))->first();
        $jobTypes = DB::table('job_types_tables')->get();

        return view('employer.pages.manageJobs.view', compact('job','skills', 'jobTypes'));
    }

    public function jobStatus(Request $request)
    {
        $job = DB::table('jobs')->where('id',$request->job_id)->first();

        if(empty($job)) {
            return response()->json(['status' => 0]);
        }

        DB::table('jobs')->where('id', $job->id)->update([
            'status' => $request->status,
        ]);

        return response()->json(['status' => 1]);
    }

    public function edit($id)
    {
        $countries = DB::table('countries')->get();
        $salaries = DB::table('job_salary_ranges')->get();
        $qualifications = DB::table('job_qualifications')->get();
        $experiences = DB::table('job_experiences')->get();
        $candidateLocations = DB::table('job_candidate_locations')->get();
        $categories = DB::table('employee_bussiness_categories')->get();
        $skills = DB::table('skills')->get();
        $nationalities = DB::table('nationalities')->select()->get();
        $careerLevels = DB::table('job_career_levels')->select()->get();
        $jobTypes = DB::table('job_types_tables')->get();

        $job = DB::table('jobs')->where('id', decrypt($id))->first();

        $cities = DB::table('cities')->where('country_id', $job->job_location)->get();

        return view('employer.pages.manageJobs.edit', compact('job', 'countries','salaries','qualifications',
            'experiences','candidateLocations','categories','skills','nationalities','careerLevels', 'cities', 'jobTypes'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'string|max:255|required',
            'title_ar' => 'string|max:255|required',
            'salary' => 'required',
            'job_location' => 'required',
            'candidate_nationality' => 'required',
            'qualification' => 'required',
            'career_level' => 'required',
            'experience' => 'required',
            'type' => 'required',
            'skills' => 'required',
            'gender' => 'required',
            'candidate_location' => 'required',
            'category' => 'required',
        //    'date' => 'required|date',
            // 'endingDate' => 'required|date|after_or_equal:date',
            'description' => 'required',
            'responsibilities' => 'required',
            'education' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $skills = implode(',', $request->skills);

        DB::table('jobs')
            ->where('id', decrypt($id))
            ->update(array(
            'title' => $request->title,
            'title_ar' => $request->title_ar,
            'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title))).decrypt($id),
            'salary' => $request->salary,
            'job_location' => $request->job_location,
            'city' => $request->city_id,
            'candidate_nationality' => $request->candidate_nationality,
            'qualification' => $request->qualification,
            'career_level' => $request->career_level,
            'experience' => $request->experience,
            'type' => $request->type,
            'skills' => $skills,
            'gender' => $request->gender,
            'candidate_location' => $request->candidate_location,
            'category' => $request->category,
            // 'date' => $request->date,
            // 'endingDate' => $request->endingDate,
            'description' => $request->description,
            'responsibilities' => $request->responsibilities,
            'education' => $request->education,
        ));

        return redirect()->route('manageJobs')->with('success','Job updated successfully');

    }

    public function delete(Request $request)
    {
        $job = DB::table('jobs')->where('id',$request->id)->first();

        if(empty($job)) {
            return response()->json(['status' => 0]);
        }

        DB::table('candidate_applied_jobs')->where('job_id',$request->id)->delete();
        DB::table('jobs')->where('id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }

    public function manageCandidate($id)
    {
        $usersInactive = DB::table('users')->where('account_active', 1)->get()->pluck('id');

        $jobs = DB::table('jobs')->where('id', decrypt($id))->first();
        $candidate_jobs = DB::table('candidate_applied_jobs')->whereIn('user_id', $usersInactive)->where('job_id', $jobs->id)->orderBy('id', 'desc')->get();  

        return view('employer.pages.manageCandidate.manageCandidate', compact('jobs','candidate_jobs'));
    }

    public function manageMatchedCandidates($id)
    {
        $jobs = DB::table('jobs')->where('id', decrypt($id))->first();

        $candidateId = DB::table('candidate_applied_jobs')->where('job_id', $jobs->id)->get()->pluck('user_id');
      
        $matchedCandidates  = DB::table('users as u')->select('u.id')->whereIn('u.id', $candidateId)
        ->join('candidate_abouts as ab', 'u.id', '=', 'ab.user_id')
        ->join('candidate_personal_informations as pi', 'u.id', '=', 'pi.user_id')
        ->where('u.match_cv', 1)
        ->where('u.account_active', 1)
        ->where('ab.location', $jobs->job_location)
        ->where('pi.nationality', $jobs->candidate_nationality)
        ->where('ab.gender', $jobs->gender)
        ->whereRaw("find_in_set('".$jobs->category."', ab.field_of_expertise)")
        ->get()->pluck('id');

        $candidate_jobs = DB::table('candidate_applied_jobs')->whereIn('user_id', $matchedCandidates)->where('job_id', $jobs->id)->orderBy('id', 'desc')->get();  
        
        return view('employer.pages.manageCandidate.manageCandidate', compact('jobs','candidate_jobs'));
    }

    public function employerUpdateNoteCandidate(Request $request){
        DB::table('candidate_applied_jobs')->where('id', $request->popUpRowId)->update([
            'note' => $request->popUpRowNote,
        ]);

        return redirect()->back()->with('success', 'Note Updated.');
    }

    public function jobFeedback(Request $request)
    {
        $job = DB::table('candidate_applied_jobs')
            ->where('job_id',$request->job_id)
            ->where('user_id',$request->candidate_id)
            ->first();

        if(empty($job)) {
            return response()->json(['status' => 0]);
        }

        DB::table('candidate_applied_jobs')->where('id', $job->id)->update([
            'application_status' => $request->status_id,
        ]);

        return response()->json(['status' => 1]);
    }

    public function CV($id)
    {
        $candidate = DB::table('users')
            ->join('candidate_abouts','users.id','=','candidate_abouts.user_id')
            ->join('candidate_personal_informations','users.id','=','candidate_personal_informations.user_id')
            ->where('users.id',decrypt($id))
            ->first();

            // dd($candidate);

        DB::table('cv_counters')->where('user_id', decrypt($id))->increment('count');

        $educations = DB::table('candidate_educations')->where('user_id', decrypt($id))->get();
        $portfolios = DB::table('candidate_portfolios')->where('user_id', decrypt($id))->get();
        $skills = DB::table('candidate_skills')->where('user_id', decrypt($id))->first();

        return view('employer.pages.manageCandidate.candidateCV', compact('candidate', 'educations', 'skills', 'portfolios'));
    }

    public function saveCvPdf($id){
        $candidate = DB::table('users')
            ->join('candidate_abouts','users.id','=','candidate_abouts.user_id')
            ->join('candidate_personal_informations','users.id','=','candidate_personal_informations.user_id')
            ->where('users.id',decrypt($id))
            ->first();

        DB::table('cv_counters')->where('user_id', decrypt($id))->increment('count');

        $educations = DB::table('candidate_educations')->where('user_id', decrypt($id))->get();
        $portfolios = DB::table('candidate_portfolios')->where('user_id', decrypt($id))->get();
        $skills = DB::table('candidate_skills')->where('user_id', decrypt($id))->first();

        if($candidate->avatar != null){
            $candidateImage = base64_encode(file_get_contents(asset('images/'.$candidate->avatar)));
        }
        else{
            $candidateImage = null;
        }

        // return view('employer.pages.manageCandidate.cvPdf', compact('candidate', 'candidateImage', 'educations', 'skills', 'portfolios'));

        $pdf = PDF::loadView('employer.pages.manageCandidate.cvPdf', compact('candidate', 'candidateImage', 'educations', 'skills', 'portfolios'));
        
        return $pdf->download('CV.pdf');
    }

    public function purchase()
    {
        $packages = DB::table('packages')->whereRaw("find_in_set('".auth()->user()->country_name."',countries)")->get();

        $exist = 0;
        $existRecord = '';

        $record =  DB::table('employee_packages')
        ->where('user_id', Auth::user()->id)
        ->where('status', 1)
        ->first();

        if(!empty($record)){
            $jobsLimit = $record->jobs_limit;
            $exist = 1;
            $existRecord = DB::table('employee_packages')
            ->where('user_id', Auth::user()->id)
            ->where('jobs_count', '<' , $jobsLimit)
            ->where('status', 1)
            ->first();
        }

        return view('employer.pages.purchase.purchase',compact('packages','exist','existRecord'));
    }

    public function packageDetail($id)
    {
        $package = DB::table('packages')->where("id", decrypt($id))->first();

        $exist = 0;
        $existRecord = '';

        $record =  DB::table('employee_packages')
        ->where('user_id', Auth::user()->id)
        ->where('status', 1)
        ->first();

        if(!empty($record)){
            $jobsLimit = $record->jobs_limit;
            $exist = 1;
            $existRecord = DB::table('employee_packages')
            ->where('user_id', Auth::user()->id)
            ->where('jobs_count', '<' , $jobsLimit)
            ->where('status', 1)
            ->first();
        }

        return view('employer.pages.purchase.packageDetail',compact('package','exist','existRecord'));
    }

    public function paymentHistory()
    {
        $employeePackages = DB::table('employee_packages')
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'Desc')
            ->get();

        return view('employer.pages.payment.history',compact('employeePackages'));
    }

    public function payment($packageId)
    {
        $packageId = decrypt($packageId);

        if(auth()->user()->country_name == 4){
            $paymentMethod = request()->payment_method;
        }
        else{
            $paymentMethod = 2;
        }

        $packageDetail = DB::table('package_details')->where('package_id', $packageId)->first();
        $packageCurrency = DB::table('package_currencys')->where('id', $packageDetail->currency)->first();

        if(isset($packageCurrency)){
            $currency = $packageCurrency->currency_name;
        }
        else{
            $currency = 'KWD';
        }

        $exist = 0;
        $existRecord = '';

        $record =  DB::table('employee_packages as ep')->select('ep.jobs_limit')
        ->where('user_id', Auth::user()->id)
        ->where('status', 1)
        ->first();


        if(isset($record)){
            $exist = 1;
            $jobsLimit = $record->jobs_limit;

            $existRecord =  DB::table('employee_packages as ep')
                ->select('*')
                ->where('ep.user_id', Auth::user()->id)
                ->where('ep.jobs_count', '<' , $jobsLimit)
                ->where('ep.status', 1)
                ->first();
        }

        if($exist == 1){
            if($existRecord != "" || !empty($existRecord)){
                if($existRecord->package_id == $packageId){
                    return redirect()->back()->with('error', 'You have already Purchased this Package');
                }
            }
        }

        $errorURL = route('purchase');
        $successURL = route('paymentSuccessful');

        // $errorURL = 'https://www.youtube.com/';
        // $successURL = 'https://www.google.com/';

        $package_info = DB::table('packages as P')
        ->select('*')
        ->join('package_details as PD', 'P.id', '=', 'PD.package_id')
        ->where('P.id', $packageId)
        ->get();

        $package = array();

        foreach ($package_info as $key => $value) {
            $package['id'] = $value->package_id;
            $package['package_detail_id'] = $value->id;
            $package['package_name'] = $value->package_name;
            $package['package_description'] = $value->package_description;
            $package['currency'] = $value->currency;
            $package['rate'] = $value->rate;
            $package['job_limit'] = $value->job_limit;
            $package['cv_limit'] = $value->cv_limit;
        }

        $user_info = DB::table('users')->where('id', '=', Auth::user()->id)->first();

        $total_price = $package['rate'];
        $jobLimit = $package['job_limit'];
        $cvLimit = $package['cv_limit'];




        // Latest Payment Code
        $packageName = $package['package_name'];
        $customData = $package['id'] . ',' . $jobLimit . ',' . $cvLimit;


        // if package price is 0 it will not go to payment gateway.
        if($total_price <= 0){
            DB::table('employee_packages')->where('user_id' , Auth::user()->id)->update(array(
                'status' => 0,
            ));

            DB::table('employee_packages')->insert(array(

                'user_id' => Auth::user()->id,
                'package_id' => $package['id'],
                'country_name' => auth()->user()->country_name,

                'package_name' => $packageName,
                'currency' => $currency,
                'amount_paid' => $total_price,

                'customer_name' => $user_info->name,
                'customer_email' => $user_info->email,
                'customer_phone' => $user_info->phoneNo,

                'jobs_limit' => $jobLimit,
                'cv_limit' => $cvLimit,

            ));

            $finalResult = DB::table('employee_packages')
            ->where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->first();

            return view('employer.pages.payment.success', compact('finalResult'));
        }


        $token  = "S8mcb_v05LxWjWfnIYQjPV7IosuQ9uCgyH-DMTDs2uB6MdmYB1GFOgdu1aWP0x-vBPwEgBX8BP_Oem3aH_sCTtRprEz35-B-kJ6UY0nZ-tB2RKhPYRQEfi6cnhMZeqrkBK7t2MyoGHOHPx-JMzX48Yfvek-t8WgjWSq7qJEwuKSJ6vlL7TYntEKNHcFlidLOnqXRFcLuuwGzFxRjUFo5yKN1NZClQ6u-JnMDjpPpg-wXrR6B4UcsP0tntGKYXFGJjUT2c_AmDwFw1Psg0RcGuGUQmgI1bzPuXLpF1NiP5bHCnuZ8n5QQ0t26YRKLYkEq-TOVAc7X5L7bny0cdF-Qoxv-dYaQsqNnaJz1k9YQq8B-JabdytclFDhSxpt482w8xXgG9kADTpISfd8H1uRjV8XUlN2IHX-PfzwC7-2WsxDP_lr6BET9cTabOiWSMSZ-7MeT_7ydSgJzqWNdB9ybUEZkPzwkv2BHnI8coAYRwcbuLPU_3UtJyAdFwxNJUkTeptjlrePWnbs_WNbC1vCBjz9dhmZ_t10u4UCkWKuXU26k1SXP3m9B9xjmd-_m2io95eGgas47S_Sb3dF-tAM6MSDag8pgn-3laOBCECAAaYaqhlsiReYfdkLJSX72Z_4vkInN2bjeHFR08Zt8pvcVyR0BenVN4PxTvK-yLK8OmMcjUjVS";
        $basURL = "https://api.myfatoorah.com";
        $t= time();

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "$basURL/v2/ExecutePayment",
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{
            \"PaymentMethodId\": \"$paymentMethod\",
            \"CustomerName\": \"$user_info->name\",
            \"DisplayCurrencyIso\": \"$currency\",
            \"MobileCountryCode\":\"+965\",
            \"CustomerMobile\": \"$user_info->phoneNo\",
            \"CustomerEmail\": \"$user_info->email\",
            \"InvoiceValue\": $total_price,
            \"CallBackUrl\": \"$successURL\",
            \"ErrorUrl\": \"$errorURL\",
            \"Language\": \"en\",
            \"CustomerReference\": \"$t\",
            \"CustomerCivilId\":12345678,
            \"UserDefinedField\": \"$customData\",
            \"ExpireDate\": \"\",
            \"SupplierCode\": \"\",
            \"CustomerAddress\" :{
                \"Block\": \"\",
                \"Street\": \"\",
                \"HouseBuildingNo\": \"\",
                \"Address\": \"\",
                \"AddressInstructions\": \"\"
            },
            \"InvoiceItems\": [
                {
                    \"ItemName\": \"$packageName\",
                    \"Quantity\": 1,
                    \"UnitPrice\": $total_price
                }
            ]
        }",
        CURLOPT_HTTPHEADER => array("Authorization: Bearer $token","Content-Type: application/json"),
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $record= json_decode($response,true);

        if($record['IsSuccess'] == false){
            return redirect()->route('purchase')->with('error', $record['ValidationErrors'][0]['Error']);
        }

        $RedirectUrl= $record['Data']['PaymentURL'];

        echo'<script type="text/javascript">
            window.location="'.$RedirectUrl.'";
        </script>';

    }

    public function paymentSuccess()
    {
        // Old Payment Code

        $token  = "S8mcb_v05LxWjWfnIYQjPV7IosuQ9uCgyH-DMTDs2uB6MdmYB1GFOgdu1aWP0x-vBPwEgBX8BP_Oem3aH_sCTtRprEz35-B-kJ6UY0nZ-tB2RKhPYRQEfi6cnhMZeqrkBK7t2MyoGHOHPx-JMzX48Yfvek-t8WgjWSq7qJEwuKSJ6vlL7TYntEKNHcFlidLOnqXRFcLuuwGzFxRjUFo5yKN1NZClQ6u-JnMDjpPpg-wXrR6B4UcsP0tntGKYXFGJjUT2c_AmDwFw1Psg0RcGuGUQmgI1bzPuXLpF1NiP5bHCnuZ8n5QQ0t26YRKLYkEq-TOVAc7X5L7bny0cdF-Qoxv-dYaQsqNnaJz1k9YQq8B-JabdytclFDhSxpt482w8xXgG9kADTpISfd8H1uRjV8XUlN2IHX-PfzwC7-2WsxDP_lr6BET9cTabOiWSMSZ-7MeT_7ydSgJzqWNdB9ybUEZkPzwkv2BHnI8coAYRwcbuLPU_3UtJyAdFwxNJUkTeptjlrePWnbs_WNbC1vCBjz9dhmZ_t10u4UCkWKuXU26k1SXP3m9B9xjmd-_m2io95eGgas47S_Sb3dF-tAM6MSDag8pgn-3laOBCECAAaYaqhlsiReYfdkLJSX72Z_4vkInN2bjeHFR08Zt8pvcVyR0BenVN4PxTvK-yLK8OmMcjUjVS";
        $basURL = "https://api.myfatoorah.com";

        if(isset($_GET['paymentId'])){
            // return 1;
            $paymentId=$_GET['paymentId'];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$basURL/v2/GetPaymentStatus",
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{
                    \"Key\":\"$paymentId\",
                    \"KeyType\": \"PaymentId\"
                }",
                CURLOPT_HTTPHEADER => array("Authorization: Bearer $token","Content-Type: application/json"),
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
            $getRecorById= json_decode($response,true);

            if($getRecorById['IsSuccess'] == false){
                return redirect()->route('purchase')->with('error', 'Payment was not successfull');
            }

            $finalResult = array();
            $finalResult['InvoiceId'] = $getRecorById['Data']['InvoiceId'];
            $finalResult['OrderId'] = $getRecorById['Data']['InvoiceId'];
            $finalResult['InvoiceReference'] = $getRecorById['Data']['InvoiceReference'];
            $finalResult['CreatedDate'] = $getRecorById['Data']['CreatedDate'];
            $finalResult['ExpireDate'] = $getRecorById['Data']['ExpiryDate'];
            $finalResult['InvoiceValue'] = $getRecorById['Data']['InvoiceValue'];
            $finalResult['Comments'] = $getRecorById['Data']['Comments'];
            $finalResult['CustomerName'] = $getRecorById['Data']['CustomerName'];
            $finalResult['CustomerMobile'] = $getRecorById['Data']['CustomerMobile'];
            $finalResult['CustomerEmail'] = $getRecorById['Data']['CustomerEmail'];
            $finalResult['TransactionDate'] = $getRecorById['Data']['InvoiceTransactions'][0]['TransactionDate'];
            $finalResult['PaymentGateway'] = $getRecorById['Data']['InvoiceTransactions'][0]['PaymentGateway'];
            $finalResult['ReferenceId'] = $getRecorById['Data']['InvoiceTransactions'][0]['ReferenceId'];
            $finalResult['TrackId'] = $getRecorById['Data']['InvoiceTransactions'][0]['TrackId'];
            $finalResult['TransactionId'] = $getRecorById['Data']['InvoiceTransactions'][0]['TransactionId'];
            $finalResult['PaymentId'] = $getRecorById['Data']['InvoiceTransactions'][0]['PaymentId'];
            $finalResult['AuthorizationId'] = $getRecorById['Data']['InvoiceTransactions'][0]['AuthorizationId'];
            $finalResult['PaidCurrency'] = $getRecorById['Data']['InvoiceTransactions'][0]['PaidCurrency'];
            $finalResult['PaidCurrencyValue'] = $getRecorById['Data']['InvoiceTransactions'][0]['PaidCurrencyValue'];
            $finalResult['TransationValue'] = $getRecorById['Data']['InvoiceTransactions'][0]['TransationValue'];
            $finalResult['CustomerServiceCharge'] = $getRecorById['Data']['InvoiceTransactions'][0]['CustomerServiceCharge'];
            $finalResult['DueValue'] = $getRecorById['Data']['InvoiceTransactions'][0]['DueValue'];
            $finalResult['Currency'] = $getRecorById['Data']['InvoiceTransactions'][0]['Currency'];
            $finalResult['ApiCustomFileds'] = $getRecorById['Data']['UserDefinedField'];
            $finalResult['PackageName'] = $getRecorById['Data']['InvoiceItems'][0]['ItemName'];


            // return $finalResult;
            $package_info = explode(',',$finalResult['ApiCustomFileds']);

            DB::table('employee_packages')->where('user_id' , Auth::user()->id)->update(array(
                'status' => 0,
            ));

            DB::table('employee_packages')->insert(array(

                'user_id' => Auth::user()->id,
                'package_id' => $package_info[0],
                'country_name' => auth()->user()->country_name,

                'payment_id' => $finalResult['TransactionId'],
                'invoice_id' => $finalResult['InvoiceId'],
                'order_id' => $finalResult['OrderId'],
                'authorization_id' => $finalResult['AuthorizationId'],

                'package_name' => $finalResult['PackageName'],
                'currency' => $finalResult['Currency'],
                'amount_paid' => $finalResult['DueValue'],
                'payment_gateway' => $finalResult['PaymentGateway'],

                'customer_name' => $finalResult['CustomerName'],
                'customer_email' => $finalResult['CustomerEmail'],
                'customer_phone' => $finalResult['CustomerMobile'],

                'jobs_limit' => $package_info[1],
                'cv_limit' => $package_info[2],

            ));

            $finalResult = DB::table('employee_packages')
            ->where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->first();

            return view('employer.pages.payment.success', compact('finalResult'));

        }
        else{
            return redirect()->route('purchase')->with('error', 'Error after paying.');
        }


    }

    public function invoice($id)
    {
        $invoiceId = decrypt($id);
        $invoices = DB::table('employee_packages')->find($invoiceId);

        if($invoices->user_id != Auth::user()->id){
            return redirect()->back()->with('error', 'Something Went Wrong.');
        }

        return view('employer.pages.invoice.invoice', compact('invoices'));
    }

    public function getcountryCities(Request $request){
        $country = DB::table('countries')->find($request->country_id);
        
        if(empty($country))
            return response()->json(['status' => 0]);

        $cities = DB::table('cities')->where('country_id', $country->id)->get();

        if(count($cities) == 0)
            return response()->json(['status' => 0]);

        return response()->json(['status' => 1, 'cities' => $cities]);
    }

}
