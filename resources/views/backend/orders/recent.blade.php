@extends('backend.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">All Orders</h2>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
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
                                                    <li>• {{ $item->name }}
                                                        <span class="text-primary">(QTY
                                                            {{ $item->qty }} PCS)
                                                        </span>
                                                        <span class="text-primary">(
                                                            Size: {{ $item->size }})
                                                        </span>
                                                        <span class="text-info">(
                                                            Code: {{ $item->product_id }})
                                                        </span>
                                                    </li>
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
    </div>
@endsection
