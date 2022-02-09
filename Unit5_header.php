<?php
    
    ini_set('display_errors', 'Off');
    session_start();
    

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <link rel="stylesheet" href="Unit5_common.css?v=<?php echo time(); ?>">
    
    <link rel="stylesheet" href="Unit5_store.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="Unit5_process_order.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="Unit5_admin.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="Unit5_order_entry.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="Unit5_adminProduct.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="Unit5_login.css?v=<?php echo time(); ?>">



    
	
</head>
<header>



<?php
    //customer service is role 1, primary page order entry and can also do admin page
    //admin is role 2. primary page is priducts and can access all pages
    //end user, no login, primary page is store
    if ($_SESSION['role'] == 1) {
        echo "<ul class='topnav'>"; 
        echo "<a href='Unit5_index.php' id=homePage>Home</a>";
        echo "<a href='Unit5_order_entry.php' id=orderPage>Order Entry</a>";
        echo "<a href='Unit5_admin.php' id = admin>Admin</a>";
        echo "<li style = 'float:right'><a href='Unit5_logout.php'>Logout</a></li>";
        echo "</ul>";
        echo "<h1>Games, Toys, and Fun!!!</h1>";
        echo "<h3>Get the best entertainment around!</h3>";
        echo "<h4>Welcome, " . $_SESSION['first_name'] . "</h4>";
        // echo "<h4>Welcome, <span id=userNameInsert></span></h4>";
        

    } else if ($_SESSION['role'] == 2) { 
        echo "<ul class='topnav'>"; 
        echo "<a href='Unit5_index.php' id=homePage>Home</a>";
        echo "<a href='Unit5_store.php' id=storePage>Store</a>";
        echo "<a href='Unit5_order_entry.php' id=orderPage>Order Entry</a>";
        echo "<a href='Unit5_admin.php' id = admin>Admin</a>";
        echo "<a href='Unit5_adminProduct.php' id=productPage>Products</a>";
        echo "<li style = 'float:right'><a href='Unit5_logout.php'>Logout</a></li>";
        echo "</ul>";
        echo "<h1>Games, Toys, and Fun!!!</h1>";
        echo "<h3>Get the best entertainment around!</h3>";
        echo "<h4>Welcome, " . $_SESSION['first_name'] . "</h4>";
  
    } else {
        echo "<ul class='topnav'>"; 
        echo "<a href='Unit5_index.php' id=homePage>Home</a>";
        echo "<a href='Unit5_store.php' id=storePage>Store</a>";
        echo "<li style = 'float:right'><a href='Unit5_logout.php'>Logout</a></li>";
        echo "</ul>";
        echo "<h1>Games, Toys, and Fun!!!</h1>";
        echo "<h3>Get the best entertainment around!</h3>";
    }
    
?>


   

</header>
</html>