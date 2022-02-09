<?php
if (session_status() <> PHP_SESSION_ACTIVE) session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] == 0 ) {
    header("Location:Unit5_index.php?err=Must log in first");
}
include_once('Unit5_header.php');
include('Unit5_database.php');
date_default_timezone_set("America/Denver");

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>




<body>

    <section>

        <div id=left>
            <span id='header'> Personal Information </span>
            <br></br>

            <form >
                <label for="fname">First name: *</label><br>
                <input type="text" id="fname" name="fname" value="" required pattern="[a-zA-Z' ]+" onkeyup="showHint(this.value, 'first')"><br>

                <label for="lname">Last name: *</label><br>
                <input type="text" id="lname" name="lname" value="" required pattern="[a-zA-Z' ]+" onkeyup="showHint(this.value, 'last')"><br>

                <label for="email">Email: *</label><br>
                <input type="email" id="email" name="email" value="" required><br><br>







                <span id='header'> Product Information </span>
                <br></br>

                <label for="games">Select a game or toy:</label>
                <?php
                $conn = getConnection($servername, $username, $password, $dbname);
                $data = getProducts($conn);
                echo "<select id='games' name='games' required >";
                echo "<option value='select' disabled selected>Choose a game or toy</option>";
                foreach ($data as $row) :
                    echo "<option value='{$row['image_name']}' in-stock='{$row['in_stock']}'>{$row['product_name']} @ {$row['price']}</option>'";
                endforeach;
                ?>
                </select>
                <br></br>
                <label for="available">Available :</label>
                <input type="text" id="available" name="Avaliability" value="" readonly>
                <br></br>
                <label for="quantity">Quantity :</label>
                <input type="number" id="quantity" name="quantity" min="1" max="100" required>


                <input type="hidden" name="dateAdded" value="<?php echo time(); ?>">





                <input type="submit" id="submit" value="Purchase">
                <input type="reset" value="Clear Fields" id=resetButton>
            </form>
        </div>

        <div id=right>
            <p>Choose an existing customer</p>
            <span id="txtHint"> </span>
            <span id="orderPlaced" class="orderPlaced"></span>
        </div>

    </section>

</body>



<script src="Unit5_script.js?v=<?php echo time(); ?>""></script>


<?php
include('Unit5_footer.php');
?>