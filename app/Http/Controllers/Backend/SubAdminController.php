<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubAdminController extends Controller
{
    public function dashboard()
    {
        $user = DB::table('users')->where('id', Auth::user()->id)->first();

        $liveJobs = DB::table('jobs')->where('job_location', $user->country_name)->where('status','=',1)->where('approval_status','=',1)->count();
        $liveAppliedCandidateJobs = DB::table('candidate_applied_jobs')
            ->join('jobs','candidate_applied_jobs.job_id','=','jobs.id')
            ->where('jobs.job_location','=',$user->country_name)
            ->count();
        $employers = DB::table('model_has_roles')
            ->join('users','model_has_roles.model_id','=','users.id')
            ->select('model_id')
            ->where('model_has_roles.role_id','=',2)
            ->where('users.country_name',$user->country_name)
            ->get();
        $candidates = DB::table('model_has_roles')
            ->join('users','model_has_roles.model_id','=','users.id')
            ->select('model_id')
            ->where('model_has_roles.role_id','=',3)
            ->where('users.country_name',$user->country_name)
            ->get();

        $date = \Carbon\Carbon::today()->subDays(5);
        $jobs = DB::table('jobs')->where('job_location', $user->country_name)->where('created_at','>=',$date)->get();

        return view('backend.pages.dashboard.dashboard',compact('liveJobs','liveAppliedCandidateJobs','employers','candidates','jobs'));
    }

    public function listUsers()
    {
        $users= DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->select('users.id','users.name','model_has_roles.role_id','users.email','users.created_at','users.updated_at')
            ->whereIn('model_has_roles.role_id', ['2','3'])
            ->where('users.country_name', Auth::user()->country_name)
            ->orderBy('users.id', 'desc')
            ->get();

        return view('backend.pages.user.list', compact('users'));
    }

    public function createUser()
    {
        return view('backend.pages.user.create');
    }

    public function storeUser(Request $request)
    {
        $rules = [
            'Username' => 'required|string|max:255',
            'accountTypeUser' => 'required',
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
            'country_name' => Auth::user()->country_name,
            'agreement' => 1,
        ]);

        if($request->accountTypeUser == 'Employer')
        {
            $data1=array('role_id'=>'2',"model_type"=>'App\User',"model_id"=>$userid->id);
            DB::table('model_has_roles')->insert($data1);
        }

        elseif($request->accountTypeUser == 'Candidate')
        {
            $data1=array('role_id'=>'3',"model_type"=>'App\User',"model_id"=>$userid->id);
            DB::table('model_has_roles')->insert($data1);
        }

        return redirect()->route('subAdminListUsers')->with('success', 'Record Added Successfully.');
    }

    public function editUser($id)
    {
        $user = DB::table('users')->where('users.id', $id)
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->select('users.id','users.name','model_has_roles.role_id','users.email','users.country_name','users.created_at','users.updated_at')
            ->whereIn('model_has_roles.role_id', ['2','3'])
            ->first();

        if($user == null)
        {
            return redirect()->route('subAdminListUsers')->with('error', 'No Record Found.');
        }

        return view('backend.pages.user.edit', compact('user'));
    }

    public function updateUser(Request $request)
    {
        $user = DB::table('users')->where('id', $request->id)->first();

        if($user == null)
        {
            return redirect()->route('subAdminListUsers')->with('error', 'No Record Found.');
        }

        $user_type = DB::table('model_has_roles')->where('model_id',$user->id)->first();

        if ($user_type->role_id == 2)
        {
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

            return redirect()->route('subAdminListUsers')->with('success','Record Successfully Updated');
        }

        elseif ($user_type->role_id == 3)
        {
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

            return redirect()->route('subAdminListUsers')->with('success','Record Successfully Updated');
        }

        return redirect()->route('subAdminListUsers')->with('success','Record Successfully Updated');

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
            ->whereIn('model_has_roles.role_id', ['2','3'])
            ->first();

        if($userRole->role_id == 2){
            $user= DB::table('users')->where('users.id', $id)
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->select('users.id','users.name','model_has_roles.role_id','users.email','users.created_at','users.updated_at','users.avatar','users.phoneNo','users.phoneNo2','users.companyPhoneNo','users.country_name')
                ->whereIn('model_has_roles.role_id', ['2','3'])
                ->first();
        }

        if($userRole->role_id == 3){
            $user= DB::table('users')->where('users.id', $id)
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('candidate_profiles', 'users.id', '=', 'candidate_profiles.user_id')
                ->join('candidate_abouts', 'users.id', '=', 'candidate_abouts.user_id')
                ->select('users.id','users.name','model_has_roles.role_id','users.email','users.created_at','users.updated_at','users.avatar','users.phoneNo','users.phoneNo2','users.companyPhoneNo','users.country_name')
                ->whereIn('model_has_roles.role_id', ['2','3'])
                ->first();
        }

        if($user == null)
        {
            return redirect()->route('subAdminListUsers')->with('error', 'No Record Found.');
        }

        return view('backend.pages.user.view', compact('user'));
    }

    public function candidateList()
    {
        $candidates = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->select('users.name','users.country_name','model_has_roles.model_id')
            ->where('model_has_roles.role_id', '=', 3)
            ->where('users.country_name', Auth::user()->country_name)
            ->orderBy('users.id', 'desc')
            ->get();
        $date = \Carbon\Carbon::today()->subDays(5);
        $activeUsers = DB::table('active_users')->where('date','>=',$date)->count();

        return view('backend.pages.candidate.list', compact('candidates','activeUsers'));
    }

    public function jobApprovalList()
    {
        $jobs = DB::table('jobs')->where('job_location', Auth::user()->country_name)->where('approval_status','=',0)->orderBy('id', 'desc')->get();

        return view('backend.pages.jobApproval.list', compact('jobs'));
    }

    public function job_details($id)
    {
        $job = DB::table('jobs')->where('id',decrypt($id))->first();

        return view('backend.pages.jobApproval.jobDetails', compact('job'));
    }

    public function jobApprovalStatus(Request $request)
    {
        if ($request->value == 1)
        {
            $current = Carbon::now();

            $jobExpires = $current->addDays(30);

            DB::table('jobs')->where('id',$request->id)->update([
                'approval_status' => $request->value,
                'expireDate' => Carbon::parse($jobExpires)->format('Y-m-d')

            ]);
            return response()->json(['status' => 1]);
        }
        elseif($request->value == 2)
        {
            DB::table('jobs')->where('id',$request->id)->update([
                'approval_status' => $request->value
            ]);

            $countCheck = DB::table('employee_packages')->where('user_id', $request->user_id)->first();
            if ($countCheck > 0)
            {
                DB::table('employee_packages')->where('user_id', $request->user_id)->decrement('jobs_count',1);
            }

            return response()->json(['status' => 1]);
        }
        else
        {
            return response()->json(['status' => 0]);
        }
    }

    public function financialList()
    {
        $packages = DB::table('employee_packages')->where('country_name', Auth::user()->country_name)->orderBy('id', 'desc')->get();

        return view('backend.pages.financial.list',compact('packages'));
    }

    public function statisticsList()
    {
        $liveJobs = DB::table('jobs')->where('job_location', Auth::user()->country_name)->where('status','=',1)->where('approval_status','=',1)->count();
        $totalJobs = DB::table('jobs')->where('job_location', Auth::user()->country_name)->get();
        $totalCandidateJobsApplied = DB::table('candidate_applied_jobs')
            ->join('jobs','candidate_applied_jobs.job_id','=','jobs.id')
            ->where('jobs.job_location',Auth::user()->country_name)
            ->count();
        $liveAppliedCandidateJobs = DB::table('candidate_applied_jobs')
            ->join('jobs','candidate_applied_jobs.job_id','=','jobs.id')
            ->where('jobs.job_location',Auth::user()->country_name)
            ->count();
        $employers = DB::table('model_has_roles')
            ->join('users', 'model_has_roles.model_id', '=', 'users.id')
            ->select('model_id')
            ->where('model_has_roles.role_id','=','2')
            ->where('users.country_name', Auth::user()->country_name)
            ->get();
        $candidates = DB::table('model_has_roles')
            ->join('users', 'model_has_roles.model_id', '=', 'users.id')
            ->select('model_id')
            ->where('model_has_roles.role_id','=','3')
            ->where('users.country_name', Auth::user()->country_name)
            ->get();

        return view('backend.pages.statistics.view',compact('liveJobs','totalJobs','totalCandidateJobsApplied','liveAppliedCandidateJobs','employers','candidates'));
    }

    public function advertiseList()
    {
        $advertisements = DB::table('advertisements')->where('admin_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return view('backend.pages.advertise.list',compact('advertisements'));
    }

    public function advertiseCreate()
    {
        $employers = DB::table('model_has_roles')
            ->join('users', 'model_has_roles.model_id','users.id')
            ->select('model_id')
            ->where('model_has_roles.role_id','=','2')
            ->where('users.country_name', Auth::user()->country_name)
            ->get();

        return view('backend.pages.advertise.create',compact('employers'));
    }

    public function advertiseStore(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'employer' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $advertise =  DB::table('advertisements')->insertGetId([
            'admin_id' => Auth::user()->id,
            'title' => $request['title'],
            'countries' => Auth::user()->country_name,
            'employer' => $request['employer'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image)
            {
                $images = $image;
                $path = public_path(). '/images/';
                $filename = time() . '.' . $images->getClientOriginalExtension();
                $images->move($path, $filename);
                $advertisementImage  = $filename;

                DB::table('advertisements_images')->insert(array(
                    'ad_id'=> $advertise,
                    'image'=> $advertisementImage,
                    'created_at'=> DB::raw('CURRENT_TIMESTAMP')
                ));
            }
        }

        return redirect()->route('subAdminListAdvertise')->with('success', 'Record Added Successfully.');
    }

    public function advertiseEdit($id)
    {
        $advertisements = DB::table('advertisements')
            ->where('admin_id', Auth::user()->id)
            ->where('id', $id)
            ->first();

        $employers = DB::table('model_has_roles')
            ->join('users', 'model_has_roles.model_id', 'users.id')
            ->select('model_id')
            ->where('model_has_roles.role_id','=','2')
            ->where('users.country_name',Auth::user()->country_name)
            ->get();

        if($advertisements == null)
        {
            return redirect()->route('subAdminListAdvertise')->with('error', 'No Record Found.');
        }

        return view('backend.pages.advertise.edit', compact('advertisements','employers'));
    }

    public function advertiseUpdate(Request $request,$id)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'employer' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $advertisement = DB::table('advertisements')->where('id', $id)->first();

        if (empty($advertisement))
        {
            return redirect()->route('subAdminListAdvertise')->with('error', 'Something went wrong try again!');
        }
        else{

            DB::table('advertisements')->where('id', $advertisement->id)->update([
                'title' => $request['title'],
                'employer' => $request['employer'],
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
                'updated_at' => DB::raw('CURRENT_TIMESTAMP')
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image)
                {
                    $images = $image;
                    $path = public_path(). '/images/';
                    $filename = time() . '.' . $images->getClientOriginalExtension();
                    $images->move($path, $filename);
                    $advertisementImage  = $filename;

                    DB::table('advertisements_images')->insert(array(
                        'ad_id'=> $id,
                        'image'=> $advertisementImage,
                        'created_at'=> DB::raw('CURRENT_TIMESTAMP')
                    ));
                }
            }

            return redirect()->route('subAdminListAdvertise')->with('success', 'Record Added Successfully.');
        }
    }

    public function advertiseDelete(Request $request)
    {
        $advertisement = DB::table('advertisements')->where('id',$request->id)->first();

        if(empty($advertisement)) {
            return response()->json(['status' => 0]);
        }

        DB::table('advertisements')->where('id',$request->id)->delete();
        DB::table('advertisements_images')->where('ad_id', $request->id)->delete();

        return response()->json(['status' => 1]);
    }

    public function advertiseDeleteImage(Request $request)
    {
        $image = DB::table('advertisements_images')->where('id', $request->id)->first();

        if(empty($image)) {
            return response()->json(['status' => 0]);
        }

        if (Storage::exists($image->image))
        {
            Storage::delete('/'.$image->image);
        }
        DB::table('advertisements_images')->delete($request->id);

        return response()->json(['status' => 1]);
    }

    public function adevertiseStatus(Request $request)
    {
        $advertisement = DB::table('advertisements')->where('id',$request->ad_id)->first();

        if(empty($advertisement)) {
            return response()->json(['status' => 0]);
        }

        DB::table('advertisements')->where('id', $advertisement->id)->update([
            'status' => $request->status_id,
        ]);

        return response()->json(['status' => 1]);
    }

}
