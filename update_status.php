<?php
include 'db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['appointment_id'];
    $status = $_POST['status'];
    $admin_message = $_POST['admin_message'];

    $stmt = $con->prepare("UPDATE appointments SET status = ?, admin_message = ? WHERE id = ?");
    $stmt->bind_param("ssi", $status, $admin_message, $id);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'status' => $status
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Failed to update appointment.'
        ]);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request method.'
    ]);
}
?>
