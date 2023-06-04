<?
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$car_no = $_GET['car_no'];

$result = mysqli_query($conn, "delete from car where car_no = '$car_no'");

if(!$result)
{
	msg('Query Error : '.mysqli_error($conn));
}
else
{
	s_msg ('성공적으로 삭제 되었습니다');
	echo "<meta http-equiv='refresh' content='0;url=car_list.php'>";
}	
?>

