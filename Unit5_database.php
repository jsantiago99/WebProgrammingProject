<?php
include ('Unit5_database_credentials.php');
function getConnection($servername, $username, $password, $dbname) {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
  
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
    //echo "Connected successfully";
}

/* test function to show PHP/HTML */
function getCustomers($conn) {
    $sql = "select * from customer";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function getProductChosen($conn, $productName) {
    $sql = "SELECT * FROM product WHERE image_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}
function findCustomer($conn, $customerEmail) {
    $sql = "SELECT * FROM customer WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $customerEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function getProducts($conn) {
    $sql = "select * from product";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function checkCustomer($conn, $customerEmail) {
    $sql = "SELECT COUNT(*) FROM customer WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $customerEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function checkOrder($conn, $productName, $customerEmail, $timestamp) {
    //check customer, product and timestamp
    $sql = "SELECT COUNT(*) FROM orders WHERE (product_id=(SELECT id from product WHERE product_name=?) AND customer_id=(SELECT id from customer WHERE email=?) AND timestamp=?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $productName, $customerEmail, $timestamp);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result;
}

function addOrder($conn, $productName, $customerEmail, $quantity, $tax, $donationAmount, $timestamp) {
    $data = checkOrder($conn, $productName, $customerEmail, $timestamp);
    $row = $data->fetch_row();

    if ($row[0] != 1) {
        $sql = "INSERT INTO orders (product_id, customer_id, quantity, price, tax, donation, timestamp) 
                VALUES ((SELECT id from product WHERE product_name=?), (SELECT id from customer WHERE email=?), ?, (SELECT price from product WHERE product_name=?), ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisddi", $productName , $customerEmail, $quantity, $productName,  $tax, $donationAmount, $timestamp);
        $stmt->execute();
        $amount = getCurrentStock($conn, $productName);
        $amountInstock = $amount->fetch_row();
        // echo $amountInstock[0];
        updateQuantity($conn,$quantity,  $productName, $amountInstock[0]);
        $stmt->close();
    } else {
        return;
    }

    
}
function addCustomer($conn, $firstName, $lastName, $customerEmail) {
    $sql = "INSERT INTO customer (first_name, last_name, email) 
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $firstName, $lastName, $customerEmail);
    $stmt->execute();
    $stmt->close();
}

function getCurrentStock($conn,$productName) {
    $sql = "SELECT in_stock FROM product WHERE product_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    return $result;
}


function updateQuantity($conn, $quantityPurchased, $productName, $amount) {
    if ($amount - $quantityPurchased >= 0) {
        $sql = "UPDATE product SET in_stock = in_stock -  $quantityPurchased WHERE product_name = ?" ;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $productName);
        $stmt->execute();
        $stmt->close();
    } else if ($amount - $quantityPurchased < 0) {
        $sql = "UPDATE product SET in_stock = 0 WHERE product_name = ?" ;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $productName);
        $stmt->execute();
        $stmt->close();
    }
}

function displayCustomerTable($conn) {
    $sql = "SELECT * FROM customer";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function displayProductTable($conn) {
    $sql = "SELECT * FROM product";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function displayOrderTable($conn) {
    $sql = "SELECT customer.first_name, customer.last_name, product.product_name, orders.timestamp, orders.quantity, orders.price, orders.tax, orders.donation 
                 FROM orders 
                 INNER JOIN customer ON orders.customer_id = customer.id
                 INNER JOIN product ON orders.product_id = product.id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function checkCountOrders($conn) {
    $sql = "SELECT COUNT(*) FROM orders";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function getQuantity($conn, $selection) {
    $sql = "SELECT in_stock FROM product WHERE image_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selection);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function getCustomersFirstBasedOnChar($conn, $char) {
    $var1 = "$char%";
    $sql = "SELECT * FROM customer WHERE first_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $var1);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function getCustomersLastBasedOnChar($conn, $char) {
    $var = "$char%";
    $sql = "SELECT * FROM customer WHERE last_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $var);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}


function createGameTable($conn) {
    $productTable = displayProductTable($conn);
    if ($productTable -> num_rows > 0) {
        echo "<table id='game-table' class='scrollBar'>
      <tr>
      <th>Product Name</th>
      <th>Image Name</th>
      <th>Price</th>
      <th>In stock</th>
      <th>Inactive?</th>
      </tr>";
        while($row = $productTable-> fetch_assoc()) {   
            echo "<tr><td>";
            echo $row['product_name'] . "</td>". "<td>" . $row['image_name'] ."</td>". "<td>" . $row['price'] ."</td>". "<td>" . $row['in_stock'] ."</td>";
            if ($row['inactive'] == 1) {
                echo "<td>" . "Yes" . "</td></tr>";
            } else {
                echo "<td>" . "No" . "</td></tr>";
            }
        }
        echo "</table>";
    } else {
        echo "<p id=noProducts> No Products</p>";
    }
}

function addProduct($conn, $productName, $imageName, $price, $stock, $inactivity) {
    $sql = "INSERT INTO product (product_name, image_name, price, in_stock, inactive) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $productName, $imageName, $price, $stock, $inactivity);
    $stmt->execute();
    $stmt->close();
}

function getProductID($conn, $productName) {
    $sql = "SELECT id FROM product WHERE product_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result -> fetch_row();
    $stmt->close();
    return $data[0];
}

function updateProduct($conn, $productName, $imageName, $price, $stock, $inactivity, $productID) {
    $sql = "UPDATE product SET product_name = ? WHERE id = ?" ;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $productName, $productID);
    $stmt->execute();
    $stmt->close();

    $sql = "UPDATE product SET image_name = ? WHERE id = ?" ;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $imageName, $productID);
    $stmt->execute();
    $stmt->close();

    $sql = "UPDATE product SET price = ? WHERE id = ?" ;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $price, $productID);
    $stmt->execute();
    $stmt->close();

    $sql = "UPDATE product SET in_stock = ? WHERE id = ?" ;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $stock, $productID);
    $stmt->execute();
    $stmt->close();

    $sql = "UPDATE product SET inactive = ? WHERE id = ?" ;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $inactivity, $productID);
    $stmt->execute();
    $stmt->close();
}

function checkOrderByProductID($conn, $productID) {
    $sql = "SELECT COUNT(*) FROM orders WHERE product_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $data = $result -> fetch_row();
    return $data[0];
}

function deleteProduct($conn, $productID) {
    $sql = "DELETE FROM product WHERE id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $stmt->close();
}

function checkUserInput($conn, $email, $password) {
    $sql = "SELECT COUNT(*) FROM users WHERE email=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $data = $result -> fetch_row();
    return $data[0];
}

function getUser($conn, $email, $password) {
    $sql = "SELECT * FROM users WHERE email=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
    
}



?>