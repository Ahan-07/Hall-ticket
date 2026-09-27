<?php
session_start();
require 'config.php';

// Validate session
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

// Fetch student info
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch();

if (!$student) {
    die("Student record not found.");
}

// Fetch latest exam form
$stmt = $pdo->prepare("SELECT * FROM exam_forms WHERE student_id = ? ORDER BY submitted_at DESC LIMIT 1");
$stmt->execute([$student_id]);
$exam_form = $stmt->fetch();

if (!$exam_form) {
    die("No exam form submitted.");
}

$subjects = json_decode($exam_form['subjects'], true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admit Card - Jamia Millia Islamia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }

        .card-wrapper {
            background: white;
            max-width: 900px;
            margin: auto;
            padding: 30px;
            border: 2px solid #ccc;
            border-radius: 10px;
        }

        .admit-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 30px;
        }

        .admit-header img {
            flex-shrink: 0;
        }

        .admit-header .admit-title-block {
            width: 100%;
            text-align: center;
        }

        .admit-header h3, .admit-header h4 {
            margin: 5px 0;
        }

        .student-info, .footer {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .student-photo {
            width: 120px;
            height: 140px;
            border: 1px solid #ccc;
            object-fit: cover;
        }

        .subject-table th, .subject-table td {
            padding: 8px 12px;
            border: 1px solid #666;
            text-align: center;
        }

        .rules {
            font-size: 14px;
        }

        .rules li {
            margin-bottom: 4px;
        }

        .print-button {
            margin-top: 25px;
            text-align: center;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="card-wrapper">
    <div class="admit-header">
        <img src="asset/jmi-logo.svg" alt="Jamia Logo" style="width:80px; height:auto;">
        <div class="admit-title-block">
            <h3 class="mb-1">Jamia Millia Islamia</h3>
            <h4 class="mb-1">Admit Card - <?= htmlspecialchars($exam_form['type']) ?> Examination</h4>
            <p class="mb-0">Session: <?= date("Y") ?></p>
        </div>
    </div>

    <div class="student-info">
        <div style="width: 70%;">
            <p><strong>Name:</strong> <?= htmlspecialchars($student['candidate_name']) ?></p>
            <p><strong>Father's Name:</strong> <?= htmlspecialchars($student['father_name']) ?></p>
            <p><strong>Course:</strong> <?= htmlspecialchars($student['course']) ?></p>
            <p><strong>Semester:</strong>Semester- <?=  htmlspecialchars($exam_form['semester']) ?></p>
            <p><strong>Enrollment No:</strong> <?= htmlspecialchars($student['enrollment_no']) ?></p>
        </div>
        <div>
            <img src="<?= htmlspecialchars($student['image_path']) ?>" class="student-photo" alt="Student Photo">
            <p class="mt-2 text-center">Signature</p>
        </div>
    </div>

    <h5>Subjects:</h5>
    <table class="table subject-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subjects as $subject): ?>
                <?php
                $parts = explode(" - ", $subject);
                ?>
                <tr>
                    <td><?= htmlspecialchars($parts[0]) ?></td>
                    <td><?= htmlspecialchars($parts[1]) ?></td>
                    <td><?= htmlspecialchars($parts[2]) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer mt-4">
        <div>
            <p><strong>Roll No:</strong> <?= $student['roll_no'] ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
        </div>
        <div class="text-end">
            <p><strong>Signature of Dean/Principal</strong></p>
            <img src="asset/stamp.png" alt="Stamp" style="width:100px;">
        </div>
    </div>

    <div class="rules mt-4">
        <strong>Note:</strong>
        <ol>
            <li>Students must carry this admit card to the examination hall.</li>
            <li>Use of mobile phones and smart devices is prohibited.</li>
            <li>Adhere strictly to exam time and instructions.</li>
        </ol>
    </div>
</div>
 <div class="print-button">
        <button id="download" class="btn btn-primary">🖨️ Download Admit Card</button>
        <button onclick="printSection('.card-wrapper')" class="btn btn-primary">🖨️ Print Admit Card</button>
        <a href="student_info.php" class="btn btn-secondary">⬅️ Back</a>
    </div>
<!-- jsPDF + html2canvas CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    document.getElementById("download")?.addEventListener("click", async () => {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
const preview = document.querySelector(".card-wrapper");
  const canvas = await html2canvas(preview, { scale: 2 });

  const imgData = canvas.toDataURL("image/png");
  const pdfWidth = doc.internal.pageSize.getWidth();
  const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

  doc.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
  doc.save("exam_form.pdf");
});

function printSection(sectionId) {
  var printContents = document.querySelector(sectionId).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
  location.reload(); // To restore JS events and state
}
</script>
</body>
</html>
