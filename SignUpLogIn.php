<?php
require_once 'connection.php';
session_start();

// User Signup
if (isset($_POST['signUp'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        return;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $insertSql = "INSERT INTO users (username, email, phone, address, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertSql);
    mysqli_stmt_bind_param($stmt, 'sssss', $name, $email, $phone, $address, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        echo "New record created successfully.";
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
}

// User Login
if (isset($_POST['login'])) {
    $email = $_POST['LOGemail'];
    $password = $_POST['LOGpassword'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if ($password == $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with that email.";
        }
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="SignUpLogIn.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <title>Hotel KSP</title>
    <link rel="icon" type="image/x-icon" href="assets/5.png">
  </head>
  <body>
    <nav>
      <div class="nav__logo">
    <a href="index.php"><img src="assets/d.png" alt="Logo" /></a>
  </div>
  <ul class="nav__links">
   
    <div class="nav__menu">
      <li class="link"><a href="index.php">Home</a></li>
      <li class="link"><a href="Room Details.php">Accommodations</a></li>
      <li class="link"><a href="event.php">Events & News</a></li>
      <li class="link"><a href="#">About Us</a></li>
      <li class="link"><a href="ContactUs.php">Contact Us</a></li>
    </div>

        <div class="nav__icons">
          <li class="link"><a href="#"><i class='bx bxs-user'></i></a></li>
          <li class="link"><a href="#"><i class='bx bx-search-alt-2'></i></a></li>
          <li class="link"><a href="#"><i class='bx bx-menu'></i></a></li>
        </div>
      </ul>
    </nav>
<header class="section__container header__container">
    <div class="header__image__container">
        <div class="main-content">
            <div class="container">
                <input type="checkbox" id="check">
                
                <!-- Login Form -->
                <div class="login form">
                    <header>Login</header>
                    <form action="" method="POST">
                        <input type="email" name="LOGemail" placeholder="Enter your email" required>
                        <input type="password" name="LOGpassword" placeholder="Enter your password" required>
                        <a href="#">Forgot password?</a>
                        <input type="submit" class="button" name="login" value="Login">
                    </form>
                    <div class="signup">
                        <span class="signup">Don't have an account?
                            <label for="check">Signup</label>
                        </span>
                    </div>
                </div>

                <!-- Signup Form -->
                <div class="registration form">
                    <header>Signup</header>
                    <form action="" method="POST">
                        <input type="text" name="name" placeholder="Enter your name" required>
                        <input type="email" name="email" placeholder="Enter your email" required>
                        <input type="text" name="phone" placeholder="Enter your phone" required>
                        <input type="text" name="address" placeholder="Enter your address" required>
                        <input type="password" name="password" placeholder="Create a password" required>
                        <input type="password" name="confirm_password" placeholder="Confirm your password" required>
                        <input type="submit" class="button" name="signUp" value="Signup">
                    </form>
                    <div class="signup">
                        <span class="signup">Already have an account?
                            <label for="check">Login</label>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>




    <footer class="footer">
      <div class="footer__logo-section">
        <img src="assets/m.png" alt="Hotel KSP Logo">
        <hr>
      </div>

      <div class="footer__container">
        <div class="footer__col">
          <p>Hotel KSP, Wilagedara Watta,<br> Thuththiripitigama, Panduwasnuwara.</p> <br>
          <p>+94 37 494 7270</p><br>
          <p>inquiries :: shanuthpchamalka@gmail.com</p>
        </div>

        <div class="footer__col">
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Accommodations</a></li>
            <li><a href="#">Events & News</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
          </ul>
        </div>

        <div class="footer__col">
          <div class="promo-section">
            <input type="text" id="promo-code">
            <label for="promo-code">Promo Code</label>
          </div>
          <button class="newsletter-btn">News Letter</button>

          <div class="social-icons">
            <a href="#"><i class="bx bxl-facebook"></i></a>
            <a href="#"><i class="bx bxl-whatsapp"></i></a>
            <a href="#"><i class="bx bxl-tiktok"></i></a>
            <a href="#"><i class="bx bxl-instagram"></i></a>
          </div>
        </div>
      </div>

      <div class="footer__bar">
        <p>Copyright © 2024 Team Phoenex. All rights reserved.</p>
      </div>
    </footer>
  </body>
</html>
