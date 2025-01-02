<script>
    function check_input() {
        if (!document.message_form.rv_id.value) {
        alert("상대방의 닉네임을 입력하세요!");
        document.message_form.rv_id.focus();
        return;
        }
        if (!document.message_form.send_rc.value & !document.message_form.rv_rc.value) {
            alert("내용을 전부 기입하여 주십시오.");
            document.message_form.content.focus();
            return;
        }
        document.message_form.submit();
    }
</script>

<!-- <section>
    <div id = "messagebox">
        <h3 id = "write_title">
            쪽지 보내기
        </h3>
        <ul class="top_buttons">
            <li><span><a href="message_box.php?mode=rv">수신 쪽지함</a></span></li>
            <li><span><a href="message_box.php?mode=send">송신 쪽지함</a></span></li>
        </ul>
        <form name="message_form" method="post" action="message_insert.php?send_id=<?= $userid ?>">
            <div id="write_msg">
                <ul>
                    <li>
                        <span class="col1">수신 아이디 : </span>
                        <span class="col2"><input name="rv_id" type="text"></span>
                    </li>
                    <li id = "text_area">
                        <span class="col1">내용 : </span>
                        <span class="col2">
                            <textarea name = "content"></textarea>
                        </span>
                    </li>
                </ul>
                <button type = "button" onclick = "check_input()">등록</button>
            </div>
        </form>
    </div>
</section> -->
   