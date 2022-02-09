<?php
if (session_status() <> PHP_SESSION_ACTIVE) session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] == 0 ) {
    header("Location:Unit5_index.php?err=Must log in first");
} else if ($_SESSION['role'] < 2) {
    header("Location:Unit5_index.php?err=You are not authorized for that page!");
}
include_once('Unit5_header.php');
include('Unit5_database.php');
date_default_timezone_set("America/Denver");
$conn = getConnection($servername, $username, $password, $dbname);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>




<body>

    <section>

        <div id=left >
            <p>Games/Toys</p>
            <span id="puzzleDisplay" onload="loadProductTable()"> </span>
            

        </div>

        <div id=right>
            
            <span id='header'> Product Information </span>
            <br></br>
            <p id ='alertMaker'></p>

            <form>
                <input type="hidden" id=productNameOriginal name="productNameOriginal" value="">
                <label for="gameName">Game Name: *</label><br>
                <input type="text" id="gameName" name="gameName" value="" required pattern="[a-zA-Z' ]+" ><br>

                <label for="gameImage">Game Image: *</label><br>
                <input type="text" id="gameImage" name="gameImage" value="" required pattern="[a-zA-Z' ]+"><br>

                <label for="quantity">Quantity :</label>
                <input type="number" id="quantity" name="quantity" min="0" max="100" required  value=0>
                <br><br>
                <label for="price">Price: *</label>
                <input type="text" id="price" name="price" value="" required><br><br>

                <label for="inactive">Make Inactive: *</label>
                <input type="hidden" id="inactiveHidden" name="inactive" value="No">
                <input type="checkbox" id="inactive" name="inactive" value="Yes" required>
                <br></br>
                
                <input type="hidden" name="dateAdded" value="<?php echo time(); ?>">

                <input type="button" id="add" value="Add">
                <input type="button" id="update" value="Update">
                <input type="button" id="delete" value="Delete">
            </form>
        </div>

    </section>

</body>



<script>
    // var productID;
    $(document).ready(function() {
        const xmlhtt = new XMLHttpRequest();
        xmlhtt.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("puzzleDisplay").innerHTML = this.responseText;
                gameHighlight_row();
            }
        };
    xmlhtt.open("POST", "Unit5_get_game_table.php");
    xmlhtt.send();
});

function gameHighlight_row() {
    var table = document.getElementById('game-table');
    var cells = table.getElementsByTagName('td');

    for (var i = 0; i < cells.length; i++) {
        // Take each cell
        var cell = cells[i];
        // do something on onclick event for cell
        cell.onclick = function() {
            // Get the row id where the cell exists
            var rowId = this.parentNode.rowIndex;

            var rowsNotSelected = table.getElementsByTagName('tr');
            for (var row = 0; row < rowsNotSelected.length; row++) {
                rowsNotSelected[row].style.backgroundColor = "";
                rowsNotSelected[row].classList.remove('selected');
            }
            var rowSelected = table.getElementsByTagName('tr')[rowId];
            rowSelected.style.backgroundColor = "yellow";
            rowSelected.className += " selected";
            

            
            $('#gameName').val(rowSelected.cells[0].innerHTML);
            $('#productNameOriginal').val(rowSelected.cells[0].innerHTML);
            $('#gameImage').val(rowSelected.cells[1].innerHTML);
            $('#price').val(rowSelected.cells[2].innerHTML);
            $('#quantity').val(rowSelected.cells[3].innerHTML);
            if (rowSelected.cells[4].innerHTML == "Yes") {
                $('#inactive').prop('checked', true);
            } else {
                $('#inactive').prop('checked', false);
            }

        }
    }
    
}

$(document).ready(function() {
    
    $("#add").click(function(e) {
        e.preventDefault();
        checkFieldsandAjax("Unit5_adminCreateProduct.php");
    });

    $("#update").click(function(e) {
        e.preventDefault();
        checkFieldsandAjax("Unit5_adminUpdateProduct.php");
    });

    $("#delete").click(function(e) {
        e.preventDefault();
        // var $orderCheck = 
        // console.log($orderCheck);
        checkOrders($('#productNameOriginal').val());
        // if () != false) {
        //     // $('#alertMaker').text("There are orders on this product, we cannot delete!");
        // } else {
            
        // }

        
    });
});

function checkFieldsandAjax($ajaxFileName) {
        var gameName = $("#gameName").val();
        var gameImage = $("#gameImage").val();
        var price = $("#price").val();
        var inactive = $("#inactive").val();
        var quality = $("#quality").val();
        //creating the add and checking fields
        if (gameName == '') {
            $('#alertMaker').text("Game Name input is Missing!");
        } else if (gameImage == '') {
            $('#alertMaker').text("Game Image input is Missing!");
        } else if (price == '') {
            $('#alertMaker').text("Price input is Missing!");
        } else if (quality == 0) {
            $('#inactive').prop('checked', true);
            var inactive = $("#inactive").val();
        } else if (inactive != "Yes") {
            $('#inactive').prop('checked', false);
            inactive = $("#inactive").val();
        } else {
            // AJAX Code To Submit Form.
            var formData = $('form').serialize();
            $.ajax({
                type: "POST",
                url: $ajaxFileName,
                data: formData,
                cache: false,
                success: function resetForm() {
                    $('form').trigger("reset");
                    location.reload();
                }
            });
        }
        return false;
}

function checkOrders(selection) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            if (this.responseText == 1) {
                $('#alertMaker').text("There are orders on this product, we cannot delete!");
            } else {
                if (window.confirm('Are you sure you would like to delete this product?')) {
                    checkFieldsandAjax("Unit5_adminDeleteProduct.php");
                } 
            }
        }

    };
    xhttp.open("GET", "Unit5_checkOrders.php?productName=" + selection, true);
    xhttp.send();
}

</script>


<?php
include('Unit5_footer.php');
?>