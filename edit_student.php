<?php
session_start();
include("db.php");

header('Content-Type: application/json');

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid or empty request'
    ]);
    exit;
}

// Required fields check
$required = ['id', 'fname', 'lname', 'email', 'bday', 'strand_course', 'year_level'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        echo json_encode([
            'success' => false,
            'message' => "Missing field: $field"
        ]);
        exit;
    }
}

// Assign values
$student_no     = $data['id']; // from JS: student.student_no
$fname          = trim($data['fname']);
$mname          = !empty($data['mname']) ? trim($data['mname']) : "N/A";
$lname          = trim($data['lname']);
$email          = trim($data['email']);
$bday           = $data['bday'];
$rfid           = isset($data['rfid']) ? trim($data['rfid']) : null;
$strand_course  = trim($data['strand_course']);
$year_level     = trim($data['year_level']);

// SQL Update
$sql = "UPDATE form SET 
            fname = ?, 
            mname = ?, 
            lname = ?, 
            email = ?, 
            bday = ?, 
            rfid = ?, 
            strand_course = ?, 
            year_level = ?
        WHERE student_no = ?";

$stmt = $con->prepare($sql);

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => $con->error
    ]);
    exit;
}

$stmt->bind_param(
    "sssssssss",
    $fname,
    $mname,
    $lname,
    $email,
    $bday,
    $rfid,
    $strand_course,
    $year_level,
    $student_no
);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode([
        'success' => false,
        'message' => $stmt->error
    ]);
}

$stmt->close();
$con->close();
?>
