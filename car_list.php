<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from car natural join customer";
    if (array_key_exists("search_keyword", $_POST)) {
        $search_keyword = $_POST["search_keyword"];
        $query .= " where model_name like '%$search_keyword%'";
    }
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
            echo "<td>{$row['model_year']}</td>";
            echo "<td>{$row['mileage']}</td>";
            echo "<td>{$row['accident_history']}</td>";
            echo "<td>{$row['color']}</td>";
            echo "<td>{$row['estimated_price']}</td>";
            echo "<td>{$row['name']}</td>";
            // Send the model_name to model_view.php
            echo "<td><a href='model_view.php?model_name={$row['model_name']}'>{$row['model_name']}</a></td>";
            echo "<td>
                <a href='car_form.php?car_no={$row['car_no']}'><button class='button primary medium'>수정</button></a>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
    </table>
    <script>
        // Need to check user input is equal to $row['password'] in the database
        function deleteConfirm(encodedCarNo) {
            var car_no = decodeURIComponent(encodedCarNo);
            if (confirm("정말 삭제하시겠습니까?") == true) {
                window.location = "car_delete.php?car_no=" + encodeURIComponent(car_no);
            } else {
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
>