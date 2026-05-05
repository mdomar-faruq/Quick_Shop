@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid py-5 px-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                <h2 class="fw-black mb-1 text-dark">Product Inventory</h2>
                <p class="text-muted mb-0">Manage your premium kits and stock levels</p>
            </div>
            <a href="{{ route('adminAddProduct') }}" class="btn btn-dark btn-lg rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i> Add New Product
            </a>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <small class="text-uppercase fw-bold text-muted">Total Products</small>
                    <h3 class="fw-bold mb-0">{{ $products->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 border-0 text-uppercase small fw-bold text-muted">Product Info</th>
                                <th class="py-3 border-0 text-uppercase small fw-bold text-muted">Category</th>
                                <th class="py-3 border-0 text-uppercase small fw-bold text-muted">Price Strategy</th>
                                <th class="py-3 border-0 text-uppercase small fw-bold text-muted">Page Link</th>
                                <th class="py-3 border-0 text-uppercase small fw-bold text-muted">Status</th>
                                <th class="py-3 border-0 text-uppercase small fw-bold text-muted text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr class="transition">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative">
                                                @if ($product->image)
                                                    <img src="{{ $product->image }}" class="rounded-3 shadow-sm"
                                                        width="60" height="60" style="object-fit: cover;">
                                                @else
                                                    <div class="bg-soft-secondary rounded-3 d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <span
                                                    class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-dark border border-white">
                                                    #{{ $product->id }}
                                                </span>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="fw-bold mb-0">{{ $product->name }}</h6>
                                                <small class="text-muted">Slug: /{{ $product->slug ?? 'no-slug' }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-medium">
                                            <i class="bi bi-tag-fill me-1 text-primary"></i> {{ $product->cat_name }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="fw-bold text-dark">Tk {{ number_format($product->price, 2) }}</div>
                                        @if ($product->old_price)
                                            <small class="text-muted text-decoration-line-through">Tk
                                                {{ number_format($product->old_price, 2) }}</small>
                                        @endif
                                    </td>

                                    <td>
                                        <button class="btn btn-outline-primary btn-sm rounded-pill px-3 copy-btn"
                                            onclick="copyToClipboard('{{ route('getProductDetails', $product->slug) }}', this)">
                                            <i class="bi bi-link-45deg"></i> Copy Link
                                        </button>
                                    </td>

                                    <td>
                                        <form action="{{ route('adminProductEnableDisable', $product->id) }}"
                                            method="POST" id="statusForm_{{ $product->id }}">
                                            @csrf
                                            <div class="form-check form-switch">
                                                <input class="form-check-input custom-switch" type="checkbox" role="switch"
                                                    id="switch_{{ $product->id }}"
                                                    {{ $product->status == 1 ? 'checked' : '' }}
                                                    onchange="this.form.submit()">
                                                <label
                                                    class="form-check-label small fw-bold {{ $product->status == 1 ? 'text-success' : 'text-danger' }}">
                                                    {{ $product->status == 1 ? 'Active' : 'Disabled' }}
                                                </label>
                                                <input type="hidden" name="txt_status"
                                                    value="{{ $product->status == 1 ? 2 : 1 }}">
                                            </div>
                                        </form>
                                    </td>

                                    <td class="text-end pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-circle" type="button"
                                                data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('adminProductEdit', $product->id) }}"><i
                                                            class="bi bi-pencil me-2"></i> Edit Details</a></li>
                                                <li><a class="dropdown-item" href="/product/{{ $product->slug }}"
                                                        target="_blank"><i class="bi bi-eye me-2"></i> View Live</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item text-danger" href="#"><i
                                                            class="bi bi-trash me-2"></i> Delete Product</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="80"
                                            class="mb-3 opacity-25">
                                        <p class="text-muted fw-medium">No products available in your inventory.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .fw-black {
            font-weight: 900;
        }

        .bg-soft-secondary {
            background-color: #f0f2f5;
        }

        .transition {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #fafbfc;
            transform: scale(1.002);
        }

        /* Modern Switch Styling */
        .custom-switch {
            width: 2.5rem !important;
            height: 1.25rem !important;
            cursor: pointer;
        }

        .custom-switch:checked {
            background-color: #198754;
            border-color: #198754;
        }

        /* Action Dropdown Hover */
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #000;
        }

        /* page link */
        .custom-switch {
            width: 2.5em !important;
            height: 1.25em !important;
            cursor: pointer;
        }

        .transition {
            transition: all 0.2s ease-in-out;
        }

        .transition:hover {
            background-color: rgba(13, 110, 253, 0.02);
        }

        .bg-soft-secondary {
            background-color: #f8f9fa;
        }
    </style>

    <script>
        function copyToClipboard(text, button) {
            // Create a temporary textarea to handle the copy
            const el = document.createElement('textarea');
            el.value = text;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);

            // Visual Feedback
            const originalContent = button.innerHTML;
            button.classList.replace('btn-outline-primary', 'btn-success');
            button.innerHTML = '<i class="bi bi-check2"></i> Copied!';
            button.disabled = true;

            // Reset button after 2 seconds
            setTimeout(() => {
                button.classList.replace('btn-success', 'btn-outline-primary');
                button.innerHTML = originalContent;
                button.disabled = false;
            }, 2000);
        }
    </script>
@endsection
