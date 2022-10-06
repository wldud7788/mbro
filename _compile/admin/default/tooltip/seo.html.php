<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/tooltip/seo.html 000009136 */ ?>
<div id="tip1" class="tip_wrap">
	<h1>검색로봇 접근 권한 설정</h1>
	
	<div class="con_wrap">
		<ul class="bullet_hyphen exp">
			<li>검색로봇이란, 검색엔진(네이버, 다음, 구글 등)에서 검색결과(데이터베이스)를 업데이트 하기 위해 웹페이지에 접근하여 정보를 가져가는 프로그램을 말입니다.</li>	
			<li>특정 검색 로봇의 접근을 제어하고 싶은 경우 아래 예시 내용을 참고하여 robots.txt 파일을 작성하여 업로드 해주시기 바랍니다.</li>
			<li>별도로 robots.txt 파일을 업로드 하지 않은 경우 모든 검색엔진의 검색로봇 접근을 기본 허용합니다</li>			
		</ul>
		
		<ul class="bullet_circle_in list_01">
			<li>
				작성 예시: 모든 검색엔진에 대하여 사이트 전체 접근 허용 			
				<div class="section">
					<div class="box_style">
						User-agent: *<br>
						Allow: /
					</div>
				</div>
			</li>
			<li>
				작성 예시: 모든 검색엔진에 대하여 사이트 전체 접근 차단 			
				<div class="section">
					<div class="box_style">
						User-agent: *<br>
						Disallow: /
					</div>
				</div>
			</li>
			<li>
				작성 예시: 모든 검색엔진에 대하여 사이트 admin 디렉토리 접근 차단			
				<div class="section">
					<div class="box_style">
						User-agent: *<br>
						Disallow: /admin/
					</div>
				</div>
			</li>
			<li>
				작성 예시: 특정 검색엔진(구글)에 대하여 사이트 전체 접근 차단		
				<div class="section">
					<div class="box_style">
						User-agent: Googlebot<br>
						Disallow: /
					</div>
				</div>
			</li>
		</ul>
		
		<div class="mt30">※ 주요 검색엔진 검색로봇</div>
		<ul class="bullet_hyphen exp">
			<li>구글 : Googlebot </li>	
			<li>구글이미지 : Googlebot-image</li>
			<li>구글모바일 : Googelbot-mobile</li>
			<li>네이버 : naverbot, yeti</li>
			<li>다음 : daumos</li>
		</ul>
	</div>
</div>

<div id="tip2" class="tip_wrap">
	<h1>사이트 맵</h1>
	
	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>사이트 맵이란? 검색엔진 로봇의 효율적인 검색을 돕기 위해 사이트의 URL 목록과 추가적인 정보(업데이트 날짜, 변경 빈도, 상대적 중요도)를 함께 사이트 내의 URL로 제공하는 XML 형태의 파일입니다.</li>				
			<li>사이트맵 제작 사이트: http://www.web-site-map.com</li>
		</ul>
		
		<ul class="bullet_circle_in list_01">
			<li>
				작성 방법 안내
				<ul class="bullet_hyphen">
					<li>확장자가 .xml 인 파일만 등록 가능합니다.</li>	
				</ul>

				<div class="section">
					<div class="box_style">
						<ul>
							<li class="title">1. 작성 예시</li>
							<li>
								<pre>
&lt;?xml version="1.0" encoding="UTF-8" ?&gt;
&lt;urlset xmlns="http://www.google.com/schemas/sitemap/0.90"&gt;
  &lt;url&gt;
	&lt;loc&gt;http://www.sitemappro.com/&lt;/loc&gt;
	&lt;lastmod&gt;2016-02-27T23:55:42+01:00&lt;/lastmod&gt;
	&lt;changefreq&gt;daily&lt;/changefreq&gt;
	&lt;priority&gt;0.5&lt;/priority&gt;
  &lt;/url&gt;
  &lt;url&gt;
	&lt;loc&gt;http://www.sitemappro.com/download.html&lt;/loc&gt;
	&lt;lastmod&gt;2016-02-26T17:24:27+01:00&lt;/lastmod&gt;
	&lt;changefreq&gt;daily&lt;/changefreq&gt;
	&lt;priority&gt;0.5&lt;/priority&gt;
  &lt;/url&gt;
  &lt;url&gt;
	&lt;loc&gt;http://www.sitemappro.com/kb02.html&lt;/loc&gt;
	&lt;lastmod&gt;2016-02-15T15:48:47+00:00&lt;/lastmod&gt;
	&lt;changefreq&gt;daily&lt;/changefreq&gt;
	&lt;priority&gt;0.5&lt;/priority&gt;
  &lt;/url&gt;
&lt;/urlset&gt;
								</pre>
							</li>					
						</ul>
					</div>
				</div>
			</li>			
		</ul>	
	</div>
</div>

<div id="tip3" class="tip_wrap">
	<h1>검색엔진 수집 정보</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>주요 페이지별로 태그를 설정할 수 있습니다.</li>	
			<li>키워드는 ,(콤마)로 구분해주세요.</li>	
		</ul>	

		<ul class="bullet_circle_in list_01">
			<li>
				작성 방법 안내			
				<table class="table_basic thl mt10">				
					<tr>
						<th>타이틀: title 및 title태그</th>
						<td>퍼스트몰 - 대한민국 No.1 쇼핑몰솔루션, 퍼스트몰</td>
					</tr>		
					
					<tr>
						<th>설명: description</th>
						<td>퍼스트몰은 온라인 쇼핑몰을 운영할 수 있는 무료형, 임대형, 독립형, 입점형의 다양한 솔루션이 있으며, 재고관리가 필요한 쇼핑몰을 위해 재고관리 기능이 탑재된 올인원 쇼핑몰을 제공합니다.</td>
					</tr>

					<tr>
						<th>제작자: author</th>
						<td>퍼스트몰</td>
					</tr>

					<tr>
						<th>키워드: Keyword</th>
						<td>온라인, 쇼핑몰, 커머스, 솔루션</td>
					</tr>
				</table>			
			</li>
		</ul>

		<img src="/admin/skin/default/images/design/metatag.png" width="100%" class="mt15">
	</div>
</div>

<div id="tip4" class="tip_wrap">
	<h1>타이틀: Title</h1>	

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>해당 페이지의 타이틀입니다. 검색 사이트의 검색결과페이지에서 타이틀로 노출되며, 브라우저 상단의 타이틀로도 노출됩니다.</li>		
		</ul>
	</div>
</div>

<div id="tip5" class="tip_wrap">
	<h1>제작자: Author</h1>
	
	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>해당 페이지(또는 사이트)의 제작자명입니다.</li>		
		</ul>
	</div>
</div>

<div id="tip6" class="tip_wrap">
	<h1>설명: Description</h1>
	
	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>해당 페이지의 설명입니다. 검색 사이트 검색 결과 페이지에서 페이지 설명으로 노출됩니다.</li>		
		</ul>
	</div>
</div>

<div id="tip7" class="tip_wrap">
	<h1>키워드: Keywords</h1>	

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>자주 검색하는 검색어를 ,(콤마)로 구분하여 입력하세요.</li>		
		</ul>
	</div>
</div>

<div id="tip8" class="tip_wrap">
	<h1>URL 정보 제공 방식</h1>

	<div class="con_wrap">
		<ul class="bullet_circle_in list_01">
			<li>
				URL 주소 정보 제공 예시
				<ul class="bullet_hyphen">
					<li>예) http://도메인/goods/view?no=1</li>	
				</ul>
			</li>
			<li>
				URL 주소 정보 짧게 변환 예시
				<ul class="bullet_hyphen">
					<li>http://bit.ly/xxxxxxxx </li>	
				</ul>
			</li>	
		</ul>
	</div>
</div>

<div id="tip9" class="tip_wrap">
	<h1>상품 이미지 Alt</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>이미지를 인식할 수 없는 검색엔진에 Alt 태그를 텍스트 형식으로 삽입하여 이미지 정보를 제공합니다.</li>	
			<li>상품 이미지에 Alt 텍스트를 설정함으로 검색 엔진이 상품 이미지를 텍스트로 인식할 수 있습니다.</li>	
		</ul>
	</div>
</div>

<div id="tip10" class="tip_wrap">
	<h1>오픈 그래프 태그</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>
				오픈 그래프 태그(Open Graph) 란 SNS로 상품 정보나 이벤트를 공유 또는 좋아요 할 경우 우선적으로 활용되는 정보를 통합할 수 있는 기능입니다.<br>
				태그 설정을 통해 사용자가 설정한 정보를 우선적으로 제공하고 기존의 웹사이트를 SNS와 연동하여 또 다른 마케팅 플랫폼으로 활용할 수 있습니다.						
			</li>
		</ul>
		<ul class="bullet_circle_in list_01">
			<li>
				설정예시
				<div><img class="section" src="/admin/skin/default/images/common/tt_seo1.jpg" ></div>
			</li>
		</ul>
	</div>
</div>



<div id="tip_seo_title" class="tip_wrap">
	<h1>타이틀: Title</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>
				해당 페이지의 타이틀입니다. 검색 사이트의 검색결과페이지에서 타이틀로 노출되며, 브라우저 상단의 타이틀로도 노출됩니다.			
			</li>
		</ul>
	</div>
</div>


<div id="tip_seo_author" class="tip_wrap">
	<h1>제작자: Author</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>
				해당 페이지(또는 사이트)의 제작자명입니다.	
			</li>
		</ul>
	</div>
</div>


<div id="tip_seo_description" class="tip_wrap">
	<h1>설명: Description</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>
				해당 페이지의 설명입니다. 검색 사이트 검색 결과 페이지에서 페이지 설명으로 노출됩니다.
			</li>
		</ul>
	</div>
</div>


<div id="tip_seo_keywords" class="tip_wrap">
	<h1>키워드: Keywords</h1>

	<div class="con_wrap">
		<ul class="bullet_hyphen">
			<li>
				자주 검색하는 검색어를 ,(콤마)로 구분하여 입력하세요
			</li>
		</ul>
	</div>
</div>