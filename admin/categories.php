<?php include 'header.php'; ?>

<div class="content-area">
  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0">Manage Categories</h3>
      <button class="btn btn-danger shadow" data-bs-toggle="modal" data-bs-target="#categoryModal">
        <i class="bi bi-plus-lg"></i> Add Category
      </button>
    </div>

    <div id="cat_msg"></div>

    <div class="card shadow">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle" id="categoryTable">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Parent</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody><!-- JS loads here --></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="catModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="cat_form" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="catModalLabel">Add Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="cat_id" id="cat_id">
        <div class="mb-3">
          <label>Category Name</label>
          <input type="text" name="cat_name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Parent Category</label>
          <select name="parent_id" class="form-select" id="category_dropdown">
            <option value="">None</option>
            <!-- JS fills this -->
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" type="submit">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
  let catDT;

  function loadCategoriesTable() {
    $.getJSON("ajax/get_categories_list.php", function (data) {
      let rows = "", dropdown = '<option value="">None</option>';

      if (data.length === 0) {
        rows = `<tr>
          <td colspan="4" class="text-center text-secondary py-4">
            <i class="bi bi-tags fs-2 mb-2 d-block"></i>
            <div>No categories found.</div>
          </td>
        </tr>`;
      } else {
        data.forEach((cat, i) => {
          rows += `<tr>
            <td>${i + 1}</td>
            <td>${cat.name}</td>
            <td>${cat.parent_name || "-"}</td>
            <td>
              <button class="btn btn-sm btn-warning me-1 editCatBtn" data-id="${cat.category_id}">
                <i class="bi bi-pencil"></i>
              </button>
              <button class="btn btn-sm btn-danger delCatBtn" data-id="${cat.category_id}">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>`;
          dropdown += `<option value="${cat.category_id}">${cat.name}</option>`;
        });
      }

      $("#categoryTable tbody").html(rows);
      $("#category_dropdown").html(dropdown);

      if (catDT) {
        catDT.destroy();
      }

      catDT = $('#categoryTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 20, 50, 100],
        order: [[1, 'asc']],
        responsive: true
      });
    });
  }



  $('#cat_form').submit(function (e) {
    e.preventDefault();
    const url = $('#cat_id').val() ? 'ajax/edit_category.php' : 'ajax/add_category.php';
    $.post(url, $(this).serialize(), function (response) {
      let res = typeof response === 'string' ? JSON.parse(response) : response;
      let type = res.success ? 'success' : 'danger';

      $('#cat_msg').html(`<div class="alert alert-${type}">${res.message}</div>`);
      $('#categoryModal').modal('hide');
      if (res.success) {
        $('#cat_form')[0].reset();
        $('#cat_id').val('');
        $('#catModalLabel').text("Add Category");
        loadCategoriesTable();
      }

      setTimeout(() => $('#cat_msg').html(''), 2500);
    });
  });



  // Load category for edit
  $(document).on('click', '.editCatBtn', function () {
    let cat_id = $(this).data("id");
    $.getJSON("ajax/get_category.php?id=" + cat_id, function (cat) {
      $('#cat_id').val(cat.category_id);
      $('#cat_form [name="cat_name"]').val(cat.name);

      $.getJSON("ajax/get_categories_list.php", function (data) {
        let dropdown = '<option value="">None</option>';
        data.forEach(c => {
          dropdown += `<option value="${c.category_id}">${c.name}</option>`;
        });
        $("#category_dropdown").html(dropdown);
        $('#category_dropdown').val(cat.parent_id || '');
      });

      $('#catModalLabel').text("Edit Category");
      new bootstrap.Modal(document.getElementById('categoryModal')).show();
    });
  });

  // Delete category
  $(document).on('click', '.delCatBtn', function () {
    if (confirm("Are you sure you want to delete this category?")) {
      $.post('ajax/delete_category.php', { id: $(this).data('id') }, function (response) {
        let res = typeof response === 'string' ? JSON.parse(response) : response;
        let type = res.success ? 'success' : 'danger';

        $('#cat_msg').html(`<div class="alert alert-${type}">${res.message}</div>`);
        loadCategoriesTable();
        setTimeout(() => $('#cat_msg').html(''), 3500);
      });
    }
  });

  // Reset form on modal close
  $('#categoryModal').on('hidden.bs.modal', function () {
    $('#cat_form')[0].reset();
    $('#cat_id').val('');
    $('#catModalLabel').text('Add Category');
  });

  // Initial load
  $(function () {
    loadCategoriesTable();
  });
</script>

<?php include 'footer.php'; ?>