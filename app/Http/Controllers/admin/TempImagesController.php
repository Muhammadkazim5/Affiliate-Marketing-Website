<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
class TempImagesController extends Controller
{
    public function store(Request $request)
    {
        $image = $request->image;
        if (!empty($request->image)) {
            $ext = $image->getClientOriginalExtension();
            $tempImage = new TempImage();
            $tempImage->name = 'NULL';
            $tempImage->save();
            $imageName = $tempImage->id . '.' . $ext;
            $tempImage->name = $imageName;
            $tempImage->save();
            $tempImage->name = $imageName;
            $tempImage->save();
            $image->move(public_path('uploads/temp/'), $imageName);

            // create thumbnail
            $sourcePath = public_path('uploads/temp/') . $imageName;
            $destPath = public_path('uploads/temp/thumb/') . $imageName;
            $image = Image::make($sourcePath);
            $image->fit(300, 275);
            $image->save($destPath);
            return response()->json([
                'status' => true,
                'Image_id' => $tempImage->id,
                'name' => $imageName,
                'ImagePath' => asset('uploads/temp/thumb/' . $imageName),
                'message' => "image uploaded successfully"
            ]);
        }

    }
}