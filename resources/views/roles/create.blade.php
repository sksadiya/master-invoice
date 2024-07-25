@extends('layouts.master')
@section('title')
Roles
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
                <h4 class="card-title mb-0">Role Information</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('role.store') }}" method="post" id="role-create-form" name="role-create-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="row mb-3">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label" for="name">Name</label>
                                <div class="col-md-9">
                                    <input type="text" placeholder="Name" id="name" name="name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <ul class="list-group mb-4">
                                <li class="list-group-item bg-light" aria-current="true">Permissions</li>
                                <li class="list-group-item">
                                    <div class="row">
                                    @foreach ($permissions as $permission)
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3 permission-switch">
                                            <div class="form-check form-switch form-switch-md">
                                                <input class="form-check-input" type="checkbox" role="switch" 
                                                       name="permissions[]" 
                                                       value="{{ $permission->id }}" 
                                                       {{ old('permissions') && in_array($permission->id, old('permissions')) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $permission->name }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-12 mt-3">
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

@endsection