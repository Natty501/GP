<?php
header('Content-Type: application/json');
include('db.php'); 

if (!isset($_GET['rfid'])) {
    echo json_encode(['error' => 'RFID missing']);
    exit;
}

$rfid = $_GET['rfid'];

$stmt = $con->prepare("SELECT student_no, fname, mname, lname, year_level, strand_course, avatar_choice, time_in, time_out FROM form WHERE rfid = ?");
$stmt->bind_param("s", $rfid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $full_name = trim($student['fname'] . ' ' . ($student['mname'] ?: '') . ' ' . $student['lname']);
    echo json_encode([
        'student_no' => $student['student_no'],
        'full_name' => $full_name,
        'grade' => $student['year_level'],
        'strand' => $student['strand_course'],
        'photo' => $student['avatar_choice'],
        'time_in' => $student['time_in'],
        'time_out' => $student['time_out']
    ]);
} else {
    echo json_encode(['error' => 'Oopsie! Card not valid']);
}
?>
