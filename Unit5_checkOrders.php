<?php
include('Unit5_database.php');
$selection = $_GET['productName'];
$conn = getConnection($servername, $username, $password, $dbname);

$productID = getProductID($conn, $selection);

$orderCount = checkOrderByProductID($conn, $productID);

if ($orderCount == 0) {
    echo false;
} else {
    echo true;
}


?>
