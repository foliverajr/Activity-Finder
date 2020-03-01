<?php
include("configServ.php");
   
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $username = mysqli_real_escape_string($db,$_POST['username']);
      $password = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT user_id FROM users WHERE username = '$username' and password = '$password'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
		
      if($count == 1) {
         $_SESSION['login_user'] = $username;
         $_SESSION['username'] = $username;
         header("location: home.php");
      } else {
         echo '<script>alert("Your username or password is incorrect.")</script>';
		 echo "<script>location.href = 'login.php';</script>";
      }
   }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="loginSS.css">
</head>

<body>
  <div class="imgcontainer">
    <img src="images/logo.jpg" alt="Avatar" class="avatar">
  </div>

  <div class="overall-container">
    <form action="" method="post">
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" required><br>
        
        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required><br>
    
        <button type="submit">Login</button>
    </form>
 
    <div class="container" style="font-family:sans-serif; background-color:white">
        <span class="password"><a href="registerAccount.php">Create an account</a></span>
    </div>
  </div> 
</body>
</html>