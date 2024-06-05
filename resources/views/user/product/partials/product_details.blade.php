<div class="col-md-8 mb-3">
  <div class="card shadow mb-4 product-card" style="overflow: hidden">
    <div class="row g-0">
      <div class="col-md-4 border-end">
        <img src="{{ $product->image }}" class="img-fluid product-image h-100" alt="{{ $product->name }}">
      </div>
      <div class="col-md-8 d-flex flex-column">
        <div class="product-details flex-grow-1">
          <h4 class="card-title h3">{{ $product->name }}</h4>
          <div class="d-flex gap-3 py-2">
            {{-- <div>142 reviews</div>
            <div class="text-success"><i class="bx bxs-cart-alt align-middle"></i> 134 orders</div> --}}
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
</div>