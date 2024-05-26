<?php
// Connect to the database
include 'dbconnect.php';
session_start(); // Start session

// Get product_id from the URL
$productId = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Initialize variables for the product data and user data
$productData = null;

// Fetch product details from the database
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
        // Bind parameters
        $stmt->bind_param('i', $productId);

        // Execute the statement
        $stmt->execute();

        // Fetch the result
        $result = $stmt->get_result();
        $productData = $result->fetch_assoc();

        // Close the statement
        $stmt->close();
    } else {
        echo '<p>Error preparing statement: ' . $conn->error . '</p>';
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<link href="home.css" rel="stylesheet">

    <title>Product Details</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body{
        font-family: 'Poppins';
    }
       /* body {
             height:500px;
            display: flex;
            justify-content: center;
            align-items: center; 
        } */
        /* Custom CSS styles */
        body{
            background-color:rgb(241, 235, 235);
            height:1000px;
        }
        .container, .container2 {
            display: flex;
            flex-direction:column;
            gap: 50px;
            width: 65%;
            background:white;
            margin: auto;
            margin-top:50px;
            padding: 20px;
            /* border: 1px solid #ccc; */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds box shadow */
        }

        
        .product{
            display:flex;
        }
        
        .container{
            padding-left:50px;
            padding-top:50px;
            padding-bottom:25px

        }

        .container img {
            width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-left:10px;
            margin-right:40px;
        }

        .container .details {
            flex: 1;
            padding-left: 20px;
        }

        .details p {
            margin: 5px 0;
        }
        
        

        .details h3 {
            margin-top: 15px;
        }

        .button-container {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .button-container button {
            padding: 10px 20px;
            background-color: green;
            font-size:17px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
           
        }

        .button-container button:hover {
            background-color: #009E60;
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

        /* Form styles */
        .form-container {
            display: none; /* Hide form by default */
            margin-top: 20px;
            max-width: 800px;
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
        form{
            display:flex;
            flex-direction:column;
        }
        .right{
            display:flex;
            justify-content:right;
        }
        .dates{
            gap:15px;
            display:flex;
        }
        .agency-details{
            display:flex;
            flex-direction:column;
          gap:20px;
          margin-top:15px;
        }
        .subdiv{
            display:flex;
            gap:50px;
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
            <div class="profile" style="display:flex; gap:40px; justify-content:flex-end; align-items: center; margin-right:20px; margin-bottom:5px">
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
                       echo '<a style="color:green;font-size:19px" href="login.php">User Login</a>';
                     }
                  ?>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php
        // Check if product data exists
        if ($productData) {
            // Convert image data to base64
            $imageData = base64_encode($productData['image']);

            // Display product details
            echo '<div class="product">';
            echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="' . $productData['description'] . '">';
            echo '<div class="details" >';
           
            echo '<p><b>Category:</b> ' . $productData['category'] . '</p>';
            echo '<p><b>Model Brand:</b> ' . $productData['model_brand'] . '</p>';
            echo '<p><b>Model Year:</b> ' . $productData['model_year'] . '</p>';
            echo '<p><b>Rental Cost (per hour):</b> Rs. ' . $productData['rental_cost'] . '</p>';
          //  echo '<p>User ID: ' . $productData['user_id'] . '</p>';
            echo '<p><b>Agency Name:</b> ' . $productData['agency_name'] . ' </p>';
            echo '<h3>Product Description:</h3>';
            echo '<p>' . $productData['description'] . '</p>';
            echo '</div>';
            echo '</div>';

             // Display agency details
             echo '<div class="agency-details">';
             echo '<h3 style="margin-left:20px">Agency Details:</h3>';
             echo '<div class="details">';
             echo '<div class="subdiv">';
             echo '<p><b>Agency Name:</b> ' . $productData['agency_name'] . '</p>';
             echo '<p><b>Mobile:</b> ' . $productData['mobile'] . '</p>';
             echo '</div>';
             echo '<div class="subdiv">';
             echo '<p><b>Location:</b> ' . $productData['location'] . '</p>';
             echo '<p><b>Email:</b> ' . $productData['email'] . '</p>';
             echo '</div>';
             echo '<p><b>Address:</b> ' . $productData['address'] . '</p>';
             echo '</div>';
            echo '</div>';
            // Add button container below details
            echo '<div class="button-container">';
            echo '<button id="next-button" type="button" onclick="navigateToConfirmBook()">Next</button>';  // Customize button text as needed
            echo '</div>';
        } else {
            echo '<p>Product not found.</p>';
        }
        ?>
    </div>
    
        
         

    <!-- Form container -->
<div id="form-container" class="form-container" style="display: none;">
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

<script>
    // JavaScript to handle the button click event and display the form
    function displayForm() {
        var formContainer = document.getElementById('form-container');
        formContainer.style.display = 'block';
    }

    // JavaScript to handle the payment method selection
    // function handlePaymentMethodChange() {
    //     var paymentMethod = document.getElementById('payment-method').value;
    //     var makePaymentButton = document.getElementById('make-payment-button');
    //     if (paymentMethod === 'UPI') {
    //         makePaymentButton.style.display = 'block';
    //     } else {
    //         makePaymentButton.style.display = 'none';
    //     }
    // }

    function navigateToConfirmBook() {
    // Construct the URL with parameters to navigate to confirm_book.php
    var productId = <?php echo $productId; ?>;
    var url = 'confirm_book.php?product_id=' + productId;

    // Redirect the user to the confirm_book.php page with the parameters
    window.location.href = url;
}

</script>


</body>
</html>
