<?php
session_start();
require 'config.php';

$error = '';

// Handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        // Check both email or enrollment_no
        $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ? OR enrollment_no = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Set session data
            $_SESSION['student_id'] = $user['id'];
            $_SESSION['student_name'] = $user['candidate_name'];
            $_SESSION['enrollment_no'] = $user['enrollment_no'];
            $_SESSION['image_path'] = $user['image_path'];

            // Redirect to dashboard
            header("Location: student_info.php");
            exit;
        } else {
            $error = "Invalid credentials. Please try again.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Login | Jamia Millia Islamia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      background: linear-gradient(135deg, #5f2c82, #49a09d);
      font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      border-radius: 15px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
      padding: 2rem;
      max-width: 420px;
      width: 100%;
      animation: fadeIn 0.8s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .form-control:focus {
      border-color: #fff;
      box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
    }
    .login-header {
      color: #fff;
    }
    .form-label, small {
      color: #e0e0e0;
    }
    .link-light:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="d-flex justify-content-center align-items-center vh-100">
  <div class="login-card text-white">
    <div class="text-center mb-4">
      <img src="asset/logo.svg" alt="Jamia Logo" width="300">
      <h4 class="login-header mt-2">Student Login</h4>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label"><i class="fa fa-user"></i> Email or Enrollment No</label>
        <input type="text" name="username" class="form-control" placeholder="Enter email or enrollment" required>
      </div>
      <div class="mb-4">
        <label class="form-label"><i class="fa fa-lock"></i> Password</label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn btn-light w-100 fw-bold">Login</button>
    </form>

    <div class="mt-4 text-center">
      <a href="forget_password.php" class="link-light d-block mb-2">Forgot Password?</a>
      <a href="register.php" class="link-light">Don't have an account? Sign Up</a>
    </div>

    <div class="text-center mt-4">
      <small>Jamia Millia Islamia © <?= date("Y") ?></small>
    </div>
  </div>
</div>

</body>
</html>
