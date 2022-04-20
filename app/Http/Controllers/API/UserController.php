<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Otp;
use App\Models\User;
use App\Models\Job;
use App\Models\EmailOtp;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;
use DB;
use Str;
use Storage;
use Illuminate\Http\File;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request)
    {
        // return $request;
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logout(){
        auth()->user()->token()->revoke();
        return response()->json(['message' => "Logout Successfully"], $this->successStatus);
    }

    protected function authenticated($request, $user){
        if($user->hasRole('Admin')){
            return redirect('/admin/dashboard');
        }else if($user->hasRole('employee')){
            return redirect('/employee/dashboard');
        }else if($user->hasRole('candidate')){
            return redirect('/candidate/dashboard');
        } else {
            return redirect('/');
        }
    }

    public function registerEmployer(Request $request){
        $user = User::where('email', $request->email)
        ->orWhere('phone_number', $request->phone_number)
        ->first();
        if(!empty($user)){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Mobile number or email already exist please try with another email or mobile number!',
                ], 200);
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'street_address' => 'required',
            'city_name' => 'required',
            'state_id' => 'required',
            'zip_code' => 'required',
            'latitude' => 'required', 
            'longitude' => 'required',
            'terms_and_conditions' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
                'comp_name' => 'required',
            'comp_location' => 'required',
            'salary_schedual' => 'required',
            
            
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()->first()], 401);
        }

        $employerData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'street_address' => $request->street_address,
            'city_name' => $request->city_name,
            'state_id' => $request->state_id,
            'zip_code' => $request->zip_code,
            'terms_and_conditions' => $request->terms_and_conditions,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
            'comp_name'=> $request->comp_name,
            'comp_location'=> $request->comp_location,
            'salary_schedual'=> $request->salary_schedual,
            'job_schedual_from'=> date('Y-m-d H:i:s',strtotime($request->job_schedual_from)),
            'job_schedual_to'=> date('Y-m-d H:i:s',strtotime($request->job_schedual_to)),
            
        ];

        $user = User::create($employerData);
        $token =  $user->createToken('MyApp')-> accessToken;

        $data = array('role_id' => '2', "model_type" => 'App\Models\User', "model_id" => $user->id);
        DB::table('model_has_roles')->insert($data);

        if($request->business_cat_id){
            $jobData = [
                'business_cat_id' => $request->business_cat_id,
                'employer_id' => $user->id,
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'salary' => $request->salary,
                'job_type' => $request->job_type,
                'job_qualification' => $request->job_qualification,
                'state_authorized' => $request->state_authorized,
                'description' => $request->description,
                
            ];
            Job::create($jobData);
        }
        if ($user) {
            return response()->json([
                'success' => true,
                'message' =>  'Employer registered successfuly!',
                'token' =>  $token,
            ], 200);
        }
        return response()->json([
            'success' => true,
            'message' =>  'Something went wrong please try again!',
        ], 200);
    }

    public function details(){
        $roles = auth()->user()->roles()->pluck('name');
        $user = Auth::user();
        return response()->json(['success' => $user, $roles[0] ], $this->successStatus);
    }

    public function uploadProfileImage(Request $request){
        // return Auth::Id();

        $user = Auth::user();

         // create directory
        $profileFolder = 'profile';
        if (!Storage::exists($profileFolder)) {
            Storage::makeDirectory($profileFolder);
        }

        // upload file
        if ($request->hasFile('profile_image')) {
            $image = Storage::putFile($profileFolder, new File($request->file('profile_image')));
            $user->profile_image = $image;

            if($user->update()){
                return response()->json([
                    'success' => 'Profile uploaded successfuly!',
                    'user' => $user,
                ], 200);
            }
        }


        return response()->json([
            'error' => 'Something went wrong please try again!',
        ], 401);
    }

    public function getUserInfo(Request $request){
        $user = Auth::user();

        if($request->user_id){
            $user = User::find($request->user_id);
        }

        
        if($user){
            return response()->json([
                'user' => $user,
            ], 200);
        }

        return response()->json([
                'error' => 'Something went wrong please try again!',
            ], 401);
    }

    public function updateUserInfo(Request $request){
        $user = User::find(Auth::id());
        !empty($request->first_name) ? $request->first_name : $user->first_name;
        $employerData = [
            'first_name' => !empty($request->first_name) ? $request->first_name : $user->first_name,
            'last_name' => !empty($request->last_name) ? $request->last_name : $user->last_name,
            'street_address' => !empty($request->street_address) ? $request->street_address : $user->street_address,
            'city_name' => !empty($request->city_name) ? $request->city_name : $user->city_name,
            'state_id' => !empty($request->state_id) ? $request->state_id : $user->state_id,
            'zip_code' => !empty($request->zip_code) ? $request->zip_code : $user->zip_code,
            'latitude' => !empty($request->latitude) ? $request->latitude : $user->latitude,
            'longitude' => !empty($request->longitude) ? $request->longitude : $user->longitude,
            'terms_and_conditions' => !empty($request->terms_and_conditions) ? $request->terms_and_conditions : $user->terms_and_conditions,
            'email' => !empty($request->email) ? $request->email : $user->email,
            'phone_number' => !empty($request->phone_number) ? $request->phone_number : $user->phone_number,
        ];

        $request->password ? array_push($employerData, ['password' => bcrypt($request->password)]) : '';

        if($user->update($employerData)){
            return response()->json([
                'success' => 'User updated successfuly!',
                'user' => $user,
            ], 200);
        }

        return response()->json([
                'error' => 'Something went wrong please try again!',
            ], 401);
    }

    public function register_employee(Request $request)
    {
        
        $user = User::where('email', $request->email)
        ->orWhere('phone_number', $request->phone_number)
        ->first();
        if(!empty($user)){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Mobile number or email already exist please try with another email or mobile number!',
                ], 200);
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'street_address' => 'required',
            'city_name' => 'required',
            'zip_code' => 'required', 
            'latitude' => 'required', 
            'longitude' => 'required', 
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'terms_and_conditions' => 'required',
        ]);

        $employeeData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'street_address' => $request->street_address,
            'city_name' => $request->city_name,
            'state_id' => $request->state_id,
            'zip_code' => $request->zip_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'terms_and_conditions' => $request->terms_and_conditions,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
        ];


        $user = User::create($employeeData);
        $token =  $user->createToken('MyApp')-> accessToken;

        $data = array('role_id' => '3', "model_type" => 'App\Models\User', "model_id" => $user->id);
        DB::table('model_has_roles')->insert($data);

        if ($user) {
            return response()->json([
                'success' => true,
                'message' =>  'Employer registered successfuly!',
                'token' =>  $token,
            ], 200);
        }
        return response()->json([
            'success' => true,
            'message' =>  'Something went wrong please try again!',
        ], 200);

    }

    public function getNotification()
    {
        $notifications = unserialized_notification(user()->get_notification);

        return response()->json([
            'count' => !empty($notifications) ? count($notifications) : 0,
            'notifications' => $notifications,
        ], 200);
    }
    
    public function readNotification(Request $request)
    {
        $id = $request->notification_id;
        $notifications = user()->get_notification;

        if (!empty($id)) {
            // read single notification
            $notification = $notifications->where('id', $id)->first();
            if(!empty($notification)){
                $notification->read_at = date('Y-m-d h:i:s');
                $notification->update();
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Notification not read successfuly!',
                ], 400);
            }
        }else{
            // read all notifications
            foreach ($notifications as $key => $value) {
                $value->read_at = date('Y-m-d h:i:s');
                $value->update();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Notification read successfuly!',
        ], 200);
    }

    public function removeNotification(Request $request)
    {
        $id = $request->notification_id;
       
        // remove single notification
        $notification = user()->get_notification->where('id', $id)->first();
        if(!empty($notification)){
            $notification->delete();
            return response()->json([
                'success' => true,
                'message' => 'Notification removed successfuly!',
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong please try again!',
            ], 400);
        }

    }

    public function sendOTP(Request $request)
    {
        $email = User::select('email')->where('email', $request->email)->first();
        if (!empty($email)) {
            $otpCode = rand(1000, 9999);
            $otp = EmailOtp::updateOrCreate(
                ['email' => $request->email],
                ['otp' => $otpCode],
            );
            if($otp){
                Mail::to($request->email)->send(new Otp($otpCode));
                return response()->json([
                    'success' => true,
                    'message' => 'Otp sent to your email please verify with your otp!',
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong with the email please try again!',
            ], 400);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Email does not exist in our record!',
            ], 400);
        }
    }

    public function verifyOTP(Request $request)
    {
        $otpCode = EmailOtp::where([
            ['email', $request->email],
            ['otp', $request->otp],
        ])->first();
        if($otpCode){
            EmailOtp::where('email', $request->email)->first()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Otp matched successfuly!',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Otp does not matched successfuly!',
        ], 400);
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            if($request->password == $request->confirm_password){
                $user->password = bcrypt($request->password);
                $user->update();
                return response()->json([
                    'success' => true,
                    'message' => 'Password reset successfuly!',
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => 'Password does not match with confirmation please try again!',
            ], 400);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Email does not exist in our record!',
            ], 400);
        }
    }
}