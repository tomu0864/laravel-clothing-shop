@extends('layouts.app')

@section('title', 'Seller: Categories')

@section('content')

<div class="row">
  <div class="col-12 col-md-12 ms-auto">
    <form action="{{ route('seller.mainCategories.store') }}" method="post" class="d-flex align-items-center justify-content-between">
      @csrf
      <div class="col">
        <h5>Main Category</h5>
      </div>
      <div class="col-6 d-flex">
        <input type="text" name="main_c_name" class="form-control me-2 flex-grow-1 ms-auto" value="{{ old('main_c_name') }}" placeholder="Add a main category...">
        <button type="submit" class="btn btn-success flex-shrink-0">
          <i class="fa-solid fa-plus"></i> Add
        </button>
      </div>
    </form>
    @error('main_c_name')
      <p class="text-danger mb-0">{{ $message }}</p>
    @enderror

    <form action="{{ route('seller.categories') }}" method="get" class="d-flex align-items-center me-5">
      <div class="col-md-3">
      <div class="input-group">
          <input type="search" name="search_main_c" placeholder="search..." class="form-control form-control-sm flex-grow-1">
          <button type="submit" class="btn btn-success">
              <i class="fas fa-search"></i>
          </button>
      </div>
    </div>
  </form>
  </div>
</div>


{{-- text setting wouldn't be apply for th with bootstrap --}}
{{-- Use color inherit on style.css--}}
<table class="table border table-hover bg-white align-middle text-secondary text-center mt-4">
 <thead class="text-secondary table-success text-uppercase small">
   <tr>
     <th>#</th>
     <th>NAME</th>
     {{-- <th>COUNT</th> --}}
     <th></th>
   </tr>
 </thead>
 <tbody>
    @forelse ($mainCategories as $mainCategory)

       <tr>
        <td>{{ $mainCategory->id }}</td>
        <td>{{ $mainCategory->name }}</td>
        {{-- <td>{{ count($category->categoryPosts) }}</td> --}}
        <td>
          <button class="btn btn-outline-warning me-1 mb-1" data-bs-toggle="modal" data-bs-target="#edit-mainCategory{{ $mainCategory->id }}">
            <i class="fa-solid fa-pencil"></i>
          </button>
      
          <button type="button" class="btn btn-outline-danger me-1 mb-1" data-bs-toggle="modal" data-bs-target="#delete-mainCategory{{ $mainCategory->id }}">
            <i class="fa-solid fa-trash-can"></i>
          </button>
        </td>
       </tr>
       @include('seller.modals.main_categories')

    @empty
      <tr>
        <td class="text-center" colspan="5">No Main Categories found.</td>
      </tr>

    @endforelse
 </tbody>
</table>

{{ $mainCategories->links() }}

<div class="row mt-5">
  <div class="col-12 col-md-12 ms-auto">
    <form action="{{ route('seller.categories.store') }}" method="post" class="d-flex align-items-center justify-content-between">
      @csrf
      <div class="col">
        <h5>Sub Category</h5>
      </div>
      <div class="col-6 d-flex">
        <input type="text" name="name" class="form-control me-2 flex-grow-1 ms-auto" value="{{ old('name') }}" placeholder="Add a sub category...">
        <button type="submit" class="btn btn-success flex-shrink-0">
          <i class="fa-solid fa-plus"></i> Add
        </button>
      </div>
    </form>
    @error('name')
      <p class="text-danger mb-0">{{ $message }}</p>
    @enderror

    <form action="{{ route('seller.categories') }}" method="get" class="d-flex align-items-center me-5">
      <div class="col-md-3">
      <div class="input-group">
          <input type="search" name="search_sub_c" placeholder="search..." class="form-control form-control-sm flex-grow-1">
          <button type="submit" class="btn btn-success">
              <i class="fas fa-search"></i>
          </button>
      </div>
    </div>
  </form>
  </div>
</div>


   {{-- text setting wouldn't be apply for th with bootstrap --}}
   {{-- Use color inherit on style.css--}}
   <table class="table border table-hover bg-white align-middle text-secondary text-center mt-4">
     <thead class="text-secondary table-success text-uppercase small">
       <tr>
         <th>#</th>
         <th>NAME</th>
         {{-- <th>COUNT</th> --}}
         <th></th>
       </tr>
     </thead>
     <tbody>
        @forelse ($categories as $category)

           <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            {{-- <td>{{ count($category->categoryPosts) }}</td> --}}
            <td>
              <button class="btn btn-outline-warning me-1 mb-1" data-bs-toggle="modal" data-bs-target="#edit-category{{ $category->id }}">
                <i class="fa-solid fa-pencil"></i>
              </button>
          
              <button type="button" class="btn btn-outline-danger me-1 mb-1" data-bs-toggle="modal" data-bs-target="#delete-category{{ $category->id }}">
                <i class="fa-solid fa-trash-can"></i>
              </button>
            </td>
           </tr>
           @include('seller.modals.categories')

        @empty
          <tr>
            <td class="text-center" colspan="5">No Categories found.</td>
          </tr>

        @endforelse
     </tbody>
   </table>

   {{ $categories->links() }}


  
@endsection
