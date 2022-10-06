<?php /* Template_ 2.2.6 2022/05/17 12:31:54 /www/music_brother_firstmall_kr/admin/skin/default/goods/social_catalog.html 000034137 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?dummy=<?php echo date('YmdHis')?>"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
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
				alert("삭제할 티켓상품을 선택해 주세요.");
				return;
			}else{
				var queryString = $("#goodsForm").serialize();
				if(!confirm("선택한 티켓상품을 삭제 시키겠습니까? ")) return;
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

			if(!confirm("이 티켓상품을 복사해서 티켓상품을 등록하시겠습니까?")) return;

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
							customOptions['btn_action']	= "window.open('https://firstmall.kr/myshop','_blank')";
							openDialogAlert("용량이 초과되어 상품을 등록 또는 수정할 수 없습니다.<br/>용량 추가를 하시길 바랍니다.",400,175,'',customOptions);
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
			//window.open("/admin/order/download_list","","");
			location.href = "/admin/goods/social_excel_form";
		});


		$("button[name='excel_down']").click(function(){
			if(!$("#excel_type").val()){
				alert("양식을 선택 해 주세요.");
				return;
			}
			if($("#excel_type").val()=='select'){
				var cnt = $("input:checkbox[name='goods_seq[]']:checked").length;
				if(cnt<1){
					alert("다운로드 할 티켓상품을 선택해 주세요.");
					return;
				}
			}

			$("#goodsForm").append('<input type="hidden" name="goods_kind" value="COUPON" />');
			var queryString = $("#goodsForm").serializeArray();
			ajaxexceldown_spout('/admin/goods_process/goods_excel_download', queryString);
		});


		// export_upload
		$("button[name='upload_excel']").live("click",function(){
			openDialog("티켓상품일괄등록/수정 <span class='desc'></span>", "export_upload", {"width":"800","height":"500","show" : "fade","hide" : "fade"});
		});

		// 상품일괄등록/수정
		$("button[name='excel_upload']").live("click",function(){
			location.href	= 'social_excel_upload';
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

		// 상품관리 기본값 설정 불러오기 :: 2015-04-13 lwh
		$("#set_option_view").bind("click", function(){
			$.ajax({
				type: "get",
				url: "./option_default_setting",
				data: "goods_kind=coupon",
				success: function(html){
					if ($("#displayGoodsSelectPopup").length) $("#displayGoodsSelectPopup").remove();
					$("#set_option_view_lay").html(html);
					openDialog("티켓상품관리 기본값 설정", "set_option_view_lay", {'width':900,'height':570,'show':'fade','hide' : 'fade'});
				}
			});
		});

	});

	function ajaxexceldown_spout(url, queryString){
		var params = {};
		params['goods_seq'] = [];
		jQuery.each(queryString, function(i, field){
			if(field.name == 'goods_seq[]'){
				params['goods_seq'].push(field.value);
			} else {
				params[field.name] = field.value;
			}
		});

		$.ajax({      
			type: "POST",  
			url: url,      
			data: params, 
			success:function(args){ 
				loadingStop();
				var exe = args.split('.').pop();
				if(exe == "csv" || exe == "zip" || exe == "xlsx"){
					window.location.href = '/admin/excel_spout/file_download?url=' + args; 
				} else {
					alert(args);
				}
			}, error:function(e){  
				alert(e.responseText);  
			}  
		});
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
		$("form[name='goodsForm']").attr('action','social_regist');
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
				openDialog("<span style='margin-left:450px;'>이 티켓상품의</span>", "Advanced_Statistics", {"width":"1000","height":"700","show" : "fade","hide" : "fade"});
			}
		});
	}

	// 빅데이터 미리보기 페이지 오픈
	function openBigdataPreview(goods_seq){
		window.open('../bigdata/preview?no='+goods_seq);
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

	// 가격대체문구 레이어 노출
	function viewStringPrice(type, obj){
		if	(type == 'open')	$(obj).closest('div').find('div.view-string-price-lay').show();
		else					$(obj).closest('div').find('div.view-string-price-lay').hide();
	}
</script>
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/layer_stock.css" />
<style>
	.goodsOptionTable {display:none; position:absolute; border-collapse:collapse; top:-10px; left:60px; border:1px solid #f5f5f5;}
	.goodsOptionTable table {width:220px;}
	.goodsOptionTable th {padding:5px; border:1px solid #ddd; background-color:#f5f5f5}
	.goodsOptionTable td {height:25px !important; border:1px solid #ddd; background-color:#ffffff; text-align:center;}
	div.list-string-price-lay {position:relative;}
	div.list-string-price-lay img {cursor:pointer;}
	div.view-string-price-lay {position:absolute;top:20px;left:41px;width:300px;z-index:100;background-color:#fff;}
	.t_tot_stock {text-align:center; border-collapse:collapse; width:570px;}
	.t_tot_stock td {border:1px solid #666; padding:5px;}
	.gr_col {color:#666;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2><!--span class="icon-goods-kind-coupon"--></span>[티켓]티켓 상품 리스트</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span class="btn large orange"><button type="button" id="set_option_view">티켓상품 관리설정</button></span></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large"><button name="excel_upload"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> 일괄 티켓상품등록/수정</button></span></li>

<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_VAR["managerInfo"]){?>
			<li>
				<span class="icon-goods-kind-<?php echo $TPL_VAR["goods"]["goods_kind"]?>"></span>
				<span class="btn large deepblue">
					<button onclick="location.href='social_regist?provider=base';">본사매입 상품등록
						<span class="arrowright"></span>
					</button>
				</span>
			</li>
			<li>
				<span class="icon-goods-kind-<?php echo $TPL_VAR["goods"]["goods_kind"]?>"></span>
				<span class="btn large red">
					<button onclick="location.href='social_regist';">입점사 상품등록
						<span class="arrowright"></span>
					</button>
				</span>
			</li>
<?php }elseif($TPL_VAR["providerInfo"]){?>
			<li>
				<span class="btn large black">
					<button onclick="location.href='social_regist';">상품등록<span class="arrowright"></span></button>
				</span>
			</li>
<?php }?>
<?php }else{?>
			<li>
				<span class="btn large black">
					<button onclick="location.href='social_regist?provider=base';">상품등록<span class="arrowright"></span></button>
				</span>
			</li>
<?php }?>

		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<form name="goodsForm" id="goodsForm">
<input type="hidden" name="query_string"/>
<input type="hidden" name="no" />
<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sort"]?>"/>

<!-- 티켓상품 검색폼 : 시작 -->
<?php $this->print_("goods_search_form",$TPL_SCP,1);?>

<!-- 티켓상품 검색폼 : 끝 -->

<div class="clearbox">
	<ul class="left-btns">
		<li>
			<div class="left-btns-txt" id="search_count" class="hide">
				총 <b><?php echo $TPL_VAR["page"]["totalcount"]?></b> 개
			</div>
		</li>
	</ul>
	<ul class="right-btns">
		<li>
			<select class="custom-select-box-multi" name="excel_type" id="excel_type">
				<option value="">양식선택</option>
				<option value="select">선택 다운로드</option>
				<option value="search">검색 다운로드</option>
			</select>
			<span class="btn small"><button type="button" name="excel_down"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> 다운로드</button></span>
			<span class="btn small"><button type="button" name="down_list"><img src="/admin/skin/default/images/common/btn_img_ex.gif" align="absmiddle" /> 다운로드항목설정</button></span>
		</li>
		<li>
			<select class="custom-select-box-multi" name="orderby" onchange="searchformchange();">
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
			</select>
		</li>
		<li>
			<select  class="custom-select-box-multi" name="perpage" onchange="searchformchange();">
				<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
				<option id="dp_qty50" value="50" <?php if($TPL_VAR["perpage"]== 50){?> selected<?php }?> >50개씩</option>
				<option id="dp_qty100" value="100" <?php if($TPL_VAR["perpage"]== 100){?> selected<?php }?> >100개씩</option>
				<option id="dp_qty200" value="200" <?php if($TPL_VAR["perpage"]== 200){?> selected<?php }?> >200개씩</option>
			</select>
		</li>
	</ul>
</div>

<!-- 주문리스트 테이블 : 시작 -->
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="30" />
		<col width="30" />
		<col width="40" />
<?php if(serviceLimit('H_AD')){?>
		<col width="60" />
<?php }?>
		<col width="40"/>
		<col />
		<col width="85" />
		<col width="85" />
		<col width="120" />
		<col width="100" />
		<col width="90" />
		<col width="120" />
		<col width="65" />
		<col width="50" />
		<col width="70" />
		<col width="70" />
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th>
		<th><span class="icon-star-gray hand <?php if($TPL_VAR["sc"]["orderby"]=='favorite_chk'&&$TPL_VAR["sc"]["sort"]=='desc'){?>checked<?php }?>" id="order_star"></span></th>
		<th>번호</th>
<?php if(serviceLimit('H_AD')){?>
		<th>입점</th>
<?php }?>
		<th colspan="2">
			<span class="btnSort hand" orderby="goods_name" title="[티켓명]으로 정렬">티켓명<?php if($TPL_VAR["orderby"]=='asc_goods_name'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_goods_name'){?>▼<?php }?></span>
		</th>
		<th>
			<span class="btnSort hand" orderby="consumer_price" title="[정가]로 정렬">정가<?php if($TPL_VAR["orderby"]=='asc_consumer_price'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_consumer_price'){?>▼<?php }?></span>
		</th>
		<th>
			<span class="btnSort hand" orderby="price" title="[할인가]로 정렬">판매가<?php if($TPL_VAR["orderby"]=='asc_price'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_price'){?>▼<?php }?></span>
		</th>
		<th>
			<span class="btnSort hand" orderby="tot_stock" title="[재고] 정렬">재고<?php if($TPL_VAR["orderby"]=='asc_tot_stock'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_tot_stock'){?>▼<?php }?></span>/가용
			<span class="helpicon2 detailDescriptionLayerBtn" title="[안내] 재고/가용 표기"></span>
			<div class="detailDescriptionLayer hide">
				<table class='t_tot_stock'>
					<tr>
						<td style="color:#5CD1E5;">[가용재고 > 0 인 옵션의 개수]</td>
						<td>해당 옵션의 재고 합계</td>
						<td>해당 옵션의 가용재고 합계</td>
					</tr>
					<tr>
						<td style="color:#5CD1E5;">[가용재고 < = 0 인 옵션의 개수]</td>
						<td>해당 옵션의 재고 합계</td>
						<td>해당 옵션의 가용재고 합계</td>
					</tr>
				</table><br />
				해당 상품에 가용재고 > 0 인 옵션이 있다면 해당 옵션의 재고 합계 > 0 이며, 가용재고 합계 > 0 입니다.<br />
				해당 상품에 가용재고 < = 0 인 옵션이 있다면 해당 옵션의 재고 합계 = 0 이며, 가용재고 합계 < = 0 입니다.<br /><br /><br />
				<b>예시 1 - '가' 상품)</b><br />
				<span class="helpicon_noimg" title="가용재고 있는 옵션 개수">[1]</span>  10 / 3&nbsp;&nbsp;&nbsp;<span class="desc">→ 가용재고 > 0 인 옵션은 [1]개이며 해당 옵션의 재고합계 10 / 가용재고합계 3</span><br /><span class="helpicon_noimg" title="가용재고 없는 옵션 개수">[3]</span>  <span style='color:#FF4848;'>0</span> / <span style='color:#FF4848;'>-1</span>&nbsp;&nbsp;&nbsp;<span class="desc">→ 가용재고 < = 0 인 옵션은 [3]개이며 해당 옵션의 재고합계 0 / 가용재고합계 -1</span><br /><br />
				<b>예시 2 - '나' 상품)</b><br />
				<span class="helpicon_noimg" title="가용재고 있는 옵션 개수">[2]</span>  9 / 7&nbsp;&nbsp;&nbsp;&nbsp;<span class="desc">→ 가용재고 > 0 인 옵션은 [2]개이며 해당 옵션의 재고합계 9 / 가용재고합계 7</span><br /><span class="helpicon_noimg" title="가용재고 없는 옵션 개수">[0]</span>  - / -&nbsp;&nbsp;&nbsp;&nbsp;<span class="desc">→ 가용재고 < = 0 인 옵션은 없습니다.</span><br /><br />
				<b>예시 3 - '다' 상품)</b><br />
				<span class="helpicon_noimg" title="가용재고 있는 옵션 개수">[0]</span>  - / -&nbsp;&nbsp;&nbsp;&nbsp;<span class="desc">→ 가용재고 > 0 인 옵션은 없습니다.</span><br /><span class="helpicon_noimg" title="가용재고 없는 옵션 개수">[1]</span>  <span style='color:#FF4848;'>0</span> / <span style='color:#FF4848;'>0</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="desc">→ 가용재고 < = 0 인 옵션은 [1]개이며 해당 옵션의 재고합계 0 / 가용재고합계 0</span><br /><br />
			</div>
		</th>
		<th>재고판매
			<span class="helpicon2 detailDescriptionLayerBtn" title="[안내] 재고에 따른 판매 가능여부"></span>
			<div class="detailDescriptionLayer hide">재고(옵션 기준)에 따른 상품 판매 설정에 따라<br />아래와 같이 3가지로 표기됩니다.<br />- 주문수량 < = 재고  : <span class="desc">주문수량 < = 재고 일 때 주문 가능</span><br />- 주문수량 < = 가용재고  : <span class="desc">주문수량 < = 가용재고 일 때 주문 가능</span><br />- 무제한  : <span class="desc">재고 상관없이 주문 가능</span></div>
		</th>
		<th>
			구매/<span class="btnSort hand" orderby="page_view" title="[페이지뷰]로 정렬">PV<?php if($TPL_VAR["orderby"]=='asc_page_view'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_page_view'){?>▼<?php }?></span>
		</th>
		<th><span class="btnSort hand" orderby="goods_seq" title="[등록일순] 정렬">등록일<?php if($TPL_VAR["orderby"]=='asc_goods_seq'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_goods_seq'){?>▼<?php }?></span>
		/<span class="btnSort hand" orderby="update_date" title="[수정일순] 정렬">수정일<?php if($TPL_VAR["orderby"]=='asc_update_date'){?>▲<?php }elseif($TPL_VAR["orderby"]=='desc_update_date'){?>▼<?php }?></span></th>
		<th>상태</th>
		<th>노출</th>
		<th>통계</th>
		<th>관리</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;">
			<td align="center"><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /></td>
			<td align="center"><span class="icon-star-gray star_select <?php echo $TPL_V1["favorite_chk"]?>" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"></span></td>
			<td align="center" class="page_no"><?php echo $TPL_V1["_no"]?></td>
<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_V1["provider_seq"]=='1'){?>
			<td align="center" class="white bold bg-blue">
				본사<br/>매입
			</td>
<?php }else{?>
			<td align="center" class="white bold bg-red"><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
<?php }?>
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

<?php if($TPL_V1["goods_code"]){?><div ><a href="../goods/social_regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><span class="fx11 gray">[티켓상품코드: <?php echo $TPL_V1["goods_code"]?>]</span></a></div><?php }?>
			<div>
				<a href="../goods/social_regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 80)?></a>
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
							<th class="its-th-align center">비회원</th>
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
			<td align="right">
				<table class='gr_col' width="100%" style="padding-left:1px;padding-right:1px;">
					<tr>
						<td colspan=2 style="border:0px;height:15px;width:*;text-align:left;">
							<span style='color:#5CD1E5;'>[<?php echo number_format($TPL_V1["a_stock_cnt"])?>]</span>
<?php if($TPL_V1["a_stock_cnt"]== 0){?>
							<?php echo $TPL_V1["a_stock"]?> / <?php echo $TPL_V1["a_rstock"]?>

<?php }else{?>
							<?php echo number_format($TPL_V1["a_stock"])?> / <?php echo number_format($TPL_V1["a_rstock"])?>

<?php }?>
						</td>
					</tr>
					<tr>
						<td style="border:0px;height:15px;text-align:left;">
							<span style='color:#5CD1E5;'>[<?php echo number_format($TPL_V1["b_stock_cnt"])?>]</span>
<?php if($TPL_V1["b_stock_cnt"]== 0){?>
							<?php echo $TPL_V1["b_stock"]?> / <?php echo $TPL_V1["b_rstock"]?>

<?php }else{?>
							<span style='color:#FF4848;'><?php echo number_format($TPL_V1["b_stock"])?></span> / <span style='color:#FF4848;'><?php echo number_format($TPL_V1["b_rstock"])?></span>
<?php }?>
						</td>
						<td style="border:0px;height:15px;text-align:right;padding-right:2px;">
							<span class="wh_option hand" onclick="goods_option_btn('<?php echo $TPL_V1["goods_seq"]?>',this,<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>'<?php echo $TPL_V1["provider_seq"]?>'<?php }else{?>'2'<?php }?>)">
							<span class="option-stock" optType="option" optSeq=""></span>
							<span class="btn-administration goodsOptionBtn" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"><span class="hide">옵션</span></span>
						</td>
					</tr>
				</table>
<?php if($TPL_V1["options"][ 0]["option_title"]){?>
				<br/>
<?php if($TPL_VAR["cfg_goods_default"]["list_condition_stock"]=='y'){?>
<?php if($TPL_V1["runout_policy"]=='stock'){?>
				<!-- img src="/admin/skin/default/images/common/icon/ico_goods_stock.png" class="help" title="[개별설정] 주문수량 <= 재고" align="absmiddle" / -->
				주문수량<br /><= 재고
<?php }elseif($TPL_V1["runout_policy"]=='ableStock'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_goods_ablestock.png" class="help" title="[개별설정] 주문수량 <= 가용재고" align="absmiddle" / -->
				주문수량<br /><= 가용재고
<?php }elseif($TPL_V1["runout_policy"]=='unlimited'){?>
				<!--img src="/admin/skin/default/images/common/icon/ico_goods_nolimit.png" class="help" title="[개별설정] 무제한" align="absmiddle" / -->
				<span class="red">무제한</span>
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='stock'){?>
				<!-- img src="/admin/skin/default/images/common/icon/ico_config_stock.png" class="help" title="[통합설정] 주문수량 <= 재고" align="absmiddle" / -->
				 주문수량<br /><= 재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='ableStock'){?>
				<!-- img src="/admin/skin/default/images/common/icon/ico_config_ablestock.png" class="help" title="[통합설정] 주문수량 <= 가용재고" align="absmiddle" / -->
				주문수량<br /><= 가용재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='unlimited'){?>
				<!-- img src="/admin/skin/default/images/common/icon/ico_config_nolimit.png" class="help" title="[통합설정] 무제한" align="absmiddle" / -->
				<span class="red">무제한</span>
<?php }?>
<?php }?>
<?php }?>
			</td>
			<td align="center" class='gr_col'>
<?php if($TPL_V1["runout_policy"]){?>
<?php if($TPL_V1["runout_policy"]=='stock'){?>
				주문수량 <= 재고
<?php }elseif($TPL_V1["runout_policy"]=='ableStock'){?>
				주문수량<br /><= 가용재고
<?php }elseif($TPL_V1["runout_policy"]=='unlimited'){?>
				<span style='color:#FF4848;'>무제한</span>
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["cfg_order"]["runout"]=='stock'){?>
				주문수량 <= 재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='ableStock'){?>
				주문수량<br /><= 가용재고
<?php }elseif($TPL_VAR["cfg_order"]["runout"]=='unlimited'){?>
				<span style='color:#FF4848;'>무제한</span>
<?php }?>
<?php }?>
			</td>
			<td align="center"><a href="/admin/order/catalog?goods_seq=<?php echo $TPL_V1["goods_seq"]?>">조회</a><br/><?php echo number_format($TPL_V1["page_view"])?></td>
			<td align="center"><?php echo $TPL_V1["regist_date"]?><br/><?php echo $TPL_V1["update_date"]?></td>
			<td align="center">
<?php if($TPL_V1["provider_status_reason"]){?><?php echo $TPL_V1["provider_status_reason"]?><br/><?php }?>
<?php if(serviceLimit('H_AD')){?><?php echo $TPL_V1["provider_status_text"]?><br/><?php }?><?php echo $TPL_V1["goods_status_text"]?>

			</td>
			<td align="center">
<?php if($TPL_V1["display_terms"]=='AUTO'){?>
				<span class="click-lay display-terms-<?php echo $TPL_V1["goods_seq"]?>" style="color:#ff9900 !important;" onclick="openGoodsDisplayTerms('<?php echo $TPL_V1["goods_seq"]?>');">자동<br/>노출</span>
<?php }?>
				<span class="display-goods-view-<?php echo $TPL_V1["goods_seq"]?> <?php if($TPL_V1["display_terms"]=='AUTO'){?>hide<?php }?>"><?php echo $TPL_V1["goods_view_text"]?></span>
			</td>
			<td align="center">
				<div><img src="/admin/skin/default/images/design/btn_stats.gif" style="cursor:pointer;" onclick="openAdvancedStatistic('<?php echo $TPL_V1["goods_seq"]?>');"  /></div>
				<div style="margin-top:2px;"><img src="/admin/skin/default/images/design/btn_bigdata.gif" style="cursor:pointer;" onclick="openBigdataPreview('<?php echo $TPL_V1["goods_seq"]?>');"  /></div>
			</td>
			<td align="center">
				<span class="btn small valign-middle"><input type="button" class="manager_copy_btn" value="복사" goods_seq="<?php echo $TPL_V1["goods_seq"]?>"/></span>
				<span class="btn small valign-middle"><input type="button" name="manager_modify_btn" value="상세" goods_seq="<?php echo $TPL_V1["goods_seq"]?>" onclick="goodsView('<?php echo $TPL_V1["goods_seq"]?>');"/></span><br/>
			</td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" <?php if(serviceLimit('H_AD')){?>colspan="16"<?php }else{?>colspan="15"<?php }?>>
<?php if($TPL_VAR["search_text"]){?>
				'<?php echo $TPL_VAR["search_text"]?>' 검색된 티켓상품이 없습니다.
<?php }else{?>
				등록된 티켓상품이 없습니다.
<?php }?>
		</td>
	</tr>
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->

</table>
<!-- 주문리스트 테이블 : 끝 -->
<div class="clearbox">
	<ul class="left-btns" style="margin-top:-10px;">
		<li>
			<span class="btn small gray"><button type="button" id="delete_btn">삭제</button></span>
		</li>
	</ul>
	
	<!-- 페이징 -->
	<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>
</div>
</form>

<!-- 기본검색설정 : 시작 -->
<div class="hide" id="search_detail_dialog"><?php $this->print_("set_search_default",$TPL_SCP,1);?></div>
<!-- 기본검색설정 : 끝 -->

<div id="export_upload" class="hide">
<form name="excelRegist" id="excelRegist" method="post" action="../goods_process/excel_upload" enctype="multipart/form-data"  target="actionFrame">

	<div class="clearbox"></div>
	<div class="item-title">티켓상품 일괄 등록 및 수정</div>
	<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="20%" />
		<col width="80%" />
	</colgroup>
	<tr>
		<th class="its-th-align center">일괄수정</th>
		<td class="its-td">
			<input type="file" name="excel_file" id="excel_file" style="height:20px;"/>
		</td>
	</tr>
	</table>

	<div style="width:100%;text-align:center;padding-top:10px;">
	<span class="btn large cyanblue"><button id="upload_submit">확인</button></span>
	</div>

	<div style="padding:15px;"></div>

	<div style="padding-left:10px;font-size:12px;">
		* 티켓상품을 일괄 등록하거나 수정할 때 엑셀 양식을  먼저 다운로드 받은 후에 이용하면 됩니다.<br/>
		&nbsp;&nbsp; ( <span style="color:red;">필독! 엑셀파일 저장시 확장자가 XLS 인 엑셀 97~2003 양식으로 저장해 주세요</span> ) <br/>
		<div style="padding:3px;"></div>
		* 일괄 등록과 수정의 구분은 고유값 필드에 있는 값의 유무로 판단합니다.(고유값 필드에 값이 있으면 수정, 없으면 등록입니다.)<br/>
		<div style="padding:3px;"></div>
		* 티켓상품 옵션은 옵션마다 1개의 행을 차지합니다.(옵션을 등록한 이후에 엑셀을 다운로드 받아서 보면 이해하기 편합니다.)<br/>
		<div style="padding:3px;"></div>
		* 옵션 항목에는 옵션값만 입력해야 하며 티켓상품 공통 정보를 입력하면 안됩니다. 티켓상품 공통 정보 항목도 옵션값을 입력하면 안됩니다. <br/>
		<div style="padding:3px;"></div>
		* 대표카테고리와 추가카테고리가 병합되었습니다. 맨마지막 카테고리번호가 대표카테고리로 등록됩니다.<br/>
		<div style="padding:3px;"></div>
		* 대표브랜드와 추가브랜드가 병합되었습니다. 맨마지막 브랜드번호가 대표브랜드로 등록됩니다.<br/>
	</div>

	<div style="padding:15px;"></div>


</form>
</div>

<!--### 옵션보기 설정 -->
<div id="set_option_view_lay" class="hide"></div>
<script type="text/javascript">
// 리스트 카운트 에러 발생으로 제거 20.02.06 sms
</script>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>