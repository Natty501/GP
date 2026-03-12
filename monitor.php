<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance Monitor</title>
  <script src="/_sdk/element_sdk.js"></script>
  <style>
        body {
            box-sizing: border-box;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Georgia', 'Times New Roman', serif;
        }

        body {
            background: #f5f5f5;
            color: #333333;
            height: 100%;
            min-height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            overflow: hidden;
        }

        /* MAIN CONTAINER - Resume Style */
        .resume-container {
            width: 100%;
            max-width: 1400px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            height: calc(100% - 20px);
            max-height: calc(100% - 20px);
        }

        /* LEFT SIDEBAR - Resume Style */
        .sidebar {
            width: 300px;
            background: linear-gradient(135deg, #003366 0%, #004080 100%);
            color: white;
            padding: 25px 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            overflow-y: auto;
        }

        .college-header {
            text-align: center;
            border-bottom: 2px solid rgba(255,255,255,0.3);
            padding-bottom: 25px;
        }

        .college-name {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 8px;
            color: #ffc107;
        }

        .college-subtitle {
            font-size: 14px;
            color: rgba(255,255,255,0.8);
            font-style: italic;
        }

        .profile-section {
            text-align: center;
        }

        .profile-pic {
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            position: relative;
            overflow: hidden;
        }

        .profile-pic img {
            width: 180px;
            height: 180px;
            border-radius: 6px;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .profile-pic.active {
            border-color: #ffc107;
            box-shadow: 0 0 20px rgba(255,193,7,0.5);
        }

        .scanning-line {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #ffc107, transparent);
            animation: scanMove 2s linear infinite;
            opacity: 0;
        }

        .profile-pic.scanning .scanning-line {
            opacity: 1;
        }

        @keyframes scanMove {
            0% { top: 0; }
            100% { top: 100%; }
        }

        .status-display {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid rgba(255,255,255,0.3);
        }

        .status-display.active {
            background: #28a745;
            border-color: #28a745;
        }

        .status-display.error {
            background: #dc3545;
            border-color: #dc3545;
        }

        .status-display.processing {
            background: #ffc107;
            color: #000;
            border-color: #ffc107;
        }

        .system-info {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
        }

        .system-info h3 {
            font-size: 16px;
            margin-bottom: 15px;
            color: #ffc107;
        }

        .clock-display {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .date-display {
            font-size: 14px;
            color: rgba(255,255,255,0.8);
        }

        /* RIGHT CONTENT AREA - Resume Style */
        .content-area {
            flex: 1;
            padding: 25px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            overflow-y: auto;
        }

        .header-section {
            border-bottom: 3px solid #003366;
            padding-bottom: 20px;
        }

        .student-name {
            font-size: 32px;
            font-weight: 700;
            color: #003366;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .student-subtitle {
            font-size: 16px;
            color: #666;
            font-style: italic;
        }

        /* INFORMATION SECTIONS */
        .info-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 5px solid #003366;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #003366;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 8px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .info-label {
            font-weight: 600;
            color: #666;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: #333;
            font-size: 18px;
            font-weight: 500;
        }

        .time-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .time-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-top: 4px solid #28a745;
        }

        .time-card.time-out {
            border-top-color: #dc3545;
        }

        .time-card.empty {
            border-top-color: #dee2e6;
            background: #f8f9fa;
        }

        .time-label {
            font-size: 14px;
            font-weight: 600;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .time-value {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .time-card.empty .time-value {
            color: #999;
        }

      /* ================== Intro Screen ================== */
#introScreen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url('attendance.png') no-repeat center center/cover;
  background-size: cover;
  animation: gradientBG 15s ease infinite;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  cursor: pointer;
  overflow: hidden;
}

@keyframes gradientBG {
  0% { background-position:0% 50%; }
  50% { background-position:100% 50%; }
  100% { background-position:0% 50%; }
}

/* Semi-transparent overlay for readability */
#introScreen::before {
  content: "";
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(255,255,255,0.15);
  z-index: 0;
}

.intro-content {
  z-index: 1;
  text-align: center;
  color: #003366; /* Dark blue text for contrast */
  font-family: 'Arial', sans-serif;
  text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
}

.intro-content h1 {
  font-size: 48px;
  margin-bottom: 10px;
}

.intro-content {
  z-index: 1;
  text-align: center;
  color: white;
  font-size: 2rem;
  text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
}

/* ================== Floating Sakura Petals (soft pink/yellow for anime feel) ================== */
.petal {
  position: absolute;
  width: 15px;
  height: 15px;
  background: rgba(255, 230, 153, 0.8); /* soft yellow */
  border-radius: 50%;
  opacity: 0.7;
  animation: fall linear infinite;
}

@keyframes fall {
  0% { transform: translateY(-50px) rotate(0deg); }
  100% { transform: translateY(100vh) rotate(360deg); }
}

/* ================== Hide attendance initially ================== */
.hidden {
  display: none;
}

.toast {
  background-color: rgba(255, 0, 0, 0.85); /* red for invalid */
  color: white;
  padding: 12px 20px;
  border-radius: 8px;
  margin-top: 10px;
  font-weight: bold;
  box-shadow: 0 4px 6px rgba(0,0,0,0.2);
  opacity: 0;
  transform: translateX(100%);
  transition: all 0.5s ease;
}

.toast.show {
  opacity: 1;
  transform: translateX(0);
}


        /* ERROR MESSAGE */
        .error-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #dc3545;
            color: white;
            padding: 30px 50px;
            border-radius: 10px;
            font-size: 24px;
            font-weight: 600;
            box-shadow: 0 8px 32px rgba(220,53,69,0.4);
            z-index: 1000;
            opacity: 0;
            animation: errorFade 3s ease-in-out;
        }

        @keyframes errorFade {
            0% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
            20% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
            80% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
            100% { opacity: 0; transform: translate(-50%, -50%) scale(0.8); }
        }

        /* SUCCESS FLASH */
        .success-flash {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(40, 167, 69, 0.2);
            pointer-events: none;
            opacity: 0;
            animation: successFlash 0.6s ease-out;
        }

        @keyframes successFlash {
            0% { opacity: 0; }
            50% { opacity: 1; }
            100% { opacity: 0; }
        }

        /* RESPONSIVE DESIGN */
        @media (max-width: 768px) {
            .resume-container {
                flex-direction: column;
                max-width: 100%;
            }
            
            .sidebar {
                width: 100%;
                padding: 30px 20px;
            }
            
            .profile-pic {
                width: 150px;
                height: 150px;
            }
            
            .profile-pic img {
                width: 130px;
                height: 130px;
            }
            
            .content-area {
                padding: 30px 20px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .time-section {
                grid-template-columns: 1fr;
            }
        }

        
    </style>

  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
  <script src="https://cdn.tailwindcss.com" type="text/javascript"></script>
 </head>
 <body>
  <div class="resume-container">

  
<!-- Toast Container for Notifications -->
<div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 10000;"></div>

<!-- Intro Background -->
<div id="introScreen">
  <div class="intro-content">
    <p><strong>Tap your card to start</strong></p>
  </div>
</div>
    
  <!-- LEFT SIDEBAR - Resume Style -->
   <div class="sidebar">
    <div class="college-header">
     <div class="college-name" id="school_name">
      STI COLLEGE
     </div>
     <div class="college-name">
      ROSARIO
     </div>
     <div class="college-subtitle" id="department">
      Senior High Department
     </div>
    </div>
    <div class="profile-section">
     <div class="profile-pic" id="profile_container">
      <div class="scanning-line"></div><img id="student_photo" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='180' height='180' viewBox='0 0 180 180'%3E%3Crect width='180' height='180' fill='%23f8f9fa' rx='6'/%3E%3Ccircle cx='90' cy='65' r='25' fill='%23dee2e6'/%3E%3Cpath d='M45 135 Q45 110 90 110 Q135 110 135 135 L135 180 L45 180 Z' fill='%23dee2e6'/%3E%3Ctext x='90' y='150' text-anchor='middle' fill='%236c757d' font-size='12' font-family='Arial'%3EReady%3C/text%3E%3C/svg%3E" alt="Student Profile">
     </div>
     <div class="status-display" id="status_display">
      System Ready
     </div>
    </div>
    <div class="system-info">
     <h3>System Status</h3>
     <div class="clock-display" id="live_clock">
      00:00:00
     </div>
     <div class="date-display" id="date_display">
      Loading...
     </div>
    </div>
   </div>
   
   <!-- RIGHT CONTENT AREA - Resume Style -->
   <div class="content-area">
    <div class="header-section">
     <div class="student-name" id="student_name">
      Please Tap Your RFID Card
     </div>
     <div class="student-subtitle" id="student_subtitle">
      Waiting for student identification...
     </div>
    </div>
    <div class="info-section">
     <div class="section-title">
      Student Information
     </div>
     <div class="info-grid">
      <div class="info-item"><span class="info-label">Student Number</span> <span class="info-value" id="student_number">Waiting...</span>
      </div>
      <div class="info-item"><span class="info-label">Full Name</span> <span class="info-value" id="full_name">Waiting...</span>
      </div>
      <div class="info-item"><span class="info-label">Grade Level</span> <span class="info-value" id="grade_level">Waiting...</span>
      </div>
      <div class="info-item"><span class="info-label">Strand/Track</span> <span class="info-value" id="strand">Waiting...</span>
      </div>
     </div>
    </div>
    <div class="info-section">
     <div class="section-title">
      Attendance Record
     </div>
     <div class="time-section">
      <div class="time-card empty" id="time_in_card">
       <div class="time-label">
        Time In
       </div>
       <div class="time-value" id="time_in">
        --:--:--
       </div>
      </div>
      <div class="time-card time-out empty" id="time_out_card">
       <div class="time-label">
        Time Out
       </div>
       <div class="time-value" id="time_out">
        --:--:--
       </div>
      </div>
     </div>
    </div>
   <div class="info-section">
    <div class="section-title">
        System Message
    </div>

    <div class="info-item">
        <span class="info-label">Current Status</span> 
        <span class="info-value" id="attendance_status">Waiting for RFID card scan...</span>
    </div>

    <div class="info-item">
        <span class="info-label">Message</span>
        <span class="info-value" id="system_message">System Ready</span>
    </div>
</div>

  
<script>
let isProcessing = false;
let monitorVisible = false;


// Generate floating petals
const introScreen = document.getElementById('introScreen');
for(let i=0; i<20; i++) {
    const petal = document.createElement('div');
    petal.className = 'petal';
    petal.style.left = Math.random() * 100 + 'vw';
    petal.style.animationDuration = 5 + Math.random()*5 + 's';
    petal.style.width = 10 + Math.random()*10 + 'px';
    petal.style.height = petal.style.width;
    introScreen.appendChild(petal);
}

// ⭐ ADD: updateSystemMessage() — NO EXISTING CODE CHANGED
function updateSystemMessage(systemText, statusText) {
    const systemMsg = document.getElementById('system_message');
    const attendanceMsg = document.getElementById('attendance_status');

    if(systemMsg) systemMsg.textContent = systemText;
    if(attendanceMsg) attendanceMsg.textContent = statusText;
}

// Get current time
function getCurrentTime() {
    const now = new Date();
    return now.toLocaleTimeString('en-US', { hour12: true });
}

// Update live clock
function updateClock() {
    const now = new Date();
    document.getElementById('live_clock').textContent = now.toLocaleTimeString('en-US', { hour12: true });
    document.getElementById('date_display').textContent = now.toLocaleDateString('en-US', { 
        weekday:'long', 
        year:'numeric', 
        month:'long', 
        day:'numeric' 
    });
}

// Process RFID scan
async function processRFIDScan(rfidTag) {
    if(isProcessing) return;
    isProcessing = true;

    showScanningAnimation();
    updateSystemMessage("Scanning RFID...", "Processing...");

    try {
        const res = await fetch(`get_student.php?rfid=${rfidTag}`);
        const studentData = await res.json();

        if(studentData.error) {
            // Invalid card detected, show toast, keep intro visible
            showError(studentData.error);
            return;
        }

        // Valid card lang bago ipakita ang monitor
        if(!monitorVisible) {
            document.getElementById('introScreen').style.display = 'none';
            document.querySelector('.sidebar').classList.remove('hidden');
            document.querySelector('.content-area').classList.remove('hidden');
            monitorVisible = true;
        }

        processAttendance(rfidTag, studentData);

    } catch (err) {
        showError('Server Error');
    }
}

// Scanning animation
function showScanningAnimation() {
    const profileContainer = document.getElementById('profile_container');
    const status = document.getElementById('status_display');
    profileContainer.classList.add('scanning');
    status.textContent = 'Scanning Card...';
    status.className = 'status-display processing';
}

// Process attendance and update display
function processAttendance(rfidTag, studentData) {
    const currentTime = getCurrentTime();

    // Display student info agad
    document.getElementById('student_name').textContent = studentData.full_name;
    document.getElementById('student_number').textContent = studentData.student_no;
    document.getElementById('student_subtitle').textContent =
        `${studentData.grade} - ${studentData.strand} Student`;
    document.getElementById('full_name').textContent = studentData.full_name;
    document.getElementById('grade_level').textContent = studentData.grade;
    document.getElementById('strand').textContent = studentData.strand;
    document.getElementById('student_photo').src = studentData.photo || 'default_avatar.png';

    const timeInElement = document.getElementById('time_in');
    const timeOutElement = document.getElementById('time_out');
    const timeInCard = document.getElementById('time_in_card');
    const timeOutCard = document.getElementById('time_out_card');
    const status = document.getElementById('status_display');

    // Send RFID tap to PHP
    fetch("update_attendance.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ rfid: rfidTag, time: currentTime })
    })
    .then(res => res.json())
    .then(result => {

        if (!result.success) {
            status.textContent = result.message;
            status.className = "status-display error";
            return;
        }

       if (result.action === "time_in") {
    setTimeout(() => {
        timeInElement.textContent = currentTime;
        timeOutElement.textContent = "--:--:--";
        timeInCard.className = "time-card";
        timeOutCard.className = "time-card time-out empty";

        // ✅ Friendly message for monitor only
        let displayStatus = result.status;
        if(displayStatus === 'late') {
            displayStatus = "You're in! (A little late 😅)";
        }

        status.textContent = displayStatus;
        status.className = "status-display active";
        updateSystemMessage("Card Detected", displayStatus);

        // AUTO RESET BACKGROUND AFTER 5 SECONDS
        setTimeout(() => resetToBackground(), 5000);
    }, 2000); // 2 seconds delay
}


       else if (result.action === "time_out") {
    setTimeout(() => {
        timeOutElement.textContent = currentTime;
        timeOutCard.className = "time-card time-out";

        // ✅ Friendly message for monitor only
        let displayStatus = "Time Out Recorded"; 
        displayStatus = "See you later! Logged out 😎"; // Friendly version

        status.textContent = displayStatus;
        status.className = "status-display active";
        updateSystemMessage("Card Detected", displayStatus);

        // AUTO RESET BACKGROUND AFTER 5 SECONDS
        setTimeout(() => resetToBackground(), 5000);
    }, 2000); // 2 seconds delay
}


        else if (result.action === "already_timed_out") {
            status.textContent = "Already Timed Out";
            status.className = "status-display processing";
            updateSystemMessage("Card Detected", "Already Timed Out");

            // Optional: reset background after 5 seconds even if already timed out
            setTimeout(() => resetToBackground(), 5000);
        }
    });
}

function resetToBackground() {
    // Hide monitor
    document.querySelector('.sidebar').classList.add('hidden');
    document.querySelector('.content-area').classList.add('hidden');

    // Show background
    document.getElementById('introScreen').style.display = 'flex';

    // Reset flags and display
    monitorVisible = false;
    resetDisplay(); // optional: para ma-reset lahat ng student info / time
}


// Flash animation
function showSuccessFlash() {
    const flash = document.createElement('div');
    flash.className = 'success-flash';
    document.body.appendChild(flash);
    setTimeout(()=>{document.body.removeChild(flash)},600);
}

// Show invalid card as toast notification
function showError(message) {
    // Show toast instead of creating error div
    showToast(message);

    const status = document.getElementById('status_display');
    status.textContent = 'Invalid Card';
    status.className = 'status-display error';

    updateSystemMessage("Invalid RFID Card", "RFID Not Recognized");

    // Keep background visible, no monitor display
    resetDisplay(); // optional: reset partial info
    isProcessing = false; // allow next scan
}

function showToast(message) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = message;
    container.appendChild(toast);

    // Show animation
    setTimeout(() => toast.classList.add('show'), 50);

    // Hide after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if(container.contains(toast)) container.removeChild(toast);
        }, 500); // wait for fade out
    }, 3000);
}


// Reset display
function resetDisplay() {
    document.getElementById('student_name').textContent = 'Please Tap Your RFID Card';
    document.getElementById('student_subtitle').textContent = 'Waiting for student identification...';
    document.getElementById('full_name').textContent = 'Waiting...';
    document.getElementById('student_number').textContent = 'Waiting...';
    document.getElementById('grade_level').textContent = 'Waiting...';
    document.getElementById('strand').textContent = 'Waiting...';
    document.getElementById('time_in').textContent = '--:--:--';
    document.getElementById('time_out').textContent = '--:--:--';
    document.getElementById('attendance_status').textContent = 'Waiting for RFID card scan...';
    document.getElementById('time_in_card').className = 'time-card empty';
    document.getElementById('time_out_card').className = 'time-card time-out empty';
    document.getElementById('student_photo').src = "default_avatar.png";

    const profileContainer = document.getElementById('profile_container');
    const status = document.getElementById('status_display');
    profileContainer.classList.remove('scanning','active');
    status.textContent = 'System Ready';
    status.className = 'status-display';

    updateSystemMessage("System Ready", "Waiting for RFID card scan...");  // ⭐ ADDED

    isProcessing = false;
}

// Initialize
updateClock();
setInterval(updateClock,1000);
resetDisplay();

// Real RFID scan listener
document.addEventListener('DOMContentLoaded', () => {
    const rfidInput = document.createElement('input');
    rfidInput.type = 'text';
    rfidInput.id = 'rfid_input';
    rfidInput.autofocus = true;
    rfidInput.style.position = 'absolute';
    rfidInput.style.opacity = 0;
    document.body.appendChild(rfidInput);

    rfidInput.addEventListener('change', function() {
        const rfidTag = this.value.trim();
        if(rfidTag) processRFIDScan(rfidTag);
        this.value = '';
    });
    
});
</script>
