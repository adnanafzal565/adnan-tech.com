<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator;

class TagController extends Controller
{
    public function add()
    {
        if (request()->isMethod("post"))
        {
            $validator = Validator::make(request()->all(), [
                "tag" => "required"
            ]);
         
            if ($validator->fails())
            {
                return response()->json([
                    "status" => "error",
                    "message" => $validator->errors()->first()
                ]);
            }

            $tag = request()->tag ?? "";

            $exists = DB::table('tags')
                ->where('name', $tag)
                ->exists();

            if ($exists)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "Tag already exists."
                ]);
            }

            DB::table('tags')->insert([
                'name' => $tag,
                "created_at" => now()->utc(),
                "updated_at" => now()->utc()
            ]);

            return response()->json([
                "status" => "success",
                "message" => "Tag has been added."
            ]);
        }
    }
}
