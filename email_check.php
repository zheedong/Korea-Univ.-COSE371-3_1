<?php
    include "config.php";
    include "util.php";

    $conn = dbconnect($host, $dbid, $dbpass, $dbname);

    if(isset($_POST["email"])) {
        $email = $_POST["email"];

        $query = "SELECT * FROM customer WHERE email = ?";
        if($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = $email;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1) {
                    alert("이미 등록됨");
                    echo "duplicate";  // 이메일 중복
                } else {
                    echo "unique";  // 이메일 유니크
                }
            } else {
                echo "Error occurred while checking email.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
?>
