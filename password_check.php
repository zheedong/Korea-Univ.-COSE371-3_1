<?php
include "config.php";
include "util.php";

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

$entered_password = $_POST['password'];
$customer_no = $_POST['customer_no'];

$query = "SELECT * FROM customer WHERE customer_no = '$customer_no'";
$result = mysqli_query($conn, $query);
$customer = mysqli_fetch_array($result);

// Check if the entered password is correct
if($customer && $customer['password'] != $entered_password) {
    echo 'password incorrect';
} else {
    echo 'success';
}
?>
