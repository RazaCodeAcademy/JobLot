<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function listUsers()
    {
        $users= DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->select('users.id','users.name','model_has_roles.role_id','users.email','users.created_at','users.updated_at')
        ->whereIn('model_has_roles.role_id', ['2','3','4'])
        ->orderBy('users.id', 'desc')
        ->get();

        return view('backend.pages.user.list', compact('users'));
    }

    public function createUser()
    {
        $countries = DB::table('countries')->get();

        return view('backend.pages.user.create',compact('countries'));
    }

    public function storeUser(Request $request)
    {
        $rules = [
            'Username' => 'required|string|max:255',
            'accountTypeUser' => 'required',
            'country_name' => 'required',
            'UserEmail' => 'required|unique:users,email',
            'user_password' => 'required|confirmed|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userid =  User::create([
            'name' => $request['Username'],
            'email' => $request['UserEmail'],
            'password' => Hash::make($request['user_password']),
            'agreement' => 1,
            'country_name' => $request['country_name'],
        ]);

        if($request->accountTypeUser == 'Employer')
        {
            $data1=array('role_id'=>'2',"model_type"=>'App\Models\User',"model_id"=>$userid->id);
            DB::table('model_has_roles')->insert($data1);
        }

        elseif($request->accountTypeUser == 'Candidate')
        {
            $data1=array('role_id'=>'3',"model_type"=>'App\Models\User',"model_id"=>$userid->id);
            DB::table('model_has_roles')->insert($data1);

            DB::table('candidate_abouts')->insert([
                'user_id' => $userid->id
            ]);

            DB::table('candidate_personal_informations')->insert([
                'user_id' => $userid->id
            ]);
        }

        elseif($request->accountTypeUser == 'Admin')
        {
            $data1 = array('role_id'=>'4',"model_type"=>'App\Models\User',"model_id"=>$userid->id);
            DB::table('model_has_roles')->insert($data1);
        }

        return redirect()->route('listUsers')->with('success', 'Record Added Successfully.');
    }

    public function editUser($id)
    {
        $user = DB::table('users')->where('users.id', $id)
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->select('users.id','users.name', 'users.free_jobs', 'model_has_roles.role_id','users.email','users.country_name','users.created_at','users.updated_at')
        ->whereIn('model_has_roles.role_id', ['2','3','4'])
        ->first();

        $countries = DB::table('countries')->get();

        if($user == null)
        {
            return redirect()->route('listUsers')->with('error', 'No Record Found.');
        }

        return view('backend.pages.user.edit', compact('user','countries'));
    }

    public function updateUser(Request $request)
    {
        $user = DB::table('users')->where('id', $request->id)->first();

        if($user == null)
        {
            return redirect()->route('listUsers')->with('error', 'No Record Found.');
        }

        $user_type = DB::table('model_has_roles')->where('model_id',$user->id)->first();

        if ($user_type->role_id == 2){

            $user_role_id = DB::table('model_has_roles')->where('model_id', auth()->user()->id)->first();
			$myRole = DB::table('roles')->where('id', $user_role_id->role_id)->first();

            $rules = [
                'Username' => 'required|string|max:255'
            ];

            if($myRole->id == 1){
                $rules['free_jobs'] = 'integer';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::table('users')->where('id', $request->id)->update([
                'name' => $request->Username,
                'name' => $request->Username,
                'phoneNo' => $request->phoneNo,
                'phoneNo2' => $request->phoneNo2,
                'companyPhoneNo' => $request->companyPhoneNo,
            ]);

            $user_role_id = DB::table('model_has_roles')->where('model_id', auth()->user()->id)->first();
			$myRole = DB::table('roles')->where('id', $user_role_id->role_id)->first();

            if($myRole->id == 1){
                DB::table('users')->where('id', $request->id)->update([
                    'free_jobs' => $request->free_jobs,
                ]);
            }

            if($request->hasFile('profile_avatar')) {
                $image = $request->file('profile_avatar');
                $path = public_path(). '/images/';
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);
                $avatar  = $filename;


                DB::table('users')->where('id', $request->id)->update(array(
                    'avatar' => $avatar,
                ));
            }

            return redirect()->route('listUsers')->with('success','Record Successfully Updated');
        }

        elseif ($user_type->role_id == 3){
            $rules = [
                'Username' => 'required|string|max:255'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::table('users')->where('id', $request->id)->update([
                'name' => $request->Username,
                'phoneNo' => $request->phoneNo,
                'phoneNo2' => $request->phoneNo2,
                'companyPhoneNo' => $request->companyPhoneNo
            ]);

            if($request->hasFile('profile_avatar')) {
                $image = $request->file('profile_avatar');
                $path = public_path(). '/images/';
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);
                $avatar  = $filename;


                DB::table('users')->where('id', $request->id)->update(array(
                    'avatar' => $avatar,
                ));
            }

            return redirect()->route('listUsers')->with('success','Record Successfully Updated');
        }

        elseif ($user_type->role_id == 4){
            $rules = [
                'country_name' => 'required',
                'Username' => 'required|string|max:255'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::table('users')->where('id', $request->id)->update([
                'name' => $request->Username,
                'country_name' => $request->country_name
            ]);
            return redirect()->route('listUsers')->with('success','Record Successfully Updated');
        }

        return redirect()->route('listUsers')->with('success','Record Successfully Updated');

    }

    public function deleteUser(Request $request){
        $user = DB::table('users')->where('id',$request->id)->first();

        if(empty($user)) {
            return response()->json(['status' => 0]);
        }

        DB::table('users')->where('id',$request->id)->delete();
        DB::table('model_has_roles')->where('model_id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }

    public function viewUser($id)
    {
        $userRole= DB::table('users')->where('users.id', $id)
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->select('users.id','users.name','model_has_roles.role_id','users.email','users.created_at','users.updated_at')
        ->whereIn('model_has_roles.role_id', ['2','3','4'])
        ->first();

        if($userRole->role_id == 2){
            $user= DB::table('users')->where('users.id', $id)
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->select('users.id','users.name','model_has_roles.role_id','users.email','users.avatar', 'users.phoneNo','users.phoneNo2','users.companyPhoneNo' ,'users.created_at','users.updated_at', 'users.country_name', 'users.free_jobs')
            ->whereIn('model_has_roles.role_id', ['2','3'])
            ->first();
        }

        if($userRole->role_id == 3){
            $user= DB::table('users')->where('users.id', $id)
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('candidate_profiles', 'users.id', '=', 'candidate_profiles.user_id')
            ->join('candidate_abouts', 'users.id', '=', 'candidate_abouts.user_id')
            ->select('users.id','users.name','model_has_roles.role_id','users.email','users.created_at','users.updated_at','users.avatar','users.phoneNo','users.phoneNo2','users.companyPhoneNo','candidate_abouts.location','users.country_name')
            ->whereIn('model_has_roles.role_id', ['2','3'])
            ->first();
        }

        if($userRole->role_id == 4){
            $user= DB::table('users')->where('users.id', $id)
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->select('users.id','users.name','model_has_roles.role_id','users.email','users.country_name','users.created_at','users.updated_at')
                ->whereIn('model_has_roles.role_id', ['4'])
                ->first();
        }

        // return $user;

        if($user == null)
        {
            return redirect()->route('listUsers')->with('error', 'No Record Found.');
        }

        return view('backend.pages.user.view', compact('user'));
    }
}
