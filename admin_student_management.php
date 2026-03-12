<?php
session_start();
include("db.php"); 

// Fetch all students
$students_sql = "SELECT * FROM form ORDER BY lname ASC";
$result = $con->query($students_sql);

$college_students = [];
$shs_students = [];

while($row = $result->fetch_assoc()) {
    $year = strtolower($row['year_level']);
    if(strpos($year, 'grade') !== false) {
        $shs_students[] = $row;
    } else {
        $college_students[] = $row;
    }
}
?>

<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Account Management - GuidanceHub</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background-color: #ffffff;
            border-right: 1px solid #e0e0e0;
            padding: 2rem 0;
            position: fixed;
            height: 100%;
            z-index: 100;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.9rem 1.5rem;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .sidebar-nav a:hover, .sidebar-nav a.active {
            background-color: #f1f5f9;
            color: #2563eb;
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2.5rem;
        }

        .section-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .section-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .section-header.shs {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        /* FIX: Ito ang magpipigil sa pagpapatong ng buttons */
        .action-container {
            display: flex !important;
            gap: 6px !important;
            white-space: nowrap !important;
            min-width: 120px;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .sidebar { width: 100%; position: relative; height: auto; }
            .main-content { margin-left: 0; }
        }
    </style>
 </head>
 <body>
  <div class="dashboard-wrapper">
   <aside class="sidebar">
    <div class="px-4 mb-4">
     <h2 class="h5 fw-bold"><i class="bi bi-speedometer2 text-primary"></i> Admin Panel</h2>
    </div>
    <nav>
     <ul class="nav flex-column sidebar-nav">
       <li><a href="admin_dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
       <li><a href="admin_records.php"><i class="bi bi-people"></i> Student Records</a></li>
       <li><a href="admin_student_management.php" class="active"><i class="bi bi-person-lines-fill"></i> Student Accounts</a></li>
     </ul>
    </nav>
   </aside>
   
  <main class="main-content">
    <div class="mb-4">
        <h1 class="h2 fw-bold">Student Account Management</h1>
        <p class="text-muted">Manage all student records for college and senior high school</p>
    </div>

    <div class="card border-0 shadow-sm p-4 mb-4">
        <form class="row g-3" id="searchForm">
            <div class="col-md-6">
                <label class="form-label fw-bold">Search Student</label>
                <input type="text" id="searchInput" class="form-control" placeholder="Enter name or student number">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Student Type</label>
                <select id="typeFilter" class="form-control">
                    <option value="">All Students</option>
                    <option value="college">College</option>
                    <option value="shs">Senior High School</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Search</button>
            </div>
        </form>
    </div>

    <div class="section-card">
        <div class="section-header">
            <h2 class="h5 m-0">🎓 College Students</h2>
        </div>
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Student No</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Email | Birthday</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="collegeTableBody"></tbody>
            </table>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header shs">
            <h2 class="h5 m-0">🏫 Senior High Students</h2>
        </div>
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Student No</th>
                        <th>Name</th>
                        <th>Strand</th>
                        <th>Grade</th>
                        <th>RFID</th>
                        <th>Email | Birthday</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="shsTableBody"></tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="editStudentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <form id="editStudentForm">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Edit Student Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="editStudentId">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">First Name</label><input type="text" class="form-control" id="editFname" required></div>
                        <div class="col-md-4"><label class="form-label">Middle Name</label><input type="text" class="form-control" id="editMname"></div>
                        <div class="col-md-4"><label class="form-label">Last Name</label><input type="text" class="form-control" id="editLname" required></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" id="editEmail" required></div>
                        <div class="col-md-6"><label class="form-label">Birthday</label><input type="date" class="form-control" id="editBday" required></div>
                        <div class="col-md-6" id="rfidWrapper"><label class="form-label text-danger fw-bold">RFID</label><input type="text" class="form-control border-danger" id="editRFID"></div>
                        <div class="col-md-6"><label class="form-label">Course/Strand</label><input type="text" class="form-control" id="editStrandCourse" required></div>
                        <div class="col-md-6"><label class="form-label">Year Level / Grade</label><input type="text" class="form-control" id="editYearLevel" required></div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update Student</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteStudentModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Delete Student</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <p class="mb-0">Are you sure you want to delete this student?</p>
      </div>

      <div class="modal-footer justify-content-center">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
      </div>

    </div>
  </div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="toast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"><span id="toastMessage"></span></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
let students = <?php echo json_encode(array_merge($college_students, $shs_students)); ?>;
let searchTerm = '';
let typeFilter = '';
let deleteStudentId = null; // Stores the ID to delete when modal is confirmed

// RENDER STUDENTS
function renderStudents() {
    const collegeBody = document.getElementById('collegeTableBody');
    const shsBody = document.getElementById('shsTableBody');
    collegeBody.innerHTML = '';
    shsBody.innerHTML = '';

    const filtered = students.filter(s => {
        const fullName = `${s.fname} ${s.mname} ${s.lname}`.toLowerCase();
        const matchesSearch =
            fullName.includes(searchTerm.toLowerCase()) ||
            s.student_no.toLowerCase().includes(searchTerm.toLowerCase());
        const isSHS = s.year_level.toLowerCase().includes('grade');
        if (typeFilter === 'college') return matchesSearch && !isSHS;
        if (typeFilter === 'shs') return matchesSearch && isSHS;
        return matchesSearch;
    });

    filtered.forEach(s => {
        const isSHS = s.year_level.toLowerCase().includes('grade');
        const fullName = `${s.fname} ${s.mname !== "N/A" ? s.mname + ' ' : ''}${s.lname}`;
        const bday = new Date(s.bday).toLocaleDateString('en-US', {
            month: 'short', day: 'numeric', year: 'numeric'
        });

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${s.student_no}</td>
            <td class="fw-medium">${fullName}</td>
            <td>${s.strand_course}</td>
            <td>${s.year_level}</td>
            ${isSHS ? `<td class="text-primary fw-bold">${s.rfid || '---'}</td>` : ''}
            <td class="small text-muted">
                <i class="bi bi-envelope me-1"></i>${s.email}<br>
                <i class="bi bi-calendar me-1"></i>${bday}
            </td>
            <td>
                <div class="action-container">
                    <button class="btn btn-sm btn-primary edit-btn" data-id="${s.student_no}">Edit</button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="${s.student_no}">Delete</button>
                </div>
            </td>
        `;
        if (isSHS) shsBody.appendChild(row);
        else collegeBody.appendChild(row);
    });

    attachActionButtons();
}

// ATTACH BUTTON EVENTS
function attachActionButtons() {
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.onclick = () => editStudent(btn.dataset.id);
    });
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.onclick = () => showDeleteModal(btn.dataset.id);
    });
}

// EDIT STUDENT
function editStudent(id) {
    const s = students.find(st => st.student_no == id);
    if (!s) return;

    document.getElementById('editStudentId').value = s.student_no;
    document.getElementById('editFname').value = s.fname;
    document.getElementById('editMname').value = s.mname !== "N/A" ? s.mname : '';
    document.getElementById('editLname').value = s.lname;
    document.getElementById('editEmail').value = s.email;
    document.getElementById('editBday').value = s.bday;
    document.getElementById('editStrandCourse').value = s.strand_course;
    document.getElementById('editYearLevel').value = s.year_level;

    const isSHS = s.year_level.toLowerCase().includes('grade');
    document.getElementById('rfidWrapper').style.display = isSHS ? 'block' : 'none';
    document.getElementById('editRFID').value = s.rfid || '';

    new bootstrap.Modal(document.getElementById('editStudentModal')).show();
}

// SUBMIT EDIT FORM
document.getElementById("editStudentForm").onsubmit = function(e) {
    e.preventDefault();

    const studentData = {
        student_no: document.getElementById('editStudentId').value,
        fname: document.getElementById('editFname').value,
        mname: document.getElementById('editMname').value || "N/A",
        lname: document.getElementById('editLname').value,
        email: document.getElementById('editEmail').value,
        bday: document.getElementById('editBday').value,
        strand_course: document.getElementById('editStrandCourse').value,
        year_level: document.getElementById('editYearLevel').value,
        rfid: document.getElementById('editRFID').value || null
    };

    fetch("update_student.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(studentData)
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            const idx = students.findIndex(s => s.student_no == studentData.student_no);
            if(idx > -1) students[idx] = studentData; // update local array
            renderStudents();
            showToast("Student updated successfully", "bg-success");
            bootstrap.Modal.getInstance(document.getElementById('editStudentModal')).hide();
        } else {
            showToast("Update failed: " + (data.message || ""), "bg-danger");
        }
    })
    .catch(() => {
        showToast("Server error", "bg-danger");
    });
}

// SHOW DELETE MODAL
function showDeleteModal(id) {
    deleteStudentId = id;
    const modal = new bootstrap.Modal(document.getElementById('deleteStudentModal'));
    modal.show();
}

// CONFIRM DELETE
document.getElementById("confirmDeleteBtn").onclick = function () {
    if (!deleteStudentId) return;

    fetch("delete_student.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: deleteStudentId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            students = students.filter(s => s.student_no != deleteStudentId);
            renderStudents();
            showToast("Student deleted successfully", "bg-success");
        } else {
            showToast("Failed to delete student: " + (data.message || ""), "bg-danger");
        }
        bootstrap.Modal.getInstance(document.getElementById('deleteStudentModal')).hide();
    })
    .catch(() => {
        showToast("Server error", "bg-danger");
        bootstrap.Modal.getInstance(document.getElementById('deleteStudentModal')).hide();
    });
};

// SEARCH FORM
document.getElementById('searchForm').onsubmit = (e) => {
    e.preventDefault();
    searchTerm = document.getElementById('searchInput').value;
    typeFilter = document.getElementById('typeFilter').value;
    renderStudents();
};

// TOAST NOTIFICATION
function showToast(message, color) {
    const toastEl = document.getElementById("toast");
    const toastMsg = document.getElementById("toastMessage");
    toastMsg.innerText = message;
    toastEl.className = "toast align-items-center text-white border-0 " + color;
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}

// INITIAL LOAD
window.onload = renderStudents;
</script>