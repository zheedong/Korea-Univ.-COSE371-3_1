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
            <th>모델명</th>
            <th>제조사</th>
            <th>출고가</th>
            <th>연료</th>
            <th>변속기</th>
            <th>연비</th>
            <th>차종</th>
            <th>배기량</th>
        </tr>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row['model_name']}</td>";
            echo "<td>{$row['manufacturer']}</td>";
            echo "<td>{$row['forwarding_price']}</td>";
            echo "<td>{$row['fuel_type']}</td>";
            echo "<td>{$row['gearbox_type']}</td>";
            echo "<td>{$row['fuel_efficiency']}</td>";
            echo "<td>{$row['car_type']}</td>";
            echo "<td>{$row['displacement']}</td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
    </table>
</div>
<? include("footer.php") ?>
>
