<?php
require_once 'db.php';
$res = $mysqli->query("
  SELECT p.*, u.name as user_name, u.email as user_email
  FROM payments p
  LEFT JOIN users u ON p.usercode = u.usercode
  ORDER BY p.payment_id DESC
");
$data = [];
while ($row = $res->fetch_assoc())
  $data[] = $row;
header("Content-Type: application/json");
echo json_encode($data);
?>