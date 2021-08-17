<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use AshAllenDesign\LaravelExchangeRates\Classes\ExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialController extends Controller
{
    public function list()
    {
        $total_packages = DB::table('employee_packages')->count();

//        $exchangeRates = new ExchangeRate();
//        $result = $exchangeRates->exchangeRate('KD', 'USD');
//        dd($exchangeRates->currencies());

        $countries = DB::table('countries')->get();
        $packages = DB::table('employee_packages')->orderBy('id', 'desc')->get();

        return view('backend.pages.financial.list',compact('total_packages','countries','packages'));
    }

    public function filterCountry(Request $request)
    {
        if ($request->country_id == 0)
        {
            $totalPackages = DB::table('employee_packages')->count();

            $data = [$totalPackages];

            return response()->json(['values'=>$data]);
        }

        else
        {
            $totalPackages = DB::table('employee_packages')->where('country_name', $request->country_id)->count();

            $data = [$totalPackages];

            return response()->json(['values'=>$data]);
        }

    }

}
