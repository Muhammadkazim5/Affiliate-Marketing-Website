<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $subcategories = SubCategory::select('sub_categories.*', 'categories.name as categoryName')->latest('sub_categories.id')->leftJoin('categories', 'categories.id', 'sub_categories.category_id');
        if (!empty($request->get('keyword'))) {
            $subcategories = $subcategories->where('sub_categories.name', 'like', '%' . $request->get('keyword') . '%');
            $subcategories = $subcategories->orwhere('categories.name', 'like', '%' . $request->get('keyword') . '%');
        }
        $subcategories = $subcategories->paginate(3);
        return view('admin.subcategory.list', compact('subcategories'));
    }
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('admin.subcategory.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required',
        ]);
        if ($validator->passes()) {
            $subcategory = new SubCategory();
            $subcategory->name = $request->name;
            $subcategory->slug = $request->slug;
            $subcategory->status = $request->status;
            // $subcategory->showHome = $request->showHome;
            $subcategory->category_id = $request->category_id;
            $subcategory->save();
            return redirect()->route('subcategories.index')->with('success', 'Sub Category created successfully!');
        } else {
            return redirect()->route('subcategories.create')->withErrors($validator)->withInput($request->only('name'));
        }
    }
    public function edit($subcategoryId, Request $request)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategory = SubCategory::find($subcategoryId);
        if (empty($subcategory)) {
            return redirect()->route('subcategories.index');
        }
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }
    public function update($subcategoryId, Request $request)
    {
        $subcategory = SubCategory::find($subcategoryId);
        if (empty($subcategory)) {
            return redirect()->route('subcategories.index')->with('error', 'Sub Category Not Found!');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,' . $subcategory->id . ',id',
            'category_id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->passes()) {
            $subcategory->name = $request->name;
            $subcategory->slug = $request->slug;
            $subcategory->status = $request->status;
            // $subcategory->showHome = $request->showHome;
            $subcategory->category_id = $request->category_id;
            $subcategory->save();
            return redirect()->route('subcategories.index')->with('success', 'Sub-Category Updated successfully!');
        } else {
            return redirect()->route('subcategories.edit', $subcategoryId)
                ->withErrors($validator)
                ->withInput($request->only('name', 'slug', 'category_id', 'status', 'showHome'));
        }
    }
    public function destroy($subcategoryId)
    {
        $subcategory = SubCategory::find($subcategoryId);
        if (empty($subcategory)) {
            return response()->json([
                'status' => true,
                'error' => 'Sub Category Not Found!'
            ]);
        }
        $subcategory->delete();
        // return redirect()->route('categories.index')->with('success', 'Category delete successfully!');
        return response()->json([
            'status' => true,
            'success' => 'Sub Category delete successfully!'
        ]);
    }
}
