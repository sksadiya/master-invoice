@extends('layouts.master')
@section('title')
@lang('translation.settings')
@endsection
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"
    type="text/css" />
@endsection
@section('content')

<div class="position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg profile-setting-img">
        <img src="{{ URL::asset('build/images/profile-bg.jpg') }}" class="profile-wid-img" alt="">
        <div class="overlay-content">
            <div class="text-end p-3">
                <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                    <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                    <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                        <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xxl-3">
        <div class="card mt-n5">
            <div class="card-body p-4">
                <div class="text-center">
                    <form id="profileImageForm" action="{{ route('updateProfile', Auth::user()->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img src="{{ URL::asset('images/' . Auth::user()->avatar) }}"
                                class="rounded-circle avatar-xl img-thumbnail user-profile-image material-shadow"
                                alt="user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" type="file" name="avatar"
                                    class="profile-img-file-input">
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body material-shadow">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-1">{{ Auth::user()->name }}</h5>
                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
        <!--end card-->
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-5">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Complete Your Profile</h5>
                    </div>
                    <!-- <div class="flex-shrink-0">
                        <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i class="ri-edit-box-line align-bottom me-1"></i> Edit</a>
                    </div> -->
                </div>
                <div class="progress animated-progress custom-progress progress-label">
                    <div class="progress-bar bg-danger" role="progressbar"
                        style="width: {{ $profileCompletionPercentage }}%" aria-valuenow="30" aria-valuemin="0"
                        aria-valuemax="100">
                        <div class="label">{{$profileCompletionPercentage}}%</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--end col-->
    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            <div id="alert-container">
                @if(Session::has('message'))
                    <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show"
                        role="alert">
                        {{ Session::get('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="card-header">
                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                            <i class="fas fa-home"></i> Personal Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                            <i class="far fa-user"></i> Change Password
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="firstnameInput" class="form-label">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="firstnameInput"
                                        value="{{ Auth::user()->name }}" placeholder="Enter your firstname" name="name"
                                        value="Dave">
                                        @if ($errors->has('name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="phonenumberInput" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select class="js-example-basic-single" id="regionCodeSelect"
                                                name="region_code">
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->phone_code }}" {{ Auth::user()->region_code == $country->phone_code ? 'selected' : '' }}
                                                        data-flag="{{ $country->flag }}">
                                                        +{{ $country->phone_code }} ({{ $country->name }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                        <input type="text" class="form-control @error('contact') is-invalid @enderror" id="phonenumberInput"
                                            value="{{ Auth::user()->contact }}" name="contact"
                                            placeholder="Enter your phone number">
                                        @if ($errors->has('contact'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('contact') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="emailInput" class="form-label">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ Auth::user()->email }}"
                                        id="emailInput" placeholder="Enter your email" name="email"
                                        value="daveadame@velzon.com">
                                        @if ($errors->has('email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="submit" class="btn btn-primary">Updates</button>
                                    <button type="button" class="btn btn-soft-success">Cancel</button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                        </form>
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="changePassword" role="tabpanel">
                        <form action="{{ route('updatePassword', Auth::user()->id)}}" method="post">
                            @csrf
                            <div class="row g-2">
                                <div class="col-lg-4">
                                    <div>
                                        <label for="oldpasswordInput" class="form-label">Old Password*</label>
                                        <input type="password" class="form-control" id="oldpasswordInput"
                                            name="current_password" placeholder="Enter current password"
                                            autocomplete="current-password">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div>
                                        <label for="newpasswordInput" class="form-label">New Password*</label>
                                        <input type="password" class="form-control" id="newpasswordInput"
                                            name="password" placeholder="Enter new password"
                                            autocomplete="new-password">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div>
                                        <label for="confirmpasswordInput" class="form-label">Confirm Password*</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="confirmpasswordInput" placeholder="Confirm password"
                                            autocomplete="new-password">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <a href="javascript:void(0);"
                                            class="link-primary text-decoration-underline">Forgot Password ?</a>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success">Change Password</button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                        <div class="mt-4 mb-3 border-bottom pb-2">
                            <div class="float-end">
                                <a href="javascript:void(0);" class="link-primary">All Logout</a>
                            </div>
                            <h5 class="card-title">Login History</h5>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 avatar-sm">
                                <div class="avatar-title bg-light text-primary rounded-3 fs-18 material-shadow">
                                    <i class="ri-smartphone-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6>iPhone 12 Pro</h6>
                                <p class="text-muted mb-0">Los Angeles, United States - March 16 at 2:47PM</p>
                            </div>
                            <div>
                                <a href="javascript:void(0);">Logout</a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 avatar-sm">
                                <div class="avatar-title bg-light text-primary rounded-3 fs-18 material-shadow">
                                    <i class="ri-tablet-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6>Apple iPad Pro</h6>
                                <p class="text-muted mb-0">Washington, United States - November 06 at 10:43AM</p>
                            </div>
                            <div>
                                <a href="javascript:void(0);">Logout</a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0 avatar-sm">
                                <div class="avatar-title bg-light text-primary rounded-3 fs-18 material-shadow">
                                    <i class="ri-smartphone-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6>Galaxy S21 Ultra 5G</h6>
                                <p class="text-muted mb-0">Conneticut, United States - June 12 at 3:24PM</p>
                            </div>
                            <div>
                                <a href="javascript:void(0);">Logout</a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 avatar-sm">
                                <div class="avatar-title bg-light text-primary rounded-3 fs-18 material-shadow">
                                    <i class="ri-macbook-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6>Dell Inspiron 14</h6>
                                <p class="text-muted mb-0">Phoenix, United States - July 26 at 8:10AM</p>
                            </div>
                            <div>
                                <a href="javascript:void(0);">Logout</a>
                            </div>
                        </div>
                    </div>
                    <!--end tab-pane-->

                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!--select2 cdn-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ URL::asset('build/js/pages/select2.init.js') }}"></script>

<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/profile-setting.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection