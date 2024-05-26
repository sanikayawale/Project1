<?php
session_start(); // Start session

// Check if the user is logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
    // Retrieve user details from the database using user ID
    include 'dbconnect.php';
    $userId = $_SESSION['user_id'];
    $fetchUserQuery = 'SELECT first_name, last_name, mobile, location, address FROM users WHERE Id = ?';
    if ($stmt = $conn->prepare($fetchUserQuery)) {
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $firstName = $row['first_name'];
            $lastName = $row['last_name'];
            $mobile = $row['mobile'];
            $location = $row['location'];
            $address = $row['address'];
        }
        $stmt->close();
    } else {
        echo '<p>Error preparing statement: ' . $conn->error . '</p>';
    }
} else {
    // If user is not logged in, show alert and redirect to login.php after 1 second
    echo '<script>alert("User not logged in."); setTimeout(function(){ window.location.href = "login.php"; }, 1000);</script>';
    exit; // Stop executing further PHP code
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="home.css" rel="stylesheet">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"
/>
    <title>Profile</title>
</head>
<style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body{
        font-family: 'Poppins';
    }
        /* user-initial navbar styling */
    .user-initial {
            width: 40px;
            height: 40px;
            background-color: green;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            /* margin-left:50px; */
            position: absolute;
            top: 20px; /* Adjust top position */
            right: 20px; /* Adjust right position */
        }
        .profile{
            margin-left: 15px;
        }
        .link i{
            /* position: absolute; */
            /* justify-items: center; */
            /* right: 10px;  */
            /* margin-bottom: 30px; */
            font-size: 25px;
            color: green;
            margin-left: 20px;
            font-size: 30px;
        }
        </style>


<style>
    .username{
        /* border:solid red 1px; */
        width:150px;
        display:flex;
        align-items:center;
    }
    .profile-section{
        margin-left:100px;
        width: 20%; 
        background-color: #f9f9f9;
        margin-top:25px;
        padding: 10px;
        /* border:solid black 1px; */
        border-radius:10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); 
    }
    .profile-user{
        display:flex;
        gap:10px;
        margin-top: 25px;
        /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);  */
    }
    .name{
        font-size:20px;
        padding:5px;
    }
    .profile-links{
        margin-top:50px;        
        /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); */
    }
    .links{
        display: flex;
        flex-direction: column; 
        gap: 25px; 
        /* border:solid black 1px; */
        list-style: none;
        /* border: solid red 1px; */
        margin-left:30px;
    }
    .links a{
        color: green;
        font-size:18px;
        /* border: 1px red solid; */
        /* margin-left:70px; */
        /* margin-top: 60px; */
        
    }
    .links a:hover{
        /* color:black; */
        cursor:pointer;
        color: rgb(61, 161, 61);
        /* background-color:red; */
        /* border-bottom: 3px solid green; */
        /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);  */
    }
    .link{
        width: fit-content;
        padding: 5px;
    }
    .link:hover{
        background-color: rgb(234, 226, 226);
        border-radius: 5px;
    }
    
    .out{
        margin-top:100px;
    }
    
    .big-container{
        width: 80%; 
        padding: 10px; 
        /* border: solid black 1px; */
        margin-top:25px;
        margin-right:20px;
    }
</style>
<style>
   .profile-details {
        margin-top: 40px;
        padding: 20px;
        margin-left:30px;
        width:900px;
        height:400px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .actual-details{
        margin-top: 20px;
         width:100%;
         padding:20px;
    }
    .profile-details .name {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .profile-details .name strong {
        font-weight: bold;
        color: #333;
    }

    .profile-details .name p {
        margin: 0;
        font-size: 20px;
        color: #555;
    }

    .profile-details p {
        margin-bottom: 10px;
        font-size: 18px;
        color: #666;
    }

    .profile-details strong {
        font-weight: bold;
        color: #333;
        margin-left: 10px;
        margin-right: 30px;
    }

    .img-user{
        display:flex;
        margin-left: 30px;
    }
    img{
        margin-left:25px;
    }
    h2 {
        color: #333;
        font-size: 24px;
        margin-bottom: 20px;
        margin-top:30px;
        padding:10px;
        margin-left:50px;
    }
    .all{
        display:flex;
    }
    .image{
        display:flex;
        align-items:center;
        width:550px;
    }
    .image img{
        border-radius:5px;
    }
    .inner-det{
        border-bottom: 1px solid rgb(195, 193, 193);
        padding:10px;
        margin-bottom: 10px;
    }
    
    
</style>
<body>
<nav class="navbar background">
        <div class="logo">
            <img src="home-images/Yantadoot.png" style="height: 80px;" alt="Logo">
        </div>
        <ul class="nav-list">
            <li><a href="Home.php">Home</a></li>
            <li><a href="#About_Us">About Us</a></li>
           
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
            <div class="profile" style="display:flex; gap:20px; justify-content:flex-end; margin-right:20px">
                <div><a href="Agency_login.php" style="color:green;font-size:17px; margin: 0 50px";>Agency Login</a></div>
               <div>
                 <?php
                  //session_start(); // Start session
            
                    // Check if the user is logged in
                     if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
                     $username = $_SESSION['username'];
                      $first_letter = strtoupper(substr($username, 0, 1)); // Get the first letter and convert it to uppercase
                
                       // Display the user's initial in a circle
                       echo '<a href="profile.php" class="user-initial">' . $first_letter . '</a>';

                      } else {
                      // Display the login link if the user is not logged in
                         // echo '<a href="login.php"><img src="home-images/person33.png" style="height: 50px;margin-right:15px; padding-left: 20px; padding-top: 10px;"></a>';
                       echo '<a style="color:green;font-size:17px; margin: 0 50px" href="login.php">User Login</a>';
                     }
                  ?>
                </div>
            </div>
        </div>
    </nav>
    

    <!-- Profile and Big Container -->
    <div class="content-container" style="display: flex; gap: 20px;">
        <!-- Profile Section on the left side -->
        <div class="profile-section" >
            <!-- Profile content goes here -->
            <div class="profile-user" >
               <div class="p-img">
               <img src="other-images/profile-icon.png"  style="width: 70px; height: 70px;">
                </div>
                <div class="username">
                <!-- <h3>Profile</h3> -->
                <?php
                // session_start(); // Start session
                
                // Check if the user is logged in
                if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
                    $username = $_SESSION['username'];
                    echo '<p class="name" style="color:green;">Hi  ' . $username . '  !</p>'; // Display the user's full name
                }
                ?>
                </div>
            </div>


            <div class="profile-links">
            <ul class="links">
                <div class="link" style="display: flex; align-items: center; gap: 70px">
                    <li><a href="edit_profile.php">Edit Profile</a></li>
                    <a class="arrow"><i class="ri-arrow-right-s-line"></i></a>
                </div>
                <div class="link" style="display: flex; align-items: center; gap: 15px">
                    <li><a href="booked-products.php" id="bookedProductsLink">Booked Products</a></li>
                    <a class="arrow"><i class="ri-arrow-right-s-line"></i></a>
                </div>
                <div class="link" style="display: flex; align-items: center; gap: 105px">
                    <li><a href="#" id="historyLink">History</a></li>
                    <a class="arrow"><i class="ri-arrow-right-s-line"></i></a>
                </div>
                <div class="link" style="display: flex; align-items: center; gap: 125px">
                    <li><a href="help.php">Help</a></li>
                    <a class="arrow"><i class="ri-arrow-right-s-line"></i></a>
                </div>
                <div class="link" style="display: flex; align-items: center; gap: 105px;">
                    <li><a href="logout.php">Logout</a></li>
                    <a class="arrow"><i class="ri-arrow-right-s-line"></i></a>
                </div>    
              </ul>
            </div>


        </div>

        <!-- Big Container on the right side -->
        <div class="big-container"id="bigContainer" >
            <div class="all">
             <div class="user">
               <div class="img-user">
                  <img src="other-images/profile-icon.png" style="width: 100px; height: 100px; border-radius: 50%;">
                  <h2>User Profile</h2>
               </div>
               <div class="profile-details">
                     <div class="actual-details">
                        <?php if (isset($firstName)): ?>
                     <div class="inner-det">
                  <p><strong>User Name:</strong> <?php echo $firstName . ' ' . $lastName; ?></p>
                  </div>
                  <div class="inner-det">
                      <p><strong>Contact No:</strong> <?php echo $mobile; ?></p>
                    </div>
                    <div class="inner-det">
                      <p><strong style="margin-right: 55px;">Location:</strong> <?php echo $location; ?></p>
                    </div>
                    <div class="inner-det">
                      <p><strong style="margin-right: 55px;">Address:</strong> <?php echo $address; ?></p>
                    </div>
                    
                      <?php else: ?>
                        <p>No user profile found.</p>
                      <?php endif; ?>
                   </div>
               </div>
             </div>
             <!-- <div class="image">
                <img src="other-images/farm.jpg" >
             </div> -->
          </div>

        </div>

    <script>
    // Listen for clicks on the "Booked Products" link
        document.getElementById('bookedProductsLink').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default link behavior

            // Create a new XMLHttpRequest object
            const xhr = new XMLHttpRequest();

            // Set up the request
            xhr.open('GET', 'booking_details.php', true);

            // Set up the onload function to handle the response
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Update the content of the big container with the response from booked_products.php
                    document.getElementById('bigContainer').innerHTML = xhr.responseText;
                } else {
                    console.error('Failed to load booked_products.php. Status:', xhr.status);
                }
            };

            // Set up the onerror function to handle request errors
            xhr.onerror = function () {
                console.error('An error occurred while loading booked_products.php.');
            };

            // Send the request
            xhr.send();
        });
    </script>
 
 <script>
    // Listen for clicks on the "Edit Profile" link
    document.querySelector('a[href="edit_profile.php"]').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default link behavior

        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open('GET', 'edit_profile.php', true);

        // Set up the onload function to handle the response
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the content of the big container with the response from edit_profile.php
                document.getElementById('bigContainer').innerHTML = xhr.responseText;
            } else {
                console.error('Failed to load edit_profile.php. Status:', xhr.status);
            }
        };

        // Set up the onerror function to handle request errors
        xhr.onerror = function () {
            console.error('An error occurred while loading edit_profile.php.');
        };

        // Send the request
        xhr.send();
    });
</script>

<!-- Add this script at the end of your HTML -->
<script>
    // Listen for clicks on the "History" link
    document.getElementById('historyLink').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default link behavior

        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open('GET', 'user_history.php', true);

        // Set up the onload function to handle the response
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the content of the big container with the response from user_history.php
                document.getElementById('bigContainer').innerHTML = xhr.responseText;
            } else {
                console.error('Failed to load user_history.php. Status:', xhr.status);
            }
        };

        // Set up the onerror function to handle request errors
        xhr.onerror = function () {
            console.error('An error occurred while loading user_history.php.');
        };

        // Send the request
        xhr.send();
    });
</script>

</body>
</html>