@extends('layouts.app')

@section('title', 'Seller: Edit Product')

@section('content')

<div class="card shadow">
  <div class="card-body p-4">
    <h5 class="card-title">Add New Product</h5>
    <hr>
    <form action="{{ route('seller.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <div class="form-body mt-4">
        <div class="row">
          <div class="col-lg-8 mb-2">
            <div class="border border-3 p-4 rounded">
              <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter product Name" value="{{ old('name', $product->name) }}">
                @error('name')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="mb-3">
                <label for="short_desc" class="form-label">Short Description</label>
                <textarea class="form-control" name="short_desc" id="short_desc" rows="2">{{ old('short_desc', $product->short_desc) }}</textarea>
                @error('short_desc')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="5">{{ old('description', $product->description) }}</textarea>
                @error('description')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Product Images</label>
                <input id="image" type="file" name="image" class="form-control">
                @error('image')
                  <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>

              <div class="mb-3">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-lg">
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label for="price" class="form-label">Price</label>
                  <input type="number" class="form-control" name="price" id="price" placeholder="00.00" value="{{ old('price', $product->price) }}">
                  @error('price')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="quantity" class="form-label">Quantity</label>
                  <input type="number" class="form-control" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity) }}">
                  @error('quantity')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="discount" class="form-label">Discount</label>
                  <input type="number" class="form-control" name="discount" id="discount" value="{{ old('discount', $product->discount) }}">
                  @error('discount')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="gender" class="form-label">Gender</label>
                  <select class="form-select" name="gender" id="gender">
                    <option selected disabled>Select Gender</option>
                    <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }} {{ $product->gender == 'M' ? 'selected' : '' }}>Men</option>
                    <option value="W" {{ old('gender') == 'W' ? 'selected' : '' }} {{ $product->gender == 'W' ? 'selected' : '' }}>Women</option>
                    <option value="U" {{ old('gender') == 'U' ? 'selected' : '' }} {{ $product->gender == 'U' ? 'selected' : '' }}>Unisex</option>
                  </select>
                  @error('gender')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="border border-3 p-4 rounded">
              <div class="row g-3">
                <div class="col-12">

                  <label for="main_category_id" class="form-label">Main Category</label>
                  <select class="form-select" name="main_category_id" id="main_category_id">
                    <option selected disabled>Select Main Category</option>

                    @foreach ($mainCategories as $mainCategory)
                      <option value="{{ $mainCategory->id }}" {{ $mainCategory->id == $product->mainCategory->id ? 'selected' : '' }}>
                        {{ $mainCategory->name }}
                      </option>
                  
                    @endforeach
                </select>
                  @error('main_category_id')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror

                </div>
                <div class="col-12" style="max-height: 600px; overflow-y: auto;">
                  <label for="category_id" class="form-label">Sub Category</label>
                  @foreach ($categories as $category)
                  <div class="form-check">
                    @if (in_array($category->id, $selected_category))
                    <input class="form-check-input" type="checkbox" name="category_id[]" value="{{ $category->id }}" id="category_{{ $category->id }}" {{ in_array($category->id, old('category_id', [])) ? 'checked' : '' }} checked>
                    <label class="form-check-label" for="category_{{ $category->id }}">
                      {{ $category->name }}
                    </label>
                    @else
                    <input class="form-check-input" type="checkbox" name="category_id[]" value="{{ $category->id }}" id="category_{{ $category->id }}" {{ in_array($category->id, old('category_id', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category_{{ $category->id }}">
                      {{ $category->name }}
                    </label>
                    @endif
                    </div>
                  @endforeach
                  @error('category_id')
                    <p class="text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12">
                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Save Product</button>
                  </div>
                </div>
              </div>
            </div> 
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection