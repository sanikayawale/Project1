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


// Retrieve agency_id from the session
$agencyId = $_SESSION['agency_id'];

// Query to fetch booking data including related product and user information
$query = "SELECT b.product_id, b.user_id, b.start_date, b.end_date, b.payment_method, b.booking_datetime,
                 p.model_brand, p.category, p.rental_cost, p.image,
                 u.first_name, u.last_name, u.mobile, u.address
          FROM booking b
          JOIN products p ON b.product_id = p.product_id
          JOIN users u ON b.user_id = u.Id
          WHERE p.agency_id = '$agencyId'";
$result = mysqli_query($conn, $query);

// Check if any bookings were found
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='booking-container'>";
        echo "<div class='booking-info' 
        data-product-id='{$row['product_id']}' 
        data-user-id='{$row['user_id']}' 
        data-agency-id='$agencyId' 
        data-start-date='{$row['start_date']}' 
        data-end-date='{$row['end_date']}' 
        data-payment-method='{$row['payment_method']}' 
        data-booking-datetime='{$row['booking_datetime']}'>";
        echo "<div>";
        echo "<img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' height='100' width='100' />";
        echo "</div>";
        echo "<div>";
        echo "<p><strong>Model Brand:</strong> " . $row['model_brand'] . "</p>";
        echo "<p><strong>Category:</strong> " . $row['category'] . "</p>";
        echo "<p><strong>Rental Cost: Rs </strong> " . $row['rental_cost'] . "</p>";
        echo "</div>";
        echo "<div>";
        echo "<p><strong>First Name:</strong> " . $row['first_name'] . "</p>";
        echo "<p><strong>Last Name:</strong> " . $row['last_name'] . "</p>";
        echo "<p><strong>Mobile:</strong> " . $row['mobile'] . "</p>";
        echo "<p><strong>Address:</strong> " . $row['address'] . "</p>";
        echo "</div>";
        echo "<div>";
        echo "<p><strong>Start Date:</strong> " . $row['start_date'] . "</p>";
        echo "<p><strong>End Date:</strong> " . $row['end_date'] . "</p>";
        echo "<p><strong>Payment Method:</strong> " . $row['payment_method'] . "</p>";
        echo "<p><strong>Booking Datetime:</strong> " . $row['booking_datetime'] . "</p>";
        echo "</div>";
        echo "<div class='btn'>";
        echo "<button type='submit'class='return-btn' name='return' >Return</button>";
        echo "</div>";
        echo "</div>"; // Close booking-info
        echo "</div>"; // Close booking-container
    }
} else {
    echo "<div class='no-booking'>No bookings found.</div>";
}

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<style>
    .booking-container {
    border: 1px solid #ccc;
    margin-bottom: 20px;
    padding: 10px;
    width:1200px;
}

.booking-info img {
    /* float: left; */
    margin-right: 10px;
    width:200px;
    height:150px;
}
.booking-info{
    display:flex;
    gap:25px;
}
.no-booking {
    text-align: center;
    font-style: italic;
}
.btn{
    width:200px;
    position: relative;
   margin-top:50px;
   /* border: solid red 1px; */
   
}
button{
    width:120px;
    height:30px;
    position: absolute;
    bottom: 10px;
    right: 10px;
    font-size:17px;
    background:#A5E79C ;
    cursor: pointer;
    border-radius:5px;
}
button:hover{
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

</style>
<body>
    
<script>
    function returnBooking(button) {
    // Retrieve booking details from the button's data attributes
    const productId = $(button).closest('.booking-info').data('product-id');
    const userId = $(button).closest('.booking-info').data('user-id');
    const agencyId = $(button).closest('.booking-info').data('agency-id');
    const startDate = $(button).closest('.booking-info').data('start-date');
    const endDate = $(button).closest('.booking-info').data('end-date');
    const paymentMethod = $(button).closest('.booking-info').data('payment-method');
    const bookingDatetime = $(button).closest('.booking-info').data('booking-datetime');

    // Make AJAX request to handle return action
    $.ajax({
        url: 'return_booking.php',
        method: 'POST',
        data: {
            productId: productId,
            userId: userId,
            agencyId: agencyId,
            startDate: startDate,
            endDate: endDate,
            paymentMethod: paymentMethod,
            bookingDatetime: bookingDatetime
        },
        success: function(response) {
            // Check if response is "success"
            if (response.trim() === 'success') {
                // Update interface to reflect deletion
                $(button).closest('.booking-container').fadeOut('slow', function() {
                    $(this).remove(); // Use $(this) to refer to the booking-container
                });
            } else {
                console.error('Failed to handle return action');
            }
        }
    });
}


    </script>



</body>
</html>