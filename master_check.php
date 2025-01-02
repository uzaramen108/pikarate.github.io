<?php

$mb_password = trim($_POST['mb_password']);

if (empty($mb_password)) {
    echo "<script>alert('비밀번호가 공백이면 안되용.');</script>";
    echo "<script>location.replace('./mypage.php');</script>";
    exit;
}   else if ($mb_password == "dbwkfkaus8010") {
    $masterkey = $mb_password;
}   else {
    exit;
}

// 세션 저장


// 로그인 성공 메시지 및 리다이렉트
if ($masterkey) {
    echo "<script>alert('마스터 로그인 성공!');</script>";
    echo "
        <form id='postForm' action='./master.php' method='post'>
            <input type='hidden' name='masterkey' value='" . htmlspecialchars($masterkey, ENT_QUOTES) . "'>
        </form>
        <script>
            document.getElementById('postForm').submit();
        </script>
    ";
    
} 
echo "<script>alert('실풰에에~');</script>";
echo "<script>location.replace('./master.php');</script>";
?>