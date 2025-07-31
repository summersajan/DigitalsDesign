<?php include 'header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
<!-- Quill CDN -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<!-- DataTables CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<style>
  .thumb-preview {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border: 1px solid #ddd;
    border-radius: 6px;
    margin-right: 6px;
    margin-bottom: 6px;
    position: relative;
    cursor: pointer;
  }

  .file-badge {
    background: #edede9;
    padding: 2px 8px;
    border-radius: 5px;
    border: 1px solid #bababa;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.97em;
    margin: 2px;
    position: relative;
    cursor: pointer;
  }

  .remove-file {
    position: absolute;
    top: -8px;
    right: -6px;
    background: #fa3c3c;
    color: #fff;
    border-radius: 99px;
    width: 21px;
    height: 21px;
    line-height: 20px;
    text-align: center;
    font-size: 1rem;
    z-index: 2;
    cursor: pointer;
  }

  .file-preview {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }

  .dragzone {
    border: 2px dashed #aaa !important;
    background: #f8f9fa !important;
  }
</style>

<div class="content-area">
  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0">Manage Products</h3>
      <button class="btn btn-danger shadow" data-bs-toggle="modal" data-bs-target="#prodModal">
        <i class="bi bi-plus-lg"></i> Add Product
      </button>
    </div>
    <div id="prod_msg"></div>
    <div class="card shadow">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle" id="productTable">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Categories</th>
              <th>Price</th>
              <th>Added</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody><!-- JS --></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="prodModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <form id="prod_form" class="modal-content" enctype="multipart/form-data" autocomplete="off" novalidate>
      <div class="modal-header">
        <h5 class="modal-title" id="prodModalLabel">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- First Column -->
          <div class="col-md-6">
            <input type="hidden" name="product_id" id="product_id">
            <div class="mb-3">
              <label for="prod_title" class="form-label">Product Title<span class="text-danger">*</span></label>
              <input type="text" name="title" id="prod_title" class="form-control" required maxlength="190">
              <div class="invalid-feedback">Product title is required.</div>
            </div>

            <div class="mb-3">
              <label for="prod_price" class="form-label">Price* ($)</label>
              <input type="number" step="0.01" min="0" name="price" id="prod_price" class="form-control" required>
              <div class="invalid-feedback">A valid price is required.</div>
            </div>

            <!-- Trending Checkbox, just after price input -->
            <div class="mb-3 form-check">
              <input type="checkbox" name="featured" class="form-check-input" id="prod_featured">
              <label class="form-check-label" for="prod_featured">Trending Product</label>
            </div>

            <div class="mb-3">
              <label>Categories<span class="text-danger">*</span></label>
              <select name="category_ids[]" id="product_category_dropdown" class="form-select" multiple required>
                <!-- Options filled by JS -->
              </select>
            </div>


            <div class="mb-3">
              <label class="form-label">Product Images
                <span class="text-muted fs-6">(jpeg, png, svg, max 6, 5MB each)</span>
              </label>
              <div id="prodImgDrop" class="border p-2 rounded dragzone-area text-center" style="cursor:pointer;">
                <input type="file" name="product_image[]" id="prod_images" class="form-control d-none" multiple
                  accept="image/jpeg,image/png,image/svg+xml">
                <div id="prod_images_preview" class="file-preview mt-2"></div>
                <div class="text-muted small">Drag & drop or click here to select images</div>
              </div>
              <div class="invalid-feedback d-block" id="prod_images_error"></div>
            </div>

            <div class="mb-3">
              <label class="form-label">Digital Files
                <span class="text-muted fs-6">(zip, ai, psd, eps, images; max 6, 15MB each)</span>
              </label>
              <div id="prodFileDrop" class="border p-2 rounded dragzone-area text-center" style="cursor:pointer;">
                <input type="file" name="digital_file[]" id="prod_files" class="form-control d-none" multiple
                  accept=".zip,.jpg,.jpeg,.png,.svg,.ai,.psd,.eps,.webp">
                <div id="prod_files_preview" class="file-preview mt-2"></div>
                <div class="text-muted small">Drag & drop or click here to select files</div>
              </div>
              <div class="invalid-feedback d-block" id="prod_files_error"></div>
            </div>
          </div>

          <!-- Second Column -->
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Description<span class="text-danger">*</span></label>
              <div id="quill_desc"></div>
              <input type="hidden" name="description">
              <div class="invalid-feedback d-block" id="prod_desc_error"></div>
            </div>
            <div class="mb-3">
              <label class="form-label">Additional Info</label>
              <div id="quill_additional"></div>
              <input type="hidden" name="additional_info">
              <div class="invalid-feedback d-block" id="prod_additional_error"></div>
            </div>
          </div>
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
  let selectedImages = [], selectedFiles = [];
  let prodDT;

  // --- Product Table ---
  function loadProductsTable() {
    $.getJSON('ajax/get_products_list.php', function (data) {
      let rows = "";
      if (!data.length) {
        rows = `<tr>
    <td colspan="6" class="text-center text-secondary py-4">
    <i class="bi bi-box-seam fs-2 mb-2 d-block"></i>
    <div>No products found.</div></td></tr>`;
      } else {
        data.forEach(function (prod, i) {
          rows += `<tr>
    <td>${i + 1}</td>
    <td>${prod.title}</td>
    <td>${prod.categories || '-'}</td>
    <td>$${parseFloat(prod.price).toFixed(2)}</td>
    <td>${prod.created_at}</td>
    <td>
      <button class="btn btn-sm btn-warning me-1 editProdBtn" data-id="${prod.product_id}">
        <i class="bi bi-pencil"></i>
      </button>
      <button class="btn btn-sm btn-danger delProdBtn" data-id="${prod.product_id}">
        <i class="bi bi-trash"></i>
      </button>
    </td></tr>`;
        });
      }
      $("#productTable tbody").html(rows);
      if (prodDT) { prodDT.destroy(); prodDT = null; }
      prodDT = $('#productTable').DataTable({
        pageLength: 10,
        lengthMenu: [5, 10, 20, 50, 100],
        order: [[1, 'asc']],
        responsive: true
      });
    });
  }

  // --- Category Dropdown (multi-select!) ---
  function loadProductCategoryDropdown(selected = '') {
    $.get('ajax/get_categories.php', function (html) {
      $('#product_category_dropdown').html(html);
      if (selected) $('#product_category_dropdown').val(selected).trigger('change');
    });
  }

  // --- Product Message ---
  function showProdMsg(type, msg) {
    $('#prod_msg').html(`<div class="alert alert-${type}">${msg}</div>`);
    setTimeout(() => { $('#prod_msg').html('') }, 3500);
  }

  // ---------------  QUILL  -----------------
  let quillDesc, quillAdditional;

  $(function () {
    quillDesc = new Quill('#quill_desc', { theme: 'snow' });
    quillAdditional = new Quill('#quill_additional', { theme: 'snow' });
    loadProductsTable();

    // When opening modal: reset everything and reload categories
    $('#prodModal').on('show.bs.modal', function () {
      if (!$('#product_id').val()) {
        $('#prod_form')[0].reset();
        quillDesc.setContents([]);
        quillAdditional.setContents([]);
        $('#prod_desc_error,#prod_additional_error').text('');
        $('#prod_images_preview,#prod_files_preview,#prod_images_error,#prod_files_error').html('');
        selectedImages = [];
        selectedFiles = [];
        loadProductCategoryDropdown();
        $('#prodModalLabel').text("Add New Product");
      }
    });
  });

  // --- Preview Updaters ---
  function updateImagePreviews() {
    const previews = selectedImages.map((file, idx) => {
      let url = URL.createObjectURL(file);
      return `<span style="position:relative;">
    <span class="remove-file" title="Remove" onclick="removeImage(${idx})">&times;</span>
    <img src="${url}" class="thumb-preview" title="${file.name}">
  </span>`;
    });
    $("#prod_images_preview").html(previews.join(""));
    if (selectedImages.length === 0) $("#prod_images").val('');
  }

  function updateFilePreviews() {
    const previews = selectedFiles.map((file, idx) => {
      if (/^image\//.test(file.type)) {
        let url = URL.createObjectURL(file);
        return `<span style="position:relative;">
      <span class="remove-file" title="Remove" onclick="removeFile(${idx})">&times;</span>
      <img src="${url}" class="thumb-preview" title="${file.name}">
    </span>`;
      } else {
        let ext = file.name.split('.').pop().toUpperCase();
        return `<span style="position:relative;">
      <span class="remove-file" title="Remove" onclick="removeFile(${idx})">&times;</span>
      <span class="file-badge"><i class="bi bi-file-earmark-zip"></i> ${file.name} (${ext})</span>
    </span>`;
      }
    });
    $("#prod_files_preview").html(previews.join(""));
    if (selectedFiles.length === 0) $("#prod_files").val('');
  }

  // --- Remove file/image handlers ---
  window.removeImage = function (idx) {
    selectedImages.splice(idx, 1);
    updateImagePreviews();
  };
  window.removeFile = function (idx) {
    selectedFiles.splice(idx, 1);
    updateFilePreviews();
  };

  // --- File Validation ---
  function fileAlreadyAdded(file, arr) {
    return arr.some(f => f.name === file.name && f.size === file.size && f.type === file.type);
  }
  const imgAllowedTypes = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp', 'image/gif'];
  const fileAllowedTypes = [
    'image/jpeg', 'image/png', 'image/svg+xml', 'image/webp', 'image/gif',
    'application/zip', 'application/x-zip-compressed',
    'application/x-photoshop', 'image/vnd.adobe.photoshop',
    'application/postscript'
  ];
  const imgMaxFiles = 6, imgMaxSize = 5 * 1024 * 1024, fileMaxFiles = 6, fileMaxSize = 15 * 1024 * 1024;

  function validateImages(files) {
    let errors = [];
    Array.from(files).forEach(f => {
      if (selectedImages.length >= imgMaxFiles) {
        errors.push('Max ' + imgMaxFiles + ' images');
      } else if (!imgAllowedTypes.includes(f.type)) {
        errors.push(f.name + ' is not a permitted image.');
      } else if (f.size > imgMaxSize) {
        errors.push(f.name + ' >5MB.');
      } else if (fileAlreadyAdded(f, selectedImages)) {
        errors.push(f.name + ' is already added.');
      } else {
        selectedImages.push(f);
      }
    });
    return errors;
  }

  function validateFiles(files) {
    let errors = [];
    Array.from(files).forEach(f => {
      if (selectedFiles.length >= fileMaxFiles) {
        errors.push('Max ' + fileMaxFiles + ' files.');
      } else if (
        !fileAllowedTypes.includes(f.type) && !/\.(zip|psd|ai|eps)$/i.test(f.name)
      ) {
        errors.push(f.name + ' not allowed.');
      } else if (f.size > fileMaxSize) {
        errors.push(f.name + ' >15MB.');
      } else if (fileAlreadyAdded(f, selectedFiles)) {
        errors.push(f.name + ' is already added.');
      } else {
        selectedFiles.push(f);
      }
    });
    return errors;
  }

  // --- Drag-drop & Input Events ---
  $('#prodImgDrop').on('click', function (e) {
    if (e.target === this) $('#prod_images').trigger('click');
  });
  $('#prodFileDrop').on('click', function (e) {
    if (e.target === this) $('#prod_files').trigger('click');
  });
  $('.dragzone-area').on('dragover', function (e) { e.preventDefault(); e.stopPropagation(); $(this).addClass('dragzone'); });
  $('.dragzone-area').on('dragleave dragend drop', function () { $(this).removeClass('dragzone'); });
  $('#prodImgDrop').on('drop', function (e) {
    e.preventDefault(); e.stopPropagation();
    let errors = validateImages(e.originalEvent.dataTransfer.files);
    updateImagePreviews();
    $("#prod_images_error").html(errors.join('<br>') || '');
  });
  $('#prodFileDrop').on('drop', function (e) {
    e.preventDefault(); e.stopPropagation();
    let errors = validateFiles(e.originalEvent.dataTransfer.files);
    updateFilePreviews();
    $("#prod_files_error").html(errors.join('<br>') || '');
  });
  $("#prod_images").on('change', function () {
    let errors = validateImages(this.files);
    updateImagePreviews();
    $("#prod_images_error").html(errors.join('<br>') || ''); this.value = '';
  });
  $("#prod_files").on('change', function () {
    let errors = validateFiles(this.files);
    updateFilePreviews();
    $("#prod_files_error").html(errors.join('<br>') || ''); this.value = '';
  });

  // --- Form Validation (including file presence!) ---
  function validateFormFields() {
    let err = false;

    // 1. Product Title Validation
    if (!$('#prod_title').val().trim() || $('#prod_title').val().length > 190) {
      $('#prod_title').addClass('is-invalid');
      err = true;
    } else {
      $('#prod_title').removeClass('is-invalid');
    }

    // 2. Price Validation
    let price = parseFloat($('#prod_price').val());
    if (isNaN(price) || price <= 0) {
      $('#prod_price').addClass('is-invalid');
      err = true;
    } else {
      $('#prod_price').removeClass('is-invalid');
    }

    // 3. Category Validation (Multi-select)
    if (!$('#product_category_dropdown').val() || !$('#product_category_dropdown').val().length) {
      $('#product_category_dropdown').addClass('is-invalid');
      err = true;
    } else {
      $('#product_category_dropdown').removeClass('is-invalid');
    }

    // 4. Description Validation (Quill Editor)
    let desc = quillDesc.getText().trim();
    if (desc.length === 0) {
      $('#prod_desc_error').text("Description required");
      err = true;
    } else {
      $('#prod_desc_error').text('');
      $('input[name="description"]').val(quillDesc.root.innerHTML);
    }

    // 5. Additional Info (Optional - just save the content)
    $('input[name="additional_info"]').val(quillAdditional.root.innerHTML);

    // 6. File Validation (FIXED: Handle both Add and Edit modes)
    let product_id = $('#product_id').val();
    let isEditMode = (product_id && product_id !== '');
    let hasExistingFiles = false;

    if (isEditMode) {
      // Count existing images and digital files in the preview areas
      let existingImages = $('#prod_images_preview').find('img').length;
      let existingDigitalFiles = $('#prod_files_preview').find('.file-badge, img').length;
      hasExistingFiles = (existingImages > 0 || existingDigitalFiles > 0);
    }

    // Check file requirements based on mode
    if (!isEditMode) {
      // ADD MODE: Require at least one new file
      if (selectedImages.length === 0 && selectedFiles.length === 0) {
        $('#prod_images_error,#prod_files_error').text("At least one image or digital file is required.");
        err = true;
      } else {
        $('#prod_images_error,#prod_files_error').text('');
      }
    } else {
      // EDIT MODE: Allow existing files OR new files
      if (selectedImages.length === 0 && selectedFiles.length === 0 && !hasExistingFiles) {
        $('#prod_images_error,#prod_files_error').text("At least one image or digital file is required.");
        err = true;
      } else {
        $('#prod_images_error,#prod_files_error').text('');
      }
    }

    return !err;
  }


  // --- Category multi-select handling --- 
  function appendCategoriesToFormData(formData, ids) {
    if (Array.isArray(ids)) {
      ids.forEach(val => formData.append('category_ids[]', val));
    }
  }

  // --- FORM SUBMIT HANDLER ---
  $('#prod_form').submit(function (e) {
    e.preventDefault();
    $('input[name="description"]').val(quillDesc.root.innerHTML);
    $('input[name="additional_info"]').val(quillAdditional.root.innerHTML);

    if (!validateFormFields()) return false;
    let form = this, product_id = $('#product_id').val();
    let formData = new FormData(form);

    // Remove and add files explicitly, in case input fields are empty due to manual append
    formData.delete('product_image[]');
    formData.delete('digital_file[]');
    for (const f of selectedImages) formData.append('product_image[]', f);
    for (const f of selectedFiles) formData.append('digital_file[]', f);

    // Remove and re-add categories (multi-select)
    formData.delete('category_ids[]');
    appendCategoriesToFormData(formData, $('#product_category_dropdown').val());

    let url = product_id ? 'ajax/edit_product.php' : 'ajax/add_product.php';
    $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (res) {
        console.log('Upload response:', res);
        try {
          if (typeof res === 'string') res = JSON.parse(res);
          if (res.success) {
            showProdMsg('success', res.message);
          } else {
            showProdMsg('danger', res.message);
          }
        } catch {
          showProdMsg('danger', 'Upload response parse error.');
        }
        $('#prodModal').modal('hide');
        form.reset();
        quillDesc.setContents([]);
        quillAdditional.setContents([]);
        selectedImages = [];
        selectedFiles = [];
        $('#prod_images_preview,#prod_files_preview').html('');
        loadProductsTable();
      },
      error: function (xhr, status, error) {
        console.error(`Server error: ${xhr.status} ${xhr.statusText}\n${xhr.responseText}`);
        showProdMsg('danger', `Server error: ${xhr.status} ${xhr.statusText}<br><pre>${xhr.responseText}</pre>`);
      }
    });
  });

  // ---- EDIT logic ----
  $(document).on('click', '.editProdBtn', function () {
    let id = $(this).data('id');
    $.getJSON('ajax/get_product.php', { id }, function (prod) {
      $("#product_id").val(prod.product_id);
      $('#prod_form [name="title"]').val(prod.title);
      quillDesc.root.innerHTML = prod.description;
      quillAdditional.root.innerHTML = prod.additional_info || '';
      $('#prod_form [name="price"]').val(prod.price);
      // loadProductCategoryDropdown(prod.category_id || '');
      loadProductCategoryDropdownEdit(prod.category_ids);
      $('#prod_featured').prop('checked', !!(prod.featured && prod.featured !== "0"));

      // Show existing images
      let imgs = (prod.product_images || []).map(img => `
      <span style="position:relative;">
      <span class="remove-file" title="Delete" onclick="deleteExistingImage(${img.image_id}, this)">&times;</span>
      <img src="../${img.image_url}" class="thumb-preview" title="">
      </span>
    `).join('');
      $('#prod_images_preview').html(imgs);

      let files = (prod.digital_files || []).map(file => `
      <span style="position:relative;">
      <span class="remove-file" title="Delete" onclick="deleteExistingFile(${file.file_id}, this)">&times;</span>
      ${/\.(jpg|jpeg|png|gif|svg|webp)$/i.test(file.file_url)
          ? `<img src="../${file.file_url}" class="thumb-preview">`
          : `<span class="file-badge"><i class="bi bi-file-earmark-zip"></i> ${file.file_url.split('/').pop()}</span>`
        }
      </span>
    `).join('');
      $('#prod_files_preview').html(files);

      selectedImages.length = 0; selectedFiles.length = 0;
      $('#prod_images_error, #prod_files_error').text('');
      $('#prodModalLabel').text("Edit Product");
      new bootstrap.Modal(document.getElementById('prodModal')).show();
    });
  });

  window.deleteExistingImage = function (image_id, el) {
    if (!confirm("Remove this image?")) return;
    $.post('ajax/delete_product_image.php', { image_id }, function (res) {
      if (res.trim() === 'ok') $(el).parent().remove();
      else alert("Failed to delete image: " + res);
    });
  };
  window.deleteExistingFile = function (file_id, el) {
    if (!confirm("Remove this file?")) return;
    $.post('ajax/delete_product_file.php', { file_id }, function (res) {
      if (res.trim() === 'ok') $(el).parent().remove();
      else alert("Failed to delete file: " + res);
    });
  };

  // DELETE logic
  $(document).on('click', '.delProdBtn', function () {
    if (confirm("Delete this product?")) {
      $.post('ajax/delete_product.php', { id: $(this).data('id') }, function (res) {
        $('#prod_msg').html('<div class="alert alert-info">' + res + '</div>');
        loadProductsTable();
        setTimeout(() => { $('#prod_msg').html('') }, 3500);
      });
    }
  });

  /** category multi-select handling **/
  function selectCategoryDropdown(selectedIds) {
    if (!selectedIds) return;
    if (typeof selectedIds === 'string') {
      selectedIds = selectedIds.split(',').map(x => x.trim());
    }
    selectedIds = selectedIds.map(x => x.toString());
    $("#product_category_dropdown option").each(function () {
      if (selectedIds.includes($(this).val())) {
        $(this).prop('selected', true);
      } else {
        $(this).prop('selected', false);
      }
    });
  }

  function loadProductCategoryDropdownEdit(selected = []) {
    $.get('ajax/get_categories.php', function (html) {
      $('#product_category_dropdown').html(html);
      setTimeout(() => selectCategoryDropdown(selected), 10);
    });
  }

</script>
<?php include 'footer.php'; ?>