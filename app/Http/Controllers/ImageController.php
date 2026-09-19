<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            "image" => [
                "required",
                "image",
                "mimes:jpg,jpeg,png,gif,webp",
                "max:5120",
            ],
        ]);

        $image_path = $request
            ->file("image")
            ->store("editor/images", "public");

        return response()->json([
            "success" => true,
            "url" => asset("storage/" . $image_path),
        ]);
    }
}
