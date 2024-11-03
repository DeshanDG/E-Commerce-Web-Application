<?php
session_start();

require_once('connection.php');
?>

<!-- header.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet"href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="styleEvent.css">


</head>

<nav>
    <div class="nav__logo">
      <img src="logo1.png" alt="Logo" />
    </div>
    <ul class="nav__links">
     
      <div class="nav__menu">
        <li class="link"><a href="#">Home</a></li>
        <li class="link"><a href="#">Accommodations</a></li>
        <li class="link"><a href="#">Events & News</a></li>
        <li class="link"><a href="#">About Us</a></li>
        <li class="link"><a href="#">Contact Us</a></li>
      </div>
  
      <div class="nav__icons">
        <li class="link"><a href="SignUpLogIn.html"><i class='bx bxs-user'></i></a></li>
        <li class="link"><a href="#"><i class='bx bx-search-alt-2'></i></a></li>
        <li class="link"><a href="#"><i class='bx bx-menu'></i></a></li>
      </div>
    </ul>
  </nav>


<!--Background -->

<!-- Section 1: Full-Width Background Image -->

<section class="full-width-background">
</section>

<!-- Section 2: Meeting & Events Description -->

<section class="meeting-events-description">
    <h2>Meeting & Events</h2>
    <div class="event-content">
        <img src="second.jpg" alt="Event Image" class="event-image"> 
        <div class="event-text">
            <p>
            "At Hotel KSP, we turn your vision into reality with impeccable event management. From intimate gatherings to grand celebrations, our dedicated team ensures every detail is perfect. Let us handle the logistics while you enjoy a seamless experience, transforming moments into lasting memories. Your special event is in expert hands." </p>
        </div>
    </div>
</section>




<!-- Event Listings -->






<div class="container my-5">
   <dev>
        <h2><B>Upcoming Events</B></h2>
   </dev> 
    <div class="row">

        
        <?php
        $sql = "SELECT * FROM events ORDER BY event_date DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-4'>
                    <div class='card mb-4'>
                        <img src='{$row['image_url']}' class='card-img-top' alt='Event Image'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$row['event_name']}</h5>
                            <p class='card-text'>Venue: {$row['venue']}</p>
                            <p class='card-text'>Date: {$row['event_date']}</p>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<p>No upcoming events at the moment.</p>";
        }
        ?>


    </div>
</div>

<footer class="footer">
    <div class="footer__logo-section">
      <img src="logo2.png" alt="Hotel KSP Logo">
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
      <p>Copyright © 2024 Deshan D Gunathilaka. All rights reserved.</p>
    </div>
  </footer>

