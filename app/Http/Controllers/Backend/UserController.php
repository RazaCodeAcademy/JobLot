<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Country;
use App\Models\ModelHasRole;
use App\Models\EmployeePersonalInformation;
use App\Models\Role;
use App\Models\City;
use App\Models\State;


class UserController extends Controller
{
    public function listAdmins()
    {
        $users= User::whereHas(
            'roles', function($q){
                $q->where('role_id', '1');
            })->orderby('created_at','desc')->get();
       
        return view('backend.pages.user.list', compact('users'));
    }
    public function listEmployers()
    {
        $users= User::whereHas(
            'roles', function($q){
                $q->where('role_id', '2');
            })->orderby('created_at','desc')->get();
       
        return view('backend.pages.user.list', compact('users'));
    }

    public function createUser()
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        return view('backend.pages.user.create',compact('countries','cities','states'));
    }

    public function storeUser(Request $request)
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'accountTypeUser' => 'required',
            'state_id' => 'required',
            'UserEmail' => 'required|unique:users,email',
            'user_password' => 'required|confirmed|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userid =  User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'street_address' => $request['street_address'],
            'city_name' => $request['city_name'],
            
            'state_id' => $request['state_id'],
            'zip_code' => $request['zip_code'],
            'email' => $request['UserEmail'],
            'phone_number' => $request['phone_number'],
            'password' => Hash::make($request['user_password']),
            'terms_and_conditions' => 1,
            // 'country_name' => $request['country_name'],
        ]);

        if($request->accountTypeUser == 'Employer')
        {
            $data1=array('role_id'=>'2',"model_type"=>'App\Models\User',"model_id"=>$userid->id);
            ModelHasRole::insert($data1);
        }

        elseif($request->accountTypeUser == 'Employee')
        {
            $data1=array('role_id'=>'3',"model_type"=>'App\Models\User',"model_id"=>$userid->id);
            ModelHasRole::insert($data1);

            // DB::table('candidate_abouts')->insert([
            //     'user_id' => $userid->id
            // ]);

            EmployeePersonalInformation::insert([
                'user_id' => $userid->id
            ]);
        }

        elseif($request->accountTypeUser == 'Admin')
        {
            $data1 = array('role_id'=>'1',"model_type"=>'App\Models\User',"model_id"=>$userid->id);
            ModelHasRole::insert($data1);
        }

        return redirect()->route('listUsers')->with('success', 'Record Added Successfully.');
    }

    public function editUser($id)
    {
        $user = User::find($id);

        $countries = Country::all();
        $cities = City::all();

        if($user == null)
        {
            return redirect()->route('listUsers')->with('error', 'No Record Found.');
        }

        return view('backend.pages.user.edit', compact('user','countries','cities'));
    }

    public function updateUser(Request $request,$id)
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'state_id' => 'required',
            'UserEmail' => 'required|unique:users,email',
        ];

        $user =User::find($id);

        if($user == null)
        {
            return redirect()->route('listUsers')->with('error', 'No Record Found.');
        }

        $user_type = ModelHasRole::where('model_id',$user->id)->first();

        if ($user_type->role_id == 2){
                
            $user_role_id = ModelHasRole::where('model_id', Auth::user()->id)->first();
			$myRole = Role::where('id', $user_role_id->role_id)->first();

            $rules = [
                'first_name' => 'required|string|max:255',
                
                
                'phone_number' => 'required',
            ];
           

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            User::find($id)->update([
                'first_name' => $request->first_name,
       
                'phone_number' => $request->phone_number,
                
            ]);

            $user_role_id = ModelHasRole::where('model_id', auth()->user()->id)->first();
			$myRole = Role::where('id', $user_role_id->role_id)->first();

            
            if($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $path = public_path(). '/images/';
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);
                $avatar  = $filename;


                User::find($id)->update(array(
                    'avatar' => $avatar,
                ));
            }

            return redirect()->route('listUsers')->with('success','Record Successfully Updated');
        }

        elseif ($user_type->role_id == 3){
            $rules = [
                'first_name' => 'required|string|max:255',
                
                 'state_id' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

           User::find($id)->update([
                'name' => $request->Username,
                'phoneNo' => $request->phone_number,
                
            ]);

            if($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $path = public_path(). '/images/';
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);
                $avatar  = $filename;


               User::find($id)->update(array(
                    'avatar' => $avatar,
                ));
            }

            return redirect()->route('listUsers')->with('success','Record Successfully Updated');
        }

        elseif ($user_type->role_id == 1){
            $rules = [
                'first_name' => 'required|string|max:255',
                'state_id' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

             User::find($id)->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'street_address' => $request['street_address'],
            'city_name' => $request['city_name'],
            
            'state_id' => $request['state_id'],
            'zip_code' => $request['zip_code'],
            'email' => $request['UserEmail'],
            'phone_number' => $request['phone_number'],
            ]);
            return redirect()->route('listUsers')->with('success','Record Successfully Updated');
        }

        return redirect()->route('listUsers')->with('success','Record Successfully Updated');

    }

    public function deleteUser(Request $request){
        $user =User::where('id',$request->id)->first();

        if(empty($user)) {
            return response()->json(['status' => 0]);
        }

       User::where('id',$request->id)->delete();
       ModelHasRole::where('model_id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }

    public function viewUser($id)
    {
        $user = User::where('id', $id)
        ->whereHas(
            'roles', function($q){
                $q->where('name', 'admin')->orwhere('name', 'employer')->orwhere('name','employee');
            })->orderby('created_at','desc')->first();

        if($user == null)
        {
            return redirect()->route('listUsers')->with('error', 'No Record Found.');
        }

        return view('backend.pages.user.view', compact('user'));
    }
}
