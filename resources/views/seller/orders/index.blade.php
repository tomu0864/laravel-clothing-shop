@extends('layouts.app')

@section('title', 'Seller: Orders')

@section('content')


    <div class="d-flex justify-content-between">
        <form action="{{ route('seller.products') }}" method="get" class="d-flex align-items-center me-5">
          <div class="input-group">
              <input type="search" name="search" placeholder="search" class="form-control form-control-sm">
              <button type="submit" class="btn btn-primary">
                  <i class="fas fa-search"></i>
              </button>
          </div>
        </form>
    </div>


   {{-- text setting wouldn't be apply for th with bootstrap --}}
   {{-- Use color inherit on style.css--}}
   <table class="table border table-hover bg-white align-middle text-secondary text-center mt-5">
     <thead class="text-secondary table-warning text-uppercase small">
       <tr>
         <th>Order NO.</th>
         <th>Name</th>
         <th>iamge</th>
         <th>Category</th>
         <th>Username</th>
         <th>Total Price</th>
         <th>Quantity</th>
         <th>Order Date</th>
         <th>Status</th>
         <th>Ship</th>

       </tr>
     </thead>
     <tbody>
        @forelse ($orders as $order)

           <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->product->name }}</td>
            <td><img src="{{ $order->product->image }}" alt="{{ $order->product->name }}" class="img-sm"></td>
            <td>{{ $order->product->mainCategory->name }}</td>
            <td>{{ $order->user->name }}</td>
            <td>${{ $order->total_price }}</td>
            <td>{{ $order->quantity }}</td>
            <td>{{ $order->created_at }}</td>
            <td>
              @if ($order->status == 'pending')
              <span class="badge bg-danger">Pending</span>
            @else
              <span class="badge bg-success">Shipped</span>
            @endif
          </td>
          <td>
              @if ($order->status == 'pending')
                <form action="{{ route('seller.orders.ship', $order->id) }}" method="post">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="btn btn-sm btn-warning">
                    <i class="fa-solid fa-truck-arrow-right"></i>
                  </button>
                </form>
              @else
               {{ $order->updated_at }}
              @endif
           </td>
           </tr>
         
        @empty
          <tr>
            <td class="text-center" colspan="10">No Products found.</td>
          </tr>

        @endforelse
     </tbody>
   </table>

   {{ $orders->links() }}
  
@endsection