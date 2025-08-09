<?php include 'header.php'; ?>
<style>
  /* Cart Page Specific Styles - Properly Scoped */

  /* Base container - scoped to avoid header conflicts */
  .cart-page-container {
    margin-left: 7%;
    margin-right: 7%;
  }

  /* Protect header from interference */
  .navbar .custom-container,
  .category-nav .custom-container {
    margin-left: auto !important;
    margin-right: auto !important;
    max-width: 1300px !important;
  }

  /* Cart-specific table styles */
  #cartSection .table thead th,
  .cart-table .table thead th {
    background: #f7f7f7;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  #cartSection .table tbody td,
  .cart-table .table tbody td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
  }

  /* Cart item styles */
  .cart-product-name {
    color: #c44536;
    font-size: 1.1rem;
    font-weight: 500;
    line-height: 1.3;
  }

  .cart-page .product-price {
    color: #333;
    font-weight: 600;
  }

  /* Trash button */
  .cart-page .trash-btn {
    background: none;
    border: none;
    padding: 8px;
    cursor: pointer;
    border-radius: 50%;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .cart-page .trash-btn:hover {
    background-color: rgba(196, 69, 54, 0.1);
  }

  .cart-page .trash-btn svg {
    transition: fill 0.2s;
  }

  .cart-page .trash-btn:hover svg {
    fill: #c44536;
  }

  /* Checkout buttons */
  .btn-paypal {
    background-color: #003087;
    color: white;
    border: none;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
  }

  .btn-paypal:hover {
    background-color: #001c55;
    transform: translateY(-1px);
    color: white;
  }

  .btn-stripe {
    background-color: #635bff;
    color: white;
    border: none;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
  }

  .btn-stripe:hover {
    background-color: #3d36d2;
    transform: translateY(-1px);
    color: white;
  }

  /* Cart total section */
  .cart-total-section {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    height: fit-content;
    position: sticky;
    top: 20px;
  }

  .cart-total-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    color: #495057;
    font-weight: 600;
    padding: 1rem;
    border-radius: 0.5rem 0.5rem 0 0;
    text-align: center;
    border-bottom: 1px solid #dee2e6;
  }

  .cart-total-body {
    padding: 1.5rem;
  }

  /* Empty cart message */
  .empty-cart-container {
    background: #fff;
    border-radius: 0.5rem;
    padding: 3rem 2rem;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  }

  .empty-cart-icon {
    color: #6c757d;
    margin-bottom: 1.5rem;
  }

  .empty-cart-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 1rem;
  }

  .empty-cart-text {
    color: #6c757d;
    margin-bottom: 2rem;
  }

  /* Mobile cart items */
  .mobile-cart-item {
    display: none;
    /* Hidden by default, shown on mobile */
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    padding: 1rem;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  }

  .mobile-cart-item .cart-item-image {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
  }

  .mobile-cart-item .cart-item-details {
    margin-bottom: 1rem;
  }

  .mobile-cart-item .cart-item-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  /* Product images */
  .cart-page .product-image {
    max-width: 120px;
    height: auto;
    border-radius: 0.25rem;
    object-fit: cover;
  }

  /* Loading states */
  .btn-loading {
    position: relative;
    pointer-events: none;
  }

  .btn-loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid transparent;
    border-top-color: currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  /* Search results in cart page */
  .cart-page .search-results-grid {
    margin-top: 2rem;
  }

  .cart-page .product-card {
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    background: #fff;
    overflow: hidden;
  }

  .cart-page .product-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
  }

  .cart-page .product-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .cart-page .rating {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(255, 255, 255, 0.9);
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 500;
  }

  .cart-page .overlay-buttons {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.95);
    display: flex;
    justify-content: space-around;
    padding: 0.5rem;
    transform: translateY(100%);
    transition: transform 0.3s ease;
  }

  .cart-page .product-card:hover .overlay-buttons {
    transform: translateY(0);
  }

  .cart-page .action-btn {
    background: none;
    border: none;
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.3s ease;
    color: #666;
  }

  .cart-page .action-btn:hover {
    background: #ff5757;
    color: white;
  }

  /* Checkout button container */
  .checkout-buttons {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  /* Mobile Responsive Styles */
  @media (max-width: 991.98px) {
    .cart-page-container {
      margin-left: 4%;
      margin-right: 4%;
    }

    .cart-total-section {
      position: static;
      margin-top: 2rem;
    }

    .table-responsive {
      border-radius: 0.5rem;
      overflow: hidden;
    }

    .checkout-buttons .btn {
      font-size: 0.9rem;
      padding: 0.7rem 1.2rem;
    }
  }

  @media (max-width: 767.98px) {
    .cart-page-container {
      margin-left: 2%;
      margin-right: 2%;
    }

    /* Hide desktop table, show mobile cards */
    #cartSection .table-responsive {
      display: none !important;
    }

    .mobile-cart-item {
      display: block !important;
    }

    /* Mobile table adjustments for any remaining tables */
    #cartSection .table thead th {
      font-size: 0.8rem;
      padding: 0.75rem 0.5rem;
    }

    #cartSection .table tbody td {
      padding: 1rem 0.5rem;
    }

    .cart-product-name {
      font-size: 1rem;
    }

    .cart-page .product-image {
      max-width: 100px !important;
    }

    .cart-total-body {
      padding: 1rem;
    }

    .checkout-buttons .btn {
      font-size: 0.85rem;
      padding: 0.6rem 1rem;
    }

    .empty-cart-container {
      padding: 2rem 1rem;
    }

    .cart-page .search-results-grid .col {
      margin-bottom: 1rem;
    }

    /* Mobile alerts */
    .cart-page .alert {
      margin: 0.5rem;
      font-size: 0.9rem;
    }
  }

  @media (max-width: 575.98px) {
    .cart-page-container {
      margin-left: 1%;
      margin-right: 1%;
    }

    .cart-page .product-image {
      max-width: 80px !important;
    }

    .cart-product-name {
      font-size: 0.95rem;
      margin-bottom: 0.5rem;
    }

    .checkout-buttons {
      gap: 0.5rem;
    }

    .checkout-buttons .btn {
      font-size: 0.8rem;
      padding: 0.5rem 0.8rem;
    }

    .empty-cart-container {
      padding: 1.5rem 0.5rem;
    }

    .cart-total-body {
      padding: 1rem 0.75rem;
    }
  }

  /* Ensure header elements are not affected */
  .navbar,
  .navbar *,
  .category-nav,
  .category-nav * {
    /* Reset any potential interference */
  }

  /* Table in navigation should not be affected */
  .navbar .table,
  .category-nav .table {
    background: transparent !important;
  }

  /* Navigation container protection */
  .navbar .container,
  .navbar .container-fluid,
  .category-nav .container,
  .category-nav .container-fluid {
    margin-left: auto !important;
    margin-right: auto !important;
  }
</style>

<div class="custom-container">
  <div class="container-fluid py-4">

    <!-- Page Title -->


    <div class="row">
      <!-- Cart Table Section -->
      <div class="col-12 col-lg-8 mb-4" id="cartSection">
        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
          <table class="table mb-0 bg-white rounded shadow-sm">
            <thead>
              <tr>
                <th style="width: 60px; text-align: center;">Remove</th>
                <th style="width: 220px;">Product</th>
                <th></th>
                <th style="width: 120px;" class="text-end">Price</th>
              </tr>
            </thead>
            <tbody id="cartItems">
              <!-- JS will populate this -->
            </tbody>
          </table>
        </div>

        <!-- Mobile Card View -->
        <div class="d-md-none" id="mobileCartItems">
          <!-- JS will populate mobile cart items here -->
        </div>
      </div>

      <!-- Cart Total Section -->
      <div class="col-12 col-lg-4" id="cartTotalSection">
        <div class="cart-total-section">
          <div class="cart-total-header">
            <h5 class="mb-0">Order Summary</h5>
          </div>
          <div class="cart-total-body">
            <div class="mb-4">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Subtotal</span>
                <span class="fw-bold h6 mb-0" id="subtotal">$0.00</span>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Shipping</span>
                <span class="text-success fw-semibold">Free</span>
              </div>
              <hr>
              <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="fw-bold h5 mb-0">Total</span>
                <span class="fw-bold h5 mb-0 text-primary" id="grandtotal">$0.00</span>
              </div>
            </div>

            <div class="d-grid gap-3 checkout-buttons">
              <button id="paypalCheckoutBtn" class="btn btn-paypal btn-lg">
                <i class="fab fa-paypal me-2"></i>
                <span>Pay with PayPal</span>
              </button>
              <button id="stripeCheckoutBtn" class="btn btn-stripe btn-lg">
                <i class="fab fa-stripe me-2"></i>
                <span>Pay with Stripe</span>
              </button>
            </div>

            <div class="text-center mt-3">
              <small class="text-muted">
                <i class="fas fa-lock me-1"></i>
                Secure SSL encrypted payment
              </small>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty Cart Message -->
      <div class="col-12 d-none" id="emptyCartMessage">
        <div class="empty-cart-container">
          <div class="empty-cart-icon">
            <i class="fas fa-shopping-cart fa-4x"></i>
          </div>
          <h4 class="empty-cart-title">Your cart is empty</h4>
          <p class="empty-cart-text">Looks like you haven't added any items to your cart yet.</p>
          <a href="index.php" class="btn btn-primary btn-lg px-4">
            <i class="fas fa-arrow-left me-2"></i>
            Continue Shopping
          </a>
        </div>
      </div>

      <!-- Search Results Section -->
      <div class="col-12 d-none" id="search-results-section">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h4 class="fw-bold mb-0" id="search-title"></h4>
          <button type="button" id="clear-category-btn" class="btn btn-sm btn-outline-secondary" title="Clear search"
            style="display:none;">
            <i class="fas fa-times"></i>
            <span class="d-none d-sm-inline ms-1">Clear</span>
          </button>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4 search-results-grid"
          id="search-products-dynamic"></div>

        <div class="text-center my-5">
          <button id="load-more-search-products" class="btn btn-outline-primary btn-lg px-4" style="display:none;">
            Load More Products
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Global variables
  const ITEMS_PER_PAGE = 4;
  let searchPage = 0;
  let currentSearch = "";
  let currentCategory = 0;
  let searchMode = false;
  let cartProductIds = [];
  let cartProductQtys = [];

  // Render individual cart item for desktop
  function renderCartItem(item) {
    return `
  <tr class="cart-item" data-id="${item.cart_item_id}">
    <td class="text-center">
      <button class="trash-btn" onclick="deleteItem(this, ${item.cart_item_id})" 
              title="Remove item">
        <svg width="24" height="24" fill="#aaa" viewBox="0 0 24 24">
          <path d="M10 2v2H4v2h16V4h-6V2h-4zm-6 6h16l-1.5 14h-13L4 8zm4 3v7h2v-7H8zm4 0v7h2v-7h-2z"/>
        </svg>
      </button>
    </td>
    <td>
      <img src="${item.image_url || 'https://via.placeholder.com/150'}" 
           alt="${item.title}" 
           class="img-fluid rounded product-image" 
           style="max-width: 120px; height: auto;"
           onerror="this.src='https://via.placeholder.com/150'">
    </td>
    <td>
      <div class="cart-product-name">${item.title}</div>
      <small class="text-muted">${item.vendor || 'Digital Product'}</small>
    </td>
    <td class="text-end">
      <div class="product-price h6 mb-0">$${parseFloat(item.price || 0).toFixed(2)}</div>
    </td>
  </tr>`;
  }

  // Render individual cart item for mobile
  function renderMobileCartItem(item) {
    return `
  <div class="mobile-cart-item" data-id="${item.cart_item_id}">
    <div class="cart-item-image">
      <img src="${item.image_url || 'https://via.placeholder.com/100'}" 
           alt="${item.title}" 
           class="product-image me-3" 
           style="max-width: 80px; height: auto; border-radius: 0.25rem;"
           onerror="this.src='https://via.placeholder.com/100'">
      <div class="flex-grow-1">
        <div class="cart-product-name">${item.title}</div>
        <small class="text-muted d-block">${item.vendor || 'Digital Product'}</small>
      </div>
    </div>
    <div class="cart-item-actions">
      <div class="product-price h6 mb-0">$${parseFloat(item.price || 0).toFixed(2)}</div>
      <button class="trash-btn ms-3" onclick="deleteItem(this, ${item.cart_item_id})" 
              title="Remove item">
        <svg width="20" height="20" fill="#aaa" viewBox="0 0 24 24">
          <path d="M10 2v2H4v2h16V4h-6V2h-4zm-6 6h16l-1.5 14h-13L4 8zm4 3v7h2v-7H8zm4 0v7h2v-7h-2z"/>
        </svg>
      </button>
    </div>
  </div>`;
  }

  // Load cart items
  function loadCart() {
    $.getJSON('ajax/cart_get.php', function (items) {
      console.log('Cart items loaded:', items);
      let desktopHtml = '';
      let mobileHtml = '';
      let subtotal = 0;
      cartProductIds = [];
      cartProductQtys = [];

      const hasItems = Array.isArray(items) && items.length > 0;

      if (!hasItems) {
        $('#cartSection').addClass('d-none');

        $('#cartTotalSection').addClass('d-none');
        $('#emptyCartMessage').removeClass('d-none');
        console.log('Cart is empty');
      } else {
        $('#cartSection').removeClass('d-none');

        $('#cartTotalSection').removeClass('d-none');
        $('#emptyCartMessage').addClass('d-none');

        items.forEach(item => {
          const price = parseFloat(item.price || 0);
          const quantity = parseInt(item.quantity || 1);
          subtotal += price * quantity;

          desktopHtml += renderCartItem(item);
          mobileHtml += renderMobileCartItem(item);

          cartProductIds.push(item.product_id);
          cartProductQtys.push(quantity);
        });

        $('#cartItems').html(desktopHtml);
        $('#mobileCartItems').html(mobileHtml);
        console.log('Cart loaded with', items.length, 'items, subtotal:', subtotal);
      }

      $('#subtotal').text('$' + subtotal.toFixed(2));
      $('#grandtotal').text('$' + subtotal.toFixed(2));

      // Update cart count in header
      updateCartIconCount();

    }).fail(function (xhr, status, error) {
      console.error("Cart load failed:", error, xhr.responseText);
      $('#cartSection').addClass('d-none');

      $('#cartTotalSection').addClass('d-none');
      $('#emptyCartMessage').removeClass('d-none').html(
        '<div class="empty-cart-container">' +
        '<div class="empty-cart-icon"><i class="fas fa-exclamation-triangle fa-3x text-warning"></i></div>' +
        '<h4 class="empty-cart-title text-danger">Error Loading Cart</h4>' +
        '<p class="empty-cart-text">Could not load your cart. Please refresh the page and try again.</p>' +
        '<button onclick="location.reload()" class="btn btn-primary">Refresh Page</button>' +
        '</div>'
      );
    });
  }

  // Delete cart item
  function deleteItem(btn, cart_item_id) {
    if (!confirm("Are you sure you want to remove this item from your cart?")) {
      return;
    }

    const $btn = $(btn);
    const originalHtml = $btn.html();
    $btn.prop("disabled", true).addClass('btn-loading');

    $.ajax({
      type: 'POST',
      url: 'ajax/cart_delete.php',
      data: { cart_item_id: cart_item_id },
      dataType: 'json',
      success: function (response) {
        console.log('Delete response:', response);
        loadCart();
        showMessage('Item removed from cart successfully', 'success');
      },
      error: function (xhr, status, error) {
        console.error('Delete failed:', error, xhr.responseText);
        try {
          const errorResponse = JSON.parse(xhr.responseText);
          showMessage(errorResponse.message || 'Failed to remove item', 'error');
        } catch (e) {
          showMessage('Failed to remove item. Please try again.', 'error');
        }
      },
      complete: function () {
        $btn.prop("disabled", false).removeClass('btn-loading').html(originalHtml);
      }
    });
  }

  // Show temporary message
  function showMessage(message, type = 'info') {
    const alertClass = type === 'success' ? 'alert-success' :
      type === 'error' ? 'alert-danger' : 'alert-info';

    const icon = type === 'success' ? 'fas fa-check-circle' :
      type === 'error' ? 'fas fa-exclamation-circle' : 'fas fa-info-circle';

    const messageHtml = `
    <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
         style="top: 20px; right: 20px; z-index: 9999; max-width: 400px;" role="alert">
      <i class="${icon} me-2"></i>${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;

    $('.alert').remove();
    $('body').append(messageHtml);

    setTimeout(() => {
      $('.alert').fadeOut(300, function () { $(this).remove(); });
    }, 4000);
  }

  // Start checkout process
  function startCheckout(buttonId, gateway) {
    if (!cartProductIds.length) {
      showMessage("Your cart is empty! Please add some items before checkout.", 'error');
      return;
    }

    const $btn = $(`#${buttonId}`);
    const originalText = $btn.html();
    const processingText = gateway === 'paypal' ? 'Processing PayPal...' : 'Processing Stripe...';

    $btn.prop('disabled', true).html(`
    <span class="spinner-border spinner-border-sm me-2"></span>
    ${processingText}
  `);

    const url = gateway === 'stripe' ? 'ajax/buy_now_stripe.php' : 'ajax/buy_now_paypal.php';

    $.ajax({
      type: 'POST',
      url: url,
      data: {
        product_ids: cartProductIds,
        quantities: cartProductQtys
      },
      dataType: 'json',
      success: function (data) {
        console.log('Checkout response:', data);

        if (data.checkoutUrl || data.approveUrl) {
          showMessage(`Redirecting to ${gateway}...`, 'success');
          setTimeout(() => {
            window.location.href = data.checkoutUrl || data.approveUrl;
          }, 1000);
        } else if (data.error) {
          showMessage(data.error, 'error');
          if (data.error.includes('login') || data.error.includes('authenticate')) {
            setTimeout(() => {
              window.location.href = 'login.php';
            }, 2000);
          }
        } else {
          showMessage("Checkout failed. Please try again.", 'error');
        }
      },
      error: function (xhr, status, error) {
        console.error("Checkout failed:", error, xhr.responseText);

        try {
          const errorResponse = JSON.parse(xhr.responseText);
          showMessage(errorResponse.message || "Checkout error occurred", 'error');
        } catch (e) {
          if (xhr.status === 401) {
            showMessage("Please log in to continue", 'error');
            setTimeout(() => {
              window.location.href = 'login.php';
            }, 2000);
          } else {
            showMessage("Checkout error occurred. Please try again.", 'error');
          }
        }
      },
      complete: function () {
        setTimeout(() => {
          $btn.prop('disabled', false).html(originalText);
        }, 2000);
      }
    });
  }

  // Render products for search results
  function renderProducts(products, targetSelector, append = false) {
    if (!Array.isArray(products) || products.length === 0) {
      if (!append) {
        $(targetSelector).html('<div class="col-12 text-center py-5"><p class="text-muted">No products found.</p></div>');
      }
      return;
    }

    let html = '';
    products.forEach(function (p) {
      html += `
    <div class="col">
      <div class="product-card bg-white h-100 shadow-sm">
        <div class="rating">
          <i class="fa fa-star text-warning"></i> 
          ${parseFloat(p.rating || 5).toFixed(1)}
        </div>
        <img src="${p.image || 'images/octopus.webp'}" 
             class="product-img" 
             alt="${p.title}" 
             onerror="this.src='images/octopus.webp'">
        <div class="overlay-buttons" data-product-id="${p.product_id}">
          <button class="action-btn wishlist-btn" title="Add to Wishlist">
            <i class="fa-regular fa-heart"></i>
          </button>
          <button class="action-btn cart-btn" title="Add to Cart">
            <i class="fa-solid fa-cart-plus"></i>
          </button>
        </div>
        <div class="p-3">
          <a href="product.php?product_id=${p.product_id}" class="text-decoration-none">
            <h6 class="mb-2 fw-semibold text-dark">${p.title}</h6>
          </a>
          <small class="text-muted d-block mb-2">${p.vendor || 'Digital Product'}</small>
          <div class="d-flex align-items-center">
            <span class="text-primary fw-bold h6 mb-0">$${parseFloat(p.price || 0).toFixed(2)}</span>
            ${p.old_price ? `<span class="text-muted text-decoration-line-through ms-2 small">$${parseFloat(p.old_price).toFixed(2)}</span>` : ''}
            ${p.discount ? `<span class="badge bg-danger ms-2 small">${p.discount}% OFF</span>` : ''}
          </div>
        </div>
      </div>
    </div>`;
    });

    if (append) {
      $(targetSelector).append(html);
    } else {
      $(targetSelector).html(html);
    }
  }

  // Show cart sections (hide search)
  function showCartSections() {
    $('#cartSection, #cartTotalSection').removeClass('d-none').show();
    $('#search-results-section').hide().addClass('d-none');
    $('#main-search-input, #main-search-input-mobile').val('');
    $('#search-products-dynamic').empty();
    $('#load-more-search-products').hide();
    searchMode = false;
    currentSearch = "";
    currentCategory = 0;
    loadCart();
  }

  // Fetch and render search results
  function fetchAndRenderSearch(reset = false) {
    $('#emptyCartMessage').addClass('d-none');

    if (reset) {
      searchPage = 0;
    }

    let params = {
      offset: searchPage * ITEMS_PER_PAGE,
      limit: ITEMS_PER_PAGE
    };

    if (currentSearch) params.search = currentSearch;
    if (currentCategory) params.category_id = currentCategory;

    $.getJSON('ajax/get_products.php', params, function (resp) {
      console.log('Search results:', resp);
      renderProducts(resp.products, '#search-products-dynamic', !reset);

      let totalLoaded = (searchPage + 1) * ITEMS_PER_PAGE;
      if (totalLoaded < resp.total) {
        $('#load-more-search-products').show();
      } else {
        $('#load-more-search-products').hide();
      }
    }).fail(function (xhr, status, error) {
      console.error('Search failed:', error);
      if (!reset) {
        $('#search-products-dynamic').html('<div class="col-12 text-center py-5"><p class="text-danger">Error loading products. Please try again.</p></div>');
      }
    });
  }

  // Update cart icon count
  function updateCartIconCount() {
    const count = cartProductIds.length;
    $('#cartCountBadge, #cartCountBadgeMobile').each(function () {
      $(this).text(count);
      if (count > 0) {
        $(this).css('color', '#dc3545');
      } else {
        $(this).css('color', '#aaa');
      }
    });
  }

  // Document ready
  $(document).ready(function () {
    // Initialize cart
    loadCart();

    // Checkout button handlers
    $('#paypalCheckoutBtn').click(() => startCheckout('paypalCheckoutBtn', 'paypal'));
    $('#stripeCheckoutBtn').click(() => startCheckout('stripeCheckoutBtn', 'stripe'));

    // Live search functionality
    let searchTimeout = null;
    $('#main-search-input, #main-search-input-mobile').on('input', function () {
      clearTimeout(searchTimeout);
      let val = $(this).val().trim();

      $('#main-search-input, #main-search-input-mobile').val(val);

      searchTimeout = setTimeout(function () {
        if (val.length === 0) {
          showCartSections();
        } else {
          currentSearch = val;
          currentCategory = 0;
          searchPage = 0;
          searchMode = true;
          $('#cartSection, #cartTotalSection').addClass('d-none').hide();
          $('#search-results-section').removeClass('d-none').show();
          $('#search-title').text('Search Results: "' + currentSearch + '"');
          fetchAndRenderSearch(true);
        }
      }, 300);
    });

    // Load more search results
    $('#load-more-search-products').click(function () {
      searchPage++;
      fetchAndRenderSearch(false);
    });

    // Combined desktop and mobile category click handler
    $(document).on('click', '#category-nav .nav-link, .mobile-category-direct, .mobile-subcategory-link', function (e) {
      e.preventDefault();
      e.stopPropagation();

      $(this).blur();

      // Handle mobile menu closing
      if ($(this).hasClass('mobile-category-direct') || $(this).hasClass('mobile-subcategory-link')) {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        const offcanvasElement = document.getElementById('mobileMenuOffcanvas');
        const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
        if (offcanvas) {
          offcanvas.hide();
        }

        setTimeout(() => {
          $('.offcanvas-backdrop').remove();
          $('body').removeClass('modal-open offcanvas-open').css({
            'overflow': 'auto',
            'position': 'static',
            'padding-right': '0',
            'height': 'auto'
          });
          window.scrollTo(0, scrollTop);
        }, 100);
      }

      let href = $(this).attr('href');
      if (!href || href === '#') return;

      let urlParams = new URLSearchParams((href.split('?')[1] || ''));
      let catId = urlParams.get('category_id');

      if (catId) {
        currentCategory = catId;
        currentSearch = "";
        searchPage = 0;
        searchMode = true;
        $('#main-search-input, #main-search-input-mobile').val('');
        $('#cartSection, #cartTotalSection').addClass('d-none').hide();
        $('#search-results-section').removeClass('d-none').show();
        let catName = $(this).text().trim();
        $('#search-title').text('Category: ' + catName);
        fetchAndRenderSearch(true);

        if (window.innerWidth < 992) {
          setTimeout(() => {
            $('body, html').css('overflow', 'auto');
            if ($('#search-results-section').length) {
              $('html, body').animate({
                scrollTop: $('#search-results-section').offset().top - 100
              }, 300);
            }
          }, 200);
        }
      }
    });

    // Handle mobile submenu toggle
    // Replace the existing mobile category click handler with this fixed version
    $(document).on('click', '.mobile-category-link', function (e) {
      const $submenu = $(this).next('.mobile-subcategory-list');

      if ($submenu.length > 0) {
        // Has subcategories - toggle submenu
        e.preventDefault();
        e.stopPropagation();

        const $item = $(this).closest('.mobile-category-item');
        const isCurrentlyOpen = $item.hasClass('show');

        // Close all other open submenus first
        $('.mobile-category-item').not($item).removeClass('show');
        $('.mobile-subcategory-list').not($submenu).slideUp(200);

        // Toggle current submenu
        if (isCurrentlyOpen) {
          $item.removeClass('show');
          $submenu.slideUp(200);
        } else {
          $item.addClass('show');
          $submenu.slideDown(200);
        }
      } else {
        // No subcategories - treat as direct category link and allow navigation
        // Don't prevent default here, let it navigate
        $(this).addClass('mobile-category-direct');
        // The existing category handler will process this
      }
    });


    // Logo click to reset to cart view
    $(document).on('click', '.navbar-brand', function (e) {
      if (searchMode) {
        e.preventDefault();
        showCartSections();
      }
    });

    // Clear search button
    $('#clear-category-btn').on('click', function () {
      showCartSections();
    });
  });

  // Close mobile submenus when clicking outside
  $(document).on('click touchstart', function (e) {
    if (!$(e.target).closest('#mobileMenuOffcanvas').length) {
      $('.mobile-category-item').removeClass('show');
      $('.mobile-subcategory-list').slideUp(200);
    }
  });

  // Handle offcanvas events
  document.addEventListener('DOMContentLoaded', function () {
    const offcanvasElement = document.getElementById('mobileMenuOffcanvas');
    if (offcanvasElement) {
      offcanvasElement.addEventListener('hide.bs.offcanvas', function () {
        $('.mobile-category-item').removeClass('show');
        $('.mobile-subcategory-list').slideUp(200);
      });
    }
  });
  // Update the renderMobileMenu function


</script>


<?php include 'footer.html'; ?>