@extends('layouts.master')
@section('title')
App Settings
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
        <h4 class="card-title mb-0">App Settings</h4>
      </div>
      <div class="card-body p-4">
        <form action="{{ route('updateSettings')}}" method="post" id="app_settings-form" name="app_settings-form"
          enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="app-name" class="form-label">App Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('app-name') is-invalid @enderror" id="app-name"
                  placeholder="app name" value="{{ $settings['app-name'] }}" name="app-name">
                @if ($errors->has('app-name'))
          <div class="invalid-feedback">
            {{ $errors->first('app-name') }}
          </div>
        @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="company-name" class="form-label">Company Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('company-name') is-invalid @enderror" id="company-name"
                  placeholder="company name" value="{{ $settings['company-name'] }}" name="company-name">
                  @if ($errors->has('company-name'))
                    <div class="invalid-feedback">
                      {{ $errors->first('company-name') }}
                    </div>
                  @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="company-email" class="form-label">Company Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('company-email') is-invalid @enderror" id="company-email"
                  placeholder="Company Email" value="{{ $settings['company-email'] }}" name="company-email">
                  @if ($errors->has('company-email'))
                    <div class="invalid-feedback">
                      {{ $errors->first('company-email') }}
                    </div>
                  @endif
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="country-code" class="form-label">Country Code <span class="text-danger">*</span></label>
                <div class="mb-3">
                  <select class="form-control" name="country-code" id="country-code">
                    @foreach ($countries as $country)
            <option {{ ($settings['country-code'] && $settings['country-code'] == $country->phone_code) ? 'selected' : '' }} value="{{ $country->phone_code }}">+({{ $country->phone_code }})
              {{ $country->name }}
            </option>
          @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="company-phone" class="form-label">Company Phone <span class="text-danger">*</span></label>
                <input type="tel" class="form-control @error('company-phone') is-invalid @enderror" id="company-phone"
                  placeholder="company phone" value="{{ $settings['company-phone'] }}" name="company-phone">
                @if ($errors->has('company-phone'))
          <div class="invalid-feedback">
            {{ $errors->first('company-phone') }}
          </div>
        @endif
              </div>
            </div>

            <div class="col-lg-6">
              <div class="mb-3">
                <label for="country-name" class="form-label">Country</label>
                <div class="mb-3">
                  <select class="form-control" name="country-name" id="country-name">
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
            <option value="{{ $country->id }}" {{ ($settings['country-name'] && $settings['country-name'] == $country->id) ? 'selected' : '' }}>
              {{ $country->name }}
            </option>
          @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="state-code" class="form-label">State</label>
                <div class="mb-3">
                  <select class="form-control" name="state-code" id="state-code">
                  </select>
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <div class="mb-3">
                  <select class="form-control" name="city" id="city">
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="zip-code" class="form-label">Zip Code</label>
                <input type="text" class="form-control @error('zip-code') is-invalid @enderror" id="zip-code"
                  placeholder="Zip Code" value="{{ $settings['zip-code'] }}" name="zip-code">
                @if ($errors->has('zip-code'))
          <div class="invalid-feedback">
            {{ $errors->first('zip-code') }}
          </div>
        @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="GST-NO" class="form-label">GST NO</label>
                <input type="text" class="form-control @error('GST-NO') is-invalid @enderror" id="GST-NO"
                  placeholder="GSTIN" value="{{ $settings['GST-NO'] }}" name="GST-NO">
                @if ($errors->has('GST-NO'))
          <div class="invalid-feedback">
            {{ $errors->first('GST-NO') }}
          </div>
        @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="invoice-prefix" class="form-label">Invoice Prefix <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('invoice-prefix') is-invalid @enderror" id="invoice-prefix"
                  placeholder="Invoice prefix" value="{{ $settings['invoice-prefix'] }}" name="invoice-prefix">
                @if ($errors->has('invoice-prefix'))
          <div class="invalid-feedback">
            {{ $errors->first('invoice-prefix') }}
          </div>
        @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="Address" class="form-label">Address <span class="text-danger">*</span></label>
                <textarea class="form-control @error('Address') is-invalid @enderror" cols="5" rows="5" id="Address"
                  placeholder="Address" name="Address">{{ $settings['Address'] }} </textarea>
                @if ($errors->has('Address'))
          <div class="invalid-feedback">
            {{ $errors->first('Address') }}
          </div>
        @endif
              </div>
            </div>
            <div class="row">
              <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column align-items-center">
                  <div class="mb-2">
                    <span>App Logo <span class="text-danger">*</span></span>
                  </div>
                  <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                    <img src="{{ URL::asset('images/uploads/' . $settings['app-logo']) }}"
                      class="rounded-circle avatar-xl img-thumbnail app-logo-image material-shadow"
                      alt="app-logo-image">
                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                      <input id="app-logo-input" type="file" name="app-logo" class="app-logo-input">
                      <label for="app-logo-input" class="profile-photo-edit avatar-xs">
                        <span class="avatar-title rounded-circle bg-light text-body material-shadow">
                          <i class="ri-camera-fill"></i>
                        </span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column align-items-center">
                  <div class="mb-2">
                    <span>App Fevicon <span class="text-danger">*</span></span>
                  </div>
                  <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                    <img src="{{ URL::asset('images/uploads/' . $settings['app-fevicon']) }}"
                      class="rounded-circle avatar-xl img-thumbnail app-fevicon-image material-shadow"
                      alt="app-fevicon-image">
                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                      <input id="app-fevicon-input" type="file" name="app-fevicon" class="app-fevicon-input">
                      <label for="app-fevicon-input" class="profile-photo-edit avatar-xs">
                        <span class="avatar-title rounded-circle bg-light text-body material-shadow">
                          <i class="ri-camera-fill"></i>
                        </span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 d-none">
              <div class="mb-3">
                <label for="Copyright" class="form-label">Copyright</label>
                <input type="text" class="form-control @error('Copyright') is-invalid @enderror" id="Copyright"
                  placeholder="Copyright" value="{{ $settings['Copyright'] }}" name="Copyright">
                @if ($errors->has('Copyright'))
          <div class="invalid-feedback">
            {{ $errors->first('Copyright') }}
          </div>
        @endif
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

    $('#state-code').select2();
    $('#city').select2();
    $('#country-name').select2();
    $('#country-code').select2();

    $('#country-name').change(function () {
      fetchStates($(this).val());
    });

    $('#state-code').change(function () {
      fetchCities($(this).val());
    });

    function fetchStates(countryId) {
      const fetchRoute = "{{ route('fetch.states', ':countryId') }}".replace(":countryId", countryId);
      $.ajax({
        url: fetchRoute,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
          $('#state-code').empty();
          response.states.forEach(state => {
            $('#state-code').append(new Option(state.name, state.id, state.id == "{{ $settings['state-code'] }}", state.id == "{{ $settings['state-code'] }}"));
          });
          $('#state-code').trigger('change');
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error: ' + status + ' - ' + error);
        }
      });
    }

    function fetchCities(stateId) {
      const fetchCitiesRoute = "{{ route('fetch.cities', ':stateId') }}".replace(':stateId', stateId);
      $.ajax({
        url: fetchCitiesRoute,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
          // console.log('Cities fetched:', response.cities);
          $('#city').empty();
          response.cities.forEach(city => {
            $('#city').append(new Option(city.name, city.id, city.id == "{{ $settings['city'] }}", city.id == "{{ $settings['city'] }}"));
          });
          $('#city').trigger('change');
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error: ' + status + ' - ' + error);
        }
      });
    }

    function initializeSelect2() {
      var initialCountryId = $('#country-name').val();
      var initialStateId = "{{ $settings['state-code'] }}";
      var initialCityId = "{{ $settings['city'] }}";

      if (initialCountryId) {
        fetchStates(initialCountryId);
      }

      // Ensure cities are fetched only after states are loaded
      $('#state-code').one('change', function () {
        if (initialStateId) {
          fetchCities(initialStateId);
        }
        if (initialCityId) {
          $('#city').val(initialCityId).trigger('change');
        }
      });

      if (initialStateId) {
        $('#state-code').val(initialStateId).trigger('change');
      }
    }

    initializeSelect2();

  });
</script>


@endsection