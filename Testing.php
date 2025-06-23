<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-image: url('https://icct.edu.ph/wp-content/uploads/2019/02/Caintamainhih-01.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      display: flex;
      justify-content: center;
      min-height: 100vh;
      align-items: center;
      color: #222;
    }
    .container {
      background-color: rgba(255,255,255,0.9);
      padding: 32px;
      border-radius: 16px;
      max-width: 600px;
      width: 90%;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    .logo {
      display: block;
      margin: 0 auto 24px auto;
      max-width: 180px;
      height: auto;
    }
    h2 {
      text-align: center;
      margin-bottom: 24px;
      font-weight: 700;
      font-size: 2rem;
      color: #4b4b4b;
    }
    a.back-btn {
      display: inline-block;
      margin-bottom: 24px;
      padding: 12px 24px;
      background-color: #4f46e5;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      transition: background-color 0.3s ease;
      user-select: none;
    }
    a.back-btn:hover,
    a.back-btn:focus {
      background-color: #4338ca;
      outline: none;
    }
    form label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #333;
    }
    form textarea,
    form input[type="text"] {
      width: 100%;
      padding: 10px 14px;
      margin-bottom: 20px;
      border: 2px solid #ddd;
      border-radius: 8px;
      font-size: 1rem;
      resize: vertical;
      transition: border-color 0.3s ease;
      font-family: inherit;
    }
    form textarea:focus,
    form input[type="text"]:focus {
      border-color: #4f46e5;
      outline: none;
    }
    input[type="submit"] {
      background-color: #4f46e5;
      color: white;
      border: none;
      padding: 14px 28px;
      font-size: 1.1rem;
      border-radius: 12px;
      cursor: pointer;
      font-weight: 700;
      transition: background-color 0.3s ease;
      width: 100%;
      user-select: none;
    }
    input[type="submit"]:hover,
    input[type="submit"]:focus {
      background-color: #4338ca;
      outline: none;
    }
    p.success-message {
      text-align: center;
      font-weight: 700;
      color: #059669;
      margin-bottom: 20px;
      font-size: 1.1rem;
      user-select: none;
    }
  </style>
</head>
<body>
  <div class="container" role="main" aria-label="Create New Question Form">
    <a href="dashboard.php" class="back-btn" aria-label="Back to Dashboard">
      &larr; Back to Dashboard
    </a>
    <img src="https://tse1.mm.bing.net/th?id=OIP.XIEMRyhlf6lbxE-aK7Cj_QAAAA&pid=Api&P=0&h=180" />
    <h2>Create New Question</h2>
    <?php
      if (isset($_GET['success'])) {
          echo '<p class="success-message" role="alert">✅ Question added successfully!</p>';
      }
    ?>
    <form method="post" action="" aria-describedby="form-instructions">
      <label for="question">Question:</label>
      <textarea id="question" name="question" rows="4" required aria-required="true"></textarea>
      <label for="choice_a">Choice A:</label>
      <input type="text" id="choice_a" name="choice_a" required aria-required="true" />
      <label for="choice_b">Choice B:</label>
      <input type="text" id="choice_b" name="choice_b" required aria-required="true" />
      <label for="choice_c">Choice C:</label>
      <input type="text" id="choice_c" name="choice_c" required aria-required="true" />
      <label for="choice_d">Choice D:</label>
      <input type="text" id="choice_d" name="choice_d" required aria-required="true" />
      <label for="correct_answer">Correct Answer (A/B/C/D):</label>
      <input type="text" id="correct_answer" name="correct_answer" maxlength="1" pattern="[ABCDabcd]" title="Please enter A, B, C, or D" required aria-required="true" />
      <input type="submit" value="Create Question" />
    </form>
  </div>
</body>
</html>