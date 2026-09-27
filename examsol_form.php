<?php
session_start();
require 'config.php';

$user = $_SESSION['user'] ?? null;
if (!$user) {
    header("Location: login.php");
    exit;
}

// Get student info
$stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
$stmt->execute([$user]);
$student = $stmt->fetch();

// Subject array for Diploma in Computer Engineering
$subjects = [
    "1" => [
        ["code" => "DCOS 101", "name" => "Communication Skill - I", "type" => "THEORY"],
        ["code" => "DCOM 102", "name" => "Applied Maths-I", "type" => "THEORY"],
        ["code" => "DEE 103", "name" => "Electrical and Electronics Engg.", "type" => "THEORY"],
        ["code" => "DME 104", "name" => "Elements of Mechanical Engg.", "type" => "THEORY"],
        ["code" => "DCO 105", "name" => "Fundamental of Computers", "type" => "THEORY"],
        ["code" => "DEE 113", "name" => "Electrical and Electronics Lab", "type" => "PRACTICAL"],
        ["code" => "DME 116", "name" => "Workshop Practice", "type" => "PRACTICAL"],
        ["code" => "DME 117", "name" => "Engineering Drawing", "type" => "PRACTICAL"],
        ["code" => "DCO 115", "name" => "P.C.Software Lab", "type" => "PRACTICAL"]
    ],
    "2" => [
        ["code" => "DCOM 201", "name" => "Applied Maths-II", "type" => "THEORY"],
        ["code" => "DCOP 202", "name" => "Applied Physics", "type" => "THEORY"],
        ["code" => "DEL 203", "name" => "Electronics Devices", "type" => "THEORY"],
        ["code" => "DCOC 204", "name" => "Engineering Chemistry", "type" => "THEORY"],
        ["code" => "DCO 205", "name" => "Programming in C", "type" => "THEORY"],
        ["code" => "DCOP 212", "name" => "Physics Lab", "type" => "PRACTICAL"],
        ["code" => "DEL 213", "name" => "Electronics Lab", "type" => "PRACTICAL"],
        ["code" => "DCOC 214", "name" => "Chemistry Lab", "type" => "PRACTICAL"],
        ["code" => "DCO 215", "name" => "C Programming Lab", "type" => "PRACTICAL"]
    ],
    "3" => [
        ["code" => "DCO 301", "name" => "Computer Oriented Numerical Methods", "type" => "THEORY"],
        ["code" => "DCO 302", "name" => "Object Oriented Programming", "type" => "THEORY"],
        ["code" => "DEE 303", "name" => "Signals & Systems", "type" => "THEORY"],
        ["code" => "DCO 304", "name" => "Computer Architecture", "type" => "THEORY"],
        ["code" => "DEL 306", "name" => "Digital Electronics", "type" => "THEORY"],
        ["code" => "DCO 312", "name" => "OOP Lab", "type" => "PRACTICAL"],
        ["code" => "DCO 314", "name" => "Computer Workshop", "type" => "PRACTICAL"],
        ["code" => "DCO 315", "name" => "Computer System & Maintenance", "type" => "PRACTICAL"],
        ["code" => "DEL 316", "name" => "Digital Electronics Lab", "type" => "PRACTICAL"]
    ],
    "4" => [
        ["code" => "DCOS 401", "name" => "Communication Skills - II", "type" => "THEORY"],
        ["code" => "DCO 402", "name" => "Database Management System", "type" => "THEORY"],
        ["code" => "DCO 403", "name" => "Operating System", "type" => "THEORY"],
        ["code" => "DCO 404", "name" => "Data Structures", "type" => "THEORY"],
        ["code" => "DEL 405", "name" => "Microprocessor & Microcontroller", "type" => "THEORY"],
        ["code" => "DCO 412", "name" => "DBMS Lab", "type" => "PRACTICAL"],
        ["code" => "DCO 413", "name" => "Operating System Lab", "type" => "PRACTICAL"],
        ["code" => "DCO 414", "name" => "Data Structures Lab", "type" => "PRACTICAL"],
        ["code" => "DEL 415", "name" => "Microprocessor Programming", "type" => "PRACTICAL"]
    ],
    "5" => [
        ["code" => "DCO 501", "name" => "Computer Graphics", "type" => "THEORY"],
        ["code" => "DCO 502", "name" => "Web Technology", "type" => "THEORY"],
        ["code" => "DCO 503", "name" => "Data Communication & Networks", "type" => "THEORY"],
        ["code" => "DCO 504", "name" => "Software Engineering", "type" => "THEORY"],
        ["code" => "DCO 505", "name" => "Java Programming", "type" => "THEORY"],
        ["code" => "DCO 511", "name" => "Graphics & Multimedia Lab", "type" => "PRACTICAL"],
        ["code" => "DCO 512", "name" => "Web Technology Lab", "type" => "PRACTICAL"],
        ["code" => "DCO 513", "name" => "Computer Networks Lab", "type" => "PRACTICAL"],
        ["code" => "DCO 515", "name" => "Java Programming Lab", "type" => "PRACTICAL"],
        ["code" => "DCO 520", "name" => "Minor Project", "type" => "PRACTICAL"]
    ],
    "6" => [
        ["code" => "DCO 601", "name" => "Advanced RDBMS", "type" => "THEORY"],
        ["code" => "DCO 602", "name" => "Visual Programming", "type" => "THEORY"],
        ["code" => "DCO 603", "name" => "Information Security & Cyber Law", "type" => "THEORY"],
        ["code" => "DCO 604", "name" => "Elective I", "type" => "THEORY"],
        ["code" => "DCO 608", "name" => "ICT Management & Entrepreneurship", "type" => "THEORY"],
        ["code" => "DCO 611", "name" => "Advanced RDBMS Lab", "type" => "PRACTICAL"],
        ["code" => "DCO 612", "name" => "Visual Programming Lab", "type" => "PRACTICAL"],
        ["code" => "DCO 620", "name" => "Major Project", "type" => "PRACTICAL"],
        ["code" => "DCO 630", "name" => "Industrial Training & Visits", "type" => "PRACTICAL"]
    ]
];


$course = $student['course'];
$course_normalized = strtolower(trim($course));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['semester'], $_POST['exam_type'], $_POST['subjects'])) {
    $_SESSION['exam_form'] = [
        "semester" => $_POST['semester'],
        "exam_type" => $_POST['exam_type'],
        "subjects" => $_POST['subjects']
    ];
    header("Location: exam_form.php");
    exit;
}

$exam_form = $_SESSION['exam_form'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Exam Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f9fd; }
    .form-box, .preview-box {
        background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 0 12px rgba(0,0,0,0.05);
        animation: fadeIn 0.5s ease-in-out;
    }
    .hidden { display: none; }
    @keyframes fadeIn { from {opacity: 0;} to {opacity: 1;} }
  </style>
</head>
<body class="container py-4">
<h3 class="text-center text-primary mb-4">Jamia Millia Islamia - Exam Form</h3>

<?php if (!$exam_form): ?>
<form method="POST" class="form-box">
  <div class="mb-3">
    <label>Course</label>
    <input type="text" class="form-control" value="<?= htmlspecialchars($course) ?>" readonly>
  </div>
  <div class="mb-3">
    <label>Semester</label>
    <select name="semester" id="semester" class="form-select" required>
      <option value="">-- Select Semester --</option>
      <?php for ($i = 1; $i <= 6; $i++): ?>
        <option value="<?= $i ?>">Semester <?= $i ?></option>
      <?php endfor; ?>
    </select>
  </div>
  <div class="mb-3">
    <label>Exam Type</label>
    <select name="exam_type" class="form-select" required>
      <option value="">-- Select Type --</option>
      <option value="Regular">Regular</option>
      <option value="Ex">Ex</option>
      <option value="Back">Back</option>
    </select>
  </div>
  <div id="subject-container" class="mb-4"></div>
  <button type="submit" class="btn btn-success">Submit Exam Form</button>
</form>
<?php else: ?>
<div class="preview-box" id="print-section">
  <h4 class="text-center text-success">Form A - Examination Confirmation</h4>
  <p><strong>Name:</strong> <?= htmlspecialchars($student['name']) ?></p>
  <p><strong>Enrollment:</strong> <?= htmlspecialchars($student['enrollment']) ?></p>
  <p><strong>Semester:</strong> <?= $exam_form['semester'] ?></p>
  <p><strong>Exam Type:</strong> <?= $exam_form['exam_type'] ?></p>
  <h5 class="mt-4">Subjects</h5>
  <ul class="list-group">
    <?php foreach ($exam_form['subjects'] as $sub): ?>
      <li class="list-group-item"><?= htmlspecialchars($sub) ?></li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="text-center mt-4">
  <button onclick="window.print()" class="btn btn-secondary">🖨️ Print</button>
  <button class="btn btn-outline-primary" id="download">⬇️ Download</button>
</div>

<div class="text-center mt-5">
  <h6 class="text-danger">⏳ Wait <span id="timer">60</span> seconds to Generate Admit Card</h6>
  <button class="btn btn-success hidden" id="generateBtn">Generate Admit Card</button>
</div>
<?php endif; ?>

<script>
  const allSubjects = <?= json_encode($subjects) ?>;
  const subjectContainer = document.getElementById("subject-container");
  const semesterSelect = document.getElementById("semester");

  if (semesterSelect) {
    semesterSelect.addEventListener("change", () => {
      const semester = semesterSelect.value;
      const list = allSubjects[semester] || [];
      let html = "<h5>Select Subjects</h5>";
      list.forEach((s, i) => {
        html += `
          <div class="form-check">
            <input type="checkbox" checked class="form-check-input" name="subjects[]" value="${s.code} - ${s.name} - ${s.type}" id="s${i}" >
            <label class="form-check-label" for="s${i}">${s.code} - ${s.name} (${s.type})</label>
          </div>`;
      });
      subjectContainer.innerHTML = html || "<p class='text-danger'>No subjects available.</p>";
    });
  }

  // Timer
  let sec = 60;
  const timerEl = document.getElementById("timer");
  const btn = document.getElementById("generateBtn");

  if (timerEl) {
    const countdown = setInterval(() => {
      sec--;
      timerEl.innerText = sec;
      if (sec <= 0) {
        clearInterval(countdown);
        btn.classList.remove("hidden");
      }
    }, 1000);
  }

  // Download = print fallback
  document.getElementById("download")?.addEventListener("click", () => window.print());
</script>
</body>
</html>
