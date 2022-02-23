<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\City;
use App\Models\Country;

class CityController extends Controller
{
    public function listCities()
    {
        $cities = City::orderBy('id', 'desc')->get();
        return view('backend.pages.city.list', compact('cities'));
    }

    public function createCity()
    {
        $countries = Country::all();
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
        $city = City::find($id);

        if($city == null)
        {
            return redirect()->route('listCities')->with('error', 'No Record Found.');
        }

        $countries =Country::all();

        return view('backend.pages.city.edit', compact('city', 'countries'));
    }

    public function updateCity(Request $request, $id)
    {
        $city =City::find($id);

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

            City::find($id)->update([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'country_id' => $request->country_id
        ]);

        return redirect()->route('listCities',compact('city'))->with('success','Record Successfully Updated');

    }

    public function deleteCity($id){
        
        $city = City::find($id);

        if(empty($city)) {
            return response()->json(['status' => 0]);
        }

        $city->delete();

        return response()->json(['status' => 1]);
    }
}
