<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$action = "appraisal_insert.php";
?>

<div class="container">
    <form id="appraisal_form" name="appraisal_form" action="<?=$action?>" method="post" class="fullwidth">
        <input type="hidden" id="appraisal_no" name="appraisal_no" value="<?=$appraisal['appraisal_no']?>"/>
        <h3>감정 신청<?=$mode?></h3>
        <h6>*은 필수 입력 필드입니다.</h6>
        <p>
            <label for="name">차량 번호*</label>
            <input type="text" placeholder="고객 이름 입력" id="name" name="name" value="<?=$appraisal['name']?>"/>
        </p>
        <p>
            <label for="contact">연락처</label>
            <input type="number" placeholder="숫자만 입력 (-은 제외)" id="contact" name="contact" value="<?=$appraisal['contact']?>" />
        </p>
        <p>
            <label for="email">Email*</label>
            <input type="text" placeholder="이메일은 필수 입력" id="email" name="email" value="<?=$appraisal['email']?>" />
        </p>
        <p>
            <label for="address">주소</label>
            <input type="text" placeholder="주소 입력" id="address" name="address" value="<?=$appraisal['address']?>" />
        </p>
        <p>
            <label for="password">비밀번호*</label>
            <input type="password" placeholder="가입 비밀번호" id="password" name="password" value="" />
        </p>

        <p align="center"><button class="button primary large" onclick="javascript:return validate();">신청</button></p>

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

            $('#appraisal_form').on('submit', function(e) {
                e.preventDefault(); // prevent form from submitting

                var email = document.getElementById("email").value;
                var password = document.getElementById("password").value;
                var appraisal_no = document.getElementById("appraisal_no").value;

                var promise;

                // If mode = 수정, check if email already exists and password is correct
                if (mode == "수정") {
                    promise = $.ajax({
                        url: 'password_check.php',
                        type: 'POST',
                        data: {
                            'password': password,
                            'appraisal_no': appraisal_no
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
                        $('#appraisal_form').off('submit').submit();
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
