<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Jackiedo\Cart\Facades\Cart;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filterCategorySlog = $request->get('category');
        $categories = Category::take(11)->get();
        $category = Category::where('slog', $filterCategorySlog)->first();
        // dd($category);
    
if($category)
{
    $products = $category->products()->get();
}

else{
    $products = Product::all();
}
        return view('product.list',[
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function show($slog)
    {
        
        $product = Product::where('slog', $slog)->first();
        // dd($product->categories);
        return view('product.show',[
            'product'=> $product
        ]);
    }
}
