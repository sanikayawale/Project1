<?php
session_start(); // Start session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Dashboard</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <!-- Link to the Font Awesome CSS library -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"/>
    <link href="home.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body{
        font-family: 'Poppins';
    }
        /* Reset default margins and paddings */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styles */
body {
    
    line-height: 1.6;
    background-color: #f4f4f4;
    color: #333;
}

/* Container */
.container {
    display: flex;
    flex-wrap: wrap;
    max-width: 1250px;
    margin: 0 auto;
    padding: 20px;
}

/* Header styles */
header {
    width: 100%;
    background-color: #007bff;
    padding: 10px;
    color: white;
}

header nav ul {
    display: flex;
    justify-content: space-between;
    list-style: none;
}

header nav ul li {
    margin-right: 10px;
}

header nav ul li a {
    color: white;
    text-decoration: none;
}

header nav ul li a:hover {
    text-decoration: underline;
}

/* Sidebar styles */
aside {
    width: 25%;
    padding: 20px;
    background-color: #ffffff;
    border-right: 1px solid #ccc;
    margin-top: 20px;
}

aside h3, aside h4 {
    margin-bottom: 10px;
}

aside ul {
    list-style: none;
}

aside li {
    margin-bottom: 5px;
    
}

aside input[type="checkbox"] {
    margin-right: 10px;
    font-size: 15px;
}

/* Main content styles */
main {
    width: 75%;
    padding: 20px;
}

main h3 {
    margin-bottom: 10px;
}

#products {
    display: grid;
    
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    background-color: #ffffff;
}

 /* .product {
    background-color: white;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
 }

 .product img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
 }

 .product .details {
    margin-top: 10px;
  } */

 /* .product .details h5 {
    margin-bottom: 5px;
 }

 .product .details p {
    font-weight: bold;
 } */

.filter-block li{
    display: flex;
    font-size: 0.9em;
    position: relative;
    line-height: 2;
}
.filter-block label .checked{
    height: 16px;
    width: 16px;
    position: relative;
    line-height: 0;
    display: inline-block;
    border: 2px solid green;
    vertical-align: text-top;
    margin: 0 7px 0 0;
    cursor: pointer;
}
.filter-block label .checked::before{
    content: '';
    position: absolute;
    width: 8px;
    height: 8px;
    background-color: green;
    top: 2px;
    left: 2px;
    opacity: 0;
}
.filter-block input:checked + label .checked::before{
    opacity: 1;
}
/* Hide the default checkbox */
input[type="checkbox"] {
            display: none;
        }
#products{
    padding:10px;
}
    .product {
    /* display: flex;
    flex-direction: column;
    align-items: center; */
    width: 250px;
    height: 300px;
    /* padding: 10px */
    border: 1px solid #ccc;
    border-radius: 5px;
    margin: 10px;
    overflow: hidden;
    transition: transform 0.3s ease-in-out;
}

.product:hover {
    transform: scale(1.05);
}

.product img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.product .details {
    padding: 10px;
    /* margin-left:2px; */
    /* border:solid black 1px; */
    text-align: left;
    position: relative;
}
.product .details .arrow {
    position: absolute;
    bottom: 10px;
    right: 10px;
    font-size: 25px;
    color: green;
}

/* .product .details h5 {
    margin-bottom: 5px;
} */

.product .details p {
    /* margin-bottom: 5px; */
    color: #666;
}



</style>
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
        </style>
</head>
<body>
    <div class="container">
    <nav class="navbar background" style="width:1300px">
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
            <div class="profile" style="display:flex; gap:25px;justify-content:flex-end; margin-right:20px">
                <div style="width:150px; justify-content:center;display:flex"><a href="Agency_login.php" style="color:green;font-size:19px">Agency Login</a></div>
               <div>
                 <?php
                //   session_start(); // Start session
            
                    // Check if the user is logged in
                     if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
                     $username = $_SESSION['username'];
                      $first_letter = strtoupper(substr($username, 0, 1)); // Get the first letter and convert it to uppercase
                
                       // Display the user's initial in a circle
                       echo '<a href="profile.php" class="user-initial">' . $first_letter . '</a>';

                      } else {
                      // Display the login link if the user is not logged in
                         // echo '<a href="login.php"><img src="home-images/person33.png" style="height: 50px;margin-right:15px; padding-left: 20px; padding-top: 10px;"></a>';
                       echo '<a style="color:green;font-size:19px;margin: 0 50px" href="login.php">User Login</a>';
                     }
                  ?>
                </div>
            </div>
        </div>
    </nav>

        <!-- Sidebar Filters -->
        <aside>
            <h3>Filter By</h3>
            <!-- Categories -->
            <div class="filter-block">
                <h4>Category</h4>
                <ul>
                    <!-- <li><label><input type="checkbox" name="category" value="Tractors"> Tractors</label></li> -->
                    <li>
                        <input type="checkbox" name="checkbox" id="Tractors" class="category">
                        <label for="Tractors">
                            <span class="checked"></span>
                            <span>Tractors</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="Sprayer" class="category">
                        <label for="Sprayer">
                            <span class="checked"></span>
                            <span>Sprayer</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="Brush Cutters" class="category">
                        <label for="Brush Cutters">
                            <span class="checked"></span>
                            <span>Brush Cutters</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="Cultivaters" class="category">
                        <label for="Cultivaters">
                            <span class="checked"></span>
                            <span>Cultivaters</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="Harvesters" class="category">
                        <label for="Harvesters">
                            <span class="checked"></span>
                            <span>Harvesters</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="Pipe & Spinklers" class="category">
                        <label for="Pipe & Spinklers">
                            <span class="checked"></span>
                            <span>Pipe and Spinklers</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="Tillers" class="category">
                        <label for="Tillers">
                            <span class="checked"></span>
                            <span>Tillers</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="Weeders" class="category">
                        <label for="Weeders">
                            <span class="checked"></span>
                            <span>Weeders</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="Planting Equipment" class="category">
                        <label for="Planting Equipment">
                            <span class="checked"></span>
                            <span>Planting Equipment</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="Others" class="category">
                        <label for="Others">
                            <span class="checked"></span>
                            <span>Others</span>
                        </label>
                    </li>
                    <!-- <li><label><input type="checkbox" name="category" value="Sprayer"> Sprayer</label></li>
                    <li><label><input type="checkbox" name="category" value="Brush Cutters"> Brush Cutters</label></li>
                    <li><label><input type="checkbox" name="category" value="Cultivaters"> Cultivaters</label></li>
                    <li><label><input type="checkbox" name="category" value="Harvesters"> Harvesters</label></li>
                    <li><label><input type="checkbox" name="category" value="Pipe and Spinklers"> Pipe and Spinklers</label></li>
                    <li><label><input type="checkbox" name="category" value="Tillers"> Tillers</label></li>
                    <li><label><input type="checkbox" name="category" value="Weeders"> Weeders</label></li>
                    <li><label><input type="checkbox" name="category" value="Planting Equipment"> Planting Equipment</label></li>
                    <li><label><input type="checkbox" name="category" value="Others"> Others</label></li> -->
                </ul>
            </div>

            <!-- Brands -->
            <div class="filter-block">
                <h4>Brand</h4>
                <ul>
                    <!-- <li><label><input type="checkbox" name="brand" value="john_deere"> John Deere</label></li>
                    <li><label><input type="checkbox" name="brand" value="mahindra"> Mahindra</label></li> -->
                    <li>
                        <input type="checkbox" name="checkbox" id="Mahindra" class="brand">
                        <label for="Mahindra">
                            <span class="checked"></span>
                            <span>Mahindra</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="Preet" class="brand">
                        <label for="Preet">
                            <span class="checked"></span>
                            <span>Preet</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="john deere" class="brand">
                        <label for="john deere">
                            <span class="checked"></span>
                            <span>John Deere</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="force motors" class="brand">
                        <label for="force motors">
                            <span class="checked"></span>
                            <span>Force Motors</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="tafe" class="brand">
                        <label for="tafe">
                            <span class="checked"></span>
                            <span>Tafe</span>
                        </label>
                    </li>
                    <li>
                        <input type="checkbox" name="checkbox" id="sonalika" class="brand">
                        <label for="sonalika">
                            <span class="checked"></span>
                            <span>Sonalika</span>
                        </label>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Section -->
        <main>
            <h3>Products</h3>
            <div class="outer-products">
            <div id="products">
               
            </div>
            </div>
        </main>
    </div>

   <script>
    document.addEventListener('DOMContentLoaded', function() {
  // Fetch products based on selected filters
  function fetchProducts() {
  // Get selected categories and brands
  const categories = Array.from(document.querySelectorAll('input[type="checkbox"][name="checkbox"].category:checked'))
    .map(input => input.id);
  const brands = Array.from(document.querySelectorAll('input[type="checkbox"][name="checkbox"].brand:checked'))
    .map(input => input.id);

    console.log('Categories:', categories);
   console.log('Brands:', brands);

  // Send filters to server
  fetch('get-products.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ categories, brands }),
  })
  .then(response => response.json())
  .then(products => {
    // Clear current products
    const productsContainer = document.querySelector('#products');
    productsContainer.innerHTML = '';

    // Display the products
    products.forEach(product => {
      const productElement = document.createElement('div');
      productElement.classList.add('product');

      const imageData = 'data:image/jpeg;base64,' + product.image;

      productElement.innerHTML = `
                <img src="${imageData}" alt="${product.model_brand}">
                <div class="details">
                    <h5>${product.agency_name} </h5>
                    <h5>${product.model_brand}</h5>
                    <p>Rental Cost: Rs ${product.rental_cost}</p>
                    <p>Category: ${product.category}</p>
                    <a href="details.php?product_id=${product.product_id}" class="arrow"><i class="ri-arrow-right-s-line angle"></i></a>
                </div>
            `;

      productsContainer.appendChild(productElement);
    });
  })
  .catch(error => {
    console.error('Error fetching products:', error);
  });
}

  // Add event listeners to category checkboxes
  document.querySelectorAll('input[type="checkbox"][name="checkbox"].category').forEach(checkbox => {
    checkbox.addEventListener('change', fetchProducts);
  });

  // Add event listeners to brand checkboxes
  document.querySelectorAll('input[type="checkbox"][name="checkbox"].brand').forEach(checkbox => {
    checkbox.addEventListener('change', fetchProducts);
  });

  // Initial fetch to display all products
  fetchProducts();
});
   </script>
   
</body>
</html>
