@extends('layouts.master')

@section('title')
Categories
@endsection

@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">Product Categories</h4>
      </div>

      <div class="card-body">
        <div class="listjs-table" id="categoryList">
          <div class="row g-4 mb-3">
            <div class="col-sm-auto">
              <div>
                <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn"
                  data-bs-target="#addCategoryModal"><i class="bx bx-plus-circle me-2"></i> Add Category</button>
              </div>
            </div>
            <div class="col-sm">
              <form method="GET" action="{{ route('categories') }}" id="searchForm">
                <div class="d-flex justify-content-sm-end">
                  <div class="search-box ms-2 me-2">
                    <input type="text" class="form-control search" name="search" id="searchInput"
                      value="{{ request()->get('search') }}" placeholder="Search...">
                    <i class="ri-search-line search-icon"></i>
                  </div>
                  <a href="{{ route('categories') }}" type="button" class="btn bg-primary text-light">reset</a>

                </div>
              </form>
            </div>
          </div>

          <div class="table-responsive table-card mt-3 mb-1">
            <table class="table align-middle table-nowrap" id="categoryTable">
              <thead class="table-light">
                <tr>
                  <th class="sort" data-sort="category-name">Category</th>
                  <th class="sort" data-sort="product-count">Product</th>
                  <th class="sort" data-sort="action">Action</th>
                </tr>
              </thead>
              <tbody class="list form-check-all">
                @if($categories)
          @foreach ($categories as $category)
        <tr>
        <td class="category-name">{{ $category->name }}</td>
        <td class="product-count">{{ $category->products_count }}</td>
        <td class="">
        <div class="justify-content-end d-flex gap-2">
          <div class="edit">
          <button type="button" class="btn btn-sm btn-success edit-item-btn" data-bs-toggle="modal"
          data-bs-target="#editCategoryModal" data-id="{{ $category->id }}"
          data-name="{{ $category->name }}"><i class="bx bxs-pencil"></i> Edit</button>
          </div>
          <div class="remove">
          <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal"
          data-bs-target="#deleteRecordModal" data-id="{{ $category->id }}"><i class="bx bx-trash"></i> Delete</button>
          </div>
        </div>
        </td>
        </tr>
      @endforeach
        @else
      <tr>
        <td colspan="2" class="text-center">Result Not found</td>
      </tr>
    @endif
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-md-6 justify-content-start">
              <div class="pagination-wrap hstack gap-2">
                {{ $categories->links() }}
              </div>
            </div>
            <div class="col-md-6 justify-content-end d-flex">
              <div class="dropdown">
                <button class="btn bg-primary btn-secondary dropdown-toggle" type="button" id="perPageDropdown"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  Per Page
                </button>
                <ul class="dropdown-menu" aria-labelledby="perPageDropdown">
                  <li><a class="dropdown-item category-per-page-item" href="#" data-per-page="20">20</a></li>
                  <li><a class="dropdown-item category-per-page-item" href="#" data-per-page="30">30</a></li>
                  <li><a class="dropdown-item category-per-page-item" href="#" data-per-page="50">50</a></li>
                  <li><a class="dropdown-item category-per-page-item" href="#" data-per-page="100">100</a></li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light p-3">
        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
          id="close-add-modal"></button>
      </div>
      <form id="addCategoryForm" name="addCategoryForm">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="addCatName" class="form-label">Category Name</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter Category Name"  />
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" id="close-add-modal" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="add-btn">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light p-3">
        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
          id="close-edit-modal"></button>
      </div>
      <form id="editCategoryForm" name="editCategoryForm">
        @csrf
        @method('PUT')
        <input type="hidden" id="editCatId" name="id">
        <div class="modal-body">
          <div class="mb-3">
            <label for="editCatName" class="form-label">Category Name</label>
            <input type="text" id="editCatName" name="name" class="form-control" placeholder="Enter Category Name" required />
            <div class="invalid-feedback">Please enter a category name.</div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="hstack gap-2 justify-content-end">
            <button type="button" class="btn btn-light" id="close-edit-modal" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="edit-btn">Save Changes</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
      </div>
      <div class="modal-body">
        <div class="mt-2 text-center">
          <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
          <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
            <h4>Are you sure?</h4>
            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this category?</p>
          </div>
        </div>
        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
          <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn w-sm btn-danger" id="delete-record">Yes, Delete It!</button>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
  $(document).ready(function () {

    $('.dropdown-item.category-per-page-item').on('click', function (e) {
      e.preventDefault();
      var perPage = $(this).data('per-page');
      var url = '{{ $categories->url($categories->currentPage()) }}' + '&perPage=' + perPage;
      window.location.href = url;
    });
    var categoryList = new List('categoryList', {
      valueNames: ['category-name', 'product-count', 'action'],
    });
    $('#addCategoryForm').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: '{{ route("category.add") }}',
        data: $(this).serialize(),
        success: function (response) {
          if (response.status) {
            $('#addCategoryModal').hide();
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: response.message,
            }).then(function () {
              location.reload();
            });
          }
        },
        error: function (response) {
          var errors = response.responseJSON.errors;
          if (errors) {
            $.each(errors, function (key, value) {
              $('#' + key).addClass('is-invalid');
              $('#' + key).next('.invalid-feedback').text(value[0]);
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.responseJSON.message,
            });
          }
        }
      });
    });

    $('#addCategoryModal').on('hidden.bs.modal', function () {
      $('#addCategoryForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    });

    // Handle modal close button click to reset the form
    $('#close-add-modal, .btn-light').on('click', function () {
      $('#addCategoryForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    });
    $('.edit-item-btn').on('click', function () {
      var categoryId = $(this).data('id');
      var categoryName = $(this).data('name');

      // Populate the edit modal with the category data
      $('#editCatId').val(categoryId);
      $('#editCatName').val(categoryName);

      // Show the edit modal
      $('#editCategoryModal').modal('show');
    });
    $('#editCategoryForm').on('submit', function (e) {
      e.preventDefault();

      var categoryId = $('#editCatId').val();
      const catRoute = "{{ route('category.update', 'ID') }}";
      const newcatRoute = catRoute.replace("ID", categoryId)
      $.ajax({
        type: 'PUT',
        url: newcatRoute,  // Adjust this URL to match your route
        data: $(this).serialize(),
        success: function (response) {
          if (response.status) {
            $('#editCategoryModal').hide();
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: response.message,
            }).then(function () {
              location.reload();
            });
          }
        },
        error: function (response) {
          var errors = response.responseJSON.errors;
          if (errors) {
            $.each(errors, function (key, value) {
              $('#editCatName').addClass('is-invalid');
              $('#editCatName').next('.invalid-feedback').text(value[0]);
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.responseJSON.message,
            });
          }
        }
      });
    });

    // Reset edit form when the modal is hidden
    $('#editCategoryModal').on('hidden.bs.modal', function () {
      $('#editCategoryForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    });

    // Handle modal close button click to reset the edit form
    $('#close-edit-modal, .btn-light').on('click', function () {
      $('#editCategoryForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    });

    $('.remove-item-btn').on('click', function () {
      var categoryId = $(this).data('id');
      $('#delete-record').data('id', categoryId);
      $('#deleteRecordModal').modal('show');
    });

    $('#delete-record').on('click', function () {
      var categoryId = $(this).data('id');
      const delRoute = "{{ route('category.delete', 'ID') }}";
      const newdelRoute = delRoute.replace('ID', categoryId);

      $.ajax({
        type: 'DELETE',
        url: newdelRoute,
        data: {
          _token: '{{ csrf_token() }}'
        },
        success: function (response) {
          if (response.status) {
            $('#deleteRecordModal').hide();
            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: response.message,
            }).then(function () {
              location.reload();
            });
          }
        },
        error: function (response) {
          $('#deleteRecordModal').hide();
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.responseJSON.message,
          });
        }
      });
    });
  });
</script>
@endsection