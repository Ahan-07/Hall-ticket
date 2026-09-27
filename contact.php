<?php
session_start();
require 'config.php';

if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}

$name = $email = $enrollment = $dept = $sem = $message = "";
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $enrollment = trim($_POST['enrollment']);
    $dept = trim($_POST['dept']);
    $sem = trim($_POST['sem']);
    $message = trim($_POST['message']);

    // Validation
    if (empty($name)) $errors[] = "Name is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (!preg_match("/^[0-9]{5,10}$/", $enrollment)) $errors[] = "Valid enrollment number required";
    if (empty($dept)) $errors[] = "Department is required";
    if (!is_numeric($sem) || $sem < 1 || $sem > 8) $errors[] = "Semester must be between 1 and 8";
    if (strlen($message) < 10) $errors[] = "Message must be at least 10 characters";

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO contact_queries (name, email, enrollment, dept, sem, message) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $enrollment, $dept, $sem, $message]);
        $success = true;

        // Clear form fields after submission
        $name = $email = $enrollment = $dept = $sem = $message = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact - Hall Ticket Support</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #e3f2fd, #fff);
      min-height: 100vh;
    }
    .form-section {
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      padding: 40px;
      max-width: 700px;
      margin: auto;
    }
    .form-control:focus {
      border-color: #28a745;
      box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    .fade-out {
      animation: fadeOut 2s forwards;
    }
    @keyframes fadeOut {
      to { opacity: 0; visibility: hidden; }
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
                    <!-- <?php if ($user): ?> -->
                    <li class="nav-item fw-bold"><span class="nav-link">👋 Hello,
                            <strong><?= htmlspecialchars($_SESSION['student_name'] ?? '') ?></strong></span></li>
                            <li class="nav-item fw-bold "><a class="nav-link" href="Student_info.php">Dashboard</a></li>
                    <li class="nav-item fw-bold "><a class="nav-link" href="logout.php">Logout</a></li>
                    <!-- <?php else: ?> -->
                    <li class="nav-item fw-bold"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="register.php">Register</a></li>
                    <!-- <?php endif; ?> -->
                </ul>
            </div>

        </div>
    </nav>
<!-- contact form -->
<div class="container py-2">
  <div class="form-section animate__animated animate__fadeInUp">
    <h2 class="text-center mb-4 text-success fw-bold">Contact Support</h2>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger animate__animated animate__shakeX">
        <ul class="mb-0">
          <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert alert-success animate__animated animate__fadeInDown" id="successMsg">
        ✅ Your message has been sent successfully!
      </div>
    <?php endif; ?>

    <form id="contactForm" method="POST" novalidate>
      <div class="mb-3">
        <label class="form-label">Full Name *</label>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" class="form-control" required>
        <div class="invalid-feedback">Name is required.</div>
      </div>

      <div class="mb-3">
        <label class="form-label">Email *</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="form-control" required>
        <div class="invalid-feedback">Enter a valid email.</div>
      </div>

      <div class="mb-3">
        <label class="form-label">Enrollment Number *</label>
        <input type="text" name="enrollment" value="<?= htmlspecialchars($enrollment) ?>" class="form-control" required pattern="\d{5,10}">
        <div class="invalid-feedback">Enter a valid enrollment$enrollment number (5–10 digits).</div>
      </div>

      <div class="mb-3">
        <label class="form-label">Department *</label>
        <input type="text" name="dept" value="<?= htmlspecialchars($dept) ?>" class="form-control" required>
        <div class="invalid-feedback">Department is required.</div>
      </div>

      <div class="mb-3">
        <label class="form-label">Semester (1–8) *</label>
        <input type="number" name="sem" value="<?= htmlspecialchars($sem) ?>" class="form-control" required min="1" max="8">
        <div class="invalid-feedback">Semester must be between 1 and 8.</div>
      </div>

      <div class="mb-3">
        <label class="form-label">Message *</label>
        <textarea name="message" class="form-control" required rows="5"><?= htmlspecialchars($message) ?></textarea>
        <div class="invalid-feedback">Message must be at least 10 characters.</div>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-success btn-lg">Send Message</button>
      </div>
    </form>
  </div>
</div>
<!-- footer -->
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
<script>
  // Bootstrap validation
  const form = document.getElementById('contactForm');
  form.addEventListener('submit', function (event) {
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add('was-validated');
  });

  // Auto fade-out success message
  const success = document.getElementById("successMsg");
  if (success) {
    setTimeout(() => {
      success.classList.add('fade-out');
    }, 3000);
  }
</script>

</body>
</html>
