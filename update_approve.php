<?php

function tiernum($t) {
    if ($t > 3100) {
        $tiername = 7;
    } else if ($t > 2500) {
        $tiername = 6;
    } else if ($t > 1900) {
        $tiername = 5;
    } else if ($t > 1400) {
        $tiername = 4;
    } else if ($t > 1000) {
        $tiername = 3;
    } else if ($t > 700) {
        $tiername = 2;
    } else {
        $tiername = 1;
    }
    return $tiername;
}

function calrating($mer, $your, $mep, $youp) {
    if ($mep == $youp) {
        $calc = 0;
    } else if ($mep == "점수승") {
        $calc = 50 - 3 * (tiernum($mer)-tiernum($your)) - 3 * tiernum($mer);
    } else if ($mep == "점수패") {
        $calc = -30 - 3 * (tiernum($mer)-tiernum($your)) - 3 * tiernum($mer);
    } else if ($mep > $youp) {
        $calc = 50 - 3 * (tiernum($mer)-tiernum($your) - 3 * tiernum($mer));
    } else if ($mep < $youp) {
        $calc = -30 - 3 * (tiernum($mer)-tiernum($your)) - 3 * tiernum($mer);
    } else {
        $calc = 0;
    }
    return $calc;
}

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
    $sql = "UPDATE recording SET approve = 1 WHERE num = '$num'";
    if (mysqli_query($con, $sql)) {
        echo $rv_id;

        // code for rvid
        $sql = "SELECT * FROM member WHERE mb_id = '$rv_id'";
        $rkqt = calrating($rv_id, $send_id, $rv_rc, $send_rc);
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $mb_rating = $row['mb_rating'];
        $mb_rating = $mb_rating + $rkqt;
        if ($mb_rating > 0) {
            $sql = "UPDATE member SET mb_rating = '$mb_rating' WHERE mb_id = '$rv_id'";
            mysqli_query($con, $sql);
        }   else {
            $mb_rating = 0;
            $sql = "UPDATE member SET mb_rating = '$mb_rating' WHERE mb_id = '$rv_id'";
            mysqli_query($con, $sql);
        }

        
        
        // code for sendid
        $sql = "SELECT * FROM member WHERE mb_id = '$send_id'";
        $rkqt = calrating($send_id, $rv_id, $send_rc, $rv_rc);
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $mb_rating = $row['mb_rating'];
        $mb_rating = $mb_rating + $rkqt;
        if ($mb_rating > 0) {
            $sql = "UPDATE member SET mb_rating = '$mb_rating' WHERE mb_id = '$send_id'";
            mysqli_query($con, $sql);
        } else {
            $mb_rating = 0;
            $sql = "UPDATE member SET mb_rating = '$mb_rating' WHERE mb_id = '$send_id'";
            mysqli_query($con, $sql);
        }
        mysqli_close($con);
        echo "선택하신 전적을 승인 완료하였습니다.";
        echo "<script>location.replace('./mypage.php');</script>";
    } else {
        echo "승인 처리 중 오류가 발생했습니다: " . mysqli_error($con);
    }
} else {
    echo "잘못된 접근입니다.";
}
?>
