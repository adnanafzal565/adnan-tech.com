<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator;

class CategoryController extends Controller
{
    public function add()
    {
        if (request()->isMethod("post"))
        {
            $validator = Validator::make(request()->all(), [
                "category" => "required"
            ]);
         
            if ($validator->fails())
            {
                return response()->json([
                    "status" => "error",
                    "message" => $validator->errors()->first()
                ]);
            }

            $category = request()->category ?? "";

            $exists = DB::table('categories')
                ->where('name', $category)
                ->exists();

            if ($exists)
            {
                return response()->json([
                    "status" => "error",
                    "message" => "Category already exists."
                ]);
            }

            DB::table('categories')->insert([
                'name' => $category,
                "created_at" => now()->utc(),
                "updated_at" => now()->utc()
            ]);

            return response()->json([
                "status" => "success",
                "message" => "Category has been added."
            ]);
        }
    }
}
