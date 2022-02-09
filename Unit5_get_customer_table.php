<?php
include('Unit5_database.php');
$q = $_REQUEST["q"];
$field = $_REQUEST["f"];
$conn = getConnection($servername, $username, $password, $dbname);

if ($field == 'first') {
    
    $dataCustomerFirst = getCustomersFirstBasedOnChar($conn,$q);
    if ($dataCustomerFirst -> num_rows > 0) {
        echo "<table id='customer-table'>
      <tr>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
      </tr>";
        while($row = $dataCustomerFirst-> fetch_assoc()) {   
            echo "<tr><td>";
            echo $row['first_name'] . "</td>". "<td>" . $row['last_name'] ."</td>". "<td>" . $row['email']. "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p id=noCustomers> No Customers</p>";
    }
} else {
    
    $dataCustomerLast = getCustomersLastBasedOnChar($conn,$q);
    if ($dataCustomerLast -> num_rows > 0) {
        echo "<table id='customer-table'>
      <tr>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
      </tr>";
        while($row = $dataCustomerLast-> fetch_assoc()) {   
            echo "<tr><td>";
            echo $row['first_name'] . "</td>". "<td>" . $row['last_name'] ."</td>". "<td>" . $row['email']. "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p id=noCustomers> No Customers</p>";
    }
}
 ?>