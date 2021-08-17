<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('candidates.pages.profile.profile');
    }

    public function saveProfile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'string|max:255|required',
            'phoneNo' => 'required',
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

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

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

        if($request->has('match_cv')){
            $matchCv = 1;
        }
        else{
            $matchCv = 0;
        }

        if($request->has('account_active')){
            $accountActive = 1;
        }
        else{
            $accountActive = 0;
        }

        DB::table('users')->where('id', Auth::user()->id)->update(array(
            'name' => $request->input(['name']),
            'phoneNo' => $request->input(['phoneNo']),
            'phoneNo2' => $request->input(['phoneNo2']),
            'companyPhoneNo' => $request->input(['companyPhoneNo']),
            'match_cv' => $matchCv,
            'account_active' => $accountActive,
        ));

        if ($request->input('new_password') != null || $request->input('new_password') != '')
        {
            DB::table('users')->where('id', Auth::user()->id)->update([
                'password' =>  Hash::make($request->input('new_password'))
            ]);
        }

        return redirect()->route('candidateDashboard')->with('success', 'Profile Edited successfully');
    }

}
