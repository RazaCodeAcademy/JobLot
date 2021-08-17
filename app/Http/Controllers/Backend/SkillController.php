<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class SkillController extends Controller
{
    public function listJobSkills()
    {
        $skills = DB::table('skills')->orderBy('id', 'desc')->get();

        return view('backend.pages.jobSkill.list', compact('skills'));
    }

    public function createJobSkill()
    {
        return view('backend.pages.jobSkill.create');
    }

    public function storeJobSkill(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:skills,name',
            'name_ar' => 'required|string|max:255|unique:skills,name_ar',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('skills')->insert([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
        ]);

        return redirect()->route('listJobSkills')->with('success', 'Record Added Successfully.');
    }

    public function editJobSkill($id)
    {
        $skill = DB::table('skills')->where('id', $id)->first();

        if($skill == null)
        {
            return redirect()->route('listJobSkills')->with('error', 'No Record Found.');
        }

        return view('backend.pages.jobSkill.edit', compact('skill'));
    }

    public function updateJobSkill(Request $request)
    {
        $skill = DB::table('skills')->where('id', $request->id)->first();

        if($skill == null)
        {
            return redirect()->route('listJobSkills')->with('error', 'No Record Found.');
        }

        $rules = [
            'name' => 'required|string|max:255|unique:skills,name,'.$skill->id,
            'name_ar' => 'required|string|max:255|unique:skills,name_ar,'.$skill->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('skills')->where('id', $request->id)->update([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
        ]);

        return redirect()->route('listJobSkills')->with('success','Record Successfully Updated');

    }

    public function deleteJobSkill(Request $request){
        $skill = DB::table('skills')->where('id',$request->id)->first();

        if(empty($skill)) {
            return response()->json(['status' => 0]);
        }

        DB::table('skills')->where('id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }
}
