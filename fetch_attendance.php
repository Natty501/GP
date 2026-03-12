<?php
include("db.php");

// OPTIONAL: filter by date (admin / future use)
$dateFilter = $_GET['date'] ?? date('Y-m-d');

$sql = "
SELECT 
    f.fname,
    f.lname,
    a.student_no,
    a.time_in,
    a.time_out,
    a.status
FROM attendance_logs a
JOIN form f ON a.student_no = f.student_no
WHERE a.date = ?
ORDER BY a.time_in DESC
";

$stmt = $con->prepare($sql);
$stmt->bind_param("s", $dateFilter);
$stmt->execute();
$result = $stmt->get_result();

$attendance_rows = [];

while ($row = $result->fetch_assoc()) {

    // Format Time In
    $row['time_in'] = (!empty($row['time_in']) && $row['time_in'] !== '0000-00-00 00:00:00')
        ? date('g:i A', strtotime($row['time_in']))
        : '–';

    // Format Time Out
    $row['time_out'] = (!empty($row['time_out']) && $row['time_out'] !== '0000-00-00 00:00:00')
        ? date('g:i A', strtotime($row['time_out']))
        : '–';

    $attendance_rows[] = $row;
}

echo json_encode($attendance_rows);

$stmt->close();
$con->close();
?>
