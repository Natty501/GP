<?php
session_start();
include("db.php");

// Redirect if no student is logged in
if (!isset($_SESSION['student_no'])) {
    header("Location: login.php"); // redirect to login page
    exit;
}

$student_no = $_SESSION['student_no'];

// Fetch student info
$sql = "SELECT * FROM form WHERE student_no = '$student_no'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found.";
    exit;
}

// Fetch all attendance logs for this student
$attendance_sql = "SELECT * FROM attendance_logs WHERE student_no='$student_no' ORDER BY date DESC";
$attendance_result = $con->query($attendance_sql);

// Store attendance rows
$attendance_rows = [];
if ($attendance_result->num_rows > 0) {
    while ($row = $attendance_result->fetch_assoc()) {
        $attendance_rows[] = $row;
    }
}

// Calculate summary statistics
// Initialize counters
$totalDays = count($attendance_rows);
$presentDays = 0;
$absentDays = 0;
$lateDays = 0;

foreach ($attendance_rows as $row) {
    // Normalize status: trim spaces and lowercase
    $status = isset($row['status']) ? strtolower(trim($row['status'])) : '';

    switch($status) {
        case 'present':
            $presentDays++;
            break;
        case 'late':
            $presentDays++; // Count late as present too
            $lateDays++;
            break;
        case 'absent':
            $absentDays++;
            break;
        default:
            // If status is empty or unknown, count as absent
            $absentDays++;
            break;
    }
}

// Calculate attendance rate safely
$attendanceRate = ($totalDays > 0) ? round(($presentDays / $totalDays) * 100) : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior High RFID Attendance – Student View</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F3F4F6;
            color: #111827;
        }

        /* Header */
        .header {
            background-color: #1E3A8A;
            color: white;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }

        .header p {
            margin: 0.5rem 0 0 0;
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Student Profile Section */
        .student-profile {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3B82F6, #1E40AF);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            border: 4px solid white;
            flex-shrink: 0;
        }

        .profile-info {
            flex: 1;
        }

        .student-name {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .student-details {
            color: #6B7280;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .student-details p {
            margin: 0.25rem 0;
        }

        .current-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
        }

        .status-present {
            background: rgba(34, 197, 94, 0.1);
            color: #15803D;
            border: 2px solid rgba(34, 197, 94, 0.3);
        }

        .status-late {
            background: rgba(245, 158, 11, 0.1);
            color: #D97706;
            border: 2px solid rgba(245, 158, 11, 0.3);
        }

        .status-absent {
            background: rgba(239, 68, 68, 0.1);
            color: #DC2626;
            border: 2px solid rgba(239, 68, 68, 0.3);
        }

        /* Controls Section */
        .controls {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .search-filter {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-input {
            padding: 0.75rem;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            font-size: 1rem;
            width: 250px;
        }

        .search-input:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .filter-select {
            padding: 0.75rem;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            cursor: pointer;
        }

        .export-buttons {
            display: flex;
            gap: 0.75rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: #3B82F6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563EB;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #6B7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4B5563;
            transform: translateY(-1px);
        }

        /* Attendance Table */
        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-header {
            background: #1E3A8A;
            color: white;
            padding: 1.5rem 2rem;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .table-wrapper {
            max-height: 500px;
            overflow-y: auto;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table th {
            background: #1E3A8A;
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 700;
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 2px solid #1E40AF;
        }

        .attendance-table td {
            padding: 1rem;
            border-bottom: 1px solid #F1F5F9;
            color: #374151;
        }

        .attendance-table tr:nth-child(even) {
            background: #F8FAFC;
        }

        .attendance-table tr:hover {
            background: #EFF6FF;
        }

        .table-status {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .table-status.present {
            background: rgba(34, 197, 94, 0.1);
            color: #15803D;
        }

        .table-status.late {
            background: rgba(245, 158, 11, 0.1);
            color: #D97706;
        }

        .table-status.absent {
            background: rgba(239, 68, 68, 0.1);
            color: #DC2626;
        }

        /* Summary Cards */
        .summary-section {
            margin-top: 2rem;
        }

        .summary-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .summary-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #E2E8F0;
        }

        .summary-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }

        .summary-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .summary-label {
            color: #6B7280;
            font-weight: 600;
            font-size: 1rem;
        }

        .summary-card.total .summary-icon { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
        .summary-card.total .summary-number { color: #3B82F6; }

        .summary-card.present .summary-icon { background: rgba(34, 197, 94, 0.1); color: #22C55E; }
        .summary-card.present .summary-number { color: #22C55E; }

        .summary-card.absent .summary-icon { background: rgba(239, 68, 68, 0.1); color: #EF4444; }
        .summary-card.absent .summary-number { color: #EF4444; }

        .summary-card.attendance-rate .summary-icon { background: rgba(168, 85, 247, 0.1); color: #A855F7; }
        .summary-card.attendance-rate .summary-number { color: #A855F7; }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .student-profile {
                flex-direction: column;
                text-align: center;
            }

            .controls {
                flex-direction: column;
                align-items: stretch;
            }

            .search-filter {
                flex-direction: column;
            }

            .search-input {
                width: 100%;
            }

            .attendance-table {
                font-size: 0.875rem;
            }

            .attendance-table th,
            .attendance-table td {
                padding: 0.75rem 0.5rem;
            }

            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }


      .back-button a {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 28px;           /* smaller square */
    height: 28px;
    background-color: #f0f0f0;  /* subtle background */
    border-radius: 4px;         /* slightly rounded corners */
    color: #333;                /* arrow color */
    text-decoration: none;
    font-size: 14px;            /* smaller arrow */
    font-weight: normal;        /* not bold */
    transition: all 0.2s;
}

.back-button a:hover {
    background-color: #007bff;  /* subtle hover color */
    color: #fff;
    transform: scale(1.05);     /* tiny zoom on hover */
}

.back-button {
    margin-bottom: 8px;        /* spacing from header */
}




        /* Loading Animation */
        .loading {
            text-align: center;
            padding: 2rem;
            color: #6B7280;
        }

        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid #E5E7EB;
            border-radius: 50%;
            border-top-color: #3B82F6;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* No Records Message */
        .no-records {
            text-align: center;
            padding: 3rem;
            color: #6B7280;
        }

        .no-records i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
</head>
<body>

    <!-- Header -->

 <!-- Back Button -->
<div class="back-button">
    <a href="dashboard.php">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
    <div class="header">
        <h1>Senior High RFID Attendance – Student View</h1>
        <p>View your personal attendance records and statistics</p>
    </div>

  <!-- Main Container -->
<div class="container">
    <!-- Student Profile Section -->
    <div class="student-profile">
        <div class="profile-picture">
            <i class="fas fa-user"></i>
        </div>
        <div class="profile-info">
            <h2 class="student-name">
    <?php 
        // Check if middle name exists and is not empty
        $fullName = $student['fname']; // First name
        if (!empty($student['mname'])) {
            $fullName .= ' ' . $student['mname']; // Add middle name if exists
        }
        $fullName .= ' ' . $student['lname']; // Last name always
        echo $fullName;
    ?>
</h2>
            <div class="student-details">
                <p><strong>Student No.:</strong> <?php echo $student['student_no']; ?></p>
                <p><strong>Year:</strong> <?php echo $student['year_level']; ?></p>
                <p><strong>Course/Strand:</strong> <?php echo $student['strand_course']; ?></p>
                <p><strong>School Year:</strong> 2024-2025</p>
            </div>
        </div>
    </div>
</div>

        <!-- Controls Section -->
        <div class="controls">
            <div class="search-filter">
                <input type="text" class="search-input" id="searchInput" placeholder="Search by date or remarks...">
                <select class="filter-select" id="filterSelect">
                    <option value="all">All Records</option>
                    <option value="present">Present Only</option>
                    <option value="late">Late Only</option>
                    <option value="absent">Absent Only</option>
                </select>
            </div>
        </div>

  <!-- Attendance Table -->
<div class="table-container">
    <div class="table-header">
        <i class="fas fa-table"></i> My Attendance Records
    </div>
    
    <div class="table-wrapper">
        <table class="attendance-table">
            <thead>
                <tr>
                    <th>Total Days</th>
                    <th>Present</th>
                    <th>Late</th>
                    <th>Absent</th>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody id="attendanceTableBody">
                <?php if (!empty($attendance_rows)): ?>
                    <?php foreach ($attendance_rows as $row): ?>
                        <?php
                            // Determine status class and icon
                            $statusClass = strtolower($row['status'] ?? 'absent'); // default to absent
                            $icon = 'fas fa-times-circle';
                            if ($statusClass === 'present') $icon = 'fas fa-check-circle';
                            elseif ($statusClass === 'late') $icon = 'fas fa-clock';

                            // Calculate total and present days safely
                            $totalDaysRow = $row['total_days'] ?? $totalDays;
$presentDaysRow = $row['present_days'] ?? $presentDays;
$lateDaysRow = $row['late_days'] ?? $lateDays;
$absentDaysRow = $totalDaysRow - $presentDaysRow;


                            // Format date and time separately
                            $formattedDate = !empty($row['date']) ? date("F j, Y", strtotime($row['date'])) : '–';
                            $formattedTimeIn = !empty($row['time_in']) ? date("g:i:s A", strtotime($row['time_in'])) : '–';
                            $formattedTimeOut = !empty($row['time_out']) ? date("g:i:s A", strtotime($row['time_out'])) : '–';
                        ?>
                        <tr>
                            <td><?php echo $totalDaysRow; ?></td>
                            <td><?php echo $presentDaysRow; ?></td>
                            <td><?php echo ($statusClass === 'late') ? 1 : 0; ?></td>
                            <td><?php echo $absentDaysRow; ?></td>
                            <td><?php echo $formattedDate; ?></td>
                            <td><?php echo $formattedTimeIn; ?></td>
                            <td><?php echo $formattedTimeOut; ?></td>
                            <td>
                                <span class="table-status <?php echo $statusClass; ?>">
                                    <i class="<?php echo $icon; ?>"></i> <?php echo ucfirst($statusClass); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="no-records">No attendance records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


        <!-- Summary Section -->
        <div class="summary-grid">
    <div class="summary-card total">
        <div class="summary-icon"><i class="fas fa-calendar-alt"></i></div>
        <div class="summary-number"><?php echo $totalDays; ?></div>
        <div class="summary-label">Total Days</div>
    </div>
    <div class="summary-card present">
        <div class="summary-icon"><i class="fas fa-check-circle"></i></div>
        <div class="summary-number"><?php echo $presentDays; ?></div>
        <div class="summary-label">Days Present</div>
    </div>
    <div class="summary-card late">
        <div class="summary-icon"><i class="fas fa-clock"></i></div>
        <div class="summary-number"><?php echo $lateDays; ?></div>
        <div class="summary-label">Days Late</div>
    </div>
    <div class="summary-card absent">
        <div class="summary-icon"><i class="fas fa-times-circle"></i></div>
        <div class="summary-number"><?php echo $absentDays; ?></div>
        <div class="summary-label">Days Absent</div>
    </div>
    <div class="summary-card rate">
        <div class="summary-icon"><i class="fas fa-percentage"></i></div>
        <div class="summary-number"><?php echo $attendanceRate; ?>%</div>
        <div class="summary-label">Attendance Rate</div>
    </div>
</div>

   <script>
/* ================================
   SEARCH & FILTER
================================ */
function initializeFilters() {
    const searchInput = document.getElementById('searchInput');
    const filterSelect = document.getElementById('filterSelect');

    if (!searchInput || !filterSelect) return;

    searchInput.addEventListener('input', filterTable);
    filterSelect.addEventListener('change', filterTable);
}

function filterTable() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const filterValue = document.getElementById('filterSelect').value;
    const rows = document.querySelectorAll('#attendanceTableBody tr');

    rows.forEach(row => {
        const rowText = row.textContent.toLowerCase();

        const statusEl = row.querySelector('.table-status');
        const statusClass = statusEl ? statusEl.className : '';

        const matchesSearch = rowText.includes(searchTerm);

        let matchesFilter = true;
        if (filterValue !== 'all') {
            matchesFilter = statusClass.includes(filterValue);
        }

        row.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
    });
}

/* ================================
   EXPORT TO CSV
================================ */
function exportToCSV() {
    const table = document.getElementById('attendanceTableBody');
    const rows = table.querySelectorAll('tr:not([style*="display: none"])');

    let csv = 'First Name,Last Name,Total Days,Present,Absent,Time In,Time Out,Remarks\n';

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const rowData = [];

        cells.forEach((cell, index) => {
            if (index === 7) {
                const status = cell.querySelector('.table-status');
                rowData.push(`"${status ? status.textContent.trim() : ''}"`);
            } else {
                rowData.push(`"${cell.textContent.trim()}"`);
            }
        });

        csv += rowData.join(',') + '\n';
    });

    const blob = new Blob([csv], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);

    const a = document.createElement('a');
    a.href = url;
    a.download = 'attendance_records.csv';
    a.click();

    URL.revokeObjectURL(url);
    showNotification('CSV file downloaded successfully!', 'success');
}

/* ================================
   EXPORT TO PDF (PLACEHOLDER)
================================ */
function exportToPDF() {
    showNotification('PDF export feature coming soon!', 'info');
}


/* ================================
   SUMMARY STATS
================================ */
function updateSummaryStats() {
    const rows = document.querySelectorAll('#attendanceTableBody tr');
    if (!rows.length) return;

    const cells = rows[0].querySelectorAll('td');

    const totalDays = parseInt(cells[2]?.textContent) || 0;
    const presentDays = parseInt(cells[3]?.textContent) || 0;
    const absentDays = parseInt(cells[4]?.textContent) || 0;

    const attendanceRate = totalDays
        ? Math.round((presentDays / totalDays) * 100)
        : 0;

    document.getElementById('totalDaysCard').textContent = totalDays;
    document.getElementById('presentDaysCard').textContent = presentDays;
    document.getElementById('absentDaysCard').textContent = absentDays;
    document.getElementById('attendanceRate').textContent = attendanceRate + '%';
}


/* ================================
   INITIALIZE
================================ */
document.addEventListener('DOMContentLoaded', () => {
    initializeFilters();
    updateSummaryStats();
    setInterval(simulateRFIDUpdate, 30000);
});
</script>
