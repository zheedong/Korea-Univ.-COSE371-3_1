<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$customer_name = $_POST['customer_name'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$address = $_POST['address'];

$result = mysqli_query($conn, "insert into customer (customer_name, contact, email, address) values('$customer_name', '$contact', '$email', '$address')");
if(!$result)
{
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 입력 되었습니다');
    echo "<script>location.replace('customer_list.php');</script>";
}

?>