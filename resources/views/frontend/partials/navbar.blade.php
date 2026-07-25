<nav class="navbar navbar-expand navbar-light bg-white py-2 shadow-sm sticky-top custom-navbar">
    <div class="container d-flex justify-content-between align-items-center">

        <!-- Brand / Logo -->
        <a class="navbar-brand fw-bold d-flex align-items-center me-0" href="/">
            <span class="brand-first">SURJO</span>
            <span class="brand-second ms-1">SPORTS</span>
        </a>

        <!-- Navigation Links & Action Buttons -->
        <div class="d-flex align-items-center gap-2 gap-sm-3">

            <!-- Home Link -->
            <a href="/" class="nav-link text-dark fw-semibold d-none d-sm-inline-block px-2">
                <i class="bi bi-house-door me-1"></i> হোম
            </a>

            <!-- Helpline Button -->
            <a href="tel:+8801700000000" class="helpline-btn d-flex align-items-center text-decoration-none">
                <div class="icon-circle me-md-2">
                    <i class="bi bi-telephone-fill"></i>
                </div>
                <div class="d-none d-md-flex flex-column text-start">
                    <span class="helpline-label">হেল্পলাইন</span>
                    <span class="helpline-number">+৮৮০১৭...</span>
                </div>
            </a>

            <!-- Cart Button -->
            <a href="{{ route('cart') }}"
                class="cart-btn position-relative d-flex align-items-center justify-content-center text-decoration-none">
                <i class="bi bi-bag-check-fill fs-5"></i>
                <span class="d-none d-sm-inline ms-2 fw-bold">কার্ট</span>
                <span id="cart-count-badge" class="cart-badge badge rounded-pill bg-danger">0</span>
            </a>

        </div>
    </div>
</nav>

<style>
    /* Navbar Custom Styles */
    .custom-navbar {
        backdrop-filter: blur(12px);
        background-color: rgba(255, 255, 255, 0.92) !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Brand Logo */
    .brand-first {
        color: #1e272e;
        font-size: 1.35rem;
        letter-spacing: 0.5px;
    }

    .brand-second {
        color: #ff4757;
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    /* Helpline Button */
    .helpline-btn {
        background: #f8f9fa;
        padding: 6px 14px;
        border-radius: 50px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .helpline-btn:hover {
        background: #eef2f5;
        transform: translateY(-1px);
    }

    .helpline-btn .icon-circle {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #ff4757, #ff6b81);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        box-shadow: 0 3px 8px rgba(255, 71, 87, 0.3);
    }

    .helpline-label {
        font-size: 0.68rem;
        color: #6c757d;
        line-height: 1;
        font-weight: 600;
    }

    .helpline-number {
        font-size: 0.82rem;
        color: #2d3436;
        font-weight: 700;
        line-height: 1.2;
    }

    /* Cart Button */
    .cart-btn {
        background: linear-gradient(135deg, #FF416C, #FF4B2B);
        color: #ffffff !important;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.9rem;
        box-shadow: 0 4px 12px rgba(255, 65, 108, 0.3);
        transition: all 0.3s ease;
    }

    .cart-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 65, 108, 0.45);
    }

    /* Floating Cart Badge */
    .cart-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        font-size: 0.72rem;
        padding: 4px 7px;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        animation: pulse-badge 2s infinite;
    }

    @keyframes pulse-badge {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    /* Mobile Responsive Optimizations */
    @media (max-width: 576px) {

        .brand-first,
        .brand-second {
            font-size: 1.15rem;
        }

        .helpline-btn {
            padding: 4px;
            background: transparent;
            border: none;
        }

        .helpline-btn .icon-circle {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }

        .cart-btn {
            padding: 8px 12px;
            border-radius: 50%;
            width: 38px;
            height: 38px;
        }
    }
</style>

<script>
    function updateCartBadge() {
        let cart = JSON.parse(localStorage.getItem('surjo_cart')) || [];
        let count = cart.reduce((sum, item) => sum + item.qty, 0);
        let badge = document.getElementById('cart-count-badge');
        if (badge) {
            badge.innerText = count;
            badge.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', updateCartBadge);
    window.addEventListener('storage', updateCartBadge);
</script>
