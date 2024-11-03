<?php

require_once 'connection.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture and sanitize form inputs
    $roomID = htmlspecialchars(trim($_POST['RoomID']));
    $checkInDate = htmlspecialchars(trim($_POST['date']));
    $checkOutDate = htmlspecialchars(trim($_POST['CheckOut']));
    $bookingDate = htmlspecialchars(trim($_POST['BDate']));

    // Basic validation
    $errors = [];
    if (empty($roomID)) {
        $errors[] = "Room ID is required.";
    }
    if (empty($checkInDate) || empty($checkOutDate) || empty($bookingDate)) {
        $errors[] = "All date fields are required.";
    }

    // Example date validation (optional)
    if (strtotime($checkInDate) > strtotime($checkOutDate)) {
        $errors[] = "Check-out date must be after check-in date.";
    }

    // If there are no errors, proceed with processing (e.g., save to database)
    if (empty($errors)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO bookings (RoomID, CheckInDate, CheckOutDate, BDate) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $roomID, $checkInDate, $checkOutDate, $bookingDate); // Assuming RoomID is an integer

        // Execute the statement
        if ($stmt->execute()) {
            echo "Room booked successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}

// Close the database connection
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
    <link rel="stylesheet" href="Room Details.css?v=1.1" />
	<link rel="stylesheet"
  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <title>Hotel KSP</title>
	<link rel="icon" type="image/x-icon" href="assets/5.png">
	
	<style>
	
	.Room-form-modal {
    display: none; /* Hide by default */
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    align-items: center;
    justify-content: center;
}

.Room-form-modal.active {
    display: flex; /* Show when active */
}

.Room-form {
    background: white;
    padding: 20px;
    border-radius: 8px;
}

		.add-Room-btn {
            background-color: #4caf50;
			border-radius:10px;
            color: white;
            border: none;
            padding: 10px 30px;
            cursor: pointer;
            right: 20px;
            top: 20px;
        }

        .Room-form {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            width: 300px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .Room-form input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .Room-form button {
            background-color: #4caf50;
            color: white;
            border: none;
			border-radius:15px;
            padding: 10px;
            cursor: pointer;
        }
	
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
  <h1>Deluxe Room</h1>
  
  <div class="room-columns">
    <div class="room-image">
      <img src="assets/23.jpg" alt="Luxury Room">
    </div>
    
    <div class="room-info">
      <div class="price">$100 per night</div>
      <div class="rating">
        <span>★ ★ ★ ★</span>
      </div>
      <div class="features">
        <h4>Features</h4>
        <p>bedroom, balcony, kitchen</p>
      </div>
      <div class="facilities">
        <h4>Facilities</h4>
        <p>WiFi, Room Heater, Air conditioner</p>
      </div>
      <div class="guests">
        <h4>Guest</h4>
        <p>8 Adults, 6 Children</p>
      </div>
      <button class="add-Room-btn">Book Now</button>
    </div>
  </div>
  
 
  <div class="room-description">
    <h2>Description</h2><br><br>
    <p>
      Welcome to the epitome of comfort and elegance at Hotel KSP. Our luxury rooms are meticulously designed to provide you with an unforgettable stay experience. Here's what you can expect:
      <ul><br><br>
        <li>Spacious Interiors: Each luxury room boasts a generous floor plan with an elegant design that combines contemporary style with classic comfort.
</li><li>King-Sized Bed: Enjoy a restful night on a plush king-sized bed, adorned with premium linens and an array of pillows for maximum comfort.
</li><li>Private Balcony: Step out onto your private balcony to enjoy stunning views of the city skyline or the serene hotel gardens.
</li><li>En-Suite Bathroom: Indulge in the luxurious en-suite bathroom equipped with a rain shower, soaking tub, premium toiletries, and soft, fluffy towels.
</li><li>Modern Amenities: Each room is fitted with a state-of-the-art flat-screen TV, high-speed Wi-Fi, a mini-bar stocked with gourmet snacks and beverages, and a Nespresso coffee machine.
</li><li>Work Desk: A spacious work desk with an ergonomic chair is provided for guests who need to stay productive during their stay.
</li><li>Climate Control: Individually controlled air conditioning and heating ensure your comfort in any season.
     <br><h2><br><br>Services<br><br>
</h2><li>24/7 Room Service: Enjoy gourmet dining in the comfort of your room with our round-the-clock room service.
</li><li>Daily Housekeeping: Our attentive housekeeping team ensures your room is pristine and refreshed daily.
</li><li>Concierge Service: Our dedicated concierge is available to assist with any requests, from restaurant reservations to local sightseeing recommendations.
</li>      </ul>
    </p>
  </div>
 
 <div class="Room-form-modal" id="RoomFormModal">
        <form method="POST" action="">
            <div class="Room-form">
                <input type="text" name="RoomID" placeholder="Room ID" required>
                <input type="date" name="date" placeholder="Check-in Date" required>
                <input type="date" name="CheckOut" placeholder="Check-out Date" required>
                <input type="date" name="BDate" placeholder="Booking Date" required>
                <button type="submit" class="addRoomBtn">Book Room</button>
            </div>
        </form>
    </div>
 </div>


	

    

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
  <script>
const addRoomBtn = document.querySelector('.add-Room-btn');
const roomFormModal = document.getElementById('RoomFormModal');

// Show the modal when the button is clicked
addRoomBtn.addEventListener('click', (event) => {
    event.preventDefault(); // Prevent the default button action
    roomFormModal.classList.add('active');
});

// Hide the modal when clicking outside of it
roomFormModal.addEventListener('click', (event) => {
    if (event.target === roomFormModal) {
        roomFormModal.classList.remove('active');
    }
});


</script>
</html>
