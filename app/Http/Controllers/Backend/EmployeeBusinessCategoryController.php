<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class EmployeeBusinessCategoryController extends Controller
{
    public function listCategories()
    {
        $categories = DB::table('employee_bussiness_categories')->orderBy('id', 'desc')->get();

        return view('backend.pages.category.list', compact('categories'));
    }

    public function createCategory()
    {
        return view('backend.pages.category.create');
    }

    public function storeCategory(Request $request)
    {
        $rules = [
            'category' => 'required|string|max:255|unique:employee_bussiness_categories,category',
            'category_ar' => 'required|string|max:255|unique:employee_bussiness_categories,category_ar',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('employee_bussiness_categories')->insert([
            'category' => $request->category,
            'category_ar' => $request->category_ar,
            'icon' => 'cateogry'
        ]);

        return redirect()->route('listCategories')->with('success', 'Record Added Successfully.');
    }

    public function editCategory($id)
    {
        $category = DB::table('employee_bussiness_categories')->where('id', $id)->first();

        if($category == null)
        {
            return redirect()->route('listCategories')->with('error', 'No Record Found.');
        }

        return view('backend.pages.category.edit', compact('category'));
    }

    public function updateCategory(Request $request)
    {
        $category = DB::table('employee_bussiness_categories')->where('id', $request->id)->first();

        if($category == null)
        {
            return redirect()->route('listCategories')->with('error', 'No Record Found.');
        }

        $rules = [
            'category' => 'required|string|max:255|unique:employee_bussiness_categories,category,'.$category->id,
            'category_ar' => 'required|string|max:255|unique:employee_bussiness_categories,category_ar,'.$category->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('employee_bussiness_categories')->where('id', $request->id)->update([
            'category' => $request->category,
            'category_ar' => $request->category_ar,
        ]);

        return redirect()->route('listCategories')->with('success','Record Successfully Updated');

    }

    public function deleteCategory(Request $request){
        $category = DB::table('employee_bussiness_categories')->where('id',$request->id)->first();

        if(empty($category)) {
            return response()->json(['status' => 0]);
        }

        DB::table('employee_bussiness_categories')->where('id',$request->id)->delete();

        return response()->json(['status' => 1]);
    }
}
