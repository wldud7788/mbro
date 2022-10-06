<?php /* Template_ 2.2.6 2020/12/29 18:18:16 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl_1/coin/wait.html 000002950 */  $this->include_("sslAction");?>
<style type="text/css">
	/*로딩 css*/

.container {
  height: 100vh;
  width: 100vw;
  font-family: Helvetica;
}

.loader {
  height: 20px;
  width: 250px;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
}
.loader--dot {
  animation-name: loader;
  animation-timing-function: ease-in-out;
  animation-duration: 3s;
  animation-iteration-count: infinite;
  height: 20px;
  width: 20px;
  border-radius: 100%;
  background-color: black;
  position: absolute;
  border: 2px solid white;
}
.loader--dot:first-child {
  background-color: #8cc759;
  animation-delay: 0.5s;
}
.loader--dot:nth-child(2) {
  background-color: #8c6daf;
  animation-delay: 0.4s;
}
.loader--dot:nth-child(3) {
  background-color: #ef5d74;
  animation-delay: 0.3s;
}
.loader--dot:nth-child(4) {
  background-color: #f9a74b;
  animation-delay: 0.2s;
}
.loader--dot:nth-child(5) {
  background-color: #60beeb;
  animation-delay: 0.1s;
}
.loader--dot:nth-child(6) {
  background-color: #fbef5a;
  animation-delay: 0s;
}
.loader--text {
  position: absolute;
  top: 200%;
  left: 0;
  right: 0;
  width: 4rem;
  margin: auto;
}
.loader--text:after {
  content: "Loading";
  font-weight: bold;
  animation-name: loading-text;
  animation-duration: 3s;
  animation-iteration-count: infinite;
}

@keyframes loader {
  15% {
    transform: translateX(0);
  }
  45% {
    transform: translateX(230px);
  }
  65% {
    transform: translateX(230px);
  }
  95% {
    transform: translateX(0);
  }
}
@keyframes loading-text {
  0% {
    content: "Loading";
  }
  25% {
    content: "Loading.";
  }
  50% {
    content: "Loading..";
  }
  75% {
    content: "Loading...";
  }
}

	/*BMP캐시 확인하기 css*/
	.wait_text{font-weight: bold; text-align: center;text-shadow: 18px; margin-bottom: 20px;}
	.wait_btn_box>a{padding:20px; background-color: #343434; color: white; font-size: 22px; display: block; max-width: 270px; margin: 0 auto; box-sizing: border-box;text-align: center; transition: all 0.2s;}
	.wait_btn_box>a:hover{opacity: 0.7;}
</style>
<div class='container'>
	<div style="text-align: center;">
		<h1>잠시만 기다려 주세요</h1>
		<p>전자 지갑 정보를 불러오는 중입니다.</p>
	</div>
	<p class="wait_text">*입금이 확인되신 분은 마이페이지에서 확인이 가능합니다.</p>
	<div class="wait_btn_box">
		<a href="<?php echo sslAction('../mypage/emoney')?>" hrefOri='ez1zc2xBY3Rpb24o' >BMP캐쉬 확인하기</a>
	</div>
 	<div class='loader'>
 		<div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--dot'></div>
	    <div class='loader--text'></div>
	</div>

	    
  	
</div>