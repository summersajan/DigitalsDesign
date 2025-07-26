</div>

<!-- Sidebar Offcanvas (Mobile) -->
<div class="offcanvas offcanvas-start sidebar" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header">
        <span class="brand">Digitals<span class="highlight">Product</span></span>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column align-items-center px-3 pt-0">
        <div class="user-block text-center w-100 mb-2">
            <div class="mb-2">
                <i class="bi bi-person"></i>
            </div>
            <div class="fw-bold" style="font-size: 1.12em">Admin</div>
            <div class="text-secondary small">admin@example.com</div>
        </div>
        <nav class="nav flex-column w-100 mb-1">
            <a class="nav-link active" href="admin-dashboard.html"><i class="bi bi-house"></i> Dashboard</a>
            <a class="nav-link" href="users.html"><i class="bi bi-people"></i> Users</a>
            <a class="nav-link" href="categories.html"><i class="bi bi-tags"></i> Categories</a>
            <a class="nav-link" href="products.html"><i class="bi bi-box-seam"></i> Products</a>
            <a class="nav-link" href="orders.html"><i class="bi bi-cart-check"></i> Orders</a>
            <a class="nav-link" href="payments.html"><i class="bi bi-credit-card"></i> Payments</a>
        </nav>
        <button class="btn btn-outline-danger logout-btn mt-4">
            <i class="bi bi-box-arrow-left"></i> Logout
        </button>
    </div>
</div>
</div>

<script>
    // Your AJAX as before
    $(function () {
        $.getJSON("ajax/dashboard_counts.php", function (res) {
            $("#userCount").text(res.users || "-");
            $("#productCount").text(res.products || "-");
            $("#orderCount").text(res.orders || "-");
        });
    });
</script>
</body>

</html>