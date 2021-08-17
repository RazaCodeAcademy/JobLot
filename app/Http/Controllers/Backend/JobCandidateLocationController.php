<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class JobCandidateLocationController extends Controller
{
    public function listLocations()
    {
        $locations = DB::table('job_candidate_locations')->orderBy('id', 'desc')->get();

        return view('backend.pages.location.list', compact('locations'));
    }

    public function createLocation()
    {
        return view('backend.pages.location.create');
    }

    public function storeLocation(Request $request)
    {
        $rules = [
            'location' => 'required|string|max:255|unique:job_candidate_locations,location',
            'location_ar' => 'required|string|max:255|unique:job_candidate_locations,location_ar',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('job_candidate_locations')->insert([
            'location' => $request->location,
            'location_ar' => $request->location_ar,
        ]);

        return redirect()->route('listLocations')->with('success', 'Record Added Successfully.');
    }

    public function editLocation($id)
    {
        $location = DB::table('job_candidate_locations')->where('id', $id)->first();

        if($location == null)
        {
            return redirect()->route('listLocations')->with('error', 'No Record Found.');
        }

        return view('backend.pages.location.edit', compact('location'));
    }

    public function updateLocation(Request $request)
    {
        $location = DB::table('job_candidate_locations')->where('id', $request->id)->first();

        if($location == null)
        {
            return redirect()->route('listLocations')->with('error', 'No Record Found.');
        }

        $rules = [
            'location' => 'required|string|max:255|unique:job_candidate_locations,location,'.$location->id,
            'location_ar' => 'required|string|max:255|unique:job_candidate_locations,location_ar,'.$location->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('job_candidate_locations')->where('id', $request->id)->update([
            'location' => $request->location,
            'location_ar' => $request->location_ar,
        ]);

        return redirect()->route('listLocations')->with('success','Record Successfully Updated');

    }

    public function deleteLocation(Request $request){
        $location = DB::table('job_candidate_locations')->where('id',$request->id)->first();

        if(empty($location)) {
            return response()->json(['status' => 0]);
        }

        DB::table('job_candidate_locations')->where('id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }
}
