<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Invoice {{ $invoice->invoice_number}}</title>
</head>

<body>
  <div class="container py-3">
    <div class="row">
    <div class="row">
        <div class="d-flex justify-content-between bd-highlight mb-3">
          <div class="p-2 bd-highlight">
          <h2 class="text-uppercase mb-2 ps-2 bg-dark text-light mb-sm-0 d-inline-block">Invoice
              {{ $invoice->invoice_number }}
            </h2><br>
            <strong class="text-muted fs-5">Bill date :
              <small>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</small></strong><br>
            <strong class="text-muted fs-5">Due date :
              <small>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</small></strong>
          </div>
          <div class="p-2 bd-highlight">
          <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/uploads/' . $settings['app-logo']))) }}" class="img-fluid" alt="Logo" style="max-width: 200px;">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="d-flex justify-content-between bd-highlight mb-3">
          <div class="p-2 bd-highlight">
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
          <div class="p-2 bd-highlight">
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
      </div>
      <div class="col-md-12">
        <table class="table table-striped">
          <thead class="bg-dark text-light">
            <tr>
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
                      <th>Discount (₹)</th>
                      <td>₹ {{ $invoice->discount_total }}</td>
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
                      <th>Total (₹)</th>
                      <td>₹ {{ $invoice->total }}</td>
                    </tr>
          </tbody>
        </table>
      </div>
      <div class="row mt-2">
        <div class="col-md-6">
          <h4>{{ $settings['company-name'] }}</h4>
          <strong>Company Name: </strong>{{ $settings['company-name'] }} <br>
          <strong>Account Number: </strong>{{ $settings['company-name'] }}<br>
          <strong>IFSC: </strong>{{ $settings['company-name'] }}<br>
          <strong>SWIFT code: </strong>{{ $settings['company-name'] }}<br>
          <strong>Bank name: </strong>{{ $settings['company-name'] }}<br>
          <strong>Branch: </strong>{{ $settings['company-name'] }}<br>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-12">
          <b>Terms & Conditions :-</b>
            <ul class="text-muted">
                <li>Payment should be made within 30 days from the invoice date.</li>
                <li>Please mention the invoice number while making the payment.</li>
                <li>Late payments may incur additional charges.</li>
                <li>For any queries regarding this invoice, please contact us at info@company.com.</li>
            </ul>
        </div>
      </div>
    </div>
  </div>
</body>

</html>