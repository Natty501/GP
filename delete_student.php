<?php
session_start();
include("db.php");

$data = json_decode(file_get_contents("php://input"), true);

if(!$data || !isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$id = $data['id'];

$sql = "DELETE FROM form WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);

if($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
?>
