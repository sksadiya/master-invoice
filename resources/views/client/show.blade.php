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
          @if($client->invoices->count() > 0)
        <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#invoices" role="tab">
          <i class="far fa-user"></i> Invoices
        </a>
        </li>
      @endif
          @if($client->invoices->pluck('payments')->flatten()->isNotEmpty())
        <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#payments" role="tab">
          <i class="far fa-user"></i> Payments
        </a>
        </li>
      @endif

        </ul>
      </div>
      <div class="card-body p-4">
        <div class="tab-content">
          <div class="tab-pane active" id="clientDetails" role="tabpanel">
            <div class="row">
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-3">
                <label for="name" class=" ">Full Name</label>
                <input type="text" name="name" id="name" readonly class="form-control"
                  value="{{ $client->first_name }} {{ $client->last_name }}">
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-3">
                <label for="name" class="">Email</label>
                <input type="text" name="email" id="email" readonly class="form-control" value="{{ $client->email}}">
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-3">
                <label for="name" class=" ">Phone Number</label>
                <input type="text" name="contact" id="contact" readonly class="form-control"
                  value="{{ $client->contact}}">
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-3">
                <label for="name" class="">Country</label>
                <input type="text" name="country" id="country" readonly class="form-control"
                  value="{{ $country->name }}">
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-3">
                <label for="name" class="">State</label>
                <input type="text" name="state" id="state" readonly class="form-control" value="{{ $state->name }}">
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-3">
                <label for="name" class="">City</label>
                <input type="text" name="city" id="city" readonly class="form-control" value="{{ $city->name }}">
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-3">
                <label for="name" class="">Address</label>
                <textarea readonly class="form-control" name="address" id="address">{{ $client->Address}}</textarea>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-3">
                <label for="name" class="">Note</label>
                <input type="text" name="notes" id="notes" readonly class="form-control" value="{{ $client->Notes }}">
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-3">
                <label for="name" class="">GSTIN</label>
                <input type="text" name="gst" id="gst" readonly class="form-control" value="{{ $client->GST }}">
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
                              <a href="{{ route('exportClientInvoices', $client->id) }}" type="button"
                                class="btn btn-outline-success btn-border me-2">PDF Export</a>
                              <a href="{{ route('clients.export-with-invoices', $client->id) }}" type="button"
                                class="btn btn-outline-info btn-border me-2">Excel Export</a>

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
            <td class="invoice-date">
            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}
            </td>
            <td class="invoice-due-date">
            {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}
            </td>
            <td class="invoice-total">₹{{ $invoice->total }}</td>
            <td class="invoice-due">₹{{ $invoice->due_amount}}</td>
            <td class="invoice-status">
            @if($invoice->invoice_status == 'Unpaid')
        <span class="badge bg-danger-subtle text-danger badge-border">
        {{ $invoice->invoice_status }}
        </span>
      @elseif($invoice->invoice_status == 'Paid')
    <span class="badge bg-success-subtle text-success badge-border">
    {{ $invoice->invoice_status }}
    </span>
  @elseif($invoice->invoice_status == 'Partially_Paid')
  <span class="badge bg-secondary-subtle text-secondary badge-border">
  {{ $invoice->invoice_status }}
  </span>
@elseif($invoice->invoice_status == 'Overdue')
  <span class="badge bg-primary-subtle text-primary badge-border">
  {{ $invoice->invoice_status }}
  </span>
@elseif($invoice->invoice_status == 'Processing')
  <span class="badge bg-info-subtle text-info badge-border">
  {{ $invoice->invoice_status }}
  </span>
@else
  <span class="badge bg-warning-subtle text-warning badge-border">
  {{ $invoice->invoice_status }}
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

          <div class="tab-pane" id="payments" role="tabpanel">
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <div class="listjs-table" id="paymentList">
                      <div class="row g-4 mb-3">
                        <div class="col-sm">
                          <form method="GET" action="" id="searchForm">
                            <div class="d-flex justify-content-sm-end">
                              <a href="{{ route('exportClientPayments', $client->id) }}" type="button"
                                class="btn btn-outline-success btn-border me-2">PDF Export</a>
                              <a href="{{ route('clients.export-with-payments', $client->id) }}" type="button"
                                class="btn btn-outline-info btn-border me-2">Excel Export</a>
                              <div class="search-box ms-2 me-2">
                                <input type="text" class="form-control search" name="paymentSearch" id="searchInput"
                                  value="{{ request()->get('paymentSearch') }}" placeholder="Search...">
                                <i class="ri-search-line search-icon"></i>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="paymentTable">
                          <thead class="table-light">
                            <tr>
                              <th class="sort" data-sort="payment-invoice-number">Invoice</th>
                              <th class="sort" data-sort="payment-date">Payment Date</th>
                              <th class="sort" data-sort="payment-mode">Payment Mode</th>
                              <th class="sort" data-sort="payment-total">Payment Amount</th>
                              <th class="sort" data-sort="payment-due">Due Amount</th>
                            </tr>
                          </thead>
                          <tbody class="list form-check-all">
                            @foreach($payments as $payment)
                <tr>
                  <td class="payment-invoice-number"> {{ $payment->invoice->invoice_number }}</td>
                  <td class="payment-date">
                  {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                  <td class="payment-mode">{{ $payment->payment_mode}}</td>
                  <td class="payment-total">{{ $payment->amount }}</td>
                  <td class="payment-due">{{ $payment->due_payment }}</td>
                </tr>
              @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
    var paymentList = new List('paymentList', {
      valueNames: ['payment-invoice-number', 'payment-date', 'payment-mode', 'payment-total',
        'payment-due'],
    });
  });
</script>
@endsection