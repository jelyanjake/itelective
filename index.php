<?php    

session_start();
include('func/connection.php');  
$con = OpenCon();

// Include the Auth class
include('func/auth.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $auth = new Auth($con); // Create an Auth object
        if ($auth->login($username, $password)) {
            header("Location: dashboard.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "<strong>&#10071; " . $e->getMessage() . "</strong>";
        header("Location: index.php");
        exit();
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