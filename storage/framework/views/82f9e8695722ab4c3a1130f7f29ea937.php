<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice <?php echo e($invoice->invoice_number); ?></title>
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/css/bootstrap.min.css')); ?>">
</head>
<body>
    <section class="py-3 py-md-5">
        <div class="container invoice">
            <div class="card py-5">
                <div class="row justify-content-center px-lg-5 px-sm-1">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-5 pb-4 px-4">
                        <div class="col-md-4 mb-3">
                            <h2 class="text-uppercase mb-2 ps-2 bg-dark text-light mb-sm-0 d-inline-block">Invoice
                                <?php echo e($invoice->invoice_number); ?>

                            </h2><br>
                            <strong class="text-muted fs-5">Bill date :
                                <small><?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y')); ?></small></strong><br>
                            <strong class="text-muted fs-5">Due date :
                                <small><?php echo e(\Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y')); ?></small></strong>
                        </div>
                        <div class="text-center">
                            <img src="<?php echo e(public_path('images/uploads/' . $settings['app-logo'])); ?>" class="img-fluid" alt="Logo"
                                 style="max-width: 200px;">
                        </div>
                    </div>
                    <div class="row d-inline-flex">
                        <div class="row mb-5">
                            <div class="col-12 col-sm-6 col-md-8">
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
                            <div class="col-12 col-sm-6 col-md-4">
                                <h4>SAS Associates</h4>
                                <address>
                                    <strong><?php echo e($settings['company-name']); ?></strong><br>
                                    <?php echo e($settings['Address']); ?><br>
                                    <?php echo e($settings['city']); ?>, <?php echo e($settings['state']); ?>, <?php echo e($settings['zip-code']); ?><br>
                                    <?php echo e($settings['country']); ?><br>
                                    Phone: + <?php echo e($settings['country-code']); ?> <?php echo e($settings['company-phone']); ?><br>
                                    Email: <?php echo e($settings['company-email']); ?><br>
                                    <b>GST Number:</b> <?php echo e($settings['GST-NO']); ?>

                                </address>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead class="bg-dark">
                                            <tr class="text-light">
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
                                                <th>Subtotal (₹)</th>
                                                <td>₹ <?php echo e($invoice->subtotal); ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <?php
                                                    $invoice->tax = rtrim(rtrim($invoice->tax, '0'), '.');
                                                ?>
                                                <th>Tax (<?php echo e($invoice->tax); ?>%)</th>
                                                <td>₹ <?php echo e($invoice->tax_total); ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th>Discount (₹)</th>
                                                <td>₹ <?php echo e($invoice->discount_total); ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th>Total (₹)</th>
                                                <td>₹ <?php echo e($invoice->total); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-sm-6 col-md-8">
                                <h4><?php echo e($settings['company-name']); ?></h4>
                                <strong>Company Name: </strong><?php echo e($settings['company-name']); ?> <br>
                                <strong>Account Number: </strong><?php echo e($settings['company-name']); ?><br>
                                <strong>IFSC: </strong><?php echo e($settings['company-name']); ?><br>
                                <strong>SWIFT code: </strong><?php echo e($settings['company-name']); ?><br>
                                <strong>Bank name: </strong><?php echo e($settings['company-name']); ?><br>
                                <strong>Branch: </strong><?php echo e($settings['company-name']); ?><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\master\resources\views/invoices/invoice_pdf.blade.php ENDPATH**/ ?>