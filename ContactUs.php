<?php
require_once 'connection.php';

// Handling the 'Contact Us' form submission
if (isset($_POST['Contacttbtn'])) {
    $firstName = $_POST['first_name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contacts (Name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $firstName, $email, $message);

    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

if (isset($_POST['commentbtn'])) {
    $name = $_POST['comment-name'];
    $rating = $_POST['rating-value'];
    $compliment = $_POST['compliment'];

    $insertSql = "INSERT INTO comments (name, rating, complement_of_service) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertSql);

    $stmt->bind_param("sis", $name, $rating, $compliment);

    if ($stmt->execute()) {
        echo "<script>alert('Comment submitted successfully!');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}


$sql = "SELECT name, rating, complement_of_service FROM comments ORDER BY id DESC LIMIT 3";
$result = $conn->query($sql);

$comments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
} else {
    echo "<p>No comments yet. Be the first to comment!</p>";
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
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
    
    <section class="section__container">
     <div class="form-container">
			
			<!--Contact section-->
            
			<div class="form-section">
                <h2>Contact Us</h2>
                <form action="" method="post">
				
					<label for="first_name">Name</label>
                    <input type="text" id="first_name" name="first_name" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="4" required></textarea>

                    <button type="submit" name="Contacttbtn">Submit</button>
                </form>
            </div>

			<!--Comment section-->

            <div class="comment-section">
			
                <h2>Comment</h2>
				
                <form id="comment-form" action="" method="post">
					<label for="comment-name">Name</label>
					<input type="text" id="comment-name" name="comment-name" required>

					<label for="rating">Rating</label>
					<div class="rating" id="rating-stars">
						<input type="hidden" id="rating-value" name="rating-value" value="0">
						<i class="bx bx-star" data-value="1"></i>
						<i class="bx bx-star" data-value="2"></i>
						<i class="bx bx-star" data-value="3"></i>
						<i class="bx bx-star" data-value="4"></i>
						<i class="bx bx-star" data-value="5"></i>
					</div>

						<label for="compliment">Compliment of Service</label>
						<textarea id="compliment" name="compliment" rows="4" required></textarea>

						<button type="submit" name="commentbtn">Post / Update</button>
				</form>

            </div>
			
			<!-- Comment cards -->
			
			<div class="comment-cards">
					<?php foreach ($comments as $comment): ?>
				<div class="card">
					<h3 class="card-name"><?= htmlspecialchars($comment['name']) ?></h3>
					<p class="card-rating">Rating: <?= str_repeat('★', $comment['rating']) . str_repeat('☆', 5 - $comment['rating']) ?></p>
					<p class="card-compliment"><?= htmlspecialchars($comment['complement_of_service']) ?></p>
				</div>
				   <?php endforeach; ?>
			</div>
			
			<br><br>
            
			<!-- Contact det -->
			
			<div class="contact-details">
                <h2>Contact Details</h2>
                <p>Address: Hotel KSP, Wilagedara Watta, Thuththiripitigama, Panduwasnuwara.</p>
                <p>Phone: +94 37 494 7270</p>
                <p>Email: shanuthpchamalka@gmail.com</p>
            </div>
        </div>
		

    </section>
	
			<!-- Footer -->

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

<script>
const stars = document.querySelectorAll("#rating-stars i");
const ratingValue = document.getElementById("rating-value");

stars.forEach((star) => {
    star.addEventListener("click", function () {
        const value = this.getAttribute("data-value");
        ratingValue.value = value;

        stars.forEach((s) => s.classList.remove("active"));

        this.classList.add("active");
        let prevStar = this.previousElementSibling;
        while (prevStar) {
            prevStar.classList.add("active");
            prevStar = prevStar.previousElementSibling;
        }
    });
});


</script>
</html>
