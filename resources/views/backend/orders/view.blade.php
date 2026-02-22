@extends('backend.layouts.app')

@section('content')
    <style>
        /* --- PRINT SETTINGS --- */
        @media print {

            /* 1. This removes the Browser Header (Date/Title) and Footer (URL) */
            @page {
                size: auto;
                /* auto is the current printer page size */
                margin: 0;
                /* this is the magic line that hides browser header/footer */
            }

            body {
                background-color: #fff !important;
                margin: 0;
                padding: 0;
            }

            /* 2. Hide everything from the backend layout */
            body * {
                visibility: hidden;
            }

            /* 3. Show only the invoice area */
            .print-area,
            .print-area * {
                visibility: visible;
            }

            /* 4. Position at the absolute top and add manual padding
                                          so content doesn't get cut off by the printer */
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 40px;
                /* Manual "safe margin" for the content */
                border: none !important;
            }

            /* Hide the print button during printing */
            .d-print-none {
                display: none !important;
            }

            /* Fix for background colors not showing in some browsers */
            .table-dark {
                background-color: #212529 !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        /* Screen-only styling */
        .invoice-card {
            border-radius: 8px;
            overflow: hidden;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>

    <div class="container py-4">
        <div class="card shadow-sm print-area invoice-card">

            <div class="card-header  d-flex justify-content-between align-items-center d-print-none">
                <h5 class="mb-0 text-muted small fw-bold">INVOICE PREVIEW</h5>
                <button onclick="window.print()" class="btn btn-primary btn-sm">
                    <i class="bi bi-printer-fill me-1"></i> Print Now
                </button>
            </div>

            <div class="card-body p-5">
                <div class="row mb-4">
                    <div class="col-8">
                        <h2 class="fw-bold text-dark mb-1">SURJO SPORTS</h2>
                        <p class="text-muted small">
                            House 33/2A, Road 1, Zigatola, Dhaka-1213<br>
                            <strong>Phone:</strong> +880 1700-000000 | <strong>Email:</strong> sales@surjosports.com
                        </p>
                    </div>
                    <div class="col-4 text-end">
                        <h3 class="text-uppercase text-secondary fw-light">Invoice</h3>
                        <div class="small">
                            <span class="text-muted">ID:</span> #{{ $order->id }}<br>
                            <span class="text-muted">Date:</span> {{ date('d M, Y', strtotime($order->created_at)) }}
                        </div>
                    </div>
                </div>

                <div class="row mb-4 pt-3 border-top">
                    <div class="col-6">
                        <p class="text-muted text-uppercase small fw-bold mb-1">Bill To</p>
                        <h6 class="fw-bold mb-0">{{ $order->customer_name }}</h6>
                        <p class="text-muted small mb-0">{{ $order->address }}</p>
                        <p class="text-muted small"><strong>Mobile:</strong> {{ $order->mobile }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="text-muted text-uppercase small fw-bold mb-1">Order Status</p>
                        <span
                            class="badge {{ $order->status == 'delivered' ? 'bg-success' : 'bg-warning' }} text-uppercase">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Product Details</th>
                            <th class="text-center">Size</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $items = json_decode($order->cart_details); @endphp
                        @if ($items)
                            @foreach ($items as $item)
                                @php $product = DB::table('products')->where('id', $item->product_id)->first(); @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($product)
                                                <img src="{{ $product->image }}" class="product-img me-2">
                                            @endif
                                            <div>
                                                <span class="d-block fw-bold">{{ $item->name }}</span>
                                                <small class="text-muted">SKU: {{ $item->product_id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">{{ $item->size }}</td>
                                    <td class="text-center align-middle">{{ $item->qty }}</td>
                                    <td class="text-end align-middle fw-bold">Tk
                                        {{ number_format($item->price * $item->qty, 2) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <div class="row justify-content-end">
                    <div class="col-5">
                        <div class="d-flex justify-content-between p-2">
                            <span class="fw-bold">Grand Total:</span>
                            <span class="fw-bold text-primary">Tk {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 text-center border-top">
                    <p class="small text-muted mb-0">Thank you for choosing Surjo Sports!</p>
                    <small class="text-muted">Visit us again at www.surjo.net</small>
                </div>
            </div>
        </div>
    </div>
@endsection
