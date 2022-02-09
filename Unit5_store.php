<?php
ini_set('display_errors', 'Off');
include_once('Unit5_header.php');
include('Unit5_database.php');
date_default_timezone_set("America/Denver");

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>




<body onload="clearItems()">

    <section>
        <aside>

            <div name="image_input">
                <p>Select a puzzle to see image</p>
                <img id="imageUsed" src="" alt="" width="300" height="300" />
                <h3 id="stockLeft">AMOUNT</h3>
            </div>

        </aside>

        <span id='header'> Personal Information </span>
        <br></br>

        <form action="Unit5_process_order.php" method="post">
            <label for="fname">First name: *</label><br>
            <input type="text" id="fname" name="fname" value="" required pattern="[a-zA-Z' ]+"><br>

            <label for="lname">Last name: *</label><br>
            <input type="text" id="lname" name="lname" value="" required pattern="[a-zA-Z' ]+"><br>

            <label for="email">Email: *</label><br>
            <input type="email" id="email" name="email" value="" required><br><br>





            <span id='header'> Product Information </span>
            <br></br>

            <label for="games">Select a game or toy:</label>
            <?php
            $conn = getConnection($servername, $username, $password, $dbname);
            $data = getProducts($conn);
            echo "<select id='games' name='games' required>";
            echo "<option value='' disabled selected>Choose a game or toy</option>";
            foreach ($data as $row) :
                if ($row['inactive'] != 1) {
                    echo "<option value='{$row['image_name']}' in-stock='{$row['in_stock']}'>{$row['product_name']} @ {$row['price']}</option>'";
                }
            endforeach;
            ?>
            </select>
            <br></br>
            <label for="quantity">Quantity :</label>
            <input type="number" id="quantity" name="quantity" min="1" max="100" required>




            <p>Round up to the nearest dollar for a donation?</p>

            <input type="radio" id="true" name="round_up" value="true" checked>
            <label for="true">Yes</label><br>
            <input type="radio" id="false" name="round_up" value="false">
            <label for="false">No</label><br>

            <input type="hidden" name="dateAdded" value="<?php echo time(); ?>">


    </section>

    <input type="submit" value="Purchase">
    </form>

    <script>
        var arrayViewed = [];
        $("#games").on('change', function() {
            var gameChosen = $(this).val();
            // $("#imageUsed").attr('src', "imgs/" + gameChosen + ".jpg");
            $("#imageUsed").attr('src', "imgs/" + gameChosen);
            

            var quantityLeft = $("#games option:selected").attr('in-stock');
            if (quantityLeft == 0) {
                $("#stockLeft").show();
                $("#stockLeft").text('SOLD OUT');
            } else if (quantityLeft < 5) {
                $("#stockLeft").show();
                $("#stockLeft").text('ONLY ' + quantityLeft + ' LEFT!!!');
            } else {
                $("#stockLeft").hide();
            }
            
            if (!arrayViewed.includes(gameChosen.substring(0, gameChosen.length - 4))) {
                arrayViewed.push(gameChosen.substring(0, gameChosen.length - 4));
            }

            var json_str = JSON.stringify(arrayViewed);
            
            setCookie("itemsViewed", json_str, 1);
        
        });

        function setCookie(name, value, daysToLive) {
            // Encode value in order to escape semicolons, commas, and whitespace
            var cookie = name + "=" + encodeURIComponent(value);

            if (typeof daysToLive === "number") {
                /* Sets the max-age attribute so that the cookie expires
                after the specified number of days */
                cookie += "; max-age=" + (daysToLive * 24 * 60 * 60);

                document.cookie = cookie;
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

        function clearItems() {
            const newArray = [];
            var json_str = JSON.stringify(newArray);
            setCookie("itemsViewed", json_str);
        }
    </script>




</body>

<?php
include('Unit5_footer.php');
?>