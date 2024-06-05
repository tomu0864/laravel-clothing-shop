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

    public function index(Request $request)
    {
        $query = $this->order::query();

        if ($request->search) {
            $searchTerm = '%' . $request->search . '%';

            $query->where('order_number', 'LIKE', $searchTerm)
                ->orWhereHas('product', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', $searchTerm);
                })
                ->orWhereHas('user', function ($query) use ($searchTerm) {
                    $query->where('name', 'LIKE', $searchTerm);
                });

            $orders = $query->latest()->paginate(10);
        } else {

            $orders = $this->order->latest()->paginate(10);
        }


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
