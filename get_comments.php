<?php
header('Content-Type: application/json');

$file = 'data/comments.json';
$itemId = $_GET['item_id'] ?? '';

if (empty($itemId) || !file_exists($file)) {
    echo json_encode([]);
    exit;
}

$comments = json_decode(file_get_contents($file), true);
echo json_encode($comments[$itemId] ?? []);
