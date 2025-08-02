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
  let cartProductIds = [];
  let cartProductQtys = [];

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
        <img src="${item.image_url || 'https://via.placeholder.com/170'}" alt="${item.title}" class="img-fluid rounded" style="max-width:170px;">
      </td>
      <td class="align-middle">
        <span class="cart-product-name">${item.title}</span>
      </td>
      <td class="align-middle text-end" style="font-size:1.2rem; font-weight:500;">
        <span class="product-price">$${parseFloat(item.price).toFixed(2)}</span>
      </td>
    </tr>
    `;
  }

  function loadCart() {
    $.getJSON('ajax/cart_get.php', function (items) {
      let html = '';
      let subtotal = 0;
      cartProductIds = [];
      cartProductQtys = [];

      const hasItems = Array.isArray(items) && items.length > 0;

      if (!hasItems) {
        $('#cartSection').addClass('d-none');
        $('#cartTotalSection').addClass('d-none');
        $('#emptyCartMessage').removeClass('d-none');
      } else {
        $('#cartSection').removeClass('d-none');
        $('#cartTotalSection').removeClass('d-none');
        $('#emptyCartMessage').addClass('d-none');

        items.forEach(item => {
          subtotal += parseFloat(item.price) * item.quantity;
          html += renderCartItem(item);
          cartProductIds.push(item.product_id);
          cartProductQtys.push(item.quantity);
        });

        $('#cartItems').html(html);
      }

      $('#subtotal').text('$' + subtotal.toFixed(2));
      $('#grandtotal').text('$' + subtotal.toFixed(2));
    }).fail(function (xhr, status, error) {
      console.error("Cart load failed:", error);
      $('#cartSection').addClass('d-none');
      $('#cartTotalSection').addClass('d-none');
      $('#emptyCartMessage').removeClass('d-none').html('<p class="text-danger">Could not load cart.</p>');
    });
  }

  function deleteItem(btn, cart_item_id) {
    if (confirm("Remove this item from your cart?")) {
      const $btn = $(btn);
      $btn.prop("disabled", true).html("Removing...");

      $.post('ajax/cart_delete.php', { cart_item_id })
        .done(function (resp) {
          // Optional: parse JSON if your PHP returns a message
          // const response = JSON.parse(resp);
          location.reload();
        })
        .fail(function () {
          location.reload();
          $btn.prop("disabled", false).html("Remove");
        });
    }
  }


  function startCheckout(buttonId, gateway) {
    if (!cartProductIds.length) {
      alert("Cart is empty!");
      return;
    }

    const $btn = $(`#${buttonId}`);
    const originalText = $btn.html();
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Redirecting...');

    const url = gateway === 'stripe' ? 'ajax/buy_now_stripe.php' : 'ajax/buy_now_paypal.php';

    $.post(url, {
      product_ids: cartProductIds,
      quantities: cartProductQtys
    }, function (data) {
      if (data.checkoutUrl || data.approveUrl) {
        window.location.href = data.checkoutUrl || data.approveUrl;
      } else {
        console.error("Checkout failed:", data);
        alert(data.error || "Checkout failed");
        $btn.prop('disabled', false).html(originalText);
        window.location.href = 'login.php';
      }
    }, 'json').fail(function (xhr) {
      console.error("Checkout failed:", xhr.responseText);
      alert("Checkout error:\n" + xhr.responseText);
      $btn.prop('disabled', false).html(originalText);
    });
  }

  $('#paypalCheckoutBtn').click(() => startCheckout('paypalCheckoutBtn', 'paypal'));
  $('#stripeCheckoutBtn').click(() => startCheckout('stripeCheckoutBtn', 'stripe'));

  $(document).ready(loadCart);
</script>
<script>
  const ITEMS_PER_PAGE = 4;
  let searchPage = 0;
  let currentSearch = "";
  let currentCategory = 0;

  function renderProducts(products, targetSelector, append = false) {
    let html = '';
    products.forEach(function (p) {
      html += `
<div class="col">
  <div class="product-card bg-white">
    <div class="rating"><i class="fa fa-star"></i> ${parseFloat(p.rating || 5).toFixed(1)}</div>
    <img src="${p.image || '../../images/octopus.webp'}" class="product-img" alt="${p.title}">
    <div class="overlay-buttons" data-product-id="${p.product_id}">
      <button class="action-btn wishlist-btn" title="Add to Wishlist"><i class="fa-regular fa-heart"></i></button>
      <button class="action-btn cart-btn" title="Add to Cart"><i class="fa-solid fa-cart-plus"></i></button>
    </div>
    <div class="p-3">
      <a href="product.php?product_id=${p.product_id}"><h6 class="mb-1 fw-semibold">${p.title}</h6></a>
      <small class="text-muted">${p.vendor || ''}</small><br/>
      <span class="text-danger fw-bold">$${parseFloat(p.price).toFixed(2)}</span>
      ${p.old_price ? `<span class="strike">$${parseFloat(p.old_price).toFixed(2)}</span>` : ''}
      ${p.discount ? `<span class="discount">–${p.discount}%</span>` : ''}
    </div>
  </div>
</div>
`;
    });
    if (html === '' && !append) html = '<div class="col">No products yet.</div>';
    if (append) {
      $(targetSelector).append(html);
    } else {
      $(targetSelector).html(html);
    }
  }

  function showCartSections() {
    $('#cartSection').show();
    $('#cartTotalSection').show();
    $('#search-results-section').hide();
    $('#main-search-input').val('');
    $('#search-products-dynamic').empty();
    $('#emptyCartMessage').removeClass('d-none');
  }

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
      renderProducts(resp.products, '#search-products-dynamic', !reset);
      let totalLoaded = (searchPage + 1) * ITEMS_PER_PAGE;
      if (totalLoaded < resp.total) {
        $('#load-more-search-products').show();
      } else {
        $('#load-more-search-products').hide();
      }
    });
  }

  $(function () {
    // Live search as user types in the global search bar
    let searchTimeout = null;
    $('#main-search-input').on('input', function () {
      clearTimeout(searchTimeout);
      let val = $(this).val().trim();
      searchTimeout = setTimeout(function () {
        if (val.length === 0) {

          showCartSections();
        } else {
          currentSearch = val;
          currentCategory = 0;
          searchPage = 0;
          $('#cartSection').hide();
          $('#cartTotalSection').hide();
          $('#search-results-section').show();
          $('#search-title').text('Search: ' + currentSearch);
          fetchAndRenderSearch(true);
        }
      }, 300);
    });

    // "Load More" for search
    $('#load-more-search-products').click(function () {
      searchPage++;
      fetchAndRenderSearch(false);
    });

    // Category nav works just like elsewhere
    $(document).on('click', '#category-nav .nav-link', function (e) {
      e.preventDefault();
      let href = $(this).attr('href');
      let urlParams = new URLSearchParams(href.split('?')[1]);
      let catId = urlParams.get('category_id');
      if (catId) {
        currentCategory = catId;
        currentSearch = "";
        searchPage = 0;
        $('#main-search-input').val('');
        $('#cartSection').hide();
        $('#cartTotalSection').hide();
        $('#search-results-section').show();
        let catName = $(this).text().trim();
        $('#search-title').text('Category: ' + catName);
        fetchAndRenderSearch(true);
      }
    });

    // Clicking the logo resets to the cart
    $(document).on('click', '.navbar-brand', function (e) {
      showCartSections();
    });
  });

</script>


<?php include 'footer.html'; ?>