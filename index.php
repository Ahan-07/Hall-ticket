<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Hall_ticket Generator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-color: #dcdcdc;
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
                margin-bottom: 1rem;
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
                    <?php $user = isset($_SESSION['student_id']); ?>
                    <?php if ($user): ?>
                    <li class="nav-item fw-bold"><span class="nav-link">👋 Hello,
                            <strong><?= htmlspecialchars($_SESSION['student_name']) ?></strong></span></li>
                    <li class="nav-item fw-bold "><a class="nav-link" href="student_info.php">Dashboard</a></li>
                    <li class="nav-item fw-bold "><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php else: ?>
                    <li class="nav-item fw-bold"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </nav>




    <div id="carouselExampleDark" class="carousel slide " data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3"
                aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="4"
                aria-label="Slide 5"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="2000">
                <img src="asset/polytechnic.jpg " style="height: 70vh;" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block text-white">
                    <h4>Welcome to Jamia Millia Islamia</h4>
                    <h5>Controller of Examination</h5>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="asset/images2.jpg" style="height: 70vh;" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block text-white">
                    <h4>Welcome to Jamia Millia Islamia</h4>
                    <p>You don't have to be great to start, but you have to start to be great.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="asset/img3.jpg" style="height: 70vh;" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block text-white">
                    <h4>Welcome to Jamia Millia Islamia</h4>
                    <p>Mistakes are lessons, not failures.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="asset/images4.jpeg" style="height: 70vh;" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block text-white">
                    <h4>Welcome to Jamia Millia Islamia</h4>
                    <p>Don't wait for perfection; start writing today.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="asset/img5.jpg" style="height: 70vh;" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block ">
                    <h4>Welcome to Jamia Millia Islamia</h4>
                    <p>Fear less, write more.</p>

                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
</div>
        <!-- Hero Section with Call to Action -->
        <section class="text-center my-5">
            <h2 class="fw-bold mb-3 animate__animated animate__fadeInDown">Your Hall Ticket, Just One Click Away!</h2>
            <p class="mb-4 animate__animated animate__fadeIn animate__delay-1s">Download your examination hall ticket
                securely and instantly.</p>
            <a href="student_info.php"
                class="btn btn-success btn-lg px-4 py-2 animate__animated animate__pulse animate__infinite">Generate
                Now</a>
        </section>

        <!-- Information Cards Section -->
        <section class="container my-5">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 animate__animated animate__fadeInUp">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success">Exam Instructions</h5>
                            <p class="card-text">Know what to carry, exam timings, and other important details.</p>
                            <a href="#" class="btn btn-outline-success btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success">Exam Schedule</h5>
                            <p class="card-text">Check the latest date sheet and subject-wise exam slots.</p>
                            <a href="#" class="btn btn-outline-success btn-sm">View Schedule</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success">Results & Updates</h5>
                            <p class="card-text">Get updates on results, re-evaluation dates, and notices.</p>
                            <a href="#" class="btn btn-outline-success btn-sm">Check Updates</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
            </script>
            <?php if (isset($_GET['logged_out'])): ?>
<script>
    window.location.replace("index.php");
</script>
<?php endif; ?>
</body>
</html>