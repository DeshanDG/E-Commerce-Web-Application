<?php
session_start();

require_once('connection.php');

if (isset($_POST['login-btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, position FROM employee WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $employee = $result->fetch_assoc();


        if ($password == $employee['password']) {
            $_SESSION['Employee_id'] = $employee['id'];

          if ($employee['position'] === 'Admin') {
                header('Location: admin.php');
				 exit();
            } else {
                header('Location: profile.php');
				 exit();
            }
           
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
}

$conn->close();
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
    <link rel="stylesheet" href="AllRoom.css" />
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
	
	<div class="login-container">
        <form class="login-form" method="POST" action="EmpLogIn.php">
            <h2>Employee Login</h2>
            <?php if (isset($error)) { ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php } ?>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="login-btn" name="login-btn">Login</button>
        </form>
    </div>
	
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