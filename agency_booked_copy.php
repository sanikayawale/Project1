<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .contain{
        width: 80%;
        /* margin:10px; */
        background-color:white;
        padding: 20px;
        border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }
    .booking-container {
    border-bottom: 1px solid #ccc;
    /* border-radius: 10px; */
    margin-bottom: 20px;
    padding: 10px;
    width:1200px;
    transition: opacity 0.5s ease-in-out;
}

.deleted {
        opacity: 0; /* Make the deleted item invisible */
        height: 0; /* Optionally, you can also collapse the height */
        margin: 0; /* Reset margin */
        padding: 0; /* Reset padding */
        overflow: hidden; /* Hide any overflow content */
    }
.booking-info img {
    /* float: left; */
    margin-right: 10px;
    width:200px;
    height:180px;
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
    height:35px;
    position: absolute;
    bottom: 10px;
    right: 10px;
    font-size:17px;
    color: white;
    background:green ;
    cursor: pointer;
    border: none;
    border-radius:5px;
}
button:hover{
    background-color: rgb(1, 90, 1);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}
</style>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body{
        font-family: 'Poppins';
    }
        body {
            /* font-family: Arial, sans-serif; */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            /* height: 100vh; */
        /* background-color: white; */
        background:linear-gradient(270deg, whitesmoke, lightgreen);

        }

        .box {
            width: 100%;
            padding: 2px;
            /* width: 90%; */
            /* padding: 20px; */
            /* height: auto; */
           
            /* border: 1px solid #d71313; */
            border-radius: 5px;
            /* background-color:  rgb(241, 235, 235); */
            background-color: white;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .left{
            height: 50px;
            margin-left: 20px;
        }

        .portal-title {
            font-size: 24px;
            font-weight: bold;
            /* margin-bottom: 20px; */
        }

        .horizontal-bar {
            margin-top: 5px;
            /* margin-bottom: 20px; */
            /* padding: 10px 0; */
            display: flex;
            height: 40px;
           padding: 3px;
            justify-content: center;
            align-items: center;
            background-color: white;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */

;
            /* border-top: 1px solid #ccc; */
        }

        
        .horizontal-bar a {
         display: block; /* Make each link take up the full width and height of its container */
         padding: 0 20px; /* Add padding for better visibility */
         text-decoration: none;
         color: green;
         font-size: 20px;
         /* font-weight: bold; */
         
            text-align: center;       
         /* Ensures the link spans the full height of the container  */
}

          /* Hover effect for links in the horizontal bar */
         /* .horizontal-bar a:hover {
          background-color: #0056b3; 
         color: #fff; 
          border-radius: 5px;
         } */
          /* Hover effect for links in the horizontal bar */
          .horizontal-bar a:hover {
          background-color: green; 
         color: #fff; 
          border-radius: 3px;
          /* text-transform: capitalize; */
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100%; /* Make the link take up the full height of its container */
         }

         .horizontal-bar a:hover:before {
          /* content: ""; */
          display: block;
          width: 100%;
          height: 100%;
         }
     
         #addproduct {
            display: none;
        }
        </style>


<body>
<div class="box" style="display: flex; gap: 100px;">
        <div class="left" style="display: flex; gap: 10px;">
            <img style="width: 80px; height: 60px;" src="home-images/Yantadoot.png" alt="logo">
        <div style="margin-top: 5px;" class="portal-title">Agency Portal</div>
    </div>       
       
        <!-- Add more content here, such as welcome message, forms, or other information -->

        <!-- Horizontal bar with links -->
        <div class="horizontal-bar">
            <a href="agency_portal.php" id="addProductLink">Add Product</a>
            <a href="agency_products_copy.php" id="yourProductsLink">Your Products</a>
            <a href="agency_booked_copy.php" id="bookedProductsLink">Booked Products</a>
            <a href="agency_history.php">History</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="head">
        <h1 style="margin-top: 20px;">Booked Products</h1>
    </div>

    <div class="main" id="mainSection">
    </div>

    <script>
    // Add an event listener to the form submission
    document.getElementById('returnForm').addEventListener('submit', function (event) {
        // Prevent the default form submission
        event.preventDefault();
        
        // Use Fetch API or AJAX to submit the form data asynchronously
        // For simplicity, let's assume the form submission is successful
        
        // Simulate a successful form submission
        setTimeout(function () {
            // Get the booking container
            var bookingContainer = document.querySelector('.booking-container');
            
            // Add a class to trigger the transition effect
            bookingContainer.classList.add('deleted');
        // Display alert
        alert('Product returned successfully!');

// Redirect to agency_booked_copy.php
window.location.href = 'agency_booked_copy.php';
}, 500); // Adjust the delay based on your transition duration
    });
</script>
</body>
</html>
<div class="contain">
<?php

// Include the database connection file
include 'dbconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['agency_id'])) {
    // User is not logged in, redirect them to the login page
    header('Location: Agency_login.php');
    exit;
}

// Check if the return button is clicked
if (isset($_POST['return'])) {
    // Get the booking information from the button's data attributes
    $product_id = $_POST['product_id'];
    $user_id = $_POST['user_id'];
    $agency_id = $_POST['agency_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $payment_method = $_POST['payment_method'];
    $booking_datetime = $_POST['booking_datetime'];
    $return_datetime = date('Y-m-d H:i:s'); // Current date and time

    // Insert data into the history table
    $insert_query = "INSERT INTO history (product_id, user_id, agency_id, start_date, end_date, payment_method, booking_datetime, return_datetime)
                     VALUES ('$product_id', '$user_id', '$agency_id', '$start_date', '$end_date', '$payment_method', '$booking_datetime', '$return_datetime')";
    mysqli_query($conn, $insert_query);

    // Update product counts
    $update_query = "UPDATE products 
                     SET count = count + 1, booked_count = booked_count - 1 
                     WHERE product_id = '$product_id' AND agency_id = '$agency_id'";
    mysqli_query($conn, $update_query);

    // Delete the booking entry
    $delete_query = "DELETE FROM booking 
                     WHERE product_id = '$product_id' AND user_id = '$user_id' AND agency_id = '$agency_id'";
    mysqli_query($conn, $delete_query);

    // Close the database connection
    mysqli_close($conn);
    exit; // Stop further execution
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
        echo "<form method='post'>";
        echo "<input type='hidden' name='product_id' value='{$row['product_id']}'>";
        echo "<input type='hidden' name='user_id' value='{$row['user_id']}'>";
        echo "<input type='hidden' name='agency_id' value='$agencyId'>";
        echo "<input type='hidden' name='start_date' value='{$row['start_date']}'>";
        echo "<input type='hidden' name='end_date' value='{$row['end_date']}'>";
        echo "<input type='hidden' name='payment_method' value='{$row['payment_method']}'>";
        echo "<input type='hidden' name='booking_datetime' value='{$row['booking_datetime']}'>";
        echo "<button type='submit' class='return-btn' name='return'>Return</button>";
        echo "</form>";
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
</div>