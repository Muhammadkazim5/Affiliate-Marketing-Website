<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::latest();
        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $categories = $categories->paginate(3);

        return view('admin.category.list', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->passes()) {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            // $category->showHome = $request->showHome;
            $category->save();
            if ($request->image != "") {
                $image = $request->image;
                $ext = $image->getClientOriginalExtension();
                $imageName = time() . '.' . $ext;
                $image->move(public_path('uploads/category'), $imageName);
                $category->image = $imageName;
                $category->save();
            }
            return redirect()->route('categories.index')->with('success', 'Category created successfully!');
        } else {
            return redirect()->route('categories.create')->withErrors($validator)->withInput($request->only('name'));
        }
    }

    public function edit($categoryId, Request $request)
    {
        $category = Category::find($categoryId);
        if (empty($category)) {
            return redirect()->route('categories.index');
        }
        return view('admin.category.edit', compact('category'));
    }
    public function update($categoryId, Request $request)
    {
        $category = Category::find($categoryId);
        if (empty($category)) {
            return redirect()->route('categories.index')->with('error', 'Category Not Found!');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $category->id . ',id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->passes()) {
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            // $category->showHome = $request->showHome;
            $category->save();
            if ($request->image != "") {
                File::delete(public_path('uploads/category' . $category->image));
                $image = $request->image;
                $ext = $image->getClientOriginalExtension();
                $imageName = time() . '.' . $ext;
                $image->move(public_path('uploads/category'), $imageName);
                $category->image = $imageName;
                $category->save();
            }
            return redirect()->route('categories.index')->with('success', 'Category Updated successfully!');
        } else {
            return redirect()->route('categories.edit')->withErrors($validator)->withInput($request->only('name'));
        }
    }
    public function destroy($categoryId, Request $request)
    {
        $category = Category::find($categoryId);
        if (empty($category)) {
            return response()->json([
                'status' => true,
                'error' => 'Category Not Found!'
            ]);
        }
        $category->delete();
        // return redirect()->route('categories.index')->with('success', 'Category delete successfully!');
        return response()->json([
            'status' => true,
            'success' => 'Category delete successfully!'
        ]);
    }
}
