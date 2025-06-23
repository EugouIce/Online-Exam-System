<?php
session_start();
$student_name = $_SESSION['student_name'] ?? 'Student';
$score = $_SESSION['last_score'] ?? 0;
$total = $_SESSION['total_questions'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Exam Result</title>
  <style>
    body {
      padding: calc(var(--spacing-unit) * 3);
      margin-left: 0;
      max-width: 100%;
      background-image:
        linear-gradient(rgba(137, 116, 116, 0.81), rgba(18, 18, 18, 0.85)),
        url('https://ik.imagekit.io/eugouice2/image_2025-06-15_214815741.png?updatedAt=1749995301306');
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-size: cover;
      background-position: center center;
      min-height: calc(100vh - 88px); 
      font-family: Arial, sans-serif;
    }

    .result-container {
      background: rgba(255, 255, 255, 0.95);
      padding: 40px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
    }

    .score {
    font-size: 20px;
    font-weight: bold;
    color: #2c3e50;
    background: linear-gradient(45deg, #6dd5ed, #2193b0);
    padding: 10px 16px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    display: inline-block;
  }

  .return-container {
    text-align: left;
  }

  .return-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
    transition: background-color 0.3s;
  }

  .return-btn:hover {
    background-color: #2980b9;
  }
  </style>
</head>
<body>
  <div class="result-container">
  <div class="score">Your Score: <?php echo $score . " / " . $total; ?></div>

  <div class="return-container">
    <a href="../return.php" class="return-btn">⬅ Return</a>
  </div>
</div>
</body>
</html>
