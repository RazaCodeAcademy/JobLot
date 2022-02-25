<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployerRegistrationController extends Controller
{
    public function registerView(Request $request)
    {
        // session()->forget('sessionData');
        $countries = DB::table('countries')->get();
        $fields = DB::table('employee_bussiness_categories')->get();

        return view('employer.pages.registration.registration',
            compact('fields','countries'));
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

    public function companyCheck(Request $request)
    {
        $all_users = DB::table('users')
            ->join('model_has_roles', 'users.id','=','model_has_roles.model_id')
            ->select('users.name','users.country_name')
            ->where('model_has_roles.role_id', '=' ,2)
//            ->where('users.id', '!=' , Auth::user()->id)
            ->where('users.id', '!=' ,1)
            ->get();
//dd($request->name . ' '. $request->country_name);
dd($request->all());
        foreach ($all_users as $all_user)
        {
            if($request->name === $all_user->name && $request->country_name === $all_user->country_name)
            {
//                return redirect()->back()->with('error', 'Company name already present in our records for selected country');
                $isAvailable = false;
                return response()->json(['valid' => $isAvailable]);
            }
        }

        $isAvailable = true;
        return response()->json(['valid' => $isAvailable]);
    }

    public function employerData(Request $request)
    {
        $countryName = DB::table('countries')->where('id', $request->country_name)->first();

        if ($request->category != null){

             $category = DB::table('employee_bussiness_categories')->whereIn('id', $request->category)->get();
        }
        else{
            $category = array();
        }

        $all_users = DB::table('users')
            ->join('model_has_roles', 'users.id','=','model_has_roles.model_id')
            ->select('users.name','users.country_name')
            ->where('model_has_roles.role_id', '=' ,2)
            ->where('users.id', '!=' ,1)
            ->get();

        foreach ($all_users as $all_user)
        {
            if($request->name === $all_user->name && $request->country_name === $all_user->country_name)
            {
                return response()->json(['status' => 0]);
            }
        }

        $data = array();

        $data['email'] = $request->email;
        $data['avatar'] = $request->profile_avatar;

        $data['name'] = $request->name;
        $data['phoneNo'] = $request->phoneNo;
        $data['phoneNo2'] = $request->phoneNo2;

        $data['companyPhoneNo'] = $request->companyPhoneNo;
        $data['companyWebAddress'] = $request->companyWebAddress;
        $data['aboutus'] = $request->aboutus;
        if ($countryName == null){
            $data['country_name'] = '';
        }
        else{
            $data['country_name'] = $countryName->name;
        }

        if (count($category) > 0){
            $data['category'] = $category;
            $data['categoryData'] = $request->category;
        }
        else{
            $data['category'] = $category;
        }
        $data['instagramlink'] = $request->instagramlink;
        $data['twitterlink'] = $request->twitterlink;
        $data['linkedinlink'] = $request->linkedinlink;

        session()->put('sessionData', $data);

        return response()->json(['status' => 1]);
    }

    public function store(Request $request)
    {
        $categories = implode(',', session()->get('sessionData')['categoryData']);
        $id =   DB::table('users')->insertGetId([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'phoneNo' => $request['phoneNo'],
            'phoneNo2' => $request['phoneNo2'],
            'companyphoneNo' => $request['companyphoneNo'],
            'companyWebAddress' => $request['companyWebAddress'],
            'aboutus' => $request['aboutus'],
            'country_name' => $request['country_name'],
            'category' => $categories,
            'instagram' => $request['instagramlink'],
            'twitter' => $request['twitterlink'],
            'linkedin' => $request['linkedinlink'],
        ]);

        if( $request->hasFile('profile_avatar')) {
            $image = $request->file('profile_avatar');
            $path = public_path(). '/images/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);
            $avatar  = $filename;

            DB::table('users')->where('id', $id)->update(array(
                'avatar' => $avatar,
            ));
        }

        DB::table('active_users')->insert([
            'user_id' => $id,
            'model_id' => 2,
            'date' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        $data1=array('role_id'=>'2',"model_type"=>'App\Models\User',"model_id"=>$id);
        DB::table('model_has_roles')->insert($data1);
        session()->forget('sessionData');

        return redirect()->route('login')->with('success','Registered successfully login to continue!');

    }
}
