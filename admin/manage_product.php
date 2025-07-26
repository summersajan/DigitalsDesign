<?php include 'header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
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
            <button class="btn btn-success shadow" data-bs-toggle="modal" data-bs-target="#prodModal">
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
<!-- Product Modal -->
<div class="modal fade" id="prodModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form id="prod_form" class="modal-content" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="prodModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="col-md-6">
                        <label for="prod_title" class="form-label">Product Title*</label>
                        <input type="text" name="title" id="prod_title" class="form-control" required maxlength="190">
                    </div>
                    <div class="col-md-6">
                        <label for="prod_price" class="form-label">Price* ($)</label>
                        <input type="number" step="0.01" name="price" id="prod_price" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="col-md-4">
                        <label>Categories*</label>
                        <select name="category_ids[]" id="product_category_dropdown" class="form-select" multiple
                            required>
                            <!-- JS populates -->
                        </select>
                    </div>
                </div>
                <div class="row mt-4 g-3">
                    <div class="col-md-6">
                        <label class="form-label">Product Images <span class="text-muted fs-6">(jpeg, png, svg, max
                                6)</span></label>
                        <div id="prodImgDrop" class="border p-2 rounded dragzone-area" style="cursor:pointer;">
                            <input type="file" name="product_image[]" id="prod_images" class="form-control d-none"
                                multiple accept="image/*">
                            <div id="prod_images_preview" class="file-preview mt-2"></div>
                            <div class="text-muted small">Drag & drop or click here to select images</div>
                        </div>
                        <div class="invalid-feedback d-block" id="prod_images_error"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Digital Files <span class="text-muted fs-6">(images or .zip, max 6
                                files, 15MB
                                each)</span></label>
                        <div id="prodFileDrop" class="border p-2 rounded dragzone-area" style="cursor:pointer;">
                            <input type="file" name="digital_file[]" id="prod_files" class="form-control d-none"
                                multiple accept=".zip,.jpg,.jpeg,.png,.svg,.ai,.psd,.eps">
                            <div id="prod_files_preview" class="file-preview mt-2"></div>
                            <div class="text-muted small">Drag & drop or click here to select files</div>
                        </div>
                        <div class="invalid-feedback d-block" id="prod_files_error"></div>
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

<!-- DataTable and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" />
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>
    let prodDT;
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
    function loadProductCategoryDropdown(selected = []) {
        $.get('ajax/get_categories.php', function (html) {
            $('#product_category_dropdown').html(html);
            if (selected.length) $('#product_category_dropdown').val(selected);
        });
    }

    let selectedImages = [], selectedFiles = [];

    function updateImagePreviews() {
        let previews = selectedImages.map((file, idx) => {
            let url = URL.createObjectURL(file);
            return `<span style="position:relative;">
<span class="remove-file" title="Remove" onclick="removeImage(${idx})">&times;</span>
<img src="${url}" class="thumb-preview" title="${file.name}">
</span>`;
        });
        $("#prod_images_preview").append(previews.join(''));
        if (selectedImages.length === 0) $("#prod_images").val('');
    }
    function updateFilePreviews() {
        let previews = selectedFiles.map((file, idx) => {
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
        $("#prod_files_preview").append(previews.join(''));
        if (selectedFiles.length === 0) $("#prod_files").val('');
    }
    window.removeImage = function (idx) { selectedImages.splice(idx, 1); $("#prod_images_preview").html(''); updateImagePreviews(); }
    window.removeFile = function (idx) { selectedFiles.splice(idx, 1); $("#prod_files_preview").html(''); updateFilePreviews(); }
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
            if (selectedImages.length >= imgMaxFiles) errors.push('Max ' + imgMaxFiles + ' images');
            else if (!imgAllowedTypes.includes(f.type)) errors.push(f.name + ' is not an image.');
            else if (f.size > imgMaxSize) errors.push(f.name + ' >5MB.');
            else selectedImages.push(f);
        });
        return errors;
    }
    function validateFiles(files) {
        let errors = [];
        Array.from(files).forEach(f => {
            if (selectedFiles.length >= fileMaxFiles) errors.push('Max ' + fileMaxFiles + ' files.');
            else if (
                !fileAllowedTypes.includes(f.type) && !/\.(zip|psd|ai|eps)$/i.test(f.name)
            ) errors.push(f.name + ' not allowed.');
            else if (f.size > fileMaxSize) errors.push(f.name + ' >15MB.');
            else selectedFiles.push(f);
        });
        return errors;
    }

    // input triggers
    $("#prod_images").on('change', function () {
        let errors = validateImages(this.files);
        $("#prod_images_preview").html(''); updateImagePreviews();
        $("#prod_images_error").html(errors.join('<br>') || ''); this.value = '';
    });
    $("#prod_files").on('change', function () {
        let errors = validateFiles(this.files);
        $("#prod_files_preview").html(''); updateFilePreviews();
        $("#prod_files_error").html(errors.join('<br>') || ''); this.value = '';
    });
    // DRAG & DROP
    $('.dragzone-area').on('click', function (e) {
        $(this).find('input[type="file"]').trigger('click');
    });
    $('.dragzone-area').on('dragover', function (e) { e.preventDefault(); e.stopPropagation(); $(this).addClass('dragzone'); });
    $('.dragzone-area').on('dragleave dragend', function () { $(this).removeClass('dragzone'); });
    $('#prodImgDrop').on('drop', function (e) {
        e.preventDefault(); e.stopPropagation(); $(this).removeClass('dragzone');
        let errors = validateImages(e.originalEvent.dataTransfer.files);
        $("#prod_images_preview").html(''); updateImagePreviews();
        $("#prod_images_error").html(errors.join('<br>') || '');
    });
    $('#prodFileDrop').on('drop', function (e) {
        e.preventDefault(); e.stopPropagation(); $(this).removeClass('dragzone');
        let errors = validateFiles(e.originalEvent.dataTransfer.files);
        $("#prod_files_preview").html(''); updateFilePreviews();
        $("#prod_files_error").html(errors.join('<br>') || '');
    });

    // --- Add/Edit submit (with all selected files)
    $('#prod_form').submit(function (e) {
        e.preventDefault();
        if ($("#prod_images_error").text() || $("#prod_files_error").text()) return false;
        let form = this, product_id = $('#product_id').val();
        let formData = new FormData(form);
        for (const f of selectedImages) formData.append('product_image[]', f);
        for (const f of selectedFiles) formData.append('digital_file[]', f);
        let url = product_id ? 'ajax/edit_product.php' : 'ajax/add_product.php';
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false, contentType: false,
            success: function (res) {
                $('#prod_msg').html('<div class="alert alert-info">' + res + '</div>');
                $('#prodModal').modal('hide');
                form.reset();
                selectedImages.length = 0; selectedFiles.length = 0;
                $('#prod_images_preview,#prod_files_preview').html('');
                loadProductsTable();
                setTimeout(() => { $('#prod_msg').html('') }, 3500);
            }
        });
    });

    // Edit modal population w/ preview
    $(document).on('click', '.editProdBtn', function () {
        let id = $(this).data('id');
        $.getJSON('ajax/get_product.php', { id }, function (prod) {
            $("#product_id").val(prod.product_id);
            $('#prod_form [name="title"]').val(prod.title);
            $('#prod_form [name="description"]').val(prod.description);
            $('#prod_form [name="price"]').val(prod.price);
            loadProductCategoryDropdown(prod.category_ids || []);
            // Show current images/files
            let imgs = (prod.product_images || []).map(img => `
<span style="position:relative;">
<span class="remove-file" title="Delete" onclick="deleteExistingImage(${img.image_id}, this)">&times;</span>
<img src="${img.image_url}" class="thumb-preview" title="">
</span>
`).join('');
            $('#prod_images_preview').html(imgs);
            let files = (prod.digital_files || []).map(file => `
<span style="position:relative;">
<span class="remove-file" title="Delete" onclick="deleteExistingFile(${file.file_id}, this)">&times;</span>
${/\.(jpg|jpeg|png|gif|svg|webp)$/i.test(file.file_url)
                    ? `<img src="${file.file_url}" class="thumb-preview">`
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

    // Delete logic
    $(document).on('click', '.delProdBtn', function () {
        if (confirm("Delete this product?")) {
            $.post('ajax/delete_product.php', { id: $(this).data('id') }, function (res) {
                $('#prod_msg').html('<div class="alert alert-info">' + res + '</div>');
                loadProductsTable();
                setTimeout(() => { $('#prod_msg').html('') }, 3500);
            });
        }
    });
    $(function () {
        loadProductsTable();
        $('#prodModal').on('show.bs.modal', function () {
            if (!$('#product_id').val()) {
                $('#prod_form')[0].reset();
                $('#prod_images_preview,#prod_files_preview,#prod_images_error,#prod_files_error').html('');
                selectedImages.length = 0; selectedFiles.length = 0;
                loadProductCategoryDropdown();
                $('#prodModalLabel').text("Add New Product");
            }
        });
    });
</script>
<?php include 'footer.php'; ?>