<?php
include('Unit5_database.php');
$conn = getConnection($servername, $username, $password, $dbname);
//Fetching Values from URL
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$customerEmail=$_POST['email'];
$productName=$_POST['games'];
$quantity=$_POST['quantity'];


function makeOrder($conn, $productName, $fname, $lname, $customerEmail,  $quantity) {
    $data = getProductChosen($conn,$productName);
    $row = $data -> fetch_row();
    $subTotalCalc = $_POST["quantity"] * $row[3];
    $taxTotal = ($subTotalCalc * 0.0075);
    $calcTax =  $taxTotal + $subTotalCalc;
    addOrder($conn, $row[1], $_POST["email"], $_POST["quantity"], $taxTotal, 0, $_POST["dateAdded"]);
    echo "Order Submitted for: " . $fname . " " . $lname . " " . $quantity . " ". $row[1] . " Total is $" . $calcTax . "</p>";
}


$customer = checkCustomer($conn, $customerEmail);
$row = $customer->fetch_row();

if ($row[0] == 1) {
    
    makeOrder($conn, $productName, $fname, $lname, $customerEmail, $quantity);
    
} else {
    addCustomer($conn, $_POST["fname"], $_POST["lname"], $_POST["email"]);
    
    makeOrder($conn, $productName, $fname, $lname, $customerEmail, $quantity);
}



?>