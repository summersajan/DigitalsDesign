<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contact Us • DigitalsDesign</title>
    <meta name="description"
        content="Contact DigitalsDesign.com for product support, custom requests, partnerships, and general inquiries." />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif
        }

        .dd-gradient {
            background: linear-gradient(135deg, #fef7f4 0%, #faece7 100%);
        }

        .rounded-2xl {
            border-radius: 1.25rem
        }

        .shadow-soft {
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08)
        }
    </style>
</head>

<body>

    <!-- Hero -->
    <header class="dd-gradient text-white py-5">
        <div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div>
                <h1 class="display-5 fw-bold mb-2 text-dark">Contact Us</h1>
                <p class="lead mb-0 text-dark">Questions, custom requests, or partnership ideas? We’d love to help.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="index.php" class="btn btn-light fw-semibold shadow-soft rounded-2xl">🏠 Home</a>
            </div>
        </div>
    </header>


    <!-- Contact Section -->
    <section class="py-5">
        <div class="container-xxl">
            <div class="row g-5">

                <div class="col-lg-6">
                    <div class="p-4 p-md-5 bg-light rounded-2xl h-100">
                        <h2 class="h5 fw-bold">Contact details</h2>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li class="mb-2"><strong>Email:</strong> <a href="mailto:support@digitalsdesign.com"
                                    class="text-decoration-none">support@digitalsdesign.com</a></li>
                            <li class="mb-2"><strong>Website:</strong> <a href="https://www.digitalsdesign.com"
                                    class="text-decoration-none">www.digitalsdesign.com</a></li>
                        </ul>
                        <h2 class="h6 fw-semibold">Follow us</h2>
                        <div class="d-flex gap-3">
                            <a href="#" aria-label="Instagram" class="link-dark">Instagram</a>
                            <a href="#" aria-label="Facebook" class="link-dark">Facebook</a>
                            <a href="#" aria-label="Pinterest" class="link-dark">Pinterest</a>
                        </div>
                        <hr class="my-4">
                        <p class="small text-muted mb-0">Response time: within 24–48 business hours.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-5 border-top">
        <div class="container-xxl">
            <h2 class="h4 fw-bold mb-4">Frequently asked questions</h2>
            <div class="accordion" id="faq">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="q1h"><button class="accordion-button" type="button"
                            data-bs-toggle="collapse" data-bs-target="#q1" aria-expanded="true" aria-controls="q1">Do I
                            get instant access after purchase?</button></h2>
                    <div id="q1" class="accordion-collapse collapse show" aria-labelledby="q1h" data-bs-parent="#faq">
                        <div class="accordion-body">Yes. You'll receive a download link immediately after checkout.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="q2h"><button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#q2" aria-expanded="false" aria-controls="q2">Can
                            I use templates for clients?</button></h2>
                    <div id="q2" class="accordion-collapse collapse" aria-labelledby="q2h" data-bs-parent="#faq">
                        <div class="accordion-body">Yes, with an active license. Please review the license terms
                            included with your download.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="q3h"><button class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#q3" aria-expanded="false" aria-controls="q3">Do
                            you offer refunds?</button></h2>
                    <div id="q3" class="accordion-collapse collapse" aria-labelledby="q3h" data-bs-parent="#faq">
                        <div class="accordion-body">Due to the nature of digital products there is no refund.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-white border-top">
        <div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <span class="small">© <span id="year2"></span> DigitalsDesign.com</span>

        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Bootstrap validation + demo submit handler (replace with your backend)
        const form = document.getElementById('contactForm');
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!form.checkValidity()) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }
            // Simulate success
            document.getElementById('formSuccess').classList.remove('d-none');
            form.reset();
            form.classList.remove('was-validated');
        });
        document.getElementById('year2').textContent = new Date().getFullYear();
    </script>
</body>

</html>