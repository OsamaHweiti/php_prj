<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  $isloged = FALSE;
} else {
  $isloged = TRUE;
}

if (isset($_POST["logout"])) {
  $_SESSION["loggedin"] = FALSE;
  $isloged = FALSE;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User login </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
  <style> 
 body {
  font-family: "Barlow Semi Condensed", sans-serif;
      background-image: url("971.jpg");
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: left center; /* Move the background image to the right */
      min-height: 100vh;
      overflow: hidden;
  }
  #wlc , #info {
    color: white;
  }
</style>

</head>
<body>
  <div class="container">
    <div class="alert alert-success my-5 text-center h5" id="topwelc "style="background-color: #3a85fc;">
      Welcome ! You are now signed in to your account.
    </div>
    <!-- User profile -->
    <div class="row justify-content-center">
      <div class="col-lg-5 text-center">
        <img src="./img/blank-avatar.jpg" class="img-fluid rounded" alt="User avatar" width="180">
        <h4 class="my-4" id="welc" style="color:white;">Welcome to our site please login / sign up </h4>
        <h3 class="my-4" id="info"></h3>
        <button class="btn btn-primary" style="display: inline-block;" id="logout">Log Out</button>
        <a href="login.php" class="btn btn-primary" id="login" style="display: none;">Log in</a>
        <a href="register.php" class="btn btn-primary"id="signup" style="display: none;">Sign in</a>
      </div>
    </div>
  </div>
</body>
<script>
    var isloged = <?php echo $isloged ? 'true' : 'false'; ?>;
    var user = "<?php echo isset($_SESSION["username"]) ? htmlspecialchars($_SESSION["username"]) : ''; ?>";
    var name =  "<?php echo isset($_SESSION["FullName"]) ? htmlspecialchars($_SESSION["FullName"]) : ''; ?>";
    console.log(name);
    var firstName = name.split(' ')[0];
    var mobile = "<?php echo isset($_SESSION["mobile"]) ? htmlspecialchars($_SESSION["mobile"]) : ''; ?> ";
    var welc = document.querySelector('#welc');
    var info = document.querySelector('#info');
    var loginbtn = document.querySelector('#login');
    var signupbtn = document.querySelector('#signup');
    var logoutbtn = document.querySelector('#logout');
    var topwelc = document.querySelector('#topwelc');
    
    if (isloged) {
            logoutbtn.style.display = "inline-block";
            loginbtn.style.display = "none";
            signupbtn.style.display = "none";
            welc.textContent= `Welcome ${firstName || name} Enjoy your stay`
            info.innerHTML= `Mobile: ${mobile} <br>
            Email: ${user}`
            topwelc.textContent = 'Welcome ! You are now signed in to your account.'
        } else {
            logoutbtn.style.display = "none";
            loginbtn.style.display = "inline-block";
            signupbtn.style.display = "inline-block";
            
            topwelc.textContent = 'Sign in to continue in our site'
        }

        logoutbtn.addEventListener('click', (e) => {
            e.preventDefault();
            fetch('', {
                method: 'POST',
                body: 'logout=true'
            }).then(() => {
                logoutbtn.style.display = "none";
                loginbtn.style.display = "inline-block";
                signupbtn.style.display = "inline-block";
                isloged = false;
                window.location.href = 'logout.php'
            });
       
        });
</script>
</html>