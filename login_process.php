<?php
session_start();

// Simulasikan verifikasi JWT untuk keperluan demo (Dalam produksi, gunakan Google API PHP Client)
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['credential'])) {
    $jwt = $data['credential'];
    $parts = explode('.', $jwt);
    if (count($parts) === 3) {
        $payload = json_decode(base64_decode(str_pad(strtr($parts[1], '-_', '+/'), strlen($parts[1]) % 4, '=', STR_PAD_RIGHT)), true);
        
        if ($payload) {
            $_SESSION['user'] = [
                'name' => $payload['name'],
                'email' => $payload['email'],
                'picture' => $payload['picture']
            ];
            echo json_encode(['status' => 'success']);
            exit;
        }
    }
}
echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
