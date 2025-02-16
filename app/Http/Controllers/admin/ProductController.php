<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductRating;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::select(
            'products.*',
            'categories.name as categoryName',
            'sub_categories.name as subCategoryName'
        )->with('product_images')
            ->latest('products.id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->leftJoin('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id');

        // Apply the search filter before fetching the results
        if (!empty($request->get('keyword'))) {
            $products = $products->where('products.name', 'like', '%' . $request->get('keyword') . '%');
        }

        // Paginate after applying filters
        $products = $products->paginate(3);
        return view('admin.product.list', compact('products'));
    }
    public function create()
    {

        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategories = SubCategory::orderBy('name', 'ASC')->get();
        return view('admin.product.create', compact('categories', 'subcategories'));
    }
    public function store(Request $request)
    {

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'description' => 'required',
            'category_id' => 'required|numeric',
            'sub_category' => 'required|exists:sub_categories,id',
            // 'affiliate_link' => 'required|url',
            'is_featured' => 'required|in:Yes,No',
            'status' => 'required',

            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            // 'size' => 'array',
            // 'size.*' => 'in:S,M,L,XL,XXL',

        ];
        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['quantity'] = 'required|numeric';
        }
        $validator = Validator::make($request->all(), $rules);
        // $sizes = $request->input('size', []);
        if ($validator->passes()) {
            $product = new Product;
            $product->name = $request->title;
            $product->slug = $request->slug;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->description = $request->description;
            $product->status = $request->status;
            $product->sku = $request->sku;
            $product->track_qty = $request->track_qty;
            $product->barcode = $request->barcode;
            $product->quantity = $request->quantity;
            // $product->sizes = $sizes;
            $product->is_featured = $request->is_featured;
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category;
            $product->affiliate_product = $request->affiliate_product;
            $product->affiliate_link = $request->affiliate_link;
            $product->save();

            // Check if images were uploaded
            if (!empty($request->image_id)) {
                foreach ($request->image_id as $key => $imageId) {
                    // Fetch the TempImage record
                    $tempImage = TempImage::find($imageId);

                    // Check if TempImage record exists
                    if (!$tempImage) {
                        // Handle the case where the TempImage doesn't exist (either skip or return an error)
                        return redirect()->back()->withErrors('Temp image not found for ID: ' . $imageId);
                    }

                    $extArray = explode('.', $tempImage->name);
                    $ext = last($extArray);
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'Null'; // Temporarily set to 'Null'
                    $productImage->save();

                    $newImageName = $productImage->id . '.' . $ext;
                    $productImage->image = $newImageName;
                    $productImage->save();

                    // first thumbnail // Small image
                    $sPaths = public_path('uploads/temp/') . $tempImage->name;
                    $dPaths = public_path('uploads/products/small/') . $newImageName;
                    $image = Image::make($sPaths);
                    $image->fit(300, 300);
                    $image->save($dPaths);

                    // second thumbnail // large image
                    $sPathl = public_path('uploads/temp/') . $tempImage->name;
                    $dPathl = public_path('uploads/products/large/') . $newImageName;
                    $image = Image::make($sPathl);
                    $image->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $image->save($dPathl);
                }
            }
            //end image
            session()->flash('success', 'Product Added Successfully.');
            return response()->json([
                'status' => true,
                'message' => "Product Added Successfully.",
            ]);
        } else {
            // return redirect()->route('products.create')->withErrors($validator)->withInput($request->only('name'));
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function edit($productId, Request $request)
    {
        $product = Product::find($productId);
        $categories = Category::orderBy('name', 'ASC')->get();
        $subcategory = SubCategory::where('category_id', $product->category_id)->get();
        if (empty($product)) {
            return redirect()->route('products.index')->with('error', 'product not found');
        }
        //fetch product images
        $productImage = ProductImage::where('product_id', $product->id)->get();
        return view('admin.product.edit', compact('productImage', 'subcategory', 'categories', 'product'));
    }
    public function update($productId, Request $request)
    {
        $product = Product::find($productId);
        if (empty($product)) {
            return response()->json([
                'status' => false,
                'message' => "Product Not Found.",
            ]);
        }
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id . ',id',
            'price' => 'required|numeric',
            'description' => 'required',
            'category_id' => 'required|numeric',
            'sub_category' => 'required|exists:sub_categories,id',
            // 'affiliate_link' => 'required|url',
            'is_featured' => 'required|in:Yes,No',
            'status' => 'required',
            'sku' => 'required|unique:products,sku,' . $product->id . ',id',
            'track_qty' => 'required|in:Yes,No'

        ];
        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['quantity'] = 'required|numeric';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $product->name = $request->title;
            $product->slug = $request->slug;
            $product->price = $request->price;
            $product->sku = $request->sku;
            $product->track_qty = $request->track_qty;
            $product->barcode = $request->barcode;
            $product->quantity = $request->quantity;
            $product->description = $request->description;
            $product->status = $request->status;
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category;
            $product->affiliate_product = $request->affiliate_product;
            $product->affiliate_link = $request->affiliate_link;
            $product->save();
            session()->flash('success', 'Product updated Successfully.');
            return response()->json([
                'status' => true,
                'message' => "Product updated Successfully.",
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function destroy($productId)
    {
        $product = Product::find($productId);
        if (empty($product)) {
            return response()->json([
                'status' => true,
                'error' => 'Product Not Found!'
            ]);
        }
        $product->delete();
        // return redirect()->route('categories.index')->with('success', 'Category delete successfully!');
        return response()->json([
            'status' => true,
            'success' => 'Product delete successfully!'
        ]);
    }
    public function getProducts(Request $request)
    {
        $tempProduct = [];
        if ($request->term != "") {
            $products = Product::where('title', 'like', '%' . $request->term . '%')->get();
            if ($products->isNotEmpty()) {
                foreach ($products as $product) {
                    $tempProduct[] = array('id' => $product->id, 'text' => $product->title);
                }
            }
        }
        return response()->json([
            'tags' => $tempProduct,
            'status' => true
        ]);

    }

    public function productRatings(Request $request)
    {
        $ratings = ProductRating::select('product_ratings.*', 'products.name as productTitle')->orderBy('product_ratings.created_at', 'DESC');
        $ratings = $ratings->leftJoin('products', 'products.id', 'product_ratings.product_id');
        if (!empty($request->get('keyword'))) {
            $ratings = $ratings->where(function ($query) use ($request) {
                $query->orWhere('products.name', 'like', '%' . $request->get('keyword') . '%')
                    ->orWhere('product_ratings.username', 'like', '%' . $request->get('keyword') . '%');
            });
        }
        $ratings = $ratings->paginate(5);

        return view('admin.product.ratings', compact('ratings'));
    }
    public function changeRatingStatus(Request $request)
    {
        $productRating = ProductRating::find($request->id);
        $productRating->status = $request->status;
        $productRating->save();
        session()->flash('success', 'Rating status change successfully');
        return response()->json([
            'status' => true
        ]);
    }
}
