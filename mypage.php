<!DOCTYPE html>
<?php
    include("./dbconn.php");
?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA_Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" type = "text/css" href="./css/mypastyle.css">
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
<?php if (!isset($_SESSION['ss_mb_id'])) { ?>
    <section class = "hlink1">
    
    </section>
    <section class = "img1">
        <img src="img/pikalogo3.png" alt="로고" width="300" height="300"/>
    </section>
    <section class = "ver1">
    <form action="login_check.php" method="post">
        <label for="nickname">닉네임:</label>
        <input type="text" id="nickname" name="mb_id" class = "text1" required><br><br>
    
        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="mb_password" required><br><br>
        <td colspan = "2" class = "td_center">
            <input type = "submit" value = "로그인">
            <a href="./register.php">회원가입</a>
        </td>
    
        <!--<button type="submit">로그인</button>-->
    </form>
    </section>
    <footer class = "footer1">
    이 웹페이지는 피카츄배구 온라인을 위한 페이지이며 제작자는 음주대학생입니다.
    </footer>

<?php } else { ?>
    
    <?php
        $mb_id = $_SESSION['ss_mb_id'];
    ?>
    <section>
            <nav> <!--주요 탐색 영역으로 간주됩니다. -->
                <ul>         
                    <a href="./mypage.php">마이페이지</a>
                    <a href="./tier.php">티어 보기</a>
                    <a href="./event.php">이벤트 매치</a>
                </ul>
            </nav>
    </section>
    <section class = "img2">
        <img src="img/pikalogo4.png" alt="로고" width="200" height="200"/>
    </section>
    <section class = "ver2">
    <form action="logout.php" method="post">
        <td colspan = "2" class = "td_center">
            <input type = "submit" value = "로그아웃">
        </td>
    </form>
    </section>
    <section class = "tier1">
    <?php
        $mb_id = $_SESSION['ss_mb_id'];

        // SQL Injection 방지를 위해 mysqli_real_escape_string 사용
        $mb_id = mysqli_real_escape_string($conn, $mb_id);
        $sql = "SELECT * FROM member WHERE mb_id = TRIM('$mb_id')";
        $result = mysqli_query($conn, $sql);

        

        // 결과 확인 및 데이터 가져오기
        if ($result && mysqli_num_rows($result) > 0) {
            $mb = mysqli_fetch_assoc($result);
        } else {
            echo "<p>회원 정보를 가져올 수 없습니다.</p>";
        }

        

        // 사용자 티어 조회
        $sql = "SELECT mb_rating FROM member WHERE mb_id = '$mb_id'";
        $result = mysqli_query($conn, $sql);
        


        if (!$result) {
            echo "<script>alert('티어 정보를 가져오는 데 실패했습니다.');</script>";
            echo "<script>location.replace('./profile.php');</script>";
            exit;
        }

        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $mb_rating = $row['mb_rating'];
            $tier = tierconfig($mb_rating);

            
        } else {
            echo "<script>alert('사용자를 찾을 수 없습니다.');</script>";
            echo "<script>location.replace('./mypage.php');</script>";
        }

        // 사용자 레이팅 조회
        $sql = "SELECT mb_rating FROM member WHERE mb_id = '$mb_id'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "<script>alert('레이팅 정보를 가져오는 데 실패했습니다.');</script>";
            echo "<script>location.replace('./profile.php');</script>";
            exit;
        }

        
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $mb_rating = $row['mb_rating'];
            
            
        } else {
            echo "<script>alert('사용자를 찾을 수 없습니다.');</script>";
            echo "<script>location.replace('./profile.php');</script>";
        }

        ?>    
            <section>    
            <table class="main1">
                <tr>
                <th ><?php echo $mb['mb_id']?></th>
                </tr>
                <tr>
                <th ><?php echo $tier?></th>
                </tr>
                <tr>
                    <th ><?php echo $mb_rating?></th>
                </tr>

            </table>
            </section>
        <?php


        // 데이터베이스 연결 종료
        mysqli_close($conn);
        ?>
    </section>
        



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
<section class = "record1">
    <div id = "messagebox">
        <h3 id = "write_title">전적 등록</h3>        
            <div id="write_msg">
                <section class = "ver3">
                <form name="message_form" method="post" action="message_insert.php?send_id=<?= $mb_id ?>" enctype="multipart/form-data">
                    <ul class="regist1" style="white-space: nowrap; display: flex; align-items: center;">
                        <text class="rv1" name="send_id" style="white-space: nowrap; display: flex; align-items: center;"><?php echo "$mb_id" ?></text>
                        <span class="col1" style="white-space: nowrap; display: flex; align-items: center;">
                            <select name="send_rc">
                                <option>0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                            </select>
                            <span style="margin: 0 5px;">:</span>
                            <select name="rv_rc">
                                <option>0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                            </select>
                        </span>
                        <span class="col1"><input name="rv_id" type="text" class="text2"></span>
                    </ul>
                    <ul class="regist2" style="white-space: nowrap; display: flex; align-items: center; margin-top: 10px;">
                        <label for="file_upload">파일 업로드:</label>
                        <input type="file" name="uploaded_file" id="file_upload" style="margin-left: 10px;">
                    </ul>
                    <ul class="regist3">
                        <td colspan="2" class="td_center">
                            <input type="submit" value="등록">
                        </td>
                    </ul>
                </form>
                </section>
            </div>
        
    </div>
</section>

        <!-- 여기부터 보낸 메시지 확인하는 공간을 만들 것임.-->
<section id = "받은 메일들" class = "record2">
    <div>
        <?php
            $sql = "SELECT * FROM recording WHERE approve = 0 AND rv_id = '$mb_id'";
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
                    echo "<td>
                        <form action='update_approve.php' method='post' style='display:inline;'>
                            <input type='hidden' name='num' value='" . $row['num'] ."'>
                            <button type='submit'>승인</button>
                        </form>
                        <form action='refuse.php' method='post' style='display:inline;'>
                            <input type='hidden' name='num' value='" . $row['num'] ."'>
                            <button type='submit'>거절</button>
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
