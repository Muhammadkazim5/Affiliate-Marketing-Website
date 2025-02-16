<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::with('product_images')->find($request->id);
        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Record Not Found'
            ]);
        }
        if (Cart::count() > 0) {
            // echo "already added";
            $cartContent = Cart::content();
            $productAlreadyExist = false;
            foreach ($cartContent as $item) {
                if ($item->id == $product->id) {
                    $productAlreadyExist = true;
                }

            }
            if ($productAlreadyExist == false) {
                Cart::add($product->id, $product->name, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
                $status = true;
                $message = '<strong>' . $product->name . '</strong> added in your cart successfully';
                session()->flash('success', $message);

            } else {
                $status = false;
                $message = $product->name . ' already added in cart';
            }
        } else {
            // echo "cart is empty now added";
            Cart::add($product->id, $product->name, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);

            $status = true;
            $message = '<strong>' . $product->name . '</strong> added in your cart successfully';
            session()->flash('success', $message);
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
        // Cart::add('293ad', 'Product 1', 1, 9.99);
    }

    public function cart()
    {
        $cartContent = Cart::content();
        // dd($cartContent);
        // $data['cartContent'] = $cartContent;
        return view('front.cart', compact('cartContent'));
    }
    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty);
        $message = 'cart update successfully';
        session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
    public function deleteItem(Request $request)
    {
        $rowId = $request->rowId;
        $itemInfo = Cart::get($rowId);
        if ($itemInfo == null) {
            session()->flash('error', 'item not found in cart');
            return response()->json([
                'status' => false,
                'message' => 'item not found in cart'
            ]);
        }
        Cart::remove($rowId);
        session()->flash('success', 'Item deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Item deleted successfully'
        ]);
    }
    public function checkout()
    {
        if (Cart::count() == 0) {
            session()->flash('error', 'Your cart is empty. Please add items to proceed.');
            return redirect()->route('front.cart');
        }
        if (Auth::check() == false) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);

            }
            return redirect()->route('account.login');
        }

        $customerAddress = CustomerAddress::where('user_id', $user = Auth::user()->id)->first();

        session()->forget('url.intended');
        $countries = Country::orderBy('name', 'ASC')->get();
        return view('front.checkout', compact('countries', 'customerAddress'));
    }

    public function processCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:5',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required|min:10',
            'city' => 'required',
            'district' => 'required',
            'zip' => 'required',
            'mobile' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the error',
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        //save customer details
        $user = Auth::user();
        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'country_id' => $request->country,
                'address' => $request->address,
                'house_no' => $request->houseNumber,
                'city' => $request->city,
                'district' => $request->district,
                'zip' => $request->zip,
                'mobile' => $request->mobile,
            ]
        );
        //store data in order table
        if ($request->payment_method == 'cod') {
            $shipping = 0;
            $discount = 0;
            $subTotal = Cart::subtotal(2, '.', '');
            $finalTotal = $subTotal + $shipping;
            $order = new Order;
            $order->subtotal = $subTotal;
            $order->shipping = $shipping;
            // $order->discount=$discount;
            $order->final_total = $finalTotal;
            $order->user_id = $user->id;
            $order->payment_status = "not paid";
            $order->status = "pending";
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->address = $request->address;
            $order->mobile = $request->mobile;
            $order->house_no = $request->houseNumber;
            $order->country_id = $request->country;
            $order->city = $request->city;
            $order->district = $request->district;
            $order->zip = $request->zip;
            $order->notes = $request->notes;
            $order->save();
            // store order items in orderitem table
            foreach (Cart::content() as $item) {
                # code...
                $orderItem = new OrderItem;
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->name = $item->name;
                $orderItem->qty = $item->qty;
                $orderItem->price = $item->price;
                $orderItem->total = $item->price * $item->qty;
                $orderItem->save();

                //update product stock
                $productData = Product::find($item->id);
                if ($productData->track_qty == 'Yes') {
                    $currentQty = $productData->quantity;
                    $updateQty = $currentQty - $item->qty;
                    $productData->quantity = $updateQty;
                    $productData->save();
                }

            }



            //send email
            orderEmail($order->id, 'customer');
            session()->flash('success', 'You have Successfully placed your order.');
            Cart::destroy();
            return response()->json([
                'message' => 'order saved Successfully',
                'orderId' => $order->id,
                'status' => true

            ]);
        } else {

        }

    }
    public function thankyou($id)
    {
        return view('front.thanks', compact('id'));
    }
}