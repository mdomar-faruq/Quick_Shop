@extends('backend.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold">Edit Product: <span class="text-primary">{{ $product->name }}</span></h3>
                </div>
                <a href="{{ route('adminProduct') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            <div class="col-12">
                <form action="{{ route('adminProductUpdate', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Crucial for Update routes --}}

                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="card shadow-sm border-0 rounded-4 p-4 mb-4">
                                <h5 class="fw-bold mb-4">Product Information</h5>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Product Name</label>
                                    <input type="text" name="name" id="product_name"
                                        class="form-control form-control-lg" value="{{ $product->name }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Slug (URL)</label>
                                    <input type="text" name="slug" id="slug" class="form-control bg-light"
                                        value="{{ $product->slug }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" rows="5" class="form-control">{{ $product->description }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Price (TK)</label>
                                        <input type="number" name="price" class="form-control"
                                            value="{{ $product->price }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Old Price (TK)</label>
                                        <input type="number" name="old_price" class="form-control"
                                            value="{{ $product->old_price }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card shadow-sm border-0 rounded-4 p-4 mb-4">
                                <label class="form-label fw-bold text-info">Category</label>
                                <select name="category_id" class="form-select">
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="card shadow-sm border-0 rounded-4 p-4 mb-4">
                                <label class="form-label fw-bold text-warning">Main Image</label>
                                <div class="mb-3 text-center">
                                    <img src="{{ $product->image }}" class="rounded border mb-2"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <input type="file" name="image" class="form-control">
                                <small class="text-muted small">Upload new to replace</small>
                            </div>

                            <div class="card shadow-sm border-0 rounded-4 p-4 mb-4">
                                <label class="form-label fw-bold text-success">Gallery Images</label>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    @foreach ($product->gallery as $img)
                                        <img src="{{ $img }}" class="rounded border"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    @endforeach
                                </div>
                                <input type="file" name="gallery[]" class="form-control" multiple>
                                <small class="text-muted small">Selecting new files will replace all gallery images</small>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill py-3 fw-bold">
                                <i class="bi bi-check-circle me-1"></i> Update Product
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Keep slug generator for edits too
        document.getElementById('product_name').addEventListener('keyup', function() {
            let text = this.value;
            text = text.toLowerCase().replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
            document.getElementById('slug').value = text;
        });
    </script>
@endsection
