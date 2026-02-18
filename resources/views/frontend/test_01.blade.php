<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Compact Kit Store | Auto-Scroll</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #0d6efd;
            --bg: #f4f7fa;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            font-size: 14px;
        }

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
</head>

<body>

    <div class="container py-4">
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
                                placeholder="Customer Name" required>
                            <input type="tel" id="c-mobile" class="form-control form-control-sm mb-1"
                                placeholder="Mobile" required>
                            <textarea id="c-addr" class="form-control form-control-sm mb-2" rows="2" placeholder="Full Address" required></textarea>
                            <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">PLACE ORDER</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const teams = [{
                id: 'fr',
                name: 'France',
                flag: 'https://flagcdn.com/w640/fr.png',
                kits: [{
                        id: 101,
                        name: 'Home Blue Kit',
                        price: 90,
                        img: 'https://placehold.co/100x100?text=FR+Home'
                    },
                    {
                        id: 102,
                        name: 'Away White Kit',
                        price: 85,
                        img: 'https://placehold.co/100x100?text=FR+Away'
                    }
                ]
            },
            {
                id: 'br',
                name: 'Brazil',
                flag: 'https://flagcdn.com/w640/br.png',
                kits: [{
                        id: 201,
                        name: 'Classic Yellow',
                        price: 95,
                        img: 'https://placehold.co/100x100?text=BR+Yellow'
                    },
                    {
                        id: 202,
                        name: 'Away Blue',
                        price: 85,
                        img: 'https://placehold.co/100x100?text=BR+Blue'
                    }
                ]
            },
            {
                id: 'ar',
                name: 'Argentina',
                flag: 'https://flagcdn.com/w640/ar.png',
                kits: [{
                        id: 301,
                        name: 'Home 3-Star',
                        price: 110,
                        img: 'https://placehold.co/100x100?text=AR+Home'
                    },
                    {
                        id: 302,
                        name: 'Training Jersey',
                        price: 65,
                        img: 'https://placehold.co/100x100?text=AR+Train'
                    }
                ]
            },
            {
                id: 'jp',
                name: 'Japan',
                flag: 'https://flagcdn.com/w640/jp.png',
                kits: [{
                        id: 401,
                        name: 'Samurai Blue',
                        price: 90,
                        img: 'https://placehold.co/100x100?text=JP+Blue'
                    },
                    {
                        id: 402,
                        name: 'Special Edition',
                        price: 120,
                        img: 'https://placehold.co/100x100?text=JP+Spec'
                    }
                ]
            },
            {
                id: 'de',
                name: 'Germany',
                flag: 'https://flagcdn.com/w640/de.png',
                kits: [{
                        id: 501,
                        name: 'Home White',
                        price: 95,
                        img: 'https://placehold.co/100x100?text=DE+Home'
                    },
                    {
                        id: 502,
                        name: 'Pink Away 2024',
                        price: 100,
                        img: 'https://placehold.co/100x100?text=DE+Away'
                    }
                ]
            },
            {
                id: 'es',
                name: 'Spain',
                flag: 'https://flagcdn.com/w640/es.png',
                kits: [{
                    id: 601,
                    name: 'La Roja Home',
                    price: 90,
                    img: 'https://placehold.co/100x100?text=ES+Home'
                }]
            },
            {
                id: 'gb-eng',
                name: 'England',
                flag: 'https://flagcdn.com/w640/gb-eng.png',
                kits: [{
                        id: 701,
                        name: 'Three Lions Home',
                        price: 95,
                        img: 'https://placehold.co/100x100?text=ENG+Home'
                    },
                    {
                        id: 702,
                        name: 'Away Dark Blue',
                        price: 90,
                        img: 'https://placehold.co/100x100?text=ENG+Away'
                    }
                ]
            },
            {
                id: 'pt',
                name: 'Portugal',
                flag: 'https://flagcdn.com/w640/pt.png',
                kits: [{
                    id: 801,
                    name: 'CR7 Home Kit',
                    price: 115,
                    img: 'https://placehold.co/100x100?text=PT+Home'
                }]
            }
        ];

        let cart = JSON.parse(localStorage.getItem('kitShopCart')) || [];

        window.onload = () => {
            renderFlags();
            renderCart();
        };

        function renderFlags() {
            document.getElementById('team-grid').innerHTML = teams.map(t => `
        <div class="col">
            <div class="flag-card" id="flag-${t.id}" onclick="loadKits('${t.id}')">
                <img src="${t.flag}" class="flag-img">
                <div class="flag-name">${t.name}</div>
            </div>
        </div>`).join('');
        }

        function loadKits(id) {
            const team = teams.find(t => t.id === id);

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
            <td><select id="s-${k.id}" class="form-select form-select-sm py-0" style="width:55px; font-size:10px;"><option>S</option><option selected>M</option><option>L</option></select></td>
            <td class="fw-bold text-primary small">$${k.price}</td>
            <td class="text-end"><button class="btn btn-dark btn-sm rounded-circle py-0 px-2" onclick="addToCart('${k.name}', ${k.price}, '${k.img}', 's-${k.id}')">+</button></td>
        </tr>`).join('');

            // --- FIX: GO TO TABLE ON CLICK ---
            document.getElementById('shop-anchor').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function addToCart(name, price, img, sizeId) {
            const size = document.getElementById(sizeId).value;
            const item = cart.find(i => i.name === name && i.size === size);
            if (item) {
                item.qty += 1;
            } else {
                cart.push({
                    id: Date.now(),
                    name,
                    price,
                    img,
                    size,
                    qty: 1
                });
            }
            save();
        }

        function changeQty(id, d) {
            const item = cart.find(i => i.id === id);
            if (item) {
                item.qty += d;
                if (item.qty <= 0) cart = cart.filter(i => i.id !== id);
            }
            save();
        }

        function save() {
            localStorage.setItem('kitShopCart', JSON.stringify(cart));
            renderCart();
        }

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
                    <button class="qty-btn" onclick="changeQty(${i.id}, -1)">-</button>
                    <span class="fw-bold" style="font-size:10px;">${i.qty}</span>
                    <button class="qty-btn" onclick="changeQty(${i.id}, 1)">+</button>
                </div>
                <span class="fw-bold small" style="min-width:30px">$${i.price * i.qty}</span>
            </div>
        </div>`).join('');
            document.getElementById('total-val').innerText = cart.reduce((a, c) => a + (c.price * c.qty), 0);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
