<header class="text-center">
  <h1 class="roboto-black pt-2">Laravel Clothing</h1>
  <p class="mt-3"><span class="fs-5 py-1 px-5 text-white sub-title">There's everything you want</span></p>
  @if (Session('success'))
    <h3 class="text-success mt-2">{{ session('success') }}</h3>
  @endif
</header>

<div class="row mt-5">
 <div class="col-md-3">
   <img class="w-100 header-img" src="{{ asset('img/header-img-women.jpg') }}" alt="Woemn Image">
 </div>
 <div class="col-md-6">
   <img class="w-100 header-img" src="{{ asset('img/header-img-main.jpg') }}" alt="Header Main Image">
 </div>
 <div class="col-md-3">
   <img class="w-100 header-img" src="{{ asset('img/header-img-men.jpg') }}" alt="Men Image">
 </div>
</div>