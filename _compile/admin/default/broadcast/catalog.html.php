<?php /* Template_ 2.2.6 2022/05/10 14:51:37 /www/music_brother_firstmall_kr/admin/skin/default/broadcast/catalog.html 000004032 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/broadcastList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript">
var scObj = <?php echo $TPL_VAR["scObj"]?>;
</script>
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 좌측 버튼 -->
		<div class="page-buttons-left">
		</div>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>라이브 예약 관리</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 리스트검색폼 : 시작 -->
<?php $this->print_("searchForm",$TPL_SCP,1);?>

<!-- 리스트검색폼 : 끝 -->

<div class="contents_dvs v2">
	<div class="list_info_container">
		<div class="dvs_left">
			<div class="left-btns-txt">검색 <b id="searchcount">0</b> 개 (총 <b id="totalcount"></b>개)</div>
		</div>
		<div class="dvs_right">
			<span class="display_sort" sort="<?php echo $TPL_VAR["sc"]["orderby"]?>"></span>
			<span class="display_quantity" perpage="<?php echo $TPL_VAR["sc"]["perpage"]?>"></span>
		</div>
	</div>

	<div class="table_row_frame">
		<div class="dvs_top">
			<div class="dvs_left">
<?php if(isBroadcastVersion('2.0')&&serviceLimit('H_AD')){?>
				<select>

				</select>
				<button class="resp_btn active vertical-middle">변경</button>
<?php }?>
			</div>
			<div class="dvs_right">
				<div class="live-used-stat">
					<dl>
						<dt>트래픽</dt>
						<dd><span id="used_live_traffics">0</span></dd>
					</dl>
				</div>
				<button class="resp_btn active broad_create">방송 예약</button>
				<button class="resp_btn v3 go_live_page">라이브 보기</button>
			</div>
		</div>

		<table class="table_row_basic list">
			<colgroup>
				<col width="5%" /> <!--번호-->
				<col width="10%" /> <!--방송 제목-->
				<col width="*" /> <!--방송 제목-->
				<col width="18%" /> <!--상품-->
				<col width="13%" /> <!--방송일-->
				<col width="8%" /> <!--상태-->
				<col width="8%" /> <!--노출-->
				<col width="8%" /> <!--시청-->
				<col width="9%" /> <!--관리-->
			</colgroup>
			<thead>
				<tr>
					<th>번호</th>
<?php if(isBroadcastVersion('2.0')&&serviceLimit('H_AD')){?>
					<th>승인 여부</th>
<?php }?>
					<th colspan="2">방송 제목</th>
					<th>방송 상품</th>
<?php if(isBroadcastVersion('2.0')&&serviceLimit('H_AD')){?>
					<th>입점사</th>
<?php }?>
					<th>방송일</th>
					<th>방송 상태</th>
					<th>노출</th>
					<th>방송 시청</th>
					<th>관리</th>
				</tr>
			</thead>
			<tbody id="broad_catalog">
			</tbody>
		</table>
	</div>
	<div class="paging_navigation"></div>
</div>
<!-- 서브 레이아웃 영역 : 끝 -->

<div id="broadcast_info" class="hide">
	<div class="content">
		퍼스트몰 라이브 쇼핑 서비스가 신청되지 않았습니다.<br/>
		서비스를 신청하겠습니까?
	</div>
	<div class="center mt20">
		<button type="button" class="resp_btn active size_XL goInfo">확인</button>
		<button type="button" class="resp_btn v3 size_XL" onclick="javascript:history.back();">이전</button>
	</div>
</div>
<div id="broadcast_ssl" class="hide">
	<div class="content">
		퍼스트몰 라이브 쇼핑 이용을 위해서<br/>
		SSL 인증서를 먼저 설치해주세요.
	</div>
	<div class="center mt20">
		<button type="button" class="resp_btn active size_XL goSsl">확인</button>
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialog('broadcast_ssl')">닫기</button>
	</div>
</div>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>