<?php

include("./dbconn.php");
$con = mysqli_connect("localhost", "drunkp", "uza108", "pikarate");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $num = $_POST['num']; // 전달받은 id를 안전하게 정수로 변환
    $sql = "SELECT * FROM recording WHERE num = '$num'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $send_id = $row['send_id'];
    $send_rc = $row['send_rc'];
    $rv_id = $row['rv_id'];
    $rv_rc = $row['rv_rc'];

    // 데이터베이스 업데이트 쿼리
    $sql = "UPDATE recording SET approve = 2 WHERE num = '$num'";
    if (mysqli_query($con, $sql)) {
        echo "<script>location.replace('./mypage.php');</script>";
        echo "거절 처리가 완료되었습니다.";
    } else {
        echo "승인 처리 중 오류가 발생했습니다: " . mysqli_error($con);
    }
} else {
    echo "잘못된 접근입니다.";
}
?>
