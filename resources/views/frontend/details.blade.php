<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | SURJO SPORTS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --accent-color: #ff4757;
            --success-color: #2ed573;
        }

        body {
            font-family: 'Hind Siliguri', 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7fa;
            color: #2d3436;
            padding-bottom: 80px;
            /* Space for mobile sticky button */
        }

        /* Navbar Styling */
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95) !important;
            transition: 0.3s;
        }

        .navbar-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-transform: uppercase;
            font-size: 1.5rem !important;
        }

        /* Product Image & Gallery */
        .main-img-container {
            background: white;
            border-radius: 20px;
            border: 1px solid #eee;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-img-container img {
            max-height: 450px;
            width: 100%;
            object-fit: contain;
        }

        .thumb-scroll {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 10px 0;
            scrollbar-width: none;
        }

        .thumb-scroll::-webkit-scrollbar {
            display: none;
        }

        .thumb-img {
            width: 70px;
            height: 70px;
            flex-shrink: 0;
            object-fit: cover;
            border-radius: 12px;
            cursor: pointer;
            border: 2px solid #eee;
            transition: 0.2s;
        }

        .thumb-img.active {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        /* Pricing */
        .price-badge {
            display: inline-block;
            background: linear-gradient(45deg, var(--accent-color), #ff6b81);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1.5rem;
        }

        .old-price-style {
            text-decoration: line-through;
            color: #a1a1a1;
            font-size: 1.1rem;
        }

        /* Form Styling */
        .order-form-card {
            background: #ffffff;
            border-radius: 20px;
            border: 2px dashed var(--primary-color);
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #dfe6e9;
        }

        .btn-order-now {
            background: linear-gradient(45deg, #FF416C, #FF4B2B);
            /* Bright Red-Orange */
            border: none;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(255, 65, 108, 0.3);
        }

        .btn-order-now:hover {
            background: linear-gradient(45deg, #FF4B2B, #FF416C);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 65, 108, 0.4);
            color: white;
        }



        /* Mobile Optimization */
        @media (max-width: 768px) {
            .mobile-sticky-btn {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                padding: 15px;
                z-index: 1030;
                box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.1);
            }

            .navbar-brand {
                font-size: 1.2rem !important;
            }

            .price-badge {
                font-size: 1.2rem;
            }
        }

        footer {
            background-color: #1e272e !important;
        }

        .social-btn {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: 0.3s;
        }

        .social-btn:hover {
            background: var(--accent-color);
            border-color: var(--accent-color);
        }
    </style>

    <style>
        /* Animated Border Card */
        .animated-card-wrapper {
            position: relative;
            padding: 3px;
            /* The thickness of the animated border */
            background: #ff9a9e;
            border-radius: 18px;
            overflow: hidden;
            height: 100%;
            z-index: 1;
        }

        /* The Moving Gradient Background */
        .animated-card-wrapper::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: linear-gradient(270deg, #ff9a9e, #fad0c4, #fbc2eb, #8b00ff);
            top: -25%;
            left: -25%;
            animation: borderRotate 4s linear infinite;
            z-index: -2;
        }

        /* Inner card cover to hide the center of the gradient */
        .product-card-inner {
            background: white;
            border-radius: 15px;
            height: 100%;
            width: 100%;
            padding: 10px;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
        }

        @keyframes borderRotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Product Card Elements */
        .product-card-inner img {
            transition: transform 0.3s ease;
        }

        .animated-card-wrapper:hover img {
            transform: scale(1.05);
        }

        .sale-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff4757;
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 5px;
            z-index: 2;
            text-transform: uppercase;
        }

        .card-old-price {
            text-decoration: line-through;
            color: #a1a1a1;
            font-size: 0.85rem;
            margin-right: 5px;
        }

        .card-new-price {
            color: #ff4757;
            font-weight: 800;
            font-size: 1.1rem;
        }

        .btn-more-details {
            background: rgba(13, 110, 253, 0.05);
            color: #0d6efd;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid rgba(13, 110, 253, 0.2);
            transition: all 0.3s ease;
        }

        .animated-card-wrapper:hover .btn-more-details {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
        }
    </style>

    <style>
        .btn-whatsapp {
            background-color: #25D366;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            transition: 0.3s;
        }

        .btn-whatsapp:hover {
            background-color: #128C7E;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 211, 102, 0.3);
        }

        /* Optional: Pulse effect for WhatsApp to grab attention */
        .btn-whatsapp {
            animation: shadow-pulse 2s infinite;
        }

        @keyframes shadow-pulse {
            0% {
                box-shadow: 0 0 0 0px rgba(37, 211, 102, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(37, 211, 102, 0);
            }

            100% {
                box-shadow: 0 0 0 0px rgba(37, 211, 102, 0);
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-light bg-white py-3 shadow-sm sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                <span style="color: #000;">SURJO</span>
                <span style="color: var(--accent-color); margin-left: 2px;">SPORTS</span>
            </a>

            <a href="tel:+8801XXXXXXXXX"
                class="text-decoration-none d-flex align-items-center bg-light px-3 py-2 rounded-pill">
                <i class="bi bi-telephone-fill text-danger me-2"></i>
                <span class="fw-bold d-none d-md-inline small text-dark">হেল্পলাইন: +৮৮০১৭...</span>
            </a>
        </div>
    </nav>


    <div class="container py-4">
        <div class="row g-4 gx-lg-5">
            <div class="col-lg-6">
                <div class="main-img-container p-2 mb-3 shadow-sm">
                    <img id="view" src="{{ $product->image }}" class="rounded-4" alt="{{ $product->name }}">
                </div>

                @php $gallery = json_decode($product->gallery); @endphp
                <div class="thumb-scroll justify-content-center">
                    <img src="{{ $product->image }}" class="thumb-img active shadow-sm" onclick="changeImage(this)">
                    @if ($gallery)
                        @foreach ($gallery as $img)
                            <img src="{{ $img }}" class="thumb-img shadow-sm" onclick="changeImage(this)">
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-lg-6" id="order-section">
                <div class="ps-lg-3">
                    <h1 class="fw-bold mb-2 h2">{{ $product->name }}</h1>

                    <div class="mb-4 d-flex align-items-center gap-3">
                        @if ($product->old_price)
                            <span class="old-price-style">{{ number_format($product->old_price, 0) }} TK</span>
                        @endif
                        <div class="price-badge">{{ number_format($product->price, 0) }} TK</div>
                    </div>

                    <div class="order-form-card mb-4 shadow-sm">
                        <h5 class="fw-bold mb-4 text-primary d-flex align-items-center">
                            <i class="bi bi-truck-flatbed me-2"></i> ডেলিভারি তথ্য দিন
                        </h5>

                        <form action="{{ route('placeOrder') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="product_name" value="{{ $product->name }}">
                            <input type="hidden" id="product_price" name="price" value="{{ $product->price }}">

                            <div class="mb-3">
                                <label class="form-label fw-bold small">আপনার নাম</label>
                                <input type="text" name="name" class="form-control" placeholder="নাম লিখুন">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">মোবাইল নাম্বার *</label>
                                <input type="tel" name="phone" class="form-control"
                                    placeholder="১১ ডিজিটের মোবাইল নাম্বার" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">সম্পূর্ণ ঠিকানা</label>
                                <textarea name="address" class="form-control" rows="2" placeholder="জেলা, থানা, এলাকা"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small d-block">সাইজ সিলেক্ট করুন *</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach (['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                        <input type="radio" class="btn-check" name="size"
                                            id="s-{{ $size }}" value="{{ $size }}" required>
                                        <label class="btn btn-outline-dark fw-bold px-3 py-2 rounded-3"
                                            for="s-{{ $size }}">{{ $size }}</label>
                                    @endforeach
                                </div>
                            </div>

                            <label class="form-label fw-bold small">ডেলিভারি এরিয়া সিলেক্ট করুন *</label>
                            <div class="form-check p-3 rounded-4 border w-100 mb-2 bg-light d-flex align-items-center">
                                <input class="form-check-input ms-1" type="radio" name="delivery_charge"
                                    id="in" value="60" onchange="updateTotal()" checked>
                                <label class="form-check-label ms-2" for="in">ঢাকার ভিতরে (৬০ টাকা)</label>
                            </div>
                            <div class="form-check p-3 rounded-4 border w-100 mb-4 bg-light d-flex align-items-center">
                                <input class="form-check-input ms-1" type="radio" name="delivery_charge"
                                    id="out" value="120" onchange="updateTotal()">
                                <label class="form-check-label ms-2" for="out">ঢাকার বাইরে (১২০ টাকা)</label>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                                <span class="fw-bold">মোট খরচ:</span>
                                <span class="fw-bold text-danger h4 mb-0"><span
                                        id="total_display">{{ number_format($product->price + 60, 0) }}</span>
                                    TK</span>
                            </div>

                            <button type="submit" class="btn btn-order-now w-100 py-3 rounded-4">
                                <i class="bi bi-bag-check-fill me-2"></i> অর্ডার কনফার্ম করুন
                            </button>

                            {{-- <a href="https://wa.me/8801XXXXXXXXX?text={{ urlencode('হ্যালো, আমি আপনার শপ থেকে ' . $product->name . ' এই প্রোডাক্টটি অর্ডার করতে চাই। মূল্য: ' . $product->price . ' টাকা।') }}"
                                target="_blank"
                                class="btn btn-whatsapp w-100 py-3 rounded-4 d-flex align-items-center justify-content-center mt-3">
                                <i class="bi bi-whatsapp me-2"></i> হোয়াটসঅ্যাপে অর্ডার করুন
                            </a> --}}
                        </form>
                    </div>

                    <div class="p-3 bg-white rounded-4 shadow-sm mb-4 border-start border-primary border-4">
                        <h6 class="fw-bold text-dark">পণ্যটির বিস্তারিত:</h6>
                        <p class="text-secondary small mb-0">
                            {{ $product->description ?? 'প্রিমিয়াম কোয়ালিটি ফেব্রিক, প্লেয়ার ভার্সন জার্সি। আরামদায়ক এবং টেকসই।' }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <div class="mt-5">
            <h4 class="fw-bold mb-4 d-flex align-items-center">
                <span class="bg-primary p-1 me-2 rounded"
                    style="height: 24px; width: 6px; display: inline-block;"></span>
                আরও কিছু প্রোডাক্ট
            </h4>
            <div class="row g-3">
                @foreach ($similar as $item)
                    <div class="col-6 col-md-3">
                        <div class="animated-card-wrapper shadow-sm">
                            <div class="product-card-inner">
                                <a href="{{ route('getProductDetails', $item->slug) }}" class="text-decoration-none">

                                    @if ($item->old_price > $item->price)
                                        @php
                                            $discount = round(
                                                (($item->old_price - $item->price) / $item->old_price) * 100,
                                            );
                                        @endphp
                                        <div class="sale-badge">{{ $discount }}% OFF</div>
                                    @endif

                                    <div class="overflow-hidden rounded-3 mb-2">
                                        <img src="{{ $item->image }}" class="img-fluid" alt="{{ $item->name }}">
                                    </div>

                                    <h6 class="text-dark fw-bold mb-1 text-truncate" style="font-size: 0.95rem;">
                                        {{ $item->name }}
                                    </h6>

                                    <div class="d-flex align-items-center flex-wrap">
                                        @if ($item->old_price)
                                            <span class="card-old-price">{{ number_format($item->old_price, 0) }}
                                                ৳</span>
                                        @endif
                                        <span class="card-new-price">{{ number_format($item->price, 0) }} ৳</span>
                                    </div>

                                    <div class="btn-more-details text-center py-2 rounded-3">
                                        বিস্তারিত দেখুন <i class="bi bi-arrow-right-short"></i>
                                    </div>

                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <footer class="text-white pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row gy-4 text-center text-md-start">
                <div class="col-md-4">
                    <h4 class="fw-bold mb-3">SURJO <span style="color: var(--accent-color);">SPORTS</span></h4>
                    <p class="text-white-50 small">প্রিমিয়াম কোয়ালিটি জার্সি এবং স্পোর্টস এক্সেসরিজের নির্ভরযোগ্য
                        অনলাইন শপ। সারা বাংলাদেশে ক্যাশ অন ডেলিভারি।</p>
                </div>

                <div class="col-md-4 text-center">
                    <h6 class="fw-bold text-uppercase mb-3 text-white-50 small">যোগাযোগের ঠিকানা</h6>
                    <div class="text-white-50 small">
                        <p class="mb-2"><i class="bi bi-geo-alt-fill text-danger me-2"></i> ঢাকা, বাংলাদেশ</p>
                        <p class="mb-2"><i class="bi bi-telephone-fill text-danger me-2"></i> +৮৮০১৭XXXXXXXX</p>
                        <p class="mb-2"><i class="bi bi-envelope-fill text-danger me-2"></i> info@surjosports.com
                        </p>
                    </div>
                </div>

                <div class="col-md-4 text-md-end text-center">
                    <h6 class="fw-bold text-uppercase mb-3 text-white-50 small">ফলো করুন</h6>
                    <div class="d-flex justify-content-center justify-content-md-end gap-2">
                        <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-tiktok"></i></a>
                        <a href="https://wa.me/+8801681935050" class="social-btn" target="_blank">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.05);">
            <div class="text-center text-white-50 small">
                © ২০২৬ <span class="fw-bold text-white">SURJO SPORTS</span>. সর্বস্বত্ব সংরক্ষিত।
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function changeImage(element) {
            document.getElementById('view').src = element.src;
            document.querySelectorAll('.thumb-img').forEach(img => img.classList.remove('active'));
            element.classList.add('active');
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'অর্ডার সফল!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2ed573'
            });
        @endif
    </script>

    <script>
        function updateTotal() {
            // Get the base product price from the hidden input
            let productPrice = parseInt(document.getElementById('product_price').value);

            // Get the selected delivery charge
            let deliveryCharge = parseInt(document.querySelector('input[name="delivery_charge"]:checked').value);

            // Calculate total
            let total = productPrice + deliveryCharge;

            // Update the display text
            document.getElementById('total_display').innerText = total.toLocaleString();
        }

        // Run once on load to ensure price is correct if 'out' was somehow pre-selected
        window.onload = updateTotal;
    </script>
</body>

</html>
