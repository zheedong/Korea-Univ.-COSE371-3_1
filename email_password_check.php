<?php
include "config.php";
include "util.php";

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

$email = $_POST['email'];
$entered_password = $_POST['password'];
$customer_no = $_POST['customer_no'];

$query = "SELECT * FROM customer WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$customer = mysqli_fetch_array($result);

if($customer && $customer['customer_no'] != $customer_no) {
    echo 'email exists';
} else {
    $query = "SELECT * FROM customer WHERE customer_no = '$customer_no'";
    $result = mysqli_query($conn, $query);
    $customer = mysqli_fetch_array($result);
    if($customer && $customer['password'] != $entered_password) {
        echo 'password incorrect';
    } else {
        echo 'success';
    }
}
?>
