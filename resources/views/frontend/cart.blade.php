<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>কার্ট | SURJO SPORTS</title>
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

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #0d6efd;
            --accent-color: #ff4757;
            --success-color: #2ed573;
        }

        body {
            background: #f4f7fa;
            font-family: 'Hind Siliguri', sans-serif;
            color: #2d3436;
            padding-bottom: 90px;
        }

        @media (min-width: 992px) {
            body {
                padding-bottom: 0;
            }
        }

        .cart-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .03);
        }

        .cart-item {
            border-bottom: 1px solid #f1f5f9;
            padding: 12px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            flex-shrink: 0;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            font-size: 15px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }

        .form-check {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .form-check .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-order-now {
            background: linear-gradient(45deg, #FF416C, #FF4B2B);
            border: none;
            color: white;
            font-weight: 700;
            transition: 0.2s;
            box-shadow: 0 4px 12px rgba(255, 65, 108, 0.3);
        }

        .btn-order-now:active {
            transform: scale(0.98);
        }

        .summary-box {
            border: 1px solid #e2e8f0;
            border-left: 4px solid var(--primary-color);
            border-radius: 12px;
        }

        /* Mobile Sticky Bottom Bar */
        .mobile-sticky-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #ffffff;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
            padding: 12px 16px;
            z-index: 1040;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }

        @media (min-width: 992px) {
            .mobile-sticky-bar {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    @include('frontend.partials.navbar')

    <div class="container py-3 py-md-5">
        <div class="row g-3 g-lg-4">

            <!-- Left Side: Cart Items -->
            <div class="col-lg-7 col-xl-8">
                <div class="cart-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="fw-bold mb-0 fs-5 fs-md-4">আপনার কার্ট</h4>
                            <small class="text-muted d-none d-sm-block">পছন্দের পণ্যগুলো বেছে নিয়ে অর্ডার করুন</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                            onclick="clearCart()">
                            <i class="bi bi-trash me-1"></i>খালি করুন
                        </button>
                    </div>
                    <hr class="my-2 text-muted">
                    <div id="cart-items"></div>
                </div>
            </div>

            <!-- Right Side: Delivery Form & Summary -->
            <div class="col-lg-5 col-xl-4">
                <div class="cart-card p-3 p-md-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-2 text-danger d-flex align-items-center justify-content-center"
                            style="width: 36px; height: 36px;">
                            <i class="bi bi-truck fs-5"></i>
                        </div>
                        <h5 class="fw-bold mb-0 fs-6 fs-md-5">ডেলিভারি তথ্য</h5>
                    </div>

                    <form id="checkout-form" action="{{ url('/v1/orders') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cart" id="cart-input" value='[]'>
                        <input type="hidden" name="subtotal" id="subtotal-input" value="0">
                        <input type="hidden" name="total" id="total-input" value="0">
                        <input type="hidden" name="delivery_charge" id="delivery-charge-input" value="60">
                        <input type="hidden" name="delivery_type" id="delivery-type-input" value="inside_dhaka">
                        <input type="hidden" name="customer_name" id="customer-name-input">
                        <input type="hidden" name="mobile" id="mobile-input">
                        <input type="hidden" name="address" id="address-input">

                        <div class="mb-2">
                            <label class="form-label fw-semibold small mb-1">আপনার নাম</label>
                            <input type="text" name="name" class="form-control" placeholder="নাম লিখুন (ঐচ্ছিক)">
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-semibold small mb-1">মোবাইল নাম্বার *</label>
                            <input type="tel" name="phone" class="form-control" placeholder="01XXXXXXXXX" required
                                pattern="[0-9]*" inputmode="numeric">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small mb-1">সম্পূর্ণ ঠিকানা</label>
                            <textarea name="address_field" class="form-control" rows="2" placeholder="জেলা, থানা, এলাকা (ঐচ্ছিক)"></textarea>
                        </div>

                        <label class="form-label fw-semibold small mb-1">ডেলিভারি এরিয়া সিলেক্ট করুন *</label>
                        <div class="form-check p-2 ps-4 rounded-3 border w-100 mb-2 bg-light d-flex align-items-center">
                            <input class="form-check-input me-2" type="radio" name="delivery_area" id="in"
                                value="60" checked>
                            <label class="form-check-label small fw-semibold" for="in">ঢাকার ভিতরে (৬০
                                টাকা)</label>
                        </div>
                        <div class="form-check p-2 ps-4 rounded-3 border w-100 mb-3 bg-light d-flex align-items-center">
                            <input class="form-check-input me-2" type="radio" name="delivery_area" id="out"
                                value="120">
                            <label class="form-check-label small fw-semibold" for="out">ঢাকার বাইরে (১২০
                                টাকা)</label>
                        </div>

                        <div class="summary-box p-3 mb-3 bg-light">
                            <div class="d-flex justify-content-between mb-1 small">
                                <span>মোট পণ্য:</span>
                                <span id="cart-count" class="fw-bold">0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1 small">
                                <span>ডেলিভারি চার্জ:</span>
                                <span id="delivery-charge" class="fw-bold">60 Tk</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold text-danger fs-6">
                                <span>সর্বমোট:</span>
                                <span id="cart-total">0 Tk</span>
                            </div>
                        </div>

                        <!-- Desktop Checkout Button -->
                        <button type="button" class="btn btn-order-now w-100 py-3 rounded-3 d-none d-lg-block fs-6"
                            onclick="confirmOrder()">অর্ডার কনফার্ম করুন</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sticky Footer -->
    <div class="mobile-sticky-bar d-lg-none">
        <div class="d-flex align-items-center justify-content-between gap-2">
            <div>
                <small class="text-muted d-block" style="font-size: 11px;">সর্বমোট মূল্য</small>
                <div class="fw-bold text-danger fs-5 lh-1" id="mobile-cart-total">0 Tk</div>
            </div>
            <button type="button" class="btn btn-order-now py-2 px-4 rounded-pill fs-6" onclick="confirmOrder()">
                অর্ডার কনফার্ম করুন
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold fs-6" id="confirmModalLabel">অর্ডার কনফার্ম করবেন?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-0 text-muted small">আপনি কি এই অর্ডারটি নিশ্চিত করতে চান? নিশ্চিত করলে আমাদের
                        প্রতিনিধি আপনার সাথে যোগাযোগ করবে।</p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                        data-bs-dismiss="modal">না</button>
                    <button type="button" class="btn btn-sm btn-order-now rounded-pill px-4"
                        onclick="submitOrder()">হ্যাঁ</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function getCart() {
            return JSON.parse(localStorage.getItem('surjo_cart')) || [];
        }

        function renderCart() {
            const cart = getCart();
            const container = document.getElementById('cart-items');
            const countEl = document.getElementById('cart-count');
            const totalEl = document.getElementById('cart-total');
            const mobileTotalEl = document.getElementById('mobile-cart-total');
            const deliveryEl = document.getElementById('delivery-charge');

            if (!cart.length) {
                container.innerHTML =
                    '<div class="text-center py-4 text-muted small"><i class="bi bi-cart-x fs-2 d-block mb-2"></i>কার্টে কোনো পণ্য নেই।</div>';
                countEl.innerText = '0';
                totalEl.innerText = '0 Tk';
                if (mobileTotalEl) mobileTotalEl.innerText = '0 Tk';
                deliveryEl.innerText = '0 Tk';
                return;
            }

            container.innerHTML = cart.map(item => `
            <div class="cart-item d-flex align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2 min-w-0">
                    <img src="${item.image}" class="cart-img" alt="${item.name}">
                    <div class="text-truncate">
                        <h6 class="fw-bold mb-0 text-truncate fs-6" style="max-width: 160px;">${item.name}</h6>
                        <small class="text-muted d-block" style="font-size: 12px;">সাইজ: ${item.size}</small>
                        <div class="text-danger fw-bold small">${Number(item.price).toLocaleString()} Tk</div>
                    </div>
                </div>
                <div class="text-end flex-shrink-0">
                    <div class="fw-bold small mb-1">${item.qty} x</div>
                    <button class="btn btn-sm btn-link text-danger p-0 border-0" style="font-size: 13px;" onclick="removeItem(${item.product_id}, '${item.size}')">
                        <i class="bi bi-trash"></i> মুছুন
                    </button>
                </div>
            </div>
            `).join('');

            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
            const delivery = document.querySelector('input[name="delivery_area"]:checked')?.value || 60;
            const total = subtotal + Number(delivery);

            countEl.innerText = cart.reduce((sum, item) => sum + item.qty, 0);
            deliveryEl.innerText = Number(delivery).toLocaleString() + ' Tk';
            totalEl.innerText = total.toLocaleString() + ' Tk';
            if (mobileTotalEl) mobileTotalEl.innerText = total.toLocaleString() + ' Tk';
        }

        function removeItem(productId, size) {
            let cart = getCart();
            cart = cart.filter(item => !(item.product_id === productId && item.size === size));
            localStorage.setItem('surjo_cart', JSON.stringify(cart));
            renderCart();
        }

        function clearCart() {
            localStorage.removeItem('surjo_cart');
            renderCart();
        }

        function confirmOrder() {
            const cart = getCart();
            if (!cart.length) {
                Swal.fire({
                    icon: 'warning',
                    title: 'কার্ট খালি!',
                    text: 'কার্টে কোনো পণ্য নেই।',
                    confirmButtonText: 'ঠিক আছে',
                    confirmButtonColor: '#ff4757'
                });
                return;
            }

            const form = document.getElementById('checkout-form');
            const name = form.querySelector('input[name="name"]').value.trim();
            const phone = form.querySelector('input[name="phone"]').value.trim();
            const address = form.querySelector('textarea[name="address_field"]').value.trim();
            const deliveryValue = document.querySelector('input[name="delivery_area"]:checked')?.value || '60';

            if (!phone) {
                Swal.fire({
                    icon: 'info',
                    title: 'মোবাইল নাম্বার দিন',
                    text: 'মোবাইল নাম্বার লিখুন।',
                    confirmButtonText: 'ঠিক আছে',
                    confirmButtonColor: '#0d6efd'
                }).then(() => {
                    form.querySelector('input[name="phone"]').focus();
                });
                return;
            }

            if (!/^01[3-9]\d{8}$/.test(phone)) {
                Swal.fire({
                    icon: 'error',
                    title: 'ভুল নাম্বার!',
                    text: '১১ ডিজিটের বৈধ মোবাইল নাম্বার লিখুন।',
                    confirmButtonText: 'ঠিক আছে',
                    confirmButtonColor: '#ff4757'
                }).then(() => {
                    form.querySelector('input[name="phone"]').focus();
                });
                return;
            }

            document.getElementById('cart-input').value = JSON.stringify(cart);
            document.getElementById('subtotal-input').value = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
            document.getElementById('total-input').value = Number(document.getElementById('subtotal-input').value) + Number(
                deliveryValue);
            document.getElementById('delivery-charge-input').value = deliveryValue;
            document.getElementById('delivery-type-input').value = deliveryValue === '120' ? 'outside_dhaka' :
                'inside_dhaka';
            document.getElementById('customer-name-input').value = name;
            document.getElementById('mobile-input').value = phone;
            document.getElementById('address-input').value = address;

            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        }

        function submitOrder() {
            const confirmModalEl = document.getElementById('confirmModal');
            const modalInstance = bootstrap.Modal.getInstance(confirmModalEl);
            if (modalInstance) {
                modalInstance.hide();
            }

            const form = document.getElementById('checkout-form');
            const cart = getCart();
            const deliveryValue = document.querySelector('input[name="delivery_area"]:checked')?.value || '60';
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
            const total = subtotal + Number(deliveryValue);

            if (!cart.length) {
                Swal.fire({
                    icon: 'warning',
                    title: 'কার্ট খালি!',
                    text: 'কার্টে কোনো পণ্য নেই।',
                    confirmButtonText: 'ঠিক আছে'
                });
                return;
            }

            const name = form.querySelector('input[name="name"]').value.trim();
            const phone = form.querySelector('input[name="phone"]').value.trim();
            const address = form.querySelector('textarea[name="address_field"]').value.trim();

            if (!phone) {
                Swal.fire({
                    icon: 'info',
                    title: 'মোবাইল নাম্বার প্রয়োজন',
                    text: 'মোবাইল নাম্বার অবশ্যই প্রদান করুন।',
                    confirmButtonText: 'ঠিক আছে'
                });
                return;
            }

            document.getElementById('cart-input').value = JSON.stringify(cart);
            document.getElementById('subtotal-input').value = subtotal;
            document.getElementById('total-input').value = total;
            document.getElementById('delivery-charge-input').value = deliveryValue;
            document.getElementById('delivery-type-input').value = deliveryValue === '120' ? 'outside_dhaka' :
                'inside_dhaka';
            document.getElementById('customer-name-input').value = name;
            document.getElementById('mobile-input').value = phone;
            document.getElementById('address-input').value = address;

            const formData = new FormData(form);
            const csrfToken = form.querySelector('input[name="_token"]').value;

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        localStorage.removeItem('surjo_cart');
                        renderCart();

                        Swal.fire({
                            icon: 'success',
                            title: 'অর্ডার সফল হয়েছে!',
                            text: 'আপনার অর্ডারটি সফলভাবে জমা নেওয়া হয়েছে।',
                            confirmButtonText: 'ঠিক আছে',
                            confirmButtonColor: '#2ed573'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/';
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ব্যর্থ হয়েছে!',
                            text: result.error || 'অর্ডার সম্পন্ন করা সম্ভব হয়নি।',
                            confirmButtonText: 'আবার চেষ্টা করুন',
                            confirmButtonColor: '#ff4757'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'ত্রুটি!',
                        text: 'অর্ডার সম্পন্ন করা সম্ভব হয়নি। অনুগ্রহ করে ইন্টারনেট সংযোগ চেক করুন।',
                        confirmButtonText: 'ঠিক আছে',
                        confirmButtonColor: '#ff4757'
                    });
                });
        }

        document.querySelectorAll('input[name="delivery_area"]').forEach((radio) => {
            radio.addEventListener('change', renderCart);
        });

        window.onload = renderCart;
    </script>
</body>

</html>
