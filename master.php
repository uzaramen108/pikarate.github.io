<!DOCTYPE html>
<?php
    include("./dbconn.php");
?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA_Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>

<header>
    <h1>피카츄 배구 온라인 랭크시스템</h1>
    <a href="https://gorisanson.github.io/pikachu-volleyball-p2p-online/ko/" target="Blank">피카츄 배구 온라인 바로가기</a><br/>
</header>

<?php
    function tierconfig($t) {
        if ($t > 3100) {
            $tiername = "그랜드마스터";
        } else if ($t > 2500) {
            $tiername = "마스터";
        } else if ($t > 1900) {
            $tiername = "다이아아";
        } else if ($t > 1400) {
            $tiername = "플레티넘";
        } else if ($t > 1000) {
            $tiername = "골드";
        } else if ($t > 700) {
            $tiername = "실버";
        } else {
            $tiername = "브론즈";
        }
        return $tiername;
    }

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
            $calc = 50 - 3 * (tiernum($mer)-tiernum($your));
        } else if ($mep == "점수패") {
            $calc = -50 - 3 * (tiernum($mer)-tiernum($your));
        } else if ($mep > $youp) {
            $calc = 50 - 3 * (tiernum($mer)-tiernum($your));
        } else if ($mep < $youp) {
            $calc = -50 - 3 * (tiernum($mer)-tiernum($your));
        } else {
            $calc = 0;
        }
        return $calc;
    }
?>

<body>
<?php 
$masterkey = $_POST['masterkey'];
if (!isset($masterkey)) { ?>
    <section class = "ver1">
    <form action="master_check.php" method="post">
        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="mb_password" required><br><br>
        <td colspan = "2" class = "td_center">
            <input type = "submit" value = "로그인">
        </td>
    
        <!--<button type="submit">로그인</button>-->
    </form>
    </section>
    <footer class = "footer1">
    이 웹페이지는 피카츄배구 온라인을 위한 페이지이며 지금의 사이트는 마스터 사이트입니다.
    </footer>

<?php }else { ?>
        



<section>
    <div id="message_box">
            <ul id = "message">
                <?php
                    $con = mysqli_connect("localhost", "drunkp", "uza108", "pikarate");
                ?>
            </ul>

    </div>
</section>
<!-- 여기부터 메일 기능 -->

        <!-- 여기부터 보낸 메시지 확인하는 공간을 만들 것임.-->
        <section id = "유저목록" class = "record2">
    <div>
        <?php
            $sql = "SELECT * FROM member";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo "<table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>"; // 테이블 시작
                echo "<tr>
                        <th>mb_no</th>
                        <th>mb_id</th>
                        <th>mb_ip</th>
                        <th>mb_rating</th>
                        <th>apcheck</th>
                        <th></th>
                    </tr>"; // 헤더 출력

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['mb_no'] . "</td>";
                    echo "<td>" . $row['mb_id'] . "</td>";
                    echo "<td>" . $row['mb_ip'] . "</td>";
                    echo "<td>" . $row['mb_rating'] . "</td>";
                    echo "<td>" . $row['apcheck'] . "</td>";
                    echo "<td>
                        <form action='userassign.php' method='post' style='display:inline;'>
                            <input type='hidden' name='mb_no' value='" . $row['mb_no'] ."'>
                            <button type='submit'>승인</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "인원이 없습니다.";
            }
    ?>
        
    </div>
    
</section>
<section id = "거부 메일들" class = "record2">
    <div>
        <?php
            $sql = "SELECT * FROM recording WHERE approve = 2";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo "<table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>"; // 테이블 시작
                echo "<tr>
                        <th>등록인</th>
                        <th>Game Point</th>
                        <th>Game Point</th>
                        <th>수신인</th>
                        <th>등록일</th>
                        <th></th>
                    </tr>"; // 헤더 출력

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['send_id'] . "</td>";
                    echo "<td>" . $row['send_rc'] . "</td>";
                    echo "<td>" . $row['rv_rc'] . "</td>";
                    echo "<td>" . $row['rv_id'] . "</td>";
                    echo "<td>" . $row['regist_day'] . "</td>";

                    $fileContent = "제목: " . $row['filename'] . "\n내용: " . $row['content'];
                    $fileEncoded = urlencode($fileContent); // 파일 내용을 URL 인코딩

                    // 다운로드 링크 추가
                    echo "<td>
                        <form action='download.php' method='post' style='display:inline;'>
                            <input type='hidden' name='num' value='" . $row['num'] ."'>
                            <button type='submit'>다운로드</button>
                        </form>
                    </td>";
                    echo "<td>
                        <form action='assign.php' method='post' style='display:inline;'>
                            <input type='hidden' name='num' value='" . $row['num'] ."'>
                            <button type='submit'>거절 승인</button>
                        </form>
                    </td>";
                    echo "<td>
                        <form action='update_approve.php' method='post' style='display:inline;'>
                            <input type='hidden' name='num' value='" . $row['num'] ."'>
                            <button type='submit'>거절 거부</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "처리중인 전적이 없습니다.";
            }
    ?>
        
    </div>
    
</section>

<footer class = "footer2">
    이 웹페이지는 피카츄배구 온라인을 위한 페이지이며 제작자는 음주대학생입니다.
</footer>

<?php } ?>
</body>


</html>
