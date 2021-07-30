<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class JobQualificationController extends Controller
{
    public function listQualifications()
    {
        $qualifications = DB::table('job_qualifications')->get();

        return view('backend.pages.qualification.list', compact('qualifications'));
    }

    public function createQualification()
    {
        return view('backend.pages.qualification.create');
    }

    public function storeQualification(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:job_qualifications,name',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('job_qualifications')->insert([
            'name' => $request->name
        ]);

        return redirect()->route('listQualifications')->with('success', 'Record Added Successfully.');
    }

    public function editQualification($id)
    {
        $qualification = DB::table('job_qualifications')->where('id', $id)->first();

        if($qualification == null)
        {
            return redirect()->route('listQualifications')->with('error', 'No Record Found.');
        }

        return view('backend.pages.qualification.edit', compact('qualification'));
    }

    public function updateQualification(Request $request)
    {
        $qualification = DB::table('job_qualifications')->where('id', $request->id)->first();

        if($qualification == null)
        {
            return redirect()->route('listQualifications')->with('error', 'No Record Found.');
        }

        $rules = [
            'name' => 'required|string|max:255|unique:job_qualifications,name,'.$qualification->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('job_qualifications')->where('id', $request->id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('listQualifications')->with('success','Record Successfully Updated');

    }

    public function deleteQualification(Request $request){
        $qualification = DB::table('job_qualifications')->where('id',$request->id)->first();

        if(empty($qualification)) {
            return response()->json(['status' => 0]);
        }

        DB::table('job_qualifications')->where('id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }
}
