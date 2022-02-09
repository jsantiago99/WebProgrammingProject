<?php
include_once('Unit5_header.php');
include('Unit5_database.php');



?>




<body>

    <div id="purchaseCard">

        <?php
        $conn = getConnection($servername, $username, $password, $dbname);
        function makeOrder($conn, $name)
        {
            $data = getProductChosen($conn, $name);
            $row = $data->fetch_row();
            $order = "We hope you enjoy your <u><span id='chosenGame'>" . $row[1] . "</span></u>!!!" . "<br>";
            echo $order;
            echo "<p id='order'> Order details:</p>";
            $subTotalCalc = $_POST["quantity"] * $row[3];
            $taxTotal = ($subTotalCalc * 0.0075);
            $calcTax =  $taxTotal + $subTotalCalc;
            echo "<p id='p1'>" . $_POST["quantity"] . " @ " .  $row[3] . ": " . "$" . $subTotalCalc . "</p>";
            echo "<p id='p2'>Tax: " . "$" . number_format((float)$taxTotal, 2, '.', '') . "</p>";
            echo "<p id='p3'>Subtotal: " . "$" . number_format((float)$calcTax, 2, '.', '') . "</p>";
            if ($_POST["round_up"] == "true") {
                $donationTotal = ceil($calcTax);
                $donation = "<p id='p4'>Total with Donation: " . "$" . $donationTotal . "</p>";
                $donationAmount = $donationTotal - $calcTax;
                echo $donation;
            } else {
                $donationAmount = 0;
            }
            echo "We'll send special offers to " . $_POST["email"] . "!!!";
            addOrder($conn, $row[1], $_POST["email"], $_POST["quantity"], $taxTotal, $donationAmount, $_POST["dateAdded"]);
            echo "<p id='viewHistory' hidden> Based on your viewing history, we'd like to offer 20% off these items:</p>";
            echo "<p id='selectedGame' hidden>" . $_POST["games"] . "</p>";
            echo "<span id=itemList></span>";
        }

        $customer = checkCustomer($conn, $_POST["email"]);
        $row = $customer->fetch_row();

        if ($row[0] == 1) {
            $greeting = "<p> <span id='intro'>Hello "  . $_POST["fname"] . " " . $_POST["lname"] .  "</span> <em>- Welcome Back!</em></p>";
            echo $greeting;
            makeOrder($conn, $_POST["games"]);
        } else {
            addCustomer($conn, $_POST["fname"], $_POST["lname"], $_POST["email"]);
            $greeting = "<p><span id='intro'>Hello "  . $_POST["fname"] . " " . $_POST["lname"] .  "</span> <em>- Welcome New Customer!</em></p>";
            echo $greeting;
            makeOrder($conn, $_POST["games"]);
        }

        ?>

    </div>
    <br>
    <script>
        findItems();

        function findItems() {
            var json_str = getCookie("itemsViewed");
            var cookieArray = JSON.parse(json_str);
            console.log(document.getElementById("selectedGame").textContent);
            var gameChosen = document.getElementById("selectedGame").textContent;
            var index = cookieArray.indexOf(document.getElementById("selectedGame").textContent.substring(0, gameChosen.length - 4));
            if (index > -1) {
                cookieArray.splice(index, 1);
            }
            if (cookieArray.length != 0) {
                document.getElementById("viewHistory").style.display = "block";
                var ul = document.createElement('ul');
                for (var i = 0; i < cookieArray.length; i++) {
                    var obj = cookieArray[i];
                    var li = document.createElement('li');
                    li.appendChild(document.createTextNode(obj));
                    ul.appendChild(li);
                    
    
                }
                document.getElementById("itemList").append(ul);
            }
        }


        function getCookie(name) {
            // Split cookie string and get all individual name=value pairs in an array
            var cookieArr = document.cookie.split(";");

            // Loop through the array elements
            for (var i = 0; i < cookieArr.length; i++) {
                var cookiePair = cookieArr[i].split("=");

                /* Removing whitespace at the beginning of the cookie name
                and compare it with the given string */
                if (name == cookiePair[0].trim()) {
                    // Decode the cookie value and return
                    return decodeURIComponent(cookiePair[1]);
                }
            }

            // Return null if not found
            return null;
        }
    </script>



</body>







<?php
include('Unit5_footer.php');
?>