<?php
include 'dbconnect.php';
session_start(); // Start session

// Check if the user is logged in
if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
    // Retrieve user details from the database using user ID
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
}

// Update user details
if (isset($_POST['edit'])) {
    // Retrieve edited details from the form
    $editedFirstName = $_POST['firstName'];
    $editedLastName = $_POST['lastName'];
    $editedMobile = $_POST['mobile'];
    $editedLocation = $_POST['location'];
    $editedAddress = $_POST['address'];

    // Update the user's details in the database
    $updateUserQuery = 'UPDATE users SET first_name = ?, last_name = ?, mobile = ?, location = ?, address = ? WHERE Id = ?';
    if ($stmt = $conn->prepare($updateUserQuery)) {
        $stmt->bind_param('sssssi', $editedFirstName, $editedLastName, $editedMobile, $editedLocation, $editedAddress, $userId);
        if ($stmt->execute()) {
            // Redirect to the profile page after successful update
            header('Location: profile.php');
            exit;
        } else {
            echo '<p>Error updating user details: ' . $conn->error . '</p>';
        }
        $stmt->close();
    } else {
        echo '<p>Error preparing statement: ' . $conn->error . '</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body{
        font-family: 'Poppins';
    }
      .form-div{
        width:1000px;
        height:500px;
        padding: 10px;
        padding-left: 20px;
        /* border:solid black 1px; */
        /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);  */
      }
      form{
        width:800px;
        height:400px;
        margin-left:50px;
        margin-top:50px;
        padding: 20px;
        background-color: #f9f9f9;
        /* border:solid red 1px; */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); 
      }
      .first_last{
        display:flex;
        gap:20px;
        margin-left:22px;
        margin-top:25px;
        padding:7px;
      }
      input{
        width: fit-content;
        /* border:solid black 1px; */
        border-bottom: 3px solid green;
        height:35px;
        padding:5px;
        font-size:15px;
        background-color: #f9f9f9;
        margin-left:20px;
        /* border-radius:5px; */
      }
      label{
        font-size:20px;
        font-weight: bold;
        margin-right: 10px;
      }
      .div1{
        /* margin-top:; */
        margin-left:30px;
        margin-bottom: 5px;
      }
      input[type="submit"]
      {
        color:white;
        width:100px;
        margin-top:20px;
        margin-left:300px;
        font-size:20px;     
        background:green;
      }
      input[type="submit"]:hover{
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        background:#16680f ;
        cursor: pointer;
      }
      h1{
        margin-top:25px;
        margin-left:60px;
      }
</style>
<body>
    <h1>Edit Profile</h1>
    <div class="form-div">
    <form method="post">
        <div class="first_last">
            <div class="sub-div">
        <label for="firstName">First Name:</label>
        <input style="margin-left: 3px;" type="text" id="firstName" name="firstName" value="<?php echo isset($firstName) ? $firstName : ''; ?>" required><br><br>
             </div>
             <div class="sub-div">
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo isset($lastName) ? $lastName : ''; ?>" required><br><br>
              </div>
        </div>
        <div class="div1">
        <label for="mobile" style="margin-right: 20px;">Contact:</label>
        <input type="text" id="mobile" name="mobile" value="<?php echo isset($mobile) ? $mobile : ''; ?>" required><br><br>
        </div>
        <div class="div1">
        <label for="location" style="margin-right: 12px;">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo isset($location) ? $location : ''; ?>" required><br><br>
         </div>
         <div class="div1">
        <label for="address" style="margin-right: 15px;">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo isset($address) ? $address : ''; ?>" required><br><br>
        </div>
        <div>
        <input type="submit" name="edit" value="Edit">
        </div>
    </form>
    </div>
</body>
</html>
