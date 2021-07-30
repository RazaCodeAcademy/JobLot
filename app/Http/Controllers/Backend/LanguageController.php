<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class LanguageController extends Controller
{
    public function listLanguages()
    {
        $languages = DB::table('languages')->get();

        return view('backend.pages.language.list', compact('languages'));
    }

    public function createLanguage()
    {
        return view('backend.pages.language.create');
    }

    public function storeLanguage(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:languages,name',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('languages')->insert([
            'name' => $request->name
        ]);

        return redirect()->route('listLanguages')->with('success', 'Record Added Successfully.');
    }

    public function editLanguage($id)
    {
        $language = DB::table('languages')->where('id', $id)->first();

        if($language == null)
        {
            return redirect()->route('listLanguages')->with('error', 'No Record Found.');
        }

        return view('backend.pages.language.edit', compact('language'));
    }

    public function updateLanguage(Request $request)
    {
        $language = DB::table('languages')->where('id', $request->id)->first();

        if($language == null)
        {
            return redirect()->route('listLanguages')->with('error', 'No Record Found.');
        }

        $rules = [
            'name' => 'required|string|max:255|unique:languages,name,'.$language->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('languages')->where('id', $request->id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('listLanguages')->with('success','Record Successfully Updated');

    }

    public function deleteLanguage(Request $request){
        $language = DB::table('languages')->where('id',$request->id)->first();

        if(empty($language)) {
            return response()->json(['status' => 0]);
        }

        DB::table('languages')->where('id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }
}
