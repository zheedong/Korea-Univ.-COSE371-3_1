<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from model where model_name = '{$_GET['model_name']}'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        msg('Query Error : '.mysqli_error($conn));
    }
    ?>

    <table class="table table-striped table-bordered">
        <tr>
            <th>차량 번호</th>
            <th>연식</th>
            <th>주행 거리</th>
            <th>사고 이력</th>
            <th>색상</th>
            <th>예상 가격</th>
            <th>판매자</th>
            <th>모델명</th>
        </tr>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row['car_no']}</td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
    </table>
</div>
<? include("footer.php") ?>
>
