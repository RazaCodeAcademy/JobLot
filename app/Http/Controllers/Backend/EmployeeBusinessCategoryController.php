<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\EmployeeBussinessCategory;
use App\Models\City;

class EmployeeBusinessCategoryController extends Controller
{
    public function listCategories()
    {
        $categories = EmployeeBussinessCategory::all();

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

        EmployeeBussinessCategory::create([
            'category' => $request->category,
            'category_ar' => $request->category_ar,
            
        ]);

        return redirect()->route('listCategories')->with('success', 'Record Added Successfully.');
    }

    public function editCategory($id)
    {
        $category = EmployeeBussinessCategory::find($id);

        if($category == null)
        {
            return redirect()->route('listCategories')->with('error', 'No Record Found.');
        }

        return view('backend.pages.category.edit', compact('category'));
    }

    public function updateCategory(Request $request,$id)
    {
        $category = EmployeeBussinessCategory::find($id);

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

         EmployeeBussinessCategory::find($id)->update([
            'category' => $request->category,
            'category_ar' => $request->category_ar,
        ]);

        return redirect()->route('listCategories')->with('success','Record Successfully Updated');

    }

    public function deleteCategory(Request $request,$id){
        $category = EmployeeBussinessCategory::find($id);

        if(empty($category)) {
            return response()->json(['status' => 0]);
        }

        $category->delete();

        return response()->json(['status' => 1]);
    }
}
