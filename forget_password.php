<?php
session_start();
require 'config.php'; // Database connection

$email = '';
$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Simulate token (replace with real token in production)
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Save token in DB (you should have a `password_resets` table)
            $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)")
                ->execute([$email, $token, $expiry]);

            // Normally, you'd send an email with this link
            $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
            $message = "A password reset link has been sent to your email (simulation).<br><strong>Reset Link:</strong> <a href='$resetLink'>$resetLink</a>";
        } else {
            $error = "No user found with that email address.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f4f9fd;
    }
    .box {
      max-width: 500px;
      margin: 80px auto;
      padding: 30px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <div class="box">
    <h3 class="text-center text-primary mb-4">Forgot Password</h3>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($message): ?>
      <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Registered Email address</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="form-control" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Send Reset Link</button>
      </div>
      <div class="text-center mt-3">
        <a href="login.php" class="text-decoration-none">Back to Login</a>
      </div>
    </form>
  </div>
</body>
</html>
