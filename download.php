<?php

include("./dbconn.php");
$con = mysqli_connect("localhost", "drunkp", "uza108", "pikarate");


    $num = $_POST['num']; // 전달받은 id를 안전하게 정수로 변환
    $sql = "SELECT * FROM recording WHERE num = '$num'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $filename = $row['filename'];
    $content = $row['content'];


// 파일 다운로드 헤더 설정
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . strlen($content));

echo $content;

echo "<script>
location.href = 'master.php?mode=send';
</script>";
exit;
?>
