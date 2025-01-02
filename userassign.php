<?php

include("./dbconn.php");
$con = mysqli_connect("localhost", "drunkp", "uza108", "pikarate");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mb_no = $_POST['mb_no']; // 전달받은 id를 안전하게 정수로 변환
    $sql = "SELECT * FROM member WHERE mb_no = '$mb_no'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $apcheck = $row['apcheck'];
    

    // 데이터베이스 업데이트 쿼리
    if ($apcheck == 0) {
        $sql = "UPDATE member SET apcheck = 1 WHERE mb_no = '$mb_no'";
        if (mysqli_query($con, $sql)) {
            
            echo "유저 등록 처리가 완료되었습니다.";
        } else {
            echo "승인 처리 중 오류가 발생했습니다: " . mysqli_error($con);
        }
        }   else {
            $sql = "UPDATE member SET apcheck = 0 WHERE mb_no = '$mb_no'";
            if (mysqli_query($con, $sql)) {
                
                echo "유저 등록 처리가 완료되었습니다.";
            } else {
                echo "승인 처리 중 오류가 발생했습니다: " . mysqli_error($con);
            }
        }
        echo "<script>location.replace('./master.php');</script>";
    } else {
    echo "잘못된 접근입니다.";
}
?>