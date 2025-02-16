<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function showChangePassword()
    {
        return view('admin.change-password');
    }
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);
        $admin = User::where('id', Auth::guard('admin')->id())->first();
        if ($validator->passes()) {
            if (!Hash::check($request->old_password, $admin->password)) {
                session()->flash('error', 'Your old password is Incorrect, please try again.');
                return response()->json([
                    'status' => true,
                ]);
            }

            User::where('id', Auth::guard('admin')->id())->update([
                'password' => Hash::make($request->new_password)
            ]);
            session()->flash('success', 'You have successfully changed your password');
            return response()->json([
                'status' => true,
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
