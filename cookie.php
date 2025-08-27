<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cookie Policy • DigitalsDesign</title>
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
                <h1 class="display-5 fw-bold mb-2 text-dark">Cookie Policy</h1>
                <p class="lead mb-0 text-dark">How and why we use cookies on DigitalsDesign.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="/" class="btn btn-light fw-semibold shadow-soft rounded-2xl">🏠 Home</a>
            </div>
        </div>
    </header>

    <!-- Cookie Policy Content -->
    <section class="py-5">
        <div class="container-xxl bg-white p-4 p-md-5 rounded-2xl shadow-soft">
            <p><strong>Last updated:</strong> July 30, 2025</p>

            <p>This Cookie Policy explains how DigitalsDesign.Com (“we”, “our”, or “us”) uses cookies and similar
                technologies on our website. By continuing to browse or use our site, you agree to our use of cookies as
                described below.</p>

            <h2 class="h5 mt-4">1. What Are Cookies?</h2>
            <p>Cookies are small text files placed on your device to help the website function properly, improve your
                browsing experience, and analyze how users interact with our content.</p>

            <h2 class="h5 mt-4">2. What Cookies Do We Use?</h2>
            <p>We only use cookies for Google Analytics to understand how visitors interact with our website. These
                cookies help us:</p>
            <ul>
                <li>Track website traffic and usage behavior</li>
                <li>Measure performance and improve site features</li>
                <li>Understand which pages are most visited</li>
            </ul>

            <h2 class="h5 mt-4">3. Google Analytics Cookies</h2>
            <p>Google Analytics sets cookies such as <code>_ga</code>, <code>_gid</code>, and <code>_gat</code> to
                collect information anonymously, including browser type, device, pages visited, and time spent on each
                page. Google’s Privacy Policy is available at: <a href="https://policies.google.com/privacy"
                    target="_blank" rel="noopener noreferrer">https://policies.google.com/privacy</a></p>

            <h2 class="h5 mt-4">4. Managing Cookies</h2>
            <p>You can manage or disable cookies through your browser settings. Please note that disabling cookies may
                affect the functionality of our website.</p>
            <ul>
                <li><a href="https://support.google.com/chrome/answer/95647" target="_blank">Google Chrome</a></li>
                <li><a href="https://support.mozilla.org/en-US/kb/enable-and-disable-cookies-website-preferences"
                        target="_blank">Mozilla Firefox</a></li>
                <li><a href="https://support.apple.com/en-in/guide/safari/sfri11471/mac" target="_blank">Safari</a></li>
                <li><a href="https://support.microsoft.com/en-us/topic/how-to-delete-cookie-files-in-internet-explorer-bca9446f-d873-78de-77ba-d42645fa52fc"
                        target="_blank">Internet Explorer / Edge</a></li>
            </ul>

            <h2 class="h5 mt-4">5. Updates to This Policy</h2>
            <p>We may update this Cookie Policy from time to time to reflect changes in technology or legal
                requirements. Please check this page periodically for updates.</p>

            <h2 class="h5 mt-4">6. Contact Us</h2>
            <p>If you have any questions about this Cookie Policy, you can contact us at <a
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