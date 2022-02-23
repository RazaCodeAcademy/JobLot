<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use App\Models\User;

class AuthController extends Controller
{
    public function login(){
        if(auth()->check()){
            if (Auth::user()->hasRole('Admin'))
            {
                return redirect()->route('adminDashboard');
            }
            elseif (Auth::user()->hasRole('Employer'))
            {
                $activeUser =  DB::table('active_users')->where('user_id',  Auth::user()->id)->first();
                if (isset($activeUser))
                {
                    DB::table('active_users')->where('user_id', $activeUser->user_id)->update([
                        'date' => DB::raw('CURRENT_TIMESTAMP')
                    ]);
                }
                else
                {
                    DB::table('active_users')->insert([
                        'user_id' => Auth::user()->id,
                        'model_id' => 2,
                        'date' => DB::raw('CURRENT_TIMESTAMP')
                    ]);
                }
                return redirect()->route('employerDashboard');
            }
            elseif (Auth::user()->hasRole('Candidate'))
            {
                $activeUser =  DB::table('active_users')->where('user_id',  Auth::user()->id)->first();

                if (isset($activeUser))
                {
                    DB::table('active_users')->where('user_id', $activeUser->user_id)->update([
                        'date' => DB::raw('CURRENT_TIMESTAMP')
                    ]);
                }
                else
                {
                    DB::table('active_users')->insert([
                        'user_id' => Auth::user()->id,
                        'model_id' => 3,
                        'date' => DB::raw('CURRENT_TIMESTAMP')
                    ]);
                }
                return redirect()->route('candidateDashboard');
            }
            elseif (Auth::user()->hasRole('Sub Admin'))
            {
                return redirect()->route('subAdminDashboard');
            }
        }

        return view('backend.pages.auth.login');
    }

    public function loginPost(Request $request)
    {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );

        $validator = Validator::make($request->all() , $rules);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else
        {
            $userdata = array(
                'email' => $request->email,
                'password' => $request->password,
            );
            
           
            if (Auth::attempt($userdata))
            { 
                // dd(Auth::user()->hasRole('admin'));
                if (Auth::user()->hasRole('admin'))
                {
                   
                    return redirect()->route('adminDashboard');
                }
                elseif (Auth::user()->hasRole('employer'))
                { 
                    return redirect()->route('employerDashboard');
                   
                }
                elseif (Auth::user()->hasRole('employee'))
                {
                    return redirect()->route('candidateDashboard');
                }
            
            }
            else
            {
                
                return redirect()->back()->withInput()->with('warning','These credentials do not match our records.');
            }
        }
    }

    public function adminUpdateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if($user == null)
        {
            return redirect()->route('adminDashboard')->with('error', 'No Record Found.');
        }
        $rules = [
            'name' => 'required|string|max:255',
            'new_password' => 'string|min:6|nullable|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'name'=> $request->input('name'),
        ];

        $user->update($data);

        if ($request->new_password != '')
        {
            if (!(Hash::check($request->get('current_password'), Auth::user()->getAuthPassword())))
            {
                return redirect()->back()->with('error',' Current password not matched');
            }
            if (strcmp($request->get('current_password'),$request->get('new_password')) == 0)
            {
                return redirect()->back()->with('error','Your current password cannot be same to new password');
            }
            $data = [
                'password'=> Hash::make($request->input('new_password'))
            ];

            $user->update($data);
        }

        return redirect()->route('adminDashboard')->with('success', 'Updated Successfully');

    }

    public function subAdminUpdateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if($user == null)
        {
            return redirect()->route('subAdminDashboard')->with('error', 'No Record Found.');
        }
        $rules = [
            'name' => 'required|string|max:255',
            'new_password' => 'string|min:6|nullable|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'name'=> $request->input('name'),
        ];

        $user->update($data);

        if ($request->new_password != '')
        {
            if (!(Hash::check($request->get('current_password'), Auth::user()->getAuthPassword())))
            {
                return redirect()->back()->with('error',' Current password not matched');
            }
            if (strcmp($request->get('current_password'),$request->get('new_password')) == 0)
            {
                return redirect()->back()->with('error','Your current password cannot be same to new password');
            }
            $data = [
                'password'=> Hash::make($request->input('new_password'))
            ];

            $user->update($data);
        }

        return redirect()->route('subAdminDashboard')->with('success', 'Updated Successfully');

    }
}
