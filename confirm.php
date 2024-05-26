<?php
// Include the database connection
include 'dbconnect.php';
session_start(); // Start the session

// Retrieve the product_id from the POST request
$productId = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;


// Initialize arrays for holding product, agency, and user data
$productData = [];
$agencyData = [];
$userData = [];

// Fetch product details using product_id
if ($productId > 0) {
    // Prepare the query to fetch product details
    $query = 'SELECT p.product_id, p.rental_cost, p.description, p.category, p.image, p.agency_id,
    p.model_brand, p.model_year, p.count,
    a.name AS agency_name, a.mobile, a.location, a.address, a.email
FROM products p
INNER JOIN agency a ON p.agency_id = a.agency_id
WHERE p.product_id = ?';
    
    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter
        $stmt->bind_param('i', $productId);
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch the result
        $result = $stmt->get_result();
        
        // Fetch data as an associative array
        if ($row = $result->fetch_assoc()) {
            $productData = $row;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo '<p>Error preparing statement: ' . $conn->error . '</p>';
    }
}

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
$imageData = base64_encode($productData['image']);

?>


<!DOCTYPE html>
<html>
<head>
<link href="home.css" rel="stylesheet">
    <title>Booking Confirmation</title>
    <!-- Add any CSS styling here -->
    <style>
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
        .product_details{
            display:flex;
            flex-direction:column;
            width:50%;
            border: solid black 1px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds box shadow */
            height:auto;
        }
        .product_details h3{
            margin-left:50px;
        }
        .product_details img{
            width:250px;
            height:auto;
            border-radius:5px;
            margin-bottom:10px;
        }
        .main{
            display:flex;
            justify-content:space-around;
        }
        .details{
            display:flex;
            flex-direction:column;
        }
        .sub-div{
            display:flex;
            gap:15px;
        }
        p{
            font-weight:bold;
        }

        .agency_details{
            display:flex;
            width:60%;
            border: solid black 1px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds box shadow */
            justify-content:space-around;
            margin-top:15px;
        }
        .details2, .details3{
            border:solid red 1px;
            display:flex;
            flex-direction:column;
           /* margin-left:120px; */
        }
        .details3{
            margin-left:80px;
        }

        .user_details{
            display:flex;
            flex-direction:column;
            width:50%;
            
            border: solid black 1px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds box shadow */
            justify-content:space-around;
            margin-top:15px;
        }
        .details3 input{
            width:300px;
            height:25px;
            border: solid black 1px;
        }
        .details3 label{
            font-weight:bold;
        }
        .sub-div{
            margin-top:15px;
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
            width:100px;
            height:30px;
            background:green;
            border-radius:5px;
        }

        /* Form styles */
        .form-container {
           
            margin-top: 20px;
            width:50%;
            background:white;
            margin: auto;
            margin-top:50px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds box shadow */
        }

        .form-container input,
        .form-container select,
        .form-container button {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            background-color: #28a745;
            width:20%;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #218838;
        }
        .right{
            display:flex;
            justify-content:right;
        }
        .dates{
            gap:15px;
            display:flex;
        }
        
    </style>
</head>
<body>
<nav class="navbar background">
        <div class="logo">
            <img src="home-images/Yantadoot.png" style="height: 80px;" alt="Logo">
        </div>
        <ul class="nav-list">
            <li><a href="#home">Home</a></li>
            <li><a href="#About_Us">About Us</a></li>
            <li style="width:120px;"><a href="add-product.php">Rent Your Product</a></li>
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
            <div class="profile" style="display:flex; gap:20px; border:solid black 1px;justify-content:flex-end; margin-right:20px">
                <div><a href="Agency_login.php" style="color:green;font-size:17px">Agency Login</a></div>
               <div>
                 <?php
                  
            
                    // Check if the user is logged in
                     if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
                     $username = $_SESSION['username'];
                      $first_letter = strtoupper(substr($username, 0, 1)); // Get the first letter and convert it to uppercase
                
                       // Display the user's initial in a circle
                      echo '<div class="user-initial">' . $first_letter . '</div>';
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
    <h2>Booking Confirmation</h2>

    <!-- Display product details -->
    <div class="product_details">
        <div>
          <h3>Product Details</h3>
         </div>

        <div class="main">
        <!-- <p>Image:</p> -->
        <img src="data:image/jpeg;base64,<?php echo $imageData; ?>" alt="<?php echo $productData['description']; ?>">
      
      <div class="details">
         <!-- <p>Product ID: <?php echo $productData['product_id']; ?></p> -->
         <div class="sub-div">
            <p>Model Brand: <?php echo $productData['model_brand']; ?></p>
            <p>Model Year: <?php echo $productData['model_year']; ?></p>
         </div>
          <!-- <p>Count: <?php echo $productData['count']; ?></p> -->
          <div class="sub-div">
          <p>Rental Cost: $<?php echo $productData['rental_cost']; ?></p>
          <p>Category: <?php echo $productData['category']; ?></p>
          </div>
          <p>Description:</p>
          <?php echo $productData['description']; ?>
       </div>
       </div>
        
       <h3>Agency Details:</h3>
      <div class="details2">
        <div class="sub-div">
          <p>Agency Name: <?php echo $productData['agency_name']; ?></p>
          <p>Mobile: <?php echo $productData['mobile']; ?></p>
       </div>
       <div class="sub-div">
         <p>Location: <?php echo $productData['location']; ?></p>
         <p>Address: <?php echo $productData['address']; ?></p>
       </div>
      </div>
    </div>

  
     
    

    <!-- Display user details -->
    <div class="user_details">
        <div>
        <h3>User Details</h3>
        </div>
        <div class="details3">
            <div class="sub-div">
               <p>First Name: <?php echo $userData['first_name']; ?></p>
               <p>Last Name: <?php echo $userData['last_name']; ?></p>
            </div>
            <div class="sub-div-user">
               
             <form method="POST" action="update_user_contact.php">
                <div>
                <label for="mobile">Mobile:</label>
                <input type="text" name="mobile" id="mobile" value="<?php echo htmlspecialchars($userData['mobile']); ?>">
                </div>
            
                <div>
                <!-- Input field for address -->
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($userData['address']); ?>">
                </div>

               
                <!-- Submit button to update user mobile and address -->
                <!-- <button type="submit" value="Update"> -->
            <button type="submit" >Update</button>
                </form>
            </div>
            
        </div>
    </div>

   
    <div id="form-container" class="form-container" >
       <h3>Enter the duration:</h3>
    <form action="confirm_book.php" method="POST">
        <div class="dates">
           <!-- Start Date input -->
           <div>
           <label for="start-date">Start Date:</label>
          <input type="date" id="start-date" name="start-date" required>
          </div>
           <!-- End Date input -->
           <div>
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
         <!-- Hidden input to pass product_id -->
         <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
        <div class="right">
          <button type="submit" id="proceed-button" >Proceed to Book</button>
        </div>
    </form>
  </div>
  </div>

</body>
</html>

