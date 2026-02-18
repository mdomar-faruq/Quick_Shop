<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports T-Shirt Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* 1. Slimmer Animated Border Box */
        .animated-border-box {
            position: relative;
            padding: 10px;
            /* Decreased from 8px for a cleaner look */
            /* background: linear-gradient(270deg, #8a2be2, #00ffff, #4b0082, #8a2be2); */
            background: linear-gradient(270deg, #ff9a9e, #fad0c4, #fad0c4, #fbc2eb);
            background-size: 400% 400%;
            border-radius: 15px;
            animation: moveGradient 6s ease infinite;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        /* 2. Focused Image Styling for T-Shirts */
        .carousel-img {
            height: 550px;
            /* Increased height to show more of the T-shirt */
            width: 100%;
            object-fit: contain;
            /* 'contain' ensures the whole T-shirt is visible without cropping */
            background-color: #f9f9f9;
            /* Light background for the T-shirt frame */
        }

        .carousel-inner {
            border-radius: 0px;
        }

        /* Animation Speed */
        @keyframes moveGradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Small Buttons for Carousel */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 15px;
            /* Smaller padding */
            border-radius: 50%;
            transform: scale(0.8);
        }

        /* Price Styling */
        .old-price {
            text-decoration: line-through;
            color: #888;
            font-size: 1.2rem;
        }

        .new-price {
            color: #d9534f;
            font-weight: bold;
            font-size: 2rem;
        }

        /* Mobile Adjustments */
        @media (max-width: 991px) {
            .carousel-img {
                height: 400px;
                /* Adjusted for mobile screens */
            }

            .display-4 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>
    <section class="hero-section py-5">
        <div class="container">
            {{-- 1 --}}
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="animated-border-box">
                        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://images.unsplash.com/photo-1581338834647-b0fb40704e21?auto=format&fit=crop&w=800"
                                        class="d-block w-100 carousel-img" alt="Brazil T-Shirt Front">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://images.unsplash.com/photo-1581338834647-b0fb40704e21?auto=format&fit=crop&w=800"
                                        class="d-block w-100 carousel-img" alt="Brazil T-Shirt Back">
                                </div>
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 text-center px-lg-5 mt-4 mt-lg-0">
                    <span class="badge bg-danger mb-2">HOT DEAL</span>
                    <h1 class="display-3 fw-bold">Brazil Home</h1>
                    <div class="my-3">
                        <span class="old-price">1200 Tk</span> <br>
                        <span class="new-price">Today: 950 Tk</span>
                    </div>
                    <p class="lead text-muted mb-4">High-quality breathable fabric, perfect for sports and casual wear.
                        Get the iconic look today!</p>

                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-dark btn-lg px-5 py-3 rounded-pill shadow-sm">অর্ডার করতে চাই</button>
                    </div>
                </div>

            </div>

            {{-- 2 --}}

            <div class="row align-items-center mt-5">
                <div class="col-lg-6">
                    <div class="animated-border-box">
                        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://images.unsplash.com/photo-1581338834647-b0fb40704e21?auto=format&fit=crop&w=800"
                                        class="d-block w-100 carousel-img" alt="Brazil T-Shirt Front">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://images.unsplash.com/photo-1581338834647-b0fb40704e21?auto=format&fit=crop&w=800"
                                        class="d-block w-100 carousel-img" alt="Brazil T-Shirt Back">
                                </div>
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 text-center px-lg-5 mt-4 mt-lg-0">
                    <span class="badge bg-danger mb-2">HOT DEAL</span>
                    <h1 class="display-3 fw-bold">Japan Home</h1>
                    <div class="my-3">
                        <span class="old-price">1200 Tk</span> <br>
                        <span class="new-price">Today: 950 Tk</span>
                    </div>
                    <p class="lead text-muted mb-4">High-quality breathable fabric, perfect for sports and casual wear.
                        Get the iconic look today!</p>

                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-dark btn-lg px-5 py-3 rounded-pill shadow-sm">অর্ডার করতে চাই</button>
                    </div>
                </div>

            </div>

            {{-- 3 --}}

            <div class="row align-items-center mt-5">
                <div class="col-lg-6">
                    <div class="animated-border-box">
                        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="https://images.unsplash.com/photo-1581338834647-b0fb40704e21?auto=format&fit=crop&w=800"
                                        class="d-block w-100 carousel-img" alt="Brazil T-Shirt Front">
                                </div>
                                <div class="carousel-item">
                                    <img src="https://images.unsplash.com/photo-1581338834647-b0fb40704e21?auto=format&fit=crop&w=800"
                                        class="d-block w-100 carousel-img" alt="Brazil T-Shirt Back">
                                </div>
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 text-center px-lg-5 mt-4 mt-lg-0">
                    <span class="badge bg-danger mb-2">HOT DEAL</span>
                    <h1 class="display-3 fw-bold">Argentina Home</h1>
                    <div class="my-3">
                        <span class="old-price">1200 Tk</span> <br>
                        <span class="new-price">Today: 950 Tk</span>
                    </div>
                    <p class="lead text-muted mb-4">High-quality breathable fabric, perfect for sports and casual wear.
                        Get the iconic look today!</p>

                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-dark btn-lg px-5 py-3 rounded-pill shadow-sm">অর্ডার করতে চাই</button>
                    </div>
                </div>

            </div>


            {{-- end carousel--}}


            
        </div>
        {{-- End container --}}
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
