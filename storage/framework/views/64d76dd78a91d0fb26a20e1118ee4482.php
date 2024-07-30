

<?php $__env->startSection('title'); ?>
Payments
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('build/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title mb-0">Payments</h4>
      </div>

      <div class="card-body">
        <div class="listjs-table" id="paymentList">
          <div class="row g-4 mb-3">
            <div class="col-sm-auto">
              <div>
                <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal" id="create-btn"
                  data-bs-target="#addPaymentModal"><i class="bx bx-plus-circle me-2"></i>Add Payments</button>
              </div>
            </div>
            <div class="col-sm">
              <form method="GET" action="<?php echo e(route('payments')); ?>" id="searchForm">
                <div class="d-flex justify-content-sm-end">
                <a href="<?php echo e(route('exportPayments')); ?>" type="button" class="btn btn-outline-success btn-border me-2">PDF Export</a>
                <a href="<?php echo e(route('export-payments')); ?>" type="button" class="btn btn-outline-info btn-border">Excel Export</a>
                  <div class="search-box ms-2 me-2">
                    <input type="text" class="form-control search" name="search" id="searchInput"
                      value="<?php echo e(request()->get('search')); ?>" placeholder="Search...">
                    <i class="ri-search-line search-icon"></i>
                  </div>
                  <a href="<?php echo e(route('payments')); ?>" type="button" class="btn bg-primary text-light">reset</a>

                </div>
              </form>
            </div>
          </div>

          <div class="table-responsive table-card mt-3 mb-1">
            <table class="table align-middle table-nowrap" id="categoryTable">
              <thead class="table-light">
                <tr>
                  <th class="sort" data-sort="payment-invoice-number">Invoice</th>
                  <th class="sort" data-sort="payment-date">Payment Date</th>
                  <th class="sort" data-sort="payment-mode">Payment Mode</th>
                  <th class="sort" data-sort="payment-total">Payment Amount</th>
                  <th class="sort" data-sort="payment-due">Due Amount</th>
                  <th class="sort" data-sort="payment-action">Action</th>
                </tr>
              </thead>
              <tbody class="list form-check-all">
                <?php if($payments): ?>
          <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
        <td class="payment-invoice-number"><a
          href="<?php echo e(route('invoice.show', $payment->invoice->id)); ?>"><?php echo e($payment->invoice->invoice_number); ?></a>
        </td>
        <td class="payment-date"><?php echo e(\Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y')); ?></td>
        <td class="payment-mode"><?php echo e($payment->payment_mode); ?></td>
        <td class="payment-total"><?php echo e($payment->amount); ?></td>
        <td class="payment-due"><?php echo e($payment->due_payment); ?></td>

        <td class="">
        <div class="justify-content-end d-flex gap-2">
          <div class="edit">
          <button type="button" class="btn btn-sm btn-success edit-item-btn" data-bs-toggle="modal"
          data-bs-target="#editPaymentModal" data-id="<?php echo e($payment->id); ?>" data-invoice="<?php echo e($payment->invoice_id); ?>"
          data-payment-method="<?php echo e($payment->payment_mode); ?>" data-payment-note="<?php echo e($payment->notes); ?>" data-payment-date="<?php echo e($payment->payment_date); ?>" data-payment-amount="<?php echo e($payment->amount); ?>"><i class="bx bxs-pencil"></i> Edit</button>
          </div>
          <div class="remove">
          <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal"
          data-bs-target="#confirmationModal" data-id="<?php echo e($payment->id); ?>"><i class="bx bx-trash"></i>
          Delete</button>
          </div>
        </div>
        </td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
      <tr>
        <td colspan="2" class="text-center">Result Not found</td>
      </tr>
    <?php endif; ?>
              </tbody>
            </table>
          </div>
          <div class="row">
            <div class="col-md-6 justify-content-start">
              <div class="pagination-wrap hstack gap-2">
                <?php echo e($payments->links()); ?>

              </div>
            </div>
            <div class="col-md-6 justify-content-end d-flex">
              <div class="dropdown">
                <button class="btn bg-primary btn-secondary dropdown-toggle" type="button" id="perPageDropdown"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  Per Page
                </button>
                <ul class="dropdown-menu" aria-labelledby="perPageDropdown">
                  <li><a class="dropdown-item payment-per-page-item" href="#" data-per-page="20">20</a></li>
                  <li><a class="dropdown-item payment-per-page-item" href="#" data-per-page="30">30</a></li>
                  <li><a class="dropdown-item payment-per-page-item" href="#" data-per-page="50">50</a></li>
                  <li><a class="dropdown-item payment-per-page-item" href="#" data-per-page="100">100</a></li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- add Payment Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light p-3">
        <h5 class="modal-title" id="addPaymentModalLabel">Add Payments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
          id="close-add-modal"></button>
      </div>
      <form id="addPaymentForm" name="addPaymentForm" method="post">
        <?php echo csrf_field(); ?>
        <div class="modal-body">
          <div class="mb-3">
            <label for="invoice" class="form-label">Select Invoice</label>
            <select class="form-select mb-3" id="invoice" name="invoice">
              <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($invoice->id); ?>"><?php echo e($invoice->invoice_number); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <div class="invalid-feedback"></div>
          </div>
          <div class="mb-3">
            <label for="Payment_method" class="form-label">Payment Method</label>
            <select class="form-select mb-3" id="Payment_method" name="Payment_method">
              <option value="bank_transfer">Bank Transfer</option>
              <option value="phone_pe">PhonePe</option>
              <option value="google_pay">Google Pay</option>
            </select>
            <div class="invalid-feedback"></div>
          </div>
          <div class="mb-3">
            <label for="payment_date" class="form-label">Payment Date</label>
            <input type="date" class="form-control" id="payment_date"
              value="<?php echo e(\Carbon\Carbon::today()->toDateString()); ?>" name="payment_date" />
            <div class="invalid-feedback"></div>
          </div>
          <div class="mb-3">
            <label for="payment_amount" class="form-label">Payment Amount</label>
            <input type="number" class="form-control" id="payment_amount" step="0.01" min="0" placeholder="Enter Amount"
              name="payment_amount" />
            <div class="invalid-feedback"></div>
          </div>
          <div class="mb-3">
            <label for="payment_note" class="form-label">Payment Note</label>
            <textarea class="form-control" cols="5" rows="5" name="payment_note" placeholder="Enter Note"
              id="payment_note"></textarea>
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

<!-- Edit Tax Modal -->
<div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light p-3">
        <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
          id="close-edit-modal"></button>
      </div>
      <form id="editPaymentForm" name="editPaymentForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="modal-body">
          <div class="mb-3">
          <input type="hidden" name="edit_payment_id" id="edit_payment_id">
            <label for="invoice" class="form-label">Select Invoice</label>
            <select class="form-select" name="edit_invoice_id" id="edit_invoice_id" >
              <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($invoice->id); ?>"><?php echo e($invoice->invoice_number); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <div class="invalid-feedback"></div>
          </div>
          <div class="mb-3">
            <label for="edit_Payment_method" class="form-label">Payment Method</label>
            <select class="form-select mb-3" id="edit_Payment_method" name="edit_Payment_method">
              <option value="bank_transfer">Bank Transfer</option>
              <option value="phone_pe">PhonePe</option>
              <option value="google_pay">Google Pay</option>
            </select>
            <div class="invalid-feedback"></div>
          </div>
          <div class="mb-3">
            <label for="payment_date" class="form-label">Payment Date</label>
            <input type="date" class="form-control" id="edit_payment_date"
              value="<?php echo e(\Carbon\Carbon::today()->toDateString()); ?>" name="edit_payment_date" />
            <div class="invalid-feedback"></div>
          </div>
          <div class="mb-3">
            <label for="edit_payment_amount" class="form-label">Payment Amount</label>
            <input type="number" class="form-control" id="edit_payment_amount" step="0.01" min="0" placeholder="Enter Amount"
              name="edit_payment_amount" />
            <div class="invalid-feedback"></div>
          </div>
          <div class="mb-3">
            <label for="edit_payment_note" class="form-label">Payment Note</label>
            <textarea class="form-control" cols="5" rows="5" name="edit_payment_note" placeholder="Enter Note"
              id="edit_payment_note"></textarea>
            <div class="invalid-feedback"></div>
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
<div class="modal fade zoomIn" id="confirmationModal" tabindex="-1" aria-hidden="true">
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
            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this payment?</p>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/list.js/list.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/list.pagination.js/list.pagination.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/select2/js/select2.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<script>
  <?php if(Session::has('success')): ?>
    Swal.fire({
    title: 'Success!',
    text: '<?php echo e(Session::get('success')); ?>',
    icon: 'success',
    showCancelButton: false,
    customClass: {
      confirmButton: 'btn btn-primary w-xs me-2 mt-2',
    },
    buttonsStyling: false,
    showCloseButton: true
    });
  <?php endif; ?>

  <?php if(Session::has('error')): ?>
    Swal.fire({
    title: 'Error!',
    text: "<?php echo e(Session::get('error')); ?>",
    icon: 'error',
    showCancelButton: false,
    customClass: {
      confirmButton: 'btn btn-danger w-xs mt-2',
    },
    buttonsStyling: false,
    showCloseButton: true
    });
  <?php endif; ?>

  $(document).ready(function () {
    $('.dropdown-item.payment-per-page-item').on('click', function (e) {
      e.preventDefault();
      var perPage = $(this).data('per-page');
      var url = '<?php echo e($payments->url($payments->currentPage())); ?>' + '&perPage=' + perPage;
      window.location.href = url;
    });
    var paymentList = new List('paymentList', {
      valueNames: ['payment-invoice-number', 'payment-date', 'payment-mode', 'payment-total',
        'payment-due'],
    });

    $('#addPaymentModal').on('shown.bs.modal', function () {
      $('#invoice').select2({
        dropdownParent: $('#addPaymentModal') // Ensure dropdown is appended to modal
      });
      $('#Payment_method').select2({
        dropdownParent: $('#addPaymentModal') // Ensure dropdown is appended to modal
      });
    });
    $('#editPaymentModal').on('shown.bs.modal', function () {
      $('#edit_invoice_id').select2({
        dropdownParent: $('#editPaymentModal') // Ensure dropdown is appended to modal
      });
      $('#edit_Payment_method').select2({
        dropdownParent: $('#editPaymentModal') // Ensure dropdown is appended to modal
      });
    });

    $('#addPaymentForm').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: '<?php echo e(route("payment.store")); ?>',
        data: $(this).serialize(),
        success: function (response) {
          if (response.status) {
            $('#addPaymentModal').modal('hide');
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
              $('#' + key).siblings('.invalid-feedback').text(value[0]);
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.message,
            });
          }
        }
      });
    });

    $('#addPaymentModal').on('hidden.bs.modal', function () {
      $('#addPaymentForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    });

    $('#close-add-modal, .btn-light').on('click', function () {
      $('#addPaymentForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    });
   
    $('.edit-item-btn').on('click', function () {
      var paymentId = $(this).data('id');
      var paymentInvoice = $(this).data('invoice');
      var paymentMethod = $(this).data('payment-method');
      var paymentNote = $(this).data('payment-note');
      var paymentDate = $(this).data('payment-date');
      var paymentAmount = $(this).data('payment-amount');

      // Populate the edit modal with the category data
      $('#edit_payment_id').val(paymentId);
      $('#edit_invoice_id').val(paymentInvoice);
      $('#edit_Payment_method').val(paymentMethod);
      $('#edit_payment_note').val(paymentNote);
      $('#edit_payment_date').val(paymentDate);
      $('#edit_payment_amount').val(paymentAmount);

      // Show the edit modal
      $('#editPaymentModal').modal('show');
    });
    $('#editPaymentForm').on('submit', function (e) {
      e.preventDefault();

      var paymentId = $('#edit_payment_id').val();
      const PaymentRoute = "<?php echo e(route('payment.update', 'ID')); ?>";
      const newPaymentRoute = PaymentRoute.replace("ID", paymentId)
      $.ajax({
        type: 'PUT',
        url: newPaymentRoute,  // Adjust this URL to match your route
        data: $(this).serialize(),
        success: function (response) {
          console.log(response);
          if (response.status) {
            $('#editPaymentModal').hide();
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
          console.log(response);
          if (response.status === 422) {
          var errors = response.responseJSON.errors;
          if (errors) {
            $.each(errors, function (key, value) {
              $('#' + key).addClass('is-invalid');
              $('#' + key).siblings('.invalid-feedback').text(value[0]);
            });
          } else {
           window.location.reload();
          }
          }

        }
      });
    });

    // Reset edit form when the modal is hidden
    $('#editPaymentModal').on('hidden.bs.modal', function () {
      $('#editPaymentForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    });

    // Handle modal close button click to reset the edit form
    $('#close-edit-modal, .btn-light').on('click', function () {
      $('#editPaymentForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.invalid-feedback').text('');
    });

    
    $('.remove-item-btn').on('click', function () {
      var paymentId = $(this).data('id');
      $('#delete-record').data('id', paymentId);
    });

    $('#delete-record').on('click', function () {
      var paymentId = $(this).data('id');
      console.log(paymentId);
      const delRoute = "<?php echo e(route('payment.delete', 'ID')); ?>";
      const newdelRoute = delRoute.replace('ID', paymentId);

      $.ajax({
        type: 'DELETE',
        url: newdelRoute,
        data: {
          _token: '<?php echo e(csrf_token()); ?>'
        },
        success: function (response) {
          if (response.status) {
            $('#confirmationModal').hide();
            console.log(response.status);
            location.reload();
          }
        },
        error: function (response) {
          $('#confirmationModal').hide();
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\master\resources\views/payments/index.blade.php ENDPATH**/ ?>