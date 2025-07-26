<?php
require_once 'db.php';
$res = $mysqli->query("
  SELECT o.*, u.name as user_name, u.email as user_email
  FROM orders o
  LEFT JOIN users u ON o.usercode = u.usercode
  ORDER BY o.order_id DESC
");
$data = [];
while ($row = $res->fetch_assoc())
  $data[] = $row;
header("Content-Type: application/json");
echo json_encode($data);
?>