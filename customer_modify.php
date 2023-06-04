<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$customer_no = $_POST['customer_no'];
$name = $_POST['name'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$address = $_POST['address'];
$password = $_POST['password'];

// update
$result = mysqli_query($conn, "update customer set name = '$name', contact = '$contact', email = '$email', address = '$address', password = '$password' where customer_no = '$customer_no'");

if(!$result)
{
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 수정 되었습니다');
    echo "<script>location.replace('customer_list.php');</script>";
}

?>
