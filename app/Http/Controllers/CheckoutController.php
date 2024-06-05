<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class CheckoutController extends Controller
{
    private $order;
    private $product;

    private $cart;

    public function __construct(Order $order, Product $product, Cart $cart)
    {
        $this->order = $order;
        $this->product = $product;
        $this->cart = $cart;
    }

    public function checkoutMulti(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'password' => 'required|string',
            'product_id.*' => 'required|exists:products,id',
            'quantity.*' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $productId = $request->product_id[array_search($attribute, $request->quantity)];
                    $product = Product::findOrFail($productId);
                    if ($value > $product->quantity) {
                        $fail('The quantity for ' . $product->name . ' exceeds the available stock.');
                    }
                },
            ],
        ]);

        // If quantity in the cart exceeds stock, redierect back with error message
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // Password check
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('invalid_password', 'password does not match');
        }

        // Insert data individually to orders table
        foreach ($request->product_id as $index => $productId) {
            $product = $this->product::findOrFail($productId);
            $quantity = $request->quantity[$index];

            $subtotal = $product->price * $quantity;
            $discount = $product->getDiscount() * $quantity;
            $totalPrice = $subtotal - $discount;

            $this->order::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'total_price' => $totalPrice,
                'quantity' => $quantity,
                'order_number' => rand(000000000, 999999999),
                'address' => $request->address,
            ]);

            // Decrease quantity(stock)
            $product->quantity -= $quantity;
            $product->save();
        }


        // Delete all products out of the cart
        $this->cart->where('user_id', $user->id)->delete();

        return redirect()->back()->with('success', 'Thank your for your purchase!');
    }

    public function cartcheckout(Request $request, $id)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'password' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        // Password check
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('invalid_password', 'password does not match');
        }

        $quantity = $request->quantity;
        $product = $this->product->findOrFail($id);
        $subtotal = $product->price * $quantity;
        $discount = $product->getDiscount() * $quantity;
        $totalPrice = $subtotal - $discount;

        if ($request->quantity > $product->quantity) {
            return redirect()->back()->with('exceed_quantity', 'Quantity can not exceed stock');
        }

        $this->order->Insert([
            'user_id' => $user->id,
            'product_id' => $id,
            'total_price' => $totalPrice,
            'quantity' => $quantity,
            'address' => $request->address,
            'order_number' => rand(000000000, 999999999),
            'created_at' => Carbon::now(),
        ]);

        $product->quantity -= $quantity;
        $product->save();

        $this->cart->where('product_id', $product->id)->where('user_id', $user->id)->delete();

        return redirect()->route('cart.index')->with('success', 'Thank your for your purchase!');
    }

    public function checkout(Request $request, $id)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'password' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        // Password check
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('invalid_password', 'password does not match');
        }

        $quantity = $request->quantity;
        $product = $this->product->findOrFail($id);
        $subtotal = $product->price * $quantity;
        $discount = $product->getDiscount() * $quantity;
        $totalPrice = $subtotal - $discount;

        if ($request->quantity > $product->quantity) {
            return redirect()->back()->with('exceed_quantity', 'Quantity can not exceed stock');
        }

        $this->order->Insert([
            'user_id' => $user->id,
            'product_id' => $id,
            'total_price' => $totalPrice,
            'quantity' => $quantity,
            'order_number' => rand(000000000, 999999999),
            'address' => $request->address,
            'created_at' => Carbon::now(),
        ]);

        $product->quantity -= $quantity;
        $product->save();

        return redirect()->route('home')->with('success', 'Thank your for your purchase!');;
    }
}
