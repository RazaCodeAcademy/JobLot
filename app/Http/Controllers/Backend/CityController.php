<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class CityController extends Controller
{
    public function listCities()
    {
        $cities = DB::table('cities')->orderBy('id', 'desc')->get();
        return view('backend.pages.city.list', compact('cities'));
    }

    public function createCity()
    {
        $countries = DB::table('countries')->get();
        return view('backend.pages.city.create', compact('countries'));
    }

    public function storeCity(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:cities,name',
            'country_id' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('cities')->insert([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'country_id' => $request->country_id
        ]);

        return redirect()->route('listCities')->with('success', 'Record Added Successfully.');
    }

    public function editCity($id)
    {
        $city = DB::table('cities')->where('id', $id)->first();

        if($city == null)
        {
            return redirect()->route('listCities')->with('error', 'No Record Found.');
        }

        $countries = DB::table('countries')->get();

        return view('backend.pages.city.edit', compact('city', 'countries'));
    }

    public function updateCity(Request $request)
    {
        $city = DB::table('cities')->where('id', $request->id)->first();

        if($city == null)
        {
            return redirect()->route('listCities')->with('error', 'No Record Found.');
        }

        $rules = [
            'name' => 'required|string|max:255|unique:cities,name,'.$city->id,
            'country_id' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('cities')->where('id', $request->id)->update([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'country_id' => $request->country_id
        ]);

        return redirect()->route('listCities')->with('success','Record Successfully Updated');

    }

    public function deleteCity(Request $request){
        $city = DB::table('cities')->where('id',$request->id)->first();

        if(empty($city)) {
            return response()->json(['status' => 0]);
        }

        DB::table('cities')->where('id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }
}
