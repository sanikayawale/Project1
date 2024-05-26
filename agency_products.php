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

<style>
    .all {
    display: flex;
    flex-wrap: wrap;
    /* flex-direction:column; */
    width:1200px;
    border:solid red 1px;
    margin-top:20px;
    gap:15px;
    
}

.product {
    width: 250px;
    margin-left: 12px;
    margin-top:10px;
    /* border: 1px solid #ccc; */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4); 
    border-radius:5px;
    padding: 10px;
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
    display:flex;
    justify-content:flex-end;

}
button{
    width:80px;
    height:25px;
    font-size:17px;
    background:#A5E79C;
}


</style>