<?php
include("db.php");

if (isset($_POST['identifier'])) {
    $identifier = trim($_POST['identifier']);
    $userFound = false;
    $fname = "";

    if (ctype_digit($identifier)) {
        $short_no = ltrim($identifier, '0');
        $short_no = substr($short_no, -6);
        $stmt = $con->prepare("SELECT fname FROM form WHERE RIGHT(TRIM(LEADING '0' FROM student_no), 6) = ? LIMIT 1");
        $stmt->bind_param("s", $short_no);
    } else {
        $stmt = $con->prepare("SELECT fname FROM form WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $identifier);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'fname' => $user['fname']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Account not found. Please contact Guidance Office.']);
    }
    exit();
}