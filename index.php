<?php    

session_start();
include('func/connection.php');  
$con = OpenCon();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    
    $sql = "SELECT * FROM users WHERE user = '$username'";
    $result = mysqli_query($con, $sql);
    
    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $row['user'];
            $_SESSION['level'] = $row['level'];
            header("Location: dashboard.php");
            exit;
        }
        
        else {
            $_SESSION['error'] = "<strong>&#10071; Invalid username or password.</strong>";
            header("Location: index.php");
            exit;
        } 
    }
        
    else {
        $_SESSION['error'] = "<strong>&#10071; Invalid username or password.</strong>";
        header("Location: index.php");
        exit;
    }
}
    
CloseCon($con);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Blossom IS - Login</title>
    <link rel="icon" type="image/x-icon" href="img/icon.ico">
</head>
<body>
<main>
    <br>
    <br>
    <br>
    <div class="contentinsidebg" style="border-radius: 25px;">
    <form action="index.php" method="post">
        <h1>Welcome to Blossom IS &#127800;</h1>
        <br>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p style='color:#ff9800;text-align:center'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Enter username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter password" required>
        </div>
        <br>
        <button type="submit">Login</button>
    </form>
    <footer><p style="text-align:center">Don't have an account? <a href="register.php">Register</p></footer>
    </div>
</main>
</body>
</html>