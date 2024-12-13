<?php

if (isset($_POST['add_product']) && isset($_POST['productname'])) {
    $productname = mysqli_real_escape_string($con, $_POST['productname']);
    $default_stock = 0;

    $sql_check = "SELECT * FROM products WHERE productname = '$productname'";
    $result_check = mysqli_query($con, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        $_SESSION['error'] = "<strong>&#10071; Product with this name already exists.</strong>";
        header("Location: stock.php");
        exit;
    } else {
        // Insert without productid (auto-incremented)
        $sql_insert = "INSERT INTO products (productname, productstocks) VALUES ('$productname', '$default_stock')";
        
        if (mysqli_query($con, $sql_insert)) {
            $productid = mysqli_insert_id($con); // Get the auto-incremented productid
            $sql_log_movement = "INSERT INTO stock_movements (productid, stock_change) VALUES ('$productid', '$default_stock')";
            mysqli_query($con, $sql_log_movement);
            $_SESSION['success'] = "<strong>&#127881; Product Added Successfully!</strong>";
            header("Location: stock.php");
            exit;
        } else {
            $_SESSION['error'] = "<strong>&#10071; Error Adding Product.</strong>";
            header("Location: stock.php");
            exit;
        }
    }
}

$search_query = "";
if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($con, $_GET['search']);
    $sql = "SELECT productid, productname, productstocks FROM products WHERE productid LIKE '%$search_query%' OR productname LIKE '%$search_query%' ORDER BY productname ASC";
}
else {
    $sql = "SELECT productid, productname, productstocks FROM products ORDER BY productstocks ASC";
}

$result = mysqli_query($con, $sql);