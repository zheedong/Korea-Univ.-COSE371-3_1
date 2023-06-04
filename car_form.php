<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "car_insert.php";

if (array_key_exists("car_no", $_GET)) {
    $car_no = $_GET["car_no"];
    $query =  "select * from car where car_no = $car_no";
    $result = mysqli_query($conn, $query);
    $car = mysqli_fetch_array($result);
    if(!$car) {
        msg("차량이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "car_modify.php";
}

$model = array();

$query = "select * from model";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)) {
    $model[$row['model_name']] = $row['model_name'];
}
?>

    <div class="container">
        <form name="car_form" action="<?=$action?>" method="post" class="fullwidth">
            <h3>차량 정보 <?=$mode?></h3>
            <h6>*은 필수 입력 필드입니다.</h6>
            <p>
                <label for="car_no">차량 번호*</label>
                <input type="text" placeholder="차량 번호 입력" id="car_no" name="car_no" value="<?=$car['car_no']?>"/>
            </p>
            <p>
                <label for="model">차량 모델*</label>
                <select name="model_name" id="model_name">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($model as $name) {
                            if($name == $car['model_name']){
                                echo "<option value='{$car}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$car}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <p>
                <label for="customer_no">고객 번호*</label>
                <input type="number" placeholder="고객 번호 입력" id="customer_no" name="customer_no" value="<?=$car['customer_no']?>"/>
            </p>
            <p>
                <label>고객 비밀번호*</label>
                <input type="password" placeholder="비밀번호 입력" id="password" name="password"/> 
            </p>
            <p>
                <label for="model_year">연식</label>
                <input type="number" placeholder="정수로 입력" id="model_year" name="model_year" value="<?=$car['model_year']?>" />
            </p>
            <p>
                <label for="price">주행 거리</label>
                <input type="number" placeholder="정수로 입력" id="price" name="price" value="<?=$car['price']?>" />
            </p>
            <p>
                <label for="accident_history">사고 이력</label>
                <input type="number" placeholder="횟수로 입력" id="accident_history" name="accident_history" value="<?=$car['accident_history']?>" />
            </p>
            <p>
                <label for="color">차량 색상</label>
                <input type="text" placeholder="차량 색상 입력" id="color" name="color" value="<?=$car['color']?>"/>
            </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("car_no").value == "") {
                        alert ("차량 번호를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("customer_no").value == "") {
                        alert ("고객 번호를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("model_name").value == "-1") {
                        alert ("차량 모델을 선택해 주십시오"); return false;
                    }

                    $("#car_form").on('submit', function(e){
                        e.preventDefault();
                        var customer_no = document.getElementById("customer_no").value;
                        var promise;
                        promise = $.ajax({
                            url: 'customer_check.php',
                            type: 'POST',
                            data: {
                                'customer_no': customer_no
                            }
                        });

                        promise.then(function(data) {
                            if(data == "false") {
                                alert("존재하지 않는 고객 번호입니다.");
                                return false;
                            }
                        })
                        .catch(function(jqXHR, textStatus, errorThrown) {
                            console.log('Ajax request failed: ' + textStatus + ', ' + errorThrown);
                        });

                        promise = $.ajax({
                            url: 'password_check.php',
                            type: 'POST',
                            data: {
                                'password': document.getElementById("password").value,
                                'customer_no': customer_no
                            }
                        });

                        promise.then(function(data) {
                            if(data == "password incorrect") {
                                alert("비밀번호가 일치하지 않습니다.");
                                return false;
                            }
                        })
                        .catch(function(jqXHR, textStatus, errorThrown) {
                            console.log('Ajax request failed: ' + textStatus + ', ' + errorThrown);
                        });

                    });
                }

                    
            </script>

        </form>
    </div>
<? include("footer.php") ?>