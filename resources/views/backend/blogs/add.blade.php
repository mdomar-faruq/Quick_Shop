@extends('backend.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('adminBlog') }}">Blogs</a></li>
                        <li class="breadcrumb-item active">New Blog</li>
                    </ol>
                </nav>

                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Add New Blog</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('adminBlogStore') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Title</label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Title"
                                    value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category_id" id="category_id" class="form-control ">
                                    <option value="">Choose Option</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == old('category_id') ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Offer Price</label>
                                <div class="input-group">
                                    <input type="text" name="offer_price_text"
                                        class="form-control @error('offer_price_text') is-invalid @enderror"
                                        placeholder="Today :" value="{{ old('offer_price_text') }}" required>
                                    <span class="input-group-text">Tk</span>
                                    <input type="number" step="0.01" name="offer_price"
                                        class="form-control @error('offer_price') is-invalid @enderror" placeholder="0.00"
                                        value="{{ old('offer_price') }}" required>
                                    @error('offer_price_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('offer_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Regular Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">Tk</span>
                                    <input type="number" step="0.01" name="regular_price"
                                        class="form-control @error('regular_price') is-invalid @enderror" placeholder="0.00"
                                        value="{{ old('regular_price') }}" required>
                                    @error('regular_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Multiple Images</label>
                                <input type="file" name="images[]" id="image-input"
                                    class="form-control @error('images') is-invalid @enderror" multiple>
                                <small class="text-muted">Recommended: Square image, max 2MB each</small>
                                @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preview container -->
                            <div id="preview" class="mt-3 d-flex flex-wrap gap-2"></div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Short Description</label>
                                <textarea type="text" class="form-control @error('short_description') is-invalid @enderror" name="short_description"
                                    cols="30" rows="10">{{ old('short_description') }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-save me-2"></i>Save Product
                                </button>
                                <a href="{{ route('adminBlog') }}" class="btn btn-warning">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('image-input').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            preview.innerHTML = ""; // clear previous previews

            const files = event.target.files;
            if (files) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-thumbnail');
                        img.style.width = "100px";
                        img.style.height = "100px";
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>
@endpush
