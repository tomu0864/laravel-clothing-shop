@extends('layouts.app')
@section('title', 'Home')

@section('content')

@include('user.product.partials.header')

<h2 class="text-center mt-5 roboto-medium">New Drops</h2>
<div class="row mt-4">
    @forelse ($l_products as $l_product)
    <div class="col-lg-3 mb-3">
        <a href="{{ route('product.details', $l_product->id) }}" class="text-decoration-none">
            <div class="card shadow h-100">
                <img src="{{ $l_product->image }}" class="home-product-img" alt="{{ $l_product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $l_product->name }}</h5>
                    @if ($l_product->gender == 'U')
                    <span class="badge product-tag rounded-pill">Unisex</span>
                    @endif
                    @foreach ($l_product->productCategory as $productCategory)
                    <span class="badge product-tag rounded-pill">{{ $productCategory->category->name }}</span>
                    @endforeach
                    <div class="mt-2">
                        @if ($l_product->discount > 0)
                        <span class="price text-decoration-line-through">${{ $l_product->price }}</span>
                        <span class="text-danger ms-2">${{ $l_product->getActualPrice() }}</span>
                        <p class="text-danger">{{ $l_product->discount }}% Off</p>
                        @else
                        <span class="price h4">${{ $l_product->price }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
    @empty
    <h1 class="text-center">No items found</h1>
    @endforelse
</div>

<h2 class="text-center mt-5 roboto-medium">Sale</h2>
<div class="row mt-4">
    @forelse ($s_products as $s_product)
    <div class="col-lg-3 mb-3">
        <a href="{{ route('product.details', $s_product->id) }}" class="text-decoration-none">
            <div class="card shadow h-100">
                <img src="{{ $s_product->image }}" class="home-product-img" alt="{{ $s_product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $s_product->name }}</h5>
                    @if ($s_product->gender == 'U')
                    <span class="badge product-tag rounded-pill">Unisex</span>
                    @endif
                    @foreach ($s_product->productCategory as $productCategory)
                    <span class="badge product-tag rounded-pill">{{ $productCategory->category->name }}</span>
                    @endforeach
                    <div class="mt-2">
                        @if ($s_product->discount > 0)
                        <span class="price text-decoration-line-through">${{ $s_product->price }}</span>
                        <span class="text-danger ms-2">${{ $s_product->getActualPrice() }}</span>
                        <p class="text-danger">{{ $s_product->discount }}% Off</p>
                        @else
                        <span class="price h4">${{ $s_product->price }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
    @empty
    <h1 class="text-center">No sale yet</h1>
    @endforelse
</div>

<h2 class="text-center mt-5 roboto-medium">Men</h2>
<div class="row mt-4">
    @forelse ($m_products as $m_product)
    <div class="col-lg-3 mb-3">
        <a href="{{ route('product.details', $m_product->id) }}" class="text-decoration-none">
            <div class="card shadow h-100">
                <img src="{{ $m_product->image }}" class="home-product-img" alt="{{ $m_product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $m_product->name }}</h5>
                    @foreach ($m_product->productCategory as $productCategory)
                    <span class="badge product-tag rounded-pill">{{ $productCategory->category->name }}</span>
                    @endforeach
                    <div class="mt-2">
                        @if ($m_product->discount > 0)
                        <span class="price text-decoration-line-through">${{ $m_product->price }}</span>
                        <span class="text-danger ms-2">${{ $m_product->getActualPrice() }}</span>
                        <p class="text-danger">{{ $m_product->discount }}% Off</p>
                        @else
                        <span class="price h4">${{ $m_product->price }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
    @empty
    <h1 class="text-center">No items found</h1>
    @endforelse
</div>

<h2 class="text-center mt-5 roboto-medium">Women</h2>
<div class="row mt-4">
    @forelse ($w_products as $w_product)
    <div class="col-lg-3 mb-3">
        <a href="{{ route('product.details', $w_product->id) }}" class="text-decoration-none">
            <div class="card shadow h-100">
                <img src="{{ $w_product->image }}" class="home-product-img" alt="{{ $w_product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $w_product->name }}</h5>
                    @foreach ($w_product->productCategory as $productCategory)
                    <span class="badge product-tag rounded-pill">{{ $productCategory->category->name }}</span>
                    @endforeach
                    <div class="mt-2">
                        @if ($w_product->discount > 0)
                        <span class="price text-decoration-line-through">${{ $w_product->price }}</span>
                        <span class="text-danger ms-2">${{ $w_product->getActualPrice() }}</span>
                        <p class="text-danger">{{ $w_product->discount }}% Off</p>
                        @else
                        <span class="price h4">${{ $w_product->price }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    </div>
    @empty
    <h1 class="text-center">No items found</h1>
    @endforelse
</div>

@endsection
