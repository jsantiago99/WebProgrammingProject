
<?php
include('Unit5_database.php');
$selection = $_GET['product_id'];
$conn = getConnection($servername, $username, $password, $dbname);

$data = getQuantity($conn, $selection);
$row = $data -> fetch_row();
echo $row[0];


?>

