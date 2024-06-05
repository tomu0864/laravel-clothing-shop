@extends('layouts.app')
@section('title', 'Order ' . Auth::user()->name)

@section('content')

    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card shadow">
          <div class="card-body p-4">

            <div class="row">

              <div class="col-lg-12">

                  <div>
                    <h5 class="mb-1">Shopping Order</h5>
                    <p class="mb-0">You have {{ $orders->count() }} {{ $orders->count() > 1 ? 'items' : 'item' }} in your order</p>
                  </div>

                  @if ($orders)

                  @foreach ($orders as $order)

                  @if ($order->product)
                  <div class="card mb-3 mt-3 shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row align-items-center">
                                        <div>
                                            <a href="{{ route('product.details', $order->product->id) }}">
                                                <img src="{{ $order->product->image }}" class="cart-img rounded-3" alt="{{ $order->product->name }}">
                                            </a>
                                        </div>
                                        <div class="ms-3">
                                            <a href="{{ route('product.details', $order->product->id) }}" class="text-decoration-none">
                                                <h5>{{ $order->product->name }}</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                  <p class="text-end mb-0">
                                    Order Date:<span class="ms-1">{{ $order->created_at }}</span>
                                  </p>
                              
                                <div class="mt-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                            <div style="width: 50px;">
                                                <h5 class="fw-normal mb-0">{{ $order->quantity }}</h5>
                                            </div>
                                            <div style="width: 80px;">
        
                                                <h5 class="mb-0">${{ number_format($order->total_price, 2) }}</h5>
                                              
                                            </div>

                                            <div style="width: 80px;">
        
                                                @if ($order->status == 'shipped')
                                                 <span class="badge bg-warning">Shipped</span>
                                                @else
                                                 <span class="badge bg-danger">Pending</span>
                                                @endif
                                                <h5 class="mb-0"></h5>
                                              
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                  @endif
              @endforeach

              </div>
      
              @endif

            </div>

          </div>
        </div>
      </div>
    </div>
@endsection