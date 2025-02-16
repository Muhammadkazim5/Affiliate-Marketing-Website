<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\TempImage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::where('status', '!=', 'cancelled')->count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('final_total');
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 1)->count();

        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');
        //this month revenue
        $revenueThisMonth = Order::where('status', '!=', 'cancelled')->whereDate('created_at', '>=', $startOfMonth)->whereDate('created_at', '<=', $currentDate)->sum('final_total');
        //last month revenue
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastMonthName = Carbon::now()->subMonth()->endOfMonth()->format('M');
        $revenuelastMonth = Order::where('status', '!=', 'cancelled')->where('created_at', '>=', $lastMonthStartDate)->where('created_at', '<=', $lastMonthEndDate)->sum('final_total');

        // Delete temp images
        $dayBeforeToday = Carbon::now()->subDays(1)->format('Y-m-d H:i:s');
        $tempImages = TempImage::where('created_at', '<=', $dayBeforeToday)->get();

        foreach ($tempImages as $image) {
            $path = public_path('/temp/' . $image->name);
            $thumbPath = public_path('/temp/thumb/' . $image->name);

            // Delete main image
            if (File::exists($path)) {
                File::delete($path);
            }

            // Delete thumb image
            if (File::exists($thumbPath)) {
                File::delete($thumbPath);
            }

            // Delete record from database
            TempImage::where('id', $image->id)->delete();
        }
        // $admin = Auth::guard('admin')->user();
        return view('admin.dashboard', compact('totalOrders', 'totalProducts', 'totalUsers', 'totalRevenue', 'revenueThisMonth', 'revenuelastMonth', 'lastMonthName'));
        // echo 'welcome' . $admin->name . '<a href="' . route('admin.logout') . '">Logout</a>';
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');

    }
}
