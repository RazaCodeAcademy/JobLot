<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    public function listCountries()
    {
        $countries = DB::table('countries')->get();

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
            'currency' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('countries')->insert([
            'name' => $request->name,
            'currency' => $request->currency
        ]);

        return redirect()->route('listCountries')->with('success', 'Record Added Successfully.');
    }

    public function editCountry($id)
    {
        $country = DB::table('countries')->where('id', $id)->first();

        if($country == null)
        {
            return redirect()->route('listCountries')->with('error', 'No Record Found.');
        }

        return view('backend.pages.country.edit', compact('country'));
    }

    public function updateCountry(Request $request)
    {
        $country = DB::table('countries')->where('id', $request->id)->first();

        if($country == null)
        {
            return redirect()->route('listCountries')->with('error', 'No Record Found.');
        }

        $rules = [
            'name' => 'required|string|max:255|unique:countries,name,'.$country->id,
            'currency' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('countries')->where('id', $request->id)->update([
            'name' => $request->name,
            'currency' => $request->currency
        ]);

        return redirect()->route('listCountries')->with('success','Record Successfully Updated');

    }

    public function deleteCountry(Request $request){
        $country = DB::table('countries')->where('id',$request->id)->first();

        if(empty($country)) {
            return response()->json(['status' => 0]);
        }

        DB::table('countries')->where('id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }
}
