<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null)
    {
        $categorySelected = '';
        $subCategorySelected = '';
        $categories = Category::orderBy('name', 'ASC')->with('sub_category')->where('status', 1)->get();
        $products = Product::orderBy('id', 'DESC')->where('status', 1)->get();
        // $products = Product::whereNot('affiliate_product', 'Yes');
        $products = Product::where('status', 1);
        //    apply filters here
        if (!empty($categorySlug)) {
            $category = Category::where('slug', $categorySlug)->first();
            $products = Product::where('category_id', $category->id);
            $categorySelected = $category->id;
        }
        if (!empty($subCategorySlug)) {
            $subcategory = SubCategory::where('slug', $subCategorySlug)->first();
            $products = Product::where('sub_category_id', $subcategory->id);
            $subCategorySelected = $subcategory->id;
        }
        if ($request->get('price_max') != '' && $request->get('price_min') != '') {
            if ($request->get('price_max') == 1000) {

                $products = $products->whereBetween('price', [intval($request->get('price_min')), 100000]);
            } else {
                $products = $products->whereBetween('price', [intval($request->get('price_min')), intval($request->get('price_max'))]);

            }
        }

        if (!empty($request->get('search'))) {
            $products = $products->where('name', 'like', '%' . $request->get('search') . '%');
        }

        if ($request->get('sort') != '') {
            if ($request->get('sort') == 'latest') {

                $products = $products->orderBy('id', 'DESC');
            } else if ($request->get('sort') == 'price_asc') {
                $products = $products->orderBy('price', 'ASC');
            } else {
                $products = $products->orderBy('price', 'DESC');
            }

        } else {
            $products = $products->orderBy('id', 'DESC');
        }
        $data['priceMax'] = (intval($request->get('price_max')) == 0) ? 1000 : $request->get('price_max');
        $data['priceMin'] = intval($request->get('price_min'));
        $data['sort'] = $request->get('sort');
        $products = $products->orderBy('id', 'DESC');
        $products = $products->paginate(6);
        return view('front.shop', $data, compact('subCategorySelected', 'categorySelected', 'categories', 'products'));
    }

    // rating section 
    public function product($slug)
    {
        $product = Product::where('slug', $slug)->withCount('product_ratings')->withSum('product_ratings', 'rating')->first();
        // dd($product);
        if ($product == null) {
            abort(404);
        }
        //avg rating
        $avgRating = '0.00';
        $avgRatingPer = 0;
        if ($product->product_ratings_count > 0) {

            $avgRating = number_format(($product->product_ratings_sum_rating / $product->product_ratings_count), 2);
            $avgRatingPer = ($avgRating * 100) / 5;
        }

        $data['product'] = $product;
        $data['avgRating'] = $avgRating;
        $data['avgRatingPer'] = $avgRatingPer;
        return view('front.product', $data);
    }

    public function saveRating(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'comment' => 'required|min:5',
            'rating' => 'required',
        ]);
        $count = ProductRating::where('email', $request->email)->count();
        if ($count > 0) {
            session()->flash('success', 'You already rated this product.');
            return response()->json([
                'status' => true,
            ]);
        }
        if ($validator->passes()) {
            $productRating = new ProductRating;
            $productRating->product_id = $id;
            $productRating->username = $request->name;
            $productRating->email = $request->email;
            $productRating->comment = $request->comment;
            $productRating->rating = $request->rating;
            $productRating->status = 0;
            $productRating->save();
            session()->flash('success', 'Thanks for your Rating.');
            return response()->json([
                'status' => true,
                'message' => "Thanks for your Rating."
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
