<?php
include('configServ.php');
include('geocode.php');
session_start();

$errors = array(); 

// REGISTER USER
if (isset($_POST['reg_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $address = mysqli_real_escape_string($db, $_POST['address']);
  $contact = mysqli_real_escape_string($db, $_POST['contact']);
  $phone = mysqli_real_escape_string($db, $_POST['phone']);
  $dob = mysqli_real_escape_string($db, $_POST['dob']);

  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) {
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }
    
  if (count($errors) == 0) {
	$data_arr = geocode($address);
	if($data_arr) {
			$address = $data_arr[2];
	}
  	$query = "INSERT INTO users (is_business, contact_name, username, password, email, phone_number, address, dob) 
  			  VALUES(0, '$contact', '$username', '$password','$email', '$phone', '$address', '$dob')";
                            
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
	$_SESSION['is_business'] = 0;
	header('location: home.php');
  }
    else {
        echo '<script>alert("Username or email already taken");</script>';
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create an Account</title>
    <link rel="stylesheet" href="registerSS.css">
</head>
<body>
     <form method="post" action="">
         
         <div class="overall-container">
            <div style="margin: 10px; text-align: center;" class="header-container">
                <label style="font-size: 28px;"><b>Create an Account</b></label>
             </div>
             
                <label for="username"><b>Username</b></label>
                <input type="text" name="username" required>
  
             
                <span class="username">
                <label for="password"><b>Password</b></label>
                <input type="password" name="password" required>
                </span>
             
                <label for="email"><b>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
                <input type="text" name="email" required>
             
                <span class="username">
                <label for="contact"><b>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
                <input type="text" name="contact" required>
                </span>
             
                <span class="username">
                <label for="address"><b>Address&nbsp;&nbsp;&nbsp;</b></label>
                <input type="text" name="address" required>
                </span>
             
                <span class="username">
                <label for="phone"><b>Phone Number</b></label>
                <input type="text" name="phone" required>
                </span>
             
                <span class="username">
                <label for="dob"><b>Date of Birth&nbsp;&nbsp;&nbsp;&nbsp;</b></label>
                <input type="text" name="dob" required>
                </span>
             
             <div style="display: flex; justify-content: center;"><button type="submit" class="btn" name="reg_user">Register</button></div>
         </div>
    </form> 
</body>
</html>