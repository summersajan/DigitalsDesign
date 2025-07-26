<?php include 'header.php'; ?>

<div class="content-area">
  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0">Payments</h3>
    </div>
    <div id="payment_msg"></div>
    <div class="card shadow">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle" id="paymentTable">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Payment ID</th>
              <th>Order ID</th>
              <th>User</th>
              <th>Amount</th>
              <th>Method</th>
              <th>Status</th>
              <th>Paid At</th>
              <th>Transaction ID</th>
            </tr>
          </thead>
          <tbody>
            <!-- js populated -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<script>
  function loadPaymentTable() {
    $.getJSON("ajax/get_payments.php", function (data) {
      let rows = "";
      data.forEach(function (p, i) {
        rows += `<tr>
          <td>${i + 1}</td>
          <td>${p.payment_id}</td>
          <td>${p.order_id}</td>
          <td>${p.user_name} <small class="text-muted">(${p.user_email})</small></td>
          <td>$${parseFloat(p.amount).toFixed(2)}</td>
          <td>${p.payment_method || "-"}</td>
          <td>${p.payment_status}</td>
          <td>${p.paid_at || "-"}</td>
          <td>${p.transaction_id || "-"}</td>
        </tr>`;
      });
      const $table = $("#paymentTable");
      $table.find("tbody").html(rows);

      // Initialize DataTables (destroy if already initialized)
      if ($.fn.DataTable.isDataTable($table)) {
        $table.DataTable().clear().destroy();
      }
      $table.DataTable();
    });
  }

  $(function () {
    loadPaymentTable();
  });
</script>

<?php include 'footer.php'; ?>