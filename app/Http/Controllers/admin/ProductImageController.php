<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
class ProductImageController extends Controller
{
    public function update(Request $request)
    {
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $tempImageLocation = $image->getPathName();
        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'Null'; // Temporarily set to 'Null'
        $productImage->save();

        $newImageName = $productImage->id . '.' . $ext;
        $productImage->image = $newImageName;
        $productImage->save();

        // first thumbnail // Small image
        $sPaths = $tempImageLocation;
        $dPaths = public_path('uploads/products/small/') . $newImageName;
        $image = Image::make($sPaths);
        $image->fit(300, 300);
        $image->save($dPaths);

        // second thumbnail // large image
        $sPathl = $tempImageLocation;
        $dPathl = public_path('uploads/products/large/') . $newImageName;
        $image = Image::make($sPathl);
        $image->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($dPathl);

        return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'imagePath' => asset('uploads/products/small/' . $productImage->image),
            'message' => 'image saved successfully'
        ]);

    }
    public function destroy(Request $request)
    {
        $productImage = ProductImage::find($request->id);
        if (empty($productImage)) {
            return response()->json([
                'status' => false,
                'message' => 'image not found'
            ]);
        }
        //delete image from folder
        File::delete(public_path('uploads/products/large/' . $productImage->image));
        File::delete(public_path('uploads/products/small/' . $productImage->image));
        $productImage->delete();
        return response()->json([
            'status' => true,
            'message' => 'image delete saved successfully'
        ]);
    }
}
