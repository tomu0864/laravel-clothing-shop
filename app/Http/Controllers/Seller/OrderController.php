<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $orders = $this->order->latest()->paginate(10);

        return view('seller.orders.index')->with('orders', $orders);
    }

    public function ship($id)
    {
        $order = $this->order->findOrFail($id);

        $order->status = 'shipped';
        $order->save();

        return redirect()->back();
    }
}
