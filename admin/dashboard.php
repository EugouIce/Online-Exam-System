<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard</title>
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
      min-height: 100vh;
      align-items: center;
      color: #222;
    }
    .container {
      background-color: rgba(255,255,255,0.95);
      padding: 32px;
      border-radius: 16px;
      max-width: 500px;
      width: 90%;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      text-align: center;
    }
    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 20px;
    }
    .logo-container img {
      max-width: 150px;
      height: auto;
    }
    h2 {
      margin-bottom: 24px;
      font-weight: 700;
      font-size: 2rem;
      color: #4b4b4b;
    }
    .menu-link {
      display: block;
      margin: 12px 0;
      padding: 14px;
      background-color: #4f46e5;
      color: white;
      text-decoration: none;
      font-weight: 600;
      border-radius: 10px;
      font-size: 1rem;
      transition: background-color 0.3s ease;
    }
    .menu-link:hover,
    .menu-link:focus {
      background-color: #4338ca;
      outline: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo-container">
      <img src="https://ik.imagekit.io/eugouice2/image_2025-06-15_213506688.png?updatedAt=1749994513701" alt="School Logo">
    </div>
    <h2>Welcome, Admin</h2>
    <a href="create_question.php" class="menu-link"> Create New Question</a>
    <a href="view_questions.php" class="menu-link"> View/Edit Questions</a>
    <a href="view_scores.php" class="menu-link"> View Student Scores</a>
    <a href="../logout.php" class="menu-link"> Logout</a>
  </div>
</body>
</html>
