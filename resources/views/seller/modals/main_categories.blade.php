{{-- Category edit modal --}}
<div class="modal fade" id="edit-mainCategory{{ $mainCategory->id }}">
  <div class="modal-dialog">
    <form action="{{ route('seller.mainCategories.update', $mainCategory->id) }}" method="post">
      @csrf
      @method('PATCH')
    <div class="modal-content border-warning">
       <div class="modal-header border-warning">
         <h4 class="h5 text-warning mb-0">
          <i class="fa-solid fa-pencil"></i> Edit Category
         </h4>
       </div>
       <div class="modal-body">

          <label for="main_c_name{{ $mainCategory->id }}" class="form-label">Category Name</label>
          <input type="text" name="main_c_name{{ $mainCategory->id }}" id="main_c_name{{ $mainCategory->id }}" class="form-control" value="{{ old("main_c_name$mainCategory->id",$mainCategory->name) }}">
          @error("main_c_name$mainCategory->id")
            <p class="text-danger mb-0">{{ $message }}</p>
          @enderror
        </div>
        <div class="modal-footer border-0">
          <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-warning">Cancel</button> 
          <button type="submit" class="btn btn-sm btn-warning text-dark">Save Changes</button>
      </div>
    </div>
   </form>
  </div>
</div>
 
{{-- Category delete modal --}}
<div class="modal fade" id="delete-mainCategory{{ $mainCategory->id }}">
  <div class="modal-dialog">
    <div class="modal-content border-danger">
       <div class="modal-header border-danger">
         <h4 class="h5 text-danger mb-0">
          <i class="fa-solid fa-trash-can"></i> Delete Category
         </h4>
       </div>
       <div class="modal-body">
         <h5 class="mb-2">Are you sure to delete this category?</h5>
         <p>Category Name: {{ $mainCategory->name }}</p>
        </div>
        <div class="modal-footer border-0">
         <form action="{{ route('seller.mainCategories.delete', $mainCategory) }}" method="post">
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
