<?php
include 'header.php';

?>
<div style="margin-left: 7%; margin-right: 7%;">

    <div class="container py-5">
        <div id="wishlist-container">
            <h2 class="mb-4 text-center">Your Wishlist</h2>
            <div id="wishlist-items" class="row justify-content-center text-center">
                <div class="loader">Loading wishlist...</div>
            </div>
        </div>

        <div id="search-results-section" class="container py-4" style="display:none;">


            <div class="d-flex align-items-center mb-3">
                <h4 class="fw-bold mb-0" id="search-title"></h4>
                <button type="button" id="clear-category-btn" class="btn btn-sm btn-outline-secondary ms-2"
                    title="Clear category" style="line-height: 1;">
                    &times;
                </button>
            </div>


            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="search-products-dynamic">
            </div>



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
<style>
    .wishlist-card img {
        height: 200px;
        object-fit: cover;
    }

    .wishlist-card .card-body {
        display: flex;
        flex-direction: column;
    }

    .wishlist-card .card-footer {
        display: flex;
        justify-content: space-between;
    }

    .empty-wishlist {
        padding: 40px 0;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetchWishlist();

        function fetchWishlist() {
            fetch("ajax/wishlist_data.php")
                .then(res => res.text())
                .then(html => {
                    document.getElementById("wishlist-items").innerHTML = html;
                    attachListeners();
                });
        }

        function attachListeners() {
            document.querySelectorAll(".delete-btn").forEach(btn => {
                btn.addEventListener("click", () => {
                    const id = btn.dataset.id;

                    // Show confirmation prompt
                    const confirmDelete = confirm("Are you sure you want to remove this item from your wishlist?");
                    if (!confirmDelete) return;

                    fetch("ajax/delete_wishlist_item.php", {
                        method: "POST",
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ wishlist_item_id: id })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) fetchWishlist();
                        });
                });
            });


            document.querySelectorAll(".move-btn").forEach(btn => {
                btn.addEventListener("click", () => {
                    const itemId = btn.dataset.id;
                    const productId = btn.dataset.product;
                    var action = 'add_to_cart';

                    $.ajax({
                        type: "POST",
                        url: 'ajax/product_action.php',
                        data: {
                            action: action,
                            product_id: productId,
                            url: 'index.php' // Current page URL
                        },
                        dataType: "json",
                        success: function (resp) {
                            console.log('Response:', resp);
                            if (resp.success) {
                                updateCartIconCount();
                                alert(resp.message || 'Action complete');
                                window.location.href = 'cart.php';
                            } else {
                                console.log('Error:', resp);
                                alert(resp.message || 'Something went wrong');
                                window.location.href = 'login.php';


                            }
                        },
                        error: function (xhr, status, error) {
                            // This runs if the response is not valid JSON or server/network error occurs
                            let msg = "Unexpected error. ";
                            if (xhr.responseText) {
                                msg += "\nServer says: " + xhr.responseText;
                            }
                            alert(msg);
                            console.error('AJAX Error:', status, error, xhr.responseText);
                        }
                    });


                });
            });
        }
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

    function showCartSections() {
        $('#wishlist-container').show();

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
                    $('#wishlist-container').hide();
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
                $('#wishlist-container').hide();
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