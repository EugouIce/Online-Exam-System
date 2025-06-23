<?php
session_start();
if (!isset($_SESSION['exam_start_time'])) {
    $_SESSION['exam_start_time'] = time(); 
    $_SESSION['exam_duration'] = 60 * 60; 
}
$start_time = $_SESSION['exam_start_time'];
$duration = $_SESSION['exam_duration'];
$current_time = time();
$time_left = max(0, $start_time + $duration - $current_time); 
include("../connection.php");

if (!isset($_SESSION['question_index'])) {
    $_SESSION['question_index'] = 0;
    $_SESSION['answers'] = []; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_qid = $_POST['question_id'];
    $selected_answer = $_POST['answer'] ?? null;
    if ($selected_answer) {
        $_SESSION['answers'][$current_qid] = $selected_answer;
    }

    $_SESSION['question_index']++;

    
    header("Location: take_exam.php");
    exit();
}
if (!isset($_SESSION['random_questions'])) {
    $questions = $conn->query("SELECT * FROM questions");
    $questionsArray = [];

    while ($row = $questions->fetch_assoc()) {
        $questionsArray[] = $row;
    }

    shuffle($questionsArray); 
    $_SESSION['random_questions'] = $questionsArray;
}

$questionsArray = $_SESSION['random_questions'];


$totalQuestions = count($questionsArray);
$currentIndex = $_SESSION['question_index'] ?? 0;


if ($currentIndex >= $totalQuestions) {
    header("Location: submit_exam.php");
    exit();
}

$currentQuestion = $questionsArray[$currentIndex];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Take Exam</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      box-sizing: border-box;
      user-select: none;
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

    .exam-card {
      background-color: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 600px;
    }

    h2, h3 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    #timer {
      color: red;
      font-weight: bold;
      font-size: 18px;
      margin-bottom: 20px;
    }

    form p {
      font-size: 18px;
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin: 10px 0;
      font-size: 16px;
    }

    input[type="radio"] {
      margin-right: 10px;
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
      margin-top: 20px;
    }

    input[type="submit"]:hover {
      background-color: #2980b9;
    }
  .status-bar {
    display: flex;
    justify-content: space-between;
    align-items: baseline; /* 👈 change this line */
    background-color: rgba(230, 230, 230, 0.5);
    padding: 10px 15px;
    border-radius: 8px;
    font-size: 18px;
    margin-bottom: 20px;
    font-weight: bold;
    color: #333;
    gap: 20px;
  }


  #timer, .question-counter {
    flex: 1;
    text-align: center;
  }
  .choices {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-bottom: 20px;
}

.choice {
  display: flex;
  align-items: center;
  cursor: pointer;
  background-color: #fff;
  border: 2px solid #ccc;
  border-radius: 10px;
  padding: 12px 16px;
  font-size: 16px;
  transition: 0.3s ease;
  user-select: none;
  position: relative;
  overflow: hidden;
}

.choice input[type="radio"] {
  display: none;
}

.choice span {
  flex: 1;
  color: #333;
}

.choice:hover {
  border-color: #3498db;
  background-color: #e6f2ff;
}

.choice input[type="radio"]:checked + span {
  color: #fff;
  background-color: #3498db;
  padding: 12px 16px;
  border-radius: 10px;
  width: 100%;
  text-align: center;
}

</style>
  <script>
    let timeLeft = <?php echo $time_left; ?>;

    function startTimer() {
      const timerDisplay = document.getElementById("timer");

      const countdown = setInterval(() => {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;

        timerDisplay.textContent = `Time Left: ${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;

        if (timeLeft <= 0) {
          clearInterval(countdown);
          alert("Time's up! Submitting your exam.");
          document.forms[0].submit(); 
        }

        timeLeft--;
      }, 1000);
    }

    window.onload = startTimer;
  </script>
</head>
<body>
  <div class="exam-card">
    <div class="status-bar">
  <div id="timer">Time Left: 10:00</div>
  <div class="question-counter">Question <?php echo $currentIndex + 1; ?> of <?php echo $totalQuestions; ?></div>
</div>
    <form method="post">
      <p><strong><?php echo htmlspecialchars($currentQuestion['question']); ?></strong></p>

      <input type="hidden" name="question_id" value="<?php echo $currentQuestion['id']; ?>">

      <div class="choices">
  <label class="choice">
    <input type="radio" name="answer" value="A" required>
    <span><?php echo $currentQuestion['choice_a']; ?></span>
  </label>

  <label class="choice">
    <input type="radio" name="answer" value="B">
    <span><?php echo $currentQuestion['choice_b']; ?></span>
  </label>

  <label class="choice">
    <input type="radio" name="answer" value="C">
    <span><?php echo $currentQuestion['choice_c']; ?></span>
  </label>

  <label class="choice">
    <input type="radio" name="answer" value="D">
    <span><?php echo $currentQuestion['choice_d']; ?></span>
  </label>
</div>


      <input type="submit" value="<?php echo ($currentIndex + 1 == $totalQuestions) ? 'Submit Exam' : 'Next'; ?>">
    </form>
  </div>

  <script>
    document.addEventListener('contextmenu', e => e.preventDefault());
    document.addEventListener('copy', e => e.preventDefault());
    document.addEventListener('paste', e => e.preventDefault());

    document.addEventListener('keydown', function (e) {
      if ((e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
          (e.ctrlKey && (e.key === 'u' || e.key === 's')) ||
          (e.key === 'F12')) {
        e.preventDefault();
      }
    });
  </script>
</body>
</html>
