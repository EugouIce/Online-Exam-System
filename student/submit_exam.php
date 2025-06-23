<?php
session_start();
include("../connection.php");

$student_name = $_SESSION['student_name'];
$student_id = $_SESSION['student_id'];
$section = $_SESSION['student_section'];

$answers = $_SESSION['answers'] ?? [];

$score = 0;

foreach ($answers as $question_id => $student_answer) {
    
    $query = "SELECT correct_answer FROM questions WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $stmt->bind_result($correct_answer);
    $stmt->fetch();
    $stmt->close();

    $is_correct = ($student_answer === $correct_answer) ? 1 : 0;
    if ($is_correct) {
        $score++;
    }

    
    $insert = $conn->prepare("INSERT INTO exam_results (student_name, student_id, section, question_id, student_answer, is_correct) VALUES (?, ?, ?, ?, ?, ?)");
    $insert->bind_param("sssisi", $student_name, $student_id, $section, $question_id, $student_answer, $is_correct);
    $insert->execute();
    $insert->close();
}


$_SESSION['last_score'] = $score;
$_SESSION['total_questions'] = count($answers);


header("Location: exam_result.php");
exit();
?>
