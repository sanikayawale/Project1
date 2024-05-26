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
// Check if the user is logged in (i.e., if agency_id session variable is set)
if (isset($_SESSION['agency_id'])) {
    // Retrieve agency_id from the session
    $agencyId = $_SESSION['agency_id'];
} else {
    // User is not logged in, redirect them to the home page or login page
    header('Location: Agency_login.php'); // Change the redirect URL if needed
    exit;
}
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $modelBrand = $_POST['modelBrand'];
    $modelYear = $_POST['modelyear'];
   
    $rentalCost = $_POST['rentalCost'];
    $description = $_POST['description'];
    $category = $_POST['category']; // Retrieve the selected category
    $count = $_POST['count'];


   // Check for duplicate entries
   $checkQuery = "SELECT * FROM products WHERE model_brand = '$modelBrand' AND model_year = '$modelYear' AND agency_id = '$agencyId'";
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
        $query = "INSERT INTO products (agency_id, model_brand, model_year, count, rental_cost, description, image, category)
        VALUES ('$agencyId', '$modelBrand', '$modelYear','$count', '$rentalCost', '$description', '" . addslashes($imageData) . "', '$category')";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            echo "<script>
            alert('Product added successfully!');
            setTimeout(function() {
                window.location.href = 'agency_portal.php';
            }, 2000);
        </script>";
        } else {
            echo "<script>
        alert('Failed to add product: " . mysqli_error($conn) . "');
        setTimeout(function() {
            window.location.href = 'agency_portal.php';
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
    <title>Document</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            /* height: 100vh; */
            background-color: #f5f5f5;
            border: solid black 1px;
        }

        .box {
            width: 80%;
            /* width: 90%; */
            padding: 20px;
           
            border: 1px solid #d71313;
            border-radius: 5px;
            background-color: #fff;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .portal-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .horizontal-bar {
            margin-top: 20px;
            /* margin-bottom: 20px; */
            /* padding: 10px 0; */
            display: flex;
            height: 40px;
           
            justify-content: center;
            align-items: center;
            background-color: rgb(38, 52, 38);
            /* border-top: 1px solid #ccc; */
        }

        
        .horizontal-bar a {
         display: block; /* Make each link take up the full width and height of its container */
         padding: 0 20px; /* Add padding for better visibility */
         text-decoration: none;
         color: #dfe4e9;
         font-weight: bold;
         
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
          background-color: #0056b3; 
         color: #fff; 
          border-radius: 5px;
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
        
         .main{
            border: solid black 1px;
            height:auto;
            width: 85%;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
         }
         /* #addproduct {
            display: none;
        } */
    </style>
<body>
<div id="addproduct">
          <h2>Add Product</h2>
        <div class="container">
        <!-- <h2>Add Product</h2> -->
         <form  method="POST" enctype="multipart/form-data" >
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
        <label for="category">Select a category:</label>
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

      <!-- <div class="div2">
        <div class="subdiv1">
      <label for="startDate">Starting Rental Date:</label>
      <input type="date" id="startDate" name="startDate" required>
     
    </div>
    <div class="subdiv2">
      <label for="endDate">Ending Date:</label>
      <input type="date" id="endDate" name="endDate" required>
    </div>
    </div> -->

       <div class="div3">
        <div class="subdiv1">
         <label for="count">No. of Products</label>
         <input type="number" id="count" name="count" required>
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
       </div>
    
</body>
</html>