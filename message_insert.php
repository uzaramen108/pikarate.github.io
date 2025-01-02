<meta charset='utf-8'>

<?php
$send_id = $_GET["send_id"]; // 원래 겟이었음
$rv_id = $_POST['rv_id'];
$send_rc = $_POST['send_rc'];
$rv_rc = $_POST['rv_rc'];
$regist_day = date("Y-m-d (H:i)");

if (!$send_id) {
    echo ("<script>
            alert('로그인 후 이용해주세요! ');
            history.go(-1);
        </script>");
    exit;
}

// 파일 업로드 확인
if (!isset($_FILES['uploaded_file']) || $_FILES['uploaded_file']['error'] !== UPLOAD_ERR_OK) {
    echo ("<script>
            alert('파일 업로드에 실패했습니다. 파일을 확인해주세요.');
            history.go(-1);
        </script>");
    exit;
}

// 파일 정보 처리
$uploadDir = 'uploads/'; // 파일 저장 디렉터리
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // 디렉터리 생성
}

$fileName = basename($_FILES['uploaded_file']['name']); // 파일명
$fileTmpName = $_FILES['uploaded_file']['tmp_name']; // 임시 파일 경로
$fileContent = file_get_contents($fileTmpName); // 파일 내용 읽기

if ($fileContent === false) {
    echo ("<script>
            alert('파일 내용을 읽을 수 없습니다.');
            location.href = 'mypage.php?mode=send';
        </script>");
    exit;
}

$con = mysqli_connect("localhost", "drunkp", "uza108", "pikarate");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// 수신자 확인
$sql = "SELECT * FROM member WHERE mb_id = '$send_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$send_ap = $row['apcheck'];
$send_gc = $row['gamecount'];
$send_gc = $send_gc + 1;

$sql = "SELECT * FROM member WHERE mb_id = '$rv_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$rv_ap = $row['apcheck'];
$rv_gc = $row['gamecount'];
$rv_gc = $rv_gc + 1;





if ($send_ap == 0 or $rv_ap == 0) {
    if ($send_gc > 5 or $rv_gc > 5) {
        echo ("<script>
                alert('수신자 또는 송신자가 비승인 유저이며, 한계 전적 등록 횟수에 도달하였습니다. 사이트 제작자에게 문의하여 등록을 완료해주세요.');
                location.href = 'mypage.php?mode=send';
            </script>");
        exit;
    }   
    }   else {
        $sql = "UPDATE member SET gamecount = gamecount + 1 WHERE mb_id = '$send_id'";
    
        // 쿼리 실행
        if (mysqli_query($con, $sql)) {
            echo "Game count updated successfully.";
        } else {
            echo "Error updating game count: " . mysqli_error($con);
        }
    
        $sql = "UPDATE member SET gamecount = gamecount + 1 WHERE mb_id = '$rv_id'";
    
        // 쿼리 실행
        if (mysqli_query($con, $sql)) {
            echo "Game count updated successfully.";
        } else {
            echo "Error updating game count: " . mysqli_error($con);
        }
        }

$sql = "SELECT * FROM member WHERE mb_id = '$rv_id'";
$result = mysqli_query($con, $sql);
$num_record = mysqli_num_rows($result);

$sql = "SELECT * FROM member WHERE mb_id = '$rv_id'";

if ($num_record) {
    // 메시지 기록 삽입
    $sql = "INSERT INTO recording SET 
                send_id = '$send_id',
                send_rc = '$send_rc',
                regist_day = '$regist_day',
                rv_rc = '$rv_rc',
                rv_id = '$rv_id',
                filename = '$fileName',
                content = '" . mysqli_real_escape_string($con, $fileContent) . "'";
    $result = mysqli_query($con, $sql);

    // 파일 정보 저장
    
                
   
    echo "<script>
            alert('등록이 완료되었습니다.');
            location.href = 'mypage.php?mode=send';
        </script>";
} else {
    echo ("<script>
            alert('수신자를 잘못 입력하였습니다.');
            location.href = 'mypage.php';
        </script>");
    exit;
}

mysqli_close($con);
?>
