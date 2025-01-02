<meta charset = 'utf-8'>
<?php
    $mode = $__GET["mode"];
    $num = $_GET["num"];

    $con = mysqli_connect("localhost", "drunkp", "uza108", "pikarate");
    $sql = "select * from message where num = $num";
    mysqli_query($con, $sql);

    mysqli_close($con);

    if ($mode == "send") 
        $url = "message_box.php?mode=send";
    else
        $url = "message_box.php?mode=rv";

    echo"
        <script>
            location.href = '$url'
        </script>
    ";
?>