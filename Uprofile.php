<?php
session_start();

require_once('connection.php'); // Ensure this connects to the database correctly

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Get user ID from session

    // Fetch user information from the database
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userName = $user['username'];
        $userEmail = $user['email'];
		$userPhone = $user['phone'];
		$userAddress =$user['address'];
    } else {
        echo "User not found.";
    }

    $stmt->close();
} else {
    echo "User not logged in.";
}
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
        <h1> User Profile Page</h1><br>

       <section class="personal-info">
<div class="info-text">
    <p><strong>Name :</strong> <?= htmlspecialchars($userName); ?></p>
    <p><strong>Email :</strong> <?= htmlspecialchars($userEmail); ?></p>
	<p><strong>Address :</strong> <?= htmlspecialchars($userAddress); ?></p>
	<p><strong>Phone number :</strong> <?= htmlspecialchars($userPhone); ?></p>
</div>

	<table class="data-table">
    <div class="certifications">
        <thead>
						<tr>
							<th>Booking ID</th>
							<th>Room ID</th>
							<th>Check-in Date</th>
							<th>Check-out Date</th>
							<th>Room Type</th>
							<th>Booked Date</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody id="reservation-table">
					<?php
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id']; // Get user ID from session

    // Prepare the query to fetch bookings for the logged-in user
    $sql = "SELECT * FROM bookings WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId); // Bind the user ID as an integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['RoomID']}</td>
                <td>{$row['CheckInDate']}</td>
                <td>{$row['CheckOutDate']}</td>
                <td>{$row['Rtype']}</td>
                <td>{$row['BDate']}</td>
                <td>
                    <button class='btn btn-edit' 
                        onclick='openReservationEditForm(
                            {$row['id']}, \"{$row['RoomID']}\", 
                            \"{$row['CheckInDate']}\", 
                            \"{$row['CheckOutDate']}\", 
                            \"{$row['Rtype']}\", 
                            \"{$row['BDate']}\"
                        )'>
                        <i class='bx bxs-edit'></i>
                    </button>
                    <form method='POST' style='display: inline-block;'>
                        <input type='hidden' name='B_id' value='{$row['id']}'>
                        <button type='submit' name='deleteBooking' class='btn btn-danger'>Delete</button>
                    </form>
                </td>
            </tr>";
        } // End while loop
    } else {
        echo "<tr><td colspan='8'>No Bookings Found!</td></tr>";
    }

    $stmt->close(); // Close the statement
} else {
    echo "<tr><td colspan='8'>User not logged in.</td></tr>";
} // End if-else block

$conn->close(); // Close the database connection
?>
					</tbody>
				</table>
    </div>
</section>

	<h2>Request Loyalty</h2><a href="loyaltyReg.php"><h2>click here.</h2></a>
<h2>If you need to log out</h2>
<a href="LogOut.php"><h2>Log OUT.</h2></a>

	
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
