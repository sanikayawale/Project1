<?php
// Include the database connection
include 'dbconnect.php';
session_start(); // Start the session

// Retrieve the product_id from the POST request
$productId = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;


// Initialize arrays for holding product, agency, and user data
// $productData = [];
// $agencyData = [];
$userData = [];

// Fetch product details using product_id
// if ($productId > 0) {
//     // Prepare the query to fetch product details
//     $query = 'SELECT p.product_id, p.rental_cost, p.description, p.category, p.image, p.agency_id,
//     p.model_brand, p.model_year, p.count,
//     a.name AS agency_name, a.mobile, a.location, a.address, a.email
// FROM products p
// INNER JOIN agency a ON p.agency_id = a.agency_id
// WHERE p.product_id = ?';
    
//     // Prepare the statement
//     if ($stmt = $conn->prepare($query)) {
//         // Bind the parameter
//         $stmt->bind_param('i', $productId);
        
//         // Execute the statement
//         $stmt->execute();
        
//         // Fetch the result
//         $result = $stmt->get_result();
        
//         // Fetch data as an associative array
//         if ($row = $result->fetch_assoc()) {
//             $productData = $row;
//         }
        
//         // Close the statement
//         $stmt->close();
//     } else {
//         echo '<p>Error preparing statement: ' . $conn->error . '</p>';
//     }
// }

// Fetch user details using Id from the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Prepare the query to fetch user details
    $query = 'SELECT first_name, last_name, mobile, location, address FROM users WHERE Id = ?';

    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter
        $stmt->bind_param('i', $userId);

        // Execute the statement
        $stmt->execute();

        // Fetch the result
        $result = $stmt->get_result();

        // Fetch data as an associative array
        if ($row = $result->fetch_assoc()) {
            $userData = $row;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo '<p>Error preparing statement: ' . $conn->error . '</p>';
    }
}



// Close the database connection
$conn->close();

// Convert the BLOB data to a base64 encoded string
// $imageData = base64_encode($productData['image']);

?>


<!DOCTYPE html>
<html>
<head>
<link href="home.css" rel="stylesheet">
    <title>Booking Confirmation</title>
    <!-- Add any CSS styling here -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body{
        font-family: 'Poppins';
    }
        body{
            background-color:rgb(241, 235, 235);
        }
         .user-initial {
            width: 40px;
            height: 40px;
            background-color: green;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            position: absolute;
            top: 20px; /* Adjust top position */
            right: 20px; /* Adjust right position */
        }
        .profile{
            margin-left: 15px;
        }
        .all{
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items: center;
        }
        .heading{
            margin-top:20px;
        }
        .details2, .details3{
            /* border:solid red 1px; */
            display:flex;
            flex-direction:column;
           /* margin-left:120px; */
        }
        .details3{
            margin-left:80px;
        }

        .user_details{
            background-color:white;
            display:flex;
            flex-direction:column;
            width:50%;
            padding: 30px;
            /* border: solid black 1px; */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds box shadow */
            justify-content:space-around;
            margin-top:15px;
        }
        .details3 input{
            width:fit-content;
            height:30px;
            /* border: solid black 1px; */
            border-bottom: solid green 2px;
            padding:5px;
            padding-left: 5px;
        }
        .details3 label{
            font-weight:bold;
        }
        .sub-div{
            margin:40px 0 5px 0;
            display: flex;
            align-items: center;
            gap: 50px;
            width: fit-content;
        }
        .sub-div-user{
            display:flex;
            flex-direction:column;
        }
        .details3 form{
          display:flex;
          flex-direction:column;
          gap:20px;
          margin-top:15px;         
        }
        .details3 button{
            width:150px;
            height:40px;
            background:green;
            border-radius:5px;
            font-size:17px;
            color:white;
            align-self: center;
        }

        button:hover{
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Adds box shadow */
            cursor: pointer;
        }
        .right{
            margin-left: 200px;
            margin-top:40px;
            margin-bottom:20px;

        }
        .dates{            
            gap:15px;
            display:flex;
            align-items: center;
        }
        .duration{
            width: fit-content;
            display: flex;
            gap: 30px;
        }
        select{
            border-bottom: solid green 2px;
            width:150px;
            height:30px;
        }
        .payment{
            margin-top:10px;
            width: fit-content;
        }
        
    </style>
</head>
<body>
<nav class="navbar background">
        <div class="logo">
            <img src="home-images/Yantadoot.png" style="height: 80px;" alt="Logo">
        </div>
        <ul class="nav-list">
            <li><a href="Home.php">Home</a></li>
            <li><a href="#About_Us">About Us</a></li>
            <!-- <li style="width:120px;"><a href="add-product.php">Rent Your Product</a></li> -->
            <li><a href="chat.php">Dashboard</a></li>
            <li><a href="#Help">Help!</a></li>
        </ul>
        <div class="rightnav" >
            <!-- <div class="right-sub">
            <input type="text" name="search" id="search">
            <button class="btn btn-sm">Search</button>
            </div> -->
            <!-- <A href="login.php"><img src="home-images/person33.png"
                    style="height: 40px; padding-left: 20px; padding-top: 10px;"></A> -->
                    <!-- Here is where we dynamically show the user icon -->
            <div class="profile" style="display:flex; gap:40px;justify-content:flex-end; margin-right:20px">
                <div><a href="Agency_login.php" style="color:green;font-size:19px">Agency Login</a></div>
               <div>
                 <?php
                  
            
                    // Check if the user is logged in
                     if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
                     $username = $_SESSION['username'];
                      $first_letter = strtoupper(substr($username, 0, 1)); // Get the first letter and convert it to uppercase
                
                      // Display the user's initial in a circle
                      echo '<a href="profile.php" class="user-initial">' . $first_letter . '</a>';
                      } else {
                      // Display the login link if the user is not logged in
                         // echo '<a href="login.php"><img src="home-images/person33.png" style="height: 50px;margin-right:15px; padding-left: 20px; padding-top: 10px;"></a>';
                       echo '<a style="color:green;font-size:17px" href="login.php">User Login</a>';
                     }
                  ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="all">
    <h2 class="heading">Booking Confirmation</h2>

    <!-- Display product details -->

    <!-- Display user details -->
    <div class="user_details">
        <div>
        <h3 style="text-align:center; font-size:23px">User Details</h3>
        </div>
        <div class="details3">
            <div class="sub-div">
               <p><b>First Name:</b> <?php echo $userData['first_name']; ?></p>
               <p><b>Last Name:</b> <?php echo $userData['last_name']; ?></p>
            </div>
            <div class="sub-div-user">
               
             <form method="POST" action="book.php">
            
            <div style="width: fit-content;">
                <label for="mobile">Contact No:</label>
                <input type="text" name="mobile" id="mobile" value="<?php echo htmlspecialchars($userData['mobile']); ?>">
                </div>
            
                <div style="width: fit-content;">
                <!-- Input field for address -->
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($userData['address']); ?>">
                </div>

             <h4 style="width: fit-content;">Enter the duration</h4>
                <div class="duration">
             <div class="dates">
           <label for="start-date">Start Date:</label>
          <input type="date" id="start-date" name="start-date" required>
          </div>
           <!-- End Date input -->
           <div class="dates">
          <label for="end-date">End Date:</label>
          <input type="date" id="end-date" name="end-date" required>
          </div>
        </div>
        <div class="payment">
        <!-- Payment Method dropdown -->
        <label for="payment-method">Payment Method:</label>
        <select id="payment-method" name="payment-method" onchange="handlePaymentMethodChange()" required>
            <option value="COD">Cash on Delivery</option>
            <!-- <option value="UPI">UPI</option> -->
        </select>
        </div>

        <!-- Make Payment button (initially hidden) -->
        <!-- <button type="button" id="make-payment-button" style="display: none;">
            Make Payment
        </button> -->
         <!-- Hidden input field to pass product_id -->
    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
         
        <div class="right" style="width: fit-content;">
          <button type="submit" id="book" >Confirm Book</button>
        </div>
               
                
                </form>
            </div>
            
        </div>
    </div>

   
    
  </div>

</body>
</html>

