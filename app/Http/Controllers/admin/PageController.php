<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $pages = Page::latest();
        if (!empty($request->get('keyword'))) {
            $pages = $pages->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $pages = $pages->paginate(3);
        return view('admin.pages.list', compact('pages'));
    }
    public function create()
    {
        return view('admin.pages.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'content' => 'required'
        ]);
        if ($validator->passes()) {
            $page = new Page;
            $page->name = $request->name;
            $page->content = $request->content;
            $page->save();
            return redirect()->route('pages.index')->with('success', 'Page created successfully!');

        } else {
            return redirect()->route('pages.create')->withErrors($validator)->withInput($request->only('name'));
        }
    }
    public function edit($id, Request $request)
    {
        $page = Page::find($id);
        if (empty($page)) {
            return redirect()->route('pages.index')->with('error', 'Page Not Found!');
        }
        return view('admin.pages.edit', compact('page'));
    }
    public function update($id, Request $request)
    {
        $page = Page::find($id);
        if (empty($page)) {
            return redirect()->route('pages.index')->with('error', 'Page Not Found!');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'content' => 'required'
        ]);
        if ($validator->passes()) {
            $page->name = $request->name;
            $page->content = $request->content;
            $page->save();
            return redirect()->route('pages.index')->with('success', 'Page Updated successfully!');

        } else {
            return redirect()->route('pages.create')->withErrors($validator)->withInput($request->only('name'));
        }
    }
    public function destroy($id)
    {
        $page = Page::find($id);
        if (empty($page)) {
            return response()->json([
                'status' => true,
                'error' => 'Page Not Found!'
            ]);
        }
        $page->delete();
        // return redirect()->route('categories.index')->with('success', 'Category delete successfully!');
        return response()->json([
            'status' => true,
            'success' => 'Page delete successfully!'
        ]);
    }
}
