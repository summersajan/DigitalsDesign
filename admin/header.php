<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard - DigitalsDesign</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            min-height: 100vh;
            background: #fff;
            font-family: "Poppins", sans-serif;
        }

        .brand {
            font-weight: 700;
            font-size: 1.35rem;
        }

        .brand .highlight {
            color: #ff5757;

        }

        .sidebar {
            background: #fff;
            min-height: 100vh;
            box-shadow: 0 0 25px 0 rgba(99, 102, 241, 0.06);
            border-right: 1px solid #e4e9f1;
        }

        .sidebar .user-block {
            padding: 32px 0 18px 0;
        }

        .sidebar .user-block .bi-person {
            background: #f4f6fa;
            color: #ff5757;
            padding: 9px;
            border-radius: 50%;
            font-size: 2rem;
        }

        .sidebar .nav-link {
            color: #333;
            border-radius: 11px;
            display: flex;
            align-items: center;
            gap: 0.9em;
            font-size: 1rem;
            padding: 0.75em 1em;
            margin: 0.15em 0;
            font-weight: 500;
            transition: background 0.18s;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            color: #ff5757 !important;
            background: #f0eeff;
        }

        .sidebar .logout-btn {
            margin: 1.6em 0 0 0;
            width: 95%;
            color: #f2545b;
            border-color: #f2545b;
            font-weight: 500;
            border-radius: 9px;
            transition: all 0.18s;
        }

        .sidebar .logout-btn:hover {
            background: #ffeaea;
            color: #f2545b;
        }

        .topbar {
            padding: 0.9em 2em 0.9em 2em;
            display: flex;
            align-items: center;
            background: #fff;
            border-bottom: 1px solid #e4e9f1;
            min-height: 62px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .topbar .icon-btn {
            border: 0;
            background: transparent;
            font-size: 1.3em;
            margin-left: 10px;
            color: #444;
        }

        /* Hamburger only visible on mobile */
        .hamburger-btn {
            display: none !important;
            font-size: 1.9em !important;
            margin-right: 15px;
            color: #454092;
            border: none;
            background: none;
        }

        .content-area {
            padding: 1.7em 1.5em 1.5em 1.5em;
            min-height: 75vh;
        }

        .main-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 5px 14px 0 rgba(99, 102, 241, 0.08);
            padding: 2.4em 2em 2em 2em;
            margin-bottom: 2em;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                min-width: 200px;
            }

            .content-area {
                padding: 1em;
            }

            .main-card {
                padding: 1.1em;
            }
        }

        /* Hide sidebar and show hamburger on mobile */
        @media (max-width: 991.98px) {
            .sidebar.static-sidebar {
                display: none !important;
            }

            .topbar .hamburger-btn {
                display: inline-block !important;
            }
        }

        @media (max-width: 767.98px) {
            .sidebar.static-sidebar {
                display: none !important;
            }

            .content-area {
                padding: 0.5em;
            }
        }
    </style>
</head>

<body>
    <div class="row g-0">
        <!-- Sidebar Static (desktop only) -->
        <div class="col-12 col-md-3 col-lg-2 sidebar static-sidebar d-flex flex-column align-items-center px-3">
            <!-- Sidebar CONTENT -->
            <div class="w-100 text-start py-4">
                <span class="brand">Digitals<span class="highlight">Design</span></span>
            </div>

            <div class="user-block text-center w-100 mb-2">
                <div class="mb-2" id="userIcon">
                    <i class="bi bi-person"></i>
                </div>
                <div class="fw-bold" id="userBlockName" style="font-size: 1.12em">Admin</div>
                <div class="text-secondary small" id="userBlockEmail"></div>
            </div>

            <div class="w-100">
                <nav class="nav flex-column w-100 mb-1">
                    <a class="nav-link active" href="index.php
                    "><i class="bi bi-house"></i> Dashboard</a>
                    <a class="nav-link" href="users.php"><i class="bi bi-people"></i> Users</a>
                    <a class="nav-link" href="categories.php"><i class="bi bi-tags"></i> Categories</a>
                    <a class="nav-link" href="products.php"><i class="bi bi-box-seam"></i> Products</a>
                    <a class="nav-link" href="orders.php"><i class="bi bi-cart-check"></i> Orders</a>
                    <a class="nav-link" href="payments.php"><i class="bi bi-credit-card"></i> Payments</a>
                </nav>
                <a href="auth/logout.php" class="btn btn-outline-danger logout-btn w-100 text-decoration-none">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </a>

            </div>
        </div>

        <!-- TOPBAR -->
        <div class="col p-0 d-flex flex-column">
            <div class="topbar d-flex justify-content-between">
                <div>
                    <!-- Hamburger icon just for mobile-offcanvas -->
                    <button class="hamburger-btn d-inline-block d-lg-none" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#mobileSidebar">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                <div>

                </div>
            </div>


            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <!-- DataTables JS -->
            <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

            <script>
                $(function () {
                    // Find all nav links in sidebar and mobile sidebar
                    $('.sidebar .nav-link').each(function () {
                        let linkPage = this.href.split('/').pop();
                        let locPage = window.location.pathname.split('/').pop();
                        // For index.php, handle both '' and 'index.php'
                        if (locPage === "" && linkPage === "index.php") locPage = "index.php";
                        if (linkPage === locPage) {
                            $('.sidebar .nav-link').removeClass('active'); // Remove active from all
                            $(this).addClass('active');
                        }
                    });
                });
            </script>

            <script>
                fetch('ajax/check_session.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.status !== 'authorized') {
                            window.location.href = 'admin_login.php';
                        }
                    })
                    .catch(error => {
                        console.error('Session check failed:', error);
                        window.location.href = 'admin_login.php';
                    });
                $.get('../user/ajax/get_user_sidebar.php', function (data) {
                    try {
                        const parsed = typeof data === 'string' ? JSON.parse(data) : data;

                        // For sidebar user profile
                        $('#userName').text(parsed.name || 'User');
                        $('#userEmail').text(parsed.email || 'user@example.com');
                        if (parsed.initials) {
                            $('#userAvatar').html(parsed.initials);
                        }

                        // For user block
                        $('#userBlockName').text(parsed.name || 'User');
                        $('#userBlockEmail').text(parsed.email || 'user@example.com');
                    } catch (e) {
                        console.error('Error parsing user data:', e);

                        // Fallback
                        $('#userName, #userBlockName').text('User');
                        $('#userEmail, #userBlockEmail').text('user@example.com');
                    }
                });

            </script>