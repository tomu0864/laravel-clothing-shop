@extends('layouts.app')

@section('title', 'Seller: Products')

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

          <a href="{{ route('seller.products.add') }}" class="btn btn-primary">  
            <i class="fa-solid fa-plus"></i> Add Product
          </a>
      </div>
    </div>


   {{-- text setting wouldn't be apply for th with bootstrap --}}
   {{-- Use color inherit on style.css--}}
   <table class="table border table-hover bg-white align-middle text-secondary text-center mt-5">
     <thead class="text-secondary table-primary text-uppercase small">
       <tr>
         <th>#</th>
         <th>Name</th>
         <th>iamge</th>
         <th>Category</th>
         <th>Gender</th>
         <th>Price</th>
         <th>Quantity</th>
         <th>discount</th>
         <th></th>
       </tr>
     </thead>
     <tbody>
        @forelse ($products as $product)

           <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td><img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-sm"></td>
            <td>{{ $product->mainCategory->name }}</td>
            <td>{{ $product->gender }}</td>
            <td>${{ $product->price }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->discount }}%</td>
            <td>
              <a href="{{ route('seller.products.edit', $product->id) }}" class="btn btn-outline-warning me-1 mb-1">
                <i class="fa-solid fa-pencil"></i>
              </a>
          
              <button href="" class="btn btn-outline-danger me-1 mb-1" data-bs-toggle="modal" data-bs-target="#delete-product{{ $product->id }}">
                <i class="fa-solid fa-trash-can"></i>
              </button>
            </td>
           </tr>
           @include('seller.modals.products')

        @empty
          <tr>
            <td class="text-center" colspan="9">No Products found.</td>
          </tr>

        @endforelse
     </tbody>
   </table>

   {{ $products->links() }}
  
@endsection