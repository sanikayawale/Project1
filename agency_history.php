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
    <style>
        .contain{
        width: 80%;
        /* margin:10px; */
        background-color:white;
        padding: 20px;
        border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);

    }
        .product{
            align-items: center;
            display:flex;
            gap:40px;
            /* margin-top:10px; */
            padding: 10px;
            /* border:solid red 1px; */
            /* border-radius: 10px; */
            margin-bottom: 20px;
            width:1200px;
    border-bottom: 1px solid #ccc;

            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);  */
        }
        img{
            width:250px;
            height:180px;
        }
    </style>

<body>
<!-- Your existing HTML code -->
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
        <h1>Returned Products</h1>
    </div>
   
    <div class="main" id="mainSection">
   </div>
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

// Retrieve agency_id from the session
$agencyId = $_SESSION['agency_id'];

// Query to fetch booking history data
$query = "SELECT h.user_id, h.product_id, h.start_date, h.end_date, h.payment_method, h.booking_datetime, h.return_datetime,
                 u.first_name, u.last_name, u.mobile, u.address,
                 p.model_brand, p.category, p.rental_cost, p.image
          FROM history h
          JOIN users u ON h.user_id = u.Id
          JOIN products p ON h.product_id = p.product_id
          WHERE h.agency_id = '$agencyId'";
$result = mysqli_query($conn, $query);

echo "<div class='all'>";
// Check if any booking history data were found
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        // Output the data or use it as needed
        // echo "<p>User ID: " . $row['user_id'] . "</p>";
        // echo "<p>Product ID: " . $row['product_id'] . "</p>";
         // Display the image
         echo "<div class='product'>";
         echo "<div>";
         echo "<img src='data:image/jpeg;base64," . base64_encode($row['image']) . "' />";
         echo "</div>";
         echo "<div>";
        echo "<p><b>Start Date:</b> " . $row['start_date'] . "</p>";
        echo "<p><b>End Date:</b> " . $row['end_date'] . "</p>";
        echo "<p><b>Payment Method:</b> " . $row['payment_method'] . "</p>";
        echo "<p><b>Booking Datetime:</b> " . $row['booking_datetime'] . "</p>";
        echo "<p><b>Return Datetime:</b> " . $row['return_datetime'] . "</p>";
        echo "</div>";
        echo "<div>";
        echo "<p><b>User:</b> " . $row['first_name'] . " " . $row['last_name'] . "</p>";
        echo "<p><b>Mobile:</b> " . $row['mobile'] . "</p>";
        echo "<p><b>Address:</b> " . $row['address'] . "</p>";
        echo "</div>";
        echo "<div>";
        echo "<p><b>Product:</b> " . $row['model_brand'] . "</p>";
        echo "<p><b>Category:</b> " . $row['category'] . "</p>";
        echo "<p><b>Rental Cost:</b> " . $row['rental_cost'] . "</p>";
        echo "</div>";
        echo "</div>";
       
    }
} else {
    echo "<p>No booking history found.</p>";
}
echo "</div>";

// Close the database connection
mysqli_close($conn);
?>
</div>
