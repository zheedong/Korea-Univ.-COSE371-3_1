<?php
    include "config.php";
    include "util.php";

    $conn = dbconnect($host, $dbid, $dbpass, $dbname);

    if(isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $query = "SELECT password FROM customer WHERE email = ?";
        if($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = $email;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_bind_result($stmt, $stored_password);

                if(mysqli_stmt_fetch($stmt)) {
                    if($password == $stored_password) {
                        echo "match"; // 비밀번호 일치
                    } else {
                        echo "nomatch"; // 비밀번호 불일치
                    }
                }
            } else {
                echo "Error occurred while checking password.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
?>
