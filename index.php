<?php include 'header.php'; ?>

<!-- Hero -->
<section class="hero-section" id="hero-section">
    <div class="container">
        <div class="row align-items-center d-flex">
            <div class="col-lg-6">
                <h1 class="display-5 mb-3">
                    Crafts Made
                    <span class="easy-tag">easy</span>
                    <img src="#" class="pencil" alt="" />
                    <br />for Fun and Profit
                </h1>
                <p style="font-size: 1.17rem">
                    Creating beautifully designed crafts doesn't have to be as hard as
                    you think.
                    <span class="text-orange fw-semibold">With one email</span> a week
                    you'll discover
                    <span class="text-link">everything you need</span> to make
                    beautiful things that friends, family and customers rave about.
                    See how over five million people around the world are creating fun
                    art.
                </p>
                <form class="email-signup mt-4">
                    <span class="bi bi-envelope"></span>
                    <input type="email" placeholder="Enter email address" required />
                    <button class="btn btn-signup" type="submit">Sign Up</button>
                </form>
            </div>
            <div class="col-lg-6 text-center">
                <img class="hero-img" src="images/octopus.webp" alt="Cute Octopus" />
            </div>
        </div>
    </div>
</section>
<div style="margin-left: 7%; margin-right: 7%;">


    <!-- Featured Section -->
    <div class="container py-4" id="featured-section">
        <h4 class="fw-bold">Featured Products</h4>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="featured-products-dynamic"></div>
        <div class="text-center my-4">
            <button id="load-more-featured-products" class="btn btn-cta" style="display:none;">Load More</button>
        </div>
    </div>

    <!-- Premium Section -->
    <div class="container py-4" id="premium-section">
        <h4 class="fw-bold">Premium Graphic Design Resources</h4>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="premium-products-dynamic"></div>
        <div class="text-center my-4">
            <button id="load-more-premium-products" class="btn btn-cta" style="display:none;">Load More</button>
        </div>
    </div>

    <!-- Search/Category Results -->


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
</div>

<script>
    const ITEMS_PER_PAGE = 4;
    let featPage = 0, premPage = 0, searchPage = 0;
    let currentSearch = "";
    let currentCategory = 0;
    let searchMode = false;

    // Render product cards
    function renderProducts(products, targetSelector, append = false) {

        if (!Array.isArray(products) || products.length === 0) {
            console.warn('No products to render or invalid data:', products);
            $(targetSelector).html('<div class="col">No products found.</div>');
            return;
        }

        let html = '';
        products.forEach(function (p) {

            html += `
<div class="col">
  <div class="product-card bg-white">
    <div class="rating"><i class="fa fa-star"></i> ${parseFloat(p.rating || 5).toFixed(1)}</div>
    <img src="${p.image || 'images/octopus.webp'}" class="product-img" alt="${p.title}">
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

    // Loaders
    function fetchAndRenderFeatured(reset = false) {
        if (reset) featPage = 0;
        $.getJSON('ajax/get_products.php', {
            offset: featPage * ITEMS_PER_PAGE,
            limit: ITEMS_PER_PAGE,
            featured: 1
        }, function (resp) {
            renderProducts(resp.products, '#featured-products-dynamic', !reset);
            (featPage + 1) * ITEMS_PER_PAGE < resp.total ?
                $('#load-more-featured-products').show() :
                $('#load-more-featured-products').hide();
        });
    }

    function fetchAndRenderPremium(reset = false) {
        if (reset) premPage = 0;
        $.getJSON('ajax/get_products.php', {
            offset: premPage * ITEMS_PER_PAGE,
            limit: ITEMS_PER_PAGE,
            featured: 0
        }, function (resp) {
            renderProducts(resp.products, '#premium-products-dynamic', !reset);
            (premPage + 1) * ITEMS_PER_PAGE < resp.total ?
                $('#load-more-premium-products').show() :
                $('#load-more-premium-products').hide();
        });
    }

    function fetchAndRenderSearch(reset = false) {
        console.log('fetchAndRenderSearch :', currentSearch, 'Category:', currentCategory);
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
            totalLoaded < resp.total ?
                $('#load-more-search-products').show() :
                $('#load-more-search-products').hide();
        });
    }

    // Reset view to main home
    function showMainSections() {
        $('#hero-section, #featured-section, #premium-section').show();
        $('#search-results-section').hide();
        searchMode = false;
        currentSearch = "";
        currentCategory = 0;
        $('#search-products-dynamic').empty();
        $('#main-search-input').val('');
    }

    $(function () {
        fetchAndRenderFeatured(true);
        fetchAndRenderPremium(true);

        // Load More for featured/premium
        $('#load-more-featured-products').click(function () {
            featPage++;
            fetchAndRenderFeatured(false);
        });
        $('#load-more-premium-products').click(function () {
            premPage++;
            fetchAndRenderPremium(false);
        });
        $('#load-more-search-products').click(function () {
            searchPage++;
            fetchAndRenderSearch(false);
        });

        // *** LIVE Search as user types (debounced) ***
        let searchTimeout = null;
        $('#main-search-input').on('input', function () {
            clearTimeout(searchTimeout);
            let val = $(this).val().trim();
            searchTimeout = setTimeout(function () {
                if (val.length === 0) {
                    showMainSections();
                    fetchAndRenderFeatured(true);
                    fetchAndRenderPremium(true);
                    $('#clear-category-btn').hide();
                } else {
                    currentSearch = val;
                    currentCategory = 0; // Clear category when searching by keyword
                    searchPage = 0;
                    $('#hero-section, #featured-section, #premium-section').hide();
                    $('#search-results-section').show();
                    $('#search-title').text('Search: ' + currentSearch);
                    $('#clear-category-btn').hide(); // Only show X when a category is active, not when searching
                    fetchAndRenderSearch(true);
                    searchMode = true;
                }
            }, 300);
        });


        $(document).on('click', '#category-nav .nav-link', function (e) {
            e.preventDefault();
            let href = $(this).attr('href');
            let urlParams = new URLSearchParams(href.split('?')[1]);
            let catId = urlParams.get('category_id');
            if (catId) {
                currentCategory = catId;
                currentCategoryName = $(this).text().trim();
                $('#main-search-input').val('');
                $('#hero-section, #featured-section, #premium-section').hide();
                $('#search-results-section').show();
                $('#search-title').text('Category: ' + currentCategoryName);
                $('#clear-category-btn').show(); // Show the X button when category active
                fetchAndRenderSearch(true);
                searchMode = true;
            }
        });


        // Optional: Click logo to reset site
        $(document).on('click', '.navbar-brand', function (e) {
            showMainSections();
            fetchAndRenderFeatured(true);
            fetchAndRenderPremium(true);
        });
    });
</script>

<script>
    $(function () {
        $.getJSON('ajax/get_products.php', function (products) {
            $('#featured-products-dynamic').html(renderProducts(products, 1));
            $('#premium-products-dynamic').html(renderProducts(products, 0));
        });


    });


</script>

<?php include 'footer.html'; ?>