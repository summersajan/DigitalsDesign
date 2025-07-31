<?php
require_once '../config/db.php';

function getAllDescendantCategoryIds($mysqli, $parent_id)
{
  // Recursively get all child category IDs including the given parent_id itself
  $ids = [$parent_id];
  $query = "SELECT category_id FROM categories WHERE parent_id = $parent_id";
  $result = $mysqli->query($query);
  while ($row = $result->fetch_assoc()) {
    $ids = array_merge($ids, getAllDescendantCategoryIds($mysqli, $row['category_id']));
  }
  return $ids;
}

// --- Input params ---
$search = isset($_GET['search']) ? trim($mysqli->real_escape_string($_GET['search'])) : '';
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 4;
$featured = isset($_GET['featured']) ? intval($_GET['featured']) : -1; // -1: all

$where = [];
$joins = ["LEFT JOIN product_categories pc ON pc.product_id = p.product_id", "LEFT JOIN categories c ON c.category_id = pc.category_id"];

// --- Category (with descendants) ---
if ($category_id > 0) {
  $category_ids = getAllDescendantCategoryIds($mysqli, $category_id);
  $cat_in_sql = implode(',', array_map('intval', $category_ids));
  $where[] = "pc.category_id IN ($cat_in_sql)";
}

// --- Search (product title OR description OR category name) ---
if ($search !== '') {
  $where[] = "(p.title LIKE '%$search%' OR p.description LIKE '%$search%' OR c.name LIKE '%$search%')";
}

// --- Featured ---
if ($featured === 0 || $featured === 1) {
  $where[] = "p.featured = $featured";
}

$where_sql = count($where) ? "WHERE " . implode(' AND ', $where) : "";
$join_sql = count($joins) ? implode(' ', $joins) : "";

// --- Total count query (distinct product_id avoids double-counting with multiple categories) ---
$total_sql = "
    SELECT COUNT(DISTINCT p.product_id) as total
    FROM products p
    $join_sql
    $where_sql
";
$total_res = $mysqli->query($total_sql);
$total_row = $total_res->fetch_assoc();
$total = isset($total_row['total']) ? intval($total_row['total']) : 0;

// --- Main data query ---
$sql = "
    SELECT DISTINCT p.*,
        (SELECT image_url FROM product_images WHERE product_id=p.product_id LIMIT 1) as image
    FROM products p
    $join_sql
    $where_sql
    ORDER BY p.product_id DESC
    LIMIT $offset, $limit
";





$res = $mysqli->query($sql);

$out = [];
while ($row = $res->fetch_assoc())
  $out[] = $row;

header('Content-Type: application/json');
echo json_encode([
  'products' => $out,
  'total' => $total,
]);
