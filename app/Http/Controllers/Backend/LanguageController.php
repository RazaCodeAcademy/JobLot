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
        $languages = DB::table('languages')->orderBy('id', 'desc')->get();

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
            'name_ar' => 'required|string|max:255|unique:languages,name_ar',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('languages')->insert([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
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
            'name_ar' => 'required|string|max:255|unique:languages,name_ar,'.$language->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('languages')->where('id', $request->id)->update([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
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
