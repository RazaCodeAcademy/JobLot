<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\City;
use App\Models\Country;

class CountryController extends Controller
{
    public function listCountries()
    {
        $countries = Country::all();

        return view('backend.pages.country.list', compact('countries'));
    }

    public function createCountry()
    {
        return view('backend.pages.country.create');
    }

    public function storeCountry(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:countries,name',
            'name_ar' => 'required|string|max:255|unique:countries,name_ar',
            'currency' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

            Country::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'currency' => $request->currency
        ]);

        return redirect()->route('listCountries')->with('success', 'Record Added Successfully.');
    }

    public function editCountry($id)
    {
        $country = Country::find($id);

        if($country == null)
        {
            return redirect()->route('listCountries')->with('error', 'No Record Found.');
        }

        return view('backend.pages.country.edit', compact('country'));
    }

    public function updateCountry(Request $request,$id)
    {
        $country = Country::find($id);

        if($country == null)
        {
            return redirect()->route('listCountries')->with('error', 'No Record Found.');
        }

        $rules = [
            'name' => 'required|string|max:255|unique:countries,name,'.$country->id,
            'name_ar' => 'required|string|max:255|unique:countries,name_ar,'.$country->id,
            'currency' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

            $country = Country::find($id)->update([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'currency' => $request->currency
        ]);

        return redirect()->route('listCountries')->with('success','Record Successfully Updated');

    }

    public function deleteCountry($id){
        
        $country = Country::find($id);

        if(empty($country)) {
            return response()->json(['status' => 0]);
        }

        $country->delete();

        return response()->json(['status' => 1]);
    }
}
