
<?php $__env->startSection('title'); ?>
<?php echo e($client->first_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('build/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-xxl-12">
    <div class="card ">
      <div id="alert-container">
        <?php if(Session::has('message')): ?>
      <div class="alert <?php echo e(Session::get('alert-class', 'alert-info')); ?> alert-dismissible fade show" role="alert">
        <?php echo e(Session::get('message')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
      </div>
      <div class="card-header">
        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#clientDetails" role="tab">
              <i class="fas fa-home"></i> Client Details
            </a>
          </li>
          <?php if($client->invoices->count() > 0): ?>
        <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#invoices" role="tab">
          <i class="far fa-user"></i> Invoices
        </a>
        </li>
      <?php endif; ?>
      <?php if($client->invoices->pluck('payments')->flatten()->isNotEmpty()): ?>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#payments" role="tab">
            <i class="far fa-user"></i> Payments
        </a>
    </li>
<?php endif; ?>

        </ul>
      </div>
      <div class="card-body p-4">
        <div class="tab-content">
          <div class="tab-pane active" id="clientDetails" role="tabpanel">
            <div class="row">
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">Full Name:</label>
                <span class="fs-5 "><?php echo e($client->first_name); ?> <?php echo e($client->last_name); ?></span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">Email:</label>
                <span class="fs-5 "><?php echo e(($client->email) ? $client->email : 'N/A'); ?></span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">Phone Number:</label>
                <span class="fs-5 "><?php echo e($client->contact); ?></span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">Country:</label>
                <span class="fs-5 "><?php echo e($country->name); ?></span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">State:</label>
                <span class="fs-5 "><?php echo e($state->name); ?></span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">City:</label>
                <span class="fs-5 "><?php echo e($city->name); ?></span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">Address:</label>
                <span class="fs-5 "><?php echo e(($client->Address) ? $client->Address : 'N/A'); ?></span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">Note:</label>
                <span class="fs-5 "><?php echo e(($client->Notes) ? $client->Notes : 'N/A'); ?></span>
              </div>
              <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
                <label for="name" class="pb-2 fs-5 ">GSTIN:</label>
                <span class="fs-5 "><?php echo e($client->GST ? $client->GST : 'N/A'); ?></span>


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
                                  value="<?php echo e(request()->get('search')); ?>" placeholder="Search...">
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
                            <?php if($client->invoices): ?>
                <?php $__currentLoopData = $client->invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td class="invoice-number"><a href="#"><?php echo e($invoice->invoice_number); ?></a></td>
            <td class="invoice-date">
            <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y')); ?>

            </td>
            <td class="invoice-due-date">
            <?php echo e(\Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y')); ?>

            </td>
            <td class="invoice-total">₹<?php echo e($invoice->total); ?></td>
            <td class="invoice-due">₹<?php echo e($invoice->due_amount); ?></td>
            <td class="invoice-status">
            <?php if($invoice->invoice_status == 'Unpaid'): ?>
        <span class="badge bg-danger-subtle text-danger badge-border">
        <?php echo e($invoice->invoice_status); ?>

        </span>
      <?php elseif($invoice->invoice_status == 'Paid'): ?>
    <span class="badge bg-success-subtle text-success badge-border">
    <?php echo e($invoice->invoice_status); ?>

    </span>
  <?php elseif($invoice->invoice_status == 'Partially_Paid'): ?>
  <span class="badge bg-secondary-subtle text-secondary badge-border">
  <?php echo e($invoice->invoice_status); ?>

  </span>
<?php elseif($invoice->invoice_status == 'Overdue'): ?>
  <span class="badge bg-primary-subtle text-primary badge-border">
  <?php echo e($invoice->invoice_status); ?>

  </span>
<?php elseif($invoice->invoice_status == 'Processing'): ?>
  <span class="badge bg-info-subtle text-info badge-border">
  <?php echo e($invoice->invoice_status); ?>

  </span>
<?php else: ?>
  <span class="badge bg-warning-subtle text-warning badge-border">
  <?php echo e($invoice->invoice_status); ?>

  </span>
<?php endif; ?>
            </td>

          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
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
                              <div class="search-box ms-2 me-2">
                                <input type="text" class="form-control search" name="paymentSearch" id="searchInput"
                                  value="<?php echo e(request()->get('paymentSearch')); ?>" placeholder="Search...">
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
                              <th class="sort" data-sort="payment-total">Total Amount</th>
                              <th class="sort" data-sort="payment-due">Due Amount</th>
                            </tr>
                          </thead>
                          <tbody class="list form-check-all">
                          <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                            <td class="payment-invoice-number"> <?php echo e($payment->invoice->invoice_number); ?></td>
                            <td class="payment-date"><?php echo e(\Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y')); ?></td>
                            <td class="payment-mode"><?php echo e($payment->payment_mode); ?></td>
                            <td class="payment-total"><?php echo e($payment->amount); ?></td>
                            <td class="payment-due"><?php echo e($payment->due_payment); ?></td>
                          </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/list.js/list.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/list.pagination.js/list.pagination.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\master\resources\views/client/show.blade.php ENDPATH**/ ?>