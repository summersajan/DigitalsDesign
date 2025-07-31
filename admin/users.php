<?php include 'header.php'; ?>

<div class="content-area">



  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Manage Users</h3>
    <button class="btn btn-danger shadow" data-bs-toggle="modal" data-bs-target="#userModal">
      <i class="bi bi-plus-lg"></i> Add User
    </button>
  </div>
  <div id="user_msg"></div>
  <div class="card shadow">
    <div class="card-body table-responsive">
      <table class="table table-hover align-middle" id="userTable">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody><!-- JS generated --></tbody>
      </table>
    </div>
  </div>


  <!-- Modal (Add/Edit User) -->
  <div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" id="user_form">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLabel">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="user_id" id="user_id">
          <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" id="user_password">
            <small class="text-secondary" id="passwordHint" style="display:none">Leave blank to keep
              unchanged</small>
          </div>
          <div class="mb-3">
            <label>Admin?</label>
            <select name="is_admin" class="form-select">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>

  let userTableDT; // DataTable instance

  function fillUserTable(users) {
    let rows = "";
    users.forEach(function (user, i) {
      rows += `<tr>
<td>${i + 1}</td>
<td>${user.name}</td>
<td>${user.email}</td>
<td>${user.is_admin == 1 ? "Admin" : "Customer"}</td>
<td>${user.created_at}</td>
<td>

<button class="btn btn-sm btn-danger delUserBtn" data-id="${user.user_id}">
<i class="bi bi-trash"></i></button>
</td>
</tr>`;
    });
    $("#userTable tbody").html(rows);
  }

  function loadUserTable() {
    $.getJSON("ajax/get_users.php", function (data) {
      fillUserTable(data);

      // Initialize or Re-draw DataTable
      if (!userTableDT) {
        userTableDT = $('#userTable').DataTable({
          pageLength: 10,
          lengthMenu: [5, 10, 20, 50, 100],
          columnDefs: [{ orderable: false, targets: [5] }],
          order: [[1, 'asc']]
        });
      } else {
        userTableDT.clear().rows.add($("#userTable tbody tr")).draw();
      }
    });
  }

  $(function () {
    loadUserTable();

    // Add User Modal
    $('#userModal').on('show.bs.modal', function (evt) {
      $('#user_form')[0].reset();
      $("#user_id").val('');
      $("#passwordHint").hide();
      $("#user_password")[0].required = true;
      $('#userModalLabel').text("Add User");
    });



    // Add/Edit submit
    $('#user_form').submit(function (e) {
      console.log("Form submitted");
      e.preventDefault();
      let form = $(this);
      let formData = form.serialize();
      let url = "ajax/add_user.php";
      $.post(url, formData, function (res) {
        console.log("Response received:", res);
        $("#user_msg").html('<div class="alert alert-info">' + res + '</div>');
        $('#userModal').modal('hide');
        loadUserTable();
        setTimeout(() => { $("#user_msg").html('') }, 3500);
      });
    });

    // Delete user
    $(document).on("click", ".delUserBtn", function () {
      if (confirm("Delete this user?")) {
        $.post("ajax/delete_user.php", { id: $(this).data("id") }, function (res) {
          $("#user_msg").html('<div class="alert alert-info">' + res + '</div>');
          loadUserTable();
          setTimeout(() => { $("#user_msg").html('') }, 3500);
        });
      }
    });
  });
</script>
<?php include 'footer.php'; ?>