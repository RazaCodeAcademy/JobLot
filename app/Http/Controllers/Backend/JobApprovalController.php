<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobApprovalController extends Controller
{
    public function list()
    {
        $jobs = DB::table('jobs')->where('approval_status','=',0)->orderBy('id', 'desc')->get();

        return view('backend.pages.jobApproval.list', compact('jobs'));
    }

    public function status(Request $request)
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

    public function job_details($id)
    {
        $job = DB::table('jobs')->where('id',decrypt($id))->first();

        return view('backend.pages.jobApproval.jobDetails', compact('job'));
    }
}
