<?php
include("../connection.php");

$selected_section = $_GET['section'] ?? '';
$search = trim($_GET['search'] ?? '');
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_student_id']) && isset($_POST['delete_section'])) {
        $student_id = $conn->real_escape_string($_POST['delete_student_id']);
        $section = $conn->real_escape_string($_POST['delete_section']);
        $conn->query("DELETE FROM exam_results WHERE student_id = '$student_id' AND section = '$section'");
    }

    if (isset($_POST['delete_section_bulk'])) {
        $section = $conn->real_escape_string($_POST['delete_section_bulk']);
        $conn->query("DELETE FROM exam_results WHERE section = '$section'");
    }

    header("Location: view_scores.php?section=" . urlencode($selected_section) . "&search=" . urlencode($search) . "&page=" . urlencode($page));
    exit;
}


$section_result = $conn->query("SELECT DISTINCT section FROM exam_results");
$where_clauses = [];

if (!empty($selected_section)) {
    $where_clauses[] = "section = '" . $conn->real_escape_string($selected_section) . "'";
}
if (!empty($search)) {
    $escaped = $conn->real_escape_string($search);
    $where_clauses[] = "(student_name LIKE '%$escaped%' OR student_id LIKE '%$escaped%')";
}

$where_sql = '';
if (count($where_clauses) > 0) {
    $where_sql = " WHERE " . implode(" AND ", $where_clauses);
}

$count_query = "
    SELECT COUNT(*) AS total FROM (
        SELECT student_id, student_name, section
        FROM exam_results
        $where_sql
        GROUP BY student_id, student_name, section
    ) AS subquery
";
$count_result = $conn->query($count_query);
$total_students = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_students / $limit);

$query = "
    SELECT student_name, student_id, section, 
           SUM(is_correct) AS correct_answers, 
           COUNT(question_id) AS total_answers
    FROM exam_results
    $where_sql
    GROUP BY student_id, student_name, section
    ORDER BY correct_answers DESC
    LIMIT $limit OFFSET $offset
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Scores</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-image: url('https://icct.edu.ph/wp-content/uploads/2019/02/Caintamainhih-01.jpg');
      background-size: 120%;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding-top: 40px;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.96);
      padding: 32px;
      border-radius: 16px;
      max-width: 1100px;
      width: 95%;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }

    h2 {
      text-align: center;
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 24px;
      color: #333;
    }

    .filter-container {
      text-align: center;
      margin-bottom: 20px;
    }

    .filter-container form {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 12px;
    }

    select, input[type="text"], button {
      padding: 10px;
      font-size: 1rem;
      border-radius: 8px;
      border: 1px solid #aaa;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
      background: white;
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: center;
    }

    th {
      background-color: #4f46e5;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .pagination {
      text-align: center;
      margin-top: 20px;
    }

    .pagination a {
      margin: 0 5px;
      text-decoration: none;
      color: black;
      font-weight: 600;
    }

    .pagination a[style*="font-weight:bold"] {
      color: black;
    }

    .pagination select {
      padding: 6px;
      margin-left: 10px;
    }

    .back-link {
       text-align: left;
       margin-bottom: 10px;
    }

    .back-link a {
      display: inline-block;
      padding: 10px 20px;
      background-color: #4f46e5;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    .back-link a:hover {
      background-color: #2980b9;
    }

    button.delete-btn {
      background: #e74c3c;
      color: #fff;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
    }

    button.delete-btn:hover {
      background: #c0392b;
    }

    button.bulk-delete {
      background: #e74c3c;
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      cursor: pointer;
      margin-bottom: 10px;
    }

    button.bulk-delete:hover {
      background: #c0392b;
    }
    .bulk-delete {
      padding: 10px 16px;
      margin-left: 5px;
    }

  </style>
</head>
<body>
  <div class="container">
    <div class="back-link">
      <a href="dashboard.php">⬅ Back to Dashboard</a>
    </div>

    <h2>Student Scores</h2>

    <div class="filter-container">
  <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 12px;">
    <form method="GET" action="" style="display: flex; flex-wrap: wrap; gap: 12px;">
      <label for="section">Filter by Section:</label>
      <select name="section" id="section" onchange="this.form.submit()">
        <option value="">All Sections</option>
        <?php while ($row = $section_result->fetch_assoc()): ?>
          <option value="<?php echo $row['section']; ?>" <?php if ($row['section'] == $selected_section) echo 'selected'; ?>>
            <?php echo $row['section']; ?>
          </option>
        <?php endwhile; ?>
      </select>

      <input type="text" name="search" placeholder="Search name or ID" value="<?php echo htmlspecialchars($search); ?>">
      <button type="submit">Search</button>
    </form>

    <?php if (!empty($selected_section)): ?>
      <form method="POST" onsubmit="return confirm('Are you sure you want to delete ALL students in section <?php echo htmlspecialchars($selected_section); ?>?');">
        <input type="hidden" name="delete_section_bulk" value="<?php echo htmlspecialchars($selected_section); ?>">
        <button type="submit" class="bulk-delete">Delete All in Section</button>
      </form>
    <?php endif; ?>
  </div>
</div>


    <table>
      <tr>
        <th>Student Name</th>
        <th>Student ID</th>
        <th>Section</th>
        <th>Score</th>
        <th>Actions</th>
      </tr>

      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['student_name']; ?></td>
            <td><?php echo $row['student_id']; ?></td>
            <td><?php echo $row['section']; ?></td>
            <td><?php echo $row['correct_answers'] . " / " . $row['total_answers']; ?></td>
            <td>
              <form method="POST" onsubmit="return confirm('Are you sure you want to delete this student\'s data?');" style="display:inline;">
                <input type="hidden" name="delete_student_id" value="<?php echo $row['student_id']; ?>">
                <input type="hidden" name="delete_section" value="<?php echo $row['section']; ?>">
                <button type="submit" class="delete-btn">Delete</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="5">No results found.</td>
        </tr>
      <?php endif; ?>
    </table>

    <div class="pagination">
      <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>&section=<?php echo urlencode($selected_section); ?>&search=<?php echo urlencode($search); ?>">&laquo; Prev</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>&section=<?php echo urlencode($selected_section); ?>&search=<?php echo urlencode($search); ?>" style="<?php echo $i == $page ? 'font-weight:bold; color:red;' : ''; ?>">
          <?php echo $i; ?>
        </a>
      <?php endfor; ?>

      <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>&section=<?php echo urlencode($selected_section); ?>&search=<?php echo urlencode($search); ?>">Next &raquo;</a>
      <?php endif; ?>

      <form method="GET" style="display: inline;">
        <input type="hidden" name="section" value="<?php echo htmlspecialchars($selected_section); ?>">
        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
        <label for="page_jump">Go to page:</label>
        <select name="page" id="page_jump" onchange="this.form.submit()">
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <option value="<?php echo $i; ?>" <?php if ($i == $page) echo 'selected'; ?>><?php echo $i; ?></option>
          <?php endfor; ?>
        </select>
      </form>
    </div>

  </div>
</body>
</html>
