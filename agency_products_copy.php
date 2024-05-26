<?php
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
    .all {
    display: flex;
    flex-wrap: wrap;
    /* flex-direction:column; */
    width:80%;
    /* border:solid red 1px; */
    border-radius: 10px;
    margin-top:10px;
    background-color: white;
    gap:15px;
    padding: 20px;
    /* padding-left: 20px; */
    padding-right: 25px;
    
}

.product {
    width: 250px;
    /* height: 400px; */
    margin-left: 12px;
    margin-top:10px;
    /* border: 1px solid #ccc; */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4); 
    border-radius:5px;
    padding: 15px;
    /* display:flex; */
}

.sub-div {
    margin-left:20px;
    height:60px;
   
    gap:5px;
   
}

.image{
    width:250px;
    height:150px;
}
img {
    width: 100%;
    height:150px;
    margin-bottom: 10px;
}
p{
    height:10px;
    margin-top:5px;
}
.btn{
    margin-top: 30px;
    display:flex;
    justify-content:flex-end;

}
button{
    width:80px;
    height:30px;
    font-size:17px;
    color: white;
    background:green;
    border: none;
    border-radius: 5px
}
button:hover{
    cursor: pointer;
    background-color: rgb(1, 111, 1);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4); 
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
        
        
         .main{
            /* border: solid black 1px; */
            height:auto;
            width: 85%;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
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
     
    <div class="head" style="margin-top: 5px;">
        <h1>Your Products</h1>
    </div>
    <div class="main" id="mainSection">
    </div>
</body>
</html>

<?php
// Start the session

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

// Query to fetch products data including booked counts based on agency_id
$query = "SELECT product_id, model_brand, model_year, rental_cost, count, description, image, category, booked_count
          FROM products
          WHERE agency_id = '$agencyId'";
$result = mysqli_query($conn, $query);

echo "<div class='all'>"; 
  // Check if any products were found
  if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        
        echo "<div class='product'>";
        // Display image if available
        echo "<div class='image'>";
        if (!empty($row['image'])) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" />';
        }
        echo "</div>";
        echo "<div class='details'>";
        //echo "<p>Product ID: " . $row['product_id'] . "</p>";
        echo "<div class='sub-div'>";
        echo "<p>Category: " . $row['category'] . "</p>";
        echo "<p>Model Brand: " . $row['model_brand'] . "</p>";
        echo "</div>";
        echo "<div class='sub-div'>";
        echo "<p>Model Year: " . $row['model_year'] . "</p>"; 
        echo "<p>Rental Cost: " . $row['rental_cost'] . "</p>";
        echo "</div>";
        echo "<div class='sub-div'>";
        echo "<p>Count: " . $row['count'] . "</p>";
        echo "<p>Booked Count: " . $row['booked_count'] . "</p>";
        echo "</div>";
        echo "<div class='sub-div'>";
        echo "<p>Description: " . $row['description'] . "</p>";
        echo "</div>";
        echo "</div>";

        echo "<div class='btn'>";
         echo "<button> Edit </button>";
        echo "</div>";
        echo "</div>";
    }
  } else {
    echo "No products found.";
  }
echo "</div>";

// Close the database connection
mysqli_close($conn);
?>