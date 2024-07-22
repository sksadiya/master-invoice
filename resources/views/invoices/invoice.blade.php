<!DOCTYPE html>
<html>

<head>
  <title>Invoice {{ $invoice->invoice_number}}</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="{{ URL::asset('build/css/bootstrap.min.css') }}"> -->
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
          @foreach ($invoice->items as $item)
        <tr>
        <th scope="row">{{ $loop->iteration }}</th>
        <td>{{ $item->product_name }}</td>
        <td>{{ $item->quantity}}</td>
        <td>{{ $item->unit_price }}</td>
        <td>{{ $item->total }}</td>
        </tr>
      @endforeach
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><b>Subtotal</b></td>
            <td>₹ {{ $invoice->subtotal }}</td>
          </tr>
          <tr>
            <td class="border-0"></td>
            <td class="border-0"></td>
            <td class="border-0"></td>
            @php
        $invoice->tax = rtrim(rtrim($invoice->tax, '0'), '.');
      @endphp
            <td><b>Tax ({{ $invoice->tax }}%) </b></td>
            <td>₹ {{ $invoice->tax_total }}</td>
          </tr>
          <tr>
            <td class="border-0"></td>
            <td class="border-0"></td>
            <td class="border-0"></td>
            <td><b>Discount</b></td>
            <td>₹ {{ $invoice->discount_total }}</td>
          </tr>
          <tr>
            <td class="border-0"></td>
            <td class="border-0"></td>
            <td class="border-0"></td>
            <td><b>Total</b></td>
            <td>₹ {{ $invoice->total }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>