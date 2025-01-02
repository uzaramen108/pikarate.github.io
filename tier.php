<?php
session_start(); // 세션을 사용하는 경우 세션 시작


    


// mb_id 값 가져오기


// $mb_id가 전달되었는지 확인
if (!isset($_SESSION['ss_mb_id'])) {
    // mb_id가 없으면 mypage.php로 리다이렉트
    echo "<script>location.replace('./mypage.php');</script>";
    exit;
}
$mb_id = $_SESSION['ss_mb_id'];
include("./dbconn.php");

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

    function tierimg($timg) {
        if ($timg == 1) {
            $img = './img/Bronze.png';
    }   else if ($timg == 2) {
        $img = './img/Silver.png';  
    }   else if ($timg == 3) {
        $img = './img/Gold.png';
    }   else if ($timg == 4) {
        $img = './img/platinum.png';
    }   else if ($timg == 5) {
        $img = './img/Diamond.png';
    }   else if ($timg == 6) {
        $img = './img/Master.png';
    }   else if ($timg == 7) {
        $img = './img/Grandmaster.png';
    }   
    return $img;
    }

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA_Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type = "text/css" href="./css/tierstyle.css">
</head>

<header>
    <h1>피카츄 배구 온라인 랭크시스템</h1>
    <a href="https://gorisanson.github.io/pikachu-volleyball-p2p-online/ko/" target="Blank">피카츄 배구 온라인 바로가기</a><br/>
</header>

<body>
            <nav> <!--주요 탐색 영역으로 간주됩니다. -->
                <ul>
                    <a href="./mypage.php">마이페이지</a>
                    <a href="./tier.php">티어 보기</a>
                    <a href="./event.php">이벤트 매치</a>
                </ul>
            </nav>
    
    <?php
        $sql = "SELECT * FROM member WHERE mb_id = TRIM('$mb_id')";
        $con = mysqli_connect("localhost", "drunkp", "uza108", "pikarate");
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $rating = $row['mb_rating'];
        $tier = tiernum($rating);
        $img = tierimg($tier);
        ?>
        <section class = "img1">
            <?php
                echo "<img src = $img>";  
            ?>
        </section>
        <?php
        $mb_tier = tierconfig($rating);
echo "<ul class='user1'>";
        echo "<table class='user'>";

        // 순위 출력
        echo "<tr>";
        echo "<th class='red'>닉네임</th>";
        echo "<td>" . htmlspecialchars($mb_id) . "</td>";
        echo "</tr>";

        // 티어 출력
        echo "<tr>";
        echo "<th class='red'>티어</th>";
        echo "<td>" . htmlspecialchars($mb_tier) . "</td>";
        echo "</tr>";

        // 레이팅 출력
        echo "<tr>";
        echo "<th class='red'>레이팅</th>";
        echo "<td>" . htmlspecialchars($rating) . "</td>";
        echo "</tr>";

        // 다음 랭크까지 필요한 레이팅 계산
        if ($rating < 700) {
            $nameji = 700 - $rating;
        } elseif ($rating < 1000) {
            $nameji = 1000 - $rating;
        } elseif ($rating < 1400) {
            $nameji = 1400 - $rating;
        } elseif ($rating < 1900) {
            $nameji = 1900 - $rating;
        } elseif ($rating < 2500) {
            $nameji = 2500 - $rating;
        } else {
            $nameji = "최고 랭크입니다.";
        }

        // 다음 랭크 정보 출력
        echo "<tr>";
        echo "<th class='red'>다음 랭크까지 필요한 레이팅</th>";
        if ($rating >= 3200) {
            echo "<td>최고 랭크입니다.</td>";
        } else {
            echo "<td>" . $nameji . "</td>";
        }
        echo "</tr>";

        echo "</table>";

    echo "</ul>";
    echo "<ul class='user2'>";
        // HTML 출력
        echo "<table class='users'>";
        echo "<tr>
                <th class='blue'>순위</th>
                <th class='blue'>닉네임</th>
                <th class='blue'>레이팅</th>
            </tr>";
            $sql = "SELECT mb_id, mb_rating FROM member ORDER BY mb_rating DESC";
            $result = mysqli_query($conn, $sql);
        // 순위 초기값
        $rank = 1;

if (mysqli_num_rows($result) > 0) {
    // 데이터 출력
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $rank . "</td>"; // 순위 출력
        echo "<td>" . $row['mb_id'] . "</td>"; // mb_id 출력 (XSS 방지를 위해 htmlspecialchars 사용)
        echo "<td>" . $row['mb_rating'] . "</td>"; // mb_rating 출력
        echo "</tr>";

        $rank++; // 순위 증가
    }
} else {
    echo "<tr><td colspan='3'>데이터가 없습니다.</td></tr>";
}

echo "</table>";
echo "</ul>";
// 데이터베이스 연결 닫기
mysqli_close($conn);
?>
  

    
</body>
<footer>
    이 웹페이지는 피카츄배구 온라인을 위한 페이지이며 제작자는 음주대학생입니다.
</footer>
    
<script>
</>

</html>