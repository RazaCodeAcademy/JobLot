<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\JobQualifcation;

class JobQualificationController extends Controller
{
    public function listQualifications()
    {
        $qualifications = JobQualifcation::orderBy('id', 'desc')->get();

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
            'name_ar' => 'required|string|max:255|unique:job_qualifications,name_ar',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        JobQualifcation::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
        ]);

        return redirect()->route('listQualifications')->with('success', 'Record Added Successfully.');
    }

    public function editQualification($id)
    {
        $qualification = JobQualifcation::find($id);

        if($qualification == null)
        {
            return redirect()->route('listQualifications')->with('error', 'No Record Found.');
        }

        return view('backend.pages.qualification.edit', compact('qualification'));
    }

    public function updateQualification(Request $request,$id)
    {
        $qualification = JobQualifcation::find($id);

        if($qualification == null)
        {
            return redirect()->route('listQualifications')->with('error', 'No Record Found.');
        }

        $rules = [
            'name' => 'required|string|max:255|unique:job_qualifications,name,'.$qualification->id,
            'name_ar' => 'required|string|max:255|unique:job_qualifications,name_ar,'.$qualification->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        JobQualifcation::find($id)->update([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
        ]);

        return redirect()->route('listQualifications')->with('success','Record Successfully Updated');

    }

    public function deleteQualification(Request $request,$id){
        $qualification = JobQualifcation::find($id);

        if(empty($qualification)) {
            return response()->json(['status' => 0]);
        }

        $qualification->delete();

        return response()->json(['status' => 1]);
    }
}
