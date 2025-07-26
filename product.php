<?php include 'header.php'; ?>
<?php
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if ($product_id <= 0) {
  echo '<div class="container"><div class="alert alert-danger">Invalid product ID.</div></div>';
  exit;
}
?>
<style>
  .thumb-img {
    height: 70px;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid transparent;
  }

  .thumb-img.active {
    border-color: #c44536;
  }

  .tab-content {
    min-height: 100px;
    margin-top: 20px;
  }

  .buy-btn {
    background: #c44536;
    color: #fff;
    border: none;
  }

  .buy-btn:hover {
    background: #a73729;
  }

  .star {
    color: #f6b800;
    font-size: 1.1rem;
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

  .square-container {
    width: 100%;
    aspect-ratio: 1 / 1;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #fff;
    /* match page background */
    overflow: hidden;
    padding: 0;
  }

  .square-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    display: block;
  }

  .responsive-image {
    width: 100%;
    height: auto;
    /* Reduce height here */
    object-fit: contain;

    display: block;

    /* Optional */
  }
</style>


<div class="container py-4" id="product_id">
  <div class="row g-5" id="product-row">
    <!-- Left: Images -->
    <div class="col-lg-7">
      <div id="product-carousel-wrap"></div>
      <div class="d-flex gap-2 justify-content-start" id="product-thumbs"></div>
    </div>
    <!-- Right: Info -->
    <div class="col-lg-5">
      <h3 id="product-title"></h3>
      <p class="mb-1" id="product-meta"></p>
      <h4 class="text-danger mt-2" id="product-price"></h4>
      <div class="d-flex align-items-center mb-2" id="product-rating"></div>
      <div class="mb-3" id="product-social"></div>

      <div class="d-flex flex-column flex-md-row gap-3 mt-4">
        <button id="buyNowBtn" class="btn btn-success w-100">
          <i class="fas fa-shopping-cart me-2"></i> Buy It Now
        </button>
      </div>


      <div class="border-top pt-3" id="product-additional-info"></div>
    </div>
  </div>
  <!-- Tabs: Description & Comments -->
  <div class="row mt-5">
    <div class="col-lg-8">
      <ul class="nav nav-tabs" id="productTab" role="tablist">
        <li class="nav-item">
          <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button"
            role="tab">Description</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button"
            role="tab">Reviews (<span id="review-count">0</span>)</button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active pt-3" id="desc" role="tabpanel">
          <div id="product-description"></div>
        </div>
        <div class="tab-pane fade pt-3" id="comments" role="tabpanel">
          <div id="product-reviews"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Bootstrap 5 and icons -->
<!-- Search/Category Results -->
<div id="search-results-section" class="container py-4" style="display:none;">
  <h4 class="fw-bold" id="search-title"></h4>
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="search-products-dynamic"></div>
  <div class="text-center my-4">
    <button id="load-more-search-products" class="btn btn-cta" style="display:none;">Load More</button>
  </div>
</div>

<script>
  // Helper: Get product ID from URL
  function getProductId() {
    let params = new URLSearchParams(window.location.search);
    return params.get('product_id');
  }
  // Helper: Render star rating as icons
  function renderStars(rating) {
    let rounded = Math.round(Number(rating) || 5);
    let html = '';
    for (let i = 0; i < 5; ++i) {
      html += '<i class="star bi bi-star' + (i < rounded ? '-fill' : '') + '"></i>';
    }
    return html;
  }
  // Thumbnail switcher (could enhance to click/thumb sync!)
  function setMainImage(el) {
    document.getElementById("mainImage").src = el.src;
    document.querySelectorAll(".thumb-img").forEach((img) => img.classList.remove("active"));
    el.classList.add("active");
  }

  // MAIN: Load Product Info & Reviews
  document.addEventListener('DOMContentLoaded', function () {
    let productId = getProductId();
    if (!productId) return;

    let product_rating = 5; // Default rating if not found
    let wishlist_count = 0;

    fetch('ajax/get_product_reviews.php?product_id=' + encodeURIComponent(productId))
      .then(r => r.json()).then(reviews => {
        document.getElementById('review-count').textContent = reviews.length;
        product_rating = reviews.length > 0
          ? (reviews.reduce((sum, r) => sum + r.rating, 0) / reviews.length).toFixed(1)
          : '5.0'; // Default to 5.0 if no reviews
        document.getElementById('product-reviews').innerHTML =
          reviews.map(r => `
            <div class="mb-4 d-flex">
               <i class="fas fa-user rounded-circle me-3 bg-secondary text-white d-flex justify-content-center align-items-center" 
   style="width: 48px; height: 48px; font-size: 24px;"></i>

                <div>
                  <strong class="d-block">${r.user}</strong>
                  <small class="text-muted d-block mb-1">${r.date}</small>
                  <div class="mb-1">${renderStars(r.rating)}</div>
                  <div>${r.content}</div>
                </div>
            </div>
          `).join('');
      });
    productId = getProductId();

    fetch('ajax/get_wishlist_count.php?product_id=' + encodeURIComponent(productId))
      .then(response => response.json())
      .then(data => {
        wishlist_count = data.count;
        console.log('Wishlist count:', wishlist_count);
        // You can now update the UI or use wishlist_count as needed
      })
      .catch(error => console.error('Error fetching wishlist count:', error));





    // 1. FETCH PRODUCT INFO
    fetch('ajax/get_product_info.php?product_id=' + encodeURIComponent(productId))
      .then(r => r.json()).then(product => {
        console.log('Product data:', product);
        // Carousel
        let carouselHtml = `
  <div id="productCarousel" class="carousel slide mb-3" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner rounded">` +
          product.images.map((img, idx) =>
            `<div class="carousel-item${idx === 0 ? ' active' : ''}">
       <img src="${img}" class="responsive-image" alt="Product Image">

      
        
      </div>`).join('') +
          `</div>
    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>`;

        document.getElementById('product-carousel-wrap').innerHTML = carouselHtml;

        // Thumbnails: setMainImage on click
        document.getElementById('product-thumbs').innerHTML = product.images.map((img, idx) =>
          `<img src="${img}" class="thumb-img rounded border border-2${idx === 0 ? ' active border-danger' : ''}"
                style="height:70px;width:100px;"
                onclick="setMainImage(this)"
                alt="Thumbnail ${idx + 1}">`
        ).join('');


        // Title, Meta, Price
        document.getElementById('product-title').textContent = product.title;
        document.getElementById('product-meta').innerHTML = `By <a href="#" class="text-decoration-none">${product.vendor || ''}</a> in ` +
          product.categories.map(cat => `<span class="text-danger">${cat}</span>`).join(' / ');
        document.getElementById('product-price').innerHTML = '$' + product.price;

        // Rating
        document.getElementById('product-rating').innerHTML =
          `<span class="fs-5 fw-bold">
              ${product.rating ? parseFloat(product_rating).toFixed(1) : '5.0'}
            </span>
            <span class="ms-2">${renderStars(product_rating)}</span>
            <span class="ms-2 text-muted" style="font-size:0.9em;">based on reviews</span>
            <button class="btn btn-outline-secondary ms-auto">
              <i class="bi bi-bookmark"></i>
            </button>
            <span class="ms-2">${wishlist_count}</span>`;

        // Social, Additional Info
        document.getElementById('product-social').innerHTML =
          `<button class="btn btn-sm btn-outline-danger me-2">Save</button>
           <button class="btn btn-sm btn-dark me-2">X Post</button>
           <button class="btn btn-sm btn-primary">Share</button>`;
        document.getElementById('product-additional-info').innerHTML =
          `<h5>Additional Information</h5>
          <p>${product.addional_info}</p>`;

        // Description
        document.getElementById('product-description').innerHTML = product.description;

      });

    // 2. FETCH PRODUCT REVIEWS

  });
</script>

<script>
  $('#buyNowBtn').click(function () {
    const productId = getProductId();
    const $btn = $(this);
    const originalText = $btn.html();

    if (!productId) {
      alert("Product ID is missing.");
      return;
    }


    // Step 1: Check if the product is already in the cart
    $.getJSON('ajax/cart_get.php', function (cartItems) {
      let found = false;

      if (Array.isArray(cartItems)) {
        cartItems.forEach(item => {
          if (item.product_id == productId) found = true;
        });
      }

      if (found) {
        // Product already in cart – go to cart
        window.location.href = 'cart.php';
      } else {
        // Not in cart – add it
        $.ajax({
          type: "POST",
          url: 'ajax/product_action.php',
          data: { action: 'add_to_cart', product_id: productId },
          dataType: "json",
          success: function (resp) {
            if (resp.success) {
              window.location.href = 'cart.php';
            } else {
              alert(resp.message || 'Failed to add to cart.');
              $btn.prop("disabled", false).html(originalText);
              window.location.href = 'login.php'; // Redirect to login if not logged in
            }
          },
          error: function () {
            alert("Error adding product to cart.");
            $btn.prop("disabled", false).html(originalText);
          }
        });
      }
    });
  });


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

  function fetchAndRenderSearch(reset = false) {
    if (reset) searchPage = 0;
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

  function showProductDetails() {
    $('#product_id').show();
    $('#search-results-section').hide();
  }

  // On DOM ready
  $(function () {
    // Live search as user types
    let searchTimeout = null;
    $('#main-search-input').on('input', function () {
      clearTimeout(searchTimeout);
      let val = $(this).val().trim();
      searchTimeout = setTimeout(function () {
        if (val.length === 0) {
          showProductDetails();
        } else {
          currentSearch = val;
          currentCategory = 0;
          searchPage = 0;
          $('#product_id').hide();
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

    // Category click event (category_id in link)
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
        $('#product_id').hide();
        $('#search-results-section').show();
        let catName = $(this).text().trim();
        $('#search-title').text('Category: ' + catName);
        fetchAndRenderSearch(true);
      }
    });

    // Optional: Click logo to reset site
    $(document).on('click', '.navbar-brand', function (e) {
      $('#main-search-input').val('');
      showProductDetails();
    });
  });

</script>
<?php include 'footer.html'; ?>