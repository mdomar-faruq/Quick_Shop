<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surjo</title>
    <link href="{{ asset('css/bootstrap_5_3.css') }}" rel="stylesheet">

    <link href="{{ asset('css/bootstrap_icon_5_3.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bs-body-bg);
            transition: background-color 0.3s ease;
        }

        .navbar {
            border-bottom: 1px solid rgba(0, 0, 0, .1);
            backdrop-filter: blur(10px);
        }

        [data-bs-theme="dark"] .navbar {
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem !important;
        }

        .theme-toggle-btn {
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .theme-toggle-btn:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        [data-bs-theme="dark"] .theme-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body>

    <header class="navbar navbar-expand-lg sticky-top bg-body-tertiary">
        <div class="container-xl">
            <a class="navbar-brand fw-bold text-primary" href="/admin">
                Surjo
            </a>

            <div class="d-flex align-items-center order-lg-last ms-2">
                <div class="theme-toggle-btn me-2" id="themeToggle">
                    <i class="bi bi-moon-stars" id="themeIcon"></i>
                </div>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>

                <button class="navbar-toggler ms-2 border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('adminHome') }}"><i class="bi bi-house-door me-1"></i>
                            Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-box-seam me-1"></i>Pre Order
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm">
                            <li><a class="dropdown-item" href="{{ route('pendingOrder') }}">Pending</a></li>
                            <li><a class="dropdown-item" href="{{ route('deliveredOrder') }}">Deliverd</a></li>
                            <li><a class="dropdown-item" href="{{ route('cancelledOrder') }}">cancelled</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-box-seam me-1"></i> Report
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm">
                            <li><a class="dropdown-item" href="#">Daily</a></li>
                            <li><a class="dropdown-item" href="#">Custome</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminCategorie') }}"><i class="bi bi-map me-1"></i>
                            Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminProduct') }}"><i class="bi bi-map me-1"></i>
                            Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminBlog') }}"><i class="bi bi-map me-1"></i>
                            Blogs</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main class="container-xl py-4">
        {{-- Global Session Messages --}}
        @if (session('success') || session('error'))
            <div class="row justify-content-center">
                <div class="col-md-8">
                    {{-- Paste the Alert Code Block here --}}
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <script src="{{ asset('js/bootstrap_5_3.js') }}"></script>

    <script>
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const htmlElement = document.documentElement;

        // Check for saved theme in localStorage
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.setAttribute('data-bs-theme', savedTheme);
        updateIcon(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';

            htmlElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            if (theme === 'dark') {
                themeIcon.classList.replace('bi-moon-stars', 'bi-sun');
            } else {
                themeIcon.classList.replace('bi-sun', 'bi-moon-stars');
            }
        }
    </script>

    {{-- //Session Message  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Find all alerts
            const alerts = document.querySelectorAll('.alert-success');
            alerts.forEach(function(alert) {
                // Wait 3 seconds, then hide
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 3000);
            });
        });
    </script>

    @stack('scripts')


</body>

</html>
