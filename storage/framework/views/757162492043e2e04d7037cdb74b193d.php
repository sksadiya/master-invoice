
<?php $__env->startSection('title'); ?>
<?php echo app('translator')->get('translation.settings'); ?>
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
                <span class="fs-5 "><?php echo e(($client->GST) ?  $client->GST : 'N/A'); ?></span>


              </div>
              <!--end col-->
            </div>
            <!--end row-->
            </form>
          </div>
          <!--end tab-pane-->
          <div class="tab-pane" id="invoices" role="tabpanel">
            <div class="row">
              <div class="mb-3">
                hi invoices
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/list.js/list.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/list.pagination.js/list.pagination.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\master\resources\views/client/show.blade.php ENDPATH**/ ?>