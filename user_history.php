<?php
session_start(); // Start session

// Check if the user is logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
    // Include database connection
    include 'dbconnect.php';

    // Fetch user details from the users table
    $fetchUserQuery = 'SELECT first_name, last_name, mobile FROM users WHERE Id = ?';
    if ($stmt = $conn->prepare($fetchUserQuery)) {
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $firstName = $row['first_name'];
            $lastName = $row['last_name'];
            $mobile = $row['mobile'];
        }
        $stmt->close();
    } else {
        echo '<p>Error preparing statement: ' . $conn->error . '</p>';
    }

    // Fetch booking history details from the history table
    $fetchHistoryQuery = 'SELECT product_id, agency_id, start_date, end_date, payment_method, booking_datetime, return_datetime FROM history WHERE user_id = ?';
    if ($stmt = $conn->prepare($fetchHistoryQuery)) {
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are any history records
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productId = $row['product_id'];
                $agencyId = $row['agency_id'];
                $startDate = $row['start_date'];
                $endDate = $row['end_date'];
                $paymentMethod = $row['payment_method'];
                $bookingDatetime = $row['booking_datetime'];
                $returnDatetime = $row['return_datetime'];

                // Fetch product details from the products table
                $fetchProductQuery = 'SELECT model_brand, category, rental_cost, image FROM products WHERE product_id = ?';
                if ($stmtProduct = $conn->prepare($fetchProductQuery)) {
                    $stmtProduct->bind_param('i', $productId);
                    $stmtProduct->execute();
                    $resultProduct = $stmtProduct->get_result();
                    if ($rowProduct = $resultProduct->fetch_assoc()) {
                        $modelBrand = $rowProduct['model_brand'];
                        $category = $rowProduct['category'];
                        $rentalCost = $rowProduct['rental_cost'];
                        $imageData = $rowProduct['image']; // Retrieve image data from database
                        $image = base64_encode($imageData); // Convert image data to base64 format
                        $imageSrc = 'data:image/jpeg;base64,' . $image; // Generate data URI for image
                    }
                    $stmtProduct->close();
                }

                // Display the fetched data
                echo "<div class='product'>";
                // echo "<p><strong>Product ID:</strong> $productId</p>";
                // echo "<p><strong>Agency ID:</strong> $agencyId</p>";
                
                  echo "<div>";
                  echo "<img src='$imageSrc' alt='Product Image'>";
                  echo "</div>";
                  echo "<div class='sub-div'>";
                  echo "<p><strong>Category:</strong> $category</p>";
                  echo "<p><strong>Model Brand:</strong> $modelBrand</p>";
                  echo "<p><strong>Rental Cost:</strong> $rentalCost</p>";
                  echo "</div>";
               

                echo "<div class='sub-div'>";
                echo "<p><strong>Start Date:</strong> $startDate</p>";
                echo "<p><strong>End Date:</strong> $endDate</p>";
                echo "<p><strong>Payment Method:</strong> $paymentMethod</p>";
                echo "<p><strong>Booking Datetime:</strong> $bookingDatetime</p>";
                echo "<p><strong>Return Datetime:</strong> $returnDatetime</p>";
                echo "</div>";
               
                echo "</div>";
            }
        } else {
            echo "<p>No booking history found.</p>";
        }
        $stmt->close();
    } else {
        echo '<p>Error preparing statement: ' . $conn->error . '</p>';
    }

    // Close the database connection
    $conn->close();
} else {
    echo "<p>User is not logged in.</p>";
}
?>

<style>
    .product{
        width:800px;
        /* border:solid red 1px; */
        display:flex;
       margin-top:20px;
       margin-left:30px;
        gap:20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
    }
    img{
        width:250px;
        height:200px;
        margin-top:10px;
        margin-bottom:10px;
    }
    p{
        padding:5px;
    }
    .sub-div{
        margin-top:20px;
    }
   
</style>