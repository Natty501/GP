<?php
session_start();
if (!isset($_SESSION['student_no'])) {
    header("Location: login.php");
    exit();
}

include("db.php");

$studentNo = $_SESSION['student_no'];
$currentMonth = date('Y-m');

// Monthly summary
$summarySql = $con->prepare("
    SELECT 
        COUNT(*) AS total_days,
        SUM(status='Present') AS present_days,
        SUM(status='Late') AS late_days,
        SUM(status='Absent') AS absent_days
    FROM attendance_logs
    WHERE student_no = ?
    AND DATE_FORMAT(date, '%Y-%m') = ?
");
$summarySql->bind_param("ss", $studentNo, $currentMonth);
$summarySql->execute();
$summary = $summarySql->get_result()->fetch_assoc();
$summarySql->close();

$totalDays = $summary['total_days'] ?? 0;
$present   = $summary['present_days'] ?? 0;
$late      = $summary['late_days'] ?? 0;
$absent    = $summary['absent_days'] ?? 0;

$attendanceRate = $totalDays > 0 
    ? round((($present + $late) / $totalDays) * 100, 1)
    : 0;

// Daily records
$recordsSql = $con->prepare("
    SELECT date, status, time_in, time_out
    FROM attendance_logs
    WHERE student_no = ?
    AND DATE_FORMAT(date, '%Y-%m') = ?
    ORDER BY date DESC
");
$recordsSql->bind_param("ss", $studentNo, $currentMonth);
$recordsSql->execute();
$recordsResult = $recordsSql->get_result();
?>



<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monthly Attendance Summary</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
  <style>
    body {
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }
    .summary-card {
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .summary-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }
    .rate-circle {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      font-weight: 700;
      margin: 0 auto;
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
      box-shadow: 0 8px 16px rgba(16, 185, 129, 0.3);
    }
  </style>
  
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
  <script src="/_sdk/element_sdk.js" type="text/javascript"></script>
 </head>
 <body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
  <div class="container mx-auto px-4 py-8 max-w-7xl">

  <!-- BACK BUTTON -->
   <div class="mb-4"><a href="student_reports.php" class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 transition-colors"> <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard </a>
   </div>
   
   <!-- HEADER -->
   <div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-2"><i class="fas fa-chart-line text-blue-600 mr-3"></i>Monthly Attendance Summary</h1>
    <p class="text-gray-600">Track your attendance performance at a glance</p>
   </div>
   
  <!-- SUMMARY CARDS -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Total Days Card -->
    <div class="summary-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-3">
            <h6 class="text-blue-100 text-sm font-medium uppercase tracking-wide">Total Days</h6>
            <i class="fas fa-calendar-days text-2xl text-blue-200"></i>
        </div>
        <h2 class="text-5xl font-bold"><?= $totalDays ?></h2>
        <p class="text-blue-100 text-sm mt-2">Working days</p>
    </div>

    <!-- Present Card -->
    <div class="summary-card bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-3">
            <h6 class="text-green-100 text-sm font-medium uppercase tracking-wide">Present</h6>
            <i class="fas fa-check-circle text-2xl text-green-200"></i>
        </div>
        <h2 class="text-5xl font-bold"><?= $present ?></h2>
        <p class="text-green-100 text-sm mt-2">Days attended</p>
    </div>

    <!-- Late Card -->
    <div class="summary-card bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-3">
            <h6 class="text-amber-100 text-sm font-medium uppercase tracking-wide">Late</h6>
            <i class="fas fa-clock text-2xl text-amber-200"></i>
        </div>
        <h2 class="text-5xl font-bold"><?= $late ?></h2>
        <p class="text-amber-100 text-sm mt-2">Late arrivals</p>
    </div>

    <!-- Absent Card -->
    <div class="summary-card bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-3">
            <h6 class="text-red-100 text-sm font-medium uppercase tracking-wide">Absent</h6>
            <i class="fas fa-times-circle text-2xl text-red-200"></i>
        </div>
        <h2 class="text-5xl font-bold"><?= $absent ?></h2>
        <p class="text-red-100 text-sm mt-2">Days missed</p>
    </div>

</div>

   <!-- ATTENDANCE RATE -->
   <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
    <div class="text-center">
     <h5 class="text-2xl font-semibold text-gray-800 mb-6">Attendance Rate</h5>
     <div class="<?= $attendanceRate >= 75 ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800' ?> border-l-4 rounded-lg p-5 mb-8 shadow-sm">
    <div class="flex items-center">
        <i class="<?= $attendanceRate >= 75 ? 'fas fa-circle-check text-green-600' : 'fas fa-triangle-exclamation text-red-600' ?> text-2xl mr-4"></i>
        <div>
            <h6 class="font-semibold text-lg mb-1">
                <?= $attendanceRate >= 75 ? 'Excellent Performance!' : 'Needs Improvement' ?>
            </h6>
            <p class="text-sm">
                <?= $attendanceRate >= 75
                    ? "You're doing great! Keep maintaining your attendance."
                    : "Attendance is below 75%. Please improve consistency." ?>
            </p>
        </div>
    </div>
</div>

   
  <!-- DAILY RECORDS -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
        <h5 class="text-xl font-semibold text-white">
            <i class="fas fa-calendar-alt mr-2"></i>
            Attendance Records (<?= date('F Y') ?>)
        </h5>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                        <span class="inline-flex items-center gap-2">
                            <i class="far fa-calendar"></i> Date
                        </span>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                        <span class="inline-flex items-center gap-2">
                            <i class="fas fa-info-circle"></i> Status
                        </span>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                        <span class="inline-flex items-center gap-2">
                            <i class="fas fa-arrow-right-to-bracket"></i> Time In
                        </span>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider whitespace-nowrap">
                        <span class="inline-flex items-center gap-2">
                            <i class="fas fa-arrow-right-from-bracket"></i> Time Out
                        </span>
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
            <?php if ($recordsResult->num_rows > 0): ?>
                <?php while ($row = $recordsResult->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        
                        <!-- DATE -->
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium whitespace-nowrap">
                            <span class="inline-flex items-center">
                                <?= date("M d, Y", strtotime($row['date'])) ?>
                            </span>
                        </td>

                        <!-- STATUS -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                <?= strtolower($row['status']) === 'present' ? 'bg-green-100 text-green-800' :
                                   (strtolower($row['status']) === 'late' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </td>

                        <!-- TIME IN -->
                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                            <span class="inline-flex items-center">
                                <?= $row['time_in']
                                    ? date("g:i A", strtotime($row['time_in']))
                                    : '<span class="text-gray-400">—</span>' ?>
                            </span>
                        </td>

                        <!-- TIME OUT -->
                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                            <span class="inline-flex items-center">
                                <?= $row['time_out']
                                    ? date("g:i A", strtotime($row['time_out']))
                                    : '<span class="text-gray-400">—</span>' ?>
                            </span>
                        </td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">No records found.</p>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


     </table>
    </div>
   </div>
  </div>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9ae6075ea5a90dc9',t:'MTc2NTgwMjYyOS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>