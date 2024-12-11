<?php

$currentusername = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$currentlevel = isset($_SESSION['level']) ? $_SESSION['level'] : 1;
if ($currentlevel == 2) {
    $role = "Admin";
} else {
    $role = "User";
}

if (isset($_POST['username']) && $currentlevel == 2) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $check_user_query = "SELECT * FROM users WHERE user = '$username'";
    $check_user_result = mysqli_query($con, $check_user_query);
    
    if (mysqli_num_rows($check_user_result) > 0) {
        $_SESSION['error'] = "<strong>&#10071; Username already taken.</strong>";
        header("Location: user.php");
        exit;
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $level = mysqli_real_escape_string($con, $_POST['level']);
        $sql = "INSERT INTO users (`user`, `password`, `level`) VALUES ('$username', '$password', '$level')";

        if (mysqli_query($con, $sql)) {
            $_SESSION['success'] = "<strong>&#127881; User added successfully!</strong>";
            header("Location: user.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }
}

if ($currentlevel == 2) {
    $searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

    if (!empty($searchTerm)) {
        $sql = "SELECT id, `user`, `level` FROM users WHERE `user` LIKE '%$searchTerm%'";
    }
    else {
        $sql = "SELECT id, `user`, `level` FROM users";
    }

    $result = mysqli_query($con, $sql);
}