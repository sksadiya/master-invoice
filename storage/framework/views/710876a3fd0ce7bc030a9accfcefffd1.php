<!DOCTYPE html>
<html>

<head>
  <title>Invoice <?php echo e($invoice->invoice_number); ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/bootstrap.min.css')); ?>"> -->
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap&family=Noto+Sans&display=swap"
    rel="stylesheet">
</head>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    line-height: 1.4;
  }
</style>
<body>
  <div class="container-fluid p-2">
    <div class="row">
      <div class="col-md-6 col-lg-6 col-sm-6 column">
        <h4>Bill To</h4>
        <address>
          <strong><?php echo e($invoice->client->first_name); ?> <?php echo e($invoice->client->last_name); ?></strong><br>
          <?php echo e($invoice->client->Address); ?><br>
          <?php echo e(optional($invoice->client->city)->name); ?>, <?php echo e(optional($invoice->client->state)->name); ?>,
          <?php echo e($invoice->client->postal_code); ?><br>
          <?php echo e(optional($invoice->client->country)->name); ?><br>
          Phone: <?php echo e($invoice->client->contact); ?><br>
          Email: <?php echo e($invoice->client->email); ?><br>
          <b>GST Number:</b> <?php echo e($invoice->client->GST); ?>

        </address>
      </div>
      <div class="col-md-6 col-lg-6 col-sm-6 column">hi</div>
    </div>
    <div class="row justify-content-center">
      <table class="table">
        <thead>
          <tr class="bg-dark text-light">
            <th scope="col">#</th>
            <th scope="col">Item</th>
            <th scope="col">Quantity</th>
            <th scope="col">Rate</th>
            <th scope="col">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
        <th scope="row"><?php echo e($loop->iteration); ?></th>
        <td><?php echo e($item->product_name); ?></td>
        <td><?php echo e($item->quantity); ?></td>
        <td><?php echo e($item->unit_price); ?></td>
        <td><?php echo e($item->total); ?></td>
        </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><b>Subtotal</b></td>
            <td>₹ <?php echo e($invoice->subtotal); ?></td>
          </tr>
          <tr>
            <td class="border-0"></td>
            <td class="border-0"></td>
            <td class="border-0"></td>
            <?php
        $invoice->tax = rtrim(rtrim($invoice->tax, '0'), '.');
      ?>
            <td><b>Tax (<?php echo e($invoice->tax); ?>%) </b></td>
            <td>₹ <?php echo e($invoice->tax_total); ?></td>
          </tr>
          <tr>
            <td class="border-0"></td>
            <td class="border-0"></td>
            <td class="border-0"></td>
            <td><b>Discount</b></td>
            <td>₹ <?php echo e($invoice->discount_total); ?></td>
          </tr>
          <tr>
            <td class="border-0"></td>
            <td class="border-0"></td>
            <td class="border-0"></td>
            <td><b>Total</b></td>
            <td>₹ <?php echo e($invoice->total); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html><?php /**PATH C:\xampp\htdocs\master\resources\views/invoices/invoice.blade.php ENDPATH**/ ?>