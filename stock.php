<?php

session_start();
include('func/connection.php');
include('func/auth.php');
include('func/validate.php');
$con = OpenCon();
include('func/stockfunc.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style2.css">
    <title>Blossom IS - Stocks</title>
    <link rel="icon" type="image/x-icon" href="img/icon.ico">
    <style>
        .csearch > input, .csearch > button {
            width:200px
        }

        .csearch {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .addp {
            display:inline-flex;
            width:508px;
        }
    </style>
</head>
<body>
<main>
    <div class="contentinsidebg" style="border-radius: 25px;">
        <p><?php echo "<strong>[$role]</strong>"?>&nbsp;Welcome, <?php echo htmlspecialchars(ucwords($username));?>!</p>
            <div class="navbar">
                <div class="logo">
                &#127800; Blossom IS
                </div>
                <div class="nav-container">
                    <div class="nav-links">
                        <a href="dashboard.php"><button>Inventory</button></a>
                        <a href="user.php"><button>Users</button></a>
                        <a href="stock.php"><button>Stocks</button></a>
                        <a href="report.php"><button>Report</button></a>
                    </div>
                </div>
            </div>
            <div class="container">

            <?php
            if (isset($_SESSION['error'])) {
                echo "<p style='color:#ff9800;text-align:center'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']); // Clear the error message
            }

            if (isset($_SESSION['success'])) {
                echo "<p style='color:#55f477;text-align:center'>" . $_SESSION['success'] . "</p>";
                unset($_SESSION['success']); // Clear the success message
            }
            ?>

            <?php
            if ($level == 2):
            ?>
            <h2 style="text-align:center">Stock Management Panel [Admin]</h2>
            <form class="addp" method="POST" action="stock.php">
                <div>
                    <label for="productname">Product Name:</label>
                    <input class="addp" type="text" id="productname" name="productname" required>
                </div>
                <div>
                    <label>&nbsp;</label>
                    <input class="addp" type="submit" name="add_product" value="Add Product">
                </div>
            </form>
                <br>
                <br>
                <hr>
                <h3 style="text-align:center">Product List</h3>
                <form class="csearch" action="stock.php" method="GET">
                    <input type="text" name="search" placeholder="Search by ID or Name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    <button type="submit">Search &#128269;</button>
                </form>
                <br>
                <table>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name &#128230;</th>
                        <th>Quantity</th>
                        <th>&nbsp;</th>
                    </tr>

                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $row['productid'] . "</td>
                                    <td>" . $row['productname'] . "</td>
                                    <td>" . $row['productstocks'] . "</td>
                                    <td>
                                        <a href='editproduct.php?id=" . $row['productid'] . "'><button type='button'>Edit</button></a>
                                        <form method='POST' action='' style='display:inline;'>
                                        <a href='confirmdeleteprd.php?id=" . $row['productid'] . "&name=" . urlencode($row['productname']) . "'><button name='Delete' type='button'>Delete</button></a>
                                        </form>
                                    </td>
                                  </tr>";
                        }
                    }
                    else {
                        echo "<tr><td colspan='4'>No products found</td></tr>";
                    }
                    ?>

                </table>

        <?php else: ?>
            <br>
            <p style="text-align:center">&#128274; You do not have permission to view this page.</p>
        <?php endif; ?>

            </div>
            <br>
            <br>
            <br>
            <a href="func/logout.php"><button>Log out</button></a>
    </div>
</main>
</body>
</html>

<?php
CloseCon($con);
?>
