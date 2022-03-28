<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use beinmedia\payment\Parameters\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use App\Models\User;
use Carbon\Carbon;
class UserController extends Controller
{
    public function create()
    {
       return view('frontend.pages.register');
    }

    public function store(Request $request){
        $rules = array(
            'first_name'=> 'required',
            'last_name'=> 'required',
            'dob'=> 'required',
            'phone_number'=> 'required',
            'zip_code'=> 'required',
            'email' => 'required|email',
            'password' => 'required',
            'street_address' => 'required',
            'terms_and_conditions'=> 'required',
        );

      $validator = Validator::make($request->all() , $rules);

        if ($validator->fails())
        {
            return \redirect()->route('register')->withErrors($validator)->withInput();
        }  

        $userCount = User::where('email', $request->email)->count();
        if ($userCount > 0){
            // dd( $userCount);
            $notification = array(
                'error' => 'Email Already Exists!', 
                );
            return redirect()->back()->with($notification);
        }
        else{
        $user=new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->zip_code = $request->zip_code;
        $user->dob = $request->dob;
        $user->street_address = $request->street_address;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();
        }
        $notification = array(
        'success' => 'User Register Successfully!', 
        );
        $data = array('role_id' => '3', "model_type" => 'App\Models\User', "model_id" => $user->id);
        DB::table('model_has_roles')->insert($data);
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

            return redirect()->route('dashboard')->with($notification);
        }
          
    }

    public function login()
    {
       
        if(Auth::check()){

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
                return redirect()->route('dashboard');
            }
        }
        return view('frontend.pages.login');
    }

    public function loginuser(Request $request){
        $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );

      $validator = Validator::make($request->all() , $rules);

          if ($validator->fails())
          {
              return \redirect()->route('login')->withErrors($validator)->withInput();
          }
          else
            {
                $userdata = array(
                    'email' => $request->email,
                    'password' => $request->password,
                );

            if (Auth::attempt($userdata))
            {   
                Auth::user()->last_login = Carbon::now()->toDateTimeString();
                Auth::user()->update();
                    if (Auth::user()->hasRole('admin'))
                    {
                        
                        $notification = array(
                            'success' => 'Login Successfully!', 
                            );
                        return redirect()->route('adminDashboard')->with($notification);
                    }
                    elseif (Auth::user()->hasRole('employer'))
                    {
                        
                        return redirect()->route('employerDashboard')->with($notification);
                    }
                    elseif (Auth::user()->hasRole('employee'))
                    {   
                        $notification = array(
                            'success' => 'Login Successfully!', 
                            );
                        return redirect()->route('dashboard')->with($notification);
                    }
                }
                else
                {
                    $notification = array(
                        'error' => 'These Credentailas does not match to your recodes!', 
                        );
                    return \redirect()->route('login')->with($notification);
                }
        }
    }

    public function logout()
    {
        Auth::user()->last_login = Carbon::now()->toDateTimeString();
        Auth::user()->update();
        Auth::logout();
        $notification = array(
            'success' => 'logout Successfully!', 
            );
        return redirect()->route('login')->with($notification);
    }

}
