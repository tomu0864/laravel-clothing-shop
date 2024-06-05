@if($r_products->isNotEmpty())
  <h6 class="text-uppercase mb-2">Related Product</h6>

  <div class="row row-cols-1 row-cols-lg-3 align-items-stretch">
    @foreach ($r_products as $r_product)
      <div class="col mb-4">
       <a href="{{ route('product.details', $r_product->id) }}" class="text-decoration-none">
        <div class="card shadow h-100 d-flex flex-column" style="overflow: hidden">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="{{ $r_product->image }}" class="img-fluid h-100" alt="{{ $r_product->name }}">
            </div>
            <div class="col-md-8">
              <div class="card-body d-flex flex-column">
                <h6 class="card-title">{{ $r_product->name }}</h6>
                <div class="clearfix">
                  @if ($r_product->discount > 0)
                    <span class="price h6 text-decoration-line-through">${{ $r_product->price }}</span>
                    <span class="text-danger h ms-2">${{ $r_product->getActualPrice() }}</span> 
                    <p class="text-danger mb-1">{{ $r_product->discount }}% Off</p> 
                  @else
                    <span class="price h4">${{ $r_product->price }}</span>
                  @endif
                  <div>
                    @foreach ($r_product->productCategory as $productCategory)
                      <span class="badge product-tag rounded-pill">{{ $productCategory->category->name }}</span>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       </a>
      </div>
    @endforeach
  </div>
@endif