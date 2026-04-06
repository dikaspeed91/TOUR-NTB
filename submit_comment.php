<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login terlebih dahulu!']);
    exit;
}

$file = 'data/comments.json';
if (!file_exists('data')) {
    mkdir('data', 0777, true);
}

$comments = [];
if (file_exists($file)) {
    $comments = json_decode(file_get_contents($file), true);
}

$input = json_decode(file_get_contents('php://input'), true);
$itemId = $input['item_id'] ?? '';
$rating = intval($input['rating'] ?? 5);
$text = htmlspecialchars($input['text'] ?? '');

if (empty($itemId) || empty($text)) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

$newComment = [
    'user' => $_SESSION['user']['name'],
    'picture' => $_SESSION['user']['picture'],
    'rating' => $rating,
    'text' => $text,
    'date' => date('Y-m-d H:i')
];

if (!isset($comments[$itemId])) {
    $comments[$itemId] = [];
}
array_unshift($comments[$itemId], $newComment);

if(file_put_contents($file, json_encode($comments, JSON_PRETTY_PRINT))) {
    echo json_encode(['status' => 'success', 'message' => 'Komentar berhasil ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan komentar ke server']);
}
