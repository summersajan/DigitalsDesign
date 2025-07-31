<?php
// Your Stripe secret key
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//define('pk_test_51Rk0oLR7unRcaLddj3xyqcCLGynHQGXVk1sLCrKsjFv3aaBKQyKU0CrmxYNgIY48OY6X0q3EeATaQUqZrlTENP7000KH9uqmqR', 'sk_test_51Rk0oLR7unRcaLddJV45HX4L8r9lsxC3Cv7oWszGXVgctTHSI9EVa8OuGLC6GBTGtKMZPQ3cGRgK7xEwYY0mP2JC00KZ7v76bt'); // Replace with env or config
require_once 'vendor/autoload.php'; // Assumes Stripe PHP SDK is installed (via Composer)

define('STRIPE_SECRET_KEY', 'sk_test_51Rk0oLR7unRcaLddJV45HX4L8r9lsxC3Cv7oWszGXVgctTHSI9EVa8OuGLC6GBTGtKMZPQ3cGRgK7xEwYY0mP2JC00KZ7v76bt');  // Replace with your real key


define('MAIN_URL', 'http://localhost/DigitalProduct/user/ajax/');