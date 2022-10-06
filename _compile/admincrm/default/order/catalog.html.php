<?php /* Template_ 2.2.6 2022/05/17 12:05:25 /www/music_brother_firstmall_kr/admincrm/skin/default/order/catalog.html 000027226 */ 
$TPL_sitetypeloop_1=empty($TPL_VAR["sitetypeloop"])||!is_array($TPL_VAR["sitetypeloop"])?0:count($TPL_VAR["sitetypeloop"]);?>
<?php if(!$TPL_VAR["ajaxCall"]){?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<?php }?>
<div id="orderAdminSettle" class="hide"></div>
<div id="issueGoodsSelect" class="hide"></div>
<script type="text/javascript">
	/* variable for ajax list */
	var npage		= 1;
	var nstep		= '';
	var nnum		= '';
	var stepArr		= new Array();
	var allOpenStep	= new Array();
	var loading_status	= 'n';
	var searchTime		= "<?php echo date('Y-m-d H:i:s')?>";

	$(document).ready(function() {

<?php if(!$TPL_VAR["ajaxCall"]){?>
		$(window).css('overflow', 'scroll');
		$(window).scroll(function(){
			if	($(window).scrollTop() == ($(document).height() - $(window).height())){
				get_catalog_ajax();
			}
		});
<?php }else{?>
		$("#orderSearchDiv").scroll(function(){
			if	($("#orderSearchDiv").scrollTop() == ($("#orderSearchDiv").prop("scrollHeight") - $("#orderSearchDiv").height()-40)){
				get_catalog_ajax();
			}
		});


<?php }?>

		$(".all-check").toggle(function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',true);
		},function(){
			$(this).parent().find('input[type=checkbox]').attr('checked',false);
		});

		get_catalog_ajax();



		// 상단 주문 검색어 레이어 박스 : start
		$("#keyword").keyup(function (e) {
			if ($(this).val()) {
				$('.body_txt_order_keyword').text($(this).val());
				crmBodyOrderSearchLayerOpen();
			}else{
				$('.header_order_searchLayer').hide();
			}
		});

		$("#keyword").focus(function () {
			if ($(this).val() && $(this).val()!=$(this).attr('title')) {
				crmBodyOrderSearchLayerOpen();
			}
			$('.body_txt_keyword').html("");
			$('.body_order_search_type_text').hide();

		});

		$("a.body_order_link_keyword").click(function () {
			var sType = $(this).attr('s_type');
			$('#body_order_search_type').val(sType);
			$('.body_order_searchLayer').hide();
			setBodyOrderSearchTxt(sType);
			$("#keyword").blur();
		});

<?php if($TPL_VAR["ajaxCall"]){?>
			var offset = $("#keyword").offset();
			$('.body_order_search_type_text').css({
				'position' : 'absolute',
				'z-index' : 999,
				'left' : "1",
				'top' : "42px",
				'line-height' : '25px',
				'width':$("#keyword").width()-1,
				'height':$("#keyword").height()-5
			});
<?php }else{?>
			var offset = $("#keyword").offset();
			$('.body_order_search_type_text').css({
				'position' : 'absolute',
				'z-index' : 999,
				'left' : "1",
				'top' : "74px",
				'width':$("#keywordLayer").width()-1,
				'height':$("#keyword").height()-7
			});
<?php }?>


		$(".body_order_search_type_text").click(function () {
			$(".body_order_search_type_text").hide();
			$("#keyword").focus();
		});

		$(".header_order_searchLayer ul li").hover(function() {
			$(".header_order_searchLayer ul li").removeClass('hoverli');
			$(this).addClass('hoverli');
		});

		$("#keyword").keydown(function (e) {
			var searchbox = $(this);

			switch (e.keyCode) {
				case 40:
					if($('.bodyOrderSearchUl').find('li.hoverli').length == 0){
						$('.bodyOrderSearchUl').find('li:first-child').addClass('hoverli');
					}else{
						if($('.bodyOrderSearchUl').find('li:last-child').hasClass("hoverli") ){
							$('.bodyOrderSearchUl').find('li::last-child.hoverli').removeClass('hoverli');
							$('.bodyOrderSearchUl').find('li:first-child').addClass('hoverli');
						}else{
							$('.bodyOrderSearchUl').find('li:not(:last-child).hoverli').removeClass('hoverli').next().addClass('hoverli');
						}
					}
					break;
				case 38:
					if($('.bodyOrderSearchUl').find('li.hoverli').length == 0){
						$('.bodyOrderSearchUl').find('li:last-child').addClass('hoverli');
					}else{
						if($('.bodyOrderSearchUl').find('li:first-child').hasClass("hoverli")){
							$('.bodyOrderSearchUl').find('li::first-child.hoverli').removeClass('hoverli');
							$('.bodyOrderSearchUl').find('li:last-child').addClass('hoverli');
						}else{
							 $('.bodyOrderSearchUl').find('li:not(:first-child).hoverli').removeClass('hoverli').prev().addClass('hoverli');
						}
					}
					break;
				case 13 :
					var index=0;
					 $('.bodyOrderSearchUl').find('li').each(function(){
						if($(this).hasClass("hoverli")){
							index=$(this).index();
						}
					});

					$('.bodyOrderSearchUl').find('li>a').eq(index).click();
					//$('.header_searchLayer').hide();
					$("#keyword").blur();
					//topSearchMember();
					e.keyCode = null;
					return false;
					break;
			}
		});
		// 상단 주문 검색어 레이어 박스 : end

<?php if($_GET["body_order_search_type"]&&$_GET["keyword"]){?>
			setBodyOrderSearchTxt('<?php echo $_GET["body_order_search_type"]?>');

<?php }?>

	});

	function setBodyOrderSearchTxt(sType) {
		var search_type_array = new Array();
		search_type_array['all'] = "";
		search_type_array['order_user_name'] = "주문자 찾기";
		search_type_array['recipient_user_name'] = "받는분 찾기";
		search_type_array['depositor'] = "입금자 찾기";
		search_type_array['userid'] = "아이디 찾기";
		search_type_array['order_cellphone'] = "휴대폰 찾기";
		search_type_array['order_email'] = "이메일 찾기";
		$('.body_order_search_type_text').html(search_type_array[sType]+ " : " + $("#keyword").val()).show();
	}

	function crmBodyOrderSearchLayerOpen() {
		var offset = $("#keyword").offset();
		if( offset) {
			$('.body_order_searchLayer').css({
				'position' : 'absolute',
				'z-index' : 999,
				'left' : '1',
				'top' : '1',
				//'width':$("#header_search_keyword").width()+32
				'width':$("#keyword").width()+5
			}).show();
		}
	}

	function get_catalog_ajax(){
		
		if	(loading_status == 'n'){
			
			loading_status	= 'y';
<?php if(!$TPL_VAR["ajaxCall"]){?>
			var queryString			= '<?php echo $_SERVER["QUERY_STRING"]?>';
<?php }else{?>
			var queryString			= $("#search-form").serialize();
<?php }?>
			var stepArrCnt			= stepArr.length;
			var addParam			= '';
			for (var s = 0; s < stepArrCnt; s++ ){
				if	(stepArr[s]){
					addParam	+= '&stepBox%5B'+s+'%5D='+stepArr[s];
				}
			}
			$("#ajaxLoadingLayer").ajaxStart(function() { loadingStop(this); });
			var type = $('input[name="searchType"]').val();
			$.ajax({
				type: 'post',
				async: false,
				url: '../order/catalog_ajax',
				data: queryString +'&page='+npage+'&bfStep='+nstep+'&nnum='+nnum+'&searchTime='+searchTime+addParam+'&ajaxCall=<?php echo $TPL_VAR["ajaxCall"]?>'+'&searchType='+type,
				dataType: 'html',
				success: function(result) {


					$(".order-ajax-list<?php echo $TPL_VAR["ajaxCall"]?>").append(result);
					$(".custom-select-box").customSelectBox();
					$(".custom-select-box-multi").customSelectBox({'multi':true});

					if			(allOpenStep[nstep] == 'open'){
						$("tr.step"+nstep).find("span.btn-direct-open").each(function(){
							orderViewOnOff('open', $(this));
						});
					}else if	(allOpenStep[nstep] == 'close'){
						$("tr.step"+nstep).find("span.btn-direct-open").each(function(){
							orderViewOnOff('close', $(this));
						});
					}

					nstep	= $("#"+npage+"_step").val();
					nnum	= $("#"+npage+"_no").val();
					npage++;

					loading_status	= 'n';


					$(".help, .helpicon").poshytip({
						className: 'tip-darkgray',
						bgImageFrameSize: 8,
						alignTo: 'target',
						alignX: 'right',
						alignY: 'center',
						offsetX: 10,
						allowTipHover: false,
						slide: false,
						showTimeout : 0
					});


				}
			});
			$("#ajaxLoadingLayer").ajaxStart(function() { loadingStart(this); });
		}
	}


	function new_catalog_ajax(){
		npage		= 1;
		nstep		= '';
		nnum		= '';
		stepArr		= new Array();
		allOpenStep	= new Array();

		loading_status	= 'y';
		var queryString			= $("#search-form").serialize();
		var stepArrCnt			= stepArr.length;
		var addParam			= '';
		for (var s = 0; s < stepArrCnt; s++ ){
			if	(stepArr[s]){
				addParam	+= '&stepBox%5B'+s+'%5D='+stepArr[s];
			}
		}
		$("#ajaxLoadingLayer").ajaxStart(function() { loadingStop(this); });
		$.ajax({
			type: 'post',
			async: false,
			url: '../order/catalog_ajax',
			data: queryString +'&page='+npage+'&bfStep='+nstep+'&nnum='+nnum+'&searchTime='+searchTime+addParam+'&searchType=search',
			dataType: 'html',
			success: function(result) {


				$(".order-ajax-list<?php echo $TPL_VAR["ajaxCall"]?>").html(result);
				$(".custom-select-box").customSelectBox();
				$(".custom-select-box-multi").customSelectBox({'multi':true});

				if			(allOpenStep[nstep] == 'open'){
					$("tr.step"+nstep).find("span.btn-direct-open").each(function(){
						orderViewOnOff('open', $(this));
					});
				}else if	(allOpenStep[nstep] == 'close'){
					$("tr.step"+nstep).find("span.btn-direct-open").each(function(){
						orderViewOnOff('close', $(this));
					});
				}

				nstep	= $("#"+npage+"_step").val();
				nnum	= $("#"+npage+"_no").val();
				npage++;

				loading_status	= 'n';


				$(".help, .helpicon").poshytip({
					className: 'tip-darkgray',
					bgImageFrameSize: 8,
					alignTo: 'target',
					alignX: 'right',
					alignY: 'center',
					offsetX: 10,
					allowTipHover: false,
					slide: false,
					showTimeout : 0
				});


			}
		});
		$("#ajaxLoadingLayer").ajaxStart(function() { loadingStart(this); });

	}


	function set_date(start,end){
		$("input[name='regist_date[]']").eq(0).val(start);
		$("input[name='regist_date[]']").eq(1).val(end);
	}
</script>
<style type="text/css">
	div.search-form-container table.sf-keyword-table .sfk-td-txt .form_tit {width:50px; height:29px; line-height:30px; background:#696B77; text-align:center; color:#fff;}
	.body_order_search_type_text {background-color:#fff; padding-top:5px; line-height:17px; text-align:center; overflow:hidden; white-space:nowrap}
	.body_order_searchLayer {margin:29px 0 0 49px; width:513px !important; border:1px solid #797d86;background-color:#fff; padding:5px 0;word-break:break-all;}
	.body_order_searchLayer .body_txt_title {color:#999;font-size:11px;}
	.body_order_searchLayer .body_txt_keyword {color:#ff6633;}
	.body_order_searchLayer ul li {padding:2px 0 2px 5px;}
	.body_order_searchLayer .hoverli {background-color:#f5f5f5;}
	.search_label 	{display:inline-block;width:100px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;-o-text-overflow:ellipsis;vertical-align:middle}
	span.step_title {font-weight:normal;padding:0 5px 0 5px;}
	span.export-list {display:inline-block;background-url("/admin/skin/default/images/common/btn_list_release.gif");width:60px;height:15px;}
	div.btn-open-all {position:absolute;top:3px;left:-62px;}
	div.btn-open-all img { cursor:pointer;}
	.ft11	{font-size:11px;}
	.barcode-btn {position:absolute; top:-34px; left:10px; cursor:pointer}
	.barcode-btn .openImg{display:block;}
	.barcode-btn .closeImg{display:none;}
	.barcode-btn.opened .openImg{display:none;}
	.barcode-btn.opened .closeImg{display:block;}
	.barcode-description {display:none; background-color:#d2d8d8; border-top:1px solid #c4cccc; border-bottom:1px solid #c4cccc; text-align:center}
	.darkgreen {color:#009900;}
	.ui-combobox {position:relative; display:inline-block;}
	.ui-combobox-toggle {position:absolute; top:0; bottom:0; margin-left:-1px; padding:0; /* adjust styles for IE 6/7 */ *height:1.7em; *top:0.1em;}
	.ui-combobox-input {margin:0; padding:0.3em;}
	.ui-autocomplete {max-height:200px; overflow-y:auto; /* prevent horizontal scrollbar */ overflow-x:hidden;}
	table.export_table {border-collapse:collapse;border:1px solid #c8c8c8;width:100%}
	table.export_table th {padding:5px; border:1px solid #c8c8c8;}
	table.export_table td {padding:5px; border:1px solid #c8c8c8;}
	table.export_table th {background-color:#efefef;}
</style>

<?php if(!$TPL_VAR["ajaxCall"]){?>
<div class="orderTitle">주문</div>
<?php }?>
<!-- 주문리스트 검색폼 : 시작 -->
<div class="search-form-container">
	<form name="search-form" id="search-form" method="get">
	<input type="hidden" name="order_seq" value="<?php echo $_GET["order_seq"]?>">
	<input type="hidden" name="ajaxCall" value="<?php echo $TPL_VAR["ajaxCall"]?>">
	<input type="hidden" name="searchType" value="<?php echo $_GET["searchType"]?>">
	<table class="search-form-table" id="search_detail_table">
	<tr>
		<td>
			<table class="sf-option-table" border="0">
				<colgroup>
					<col width="80" /><col />
				</colgroup>
				<tbody>
					<tr>
						<td colspan="2" align="center">
							<table align="center">
							<tr>
								<td width="565">
									<table class="sf-keyword-table">
									<tr>
										<td class="sfk-td-txt" id="keywordLayer">
											<div id="body_crm_search_keyword_div" class="hs-box">
												<span class="fl form_tit">주문</span>
												<input type="text" name="keyword" id="keyword" value="<?php echo $_GET["keyword"]?>" title="주문자,받는분,입금자,아이디,휴대폰,이메일" class="fl" />
											</div>
											<!-- 검색어 입력시 레이어 박스 : start -->
											<div class="body_order_search_type_text hide"><?php echo $_GET["body_order_search_type"]?></div>
											<div class="body_order_searchLayer hide">
												<input type="hidden" name="body_order_search_type" id="body_order_search_type" value="<?php echo $_GET["body_order_search_type"]?>" />
												<ul class="bodyOrderSearchUl">
													<li><a class="body_order_link_keyword" s_type="all" href="#"><span class="body_txt_order_keyword"><?php echo $_GET["keyword"]?></span> <span class="body_txt_title">- 주문 전체검색</span></a></li>
													<li><a class="body_order_link_keyword" s_type="order_user_name" href="#">주문자 : <span class="body_txt_order_keyword"><?php echo $_GET["keyword"]?></span> <span class="body_txt_title">- 주문자 찾기</span></a></li>
													<li><a class="body_order_link_keyword" s_type="recipient_user_name" href="#">받는분 : <span class="body_txt_order_keyword"><?php echo $_GET["keyword"]?></span> <span class="body_txt_title">- 받는분 찾기</span></a></li>
													<li><a class="body_order_link_keyword" s_type="depositor" href="#">입금자 : <span class="body_txt_order_keyword"><?php echo $_GET["keyword"]?></span> <span class="body_txt_title">- 입금자 찾기</span></a></li>
													<li><a class="body_order_link_keyword" s_type="userid" href="#">아이디 : <span class="body_txt_order_keyword"><?php echo $_GET["keyword"]?></span> <span class="body_txt_title">- 휴대폰 찾기</span></a></li>
													<li><a class="body_order_link_keyword" s_type="order_cellphone" href="#">휴대폰 : <span class="body_txt_order_keyword"><?php echo $_GET["keyword"]?></span> <span class="body_txt_title">- 휴대폰 찾기</span></a></li>
													<li><a class="body_order_link_keyword" s_type="order_email" href="#">이메일 : <span class="body_txt_order_keyword"><?php echo $_GET["keyword"]?></span> <span class="body_txt_title">- 이메일 찾기</span></a></li>
												</ul>
											</div>
											<!-- 검색어 입력시 레이어 박스 : end -->
										</td>
									</tr>
									</table>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="pdb5" align="center">
							<table class="">
							<tr>
								<th>
									<select name="date_field">
									<option value="regist_date" <?php if($_GET["date_field"]=='regist_date'||!$_GET["date_field"]){?>selected<?php }?>>주문일</option>
									<option value="deposit_date" <?php if($_GET["date_field"]=='deposit_date'){?>selected<?php }?>>입금일</option>
									</select>
								</th>
								<td>
									<input type="text" name="regist_date[]" value="<?php echo $_GET["regist_date"][ 0]?>" class="datepicker line"  maxlength="10" size="10" />
									&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
									<input type="text" name="regist_date[]" value="<?php echo $_GET["regist_date"][ 1]?>" class="datepicker line" maxlength="10" size="10" />
									&nbsp;&nbsp;
									<span class="btn small"><input type="button" value="오늘" onclick="set_date('<?php echo date('Y-m-d')?>','<?php echo date('Y-m-d')?>')" /></span>
									<span class="btn small"><input type="button" value="3일간" onclick="set_date('<?php echo date('Y-m-d',strtotime("-3 day"))?>','<?php echo date('Y-m-d')?>')" /></span>
									<span class="btn small"><input type="button" value="일주일" onclick="set_date('<?php echo date('Y-m-d',strtotime("-7 day"))?>','<?php echo date('Y-m-d')?>')"/></span>
									<span class="btn small"><input type="button" value="1개월" onclick="set_date('<?php echo date('Y-m-d',strtotime("-1 month"))?>','<?php echo date('Y-m-d')?>')"/></span>
									<span class="btn small"><input type="button" value="3개월" onclick="set_date('<?php echo date('Y-m-d',strtotime("-3 month"))?>','<?php echo date('Y-m-d')?>')" /></span>
									<span class="btn small"><input type="button" value="전체" onclick="set_date('','')" /></span>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th class="pdl10">출고 전</th>
						<td>
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1< 50||$TPL_K1> 80){?>
<?php if($_GET["chk_step"][$TPL_K1]){?>
							<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" checked="checked" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }else{?>
							<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }?>
<?php }?>
<?php }}?>
							<span class="icon-check hand all-check"><b>전체</b></span>
						</td>
					</tr>
					<tr>
						<th class="pdl10">출고 후</th>
						<td >
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1>= 50&&$TPL_K1< 80){?>
<?php if($_GET["chk_step"][$TPL_K1]){?>
							<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" checked="checked" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }else{?>
							<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }?>
<?php }?>
<?php }}?>
							<span class="icon-check hand all-check"><b>전체</b></span>
						</td>
					</tr>
					<tr>
						<th class="pdl10">결제수단</th>
						<td >
<?php if(is_array($TPL_R1=config_load('payment'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if(!preg_match('/escrow/',$TPL_K1)){?>
							<label class="search_label"><input type="checkbox" name="payment[]" value="<?php echo $TPL_K1?>" <?php if(in_array($TPL_K1,$_GET["payment"])){?>checked<?php }?> /> <?php echo $TPL_V1?></label>
<?php }?>
<?php }}?> 
							<span class="icon-check hand all-check"><b>전체</b></span>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" class="pdt15">
<?php if(!$TPL_VAR["ajaxCall"]){?>
							<span class="btn_crm_search"><button type="submit">검색<span class="arrow"></span></button></span>
<?php }else{?>
							<span class="btn_crm_search"><button type="button" onclick="new_catalog_ajax();">검색<span class="arrow"></span></button></span>
<?php }?>
						</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	</table>
	</form>
</div>
<!-- 주문리스트 검색폼 : 끝 -->
<br style="line-height:20px;">
<!-- 주문리스트 테이블 : 시작 -->
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="100" />
		<col width="150" />
		<col />
		<col width="45" />
		<col width="45" />
		<col width="100" />
		<col width="100" />
		<col width="70" />
		<col width="70" />
<?php if($TPL_VAR["ajaxCall"]){?>
		<col width="60" />
<?php }?>
	</colgroup>
	<thead class="lth">
	<tr>
		<th>주문일시</th>
		<th>주문번호</th>
		<th>주문상품</th>
		<th>수(종)</th>
		<th>출고</th>
		<th>받는분 / 주문자</th>
		<th>결제수단/일시</th>
		<th>결제금액</th>
		<th>처리상태</th>
<?php if($TPL_VAR["ajaxCall"]){?>
		<th>CRM</th>
<?php }?>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->
	<!-- 리스트 : 시작 -->
	<tbody class="ltb order-ajax-list<?php echo $TPL_VAR["ajaxCall"]?>"></tbody>
	<!-- 리스트 : 끝 -->
</table>
<!-- 주문리스트 테이블 : 끝 -->
<div class="hide" id="search_detail_dialog">
<form name="set_search_detail" method="post" action="set_search_default" target="actionFrame">
<div id="contents">
	<table class="search-form-table">
	<tr>
		<td>
			<table class="sf-option-table">
			<tr>
				<th width="100">주문일</th>
				<td class="date" height="30">
					<label class="search_label"><input type="radio" name="regist_date" value="today" <?php if(!$_GET["regist_date_type"]||$_GET["regist_date_type"]=='today'){?> checked="checked" <?php }?>/> 오늘</label>
					<label class="search_label"><input type="radio" name="regist_date" value="3day" <?php if($_GET["regist_date_type"]=='3day'){?> checked="checked" <?php }?>/> 3일간</label>
					<label class="search_label"><input type="radio" name="regist_date" value="7day" <?php if($_GET["regist_date_type"]=='7day'){?> checked="checked" <?php }?>/> 일주일</label>
					<label class="search_label"><input type="radio" name="regist_date" value="1mon" <?php if($_GET["regist_date_type"]=='1mon'){?> checked="checked" <?php }?>/> 1개월</label>
					<label class="search_label"><input type="radio" name="regist_date" value="3mon" <?php if($_GET["regist_date_type"]=='3mon'){?> checked="checked" <?php }?>/> 3개월</label>
					<label class="search_label"><input type="radio" name="regist_date" value="all" <?php if($_GET["regist_date_type"]=='all'){?> checked="checked" <?php }?>/> 전체</label>
				</td>
			</tr>

			<tr>
				<th>출고 전</th>
				<td>
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1< 50||$TPL_K1> 80){?>
<?php if($_GET["chk_step"][$TPL_K1]){?>
					<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" checked="checked" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }else{?>
					<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }?>
<?php }?>
<?php }}?>
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			<tr>
				<th>출고 후</th>
				<td>
<?php if(is_array($TPL_R1=config_load('step'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1>= 50&&$TPL_K1< 80){?>
<?php if($_GET["chk_step"][$TPL_K1]){?>
					<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" checked="checked" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }else{?>
					<label class="search_label"><input type="checkbox" name="chk_step[<?php echo $TPL_K1?>]" value="1" /> <span class="icon-order-step-<?php echo $TPL_K1?>"><?php echo $TPL_V1?></span></label>
<?php }?>
<?php }?>
<?php }}?>
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			<tr>
				<th>결제수단</th>
				<td>
<?php if(is_array($TPL_R1=config_load('payment'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if(!preg_match('/escrow/',$TPL_K1)){?>
<?php if($_GET["payment"][$TPL_K1]){?>
					<label class="search_label"><input type="checkbox" name="payment[<?php echo $TPL_K1?>]" value="1" checked="checked" /> <?php echo $TPL_V1?></label>
<?php }else{?>
					<label class="search_label"><input type="checkbox" name="payment[<?php echo $TPL_K1?>]" value="1" /> <?php echo $TPL_V1?></label>
<?php }?>
<?php }?>
<?php }}?>
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			<tr>
				<th>판매환경</th>
				<td>
<?php if($TPL_sitetypeloop_1){foreach($TPL_VAR["sitetypeloop"] as $TPL_K1=>$TPL_V1){?>
<?php if($_GET["sitetype"][$TPL_K1]){?>
						<label class="search_label" <?php if($TPL_K1=='MF'){?>style="width:150px"<?php }?> ><input type="checkbox" name="sitetype[<?php echo $TPL_K1?>]" value="<?php echo $TPL_K1?>" checked="checked" /> <?php echo $TPL_V1["name"]?></label>
<?php }else{?>
						<label class="search_label"  <?php if($TPL_K1=='MF'){?>style="width:150px"<?php }?> ><input type="checkbox" name="sitetype[<?php echo $TPL_K1?>]" value="<?php echo $TPL_K1?>" /> <?php echo $TPL_V1["name"]?></label>
<?php }?>
<?php }}?>
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			<tr>
				<th>주문유형</th>
				<td>
					<label class="search_label" ><input type="checkbox" name="ordertype[personal]" value="personal" <?php if($_GET["ordertype"]['personal']){?>checked<?php }?>/> <img src="/admin/skin/default/images/design/icon_order_personal.gif" align="absmiddle" /> 개인결제</label>
					<label class="search_label" ><input type="checkbox" name="ordertype[personal]" value="personal" <?php if($_GET["ordertype"]['personal']){?>checked<?php }?>/> <img src="/admin/skin/default/images/design/icon_order_personal.gif" align="absmiddle" /> 개인결제</label>
					<label class="search_label" ><input type="checkbox" name="ordertype[change]" value="change" <?php if($_GET["ordertype"]['change']){?>checked<?php }?>/> <img src="/admin/skin/default/images/design/icon_order_exchange.gif" align="absmiddle" /> 맞교환</label>
					<label class="search_label" ><input type="checkbox" name="ordertype[gift]" value="gift" <?php if($_GET["ordertype"]['gift']){?>checked<?php }?>/> <img src="/admin/skin/default/images/design/icon_order_gift.gif" align="absmiddle" /> 사은품</label>
					<span class="icon-check hand all-check"><b>전체</b></span>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>
<div align="center" style="padding-top:10px;">
	<span class="btn large black">
		<button type="submit">저장하기<span class="arrowright"></span></button>
	</span>
</div>
</form>
</div>
<?php if(!$TPL_VAR["ajaxCall"]){?>
<?php $this->print_("layout_footer",$TPL_SCP,1);?>

<?php }?>