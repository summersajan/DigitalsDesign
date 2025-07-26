<?php
require_once '../config/db.php';
$res = $mysqli->query("SELECT category_id, name, parent_id FROM categories ORDER BY parent_id, name");
$cats = [];
while ($row = $res->fetch_assoc())
    $cats[] = $row;

// Build the tree:
function buildTree($elements, $parentId = null)
{
    $branch = [];
    foreach ($elements as $element) {
        if ((string) $element['parent_id'] === (string) $parentId) {
            $children = buildTree($elements, $element['category_id']);
            if ($children)
                $element['children'] = $children;
            $branch[] = $element;
        }
    }
    return $branch;
}
$tree = buildTree($cats, null);

header('Content-Type: application/json');
echo json_encode($tree);