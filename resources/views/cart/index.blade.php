@extends('layouts.app')
@section('title', 'Cart ' . Auth::user()->name)

@section('content')

    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card shadow">
          <div class="card-body p-4">

            <div class="row">

              <div class="col-lg-7">

                  <div>
                    <h5 class="mb-1">Shopping cart</h5>
                    <p class="mb-0">You have {{ $carts->count() }} {{ $carts->count() > 1 ? 'items' : 'item' }} in your cart</p>
                  </div>

                  @if (Session('success'))
                    <h3 class="text-success mt-2">{{ session('success') }}</h3>
                  @endif

                  @if ($carts->isNotEmpty())
                    
                  
                  @foreach ($carts as $cart)

                  @php
                    $subtotal = number_format($cart->product->price * $cart->quantity, 2);
                    $discount = number_format($cart->product->getDiscount() * $cart->quantity, 2);
                    $total = number_format($cart->product->price * $cart->quantity - $cart->product->getDiscount() * $cart->quantity, 2);
                  @endphp

                  @if ($cart->product)
                  <div class="card mb-3 mt-3 shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row align-items-center">
                                        <div>
                                            <a href="{{ route('product.details', $cart->product->id) }}">
                                                <img src="{{ $cart->product->image }}" class="cart-img rounded-3" alt="{{ $cart->product->name }}">
                                            </a>
                                        </div>
                                        <div class="ms-3">
                                            <a href="{{ route('product.details', $cart->product->id) }}" class="text-decoration-none">
                                                <h5>{{ $cart->product->name }}</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <p class="d-flex align-items-center justify-content-end"><i class="fas fa-cubes me-1"></i> 
                                    Stock <span class="ms-1 fw-bold text-{{ $cart->product->quantity <=5 ? 'danger' : 'success' }}"> {{ $cart->product->quantity }}</span>
                                </p>
                              
                                <div class="mt-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                            <div style="width: 50px;">
                                                <h5 class="fw-normal mb-0">{{ $cart->quantity }}</h5>
                                            </div>
                                            <div style="width: 80px;">
                                                @if ($discount > 0)
                                                <h6 class="mb-0 text-decoration-line-through">${{ number_format($cart->product->price * $cart->quantity, 2) }}</h6>
                                                <h5 class="mb-0 text-danger">${{ number_format($cart->product->getActualPrice() * $cart->quantity, 2) }}</h5>
                                                @else
                                                <h5 class="mb-0">${{ number_format($cart->product->price * $cart->quantity, 2) }}</h5>
                                                @endif
                                            </div>
                                            <form action="{{ route('product.buy.cart', $cart->product->id) }}" method="get" class="me-2 d-inline">
                                                <input type="hidden" name="quantity" value="{{ $cart->quantity }}">
                                                <button type="submit"  class="btn p-0 border-0">
                                                    <i class="fa-solid fa-cash-register text-success"></i>
                                                </button>
                                            </form>
                    
                                            <form action="{{ route('cart.delete', $cart->id) }}" method="post" class="d-inline">
                                              @csrf
                                              @method('DELETE')
                                                <button type="submit" class="btn p-0 border-0">
                                                    <i class="fas fa-trash-alt text-danger"></i>
                                                </button>
                                            </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                  @endif
              @endforeach

              </div>
              <div class="col-lg-5">

                <div class="card text-white rounded-3" style="background-color: #62b4a5;">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                      <h5 class="mb-0">Payment Details</h5>
                    </div>

                    @php
                    $totalSubtotal = 0; 
                    $totalDiscount = 0; 
                    foreach ($carts as $cart) {
                        $subtotal = $cart->product->price * $cart->quantity;
                        $discount = $cart->product->getDiscount() * $cart->quantity;
                        $totalSubtotal += $subtotal;
                        $totalDiscount += $discount;

                    }

                    $total = $totalSubtotal - $totalDiscount; // Calculate the total

                    $totalSubtotalFormatted = number_format($totalSubtotal, 2);
                    $totalDiscountFormatted = number_format($totalDiscount, 2);
                    $totalFormatted = number_format($total, 2);
                    @endphp

                    <form class="mt-4" action="{{ route('checkout.cart.multiple') }}" method="post">
                      @csrf

                      <label for="address" class="form-label">
                        Address
                      </label>
                      <input type="text" name="address" class="form-control mb-2" value="{{ old('address') }}">
                      @error('address')
                        <p class="small text-danger mb-0">{{ $message }}</p>
                      @enderror
                      
                      <label for="password" class="form-label">
                        Password
                      </label>
                      <input type="password" name="password" class="form-control" placeholder="Enter your password">
                      @error('password')
                        <p class="small text-danger mb-0">{{ $message }}</p>
                      @enderror

                      @if (session('invalid_password'))
                        <p class="text-danger small">{{ session('invalid_password') }}</p>
                      @endif

                      @foreach ($carts as $cart)
                        <input type="hidden" name="product_id[]" value="{{ $cart->product->id }}">
                        <input type="hidden" name="quantity[]" value="{{ $cart->quantity }}">
                      @endforeach

                    <hr class="my-4">

                      <div class="d-flex justify-content-between">
                        <p class="mb-2">Subtotal</p>
                        <p class="mb-2">${{ $totalSubtotalFormatted }}</p>
                      </div>

                      <div class="d-flex justify-content-between">
                        <p class="mb-2">Discount</p>
                        <p class="mb-2">${{ $totalDiscountFormatted }}</p>
                      </div>

                      <div class="d-flex justify-content-between mb-4">
                        <p class="mb-2">Total</p>
                        <p class="mb-2">${{ $totalFormatted }}</p>
                      </div>

                      @if ($errors->has('quantity'))
                        <div class="alert alert-danger mb-1">
                            @foreach ($errors->get('quantity') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                      @endif

                    <button  type="submit" class="btn btn-dark text-white btn-block btn-lg">
                      <div class="d-flex justify-content-between">
                        <span>Checkout <i class="fas fa-long-arrow-alt-right ms-2"></i></span>
                      </div>
                    </button>
                  </form>
                  </div>
                </div>

              </div>
              @endif

            </div>

          </div>
        </div>
      </div>
    </div>
@endsection