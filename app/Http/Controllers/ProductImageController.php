<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function destroy($imageId)
    {
        $image = ProductImage::find($imageId);
        $image->delete();

        return response()->json(['success' => 'Image was delete successfully']);
    }
}
