<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- BOOTSTRAP 5.3.x CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --primary: #ff5757;
            --primary-light: #e0e7ff;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --danger: #ef4444;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f1f5f9;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* Glass Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.05);
            z-index: 1000;
            transition: transform 0.3s ease;
            transform: translateX(-100%);
        }

        .sidebar-open .sidebar {
            transform: translateX(0);
        }

        .sidebar-header {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--dark);
            text-decoration: none;
        }

        .sidebar-brand span {
            color: var(--primary);
        }

        .user-profile {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.6rem;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .user-info h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark);
        }

        .user-info p {
            margin: 2px 0 0;
            font-size: 0.85rem;
            color: var(--gray);
            word-break: break-all;
        }


        .nav-menu {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.25rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: var(--dark);
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--primary-light);
            color: var(--primary);
        }

        .nav-link .bi {
            font-size: 1.1rem;
        }

        .logout-btn {
            margin: 1rem;
            width: calc(100% - 2rem);
        }

        /* Main Content */
        .main-content {
            margin-left: 0;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .sidebar-open .main-content {
            margin-left: var(--sidebar-width);
        }

        .header {
            height: var(--header-height);
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .menu-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            cursor: pointer;
            padding: 0.5rem;
        }

        .dashboard-container {
            padding: 2rem 1.5rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .sidebar-open .sidebar-overlay {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive */
        @media (min-width: 992px) {
            .sidebar {
                transform: translateX(0);
            }

            .main-content {
                margin-left: var(--sidebar-width);
            }

            .menu-toggle {
                display: none;
            }

            .sidebar-overlay {
                display: none;
            }
        }

        /* Loading Animation */
        .loading-spinner {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            border: 3px solid rgba(79, 70, 229, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Order List Styles */
        .order-list {
            display: grid;
            gap: 1rem;
        }

        .order-card {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            transition: all 0.2s;
        }

        .order-card:hover {
            border-color: var(--primary-light);
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.1);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .order-id {
            font-weight: 600;
            color: var(--primary);
        }

        .order-date {
            color: var(--gray);
            font-size: 0.875rem;
        }

        .order-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-completed {
            background: #ecfdf5;
            color: #059669;
        }

        .status-processing {
            background: #eff6ff;
            color: #2563eb;
        }

        .status-cancelled {
            background: #fef2f2;
            color: #dc2626;
        }

        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .order-total {
            font-weight: 600;
        }

        .view-order {
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .dashboard-section {
            display: none;
        }

        .dashboard-section.active {
            display: block;
        }



        .user-block {
            padding: 32px 0 18px 0;
        }

        .user-block .bi-person {
            background: #f4f6fa;
            color: #ff5757;
            padding: 9px;
            border-radius: 50%;
            font-size: 2rem;
        }
    </style>
</head>

<body>
    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <a class="navbar-brand d-flex align-items-center me-3" href="index.php">

                <a class="navbar-brand d-flex align-items-center" id="logo-div" href="../" style="margin-left: -6%;">
                    <img src="../ic_logo.svg" alt="Gadget Grid logo" style="height:48px;" />
                </a>
            </a>
        </div>


        <div class="user-block text-center w-100 mb-2">
            <div class="mb-2" id="userIcon">
                <i class="bi bi-person"></i>
            </div>
            <div class="fw-bold" id="userName" style="font-size: 1.12em">User</div>
            <div class="text-secondary small" id="userEmail"></div>
        </div>



        <nav class="nav-menu">
            <div class="nav-item">
                <button class="nav-link active" data-section="orders">
                    <i class="bi bi-cart-check"></i>
                    <span>Orders</span>
                </button>
            </div>
            <div class="nav-item">
                <button class="nav-link" data-section="cart">
                    <i class="bi bi-basket"></i>
                    <span>Shopping Cart</span>
                </button>
            </div>

            <div class="nav-item">
                <button class="nav-link" data-section="download">
                    <i class="bi bi-folder"></i>
                    <span>My Files</span>
                </button>
            </div>
            <div class="nav-item">
                <button class="nav-link" data-section="wishlist">
                    <i class="bi bi-heart"></i>
                    <span>Wishlist</span>
                </button>
            </div>
            <div class="nav-item">
                <button class="nav-link" data-section="review">
                    <i class="bi bi-chat-dots"></i>
                    <span>Review</span>
                </button>
            </div>
        </nav>

        <a href="auth/logout.php" class="btn btn-outline-danger logout-btn">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="header">
            <button class="menu-toggle" id="menuToggle">
                <i class="bi bi-list"></i>
            </button>
            <div class="header-actions">

            </div>
        </header>

        <div class="dashboard-container">
            <!-- Orders Section (Loaded First) -->
            <div id="orders" class="dashboard-section active">
                <div class="dashboard-card">
                    <h3 class="section-title">
                        <i class="bi bi-cart-check"></i>
                        Your Orders
                    </h3>
                    <div id="orders-content">
                        <div class="text-center py-5">
                            <div class="loading-spinner"></div>
                            <p class="mt-3 text-muted">Loading your orders...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Sections -->
            <div id="cart" class="dashboard-section">
                <div class="dashboard-card">
                    <h3 class="section-title">
                        <i class="bi bi-basket"></i>
                        Shopping Cart
                    </h3>
                    <div id="cart-content"></div>
                </div>
            </div>


            <div id="download" class="dashboard-section">
                <div class="dashboard-card">
                    <h3 class="section-title">
                        <i class="bi bi-folder"></i>
                        Digital Files
                    </h3>
                    <div id="download-content"></div>
                </div>
            </div>

            <div id="wishlist" class="dashboard-section">
                <div class="dashboard-card">
                    <h3 class="section-title">
                        <i class="bi bi-heart"></i>
                        Wishlist
                    </h3>
                    <div id="wishlist-content"></div>
                </div>
            </div>
            <div id="review" class="dashboard-section">
                <div class="dashboard-card">
                    <h3 class="section-title">
                        <i class="bi bi-chat-dots"></i>
                        Review
                    </h3>
                    <div id="review-content"></div>
                </div>
            </div>


        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Toggle sidebar on mobile
            $('#menuToggle').click(function () {
                $('body').toggleClass('sidebar-open');
            });

            // Close sidebar when clicking overlay
            $('#sidebarOverlay').click(function () {
                $('body').removeClass('sidebar-open');
            });

            // Load user data
            $.get('ajax/get_user_sidebar.php', function (data) {
                console.log('User data:', data);
                try {
                    const parsed = typeof data === 'string' ? JSON.parse(data) : data;

                    $('#userName').text(parsed.name || 'User');
                    $('#userEmail').text(parsed.email || 'user@example.com');
                    if (parsed.initials) {
                        $('#userAvatar').html(parsed.initials);
                    }
                } catch (e) {
                    console.error('Error parsing user data:', e);
                    $('#userName').text('User');
                    $('#userEmail').text('user@example.com');
                }
            });


            // Navigation handling
            $('.nav-link').click(function () {
                // Update active states
                $('.nav-link').removeClass('active');
                $(this).addClass('active');

                // Get section to show
                const section = $(this).data('section');
                $('.dashboard-section').removeClass('active');
                $(`#${section}`).addClass('active');

                // Load content if not already loaded
                if ($(`#${section}-content`).is(':empty')) {
                    loadSection(section);
                }

                // Close sidebar on mobile
                if ($(window).width() < 992) {
                    $('body').removeClass('sidebar-open');
                }
            });


            // Function to load section content
            function loadSection(section) {
                const $content = $(`#${section}-content`);


                // Show loading state
                $content.html(`
                    <div class="text-center py-5">
                        <div class="loading-spinner"></div>
                        <p class="mt-3 text-muted">Loading ${section.replace('_', ' ')}...</p>
                    </div>
                `);

                // Load content via AJAX
                $.get(`ajax/fetch_${section}.php`, function (data) {
                    $content.html(data);
                }).fail(function () {
                    $content.html(`
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                            Failed to load ${section.replace('_', ' ')}. Please try again later.
                        </div>
                    `);
                });
            }

            // Load orders immediately
            loadSection('orders');



        });
    </script>
    <script>
        fetch('ajax/check_session.php')
            .then(response => response.json())
            .then(data => {
                if (data.status !== 'authorized') {
                    window.location.href = '../login.php';
                }
            })
            .catch(error => {
                console.error('Session check failed:', error);
                window.location.href = '../login.php';
            });
    </script>

</body>

</html>