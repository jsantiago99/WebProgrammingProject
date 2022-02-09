<?php
    // ini_set('display_errors', 'Off');
    include_once('Unit5_header.php');
    include('Unit5_database.php');
    date_default_timezone_set("America/Denver");
    if(!isset($_SESSION['role'])) {
        $_SESSION['role'] = 0;
        $_SESSION['first_name'] = "";
    }
?>
    
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<body>

    <section id= loginSec>
    

    <p id=loginWelcome> Welcome! Please login or select Continue as Guest to begin.
    <?php
    if (isset($_GET['err'])) {
        echo "<span id=errorChecker>  " . $_GET['err'] ."</span></p>";
    }
    ?>

        <form action="Unit5_login.php" method="post">
            <label for="email" id=emailLabel>Email </label><br>
            <input type="email" id="email" name="email" value="" placeholder="Enter Email" required ><br>

            <label for="password" id=passwordLabel>Password</label><br>
            <input type="password" id="password" name="password" value="" placeholder="Enter Password" required><br><br>
            
            <input type="submit" id="loginButton"value="Login"><br>
            
            <label for="inactive" id=rememberLabel>Remember Me</label>
            <input type="hidden" id="remembermeHidden" name="rememberme" value="No">
            <input type="checkbox" id="rememberme" name="rememberme" value="Yes"> 

            <a href="url" id=forgotPassword>Forgot Password?</a>
        </form>

    </section>

    <a href="Unit5_store.php"><button id=guest>Continue as Guest</button></a>

    

    <script>
        


        
        

        
    </script>




</body>

<?php
include('Unit5_footer.php');
?>