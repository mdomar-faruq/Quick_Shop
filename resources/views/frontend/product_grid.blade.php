@foreach ($products as $item)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="animated-card-wrapper shadow-sm">
            <div class="product-card-inner">
                <a href="{{ route('getProductDetails', $item->slug) }}" class="text-decoration-none">
                    <div class="overflow-hidden rounded-3 mb-2">
                        <img src="{{ $item->image }}" class="img-fluid w-100" style="aspect-ratio: 1/1; object-fit: cover;">
                    </div>
                    <h6 class="text-dark fw-bold mb-1 text-truncate">{{ $item->name }}</h6>
                    <span class="card-new-price">{{ number_format($item->price, 0) }} ৳</span>
                    <div class="btn-more-details text-center py-2 rounded-3 mt-auto">বিস্তারিত</div>
                </a>
            </div>
        </div>
    </div>
@endforeach