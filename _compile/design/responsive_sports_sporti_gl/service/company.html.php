<?php /* Template_ 2.2.6 2022/04/06 17:20:24 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/service/company.html 000007434 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 회사소개 @@
- 파일위치 : [스킨폴더]/service/company.html
- 이미지와 텍스트는 EYE-Design을 켜고 쉽게 수정하세요~
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->


<style type="text/css">


	.service_section.v3 .title1{padding-top: 30px; padding-bottom: 10px;}


	#timeline {
	    display: flex;
	    background-color: #031625;
	}

	#timeline:hover .tl-item {
	    width: 23.3333%;
	}

	.tl-item {
	    transform: translate3d(0, 0, 0);
	    position: relative;
	    width: 25%;
	    min-height: 600px;
	    color: #fff;
	    overflow: hidden;
	    transition: width 0.5s ease;
	}

	.tl-item:before, .tl-item:after {
	    transform: translate3d(0, 0, 0);
	    content: '';
	    position: absolute;
	    left: 0;
	    top: 0;
	    width: 100%;
	    height: 100%;
	}

	.tl-item:after {
	    background: rgba(3, 22, 37, 0.85);
	    opacity: 1;
	    transition: opacity 0.5s ease;
	}

	.tl-item:before {
	    background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, black 75%);
	    z-index: 1;
	    opacity: 0;
	    transform: translate3d(0, 0, 0) translateY(50%);
	    transition: opacity 0.5s ease, transform 0.5s ease;
	}

	.tl-item:hover {
	    width: 30% !important;
	    cursor: default;
	}

	.tl-item:hover:after {
	    opacity: 0;
	}

	.tl-item:hover:before {
	    opacity: 1;
	    transform: translate3d(0, 0, 0) translateY(0);
	    transition: opacity 1s ease, transform 1s ease 0.25s;
	}

	.tl-item:hover .tl-content {
	    opacity: 1;
	    transform: translateY(0);
	    transition: all 0.75s ease 0.5s;
	}

	.tl-item:hover .tl-bg {
	    filter: grayscale(0);
	}
	.tl-item:hover .tl-year{
		top: 30%;
	}

	.tl-content {
	    transform: translate3d(0, 0, 0) translateY(25px);
	    position: relative;
	    z-index: 1;
	    text-align: center;
	    margin: 0 1.618em;
	    top: 40%;
	    opacity: 0;
	}

	.tl-content h1 {
	    font-family: 'Pathway Gothic One',Helvetica Neue,Helvetica,Arial,sans-serif;
	    text-transform: uppercase;
	    color: #fbb738;
	    font-size: 1.3rem;
	    font-weight: bold;
	}
	.tl-content p{font-size: 16px; line-height: 30px;}

	.tl-year {
	    position: absolute;
	    top: 50%;
	    left: 50%;
	    transform: translateX(-50%) translateY(-50%);
	    width: 220px;
	    text-align: center;
	    z-index: 1;
	    border-top: 1px solid #fff;
	    border-bottom: 1px solid #fff;
	    font-size: 17px;
	}

	.tl-bg {
	    transform: translate3d(0, 0, 0);
	    position: absolute;
	    width: 100%;
	    height: 100%;
	    top: 0;
	    left: 0;
	    background-size: cover;
	    background-position: center center;
	    transition: filter 0.5s ease;
	    filter: grayscale(100%);
	}

	@media (max-width: 960px) {
		#timeline {display: block;}
	  .tl-item{width: 100% !important;}
	  .tl-item:hover {width: 100% !important;}
	  .tl-item:hover .tl-content{transform: translateY(70%);}
	}

</style>

<div class="visual_title" style="max-width:1260px; margin: 0px auto 40px auto; padding: 0 15px; box-sizing: border-box; display: none;">
	<div class="img_area">
		<img src="/data/skin/responsive_sports_sporti_gl/images/design/shop_company_img.jpg" alt="회사 이미지" designImgSrcOri='Li4vaW1hZ2VzL2Rlc2lnbi9zaG9wX2NvbXBhbnlfaW1nLmpwZw==' designTplPath='cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3NlcnZpY2UvY29tcGFueS5odG1s' designImgSrc='L2RhdGEvc2tpbi9yZXNwb25zaXZlX3Nwb3J0c19zcG9ydGlfZ2wvaW1hZ2VzL2Rlc2lnbi9zaG9wX2NvbXBhbnlfaW1nLmpwZw==' designElement='image' />
	</div>
	<div class="visual_gon">
		<ul class="title_inner_a">
			<li>
				<p class="descr" designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3NlcnZpY2UvY29tcGFueS5odG1s"  style="color:white;">글로벌 K-POP 플랫폼</p> 
				<h2><span designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9zcG9ydHNfc3BvcnRpX2dsL3NlcnZpY2UvY29tcGFueS5odG1s"  style="color:white;">뮤직브로</span></h2>
			</li>
		</ul>
	</div>
</div>

<div class="visual_title" style="max-width:1260px; margin: 50px auto 50px auto; padding: 0 15px; box-sizing: border-box;">
	<h1 style="text-align: center; color: black; margin-bottom: 10px; font-weight: bold;">What is MusicBro shop?</h1>
	<section id="timeline">
	  	<div class="tl-item">
		    <div class="tl-bg" style="background-image: url(https://musicbroshop.com/data/skin/responsive_sports_sporti_gl_1/images/harry-cunningham-7qCeFo19r24-unsplash.jpg)"></div>
		    <div class="tl-year">
		      <p class="f2 heading--sanSerif">Fresh dive</p>
		    </div>
		    <div class="tl-content">
		      <h1>Fresh dive into Music bro</h1>
		      <p>뮤직브로샵은 ‘MZ세대를 위한 프리미엄 온라인 셀렉트샵입니다.’ 우리는 오직 프리미엄만을 셀렉트 합니다. 프리미엄의 정의는 뮤직브로샵이 내립니다. 꼼꼼히 따져보고 입어보고 먹어본 뮤직브로샵의 안목을 믿으세요.</p>
		    </div>
		</div>

		<div class="tl-item">
		    <div class="tl-bg" style="background-image: url(https://musicbroshop.com/data/skin/responsive_sports_sporti_gl_1/images/uriel-soberanes-MxVkWPiJALs-unsplash.jpg)"></div>
		    <div class="tl-year">
		      <p class="f2 heading--sanSerif">Various shopping Experience</p>
		    </div>
		    <div class="tl-content">
		      <h1 class="f3 text--accent ttu">Various shopping Experience in the web 4.0 generation</h1>
		      <p>뮤직브로샵은 고객의 다양한 쇼핑 경험을 중시합니다. NFT(Non-fungible Token), VR(Virtual Reality)로 선보이는 색다른 쇼핑 경험에 참여해보세요. BMP는 ‘깨끗하고 합리적인 음원유통’을 실현하며 뮤직브로샵 공간 내에서 실구매까지 가능하게 합니다.</p>
		    </div>
		</div>

		<div class="tl-item">
		    <div class="tl-bg" style="background-image: url(https://musicbroshop.com/data/skin/responsive_sports_sporti_gl_1/images/johan-godinez-dDYRYivNzbI-unsplash.jpg)"></div>
		    <div class="tl-year">
		      <p class="f2 heading--sanSerif">Customer satisfaction</p>
		    </div>
		    <div class="tl-content">
		      <h1 class="f3 text--accent ttu">Customer satisfaction is our normal</h1>
		      <p>뮤직브로샵에게 고객 만족은 최고의 기준이자 가치입니다. 우리는 모두가 가격을 가지고 경쟁할 때에, 쇼핑의 본질인 고객 만족을 위해 고군분투합니다. 보다 더 나은 상품을, 보다 더 최신의 감각으로 셀렉트 합니다.</p>
		    </div>
		</div>

		<div class="tl-item">
		    <div class="tl-bg" style="background-image: url(https://musicbroshop.com/data/skin/responsive_sports_sporti_gl_1/images/drew-dizzy-graham-cTKGZJTMJQU-unsplash.jpg)"></div>
		    <div class="tl-year">
		      <p class="f2 heading--sanSerif">irreplaceable</p>
		    </div>
		    <div class="tl-content">
		      <h1 class="f3 text--accent ttu">We are irreplaceable</h1>
		      <p>뮤직브로샵은 대체할 수 없는 수준까지 나아가고자 합니다. 우리만의 정체성을 가지고 고객의 삶과 환경을 더 나은 것으로 만들기 위해 노력합니다. 우리는 감도(Sensitivity)와 시간(Time)을 중요하게 여기며 ‘대체불가능함’을 위해 오늘도 최선을 다합니다.</p>
		    </div>
		</div>
	</section>
</div>