<?php
include("./dbconn.php");

$mode = $_POST['mode'];

if($mode != 'insert' && $mode != 'modify') {
    echo "<script>alert('mode 값이 제대로 넘어오지 않았습니다.');</script>";
    echo "<script>location.replace('./register.php');</script>";
    exit;
}

switch ($mode) {
    case 'insert' :
        $mb_id = trim($_POST['mb_id']);
        $title = "회원가입";
        break; 
    case 'modify' :
        $mb_id = trim($_SESSION['ss_mb_id']);
        $title = "회원수정";
        break; 
}

$mb_password = trim($_POST['mb_password']);
$mb_password_re = trim($_POST['mb_password_re']);
$mb_ip = trim($_SERVER['REMOTE_ADDR']);

if (!$mb_id) {
    echo "<script> alert('아이디가 넘어오지 않았습니다.');</script>";
    echo "<script> location.replace('./register.php');</script>";
    exit;
}

if (!$mb_password) {
    echo "<script> alert('비밀번호가 넘어오지 않았습니다.');</script>";
    echo "<script> location.replace('./register.php');</script>";
    exit;
}

if ($mb_password != $mb_password_re) {
    echo "<script> alert('비밀번호가 일치하지 않습니다.');</script>";
    echo "<script> location.replace('./register.php');</script>";
    exit;
}



$sql = "SELECT PASSWORD('$mb_password') AS pass ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$mb_password = $row['pass'];

if ($mode == "insert") {
    $sql = "SELECT * FROM member WHERE mb_id = '$mb_id'";
    $result = mysqli_query($conn, $sql);

// 닉네임 중복 확인
if (mysqli_num_rows($result) > 0) {
    echo "<script> alert('이미 사용중인 닉네임입니다.');</script>";
    echo "<script> location.replace('./register.php');</script>";
    exit;
}

// IP 중복 확인
$sql = "SELECT * FROM member WHERE mb_ip = '$mb_ip'";
$result = mysqli_query($conn, $sql);

// if (mysqli_num_rows($result) > 0) {
//     echo "<script>alert('해당 IP로는 이미 계정이 생성되었습니다. 혹시 본인이 계정을 생성하지 않았다면 관리자에게 문의해주세요.');</script>";
//     echo "<script>location.replace('./mypage.php');</script>";
//     exit;
// } 요거 나중에 풀기기


$sql = "INSERT INTO member
    SET mb_id = '$mb_id',
        mb_password = '$mb_password',
        mb_ip = '$mb_ip'";
    $result = mysqli_query($conn, $sql);
    echo "<script> alert('회원가입이 완료되었습니다다.');</script>";
    echo "<script> location.replace('./mypage.php');</script>";

} else if ($mode == "modify") { /*회원 수정상태**/

    $sql = " UPDATE member
        SET mb_password = '$mb_password',
        WHERE mb_id = 'mb_id'";
    $result = mysqli_query($conn, $sql);
}

?>



