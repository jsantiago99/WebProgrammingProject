<?php
include('Unit5_database.php');
$conn = getConnection($servername, $username, $password, $dbname);


createGameTable($conn);


?>