@extends('layouts.master')
@section('title')
Add Product
@endsection
@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
  <div class="col-xxl-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">Add Product</h4>
      </div>
      <div class="card-body p-4">
        <form action="{{ route('product.store')}}" method="post" id="client-create-form" name="client-create-form"
          enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                  placeholder="Product Name" value="{{ old('name') }}" name="name">
                @if ($errors->has('name'))
          <div class="invalid-feedback">
            {{ $errors->first('name') }}
          </div>
        @endif
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="category" class="form-label">Product Category <span class="text-danger">*</span></label>
                <div class="mb-3">
                  <select class="form-control" name="category" id="category">
                    @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="unit_price" class="form-label">Unit Price <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('unit_price') is-invalid @enderror" id="unit_price"
                  placeholder="Unit Price" value="{{ old('unit_price') }}" name="unit_price">
                @if ($errors->has('unit_price'))
          <div class="invalid-feedback">
            {{ $errors->first('unit_price') }}
          </div>
        @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" cols="5" rows="5"
                  id="description" placeholder="Add description Here"
                  name="description">{{ old('description') }}</textarea>
                @error('description')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
              </div>
            </div>

            <div class="col-lg-12">
              <div class="hstack gap-2 justify-content-end">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-soft-success">Cancel</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<!-- apexcharts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ URL::asset('build/js/pages/profile-setting.init.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/select2/js/select2.min.js') }}"></script>
<!-- Include jQuery -->
<!-- dashboard init -->
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
  $(document).ready(function () {

    @if(Session::has('success'))
    Swal.fire({
      title: 'Success!',
      text: '{{ Session::get('success') }}',
      icon: 'success',
      showCancelButton: false,
      customClass: {
      confirmButton: 'btn btn-primary w-xs me-2 mt-2',
      },
      buttonsStyling: false,
      showCloseButton: true
    });
  @endif

    @if(Session::has('error'))
    Swal.fire({
      title: 'Error!',
      text: "{{ Session::get('error') }}",
      icon: 'error',
      showCancelButton: false,
      customClass: {
      confirmButton: 'btn btn-danger w-xs mt-2',
      },
      buttonsStyling: false,
      showCloseButton: true
    });
  @endif

    $('#category').select2();

  });
</script>
@endsection