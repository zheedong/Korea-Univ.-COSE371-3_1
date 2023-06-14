<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set session transaction isolation level serializable");
mysqli_query($conn, "begin");

$car_no = $_POST['car_no'];
$model_year = $_POST['model_year'];
$mileage = $_POST['mileage'];
$accident_history = $_POST['accident_history'];
$color = $_POST['color'];
// estimated price derive
$customer_no = $_POST['customer_no'];
$model_name = $_POST['model'];

// 1. model table에서 출고가 (forwarding_price) 가져오기
// 2. 잔가율[올해 - 연식] * 출고가 = estimated_price
$balance_rate = [];
$balance_rate[0] = 0.826;
$balance_rate[1] = 0.725;
$balance_rate[2] = 0.614;
$balance_rate[3] = 0.518;
$balance_rate[4] = 0.437;
$balance_rate[5] = 0.368;
$balance_rate[6] = 0.311;
$balance_rate[7] = 0.262;
$balance_rate[8] = 0.221;
$balance_rate[9] = 0.186;
$balance_rate[10] = 0.157;
$balance_rate[11] = 0.132;
$balance_rate[12] = 0.112;
$balance_rate[13] = 0.094;
$balance_rate[14] = 0.079;
$balance_rate[15] = 0.067;

$model = mysqli_query($conn, "select * from model where model_name = '$model_name'");
if (!$model_year) {
    $estimated_price = Null;
} else {
    $estimated_price = mysqli_fetch_array($model)['forwarding_price'] * $balance_rate[date("Y") - $model_year];
}

$result = mysqli_query($conn, "update car set car_no = '$car_no', model_year = '$model_year', mileage = '$mileage', accident_history = '$accident_history', color = '$color', estimated_price = '$estimated_price', model_name = '$model_name' where car_no = '$car_no'");

if (!$result)
{
    mysqli_query($conn, "rollback");
    mysqli_close($conn);
    s_msg("차량정보 수정에 실패하였습니다. 다시 시도하여 주십시오.");
    echo "<script>location.replace('car_list.php');</script>";
}
else
{
    mysqli_query($conn, "commit");
    mysqli_close($conn);
    s_msg ('성공적으로 수정 되었습니다');
    echo "<script>location.replace('car_list.php');</script>";
}
?>