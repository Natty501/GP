<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$email = $_SESSION['email'];
$contact_number = isset($_POST['contact_number']) ? $_POST['contact_number'] : null;
$sms_enabled = isset($_POST['sms_enabled']) ? intval($_POST['sms_enabled']) : 0;

try {
    // Update user's contact number and SMS status
    $stmt = $con->prepare("UPDATE form SET contact_number = ?, sms_enabled = ? WHERE email = ?");
    if (!$stmt) throw new Exception($con->error);
    $stmt->bind_param("sis", $contact_number, $sms_enabled, $email);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
