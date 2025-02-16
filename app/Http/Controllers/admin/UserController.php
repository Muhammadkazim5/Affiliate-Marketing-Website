<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::latest();
        if (!empty($request->get('keyword'))) {
            $users = $users->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $users = $users->paginate(3);
        return view('admin.users.list', compact('users'));
    }
    public function create()
    {
        return view('admin.users.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|min:5',
        ]);
        if ($validator->passes()) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->status = $request->status;
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('users.index')->with('success', 'User created successfully!');

        } else {
            return redirect()->route('users.create')->withErrors($validator)->withInput($request->only('name'));
        }
    }
    public function edit($id, Request $request)
    {
        $user = User::find($id);
        if (empty($user)) {
            return redirect()->route('users.index')->with('error', 'User Not Found!');
        }
        return view('admin.users.edit', compact('user'));
    }
    public function update($id, Request $request)
    {
        $user = User::find($id);
        if (empty($user)) {
            return redirect()->route('users.index')->with('error', 'User Not Found!');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            'phone' => 'required',
        ]);
        if ($validator->passes()) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->status = $request->status;
            if ($request->password != '') {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            return redirect()->route('users.index')->with('success', 'User Updated successfully!');

        } else {
            return redirect()->route('users.index')->with('error', 'User Not Update');
        }
    }
    public function destroy($id, Request $request)
    {
        $user = User::find($id);
        if (empty($user)) {
            return response()->json([
                'status' => true,
                'error' => 'User Not Found!'
            ]);
        }
        $user->delete();
        // return redirect()->route('categories.index')->with('success', 'Category delete successfully!');
        return response()->json([
            'status' => true,
            'success' => 'User delete successfully!'
        ]);
    }
}
