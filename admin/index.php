<?php include 'header.php'; ?>

<div class="content-area">
  <!-- Your CONTENT goes here, as before -->
  <div class="main-card mb-4">
    <div class="d-flex align-items-center mb-4">
      <i class="bi bi-speedometer2 fs-3 me-2 text-primary"></i>
      <h2 class="fw-bold mb-0" style="font-size: 1.5em">
        Admin Dashboard
      </h2>
    </div>
    <div class="row g-4 mb-4">
      <div class="col-12 col-md-4">
        <div class="bg-light rounded-3 px-3 py-4 text-center">
          <div class="mb-2">
            <i class="bi bi-people text-primary fs-2"></i>
          </div>
          <div class="fs-2 fw-bold" id="userCount">-</div>
          <div class="text-secondary">Total Users</div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="bg-light rounded-3 px-3 py-4 text-center">
          <div class="mb-2">
            <i class="bi bi-box-seam text-primary fs-2"></i>
          </div>
          <div class="fs-2 fw-bold" id="productCount">-</div>
          <div class="text-secondary">Products</div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="bg-light rounded-3 px-3 py-4 text-center">
          <div class="mb-2">
            <i class="bi bi-cart-check text-primary fs-2"></i>
          </div>
          <div class="fs-2 fw-bold" id="orderCount">-</div>
          <div class="text-secondary">Orders</div>
        </div>
      </div>
    </div>

    <!-- Order Cards END -->
  </div>
</div>
<?php include 'footer.php'; ?>