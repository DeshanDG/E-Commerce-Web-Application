<?php
session_start();
include 'connection.php';

// User CRUD

// User Create 

if (isset($_POST['addUserBtn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password

        $insertSql = "INSERT INTO users (username, email, phone, address, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertSql);
        mysqli_stmt_bind_param($stmt, 'sssss', $name, $email, $phone, $address, $password);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('New record created successfully');</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
	
// User Update

if (isset($_POST['updateUser'])) {
    $id = $_POST['edit_user_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $phone = $_POST['edit_phone'];
    $address = $_POST['edit_address'];

    $sql = "UPDATE users SET username='$username', email='$email', 
            phone='$phone', address='$address' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating user: " . $conn->error . "');</script>";
    }
}


// User Delete
if (isset($_POST['deleteUser'])) {
    $userId = $_POST['user_id'];

    // Prepare and execute delete query
    $deleteQuery = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully!');</script>";
    } else {
        echo "<script>alert('Failed to delete user!');</script>";
    }
}


// Event CRUD

// Event Create 
if (isset($_POST['addEvent'])) {
    $eventName = $_POST['event_name'];
    $venue = $_POST['venue'];
    $eventTime = $_POST['event_time'];

    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["event_image"]["name"]);

    // Create uploads directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Check if the event ID exists in the database (only if eventID is provided)
		if (move_uploaded_file($_FILES["event_image"]["tmp_name"], $targetFile)) {
            $insertSql = "
                INSERT INTO events (event_name, venue, event_date, image_url) 
                VALUES (?, ?, ?, ?)
            ";
            $stmt = mysqli_prepare($conn, $insertSql);
            mysqli_stmt_bind_param($stmt, 'ssss', $eventName, $venue, $eventTime, $targetFile);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('New event added successfully!');</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
   mysqli_stmt_close($stmt);
}

// Delete Event
if (isset($_POST['deleteEvent'])) {
    $id = $_POST['event_id'];
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Event deleted successfully!');</script>";
    } else {
        echo "Error deleting event: " . mysqli_error($conn);
    }
}

//Update Event
if (isset($_POST['updateEvent'])) {

    $eventId = $_POST['event_id'];
    $eventName = $_POST['event_name'];
    $venue = $_POST['venue'];
    $eventDate =$_POST['event_date'];
    $imageUrl = $_POST['image_url'];

    $sql = "UPDATE events SET event_name = ?, venue = ?, event_date = ?, image_url = ? WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'ssssi', $eventName, $venue, $eventDate, $imageUrl, $eventId);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Event Update successfully!');</script>";
        } else {
            echo "<script>alert('Event Updation Error!');</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}



// Contact CRUD

// Add Contact
if (isset($_POST['replyBtn'])) {
    $email = $_POST['email'];
    $message = $_POST['message'];
    
        $insertSql = "
            INSERT INTO replies (email, message, created_at) 
            VALUES (?, ?, NOW())
        ";
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("ss", $email, $message);

        if ($stmt->execute()) {
            echo "<script>alert('Reply added successfully!');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    $stmt->close();
}


// Delete Contact
if (isset($_POST['contactEvent'])) {
    $id = $_POST['Contact_id'];
    $sql = "DELETE FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Entry deleted successfully!');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Delete Comment
if (isset($_POST['CommentEvent'])) {
    $id = $_POST['Comment_id'];
    $sql = "DELETE FROM comments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Entry deleted successfully!');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


// Update Comment
if (isset($_POST['updateComment'])) {
    $comment_id = $_POST['Comment_id'];
    $name = $_POST['edit-comment-name'];
    $rating = $_POST['edit-comment-rating'];
    $complement = $_POST['edit-comment-complement'];

    // Validate input
    if (empty($name) || empty($rating) || empty($complement)) {
        echo "<script>alert('All field required to Update comment!');</script>";
        exit;
    }

    $stmt = $conn->prepare("UPDATE comments SET name = ?, rating = ?, complement_of_service = ? WHERE id = ?");
    $stmt->bind_param('sisi', $name, $rating, $complement, $comment_id);

    if ($stmt->execute()) {
		echo "<script>alert('Comment Updated successfully');</script>";
    } else {
		echo "<script>alert('Comment Updation Failed');</script>";
    }

    $stmt->close();
}

// Reservations CRUD

// Add Reservations
if (isset($_POST['addRoomBtn'])) {
    $RoomID = $_POST['RoomID'];
    $CheckInDate = $_POST['date'];
    $CheckOutDate = $_POST['CheckOut'];
    $Rtype = $_POST['Rtype'];
    $Price = $_POST['Price'];
    $BDate = $_POST['BDate'];

        $insertQuery = "INSERT INTO bookings (RoomID, CheckInDate, CheckOutDate, Rtype, Price, BDate) VALUES (?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ssssss", $RoomID, $CheckInDate, $CheckOutDate, $Rtype, $Price, $BDate);

        if ($insertStmt->execute()) {
            echo "<script>alert('New booking added successfully!');</script>";
        } else {
            echo "Error adding booking: " . $conn->error;
        }
        $insertStmt->close();
}


// Delete Reservations
if (isset($_POST['deleteBooking'])) {
    $BID = $_POST['B_id'];

    $deleteQuery = "DELETE FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("s", $BID);

    if ($stmt->execute()) {
        echo "<script>alert('Reservation deleted successfully!');</script>";
    } else {
        echo "Error deleting reservation: " . $conn->error;
    }

    $stmt->close();
}

// Employee CRUD

// Create Employee

if (isset($_POST['addEmployeeBtn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $etype = $_POST['Etype'];
    $salary = $_POST['salary'];
    $password = $_POST['password']; 

    $targetDir = "uploads/"; 
    $targetFile = $targetDir . basename($_FILES["Emp_image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $uploadOk = 1;

    $check = getimagesize($_FILES["Emp_image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($_FILES["Emp_image"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["Emp_image"]["tmp_name"], $targetFile)) {

                $insertQuery = "
                    INSERT INTO employee ( name, email, phone, position, salary, password, img_url) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param("sssssss", $name, $email, $phone, $etype, $salary, $password, $targetFile);

                if ($stmt->execute()) {
                    echo "<script>alert('New employee added successfully!');</script>";
                } else {
                    echo "Error adding employee: " . $stmt->error;
                }
            } 
         else {
            echo "Sorry, there was an error uploading your file.";
        }
	}
		$stmt->close();
    }

// Handle Add Loyalty Member
if (isset($_POST['addLoyalty'])) {
    $user_id = $_POST['user_id'];
    $points = $_POST['points'];
    $last_check_in = $_POST['last_check_in'];
    $check_in_count = $_POST['check_in_count'];

    $sql = "INSERT INTO loyalty_program (user_id, points, last_check_in, check_in_count) 
            VALUES ('$user_id', '$points', '$last_check_in', '$check_in_count')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Loyalty member added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

if (isset($_POST['updateLoyalty'])) {
    $user_id = $_POST['user_id'] ?? null;
    $points = $_POST['points'] ?? 0;
    $last_check_in = $_POST['last_check_in'] ?? null;
    $check_in_count = $_POST['check_in_count'] ?? 0;

    // Validate that user_id and required fields are not empty
    if ($user_id && $last_check_in) {
        $sql = "UPDATE loyalty_program SET 
                    points = ?, 
                    last_check_in = ?, 
                    check_in_count = ? 
                WHERE user_id = ?";

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isii", $points, $last_check_in, $check_in_count, $user_id);

        if ($stmt->execute()) {
            echo "<script>alert('Loyalty record updated successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('User ID and Last Check-In are required!');</script>";
    }
}

// Handle Delete Loyalty Member
if (isset($_POST['deleteLoyalty'])) {
    $user_id = $_POST['user_id'];
    $sql = "DELETE FROM loyalty_program WHERE user_id=$user_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Loyalty member deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}


// Delete Employee
if (isset($_POST['deleteEmp'])) {
    $EmpId = $_POST['Emp_id'];

    $deleteQuery = "DELETE FROM employee WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("s", $EmpId);

    if ($stmt->execute()) {
        echo "<script>alert('Reservation deleted successfully!');</script>";
    } else {
        echo "Error deleting reservation: " . $conn->error;
    }

    $stmt->close();
}

//Total user count

$sql = "SELECT COUNT(*) AS total FROM users";
$result = $conn->query($sql);

$totalUsers = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalUsers = $row['total'];
}

//Total Contact count

$sql = "SELECT COUNT(*) AS total FROM contacts";
$result = $conn->query($sql);

$totalContact = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalContact = $row['total'];
}

//Total Booking count

$sql = "SELECT COUNT(*) AS total FROM bookings";
$result = $conn->query($sql);

$totalBooking = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalBooking = $row['total'];
}

//Total Event count

$sql = "SELECT COUNT(*) AS total FROM events";
$result = $conn->query($sql);

$totalEvent = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalEvent = $row['total'];
}

//Total Comment count

$sql = "SELECT COUNT(*) AS total FROM comments";
$result = $conn->query($sql);

$totalComments = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalComments = $row['total'];
}

//Total Employee count

$sql = "SELECT COUNT(*) AS total FROM employee";
$result = $conn->query($sql);

$totalEmployee = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalEmployee = $row['total'];
}

//Total Reply count

$sql = "SELECT COUNT(*) AS total FROM replies";
$result = $conn->query($sql);

$totalReplies = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalReplies = $row['total'];
}

// Admin Det

$employeeID = $_SESSION['Employee_id'] ?? null;

if ($employeeID) {
    $query = "SELECT name, img_url, position FROM employee WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $employeeID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employeeName = $row['name'];
        $employeeImage = $row['img_url'];
        $employeePosition = $row['position'];
		
        if ($employeePosition !== 'Admin') {
            header("Location: profile.php");
            exit;
        }
    } else {
        $employeeName = "Guest";
        $employeeImage = "assets/default-user.jpg";
    }
} else {
    $employeeName = "Guest";
    $employeeImage = "assets/default-user.jpg";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="Admin.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="assets/i.png" alt="Logo" class="logo">
        <ul class="nav-links">
            <li><a href="#" data-page="dashboard" class="active">Dashboard</a></li>
            <li><a href="#" data-page="users">Users</a></li>
            <li><a href="#" data-page="employees">Employees</a></li>
            <li><a href="#" data-page="rooms">Rooms</a></li>
            <li><a href="#" data-page="events">Events</a></li>
            <li><a href="#" data-page="loyalty">Loyalty Programs</a></li>
            <li><a href="#" data-page="contact">Contact</a></li>
        </ul>
        <div class="sign-out-container">
            <a href="LogOut.php"><button class="sign-out">Sign Out</button></a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <div class="breadcrumb">Home / Dashboard</div>
            <div class="user-menu">
                <span class="username">Welcome, <?php echo htmlspecialchars($employeeName); ?></span>
                <img class="user-icon" src="<?php echo htmlspecialchars($employeeImage); ?>" alt="User Icon">
            </div>
        </div>

        <!-- Content Container -->
        <div class="content-container">
            <!-- Dashboard Section -->
            <div id="dashboard-content" class="content-section">
                <h1>Dashboard</h1><br>
                <div class="stats-container">
                    <div class="stat-card"><h2>Total Users</h2><p id="total-users"><?php echo $totalUsers; ?></p></div>
                    <div class="stat-card"><h2>Total Contacts</h2><p id="checked-in-users"><?php echo $totalContact; ?></p></div>
                    <div class="stat-card"><h2>Total Bookings</h2><p id="total-rooms"><?php echo $totalBooking; ?></p></div>
                    <div class="stat-card"><h2>Total Events</h2><p id="booked-rooms"><?php echo $totalEvent; ?></p></div>
                     <div class="stat-card"><h2>Total Comments</h2><p id="total-comments"><?php echo $totalComments; ?></p></div>
                    <div class="stat-card"><h2>Total Employees</h2><p id="total-Employees"><?php echo $totalEmployee; ?></p></div>
                    <div class="stat-card"><h2>Total Replies</h2><p id="booked-Replies"><?php echo $totalReplies; ?></p></div>
                    
					 </div>
            </div>

            <!-- Users Section -->
           <div id="users-content" class="content-section hidden">
				<div class="page-header">
					<h1>Users</h1>
					<div class="header-actions">
						<button class="add-user-btn">Add User</button>
						<form class="search-form">
							<input type="text" id="searchInput" class="search-input" placeholder="Search User by Email" oninput="searchUsers()">
							<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
						</form>
					</div>
				</div>
				<table class="data-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Phone Number</th>
							<th>Address</th>
							<th>Password</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody id="user-table">
						<?php
							$sql = "SELECT * FROM users";
							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>
										<td>{$row['id']}</td>
										<td>{$row['username']}</td>
										<td>{$row['email']}</td>
										<td>{$row['phone']}</td>
										<td>{$row['address']}</td>
										<td>{$row['password']}</td>
										<td>
											<button class='btn btn-edit' 
													onclick='openEditForm({$row['id']}, \"{$row['username']}\", 
													\"{$row['email']}\", \"{$row['phone']}\", \"{$row['address']}\")'>
												<i class='bx bxs-edit'></i>
											</button>
											<form method='POST' style='display: inline-block;'>
												<input type='hidden' name='user_id' value='{$row['id']}'>
												<button type='submit' name='deleteUser'><i class='bx bxs-user-x'></i></button>
											</form>
										</td>
									</tr>";
								}
							} else {
								echo "<script>alert('No Users Found!');</script>";
							}
						?>
					</tbody>
				</table>
				</div>

			 <!-- Modal for User Edit Form -->
			<div class="edit-form-modal" id="edit-form-modal">
				<div class="edit-form">
					<h2>Edit User</h2>
					<form method="POST" id="editUserForm">
						<input type="hidden" name="user_id" id="editUserId">
						<label for="username">Name :</label>
						<input type="text" name="username" id="editUsername" required><br>
						<label for="email">Email    :</label>
						<input type="email" name="email" id="editEmail" required><br>
						<label for="phone">Phone    :</label>
						<input type="text" name="phone" id="editPhone" required><br>
						<label for="address">Address  :</label>
						<input type="text" name="address" id="editAddress" required><br><br>
						<div class="button-group">
							<button type="submit" name="updateUser">Update</button>
							<button type="button" class="cancel" onclick="closeEditForm()">Cancel</button>
						</div>
					</form>
				</div>
			</div>
			
<!-- Employees Section -->
<div id="employees-content" class="content-section hidden">
    <div class="page-header">
        <h1>Employees</h1>
        <div class="header-actions">
            <button class="add-Employee-btn">Add Employee</button>
            <form class="search-form">
                <input type="text" id="employeeSearchInput" class="search-input" placeholder="Search Employee by Email" oninput="searchEmployees()">
				<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </form>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Position</th>
                <th>Image</th>
                <th>Salary</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>
        </thead>
<tbody id="employee-table">
            <?php
                $sql = "SELECT * FROM employee";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['position']}</td>
                            <td><img src='{$row['img_url']}' alt='Emp Image' width='100'></td>
                            <td>{$row['salary']}</td>
                            <td>{$row['password']}</td>
                            <td>
                                <button class='btn btn-edit' 
                                    onclick='openEmployeeEditForm(
                                        {$row['id']}, \"{$row['name']}\", 
                                        \"{$row['email']}\", \"{$row['phone']}\", 
                                        \"{$row['position']}\", \"{$row['img_url']}\", 
                                        {$row['salary']}
                                    )'>
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <form method='POST' style='display: inline-block;'>
                                    <input type='hidden' name='Emp_id' value='{$row['id']}'>
                                    <button type='submit' name='deleteEmp' class='btn btn-danger'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<script>alert('No Employees Found!');</script>";
                }
            ?>
        </tbody>
    </table>
</div>

			<!-- Modal for Employee Edit Form -->
			<div class="edit-employee-modal" id="edit-employee-modal">
				<div class="edit-employee-form">
					<h2>Edit Employee</h2>
					<form method="POST" id="editEmployeeForm">
						<input type="hidden" name="Emp_id" id="editEmpId">

						<label for="name">Name:</label>
						<input type="text" name="name" id="editName" required>

						<label for="email">Email:</label>
						<input type="email" name="email" id="editEmail" required>

						<label for="phone">Phone:</label>
						<input type="text" name="phone" id="editPhone" required>

						<label for="position">Position:</label>
						<input type="text" name="position" id="editPosition" required>

						<label for="image">Image URL:</label>
						<input type="text" name="img_url" id="editImgUrl" required>

						<label for="salary">Salary:</label>
						<input type="number" name="salary" id="editSalary" required>

						<label for="password">Password:</label>
						<input type="password" name="password" id="editPassword" required>

						<div class="button-group">
							<button type="submit" name="updateEmployee">Update Employee</button>
							<button type="button" class="cancel" onclick="closeEditEmployeeForm()">Cancel</button>
						</div>
					</form>
				</div>
			</div>


						
			<!-- Reservations Section -->
			<div id="rooms-content" class="content-section hidden">
				<div class="page-header">
					<h1>Reservations</h1>
					<div class="header-actions">
						<button class="add-room-btn">Add Reservation</button>
						<form class="search-form" onsubmit="return false;">
							<input type="text" id="reservationSearchInput" class="search-input" placeholder="Search Reservation by Room ID" oninput="searchReservations()">
							<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
						</form>
					</div>
				</div>
				
				<table class="data-table">
					<thead>
						<tr>
							<th>Booking ID</th>
							<th>Room ID</th>
							<th>Check-in Date</th>
							<th>Check-out Date</th>
							<th>Room Type</th>
							<th>Price</th>
							<th>Booking Date</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody id="reservation-table">
						<?php
							$sql = "SELECT * FROM bookings";
							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>
										<td>{$row['id']}</td>
										<td>{$row['RoomID']}</td>
										<td>{$row['CheckInDate']}</td>
										<td>{$row['CheckOutDate']}</td>
										<td>{$row['Rtype']}</td>
										<td>{$row['Price']}</td>
										<td>{$row['BDate']}</td>
										<td>
											<button class='btn btn-edit' 
												onclick='openReservationEditForm(
													{$row['id']}, \"{$row['RoomID']}\", 
													\"{$row['CheckInDate']}\", 
													\"{$row['CheckOutDate']}\", 
													\"{$row['Rtype']}\", 
													\"{$row['Price']}\", 
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
								}
							} else {
								echo "<tr><td colspan='8'>No Bookings Found!</td></tr>";
							}
						?>
					</tbody>
				</table>
			</div>



			<!-- Modal for Reservation Edit Form -->
			<div class="edit-reservation-modal" id="edit-reservation-modal">
				<div class="edit-form">
					<h2>Edit Reservation</h2>
					<form method="POST" id="editReservationForm">
						<input type="hidden" name="B_id" id="editBookingId">
						
						<label for="RoomID">Room ID:</label>
						<input type="text" name="RoomID" id="editRoomID" required><br>

						<label for="CheckInDate">Check-in Date:</label>
						<input type="date" name="CheckInDate" id="editCheckInDate" required><br>

						<label for="CheckOutDate">Check-out Date:</label>
						<input type="date" name="CheckOutDate" id="editCheckOutDate" required><br>

						<label for="Rtype">Room Type:</label>
						<input type="text" name="Rtype" id="editRoomType" required><br>

						<label for="Price">Price:</label>
						<input type="text" name="Price" id="editPrice" required><br>

						<label for="BDate">Booking Date:</label>
						<input type="date" name="BDate" id="editBookingDate" required><br><br>

						<div class="button-group">
							<button type="submit" name="updateBooking">Update</button>
							<button type="button" class="cancel" onclick="closeReservationEditForm()">Cancel</button>
						</div>
					</form>
				</div>
			</div>

			
			<!-- events Section -->
            <div id="events-content" class="content-section hidden">
    <div class="page-header">
        <h1>Events</h1>
        <div class="header-actions">
            <button class="add-Event-btn">Add Events</button>
            <form class="search-form">
                <input type="text" id="eventSearchInput" class="search-input" placeholder="Search Event by Name" oninput="searchEvents()">
				<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </form>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event Name</th>
                <th>Event Location</th>
                <th>Event Date</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="event-table">
            <?php
                $sql = "SELECT * FROM events";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['event_name']}</td>
                            <td>{$row['venue']}</td>
                            <td>{$row['event_date']}</td>
                            <td><img src='{$row['image_url']}' alt='Event Image' width='100'></td>
                            <td>
                                <button class='btn btn-edit' 
                                        onclick='openEventEditForm({$row['id']}, \"{$row['event_name']}\", 
                                        \"{$row['venue']}\", \"{$row['event_date']}\", 
                                        \"{$row['image_url']}\")'>
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <form method='POST' style='display: inline-block;'>
                                    <input type='hidden' name='event_id' value='{$row['id']}'>
                                    <button type='submit' name='deleteEvent' class='btn btn-danger'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<script>alert('No Events Found!');</script>";
                }
            ?>
        </tbody>
    </table>
</div>

			<!-- Modal for Edit Form -->
			<div class="edit-Event-modal" id="edit-Event-modal">
			<div class="edit-form">
				<h2>Edit Event</h2>
				<form method="POST" id="editEventForm">
					<input type="hidden" name="event_id" id="editEventId">
					<label for="event_name">Event Name:</label>
					<input type="text" name="event_name" id="editEventName" required><br>
					<label for="venue">Event Location:</label>
					<input type="text" name="venue" id="editVenue" required><br>
					<label for="event_date">Event Date:</label>
					<input type="date" name="event_date" id="editEventDate" required><br>
					<label for="image_url">Image URL:</label>
					<input type="text" name="image_url" id="editImageUrl" required><br><br>
					<div class="button-group">
						<button type="submit" name="updateEvent">Update</button>
						<button type="button" class="cancel" onclick="closeEventEditForm()">Cancel</button>
					</div>
				</form>
				</div>
			</div>

			
<div id="loyalty-content" class="content-section">
    <div class="page-header">
        <h1>Loyalty Program</h1>
        <button class="add-Loyalty-btn" onclick="openLoyaltyForm()">Add Loyalty</button>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Points</th>
                <th>Last Check-In</th>
                <th>Check-In Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM loyalty_program";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['user_id']}</td>
                            <td>{$row['points']}</td>
                            <td>{$row['last_check_in']}</td>
                            <td>{$row['check_in_count']}</td>
                            <td>
                                <button class='btn btn-edit' 
                                        onclick='openLoyaltyEditForm({$row['user_id']}, 
                                        {$row['points']}, 
                                        \"{$row['last_check_in']}\", 
                                        {$row['check_in_count']})'>
                                    Edit
                                </button>
                                <form method='POST' style='display: inline-block;'>
                                    <input type='hidden' name='user_id' value='{$row['user_id']}'>
                                    <button type='submit' name='deleteLoyalty' class='btn btn-danger'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No Loyalty Records Found</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>

			
			<!-- contact Section -->
			<div id="contact-content" class="content-section hidden">
    <div class="page-header">
        <h1>Contact</h1>
        <div class="header-actions">
            <button class="add-Contact-btn">Reply</button>
            <form class="search-form">
                <input type="text" class="search-input" placeholder="Search Contact">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </form>
        </div>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="contact-table">
            <?php
                $sql = "SELECT * FROM contacts";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['message']}</td>
                            <td>
                                <form method='POST' style='display: inline-block;'>
                                    <input type='hidden' name='Contact_id' value='{$row['id']}'>
                                    <button type='submit' name='contactEvent' class='btn btn-danger'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<script>alert('No Contacts Found!');</script>";
                }
            ?>
        </tbody>
    </table>

 <!-- Edit Contact Modal -->
<div id="edit-contact-modal" class="modal hidden">
    <div class="edit-form">
        <h2>Edit Contact</h2>
        <form id="edit-contact-form" method="POST">
            <input type="hidden" name="Contact_id" id="edit-contact-id">
            <label for="edit-contact-name">Name:</label>
            <input type="text" name="edit-contact-name" id="edit-contact-name" required>
            <label for="edit-contact-message">Message:</label>
            <textarea name="edit-contact-message" id="edit-contact-message" required></textarea>
            <button type="submit" name="updateContact">Update</button>
            <button type="button" class="cancel" onclick="closeContactEditForm()">Cancel</button>
        </form>
    </div>
</div>

    <br>
    <h1>Comments</h1>
    <div class="header-actions">
        <h1></h1>
        <form class="search-form">
            <input type="text" class="search-input" placeholder="Search Comments">
            <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
        </form>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Rating</th>
                <th>Complement Of Service</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="comment-table">
            <?php
                $sql = "SELECT * FROM comments";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['rating']}</td>
                            <td>{$row['complement_of_service']}</td>
                            <td>
                                <form method='POST' style='display: inline-block;'>
                                    <input type='hidden' name='Comment_id' value='{$row['id']}'>
                                    <button type='button' class='btn btn-edit' onclick='openCommentEditForm({$row['id']}, \"{$row['name']}\", \"{$row['email']}\", \"{$row['rating']}\", \"{$row['complement_of_service']}\")'>Edit</button>
                                    <button type='submit' name='CommentEvent' class='btn btn-danger'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<script>alert('No Comments Found!');</script>";
                }
            ?>
        </tbody>
    </table>

    <!-- Edit Comment Form Modal -->
   <div id="edit-comment-modal" class="modal hidden">
    <div class="edit-form">
        <h2>Edit Comment</h2>
        <form id="edit-comment-form" method="POST">
            <input type="hidden" name="Comment_id" id="edit-comment-id">
            <label for="edit-comment-name">Name:</label>
            <input type="text" name="edit-comment-name" id="edit-comment-name" required>
            <label for="edit-comment-rating">Rating:</label>
            <input type="number" name="edit-comment-rating" id="edit-comment-rating" min="1" max="5" required>
            <label for="edit-comment-complement">Complement:</label>
            <textarea name="edit-comment-complement" id="edit-comment-complement" required></textarea>
            <button type="submit" name="updateComment" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-danger" onclick="closeCommentEditForm()">Cancel</button>
        </form>
    </div>
</div>
</div>

			
				</div>
			</div>
	
	<!-- User Form -->
	
	<div class="user-form-modal" id="userFormModal">
	<form method="post" action="admin.php">
        <div class="user-form">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
			<input type="text" name="phone" placeholder="Phone Number" required>
			<input type="text" name="address" placeholder="Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="addUserBtn">Add User</button>
        </div>
	</form>
    </div>
	
	
	<!-- Employee Form -->
	
	<div class="Employee-form-modal" id="EmployeeFormModal">
    <div class="Employee-form">
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="phone" placeholder="Phone Number" required><br>
            <select name="Etype" required>
                <option value="" disabled selected>Select Position</option>
                <option value="Admin">Admin</option>
                <option value="Front Office">Front Office</option>
                <option value="House Keeping Attendant">House Keeping Attendant</option>
                <option value="Food & Beverage">Food & Beverage</option>
                <option value="Event Organizer">Event Organizer</option>
            </select><br>
            <input type="file" name="Emp_image" required><br>
            <input type="text" name="salary" placeholder="Salary" required><br>
            <input type="password" name="password" placeholder="Password" autocomplete="new-password"><br>
            <button type="submit" name="addEmployeeBtn">Add</button>
			</form>
		</div>
	</div>

	
	
	<!-- Room Form -->
	
	<div class="Room-form-modal" id="RoomFormModal">
    <form method="POST" action="">
        <div class="Room-form">
            <input type="text" name="RoomID" placeholder="Room ID" required>
            <input type="date" name="date" placeholder="Check-in Date" required>
            <input type="date" name="CheckOut" placeholder="Check-out Date" required>

            <select name="Rtype" required>
                <option value="" disabled selected>Select Room Type</option>
                <option value="Standard Room">Standard Room</option>
                <option value="Deluxe Room">Deluxe Room</option>
                <option value="Suite Room">Suite Room</option>
                <option value="Executive Room">Executive Room</option>
            </select>

            <input type="text" name="Price" placeholder="Price" required>
            <input type="date" name="BDate" placeholder="Booking Date" required>
            <button type="submit" name="addRoomBtn">Add</button>
        </div>
    </form>
</div>

	
	<!-- Event Form -->
	
	<div class="Event-form-modal" id="EventFormModal">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="Event-form"> 
            <input type="text" name="event_name" placeholder="Name" required>
            <input type="text" name="venue" placeholder="Location" required>
            <input type="date" name="event_time" placeholder="Time" required> 
            <input type="file" name="event_image" required>
            <button type="submit" name="addEvent" id="addEventBtn">Add</button> 
        </div>
    </form>
	</div>

	
	
<!-- Loyalty Form Modal -->
<div class="Loyalty-form-modal" id="LoyaltyFormModal">
    <form method="POST" id="loyaltyForm">
        <h2 id="formTitle">Add Loyalty</h2> <!-- Title dynamically set -->
        <input type="hidden" name="user_id" id="editUserId"> <!-- User ID stored here for updates -->
        
        <label for="points">Points:</label>
        <input type="number" name="points" id="points" required>

        <label for="last_check_in">Last Check-In:</label>
        <input type="date" name="last_check_in" id="lastCheckIn" required>

        <label for="check_in_count">Check-In Count:</label>
        <input type="number" name="check_in_count" id="checkInCount" required>

        <div class="button-group">
            <button type="submit" name="addLoyalty" id="addLoyaltyBtn">Add</button>
            <button type="submit" name="updateLoyalty" id="updateLoyaltyBtn" class="hidden">Update</button>
            <button type="button" class="cancel" onclick="closeLoyaltyForm()">Cancel</button>
        </div>
    </form>
</div>




	
	<!-- Contact Form -->
		
		<div class="Contact-form-modal" id="ContactFormModal">
			<div class="Contact-form">
				<form method="POST" action="">
					<input type="text" name="name" placeholder="Name" required><br>
					<input type="email" name="email" placeholder="Email" required><br>
					<input type="text" name="message" placeholder="Message" required><br>
					<button type="submit" name="replyBtn" id="ReplyBtn">Reply</button> 
				</form>
			</div>
		</div>


    <script>
	
	const contentContainer = document.querySelector('.content-container');
	const sections = document.querySelectorAll('.content-section');
	const navLinks = document.querySelectorAll('.nav-links a');

// Function to show the appropriate content section
function showSection(page) {
    // Hide all sections
    sections.forEach(section => section.classList.add('hidden'));

    // Show the selected section
    const targetSection = document.getElementById(`${page}-content`);
    if (targetSection) {
        targetSection.classList.remove('hidden');
    }
}

// Function to update the active link styling
function updateActiveLink(target) {
    navLinks.forEach(link => link.classList.remove('active'));
    target.classList.add('active');
}

// Handle sidebar navigation clicks
navLinks.forEach(link => {
    link.addEventListener('click', event => {
        event.preventDefault();
        const page = event.target.dataset.page;
        showSection(page);
        updateActiveLink(event.target);
    });
});

	const addUserButton = document.querySelector('.add-user-btn');
	const userFormModal = document.getElementById('userFormModal');

	const addEmployeebtn = document.querySelector('.add-Employee-btn');
	const EmployeeFormModal = document.getElementById('EmployeeFormModal');

	const addRoombtn = document.querySelector('.add-Room-btn');
	const RoomFormModal = document.getElementById('RoomFormModal');

	const addEventbtn = document.querySelector('.add-Event-btn');
	const EventFormModal = document.getElementById('EventFormModal');

	const addLoyaltybtn = document.querySelector('.add-Loyalty-btn');
	const LoyaltyFormModal = document.getElementById('LoyaltyFormModal');

	const addContactbtn = document.querySelector('.add-Contact-btn');
	const ContactFormModal = document.getElementById('ContactFormModal');
	
	const addCommentbtn = document.querySelector('.add-Comment-btn');
	const Commentformmodal = document.getElementById('Commentformmodal');

// Add User button click to show the form
addUserButton.addEventListener('click', () => {
    userFormModal.classList.add('active');
});

// Hide the form when clicking outside of it
userFormModal.addEventListener('click', event => {
    if (event.target === userFormModal) {
        userFormModal.classList.remove('active');
    }
});

// Add User button click to show the form
addEmployeebtn.addEventListener('click', () => {
    EmployeeFormModal.classList.add('active');
});

// Hide the form when clicking outside of it
EmployeeFormModal.addEventListener('click', event => {
    if (event.target === EmployeeFormModal) {
        EmployeeFormModal.classList.remove('active');
    }
});

// Add User button click to show the form
addRoombtn.addEventListener('click', () => {
    RoomFormModal.classList.add('active');
});

// Hide the form when clicking outside of it
RoomFormModal.addEventListener('click', event => {
    if (event.target === RoomFormModal) {
        RoomFormModal.classList.remove('active');
    }
});

// Add User button click to show the form
addEventbtn.addEventListener('click', () => {
    EventFormModal.classList.add('active');
});

// Hide the form when clicking outside of it
EventFormModal.addEventListener('click', event => {
    if (event.target === EventFormModal) {
        EventFormModal.classList.remove('active');
    }
});

// Add User button click to show the form
addLoyaltybtn.addEventListener('click', () => {
    LoyaltyFormModal.classList.add('active');
});

// Hide the form when clicking outside of it
LoyaltyFormModal.addEventListener('click', event => {
    if (event.target === LoyaltyFormModal) {
        LoyaltyFormModal.classList.remove('active');
    }
});

// Add User button click to show the form
addContactbtn.addEventListener('click', () => {
    ContactFormModal.classList.add('active');
});

// Hide the form when clicking outside of it
ContactFormModal.addEventListener('click', event => {
    if (event.target === ContactFormModal) {
        ContactFormModal.classList.remove('active');
    }
});

// Add User button click to show the form
addCommentbtn.addEventListener('click', () => {
    Commentformmodal.classList.add('active');
});

// Hide the form when clicking outside of it
Commentformmodal.addEventListener('click', event => {
    if (event.target === Commentformmodal) {
        Commentformmodal.classList.remove('active');
    }
});

	// User Edit form 
	function openEditForm(id, username, email, phone, address) {
    document.getElementById('editUserId').value = id;
    document.getElementById('editUsername').value = username;
    document.getElementById('editEmail').value = email;
    document.getElementById('editPhone').value = phone;
    document.getElementById('editAddress').value = address;
	
	const modal = document.getElementById('edit-form-modal');
    modal.classList.add('active');
}

	function closeEditForm() {
    const modal = document.getElementById('edit-form-modal');
    modal.classList.remove('active');
}

	// User Contact form 
function openContactEditForm(id, name, email, message) {
    document.getElementById('edit-contact-id').value = id;
    document.getElementById('edit-contact-name').value = name;
    document.getElementById('edit-contact-email').value = email;
    document.getElementById('edit-contact-message').value = message;
    document.getElementById('edit-contact-modal').classList.remove('hidden'); // Change to add 'active' if you use that
}

function closeContactEditForm() {
    document.getElementById('edit-contact-modal').classList.add('hidden'); // Change to remove 'active' if you use that
}

function openCommentEditForm(id, name, email, rating, complement) {
    document.getElementById('edit-comment-id').value = id;
    document.getElementById('edit-comment-name').value = name;
    document.getElementById('edit-comment-rating').value = rating;
    document.getElementById('edit-comment-complement').value = complement;
    document.getElementById('edit-comment-modal').classList.remove('hidden'); // Change to add 'active' if you use that
}

function closeCommentEditForm() {
    document.getElementById('edit-comment-modal').classList.add('hidden'); // Change to remove 'active' if you use that
}

		// User Event form 
function openEventEditForm(id, eventName, venue, eventDate, imageUrl) {
    console.log('Opening edit form:', id, eventName); // Debugging

    const modal = document.getElementById('edit-Event-modal');
    modal.classList.add('active'); // Show the modal

    // Set input values
    document.getElementById('editEventId').value = id;
    document.getElementById('editEventName').value = eventName;
    document.getElementById('editVenue').value = venue;
    document.getElementById('editEventDate').value = eventDate;
    document.getElementById('editImageUrl').value = imageUrl;
}

function closeEventEditForm() {
    console.log('Closing edit form'); // Debugging

    const modal = document.getElementById('edit-Event-modal');
    modal.classList.remove('active'); // Hide the modal
}



		function openReservationEditForm(id, roomID, checkInDate, checkOutDate, roomType, price, bookingDate) {
    // Set the form input values with the provided data
    document.getElementById('editBookingId').value = id;
    document.getElementById('editRoomID').value = roomID;
    document.getElementById('editCheckInDate').value = checkInDate;
    document.getElementById('editCheckOutDate').value = checkOutDate;
    document.getElementById('editRoomType').value = roomType;
    document.getElementById('editPrice').value = price;
    document.getElementById('editBookingDate').value = bookingDate;

    // Open the modal by adding the active class
    const modal = document.getElementById('edit-reservation-modal');
    modal.classList.add('active');
}

function closeReservationEditForm() {
    // Close the modal by removing the active class
    const modal = document.getElementById('edit-reservation-modal');
    modal.classList.remove('active');
}


		// User Employee form
function openEmployeeEditForm(id, name, email, phone, position, img_url, salary) {
    // Set the form input values with the provided employee data
    document.getElementById('editEmpId').value = id;
    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editPhone').value = phone;
    document.getElementById('editPosition').value = position;
    document.getElementById('editImgUrl').value = img_url;
    document.getElementById('editSalary').value = salary;

    // Open the modal by adding the 'active' class
    const modal = document.getElementById('edit-employee-modal');
    modal.classList.add('active');
}

function closeEditEmployeeForm() {
    // Close the modal by removing the 'active' class
    const modal = document.getElementById('edit-employee-modal');
    modal.classList.remove('active');
}

// Search Reservations by Room ID
function searchReservations() {
    const searchInput = document.getElementById('reservationSearchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#reservation-table tr'); // Select all rows

    rows.forEach(row => {
        const roomIDCell = row.cells[1]; // Get the 2nd column (Room ID)

        if (roomIDCell) {
            const roomID = roomIDCell.textContent.toLowerCase();
            row.style.display = roomID.includes(searchInput) ? '' : 'none'; // Toggle row visibility
        }
    });
}

function searchUsers() {
    // Get the input value
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const userTable = document.getElementById('user-table');
    const rows = userTable.getElementsByTagName('tr');

    // Loop through all rows, except for the header
    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let matchFound = false;

        // Check each cell in the row
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            if (cell) {
                // If the cell contains the search term, mark as found
                if (cell.textContent.toLowerCase().indexOf(searchInput) > -1) {
                    matchFound = true;
                    break;
                }
            }
        }

        // Show or hide the row based on the search match
        if (matchFound) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}


// Search Employees by Email
function searchEmployees() {
    const searchInput = document.getElementById('employeeSearchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#employee-table tr'); // Select all rows

    rows.forEach(row => {
        const emailCell = row.cells[2]; // Get the 3rd column (Email)

        if (emailCell) {
            const email = emailCell.textContent.toLowerCase();
            row.style.display = email.includes(searchInput) ? '' : 'none'; // Toggle row visibility
        }
    });
}

function openLoyaltyForm(isUpdate = false, userId = '', points = '', lastCheckIn = '', checkInCount = '') {
    document.getElementById('LoyaltyFormModal').style.display = 'flex';
    document.getElementById('formTitle').innerText = isUpdate ? 'Update Loyalty' : 'Add Loyalty';
    
    if (isUpdate) {
        document.getElementById('editUserId').value = userId;
        document.getElementById('points').value = points;
        document.getElementById('lastCheckIn').value = lastCheckIn;
        document.getElementById('checkInCount').value = checkInCount;

        document.getElementById('addLoyaltyBtn').classList.add('hidden');
        document.getElementById('updateLoyaltyBtn').classList.remove('hidden');
    } else {
        document.getElementById('loyaltyForm').reset();
        document.getElementById('addLoyaltyBtn').classList.remove('hidden');
        document.getElementById('updateLoyaltyBtn').classList.add('hidden');
    }
}

function closeLoyaltyForm() {
    document.getElementById('LoyaltyFormModal').style.display = 'none';
}


function openLoyaltyEditForm(userId, points, lastCheckIn, checkInCount) {
    document.getElementById('editUserId').value = userId;
    document.getElementById('points').value = points;
    document.getElementById('lastCheckIn').value = lastCheckIn;
    document.getElementById('checkInCount').value = checkInCount;

    document.getElementById('addLoyaltyBtn').classList.add('hidden');
    document.getElementById('updateLoyaltyBtn').classList.remove('hidden');
    document.getElementById('LoyaltyFormModal').style.display = 'block';
}

    </script>

    <style>
        .hidden {
            display: none;
        }
    </style>
</body>
</html>
