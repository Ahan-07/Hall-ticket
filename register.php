<?php
require 'config.php';

$errors = [];
$success = false;

// Form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add 'roll_no' to the fields array
    $fields = ['candidate_name', 'enrollment_no', 'roll_no', 'father_name', 'mother_name', 'dob', 'gender', 'nationality', 'religion', 'course', 'admission_year', 'email', 'password'];
    foreach ($fields as $f) {
        $$f = trim($_POST[$f]);
        if (empty($$f)) $errors[] = ucfirst(str_replace('_', ' ', $f)) . " is required.";
    }

    // Image upload
    $image_path = '';
    if ($_FILES['photo']['error'] == 0) {
        $imgName = $_FILES['photo']['name'];
        $imgTmp = $_FILES['photo']['tmp_name'];
        $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];

        if (!in_array($imgExt, $allowed)) {
            $errors[] = "Only JPG, JPEG, PNG images allowed.";
        } else {
            $newName = uniqid('stu_', true) . "." . $imgExt;
            $dest = "uploads/" . $newName;
            move_uploaded_file($imgTmp, $dest);
            $image_path = $dest;
        }
    } else {
        $errors[] = "Photo is required.";
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    // Password length check
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    
    // If no errors, insert
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO students 
            (candidate_name, enrollment_no, roll_no, father_name, mother_name, dob, gender, nationality, religion, course, admission_year, email, password_hash, image_path)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $candidate_name, $enrollment_no, $roll_no, $father_name, $mother_name, $dob, $gender, $nationality, $religion, $course, $admission_year, $email,
            password_hash($password, PASSWORD_DEFAULT), $image_path
        ]);
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body { 
      background: linear-gradient(to right, #e3ffe7, #d9e7ff); 
    }
    .form-container {
      max-width: 800px; 
      background: #fff; 
      padding: 30px;
      border-radius: 12px; 
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
     .navbar-center-absolute {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: max-content;
            z-index: 1;
            pointer-events: none;
            /* Prevents blocking nav toggler on mobile */
        }

        @media (max-width: 991.98px) {
            .navbar-center-absolute {
                position: static;
                transform: none;
                width: 100%;
                pointer-events: auto;
                /* margin-bottom: 1rem; */
            }
        }

        .navbar .navbar-brand,
        .navbar .navbar-toggler {
            z-index: 2;
        }

        .borders {
            border-bottom: 5px solid green;
        }
  </style>
</head>
<body>
    <!-- navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 py-4 borders">
        <div
            class="container-fluid d-flex align-items-center justify-content-between w-100 flex-wrap position-relative">

            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center me-3 py-0 " href="index.php">
                <img src="asset/logo.svg" alt="Logo" width="320" style="mix-blend-mode: multiply;">
            </a>

            <!-- University Info (centered absolutely) -->
            <div class="navbar-center-absolute py-4">
                <h2 class="text-success mb-1 fs-5 fw-semibold">Office of the Controller of Examination</h2>
                <h3 class="mb-1 fs-6 text-dark">JAMIA MILLIA ISLAMIA</h3>
                <h5 class="mb-0 fs-6 text-dark">A CENTRAL UNIVERSITY</h5>
            </div>

            <!-- Navbar toggle (for mobile) -->
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item fw-bold"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="register.php">Register</a></li>
                </ul>
            </div>

        </div>
    </nav>
<!-- main -->
<div class="d-flex justify-content-center align-items-center min-vh-100 py-2" style="background: linear-gradient(to right, #e3ffe7, #d9e7ff);">
    <div class="form-container animate__animated animate__fadeIn w-100" style="max-width:800px;">
      <h2 class="text-center mb-4 text-success fw-bold">Student Registration Form</h2>

      <?php if ($success): ?>
        <div class="alert alert-success">🎉 Registration successful!</div>
      <?php elseif (!empty($errors)): ?>
        <div class="alert alert-danger">
          <ul><?php foreach ($errors as $e) echo "<li>$e</li>"; ?></ul>
        </div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
          <label>Candidate Name *</label>
          <input type="text" name="candidate_name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Enrollment No. *</label>
          <input type="text" name="enrollment_no" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Roll No. *</label>
          <input type="text" name="roll_no" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Father's Name *</label>
          <input type="text" name="father_name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Mother's Name *</label>
          <input type="text" name="mother_name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Date of Birth *</label>
          <input type="date" name="dob" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Gender *</label>
          <select name="gender" class="form-select" required>
            <option value="">Select</option>
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
          </select>
        </div>
        <div class="col-md-6">
          <label>Nationality *</label>
          <input type="text" name="nationality" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Religion *</label>
          <input type="text" name="religion" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Course *</label>
          <input type="text" name="course" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Year of Admission *</label>
          <input type="number" name="admission_year" class="form-control" required min="2000" max="2099">
        </div>
        <div class="col-md-6">
          <label>Email *</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label>Password *</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-12">
          <label>Upload Photo *</label>
          <input type="file" name="photo" accept="image/*" class="form-control" required>
        </div>
        <div class="col-12 text-center">
          <button type="submit" class="btn btn-success btn-lg mt-3">Register</button>
        </div>
      </form>
    </div>
  </div>
 <footer class="bg-dark text-light pt-5 pb-4">
  <div class="container">
    <div class="row">

      <!-- Logo and Address -->
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="mb-3">
          <a href="/Home/index" title="Jamia Home">
            <img src="asset/logo.svg" alt="Jamia Logo" class="img-fluid w-75">
          </a>
        </div>
        <ul class="list-unstyled small">
          <li>Jamia Millia Islamia, Jamia Nagar,<br>New Delhi-110025, India</li>
          <li><a href="#" class="text-light text-decoration-none">+91(11)26981717, 26984617, 26984658, 26988044, 26987183</a></li>
          <li><a href="#" class="text-light text-decoration-none">+91(11)2698 0229</a></li>
        </ul>
      </div>

      <!-- Quick Links (optional) -->
      <div class="col-lg-4 col-md-6 mb-4">
        <h5 class="text-uppercase mb-3">Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-light text-decoration-none">About Jamia</a></li>
          <li><a href="#" class="text-light text-decoration-none">Examination Info</a></li>
          <li><a href="#" class="text-light text-decoration-none">Student Login</a></li>
          <li><a href="#" class="text-light text-decoration-none">Helpdesk</a></li>
        </ul>
      </div>

      <!-- Social Media -->
      <div class="col-lg-4 col-md-12">
        <h5 class="text-uppercase mb-3">Connect With Us</h5>
        <ul class="list-inline">
          <li class="list-inline-item me-2">
            <a href="https://www.facebook.com/jmiofficial" target="_blank" class="text-light fs-5" title="Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
          </li>
          <li class="list-inline-item me-2">
            <a href="https://www.linkedin.com/in/jmiofficial" target="_blank" class="text-light fs-5" title="LinkedIn">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </li>
          <li class="list-inline-item me-2">
            <a href="https://www.instagram.com/jamiamilliaislamia_official/" target="_blank" class="text-light fs-5" title="Instagram">
              <i class="fab fa-instagram"></i>
            </a>
          </li>
          <li class="list-inline-item me-2">
            <a href="https://twitter.com/jmiu_official" target="_blank" class="text-light fs-5" title="Twitter">
              <i class="fab fa-twitter"></i>
            </a>
          </li>
          <li class="list-inline-item me-2">
            <a href="https://www.youtube.com/channel/UCZOGZZ8jpsnBUffIL-47UZw" target="_blank" class="text-light fs-5" title="YouTube">
              <i class="fab fa-youtube"></i>
            </a>
          </li>
        </ul>
      </div>

    </div>

    <!-- Bottom Line -->
    <div class="text-center mt-4 border-top pt-3 small">
      © 2024 Hall-Ticket Generator· <a href="#" class="text-light text-decoration-none">Privacy</a> · <a href="#" class="text-light text-decoration-none">Terms</a>
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
            </script>
</body>
</html>
