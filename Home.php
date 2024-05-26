<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="home.css" rel="stylesheet">
    <title>Home Page</title>
</head>

<style>
     @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body{
        font-family: 'Poppins';
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
        </style>
<body>
    <nav class="navbar background">
        <div class="logo">
            <img src="home-images/Yantadoot.png" style="height: 80px;" alt="Logo">
        </div>
        <ul class="nav-list">
            <li><a href="#home">Home</a></li>
            <li><a href="#About_Us">About Us</a></li>
            <!-- <li style="width:120px;"><a href="add-product.php">Rent Your Product</a></li> -->
            <li><a href="chat.php">Dashboard</a></li>
            <li><a href="#Help">Help!</a></li>
        </ul>
        <div class="rightnav" style="border:none" >
            <!-- <div class="right-sub">
            <input type="text" name="search" id="search">
            <button class="btn btn-sm">Search</button>
            </div> -->
            <!-- <A href="login.php"><img src="home-images/person33.png"
                    style="height: 40px; padding-left: 20px; padding-top: 10px;"></A> -->
                    <!-- Here is where we dynamically show the user icon -->
            <div class="profile" style="display:flex; gap:20px;justify-content:flex-end; margin-right:20px">
                <div><a href="Agency_login.php" style="color:green;font-size:18px;margin: 0 50px">Agency Login</a></div>
               <div>
                 <?php
                  session_start(); // Start session
            
                    // Check if the user is logged in
                     if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
                     $username = $_SESSION['username'];
                      $first_letter = strtoupper(substr($username, 0, 1)); // Get the first letter and convert it to uppercase
                
                       // Display the user's initial in a circle
                       echo '<a href="profile.php" class="user-initial">' . $first_letter . '</a>';

                      } else {
                      // Display the login link if the user is not logged in
                         // echo '<a href="login.php"><img src="home-images/person33.png" style="height: 50px;margin-right:15px; padding-left: 20px; padding-top: 10px;"></a>';
                       echo '<a style="color:green;font-size:18px;margin: 0 50px" href="login.php">User Login</a>';
                     }
                  ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="image-bar" id="imageBar">
    
        <button style="padding:25px; font-size:40px;"  class="prev-button" id="prevButton">&lt;</button>
        <img src="home-images/Add a subheading (1).png" alt="Image 1">
        <img src="home-images/howtouse (2).png" alt="Image 2">

        <button style="padding:25px;font-size:40px;" class="next-button" id="nextButton">&gt;</button>
    </div>
    <script src="roll.js"></script>

    <div class="container">

        <h1 class="heading">Categories</h1>

        <div class="box-container">

            <div class="box">
                <h3 style="color: green;">Harvestors</h3>
                <a href="#" class="btn">and more </a>
            </div>

            <div class="box">
                <h3 style="color: green;"> Landscaping</h3>
                <a href="#" class="btn">and more </a>
            </div>

            <div class="box">
                <h3 style="color: green;">Sprayers</h3>
                <a href="#" class="btn">and more</a>
            </div>

            <div class="box">
                <h3 style="color: green;">Brush Cutters</h3>
                <a href="#" class="btn">and more</a>
            </div>

            <div class="box">
                <h3 style="color: green;">Cultivators</h3>
                <a href="#" class="btn">and more</a>
            </div>

            <div class="box">
                <h3 style="color: green;">Fogging Machine</h3>
                <a href="#" class="btn">and more</a>
            </div>

            <div class="box">
                <h3 style="color: green;">Agricutural Pumps</h3>
                <a href="#" class="btn">and more</a>
            </div>

            <div class="box">
                <h3 style="color: green;">Pipe & Sprinklers</h3>
                <a href="#" class="btn">and more</a>
            </div>

            <div class="box">
                <h3 style="color: green;">Tillers</h3>
                <a href="#" class="btn">and more</a>
            </div>

            <div class="box">
                <h3 style="color: green;">Weeders</h3>
                <a href="#" class="btn">and more</a>
            </div>

            <div class="box">
                <h3 style="color: green;">Aquaculture</h3>
                <a href="#" class="btn">and more</a>
            </div>

            <div class="box">
                <h3 style="color: green;">Other Special Tools</h3>
                <a href="#" class="btn">and more</a>
            </div>

        </div>

    </div>

    <div class="container">

        <h1 class="heading">our services</h1>

        <div class="box-container">

            <div class="box">
                <img src="home-images/headphone.png" alt="">
                <h3>24*7 Customer Support</h3>
                <p>We are just a call away</p>
            </div>

            <div class="box">
                <img src="home-images/handshake.png" alt="">
                <h3>Trusted Renters & Hireres</h3>
                <p>Entrusted safety of your transaction</p>
            </div>

            <div class="box">
                <img src="home-images/rightclick.png" alt="">
                <h3>On click booking</h3>
                <p>Time saving booking</p>
            </div>

        </div>

    </div>

    <footer class="background">
        <p class="text-footer">
        <div class="logo">
            <img src="home-images/Yantadoot.png" style="height: 80px;" alt="Logo">
        </div>
        <div style="color: green;">
            @Krishi Yantra Doot
        </div>
        </p>
    </footer>
</body>

</html>