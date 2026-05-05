@extends('backend.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="{{ route('adminProduct') }}"
                                    class="text-decoration-none">Products</a></li>
                            <li class="breadcrumb-item active">Add New Platinum Product</li>
                        </ol>
                    </nav>
                    <h3 class="fw-bold">Create New Product</h3>
                </div>
                <a href="{{ route('adminProduct') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>

            <div class="col-12">
                <form action="{{ route('adminProductStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">

                        <div class="col-lg-8">
                            <div class="card shadow-sm border-0 rounded-4 p-3 mb-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-4 text-primary">General Information</h5>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Product Name</label>
                                        <input type="text" name="name" id="product_name"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            placeholder="e.g. Argentina Home Kit 2024" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Slug (URL)</label>
                                        <input type="text" name="slug" id="slug"
                                            class="form-control bg-light @error('slug') is-invalid @enderror"
                                            placeholder="argentina-home-kit-2024" value="{{ old('slug') }}">
                                        <small class="text-muted">This will be the web address:
                                            surjosports.com/product/<strong>slug</strong></small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Description</label>
                                        <textarea name="description" rows="5" class="form-control"
                                            placeholder="Write premium details about the fabric, fit, and quality...">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm border-0 rounded-4 p-3">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-4 text-success">Pricing & Inventory</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">New Price (TK)</label>
                                            <input type="number" name="price" class="form-control form-control-lg"
                                                placeholder="0.00" value="{{ old('price') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Old Price (TK) <span
                                                    class="text-muted small">(Optional)</span></label>
                                            <input type="number" name="old_price" class="form-control form-control-lg"
                                                placeholder="0.00" value="{{ old('old_price') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card shadow-sm border-0 rounded-4 p-3 mb-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-4 text-info">Organization</h5>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Category (Team)</label>
                                        <select name="category_id" class="form-select form-select-lg">
                                            <option value="">Choose Team</option>
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('category_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm border-0 rounded-4 p-3">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-4 text-warning">Product Media</h5>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Main Image</label>
                                        <input type="file" name="image" class="form-control"
                                            onchange="previewMainImage(this)">
                                        <div id="main-preview" class="mt-2 text-center border rounded-3 p-2 d-none">
                                            <img src="" id="main-img-tag"
                                                style="max-width: 100%; height: 150px; object-fit: contain;">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Gallery Images</label>
                                        <input type="file" name="gallery[]" class="form-control" multiple>
                                        <small class="text-muted">Select multiple images for the slider</small>
                                    </div>

                                    <button type="submit"
                                        class="btn btn-primary btn-lg w-100 rounded-pill py-3 fw-bold shadow">
                                        <i class="bi bi-cloud-upload me-2"></i> Publish Product
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-generate Slug from Name
        document.getElementById('product_name').addEventListener('keyup', function() {
            let text = this.value;
            text = text.toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug').value = text;
        });

        // Main Image Preview
        function previewMainImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('main-preview').classList.remove('d-none');
                    document.getElementById('main-img-tag').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <style>
        .card {
            transition: 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ff4757;
            box-shadow: 0 0 0 0.25rem rgba(255, 71, 87, 0.1);
        }
    </style>
@endsection
