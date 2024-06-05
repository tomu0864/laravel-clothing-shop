<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private $product;
    private $cart;

    public function __construct(Product $product, Cart $cart)
    {
        $this->product = $product;
        $this->cart = $cart;
    }

    public function index()
    {
        $carts = $this->cart->where('user_id', Auth::user()->id)->latest()->get();

        return view('cart.index')->with('carts', $carts);
    }

    public function delete($id)
    {
        $this->cart->findOrFail($id)->delete();

        return redirect()->back();
    }
}
