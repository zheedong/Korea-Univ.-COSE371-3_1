<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "입력";
$action = "customer_insert.php";

if (array_key_exists("customer_no", $_GET)) {
    $customer_no = $_GET["customer_no"];
    $query =  "select * from customer where customer_no = $customer_no";
    $result = mysqli_query($conn, $query);
    $customer = mysqli_fetch_array($result);
    if(!$customer) {
        msg("고객이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "customer_modify.php";
}
?>
    <div class="container">
        <form id="customer_form" name="customer_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" id="customer_no" name="customer_no" value="<?=$customer['customer_no']?>"/>
            <h3>고객 정보 <?=$mode?></h3>
            <h6>*은 필수 입력 필드입니다.</h6>
            <p>
                <label for="name">고객 이름*</label>
                <input type="text" placeholder="고객 이름 입력" id="name" name="name" value="<?=$customer['name']?>"/>
            </p>
            <p>
                <label for="contact">연락처</label>
                <input type="number" placeholder="숫자만 입력 (-은 제외)" id="contact" name="contact" value="<?=$customer['contact']?>" />
            </p>
            <p>
                <label for="email">Email*</label>
                <input type="text" placeholder="이메일은 필수 입력" id="email" name="email" value="<?=$customer['email']?>" />
            </p>
            <p>
                <label for="address">주소</label>
                <input type="text" placeholder="주소 입력" id="address" name="address" value="<?=$customer['address']?>" />
            </p>
            <p>
                <label for="password">비밀번호*</label>
                <input type="text" placeholder="가입 비밀번호" id="password" name="password" value="" />
            </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <!-- Include jQuery Library Here -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script> 
            var mode = "<?=$mode?>"

            function validate() {
                if(document.getElementById("name").value == "") {
                    alert ("고객 이름을 입력해 주십시오"); return false;
                }
                else if(document.getElementById("email").value == "") {
                    alert ("이메일을 입력해 주십시오"); return false;
                }
                else if(document.getElementById("password").value == "") {
                    alert ("비밀번호를 입력해 주십시오"); return false;
                }

                $('#customer_form').on('submit', function(e) {
                e.preventDefault(); // prevent form from submitting

                var email = document.getElementById("email").value;
                var password = document.getElementById("password").value;
                var customer_no = document.getElementById("customer_no").value;

                var promise;

                // If mode = 수정, check if email already exists and password is correct
                if (mode == "수정") {
                    promise = $.ajax({
                        url: 'password_check.php',
                        type: 'POST',
                        data: {
                            'password': password,
                            'customer_no': customer_no
                        }
                    });
                }
                else if (mode == "입력") {
                    promise = $.ajax({
                        url: 'email_check.php',
                        type: 'POST',
                        data: {
                            'email': email
                        }
                    });
                }

                promise.then(function(result) {
                    if (mode == "수정" && result == 'password incorrect') {
                        alert('패스워드가 틀렸습니다.');
                    } 
                    else if (mode == "입력" && result == 'email exists') {
                        alert('이미 존재하는 이메일입니다.');
                    }
                    else {
                        // No errors, submit form
                        $('#customer_form').off('submit').submit();
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
