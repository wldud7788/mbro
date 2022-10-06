<?php /* Template_ 2.2.6 2022/03/18 15:13:31 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl_1/coin/loading.html 000003788 */  $this->include_("sslAction");?>
<style>
  .container {

  font-family: Helvetica;
}

.loader {
  height: 60px;
  width: 250px;
/*  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;*/
  margin: 30px auto;
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
  background-color: gray;
  animation-delay: 0.5s;
}
.loader--dot:nth-child(2) {
  background-color: lightgray;
  animation-delay: 0.4s;
}
.loader--dot:nth-child(3) {
  background-color: gray;
  animation-delay: 0.3s;
}
.loader--dot:nth-child(4) {
  background-color: lightgray;
  animation-delay: 0.2s;
}
.loader--dot:nth-child(5) {
  background-color: gray;
  animation-delay: 0.1s;
}
.loader--dot:nth-child(6) {
  background-color: lightgray;
  animation-delay: 0s;
}
.loader--text {
  /*position: absolute;*/
/*  top: 200%;
  left: 0;
  right: 0;*/
  width: 4rem;
  margin: auto;
  padding-top: 50px; 
  box-sizing: border-box;
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
  .wait_btn_box{
    top: 50%; position: relative; z-index: 9; text-align: center;
  }
  .wait_btn_box>a{padding:20px;  font-size: 22px; display: block; max-width: 270px; margin: 0 auto; box-sizing: border-box;text-align: center; transition: all 0.2s;}
  .wait_btn_box>a:hover{opacity: 0.7;}

  .wait_btn_box>a:nth-of-type(1){background-color: #343434; color: white;}
  .wait_btn_box>a:nth-of-type(2){background-color: #AFAFAF; color: black; }

  .popup_close_text{color:maroon; font-size: 20px; margin-top: 10px; font-weight: bold;}
  .bmp_loading_box{height: 60vh ;}


  @media (max-width: 500px){
    .wait_btn_box{top: 45%;}
    .popup_close_text{font-size: 16px;}
    .bmp_loading_box{height: auto; padding-top: 60px;}
  }
</style>
<div class="bmp_loading_box">
  
    <div style="text-align: center; top: 40%; position: relative;">
      <h2>잠시만 기다려 주세요</h2>
      <p>전자 지갑 정보를 불러오는 중입니다.</p>
      <p class="popup_close_text">* 팝업이 안뜨시는 경우 팝업 차단을 해제 해주시기 바랍니다.</p>
      <div class='loader'>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--text'></div>
      </div>
      <a href="/mypage/myinfo" hrefOri='L215cGFnZS9teWluZm8=' >문자로 캐시 지급 현황을 확인 하고 싶으시면 여기를 클릭해 주세</a>
    </div>
  <div class="wait_btn_box" style="">
    <a href="<?php echo sslAction('../mypage/emoney')?>" hrefOri='ez1zc2xBY3Rpb24o' >BMP 전환 확인하기</a>
    <a href="../coin/coin_notice" hrefOri='Li4vY29pbi9jb2luX25vdGljZQ==' >이전 화면</a>
  </div>
</div>