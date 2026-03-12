<?php
date_default_timezone_set('Asia/Manila');
include("db.php");
header('Content-Type: application/json');

// Read JSON input
$input = json_decode(file_get_contents('php://input'), true);
$rfid = $input['rfid'] ?? '';

if (!$rfid) {
    echo json_encode(['success'=>false,'message'=>'Missing RFID']);
    exit;
}

// Fetch student
$stmt = $con->prepare("SELECT student_no FROM form WHERE rfid=? LIMIT 1");
$stmt->bind_param("s", $rfid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success'=>false,'message'=>'RFID not found']);
    exit;
}

$student = $result->fetch_assoc();
$studentNo = $student['student_no'];

// Current date & time
$today = date('Y-m-d');
$currentDateTime = date('Y-m-d H:i:s');

// Check today's attendance
$checkLog = $con->prepare("
    SELECT time_in, time_out, status 
    FROM attendance_logs 
    WHERE student_no=? AND date=? 
    LIMIT 1
");
$checkLog->bind_param("ss", $studentNo, $today);
$checkLog->execute();
$logResult = $checkLog->get_result();

if ($logResult->num_rows === 0) {
    // ✅ TIME IN
    $timeInOnly = date('H:i:s'); // current time in 24h format
    $lateTime = '07:00:00';
    
    if ($timeInOnly > $lateTime) {
    $status = 'late';
} else {
    $status = 'present';
}
    $insert = $con->prepare("
        INSERT INTO attendance_logs 
        (student_no, rfid, time_in, date, status)
        VALUES (?, ?, ?, ?, ?)
    ");
    $insert->bind_param("sssss", $studentNo, $rfid, $currentDateTime, $today, $status);
    $insert->execute();

    echo json_encode(['success'=>true,'action'=>'time_in','time'=>$currentDateTime,'status'=>$status]);
}
else {
    $todayLog = $logResult->fetch_assoc();

    if (empty($todayLog['time_out'])) {
        // ✅ TIME OUT (status remains Present)
        $update = $con->prepare("
            UPDATE attendance_logs 
            SET time_out=? 
            WHERE student_no=? AND date=?
        ");
        $update->bind_param("sss", $currentDateTime, $studentNo, $today);
        $update->execute();

        echo json_encode(['success'=>true,'action'=>'time_out','time'=>$currentDateTime]);

    } else {
        // ❌ ALREADY TIMED OUT
        echo json_encode(['success'=>true,'action'=>'already_timed_out']);
    }
}

$con->close();
?>
