<?php
if (session_status() <> PHP_SESSION_ACTIVE) session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] == 0 ) {
    header("Location:Unit5_index.php?err=Must log in first");
}
include_once('Unit5_header.php');
include('Unit5_database.php');
date_default_timezone_set("America/Denver");

?>





<body>
    <div id="tables">
        <?php
        $conn = getConnection($servername, $username, $password, $dbname);

        $dataCustomer = displayCustomerTable($conn);
        echo "<h4> Customers </h4>";
        echo "<table>";
        echo "<tr><th>" . "First Name" . "</th><th>" . "Last Name" . "</th><th>" . "Email" . "</th></tr>";
        while ($row = $dataCustomer->fetch_array()) {
            echo "<tr><td>" . $row['first_name'] . "</td><td>" . $row['last_name'] . "</td><td>" . $row['email'] . "</td></tr>";
        }
        echo "</table>";


        $dataOrder = displayOrderTable($conn);
        $countOrders = checkCountOrders($conn);
        $check = $countOrders->fetch_row();

        if ($check[0] > 0) {
            echo "<h4> Orders </h4>";
            echo "<table>";
            echo "<tr><th>" . "First Name" . "</th>";
            echo "<th>" . "Last Name" . "</th>";
            echo "<th>" . "Game/Toy" . "</th>";
            echo "<th>" . "Date" . "</th>";
            echo "<th>" . "Quantity" . "</th>";
            echo "<th>" . "Price" . "</th>";
            echo "<th>" . "Tax" . "</th>";
            echo "<th>" . "Donation" . "</th>";
            echo "<th>" . "Total" . "</th></tr>";
            while ($row = $dataOrder->fetch_array()) {
                echo "<tr><td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['product_name'] . "</td>";
                echo "<td>" . date('m/d/Y H:i:s', $row['timestamp']) . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['tax'] . "</td>";
                echo "<td>" . $row['donation'] . "</td>";
                echo "<td>" . number_format((float)($row['price'] +  $row['tax'] + $row['donation']), 2, '.', '') . "</td>";
            }
            echo "</table>";
        } else {
            echo "<h4> Orders </h4>";
            echo "<p> No Orders at the Moment </p>";
        }

        $dataProduct = displayProductTable($conn);
        echo "<h4> Products </h4>";
        echo "<table>";
        echo "<tr><th>" . "Product Name" . "</th><th>" . "Quantity" . "</th><th>" . "Price" . "</th></tr>";
        while ($row = $dataProduct->fetch_array()) {
            echo "<tr><td>" . $row['product_name'] . "</td><td>" . $row['in_stock'] . "</td><td>" . $row['price'] . "</td></tr>";
        }
        echo "</table>";



        ?>


    </div>
</body>







<?php
include('Unit5_footer.php');
?>