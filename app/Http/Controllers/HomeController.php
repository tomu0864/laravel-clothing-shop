<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $product;
    private $mainCategory;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(Product $product, MainCategory $mainCategory)
    {
        $this->product = $product;
        $this->mainCategory = $mainCategory;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $l_products = $this->product->latest()->take(8)->where('quantity', '>', '0')->get();
        $m_products = $this->product->latest()->where('gender', 'M')->take(8)->where('quantity', '>', '0')->get();
        $w_products = $this->product->latest()->where('gender', 'W')->take(8)->where('quantity', '>', '0')->get();
        $s_products = $this->product->latest()->where('discount', '>', '0')->where('quantity', '>', '0')->take(8)->get();

        return view('home', compact('l_products', 'm_products', 'w_products', 's_products'));
    }

    public function genre(Request $request)
    {
        $genre = '';

        if ($request->genre == 'M') {
            $products = Product::where('gender', 'M')->latest()->get();
            $genre = 'Men';
        } elseif ($request->genre == 'W') {
            $products = Product::where('gender', 'W')->latest()->get();
            $genre = 'Women';
        } elseif ($request->genre == 'sale') {
            $products = Product::where('discount', '>', '0')->latest()->get();
            $genre = 'Sale';
        } elseif ($request->search) {
            $products = Product::latest()
                ->where(function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('short_desc', 'LIKE', '%' . $request->search . '%');
                })
                ->paginate(12);
            $genre = "Search results for: $request->search";
        } elseif ($request->category) {
            $category = MainCategory::findOrFail($request->category);
            $products = Product::where('main_category_id', $request->category)->latest()->get();
            $genre = $category->name;
        } else {
            // Handle default case to ensure products is always a LengthAwarePaginator instance
            $products = Product::latest()->get();
            $genre = 'All Products';
        }

        return view('gender_sale', compact('products', 'genre'));
    }
}
