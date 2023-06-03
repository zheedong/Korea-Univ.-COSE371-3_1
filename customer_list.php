<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "select * from customer";
    $result = mysqli_query($conn, $query);
    if (!$result) {
         die('Query Error : ' . mysqli_error());
    }
    ?>

    <table class="table table-striped table-bordered">
        <tr>
            <th>고객 번호</th>
            <th>이름</th>
            <th>연락처</th>
            <th>이메일</th>
            <th>주소</th>
        </tr>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row['customer_no']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['contact']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td width='17%'>
                <a href='customer_form.php?customer_no={$row['customer_no']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['customer_no']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
    </table>
    <script>
        // Need to check user input is equal to $row['password'] in the database
        function deleteConfirm(customer_no) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "customer_delete.php?customer_no=" + customer_no;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
