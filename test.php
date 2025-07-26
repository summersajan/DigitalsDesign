<?php
include_once 'config/db.php'; // This file must include session_start() and set $usercode

header("Content-Type: text/html; charset=utf-8");
?>
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
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />


</head>
<style>
    body {
        background: #fff;
        font-family: "Poppins", sans-serif;
    }

    /* ===== NAVBAR/HEADER STYLES ===== */
    .navbar {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        background: #fff;
        padding: 0.75rem 0;
    }

    .navbar-brand {
        flex-shrink: 0;
        margin-right: 0;
    }

    .navbar-brand span {
        font-family: "Pacifico", cursive;
        color: #ff5757;
        font-weight: 700;
        font-size: 2rem;
    }

    /* Desktop Layout - Search centered, buttons at end */
    @media (min-width: 992px) {
        .navbar .container-fluid {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            flex: 0 0 auto;
        }

        .header-search {
            flex: 1;
            max-width: 500px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
        }

        .header-actions {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-left: auto;
        }

        .navbar-collapse {
            display: flex !important;
            flex: 1;
            align-items: center;
        }
    }

    .header-search input {
        border-radius: 30px;
        border: 2px solid #f0f0f0;
        padding: 0.6rem 1.5rem;
        width: 100%;
    }

    .header-search input:focus {
        border-color: #ff5757;
        box-shadow: 0 0 0 0.2rem rgba(255, 87, 87, 0.25);
    }

    .header-actions {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-cta {
        background: rgba(255, 87, 87, 0.1);
        color: #ff5757;
        border: 2px solid #ff5757;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s;
        white-space: nowrap;
        padding: 0.5rem 1rem;
    }

    .btn-cta:hover {
        background: #ff5757;
        color: #fff;
    }

    .btn-sign {
        background: #ff5757;
        color: white;
        border-radius: 30px;
        font-weight: 500;
        border: 2px solid #ff5757;
        white-space: nowrap;
        padding: 0.5rem 1.5rem;
    }

    .btn-sign:hover {
        background: #e14545;
        border-color: #e14545;
    }

    .cart-section {
        display: flex;
        align-items: center;
        margin-left: 0.5rem;
    }

    .navbar-toggler {
        border: none;
        padding: 0.25rem 0.5rem;
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }

    .nav-link,
    .navbar-nav .nav-link {
        font-weight: 600;
        color: #222 !important;
        margin-right: 10px;
        padding: 0.5rem 0.75rem;
    }

    /* Category Navigation */
    .category-nav {
        background: #fff;
        border-bottom: 1px solid #eee;
        overflow-x: auto;
        white-space: nowrap;
    }

    .category-nav .navbar-nav {
        flex-wrap: nowrap;
    }

    /* Mobile Styles */
    @media (max-width: 575.98px) {
        .navbar-brand span {
            font-size: 1.5rem;
        }

        .header-search {
            margin: 0.5rem 0;
            order: 3;
            flex-basis: 100%;
        }

        .header-actions {
            gap: 0.25rem;
        }

        .btn-cta {
            font-size: 0.85rem;
            padding: 0.4rem 0.8rem;
        }

        .btn-sign {
            font-size: 0.85rem;
            padding: 0.4rem 1rem;
        }

        .navbar {
            padding: 0.5rem 0;
        }

        .navbar-collapse {
            margin-top: 1rem;
            background: #fff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .category-nav .navbar-nav {
            padding: 0.5rem 0;
        }

        .category-nav .nav-link {
            font-size: 0.9rem;
            margin-right: 0.5rem;
        }
    }

    /* Tablet Styles (iPad) */
    @media (min-width: 576px) and (max-width: 991.98px) {
        .header-search {
            max-width: 300px;
            margin: 0 0.75rem;
        }

        .btn-cta,
        .btn-sign {
            font-size: 0.9rem;
        }

        .navbar-brand span {
            font-size: 1.7rem;
        }

        .navbar-collapse {
            background: #fff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
        }
    }

    /* Large tablet and small desktop */
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .header-search {
            max-width: 400px;
        }
    }

    /* Large desktop fine-tuning */
    @media (min-width: 1200px) {
        .header-search {
            max-width: 600px;
        }

        .header-actions {
            gap: 1rem;
        }
    }

    /* ===== HERO SECTION STYLES ===== */
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
        color: #ff5757;
        font-weight: 700;
        font-size: 1.8rem;
        display: inline-block;
        border-radius: 2px;
        transform: rotate(-6deg);
        box-shadow: 0 3px 0 rgba(255, 87, 87, 0.3);
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

    /* ===== EMAIL SIGNUP STYLES ===== */
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
        background: #ff5757;
        color: #fff;
        padding: 0.65em 2em;
        border-radius: 30px;
        font-weight: 600;
        border: none;
        margin-left: 0.5em;
        font-size: 1.07rem;
    }

    .btn-signup:hover {
        background: #e14545;
    }

    .email-signup .bi-envelope {
        font-size: 1.3em;
        color: #c2c2c2;
        margin-right: 8px;
    }

    /* ===== CAROUSEL STYLES ===== */
    .carousel-inner img {
        border-radius: 10px 10px 0 0;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: #222;
        border-radius: 18px;
        padding: 4px;
    }

    /* ===== PRODUCT CARD STYLES ===== */
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
        transition: all 0.3s ease;
        position: relative;
    }

    .product-card:hover,
    .premium-product-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.09);
        transform: translateY(-5px);
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
        color: #ff5757;
        font-weight: 700;
        margin-left: 1em;
        font-size: 0.95em;
    }

    .text-orange {
        color: #ff5757;
    }

    .text-link {
        color: #ff5757;
        text-decoration: underline;
    }

    .product-img {
        width: 100%;
        height: 220px;
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
        color: #666;
    }

    .action-btn:hover {
        color: #ff5757;
    }

    /* ===== RESPONSIVE HERO SECTION ===== */
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
        .hero-section {
            padding: 30px 0;
        }

        .hero-section .hero-img {
            width: 90vw;
            max-width: 100%;
        }
    }

    /* ===== FOOTER STYLES ===== */
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
        color: #ff5757;
    }

    .footer-logo {
        font-size: 24px;
        font-weight: 700;
    }

    .footer-logo span {
        color: #ff5757;
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

    .social-icons a:hover {
        color: #ff5757;
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

    /* ===== DROPDOWN MENU STYLES ===== */
    .dropdown-menu {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #e0e0e0;
    }

    .dropdown-item:hover {
        background-color: rgba(255, 87, 87, 0.1);
        color: #ff5757;
    }

    /* ===== UTILITY CLASSES ===== */
    .text-primary-theme {
        color: #ff5757 !important;
    }

    .bg-primary-theme {
        background-color: #ff5757 !important;
    }

    .border-primary-theme {
        border-color: #ff5757 !important;
    }

    /* ===== FOCUS STATES ===== */
    .btn:focus,
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(255, 87, 87, 0.25);
    }

    /* ===== ANIMATION IMPROVEMENTS ===== */
    .btn,
    .product-card,
    .nav-link {
        transition: all 0.3s ease;
    }

    /* ===== SCROLL BAR STYLING ===== */
    .category-nav::-webkit-scrollbar {
        height: 4px;
    }

    .category-nav::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .category-nav::-webkit-scrollbar-thumb {
        background: #ff5757;
        border-radius: 2px;
    }

    .category-nav::-webkit-scrollbar-thumb:hover {
        background: #e14545;
    }
</style>

<style>
    /* Footer styles updated with new theme color */
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
        color: #ff5757;
    }

    .footer-logo {
        font-size: 24px;
        font-weight: 700;
    }

    .footer-logo span {
        color: #ff5757;
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

    .social-icons a:hover {
        color: #ff5757;
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

    /* Mega-menu dropdown */
    .dropdown-mega .mega-menu {
        width: 650px;
        left: 0;
        right: auto;
        position: absolute !important;
        top: 100%;
        background: #fff;
        border-radius: 0.375rem;
        box-shadow: 0 4px 32px rgba(0, 0, 0, 0.09);
        display: none;
        z-index: 1002;
    }

    .dropdown-mega.show .mega-menu {
        display: block;
    }

    .dropdown-mega .dropdown-menu {
        border: none;
        margin-top: 0;
    }

    .dropdown-mega .dropdown-item {
        font-size: 1rem;
        padding-left: 0;
        padding-right: 0;
        background: transparent;
        border-radius: 0;
    }

    @media (max-width: 991.98px) {
        .dropdown-mega .mega-menu {
            width: 100vw;
            min-width: unset;
            left: 0;
            right: 0;
            position: static !important;
            box-shadow: none;
        }
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid px-3">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <span>Digitals</span><strong>Design</strong>
                <span class="fs-4" style="color: #222">.com</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Search Bar -->
                <form class="header-search mx-auto" role="search">
                    <input id="main-search-input" class="form-control" type="search"
                        placeholder="Search names, categories, occasions..." aria-label="Search" />
                </form>

                <!-- Right Side -->
                <div class="header-actions">
                    <a class="btn btn-cta d-none d-sm-inline-block" href="#">Unlock Your Creativity Today!</a>
                    <a class="btn btn-cta d-sm-none" href="#">Get Started!</a>

                    <?php if (!$usercode): ?>
                        <!-- If not signed in -->
                        <a class="btn btn-sign" href="signin.php">Sign In</a>
                    <?php else: ?>
                        <!-- If signed in -->
                        <div class="dropdown">
                            <button class="btn btn-cta dropdown-toggle" type="button" id="profileDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user-circle me-1"></i> Profile
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="user/">My Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>

                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Cart -->
                    <div class="cart-section">
                        <a href="cart.php">
                            <i class="bi bi-bag" style="font-size: 1.4em; color: #222"></i>
                        </a>
                        <span id="cartCountBadge" class="ms-1 fs-6" style="color: #aaa">0</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Category Navigation -->
    <nav class="navbar navbar-expand category-nav">
        <div class="container-fluid px-3">
            <ul class="navbar-nav" id="category-nav"></ul>
        </div>
    </nav>
    <div class="container py-4" id="product_id">
        <p>Hello</p>
    </div>

    <footer>
        <div class="container">
            <div class="row g-4">
                <!-- Logo and Counts -->
                <div class="col-lg-4">
                    <div class="footer-logo mb-2">
                        <span>Digtials</span>Design<small>.Com</small>
                    </div>
                    <p class="mb-3">
                        Craft, create, and inspire with endless design possibilities at
                        Design Bundles.
                    </p>
                    <div class="footer-counts">
                        <p><strong>5,211,609</strong> Products</p>
                        <p><strong>5,336,212</strong> Customers</p>
                        <p><strong>9,250</strong> Stores</p>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="col-6 col-lg-2 footer-links">
                    <h6>Navigation</h6>
                    <ul>
                        <li><a href="#">Certified Carbon Neutral Company</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">Our Licenses</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms and Conditions</a></li>
                        <li><a href="#">Collections</a></li>
                        <li><a href="#">News</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div class="col-6 col-lg-3 footer-links">
                    <h6>Resources</h6>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Design School</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Monogram Maker</a></li>
                        <li><a href="#">Imagine Anything</a></li>
                        <li><a href="#">DTF Printer</a></li>
                        <li><a href="#">Our Favourite Stores</a></li>
                        <li><a href="#">Recommended Products</a></li>
                        <li><a href="#">Craft Tutorials</a></li>
                    </ul>
                </div>

                <!-- Pages -->
                <div class="col-lg-2 footer-links">
                    <h6>Pages</h6>
                    <ul>
                        <li><a href="#">Create a Store</a></li>
                        <li><a href="#">Affiliates</a></li>
                        <li><a href="#">Dollar Deals</a></li>
                        <li><a href="#">Register</a></li>
                        <li><a href="#">Login</a></li>
                    </ul>
                </div>

                <!-- Badge -->
                <div class="col-lg-1 certified-badge text-lg-end">
                    <img src="https://carbonneutral.com/themes/custom/cn/images/carbon-neutral-badge.png"
                        alt="Digtials Design" />
                </div>
            </div>

            <!-- Social & Currency -->
            <div class="row mt-4 align-items-center">
                <div class="col-md-6 text-center text-md-start social-icons">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#"><i class="fab fa-x-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="dropdown d-inline-block"></div>
                </div>
            </div>

            <!-- Bottom Text -->
            <div class="footer-bottom text-center mt-4">
                <p class="mb-1">© 2025 - All rights reserved. Digtials Design</p>
                <p class="mb-0"></p>
            </div>
        </div>
    </footer>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<!-- Your existing JavaScript code remains the same -->
<script>
    function renderMegaMenu(tree) {
        function renderColumn(children) {
            // Split columns in groups of 4 or whatever fits your design
            let html = '<div class="row">';
            for (let i = 0; i < children.length; i += 4) {
                html += `<div class="col-md-3 px-3 pt-3">` +
                    children.slice(i, i + 4).map(child =>
                        `<div><a class="dropdown-item" href="?category_id=${child.category_id}">${child.name}</a></div>`
                    ).join('') +
                    `</div>`;
            }
            html += '</div>';
            return html;
        }
        return tree.map(cat => {
            if (cat.children && cat.children.length) {
                // Mega menu
                return `
        <li class="nav-item dropdown dropdown-mega">
          <a class="nav-link dropdown-toggle" href="?category_id=${cat.category_id}" data-bs-toggle="dropdown" data-bs-auto-close="outside">
            ${cat.name}
          </a>
          <div class="dropdown-menu mega-menu px-4 py-3">
            ${renderColumn(cat.children)}
            <div class="mt-3"><a href="?category_id=${cat.category_id}" class="dropdown-item fw-bold">All ${cat.name}</a></div>
          </div>
        </li>
      `;
            } else {
                // Simple category
                return `<li class="nav-item"><a class="nav-link" href="?category_id=${cat.category_id}">${cat.name}</a></li>`;
            }
        }).join('');
    }
    function renderCategoryNav(tree) {
        return tree.map(cat => {
            if (cat.children && cat.children.length) {
                // Mega menu
                return `
        <li class="nav-item dropdown dropdown-mega">
          <a class="nav-link dropdown-toggle" href="?category_id=${cat.category_id}" data-bs-toggle="dropdown" data-bs-auto-close="outside">
            ${cat.name}
          </a>
          <div class="dropdown-menu mega-menu px-4 py-3">
            ${renderColumn(cat.children)}
            <div class="mt-3"><a href="?category_id=${cat.category_id}" class="dropdown-item fw-bold">All ${cat.name}</a></div>
          </div>
        </li>
      `;
            } else {
                // Simple category
                return `<li class="nav-item"><a class="nav-link" href="?category_id=${cat.category_id}">${cat.name}</a></li>`;
            }
        }).join('');
    }
    $(function () {
        $.getJSON('ajax/get_categories.php', function (tree) {
            $('#category-nav').html(renderMegaMenu(tree));
        });
    });
    $(function () {
        // Show mega dropdown on hover
        $('#category-nav').on('mouseenter', '.dropdown-mega', function () {
            $(this).addClass('show');
            $(this).find('.mega-menu').addClass('show');
        });
        $('#category-nav').on('mouseleave', '.dropdown-mega', function () {
            $(this).removeClass('show');
            $(this).find('.mega-menu').removeClass('show');
        });
    });
    // Delegated category/subcategory handle; works for all levels
    $(document).on('click', '#category-nav .dropdown-item, #category-nav .nav-link', function (e) {
        e.preventDefault();
        let href = $(this).attr('href');
        let urlParams = new URLSearchParams(href.split('?')[1]);
        let catId = urlParams.get('category_id');
        if (catId) {
            currentCategory = catId;
            currentCategoryName = $(this).text().trim();
            $('#main-search-input').val('');
            $('#hero-section, #featured-section, #premium-section').hide();
            $('#search-results-section').show();
            $('#search-title').text('Category: ' + currentCategoryName);
            $('#clear-category-btn').show();
            fetchAndRenderSearch(true);
            searchMode = true;
        }
    });

</script>



<script>
    function updateCartIconCount() {
        $.getJSON("ajax/cart_get.php", function (items) {
            const count = items?.length || 0;
            const badge = $("#cartCountBadge");

            badge.text(count);

            if (count > 0) {
                badge.css("color", "#ff5757");
            } else {
                badge.css("color", "#aaa");
            }
        });
    }

    // Run it on page load
    $(function () {
        updateCartIconCount();
    });
    // When "X" clear button is clicked
    $('#clear-category-btn').on('click', function () {
        location.reload();
    });



</script>
</body>

</html>