<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সকল প্রোডাক্ট | SURJO SPORTS</title>

    <!-- Meta Pixel Code -->
    @php
        $facebookPixelId = env('FACEBOOK_PIXEL_ID', '');
    @endphp
    @if ($facebookPixelId)
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $facebookPixelId }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ $facebookPixelId }}&ev=PageView&noscript=1" /></noscript>
    @endif
    <!-- End Meta Pixel Code -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --accent-color: #ff4757;
        }

        body {
            font-family: 'Hind Siliguri', 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7fa;
            color: #2d3436;
        }

        /* Navbar & Footer (Same as original) */
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95) !important;
        }

        .navbar-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-transform: uppercase;
            font-size: 1.5rem !important;
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

        /* Animated Card Design (Your specific request) */
        .animated-card-wrapper {
            position: relative;
            padding: 3px;
            background: #ff9a9e;
            border-radius: 18px;
            overflow: hidden;
            height: 100%;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .animated-card-wrapper::before {
            content: '';
            position: absolute;
            width: 180%;
            height: 180%;
            top: -40%;
            left: -40%;
            background: conic-gradient(from 0deg, #ff9a9e, #fad0c4, #fbc2eb, #8b00ff, #ff9a9e);
            border-radius: 50%;
            animation: borderRotate 4s linear infinite;
            z-index: -2;
        }

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
            transition: 0.3s;
        }

        .animated-card-wrapper:hover {
            transform: translateY(-5px);
        }

        .animated-card-wrapper:hover .btn-more-details {
            background: #0d6efd;
            color: white;
        }

        .page-header {
            background: white;
            border-bottom: 1px solid #eee;
            padding: 40px 0;
            margin-bottom: 30px;
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

    <div class="page-header">
        <div class="container text-center">
            <h2 class="fw-800 mb-2">আমাদের সকল কালেকশন</h2>
            <p class="text-secondary">প্রিমিয়াম কোয়ালিটির জার্সি এবং স্পোর্টস এক্সেসরিজ</p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row g-3 g-md-4" id="product-container">
            @include('frontend.product_grid', ['products' => $products])
        </div>

        <div id="load-more-trigger" style="height: 20px;"></div>

        <div id="loading-spinner" class="text-center my-4" style="display: none;">
            <div class="spinner-border text-primary" role="status"></div>
            <p>লোড হচ্ছে...</p>
        </div>


    </div>

    <footer class="text-white pt-5 pb-4">
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
                        <p class="mb-2"><i class="bi bi-envelope-fill text-danger me-2"></i> info@surjosports.com</p>
                    </div>
                </div>

                <div class="col-md-4 text-md-end text-center">
                    <h6 class="fw-bold text-uppercase mb-3 text-white-50 small">ফলো করুন</h6>
                    <div class="d-flex justify-content-center justify-content-md-end gap-2">
                        <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-tiktok"></i></a>
                        <a href="https://wa.me/+880168XXXXXXX" class="social-btn" target="_blank">
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

    <script>
        let page = 1;
        let loading = false;
        let hasMore = true;

        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting && !loading && hasMore) {
                loadMoreProducts();
            }
        }, {
            threshold: 1.0
        });

        observer.observe(document.querySelector('#load-more-trigger'));

        function loadMoreProducts() {
            page++;
            loading = true;
            document.getElementById('loading-spinner').style.display = 'block';

            // Use your actual route URL here
            fetch(`/?page=${page}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === "") {
                        hasMore = false;
                        document.getElementById('loading-spinner').innerHTML = "<p>সব প্রোডাক্ট দেখা শেষ!</p>";
                    } else {
                        document.getElementById('product-container').insertAdjacentHTML('beforeend', data);
                        loading = false;
                        document.getElementById('loading-spinner').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loading = false;
                });
        }
    </script>
</body>

</html>
