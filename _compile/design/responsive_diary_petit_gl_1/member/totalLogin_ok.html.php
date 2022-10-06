<?php /* Template_ 2.2.6 2021/06/24 10:48:15 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/member/totalLogin_ok.html 000000642 */  $this->include_("defaultScriptFunc");?>
<html>
<head>
    <title>뮤직브로 로그인</title>
<?php echo defaultScriptFunc()?></head>
<body>
<p id="session_check" value="1">123</p>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var session = document.getElementById('session_check').value;
        console.log(session);
    });
</script>