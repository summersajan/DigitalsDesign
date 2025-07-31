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
<style>
    /* ===== CATEGORY NAVIGATION & DROPDOWN STYLES ===== */

    /* Main category navigation container */
    .category-nav {
        background: #fff;
        border-bottom: 1px solid #eee;
        overflow: visible !important;
        /* Important: Don't clip dropdowns */
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

    /*
    .category-nav .nav-link:hover {
        color: #ff5757 !important;
    }*/

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

    /* ===== DROPDOWN MEGA MENU STYLES ===== */

    /* Parent dropdown container */
    .dropdown-mega {
        position: relative;
        z-index: 1001;
    }

    /* Mega menu dropdown */
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
        /* High z-index to ensure it's on top */
        padding: 20px;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease;
    }

    /* Show dropdown on hover */
    .dropdown-mega:hover .mega-menu {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    /* Dropdown header styling */
    .dropdown-mega .dropdown-header {
        font-weight: 600;
        color: #ff5757;
        font-size: 16px;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }

    /* Dropdown items */
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

    /* Remove existing border on dropdown-toggle */
    .dropdown-toggle {
        background-color: white;
        border: none !important;
        /* Remove border */
        box-shadow: none !important;
        padding: 6px 14px;
        /* Keep padding for clickable area */
        border-radius: 6px;
        position: relative;
    }

    /* If you want a custom arrow instead of bootstrap's, use this: */
    .dropdown-toggle::after {
        content: "\f078";
        /* Font Awesome down arrow, or use ▼ instead: "\25BC" */
        font-family: "FontAwesome";
        /* Or remove line for plain text arrow */
        font-size: 0.75em;
        border: none;
        margin-left: 0.5em;
        vertical-align: middle;
    }

    /* ===== ALTERNATIVE: SIMPLE HOVER DROPDOWN ===== */

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
        /* a faint underline for hover */
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

    /* ===== RESPONSIVE STYLES ===== */

    /* Mobile and tablet responsive */
    @media (max-width: 991.98px) {
        .dropdown-mega .mega-menu {
            width: 100%;
            position: static !important;
            display: block;
            box-shadow: none;
            border: none;
            padding: 10px 0;
            background: rgba(255, 87, 87, 0.05);
            opacity: 1;
            transform: none;
        }

        .nav-item.has-submenu .submenu {
            position: static;
            opacity: 1;
            visibility: visible;
            transform: none;
            box-shadow: none;
            border: none;
            background: rgba(255, 87, 87, 0.05);
            min-width: auto;
            display: none;
        }

        .nav-item.has-submenu:hover .submenu,
        .nav-item.has-submenu.active .submenu {
            display: block;
        }

        .category-nav .navbar-nav {
            padding: 0.5rem 0;
        }

        .category-nav .nav-link {
            font-size: 0.9rem;
            margin-right: 0.5rem;
            padding: 0.4rem 0.6rem;
        }
    }

    /* Mobile styles */
    @media (max-width: 575.98px) {
        .category-nav .nav-link {
            font-size: 0.85rem;
            padding: 0.3rem 0.5rem;
        }

        .dropdown-mega .dropdown-item,
        .submenu a {
            font-size: 13px;
            padding: 8px 12px;
        }
    }

    /* ===== BOOTSTRAP DROPDOWN OVERRIDE ===== */

    /* If using Bootstrap dropdowns */
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

    /* ===== FORCE DROPDOWN TO FRONT (EMERGENCY FIX) ===== */

    /* Emergency z-index fixes */
    .dropdown-menu,
    .mega-menu,
    .submenu,
    .dropdown-mega .mega-menu {
        z-index: 99999 !important;
        position: absolute !important;
    }

    /* Ensure parent containers don't interfere */
    .navbar-nav,
    .category-nav,
    .navbar,
    .container-fluid {
        overflow: visible !important;
    }

    /* Fix for any potential conflicts */
    .dropdown-mega,
    .nav-item.has-submenu {
        z-index: 1001;
    }

    /* ===== SCROLL BAR STYLING FOR CATEGORY NAV ===== */

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
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid px-3" style="margin-left: 7%; margin-right:7%;">
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
                    <a class="btn btn-cta d-sm-none" href="#">Get Started!</a>

                    <?php if (!$usercode): ?>
                        <!-- If not signed in -->
                        <a class="btn btn-sign" href="login.php">Sign In</a>
                    <?php else: ?>
                        <!-- If signed in -->
                        <div class="dropdown">
                            <button class="btn btn-cta dropdown-toggle" type="button" id="profileDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user-circle me-1"></i> Profile
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="user/">My Profile</a></li>


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
        <div class="container-fluid px-3" style="margin-left: 7%; margin-right:7%;">
            <ul class="navbar-nav" id="category-nav"></ul>
        </div>
    </nav>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>