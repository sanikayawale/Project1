<?php
// Start session to access session variables
session_start();

// Include the database connection
require 'dbconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect them or show an error message
    echo "You must be logged in to view this page.";
    exit;
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Query to fetch booking details, product details (including image), and agency details based on user_id
$query = "
    SELECT b.product_id, b.agency_id, b.start_date, b.end_date, b.booking_datetime, b.payment_method,
           p.model_brand, p.model_year, p.rental_cost, p.category, p.image AS product_image,
           a.name AS agency_name, a.mobile AS agency_mobile, a.address AS agency_address
    FROM booking b
    JOIN products p ON b.product_id = p.product_id
    JOIN agency a ON b.agency_id = a.agency_id
    WHERE b.user_id = ?
";

// Prepare the statement
$stmt = $conn->prepare($query);

// Check if statement preparation was successful
if (!$stmt) {
    echo "Failed to prepare statement: " . $conn->error;
    exit;
}

// Bind the user ID parameter
$stmt->bind_param("i", $user_id);

// Execute the statement
$stmt->execute();

// Fetch the results
$result = $stmt->get_result();

// Check if any results were found
if ($result->num_rows == 0) {
    echo "No booked products found.";
} else {
    // Display the results in a table
    echo '<table border="1" cellpadding="10">';
    echo '<tr>';
    // echo '<th>Product ID</th>';
    echo '<th>Product Image</th>';
    echo '<th>Agency Name</th>';
    echo '<th>Start Date</th>';
    echo '<th>End Date</th>';
    echo '<th>Booking Date/Time</th>';
    echo '<th>Payment Method</th>';
    echo '<th>Model Brand</th>';
    echo '<th>Model Year</th>';
    echo '<th>Rental Cost</th>';
    echo '<th>Category</th>';
    echo '<th>Agency Mobile</th>';
    echo '<th>Agency Address</th>';
    echo '</tr>';
    
    // Loop through each result and display the data
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        // echo '<td>' . $row['product_id'] . '</td>';
        
        // Convert the BLOB image to a base64 encoded string and display the image
        $image_base64 = base64_encode($row['product_image']);
        echo '<td><img src="data:image/jpeg;base64,' . $image_base64 . '" alt="Product Image" style="width: 100px; height: 100px;"></td>';
        
        echo '<td>' . $row['agency_name'] . '</td>';
        echo '<td>' . $row['start_date'] . '</td>';
        echo '<td>' . $row['end_date'] . '</td>';
        echo '<td>' . $row['booking_datetime'] . '</td>';
        echo '<td>' . $row['payment_method'] . '</td>';
        echo '<td>' . $row['model_brand'] . '</td>';
        echo '<td>' . $row['model_year'] . '</td>';
        echo '<td>' . $row['rental_cost'] . '</td>';
        echo '<td>' . $row['category'] . '</td>';
        echo '<td>' . $row['agency_mobile'] . '</td>';
        echo '<td>' . $row['agency_address'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
