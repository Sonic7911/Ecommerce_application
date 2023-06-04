<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::take(11)->get();
        $products = Product::all();
        return view('product.list',[
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function show($slog)
    {
        $product = Product::where('slog', $slog)->first();
        dd($product->categories);
        return view('product.show',[
            'product'=> $product
        ]);
    }
}
