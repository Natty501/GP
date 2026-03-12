<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

include("db.php");

/* =========================
   FETCH ATTENDANCE + STUDENT INFO
========================= */
$attendance_sql = "
SELECT 
    a.student_no,
    a.date,
    a.time_in,
    a.time_out,
    a.status,
    f.fname,
    f.lname,
    f.year_level,
    f.strand_course
FROM attendance_logs a
JOIN form f ON a.student_no = f.student_no
ORDER BY f.year_level, a.time_in DESC
";

$attendance_result = $con->query($attendance_sql);

$grouped_attendance = [];
$totalStudents      = 0;
$presentToday       = 0;
$lateToday          = 0;
$lowAttendance      = 0;
$totalRate          = 0;

$uniqueStudents = [];

if ($attendance_result && $attendance_result->num_rows > 0) {
    while ($row = $attendance_result->fetch_assoc()) {
        $grade  = $row['year_level'] ?? 'UNKNOWN';
        $strand = $row['strand_course'] ?? 'UNKNOWN';
        $grouped_attendance[$grade][$strand][] = $row;

        $studentNo = $row['student_no']; 
        $uniqueStudents[$studentNo] = true;

        // Count today's present & late
        $status = strtolower($row['status']);
        // Count today's present & late
$status = strtolower($row['status']);
if ($status === 'present' || $status === 'late') {
    $presentToday++; // include late in present
}
if ($status === 'late') {
    $lateToday++;
}


        // Compute totals for each student
        $countSql = $con->prepare("
            SELECT 
                COUNT(*) AS total_days,
                SUM(status='Present') AS present_days,
                SUM(status='Late') AS late_days
            FROM attendance_logs
            WHERE student_no = ?
        ");
        $countSql->bind_param("s", $studentNo);
        $countSql->execute();
        $counts = $countSql->get_result()->fetch_assoc();
        $countSql->close();

        $totalDays    = $counts['total_days'] ?? 0;
        $present      = $counts['present_days'] ?? 0;
        $late         = $counts['late_days'] ?? 0;
        $totalPresent = $present + $late;
        $absent       = $totalDays - $totalPresent;

        // Attendance rate includes both Present and Late
        $rate = $totalDays > 0 ? round(($totalPresent / $totalDays) * 100, 1) : 0;

        if ($rate < 75) $lowAttendance++;
        $totalRate += $rate;
    }

    $totalStudents = count($uniqueStudents);
    $overallRate   = $totalStudents > 0 ? round($totalRate / $totalStudents, 1) : 0;
} else {
    $totalStudents = $presentToday = $lateToday = $lowAttendance = $overallRate = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior High Student Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }
        
        .dashboard {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            padding: 1.5rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar h2 {
            padding: 0 1.5rem;
            margin-bottom: 2rem;
            font-size: 1.25rem;
            font-weight: 600;
            color: #495057;
        }
        
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar li {
            margin-bottom: 0.25rem;
        }
        
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #6c757d;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .sidebar a:hover {
            background-color: #f8f9fa;
            color: #495057;
        }
        
        .sidebar a.active {
            background-color: #e3f2fd;
            color: #1976d2;
            border-right: 3px solid #1976d2;
        }
        
        .sidebar a i {
            font-size: 1.1rem;
            width: 18px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 2rem;
        }

        .page-header {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid #1976d2;
        }

        .page-header h1 {
            margin: 0;
            color: #495057;
            font-weight: 600;
            font-size: 1.75rem;
        }

        .page-header p {
            margin: 0.5rem 0 0 0;
            color: #6c757d;
            font-size: 0.95rem;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid;
            transition: transform 0.2s ease;
        }

        .summary-card:hover {
            transform: translateY(-2px);
        }

        .summary-card.total { border-left-color: #1976d2; }
        .summary-card.present { border-left-color: #28a745; }
        .summary-card.low-attendance { border-left-color: #dc3545; }
        .summary-card.rate { border-left-color: #17a2b8; }

        .summary-card h3 {
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
            color: #495057;
        }

        .summary-card p {
            margin: 0.5rem 0 0 0;
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .summary-card i {
            font-size: 1.5rem;
            opacity: 0.7;
            float: right;
            margin-top: -0.5rem;
        }

        .filters-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .table-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 {
            margin: 0;
            color: #495057;
            font-weight: 600;
        }

        .table-responsive {
            max-height: 600px;
            overflow-y: auto;
        }

        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
            position: sticky;
            top: 0;
            z-index: 10;
            cursor: pointer;
            user-select: none;
        }

        .table th:hover {
            background-color: #e9ecef;
        }

        .table th i {
            margin-left: 0.5rem;
            opacity: 0.5;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-present {
            background-color: #d4edda;
            color: #155724;
        }

        .status-late {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-absent {
            background-color: #f8d7da;
            color: #721c24;
        }

        .attendance-rate {
            font-weight: 600;
        }

        .attendance-rate.high { color: #28a745; }
        .attendance-rate.medium { color: #ffc107; }
        .attendance-rate.low { color: #dc3545; }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        .low-attendance-row {
            background-color: #fff5f5;
        }

        .search-input {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 0.5rem 1rem;
        }

        .search-input:focus {
            border-color: #1976d2;
            box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.25);
        }

        .filter-select {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 0.5rem 1rem;
        }

        .export-buttons {
            display: flex;
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .summary-cards {
                grid-template-columns: 1fr;
            }

            .table-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .export-buttons {
                justify-content: stretch;
            }

            .export-buttons .btn {
                flex: 1;
            }
        }

        .mobile-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1050;
            background: #1976d2;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem;
        }

        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Mobile Toggle Button -->
        <button class="mobile-toggle btn" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <h2><i class="bi bi-mortarboard-fill me-2"></i>Admin Panel</h2>
            <ul>
                <li><a href="admin_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                <li><a href="admin_records.php" class="active"><i class="bi bi-people"></i> Student Records</a></li>
                <li><a href="admin_appointments.php"><i class="bi bi-calendar-check"></i> Appointments</a></li>
                <li><a href="admin_reports.php"><i class="bi bi-graph-up"></i> Reports</a></li>
                <li><a href="admin_settings.php"><i class="bi bi-gear"></i> Settings</a></li>
                <li><a href="admin_announcements.php"><i class="bi bi-megaphone"></i> Announcements</a></li>
                <li><a href="admin_parents.php"><i class="bi bi-person-lines-fill"></i> Parent Accounts</a></li>
                 <li><a href="admin_student_management.php"><i class="bi bi-person-lines-fill"></i> Student Accounts</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <h1><i class="bi bi-people me-2"></i>Senior High Student Attendance</h1>
                <p>View and manage student attendance records</p>
            </div>

            <!-- Summary Cards -->
            <div class="summary-cards">
                <div class="summary-card total">
                    <i class="bi bi-people"></i>
                    <h3 id="totalStudents"><?php echo $totalStudents; ?></h3>
                    <p>Total Students</p>
                </div>
                <div class="summary-card rate">
                    <i class="bi bi-graph-up"></i>
                    <h3 id="overallRate"><?php echo $overallRate; ?>%</h3>
                    <p>Overall Attendance Rate</p>
                </div>
                <div class="summary-card present">
                    <i class="bi bi-check-circle"></i>
                    <h3 id="presentToday"><?php echo $presentToday; ?></h3>
                    <p>Present Today</p>
                </div>
                <div class="summary-card low-attendance">
                    <i class="bi bi-exclamation-triangle"></i>
                    <h3 id="lowAttendance"><?php echo $lowAttendance; ?></h3>
                    <p>Low Attendance</p>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Search Students</label>
                        <input type="text" class="form-control search-input" id="searchInput" 
                               placeholder="Search by name, student number, or date...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Grade & Section</label>
                        <select class="form-select filter-select" id="gradeFilter">
                            <option value="">All Grades</option>
                            <option value="Grade 11 - STEM ">Grade 11 - STEM </option>
                            <option value="Grade 11 - ABM ">Grade 11 - ABM</option>
                            <option value="Grade 12 - STEM ">Grade 12 - STEM</option>
                            <option value="Grade 12 - ABM ">Grade 12 - ABM</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select class="form-select filter-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="present">Present</option>
                            <option value="late">Late</option>
                            <option value="absent">Absent</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Attendance Rate</label>
                        <select class="form-select filter-select" id="rateFilter">
                            <option value="">All Rates</option>
                            <option value="high">High (≥90%)</option>
                            <option value="medium">Medium (75-89%)</option>
                            <option value="low">Low (<75%)</option>
                        </select>
                    </div>
                </div>
            </div>

            
      <!-- View Details Modal -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewDetailsLabel">Student Attendance Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
          <tbody>
            <tr><th>Student No.</th><td id="detailStudentNo"></td></tr>
            <tr><th>First Name</th><td id="detailFirstName"></td></tr>
            <tr><th>Last Name</th><td id="detailLastName"></td></tr>
            <tr><th>Grade & Section</th><td id="detailSection"></td></tr>
            <tr><th>Course/Strand</th><td id="detailStrand"></td></tr>
            <tr><th>Total Days</th><td id="detailTotalDays"></td></tr>
            <tr><th>Present</th><td id="detailPresent"></td></tr>
            <tr><th>Late</th><td id="detailLate"></td></tr>
            <tr><th>Absent</th><td id="detailAbsent"></td></tr>
            <tr><th>Attendance Rate</th><td id="detailRate"></td></tr>
            <tr><th>Date</th><td id="detailDate"></td></tr>
            <tr><th>Status</th><td id="detailStatus"></td></tr>
            <tr><th>Time In</th><td id="detailTimeIn"></td></tr>
            <tr><th>Time Out</th><td id="detailTimeOut"></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Table Section -->
<div class="table-section">
  <div class="table-header">
    <h3><i class="bi bi-table me-2"></i>Student Attendance Records</h3>
    <div class="export-buttons">
      <button class="btn btn-success btn-sm" onclick="exportToCSV()">
        <i class="bi bi-file-earmark-excel"></i> Export CSV
      </button>
      <button class="btn btn-danger btn-sm" onclick="exportToPDF()">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
      </button>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0" id="recordsTable">
      <thead>
        <tr>
          <th onclick="sortTable(0)">Student No. <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(1)">First Name <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(2)">Last Name <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(3)">Grade & Section <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(4)">Course/Strand <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(5)">Total Days <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(6)">Present <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(7)">Late <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(8)">Absent <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(9)">Rate % <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(10)">Date <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(11)">Status <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(12)">Time In <i class="bi bi-arrow-down-up"></i></th>
          <th onclick="sortTable(13)">Time Out <i class="bi bi-arrow-down-up"></i></th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="recordsTableBody">
        <?php
        if (!empty($grouped_attendance)) {
          foreach ($grouped_attendance as $grade => $strands) {
            foreach ($strands as $strand => $students) {
              foreach ($students as $row) {

                $studentNo = htmlspecialchars($row['student_no']);
                $firstName = htmlspecialchars($row['fname']);
                $lastName  = htmlspecialchars($row['lname']);
                $section   = htmlspecialchars($row['year_level']);
                $strand    = htmlspecialchars($row['strand_course']);

                // Totals
                $countSql = $con->prepare("
                  SELECT 
                    COUNT(*) AS total_days,
                    SUM(status='Present') AS present_days,
                    SUM(status='Late') AS late_days
                  FROM attendance_logs
                  WHERE student_no = ?
                ");
                $countSql->bind_param("s", $studentNo);
                $countSql->execute();
                $counts = $countSql->get_result()->fetch_assoc();
                $countSql->close();

                $totalDays    = $counts['total_days'] ?? 0;
                $present      = $counts['present_days'] ?? 0;
                $late         = $counts['late_days'] ?? 0;
                $totalPresent = $present + $late;
                $absent       = $totalDays - $totalPresent;
                $rate         = $totalDays > 0 ? round(($totalPresent / $totalDays) * 100, 1) : 0;

                $date    = !empty($row['date']) ? date("M d, Y", strtotime($row['date'])) : '–';
                $timeIn  = !empty($row['time_in']) ? date("g:i A", strtotime($row['time_in'])) : '–';
                $timeOut = !empty($row['time_out']) ? date("g:i A", strtotime($row['time_out'])) : '–';

                $status = strtolower($row['status']);
                $statusClass = $status === 'present' ? 'status-present' : ($status === 'late' ? 'status-late' : 'status-absent');
                $statusIcon  = $status === 'present' ? 'check-circle' : ($status === 'late' ? 'clock' : 'x-circle');

                $rateClass = $rate >= 90 ? 'high' : ($rate >= 75 ? 'medium' : 'low');
                $lowRowClass = $rate < 75 ? 'low-attendance-row' : '';

                echo "<tr class='{$lowRowClass}'>
                  <td>{$studentNo}</td>
                  <td>{$firstName}</td>
                  <td>{$lastName}</td>
                  <td>{$section}</td>
                  <td>{$strand}</td>
                  <td>{$totalDays}</td>
                  <td>{$present}</td>
                  <td>{$late}</td>
                  <td>{$absent}</td>
                  <td><span class='attendance-rate {$rateClass}'>{$rate}%</span></td>
                  <td>{$date}</td>
                  <td><span class='status-badge {$statusClass}'><i class='bi bi-{$statusIcon}'></i> " . ucfirst($status) . "</span></td>
                  <td>{$timeIn}</td>
                  <td>{$timeOut}</td>
                  <td>
                    <div class='action-buttons'>
                      <button class='btn btn-outline-info btn-sm' onclick='viewDetails(this)' title='View Details'><i class='bi bi-eye'></i></button>
                      <button class='btn btn-outline-danger btn-sm' onclick='deleteRecord(this)' title='Delete'><i class='bi bi-trash'></i></button>
                    </div>
                  </td>
                </tr>";
              }
            }
          }
        } else {
          echo "<tr><td colspan='15' class='text-center'>No records found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete <span id="deleteStudentName"></span>’s record?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes</button>
      </div>
    </div>
  </div>
</div>



 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<script>
  function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'pt', 'a4');

    const headers = [
        "Student No", "First Name", "Last Name", "Grade & Sec",
        "Course/Strand", "Total Days", "Present", "Late", "Absent",
        "Rate %", "Date", "Status", "Time In", "Time Out"
    ];

    const data = [];

    document
        .querySelectorAll('#recordsTable tbody tr:not([style*="display: none"])')
        .forEach(tr => {
            const row = Array.from(tr.querySelectorAll('td'))
                .slice(0, -1) // ✅ REMOVE ACTIONS COLUMN
                .map(td => td.textContent.trim());

            data.push(row);
        });

    doc.autoTable({
        head: [headers],
        body: data,
        startY: 20,
        styles: { fontSize: 8 },
        headStyles: { fillColor: [41, 128, 185] }
    });

    doc.save('attendance_records.pdf');
}


/* =========================
   SIDEBAR, FILTER, SORT, SUMMARY CARDS, DELETE, CSV & VIEW DETAILS
========================= */
function toggleSidebar() { 
    document.getElementById('sidebar').classList.toggle('show'); 
}

/* =========================
   SORT TABLE
========================= */
let sortDirection = {};
function sortTable(columnIndex) {
    const tbody = document.querySelector('#recordsTable tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    sortDirection[columnIndex] = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';
    rows.sort((a, b) => {
        const A = a.cells[columnIndex].textContent.trim();
        const B = b.cells[columnIndex].textContent.trim();
        if (!isNaN(A) && !isNaN(B)) return sortDirection[columnIndex] === 'asc' ? A - B : B - A;
        return sortDirection[columnIndex] === 'asc' ? A.localeCompare(B) : B.localeCompare(A);
    });
    rows.forEach(r => tbody.appendChild(r));
}

/* =========================
   FILTER TABLE
========================= */
function filterTable() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const gradeFilter = document.getElementById('gradeFilter').value.toLowerCase();

    document.querySelectorAll('#recordsTableBody tr').forEach(r => {
        const rowText = r.textContent.toLowerCase();
        const gradeText = r.cells[3].textContent.toLowerCase(); // Grade & Section column
        // Show row only if it matches both search term AND grade filter
        if (rowText.includes(searchTerm) && (gradeFilter === '' || gradeText.includes(gradeFilter))) {
            r.style.display = '';
        } else {
            r.style.display = 'none';
        }
    });

    updateSummaryCards();
}

function clearFilters() { 
    document.getElementById('searchInput').value = ''; 
    document.getElementById('gradeFilter').value = '';
    filterTable(); 
}

/* =========================
   SUMMARY CARDS
========================= */
function updateSummaryCards() {
    const rows = document.querySelectorAll('#recordsTableBody tr:not([style*="display: none"])');
    let total = rows.length, present = 0, low = 0, totalRate = 0;
    rows.forEach(r => {
        const status = r.cells[10].textContent.toLowerCase();
        const rate   = parseFloat(r.cells[8].textContent) || 0;
        if (status.includes('present')) present++;
        if (rate < 75) low++;
        totalRate += rate;
    });
    document.getElementById('totalStudents').textContent = total;
    document.getElementById('presentToday').textContent = present;
    document.getElementById('lowAttendance').textContent = low;
    document.getElementById('overallRate').textContent = total > 0 ? (totalRate / total).toFixed(1) + '%' : '0%';
}

/* =========================
   DELETE RECORD
========================= */
let rowToDelete = null; // store the row temporarily

function deleteRecord(btn) {
    rowToDelete = btn.closest('tr'); // store the row
    const studentName = `${rowToDelete.cells[1].textContent} ${rowToDelete.cells[2].textContent}`;
    document.getElementById('deleteStudentName').textContent = studentName;

    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Bind the confirm delete button in the modal
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (rowToDelete) {
        rowToDelete.remove(); // delete the row from the table
        rowToDelete = null;   // reset

        // OPTIONAL: call a function to update summary cards or send AJAX to delete from DB
        // updateSummaryCards();
        // deleteFromDatabase(studentNo);
    }

    // Hide the modal
    const deleteModalEl = document.getElementById('deleteModal');
    const deleteModal = bootstrap.Modal.getInstance(deleteModalEl);
    deleteModal.hide();
});



/* =========================
   EXPORT CSV
========================= */
function exportToCSV() {
    const rows = document.querySelectorAll('#recordsTable tr:not([style*="display: none"])');
    let csv = [];

    rows.forEach((r, i) => {
        let cells;

        if (i === 0) {
            // HEADER — alisin Actions
            cells = Array.from(r.querySelectorAll('th')).slice(0, -1);
        } else {
            // BODY — alisin Actions
            cells = Array.from(r.querySelectorAll('td')).slice(0, -1);
        }

        csv.push(cells.map(c => `"${c.textContent.trim()}"`).join(','));
    });

    const blob = new Blob([csv.join('\n')], { type: 'text/csv' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'attendance_records.csv';
    a.click();
    URL.revokeObjectURL(a.href);
}


/* =========================
   VIEW DETAILS MODAL
========================= */
function viewDetails(btn) {
    const row = btn.closest('tr');
    document.getElementById('detailStudentNo').textContent = row.cells[0].textContent;
    document.getElementById('detailFirstName').textContent = row.cells[1].textContent;
    document.getElementById('detailLastName').textContent  = row.cells[2].textContent;
    document.getElementById('detailSection').textContent   = row.cells[3].textContent;
    document.getElementById('detailStrand').textContent    = row.cells[4].textContent;
    document.getElementById('detailTotalDays').textContent = row.cells[5].textContent;
    document.getElementById('detailPresent').textContent   = row.cells[6].textContent;
    document.getElementById('detailLate').textContent      = row.cells[7].textContent;
    document.getElementById('detailAbsent').textContent    = row.cells[8].textContent;
    document.getElementById('detailRate').textContent      = row.cells[9].textContent;
    document.getElementById('detailDate').textContent      = row.cells[10].textContent;
    document.getElementById('detailStatus').textContent    = row.cells[11].textContent;
    document.getElementById('detailTimeIn').textContent    = row.cells[12].textContent;
    document.getElementById('detailTimeOut').textContent   = row.cells[13].textContent;

    const modal = new bootstrap.Modal(document.getElementById('viewDetailsModal'));
    modal.show();
}

/* =========================
   INIT
========================= */
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('searchInput').addEventListener('input', filterTable);
    document.getElementById('gradeFilter').addEventListener('change', filterTable);
    updateSummaryCards();
});
</script>
