<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\Job;
use App\Models\EmployeePackage;
use App\Models\JobCareerLevel;

class JobCareerLevelController extends Controller
{
    public function listCareerLevels()
    {
        $levels = JobCareerLevel::orderBy('id', 'desc')->get();

        return view('backend.pages.careerLevel.list', compact('levels'));
    }

    public function createCareerLevel()
    {
        return view('backend.pages.careerLevel.create');
    }

    public function storeCareerLevel(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:job_career_levels,name',
            'name_ar' => 'required|string|max:255|unique:job_career_levels,name_ar',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        JobCareerLevel::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
        ]);

        return redirect()->route('listCareerLevels')->with('success', 'Record Added Successfully.');
    }

    public function editCareerLevel($id)
    {
        $level =JobCareerLevel::find($id);

        if($level == null)
        {
            return redirect()->route('listCareerLevels')->with('error', 'No Record Found.');
        }

        return view('backend.pages.careerLevel.edit', compact('level'));
    }

    public function updateCareerLevel(Request $request,$id)
    {
        $level = JobCareerLevel::find($id);

        if($level == null)
        {
            return redirect()->route('listCareerLevels')->with('error', 'No Record Found.');
        }

        $rules = [
            'name' => 'required|string|max:255|unique:job_career_levels,name,'.$level->id,
            'name_ar' => 'required|string|max:255|unique:job_career_levels,name_ar,'.$level->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

            JobCareerLevel::find($id)->update([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
        ]);

        return redirect()->route('listCareerLevels')->with('success','Record Successfully Updated');

    }

    public function deleteCareerLevel($id){
        $level = JobCareerLevel::find($id);

        if(empty($level)) {
            return response()->json(['status' => 0]);
        }

       $level->delete();

        return response()->json(['status' => 1]);
    }
}
