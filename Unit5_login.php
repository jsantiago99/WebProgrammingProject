<?php
include_once('Unit5_header.php');
include('Unit5_database.php');
$conn = getConnection($servername, $username, $password, $dbname);



 if (checkUserInput($conn,$_POST['email'], $_POST['password'] )) {
    //set session variables for role and first name
    $result = getUser($conn,$_POST['email'], $_POST['password']);
    $data = $result -> fetch_row();
    $_SESSION['role'] = $data[5];
    $_SESSION['first_name'] = $data[1];
    // echo $_SESSION['role'] . " " . $_SESSION['first_name'];

    if ($_SESSION['role'] == 1) {
        $_SESSION['first_name'] = $data[1];
        header("Location:Unit5_order_entry.php");
        
    } else if ($_SESSION['role'] == 2) {
        $_SESSION['first_name'] = $data[1];
        header("Location:Unit5_adminProduct.php");
        
    }
} else {
        header("Location:Unit5_index.php?err=Invalid User");
        
}
?>


<?php
// include('Unit5_footer.php');
?>