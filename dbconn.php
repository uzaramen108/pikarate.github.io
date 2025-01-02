<?php
$mysql_host = "localhost";
$mysql_user = "drunkp";
$mysql_password = "uza108";
$mysql_db = "pikarate";

// mysqli를 사용하여 연결
$conn = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db);

// 연결 확인
if (!$conn) {
    die("연결 실패다잉ㅠ: " . mysqli_connect_error());
}

session_start();
?>
