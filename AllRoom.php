<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="AllRoom.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <title>Hotel KSP</title>
    <link rel="icon" type="image/x-icon" href="assets/5.png">
    <style>

    </style>
</head>
<body>
    <nav>
        <div class="nav__logo">
            <img src="Images/Logo/d.png" alt="Logo" />
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
                <li class="link"><a href="SignUpLogIn.php"><i class='bx bxs-user'></i></a></li>
                <li class="link"><a href="#"><i class='bx bx-search-alt-2'></i></a></li>
                <li class="link"><a href="#"><i class='bx bx-menu'></i></a></li>
            </div>
        </ul>
    </nav>

    <div class="room-details">
    <h1>Our Rooms</h1>
    <div class="stats-container">
        <div class="stat-card">
            <img src="assets/12.jpg" alt="Standard Room">
            <div class="room-info">
                <h2>Standard Room</h2>
                <p>From $100 per night</p>
                <a href="Room Details.php"><button class="btn-details">View Details</button></a>
            </div>
        </div>

        <div class="stat-card">
            <img src="assets/13.jpg" alt="Deluxe Room">
            <div class="room-info">
                <h2>Deluxe Room</h2>
                <p>From $150 per night</p>
                <button class="btn-details">View Details</button>
            </div>
        </div>

        <div class="stat-card">
            <img src="assets/14.jpg" alt="Suite Room">
            <div class="room-info">
                <h2>Suite Room</h2>
                <p>From $200 per night</p>
                <button class="btn-details">View Details</button>
            </div>
        </div>

        <div class="stat-card">
            <img src="assets/15.jpg" alt="Executive Room">
            <div class="room-info">
                <h2>Executive Room</h2>
                <p>From $250 per night</p>
                <button class="btn-details">View Details</button>
            </div>
        </div>
    </div>
</div>

        
    <br><br><br><br>

    <footer class="footer">
        <div class="footer__logo-section">
            <img src="Images/Logo/m.png" alt="Hotel KSP Logo">
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
