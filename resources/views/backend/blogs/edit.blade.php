@extends('backend.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('adminBlog') }}">Blogs</a></li>
                        <li class="breadcrumb-item active">Edit Blog</li>
                    </ol>
                </nav>

                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Blog</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('adminBlogUpdate', $blog->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            {{-- @method('PUT') --}}

                            <div class="mb-3">
                                <label class="form-label fw-bold">Title</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $blog->title) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category_id" class="form-control">
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == old('category_id', $blog->category_id) ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Offer Price</label>
                                <div class="input-group">
                                    <input type="text" name="offer_price_text" class="form-control"
                                        value="{{ old('offer_price_text', $blog->offer_price_text) }}" required>
                                    <span class="input-group-text">Tk</span>
                                    <input type="number" step="0.01" name="offer_price" class="form-control"
                                        value="{{ old('offer_price', $blog->offer_price) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Regular Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">Tk</span>
                                    <input type="number" step="0.01" name="regular_price" class="form-control"
                                        value="{{ old('regular_price', $blog->regular_price) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Current Images</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach (json_decode($blog->images, true) as $img)
                                        <img src="{{ $img }}" class="img-thumbnail"
                                            style="width:100px; height:100px;">
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Replace / Add Images</label>
                                <input type="file" name="images[]" id="image-input" class="form-control" multiple>
                                <small class="text-muted">Upload new images to replace or add</small>
                            </div>

                            <div id="preview" class="mt-3 d-flex flex-wrap gap-2"></div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Short Description</label>
                                <textarea name="short_description" class="form-control" rows="5">{{ old('short_description', $blog->short_description) }}</textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-save me-2"></i>Update Blog
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
            preview.innerHTML = "";
            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.width = "100px";
                    img.style.height = "100px";
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
