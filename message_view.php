<section>
    <div id="message_box">
        <h3 class="title">
            <?php
                $mode = $__GET["mode"];
                $num = $_GET["num"];
                
                $con = mysqli_connect("localhost", "drunkp", "uza108", "pikarate");
                $sql = "select * from recording where num = $num";
                $result = mysqli_query($con, $sql);

                $row = mysqli_fetch_array($result);
                $send_id = $row["send_id"];
                $rv_id = $row["rv_id"];
                $regist_Day = $row["regist_day"];
                $send_rc = $row["send_rc"]; 
                $rv_rc = $row["rv_rc"];
                
                if ($mode == "send")
                    $result2 = mysqli_query($con,"select naem from recording where id='rv_id'");
                else
                    $result2 = mysqli_query($send,"");

                $rocord = mysqli_fetch_array($result2);
                $msg_name = $rocord["name"];

                if ($mode == "send")
                    echo "송신 쪽지함 > 내용 보기";
                else
                    echo "수신 쪽지함 > 내용 보기";
            ?>
        </h3>
                    <ul id = "view_content">
                        <li>
                            <span class="col1"><?=$msg_name?> <?=$regist_Day?> </span>
                        </li>
                        <li>
                            <?=$send_rc?>
                            <?=$rv_rc?>
                        </li>
                    </ul>
                    <ul class = "buttons">
                        <li>
                            <button onclick="location.href = 'message_box.php?mode=rv'">
                                수신 쪽지함
                            </button>
                        </li>
                        <li>
                            <button onclick="location.href = 'message_box.php?mode=send'">
                                송신 쪽지함
                            </button>
                        </li>
                        <!-- <li>
                            <button onclick="location.href = 'message_response__form.php?num=<?=$num?>'">
                                답변 쪽지
                            </button>
                        </li> -->
                        <li>
                            <button onclick="location.href = 'message_delete.php?num=<?=$num?>&mode=<?=$mode?>'">
                                삭제
                            </button>
                        </li>
                    </ul>
    </div>
</section>