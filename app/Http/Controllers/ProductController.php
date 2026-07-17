<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function admin_index()
    {
        set_timezone();

        $products = Product::orderBy("id", "desc")
            ->paginate(config("config.PER_PAGE"));

        return view("admin/products/index", [
            "products" => $products
        ]);
    }
}
