<?php
//include_once 'security.php';
include_once '../../config/db.php';

define('BASE_URL', 'http://localhost/digitalProduct/user/');

$user_id = isset($_SESSION['user_digital_product']) ? $_SESSION['user_digital_product'] : null;
?>