<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark text-white bg-dark shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                        {{-- Women --}}
                        <form action="{{ route('women') }}" method="GET" class="mb-0">
                         <input type="hidden" name="genre" value="W">
                         <button type="submit" class="nav-link">Women</button>
                        </form>
    
                         {{-- Men --}}
                         <form action="{{ route('men') }}" method="GET" class="mb-0">
                             <input type="hidden" name="genre" value="M">
                             <button type="submit" class="nav-link">Men</button>
                         </form>
    
                         {{-- Sale --}}
                         <form action="{{ route('sale') }}" method="GET" class="mb-0">
                             <input type="hidden" name="genre" value="sale">
                             <button type="submit" class="nav-link">Sale</button>
                         </form>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">

                        @if(!request()->is('seller/*'))
                        <form action="{{ route('search') }}" method="get" class="d-flex align-items-center me-5">
                            <div class="input-group">
                                <input type="search" name="search" placeholder="Enter free words" class="form-control form-control-sm">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                        @endif

                        @php
                            $categories = App\Models\Maincategory::all();
                        @endphp

                        @if(!request()->is('seller/*'))
                        <form action="{{ route('category') }}" method="get" class="d-flex align-items-center me-5">
                            <div class="input-group">
                                <select class="form-select" name="category" aria-label="Category select" aria-describedby="category-icon">
                                    <option  disabled selected hidden>Search by category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="fa fa-search"></i> 
                                </button>
                            </div>
                        </form>
                        @endif

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            {{-- Cart --}}
                            <a href="{{ route('cart.index') }}" class="nav-link position-relative p-0 me-2 mt-2">
                                <i class="fa-solid fa-cart-shopping pt-1"></i>
                                @if (Auth::user()->carts->isNotEmpty())
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ Auth::user()->carts->count() }}
                                    </span>
                                @endif
                            </a>
                    
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    {{-- Seller --}}
                                    @can('seller')

                                        <a class="dropdown-item" href="{{ route('seller.products') }}">
                                           Seller 
                                        </a>

                                        
                                    @endcan

                                        <a class="dropdown-item" href="{{ route('order.show') }}">
                                           Order
                                        </a>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center ">
                    @if(request()->is('seller/*'))
                    @can('seller')
                        <div class="col-md-3 mb-3">
                            <div class="list-group">
                                <a href="{{ route('seller.products') }}" class="list-group-item {{ request()->is('seller/products*') ? 'active' : ''}}">
                                    <i class="fa-brands fa-product-hunt"></i> Products
                                </a>

                                <a href="{{ route('seller.orders') }}" class="list-group-item {{ request()->is('seller/orders*') ? 'active' : ''}}">
                                    <i class="fa-solid fa-boxes-stacked"></i> Orders
                                </a>

                                <a href="{{ route('seller.categories') }}" class="list-group-item {{ request()->is('seller/categories*') ? 'active' : ''}}">
                                    <i class="fa-solid fa-tags"></i> Categories
                                </a>

                            </div>
                        </div>
                    @endcan

                    @endif
                       @if(request()->is('seller/*'))
                         <div class="col-md-9">
                       @endif
                       <div class="col-md-12">
                     @yield('content')
                </div>
            </div>
        </main>
    </div>
   </body>
</html>
