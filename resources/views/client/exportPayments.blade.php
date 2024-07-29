<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Payments</title>
</head>

<body>
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="mb-3 text-center">
            <h2>Payments Export Data</h2>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Payment Date</th>
                        <th scope="col">Invoice ID</th>
                        <th scope="col">Client Name</th>
                        <th scope="col">Payment Amount</th>
                        <th scope="col">Payment Method</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <th scope="row">{{ $payment->payment_date }}</th>
                            <th scope="row">{{ $payment->invoice->invoice_number }}</th>
                            <td>{{ $payment->invoice->client->first_name}} {{ $payment->invoice->client->last_name }}</td>
                            <td>₹ {{ $payment->amount }}</td>
                            <td>{{ $payment->payment_mode }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>