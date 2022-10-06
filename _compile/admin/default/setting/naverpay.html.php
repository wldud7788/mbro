<?php /* Template_ 2.2.6 2022/05/10 15:22:06 /www/music_brother_firstmall_kr/admin/skin/default/setting/naverpay.html 000032832 */ 
$TPL_npay_shipping_1=empty($TPL_VAR["npay_shipping"])||!is_array($TPL_VAR["npay_shipping"])?0:count($TPL_VAR["npay_shipping"]);?>
<script type="text/javascript" src="//pay.naver.com/customer/js/mobile/naverPayButton.js" charset="UTF-8"></script>
<script type="text/javascript" src="//pay.naver.com/customer/js/naverPayButton.js" charset="UTF-8"></script>
<script type="text/javascript" src="/app/javascript/js/admin-shipping.js?dummy=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gCategorySelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gGoodsSelectList.js?mm=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">
	function check_naver_mileage_yn(){
		$(".naver_mileage").find("input[type='text']").each(function(){
			$(this).css("background-color","#f3f3f3");
			$(this).css("color","#c6c6c6");
			if( !$("input[name='naver_mileage_yn'][value='n']").attr("checked") ){
				$(this).css("background-color","");
				$(this).css("color","#000000");
			}
		});

<?php if($TPL_VAR["naver_mileage"]["naver_mileage_api_id"]){?>
		// 네이버 마일리지 조회
		$.get('/naver_mileage/get_accum_rate', function(data) {
			var naver_mileage_rate = 0;
			if(data.baseAccumRate){
				$("#naver_mileage_baseAccumRate").html(data.baseAccumRate);
				naver_mileage_rate += data.baseAccumRate;
			}
			if(data.addAccumRate){
				$("#naver_mileage_addAccumRate").html(data.addAccumRate);
				naver_mileage_rate += data.addAccumRate;
			}
			$("#naver_mileage_rate").html(naver_mileage_rate);
		});
<?php }?>
	}

	function check_naver_wcs_yn(){
		$(".naver_wcs").each(function(){
			$(this).attr("readonly",true);
			$(this).css("background-color","#f3f3f3");
			$(this).css("color","#c6c6c6");
			if( $("input[name='naver_wcs_yn']").attr("checked") ){
				$(this).attr("readonly",false);
				$(this).css("background-color","");
				$(this).css("color","#000000");
			}
		});
	}
	
	var max_cnt		= 0;
	var pageline	= 1000;
	var now_page	= 0;
	var max_page	= 0;
	var file_mode	= '';
	var mode		= '';

	function make_market_file(row_cnt,sel_file_mode,sel_mode){
		max_cnt		= row_cnt;
		now_page	= 0;
		max_page	= Math.ceil(max_cnt/pageline);
		file_mode	= sel_file_mode;
		mode		= sel_mode

		openDialogAlert('페이지를 이탈하거나 브라우저를 종료하지 마세요. <Br/><span id="process_list_cnt" style="font-size:12px;font-weight: bold;"></span> 파일 생성 중',400,120,function(){},{'hideButton' : true});

		loadingStart();
		do_make_market_file();
	}


	function do_make_market_file(){
		if(max_page == now_page){
			loadingStop();
			openDialogAlert('파일이 생성되었습니다.',400,120,function(){},{'hideButton' : true});
			return true;
		}else{
			now_page++;
		}

		$('#process_list_cnt').html(now_page + ' / ' + max_page);

		make_url	= '/partner/file_write?page=' + now_page +'&filemode='+file_mode+'&mode='+mode+'&rows=' + max_cnt + '&pageline=' + pageline;
		$.ajax({url: make_url,global:false}).always(function(){
			window.setTimeout(function(){do_make_market_file();}, 10000 );
		});

		return true;
	}

	// Firstmall 에서 호출하는 팝업
	function popup_event(){
		openDialog("이벤트 안내", "info_event_lay", {"width":"800","height":"700","show" : "fade","hide" : "fade"});
	}

	function npay_btn_style(mode){

		var title	= '';
		var w		= 1250;
		var h		= 650;
		if(mode == "pc_goods"){
			title = "PC버전 버튼 스타일 선택";
		}else if (mode == "mobile_goods"){
			title	= "Mobile버전 버튼 스타일 선택";
			h		= 610;
		}
		$("#npay").attr("src","../marketing/npay_btn_style?mode="+mode);
		openDialog(title,"lay_npay_btn_style", {"width":w,"height":h,"show" : "fade","hide" : "fade"});
	}

	//네이버페이 버튼 노출 설정
	function lay_npay_close(mode,npay_btn_text,h){

		$("#npay_"+mode+"_text").html(npay_btn_text);
		$("#npay_"+mode).attr("height",h);

		// 상세페이지 버튼 갱신
		$("#npay_" + mode).attr("src", "../marketing/npay_btn_style_iframe?mode=" + mode);
		// 장바구니 버튼 갱신
		$("#npay_" + mode + '_cart').attr("src", "../marketing/npay_btn_style_iframe?mode=" + mode + '&type=cart');


		$("#lay_npay_btn_style").dialog("close");
	}

	function lay_npay_popup_close(){		
	//$("#lay_npay_btn_style").dialog("close");
	closeDialogEvent("#lay_npay_btn_style");
}

	// 네이버페이 안내창 팝업
	function openpop_npay(){
		openDialog("네이버페이 - 추가입력옵션을 이미지 업로드 방식으로 구성한 경우", "npay_imageupload_pop", {"width":"830","height":"230","show" : "fade","hide" : "fade"});
	}

	$(document).ready(function() {

		/*도서 공연비 소득 공제 대상 상품*/
		setContentsRadio("navercheckout_culture", "<?php if($TPL_VAR["navercheckout"]["culture"]){?><?php echo $TPL_VAR["navercheckout"]["culture"]?><?php }else{?>n<?php }?>");	

		$(".categoryList .btn_minus").on("click",function(){
			gCategorySelect.select_delete('minus',$(this));
		});
		
		//선택삭제
		$(".select_goods_del").on("click",function(){
			gGoodsSelect.select_delete('chk',$(this));
		});

		// 상품선택
		$(".btn_select_goods").on("click",function(){
			
			var params = {
						'goodsNameStrCut':30,
						'select_goods':$(this).attr("data-goodstype"),
						'selector':this,
						'service_h_ad':window.Firstmall.Config.Environment.serviceLimit.H_AD
						};
			gGoodsSelect.open(params);

		});

		// 카테고리 선택
		$(".btn_category_select").on("click",function(){
			gCategorySelect.open();
		});	
		
		// 안내)네이버페이 이용시
		$("button#npay_shipping_setting_guide").on("click",function(){
			openDialog("알림", "npay_shipping_setting_guide_lay", {"width":"1080","height":"750","show" : "fade","hide" : "fade"});
		});

		$(".shippingGroupInfoBtn").on("click",function(){
			openDialog("네이버 페이 배송비", "shippingGroupInfo", {"width":"1000","height":"600","show" : "fade","hide" : "fade"});
		});	

		$("button.category_button").live("click",function(){

			var obj = $(this).parent().parent();
			var obj_select = obj.find("select");
			var category = '';
			var code = '';
			var mode = 'apply';
			var category_tag_name = "category_code[]";
			if( obj_select.eq(0).attr('name') == 'except_category1[]'){
				category_tag_name = "except_category_code[]";
				var mode = 'except';
			}

			obj_select.each(function(idx){
				var opt = $(this).find("option:selected");
				if(obj.val()){
					category = opt.html();
					categoryCode = obj.val();
				}
				if(opt.val()){
					if(idx == 0){
						category = opt.html();
					}else{
						category += ' > ' + opt.html();
					}
					code = opt.attr('value');
				}
			});

			if( code && !$("input[name='"+category_tag_name+"'][value='"+code+"']").val() ){
				if( mode != 'apply' || !$(".choice_category_list input[value='"+code+"']").val() ){
					var tag = "<span style='display:inline-block;width:300px'>"+category+"</span>";
					tag += "<span class='btn-minus'><button type='button' class='del_category'></button></span>";
					tag += "<input type='hidden' name='" + category_tag_name + "' value='"+code+"' />";
					obj.next().append("<div style='padding:1px;'>"+tag+"</div>");
				}
			}
		});

		$("button.del_category").live("click",function(){
			$(this).parent().parent().remove();
		});

		$("button.except_goods_button").live("click",function(){
			var displayId = "except_goods_selected";
			var inputGoods = "except_goods";
			set_goods_list(displayId,inputGoods);
		});

		$("#btn_help_price").click(function() {
			var guide_msg = "<div><p class='pdb5 left'>할인이벤트 가격 기본 적용이란?</p>";
			guide_msg += "<p class='pdb5 left'>입점마케팅 채널로 전송되는 시점이 할인이벤트 기간이라면 할인이벤트에 속한 해당 상품의 할인가는</p>";
			guide_msg += "<p class='pdb5 left'>이벤트 할인금액이 적용된 할인가격으로 자동 적용되어 전송됩니다.</p>";
			guide_msg += "<p class='pdb5 left'>※ 할인이벤트는 프로모션/쿠폰><a href=\"../event/catalog\" target=\"_blank\" style=\"color:#ff6600;font-weight:bold;\" class=\"setlink\" onfocus=\"this.blur();\">할인 이벤트</a>에서 관리됩니다.</p></div>";
			openDialogAlerttitle("안내 ) 할인이벤트 가격 기본 적용",guide_msg,700,180,function(){},{'hideButton' : true});
		});

		// 안내 팝업
		$(".info_goods").bind("click",function(){
			openDialog("안내) 대상 상품 조건", "info_goods_lay", {"width":"800","height":"700","show" : "fade","hide" : "fade"});
		});
		$(".info_domain").bind("click",function(){
			openDialog("안내) 도메인연결 신청방법", "info_domain_lay", {"width":"800","height":"700","show" : "fade","hide" : "fade"});
		});
		// 팝업 여부 확인
		/*$.ajax({
			type: "get",
			url: "http://firstmall.kr/ec_hosting/marketing/marketplace_url_pop.php",
			data: "mode=chk",
			dataType : "jsonp",
			success: function(result){
				alert(result);
			}
		});*/

<?php if($TPL_VAR["navercheckout"]["version"]!="2.1"&&($TPL_VAR["navercheckout"]["use"]=="y"||$TPL_VAR["navercheckout"]["use"]=="test")){?>
		$(".npay_ver").bind("click",function(){
			if($(this).val() == "2.1"){
			openDialog("네이버페이 연동버전 업그레이드 신청","npay_ver2_lay",{"width":650,"height":670,"show" : "fade","hide" : "fade"});
				$("input[name='navercheckout_ver'][value='1.0']").attr("checked",true);
			}
		});
<?php }?>

		$("#naverpay_upgrade").bind("click",function(){

			if(!$("input[name='naverpay_mall_id']").val()){
				openDialogAlert("페이가맹점 ID를 입력하세요.");
				return false;
			}
			if(!$("input[name='naverpay_email[]']").eq(0).val() || !$("input[name='naverpay_email[]']").eq(1).val()){
				openDialogAlert("이메일 주소를 입력하세요.");
				return false;
			}
			if(!$("input[name='naverpay_user_phone']").val()){
				openDialogAlert("휴대폰번호를 입력하세요.");
				return false;
			}

			var upgrade_form = $("form[name='naverpay_upgrade']");

		openDialogConfirm("<span class='fx12'>업그레이드 신청부터 완료기간까지 네이버페이 버튼이 노출되지<br />않습니다.(테스트모드)<br />업그레이드 하시겠습니까?</span>",450,200,function(){ upgrade_form.attr("action","../marketing_process/naverpay_upgrade");upgrade_form.submit(); } ,function(){}) ;
		});

<?php if($TPL_VAR["navercheckout"]["use"]=="y"&&$TPL_VAR["navercheckout"]["version"]==''){?>
		$(".navercheckout_use").bind("click",function(){

			if($(this).val() == "n" || $(this).val() == "test"){
				var msg = "추후 사용함으로 설정 시 상품연동 2.0 버전(주문연동 포함)으로만 연동 가능합니다.<br />사용안함(또는 테스트)으로 설정하시겠습니까?";
				openDialogConfirm(msg,550,170,function(){},function(){$("input[name='navercheckout_use'][value='y']").attr("checked",true);});
			}
		});
<?php }?>
		
<?php if($TPL_VAR["naver_use"]=='Y'){?>
		$('[name="naver_use"]').bind('click', function(){
			var v = $(this).val();

			if(v == 'Y') {
				$('.naver-ep-sec-guide').show();
			} else {				
				openDialogConfirm(
					"[미사용]으로 변경 시 네이버쇼핑 3.0 버전만 사용 가능합니다.<br/>변경하시겠습니까?",
					550, 170,
					function(){
						$('.naver-ep-sec-guide').hide();
					},
					function(){
						$('[name="naver_use"]:eq(0)').attr('checked', true);
						$('.naver-ep-sec-guide').show();
					}
				);	
			}
		});
<?php }?>
		
		$("button.culture_goods_button").on("click",function(){
			var displayId = "culture_goods_selected";
			var inputGoods = "culture_goods";
			set_goods_list(displayId,inputGoods);
		});


		$("input[name='navercheckout_culture']").on("click",function(){
			if($(this).val()=='choice'){
				$(".culture_choice").show();
			} else {
				$(".culture_choice").hide();
			}
		});

	});
</script>
<!-- ### 네이버 페이 설정 ### -->
<div class="clearbox naverpayinputPgSetting"">
	<!-- <?php if($TPL_VAR["navercheckout"]["use"]=='test'){?> -->
	<span class="desc" style="font-weight:normal;color:red;">네이버페이는 네이버 담당자의 최종 검수완료 후 사용 가능합니다.</span>
	<!-- <?php }?> -->
	<table class="table_basic thl">
		<col width="16%" /><col width="34%" />
		<col width="15%" /><col width="35%" />
		<tr>
			<th>버전</th>
			<td colspan="3">
				<div class="resp_radio">
<?php if(in_array($TPL_VAR["navercheckout"]["use"],array("y","test"))&&in_array($TPL_VAR["navercheckout"]["version"],array('','1.0'))){?>
					<label><input type="radio" name="navercheckout_ver" value="1.0" class="npay_ver" <?php if($TPL_VAR["navercheckout"]["version"]!='2.1'){?>checked="checked"<?php }?>> 상품 연동 1.0 / 주문연동 안함</label>				
<?php }?>
					<label><input type="radio" name="navercheckout_ver" value="2.1" class="npay_ver" <?php if($TPL_VAR["navercheckout"]["version"]=='2.1'||$TPL_VAR["navercheckout"]["version"]==''){?>checked="checked"<?php }?>> 상품 연동 2.0  / 주문연동 5.0</label>
				</div>
			</td>
		</tr>
		<tr>
			<th>사용여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="navercheckout_use" class="navercheckout_use" value="y" <?php if($TPL_VAR["navercheckout"]["use"]=='y'){?>checked="checked"<?php }?> /> 사용</label>
					<label><input type="radio" name="navercheckout_use" class="navercheckout_use" value="test" <?php if($TPL_VAR["navercheckout"]["use"]=='test'){?>checked="checked"<?php }?> /> 테스트</label>
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip13')"></span>
					<label><input type="radio" name="navercheckout_use" class="navercheckout_use" value="n" <?php if($TPL_VAR["navercheckout"]["use"]=='n'){?>checked="checked"<?php }?> /> 사용 안 함</label>
				</div>
			</td>
			<th>상점 ID</th>
			<td>
				<input type="text" name="navercheckout_shop_id" size="50" class="line" value="<?php echo $TPL_VAR["navercheckout"]["shop_id"]?>" />
			</td>
		</tr>
		<tr>
			<th>상점인증키(가맹점인증키)</th>
			<td>
				<input type="text" name="navercheckout_certi_key" size="50" class="line" value="<?php echo $TPL_VAR["navercheckout"]["certi_key"]?>" />
			</td>
			<th>버튼인증키</th>
			<td>
				<input type="text" name="navercheckout_button_key" size="50" class="line" value="<?php echo $TPL_VAR["navercheckout"]["button_key"]?>" />
			</td>
		</tr>
<?php if($TPL_VAR["navercheckout"]["version"]=="2.1"){?>
		<tr>
			<th>버튼 타입 (PC)</th>
			<td colspan="3">
				<div style="margin: 15px 0;">
					<button type="button" class="resp_btn v2 mr5" onclick="npay_btn_style('pc_goods')">버튼 선택</button>	
					<span id="npay_pc_goods_text"><?php echo $TPL_VAR["sel_npay_btn_text"]['pc_goods']?></span>
				</div>
				<table class="table_basic">
					<col width="50%"><col width="50%">
					<tr>
						<th>상품상세 페이지</th>
						<th>장바구니 페이지</th>
					</tr>
					<tr>
						<td class="center" valign="top">						
							<iframe name="npay_pc_goods" id="npay_pc_goods" src="../marketing/npay_btn_style_iframe?mode=pc_goods" frameborder=0 border=0 width="350" height="<?php echo $TPL_VAR["sel_npay_btn_text"]['pc_goods_h']?>"></iframe>
						</td>
						<td class="center" valign="top">
							<iframe name="npay_pc_goods_cart" id="npay_pc_goods_cart" src="../marketing/npay_btn_style_iframe?mode=pc_goods&type=cart" frameborder=0 border=0 width="350" height="<?php echo $TPL_VAR["sel_npay_btn_text"]['pc_goods_h']?>"></iframe>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<th>버튼 타입 (MOBILE)</th>
			<td colspan="3">
				<div style="margin: 15px 0;">
					<button type="button" class="resp_btn v2 mr5" onclick="npay_btn_style('mobile_goods')">버튼 선택</button>	
					<span id="npay_mobile_goods_text"><?php echo $TPL_VAR["sel_npay_btn_text"]['mobile_goods']?></span>
				</div>
				<table class="table_basic">
					<col width="50%"><col width="50%">
					<tr>
						<th>상품상세 페이지</th>
						<th>장바구니 페이지</th>
					</tr>
					<tr>
						<td class="center" valign="top">						
							<iframe name="npay_mobile_goods" id="npay_mobile_goods" src="../marketing/npay_btn_style_iframe?mode=mobile_goods" frameborder=0 border=0 width="350" height="<?php echo $TPL_VAR["sel_npay_btn_text"]['mobile_goods_h']?>"></iframe>
						</td>
						<td class="center" valign="top">
							<iframe name="npay_mobile_goods_cart" id="npay_mobile_goods_cart" src="../marketing/npay_btn_style_iframe?mode=mobile_goods&type=cart" frameborder=0 border=0 width="350" height="<?php echo $TPL_VAR["sel_npay_btn_text"]['mobile_goods_h']?>"></iframe>
						</td>
					</tr>
				</table>
			</td>
		</tr>
<?php }?>
		<tr>
			<th>
				상품 연동 제외
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/marketing', '#tip14', 'sizeM')"></span>
			</th>
			<td colspan="3" class="clear">
				<table class="table_basic thl v3" style="border-left: 0 !important;">									
					<tbody>
						<tr>
							<th>상품</th>								
							<td>
								<input type="button" value="상품 선택" class="btn_select_goods resp_btn active" data-goodstype='except_goods' />
								<span class="span_select_goods_del <?php if(count($TPL_VAR["navercheckout"]["except_goods"])== 0){?>hide<?php }?>"><input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" selectType="goods" /></span>
								<div class="mt10 wx600 <?php if(count($TPL_VAR["navercheckout"]["except_goods"])== 0){?>hide<?php }?>">
									<div class="goods_list_header">
										<table class="table_basic tdc">
											<colgroup>
												<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
												<col width="25%" />
												<col width="45%" />
<?php }else{?>
												<col width="70%" />
<?php }?>

												<col width="20%" />
											</colgroup>
											<tbody>
												<tr>
												<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" onClick="gGoodsSelect.checkAll(this)" value="goods"></label></th>
<?php if(serviceLimit('H_AD')){?>
												<th>입점사명</th>
<?php }?>
												<th>상품명</th>
												<th>판매가</th>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="goods_list">
										<table class="table_basic tdc">
											<colgroup>
												<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
												<col width="25%" />
												<col width="45%" />
<?php }else{?>
												<col width="70%" />
<?php }?>
												<col width="20%" />
											</colgroup>
											<tbody>
												<tr rownum=0 <?php if(count($TPL_VAR["navercheckout"]["except_goods"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
													<td class="center" colspan="4">상품을 선택하세요</td>
												</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->
<?php if(is_array($TPL_R1=$TPL_VAR["navercheckout"]["except_goods"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
												<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
													<td><label class="resp_checkbox"><input type="checkbox" name='except_goodsTmp[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' /></label>
														<input type="hidden" name='except_goods[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' />
														<input type="hidden" name="except_goodsSeq[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["issuegoods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
														<td><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
													<td class='left'>
														<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></div>
														<div class="goodsname">
<?php if($TPL_V1["goods_code"]){?><div>[상품코드:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
															<div><?php echo $TPL_V1["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V1["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 30)?></a></div>
														</div>
													</td>
													<td class='right'><?php echo get_currency_price($TPL_V1["price"], 2)?></td>
												</tr>
<?php }}?>
											</tbody>
										</table>
									</div>
								</div>	
							</td>
						</tr>
						
						<tr>
							<th>카테고리</th>	
							<td class="categoryList">
								<input type="button" value="카테고리 선택" class="btn_category_select resp_btn active" />								
								<div class="mt10 wx600 category_list  <?php if(count($TPL_VAR["navercheckout"]["except_category_code"])== 0){?>hide<?php }?>">
									<table class="table_basic fix">
										<colgroup>
											<col width="85%" />
											<col width="15%" />
										</colgroup>
										<thead>
											<tr class="nodrag nodrop">
												<th>카테고리명</th>
												<th>삭제</th>	
											</tr>
										</thead>
										<tbody>
											<tr rownum=0 <?php if(count($TPL_VAR["navercheckout"]["except_category_code"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
												<td class="center" colspan="2">카테고리를 선택하세요</td>
											</tr>													
<?php if(is_array($TPL_R1=$TPL_VAR["navercheckout"]["except_category_code"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
											<tr rownum="<?php echo $TPL_V1["category_code"]?>">
												<td class="center"><?php echo $TPL_V1["category_name"]?></td>
												<td class="center">
													<input type="hidden" name='issueCategoryCode[]' value='<?php echo $TPL_V1["category_code"]?>' />
													<input type="hidden" name="issueCategoryCodeSeq[<?php echo $TPL_V1["category_code"]?>]" value="<?php echo $TPL_V1["issuecategory_seq"]?>" />
													<button type="button" class="btn_minus"  selectType="category" category_seq="<?php echo $TPL_V1["category_code"]?>"></button>
												</td>
											</tr>
<?php }}?>
										</tbody>
									</table>
								</div>								
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<th>배송비</th>
			<td  colspan="3"><button type="button" class="shippingGroupInfoBtn resp_btn v2">보기</button></td>
		</tr>
		<tr>
			<th>도서공연비 소득공제<br/>대상 상품 선택</th>
			<td colspan="3"class="clear">
				<ul class="ul_list_02">
					<li>
						<div class="resp_radio">
							<label><input type="radio" name="navercheckout_culture" value="n" <?php if($TPL_VAR["navercheckout"]["culture"]==''||$TPL_VAR["navercheckout"]["culture"]=='n'){?>checked="checked"<?php }?> /> 없음</label>
							<label><input type="radio" name="navercheckout_culture" value="all" <?php if($TPL_VAR["navercheckout"]["culture"]=='all'){?>checked="checked"<?php }?>/> 전체 상품</label>
							<label><input type="radio" name="navercheckout_culture" value="choice" <?php if($TPL_VAR["navercheckout"]["culture"]=='choice'){?>checked="checked"<?php }?>/> 선택 상품</label>
						</div>
					</li>
					<li class="navercheckout_culture_choice hide clear">
						<table class="table_basic thl v3">									
							<tbody>
								<tr>
									<th>상품</th>								
									<td>
										<input type="button" value="상품 선택" class="btn_select_goods resp_btn active" data-goodstype='culture_goods' />
										<span class="span_select_goods_del <?php if(count($TPL_VAR["navercheckout"]["culture_goods"])== 0){?>hide<?php }?>"><input type="button" value="선택 삭제" class="select_goods_del resp_btn v3" /></span>
										<div class="mt10 wx600 <?php if(count($TPL_VAR["navercheckout"]["culture_goods"])== 0){?>hide<?php }?>">

											<div class="goods_list_header">
												<table class="table_basic tdc">
													<colgroup>
														<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
														<col width="25%" />
														<col width="45%" />
<?php }else{?>
														<col width="70%" />
<?php }?>

														<col width="20%" />
													</colgroup>
													<tbody>
														<tr>
														<th><label class="resp_checkbox"><input type="checkbox" name="chkAll" onClick="gGoodsSelect.checkAll(this)" value="goods"></label></th>
<?php if(serviceLimit('H_AD')){?>
															<th>입점사명</th>
<?php }?>
															<th>상품명</th>
															<th>판매가</th>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="goods_list">
												<table class="table_basic tdc">
													<colgroup>
														<col width="10%" />
<?php if(serviceLimit('H_AD')){?>
														<col width="25%" />
														<col width="45%" />
<?php }else{?>
														<col width="70%" />
<?php }?>
														<col width="20%" />
													</colgroup>
													<tbody>
														<tr rownum=0 <?php if(count($TPL_VAR["navercheckout"]["culture_goods"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
															<td class="center" colspan="4">상품을 선택하세요</td>
														</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->
<?php if(is_array($TPL_R1=$TPL_VAR["navercheckout"]["culture_goods"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
														<tr rownum="<?php echo $TPL_V1["goods_seq"]?>">
															<td><label class="resp_checkbox"><input type="checkbox" name='culture_goodsTmp[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' /></label>
																<input type="hidden" name='culture_goods[]' class="chk" value='<?php echo $TPL_V1["goods_seq"]?>' />
																<input type="hidden" name="culture_goodsSeq[<?php echo $TPL_V1["goods_seq"]?>]" value="<?php echo $TPL_V1["issuegoods_seq"]?>" /></td>
<?php if(serviceLimit('H_AD')){?>
																<td><?php echo $TPL_V1["provider_name"]?></td>
<?php }?>
															<td class='left'>
																<div class="image"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></div>
																<div class="goodsname">
<?php if($TPL_V1["goods_code"]){?><div>[상품코드:<?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
																	<div><?php echo $TPL_V1["goods_kind_icon"]?> <a href="/admin/goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">[<?php echo $TPL_V1["goods_seq"]?>]<?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 30)?></a></div>
																</div>
															</td>
															<td class='right'><?php echo get_currency_price($TPL_V1["price"], 2)?></td>
														</tr>
<?php }}?>
													</tbody>
												</table>
											</div>
										</div>
									</td>
								</tr>										
							</tbody>
						</table>									
					</li>
				</ul>			
			</td>
		</tr>
		<tr>
			<th>신청 및 관리</th>
			<td colspan="3">
				<a href="https://admin.pay.naver.com/join/step1" class="resp_btn active size_XL" target="_blank">신청</a>
				<a href="https://admin.checkout.naver.com/" class="resp_btn size_XL" target="_blank">관리</a>		
			</td>
		</tr>
	</table>

	<div class="box_style_05 mt15">
		<div class="title">안내</div>
		<ul class="bullet_hyphen">					
			<li>네이버 페이는 네이버 담당자의 최종 검수 이후 사용 가능합니다.</li>				
			<li>
				네이버 페이 주문금액의 과세/비과세 여부는 '사업자 유형'에 따라 결정됩니다.<br/>
				과세 : 개인사업자중 일반과세자, 법인사업자, 비과세 : 개인사업자중 면세사업자 및 간이과세자
			</li>
			<li>과세/비과세 처리에 대한 자세한 문의는 네이버 페이 고객센터(1588-3819)로 문의해 주세요.</li>
		</ul>
	</div>
	<!-- 네이버페이 이용시 안내 :: START -->
	<div id="npay_shipping_setting_guide_lay" class="hide">
<?php $this->print_("naverpay_desc",$TPL_SCP,1);?>

	</div>
	<!-- 네이버페이 이용시 안내 :: END -->	
	<!-- 네이버 페이 설정 :: 끝 -->
</div>

<!--네이버페이 가능 배송그룹 :: 시작-->
<div id="shippingGroupInfo" class="hide">
	<div class="content">		
		<table class="table_basic tdc">
			<colgroup>
<?php if(serviceLimit('H_AD')){?>
				<col width="21%" />
<?php }?>
				<col width="21%" />
				<col width="21%" />
				<col width="23%" />
				<col width="14%" />
			</colgroup>
			<tr>
<?php if(serviceLimit('H_AD')){?>
				<th>판매자</th>
<?php }?>
				<th>가능 배송그룹</th>
				<th>가능 배송방법</th>
				<th>연결된상품</th>
				<th>관리</th>
			</tr>			

<?php if($TPL_VAR["npay_shipping"]){?>
<?php if($TPL_npay_shipping_1){foreach($TPL_VAR["npay_shipping"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if(count($TPL_V2["shipping_set"])> 0){?>
			<tr>
<?php if(serviceLimit('H_AD')){?>
<?php if($TPL_I2== 0){?>
				<td rowspan="<?php echo count($TPL_V1)?>"><?php echo $TPL_V2["provider_info"]?></td>
<?php }?>
<?php }?>
				<td><?php echo $TPL_V2["shipping_group_name"]?>(<?php echo $TPL_V2["shipping_group_seq"]?>)</td>
				<td><?php echo implode("<br/>",$TPL_V2["shipping_set"])?></td>
				<td>
					<input name="modify_btn" onclick="window.open('/admin/goods/package_catalog?ship_grp_seq=<?php echo $TPL_V2["shipping_group_seq"]?>');" type="button" value="패키지 : <?php echo $TPL_V2["rel_goods_cnt"]['package']?>개" class="resp_btn"></span>
					<input name="modify_btn" onclick="window.open('/admin/goods/catalog?ship_grp_seq=<?php echo $TPL_V2["shipping_group_seq"]?>');" type="button" value="상품 : <?php echo $TPL_V2["rel_goods_cnt"]['goods']?>개" class="resp_btn"></span>
				</td>
				<td>
<?php if($TPL_V2["shipping_provider_seq"]> 1){?>
					<input name="modify_btn" onclick="window.open('/admin/setting/shipping_group_regist?provider_seq=<?php echo $TPL_V2["shipping_provider_seq"]?>&provider_name=<?php echo $TPL_V2["provider_info"]?>&shipping_group_seq=<?php echo $TPL_V2["shipping_group_seq"]?>');" type="button" value="수정" class="resp_btn v2">
<?php }else{?>
					<input name="modify_btn" onclick="window.open('/admin/setting/shipping_group_regist?shipping_group_seq=<?php echo $TPL_V2["shipping_group_seq"]?>');" type="button" value="수정" class="resp_btn v2">
<?php }?>
				</td>
			</tr>
<?php }?>
<?php }}?>
<?php }}?>
<?php }else{?>
			<tr>
				<td id="no_npay_shipping" colspan="<?php if(serviceLimit('H_AD')){?>5<?php }else{?>4<?php }?>">
					네이버페이 결제가 가능한 배송그룹이 없습니다.
				</td>
			</tr>
<?php }?>
		</table>		
		
		<div class="box_style_05 mt15">
			<div class="title">안내</div>
			<ul class="bullet_hyphen">					
				<li>네이버페이 배송비 규정에 의해 위의 배송그룹으로 연결된 상품만 네이버페이 결제가 가능합니다.</li>							
				<li>주소 오류, 네이버페이 통신 오류 등으로 배송비가 추가 과금 또는 누락될 수 있습니다. 이점 유의하시기 바랍니다.</li>
				<li>네이버 배송비 규정 <a href="https://www.firstmall.kr/customer/faq/1098" class="resp_btn_txt" target="_blank">자세히 보기</a></li>
				<li>새로운 배송그룹 추가를 원하는 경우 <a href="/admin/setting/shipping_group" class="resp_btn_txt" target="_blank">배송비</a>에서 추가해주세요.</li>
			</ul>
		</div>
	</div>

	<div class="footer">							
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>
<!--네이버페이 가능 배송그룹 :: 끝-->

<div id="lay_npay_btn_style" class="hide">
	<iframe name="npay" id="npay" frameborder=0 border=0 src="" style="width:100%;height:100%;" scrolling="no"></iframe>
</div>

<div id="lay_goods_select"></div><!-- 상품선택 레이어 -->
<div id="lay_category_select"></div><!-- 카테고리 선택 레이어 -->