<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from appraisal";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        msg('Query Error : '.mysqli_error($conn));
    }
    ?>

    <table class="table table-striped table-bordered">
        <tr>
            <th>감정 번호</th>
            <th>감정 가격</th>
            <th>감정일</th>
            <th>담당 직원</th>
            <th>차량 번호</th>
        </tr>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row['appraisal_no']}</td>";
            echo "<td>{$row['appraisal_price']}</td>";
            echo "<td>{$row['appraisal_day']}</td>";
            echo "<td>{$row['appraisal_charge_employee']}</td>";
            echo "<td>{$row['car_no']}</td>";
            $row_index++;
        }
        ?>
    </table>
</div>
<? include("footer.php") ?>
>