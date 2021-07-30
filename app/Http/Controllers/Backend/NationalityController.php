<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class NationalityController extends Controller
{
    public function listNationalities()
    {
        $nationalities = DB::table('nationalities')->get();

        return view('backend.pages.nationality.list', compact('nationalities'));
    }

    public function createNationality()
    {
        return view('backend.pages.nationality.create');
    }

    public function storeNationality(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:nationalities,name',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('nationalities')->insert([
            'name' => $request->name
        ]);

        return redirect()->route('listNationalities')->with('success', 'Record Added Successfully.');
    }

    public function editNationality($id)
    {
        $nationality = DB::table('nationalities')->where('id', $id)->first();

        if($nationality == null)
        {
            return redirect()->route('listNationalities')->with('error', 'No Record Found.');
        }

        return view('backend.pages.nationality.edit', compact('nationality'));
    }

    public function updateNationality(Request $request)
    {
        $nationality = DB::table('nationalities')->where('id', $request->id)->first();

        if($nationality == null)
        {
            return redirect()->route('listNationalities')->with('error', 'No Record Found.');
        }

        $rules = [
            'name' => 'required|string|max:255|unique:nationalities,name,'.$nationality->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('nationalities')->where('id', $request->id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('listNationalities')->with('success','Record Successfully Updated');

    }

    public function deleteNationality(Request $request){
        $nationality = DB::table('nationalities')->where('id',$request->id)->first();

        if(empty($nationality)) {
            return response()->json(['status' => 0]);
        }

        DB::table('nationalities')->where('id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }
}
