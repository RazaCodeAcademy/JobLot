<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Job;
use App\Models\EmployeePackage;

class JobApprovalController extends Controller
{
    public function list()
    {
        $jobs =Job::where('job_approval','=',0)->orderBy('id', 'desc')->get();

        return view('backend.pages.jobApproval.list', compact('jobs'));
    }

    public function status(Request $request,$id)
    {
        if ($request->value == 1)
        {
            $current = Carbon::now();

            $jobExpires = $current->addDays(30);

                Job::find($id)->update([
                'job_approval' => $request->value,
                'expireDate' => Carbon::parse($jobExpires)->format('Y-m-d')
            ]);
            return response()->json(['status' => 1]);
        }
        elseif($request->value == 2)
            {
                Job::find($id)->update([
                    'job_approval' => $request->value
                ]);

                $countCheck =EmployeePackage::where('user_id', $request->user_id)->first();
                if ($countCheck > 0)
                {
                    EmployeePackage::where('user_id', $request->user_id)->decrement('jobs_count',1);
                }

                return response()->json(['status' => 1]);
            }
        else
            {
                return response()->json(['status' => 0]);
            }
    }

    public function job_details($id)
    {
        $job = Job::find($id);

        return view('backend.pages.jobApproval.jobDetails', compact('job'));
    }
}
