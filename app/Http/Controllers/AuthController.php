<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Wishlist;
class AuthController extends Controller
{
    public function register()
    {
        return view('front.account.register');
    }
    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed',
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();
            session()->flash('success', 'You have register successfully');
            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->toArray() // Convert errors to array
            ]);
        }
    }
    public function login()
    {
        return view('front.account.login');
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
                // Authentication successful, proceed with logic
                $intendedUrl = session()->pull('url.intended', route('account.profile')); // Remove the intended URL after retrieving it
                return redirect($intendedUrl);
            } else {
                session()->flash('error', 'Either email or password is incorrect');
                return redirect()->route('account.login')->withInput($request->only('email'));
            }
        } else {
            return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('email'));
        }
    }
    public function profile()
    {
        $userId = Auth::user()->id;
        $countries = Country::orderBy('name', 'ASC')->get();
        $user = User::where('id', $userId)->first();
        $address = CustomerAddress::where('user_id', $userId)->first();
        return view('front.account.profile', ['user' => $user, 'address' => $address, 'countries' => $countries]);
    }
    public function updateProfile(Request $request)
    {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $userId . ',id',
            'phone' => 'required'
        ]);
        if ($validator->passes()) {
            $user = User::find($userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();
            session()->flash('success', 'Profile Updated Successfully');
            return response()->json([
                'status' => true,
                'message' => 'Profile Updated Successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function updateAddress(Request $request)
    {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:5',
            'last_name' => 'required',
            'email' => 'required|email',
            'country_id' => 'required',
            'address' => 'required|min:10',
            // 'house_no' => 'required',
            'city' => 'required',
            'district' => 'required',
            'zip' => 'required',
            'mobile' => 'required',

        ]);
        if ($validator->passes()) {
            CustomerAddress::updateOrCreate(
                ['user_id' => $userId],
                [
                    'user_id' => $userId,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'country_id' => $request->country_id,
                    'address' => $request->address,
                    'house_no' => $request->house_no,
                    'city' => $request->city,
                    'district' => $request->district,
                    'zip' => $request->zip,
                    'mobile' => $request->mobile,
                ]
            );
            session()->flash('success', 'Address Updated Successfully');
            return response()->json([
                'status' => true,
                'message' => 'Address Updated Successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login')->with('success', 'Logout Successfully');
        ;
    }
    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        return view('front.account.orders', compact('orders'));
    }
    public function orderDetails($id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('id', $id)->first();
        $orderItems = OrderItem::where('order_id', $id)->get();
        $orderItemCount = OrderItem::where('order_id', $id)->count();
        return view('front.account.order-detail', compact('order', 'orderItems', 'orderItemCount'));
    }
    public function showChangePassword()
    {
        return view('front.account.change-password');
    }
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);
        if ($validator->passes()) {
            $user = User::select('id', 'password')->where('id', Auth::user()->id)->first();
            if (!Hash::check($request->old_password, $user->password)) {
                session()->flash('error', 'Your old password is Incorrect, please try again.');
                return response()->json([
                    'status' => true,
                ]);
            }

            User::where('id', $user->id)->update([
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
    public function forgetPassword()
    {
        return view('front.account.forget-password');
    }
    public function processForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);
        if ($validator->passes()) {
            $token = Str::random(60);
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now()
            ]);
            $user = User::where('email', $request->email)->first();
            $formData = [
                'token' => $token,
                'user' => $user,
                'mailSubject' => 'You have requested to reset your password'
            ];
            Mail::to($request->email)->send(new ResetPasswordEmail($formData));
            return redirect()->route('account.forgetPassword')->with('success', 'please check your inbox to reset password.');
        } else {
            return redirect()->route('account.forgetPassword')->withInput()->withErrors($validator);
        }
    }
    public function resetPassword($token)
    {
        $tokenExist = DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($tokenExist == null) {
            return redirect()->route('account.forgetPassword')->with('error', 'Invalid Request');
        }
        return view('front.account.reset-password', compact('token'));
    }
    public function processResetPassword(Request $request)
    {
        $token = $request->token;
        $tokenExist = DB::table('password_reset_tokens')->where('token', $token)->first();
        if ($tokenExist == null) {
            return redirect()->route('account.forgetPassword')->with('error', 'Invalid Request');
        }
        $user = User::where('email', $tokenExist->email)->first();
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password'
        ]);
        if ($validator->passes()) {
            User::where('id', $user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();

            return redirect()->route('account.login', )->with('success', 'You have Successfully Reset your Password .');

        } else {
            return redirect()->route('account.resetPassword', ['token' => $token])->withErrors($validator);

        }
    }
    public function wishlist()
    {
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->with('product')->get();
        return view('front.account.wishlist', compact('wishlists'));
    }
    public function removeProductFromWishlist(Request $request)
    {
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->where('product_id', $request->id)->first();
        if ($wishlists == null) {
            session()->flash('error', 'Product already remove');
            return response()->json([
                'status' => true,
            ]);
        } else {
            $wishlists::where('user_id', Auth::user()->id)->where('product_id', $request->id)->delete();
            session()->flash('error', 'Product remove successfully');
            return response()->json([
                'status' => true,
            ]);
        }
    }
}
