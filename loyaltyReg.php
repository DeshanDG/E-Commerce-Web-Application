<?php
session_start();
require_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        // Get form data
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        
        // Insert into the database
        $sql = "INSERT INTO req (user_id, email, phone) VALUES ('$user_id', '$email', '$phone')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Loyalty request submitted successfully!";
			header ('index.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "User not logged in.";
    }
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
    <form class="login-form" method="POST" action="loyaltyReg.php">
        <h2>Loyalty Request Form</h2>
        <div class="input-group">
            <input type="email" name="email" placeholder="Email Address" required>
        </div>
        <div class="input-group">
            <input type="text" name="phone" placeholder="Phone Number" required>
        </div>
        <button type="submit" class="login-btn" name="login-btn">Send</button>
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