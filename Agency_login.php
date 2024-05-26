<?php
// Include the database connection file
include 'dbconnect.php';
session_start();
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data from the POST request
    $name = $_POST['name'];
    $password = $_POST['Password'];

    // Prepare a query to fetch agency data based on the name
    $query = "SELECT agency_id, name, password FROM agency WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a record is found
    if ($result->num_rows > 0) {
        // Fetch the agency data
        $agency = $result->fetch_assoc();

        // Verify the password
        // If passwords are stored hashed in the database, use password_verify() to compare
        if ($password === $agency['password']) {
            // Login successful
            // Start a session and store agency data
            $_SESSION['logged_in'] = true;
            $_SESSION['agency_id'] = $agency['agency_id'];
            $_SESSION['agency_name'] = $agency['name'];

            // Redirect to the agency portal and provide an alert
            echo "<script>
                alert('Login successful!');
                window.location.href = 'agency_portal.php';
            </script>";
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid password. Please try again.');</script>";
        }
    } else {
        // No agency found with the given name
        echo "<script>alert('Agency with the given name does not exist.');</script>";
    }

    // Close the prepared statement
    $stmt->close();
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
            /* padding-left: 90px; */
            justify-content: center;
            align-items: center;
            /* order: 1px solid #ccc; */
            border-radius: 10px;
            background-color: #fff;
            /* display: flex; */
            /* border: black 2px solid; */
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
            /* margin-bottom: 20px; */
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
            /* border-radius: 5px; */
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
    <!-- <div class="container"> -->
        <!-- <h2 class="head">Krushiyantra</h2> -->
        <div class="login-box">
           
            <!-- <img src="other-images/login-image.jpg" alt="Logo"> -->
            <div class="login-form">
                <h2>Agency Login</h2>
                <form  method="POST">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" placeholder="Enter the name" required>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password:</label>
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
                <p>Don't have an account? <a href="agency_register.php">Register</a></p>
            </div>
        </div>
    <!-- </div> -->
</body>
</html>
