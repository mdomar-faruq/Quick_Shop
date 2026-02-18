@extends('backend.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Product</h2>
            <a href="{{ route('adminAddProduct') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add New Product
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td class="ps-4">
                                        @if ($product->image)
                                            <img src="{{ $product->image }}" class="rounded shadow-sm" width="50"
                                                height="50" style="object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $product->name }}</td>
                                    <td>Tk{{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('adminProductEnableDisable', $product->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <div class="btn-group" role="group" aria-label="Enable/Disable">
                                                <input type="radio" class="btn-check" name="txt_status"
                                                    id="enableBtn_{{ $product->id }}" value="1" autocomplete="off"
                                                    onchange="this.form.submit()"
                                                    {{ $product->status == 1 ? 'checked' : '' }}>
                                                <label class="btn btn-outline-success"
                                                    for="enableBtn_{{ $product->id }}">Enable</label>

                                                <input type="radio" class="btn-check" name="txt_status"
                                                    id="disableBtn_{{ $product->id }}" value="2" autocomplete="off"
                                                    onchange="this.form.submit()"
                                                    {{ $product->status == 2 ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger"
                                                    for="disableBtn_{{ $product->id }}">Disable</label>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('adminProductEdit', $product->id) }}"
                                            class="btn btn-sm btn-outline-primary me-1">
                                            Edit
                                        </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
