<?php
session_start();
$_SESSION = array();



session_unset();
session_destroy();
header("Location:Unit5_index.php");
exit();

?>

