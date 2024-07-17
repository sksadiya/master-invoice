@extends('layouts.master')

@section('title')
Invoices
@endsection

@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">Invoices</h4>
      </div>

      <div class="card-body">
        <div class="listjs-table" id="invoiceList">
          <div class="row g-4 mb-3">
            <div class="col-sm-auto">
              <div>
                <a href="{{ route('invoice.add') }}" type="button" class="btn btn-primary add-btn">Add Invoice</a>
              </div>
            </div>
            <div class="col-sm">
              <form method="GET" action="{{ route('invoices') }}" id="searchForm">
                <div class="d-flex justify-content-sm-end">
                  <div class="search-box ms-2 me-2">
                    <input type="text" class="form-control search" name="search" id="searchInput"
                      value="{{ request()->get('search') }}" placeholder="Search...">
                    <i class="ri-search-line search-icon"></i>
                  </div>
                  <a href="" type="button" class="btn bg-primary text-light">reset</a>

                </div>
              </form>
            </div>
          </div>

          <div class="table-responsive table-card mt-3 mb-1">
            <table class="table align-middle table-nowrap" id="categoryTable">
              <thead class="table-light">
                <tr>
                  <th class="sort" data-sort="invoice-number">Invoice</th>
                  <th class="sort" data-sort="invoice-client">Client</th>
                  <th class="sort" data-sort="invoice-total">Total Amount</th>
                  <th class="sort" data-sort="invoice-due">Due Amount</th>
                  <th class="sort" data-sort="invoice-status">Status</th>
                  <th class="sort" data-sort="action">Action</th>
                </tr>
              </thead>
              <tbody class="list form-check-all">
              @if($invoices)
              @foreach($invoices as $invoice)
                <tr>
                  <td class="invoice-number"><a href="#">{{ $invoice->invoice_number}}</a></td>
                  <td class="invoice-client"><a href="{{ route('client.show', $invoice->client->id )}}">{{ $invoice->client->first_name}} {{ $invoice->client->last_name}}</a></td>
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
                  <td class="">
                    <div class="justify-content-end d-flex gap-2">
                      <div class="edit">
                        <a href="" class="btn btn-sm btn-success edit-item-btn"><i class="bx bxs-pencil"></i> Edit</a>
                      </div>
                      <div class="remove">
                        <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal"
                          data-bs-target="#invoiceDeleteModal" data-id="{{ $invoice->id }}"><i class="bx bx-trash"></i>
                          Delete</button>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-md-6 justify-content-start">
              <div class="pagination-wrap hstack gap-2">
                {{ $invoices->links() }}
              </div>
            </div>
            <div class="col-md-6 justify-content-end d-flex">
              <div class="dropdown">
                <button class="btn bg-primary btn-secondary dropdown-toggle" type="button" id="perPageDropdown"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  Per Page
                </button>
                <ul class="dropdown-menu" aria-labelledby="perPageDropdown">
                  <li><a class="dropdown-item invoice-per-page-item" href="#" data-per-page="20">20</a></li>
                  <li><a class="dropdown-item invoice-per-page-item" href="#" data-per-page="30">30</a></li>
                  <li><a class="dropdown-item invoice-per-page-item" href="#" data-per-page="50">50</a></li>
                  <li><a class="dropdown-item invoice-per-page-item" href="#" data-per-page="100">100</a></li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade zoomIn" id="invoiceDeleteModal" tabindex="-1" aria-hidden="true">
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
            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this invoice?</p>
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
<script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
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

  $(document).ready(function () {
    $('.dropdown-item.invoice-per-page-item').on('click', function (e) {
      e.preventDefault();
      var perPage = $(this).data('per-page');
      var url = '{{ $invoices->url($invoices->currentPage()) }}' + '&perPage=' + perPage;
      window.location.href = url;
    });

    var invoiceList = new List('invoiceList', {
      valueNames: ['invoice-number', 'invoice-client', 'invoice-total', 'invoice-due',
        'invoice-status', 'action'],
    });

    $('.remove-item-btn').on('click', function () {
      var invoiceID = $(this).data('id');
      $('#delete-record').data('id', invoiceID);
    });

    $('#delete-record').on('click', function () {
      var invoiceID = $(this).data('id');
      console.log(invoiceID);
      const delRoute = "{{ route('invoice.delete','ID') }}";
      const newdelRoute = delRoute.replace('ID', invoiceID);

      $.ajax({
        type: 'DELETE',
        url: newdelRoute,
        data: {
          _token: '{{ csrf_token() }}'
        },
        success: function (response) {
          if (response.status) {
            $('#invoiceDeleteModal').hide();
            console.log(response.status);
            location.reload();
          }
        },
        error: function (response) {
          $('#invoiceDeleteModal').hide();
          location.reload();
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: response.responseJSON.error,
          });
        }
      });
    });
  });
</script>
@endsection