@section('title', $genre)

<h2 class="text-center mt-5 roboto-medium">{{ $genre }}</h2>
<div class="row mt-4">
  @forelse ($products as $product)
  <div class="col-lg-3 mb-3">
      <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none">
          <div class="card shadow h-100">
              <img src="{{ $product->image }}" class="home-product-img" alt="{{ $product->name }}">
              <div class="card-body">
                  <h5 class="card-title">{{ $product->name }}</h5>
                  @if ($product->gender == 'U')
                  <span class="badge product-tag rounded-pill">Unisex</span>
                  @endif
                  @foreach ($product->productCategory as $productCategory)
                  <span class="badge product-tag rounded-pill">{{ $productCategory->category->name }}</span>
                  @endforeach
                  <div class="mt-2">
                      @if ($product->discount > 0)
                      <span class="price text-decoration-line-through">${{ $product->price }}</span>
                      <span class="text-danger ms-2">${{ $product->getActualPrice() }}</span>
                      <p class="text-danger">{{ $product->discount }}% Off</p>
                      @else
                      <span class="price h4">${{ $product->price }}</span>
                      @endif
                  </div>
              </div>
          </div>
      </a>
  </div>
  @empty
  <h1 class="text-center">No items found</h1>
  @endforelse

  {{-- {{ $products->links() }} --}}
</div>