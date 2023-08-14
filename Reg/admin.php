<?php
session_start();

# Check if user is logged in and is an admin
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["isAdmin"]) || $_SESSION["isAdmin"] !== true) {
    echo "<script>" . "window.location.href='./login.php';" . "</script>";
    exit;
}

require "config.php";

$userList = array(); // To store user data

if ($link) {
    $sql = "SELECT id, username, mobile, email, password, createdate FROM form";

    $result = mysqli_query($link, $sql);
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $userList[] = $row;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
   
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Admin Page</h1>
        <p class="text-center">Welcome, <?php echo $_SESSION['FullName']; ?>! You are logged in as an admin.</p>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Password (Hashed)</th>
                        <th>Creation Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userList as $user) : ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['mobile']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['password']; ?></td>
                            <td><?php echo $user['createdate']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <p class="text-center"><a href="logout.php">Log Out</a></p>
    </div>
</body>
</html>