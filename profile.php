<?php
session_start();

if (!isset($_SESSION['Employee_id'])) {
    header('Location: EmpLogIn.php');
    exit();
}

require_once('connection.php');

$Employee_id = $_SESSION['Employee_id'];


$stmt = $conn->prepare("SELECT name, email, position, img_url FROM employee WHERE id = ?");
$stmt->bind_param("i", $Employee_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $employee = $result->fetch_assoc();
} else {
    echo "Employee not found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="Room Details.css?v=1.1" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <title>Hotel KSP</title>
    <link rel="icon" type="image/x-icon" href="assets/5.png">
    <link rel="stylesheet" href="profile.css">
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

    <main class="profile-container">
        <h1>Profile Page</h1><br>

       <section class="personal-info">
            <div class="profile-pic">
                <?php
                if (!empty($employee['img_url'])) {
                    echo '<img src="' . htmlspecialchars($employee['img_url']) . '" alt="Profile Picture" />';
                } else {
                    echo '<img src="Images/default-profile.png" alt="Default Profile Picture" />';
                }
                ?>
            </div>

            <div class="info-text">
                <h2><?php echo htmlspecialchars($employee['name']); ?></h2><br>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($employee['email']); ?></p>
                <p><strong>Role:</strong> <?php echo htmlspecialchars($employee['position']); ?></p>
            </div>
        </section>

        
            <div class="certifications">
                <h2>Job</h2><br>
                <table>
                    <thead>
                        <tr>
                            <th>Floor</th>
                            <th>Location</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>40 Hour HAZWOPER</td>
                            <td>6/12/2015</td>
                            <td>6/6/2018</td>
                            </tr>
                    </tbody>
                </table>
            </div>
    </main>
	
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
