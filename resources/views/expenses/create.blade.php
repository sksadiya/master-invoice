@extends('layouts.master')
@section('title')
Add Expense
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
        <h4 class="card-title mb-0">Add Expense</h4>
      </div>
      <div class="card-body p-4">
        <form action="{{ route('expense.store')}}" method="post" id="expense-create-form" name="expense-create-form"
          enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="date">Date of Expense <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ \Carbon\Carbon::today()->toDateString() }}">
                    @error('date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="category">Category <span class="text-danger">*</span></label>
                    <select class="form-control @error('category') is-invalid @enderror" aria-placeholder="Expense Category" id="category" name="category">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id}}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="member">Team Member <span class="text-danger">*</span></label>
                    <select class="form-control @error('member') is-invalid @enderror" id="member" aria-placeholder="Team Member" name="member">
                        @foreach ($members as $member)
                            <option value="{{ $member->id}}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                    @error('member')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="amount">Amount <span class="text-danger">*</span></label>
                    <input type="number" placeholder="eg. 100" class="form-control @error('amount') is-invalid @enderror" min="0" step="" name="amount" id="amount">
                    @error('amount')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="title">Title <span class="text-danger">*</span></label>
                    <input type="text" placeholder="Title" class="form-control @error('title') is-invalid @enderror" name="title" id="title">
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="bill">Bill Receipt</label>
                    <input type="file" class="form-control @error('bill') is-invalid @enderror" name="bill" id="bill">
                    @error('bill')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Description"></textarea> 
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <!-- <div class="col-md-6">
                <div class="">
                  <div class="mb-2">
                    <span>Bill Receipt</span>
                  </div>
                  <div class="profile-user position-relative mb-4">
                    <img src="{{ URL::asset('build/images/new-document.png') }}"
                      class="rounded-circle avatar-xl img-thumbnail bill-image material-shadow"
                      alt="bill-image">
                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                      <input id="bill-input" type="file" name="bill" class="bill-input">
                      <label for="bill-input" class="profile-photo-edit avatar-xs">
                        <span class="avatar-title rounded-circle bg-light text-body material-shadow">
                          <i class="ri-camera-fill"></i>
                        </span>
                      </label>
                    </div>
                  </div>
                </div>
              </div> -->
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
    $('#category').select2();
    $('#member').select2();
   });
</script>
@endsection