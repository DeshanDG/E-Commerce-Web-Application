<?php 
session_start();
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
    <link rel="stylesheet" href="styles.css" />
	<link rel="stylesheet"
  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
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
      <li class="link"><a href="AllRoom.php">Accommodations</a></li>
      <li class="link"><a href="event.php">Events & News</a></li>
	  <li class="link"><a href="LoyaltyReg.php">Loyalty</a></li>
      <li class="link"><a href="#">About Us</a></li>
      <li class="link"><a href="ContactUs.php">Contact Us</a></li>
    </div>

    <div class="nav__icons">
          <li class="link">
        <a href="
            <?php
                echo isset($_SESSION['user_id']) ? 'Uprofile.php' : 'SignUpLogIn.php'; 
            ?>
        ">
            <i class='bx bxs-user'></i>
        </a>
    </li>
	  <li class="link"><a href="EmpLogIn.php"><i class='bx bxs-user-circle'></i></a></li>
      <li class="link"><a href="#"><i class='bx bx-search-alt-2'></i></a></li>
      <li class="link"><a href="#"><i class='bx bx-menu'></i></a></li>
    </div>
  </ul>
</nav>

    <header class="section__container header__container">
      <div class="header__image__container">
        <div class="header__content">
		<h2>WELCOME TO</h2><br>
          <h1>HOTEL KSP</h1><br>
          <p>Hotel banquet & Restaurent</p><br><br><br>
		  <a href="AllRoom.php"><button class="Boking-btn">Book Now</button>
        </div>
      </div>
    </header>
	
	<section class="description-section">
  <div class="desc-content">
    <div class="column-left">
      <img src="assets/5.jpg" alt="Description Image" class="desc-img" />
      <div class="vl"></div>
    </div>
    <div class="column-middle"><br>
      <h3>Impressive Self Experiences</h3>
	  <h2> Hotel KSP Hettipola</h2><br>
      <p>
        Hotel KSP combines tranquility with refined elegance. Surrounded by lush landscapes and 
        rich cultural heritage, the hotel offers a peaceful retreat while being conveniently connected 
        to nearby attractions. With top-tier accommodations, delightful dining experiences, and exceptional event facilities, 
        Hotel KSP is the ideal destination for both relaxation and business in the region.
      </p>
    </div>
    <div class="column-right"><br><br><br><br>
      <img src="assets/23.jpg" alt="Additional Image" class="header-img" />
    </div>
  </div>
</section>



    <section class="section__container">
      <div class="reward__container">
        <p>
            True passion fuels an emmotral spirit, one that transcends time and obstacles, leaving a lasting impact on the world
          </p>
      </div>
    </section>
	
		<section class="description-section">
  <div class="desc-content">
    <div class="column-left">
      <img src="assets/5.jpg" alt="Description Image" class="desc-img" />
      <div class="vl"></div>
    </div>
    <div class="column-middle"><br>
      <h3>Prioritizing you to you</h3>
	  <h2> Hotel KSP Hettipola</h2><br>
      <p>
        Hotel KSP is a celebration of warm hospitality and 
culinary artistry. the hotel invites guests to indulge 
in an unforgettable experience where comfort 
meets tradition. The heart of Hotel KSP lies in its 
exceptional service, where every guest is treated 
like family. The hotel’s chefs craft dishes that 
tantalize the taste buds, blending local flavors with 
international flair, ensuring that every meal is a 
journey of taste and culture. Whether savoring a 
gourmet feast or enjoying a simple yet delicious 
local delicacy, Hotel KSP promises a dining 
experience as unforgettable as its warm welcome.
      </p>
    </div>
    <div class="column-right"><br><br><br><br>
      <img src="assets/ayubowan.jpg" alt="Additional Image" class="header-img" />
    </div>
  </div>
</section>

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
    <p>Copyright © 2024 Deshan D Gunathilaka. All rights reserved.</p>
  </div>
</footer>
  </body>
</html>
