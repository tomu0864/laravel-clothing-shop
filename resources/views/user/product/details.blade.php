@extends('layouts.app')

@section('title', $product->name)

@section('content')

<style>
  .product-image {
    height: 100%;
    object-fit: cover;
  }

  .product-details {
    padding: 20px;
    display: flex;
    flex-direction: column;
  }

  .product-details .tab-content {
    flex-grow: 1;
  }

  .product-details .d-flex {
    flex-wrap: wrap;
  }

  .product-details .d-flex > div {
    flex: 1;
  }

  .product-details form {
    margin-bottom: 10px; /* Adjust as needed */
  }

  .product-description {
    max-height: 200px;
    overflow-y: auto;
  }
</style>
</head>
<body>

<div class="card shadow mb-4 product-card" style="overflow: hidden">
<div class="row g-0">
  <div class="col-md-4 border-end">
    <img src="{{ $product->image }}" class="img-fluid product-image" alt="{{ $product->name }}">
  </div>
  <div class="col-md-8 d-flex flex-column">
    <div class="product-details flex-grow-1">
      <h4 class="card-title h3">{{ $product->name }}</h4>
      <div class="d-flex gap-3 py-2">

      </div>
      <div class="mb-3">
        @if ($product->discount > 0)
        <span class="price h4 text-decoration-line-through">${{ $product->price }}</span>
        <span class="text-danger h4 ms-2">${{ $product->getActualPrice() }}</span> 
        <p class="text-danger">{{ $product->discount }}% Off</p> 
        @else
        <span class="price h4">${{ $product->price }}</span>
        @endif
        <div class="mt-2">
          @foreach ($product->productCategory as $productCategory)
            <span class="badge product-tag rounded-pill">
              {{ $productCategory->category->name }}
            </span>
          @endforeach
        </div>
      </div>

      
      <p class="card-text lead">{!! nl2br(e($product->short_desc)) !!}</p>
      <hr>

      <div class="d-flex gap-3">
        @auth

        <div>
          <form action="{{ route('product.handle', $product->id) }}" method="get" class="d-inline">
            <label class="form-label" for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control text-center mb-3" value="1">
            @if (session('invalid_quantity'))
                <p class="text-danger">{{ session('invalid_quantity') }}</p>
            @endif
            <button name="action" value="buy" class="btn btn-primary">Buy Now</button>
            <button name="action" value="add_to_cart" class="btn btn-outline-primary ms-1">
            
              
            @if($product->cartAdded())
            <i class="fa-solid fa-cart-shopping"></i> <span class="text">Already in cart</span>
            @else
            <i class="fas fa-cart-plus"></i> <span class="text">Add to cart</span>
            </button>
            @endif

            </form>
            </div>
       
       @else
           <h5>Please <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #62b4a5;">Login</a> first to check out</h5>
       @endauth

        <div>
          <p class="d-flex align-items-center"><i class="fas fa-cubes me-1"></i> 
            Stock <span class="ms-1 fw-bold text-{{ $product->quantity <=5 ? 'danger' : 'success' }}"> {{ $product->quantity }}</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<hr class="mt-0">
<div class="card-body">
  <ul class="nav nav-tabs nav-primary mb-0" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" data-bs-toggle="tab" href="#description" role="tab" aria-selected="true" tabindex="-1">
        <div class="d-flex align-items-center">
          <div class="tab-icon"><i class="bx bx-comment-detail font-18 me-1"></i></div>
          <div class="tab-title">Product Description</div>
        </div>
      </a>
    </li>
    {{-- <li class="nav-item" role="presentation">
      <a class="nav-link" data-bs-toggle="tab" href="#review" role="tab" aria-selected="false">
        <div class="d-flex align-items-center">
          <div class="tab-icon"><i class="bx bx-star font-18 me-1"></i></div>
          <div class="tab-title">Reviews</div>
        </div>
      </a>
    </li> --}}
  </ul>

  <div class="tab-content pt-3">
    <div class="tab-pane fade active show" id="description" role="tabpanel">
      <p>{!! nl2br(e($product->description)) !!}</p>
    </div>
    {{-- <div class="tab-pane fade" id="review" role="tabpanel">
      <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
    </div> --}}
  </div>
</div>
</div>

@include('partials.related_product')

@endsection


