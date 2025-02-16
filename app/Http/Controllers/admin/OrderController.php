<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::latest('orders.created_at')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->select('orders.*', 'users.name', 'users.email'); // Add specific columns if needed

        if ($request->get('keyword') != "") {
            $orders = $orders->where('orders.first_name', 'like', '%' . $request->keyword . '%');
            $orders = $orders->orWhere('users.email', 'like', '%' . $request->keyword . '%');
            $orders = $orders->orWhere('orders.id', 'like', '%' . $request->keyword . '%');

        }

        $orders = $orders->paginate(3);

        return view('admin.orders.list', compact('orders'));

    }
    public function detail($orderId)
    {
        $order = Order::select('orders.*', 'countries.name as countryName')
            ->where('orders.id', $orderId)
            ->leftJoin('countries', 'countries.id', 'orders.country_id')
            ->first();
        $orderItem = OrderItem::where('order_id', $orderId)->get();
        return view('admin.orders.detail', compact('order', 'orderItem'));
    }
    public function changeOrderStatus(Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = $request->status;
        $order->shipped_date = $request->shipped_date;
        $order->save();
        session()->flash('success', 'Order Status Changed Successfully');
        return response()->json([
            'status' => true,
            'message' => 'Status Changed Successfully'
        ]);

    }

    public function sendInvoiceEmail(Request $request, $orderId)
    {
        orderEmail($orderId, $request->userType);
        session()->flash('success', 'Order email send Successfully');
        return response()->json([
            'status' => true,
            'message' => 'Order email send Successfully'
        ]);
    }
}
