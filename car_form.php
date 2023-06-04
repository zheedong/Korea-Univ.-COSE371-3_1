<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "car_insert.php";

if (array_key_exists("car_no", $_GET)) {
    $car_no = urldecode($_GET["car_no"]);
    $query =  "select * from car where car_no = '$car_no'";
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
    <form id="car_form" name="car_form" action="<?=$action?>" method="post" class="fullwidth">
        <h3>차량 정보 <?=$mode?></h3>
        <h6>*은 필수 입력 필드입니다.</h6>
        <p>
            <label for="car_no">차량 번호*</label>
            <input type="text" placeholder="차량 번호 입력" id="car_no" name="car_no" value="<?=$car['car_no']?>"/>
        </p>
        <p>
            <label for="model">차량 모델*</label>
            <select name="model" id="model">
                <option value="-1">선택해 주십시오.</option>
                <?
                    foreach($model as $name) {
                        if($name == $car['model_name']){
                            echo "<option value='{$name}' selected>{$name}</option>";
                        } else {
                            echo "<option value='{$name}'>{$name}</option>";
                        }
                    }
                ?>
            </select>
        </p>
        <p>
            <label for="customer_no">고객 번호*</label>
            <? if ($mode == "입력") : ?>
                <input type="number" placeholder="고객 번호 입력" id="customer_no" name="customer_no" value="<?=$car['customer_no']?>"/>
            <? endif; ?>

            <? if ($mode == "수정") : ?>
                <input type="number" placeholder="고객 번호 입력" id="customer_no" name="customer_no" value="<?=$car['customer_no']?>" readonly/>
            <? endif; ?>
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
            <label for="mileage">주행 거리</label>
            <input type="number" placeholder="정수로 입력" id="mileage" name="mileage" value="<?=$car['mileage']?>" />
        </p>
        <p>
            <label for="accident_history">사고 이력</label>
            <input type="number" placeholder="횟수로 입력" id="accident_history" name="accident_history" value="<?=$car['accident_history']?>" />
        </p>
        <p>
            <label for="color">차량 색상</label>
            <input type="text" placeholder="차량 색상 입력" id="color" name="color" value="<?=$car['color']?>"/>
        </p>

        <? if ($mode == "입력") : ?>
            <p align="center"><button id="modify-button" class="button primary large"><?=$mode?></button></p>
        <? endif; ?>

        <!-- If $mode=수정, make delete button -->
        <? if ($mode == "수정") : ?>
            <p class="button-container">
                <button id="modify-button" class="button primary large"><?=$mode?></button>
                <button id="delete-button" class="button danger large">삭제</button>
                <button id="appraisal-button" class="button primary large">감정 신청</button>
            </p>
        <? endif; ?>

        <!-- Include jQuery Library Here -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            var shouldSubmit = false;

            $('#modify-button').on('click', function(e) {
                e.preventDefault();
                validate().then(function() {
                    shouldSubmit = true;
                    $('#car_form').submit();
                });
            });

            $('#delete-button').on('click', function(e) {
                e.preventDefault();
                setDeleteAction().then(function() {
                    shouldSubmit = true;
                    $('#car_form').submit();
                });
            });

            $('#appraisal-button').on('click', function(e) {
                e.preventDefault();
                checkAppraisal().then(function() {
                    shouldSubmit = true;
                    $('#car_form').submit();
                });
            });

            $('#customer_form').on('submit', function(e) {
                if(!shouldSubmit) {
                    e.preventDefault();
                }
            })

            function validate() {
                return new Promise(function(resolve, reject) {
                    if(document.getElementById("car_no").value == "") {
                        alert ("차량 번호를 입력해 주십시오");
                        reject();
                        return;
                    }
                    else if(document.getElementById("model").value == "-1") {
                        alert ("차량 모델을 입력해 주십시오");
                        reject();
                        return;
                    }
                    else if(document.getElementById("password").value == "") {
                        alert ("비밀번호를 입력해 주십시오");
                        reject();
                        return;
                    }

                    var password = document.getElementById("password").value;
                    var customer_no = document.getElementById("customer_no").value;

                    promise = $.ajax({
                        url: 'password_check.php',
                        type: 'POST',
                        data: {
                            'password': password,
                            'customer_no': customer_no
                        }
                    });

                    promise.then(function(result) {
                        if (result == 'password incorrect') {
                            alert("비밀번호가 일치하지 않습니다.")
                            reject();
                        } 
                        else {
                            // No errors, submit form
                            resolve();
                        }
                    })
                    .catch(function(jqXHR, textStatus, errorThrown) {
                        console.log('Ajax request failed: ' + textStatus + ', ' + errorThrown);
                    });
                });
            }
            
            function setDeleteAction() {
                return new Promise(function(resolve, reject) {
                    if (confirm("정말 삭제하시겠습니까?")) {
                        var password = document.getElementById("password").value;
                        if(password == "") {
                            alert ("고객 비밀번호를 입력해 주십시오");
                            reject();
                            return;
                        } 

                        promise = $.ajax({
                            url: 'password_check.php',
                            type: 'POST',
                            data: {
                                'password': document.getElementById("password").value,
                                'customer_no': customer_no
                            }
                        });

                        promise.then(function(result) {
                            if (result == "password incorrect") {
                                alert("비밀번호가 일치하지 않습니다.")
                                reject();
                            }
                            else {
                                resolve();
                            }
                        })
                        .catch(function(jqXHR, textStatus, errorThrown) {
                            console.log('Ajax request failed: ' + textStatus + ', ' + errorThrown);
                            reject();
                        });
                    }
                    else {
                        reject();
                    }
                });
            }

            function checkAppraisal() {
                return new Promise(function(resolve, reject) {
                    if (confirm("감정을 신청하시겠습니까??")) {
                        var password = document.getElementById("password").value;
                        if(password == "") {
                            alert ("고객 비밀번호를 입력해 주십시오");
                            reject();
                            return;
                        } 

                        promise = $.ajax({
                            url: 'password_check.php',
                            type: 'POST',
                            data: {
                                'password': document.getElementById("password").value,
                                'customer_no': customer_no
                            }
                        });

                        promise.then(function(result) {
                            if (result == "password incorrect") {
                                alert("비밀번호가 일치하지 않습니다.")
                                reject();
                            }
                            else {
                                resolve();
                            }
                        })
                        .catch(function(jqXHR, textStatus, errorThrown) {
                            console.log('Ajax request failed: ' + textStatus + ', ' + errorThrown);
                            reject();
                        });
                    }
                    else {
                        reject();
                    }
                });
            }

        </script>

    </form>
</div>
<? include("footer.php") ?>