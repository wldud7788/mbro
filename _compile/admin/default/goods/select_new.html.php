<?php /* Template_ 2.2.6 2022/05/17 12:31:53 /www/music_brother_firstmall_kr/admin/skin/default/goods/select_new.html 000015635 */ ?>
<script type="text/javascript" src="/app/javascript/plugin/jquery.search.keyword.dropdown.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#src_keyword_lay").fmsrckeyword({
		'border'		: '1px solid #3385d4', 
		'color'			: '#666', 
		'defaultStype'	: '<?php echo $_GET["selectKeyword_sType"]?>'
	});
});
</script>

<script type="text/javascript" src="/app/javascript/js/admin-layout.js?dummy=<?php echo date('YmdHis')?>&krdomain=http://<?php echo $TPL_VAR["config_system"]["subDomain"]?>"></script>
<script type="text/javascript">

	// 옵션 변경
	function get_option_select( cart_table, goods_seq,price_confirm){

		var w=500; h=140;
		var param;
		var member_seq = "<?php echo $_GET['member_seq']?>";
		
		//옵션 1:1매칭 체크
		if(cart_table == "reorder" || cart_table == "rematch"){
			var tmp_cart_cnt = 0;
			$(".tmp_cart_item").each(function(){
				if($(this).attr("class") != "tmp_cart_item null") tmp_cart_cnt++;
			});

			if(tmp_cart_cnt > 0){
				openDialogAlert("이미 매칭된 상품이 있습니다.",350,140);
				return false;
			}
		}

		param = "goodsSeq="+goods_seq+"&member_seq="+member_seq+"&cart_table="+cart_table+"&mode=tmp";
<?php if($_GET['option_seq']){?>param = param +"&option_seq=<?php echo $_GET['option_seq']?>";<?php }?>
<?php if($_GET['suboption_seq']){?>param = param +"&suboption_seq=<?php echo $_GET['suboption_seq']?>";<?php }?>
		if(price_confirm != ""){ param = param + "&price_confirm="+price_confirm; }

		$.ajax({

			url: "/admin/order/add_cart_check",
			type:"get",
			data: param,
			dataType: "json",
			success: function(data){

				if(data.res){
					option_modify('', cart_table, goods_seq,'');
				}else{
					if(data.errtype == "price_confirm"){
						openDialogConfirm(data.msg,500,200,function(){
							get_option_select(cart_table, goods_seq,'Y');
						},function(){
							return false;
						});

					}else{
						openDialogAlert(data.msg,w,h);
					}
					return false;
				}

			},error : function(res){
				openDialogAlert("장바구니 추가 오류입니다.",w,h);
			}

		});



	}

	// 옵션 변경 레이어 팝업 닫기
	function option_close(){
		$("div#optional_changes_dialog").html("");
		$("div#optional_changes_dialog").closest("div.ui-dialog").remove();
		closeDialog('optional_changes_dialog');
	}

	// 옵션 변경 레이어 팝업 닫기
	function goods_select_close(){
		$("div#<?php echo $_GET["displayId"]?>").closest("div.ui-dialog").remove();
		closeDialog('<?php echo $_GET["displayId"]?>');
	}

	// 상품 옵션 선택창
	function option_modify(id, cart_table, goods_seq,tmp_cart,input_img_path){
		
		var url		= "";
		var param	= "";

		url			+= "/order/optional_changes";
		url			+= "?no="+id+"&cart_table="+cart_table+"&input_img_path="+input_img_path;
		url			+= "&mode=tmp&member_seq=<?php echo $_GET['member_seq']?>&goods_seq="+goods_seq;
		url			+= "&old_option_seq=<?php echo $_GET["option_seq"]?>&old_suboption_seq=<?php echo $_GET["old_suboption_seq"]?>";

		if(tmp_cart != ''){

			$("."+tmp_cart).each(function(){ param += "&"+$(this).attr("name")+"="+$(this).val(); });

			param	+= "&tmp_cart="+tmp_cart;
			url		+= param;

		}

			if	($("form#optional_changes_form").attr('action') == 'optional_modify'){
				$("form#optional_changes_form").attr('action', '/order/optional_modify');
			}
			if	(!$("form#optional_changes_form").find("input[name='cart_table']").val()){
				$("form#optional_changes_form").append('<input type="hidden" name="cart_table" value="" />');
<?php if($TPL_VAR["ordertype"]=='person'){?>
				$("form#optional_changes_form").find("input[name='cart_table']").val('person');
<?php }else{?>
				$("form#optional_changes_form").find("input[name='cart_table']").val("<?php echo $_GET["cart_table"]?>");
<?php }?>
			}
		openDialogPopup("선택사항변경/추가","optional_changes_dialog",{
			'width':'500',
			'height':'600',
			"z-index":"300001px",
			'url':url
		});
	}

	// 장바구니 추출
	function cart_tmp(cart_table,mode,str,list_key,goods_seq){

		var member_seq		= $("input[name='member_seq']").val();
		var data			= "";
		var list_num		= 0;
		var max_option_key	= 0;

		if(str == ''){
<?php if($TPL_VAR["tmp_str"]!=''){?>str = "<?php echo $TPL_VAR["tmp_str"]?>";<?php }?>
		}

		/* 수량변경 적용시 동일상품의 옵션 키값과 중복방지 */
		if(goods_seq){

			$(".goods").each(function(e){
				if($(this).attr("goods_seq") == goods_seq) { 
					if( $(this).attr("opt_num") > max_option_key) { max_option_key = $(this).attr("opt_num"); }
				} 
			});
			max_option_key++;
		}

		if($(".tmp_cart_item").length > 0){
			var _array = Array(); 
			$(".tmp_cart_item").each(function(e){ _array[e] = $(this).attr("list_num"); }); 
			var max_list_num = Math.max.apply(Math,_array);
			list_num = parseInt(max_list_num+1);
		}


		if(str == ''){
			data = "cart_table="+cart_table+"&member_seq="+member_seq+"&mode="+mode;
			if(str == '') data += "&list_num=0";
		}else{
			data = "old_option_seq=<?php echo $_GET["option_seq"]?>&member_seq="+member_seq+"&list_num="+list_num+"&max_option_key="+max_option_key+"&"+str;
		}

		$.ajax({
			type: "get",
			url: "/admin/order/cart",
			data: data,
			success: function(result){

				var div_data	= '';
				var obj			= '';

				if(result.length > 0 && result.length < 200){
					openDialogAlert(result,400,150);
					result = "";
					return false;
				}

				if($(".tmp_cart_item").length == 0 && result == ""){
					targetList_null();
				}else{

					if(list_key && list_key != 'undefined'){ $(".tmp_cart_item."+list_key.substr(8)).remove(); }

					if(mode == "tmp") {
						div_data = $("#targetList").html();
						div_data = div_data + result;
						option_close();
					}else{
						div_data = result;
					}
					$("#targetList").html(div_data);
					$(".tmp_cart_item.null").remove();
				}
			}
		});
	}

	function targetList_null(){
		var obj = '<div class="tmp_cart_item null" list_num="0" style="height:94px"><span style="line-height:80px;" class="fx12">선택된 상품이 없습니다.</span></div>';
		$("#targetList").html(obj);
	}

	function searchformchange(){
		$(".orderby").each(function(){ $(this).html(""); });
		$("input[name='selectKeyword']").focus();
		$("form[name='goodsForm']").submit();
	}

	function selectSubmit(cart_table){

		var f = $("#orderFrmTmp");
		if(cart_table == "person" || cart_table == "admin"){
			f.attr("action","/order/optional_modify");
		}else{
			f.attr("action","/admin/order_process/order_goods_change");
		}

<?php if($_GET["displayId"]=="export_goods_selected_"){?>
		f.attr("target","export_frame");
<?php }else{?>
		f.attr("target","actionFrame");
<?php }?>
		f.attr("method","post");
		f.submit();
	}

	$(function(){

<?php if($TPL_VAR["cart_table"]=='rematch'||$TPL_VAR["cart_table"]=='reorder'){?>

<?php }?>

		$(".btnSort").bind("click", function(){
			var sort	= $(this).attr("sort");
			var orderby = sort+"_"+$(this).attr("orderby");
			var sort_ext = "";
			if(sort == "asc"){
				sort = "desc"; sort_ext = "▲";
			}else if(sort == "desc" || sort == ""){
				sort = "asc"; sort_ext = "▼";
			}
			$(".orderby").each(function(){ $(this).html(""); });

			$(".orderby."+$(this).attr("orderby")).html(sort_ext);
			$(this).attr("sort",sort);
			$("input[name='orderby']").val(orderby);
			//$("input[name='selectKeyword']").focus();
			$("form[name='goodsForm']").submit();
		});

	});

	// 내역 레이어 팝업 열기
	function open_sale_price_layer(obj){
		$(obj).closest('div').find(".sale_price_layer").show();
	}
	// 내역 레이어 팝업 닫기
	function close_sale_price_layer(obj){
		$(obj).closest('div').find(".sale_price_layer").hide();
	}

	// 장바구니 삭제
	function cart_delete(cart_seq,list_key){

		$(".tmp_cart_item."+list_key).remove();
		if($(".tmp_cart_item").length == 0) targetList_null();
		
		$.ajax({
			url: "/admin/order/delete_cart",
			type:"post",
			data: {'cart_seq' : cart_seq},
			dataType: "json",
			success: function(data){
				if(data == 'ERROR'){
					openDialogAlert("장바구니 삭제 오류(번호 누락)입니다.", 500, 140);
				}
				//console.log(data);
			},error : function(res){
				openDialogAlert("장바구니 삭제 오류입니다.", 500, 140);
			}
		});
	}
</script>
<style>
	#goodsSelectorSearch { 
		width:900px; 
		border:0px solid red;
		text-align:center;margin:auto;
	}
	.selectedGoods{ background-color:#e7f2fc; }
	.targetGoods {padding:4px; overflow:hidden; cursor:pointer}
	.targetGoods .image {padding-right:4px;}
	.targetGoods .name {display:block; width:300px; overflow:hidden; white-space:nowrap;}
	.rborder { border-right:1px solid #ddd;
</style>

<div id="goodsSelectorSearch">

	<form name="goodsForm" action="/admin/goods/select_list_new" method="get" target="select_<?php echo $_GET["displayId"]?>">
	<input type="hidden" name="cart_option_seq" id="cart_option_seq" value="<?php echo $_GET["cart_option_seq"]?>" />
	<input type="hidden" name="cart_table" value="<?php echo $_GET["cart_table"]?>" />
	<input type="hidden" name="member_seq"	value="<?php echo $_GET["member_seq"]?>" />
	<input type="hidden" name="goods_review" value="<?php echo $_GET["goods_review"]?>" />
	<input type="hidden" name="inputGoods" value="<?php echo $_GET["inputGoods"]?>" />
	<input type="hidden" name="displayId" value="<?php echo $_GET["displayId"]?>" />
	<input type="hidden" name="order_seq" value="<?php echo $_GET["order_seq"]?>" />
	<input type="hidden" name="orderby"  >
<?php if($_GET["relation_goods_seq"]){?>
	<!-- 상품의 대표 카테고리,브랜드,지역 가져와서 관련상품출력할때 사용-->
	<input type="hidden" name="relation_goods_seq" value="<?php echo $_GET["relation_goods_seq"]?>" />
<?php }?>

	<!-- 상품 검색폼 : 시작 -->
<?php $this->print_("goods_search_form",$TPL_SCP,1);?>

	<!-- 상품 검색폼 : 끝 -->

	</form>

	<div style="height:5px;"></div>

	<div>
	<!-- 주문리스트 테이블 : 시작 -->
	<table class="list-table-style" cellspacing="0">
		<!-- 테이블 헤더 : 시작 -->
		<colgroup>
			<col width="70" />
			<col />
			<col width="90" />
			<col width="90" />
			<col width="90" />
			<col width="70" />
			<col width="60" />
			<col width="78" />
		</colgroup>
		<thead class="lth">
		<tr>
			<th colspan="2">
				<span class="btnSort hand" sort="asc" orderby="goods_name" title="[상품명]으로 정렬">상품명<span class="orderby goods_name"></span>
			</th>
			<th>
				<span class="btnSort hand" sort="asc" orderby="consumer_price" title="[정가]로 정렬">정가<span class="orderby consumer_price"></span>
			</th>
			<th>
				<span class="btnSort hand" sort="asc" orderby="price" title="[할인가]로 정렬">할인가<span class="orderby price"></span>
			</th>
			<th>
				<span class="btnSort hand" sort="asc" orderby="tot_stock" title="[재고] 정렬">재고<span class="orderby tot_stock"></span></span>/가용
			</th>
			<th>상태</th>
			<th>노출</th>
			<th style="border-right:1px solid #CCC;"><span style="margin-right:18px;">선택</span></th>
		</tr>
		</thead>
		<!-- 테이블 헤더 : 끝 -->
	</table>
	</div>
	<div style="border-bottom:3px solid #075DEC;">
		<iframe width="100%" height="<?php echo $TPL_VAR["containerHeight"]?>" frameborder="0" src="/admin/goods/select_list_new?onlyType=<?php echo $_GET["onlyType"]?>&adminshipping=<?php echo $_GET["adminshipping"]?>&adminOrder=<?php echo $_GET["adminOrder"]?>&init=Y&goods_review=<?php echo $_GET["goods_review"]?>&order_seq=<?php echo $_GET["order_seq"]?>&goods_seq=<?php echo $_GET['goods_seq']?>&selectKeyword=<?php echo urlencode($_GET["selectKeyword"])?>&member_seq=<?php echo $_GET["member_seq"]?>&cart_table=<?php echo $_GET["cart_table"]?>&provider_seq=<?php echo $_GET["provider_seq"]?>" name="select_<?php echo $_GET["displayId"]?>" scroll="yes"></iframe>
	</div>

	<form name="orderFrmTmp" id="orderFrmTmp" method="get" target="actionFrame">
	<input type="hidden" name="cart_table"			value="<?php echo $_GET["cart_table"]?>" />
	<input type="hidden" name="mode"				value="tmp" />
	<input type="hidden" name="old_item_seq"		value="<?php echo $_GET["item_seq"]?>" />
	<input type="hidden" name="old_option_seq"		value="<?php echo $_GET["option_seq"]?>" />
	<input type="hidden" name="member_seq"			value="<?php echo $_GET["member_seq"]?>" />
	<input type="hidden" name="order_seq"			value="<?php echo $_GET["order_seq"]?>" />
	<input type="hidden" name="displayId"			value="<?php echo $_GET["displayId"]?>" />
	<input type="hidden" name="gl_option_select_ver"	value="0.1" />
	<input type="hidden" name="package_mode" value="<?php echo $_GET["package_mode"]?>" >
	<input type="hidden" name="package_seq" value="<?php echo $_GET["package_seq"]?>" >
	<div>
		<div>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="list-table-style">
			<colgroup>
				<col width="30" />
				<col width="" />
				<col width="70" />
				<col width="90" />
				<col width="90" />
				<col width="90" />
				<col width="108" />
			</colgroup>
			<thead class="lth">
			<tr>
				<th></th>
				<th>주문상품</th>
				<th>수량</th>
				<th>상품금액</th>
				<th>할인</th>
				<th>할인가격</th>
				<th style="border-right:1px solid #CCC;"><span style="margin-right:18px;">적립</span></th>
			</tr>
		</thead>
		</table>
		</div>
		<div style="min-height:95px;overflow-y:scroll;">
		
		<div id="targetList" style="border-top:0px;border-bottom:1px solid #ddd;"></div>

		</div>

<?php if($_GET["cart_table"]=="reorder"){?>
		<div class="fx12" style="margin-top:20px;text-align:left">
		(맞)교환으로 인한 재주문 시 다른 상품으로 변경하면<br />
		① 원주문(<a href="/admin/order/view?no=<?php echo $_GET["order_seq"]?>" target="_blank" style="color:red;"><?php echo $_GET["order_seq"]?></a>)의 결제금액과 차액이 발생할 수 있습니다.<br />
		② 변경된 상품으로 재고가 차감됩니다.
		③ 원주문 수량과 변경수량이 상이할 경우 <span class="red">원주문 수량으로 자동 저장</span>됩니다.</span>
		</div>
<?php }?>

<?php if($_GET["cart_table"]=="rematch"){?>
		<div class="fx12" style="margin-top:20px;text-align:left">
			① <span class="red">변경된 주문 상품의 가격은 변동되지 않습니다.</span><br />
			② 필수옵션 및 추가옵션은 <span class="red">1:1 매칭</span>되어야 합니다.<br />
			③ 원주문 수량과 변경수량이 상이할 경우 <span class="red">원주문 수량으로 자동 저장</span>됩니다.</span>
		</div>
<?php }?>

		<div class="center mt15">
			<span class="btn large cyanblue" onclick="selectSubmit('<?php echo $_GET["cart_table"]?>')"><button type="button">적용</button></span>
		</div>
	</div>
	</form>

	<br />
	<br />

</div>

<?php if($_GET["cart_table"]=="reorder"||$_GET["cart_table"]=="rematch"){?>
<div id="optional_changes_dialog"></div>
<?php }?>

<script type="text/javascript">
<?php if($_GET["package_mode"]){?>
targetList_null();
<?php }else{?>
cart_tmp("<?php echo $_GET["cart_table"]?>",'goods_select','','');
<?php }?>
</script>