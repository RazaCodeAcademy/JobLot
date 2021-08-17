<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{

    public function create()
    {
        $countries = DB::table('countries')->get();
        $package_currencys = DB::table('package_currencys')->get();

        return view('backend.pages.package.create',compact('countries','package_currencys'));
    }

    public function store(Request $request)
    {
        $rules = [
            'package_name' => 'required|string|max:255',
            'countries' => 'required',
            'package_description' => 'required',
            'currency' => 'required',
            'rate' => 'required|min:0',
            'job_limit' => 'required|min:1',
            'cv_limit' => 'required|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $countries = implode(',', $request->countries);

        $package = DB::table('packages')->insertGetId([
           'user_id' => Auth::user()->id,
           'package_name' => $request->input('package_name'),
           'countries' => $countries
        ]);

       $packageDetails = DB::table('package_details')->insertGetId([
            'package_id' => $package,
            'package_description' => $request->input('package_description'),
            'currency' => $request->input('currency'),
            'rate' => $request->input('rate'),
            'job_limit' => $request->input('job_limit'),
            'cv_limit' => $request->input('cv_limit'),
        ]);

        for ($i = 0; $i < count($request->package_feactures); $i++) {

            DB::table('package_feature_lists')
                ->insert(array(
                    'package_details_id' => $packageDetails,
                    'feature_name' => $request->package_feactures[$i]['feature_name'],
                ));
        }

        return redirect()->route('listPackages')->with('success', 'Package Added Successfully.');
    }

    public function edit($id)
    {
        $packages = DB::table('packages')
            ->join('package_details', 'packages.id', '=', 'package_details.package_id')
            ->select('packages.id as id','packages.package_name','packages.countries','package_details.id as package_details_id',
                             'package_details.package_id','package_details.package_description','package_details.currency',
                             'package_details.rate','package_details.job_limit','package_details.cv_limit')
            ->where('packages.id', $id)
            ->first();

        $countries = DB::table('countries')->get();
        $package_currencys = DB::table('package_currencys')->get();

        if($packages == null)
        {
            return redirect()->route('listUsers')->with('error', 'No Record Found.');
        }

        return view('backend.pages.package.edit', compact('packages','countries','package_currencys'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'package_name' => 'required|string|max:255',
            'countries' => 'required',
            'package_description' => 'required',
            'currency' => 'required',
            'rate' => 'required|min:0',
            'job_limit' => 'required|min:1',
            'cv_limit' => 'required|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $countries = implode(', ', $request->countries);

        DB::table('packages')->where('id', $id)->update([
            'user_id' => Auth::user()->id,
            'package_name' => $request->input('package_name'),
            'countries' => $countries
        ]);

        $packageDetails = DB::table('package_details')->where('package_id', $id)->first();

        DB::table('package_details')->where('package_id', $id)->update([
            'package_id' => $id,
            'package_description' => $request->input('package_description'),
            'currency' => $request->input('currency'),
            'rate' => $request->input('rate'),
            'job_limit' => $request->input('job_limit'),
            'cv_limit' => $request->input('cv_limit'),
        ]);

        DB::table('package_feature_lists')->where('package_details_id', $packageDetails->id)->delete();

        for ($i = 0; $i < count($request->package_feactures); $i++) {

            DB::table('package_feature_lists')
                ->insert(array(
                    'package_details_id' => $packageDetails->id,
                    'feature_name' => $request->package_feactures[$i]['feature_name'],
                ));
        }

        return redirect()->route('listPackages')->with('success', 'Package Added Successfully.');
    }

    public function delete(Request $request)
    {
        $package = DB::table('packages')->where('id',$request->id)->first();
        $packageDetails = DB::table('package_details')->where('package_id',$request->id)->first();

        if(empty($package)) {
            return response()->json(['status' => 0]);
        }

        DB::table('package_feature_lists')->where('package_details_id',$packageDetails->id)->delete();
        DB::table('package_details')->where('package_id',$request->id)->delete();
        DB::table('packages')->where('id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }

    public function view($id)
    {
        $packages = DB::table('packages')
            ->join('package_details', 'packages.id', '=', 'package_details.package_id')
            ->select('packages.id as id','packages.package_name','packages.countries','package_details.id as package_details_id',
                'package_details.package_id','package_details.package_description','package_details.currency',
                'package_details.rate','package_details.job_limit','package_details.cv_limit')
            ->where('packages.id', $id)
            ->first();

        $countries = DB::table('countries')->get();
        $package_currencys = DB::table('package_currencys')->get();

        if($packages == null)
        {
            return redirect()->route('listUsers')->with('error', 'No Record Found.');
        }

        return view('backend.pages.package.view', compact('packages','countries','package_currencys'));
    }

    public function list()
    {
        $packages = DB::table('package_details')->orderBy('id', 'desc')->get();

        return view('backend.pages.package.list',compact('packages'));
    }

}
