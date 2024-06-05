{{-- Products delete modal --}}
<div class="modal fade" id="delete-product{{ $product->id }}">
  <div class="modal-dialog">
    <div class="modal-content border-danger">
       <div class="modal-header border-danger">
         <h4 class="h5 text-danger mb-0">
          <i class="fa-solid fa-trash-can"></i> Delete Product
         </h4>
       </div>
       <div class="modal-body">
         <h5 class="mb-2">Are you sure to delete this product?</h5>
         <p>Product Name: {{ $product->name }}</p>
         <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-lg">

        </div>
        <div class="modal-footer border-0">
         <form action="{{ route('seller.products.delete', $product->id) }}" method="post">
          @csrf 
          @method('DELETE')
          <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-danger">Cancel</button> 
          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </form>
      </div>
    </div>
   </form>
  </div>
</div> 
