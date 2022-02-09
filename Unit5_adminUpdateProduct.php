<?php
include('Unit5_database.php');
$conn = getConnection($servername, $username, $password, $dbname);
//Fetching Values from URL
$gameName=$_POST['gameName'];
$gameImage=$_POST['gameImage'];
$price=$_POST['price'];
$inactive1=$_POST['inactive'];
$quantity=$_POST['quantity'];
$productNameID=$_POST['productNameOriginal'];

$productID = getProductID($conn, $productNameID);


if ($inactive1 == "No") {
    $inactive = 0;
} else {
    $inactive = 1;
}

updateProduct($conn, $gameName, $gameImage, $price, $quantity, $inactive, $productID);



?>