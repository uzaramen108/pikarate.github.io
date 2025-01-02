<?php
include("./dbconn.php");

$mb_id = trim($_POST['mb_id']);
$mb_password = trim($_POST['mb_password']);

if (empty($mb_id) || empty($mb_password)) {
    echo "<script>alert('회원 아이디나 비밀번호가 공백이면 안되용.');</script>";
    echo "<script>location.replace('./mypage.php');</script>";
    exit;
}

$sql = "SELECT * FROM member WHERE mb_id = '$mb_id'";
$result = mysqli_query($conn, $sql);
$mb = mysqli_fetch_assoc($result);

$sql = "SELECT PASSWORD('$mb_password') AS pass ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$password = $row['pass'];

if (!$mb['mb_id'] || !($password === $mb['mb_password'])) { /*!$result || mysqli_num_rows($result) == 0*/
    echo "<script>alert('가입된 회원아이디가 아니거나 비밀번호가 틀립니당.');</script>";
    echo "<script>location.replace('./mypage.php');</script>";
    exit;
}

// 세션 저장
$_SESSION['ss_mb_id'] = $mb_id;

mysqli_close($conn);

// 로그인 성공 메시지 및 리다이렉트
if (isset($_SESSION['ss_mb_id'])) {
    echo "<script>alert('로그인 성공!');</script>";
    echo "<script>location.replace('./mypage.php');</script>";
    exit;
}
?>
