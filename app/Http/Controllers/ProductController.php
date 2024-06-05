<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function details($id)
    {
        $product = $this->product->findOrFail($id);

        $r_products = $this->product::where('gender', $product->gender)
            ->whereHas('mainCategory', function ($query) use ($product) {
                $query->where('name', $product->mainCategory->name);
            })
            ->whereHas('productCategory', function ($query) use ($product) {
                $query->whereIn('category_id', $product->productCategory()->pluck('category_id'));
            })
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(3)
            ->get();

        return view('user.product.details')->with('product', $product)->with('r_products', $r_products);
    }
    public function handleRequest(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = $this->product::findOrFail($id);

        // Check if requested quantity is available
        if ($request->quantity > $product->quantity) {
            return redirect()->back()->with('invalid_quantity', 'Quantity cannot exceed the stock');
        }

        // Determine which action to take
        if ($request->action === 'buy') {
            return $this->buy($request, $product);
        } elseif ($request->action === 'add_to_cart') {
            return $this->addCart($request, $product);
        }

        return redirect()->back()->with('error', 'Invalid action');
    }

    private function buy(Request $request, $product)
    {
        $r_products = $this->product::where('gender', $product->gender)
            ->whereHas('mainCategory', function ($query) use ($product) {
                $query->where('name', $product->mainCategory->name);
            })
            ->whereHas('productCategory', function ($query) use ($product) {
                $query->whereIn('category_id', $product->productCategory()->pluck('category_id'));
            })
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(3)
            ->get();

        return view('user.product.buy')->with('quantity', $request->quantity)
            ->with('product', $product)
            ->with('r_products', $r_products);
    }

    private function addCart(Request $request, $product)
    {
        Cart::insert([
            'product_id' => $product->id,
            'user_id' => Auth::user()->id,
            'quantity' => $request->quantity,
            'created_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function buyFromCart(Request $request, $id)
    {
        $product = $this->product->findOrFail($id);
        $r_products = $this->product::where('gender', $product->gender)
            ->whereHas('mainCategory', function ($query) use ($product) {
                $query->where('name', $product->mainCategory->name);
            })
            ->whereHas('productCategory', function ($query) use ($product) {
                $query->whereIn('category_id', $product->productCategory()->pluck('category_id'));
            })
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(3)
            ->get();

        return view('user.product.buy_from_cart')->with('quantity', $request->quantity)
            ->with('product', $product)
            ->with('r_products', $r_products);
    }
}
