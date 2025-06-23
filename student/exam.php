<?php
session_start();
include("../connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['student_name'] = $_POST['full_name'];
    $_SESSION['student_section'] = $_POST['section'];
    $_SESSION['student_id'] = $_POST['student_id'];

    $name = $_SESSION['student_name'];
    $section = $_SESSION['student_section'];
    $student_id = $_SESSION['student_id'];

    $conn->query("INSERT INTO students (student_id, full_name, section) 
                VALUES ('$student_id', '$name', '$section')");

    header("Location: take_exam.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Start Exam</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      box-sizing: border-box;
    }

    body {
      padding: calc(var(--spacing-unit) * 3);
      margin-left: 0;
      max-width: 100%;
      background-image:
        linear-gradient(rgba(137, 116, 116, 0.81), rgba(18, 18, 18, 0.85)),
        url('https://ik.imagekit.io/eugouice2/image_2025-06-15_214815741.png?updatedAt=1749995301306');      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-size: cover;
            background-position: center center;
            min-height: calc(100vh - 88px); 
    }

    .login-card {
      background-color: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    input[type="text"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    input[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
      font-weight: bold;
    }

    input[type="submit"]:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h2>Online Examination</h2>
    <form method="post">
      <input type="text" name="full_name" placeholder="Full Name" required><br>
      <input type="text" name="section" placeholder="Section" required><br>
      <input type="text" name="student_id" placeholder="Student Number" required><br>
      <input type="submit" value="Start Exam">
    </form>
  </div>
</body>
</html>
