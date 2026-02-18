@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0 text-body">Distribution Overview</h1>
                <p class="text-secondary">Real-time Sales and Purchase data.</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-primary-subtle text-primary p-3 rounded">
                                <i class="bi bi-box-seam fs-3"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-secondary mb-1">Total Stock</h6>
                                <h4 class="mb-0 text-body">12,450</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-success-subtle text-success p-3 rounded">
                                <i class="bi bi-truck fs-3"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-secondary mb-1">On Delivery</h6>
                                <h4 class="mb-0 text-body">48</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom py-3">
                <h5 class="mb-0 text-body">Recent Orders</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Order ID</th>
                            <th>Customer Info</th>
                            <th>Items Purchased</th>
                            <th>Total Amount</th>
                            <th>Date</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $order->customer_name }}</div>
                                    <div class="text-muted small">{{ $order->mobile }}</div>
                                    <div class="text-muted small" style="max-width: 200px;">{{ $order->address }}</div>
                                </td>
                                <td>
                                    <ul class="list-unstyled mb-0 small">
                                        @php
                                            $items = json_decode($order->cart_details);
                                        @endphp
                                        @if ($items)
                                            @foreach ($items as $item)
                                                <li>• {{ $item->name }} <span class="text-primary">(QTY
                                                        {{ $item->qty }} PCS)</span></li>
                                            @endforeach
                                        @else
                                            <span class="text-danger">No items data</span>
                                        @endif
                                    </ul>
                                </td>
                                <td class="fw-bold text-success">
                                    Tk{{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="text-muted small">
                                    {{ date('d M, Y', strtotime($order->created_at)) }}<br>
                                    {{ date('h:i A', strtotime($order->created_at)) }}
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-sm dropdown-toggle 
                                           {{ $order->status == 'delivered' ? 'btn-success' : ($order->status == 'cancelled' ? 'btn-danger' : 'btn-warning') }}"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ ucfirst($order->status) }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <form action="{{ route('adminOrderUpdateStatus', $order->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="pending">
                                                    <button type="submit" class="dropdown-item">Pending</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('adminOrderUpdateStatus', $order->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="delivered">
                                                    <button type="submit"
                                                        class="dropdown-item text-success">Delivered</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('adminOrderUpdateStatus', $order->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit"
                                                        class="dropdown-item text-danger">Cancelled</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
