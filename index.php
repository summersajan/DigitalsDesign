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
                <form class="email-signup mt-4 row gx-2 align-items-center">
                    <div class="col-12 col-md-auto d-flex align-items-center mb-2 mb-md-0">
                        <span class="bi bi-envelope me-2 fs-5"></span>
                    </div>
                    <div class="col-12 col-md">
                        <input type="email" class="form-control" placeholder="Enter email address" required />
                    </div>
                    <div class="col-12 col-md-auto mt-2 mt-md-0">
                        <button class="btn btn-signup w-100" type="submit">Sign Up</button>
                    </div>
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
    // Global variables
    const ITEMS_PER_PAGE = 4;
    let featPage = 0, premPage = 0, searchPage = 0;
    let currentSearch = "";
    let currentCategory = 0;
    let currentCategoryName = "";
    let searchMode = false;

    // Render product cards
    function renderProducts(products, targetSelector, append = false) {
        if (!Array.isArray(products) || products.length === 0) {
            console.warn('No products to render or invalid data:', products);
            if (!append) {
                $(targetSelector).html('<div class="col-12 text-center py-5"><p>No products found.</p></div>');
            }
            return;
        }

        let html = '';
        products.forEach(function (p) {
            html += `
        <div class="col">
            <div class="product-card bg-white">
                <div class="rating"><i class="fa fa-star"></i> ${parseFloat(p.rating || 5).toFixed(1)}</div>
                <img src="${p.image || 'images/octopus.webp'}" class="product-img" alt="${p.title}" 
                     onerror="this.src='images/octopus.webp'">
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
            html = '<div class="col-12 text-center py-5"><p>No products available at the moment.</p></div>';
        }

        if (append) {
            $(targetSelector).append(html);
        } else {
            $(targetSelector).html(html);
        }
    }

    // Fetch and render featured products
    function fetchAndRenderFeatured(reset = false) {
        if (reset) featPage = 0;

        $.getJSON('ajax/get_products.php', {
            offset: featPage * ITEMS_PER_PAGE,
            limit: ITEMS_PER_PAGE,
            featured: 1
        }, function (resp) {
            console.log('Featured products loaded:', resp.products?.length || 0);
            renderProducts(resp.products, '#featured-products-dynamic', !reset);

            const totalLoaded = (featPage + 1) * ITEMS_PER_PAGE;
            if (totalLoaded < resp.total) {
                $('#load-more-featured-products').show();
            } else {
                $('#load-more-featured-products').hide();
            }
        }).fail(function (xhr, status, error) {
            console.error('Failed to load featured products:', error);
            if (!reset) {
                $('#featured-products-dynamic').html('<div class="col-12 text-center py-5"><p class="text-danger">Error loading featured products. Please try again.</p></div>');
            }
        });
    }

    // Fetch and render premium products
    function fetchAndRenderPremium(reset = false) {
        if (reset) premPage = 0;

        $.getJSON('ajax/get_products.php', {
            offset: premPage * ITEMS_PER_PAGE,
            limit: ITEMS_PER_PAGE,
            featured: 0
        }, function (resp) {
            console.log('Premium products loaded:', resp.products?.length || 0);
            renderProducts(resp.products, '#premium-products-dynamic', !reset);

            const totalLoaded = (premPage + 1) * ITEMS_PER_PAGE;
            if (totalLoaded < resp.total) {
                $('#load-more-premium-products').show();
            } else {
                $('#load-more-premium-products').hide();
            }
        }).fail(function (xhr, status, error) {
            console.error('Failed to load premium products:', error);
            if (!reset) {
                $('#premium-products-dynamic').html('<div class="col-12 text-center py-5"><p class="text-danger">Error loading premium products. Please try again.</p></div>');
            }
        });
    }

    // Fetch and render search results
    function fetchAndRenderSearch(reset = false) {
        console.log('fetchAndRenderSearch - Search:', currentSearch, 'Category:', currentCategory);

        if (reset) searchPage = 0;

        let params = {
            offset: searchPage * ITEMS_PER_PAGE,
            limit: ITEMS_PER_PAGE
        };

        if (currentSearch) params.search = currentSearch;
        if (currentCategory) params.category_id = currentCategory;

        $.getJSON('ajax/get_products.php', params, function (resp) {
            console.log('Search results loaded:', resp.products?.length || 0);
            renderProducts(resp.products, '#search-products-dynamic', !reset);

            let totalLoaded = (searchPage + 1) * ITEMS_PER_PAGE;
            if (totalLoaded < resp.total) {
                $('#load-more-search-products').show();
            } else {
                $('#load-more-search-products').hide();
            }
        }).fail(function (xhr, status, error) {
            console.error('Failed to load search results:', error);
            if (!reset) {
                $('#search-products-dynamic').html('<div class="col-12 text-center py-5"><p class="text-danger">Error loading search results. Please try again.</p></div>');
            }
        });
    }

    // Reset view to main home sections
    function showMainSections() {
        $('#hero-section, #featured-section, #premium-section').show();
        $('#search-results-section').hide();
        $('#clear-category-btn').hide();
        searchMode = false;
        currentSearch = "";
        currentCategory = 0;
        currentCategoryName = "";
        $('#search-products-dynamic').empty();
        $('#main-search-input, #main-search-input-mobile').val('');
        $('#load-more-search-products').hide();

        // Refresh featured and premium sections
        fetchAndRenderFeatured(true);
        fetchAndRenderPremium(true);
    }

    // Show temporary message
    function showMessage(message, type = 'info') {
        const alertClass = type === 'success' ? 'alert-success' :
            type === 'error' ? 'alert-danger' : 'alert-info';

        const messageHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999;" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;

        // Remove existing messages
        $('.alert').remove();

        // Add message
        $('body').append(messageHtml);

        // Auto remove after 3 seconds
        setTimeout(() => {
            $('.alert').fadeOut(300, function () { $(this).remove(); });
        }, 3000);
    }

    // Document ready
    $(document).ready(function () {
        // Initial load of featured and premium products
        fetchAndRenderFeatured(true);
        fetchAndRenderPremium(true);

        // Load More button handlers
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

        // Live search functionality (debounced)
        let searchTimeout = null;
        $('#main-search-input, #main-search-input-mobile').on('input', function () {
            clearTimeout(searchTimeout);
            let val = $(this).val().trim();

            // Sync both search inputs
            $('#main-search-input, #main-search-input-mobile').val(val);

            searchTimeout = setTimeout(function () {
                if (val.length === 0) {
                    showMainSections();
                } else {
                    currentSearch = val;
                    currentCategory = 0; // Clear category when searching by keyword
                    currentCategoryName = "";
                    searchPage = 0;
                    searchMode = true;
                    $('#hero-section, #featured-section, #premium-section').hide();
                    $('#search-results-section').show();
                    $('#search-title').text('Search: ' + currentSearch);
                    $('#clear-category-btn').hide(); // Only show X for category searches
                    fetchAndRenderSearch(true);
                }
            }, 300);
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
                currentCategoryName = $(this).text().trim();
                currentSearch = "";
                searchPage = 0;
                searchMode = true;
                $('#main-search-input, #main-search-input-mobile').val('');
                $('#hero-section, #featured-section, #premium-section').hide();
                $('#search-results-section').show();
                $('#search-title').text('Category: ' + currentCategoryName);
                $('#clear-category-btn').show(); // Show X button for category searches
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
                // No subcategories - treat as direct category link
                $(this).addClass('mobile-category-direct');
            }
        });

        // Clear category button handler
        $('#clear-category-btn').on('click', function () {
            showMainSections();
        });

        // Logo click to reset to home
        $(document).on('click', '.navbar-brand', function (e) {
            if (searchMode) {
                e.preventDefault();
                showMainSections();
            }
        });

        // Email signup form handler
        $('.email-signup').on('submit', function (e) {
            e.preventDefault();
            const email = $(this).find('input[type="email"]').val();

            if (!email) {
                showMessage('Please enter a valid email address', 'error');
                return;
            }

            // Add your email signup AJAX call here
            showMessage('Thank you for subscribing!', 'success');
            $(this).find('input[type="email"]').val('');
        });

        // Initialize cart count
        updateCartIconCount();
    });

    // Allow clicking outside menu to close all submenus
    $(document).on('click touchstart', function (e) {
        // Close submenus if clicking outside the entire offcanvas menu
        if (!$(e.target).closest('#mobileMenuOffcanvas').length) {
            $('.mobile-category-item').removeClass('show');
            $('.mobile-subcategory-list').slideUp(200);
        }
    });

    // Close submenus when offcanvas is being hidden
    document.addEventListener('DOMContentLoaded', function () {
        const offcanvasElement = document.getElementById('mobileMenuOffcanvas');
        if (offcanvasElement) {
            offcanvasElement.addEventListener('hide.bs.offcanvas', function () {
                $('.mobile-category-item').removeClass('show');
                $('.mobile-subcategory-list').slideUp(200);
            });
        }
    });
</script>

<?php include 'footer.html'; ?>