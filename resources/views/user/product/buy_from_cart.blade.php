@extends('layouts.app')
@section('title', $product->name)

<style>
  .product-image {
    height: 100%;
    object-fit: cover;
  }

  .product-details {
    position: relative;
    height: 100%;
    overflow-y: auto;
    padding: 20px;
  }

  .product-description {
    max-height: 200px;
    overflow-y: auto;
  }

  .card p {
    margin-bottom: 0;
  }
</style>

@section('content')
  <div class="row">
     @include('user.product.partials.product_details')

     @php
      $subtotal = number_format($product->price * $quantity, 2);
      $discount = number_format($product->getDiscount() * $quantity, 2);
      $total = number_format($product->price * $quantity - $product->getDiscount() * $quantity, 2);
     @endphp
     
    <div class="col-md-4 mb-4">
      <div class="card shadow text-white" style="background-color: #62b4a5;">
        <div class="card-body">
          <h4 class="text-center">Payment Details</h4>
          <form action="{{ route('checkout.cart', $product->id) }}" method="post" class="mb-0">
            @csrf

            <input type="hidden" name="quantity" value="{{ $quantity }}">

            @error('quantity')
              <p class="small text-danger">{{ $message }}</p>
            @enderror

            <div class="mb-2">
            <label for="address" class="form-label">
              Address
            </label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
            @error('address')
              <p class="small text-danger">{{ $message }}</p>
            @enderror
           </div>
            
           <div class="mb-2">
            <label for="password" class="form-label">
              Password
            </label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password">
            @error('password')
              <p class="small text-danger">{{ $message }}</p>
            @enderror
            
            @if (session('invalid_password'))
              <p class="text-danger small">{{ session('invalid_password') }}</p>
            @endif
            </div>
            
            
          <div class="payment-border rounded mt-4 py-3 px-2 mb-3">
          <div class="d-flex justify-content-between">
            <p>Price</p>
            <p class="fw-bold">${{ $product->price }}</p>
          </div>
          <hr class="m-0 mb-3">
          <div class="d-flex justify-content-between">
            <p>Quantity</p>
            <p class="fw-bold">{{ $quantity }}</p>
          </div>

          <hr class="m-0 mb-3">

          <div class="d-flex justify-content-between">
            <p>Subtotal</p>
            <p class="fw-bold">${{ $subtotal }}</p>
          </div>

          <hr class="m-0 mb-3">

          <div class="d-flex justify-content-between">
            <p>discount</p>
            <p class="fw-bold">${{ $discount }}</p>
          </div>

          <hr class="m-0 mb-3 border-3">

          <div class="d-flex justify-content-between">
            <p class="mb-0">Total</p>
            <p class="mb-0 total-color fw-bold">${{ $total }}</p>
          </div>
        </div>

        @if (session('exceed_quantity'))
          <p class="text-danger small">{{ session('exceed_quantity') }}</p>
        @endif

        <button type="submit" class="btn btn-dark form-control">
          <span>Checkout <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
        </button>
      </form>
        </div>
      </div>
    </div>
  </div>

  @include('partials.related_product')

@endsection

