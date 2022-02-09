<?php
include('Unit5_database.php');
$conn = getConnection($servername, $username, $password, $dbname);
//Fetching Values from URL
$gameName=$_POST['gameName'];
$gameImage=$_POST['gameImage'];
$price=$_POST['price'];
$inactive=$_POST['inactive'];
$quantity=$_POST['quantity'];


addProduct($conn, $gameName, $gameImage, $price, $quantity, $inactive);



?>