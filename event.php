<?php
    echo "<script>alert('아직은 비활성화중인 기능입니다. 대회가 열리는 날을 기대해주세요!');</script>";
    echo "<script>location.replace('./mypage.php');</script>";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA_Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>

<header>
    <h1>피카츄 배구 온라인 랭크시스템</h1>
</header>

<body>
            <nav> <!--주요 탐색 영역으로 간주됩니다. -->
            <ul>
    
        <form action="./mypage.php" method="get" style="display: inline;">
            <input type="hidden" name="mb_id" value="<?php echo htmlspecialchars($mb_id); ?>">
            <button type="submit" style="border: none; background: none; color: blue; text-decoration: underline; cursor: pointer;">마이페이지</button>
        </form>
    
        <form action="./tier.php" method="get" style="display: inline;">
            <input type="hidden" name="mb_id" value="<?php echo htmlspecialchars($mb_id); ?>">
            <button type="submit" style="border: none; background: none; color: blue; text-decoration: underline; cursor: pointer;">티어 보기</button>
        </form>
    
        <form action="./event.php" method="get" style="display: inline;">
            <input type="hidden" name="mb_id" value="<?php echo htmlspecialchars($mb_id); ?>">
            <button type="submit" style="border: none; background: none; color: blue; text-decoration: underline; cursor: pointer;">이벤트 매치</button>
        </form>
    
</ul>

            </nav>
    <a href="https://gorisanson.github.io/pikachu-volleyball-p2p-online/ko/" target="Blank">피카츄 배구 온라인 바로가기</a><br/>
    <section>
        <img src="img/pikalogo3.png" alt="로고" width="300" height="300"/>
    </section>
    <form action="login_proc.php" method = "post">
        <label for="nickname">닉네임:</label>
        <input type="text" id="nickname" name="nickname" required><br><br>
    
        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password" required><br><br>
    
        <button type="submit">로그인</button>
    </form>
    
</body>
<footer>
    이 웹페이지는 피카츄배구 온라인을 위한 페이지이며 제작자는 음주대학생입니다.
</footer>
    
<script>
</script>

</html>