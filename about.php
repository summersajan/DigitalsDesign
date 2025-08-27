<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>About Us • DigitalsDesign</title>
    <meta name="description"
        content="Learn more about DigitalsDesign.com — who we are, our mission, and what we stand for." />
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
                <h1 class="display-5 fw-bold mb-2 text-dark">About Us</h1>
                <p class="lead mb-0 text-dark">Discover who we are, what we do, and why DigitalsDesign exists.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="/" class="btn btn-light fw-semibold shadow-soft rounded-2xl">🏠 Home</a>
            </div>
        </div>
    </header>


    <!-- About Section -->
    <section class="py-5">
        <div class="container-xxl">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="h4 fw-bold mb-3">Our Story</h2>
                    <p class="mb-4">
                        At <strong>DigitalsDesign</strong>, we believe in creating high-quality digital products
                        that inspire creativity, save time, and help people build better online experiences.
                        What started as a small passion project has now grown into a platform trusted by
                        thousands of creators, freelancers, and businesses worldwide.
                    </p>
                    <p>
                        Our mission is simple — to empower designers, entrepreneurs, and content creators
                        with tools that are modern, easy to use, and accessible to everyone.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div class="p-4 p-md-5 bg-light rounded-2xl shadow-soft">
                        <h2 class="h5 fw-bold">What We Value</h2>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li class="mb-2">✔ <strong>Quality:</strong> Every product is carefully crafted with
                                attention to detail.</li>
                            <li class="mb-2">✔ <strong>Innovation:</strong> We constantly adapt to the latest design and
                                tech trends.</li>
                            <li class="mb-2">✔ <strong>Community:</strong> Your feedback drives our growth and
                                improvements.</li>
                            <li class="mb-2">✔ <strong>Support:</strong> We're here to help you every step of the way.
                            </li>
                        </ul>
                        <p class="small text-muted mb-0">Together, we aim to make design resources more accessible to
                            all.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team / Mission -->
    <section class="py-5 border-top">
        <div class="container-xxl text-center">
            <h2 class="h4 fw-bold mb-4">Our Mission</h2>
            <p class="lead mx-auto" style="max-width: 700px;">
                To make digital creativity effortless and accessible by providing innovative templates,
                resources, and tools that fuel imagination and simplify the design process.
            </p>
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
        document.getElementById('year2').textContent = new Date().getFullYear();
    </script>
</body>

</html>