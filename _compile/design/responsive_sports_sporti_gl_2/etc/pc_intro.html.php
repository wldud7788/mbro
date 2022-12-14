<?php /* Template_ 2.2.6 2022/09/06 16:41:43 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_2/etc/pc_intro.html 000024605 */  $this->include_("defaultScriptFunc");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style type="text/css">

        #layout_body{
            padding: 0 !important;
        }
        .top_wrap{
            width: 100%;
            height: 100vh;
            padding:40px 0;
            box-sizing: border-box;
            background: url(/data/skin/responsive_sports_sporti_gl_2/images/pc_intro_background.jpg) no-repeat 58% -40px;
            background-size: cover;

        }
        .ticket_wrap, .music_wrap, .audition_wrap, .shopping_wrap, .bmp_wrap, .cha_wrap{
            width: 100%;
            /*height: 125vh;*/
            padding:40px 0;
            box-sizing: border-box;
        }
        /*.top_wrap{background-color: black;}*/
        .music_wrap, .shopping_wrap, .cha_wrap{background-color: #FFC900;}

        .music_wrap, .cha_wrap{position: relative; overflow-x: hidden;}
        .title_box{
            width: 100%;
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }
        .title_box>h2{
            font-weight: bold;
            font-size: 35px;
            margin-bottom: 15px;
        }
        .title_box>img{
            width: 20vw;
            margin-bottom: 10px;
        }
        .title_box>p{
            font-size: 18px;
        }
        .store_btn_box{
            margin-bottom: 100px;
            text-align: center;
            position: absolute;
            bottom:0;
            left: 50%;
            transform: translate(-50%, 0);
            width: 100%;
        }
        .store_btn_box>a{padding:0 10px; width: 40%; display: inline-block;}

        .ticket_wrap .title_box, .audition_wrap .title_box, .bmp_wrap .title_box{
            color: #272727;
        }
        .shopping_wrap>.img_box>img{width: 85vw;}

        .pc_ticket_box, .mobile_ticket_box{
            padding: 30px;
            text-align: center;
        }
        .pc_ticket_box>p, .mobile_ticket_box>p{
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .pc_ticket_box>img, .mobile_ticket_box>img{
            margin-bottom: 10px;
        }
        .ticket_price_div{
            display: inline-block;
            background-color: #414141;
            color: white;
            border-radius: 20px;
            width: 45%;
            font-size: 18px;
            padding:10px 5px;
            margin:5px;
            box-sizing: border-box;
        }
        .ticket_price_div>p:nth-of-type(2){
            font-weight: bold;
        }
        .sub_text{
            text-align: left;
            font-size: 14px;
            font-weight: normal;
        }
        .img_box{
            text-align: center;
            z-index: 9;
        }
        .shop_link{
            background-color: #414141;
            color: white;
            border-radius: 10px;
            font-size: 20px;
            padding:15px 20px;
            display: inline-block;
            margin-top: 25px;
        }
        .bmp_img{width: 40%;}

        .footer_box{
            padding:20px;
            text-align: center;
            font-size: 14px;
            margin-top: 60px;
            background-color: #333333;
            color: white;
        }
        .footer_box>a{color: white;}

        .long_banner_box{
            width: 500%;
            position: absolute;
            top: 30%;
            z-index: 8;
            animation:rotation 30s infinite linear;
        }
        @keyframes rotation {
        from: {transform: translate(0);}
        to {transform: translate(-1350px);}
        }

        *{margin:0;padding:0;}

        ul,li{list-style:none;}
        .slide{height:185px;overflow:hidden;}
        .slide ul{width:calc(80% * 5);display:flex;animation:slide 20s infinite linear;} /* slide??? 8????????? ???????????? ???????????? ??? */
        .slide li{width:calc(80% / 5);height:185px;}
        .slide li:nth-child(1){background:url(/data/skin/responsive_sports_sporti_gl_2/images/top_banner_list01.png); background-size: cover;}
        .slide li:nth-child(2){background:url(/data/skin/responsive_sports_sporti_gl_2/images/top_banner_list02.png); background-size: cover;}
        .slide li:nth-child(3){background:url(/data/skin/responsive_sports_sporti_gl_2/images/top_banner_list03.png); background-size: cover;}
        .slide li:nth-child(4){background:url(/data/skin/responsive_sports_sporti_gl_2/images/top_banner_list04.png); background-size: cover;}
        .slide li:nth-child(5){background:url(/data/skin/responsive_sports_sporti_gl_2/images/top_banner_list05.png); background-size: cover;}
        @keyframes slide {
            from {margin-left:0;} /* 0 ~ 10  : ?????? */

            to {margin-left:-255%;}
            /*100% {margin-left:0;}*/
        }

        .banner_list_box{
            position: absolute;
            top: 30%;
            width: 100%;
            overflow-x: hidden;
        }

        .banner {position: relative; width: 270px; height: 185px; margin:0 auto; padding:0; overflow: hidden;}
        .banner ul {position: absolute; margin: 0px; padding:0; list-style: none; }
        .banner ul li {float: left; width: 270px; height: 185px; margin:0; padding:0;}

        .cha_wrap .container {
            margin: 0 auto;
            width: 200px;
            height: 150px;
            position: relative;
            perspective: 1000px;
        }

        .cha_wrap .carousel {
            height: 100%;
            width: 100%;
            position: absolute;
            transform-style: preserve-3d;
            transition: transform 1s;
        }

        .cha_wrap .item {
            display: block;
            position: absolute;
            background: #000;
            width: 200px;
            height: 150px;
            text-align: center;
            color: #FFF;
            /*opacity: 0.95;*/
            border-radius: 10px;
        }

        .cha_wrap .a {
            transform: rotateY(0deg) translateZ(250px);
            /*background: #ed1c24;*/
            border: 1px solid #333333;
            background-color: white;
        }
        .cha_wrap .b {
            transform: rotateY(60deg) translateZ(250px);
            /*background: #0072bc;*/
            border: 1px solid #333333;
            background-color: white;
        }
        .cha_wrap .c {
            transform: rotateY(120deg) translateZ(250px);
            /*background: #39b54a;*/
            border: 1px solid #333333;
            background-color: white;
        }
        .cha_wrap .d {
            transform: rotateY(180deg) translateZ(250px);
            /*background: #f26522;*/
            border: 1px solid #333333;
            background-color: white;
        }
        .cha_wrap .e {
            transform: rotateY(240deg) translateZ(250px);
            /*background: #630460;*/
            border: 1px solid #333333;
            background-color: white;
        }
        .cha_wrap .f {
            transform: rotateY(300deg) translateZ(250px);
            /*background: #8c6239;*/
            border: 1px solid #333333;
            background-color: white;
        }

        .cha_wrap .next, .cha_wrap .prev {
            color: #444;
            /*position: absolute;*/
            display: inline-block;
            /*top: 100px;*/
            bottom: 20px;
            padding: 1em 2em;
            cursor: pointer;
            background: #CCC;
            border-radius: 5px;
            border-top: 1px solid #FFF;
            box-shadow: 0 5px 0 #999;
            transition: box-shadow 0.1s, top 0.1s;
        }
        .cha_wrap .next{float: right;}
        .cha_wrap .next:hover, .prev:hover { color: #000; }
        .cha_wrap .next:active, .prev:active {
            top: 104px;
            box-shadow: 0 1px 0 #999;
        }
        .cha_wrap .next { margin-right: 10%; }
        .cha_wrap .prev { margin-left: 10%; }

        .cha_wrap .item img{height: 100%;}

        .cha_next_btn{margin-top: 50px;}
        #layout_header, #layout_footer{display: none;}
    </style>
<?php echo defaultScriptFunc()?></head>
<body>
<div class="top_wrap">
    <div class="store_box">
        <div class="title_box">
            <h2>????????? K-POP ?????????</h2>
            <img src="/data/skin/responsive_sports_sporti_gl_2/images/logo2.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2xvZ28yLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvbG9nbzIucG5n' designElement='image' >
            <p>?????? ???????????? ??? ??????????????????</p>
        </div>
        <div class="store_btn_box">
            <a href="https://play.google.com/store/apps/details?id=com.musicbrother.app" target="_" hrefOri='aHR0cHM6Ly9wbGF5Lmdvb2dsZS5jb20vc3RvcmUvYXBwcy9kZXRhaWxzP2lkPWNvbS5tdXNpY2Jyb3RoZXIuYXBw' >
                <img src="/data/skin/responsive_sports_sporti_gl_2/images/google_store.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2dvb2dsZV9zdG9yZS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvZ29vZ2xlX3N0b3JlLnBuZw==' designElement='image' >
            </a>
            <a href="https://apps.apple.com/us/app/%EB%AE%A4%EC%A7%81%EB%B8%8C%EB%A1%9C-musicbro/id1537070798" target="_" hrefOri='aHR0cHM6Ly9hcHBzLmFwcGxlLmNvbS91cy9hcHAvJUVCJUFFJUE0JUVDJUE3JTgxJUVCJUI4JThDJUVCJUExJTlDLW11c2ljYnJvL2lkMTUzNzA3MDc5OA==' >
                <img src="/data/skin/responsive_sports_sporti_gl_2/images/apple_store.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2FwcGxlX3N0b3JlLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvYXBwbGVfc3RvcmUucG5n' designElement='image' >
            </a>
        </div>
    </div>
</div>

<div class="ticket_wrap">
    <div class="title_box">
        <h2>???????????? ?????????</h2>
        <p>????????? ??????????????? ????????????</p>
    </div>

    <div class="pc_ticket_box">
        <p>PC + MOBILE</p>
        <img src="/data/skin/responsive_sports_sporti_gl_2/images/pc_ticket_img.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL3BjX3RpY2tldF9pbWcucG5n' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvcGNfdGlja2V0X2ltZy5wbmc=' designElement='image' >
        <div class="ticket_price_box">
            <!-- <div class="ticket_price_div">
                <p>??????(30???) ?????????</p>
                <p>8400???</p>
            </div> -->
            <div class="ticket_price_div">
                <p>?????? ?????? ?????????</p>
                <!-- <p>7900???</p> -->
            </div>
        </div>
        <div class="sub_text">
            <p>???????????? ?????? ?????? <br>
                ???????????? ????????? ??????????????? ??????????????? ???????????? ??? ????????????.<br>
                ????????? ????????? ????????? + ?????????(10%) ???????????? ???????????????.
            </p>
        </div>
    </div>

    <div class="mobile_ticket_box">
        <p>MOBILE</p>
        <img src="/data/skin/responsive_sports_sporti_gl_2/images/mobile_ticket_img.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL21vYmlsZV90aWNrZXRfaW1nLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvbW9iaWxlX3RpY2tldF9pbWcucG5n' designElement='image' >
        <div class="ticket_price_box">
            <!-- <div class="ticket_price_div">
                <p>??????(30???) ?????????</p>
                <p>7400???</p>
            </div> -->
            <div class="ticket_price_div">
                <p>?????? ?????? ?????????</p>
                <!-- <p>6900???</p> -->
            </div>
        </div>
        <div class="sub_text">
            <p>???????????? ?????? ?????? <br>
                ???????????? ????????? ??????????????? ??????????????? ???????????? ??? ????????????.<br>
                ????????? ????????? ????????? + ?????????(10%) ???????????? ???????????????.<br>
                ???App????????? ?????? ????????? ?????? ???????????? ????????? ???????????????.

            </p>
        </div>
    </div>
</div>

<div class="music_wrap">
    <div class="title_box">
        <h2>?????? ??????</h2>
        <p>?????????????????? ????????? ????????? ???????????????</p>
    </div>

    <div class="img_box">
        <img src="/data/skin/responsive_sports_sporti_gl_2/images/music_img.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL211c2ljX2ltZy5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvbXVzaWNfaW1nLnBuZw==' designElement='image' >
    </div>
    <!-- <div class="long_banner_box">
        <img src="/data/skin/responsive_sports_sporti_gl_2/images/long_banner.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2xvbmdfYmFubmVyLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvbG9uZ19iYW5uZXIucG5n' designElement='image' >
    </div> -->
    <div class="banner_list_box">
        <!-- <div class="slide">
            <ul>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
              <li></li>
            </ul>
        </div> -->
        <div class="banner">
            <ul>
                <li><img src="/data/skin/responsive_sports_sporti_gl_2/images/top_banner_list01.png" width="270" height="185px" designImgSrcOri='Li4vaW1hZ2VzL3RvcF9iYW5uZXJfbGlzdDAxLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvdG9wX2Jhbm5lcl9saXN0MDEucG5n' designElement='image' ></li>
                <li><img src="/data/skin/responsive_sports_sporti_gl_2/images/top_banner_list02.png" width="270" height="185px" designImgSrcOri='Li4vaW1hZ2VzL3RvcF9iYW5uZXJfbGlzdDAyLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvdG9wX2Jhbm5lcl9saXN0MDIucG5n' designElement='image' ></li>
                <li><img src="/data/skin/responsive_sports_sporti_gl_2/images/top_banner_list03.png" width="270" height="185px" designImgSrcOri='Li4vaW1hZ2VzL3RvcF9iYW5uZXJfbGlzdDAzLnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvdG9wX2Jhbm5lcl9saXN0MDMucG5n' designElement='image' ></li>
                <li><img src="/data/skin/responsive_sports_sporti_gl_2/images/top_banner_list04.png" width="270" height="185px" designImgSrcOri='Li4vaW1hZ2VzL3RvcF9iYW5uZXJfbGlzdDA0LnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvdG9wX2Jhbm5lcl9saXN0MDQucG5n' designElement='image' ></li>
                <li><img src="/data/skin/responsive_sports_sporti_gl_2/images/top_banner_list05.png" width="270" height="185px" designImgSrcOri='Li4vaW1hZ2VzL3RvcF9iYW5uZXJfbGlzdDA1LnBuZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvdG9wX2Jhbm5lcl9saXN0MDUucG5n' designElement='image' ></li>
            </ul>
        </div>
    </div>


    <script type="text/javascript">

        $(document).ready(function() {
            var $banner = $(".banner").find("ul");

            var $bannerWidth = $banner.children().outerWidth();//???????????? ???
            var $bannerHeight = $banner.children().outerHeight(); // ??????
            var $length = $banner.children().length;//???????????? ??????
            var rollingId;

            //????????? ????????? ?????? ??????
            rollingId = setInterval(function() { rollingStart(); }, 1500);//?????? ???????????? ?????? ??????????????? ??? ?????????

            function rollingStart() {
                $banner.css("width", $bannerWidth * $length + "px");
                $banner.css("height", $bannerHeight + "px");
                //alert(bannerHeight);

                //????????? ?????? ????????? ?????? ??????.
                $banner.animate({left: - $bannerWidth + "px"}, 1500, function() { //????????? ?????? ???????????? ????????????.
                    //????????? ???????????? ????????? ?????? ??????(????????? ????????? ??????)?????? ????????????.
                    $(this).append("<li>" + $(this).find("li:first").html() + "</li>");

                    //?????? ????????? ????????? ???????????? ?????? ????????? ????????????.
                    $(this).find("li:first").remove();

                    //?????? ???????????? ????????? ?????? ????????? ???????????? ????????? ??????.
                    $(this).css("left", 0);
                    //??? ????????? ??????????????? ?????? ???????????? ????????? ?????? ??? ??????.
                });
            }
        });



    </script>
</div>

<div class="audition_wrap">
    <div class="title_box">
        <h2>?????? ?????????</h2>
        <p>??? ???????????? <strong>10???!</strong></p>
        <p>K-POP ???????????? ????????? ???????????? ??? ??? ????????????.</p>
    </div>

    <div class="img_box">

        <img src="/data/skin/responsive_sports_sporti_gl_2/images/audition_img.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL2F1ZGl0aW9uX2ltZy5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvYXVkaXRpb25faW1nLnBuZw==' designElement='image' ><br>
        <video id="audition_cf" src="https://musicbroshop.com/data/skin/responsive_diary_petit_gl/images/musicbro_cf.mp4" width="400" controls autoplay muted loop></video>
        <script type="text/javascript">
            $(function(){
                document.getElementById('audition_cf').play();

            });
        </script>
        <a href="https://audition.music-brother.com" class="shop_link" hrefOri='aHR0cHM6Ly9hdWRpdGlvbi5tdXNpYy1icm90aGVyLmNvbQ==' >????????? ????????????</a>
    </div>
</div>

<div class="shopping_wrap">
    <div class="title_box">
        <h2>?????? ??????</h2>
        <p>????????? ????????? BMP??????????????? ?????? ??????!</p>
    </div>

    <div class="img_box">
        <img src="/data/skin/responsive_sports_sporti_gl_2/images/shopping_img.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL3Nob3BwaW5nX2ltZy5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvc2hvcHBpbmdfaW1nLnBuZw==' designElement='image' ><br>
        <a href="https://musicbroshop.com" class="shop_link" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29t' >????????? ????????????</a>
    </div>
</div>

<div class="bmp_wrap">
    <div class="title_box">
        <h2>BMP??????</h2>
        <p>BMP???????????? ??????, ??????, ???????????????!</p>
    </div>

    <div class="img_box">
        <img src="/data/skin/responsive_sports_sporti_gl_2/images/bmp_img.png" alt="" class="bmp_img" designImgSrcOri='Li4vaW1hZ2VzL2JtcF9pbWcucG5n' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvYm1wX2ltZy5wbmc=' designElement='image' ><br>
        <a href="https://musicbroshop.com/coin/coin_notice" class="shop_link" hrefOri='aHR0cHM6Ly9tdXNpY2Jyb3Nob3AuY29tL2NvaW4vY29pbl9ub3RpY2U=' >BMP ????????????</a>
    </div>
</div>

<div class="cha_wrap">
    <div class="title_box" style="margin-bottom: 70px;">
        <h2>???????????????</h2>
        <p>??????????????? ????????? ???????????? ??????????????????</p>
    </div>

    <div class="container">
        <div class="carousel">
            <div class="item a">
                <img src="/data/skin/responsive_sports_sporti_gl_2/images/pc_int_cha01.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL3BjX2ludF9jaGEwMS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvcGNfaW50X2NoYTAxLnBuZw==' designElement='image' >
            </div>
            <div class="item b">
                <img src="/data/skin/responsive_sports_sporti_gl_2/images/pc_int_cha02.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL3BjX2ludF9jaGEwMi5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvcGNfaW50X2NoYTAyLnBuZw==' designElement='image' >
            </div>
            <div class="item c">
                <img src="/data/skin/responsive_sports_sporti_gl_2/images/pc_int_cha03.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL3BjX2ludF9jaGEwMy5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvcGNfaW50X2NoYTAzLnBuZw==' designElement='image' >
            </div>
            <div class="item d">
                <img src="/data/skin/responsive_sports_sporti_gl_2/images/pc_int_cha04.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL3BjX2ludF9jaGEwNC5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvcGNfaW50X2NoYTA0LnBuZw==' designElement='image' >
            </div>
            <div class="item e">
                <img src="/data/skin/responsive_sports_sporti_gl_2/images/pc_int_cha05.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL3BjX2ludF9jaGEwNS5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvcGNfaW50X2NoYTA1LnBuZw==' designElement='image' >
            </div>
            <div class="item f">
                <img src="/data/skin/responsive_sports_sporti_gl_2/images/pc_int_cha06.png" alt="" designImgSrcOri='Li4vaW1hZ2VzL3BjX2ludF9jaGEwNi5wbmc=' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsXzIvZXRjL3BjX2ludHJvLmh0bWw=' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2xfMi9pbWFnZXMvcGNfaW50X2NoYTA2LnBuZw==' designElement='image' >
            </div>
        </div>
    </div>
    <div class="cha_next_btn">
        <div class="prev">Prev</div>
        <div class="next">Next</div>
    </div>
</div>

<script type="text/javascript">

    // https://codepen.io/nopr/pen/rfBJx
    $(document).ready(function(){
        var carousel = $(".cha_wrap .carousel"),
            currdeg  = 0;

        $(".cha_wrap .next").on("click", { d: "n" }, rotate);
        $(".cha_wrap .prev").on("click", { d: "p" }, rotate);

        function rotate(e){
            if(e.data.d=="n"){
                currdeg = currdeg - 60;
            }
            if(e.data.d=="p"){
                currdeg = currdeg + 60;
            }
            carousel.css({
                "-webkit-transform": "rotateY("+currdeg+"deg)",
                "-moz-transform": "rotateY("+currdeg+"deg)",
                "-o-transform": "rotateY("+currdeg+"deg)",
                "transform": "rotateY("+currdeg+"deg)"
            });
        }


    });
</script>

<div class="footer_box">
    <p>(???)???????????????</p>
    <p>?????? : ?????????</p>
    <p>?????? : ??????????????? ????????? ????????? 254-20 2???</p>
    <p>????????????????????? : 112-88-01620</p>
    <p>TEL : 070-5226-1370 &nbsp;&nbsp; ?????? : 070-4009-3707</p>
    <a href="https://mubrothers.com/bbs/content.php?co_id=privacy" style="margin-right: 10px;" hrefOri='aHR0cHM6Ly9tdWJyb3RoZXJzLmNvbS9iYnMvY29udGVudC5waHA/Y29faWQ9cHJpdmFjeQ==' >????????????????????????</a>
    <a href="https://mubrothers.com/bbs/content.php?co_id=provision" hrefOri='aHR0cHM6Ly9tdWJyb3RoZXJzLmNvbS9iYnMvY29udGVudC5waHA/Y29faWQ9cHJvdmlzaW9u' >????????????</a>
</div>


</body>
</html>