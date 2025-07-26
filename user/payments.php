<?php include 'main_header.php'; ?>
<style>
    :root {
        --primary-color: #78cf89;
        --primary-dark: #5bb86d;
        --primary-light: #e8f7eb;
    }

    body {
        font-family: "Poppins", sans-serif;
        color: #333;
        line-height: 1.6;
    }

    .bg-primary {
        background-color: var(--primary-color) !important;
    }

    .text-primary {
        color: var(--primary-color) !important;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .pricing-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .pricing-card.popular {
        border: 2px solid var(--primary-color);
    }

    .popular-badge {
        position: absolute;
        top: -15px;
        right: 20px;
        background-color: var(--primary-color);
        color: white;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 14px;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>


    <!-- Page Content -->
    <div class="container-fluid">
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Choose Your Plan</h2>
                    <p class="lead text-muted">Start free and upgrade as needed</p>
                </div>

                <div class="row g-4">
                    <!-- Standard -->
                    <div class="col-md-4">
                        <div class="pricing-card card h-100">
                            <div class="card-body">
                                <h4 class="fw-bold">Standard</h4>
                                <p class="text-muted">Newbie</p>
                                <h2 class="fw-bold">$1.99</h2>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li><i class="fa fa-check text-success me-2"></i>5 AI Summaries Credit</li>
                                    <li><i class="fa fa-check text-success me-2"></i>5 AI Q&A (50 messages) Credit</li>
                                    <li><i class="fa fa-check text-success me-2"></i>3 True/False Quizzes (up to 20
                                        Questions)</li>
                                    <li><i class="fa fa-check text-success me-2"></i>3 MCQ Quizzes (up to 20 Questions)
                                    </li>
                                    <li><i class="fa fa-check text-success me-2"></i>PDF: Max 5MB, 10 pages</li>
                                    <li><i class="fa fa-times text-danger me-2"></i>Fast API Requests</li>
                                </ul>
                                <button class="btn btn-primary w-100 pay-btn" data-amount="1.99">
                                    Upgrade Now
                                </button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>
    </div>

    <!-- PayPal Payment Script -->
    <script>
        $(document).ready(function () {
            $(".pay-btn").click(function () {
                const button = $(this);
                const originalText = button.html();
                const amount = button.data("amount");

                // Show loading
                button.prop("disabled", true);
                button.html(`<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing...`);

                $.ajax({
                    url: "ajax/paypal_create_payment.php",
                    type: "POST",
                    data: { amount: amount },
                    success: function (response) {

                        const data = JSON.parse(response);
                        if (data.status === "success") {
                            button.prop("disabled", false).html(originalText);
                            window.location.href = data.redirect_url;
                        } else {
                            alert("Error: " + data.message);
                            button.prop("disabled", false).html(originalText);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("AJAX Error:", errorThrown);
                        alert("Payment request failed. Please try again.");
                        button.prop("disabled", false).html(originalText);
                    },
                });
            });
        });

    </script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include 'main_footer.php'; ?>