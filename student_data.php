<?php
session_start();
require 'config.php';
$studentName = $_SESSION['student_name'] ?? 'Student Name';
$sessionYear = "2024-2025";
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$_SESSION['student_id']]);
$student = $stmt->fetch();

if (!$student) {
    die("Student record not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Data Sheet</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f5f5;
      /* padding: 20px; */
    }
     .sidebar {
      width: 220px;
      background: #2196F3;
      color: white;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      padding-top: 20px;
    }
    .sidebar a {
      color: white;
      padding: 10px 20px;
      display: block;
      text-decoration: none;
    }
    .sidebar a:hover {
      background: #1976D2;
    }
    .main-content {
      margin-left: 220px;
      padding: 2px 0px 20px 2px;
    }
    .data-sheet {
      background: white;
      padding: 30px;
      border: 2px solid #ccc;
      max-width: 900px;
      margin: auto;
    }
    .logo {
      width: 80px;
      height: auto;
    }
    .profile-photo {
      width: 110px;
      height: 130px;
      object-fit: cover;
      border: 2px solid #000;
    }
    .section-title {
      background: #e9ecef;
      padding: 5px 10px;
      font-weight: bold;
    }
    .print-btn {
      margin: 20px auto;
      display: block;
    }
    @media print {
      .print-btn {
        display: none;
      }
    }
    .main-content {
      margin-left: 220px;
    }
    .top-bar {
      background: #0d6efd;
      color: white;
      padding: 30px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .icon-tile {
      background: #e3f2fd;
      padding: 15px;
      border-radius: 15px;
      text-align: center;
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .icon-tile:hover {
      background: #bbdefb;
      transform: translateY(-3px);
    }
    .icon-tile img {
      width: 60px;
      height: 60px;
      margin-bottom: 10px;
    }
    .clock-box {
      font-size: 1rem;
      margin: 20px;
      color: white;
      text-align: center;
    }
  </style>
</head>
<body>
<div class="sidebar">
  <div class="clock-box" id="clock">
    ⏳ Loading...
  </div>
  <a href="student_info.php">🏠 Dashboard</a>
  <a href="index.php">🏠Home</a>
  <a href="contact.php">👨‍💻Contact</a>
  <a href="forget_password.php">🔑 Change Password</a>
  <a href="logout.php">🚪 Logout</a>
</div>

<div class="main-content" id="s_data">
  <!-- Top Bar -->
  <div class="top-bar animate__animated animate__fadeInDown">
    <div><strong>CONTROLLER OF EXAMINATION</strong></div>
    <div class="badge bg-warning text-dark"><?= $sessionYear ?></div>
    <div>👤 <?= htmlspecialchars($studentName) ?></div>
  </div>

<div class="data-sheet my-5" id="print-section">
  <div class="text-center mb-3">
    <img src="asset/logo.svg" alt="JMI Logo" class="logo mb-2">
    <h4>JAMIA MILLIA ISLAMIA</h4>
    <h5 class="text-muted">STUDENT DATA SHEET</h5>
  </div>

  <table class="table table-bordered align-middle">
    <tr>
      <td><strong>Candidate Name</strong><br><?= htmlspecialchars($student['candidate_name']) ?></td>
      <td rowspan="7" style="text-align: center;">
        <img src="<?= htmlspecialchars($student['image_path']) ?>" alt="Photo" class="profile-photo">
      </td>
    </tr>
    <tr>
      <td><strong>Enrollment No</strong><br><?= $student['enrollment_no'] ?></td>
    </tr>
    <tr>
      <td><strong>Roll No</strong><br><?= htmlspecialchars($student['roll_no']) ?></td>
    </tr>
    <tr>
      <td><strong>Father's Name</strong><br><?= $student['father_name'] ?></td>
    </tr>
    <tr>
      <td><strong>Mother's Name</strong><br><?= $student['mother_name'] ?></td>
    </tr>
    <tr>
      <td><strong>Date of Birth</strong><br><?= $student['dob'] ?></td>
    </tr>
    <tr>
      <td><strong>Gender</strong><br><?= $student['gender'] ?></td>
    </tr>
    <tr>
      <td><strong>Nationality</strong><br><?= $student['nationality'] ?></td>
      <td><strong>Religion</strong><br><?= $student['religion'] ?></td>
    </tr>
    <tr>
      <td><strong>Course</strong><br><?= $student['course'] ?></td>
      <td><strong>Year of Admission</strong><br><?= $student['admission_year'] ?></td>
    </tr>
    <tr>
      <td><strong>Email</strong><br><?= $student['email'] ?></td>
      <td><strong>Mobile No</strong><br><?= $student['mobile'] ?? 'N/A' ?></td>
    </tr>
  </table>

  <!-- <div class="section-title">PRESENT ADDRESS</div>
  <table class="table table-bordered">
    <tr>
      <td><strong>Address</strong><br><?= $student['present_address'] ?? '-' ?></td>
      <td><strong>District</strong><br><?= $student['present_district'] ?? '-' ?></td>
      <td><strong>Pin Code</strong><br><?= $student['present_pin'] ?? '-' ?></td>
    </tr>
    <tr>
      <td><strong>State</strong><br><?= $student['present_state'] ?? '-' ?></td>
      <td><strong>Country</strong><br><?= $student['present_country'] ?? '-' ?></td>
      <td><strong>Email</strong><br><?= $student['email'] ?></td>
    </tr>
  </table> -->

  <!-- <div class="section-title">PERMANENT ADDRESS</div>
  <table class="table table-bordered">
    <tr>
      <td><strong>Address</strong><br><?= $student['permanent_address'] ?? '-' ?></td>
      <td><strong>District</strong><br><?= $student['permanent_district'] ?? '-' ?></td>
      <td><strong>Pin Code</strong><br><?= $student['permanent_pin'] ?? '-' ?></td>
    </tr>
    <tr>
      <td><strong>State</strong><br><?= $student['permanent_state'] ?? '-' ?></td>
      <td><strong>Country</strong><br><?= $student['permanent_country'] ?? '-' ?></td>
      <td><strong>Email</strong><br><?= $student['email'] ?></td>
    </tr>
  </table> -->

  <div class="text-end mt-4">
    <p><strong>__________________________</strong><br>Full Signature of Applicant</p>
  </div>
</div>
<button onclick="printSection('print-section')" class="btn btn-success print-btn">🖨️ Print</button>
<button id="print" class="btn btn-primary print-btn">Download</button>
<!-- jsPDF + html2canvas CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- Clock Script -->
<script>
function updateClock() {
  const now = new Date();
  const time = now.toLocaleTimeString();
  const date = now.toLocaleDateString(undefined, { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' });
  document.getElementById('clock').innerHTML = `<strong>${time}</strong><br>${date}`;
}
setInterval(updateClock, 1000);
updateClock();

document.getElementById("print")?.addEventListener("click", async () => {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  const preview = document.getElementById("print-section");
  const canvas = await html2canvas(preview, { scale: 2 });

  const imgData = canvas.toDataURL("image/png");
  const pdfWidth = doc.internal.pageSize.getWidth();
  const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

  doc.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
  doc.save("student_data.pdf");
});


function printSection(sectionId) {
  var printContents = document.getElementById(sectionId).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
  location.reload(); // To restore JS events and state
}


</script>

</body>
</html>
