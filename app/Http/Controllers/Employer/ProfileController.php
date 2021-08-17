<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile()
    {
        $countries = DB::table('countries')->get();
        $categories = DB::table('employee_bussiness_categories')->get();

        return view('employer.pages.profile.profile', compact('countries','categories'));
    }

    public function saveProfile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'string|max:255|required',
            'companyname' => 'string|max:255|required',
            'address' => 'string|max:255|nullable',
            'phoneNo' => 'required',
            'companyWebAddress' => 'string|max:255|nullable',
            'category' => 'required',
            'aboutus' => 'required|string|between: 10,255',
            'new_password' => 'string|min:6|nullable|confirmed',
        ]);

        if ($request->current_password != ''){
            if (!(Hash::check($request->get('current_password'), Auth::user()->getAuthPassword())))
            {
                return redirect()->back()->with('error', 'Current password not matched');
            }
        }
        if ($request->new_password != ''){
            if (strcmp($request->get('current_password'),$request->get('new_password'))==0)
            {
                return redirect()->back()->with('error', 'Your current password cannot be same to new password');

            }
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();

        }

        $categories  = implode(',',$request->category);


        if( $request->hasFile('profile_avatar')) {
            $image = $request->file('profile_avatar');
            $path = public_path(). '/images/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);
            $avatar  = $filename;

            DB::table('users')->where('id', Auth::user()->id)->update(array(
                'avatar' => $avatar,
            ));
        }

        DB::table('users')->where('id', Auth::user()->id)->update(array(
            'name' => $request->input(['name']),
            'companyname' => $request->input(['companyname']),
            'address' => $request->input(['address']),
            'phoneNo' => $request->input(['phoneNo']),
            'phoneNo2' => $request->input(['phoneNo2']),
            'companyPhoneNo' => $request->input(['companyPhoneNo']),
            'companyWebAddress' => $request->input(['companyWebAddress']),
            'category' => $categories,
            'aboutus' => $request->input(['aboutus']),
            'twitter' => $request->input(['twitter']),
            'linkedin' => $request->input(['linkedin']),
            'instagram' => $request->input(['instagram']),
        ));

        if ($request->input('new_password') != null || $request->input('new_password') != '')
        {
            DB::table('users')->where('id', Auth::user()->id)->update([
               'password' =>  Hash::make($request->input('new_password'))
            ]);
        }

        return redirect()->route('employerDashboard')->with('success', 'Profile Edited successfully');
    }
}
