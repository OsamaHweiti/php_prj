<?php
# Initialize session
session_start();

# Check if user is already logged in, If yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE) {
  echo "<script>" . "window.location.href='./index.php'" . "</script>";
  exit;
}

require "config.php";


if($link)
{
  if(isset($_POST['submit']))
  {
      $username=mysqli_real_escape_string($link,$_POST['user_login']);
      
      $password=mysqli_real_escape_string($link,$_POST['user_password']);

      $password=md5($password); 
      
      $sql="SELECT * FROM form WHERE  email='$username'  AND password='$password'";
      $result=mysqli_query($link,$sql);
      
      $admin = "SELECT * FROM form WHERE '$username' =  'o@admin.com'";
      $isadmin=mysqli_query($link,$admin);
      if($result)
      {
     
        if( mysqli_num_rows($result)>=1)
        {
            // ADMIN IF TRUE PRINT OUT DB
        
            $_SESSION['message']="You are now Loggged In";
            $_SESSION['username']=$username;
            $_SESSION["loggedin"] = TRUE;
            header('location: index.php');
            // echo "<script>" . "window.location.href='index.php';" . "</script>";
            
          }
       else
       {
              $_SESSION['message']="Username and Password combiation incorrect";
       }
      }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User login system</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
  <script defer src="./js/script.js"></script>
</head>

<body>
  <div class="container">
    <div class="row min-vh-100 justify-content-center align-items-center">
      <div class="col-lg-5">
        <?php
        if (!empty($login_err)) {
          echo "<div class='alert alert-danger'>" . $login_err . "</div>";
        }
        ?>
        <div class="form-wrap border rounded p-4">
          <h1>Log In</h1>
          <p>Please login to continue</p>
         
          <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div class="mb-3">
              <label for="user_login" class="form-label">Email or username</label>
              <input type="text" class="form-control" name="user_login" id="user_login" value="">
              <small class="text-danger"></small>
            </div>
            <div class="mb-2">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="user_password" id="password">
              <small class="text-danger"></small>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="togglePassword">
              <label for="togglePassword" class="form-check-label">Show Password</label>
            </div>
            <div class="mb-3">
              <input type="submit" class="btn btn-primary form-control" name="submit" value="Log In">
            </div>
            <p class="mb-0">Don't have an account ? <a href="./register.php">Sign Up</a></p>
          </form>

        </div>
      </div>
    </div>
  </div>
</body>

</html>