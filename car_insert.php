<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$car_no = $_POST['car_no'];
$model_year = $_POST['model_year'];
$mileage = $_POST['mileage'];
$accident_history = $_POST['accident_history'];
$color = $_POST['color'];
// estimated price derive
$customer_no = $_POST['customer_no'];
$model_name = $_POST['model_name'];

// 1. model table에서 출고가 (forwarding_price) 가져오기
// 2. 잔가율[올해 - 연식] * 출고가 = estimated_price


$result = mysqli_query($conn, "insert into car (car_no, model_year, mileage, accident_history, color, estimated_price, customer_no, model_name) 
values('$car_no', '$model_year', '$mileage', '$accident_history', '$color', '$estimated_price', '$customer_no', '$model_name')");

if(!$result)
{
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 입력 되었습니다');
    echo "<script>location.replace('car_list.php');</script>";
}
?>