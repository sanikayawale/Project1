<?php
// Start the session
session_start();

// Include the database connection file
include 'dbconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['agency_id'])) {
    // User is not logged in, redirect them to the login page
    header('Location: Agency_login.php');
    exit;
}

// Retrieve data sent via POST request
$productId = $_POST['productId'];
$userId = $_POST['userId'];
$agencyId = $_POST['agencyId'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$paymentMethod = $_POST['paymentMethod'];
$bookingDatetime = $_POST['bookingDatetime'];
$returnDatetime = date('Y-m-d H:i:s'); // Get the current datetime for return

// Insert data into history table
$insertQuery = "INSERT INTO history (user_id, product_id, agency_id, start_date, end_date, payment_method, booking_datetime, return_datetime)
                VALUES ('$userId', '$productId', '$agencyId', '$startDate', '$endDate', '$paymentMethod', '$bookingDatetime', '$returnDatetime')";
if (mysqli_query($conn, $insertQuery)) {
    // If insertion is successful, delete the booking entry from the booking table
    $deleteQuery = "DELETE FROM booking WHERE product_id = '$productId' AND user_id = '$userId'";
    if (mysqli_query($conn, $deleteQuery)) {
        // Update product count and booked_product count in the products table
        $updateQuery = "UPDATE products SET count = count + 1, booked_product = booked_product - 1 WHERE product_id = '$productId'";
        if (mysqli_query($conn, $updateQuery)) {
            // Return a success message
            echo 'success';
        } else {
            echo 'Failed to update product counts: ' . mysqli_error($conn);
        }
    } else {
        echo 'Failed to delete booking: ' . mysqli_error($conn);
    }
} else {
    echo 'Failed to insert into history table: ' . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
