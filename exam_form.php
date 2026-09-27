<?php
session_start();
require 'config.php';

if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch student info
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$_SESSION['student_id']]);
$student = $stmt->fetch();

if (!$student) {
    die("Student record not found.");
}

// Subject array
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['semester'], $_POST['exam_type'], $_POST['subjects'])) {
    $stmtInsert = $pdo->prepare("INSERT INTO exam_forms (student_id, course, semester, type, subjects) VALUES (?, ?, ?, ?, ?)");
    $stmtInsert->execute([
        $student['id'],
        $student['course'],
        $_POST['semester'],
        $_POST['exam_type'],
        json_encode($_POST['subjects'])
    ]);
    header("Location: exam_form.php?success=1");
    exit;
}

// Fetch latest exam form from DB for this student
$stmtForm = $pdo->prepare("SELECT * FROM exam_forms WHERE student_id = ? ORDER BY id DESC LIMIT 1");
$stmtForm->execute([$student['id']]);
$exam_form_row = $stmtForm->fetch();

$exam_form = null;
if ($exam_form_row) {
    $exam_form = [
        "semester" => $exam_form_row['semester'],
        "exam_type" => $exam_form_row['type'],
        "subjects" => json_decode($exam_form_row['subjects'], true)
    ];
}
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
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 12px rgba(0,0,0,0.05);
        animation: fadeIn 0.5s ease-in-out;
    }
    .hidden { display: none; }
    @keyframes fadeIn { from {opacity: 0;} to {opacity: 1;} }
  </style>
</head>
<body class="container py-4">
<h3 class="text-center text-primary mb-4">Jamia Millia Islamia - Exam Form</h3>

<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success text-center">✅ Exam form submitted successfully.</div>
<?php endif; ?>

<?php if (!$exam_form): ?>
<!-- Display form -->
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
<!-- Show preview -->
<div class="preview-box" id="print-section">
  <h4 class="text-center text-success">Form A - Examination Confirmation</h4>
  <div class="d-flex flex-wrap align-items-start justify-content-between mb-3">
    <div class="flex-grow-1">
      <p><strong>Name:</strong> <?= htmlspecialchars($student['candidate_name']) ?></p>
      <p><strong>Enrollment:</strong> <?= htmlspecialchars($student['enrollment_no']) ?></p>
      <p><strong>Semester:</strong> <?= $exam_form['semester'] ?></p>
      <p><strong>Exam Type:</strong> <?= $exam_form['exam_type'] ?></p>
      <p><strong>Submitted On:</strong> <?= date("d M Y, h:i A", strtotime($exam_form_row['created_at'] ?? 'now')) ?></p>
    </div>
    <div class="ms-4 text-center">
      <img src="<?= htmlspecialchars($student['image_path']) ?>" alt="Photo" class="profile-photo mb-2" style="max-width:120px;max-height:140px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
    </div>
  </div>
  <h5 class="mt-4">Subjects</h5>
  <ul class="list-group">
    <?php foreach ($exam_form['subjects'] as $sub): ?>
      <li class="list-group-item"><?= htmlspecialchars($sub) ?></li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="text-center mt-4">
  <button onclick="printSection('print-section')" class="btn btn-secondary">🖨️ Print</button>
  <button class="btn btn-outline-primary" id="download">⬇️ Download</button>
</div>

<div class="text-center mt-5">
  <h6 class="text-danger">⏳ Wait <span id="timer">60</span> seconds to Generate Admit Card</h6>
  <a href="admit_card.php">
    <button class="btn btn-success hidden" id="generateBtn">Generate Admit Card</button>
  </a>
</div>
<?php endif; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
// download

document.getElementById("download")?.addEventListener("click", async () => {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  const preview = document.getElementById("print-section");
  const canvas = await html2canvas(preview, { scale: 2 });

  const imgData = canvas.toDataURL("image/png");
  const pdfWidth = doc.internal.pageSize.getWidth();
  const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

  doc.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
  doc.save("exam_form.pdf");
});

// print
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
