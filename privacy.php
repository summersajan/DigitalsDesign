<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Privacy Policy • DigitalsDesign</title>
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
                <h1 class="display-5 fw-bold mb-2 text-dark">Privacy Policy</h1>
                <p class="lead mb-0 text-dark">Your privacy is important to us at DigitalsDesign.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="/" class="btn btn-light fw-semibold shadow-soft rounded-2xl">🏠 Home</a>
            </div>
        </div>
    </header>

    <!-- Privacy Policy Content -->
    <section class="py-5">
        <div class="container-xxl bg-white p-4 p-md-5 rounded-2xl shadow-soft">
            <p><strong>Last updated:</strong> July 30, 2025</p>

            <p>DigitalsDesign.Com ("we", "our", or "us") is committed to protecting your privacy. This Privacy Policy
                explains how we collect, use, and safeguard your information when you visit our website and use our
                digital products and services.</p>

            <h2 class="h5 mt-4">1. Information We Collect</h2>
            <ul>
                <li><strong>Personal Information:</strong> When you make a purchase or create an account, we may collect
                    your name, email address, and payment details.</li>
                <li><strong>Usage Data:</strong> We collect data on how you interact with our site such as pages
                    visited,
                    products viewed, and download history.</li>
                <li><strong>Cookies:</strong> We use cookies to enhance your browsing experience and track usage for
                    analytics purposes.</li>
            </ul>

            <h2 class="h5 mt-4">2. How We Use Your Information</h2>
            <p>We use the collected data to:</p>
            <ul>
                <li>Process transactions and deliver digital products</li>
                <li>Send order confirmations and support emails</li>
                <li>Improve our website and user experience</li>
                <li>Prevent fraud and ensure secure transactions</li>
            </ul>

            <h2 class="h5 mt-4">3. Sharing Your Information</h2>
            <p>We do not sell, rent, or trade your personal data. We may share your information only with trusted
                service providers (e.g. payment gateways) strictly for fulfilling your order or enhancing our services.
            </p>

            <h2 class="h5 mt-4">4. Data Security</h2>
            <p>We implement appropriate security measures to protect your personal information against unauthorized
                access, alteration, or disclosure.</p>

            <h2 class="h5 mt-4">5. Third-Party Services</h2>
            <p>We may use third-party services like Google Analytics for understanding website usage. These services may
                use cookies and collect anonymous usage data.</p>

            <h2 class="h5 mt-4">6. Your Rights</h2>
            <p>You have the right to access, update, or delete your personal information. You can do this by contacting
                us at <a href="mailto:support@digitalsdesign.com">support@digitalsdesign.com</a>.</p>

            <h2 class="h5 mt-4">7. Children's Privacy</h2>
            <p>Our website is not intended for children under the age of 13. We do not knowingly collect personal
                information from children.</p>

            <h2 class="h5 mt-4">8. Changes to This Policy</h2>
            <p>We may update this Privacy Policy occasionally. Any changes will be posted on this page with a revised
                "Last updated" date.</p>

            <h2 class="h5 mt-4">9. Contact Us</h2>
            <p>If you have any questions or concerns about this Privacy Policy, please contact us at:</p>
            <p>Email: <a href="mailto:support@digitalsdesign.com">support@digitalsdesign.com</a></p>
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