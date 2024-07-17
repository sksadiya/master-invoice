@extends('layouts.master')
@section('title')
{{ $client->first_name }}
@endsection
@section('css')
<link href="{{ URL::asset('build/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row">
  <div class="col-xxl-12">
    <div class="card ">
      <div id="alert-container">
        @if(Session::has('message'))
      <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
        {{ Session::get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
      </div>
      <div class="card-header">
        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#clientDetails" role="tab">
              <i class="fas fa-home"></i> Client Details
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#invoices" role="tab">
              <i class="far fa-user"></i> Invoices
            </a>
          </li>
        </ul>
      </div>
      <div class="card-body p-4">
        <div class="tab-content">
          <div class="tab-pane active" id="clientDetails" role="tabpanel">
            <div class="row">
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">Full Name:</label>
                <span class="fs-5 ">{{ $client->first_name }} {{ $client->last_name }}</span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">Email:</label>
                <span class="fs-5 ">{{ ($client->email) ? $client->email : 'N/A'}}</span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">Phone Number:</label>
                <span class="fs-5 ">{{ $client->contact }}</span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">Country:</label>
                <span class="fs-5 ">{{ $country->name }}</span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">State:</label>
                <span class="fs-5 ">{{ $state->name }}</span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">City:</label>
                <span class="fs-5 ">{{ $city->name }}</span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">Address:</label>
                <span class="fs-5 ">{{ ($client->Address) ? $client->Address : 'N/A' }}</span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">Note:</label>
                <span class="fs-5 ">{{ ($client->Notes) ? $client->Notes : 'N/A' }}</span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">GSTIN:</label>
                <span class="fs-5 ">{{ $client->GST ? $client->GST : 'N/A' }}</span>


              </div>
              <!--end col-->
            </div>
            <!--end row-->
            </form>
          </div>
          <!--end tab-pane-->
          <div class="tab-pane" id="invoices" role="tabpanel">
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <div class="listjs-table" id="clientInvoicesList">
                      <div class="row g-4 mb-3">
                        <div class="col-sm">
                          <form method="GET" action="" id="searchForm">
                            <div class="d-flex justify-content-sm-end">
                              <div class="search-box ms-2 me-2">
                                <input type="text" class="form-control search" name="search" id="searchInput"
                                  value="{{ request()->get('search') }}" placeholder="Search...">
                                <i class="ri-search-line search-icon"></i>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="categoryTable">
                          <thead class="table-light">
                            <tr>
                              <th class="sort" data-sort="invoice-number">Invoice</th>
                              <th class="sort" data-sort="invoice-date">Invoice Date</th>
                              <th class="sort" data-sort="invoice-due-date">Due Date</th>
                              <th class="sort" data-sort="invoice-total">Total Amount</th>
                              <th class="sort" data-sort="invoice-due">Due Amount</th>
                              <th class="sort" data-sort="invoice-status">Status</th>
                            </tr>
                          </thead>
                          <tbody class="list form-check-all">
                            @if($client->invoices)
                @foreach($client->invoices as $invoice)
          <tr>
            <td class="invoice-number"><a href="#">{{ $invoice->invoice_number}}</a></td>
            <td class="invoice-date">{{ $invoice->invoice_date}}</td>
            <td class="invoice-due-date">{{ $invoice->due_date}}</td>
            <td class="invoice-total">₹{{ $invoice->total }}</td>
            <td class="invoice-due"></td>
            <td class="invoice-status">
            @if($invoice->invoice_status == 'Unpaid')
        <span class="badge bg-danger-subtle text-danger badge-border">
        {{ $invoice->invoice_status}}
        </span>
      @elseif($invoice->status == 'Paid')
    <span class="badge bg-success-subtle text-success badge-border">
    {{ $invoice->invoice_status}}
    </span>
  @elseif($invoice->status == 'Partially_Paid')
  <span class="badge bg-secondary-subtle text-secondary badge-border">
  {{ $invoice->invoice_status}}
  </span>
@elseif($invoice->status == 'Overdue')
  <span class="badge bg-primary-subtle text-primary badge-border">
  {{ $invoice->invoice_status}}
  </span>
@elseif($invoice->status == 'Processing')
  <span class="badge bg-info-subtle text-info badge-border">
  {{ $invoice->invoice_status}}
  </span>
@else
  <span class="badge bg-warning-subtle text-warning badge-border">
  {{ $invoice->invoice_status}}
  </span>
@endif
            </td>
          </tr>
        @endforeach
              @endif
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
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
<script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
  $(document).ready(function () {
    var clientInvoicesList = new List('clientInvoicesList', {
      valueNames: ['invoice-date', 'invoice-due-date', 'invoice-total', 'invoice-due',
        'invoice-status', 'invoice-number'],
    });
  });
</script>
@endsection