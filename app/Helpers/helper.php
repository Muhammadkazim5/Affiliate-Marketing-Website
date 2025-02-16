<?php

use App\Mail\OrderMail;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\Page;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Mail;

function getCategories()
{
    return Category::orderBy('name', 'ASC')->with('sub_category')->orderBy('id', 'DESC')->where('status', 1)->get();
}
function getProductImage($id)
{
    return ProductImage::where('product_id', $id)->first();
}
function orderEmail($orderId, $userType = "customer")
{
    $order = Order::where('id', $orderId)->with('items')->first();
    // dd($order);
    if ($userType == "customer") {
        $subject = "Thanks for your Order";
        $email = $order->email;
    } else {
        $subject = "You have received an Order";
        $email = env('ADMIN_EMAIL');
    }
    $mailData = [
        'subject' => $subject,
        'order' => $order,
        'userType' => $userType
    ];
    Mail::to($email)->send(new OrderMail($mailData));
}
function getCountryInfo($id)
{
    return Country::where('id', $id)->first();
}
function staticPages()
{
    $page = Page::orderBy('name', 'ASC')->get();
    return $page;
}

