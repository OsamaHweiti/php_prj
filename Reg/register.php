<?php

require_once "./config.php";


$username_err = $email_err = $password_err =   $passwordc_err = "";
$username = $email = $password = $mobile = $passwordc =  "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  # Validate full name
  if (empty(trim($_POST["username"]))) {
      $username_err = "Please enter your full name.";
  } else {
      $username = trim($_POST["username"]);
      if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
          $username_err = "Only alphabets and whitespace are allowed";
      } else {
          # Prepare a select statement
          $sql = "SELECT id FROM form WHERE username = ?";

          if ($stmt = mysqli_prepare($link, $sql)) {
              # Bind variables to the statement as parameters
              mysqli_stmt_bind_param($stmt, "s", $param_username);

              # Set parameters
              $param_username = $username;

             
              if (mysqli_stmt_execute($stmt)) {
                  
                  mysqli_stmt_store_result($stmt);

                
                  if (mysqli_stmt_num_rows($stmt) == 1) {
                      $username_err = "This full name is already registered.";
                  }
              } else {
                  echo "<script>" . "alert('Oops! Something went wrong. Please try again later.')" . "</script>";
              }

              mysqli_stmt_close($stmt);
          }
      }
  }

  # Validate email 
  if (empty(trim($_POST["email"]))) {
    $email_err = "Please enter an email address";
  } else {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Please enter a valid email address.";
    } else {
      
      $sql = "SELECT id FROM form WHERE email = ?";

      if ($stmt = mysqli_prepare($link, $sql)) {
        
        mysqli_stmt_bind_param($stmt, "s", $param_email);

   
        $param_email = $email;

     
        if (mysqli_stmt_execute($stmt)) {
        
          mysqli_stmt_store_result($stmt);

          
          if (mysqli_stmt_num_rows($stmt) == 1) {
            $email_err = "This email is already registered.";
          }
        } else {
          echo "<script>" . "alert('Oops! Something went wrong. Please try again later.');" . "</script>";
        }

        
        mysqli_stmt_close($stmt);
      }
    }
  }

  # Validate password
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter a password.";
  } else {
    $password = trim($_POST["password"]);
    if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password))  {
      $password_err = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
    }
  }
  if(empty(trim($_POST['confirmpassword']))){
    $passwordc_err = "Please enter a  confirm password.";
  }
  else{
    $password = trim($_POST["confirmpassword"]);
    if ($_POST["password"] == $_POST['confirmpassword']){
      }else{
        $passwordc_err="Password did not match!";
    }
  }
  $mobile = $_POST['mobile'];
 
  if (empty($username_err) && empty($email_err) && empty($password_err)) {
    
    $sql = "INSERT INTO form(username, mobile, email, password) VALUES (?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
      # Bind varibales to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_mobile, $param_email, $param_password);
  
   
      $param_username = $username;
      $param_mobile = $mobile;
      $param_email = $email;
      $param_password = md5($password);
      
    
      if (mysqli_stmt_execute($stmt)) {
       // echo "<script>" . "alert('Registeration completed successfully. Login to continue.');" . "</script>";
        echo "<script>" . "window.location.href='./login.php';" . "</script>";
        exit;
      } else {
        echo "<script>" . "alert('Oops! Something went wrong. Please try again later.');" . "</script>";
      }

      # Close statement
      mysqli_stmt_close($stmt);
    }
  }


  mysqli_close($link);
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
        <div class="form-wrap border rounded p-4">
          <h1>Sign up</h1>
          <p>Please fill this form to register</p>
         
          <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div class="mb-2">
              <label for="username" class="form-label">Full Name</label>
              <!-- <input type="text" class="form-control" name="username" id="username" value="<?= $username; ?>"> -->
              <input type="text" name="username" class="form-control <?php echo (!empty($full_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
              <small class="text-danger"><?= $username_err; ?></small>
            </div>
            
         
            <div class="mb-2">
              <label for="mobile" class="form-label">Mobile</label>
              <input  class="form-control" type="tel" id="phone" name="mobile" required pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" title="please enter a valid mobile">
              <small class="text-danger"></small>
            </div>
            <div class="mb-2">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" name="email" id="email" value="<?= $email; ?>">
              <small class="text-danger"><?= $email_err; ?></small>
            </div>
            <div class="mb-2">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="password" value="<?= $password; ?>">
              <small class="text-danger"><?= $password_err; ?></small>
            </div>
            <div class="mb-2">
              <label for="password" class="form-label">Password Check</label>
              <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" value="<?= $passwordc; ?>">
              <small class="text-danger"><?= $passwordc_err; ?></small>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="togglePassword">
              <label for="togglePassword" class="form-check-label">Show Password</label>
            </div>
            <div class="mb-3">
              <input type="submit" class="btn btn-primary form-control" name="submit" value="Sign Up">
            </div>
            <p class="mb-0">Already have an account ? <a href="./login.php">Log In</a></p>
          </form>
          
        </div>
      </div>
    </div>
  </div>
</body>

</html>