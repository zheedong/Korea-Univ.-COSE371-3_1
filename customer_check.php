<?php
include "config.php";
include "util.php";

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

$customer_no = $_POST['customer_no'];

$query = "SELECT * FROM customer WHERE customer_no = '$customer_no'";
$result = mysqli_query($conn, $query);
$customer = mysqli_fetch_array($result);

if($customer) {
    echo 'customer exists';
} else {
    echo 'false';
}
?>