<?php
// Start the session (not necessary if already started in login page)
session_start();

// Include the database connection file
include 'dbconnect.php';
// Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     // User is not logged in, alert the message and exit
//     echo "<script>alert('User is not logged in. Please log in first.');</script>";
//     exit;
// }
if (isset($_SESSION['user_id'])) {
// Retrieve user_id from the session
$userId = $_SESSION['user_id'];
}
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $modelBrand = $_POST['modelBrand'];
    $modelYear = $_POST['modelyear'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $location = $_POST['location'];
    $rentalCost = $_POST['rentalCost'];
    $description = $_POST['description'];
    $category = $_POST['category']; // Retrieve the selected category


   // Check for duplicate entries
   $checkQuery = "SELECT * FROM products WHERE model_brand = '$modelBrand' AND model_year = '$modelYear' AND user_id = '$userId'";
  $result = mysqli_query($conn, $checkQuery);

  if (mysqli_num_rows($result) > 0) {
    // Duplicate entry found
    echo "<script>alert('This product has already been uploaded.');</script>";
    exit;
  }
    // Retrieve the uploaded image file
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Read the image file into binary data
        $imageData = file_get_contents($_FILES['image']['tmp_name']);

         // Construct the query to insert data into the products table, including the category
        $query = "INSERT INTO products (user_id, model_brand, model_year, start_date, end_date, location, rental_cost, description, image, category)
        VALUES ('$userId', '$modelBrand', '$modelYear', '$startDate', '$endDate', '$location', '$rentalCost', '$description', '" . addslashes($imageData) . "', '$category')";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            echo "<script>
            alert('Product added successfully!');
            setTimeout(function() {
                window.location.href = 'Home.php';
            }, 2000);
        </script>";
        } else {
            echo "<script>
        alert('Failed to add product: " . mysqli_error($conn) . "');
        setTimeout(function() {
            window.location.href = 'Home.php';
        }, 2000);
    </script>";
        }
    } else {
        echo "Failed to upload image: " . $_FILES['image']['error'];
    }
}

// Close the database connection
//   mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
       body{
        justify-content: center;
        align-items: center;
        display: flex;
        flex-direction: column;
        /* margin-top:5%; */
        background-image: url(other-images/farm.jpg);
        background-size: cover;
    position: relative; /* Required for absolute positioning */
       
       }
       .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(5px); /* Apply blur to the overlay */
}

      h2{
        margin-top: 50px;
        border: solid black 1px;
        width: 12%;
        height: 35px;
        justify-content: center;
        align-items: center;
        display: flex;
        border-radius: 5px;
        background-color: rgb(240, 245, 245);
        position: relative; /* Ensure z-index works */
    z-index: 1; /* Ensure the container appears above the overlay */
      }
        .container{
            position: relative; /* Ensure z-index works */
    z-index: 1; /* Ensure the container appears above the overlay */
            border: solid black 1px;
            width: 700px;
            padding: 20px 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
           display: flex;
           flex-direction: column;
           background-color: rgb(240, 245, 245);
           
           /* margin-top: 120px; */
        }
        label{
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .div1, .div2, .div3,.div5{
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .div4{
            margin-left: 50px;
            margin-bottom: 15px;
        }
        
        .subdiv1, .subdiv2{
            /* display: flex; */
            align-items: center;
        }
        input[type="text"],input[type="date"],input[type="number"]{
            height: 30px;
            width: 250px;
            border-radius: 5px;
            border: 1px rgb(113, 110, 110) solid;
            font-size: 15px;
        }
        textarea{
            width: 500px;
            border-radius: 5px;
            font-size: 15px;
            padding: 5px 5px;
        }
        input[type="file"]{
           font-size: 15px;
        }

        select{
            height:30px;
            width: 170px;
            border-radius:5px;
        }
        input[type="submit"]{
            width: 25%;
            height: 35px;
           
           margin:auto;
           
            font-size: 18px;
           border-radius: 5px;
            background-color:rgba(21, 172, 122, 0.527);
            cursor: pointer;
            justify-content: center;
        align-items: center;
        display: flex;
        }   
        
        input[type="submit"]:hover{
            box-shadow: 0 10px 15px rgba(0, 0, 0, .3);
        }
        .check{
            margin-bottom:20px;
        }
        
        
       
    </style>
</head>
<body>
    <div class="overlay"></div>
        <h2>Add Product</h2>
    <div class="container">
        <!-- <h2>Add Product</h2> -->
      <form  method="POST" enctype="multipart/form-data" onsubmit="return checkLogin()">
        <div class="div1">
            <div class="subdiv1">
        <label for="modelBrand">Model Brand:</label>
        <input type="text" id="modelBrand" name="modelBrand" required>
          </div>
          <div class="subdiv2">
        <label>Model Year:</label>
        <input type="text" id="modelyear" name="modelyear" required>
        </div>
      </div>

      <div class="div5">
        <div class="subdiv1">
           <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <div class="subdiv2">
        <label for="category-select">Select a category:</label>
        <select id="category" name="category" required>
            <option value="">--Choose a category--</option>
            <option value="Tractors">Tractors</option>
            <option value="Sprayer">Sprayer</option>
            <option value="Brush Cutters">Brush Cutters</option>
            <option value="Cultivaters">Cultivaters</option>
            <option value="Harvesters">Harvesters</option>
            <option value="Pipe & Spinklers">Pipe and Spinklers</option>
            <option value="Tillers">Tillers</option>
            <option value="Weeders">weeders</option>
            <option value="Planting-euipment">Planting-euipment</option>
        </select>
        </div>
      </div>

      <div class="div2">
        <div class="subdiv1">
      <label for="startDate">Starting Rental Date:</label>
      <input type="date" id="startDate" name="startDate" required>
      <!-- <input type="date" name="startDate"
        placeholder="dd-mm-yyyy" value=""
        min="1997-01-01" max="2030-12-31">  -->
    </div>
    <div class="subdiv2">
      <label for="endDate">Ending Date:</label>
      <input type="date" id="endDate" name="endDate" required>
    </div>
    </div>


    <div class="div3">
        <div class="subdiv1">
         <label for="location">Location:</label>
         <input type="text" id="location" name="location" required>
    </div>
    <div class="subdiv2">
        <label for="rentalCost">Rental Cost:</label>
        <input type="number" id="rentalCost" name="rentalCost" required>
    </div>
    </div>

    <div class="div4">
    <label for="description">Description:</label>
        <textarea id="description" name="description" rows="3" placeholder="Engine type, any problem in machine,etc" required></textarea>
    </div>
    
    
       

    <label class="check">
        <input type="checkbox" id="terms" name="terms" required>
        I accept the terms and conditions
    </label>
    

    <input type="submit" value="Add Product">

</form>

</div>    

       
        
<script>
        // Function to check if user is logged in before submitting the form
        function checkLogin() {
            // Check if user is logged in
            var isLoggedIn = <?php echo isset($_SESSION['logged_in']) ? 'true' : 'false'; ?>;

            // If the user is not logged in, display an alert message and prevent form submission
            if (!isLoggedIn) {
                alert('User is not logged in. Please log in first.');
                return false; // Prevent form submission
            }

            // Allow form submission
            return true;
        }
    </script> 

        

        

        

       
</body>
</html>
