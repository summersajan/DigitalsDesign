<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Digitals Design</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" />

    <style>
        body {
            background: #fff;
            font-family: "Poppins", sans-serif;
        }

        .navbar {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            background: #fff;
        }

        .navbar-brand span {
            font-family: "Pacifico", cursive;
            color: #23b5f2;
            font-weight: 700;
            font-size: 2rem;
        }

        .header-search {
            max-width: 500px;
            margin: 0 2rem;
        }

        .header-search input {
            border-radius: 30px 0 0 30px;
        }

        .btn-cta {
            background: #fff0dd;
            color: #f9a825;
            border: 2px solid #f9a825;
            border-radius: 30px;
            margin-right: 10px;
            font-weight: 500;
            transition: background 0.3s, color 0.3s;
        }

        .btn-cta:hover {
            background: #f9a825;
            color: #fff;
        }

        .btn-sign {
            background: #23b5f2;
            color: white;
            border-radius: 30px;
            font-weight: 500;
        }

        .nav-link,
        .navbar-nav .nav-link {
            font-weight: 600;
            color: #222 !important;
            margin-right: 10px;
        }

        .hero-section {
            background: #f7ede7;
            padding: 60px 0 45px 0;
        }

        .hero-section .display-5 {
            font-weight: bolder;
            line-height: 1;
        }

        .hero-section .easy-tag {
            position: relative;
            padding: 0 0.4em;
            background: #fff;
            color: #e17cb6;
            font-weight: 700;
            font-size: 1.8rem;
            display: inline-block;
            border-radius: 2px;
            transform: rotate(-6deg);
            box-shadow: 0 3px 0 #f3c9e2;
            margin: 0 4px;
        }

        .hero-section .pencil {
            width: 32px;
            vertical-align: middle;
            margin-left: 6px;
            margin-bottom: 7px;
            transform: rotate(25deg);
        }

        .hero-section .hero-img {
            max-width: 100%;
            width: 400px;
            border-radius: 10px;
            display: block;
            margin-left: auto;
            margin-right: 0;
        }

        .hero-section .hero-img-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .email-signup {
            background: #fff;
            border-radius: 50px;
            padding: 6px 10px;
            display: flex;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
            max-width: 500px;
            align-items: center;
            margin-top: 32px;
        }

        .email-signup input {
            border: none;
            border-radius: 30px;
            flex: 1;
            outline: none;
            font-size: 1.15rem;
            background: transparent;
        }

        .btn-signup {
            background: #ffaa1d;
            color: #fff;
            padding: 0.65em 2em;
            border-radius: 30px;
            font-weight: 600;
            border: none;
            margin-left: 0.5em;
            font-size: 1.07rem;
        }

        .email-signup .bi-envelope {
            font-size: 1.3em;
            color: #c2c2c2;
            margin-right: 8px;
        }

        .carousel-inner img {
            border-radius: 10px 10px 0 0;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #222;
            border-radius: 18px;
            padding: 4px;
        }

        .product-card,
        .premium-product-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            margin-bottom: 25px;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.2s;
        }

        .product-card:hover,
        .premium-product-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.09);
        }

        .product-meta {
            font-size: 0.95em;
        }

        .product-meta .bi {
            font-size: 1em;
            margin-right: 0.19em;
            color: #ffd700;
        }

        .price {
            font-weight: 700;
            color: #d64c00;
        }

        .old-price {
            color: #aaa;
            text-decoration: line-through;
            font-size: 0.95em;
            margin-left: 0.5em;
        }

        .discount {
            color: #ffaa1d;
            font-weight: 700;
            margin-left: 1em;
            font-size: 0.95em;
        }

        .text-orange {
            color: #ffaa1d;
        }

        .text-link {
            color: #faa918;
            text-decoration: underline;
        }

        @media (max-width: 991.98px) {
            .hero-section .d-flex.align-items-center {
                flex-direction: column !important;
                text-align: center !important;
            }

            .hero-section .hero-img {
                margin: 2rem auto 0 auto;
            }
        }

        @media (max-width: 767.98px) {
            .header-search {
                max-width: 220px;
            }

            .hero-section {
                padding: 30px 0;
            }

            .hero-section .hero-img {
                width: 90vw;
                max-width: 100%;
            }
        }

        .product-card {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .overlay-buttons {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(100%);
            display: flex;
            justify-content: space-around;
            padding: 0.5rem 0;
            transition: transform 0.3s ease;
        }

        .product-card:hover .overlay-buttons {
            transform: translateY(0);
        }

        .discount {
            color: red;
            font-weight: bold;
        }

        .strike {
            text-decoration: line-through;
            color: gray;
        }

        .rating {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #ffc107;
            padding: 2px 6px;
            font-size: 0.8rem;
            border-radius: 4px;
            font-weight: bold;
        }

        .action-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.3s;
        }

        .action-btn:hover {
            color: #007bff;
        }
    </style>
    <style>
        body {
            font-family: "Poppins", sans-serif;
        }

        footer {
            background-color: #f9f9f9;
            padding: 60px 0 30px;
            font-size: 14px;
            color: #555;
        }

        footer h6 {
            font-weight: 600;
            margin-bottom: 16px;
            color: #111;
            font-size: 15px;
        }

        footer p,
        footer a {
            font-size: 14px;
            line-height: 1.7;
            color: #555;
            text-decoration: none;
        }

        footer a:hover {
            color: #000;
        }

        .footer-logo {
            font-size: 24px;
            font-weight: 700;
        }

        .footer-logo span {
            color: #00bfff;
            font-weight: 700;
        }

        .footer-counts p {
            margin: 0;
            font-weight: 600;
        }

        .footer-links ul {
            padding-left: 0;
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 8px;
        }

        .footer-bottom {
            border-top: 1px solid #ddd;
            margin-top: 40px;
            padding-top: 20px;
            font-size: 13px;
            color: #777;
        }

        .social-icons a {
            color: #555;
            margin-right: 15px;
            font-size: 16px;
        }

        .dropdown-toggle {
            background-color: white;
            border: 1px solid #ccc;
            padding: 6px 14px;
            border-radius: 6px;
        }

        .certified-badge img {
            max-width: 100px;
        }
    </style>

</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light py-2">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center ms-2" href="#">
                <span>Digtials</span><strong>Design</strong><span class="fs-4" style="color: #222">.com</span>
            </a>

            <form class="d-flex header-search flex-grow-1" role="search">
                <input class="form-control rounded-pill px-4" type="search"
                    placeholder="Search names, categories, occasions..." aria-label="Search" />
            </form>

            <div class="d-flex align-items-center">
                <a class="btn btn-cta me-1" href="#">Unlock Your Creativity Today!</a>
                <a class="btn btn-sign" href="#">Sign In</a>

                <a class="ms-3 mt-1" href="cart.php"><i class="bi bi-bag" style="font-size: 1.4em; color: #222"></i></a>
                <span id="cartCountBadge" class="ms-1 fs-6" style="color: #aaa">0</span>



            </div>
        </div>
    </nav>
    <nav class="navbar navbar-expand navbar-light" style="background: #fff; border-bottom: 1px solid #eee">
        <div class="container-fluid">
            <ul class="navbar-nav flex-row w-100" id="category-nav"></ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center d-flex">
                <div class="col-lg-6">
                    <h1 class="display-5 mb-3">
                        Crafts Made
                        <span class="easy-tag">easy</span>
                        <img src="#" class="pencil" alt="" />
                        <br />for Fun and Profit
                    </h1>
                    <p style="font-size: 1.17rem">
                        Creating beautifully designed crafts doesn't have to be as hard as
                        you think.
                        <span class="text-orange fw-semibold">With one email</span> a week
                        you'll discover
                        <span class="text-link">everything you need</span> to make
                        beautiful things that friends, family and customers rave about.
                        See how over five million people around the world are creating fun
                        art.
                    </p>
                    <form class="email-signup mt-4">
                        <span class="bi bi-envelope"></span>
                        <input type="email" placeholder="Enter email address" required />
                        <button class="btn btn-signup" type="submit">Sign Up</button>
                    </form>
                </div>
                <div class="col-lg-6 text-center">
                    <img class="hero-img" src="images/octopus.webp" alt="Cute Octopus" />
                </div>
            </div>
        </div>
    </section>

    <div class="container py-4">
        <h4 class="fw-bold">Featured Products</h4>
        <p>
            Look no further if you're hunting for graphic design resources. We have
            something suitable for every season, event, and holiday. Plus, our
            graphic design bundles come at fantastic discounted prices too!
        </p>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="featured-products-dynamic"></div>
    </div>

    <!-- --- PREMIUM PRODUCTS --- -->
    <div class="container py-4">
        <h4 class="fw-bold">Premium Graphic Design Resources</h4>
        <p>
            Look no further if you're hunting for graphic design resources. We have
            something suitable for every season, event, and holiday. Plus, our
            graphic design bundles come at fantastic discounted prices too!
        </p>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="premium-products-dynamic"></div>
    </div>

    <!-- The rest of your HTML (footer, scripts, etc.) is unchanged ... -->
    <footer>
        <!-- ... your footer code ... -->
    </footer>
    <!-- Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Utility to render dropdowns (Bootstrap 5 format)
        function renderNav(tree) {
            var html = '';
            tree.forEach(function (cat) {
                if (cat.children && cat.children.length) {
                    // Main category with subcategories - render dropdown (no extra <ul>, just one for dropdown-menu)
                    html += `
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">${cat.name}</a>
          <ul class="dropdown-menu">
            ${cat.children.map(subcat =>
                        `<li><a class="dropdown-item" href="?category_id=${subcat.category_id}">${subcat.name}</a></li>`
                    ).join('')}
          </ul>
        </li>`;
                } else {
                    // Main category without subcategories
                    html += `<li class="nav-item">
        <a class="nav-link" href="?category_id=${cat.category_id}">${cat.name}</a>
      </li>`;
                }
            });
            return html;
        }

        $(function () {
            $.getJSON('ajax/get_categories.php', function (tree) {
                $('#category-nav').html(renderNav(tree));
            });
        });
    </script>


    <script>
        function renderProducts(products, filterFeatured) {
            let html = '';
            products.filter(p => p.featured == filterFeatured).forEach(function (p) {
                html += `
<div class="col">
  <div class="product-card bg-white">
    <div class="rating"><i class="fa fa-star"></i> ${parseFloat(p.rating || 5).toFixed(1)}</div>
    <img src="admin/ajax/${p.image || 'https://via.placeholder.com/400x180?text=No+Image'}" class="product-img" alt="${p.title}">
    <div class="overlay-buttons" data-product-id="${p.product_id}">
      <button class="action-btn wishlist-btn" title="Add to Wishlist">
        <i class="fa-regular fa-heart"></i>
      </button>
      <button class="action-btn cart-btn" title="Add to Cart">
        <i class="fa-solid fa-cart-plus"></i>
      </button>
    </div>
    <div class="p-3">
      <a href="product.php?product_id=${p.product_id}">  <h6 class="mb-1 fw-semibold">${p.title}</h6> </a>
      <small class="text-muted">${p.vendor || ''}</small><br/>
      <span class="text-danger fw-bold">$${parseFloat(p.price).toFixed(2)}</span>
      ${p.old_price ? `<span class="strike">$${parseFloat(p.old_price).toFixed(2)}</span>` : ''}
      ${p.discount ? `<span class="discount">–${p.discount}%</span>` : ''}
    </div>
  </div>
</div>
`;
            });
            if (html === '') html = '<div class="col">No products yet.</div>';
            return html;
        }

        $(function () {
            $.getJSON('ajax/get_products.php', function (products) {
                $('#featured-products-dynamic').html(renderProducts(products, 1));
                $('#premium-products-dynamic').html(renderProducts(products, 0));
            });

            // Add to cart/wishlist AJAX
            $(document).on('click', '.wishlist-btn, .cart-btn', function () {
                var productId = $(this).closest('.overlay-buttons').data('product-id');
                var action = $(this).hasClass('wishlist-btn') ? 'add_to_wishlist' : 'add_to_cart';

                $.ajax({
                    type: "POST",
                    url: 'ajax/product_action.php',
                    data: {
                        action: action,
                        product_id: productId
                    },
                    dataType: "json",
                    success: function (resp) {
                        console.log('Response:', resp);
                        if (resp.success) {
                            updateCartIconCount();
                            alert(resp.message || 'Action complete');
                        } else {
                            alert(resp.message || 'Something went wrong');
                            if (resp.error) {
                                console.error('API Error:', resp.error);
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        // This runs if the response is not valid JSON or server/network error occurs
                        let msg = "Unexpected error. ";
                        if (xhr.responseText) {
                            msg += "\nServer says: " + xhr.responseText;
                        }
                        alert(msg);
                        console.error('AJAX Error:', status, error, xhr.responseText);
                    }
                });
            });
        });

    </script>
    <script>
        function updateCartIconCount() {
            $.getJSON('ajax/cart_get.php', function (items) {
                const count = items?.length || 0;
                const badge = $('#cartCountBadge');

                badge.text(count);

                if (count > 0) {
                    badge.css('color', '#dc3545'); // Bootstrap Red
                } else {
                    badge.css('color', '#aaa'); // Grey for 0
                }
            });
        }

        // Run it on page load
        $(function () {
            updateCartIconCount();
        });
    </script>

</body>

</html>