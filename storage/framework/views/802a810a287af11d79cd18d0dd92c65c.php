<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Invoices</title>
</head>

<body>
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="mb-3 text-center">
            <h2>Invoices Export Data</h2>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Invoice ID</th>
                        <th scope="col">Client Name</th>
                        <th scope="col">Invoice Date</th>
                        <th scope="col">Invoice Amount</th>
                        <th scope="col">Due Amount</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th scope="row"><?php echo e($invoice->invoice_number); ?></th>
                            <td><?php echo e($invoice->client->first_name); ?> <?php echo e($invoice->client->last_name); ?></td>
                            <td><?php echo e($invoice->invoice_date); ?></td>
                            <td>₹ <?php echo e($invoice->total); ?></td>
                            <td>₹ <?php echo e($invoice->due_amount); ?></td>
                            <td><?php echo e($invoice->due_date); ?></td>
                            <td><?php echo e($invoice->invoice_status); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html><?php /**PATH C:\xampp\htdocs\master\resources\views/invoices/exportInvoices.blade.php ENDPATH**/ ?>