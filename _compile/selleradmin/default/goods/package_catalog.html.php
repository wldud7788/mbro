<?php /* Template_ 2.2.6 2022/05/17 12:29:10 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/package_catalog.html 000027345 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript">
// SEARCH FOLDER
function showSearch(){
	if($("#goods_search_form").css('display')=='none'){
		$("#goods_search_form").show();
		$.cookie("goods_list_folder", "folded");
	}else{
		$("#goods_search_form").hide();
		$.cookie("goods_list_folder", "unfolded");
	}
}


$(document).ready(function() {

	$("#delete_btn").click(function(){
<?php if(!$TPL_VAR["auth"]){?>
		alert("권한이 없습니다.");
		return;
<?php }?>

		var cnt = $("input:checkbox[name='goods_seq[]']:checked").length;
		if(cnt<1){
			alert("삭제할 상품을 선택해 주세요.");
			return;
		}else{
			var queryString = $("#goodsForm").serialize();
			if(!confirm("선택한 상품을 삭제하겠습니까? ")) return;
			$.ajax({
				type: "get",
				url: "../goods_process/goods_delete",
				data: queryString,
				success: function(result){
					//alert(result);
					location.reload();
				}
			});
		}
	});

	$("#chkAll").click(function(){
		if($(this).attr("checked")){
			$(".chk").attr("checked",true).change();
		}else{
			$(".chk").attr("checked",false).change();
		}
	});

	$(".manager_copy_btn").click(function(){

<?php if(!$TPL_VAR["auth"]){?>
		alert("권한이 없습니다.");
		return;
<?php }?>

		if(!confirm("이 상품을 복사해서 상품을 등록하시겠습니까?")) return;

		$.ajax({
			type: "get",
			url: "../goods_process/goods_copy",
			data: "goods_seq="+$(this).attr("goods_seq"),
			success: function(result){
				switch(result){
					case	'diskfull' :
						customOptions				= [];
						customOptions['btn_title']	= '용량추가';
						customOptions['btn_class']	= 'btn large cyanblue';
						customOptions['btn_action']	= "window.open('http://firstmall.kr/myshop','_blank')";
						openDialogAlert("용량이 초과되어 상품을 등록 또는 수정할 수 없습니다.<br/>용량 추가를 하시길 바랍니다.",400,170,'',customOptions);
					break;

					default :
						location.reload();
					break;
				}
			}
		});
	});

	// 체크박스 색상
	$("input[type='checkbox'][name='goods_seq[]']").live('change',function(){
		if($(this).is(':checked')){
			$(this).closest('tr').addClass('checked-tr-background');
		}else{
			$(this).closest('tr').removeClass('checked-tr-background');
		}
	}).change();


	$("button[name='down_list']").click(function(){
		$("div.choose-down-lay").hide();
		if	($("div.choose-form-lay").css('display') != 'none')	$("div.choose-form-lay").slideUp();
		else													$("div.choose-form-lay").slideDown();
		clearCloseDownLay();
		closeDownLay(this);
	});

	$("button[name='excel_down']").click(function(){
		$("div.choose-form-lay").hide();
		if	($("div.choose-down-lay").css('display') != 'none')	$("div.choose-down-lay").slideUp();
		else													$("div.choose-down-lay").slideDown();
		clearCloseDownLay();
		closeDownLay(this);
	});

	$("div.sub-choose-lay").find('div').bind('mouseout', function(){
		closeDownLay(this);
	});
	$("div.sub-choose-lay").find('div').bind('mouseover', function(){
		clearCloseDownLay();
	});

	// export_upload
	$("button[name='upload_excel']").live("click",function(){
		openDialog("상품일괄등록/수정 <span class='desc'></span>", "export_upload", {"width":"800","height":"500","show" : "fade","hide" : "fade"});
	});

	// 상품일괄등록/수정
	$("button[name='excel_upload']").live("click",function(){
		location.href	= 'excel_upload';
	});

	$(".waterMarkImageSetting").bind("click",function(){
<?php if(serviceLimit('H_FR')){?>
		<?php echo serviceLimit('A1')?>

<?php }else{?>
		$.ajax({
			type: "get",
			url: "../setting/watermark_setting?layerid=watermark_setting_popup",
			success: function(result){
				$("div#watermark_setting_popup").html(result);
			}
		});
		openDialog("워터마크 설정", "watermark_setting_popup", {"width":"700","height":"510","show" : "fade","hide" : "fade"});
<?php }?>
	});

	$(".goodsOptionCount").bind("click",function(){
		var btnObj = $(this);
		var goodsOptionTableObj = $(this).closest("td").find(".goodsOptionTable");

		if(goodsOptionTableObj.html()==''){
			goodsOptionTableObj.load('get_goods_option',{'goods_seq':$(this).attr('goods_seq')});
		}

		$(".goodsOptionTable:visible").not($(this).closest("td").find(".goodsOptionTable")).closest("td").find(".goodsOptionBtn").click();
		$(this).closest("td").find(".goodsOptionTable").toggle();
		return false;
	});

	$('#order_star').toggle(function() {
	  $(this).addClass("checked");
	  $("span.icon-star-gray.checked").each(function(i){
		if(i>0){
			$(this).closest('tr').find("input[type='checkbox']").attr('checked',true);
		}
	  });

	}, function() {
	   $("span.icon-star-gray.checked").each(function(i){
		   if(i>0){
			$(this).closest('tr').find("input[type='checkbox']").attr('checked',false);
		   }
	   });
	   $(this).removeClass("checked");
	});

	// 상품관리 기본값 설정 불러오기 :: 2015-04-13 lwh
	$("#set_option_view").bind("click", function(){
		$.ajax({
			type: "get",
			url: "./option_default_setting",
			data: "goods_kind=package_goods",
			success: function(html){
				if ($("#displayGoodsSelectPopup").length) $("#displayGoodsSelectPopup").remove();
				$("#set_option_view_lay").html(html);
				openDialog("패키지실물상품관리 기본값 설정", "set_option_view_lay", {'width':850,'height':600,'show':'fade','hide' : 'fade'});
			}
		});
	});

	$(".btnSort").bind("click", function(){
		var sort = $("input[name='sort']").val();
		if($(this).attr("orderby") != "<?php echo $TPL_VAR["sorderby"]?>") sort = "";

		if(sort == "asc"){
			sort = "desc";
		}else if(sort == "desc" || sort == ""){
			sort = "asc";
		}
		var orderby = sort+"_"+$(this).attr("orderby");

		$(this).attr("sort",sort);
		$("select[name='orderby'] option[value='"+orderby+"']").attr("selected",true);
		$("input[name='keyword']").focus();
		$("form[name='goodsForm']").submit();
	});

});

// 엑셀 다운로드 선택 팝업 닫기
var chkCloseType	= '';
function closeDownLay(){
	chkCloseType	= setTimeout(function(){$("div.sub-choose-lay").find('div').slideUp();}, 3000);
}

// 엑셀 다운로드 선택팝업 닫기 유지 처리
function clearCloseDownLay(){
	clearTimeout(chkCloseType);
}

// 엑셀 양식 설정
function excel_form(type){
	if	(type == 'old')	location.href = "/admin/goods/download_write";
	else				location.href = "/admin/goods/excel_form";
}

// 엑셀 다운로드
function excel_down(type){
	if( $("input[name='keyword']").val() == $("input[name='keyword']").attr("title") ){
		$("input[name='keyword']").focus();
	}

	if(!$("#excel_type").val()){
		alert("양식을 선택 해 주세요.");
		return;
	}
	if($("#excel_type").val()=='select'){
		var cnt = $("input:checkbox[name='goods_seq[]']:checked").length;
		if(cnt<1){
			alert("다운로드 할 상품을 선택해 주세요.");
			return;
		}
	}

	var queryString = $("#goodsForm").serializeArray();
	if	(type == 'old'){
		ajaxexceldown('/admin/goods_process/excel_down', queryString);
	}else{
		ajaxexceldown('/admin/goods_process/goods_excel_download', queryString);
	}
}

//
function ajaxexceldown(url, queryString){
	var inputs = "";
	 jQuery.each(queryString, function(i, field){
		 inputs +='<input type="hidden" name="'+field.name+'" value="'+ field.value +'" />';
	 });
	jQuery('<form action="'+ url +'" method="post" target="actionFrame" >'+inputs+'</form>')
	.appendTo('body').submit().remove();
}

function goodsView(seq){
	$("input[name='keyword']").focus();
	$("input[name='no']").val(seq);
	var search = location.search;
	search = search.substring(1,search.length);
	$("input[name='query_string']").val(search);
	$("form[name='goodsForm']").attr('action','regist');
	$("form[name='goodsForm']").submit();
}

function openAdvancedStatistic(goods_seq){
	$.ajax({
		type: "get",
		url: "../statistic/advanced_statistics",
		data: "ispop=pop&goods_seq="+goods_seq,
		success: function(result){
			$(document).find('body').append('<div id="Advanced_Statistics"></div>');
			$("#Advanced_Statistics").html(result);
			openDialog("<span style='margin-left:410px;'>이 상품의 고급 통계</span>", "Advanced_Statistics", {"width":"1000","height":"700","show" : "fade","hide" : "fade"});
		}
	});
}

function searchformchange(){
	$("input[name='keyword']").focus();
	$("form[name='goodsForm']").submit();
}

// 옵션보기 설정 저장 완료처리
function optionViewSave(){
	loadingStop();
	closeDialog("set_option_view_lay");
	location.reload();
}

// 빅데이터 미리보기 페이지 오픈
function openBigdataPreview(goods_seq){
	window.open('../bigdata/preview?no='+goods_seq);
}

// 가격대체문구 레이어 노출
function viewStringPrice(type, obj){
	if	(type == 'open')	$(obj).closest('div').find('div.view-string-price-lay').show();
	else					$(obj).closest('div').find('div.view-string-price-lay').hide();
}
</script>
<link rel="stylesheet" type="text/css" href="/selleradmin/skin/default/css/layer_stock.css" />
<style>
.goodsOptionTable {display:none; position:absolute; border-collapse:collapse; top:-10px; left:-60px; border:1px solid #f5f5f5;}
.goodsOptionTable table {width:720px;}
.goodsOptionTable th {padding:5px; border:1px solid #ddd; background-color:#f5f5f5}
.goodsOptionTable td {height:25px !important; border:1px solid #ddd; background-color:#ffffff; text-align:center;}

div.sub-choose-lay div.choose-form-lay {top:27px;right:0;width:200px;}
div.sub-choose-lay div.choose-down-lay {top:27px;right:20px;width:150px;}
div.list-string-price-lay {position:relative;}
div.list-string-price-lay img {cursor:pointer;}
div.view-string-price-lay {position:absolute;top:20px;left:41px;width:300px;z-index:100;background-color:#fff;}
span.goodsOptionCount {color:#E45405;cursor:pointer;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>[실물]패키지/복합 상품 리스트</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span class="btn large orange"><button type="button" id="set_option_view">패키지/복합상품 관리설정</button></span></li>
		</ul>
		
		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">

			<li><span class="icon-goods-kind-<?php echo $TPL_VAR["goods"]["goods_kind"]?>"></span><span class="btn large red"><button onclick="location.href='regist?package_yn=y';">상품등록<span class="arrowright"></span></button></span></li>

		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<form name="goodsForm" id="goodsForm">
<input type="hidden" name="query_string"/>
<input type="hidden" name="no" />
<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sort"]?>"/>

<!-- 상품 검색폼 : 시작 -->
<?php $this->print_("goods_search_form",$TPL_SCP,1);?>

<!-- 상품 검색폼 : 끝 -->
<div class="clearbox">
	<ul class="right-btns clearbox">
		<li><select class="custom-select-box-multi" name="orderby" onchange="searchformchange();">
			<option value="asc_goods_name" <?php if($TPL_VAR["orderby"]=='asc_goods_name'){?>selected<?php }?>>상품명순↑</option>
			<option value="desc_goods_name" <?php if($TPL_VAR["orderby"]=='desc_goods_name'){?>selected<?php }?>>상품명순↓</option>
			<option value="asc_consumer_price" <?php if($TPL_VAR["orderby"]=='asc_consumer_price'){?>selected<?php }?>>정가↑</option>
			<option value="desc_consumer_price" <?php if($TPL_VAR["orderby"]=='desc_consumer_price'){?>selected<?php }?>>정가↓</option>
			<option value="asc_price" <?php if($TPL_VAR["orderby"]=='asc_price'){?>selected<?php }?>>할인가↑</option>
			<option value="desc_price" <?php if($TPL_VAR["orderby"]=='desc_price'){?>selected<?php }?>>할인가↓</option>
			<option value="asc_tot_stock"  <?php if($TPL_VAR["orderby"]=='asc_tot_stock'){?>selected<?php }?>>재고↑</option>
			<option value="desc_tot_stock" <?php if($TPL_VAR["orderby"]=='desc_tot_stock'){?>selected<?php }?>>재고↓</option>
			<option value="asc_page_view" <?php if($TPL_VAR["orderby"]=='asc_page_view'){?>selected<?php }?>>페이지뷰순↑</option>
			<option value="desc_page_view" <?php if($TPL_VAR["orderby"]=='desc_page_view'){?>selected<?php }?>>페이지뷰순↓</option>
			<option value="asc_goods_seq" <?php if($TPL_VAR["orderby"]=='asc_goods_seq'){?>selected<?php }?>>등록일순↑</option>
			<option value="desc_goods_seq" <?php if($TPL_VAR["orderby"]=='desc_goods_seq'){?>selected<?php }?>>등록일순↓</option>
			<option value="asc_update_date" <?php if($TPL_VAR["orderby"]=='asc_update_date'){?>selected<?php }?>>수정일순↑</option>
			<option value="desc_update_date" <?php if($TPL_VAR["orderby"]=='desc_update_date'){?>selected<?php }?>>수정일순↓</option>
		</select></li>
		<li><select  class="custom-select-box-multi" name="perpage" onchange="searchformchange();">
			<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
			<option id="dp_qty50" value="50" <?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?> >50개씩</option>
			<option id="dp_qty100" value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
			<option id="dp_qty200" value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
		</select></li>
	</ul>
</div>
<ul class="left-btns clearbox">
	<li>
		<div style="margin-top:rpx;" id="search_count">
			총 <b><?php echo $TPL_VAR["page"]["totalcount"]?></b> 개
		</div>
	</li>
</ul>
<!-- 주문리스트 테이블 : 시작 -->
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="30" /><!--체크값-->
		<col width="30" /><!--즐겨찾기-->
		<col width="40" /><!--번호-->
		<col width="60"/><!--상품이미지-->
		<col /><!--상품명-->
		<col width="90" /><!--정가-->
		<col width="90" /><!--판매가-->
		<col width="100" /><!--재고가용-->
		<col width="100" /><!--재고판매-->
		<col width="100" /><!--배송-->
		<col width="50" /><!--구매/pv-->
		<col width="150" /><!--등록일-->
		<col width="100" /><!--상태-->
		<col width="40" /><!--노출-->
		<!--<col width="70" />통계-->
		<col width="60" /><!--관리-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
		<th><span class="icon-star-gray hand <?php if($TPL_VAR["sc"]["orderby"]=='favorite_chk'&&$TPL_VAR["sc"]["sort"]=='desc'){?>checked<?php }?>" id="order_star"></span></th>
		<th>번호</th>
		<th colspan="2">
			<span class="btnSort hand" orderby="goods_name" title="[패키지 상품명]으로 정렬">패키지/복합 상품명<?php if($TPL_VAR["orderby"]=='asc_goods_name'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_goods_name'){?>▼<?php }?></span>
		</th>
		<th>
			<span class="btnSort hand" orderby="consumer_price" title="[정가]로 정렬">정가<?php if($TPL_VAR["orderby"]=='asc_consumer_price'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_consumer_price'){?>▼<?php }?></span>
		</th>
		<th>
			<span class="btnSort hand" orderby="price" title="[판매가]로 정렬">판매가<?php if($TPL_VAR["orderby"]=='asc_price'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_price'){?>▼<?php }?></span>
		</th>
		<th>
			구성 상품
		</th>
		<th>재고판매
			<span class="helpicon2 detailDescriptionLayerBtn" title="[안내] 재고에 따른 판매 가능여부"></span>
			<div class="detailDescriptionLayer hide">재고(옵션 기준)에 따른 상품 판매 설정에 따라<br />아래와 같이 3가지로 표기됩니다.<br />- 주문수량 < = 재고  : <span class="desc">주문수량 < = 재고 일 때 주문 가능</span><br />- 주문수량 < = 가용재고  : <span class="desc">주문수량 < = 가용재고 일 때 주문 가능</span><br />- 무제한  : <span class="desc">재고 상관없이 주문 가능</span></div>
		</th>
		<th>배송</th>
		<th>구매/<span class="btnSort hand" orderby="page_view" title="[페이지뷰]로 정렬">PV<?php if($TPL_VAR["orderby"]=='asc_page_view'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_page_view'){?>▼<?php }?></span></th>
		<th><span class="btnSort hand" orderby="goods_seq" title="[등록일순] 정렬">등록일<?php if($TPL_VAR["orderby"]=='asc_goods_seq'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_goods_seq'){?>▼<?php }?></span>
		/<span class="btnSort hand" orderby="update_date" title="[수정일순] 정렬">수정일<?php if($TPL_VAR["orderby"]=='asc_update_date'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_update_date'){?>▼<?php }?></span></th>
		<th>상태</th>
		<th>노출</th>
		<!--<th>통계</th>-->
		<th>관리</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;">
			<td align="center">
				<input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" <?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?> scm_rtotal_stock=<?php echo $TPL_V1["rtotal_stock"]?> <?php }?> />
			</td>
			<td align="center"><span class="icon-star-gray star_select <?php echo $TPL_V1["favorite_chk"]?>" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"></span></td>
			<td align="center" class="page_no"><?php echo $TPL_V1["_no"]?></td>
			<td align="right"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a></td>
			<td align="left" style="padding-left:10px;">
				<div class="fx11 gray">
<?php if($TPL_VAR["cfg_goods_default"]["list_condition_brand"]=='y'&&$TPL_V1["brand_default"]){?>
				[<?php echo $TPL_V1["brand_default"]?>]
<?php }?>
<?php if($TPL_VAR["cfg_goods_default"]["list_condition_category"]=='y'&&$TPL_V1["category_default"]){?>
				<?php echo $TPL_V1["category_default"]?>

<?php }?>
				</div>
<?php if($TPL_V1["goods_code"]){?><div >
			<a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><span class="fx11 gray">[상품코드: <?php echo $TPL_V1["goods_code"]?>]</span></a></div><?php }?>
			<div>
				<a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut($TPL_V1["goods_name"], 80)?></a>
				<div>
<?php if($TPL_V1["adult_goods"]=='Y'){?>
					<img src="/admin/skin/default/images/common/auth_img.png" alt="성인" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V1["option_international_shipping_status"]=='y'){?>
					<img src="/admin/skin/default/images/common/icon/plane_on.png" alt="해외배송상품" style="vertical-align: middle;" height="19" />
<?php }?>
<?php if($TPL_V1["cancel_type"]=='1'){?>
					<img src="/admin/skin/default/images/common/icon/nocancellation.gif" alt="청약철회" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V1["tax"]=='exempt'){?>
					<img src="/admin/skin/default/images/common/icon/taxfree.gif" alt="비과세" style="vertical-align: middle;"/>
<?php }?>
				</div>
				<div style="padding-top:3px;"><?php echo $TPL_V1["catename"]?></div>
			</div>
			</td>
			<td align="right"><?php echo get_currency_price($TPL_V1["consumer_price"])?>&nbsp;</td>
			<td align="right">
				<div><?php echo get_currency_price($TPL_V1["price"])?>&nbsp;</div>
<?php if($TPL_VAR["cfg_goods_default"]["list_condition_stringprice"]=='y'&&($TPL_V1["string_price_use"]||$TPL_V1["member_string_price_use"]||$TPL_V1["allmember_string_price_use"])){?>
				<div class="list-string-price-lay">
					<img src="/admin/skin/default/images/common/icon/ico_string_price.png" onmouseover="viewStringPrice('open', this);" onmouseout="viewStringPrice('close', this);"/>
					<div class="view-string-price-lay hide">
						<table class="info-table-style" style="width:100%">
<?php if($TPL_V1["string_price_use"]){?>
						<tr>
							<th width="140px" class="its-th-align center">비회원</th>
							<td><?php echo get_currency_price($TPL_V1["string_price"])?></td>
						</tr>
<?php }?>
<?php if($TPL_V1["member_string_price_use"]){?>
						<tr>
							<th class="its-th-align center">회원</th>
							<td><?php echo get_currency_price($TPL_V1["member_string_price"])?></td>
						</tr>
<?php }?>
<?php if($TPL_V1["allmember_string_price_use"]){?>
						<tr>
							<th class="its-th-align center">모든등급(일반제외)</th>
							<td><?php echo get_currency_price($TPL_V1["allmember_string_price"])?></td>
						</tr>
<?php }?>
						</table>
					</div>
				</div>
<?php }?>
			</td>
			<td align="center">
				<span class="goodsOptionCount" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"><?php echo number_format($TPL_V1["options"][ 0]["package_count"])?> 종</span>
				&nbsp;
				<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V1["goods_seq"]?>',this,'2')">
					<span class="option-stock" optType="option" optSeq=""></span>
					<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"><span class="hide">옵션</span></span>
				</span>
			</td>
			<td align="center" class="gr_col">
<?php if($TPL_V1["runout_policy"]){?>
<?php if($TPL_V1["runout_policy"]=='stock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_goods_stock.png" class="help" title="[개별설정] 주문수량 <= 재고" align="absmiddle" /-->
				주문수량<br /><= 재고
<?php }elseif($TPL_V1["runout_policy"]=='ableStock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_goods_ablestock.png" class="help" title="[개별설정] 주문수량 <= 가용재고" align="absmiddle" /-->
				주문수량<br /><= 가용재고
<?php }elseif($TPL_V1["runout_policy"]=='unlimited'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_goods_nolimit.png" class="help" title="[개별설정] 무제한" align="absmiddle" /-->
				<span class="red">무제한</span>
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["cfg_order"]["runout"]=='stock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_config_stock.png" class="help" title="[통합설정] 주문수량 <= 재고" align="absmiddle" /-->
				주문수량<br /><= 재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='ableStock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_config_ablestock.png" class="help" title="[통합설정] 주문수량 <= 가용재고" align="absmiddle" /-->
				주문수량<br /><= 가용재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='unlimited'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_config_nolimit.png" class="help" title="[통합설정] 무제한" align="absmiddle" /-->
				<span class="red">무제한</span>
<?php }?>
<?php }?>
			</td>
			<td align="center">
				<a href="/admin/setting/shipping_group_regist?shipping_group_seq=<?php echo $TPL_V1["shipping_group_seq"]?><?php if($TPL_V1["provider_seq"]> 1&&$TPL_V1["trust_shipping"]=='N'){?>&provider_seq=<?php echo $TPL_V1["provider_seq"]?><?php }?>" target="_blank" class="click-lay"><?php echo $TPL_V1["shipping_group_name"]?><br/>(<?php echo $TPL_V1["shipping_group_seq"]?>)</a>
<?php if($TPL_V1["provider_seq"]> 1&&$TPL_V1["trust_shipping"]=='Y'){?>
					<div class="red">위탁배송</div>
<?php }?>
			</td>
			<td align="center">
				<div><a href="/admin/order/catalog?goods_seq=<?php echo $TPL_V1["goods_seq"]?>">조회</a></div>
				<div><?php echo number_format($TPL_V1["page_view"])?></div>
			</td>
			<td align="center"><?php echo $TPL_V1["regist_date"]?><br/><?php echo $TPL_V1["update_date"]?></td>
			<td align="center">
<?php if($TPL_V1["provider_status_reason"]){?><div><?php echo $TPL_V1["provider_status_reason"]?></div><?php }?>
<?php if(serviceLimit('H_AD')){?><div><?php echo $TPL_V1["provider_status_text"]?></div><?php }?><div><?php echo $TPL_V1["goods_status_text"]?><div/>
			</td>
			<td align="center"><?php echo $TPL_V1["goods_view_text"]?></td>
			<!--
			<td align="center">
				<div><img src="/admin/skin/default/images/design/btn_stats.gif" style="cursor:pointer;" onclick="openAdvancedStatistic('<?php echo $TPL_V1["goods_seq"]?>');"  /></div>
				<div style="margin-top:2px;"><img src="/admin/skin/default/images/design/btn_bigdata.gif" style="cursor:pointer;" onclick="openBigdataPreview('<?php echo $TPL_V1["goods_seq"]?>');"  /></div>
			</td>-->
			<td align="center">
				<div ><span class="btn small valign-middle"><input type="button" class="manager_copy_btn" value="복사" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"/></span></div>
				<div><span class="btn small valign-middle"><input type="button" name="manager_modify_btn" value="상세" goods_seq="<?php echo $TPL_V1["goods_seq"]?>" onclick="goodsView('<?php echo $TPL_V1["goods_seq"]?>');"/></span></div>
			</td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" colspan="16">
<?php if($TPL_VAR["search_text"]){?>
				'<?php echo $TPL_VAR["search_text"]?>' 검색된 상품이 없습니다.
<?php }else{?>
				등록된 상품이 없습니다.
<?php }?>
		</td>
	</tr>
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->

</table>
<!-- 주문리스트 테이블 : 끝 -->
<div class="clearbox">
	<ul class="left-btns">
		<li>
			<span class="btn small gray"><button type="button" id="delete_btn">삭제</button></span>
		</li>
	</ul>
</div>


<br style="line-height:10px;" />

</form>

<!-- 페이징 -->
<div class="paging_navigation" style="margin:auto;"><?php echo $TPL_VAR["page"]["html"]?></div>

<!-- 기본검색설정 : 시작 -->
<div class="hide" id="search_detail_dialog"><?php $this->print_("set_search_default",$TPL_SCP,1);?></div>
<!-- 기본검색설정 : 끝 -->

<!--### 워터마크세팅 -->
<div id="watermark_setting_popup"></div>


<!--### 옵션보기 설정 -->
<div id="set_option_view_lay" class="hide"></div>

<script type="text/javascript">
<?php if($TPL_VAR["config_system"]["goods_count"]< 10000){?>
$.ajax({
	type: "get",
	url: "./count",
	data: "param=<?php echo $TPL_VAR["param_count"]?>",
	dataType : "json",
	success: function(obj){
		$("div#search_count").removeClass("hide");
		$("div#search_count b").html(comma(obj.cnt));
		var first	= obj.cnt - <?php echo ($_GET["perpage"]*($_GET["page"]- 1))?>;
		$(".page_no").each(function(idx){
			$(this).html(first-idx);
		});
	}
});
<?php }?>
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>