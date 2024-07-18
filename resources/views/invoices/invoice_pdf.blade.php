<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <!-- Include Bootstrap CSS -->
    <link href="{{ URL::asset('build/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <style>
        /* Additional styles specific to your invoice PDF */
        body {
            font-family: Poppins, sans-serif;
            font-size: 14px;
        }
        .invoice {
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        /* Define additional styles as needed */
    </style>
</head>
<body>
<section class="py-3 py-md-5">
  <div class="container invoice">
    <div class="card py-5">
      <div class="row justify-content-center px-lg-5 px-sm-1">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-5 pb-4 px-4">
          <div class="col-md-4 mb-3">
            <h2 class="text-uppercase mb-2 ps-2 bg-dark text-light mb-sm-0 d-inline-block">Invoice
              {{ $invoice->invoice_number }}
            </h2><br>
            <strong class="text-muted fs-5">Bill date :
              <small>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</small></strong><br>
            <strong class="text-muted fs-5">Due date :
              <small>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</small></strong>
          </div>
          <div class="text-center">
            <img src="{{ URL::asset('images/uploads/' . $settings['app-logo']) }}" class="img-fluid" alt="Logo"
              style="max-width: 200px;">
          </div>
        </div>
        <div class="row d-inline-flex">
          <div class="row mb-5">
            <div class="col-12 col-sm-6 col-md-8">
              <h4>Bill To</h4>
              <address>
                <strong>{{ $invoice->client->first_name }} {{ $invoice->client->last_name }}</strong><br>
                {{ $invoice->client->Address }}<br>
                {{ optional($invoice->client->city)->name }}, {{ optional($invoice->client->state)->name }},
                {{ $invoice->client->postal_code }}<br>
                {{ optional($invoice->client->country)->name }}<br>
                Phone: {{ $invoice->client->contact }}<br>
                Email: {{ $invoice->client->email }}<br>
                <b>GST Number:</b> {{ $invoice->client->GST }}
              </address>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <h4>SAS Associates</h4>
              <address>
                <strong>{{ $settings['company-name'] }}</strong><br>
                {{ $settings['Address'] }}<br>
                {{ $settings['city'] }}, {{ $settings['state'] }}, {{ $settings['zip-code'] }}<br>
                {{ $settings['country'] }}<br>
                Phone: + {{ $settings['country-code'] }} {{ $settings['company-phone'] }}<br>
                Email: {{ $settings['company-email'] }}<br>
                <b>GST Number:</b> {{ $settings['GST-NO'] }}
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
                    @foreach($invoice->items as $item)
            <tr>
              <th scope="row">{{ $loop->iteration }}</th>
              <td>{{ $item->product_name }}</td>
              <td>{{ $item->quantity }}</td>
              <td>{{ $item->unit_price }}</td>
              <td>{{ $item->total }}</td>
            </tr>
          @endforeach
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <th>Subtotal (₹)</th>
                      <td>₹ {{ $invoice->subtotal }}</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      @php
            $invoice->tax = rtrim(rtrim($invoice->tax, '0'), '.');
            @endphp
                      <th>Tax ({{ $invoice->tax }}%)</th>
                      <td>₹ {{ $invoice->tax_total }}</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <th>Discount (₹)</th>
                      <td>₹ {{ $invoice->discount_total }}</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <th>Total (₹)</th>
                      <td>₹ {{ $invoice->total }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12 col-sm-6 col-md-8">
              <h4>{{ $settings['company-name'] }}</h4>
              <strong>Company Name: </strong>{{ $settings['company-name'] }} <br>
              <strong>Account Number: </strong>{{ $settings['company-name'] }}<br>
              <strong>IFSC: </strong>{{ $settings['company-name'] }}<br>
              <strong>SWIFT code: </strong>{{ $settings['company-name'] }}<br>
              <strong>Bank name: </strong>{{ $settings['company-name'] }}<br>
              <strong>Branch: </strong>{{ $settings['company-name'] }}<br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
