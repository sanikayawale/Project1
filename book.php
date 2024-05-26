<?php
include 'dbconnect.php';
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $userId = $_SESSION['user_id']; // Current user ID from session
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $startDate = isset($_POST['start-date']) ? $_POST['start-date'] : '';
    $endDate = isset($_POST['end-date']) ? $_POST['end-date'] : '';
    $paymentMethod = isset($_POST['payment-method']) ? $_POST['payment-method'] : '';
    $productId = $_POST['product_id'] ?? 0; // Retrieve product_id from the form data


    // Get the current date and time
    $currentDateTime = date('Y-m-d H:i:s'); // Format: 'YYYY-MM-DD HH:MM:SS'

    // Update user address in the `users` table
    $updateAddressQuery = 'UPDATE users SET address = ? WHERE Id = ?';
    if ($stmt = $conn->prepare($updateAddressQuery)) {
        $stmt->bind_param('si', $address, $userId);
        $stmt->execute();
        $stmt->close();
    } else {
        echo '<p>Error preparing statement: ' . $conn->error . '</p>';
    }

    // Fetch the current count and booked_count from the `products` table using product_id
    $fetchCountQuery = 'SELECT count, booked_count, agency_id FROM products WHERE product_id = ?';
    $count = 0;
    $bookedCount = 0;
    $agencyId = 0; // Initialize agencyId
    if ($stmt = $conn->prepare($fetchCountQuery)) {
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $count = $row['count'];
            $bookedCount = $row['booked_count'];
            $agencyId = $row['agency_id']; // Fetch the agency_id
        }
        $stmt->close();
    } else {
        echo '<p>Error preparing statement: ' . $conn->error . '</p>';
    }

    // Check if there are available products to book
    if ($count > 0) {
        // Increment booked_count and decrement count by 1
        $updateProductQuery = 'UPDATE products SET count = ?, booked_count = ? WHERE product_id = ?';
        $newCount = $count - 1;
        $newBookedCount = $bookedCount + 1;
        if ($stmt = $conn->prepare($updateProductQuery)) {
            $stmt->bind_param('iii', $newCount, $newBookedCount, $productId);
            $stmt->execute();
            $stmt->close();
        } else {
            echo '<p>Error preparing statement: ' . $conn->error . '</p>';
        }

        // Insert booking details into the `booking` table
        $insertBookingQuery = 'INSERT INTO booking (start_date, end_date, payment_method, product_id, agency_id, user_id, booking_datetime) VALUES (?, ?, ?, ?, ?, ?, ?)';
        if ($stmt = $conn->prepare($insertBookingQuery)) {
            $stmt->bind_param('sssiiis', $startDate, $endDate, $paymentMethod, $productId, $agencyId, $userId, $currentDateTime);
            $stmt->execute();
            $stmt->close();
        } else {
            echo '<p>Error preparing statement: ' . $conn->error . '</p>';
        }

        // Close the database connection
        $conn->close();

        // Redirect the user to a confirmation page or display a success message
        echo '<script type="text/javascript">';
        echo 'alert("Booking confirmed successfully!");';
        echo 'window.location.href = "home.php";'; // Redirect to home.php
        echo '</script>';
    } else {
        // Display a message if no products are available for booking
        echo '<script type="text/javascript">';
        echo 'alert("No available products for booking!");';
        echo 'window.location.href = "booking_form.php";'; // Redirect back to the booking form
        echo '</script>';
    }
}
?>
