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
                    @foreach ($invoices as $invoice)
                        <tr>
                            <th scope="row">{{ $invoice->invoice_number }}</th>
                            <td>{{ $invoice->client->first_name }} {{ $invoice->client->last_name }}</td>
                            <td>{{ $invoice->invoice_date }}</td>
                            <td>₹ {{ $invoice->total }}</td>
                            <td>₹ {{ $invoice->due_amount }}</td>
                            <td>{{ $invoice->due_date }}</td>
                            <td>{{ $invoice->invoice_status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>