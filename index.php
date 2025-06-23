<?php
    include("connection.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login with Background and Logo</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: url('https://ik.imagekit.io/eugouice2/image_2025-06-15_215143610.png?updatedAt=1749995509225') no-repeat center center fixed;
      background-size: cover;
    }

    .container {
      position: relative;
      width: 400px;
      min-height: 480px;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      background: rgba(31, 41, 58, 0.85);
      border-radius: 12px;
      padding: 40px 50px 50px;
      box-shadow: 0 16px 36px rgba(0, 0, 0, 0.75);
    }




    .logo {
      width: 120px;
      height: auto;
      margin-bottom: 32px;
      user-select: none;
      filter: drop-shadow(0 0 4px rgba(14, 239, 255, 0.6));
    }

  
    .login-box {
      width: 100%;
    }

    .login-box form {
      width: 100%;
    }

    h2 {
      font-size: 2.25em;
      color: #0ef;
      text-align: center;
      margin-bottom: 36px;
      font-weight: 700;
      letter-spacing: 1px;
    }

    .input-box {
      position: relative;
      margin: 25px 0;
    }

    .input-box input {
      width: 100%;
      height: 50px;
      background: transparent;
      border: 2px solid #2c4766;
      outline: none;
      border-radius: 40px;
      font-size: 1em;
      color: #fff;
      padding: 0 20px;
      transition: 0.5s ease;
    }

    .input-box input:focus,
    .input-box input:valid {
      border-color: #0ef;
    }

    .input-box label {
      position: absolute;
      top: 50%;
      left: 20px;
      transform: translateY(-50%);
      font-size: 1em;
      color: #fff;
      pointer-events: none;
      transition: 0.5s ease;
    }

    .input-box input:focus ~ label,
    .input-box input:valid ~ label {
      top: 1px;
      font-size: 0.8em;
      background: rgba(31, 41, 58, 0.85);
      padding: 0 6px;
      color: #0ef;
    }

    .forgot-pass {
      margin: -15px 0 10px;
      text-align: center;
    }

    .forgot-pass a {
      font-size: 0.85em;
      color: #fff;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .forgot-pass a:hover {
      text-decoration: underline;
      color: #0ef;
    }

    #btn {
      width: 100%;
      height: 45px;
      background: #0ef;
      border: none;
      outline: none;
      border-radius: 40px;
      cursor: pointer;
      font-size: 1em;
      color: #1f293a;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    #btn:hover {
      background: #06b6d4;
    }

    @media (max-width: 480px) {
      .container {
        width: 90vw;
        padding: 30px 20px;
      }
      h2 {
        font-size: 1.8em;
        margin-bottom: 28px;
      }
      .logo {
        width: 80px;
        margin-bottom: 24px;
      }
      .input-box input {
        height: 44px;
        font-size: 0.9em;
      }
      #btn {
        height: 44px;
      }
    }
  </style>
</head>
<body>
  <div class="container" role="main" aria-label="Login form container">
    <img class="logo" src="https://ik.imagekit.io/eugouice2/image_2025-06-15_233208541.png?updatedAt=1750001537034" />
    <div class="login-box">
      <form name="form" action="login.php" method="POST">
        <h2>Login</h2>
        <div class="input-box">
          <input type="text" id="user" name="user" required autocomplete="username" />
          <label for="username">Username</label>
        </div>
        <div class="input-box">
          <input type="password" id="password" name="password" required autocomplete="current-password" />
          <label for="password">Password</label>
        </div>
        <div class="forgot-pass">
          <a href="#" tabindex="0">Forgot Password?</a>
        </div>
        <input type="submit" id="btn" name="submit" value="Login"/>
      </form>
    </div>
  </div>
</body>
</html>
