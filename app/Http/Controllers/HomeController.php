<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Page;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $latestproducts = Product::orderBy('id', 'DESC')->where('is_featured', 'No')->where('affiliate_product', 'No')->where('status', 1)->take(8)->get();
        $affiproducts = Product::orderBy('id', 'DESC')->where('affiliate_product', 'Yes')->where('is_featured', 'No')->where('status', 1)->take(8)->get();
        $featuredproducts = Product::orderBy('id', 'DESC')->where('is_featured', 'Yes')->where('affiliate_product', 'No')->where('status', 1)->take(8)->get();
        return view('front.home', compact('latestproducts', 'featuredproducts', 'affiproducts'));
    }
    public function page($name)
    {
        $page = Page::where('name', $name)->first();
        if ($page == null) {
            abort(404);
        }
        return view('front.page', compact('page'));
    }
    public function sendContactEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required|min:10',

        ]);
        if ($validator->passes()) {
            $mailData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'mail_subject' => "You have recieved a contact email"
            ];
            $admin = User::where('id', 3)->first();
            Mail::to($admin->email)->send(new ContactMail($mailData));
            session()->flash('success', 'Thanks for Contacting us, we will get back to you soon.');
            return response()->json([
                'status' => true,
                'message' => "Thanks for Contacting us, we will get back to you soon."
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function addToWishlist(Request $request)
    {
        if (Auth::check() == false) {
            session(['url.intended' => url()->previous()]);
            return response()->json([
                'status' => false,
            ]);
        }
        Wishlist::updateOrCreate(['user_id' => Auth::user()->id, 'product_id' => $request->id], ['user_id' => Auth::user()->id, 'product_id' => $request->id]);
        // $wishlist = new Wishlist;
        // $wishlist->user_id = Auth::user()->id;
        // $wishlist->product_id = $request->id;
        // $wishlist->save();
        $product = Product::where('id', $request->id)->first();
        if ($product == null) {
            return response()->json([
                'status' => true,
                'message' => '<div class="alert alert-danger"> Product not found.</div>'
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => '<div class="alert alert-success"><strong> "' . $product->name . '"</strong> added in your wishlist</div>'
        ]);
    }


}
