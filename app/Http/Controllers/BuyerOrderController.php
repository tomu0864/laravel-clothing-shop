<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerOrderController extends Controller
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function show()
    {
        $orders = $this->order->where('user_id', Auth::user()->id)->get();

        return view('user.order.show')->with('orders', $orders);
    }
}
