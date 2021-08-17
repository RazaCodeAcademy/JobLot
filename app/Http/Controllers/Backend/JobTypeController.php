<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class JobTypeController extends Controller
{
    public function listJobTypes()
    {
        $types = DB::table('job_types_tables')->orderBy('id', 'desc')->get();

        return view('backend.pages.jobType.list', compact('types'));
    }

    public function createJobType()
    {
        return view('backend.pages.jobType.create');
    }

    public function storeJobType(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:job_types_tables,name',
            'name_ar' => 'required|string|max:255|unique:job_types_tables,name_ar',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('job_types_tables')->insert([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
        ]);

        return redirect()->route('listJobTypes')->with('success', 'Record Added Successfully.');
    }

    public function editJobType($id)
    {
        $type = DB::table('job_types_tables')->where('id', $id)->first();

        if($type == null)
        {
            return redirect()->route('listJobTypes')->with('error', 'No Record Found.');
        }

        return view('backend.pages.jobType.edit', compact('type'));
    }

    public function updateJobType(Request $request)
    {
        $type = DB::table('job_types_tables')->where('id', $request->id)->first();

        if($type == null)
        {
            return redirect()->route('listJobTypes')->with('error', 'No Record Found.');
        }

        $rules = [
            'name' => 'required|string|max:255|unique:job_types_tables,name,'.$type->id,
            'name_ar' => 'required|string|max:255|unique:job_types_tables,name_ar,'.$type->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('job_types_tables')->where('id', $request->id)->update([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
        ]);

        return redirect()->route('listJobTypes')->with('success','Record Successfully Updated');

    }

    public function deleteJobType(Request $request){
        $type = DB::table('job_types_tables')->where('id',$request->id)->first();

        if(empty($type)) {
            return response()->json(['status' => 0]);
        }

        DB::table('job_types_tables')->where('id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }
}
