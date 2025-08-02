<?php include 'header.php'; ?>
<style>
  .table thead th {
    background: #f7f7f7;
  }

  .btn-danger {
    background: #c44536;
    border: none;
  }

  .btn-danger:hover {
    background: #a73729;
  }

  .cart-product-name {
    color: #c44536;
    font-size: 1.3rem;
  }

  .trash-btn {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
  }

  .trash-btn svg {
    transition: fill 0.2s;
  }

  .trash-btn:hover svg {
    fill: #c44536;
  }

  .btn-paypal {
    background-color: #003087;
    color: white;
    border: none;
  }

  .btn-paypal:hover {
    background-color: #001c55;
  }

  .btn-stripe {
    background-color: #635bff;
    color: white;
    border: none;
  }

  .btn-stripe:hover {
    background-color: #3d36d2;
  }
</style>

<div style="margin-left: 7%; margin-right: 7%;">


  <div class="container py-5">
    <div class="row justify-content-center">

      <!-- Cart Table Section -->
      <div class="col-lg-8 mb-4" id="cartSection">
        <div class="border rounded">
          <table class="table mb-0 align-middle" id="cartTable">
            <thead class="table-light">
              <tr>
                <th style="width: 60px">&nbsp;</th>
                <th style="width: 170px">SHOPPING CART</th>
                <th>PRODUCT NAME</th>
                <th style="width: 130px" class="text-end">PRICE</th>
              </tr>
            </thead>
            <tbody id="cartItems">
              <!-- JS will populate this -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Empty Cart Message -->
      <div class="col-lg-8 text-center d-none" id="emptyCartMessage">
        <div class="text-muted my-5">
          <i class="fas fa-shopping-cart fa-3x mb-3"></i>
          <h4>Your cart is empty</h4>
          <p>Add some products to get started</p>
          <a href="index.php" class="btn btn-outline-primary mt-3">Continue Shopping</a>
        </div>
      </div>

      <!-- Totals Section -->
      <div class="col-lg-4" id="cartTotalSection">
        <div class="border rounded">
          <div class="p-3 bg-light fw-bold">CART TOTAL</div>
          <div class="p-3">
            <div class="d-flex justify-content-between mb-2">
              <span>Subtotal</span>
              <span class="fw-bold" id="subtotal">$0.00</span>
            </div>
            <hr />
            <div class="d-flex justify-content-between mb-3">
              <span class="fw-bold">Grand Total</span>
              <span class="fw-bold" id="grandtotal">$0.00</span>
            </div>
            <div class="d-grid gap-2 mt-4">
              <button id="paypalCheckoutBtn" class="btn btn-paypal">
                <i class="fab fa-paypal me-2"></i> Pay with PayPal
              </button>
              <button id="stripeCheckoutBtn" class="btn btn-stripe">
                <i class="fab fa-stripe me-2"></i> Pay with Stripe
              </button>
            </div>
          </div>
        </div>
      </div>

      <div id="search-results-section" class="container py-4" style="display:none;">
        <div class="d-flex align-items-center mb-3">
          <h4 class="fw-bold mb-0" id="search-title"></h4>
          <button type="button" id="clear-category-btn" class="btn btn-sm btn-outline-secondary ms-2"
            title="Clear category" style="display:none;line-height: 1;">
            &times;
          </button>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="search-products-dynamic"></div>
        <div class="text-center my-4">
          <button id="load-more-search-products" class="btn btn-cta" style="display:none;">Load More</button>
        </div>
      </div>




      <div id="emptyCartMessage" class="text-center text-muted d-none">
        <!-- Font Awesome Cart Icon -->
        <i class="fas fa-cart-shopping fa-5x text-muted mb-3"></i>

        <h5>Your cart is empty</h5>
        <p>Looks like you haven’t added anything yet.</p>
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

  // Render individual cart item
  function renderCartItem(item) {
    return `
    <tr class="cart-item" data-id="${item.cart_item_id}">
        <td class="text-center align-middle">
            <button class="trash-btn" onclick="deleteItem(this, ${item.cart_item_id})">
                <svg width="28" height="28" fill="#aaa" viewBox="0 0 24 24">
                    <path d="M10 2v2H4v2h16V4h-6V2h-4zm-6 6h16l-1.5 14h-13L4 8zm4 3v7h2v-7H8zm4 0v7h2v-7h-2z"/>
                </svg>
            </button>
        </td>
        <td>
            <img src="${item.image_url || 'https://via.placeholder.com/170'}" 
                 alt="${item.title}" 
                 class="img-fluid rounded" 
                 style="max-width:170px;" 
                 onerror="this.src='https://via.placeholder.com/170'">
        </td>
        <td class="align-middle">
            <span class="cart-product-name">${item.title}</span>
        </td>
        <td class="align-middle text-end" style="font-size:1.2rem; font-weight:500;">
            <span class="product-price">$${parseFloat(item.price || 0).toFixed(2)}</span>
        </td>
    </tr>`;
  }

  // Load cart items
  function loadCart() {
    $.getJSON('ajax/cart_get.php', function (items) {
      console.log('Cart items loaded:', items);
      let html = '';
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
          html += renderCartItem(item);
          cartProductIds.push(item.product_id);
          cartProductQtys.push(quantity);
        });

        $('#cartItems').html(html);
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
      $('#emptyCartMessage').removeClass('d-none').html('<div class="text-center py-5"><p class="text-danger">Could not load cart. Please refresh the page.</p></div>');
    });
  }

  // Delete cart item
  function deleteItem(btn, cart_item_id) {
    if (!confirm("Remove this item from your cart?")) {
      return;
    }

    const $btn = $(btn);
    const originalHtml = $btn.html();
    $btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');

    $.ajax({
      type: 'POST',
      url: 'ajax/cart_delete.php',
      data: { cart_item_id: cart_item_id },
      dataType: 'json',
      success: function (response) {
        console.log('Delete response:', response);
        // Reload cart instead of full page reload for better UX
        loadCart();
        // Show success message briefly
        showMessage('Item removed from cart', 'success');
      },
      error: function (xhr, status, error) {
        console.error('Delete failed:', error, xhr.responseText);
        // Try to parse error response
        try {
          const errorResponse = JSON.parse(xhr.responseText);
          showMessage(errorResponse.message || 'Failed to remove item', 'error');
        } catch (e) {
          showMessage('Failed to remove item. Please try again.', 'error');
        }
        $btn.prop("disabled", false).html(originalHtml);
      }
    });
  }

  // Show temporary message
  function showMessage(message, type = 'info') {
    const alertClass = type === 'success' ? 'alert-success' :
      type === 'error' ? 'alert-danger' : 'alert-info';

    const messageHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;

    // Remove existing messages
    $('.alert').remove();

    // Add message at top of page
    $('body').prepend(messageHtml);

    // Auto remove after 3 seconds
    setTimeout(() => {
      $('.alert').fadeOut(300, function () { $(this).remove(); });
    }, 3000);
  }

  // Start checkout process
  function startCheckout(buttonId, gateway) {
    if (!cartProductIds.length) {
      showMessage("Your cart is empty!", 'error');
      return;
    }

    const $btn = $(`#${buttonId}`);
    const originalText = $btn.html();
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Processing...');

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
          window.location.href = data.checkoutUrl || data.approveUrl;
        } else if (data.error) {
          showMessage(data.error, 'error');
          $btn.prop('disabled', false).html(originalText);

          // If authentication required, redirect to login
          if (data.error.includes('login') || data.error.includes('authenticate')) {
            setTimeout(() => {
              window.location.href = 'login.php';
            }, 2000);
          }
        } else {
          showMessage("Checkout failed. Please try again.", 'error');
          $btn.prop('disabled', false).html(originalText);
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

        $btn.prop('disabled', false).html(originalText);
      }
    });
  }

  // Render products for search results
  function renderProducts(products, targetSelector, append = false) {
    let html = '';
    products.forEach(function (p) {
      html += `
        <div class="col">
            <div class="product-card bg-white">
                <div class="rating"><i class="fa fa-star"></i> ${parseFloat(p.rating || 5).toFixed(1)}</div>
                <img src="${p.image || '../../images/octopus.webp'}" class="product-img" alt="${p.title}" 
                     onerror="this.src='../../images/octopus.webp'">
                <div class="overlay-buttons" data-product-id="${p.product_id}">
                    <button class="action-btn wishlist-btn" title="Add to Wishlist"><i class="fa-regular fa-heart"></i></button>
                    <button class="action-btn cart-btn" title="Add to Cart"><i class="fa-solid fa-cart-plus"></i></button>
                </div>
                <div class="p-3">
                    <a href="product.php?product_id=${p.product_id}"><h6 class="mb-1 fw-semibold">${p.title}</h6></a>
                    <small class="text-muted">${p.vendor || ''}</small><br/>
                    <span class="text-danger fw-bold">$${parseFloat(p.price || 0).toFixed(2)}</span>
                    ${p.old_price ? `<span class="strike">$${parseFloat(p.old_price).toFixed(2)}</span>` : ''}
                    ${p.discount ? `<span class="discount">–${p.discount}%</span>` : ''}
                </div>
            </div>
        </div>`;
    });

    if (html === '' && !append) {
      html = '<div class="col-12 text-center py-5"><p>No products found.</p></div>';
    }

    if (append) {
      $(targetSelector).append(html);
    } else {
      $(targetSelector).html(html);
    }
  }

  // Show cart sections (hide search)
  function showCartSections() {
    $('#cartSection, #cartTotalSection').show();
    $('#search-results-section').hide();
    $('#main-search-input, #main-search-input-mobile').val('');
    $('#search-products-dynamic').empty();
    $('#load-more-search-products').hide();
    searchMode = false;
    currentSearch = "";
    currentCategory = 0;

    // Reload cart to ensure fresh data
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

      // Sync both search inputs
      $('#main-search-input, #main-search-input-mobile').val(val);

      searchTimeout = setTimeout(function () {
        if (val.length === 0) {
          showCartSections();
        } else {
          currentSearch = val;
          currentCategory = 0;
          searchPage = 0;
          searchMode = true;
          $('#cartSection, #cartTotalSection').hide();
          $('#search-results-section').show();
          $('#search-title').text('Search: ' + currentSearch);
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

      // Remove any active/focus states
      $(this).blur();

      // Handle mobile menu closing if it's a mobile click
      if ($(this).hasClass('mobile-category-direct') || $(this).hasClass('mobile-subcategory-link')) {
        // Store scroll position before closing menu
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Close the offcanvas menu
        const offcanvasElement = document.getElementById('mobileMenuOffcanvas');
        const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
        if (offcanvas) {
          offcanvas.hide();
        }

        // Force cleanup after menu closes
        setTimeout(() => {
          // Remove any backdrop manually
          $('.offcanvas-backdrop').remove();

          // Restore body scroll
          $('body').removeClass('modal-open offcanvas-open')
            .css({
              'overflow': 'auto',
              'position': 'static',
              'padding-right': '0',
              'height': 'auto'
            });

          // Restore scroll position
          window.scrollTo(0, scrollTop);
        }, 100);
      }

      // Get category data
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
        $('#cartSection, #cartTotalSection').hide();
        $('#search-results-section').show();
        let catName = $(this).text().trim();
        $('#search-title').text('Category: ' + catName);
        fetchAndRenderSearch(true);

        // Ensure page is scrollable after content loads (mobile fix)
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
    $(document).on('click', '.mobile-category-link', function (e) {
      // Only prevent default if it's a submenu toggle (has subcategories)
      if ($(this).next('.mobile-subcategory-list').length > 0) {
        e.preventDefault();
        e.stopPropagation();
        toggleMobileSubmenu(this, e);
      } else {
        // If it's a direct category link, add the mobile class for identification
        $(this).addClass('mobile-category-direct');
      }
    });

    // Logo click to reset to cart view
    $(document).on('click', '.navbar-brand', function (e) {
      if (searchMode) {
        e.preventDefault();
        showCartSections();
      }
    });
  });
</script>



<?php include 'footer.html'; ?>