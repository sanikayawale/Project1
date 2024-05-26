<?php
// Start the session (if not already started)
session_start();

// Include the database connection file
include 'dbconnect.php';

// Retrieve the products from the database
$query = "SELECT model_name, start_date, end_date, rental_cost, image FROM products";
$result = mysqli_query($conn, $query);

// Check if there are any products
if (mysqli_num_rows($result) > 0) {
    // echo '<div class="product-container">';
    
    // Iterate through the products
    while ($row = mysqli_fetch_assoc($result)) {
        // Retrieve product data
        $modelName = $row['model_name'];
        $startDate = new DateTime($row['start_date']);
        $endDate = new DateTime($row['end_date']);
        $rentalCost = $row['rental_cost'];
        $imageData = $row['image'];
        
        // Convert image data to base64 format for display
        $imageBase64 = base64_encode($imageData);
        $imageSrc = "data:image/jpeg;base64," . $imageBase64;
        
        // Format the start and end dates as "d M Y" (e.g., "12 Oct 2003")
        $startDateFormatted = $startDate->format('d M Y');
        $endDateFormatted = $endDate->format('d M Y');
        
       
    }
    
    // echo '</div>';
} else {
    echo '<p>No products found.</p>';
}

// Close the database connection
mysqli_close($conn);
?>

<!-- Add some CSS styling -->
<style>
    .product-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        /* justify-content: center; */
        border:solid black 1px;
    }
    .product-box {
        border: 1px solid #616158 ;
        border-radius: 5px;
        padding: 10px;
        width: 250px;
        text-align: center;
    }
    .product-box:hover{
        box-shadow: 0 10px 15px rgba(0, 0, 0, .3);
    }
    .product-image {
        width: 80%;
        height: auto;
        border-radius: 5px;
        background:#EEF68B;
        box-shadow: 0 10px 15px rgba(0, 0, 0, .3);
    }
    .product-details {
        margin-top: 10px;
    }
    .nav{
        height:50px;
        background:#84EC7F;
        justify-content:center;
        align-items:center;
        display:flex;
        /* flex-direction:column; */
    }
    .category{
        justify-content:center;
        align-items:center;
        display:flex;
    }
    .category h2{
       border:solid black 1px;
        text-align:center;
       border-radius:5px;
        width:10%;
        background:#ECDD7F;
        height:30px;
    }
    p{
        margin-bottom:5px;
        margin-top:5px;
        /* border:solid black 1px; */
    }

    .detail-btn{
        font-size:15px;
        background:#98DA38;
        height:30px;
        border-radius:5px;
        
    }
    .detail-btn:hover{
        box-shadow: 0 10px 15px rgba(0, 0, 0, .3);
        background:#66BE2D;
       
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="nav">
        <h2>Book Product</h2>
    </div>
    <div class="category">
    <h2>Harvesters</h2>
    </div>
    <!-- // Display the product in a box format -->
    <!-- <p>Start Date: ' . $startDateFormatted . '</p>
         <p>End Date: ' . $endDateFormatted . '</p> -->
         
    <?php
     echo '<div class="product-container">';
        echo '
        <div class="product-box">
            <img src="' . $imageSrc . '" alt="' . $modelName . '" class="product-image">
            <div class="product-details">
                <p>Model Name: ' . $modelName . '</p>
                <p>Rental Cost: $' . $rentalCost . '</p>
                <button class="detail-btn" onclick="#">See Details</button>
            </div>
        </div>';
        echo '</div>';
        ?>
    
</body>
</html>
