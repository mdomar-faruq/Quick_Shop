@extends('backend.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Edit Category</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('adminCategoryUpdate', $categories->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            {{-- @method('PUT') --}}

                            <div class="mb-3 text-center">
                                @if ($categories->image)
                                    <img src="{{ $categories->image }}" class="img-thumbnail mb-2" width="150">
                                    <p class="small text-muted">Current Image</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Category Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $categories->name) }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Update Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning">Update Category</button>
                                <a href="{{ route('adminCategorie') }}" class="btn btn-link text-muted">Go Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
