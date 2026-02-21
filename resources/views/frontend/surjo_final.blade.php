<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sports T-Shirt Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Flag Grid */
        .flag-card {
            cursor: pointer;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            transition: 0.2s;
            border: 1px solid #eee;
        }

        .flag-card.active {
            border-color: var(--primary);
            background: #f0f7ff;
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.1);
        }

        .flag-img {
            width: 100%;
            aspect-ratio: 3/2;
            object-fit: cover;
        }

        .flag-name {
            padding: 5px;
            text-align: center;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
        }

        /* Unified Container - Compact & No Gaps */
        .unified-container {
            background: #fff;
            border-radius: 12px;
            margin-top: 20px;
            overflow: hidden;
            border: 1px solid #dee2e6;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .product-side {
            padding: 15px;
            border-right: 1px solid #f0f0f0;
        }

        .cart-side {
            padding: 15px;
            background: #fcfdfe;
        }

        /* Table Tightening */
        .table td {
            padding: 6px 4px;
            border-bottom: 1px solid #f8f9fa;
            vertical-align: middle;
        }

        .product-thumb {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Cart Items */
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            padding: 6px 10px;
            border-radius: 8px;
            margin-bottom: 5px;
            border: 1px solid #f0f0f0;
        }

        .qty-box {
            display: flex;
            align-items: center;
            gap: 5px;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 6px;
        }

        .qty-btn {
            border: none;
            background: none;
            font-weight: 800;
            color: var(--primary);
            font-size: 12px;
        }

        @media (max-width: 991px) {
            .product-side {
                border-right: none;
                border-bottom: 1px solid #eee;
            }
        }
    </style>

    {{-- Coursal  --}}
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

    <style>
        .animated-text {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
        }
    </style>

</head>

<body>
    <section class="hero-section py-5">
        <div class="container">

            <div id="blog_div"></div>


            {{-- <div class="row align-items-center">
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
                        <button class="btn btn-dark btn-lg px-5 py-3 rounded-pill shadow-sm"
                            onclick="scrollToTeam('br')">অর্ডার করতে চাই</button>
                    </div>
                </div>

            </div> --}}

            {{-- end carousel --}}



        </div>
        {{-- End container --}}

        <div class="container py-4">
            <div class="row m-2">
                <div class="col-12">
                    <h1 class="text-center animated-text">
                        Select Your <span class="highlight">Favorite Team</span>
                    </h1>
                </div>
            </div>
            <div class="row g-2 row-cols-2 row-cols-md-4 mb-3" id="team-grid"></div>

            <div id="shop-anchor"></div>

            <div class="unified-container">
                <div class="row g-0">
                    <div class="col-lg-7 product-side">
                        <div id="product-placeholder" class="text-center py-5 text-muted">
                            <p class="small mb-0">Select a team above to view kits</p>
                        </div>

                        <div id="product-content" style="display:none;">
                            <h6 id="team-title" class="fw-800 mb-3 text-primary text-uppercase"></h6>
                            <table class="table table-sm align-middle mb-0">
                                <tbody id="product-tbody"></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-5 cart-side">
                        <h6 class="fw-800 mb-3">Shopping Cart</h6>
                        <div id="cart-list"></div>

                        <div class="mt-3 pt-2 border-top">
                            <div class="d-flex justify-content-between fw-800 mb-3">
                                <span>Total:</span>
                                <span class="text-primary">$<span id="total-val">0</span></span>
                            </div>

                            <form id="order-form">
                                <input type="text" id="c-name" class="form-control form-control-sm mb-1"
                                    placeholder="Customer Name">
                                <input type="tel" id="c-mobile" class="form-control form-control-sm mb-1"
                                    placeholder="Mobile" required>
                                <textarea id="c-addr" class="form-control form-control-sm mb-2" rows="2" placeholder="Full Address"></textarea>

                                <!-- Cash On Delivery Checkbox -->
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="cod-check">
                                    <label class="form-check-label fw-bold" for="cod-check">
                                        Cash On Delivery
                                    </label>
                                </div>

                                <button type="submit" id="place-order-btn" class="btn btn-primary btn-sm w-100 fw-bold"
                                    disabled>
                                    PLACE ORDER
                                </button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- //end continer --}}
    </section>


    {{-- //Blog --}}
    <script>
        renderHeroDeals();
        async function renderHeroDeals() {
            try {
                const response = await fetch('/api/blogs');
                const blogs = await response.json();
                console.log(blogs);
                const container = document.getElementById('blog_div');
                container.innerHTML = blogs.map((p, idx) => `
            <div class="row align-items-center mt-${idx > 0 ? 5 : 0}">
                <div class="col-lg-6">
                    <div class="animated-border-box">
                        <div id="carousel-${p.id}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                               ${(p.images && p.images.length > 0 ? p.images : ['https://placehold.co/300x300?text=BR+Yellow']).map((img, i) => `
                                                <div class="carousel-item ${i === 0 ? 'active' : ''}">
                                                    <img src="${img}" class="d-block w-100 carousel-img" 
                                                        alt="${p.title} Image ${i+1}" 
                                                        onerror="this.onerror=null;this.src='https://placehold.co/300x300?text=BR+Yellow';">
                                                </div>
                                            `).join('')}
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-${p.id}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-${p.id}" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 text-center px-lg-5 mt-4 mt-lg-0">
                    <span class="badge bg-danger mb-2">HOT DEAL</span>
                    <h1 class="display-3 fw-bold">${p.title}</h1>
                    <div class="my-3">
                        <span class="old-price">${p.regular_price} Tk</span> <br>
                        <span class="new-price">${p.offer_price_text} ${p.offer_price} Tk</span>
                    </div>
                    <p class="lead text-muted mb-4">${p.short_description}</p>
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-dark btn-lg px-5 py-3 rounded-pill shadow-sm"
                            onclick="scrollToTeam('${p.slug}')">অর্ডার করতে চাই</button>
                    </div>
                </div>
            </div>
        `).join('');
            } catch (err) {
                console.error("Error loading hero deals:", err);
            }
        }
    </script>

    {{-- //Product & order --}}
    <script>
        let teams = []; // will be filled from API
        let cart = JSON.parse(localStorage.getItem('kitShopCart')) || [];

        window.onload = async () => {
            await loadTeams(); // fetch teams dynamically
            renderFlags(); // render flags after data is loaded
            renderCart(); // render cart from localStorage
        };

        // Fetch teams from Laravel API
        async function loadTeams() {
            try {
                const response = await fetch('/api/categories/with_product');
                teams = await response.json(); // update global teams
                // console.log("Loaded teams:", teams);
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        // Render flag cards
        function renderFlags() {
            const grid = document.getElementById('team-grid');
            if (!teams || teams.length === 0) {
                grid.innerHTML = '<div class="text-muted">No teams available</div>';
                return;
            }
            grid.innerHTML = teams.map(t => `
            <div class="col">
                <div class="flag-card" id="flag-${t.id}" onclick="loadKits('${t.id}')">
                    <img src="${t.flag}" class="flag-img">
                    <div class="flag-name">${t.name}</div>
                </div>
            </div>`).join('');
        }

        // Load kits for a team
        function loadKits(id) {
            const team = teams.find(t => t.id === id);
            if (!team) {
                console.error("No team found for id:", id);
                return;
            }

            // Switch Visibility
            document.getElementById('product-placeholder').style.display = 'none';
            document.getElementById('product-content').style.display = 'block';

            // Highlight Active Flag
            document.querySelectorAll('.flag-card').forEach(f => f.classList.remove('active'));
            document.getElementById(`flag-${id}`).classList.add('active');

            // Populate Table
            document.getElementById('team-title').innerText = team.name;
            document.getElementById('product-tbody').innerHTML = team.kits.map(k => `
            <tr>
                <td><img src="${k.img}" class="product-thumb"></td>
                <td class="fw-bold small">${k.name}</td>
                <td>
                    <select id="s-${k.id}" class="form-select form-select-sm py-0" style="width:55px; font-size:10px;">
                        <option>S</option><option selected>M</option><option>L</option><option>XL</option><option>XXL</option>
                    </select>
                </td>
                <td class="fw-bold text-primary small">$${k.price}</td>
                <td class="text-end">
                   <button class="btn btn-dark btn-sm rounded-circle py-0 px-2"
                      onclick="addToCart(${k.id}, '${k.name}', ${k.price}, '${k.img}', 's-${k.id}')">+</button>
                </td>
            </tr>`).join('');

            // Scroll to table
            document.getElementById('shop-anchor').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        // Add item to cart
        function addToCart(productId, name, price, img, sizeId) {
            const size = document.getElementById(sizeId).value;
            const item = cart.find(i => i.product_id === productId && i.size === size);

            if (item) {
                item.qty += 1;
            } else {
                cart.push({
                    product_id: productId, // store actual product table ID
                    name,
                    price,
                    img,
                    size,
                    qty: 1
                });
            }
            save();
        }

        // Change quantity in cart
        function changeQty(productId, d) {
            const item = cart.find(i => i.product_id === productId);
            if (item) {
                item.qty += d;
                if (item.qty <= 0) cart = cart.filter(i => i.product_id !== productId);
            }
            save();
        }

        // Save cart to localStorage
        function save() {
            localStorage.setItem('kitShopCart', JSON.stringify(cart));
            renderCart();
        }

        // Render cart items
        function renderCart() {
            const list = document.getElementById('cart-list');
            if (cart.length === 0) {
                list.innerHTML = '<div class="text-center py-3 text-muted small">Cart empty</div>';
                document.getElementById('total-val').innerText = "0";
                return;
            }
            list.innerHTML = cart.map(i => `
            <div class="cart-item">
                <div class="d-flex align-items-center">
                    <img src="${i.img}" style="width:30px; height:30px; border-radius:4px; margin-right:8px; object-fit:cover;">
                    <div style="line-height:1.1">
                        <span class="fw-bold d-block" style="font-size:10px;">${i.name}</span>
                        <small class="text-muted" style="font-size:9px;">Size: ${i.size}</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="qty-box">
                       <button class="qty-btn" onclick="changeQty(${i.product_id}, -1)">-</button>
                        <span class="fw-bold" style="font-size:10px;">${i.qty}</span>
                        <button class="qty-btn" onclick="changeQty(${i.product_id}, 1)">+</button>
                    </div>
                    <span class="fw-bold small" style="min-width:30px">$${i.price * i.qty}</span>
                </div>
            </div>`).join('');
            document.getElementById('total-val').innerText = cart.reduce((a, c) => a + (c.price * c.qty), 0);
        }
    </script>

    <script>
        function scrollToTeam(id) {
            document.getElementById('shop-anchor').scrollIntoView({
                behavior: 'smooth'
            });

            loadKits(id);
        }
    </script>

    <script>
        const orderForm = document.getElementById('order-form');
        const placeOrderBtn = document.getElementById('place-order-btn');
        const codCheck = document.getElementById('cod-check');

        codCheck.addEventListener('change', function() {
            placeOrderBtn.disabled = !this.checked;
        });

        orderForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const customerName = document.getElementById('c-name').value;
            const mobile = document.getElementById('c-mobile').value;
            const address = document.getElementById('c-addr').value;

            // cart items should include size, qty, price, etc.
            const cart = JSON.parse(localStorage.getItem('kitShopCart')) || [];
            const totalAmount = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

            const payload = {
                customer_name: customerName,
                mobile: mobile,
                address: address,
                cart: cart.map(item => ({
                    product_id: item.product_id, // actual product table ID
                    name: item.name,
                    size: item.size,
                    qty: item.qty,
                    price: item.price
                })),
                total: totalAmount
            };

            console.log("Payload being sent:", payload);

            try {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch('/api/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(payload)
                });


                // read response safely
                const text = await response.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (err) {
                    console.error("Response was not JSON:", text);
                    alert("Server returned invalid response.");
                    return;
                }

                if (response.ok && data.success) {
                    alert("Order placed successfully!");
                    localStorage.removeItem('kitShopCart');
                    window.location.reload();
                } else {
                    alert("Failed: " + (data.error || 'Unknown error'));
                }
            } catch (error) {
                console.error("Error placing order:", error);
                alert("Network error, please try again.");
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
