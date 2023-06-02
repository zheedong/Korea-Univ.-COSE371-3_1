<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$customer_name = $_POST['customer_name'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$address = $_POST['address'];

// update
$result = mysqli_query($conn, "update customer set customer_name = '$customer_name', contact = '$contact', email = '$email', address = '$address' where customer_id = $customer_id");

if(!$result)
{
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 수정 되었습니다');
    echo "<script>location.replace('product_list.php');</script>";
}

?>
