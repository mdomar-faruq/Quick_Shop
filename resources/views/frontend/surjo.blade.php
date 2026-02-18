<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Surjo</title>
    <style>
        :root {
            --primary: #111827;
            --accent: #4f46e5;
            --bg: #f8fafc;
            --border: #e2e8f0;
        }

        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: -apple-system, sans-serif;
            background: var(--bg);
            margin: 0;
            padding: 0;
            color: var(--primary);
        }

        /* --- Header --- */
        header {
            padding: 20px;
            background: white;
            border-bottom: 1px solid var(--border);
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 22px;
        }

        /* --- Main Layout --- */
        .main-content {
            padding: 15px;
            /* Space for the fixed cart at the bottom */
            margin-bottom: 300px;
        }

        /* --- Product Grid --- */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        @media (min-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .product-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .img-box img {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            background: #eee;
        }

        .info {
            padding: 10px;
        }

        .info h3 {
            font-size: 14px;
            margin: 0;
            height: 35px;
            overflow: hidden;
        }

        .price {
            font-weight: bold;
            color: var(--accent);
            margin: 5px 0;
        }

        .btn-add {
            background: var(--primary);
            color: white;
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        /* --- FIXED CART TABLE AT BOTTOM --- */
        .fixed-cart {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            box-shadow: 0 -10px 25px rgba(0, 0, 0, 0.1);
            border-top: 2px solid var(--accent);
            z-index: 1000;
            max-height: 280px;
            /* Limits height so it doesn't cover the whole screen */
            display: flex;
            flex-direction: column;
        }

        .cart-header {
            padding: 10px 15px;
            background: #f1f5f9;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 14px;
        }

        .cart-scroll {
            overflow-y: auto;
            flex-grow: 1;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        /* Quantity Buttons */
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-qty {
            border: 1px solid #ddd;
            background: #fff;
            width: 28px;
            height: 28px;
            border-radius: 5px;
            font-weight: bold;
        }

        /* Footer inside Fixed Cart */
        .cart-footer {
            padding: 15px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .grand-total {
            font-size: 20px;
            font-weight: 800;
            color: var(--accent);
        }

        .btn-checkout {
            background: var(--accent);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <header>
        <h1>Surjo</h1>
    </header>

    <div class="main-content">

        <div class="products-grid" id="product-list">
            <p>Loading products...</p>
        </div>
    </div>

    <div class="fixed-cart">
        <div class="cart-header">
            <span>Shopping Cart</span>
            <span id="item-count">0 Items</span>
        </div>

        <div class="cart-scroll">
            <table class="cart-table">
                <tbody id="cart-body">
                    <tr>
                        <td colspan="3" style="text-align:center; padding: 20px; color: #999;">Your cart is empty.
                        </td>
                    </tr>
                </tbody>
            </table>

            <div id="checkout-form" style="display: flex; gap: 8px; flex-wrap: wrap; width: 100%;">
                <input type="text" id="cust-name" placeholder="Name"
                    style="flex: 1; min-width: 120px; padding: 10px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px;">
                <input type="text" id="cust-mobile" placeholder="Mobile"
                    style="flex: 1; min-width: 120px; padding: 10px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px;">
                <input type="text" id="cust-address" placeholder="Address"
                    style="flex: 2; min-width: 200px; padding: 10px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px;">
            </div>
        </div>

        <div class="cart-footer">
            <div>
                <div style="font-size: 11px; color: #666; text-transform: uppercase;">Total</div>
                <div class="grand-total" id="total-price">Tk0.00</div>
            </div>
            <button class="btn-checkout" onclick="placeOrder()">Order Now</button>
        </div>
    </div>



    <script>
        // 1. Initialize variables (Only once!)
        let products = [];
        let cart = JSON.parse(localStorage.getItem('surjo_cart')) || [];

        // 2. Fetch products from Laravel DB
        async function fetchProducts() {
            try {
                const response = await fetch('/api/products');
                products = await response.json();
                renderProducts();
            } catch (error) {
                console.error("Failed to load products:", error);
            }
        }

        function renderProducts() {
            const container = document.getElementById('product-list');
            if (!products || products.length === 0) {
                container.innerHTML = "<p>No products found.</p>";
                return;
            }

            container.innerHTML = products.map(p => `
            <div class="product-card">
                <div class="img-box"><img src="${p.image || p.img}"></div> 
                <div class="info">
                    <h3>${p.name}</h3>
                    <div class="price">TK${parseFloat(p.price).toFixed(2)}</div>
                    <button class="btn-add" onclick="addToCart(${p.id})">Add</button>
                </div>
            </div>
        `).join('');
        }

        // 3. Cart Logic
        function addToCart(id) {
            const item = products.find(p => p.id === id);
            const inCart = cart.find(p => p.id === id);
            if (inCart) {
                inCart.qty++;
            } else {
                cart.push({
                    ...item,
                    qty: 1
                });
            }
            updateUI();
        }

        function changeQty(id, delta) {
            const item = cart.find(p => p.id === id);
            if (!item) return;
            item.qty += delta;
            if (item.qty <= 0) cart = cart.filter(p => p.id !== id);
            updateUI();
        }

        function updateUI() {
            const count = cart.reduce((s, i) => s + i.qty, 0);
            const total = cart.reduce((s, i) => s + (i.price * i.qty), 0);

            document.getElementById('item-count').innerText = `${count} Items`;
            document.getElementById('total-price').innerText = `TK${total.toFixed(2)}`;
            localStorage.setItem('surjo_cart', JSON.stringify(cart));

            const body = document.getElementById('cart-body');
            if (cart.length === 0) {
                body.innerHTML = '<tr><td colspan="3" style="text-align:center; padding:20px; color:#999;">Empty</td></tr>';
            } else {
                body.innerHTML = cart.map(i => `
                <tr>
                    <td style="width: 50%;"><strong>${i.name}</strong></td>
                    <td>
                        <div class="qty-controls">
                            <button class="btn-qty" onclick="changeQty(${i.id}, -1)">-</button>
                            <span>${i.qty}</span>
                            <button class="btn-qty" onclick="changeQty(${i.id}, 1)">+</button>
                        </div>
                    </td>
                    <td style="text-align:right;">TK${(i.price * i.qty).toFixed(2)}</td>
                </tr>
            `).join('');
            }
        }

        // 4. Place Order (The function your button calls)
        async function placeOrder() {
            const payload = {
                name: document.getElementById('cust-name').value,
                mobile: document.getElementById('cust-mobile').value,
                address: document.getElementById('cust-address').value,
                cart: cart,
                total: cart.reduce((s, i) => s + (i.price * i.qty), 0)
            };

            if (!payload.name || !payload.mobile || cart.length === 0) {
                alert("Please fill Name and Mobile");
                return;
            }

            console.log(payload);


            try {
                const response = await fetch('/surjo_order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    alert("Order Success!");
                    localStorage.removeItem('surjo_cart');
                    location.reload();
                } else {
                    alert("Order failed. Check your server routes.");
                }
            } catch (err) {
                console.error("Network error:", err);
                alert("Could not connect to server.");
            }
        }

        // 5. Start on load
        document.addEventListener('DOMContentLoaded', () => {
            fetchProducts();
            updateUI();
        });
    </script>

    {{-- <script>
        function scrollToFooter() {
            document.getElementById('footer-target').scrollIntoView({
                behavior: 'smooth'
            });
        }
    </script> --}}
</body>

</html>
