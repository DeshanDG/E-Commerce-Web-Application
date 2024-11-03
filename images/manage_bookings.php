<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $id = $_POST['id'];

    if ($action == 'update') {
        $check_in = $_POST['check_in'];
        $check_out = $_POST['check_out'];
        $adults = $_POST['adults'];
        $children = $_POST['children'];

        $sql = "UPDATE bookings SET check_in='$check_in', check_out='$check_out', adults=$adults, children=$children WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            echo "Booking updated successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action == 'delete') {
        $sql = "DELETE FROM bookings WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            echo "Booking deleted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
