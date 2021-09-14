<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NewUser;
use App\Models\NewJob;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;
use DB;
use Storage;
use Illuminate\Http\File;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request)
    {
        // return $request;
        if(Auth::guard('web')->attempt(['email' => request('email'), 'password' => request('password')])){
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
        try{
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'business_name' => 'required',
                'city_name' => 'required',
                'state_id' => 'required',
                'zip_code' => 'required',
                'terms_and_conditions' => 'required',
                'email' => 'required|email|unique:new_users',
                'phone_number' => 'required|unique:new_users',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()->first()], 401);
            }

            $employerData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'business_name' => $request->business_name,
                'city_name' => $request->city_name,
                'state_id' => $request->state_id,
                'zip_code' => $request->zip_code,
                'terms_and_conditions' => $request->terms_and_conditions,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => bcrypt($request->password),
            ];

            // return NewUser::all();

            $user = NewUser::create($employerData);
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['name'] =  $user->first_name.' '.$user->last_name;

            $userid = DB::table('new_users')->orderBy('id', 'DESC')->first();

            $data1 = array('role_id' => '2', "model_type" => 'Vtlabs\Core\Models\User\User', "model_id" => $user1->id);
            DB::table('model_has_roles')->insert($data1);

            if($request->business_cat_id){
                $jobData = [
                    'business_cat_id' => $request->business_cat_id,
                    'employer_id' => $userid->id,
                    'business_name' => $request->business_name,
                    'title' => $request->title,
                    'salary' => $request->salary,
                    'job_type' => $request->job_type,
                    'job_qualification' => $request->job_qualification,
                    'state_authorized' => $request->state_authorized,
                    'description' => $request->description,
                ];
                NewJob::create($jobData);
            }

            return response()->json(['success' => $success], $this->successStatus);
        }
        catch(Exception $exception){
            return response()->json(['error' => 'The Email Address Already Exists.'], 401);
        }
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
        $categoryFolder = 'profile';
        if (!Storage::exists($categoryFolder)) {
            Storage::makeDirectory($categoryFolder);
        }

        // upload file
        if ($request->hasFile('profile_image')) {
            $image = Storage::putFile($categoryFolder, new File($request->file('profile_image')));
            $user->profile_image = $image;
        }

        if($user->update()){
            return response()->json([
                'success' => 'Profile uploaded successfuly!',
                'user' => $user,
            ], 200);
        }

        return response()->json([
            'success' => 'Something went wrong please try again!',
        ], 401);
    }

}