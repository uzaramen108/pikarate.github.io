<?php
include("./dbconn.php");

if(isset($_SESSION['ss_md_id']) && $_GET['mode'] == 'modify') {
    $mb_id = $_SESSION['ss_mb_id'];

    $sql = "SELECT * FROM member WHERE mb_id = '$mb_id'";
    $result = mysqli_query($conn, $sql);
    $mb = mysqli_fetch_assoc($result);
    mysqli_close($conn);

    $mode = "modify";
    $title = "회원수정";
    $modify_mb_info = "readonly";
}   else {
    $mode = "insert";
    $title = "회원가입";
    $modify_mb_info = '';
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA_Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="css/registyle.css">
    </head>
    <body>
        <h1><?php echo $title ?></h1>

        <form action="./register_update.php" onsubmit="return fregisterform_submit(this);"method="post">
            <input type = "hidden" name ="mode" value = "<?php echo $mode ?>">

            <table>
                <tr>
                    <th>닉네임</th>
                    <td><input type="text" name = "mb_id"  <?php echo $modify_mb_info ?>></td>
                </tr>
                <tr>
                    <th>비밀번호</th>
                    <td><input type = "password" name = "mb_password"></td>
                </tr>
                <tr>
                    <th>비밀번호 확인</th>
                    <td><input type = "password" name = "mb_password_re"></td>
                </tr>
                <tr>
                    <td colspan="2" class="td_center"><input type="submit" value="<?php echo $title ?>"><a href="./mypage.php">취소</a></td>
                </tr>
            </table>



        </form>

        <script>
            function fregisterform_submit(f) {
                if (f.mb_id.value.length < 1) {
                    alert("이름을 입력하십시오.");
                    f.mb_id.focus();
                    return false;
                }

                if (f.mb_password.value.length < 3) {
                    alert("비밀번호를 3글자 이상 입력하십시오.");
                    f.mb_password.focus();
                    return false;
                }

                if (f.mb_password.value != f.mb_password_re.value) {
                    alert("비밀번호를 다시 한번 확인하여주십시오.");
                    f.mb_password_re.focus();
                    return false;
                }

                if (f.mb_password.value.length > 0) {
                    if (f.mb_password_re.value.length < 3) {
                    alert("비밀번호를 3글자 이상 입력하십시오.");
                    f.mb_password_re.focus();
                    return false;
                }
                }

                return true;
                
            }
        </script>
    </body>
</html>