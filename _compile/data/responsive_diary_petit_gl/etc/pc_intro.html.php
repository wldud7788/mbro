<?php /* Template_ 2.2.6 2021/02/15 11:46:33 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/etc/pc_intro.html 000015492 */  $this->include_("defaultScriptFunc");?>
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
			background: url(/data/skin/responsive_diary_petit_gl/images/pc_intro_background.jpg) no-repeat 58% -40px;
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
	    .slide ul{width:calc(80% * 5);display:flex;animation:slide 20s infinite linear;} /* slide를 8초동안 진행하며 무한반복 함 */
	    .slide li{width:calc(80% / 5);height:185px;}
	    .slide li:nth-child(1){background:url(/data/skin/responsive_diary_petit_gl/images/top_banner_list01.png); background-size: cover;}
	    .slide li:nth-child(2){background:url(/data/skin/responsive_diary_petit_gl/images/top_banner_list02.png); background-size: cover;}
	    .slide li:nth-child(3){background:url(/data/skin/responsive_diary_petit_gl/images/top_banner_list03.png); background-size: cover;}
	    .slide li:nth-child(4){background:url(/data/skin/responsive_diary_petit_gl/images/top_banner_list04.png); background-size: cover;}
	    .slide li:nth-child(5){background:url(/data/skin/responsive_diary_petit_gl/images/top_banner_list05.png); background-size: cover;}
	    @keyframes slide {
	      from {margin-left:0;} /* 0 ~ 10  : 정지 */

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
	</style>
<?php echo defaultScriptFunc()?></head>
<body>
	<div class="top_wrap">
		<div class="store_box">
			<div class="title_box">
				<h2>글로벌 K-POP 놀이터</h2>
				<img src="/data/skin/responsive_diary_petit_gl/images/logo2.png" alt="">
				<p>어플 다운로드 후 이용해주세요</p>
			</div>
			<div class="store_btn_box">
				<a href="https://play.google.com/store/apps/details?id=com.musicbrother.app" target="_">
					<img src="/data/skin/responsive_diary_petit_gl/images/google_store.png" alt="">
				</a>
				<a href="https://apps.apple.com/us/app/%EB%AE%A4%EC%A7%81%EB%B8%8C%EB%A1%9C-musicbro/id1537070798" target="_">
					<img src="/data/skin/responsive_diary_petit_gl/images/apple_store.png" alt="">
				</a>
			</div>
		</div>
	</div>

	<div class="ticket_wrap">
		<div class="title_box">
			<h2>뮤직브로 이용권</h2>
			<p>원하는 이용권으로 이용하기</p>
		</div>

		<div class="pc_ticket_box">
			<p>PC + MOBILE</p>
			<img src="/data/skin/responsive_diary_petit_gl/images/pc_ticket_img.png" alt="">
			<div class="ticket_price_box">
				<!-- <div class="ticket_price_div">
					<p>기간(30일) 이용권</p>
					<p>8400원</p>
				</div> -->
				<div class="ticket_price_div">
					<p>정기 결제 이용권</p>
					<!-- <p>7900원</p> -->
				</div>
			</div>
			<div class="sub_text">
				<p>ㆍ무제한 음악 감상 <br>
					ㆍ자세한 금액은 이용권구매 페이지에서 확인하실 수 있습니다.<br>
				   ㆍ실제 결제는 이용권 + 부가세(10%) 금액으로 결제됩니다.
				</p>
			</div>
		</div>

		<div class="mobile_ticket_box">
			<p>MOBILE</p>
			<img src="/data/skin/responsive_diary_petit_gl/images/mobile_ticket_img.png" alt="">
			<div class="ticket_price_box">
				<!-- <div class="ticket_price_div">
					<p>기간(30일) 이용권</p>
					<p>7400원</p>
				</div> -->
				<div class="ticket_price_div">
					<p>정기 결제 이용권</p>
					<!-- <p>6900원</p> -->
				</div>
			</div>
			<div class="sub_text">
				<p>ㆍ무제한 음악 감상 <br>
					ㆍ자세한 금액은 이용권구매 페이지에서 확인하실 수 있습니다.<br>
					ㆍ실제 결제는 이용권 + 부가세(10%) 금액으로 결제됩니다.<br>
				   ㆍApp에서의 결제 금액은 인앱 수수료가 포함된 금액입니다. 
				   
				</p>
			</div>
		</div>
	</div>

	<div class="music_wrap">
		<div class="title_box">
			<h2>나의 음악</h2>
			<p>뮤직브로에서 나만의 음악을 즐겨보세요</p>
		</div>

		<div class="img_box">
			<img src="/data/skin/responsive_diary_petit_gl/images/music_img.png" alt="">
		</div>
		<!-- <div class="long_banner_box">
			<img src="/data/skin/responsive_diary_petit_gl/images/long_banner.png" alt="">
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
					<li><img src="/data/skin/responsive_diary_petit_gl/images/top_banner_list01.png" width="270" height="185px"></li>
					<li><img src="/data/skin/responsive_diary_petit_gl/images/top_banner_list02.png" width="270" height="185px"></li>
					<li><img src="/data/skin/responsive_diary_petit_gl/images/top_banner_list03.png" width="270" height="185px"></li>
					<li><img src="/data/skin/responsive_diary_petit_gl/images/top_banner_list04.png" width="270" height="185px"></li>
					<li><img src="/data/skin/responsive_diary_petit_gl/images/top_banner_list05.png" width="270" height="185px"></li>
				</ul>
			</div>
		</div>
		

		<script type="text/javascript">

			$(document).ready(function() {
				var $banner = $(".banner").find("ul");

				var $bannerWidth = $banner.children().outerWidth();//이미지의 폭
				var $bannerHeight = $banner.children().outerHeight(); // 높이
				var $length = $banner.children().length;//이미지의 갯수
				var rollingId;

				//정해진 초마다 함수 실행
				rollingId = setInterval(function() { rollingStart(); }, 1500);//다음 이미지로 롤링 애니메이션 할 시간차
		    
				function rollingStart() {
					$banner.css("width", $bannerWidth * $length + "px");
					$banner.css("height", $bannerHeight + "px");
					//alert(bannerHeight);

					//배너의 좌측 위치를 옮겨 준다.
					$banner.animate({left: - $bannerWidth + "px"}, 1500, function() { //숫자는 롤링 진행되는 시간이다.
						//첫번째 이미지를 마지막 끝에 복사(이동이 아니라 복사)해서 추가한다.
						$(this).append("<li>" + $(this).find("li:first").html() + "</li>");

						//뒤로 복사된 첫번재 이미지는 필요 없으니 삭제한다.
						$(this).find("li:first").remove();

						//다음 움직임을 위해서 배너 좌측의 위치값을 초기화 한다.
						$(this).css("left", 0);
						//이 과정을 반복하면서 계속 롤링하는 배너를 만들 수 있다.
					});
				}
			}); 

	

		</script>
	</div>

	<div class="audition_wrap">
		<div class="title_box">
			<h2>나의 오디션</h2>
			<p>총 우승상금 <strong>10억!</strong></p>
			<p>K-POP 팬이라면 누구나 주인공이 될 수 있습니다.</p>
		</div>

		<div class="img_box">
			
			<img src="/data/skin/responsive_diary_petit_gl/images/audition_img.png" alt=""><br>
			<video id="audition_cf" src="https://musicbroshop.com/data/skin/responsive_diary_petit_gl/images/musicbro_cf.mp4" width="400" controls autoplay muted loop></video>
			<script type="text/javascript">
				$(function(){
					document.getElementById('audition_cf').play();

				});
			</script>
			<a href="https://audition.music-brother.com" class="shop_link">오디션 바로가기</a>
		</div>
	</div>

	<div class="shopping_wrap">
		<div class="title_box">
			<h2>나의 쇼핑</h2>
			<p>다양한 상품을 BMP코인으로도 구매 가능!</p>
		</div>

		<div class="img_box">
			<img src="/data/skin/responsive_diary_petit_gl/images/shopping_img.png" alt=""><br>
			<a href="https://musicbroshop.com" class="shop_link">쇼핑몰 바로가기</a>
		</div>
	</div>

	<div class="bmp_wrap">
		<div class="title_box">
			<h2>BMP코인</h2>
			<p>BMP코인으로 음원, 쇼핑, 오디션까지!</p>
		</div>

		<div class="img_box">
			<img src="/data/skin/responsive_diary_petit_gl/images/bmp_img.png" alt="" class="bmp_img"><br>
			<a href="https://musicbroshop.com/coin/coin_notice" class="shop_link">BMP 알아보기</a>
		</div>
	</div>

	<div class="cha_wrap">
		<div class="title_box" style="margin-bottom: 70px;">
			<h2>캐릭터보기</h2>
			<p>뮤직브로의 다양한 캐릭터를 구경해보세요</p>
		</div>

		<div class="container">
		  	<div class="carousel">
			    <div class="item a">
			    	<img src="/data/skin/responsive_diary_petit_gl/images/pc_int_cha01.png" alt="">
			    </div>
			    <div class="item b">
			    	<img src="/data/skin/responsive_diary_petit_gl/images/pc_int_cha02.png" alt="">
			    </div>
			    <div class="item c">
			    	<img src="/data/skin/responsive_diary_petit_gl/images/pc_int_cha03.png" alt="">
			    </div>
			    <div class="item d">
			    	<img src="/data/skin/responsive_diary_petit_gl/images/pc_int_cha04.png" alt="">
			    </div>
			    <div class="item e">
			    	<img src="/data/skin/responsive_diary_petit_gl/images/pc_int_cha05.png" alt="">
			    </div>
			    <div class="item f">
			    	<img src="/data/skin/responsive_diary_petit_gl/images/pc_int_cha06.png" alt="">
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
		<p>(주)음악형제들</p>
		<p>대표 : 김경민</p>
		<p>주소 : 서울특별시 강남구 논현동 254-20 2층</p>
		<p>사업자등록번호 : 112-88-01620</p>
		<p>TEL : 070-5226-1370 &nbsp;&nbsp; 팩스 : 070-4009-3707</p>
		<a href="https://mubrothers.com/bbs/content.php?co_id=privacy" style="margin-right: 10px;">개인정보처리방침</a>
		<a href="https://mubrothers.com/bbs/content.php?co_id=provision">이용약관</a>
	</div>


</body>
</html>