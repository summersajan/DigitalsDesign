<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Terms and Conditions • DigitalsDesign</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .dd-gradient {
            background: linear-gradient(135deg, #fef7f4 0%, #faece7 100%);
        }


        .rounded-2xl {
            border-radius: 1.25rem;
        }

        .shadow-soft {
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .container-xxl {
            max-width: 900px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="dd-gradient text-white py-5">
        <div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div>
                <h1 class="display-5 fw-bold mb-2 text-dark">Terms & Conditions</h1>
                <p class="lead mb-0 text-dark">Please read these terms carefully before using DigitalsDesign.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="/" class="btn btn-light fw-semibold shadow-soft rounded-2xl">🏠 Home</a>
            </div>
        </div>
    </header>

    <!-- Terms Content -->
    <section class="py-5">
        <div class="container-xxl bg-white p-4 p-md-5 rounded-2xl shadow-soft">
            <p><strong>Last updated:</strong> July 30, 2025</p>

            <p>Welcome to DigitalsDesign.Com (“we,” “our,” or “us”). By accessing or using our website, you agree to be
                bound by these Terms and Conditions. Please read them carefully before using our services.</p>

            <h2 class="h5 mt-4">1. Digital Products</h2>
            <p>DigitalsDesign.Com sells downloadable digital products including PDFs, educational materials, templates,
                and
                productivity tools. Once a product is purchased, it is available for download and is non-refundable.</p>

            <h2 class="h5 mt-4">2. License & Usage</h2>
            <p>All digital products are for personal or internal business use only, unless explicitly stated otherwise.
                Redistribution, resale, or modification for resale purposes is strictly prohibited without written
                consent.</p>

            <h2 class="h5 mt-4">3. Account Responsibility</h2>
            <p>You are responsible for maintaining the confidentiality of your account credentials and for all
                activities
                under your account. You agree to notify us immediately of any unauthorized use.</p>

            <h2 class="h5 mt-4">4. Payments</h2>
            <p>All payments are processed securely via our trusted third-party payment providers. Prices are listed in
                your local currency or USD, and may change at our discretion.</p>

            <h2 class="h5 mt-4">5. Refund Policy</h2>
            <p>Due to the nature of digital downloads, all sales are final. We do not offer refunds or exchanges. Please
                ensure the product suits your needs before purchasing.</p>

            <h2 class="h5 mt-4">6. Intellectual Property</h2>
            <p>All content on DigitalsDesign.Com, including product designs, website content, graphics, and logos, is
                the
                property of DigitalsDesign.Com and protected by intellectual property laws.</p>

            <h2 class="h5 mt-4">7. Termination</h2>
            <p>We reserve the right to terminate or suspend access to our services immediately, without prior notice,
                for
                conduct that we believe violates these Terms and Conditions or is harmful to other users, us, or third
                parties.</p>

            <h2 class="h5 mt-4">8. Changes to Terms</h2>
            <p>We reserve the right to update these Terms and Conditions at any time. Continued use of the website after
                changes constitutes acceptance of the revised terms.</p>

            <h2 class="h5 mt-4">9. Limitation of Liability</h2>
            <p>We are not liable for any indirect, incidental, or consequential damages resulting from your use of our
                products or services. All products are provided "as is" without warranties of any kind.</p>

            <h2 class="h5 mt-4">10. Governing Law</h2>
            <p>These Terms shall be governed by and construed in accordance with the laws of India. Any disputes shall
                be
                subject to the exclusive jurisdiction of the courts located in India.</p>

            <h2 class="h5 mt-4">11. Contact Us</h2>
            <p>If you have any questions about these Terms and Conditions, please contact us at <a
                    href="mailto:support@digitalsdesign.com">support@digitalsdesign.com</a>.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-white border-top">
        <div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <span class="small">© <span id="year"></span> DigitalsDesign.Com</span>
        </div>
    </footer>

    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>

</html>