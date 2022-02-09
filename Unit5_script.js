$("#games").on('change', function() {
    var gameChosen = $(this).val();
    showAvaliable(gameChosen);

});

function showAvaliable(selection) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            document.getElementById("available").value = this.responseText;
        }

    };
    xhttp.open("GET", "Unit5_get_quantity.php?product_id=" + selection, true);
    xhttp.send();
}

function showHint(str, choice) {
    const xmlhttp = new XMLHttpRequest();
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
                $('#orderPlaced').empty();
                highlight_row();
            }
        };
    }
    xmlhttp.open("REQUEST", "Unit5_get_customer_table.php?q=" + str + "&f=" + choice);
    xmlhttp.send();
}


function highlight_row() {
    var table = document.getElementById('customer-table');
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

            $('#fname').val(rowSelected.cells[0].innerHTML);
            $('#lname').val(rowSelected.cells[1].innerHTML);
            $('#email').val(rowSelected.cells[2].innerHTML);
        }
    }
}

$(document).ready(function() {
    $("#submit").click(function(e) {
        e.preventDefault();
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var email = $("#email").val();
        var productSelection = document.getElementById("games");
        var product = productSelection.options[productSelection.selectedIndex].value;
        var quantity = $("#quantity").val();

        // Returns successful data submission message when the entered information is stored in database.
        var dataString = 'fname1=' + fname + '&lname1=' + lname + '&email1=' + email + '&product1=' + product + '&quantity1=' + quantity;
        if (fname == '' || lname == '' || email == '') {
            alert("Please Fill All Fields");
        } else if (product == 'select') {
            alert("Must Select a Puzzle");
        } else if ($("#quantity").val() > $("#available").val()) {
            alert("Quantity Entered (" + $('#quantity').val() + ") is greater than avaliable (" + $('#available').val() + ")");
        } else if ($("#quantity").val() == '') {
            alert("Enter Quantity");
        } else {
            // AJAX Code To Submit Form.
            var formData = $('form').serialize();
            $.ajax({
                type: "POST",
                url: "Unit5_ajaxsubmit.php",
                data: formData,
                cache: false,
                success: function displayOrderConfirm(result) {

                    document.getElementById("orderPlaced").innerHTML = result;
                    $('form').trigger("reset");
                    $('#customer-table').empty();
                }
            });
        }
        return false;
    });
});