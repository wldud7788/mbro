<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>통합 로그인</title>
    <style>
        .login_frame {
            position: initial;
            width: 100%;
            height: 80%;
            max-height: initial;
            margin-top: -15%;
        }

        .div_frame {
            overflow: hidden;
            max-height: 390px;
        }
    </style>
</head>
<body>
    <div id="div_frame" class="div_frame">
        <iframe class="login_frame" frameborder="0" scrolling="no"></iframe>
    </div>
</body>
<footer>

</footer>
</html>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function (){
        $.ajax({
            url : '/member/totalLogin_url',
            success : function (data) {
                $(".login_frame").attr('src', data);
            },
            error : function (data) {
                console.log(data);
            }
        });
    });
</script>