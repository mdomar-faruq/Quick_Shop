@extends('backend.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Blogs</h2>
            <a href="{{ route('adminAddBlog') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add New Blogs
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th class="ps-4">SL No</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Offer Price</th>
                                <th>Regular Price</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $key=>$blog)
                                <tr>
                                    <td class="fw-semibold">{{ $key + 1 }}</td>
                                    <td class="fw-semibold">{{ $blog->title }}</td>
                                    <td class="fw-semibold">{{ $blog->cat_name }}</td>
                                    <td class="fw-semibold">{{ $blog->offer_price_text }}
                                        <strong>{{ $blog->offer_price }}</strong>
                                    </td>
                                    <td class="fw-semibold text-muted">{{ $blog->regular_price }}</td>
                                    <td class="ps-4">

                                        @php
                                            $images = json_decode($blog->images, true);
                                        @endphp
                                        @if ($images)
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($images as $img)
                                                    <img src="{{ $img }}" alt="Blog image"
                                                        style="width:80px; height:80px; object-fit:cover; border-radius:4px;">
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- @if ($product->image)
                                            <img src="{{ $product->image }}" class="rounded shadow-sm" width="50"
                                                height="50" style="object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif --}}
                                    </td>
                                    <td>
                                        <form action="{{ route('adminBlogEnableDisable', $blog->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <div class="btn-group" role="group" aria-label="Enable/Disable">
                                                <input type="radio" class="btn-check" name="txt_status"
                                                    id="enableBtn_{{ $blog->id }}" value="1" autocomplete="off"
                                                    onchange="this.form.submit()"
                                                    {{ $blog->status == 1 ? 'checked' : '' }}>
                                                <label class="btn btn-outline-success"
                                                    for="enableBtn_{{ $blog->id }}">Enable</label>

                                                <input type="radio" class="btn-check" name="txt_status"
                                                    id="disableBtn_{{ $blog->id }}" value="2" autocomplete="off"
                                                    onchange="this.form.submit()"
                                                    {{ $blog->status == 2 ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger"
                                                    for="disableBtn_{{ $blog->id }}">Disable</label>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('adminBlogEdit', $blog->id) }}"
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
