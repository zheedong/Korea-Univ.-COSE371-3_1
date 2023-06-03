<?php
include "config.php";
include "util.php";

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

$email = $_POST['email'];

$query = "SELECT * FROM customer WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$customer = mysqli_fetch_array($result);

if($customer) {
    echo 'email exists';
} else {
    echo 'success';
}
?>
