<?php
include_once 'config/db.php'; // This file must include session_start() and set $usercode

header("Content-Type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Digitals Design | Download Premium PDFs, Educational & Productivity Materials</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="main_logo.svg" />

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Digitals Design offers high-quality digital products including educational PDFs, productivity templates, and learning materials. Get instant downloads to boost your knowledge and efficiency." />
    <meta name="keywords"
        content="Digital Products, Educational PDFs, Productivity Templates, Download PDFs, Study Materials, Printable Resources, Digitals Design" />
    <meta name="author" content="Digitals Design Team" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="en" />
    <meta name="theme-color" content="#ff5757" />

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="Digitals Design | Educational & Productivity Digital Products" />
    <meta property="og:description"
        content="Download educational PDFs, productivity tools, templates and more. Instant access to top-quality digital downloads." />
    <meta property="og:image" content="https://digitalsdesign.com/main_logo.svg" />
    <meta property="og:url" content="https://digitalsdesign.com/" />
    <meta property="og:type" content="website" />

    <!-- Twitter Meta Tags -->
    <meta name="twitter:title" content="Digitals Design" />
    <meta name="twitter:description"
        content="Premium digital downloads including educational PDFs, planners, and productivity tools." />
    <meta name="twitter:image" content="https://digitalsdesign.com//main_logo.svg" />
    <meta name="twitter:card" content="summary_large_image" />

    <!-- Canonical Link -->
    <link rel="canonical" href="https://digitalsdesign.com/" />

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

        /* Hide hamburger menu on desktop */
        .navbar-toggler {
            display: none !important;
        }

        /* Show category nav on desktop */
        .category-nav {
            display: block !important;
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

    /* ===== MOBILE HAMBURGER MENU STYLES ===== */
    .navbar-toggler {
        border: none;
        padding: 0.25rem 0.5rem;
        background: none;
        box-shadow: none !important;
        outline: none !important;
    }

    .navbar-toggler:focus {
        box-shadow: none;
        outline: none;
    }

    .navbar-toggler-icon {
        background-image: none;
        width: 24px;
        height: 24px;
        position: relative;
    }

    /* Custom hamburger icon */
    .navbar-toggler-icon::before,
    .navbar-toggler-icon::after,
    .navbar-toggler-icon {
        background-color: #333;
    }

    .navbar-toggler-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #333;
        transition: all 0.3s;
    }

    .navbar-toggler-icon::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #333;
        transition: all 0.3s;
    }

    .navbar-toggler-icon {
        background-color: #333;
        height: 2px;
        width: 100%;
        position: relative;
        transition: all 0.3s;
        top: 50%;
        transform: translateY(-50%);
    }

    /* Mobile offcanvas menu */
    .mobile-menu-offcanvas {
        width: 280px !important;
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .mobile-menu-header {
        background: #ff5757;
        color: white;
        padding: 1rem;
        border-bottom: 1px solid #e14545;
    }

    .mobile-menu-body {
        padding: 0;
    }

    .mobile-category-item {
        border-bottom: 1px solid #f0f0f0;
    }

    .mobile-category-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
    }

    .mobile-category-link:hover {
        background: rgba(255, 87, 87, 0.05);
        color: #ff5757;
    }

    .mobile-category-icon {
        font-size: 0.9rem;
        color: #666;
        transition: transform 0.3s;
    }

    .mobile-category-item.show .mobile-category-icon {
        transform: rotate(180deg);
    }

    .mobile-subcategory-list {
        background: #f8f9fa;
        padding: 0;
        display: none;
    }

    .mobile-subcategory-item {
        padding: 0.5rem 1rem 0.5rem 2rem;
        border-bottom: 1px solid #e9ecef;
    }

    .mobile-subcategory-item:last-child {
        border-bottom: none;
    }

    .mobile-subcategory-link {
        color: #666;
        text-decoration: none;
        font-size: 0.9rem;
        display: block;
        padding: 0.25rem 0;
    }

    .mobile-subcategory-link:hover {
        color: #ff5757;
    }

    .nav-link,
    .navbar-nav .nav-link {
        font-weight: 600;
        color: #222 !important;
        margin-right: 10px;
        padding: 0.5rem 0.75rem;
    }

    /* Category Navigation - Hidden on mobile */
    .category-nav {
        background: #fff;
        border-bottom: 1px solid #eee;
        overflow-x: auto;
        white-space: nowrap;
    }

    /* Mobile Styles */
    @media (max-width: 991.98px) {
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

        /* Hide desktop category navigation on mobile */
        .category-nav {
            display: none !important;
        }

        /* Show hamburger menu on mobile */
        .navbar-toggler {
            display: block !important;
            order: -1;
            margin-right: 0.5rem;
        }

        /* Mobile navbar layout */
        .mobile-navbar-content {
            display: flex;
            align-items: center;
            width: 100%;
            gap: 0.5rem;
        }

        .mobile-navbar-content .navbar-brand {
            flex: 1;
            text-align: center;
            margin: 0;
        }

        .mobile-header-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

    /* Rest of your existing styles... */
    /* (Include all the other styles from your original code here) */

    /* ===== CATEGORY NAVIGATION & DROPDOWN STYLES ===== */
    .category-nav {
        background: #fff;
        border-bottom: 1px solid #eee;
        overflow: visible !important;
        white-space: nowrap;
        position: relative;
        z-index: 1000;
    }

    .category-nav .navbar-nav {
        flex-wrap: nowrap;
        overflow: visible !important;
    }

    .category-nav .nav-item {
        position: relative;
    }

    .category-nav .nav-link {
        font-weight: 600;
        color: #222 !important;
        margin-right: 10px;
        padding: 0.5rem 0.75rem;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .category-nav .nav-link:hover::after {
        content: '';
        display: block;
        height: 3px;
        width: 90%;
        margin: 0 auto 0 auto;
        background: #ff5757;
        border-radius: 1.5px;
        position: absolute;
        bottom: 0;
        left: 5%;
        right: 5%;
    }

    /* Dropdown mega menu styles */
    .dropdown-mega {
        position: relative;
        z-index: 1001;
    }

    .dropdown-mega .mega-menu {
        width: 400px;
        left: 0;
        right: auto;
        position: absolute !important;
        top: 100%;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        display: none;
        z-index: 99999 !important;
        padding: 20px;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease;
    }

    .dropdown-mega:hover .mega-menu {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .dropdown-mega .dropdown-header {
        font-weight: 600;
        color: #ff5757;
        font-size: 16px;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }

    .dropdown-mega .dropdown-item {
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.3s ease;
        color: #555;
        text-decoration: none;
        display: block;
        margin-bottom: 2px;
    }

    .dropdown-mega .dropdown-item:hover {
        background-color: rgba(255, 87, 87, 0.1);
        color: #ff5757;
        text-decoration: none;
    }

    .dropdown-mega .dropdown-item i {
        color: #ff5757;
        margin-right: 8px;
    }

    .custom-container {
        max-width: 1300px;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
    }

    /* Mobile search bar full width with margins */
    @media (max-width: 991.98px) {
        .mobile-search-container {
            width: 100%;
            padding: 0.75rem 1rem;
            /* Margin from start and end */
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
        }

        .mobile-search-container .header-search {
            margin: 0;
            max-width: none;
        }

        .mobile-search-container .header-search input {
            width: 100%;
            border-radius: 25px;
            border: 2px solid #f0f0f0;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            background: #fafafa;
        }

        .mobile-search-container .header-search input:focus {
            border-color: #ff5757;
            box-shadow: 0 0 0 0.2rem rgba(255, 87, 87, 0.25);
            background: #fff;
        }
    }

    /* Custom hamburger icon - Fixed */
    .navbar-toggler {
        border: none;
        padding: 0.4rem;
        background: none;
        box-shadow: none !important;
        outline: none !important;
        width: 40px;
        height: 40px;
        position: relative;
    }

    .navbar-toggler:focus {
        box-shadow: none;
        outline: none;
    }

    .navbar-toggler-icon {
        background-image: none !important;
        width: 24px;
        height: 18px;
        position: relative;
        display: block;
    }

    /* Three horizontal lines */
    .navbar-toggler-icon,
    .navbar-toggler-icon::before,
    .navbar-toggler-icon::after {
        width: 24px;
        height: 3px;
        background-color: #333;
        border-radius: 1px;
        transition: all 0.3s ease;
    }

    .navbar-toggler-icon::before,
    .navbar-toggler-icon::after {
        content: '';
        position: absolute;
        left: 0;
    }

    .navbar-toggler-icon::before {
        top: -7px;
    }

    .navbar-toggler-icon::after {
        top: 7px;
    }

    /* Animation when opened */
    .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
        background-color: transparent;
    }

    .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
        transform: rotate(45deg);
        top: 0;
    }

    .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::after {
        transform: rotate(-45deg);
        top: 0;
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

    /* ===== MEGA MENU DROPDOWN STYLES (Updated) ===== */
    .mega-menu {
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

    /* Simple submenu for pure CSS approach */
    .nav-item.has-submenu {
        position: relative;
    }

    .nav-item.has-submenu .submenu {
        position: absolute;
        top: 100%;
        left: 0;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        min-width: 200px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 99999 !important;
        padding: 8px 0;
    }

    .nav-item.has-submenu:hover .submenu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .submenu a {
        display: block;
        padding: 10px 15px;
        color: #555;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .submenu a:hover {
        background-color: rgba(255, 87, 87, 0.1);
        color: #ff5757;
        text-decoration: none;
    }

    /* ===== BOOTSTRAP DROPDOWN OVERRIDE ===== */
    .navbar-nav .dropdown-menu {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #e0e0e0;
        z-index: 99999 !important;
    }

    .navbar-nav .dropdown-item:hover {
        background-color: rgba(255, 87, 87, 0.1);
        color: #ff5757;
    }

    /* ===== ACCESSIBILITY & FOCUS STATES ===== */
    .dropdown-mega .dropdown-item:focus,
    .submenu a:focus,
    .nav-link:focus {
        outline: 2px solid #ff5757;
        outline-offset: 2px;
    }

    /* Keyboard navigation support */
    .dropdown-mega:focus-within .mega-menu,
    .nav-item.has-submenu:focus-within .submenu {
        display: block;
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* === CATEGORY NAV CLEAN ACTIVE UNDERLINE === */
    .category-nav .nav-link {
        background: none !important;
        border: none !important;
        color: #222 !important;
        box-shadow: none !important;
        outline: none !important;
        border-radius: 0 !important;
        font-weight: 600;
        position: relative;
        transition: color .2s;
    }

    /* On hover: just underline */
    .category-nav .nav-link:hover,
    .category-nav .nav-link:focus {
        background: none !important;
        border: none !important;
        color: #ff5757 !important;
        box-shadow: none !important;
        outline: none !important;
    }

    .category-nav .nav-link:hover::after,
    .category-nav .nav-link:focus::after {
        content: '';
        display: block;
        height: 3px;
        width: 90%;
        margin: 0 auto;
        background: #ff5757;
        border-radius: 1.5px;
        position: absolute;
        bottom: -8px;
        left: 5%;
        right: 5%;
        z-index: 2;
    }

    /* On active (selected): underline, no box */
    .category-nav .nav-link.active,
    .category-nav .nav-link.selected {
        background: none !important;
        border: none !important;
        color: #ff5757 !important;
        font-weight: 700;
        box-shadow: none !important;
        border-radius: 0 !important;
        outline: none !important;
    }

    .category-nav .nav-link.active::after,
    .category-nav .nav-link.selected::after {
        content: '';
        display: block;
        height: 3px;
        width: 90%;
        margin: 0 auto;
        background: #ff5757;
        border-radius: 1.5px;
        position: absolute;
        bottom: -8px;
        left: 5%;
        right: 5%;
        z-index: 2;
    }

    /* Remove ALL FOCUS/CLICK BOXES from active */
    .category-nav .nav-link:focus,
    .category-nav .nav-link:active,
    .category-nav .nav-link.active:focus,
    .category-nav .nav-link.active:active {
        background: none !important;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }

    /* Optionally, if using Bootstrap tabs/pills, disable their active style: */
    .category-nav .nav-item .nav-link.active,
    .category-nav .nav-item.show .nav-link {
        background: none !important;
        border: none !important;
        color: #ff5757 !important;
        border-radius: 0 !important;
        font-weight: 700;
    }

    /* Remove existing border on dropdown-toggle */
    .dropdown-toggle {
        background-color: white;
        border: none !important;
        box-shadow: none !important;
        padding: 6px 14px;
        border-radius: 6px;
        position: relative;
    }

    /* Custom arrow for dropdown instead of bootstrap's */
    .dropdown-toggle::after {
        content: "\f078";
        font-family: "FontAwesome";
        font-size: 0.75em;
        border: none;
        margin-left: 0.5em;
        vertical-align: middle;
    }

    /* Profile dropdown fixes */
    .dropdown-menu {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border: 1px solid #e0e0e0;
        z-index: 9999 !important;
        min-width: 160px;
        margin-top: 0.5rem;
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        color: #333;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: rgba(255, 87, 87, 0.1);
        color: #ff5757;
    }

    /* Ensure dropdown appears above other elements */
    .navbar .dropdown {
        position: relative;
        z-index: 1050;
    }

    .dropdown-menu.show {
        display: block !important;
        opacity: 1;
        visibility: visible;
    }

    /* Mobile dropdown adjustments */
    @media (max-width: 991.98px) {
        .mobile-header-actions .dropdown-menu {
            right: 0;
            left: auto;
            transform: translateX(0);
        }
    }

    /* Remove grey shadow/backdrop on mobile category clicks */
    @media (max-width: 991.98px) {

        /* Remove any backdrop shadows */
        .modal-backdrop,
        .offcanvas-backdrop {
            display: none !important;
        }

        /* Remove focus/active shadows from mobile category links */
        .mobile-category-link:focus,
        .mobile-category-link:active,
        .mobile-category-link.active {
            background: none !important;
            box-shadow: none !important;
            outline: none !important;
        }

        /* Remove touch highlights */
        .mobile-category-link,
        .mobile-subcategory-link {
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Remove any overlay shadows */
        .offcanvas.show {
            box-shadow: none !important;
        }

        /* Ensure no grey overlay appears */
        body.modal-open,
        body.offcanvas-open {
            overflow: auto !important;
        }

        /* Remove Bootstrap's default focus styles */
        .mobile-category-link:focus-visible,
        .mobile-subcategory-link:focus-visible {
            outline: none !important;
            box-shadow: none !important;
        }
    }

    /* Global fix for grey shadows on touch devices */
    * {
        -webkit-tap-highlight-color: transparent !important;
    }

    /* Remove any lingering shadows from offcanvas */
    .mobile-menu-offcanvas {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1) !important;
    }

    .mobile-menu-offcanvas.show {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1) !important;
    }

    /* iOS specific scroll fixes */
    @media (max-width: 991.98px) {

        /* Fix iOS viewport issues */
        body {
            min-height: 100vh;
            min-height: -webkit-fill-available;
        }

        /* Prevent iOS bounce scroll from interfering */
        .mobile-menu-offcanvas {
            -webkit-overflow-scrolling: touch;
            overflow-scrolling: touch;
        }
    }

    /* Fix mobile scrolling after category selection */
    @media (max-width: 991.98px) {

        /* Ensure body scroll is restored after category clicks */
        body {
            overflow: auto !important;
            position: relative !important;
            height: auto !important;
            padding-right: 0 !important;
        }

        /* Prevent scroll lock from offcanvas */
        body.modal-open,
        body.offcanvas-open {
            overflow: auto !important;
            position: static !important;
        }

        /* Fix iOS scroll issues */
        body,
        html {
            -webkit-overflow-scrolling: touch;
            overflow-scrolling: touch;
        }

        /* Ensure content areas are scrollable */
        #search-results-section,
        .hero-section,
        #featured-section,
        #premium-section {
            overflow: visible !important;
            height: auto !important;
        }
    }

    /* Prevent submenu from closing accidentally */
    @media (max-width: 991.98px) {
        .mobile-subcategory-list {
            z-index: 10;
            position: relative;
        }

        .mobile-category-item.show .mobile-subcategory-list {
            display: block !important;
        }

        /* Prevent touch events from bubbling */
        .mobile-category-link,
        .mobile-subcategory-link {
            touch-action: manipulation;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    }

    /* Mobile search bar styling to match screenshot */
    @media (max-width: 991.98px) {
        .mobile-search-container {
            width: 100%;
            padding: 0.75rem 1rem;
            background: #fff;
        }

        .mobile-search-container .header-search {
            margin: 0;
            max-width: none;
            position: relative;
        }

        .mobile-search-container .header-search input {
            width: 100%;
            border-radius: 25px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 3rem 0.75rem 1.5rem;
            font-size: 1rem;
            background: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .mobile-search-container .header-search input:focus {
            border-color: #ff5757;
            box-shadow: 0 0 0 0.2rem rgba(255, 87, 87, 0.25);
            background: #fff;
            outline: none;
        }

        /* Add search icon */
        .mobile-search-container .header-search::after {
            content: '\f002';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1rem;
            pointer-events: none;
        }
    }

    /* Email signup form - mobile specific styling */
    @media (max-width: 991.98px) {
        .email-signup {
            background: #fff;
            border-radius: 25px;
            padding: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            max-width: 100%;
            margin-top: 2rem !important;
            border: 2px solid #e9ecef;
        }

        .email-signup .row {
            margin: 0;
            align-items: center;
        }

        .email-signup .col-12:first-child {
            display: none;
            /* Hide envelope icon on mobile */
        }

        .email-signup input[type="email"] {
            border: 2px solid #e9ecef;
            border-radius: 20px;
            background: transparent;
            font-size: 1rem;
            padding: 0.75rem 1rem;
            outline: none;
            box-shadow: none;
        }

        .email-signup input[type="email"]:focus {
            box-shadow: none;
            border: none;
            outline: none;
        }

        .email-signup .btn-signup {
            background: #ff5757;
            color: #fff;
            border: none;
            border-radius: 20px;
            font-weight: 600;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            white-space: nowrap;
            margin-left: 0.5rem;
        }

        .email-signup .btn-signup:hover {
            background: #e14545;
        }

        /* Stack elements vertically on very small screens */
        @media (max-width: 575.98px) {
            .email-signup {
                border: 2px solid #e9ecef;
                padding: 0.75rem;
                border-radius: 20px;
            }

            .email-signup .row {
                flex-direction: column;
                gap: 0.75rem;
            }

            .email-signup input[type="email"] {
                width: 100%;
                text-align: center;
            }

            .email-signup .btn-signup {
                width: 100%;
                margin-left: 0;
            }
        }
    }

    /* Desktop - keep original styling */
    @media (min-width: 992px) {
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

        .email-signup input[type="email"] {
            border: none;
            border-radius: 30px;
            flex: 1;
            outline: none;
            font-size: 1.15rem;
            background: transparent;
            padding: 0.5rem 1rem;
        }

        .email-signup .btn-signup {
            background: #ff5757;
            color: #fff;
            padding: 0.65em 2em;
            border-radius: 30px;
            font-weight: 600;
            border: none;
            margin-left: 0.5em;
            font-size: 1.07rem;
        }

        .email-signup .btn-signup:hover {
            background: #e14545;
        }

        .email-signup .bi-envelope {
            font-size: 1.3em;
            color: #c2c2c2;
            margin-right: 8px;
        }
    }
</style>
<style>
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

    /* Mobile & tablet alignment fix */
    @media (max-width: 991px) {

        .footer-top .col-lg-4,
        .footer-top .col-lg-2 {
            text-align: left;
        }
    }
</style>

<body>
    <!-- Mobile Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="custom-container px-3">
            <!-- Mobile Layout -->
            <div class="d-lg-none mobile-navbar-content">
                <!-- Hamburger Menu Button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileMenuOffcanvas" aria-controls="mobileMenuOffcanvas" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Logo (Centered) -->
                <a class="navbar-brand d-flex align-items-center" id="logo-div" href="/">
                    <img src="ic_logo.svg" alt="Digitals Design logo" style="height:38px;" />
                </a>
                <!-- Cart -->

                <!-- Mobile Actions -->
                <div class="mobile-header-actions">
                    <?php if (!$usercode): ?>
                        <a class="btn btn-sign" href="login.php" style="font-size: 0.8rem; padding: 0.3rem 0.8rem;">Sign
                            In</a>
                    <?php else: ?>
                        <div class="dropdown">
                            <button class="btn btn-cta dropdown-toggle" type="button" id="profileDropdownMobile"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                style="font-size: 0.8rem; padding: 0.3rem 0.6rem;">
                                <i class="fa fa-user-circle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdownMobile">
                                <li><a class="dropdown-item" href="user/">My Profile</a></li>
                                <li><a class="dropdown-item" href="user/auth/logout.php">Logout</a></li>
                            </ul>

                        </div>


                    <?php endif; ?>
                    <div class="cart-section">
                        <a href="cart.php">
                            <i class="bi bi-bag" style="font-size: 1.2em; color: #222"></i>
                        </a>
                        <span id="cartCountBadge" class="ms-1 fs-6" style="color: #aaa">0</span>
                    </div>

                </div>
            </div>

            <!-- Desktop Layout -->
            <div class="d-none d-lg-flex w-100 align-items-center justify-content-between">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" id="logo-div" href="/">
                    <img src="ic_logo.svg" alt="Digitals Design logo" style="height:68px;" />
                </a>

                <!-- Search Bar (centered) -->
                <form class="header-search flex-grow-1 mx-3" role="search">
                    <input id="main-search-input" class="form-control" type="search"
                        placeholder="Search names, categories, occasions..." aria-label="Search" />
                </form>

                <!-- Right Side -->
                <div class="d-flex align-items-center gap-3 flex-shrink-0">
                    <?php if (!$usercode): ?>
                        <a class="btn btn-sign" href="login.php">Sign In</a>
                    <?php else: ?>
                        <div class="dropdown">
                            <button class="btn btn-cta dropdown-toggle" type="button" id="profileDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user-circle me-1"></i> Profile
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="user/">My Profile</a></li>
                                <li><a class="dropdown-item" href="user/auth/logout.php">Logout</a></li>
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

            <!-- Mobile Search Bar (Full Width Below Header) -->

            <div class="d-lg-none mobile-search-container">
                <form class="header-search" role="search">
                    <input id="main-search-input-mobile" class="form-control" type="search"
                        placeholder="Search products, categories..." aria-label="Search" />
                </form>
            </div>

        </div>
    </nav>

    <!-- Mobile Menu Offcanvas -->
    <div class="offcanvas offcanvas-start mobile-menu-offcanvas" tabindex="-1" id="mobileMenuOffcanvas"
        aria-labelledby="mobileMenuOffcanvasLabel">
        <div class="mobile-menu-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0" id="mobileMenuOffcanvasLabel">Categories</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="mobile-menu-body">
            <div id="mobile-category-menu">
                <!-- Categories will be loaded here via JavaScript -->
            </div>
        </div>
    </div>

    <!-- Desktop Category Navigation -->
    <nav class="navbar navbar-expand category-nav d-none d-lg-block">
        <div class="custom-container px-3">
            <ul class="navbar-nav" id="category-nav"></ul>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Your existing JavaScript code continues here... -->
</body>

</html>