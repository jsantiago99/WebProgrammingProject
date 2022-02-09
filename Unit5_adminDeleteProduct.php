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

deleteProduct($conn, $productID);







?>