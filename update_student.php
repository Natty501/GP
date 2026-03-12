<?php
session_start();
include("db.php"); // your mysqli connection

// Get JSON
$data = json_decode(file_get_contents("php://input"), true);

if(!$data || !isset($data['student_no'])) {
    echo json_encode(['success'=>false,'message'=>'Invalid request']);
    exit;
}

$student_no = $data['student_no'];
$fname = $data['fname'];
$mname = $data['mname'];
$lname = $data['lname'];
$email = $data['email'];
$bday = $data['bday'];
$strand_course = $data['strand_course'];
$year_level = $data['year_level'];
$rfid = isset($data['rfid']) ? $data['rfid'] : null;

// Update query
$sql = "UPDATE form SET fname=?, mname=?, lname=?, email=?, bday=?, strand_course=?, year_level=?, rfid=? WHERE student_no=?";
$stmt = $con->prepare($sql);

if(!$stmt) {
    echo json_encode(['success'=>false,'message'=>$con->error]);
    exit;
}

$stmt->bind_param("sssssssss", $fname, $mname, $lname, $email, $bday, $strand_course, $year_level, $rfid, $student_no);

if($stmt->execute()) {
    echo json_encode(['success'=>true]);
} else {
    echo json_encode(['success'=>false,'message'=>$stmt->error]);
}

$stmt->close();
$con->close();
?>