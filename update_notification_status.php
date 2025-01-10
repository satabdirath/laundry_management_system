<?php
require 'config.php';
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'], $data['read_status'])) {
    $id = $data['id'];
    $read_status = $data['read_status'];

    $sql = "UPDATE notifications SET read_status = $read_status WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input.']);
}
?>
