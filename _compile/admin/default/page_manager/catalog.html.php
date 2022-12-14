<?php /* Template_ 2.2.6 2022/05/17 12:36:46 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/catalog.html 000013301 */ 
$TPL_page_list_1=empty($TPL_VAR["page_list"])||!is_array($TPL_VAR["page_list"])?0:count($TPL_VAR["page_list"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
// 안내 팝업창
function menu_desc(page_name, page_code){	
	var title		= '[안내] ' + page_name + ' 페이지';
	var base_table	= $('#base_desc_info').find('.info-table-style').find('tbody');
	var contents	= $('.'+page_code).find('.info-table-style').find('tbody');

	// 코드별 예외처리
	var width	= '1100';
	var height	= '330';
	switch (page_code){
		case 'category'		:
		case 'location'		:
		case 'brand'		:
			height = '330';
			$(contents).find('.variable').html(page_name);
			if(page_code == 'brand')	$(contents).find('.vari_txt').html('브랜드 이미지로 등록하세요.');
			else						$(contents).find('.vari_txt').html('반드시 등록할 필요는 없습니다.');
			break;
		case 'brand_main'	:		height = '310';	break;
		case 'src_result'	:		height = '180';	break;
		case 'bigdata_recommend' :
		case 'newarrival'	:
		case 'best'			:
		case 'all_event'	:
									height = '220';	break;
		case 'sale_event'	:
		case 'gift_event'	:
			height = '250';
			$(contents).find('.variable').html(page_name);
			if(page_code == 'gift_event')	$(contents).find('.vari_txt').html('사은품 이벤트');
			else							$(contents).find('.vari_txt').html('이벤트');
			break;
		case 'minishop'		:
			height = '250';
			break;
		default				:
			width = '1100'; height = '330'; break;
	}
	
	$(base_table).empty(); // 기본테이블 body 제거
	$('#base_desc_info').find('.info-table-style').find('tbody').append($(contents).html()); // 해당 안내문구 body append
	openDialog(title, 'base_desc_info', {"width":width,"height":height});
}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>상품리스트 페이지 관리</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li>&nbsp;</li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li>&nbsp;</li>
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 페이지 관리 검색바 : 시작 -->
<div style="margin-top:20px;">&nbsp;</div>
<!-- 페이지 관리 검색바 : 끝 -->

<!-- 페이지 관리 그리드 : 시작 -->
<?php if($TPL_VAR["page_list"]){?>
<ul class="page_manager_list">
<?php if($TPL_page_list_1){foreach($TPL_VAR["page_list"] as $TPL_V1){?>
	<li>
		<h3 class="title">
			<?php echo $TPL_V1["page_name"]?>

<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
			<span class="guide_btn"><button type="button" onclick="menu_desc('<?php echo $TPL_V1["page_name"]?>','<?php echo $TPL_V1["page_code"]?>');">안내</button></span>
<?php }?>
		</h3>
		<div class="contents">
			<ul class="list">
<?php if(is_array($TPL_R2=$TPL_V1["perform"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<li><?php echo $TPL_V2?></li>
<?php }}?>
			</ul>
		</div>
		<div class="btn_or_text">
<?php if($TPL_V1["manager_type"]=='1'){?>
			<button type="button" class="btn_gon size_c type1" name="set_btn" onclick="location.href='<?php echo $TPL_V1["manager_txt"]?>';">설정</button>
<?php }elseif($TPL_V1["manager_type"]=='2'){?>
			<p class="setting_text"><?php echo $TPL_V1["manager_txt"]?></p>
<?php }?>
		</div>
	</li>
<?php }}?>
</ul>
<?php }?>
<!-- 페이지 관리 그리드 : 끝 -->

<!-- 안내 팝업 : 시작 -->
<!--// 기본 안내 팝업 -->
<div id="base_desc_info" class="hide">
	<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
		<colgroup>
			<col width="*" />
			<col width="*" />
			<col width="*" />
		</colgroup>
		<thead>
		<tr>
			<th class="its-th-align pd10">관리항목</th>
			<th class="its-th-align pd10">안내</th>
			<th class="its-th-align pd10">비고</th>
		</tr>
		</thead>
		<tbody class="tbody">
		</tbody>
	</table>
</div>

<!--// 카테고리, 지역, 브랜드 -->
<div class="category location brand hide">
	<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td class="its-td" width="130px">접속제한</td>
		<td class="its-td">페이지에 접속할 수 있는 사용자를 제한할 수 있습니다.</td>
		<td class="its-td">특수한 경우에만 접속을 제한 하십시오.</td>
	</tr>
	<tr>
		<td class="its-td">배너</td>
		<td class="its-td">페이지에 노출되는 배너를 등록할 수 있습니다.</td>
		<td class="its-td"><span class="variable">카테고리</span> 페이지의 배너를 <span class="vari_txt">반드시 등록할 필요는 없습니다.</span></td>
	</tr>
	<tr>
		<td class="its-td">추천상품</td>
		<td class="its-td">페이지 추천상품 영역의 노출되는 상품을 선정할 수 있습니다.</td>
		<td class="its-td"><span class="variable">카테고리</span> 페이지의 추천상품을 사용자에게 노출 하십시오.</td>
	</tr>
	<tr>
		<td class="its-td">검색필터</td>
		<td class="its-td">페이지의 상품을 상세하게 검색할 수 있는 검색 옵션을 설정할 수 있습니다.</td>
		<td class="its-td"><span class="variable">카테고리</span> 페이지의 검색필터로 사용자가 원하는 상품을 쉽게 찾을 수 있도록 하십시오.</td>
	</tr>
	<tr>
		<td class="its-td">네비게이션 노출/배너</td>
		<td class="its-td">네비게이션의 노출여부를 설정할 수 있습니다.<br/>네비게이션에 노출되는 배너를 등록할 수 있습니다.</td>
		<td class="its-td">특수한 경우에만 미노출 하십시오.</td>
	</tr>
	</tbody>
	</table>
</div>

<!--// 브랜드 메인 -->
<div class="brand_main hide">
	<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td class="its-td" width="150px">배너</td>
		<td class="its-td">페이지에 노출되는 배너를 등록할 수 있습니다.</td>
		<td class="its-td">브랜드 메인 페이지의 배너를 주요 브랜드로 등록 하십시오.</td>
	</tr>
	<tr>
		<td class="its-td">검색필터</td>
		<td class="its-td">페이지의 상품을 상세하게 검색할 수 있는 검색 옵션을 설정할 수 있습니다.</td>
		<td class="its-td">브랜드 메인 페이지의 검색필터로 사용자가 원하는 브랜드를 쉽게 찾을 수 있도록 하십시오.</td>
	</tr>
	<tr>
		<td class="its-td">베스트 브랜드 및 아이콘</td>
		<td class="its-td">베스트 브랜드를 선정하여 사용자에게 베스트 브랜드를 알릴 수 있습니다.</td>
		<td class="its-td">주요 브랜드는 베스트 브랜드로 선정하십시오.</td>
	</tr>
	<tr>
		<td class="its-td">브랜드 이미지</td>
		<td class="its-td">브랜드 이미지를 등록하여 브랜드 메인 페이지에 노출할 수 있습니다.</td>
		<td class="its-td">브랜드 이미지를 등록하여 브랜드를 이미지로 사용자에게 노출하십시오.</td>
	</tr>
	</tbody>
	</table>
</div>

<!--// 검색결과 -->
<div class="src_result hide">
	<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td class="its-td">검색필터</td>
		<td class="its-td">페이지의 상품을 상세하게 검색할 수 있는 검색 옵션을 설정할 수 있습니다.</td>
		<td class="its-td">검색결과 페이지의 검색필터로 사용자가 원하는 상품을 쉽게 찾을 수 있도록 하십시오.</td>
	</tr>
	</tbody>
	</table>
</div>

<!--// 신상품 -->
<div class="newarrival hide">
	<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td class="its-td">배너</td>
		<td class="its-td">페이지에 노출되는 배너를 등록할 수 있습니다.</td>
		<td class="its-td">신상품 페이지의 배너를 반드시 등록할 필요는 없습니다.</td>
	</tr>
	<tr>
		<td class="its-td">검색필터</td>
		<td class="its-td">페이지의 신상품을 상세하게 검색할 수 있는 검색 옵션을 설정할 수 있습니다.</td>
		<td class="its-td">신상품 페이지의 검색필터로 사용자가 원하는 신규 상품을 쉽게 찾을 수 있도록 하십시오.</td>
	</tr>
	</tbody>
	</table>
</div>

<!--// 베스트 -->
<div class="best hide">
	<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td class="its-td">배너</td>
		<td class="its-td">페이지에 노출되는 배너를 등록할 수 있습니다.</td>
		<td class="its-td">베스트 페이지의 배너를 반드시 등록할 필요는 없습니다.</td>
	</tr>
	<tr>
		<td class="its-td">검색필터</td>
		<td class="its-td">페이지의 베스트 상품을 상세하게 검색할 수 있는 검색 옵션을 설정할 수 있습니다.</td>
		<td class="its-td">베스트 페이지의 검색필터로 사용자가 원하는 베스트 상품을 쉽게 찾을 수 있도록 하십시오.</td>
	</tr>
	</tbody>
	</table>
</div>

<!--// 빅데이터 추천상품 페이지 -->
<div class="bigdata_recommend hide">
	<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td class="its-td">배너</td>
		<td class="its-td">페이지에 노출되는 배너를 등록할 수 있습니다.</td>
		<td class="its-td">빅데이터 추천상품 페이지의 배너를 반드시 등록할 필요는 없습니다.</td>
	</tr>
	<tr>
		<td class="its-td">추천상품</td>
		<td class="its-td">페이지 추천상품 영역의 노출되는 상품을 선정할 수 있습니다.</td>
		<td class="its-td">빅데이터 추천상품 페이지의 추천상품 기준을 설정하여 추천상품을 사용자에게 노출 하십시오.</td>
	</tr>
	</tbody>
	</table>
</div>

<!--// 이벤트 메인 페이지 -->
<div class="all_event hide">
	<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td class="its-td">배너</td>
		<td class="its-td">페이지에 노출되는 배너를 등록할 수 있습니다.</td>
		<td class="its-td">이벤트 메인 페이지의 배너를 주요 이벤트로 등록 하십시오.</td>
	</tr>
	<tr>
		<td class="its-td">검색필터</td>
		<td class="its-td">페이지의 이벤트를 상세하게 검색할 수 있는 검색 옵션을 설정할 수 있습니다.</td>
		<td class="its-td">이벤트 메인 페이지의 검색필터로 사용자가 원하는 이벤트를 쉽게 찾을 수 있도록 하십시오.</td>
	</tr>
	</tbody>
	</table>
</div>

<!--// 할인 이벤트, 사은품 이벤트 페이지 -->
<div class="sale_event gift_event hide">
	<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td class="its-td" width="70px">접속제한</td>
		<td class="its-td">페이지에 접속할 수 있는 사용자를 제한할 수 있습니다.</td>
		<td class="its-td">특수한 경우에만 접속을 제한 하십시오.</td>
	</tr>
	<tr>
		<td class="its-td">배너</td>
		<td class="its-td">페이지에 노출되는 배너를 등록할 수 있습니다.</td>
		<td class="its-td"><span class="variable">할인 이벤트</span> 페이지의 배너를 <span class="variable">할인 이벤트</span> 내용으로 등록 하십시오.</td>
	</tr>
	<tr>
		<td class="its-td">검색필터</td>
		<td class="its-td">페이지의 <span class="vari_txt">이벤트</span> 상품을 상세하게 검색할 수 있는 검색 옵션을 설정할 수 있습니다.</td>
		<td class="its-td"><span class="variable">할인 이벤트</span> 페이지의 검색필터로 사용자가 원하는 <span class="vari_txt">이벤트</span> 상품을 쉽게 찾을 수 있도록 하십시오.</td>
	</tr>
	</tbody>
	</table>
</div>

<!--// 판매자 미니샵 페이지 -->
<div class="minishop hide">
	<table class="info-table-style" width="100%" cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td class="its-td" width="70px">소개글</td>
		<td class="its-td">페이지에 노출되는 소개글을 등록할 수 있습니다.</td>
		<td class="its-td">미니샵 페이지의 소개글을 등록 하십시오.</td>
	</tr>
	<tr>
		<td class="its-td">추천상품</td>
		<td class="its-td">페이지 추천상품 영역의 노출되는 상품을 선정할 수 있습니다.</td>
		<td class="its-td">미니샵 페이지의 추천상품을 사용자에게 노출 하십시오.</td>
	</tr>
	<tr>
		<td class="its-td">검색필터</td>
		<td class="its-td">페이지의 판매자 상품을 상세하게 검색할 수 있는 검색 옵션을 설정할 수 있습니다.</td>
		<td class="its-td">미니샵 페이지의 검색필터로 사용자가 원하는 판매자 상품을 쉽게 찾을 수 있도록 하십시오.</td>
	</tr>
	</tbody>
	</table>
</div>
<!-- 안내 팝업 : 끝 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>