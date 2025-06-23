<?php
include("../connection.php");


if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM questions WHERE id=$delete_id");
    header("Location: view_questions.php?deleted=1");
    exit();
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $question = $_POST['question'];
    $a = $_POST['choice_a'];
    $b = $_POST['choice_b'];
    $c = $_POST['choice_c'];
    $d = $_POST['choice_d'];
    $correct = strtoupper($_POST['correct_answer']);

    if (!empty($question) && in_array($correct, ['A', 'B', 'C', 'D'])) {
        $stmt = $conn->prepare("UPDATE questions SET question=?, choice_a=?, choice_b=?, choice_c=?, choice_d=?, correct_answer=? WHERE id=?");
        $stmt->bind_param("ssssssi", $question, $a, $b, $c, $d, $correct, $id);
        $stmt->execute();
        header("Location: view_questions.php?updated=1");
        exit();
    }
}


$editData = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $result = $conn->query("SELECT * FROM questions WHERE id=$edit_id");
    if ($result->num_rows > 0) {
        $editData = $result->fetch_assoc();
    }
}


$questions = $conn->query("SELECT * FROM questions");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>View & Edit Questions</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-image: url('https://icct.edu.ph/wp-content/uploads/2019/02/Caintamainhih-01.jpg');
      background-size: 120%;
      background-position: center;
      background-repeat: no-repeat;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      color: #222;
    }
    .container {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 32px;
      border-radius: 16px;
      max-width: 1100px;
      width: 95%;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    h2 {
      text-align: center;
      font-weight: 700;
      font-size: 2rem;
      margin-bottom: 20px;
      color: #4b4b4b;
    }
    a.dashboard-link {
      display: inline-block;
      margin-bottom: 24px;
      padding: 10px 20px;
      background-color: #4f46e5;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    a.dashboard-link:hover {
      background-color: #4338ca;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: white;
      border-radius: 8px;
      overflow: hidden;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #4f46e5;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f8f8f8;
    }
    .btn-edit, .btn-delete {
      padding: 8px 14px;
      border-radius: 6px;
      color: white;
      text-decoration: none;
      font-weight: 600;
      display: inline-block;
    }
    .btn-edit {
      background-color: orange;
    }
    .btn-delete {
      background-color: crimson;
      margin-left: 5px;
    }
    .success {
      font-weight: bold;
      margin-bottom: 12px;
    }
    .success.green {
      color: #059669;
    }
    .success.red {
      color: #dc2626;
    }
    form label {
      font-weight: 600;
      display: block;
      margin-top: 12px;
    }
    form textarea, form input[type="text"] {
      width: 100%;
      padding: 10px;
      border: 2px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      font-family: inherit;
      margin-top: 6px;
    }
    input[type="submit"] {
      background-color: #4f46e5;
      color: white;
      border: none;
      padding: 12px 24px;
      font-size: 1rem;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 20px;
      transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
      background-color: #4338ca;
    }
  </style>
  <script>
    function confirmDelete(id) {
      if (confirm("Are you sure you want to delete this question?")) {
        window.location.href = "view_questions.php?delete_id=" + id;
      }
    }
  </script>
</head>
<body>
  <div class="container">
    <a class="dashboard-link" href="dashboard.php">⬅ Back to Dashboard</a>
    <?php if (isset($_GET['updated'])): ?>
      <p class="success green">✅ Question updated successfully!</p>
    <?php elseif (isset($_GET['deleted'])): ?>
      <p class="success red">🗑️ Question deleted successfully!</p>
    <?php endif; ?>

    <?php if ($editData): ?>
      <h2>Edit Question</h2>
      <form method="post">
        <input type="hidden" name="id" value="<?= $editData['id']; ?>">

        <label>Question:</label>
        <textarea name="question" required><?= htmlspecialchars($editData['question']) ?></textarea>

        <label>Choice A:</label>
        <input type="text" name="choice_a" value="<?= $editData['choice_a'] ?>" required>

        <label>Choice B:</label>
        <input type="text" name="choice_b" value="<?= $editData['choice_b'] ?>" required>

        <label>Choice C:</label>
        <input type="text" name="choice_c" value="<?= $editData['choice_c'] ?>" required>

        <label>Choice D:</label>
        <input type="text" name="choice_d" value="<?= $editData['choice_d'] ?>" required>

        <label>Correct Answer (A/B/C/D):</label>
        <input type="text" name="correct_answer" value="<?= $editData['correct_answer'] ?>" maxlength="1" required>

        <input type="submit" name="update" value="Update Question">
      </form>
    <?php endif; ?>

    <h2>All Questions</h2>

    <table>
      <tr>
        <th>ID</th>
        <th>Question</th>
        <th>A</th>
        <th>B</th>
        <th>C</th>
        <th>D</th>
        <th>Correct</th>
        <th>Actions</th>
      </tr>
      <?php while($row = $questions->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['question']) ?></td>
          <td><?= $row['choice_a'] ?></td>
          <td><?= $row['choice_b'] ?></td>
          <td><?= $row['choice_c'] ?></td>
          <td><?= $row['choice_d'] ?></td>
          <td><strong><?= $row['correct_answer'] ?></strong></td>
          <td>
            <a class="btn-edit" href="view_questions.php?edit_id=<?= $row['id'] ?>">Edit</a>
            <a class="btn-delete" href="javascript:void(0);" onclick="confirmDelete(<?= $row['id'] ?>)">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>
