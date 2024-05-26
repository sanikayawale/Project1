<?php
// Include the database connection file
include 'dbconnect.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data from the POST request
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $address = $_POST['address'];
    $password = $_POST['Password'];

    // Check if the agency is already registered
    $query = "SELECT * FROM agency WHERE mobile = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $mobile, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // If agency is already registered, return a message
    if ($result->num_rows > 0) {
        echo "Agency with the given mobile number or email already exists!";
    } else {
        // If not registered, proceed to insert new agency data
        $query = "INSERT INTO agency (name, mobile, email, location, address, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash password for security
        $stmt->bind_param("ssssss", $name, $mobile, $email, $location, $address, $password);
        
        if ($stmt->execute()) {
            echo "Agency registration successful!";
            header("Location: Agency_login.php");
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    
    // Close the statement
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
    <!-- <link rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">  -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/libphonenumber-js/1.9.18/libphonenumber-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script> -->
    
</head>

    <title>Registration Form</title>
     
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-analytics.js"></script>

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
    function codeverify() {
    var code = document.getElementById('otp').value;
    coderesult.confirm(code).then(function(result) {
        
      alert("OTP verified successfully.");
        var user = result.user;
        console.log(user);
    }).catch(function(error) {
        alert(error.message);
    });
      }
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body{
        font-family: 'Poppins';
    }
        body {
            margin: 0;
            padding: 0;
            /* background-color: rgb(120, 185, 120); */
            background:linear-gradient(270deg, whitesmoke, lightgreen);

        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .head {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .registration-form {
            padding: 20px;
            border-radius: 5px;
            padding-left: 75px;
            align-items: center;
            justify-content: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        .form-group input[type="text"],
        /* .form-group input[type="tel"], */
        .form-group input[type="text"],.form-group input[type="email"],
        .form-group textarea {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
         input[type="tel"]{
            padding-left: 10px ;
            width: 80%;
            height: 35px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
         }

        .form-group button {
            padding: 10px 20px;
            background-color: green;
            font-size: 15px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .form-group button:hover {
            background-color: rgb(3, 103, 3);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .valid {
            color: green;
        }
        .invalid {
            color: red;
        }

        /* .otp-container {
            display: none;
        } */

        .verified {
            background-color: green;
        }
        .register{
            margin-left: 155px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="head">Agency Registration</h2>
        <div class="registration-form">
            <form method="POST" id="registrationForm" onsubmit="return validateForm()">
                <div class="form-group">
                    <label>Agency Name</label>
                    <input style="width: 78%; " type="text" id="name" name="name" placeholder="Enter Agency Name" required>
                </div>
                
                <!-- <div class="form-group">
                    <label for="countryCode">Country Code</label>
                    <select id="countryCode" name="countryCode">
                        <option value="+91">+91 (India)</option>
                        Add more options for other country codes if needed
                    </select>
                </div> -->
                <div class="form-group">
                    <label>Contact No</label>
                    <input type="tel" id="mobile" name="mobile" placeholder="Enter Contact No" required>
                    <div id="recaptcha-container"></div>
                    <button type="button"  onclick="phoneAuth();" id="sendOTP">Send OTP</button>
                </div>
                <div class="otp-container form-group">
                    <label for="otp">Enter OTP</label>
                    <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
                    <button type="button" onclick="codeverify();" id="verifyOTP">Verify OTP</button>
                </div>
                <!-- <div class="form-group">
                    <label for="aadhar">Aadhar Number</label>
                    <input type="text" id="aadhar" name="aadhar" required>
                </div> -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email Id" required>
                </div>
                <div class="loc" style="display: flex; gap: 65px;">
                <div class="form-group">
                    <label for="location">Location (City/Village)</label>
                    <input type="text" id="location" name="location" placeholder="Enter City/ Village" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="2" placeholder="Enter Address" required></textarea>
                </div>
            </div>
            <div class="pass" style="display: flex; gap: 65px;">
                <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="text" id="Password" name="Password" placeholder="Enter Password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="text" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                </div>
            </div>
                <div class="form-group">
                    <button class="register" type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            var password = document.getElementById("Password").value;
            var confirmPassword = document.getElementById("confirm-password").value;
            var mobile_no = document.getElementById("mobile").value;
            // var aadhar_no = document.getElementById("aadhar").value;

            if (password != confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }

            if (mobile_no.length < 10) {
                alert("Mobile number must be at least 10 digits long!");
                return false;
            }

            // if (aadhar_no.length < 12) {
            //     alert("Aadhar number must be at least 12 digits long!");
            //     return false;
            // }

            // if (!/^\d+$/.test(aadhar_no)) {
            // alert("Please enter a valid Aadhar number containing only digits.");
            // return false;
            // }

            // If all validations pass, return true to submit the form
            return true;
        }

    </script>

<!-- <script>
    const phoneInputField = document.querySelector("#mobile");
    const phoneInput = window.intlTelInput(phoneInputField, {
      utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });
  </script> -->

<!-- <script src="https://www.gstatic.com/firebasejs/8.3.1/firebase.js"></script> -->
    <script>
 var firebaseConfig = {
    apiKey: "AIzaSyDGc7CxvKB0BOCUvtwh2tdqYGy8wg3K3TU",
  authDomain: "major-project-945a1.firebaseapp.com",
  projectId: "major-project-945a1",
  storageBucket: "major-project-945a1.appspot.com",
  messagingSenderId: "723886362380",
  appId: "1:723886362380:web:b274378b1a0f8a19bb8329",
  measurementId: "G-D1SVS0TJKR"
    };
    
    firebase.initializeApp(firebaseConfig);
     firebase.analytics();
</script>
    <script src="otpverify.js" type="text/javascript"></script>

</body>
</html>