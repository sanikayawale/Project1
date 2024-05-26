<?php
// Include the database connection file
include 'dbconnect.php';

// Start a session
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the mobile number and password from the POST request
    $mobile = $_POST['mobile'];
    $password = $_POST['Password'];

    // Query to fetch user data from the database based on the mobile number
    $query = "SELECT mobile, password, first_name,Id FROM users WHERE mobile = '$mobile'";
    $result = $conn->query($query);

    // Check if any user data was found
    if ($result->num_rows > 0) {
        // Fetch the user data as an associative array
        $user = $result->fetch_assoc();
        
        // Verify the provided password with the stored password
        if ($password === $user['password']) {
            // Passwords match, user is authenticated

        
            // Store the user's mobile number in the session to keep them logged in
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['Id'];
            $_SESSION['username'] = $user['first_name'];
           
            
            // Redirect the user to the home page or dashboard
            header("Location: Home.php");
            exit();
        } else {
            // Incorrect password, display an error message
            echo "Incorrect password. Please try again.";
        }
    } else {
        // No user found with the provided mobile number
        echo "No user found with the provided mobile number. Please try again.";
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        body {
            font-family: 'Poppins';
            margin: 0;
            padding: 0;
            background:linear-gradient(270deg, whitesmoke, lightgreen);
        }
        /* .container {
            margin-left: 25%;
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            border: black 2px solid;
            background-color: #f2f2f2;
        } */
        /* .head{
            margin-left: 40%;
            margin-top: 80px;
            border: 1px solid black;
            height: 40px;
            width: 15%;
            justify-content: center;
            align-items: center;
            display: flex;
            border-radius: 25px;
            background-color: rgb(42, 153, 42);            
        } */
        .login-box {
            margin-top: 150px;
            margin-left: 550px;            
            width: 350px;
            height: 300px;
            padding: 50px;
            padding-bottom: 90px;
            justify-content: center;
            align-items: center;
            /* border: 1px solid #ccc; */
            border-radius: 10px;
            background-color: #fff;
            /* display: flex;
            border: black 2px solid; */
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        /* .login-box img {
            width: 300px;
            height: auto;
            margin-right: 20px;
        } */
        .login-form {
            margin-left: 30px;
        }
        .login-form h2 {
            margin-top: 0px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 10px;
        }
        .form-group input {
            width: 80%;
            padding: 10px;
            border: none;
            border-bottom: 2px solid green; 
        }
        /* h5{
            margin-top: 1px;
            font-weight: lighter;
        } */
        .form-group button {
            width: 60%;
            padding: 10px;
            margin-left: 50px;
            margin-top: 10px;
            margin-bottom: 7px;
            background-color: green;
            font-size: 17px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover{
            background-color: rgb(2, 98, 2);
        }
        p{
            margin-left: 15px;
        }
    </style>
</head>
<body>
    <!-- <div class="container">
        <h2 class="head">Krushiyantra</h2> -->
        <div class="login-box">
           
            <!-- <img src="other-images/login-image.jpg" alt="Logo"> -->
            <div class="login-form">
                <h2>User Login</h2>
                <form  method="POST">
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}" placeholder="Enter the phone no.">
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="text" id="Password" name="Password" placeholder="Enter the password" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="otp">OTP</label>
                        <input type="text" id="otp" name="otp" required>
                        <h5>(OTP will be sent to your mobile number)</h5>
                    </div> -->
                    <div class="form-group">
                        <button type="submit">Login</button>
                    </div>
                </form>
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </div>
    <!-- </div> -->
</body>
</html>
