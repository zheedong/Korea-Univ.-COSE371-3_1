<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$car_no = $_POST['car_no'];

$result = mysqli_query($conn, "insert into appraisal (car_no) values('$car_no')");
if(!$result)
{
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 신청 되었습니다');
    echo "<script>location.replace('appraisal_list.php');</script>";
}
?>
