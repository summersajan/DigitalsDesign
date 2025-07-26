<?php include 'header.php'; ?>

<div class="content-area">
  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0">Orders</h3>
      <!-- You might provide a "refresh" or "export" button here -->
    </div>
    <div id="order_msg"></div>
    <div class="card shadow">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle" id="orderTable">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Order ID</th>
              <th>User</th>
              <th>Status</th>
              <th>Total Amount</th>
              <th>Created At</th>
              <th>Updated At</th>
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

  let ordersDT;
  function fillOrderTable(data) {

    let rows = "";

    if (!data || data.length === 0) {
      rows = `<tr>
      <td colspan="9" class="text-center text-secondary py-4">
        <i class="bi bi-credit-card fs-2 mb-2 d-block"></i>
        <div>No Orders found.</div>
      </td>
    </tr>`;
    } else {
      data.forEach(function (o, i) {
        rows += `<tr>
      <td>${i + 1}</td>
      <td>${o.order_id}</td>
      <td>${o.user_name} <small class="text-muted">(${o.user_email})</small></td>
      <td>${o.order_status}</td>
      <td>$${parseFloat(o.total_amount).toFixed(2)}</td>
      <td>${o.created_at}</td>
      <td>${o.updated_at}</td>
    </tr>`;
      });
      $("#orderTable tbody").html(rows);
    }
  }

  function loadOrderTable() {
    $.getJSON("ajax/get_orders.php", function (data) {
      fillOrderTable(data);
      if (!ordersDT) {
        ordersDT = $('#orderTable').DataTable({
          pageLength: 10,
          lengthMenu: [5, 10, 20, 50, 100],
          order: [[1, 'desc']]
        });
      } else {
        ordersDT.clear().rows.add($("#orderTable tbody tr")).draw();
      }
    });
  }
  $(function () { loadOrderTable(); });
</script>
<?php include 'footer.php'; ?>