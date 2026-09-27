<?php
session_start();
require 'config.php';

$studentName = $_SESSION['student_name'] ?? 'Student Name';
$sessionYear = "2024-2025";
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
// Assuming student is logged in
$studentName = $_SESSION['student_name'] ?? 'Student Name';
$sessionYear = "2024-2025";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f0f2f5;
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
    .row.justify-content-center {
  margin-top: 40px;
}
.icon-tile:hover {
  background: #c8e6ff;
  transform: scale(1.05);
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

  </style>
</head>
<body>

<!-- Sidebar -->
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

<!-- Main content -->
<div class="main-content">
  <!-- Top Bar -->
  <div class="top-bar animate__animated animate__fadeInDown">
    <div><strong>CONTROLLER OF EXAMINATION</strong></div>
    <div class="badge bg-warning text-dark"><?= $sessionYear ?></div>
    <div>👤 <?= htmlspecialchars($studentName) ?></div>
  </div>

  <!-- Dashboard Icons -->
  
   <div class="container mt-4 animate__animated animate__fadeInUp">
  <div class="row justify-content-center g-4">
    <!-- Student Data Tile -->
    <div class="col-lg-4 col-md-5 col-sm-6">
      <div class="icon-tile py-5">
        <i class="fas fa-user fa-3x mb-2"></i>
        <div><a href="student_data.php">
<strong>Student Data</strong>
        </a></div>
      </div>
    </div>

    <!-- Examination Form Tile -->
    <div class="col-lg-4 col-md-5 col-sm-6">
      <div class="icon-tile py-5">
       <i class="fas fa-user fa-3x mb-2"></i>
        <div><a href="exam_form.php"><strong>Examination Form</strong></a></div>
      </div>
    </div>
  </div>
</div>



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
</script>

</body>
</html>
