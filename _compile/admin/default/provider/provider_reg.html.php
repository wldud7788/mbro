<?php /* Template_ 2.2.6 2022/05/17 12:36:51 /www/music_brother_firstmall_kr/admin/skin/default/provider/provider_reg.html 000069018 */ 
$TPL_pgroup_list_1=empty($TPL_VAR["pgroup_list"])||!is_array($TPL_VAR["pgroup_list"])?0:count($TPL_VAR["pgroup_list"]);
$TPL_certify_1=empty($TPL_VAR["certify"])||!is_array($TPL_VAR["certify"])?0:count($TPL_VAR["certify"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<!--[if IE]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js?v=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js?v=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin-providershipping.js?v=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gGoodsSelectList.js?v=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/js/admin/providerRegist.js?v=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
<?php if($TPL_VAR["provider_id"]){?>
		$("form[name='settingForm'] select[name='provider_status'] option[value='<?php echo $TPL_VAR["provider_status"]?>']").attr("selected",true);

		$("form[name='settingForm'] select[name='provider_status']").addClass('status-is'+$("form[name='settingForm'] select[name='provider_status'] option:selected").val());

		$("form[name='settingForm'] select[name='provider_gb'] option[value='<?php echo $TPL_VAR["provider_gb"]?>']").attr("selected",true);

		$("form[name='settingForm'] select[name='deli_group'] option[value='<?php echo $TPL_VAR["deli_group"]?>']").attr("selected",true);

		upload_btn_cont('bank');
		upload_btn_cont('busi');
<?php }?>	

		$("form[name='settingForm'] select[name='provider_status']").change(function(){
			if	($(this).find("option:selected").val() == 'N'){
				$(this).removeClass('status-isY');
				$(this).addClass('status-isN');
			}else{
				$(this).removeClass('status-isN');
				$(this).addClass('status-isY');
			}
		});

		$("#infoZipcodeButton").live("click",function(){
			openDialogZipcode('info_');
		});

		$("#senderZipcodeButton").live("click",function(){
			openDialogZipcode('sender');
		});
		$("#returnZipcodeButton").live("click",function(){
			openDialogZipcode('return');
		});


		$("input[name='passwd_chg']").bind("click",function(){
			if($(this).attr("checked")){
				$("#r_pass").show();
				$("#manager_passwd_confirm").show();
			}else{
				$("#r_pass").hide();
				$("#manager_passwd_confirm").hide();
			}
		});
		
		$("#goods_set").bind("click",function(){
			openDialog("입점사 상품", "goodsPopup", {"width":400});
		});
		$("#calcu_set").bind("click",function(){

			var org_commission_type	= $('#org_commission_type').val();
			var org_charge			= $('#org_charge').val()=="" ? 0 : $('#org_charge').val();

			var sel_commission_type	= (org_commission_type == '' || org_commission_type == "SACO") ? "SACO" : "SUPPLY";
			var pop_height			= 260;

			if(sel_commission_type == 'SACO'){
				var hide_desc		= $('.SUPPLY_desc');
				$('input[name="brand_charge"]').val(org_charge);
			}else{
				var hide_desc		= $('.SACO_desc');
				$('select[name="supply_type"]').val(org_commission_type).trigger('change');;
				$('input[name="supply_charge"]').val(org_charge);
			}

<?php if($_GET["no"]!=''&&$_GET["no"]> 0){?>
			var pop_height		= 490;
			hide_desc.hide();
			$('#commission_type_comfirm_chk').attr('checked','checked')
			$('.both_desc').hide();
<?php }else{?>
			var pop_height		= 490;
<?php }?>

			$("input[name='sel_commission_type'][value='"+sel_commission_type+"']").click();
			openDialog("정산 기준 설정", "calcuPopup", {"width":"680","height":pop_height,"show" : "fade","hide" : "fade"});		
		});


		$("#calcu_select").bind("click",function(){

			var sel_commission_type	= $("input[name='sel_commission_type']:checked").val();
			var vali_msg			= '수수료율을 입력하세요.';
			if(sel_commission_type == 'SUPPLY'){
				var charge_sel		= "supply_charge";
				var commission_type	= $('select[name="supply_type"]').val();
				var help_message	= "※ 약속된 정산금액을 입점사에게 지급합니다.<br/>※ 해당 입점사 신규 판매상품은 설정된 기본값이 기본으로 입력되며 통신판매중계자(본사)만이 상품의 옵션별로 정산금액을 조정할 수 있습니다.";
				vali_msg			= '정산금액을 설정하세요.';
			}else{
				var charge_sel		= "brand_charge";
				var commission_type	= sel_commission_type;
				var help_message	= "※ 정산대상금액을 기준으로 수수료를 제외한 금액을 입점사에게 지급합니다.<br>※ 정산대상금액이란? 각종 할인금액(쿠폰, 마일리지, 등급할인, 모바일할인, 에누리 등)에 대한 통신판매중계자(본사)의 부담금액이 반영된 금액입니다.<br/>※ 해당 입점사 신규 판매상품은 설정된 기본값이 기본으로 입력되며 통신판매중계자(본사)만이 상품의 옵션별로 수수료율을 조정할 수 있습니다.";
				vali_msg			= '수수료율을 입력하세요.';
			}

			var charge				= $('input[name="'+charge_sel+'"]').val();
			var chk_type			= (commission_type != 'SUPR') ? '%' : '원';

			if(!charge){
				alert(vali_msg);
				return;
			}

			if(charge == 0){
				alert('정산 금액 수수료 방식 또는 공급가 방식은 0.1%이상만 가능합니다.');
				return;
			}

			if(chk_type == '%'){
				if(charge > 100){
					$('input[name="'+charge_sel+'"]').val(0);
					alert('수수료는 100%보다 클 수 없습니다.');
					return false;
				}
				var check			= charge.match(/\.[0-9]+/);
				if(check > 0 && check.toString().length > 3){
					alert('소숫점 2자리까지 가능합니다.(2자리 초과 절삭)');
				}
				
				if(check > 0 && check.toString().length < 4){
					var changed = (charge * 100) / 100;
					var charge	 = changed.toFixed(2).replace(/0+$/,'');
				}else{
					var charge	= Math.floor(charge * 100) / 100;
				}

				$('input[name="'+charge_sel+'"]').val(charge)
			}

			if($('#commission_type_comfirm_chk').attr('checked') != 'checked'){
				alert('동의사항에 체크해 주세요.');
				return false;
			}

			var desc = "<strong>1. 정산금액 산출</strong><br/>";
			switch(commission_type){
				case	'SACO':
					var def = "<div>수수료방식 : 정산금액 = 정산대상금액 - (정산대상금액 X <span style='color:red'>"+charge+"</span>)%</div>";					
				break;
				case	'SUCO':
					var def = "<div>공급가방식 : 정산금액 = 정가 X <span style='color:red'>"+charge+"%</span></div>";				
				break;
				case	'SUPR':
					var def = "<div>공급가방식 : 정산금액 = <span style='color:red'>"+comma(charge)+"원</span></div>";				
				break;
			}			

			var msg2 = "<br/><br/><strong>2. 정산대상 기준</strong><br/>배송 : 구매확정된 출고건<br/>환불 : 환불완료된 환불건";
			def = desc + def + help_message + msg2;

			$("input[name='charge']").val(charge);
			$("input[name='commission_type']").val(commission_type);
			$("#org_charge").val(charge);
			$("#org_commission_type").val(commission_type);

			var brand = document.getElementsByName("brand[]");
			var brand_charge = document.getElementsByName("brand_charge[]");
			for(var i=0;i<brand.length;i++){
				if(brand[i].value && brand_charge[i].value){
					var temp_arr = brand[i].value.split("|");
					def += "<div>"+temp_arr[1]+"("+temp_arr[0]+") : "+brand_charge[i].value+"% <input type='hidden' name='brand_ch[]' value='"+brand[i].value+"'/><input type='hidden' name='brand_per[]' value='"+brand_charge[i].value+"'/></div>";
				}
			}
			
			//정산 기준 설정 값 노출
			setCalcuSetInfo(commission_type, charge)

			$("#calcu_div").html(def);
			closeDialog("calcuPopup");
		});

		$("#calcu_pop_close").click(function(){closeDialog("calcuPopup");});
		$("#id_chk").click(function(){
			var id = $("input[name='provider_id']").val();
			if(!id){
				alert("입접사ID를 입력해 주세요.");
				$("input[name='provider_id']").focus();
				return;
			}
			$.post("../provider_process/provider_chk", { provider_id : id }, function(response){
				//debug(response);
				//var text = response.return_result;
				//var manager_id = response.manager_id;
				alert(response.return_result);
			},'json');
		});

		// ICON
		$("button#bankBtn").live("click",function(){
			openDialog("계좌 사본  <span class='desc'></span>", "bankPopup", {"width":"350","height":"250","show" : "fade","hide" : "fade"});
		});
		/*
		$("button#busiBtn").live("click",function(){
			openDialog("사업자등록증 사본  <span class='desc'></span>", "busiPopup", {"width":"350","height":"250","show" : "fade","hide" : "fade"});
		});
		*/
		$(".registMshopVisualimage").live("click",function(){
			$provider_id	= <?php if($TPL_VAR["provider_id"]){?>'<?php echo $TPL_VAR["provider_id"]?>'<?php }else{?>$("input[name='provider_id']").val()<?php }?>;
			window.open('../setting/mshop_popup_image?id='+$provider_id+'&target=main_visual','','width=500,height=250');
		});

		$("#main_visual_name").live('mouseover',	function(){$('#preview_main_visual').show();});
		$("#main_visual_name").live('mouseout',		function(){$('#preview_main_visual').hide();});
<?php if($TPL_VAR["main_visual"]){?>
		$(".deleteVisual").live("click",function(){
			$("input[name='del_main_visual']").val('y');
			$("#btn_deletevidual").hide();
			$("#main_visual_name").html('');
			$("#preview_main_visual").html('');
		});
<?php }?>

		$("select[name='provider_statistic']").on('change', function(){
			var this_css	= $(".head-rbtn").attr('class');
			if($(this).val()=="")
			{
				$(".statistics_area").slideUp();
				$(".head-rbtn").removeClass('open');
				$(".head-rbtn").html('<img src="/admin/skin/default/images/common/icon_search_detail_open.png">');
			}else{
				if	(this_css.search(/open/) == -1){				
					$(".head-rbtn").addClass('open');
					$(".head-rbtn").html('<img src="/admin/skin/default/images/common/icon_search_detail_close.png">');				
				}
				getProviderStatistic('');
			}
		});

		$(".head-rbtn").on("click", function(){
			var this_css	= $(this).attr('class');
			
			if	(this_css.search(/open/) == -1){
				getProviderStatistic('');
				$(this).addClass('open');
				$(this).html('<img src="/admin/skin/default/images/common/icon_search_detail_close.png">');
			}else{
				$(".statistics_area").slideUp();
				$(this).removeClass('open');
				$(this).html('<img src="/admin/skin/default/images/common/icon_search_detail_open.png">');
			}
		});


		/******** 쿠폰사용 확인코드 관련 **********/

		//SMS보내기
		$(".manager_sms_send").live("click",function(event){
			if( $(this).parent().parent().find("input[name='certify_code[]']").val() == $(this).parent().parent().find("input[name='certify_code[]']").attr('title') ){
				openDialogAlert("확인코드를 입력해주세요.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
				return false;
			}
			if(  $(this).parent().parent().find("input[name='certify_code_chk[]']").val() != 'ok' ){
				openDialogAlert("사용가능한 확인코드인지 [인증]해 주세요!", 350, 150, function(){});
				return false;
			}

			var certify_code = $(this).parent().parent().find("input[name='certify_code[]']").val();
			$.get('../member/sms_pop?certify_code='+certify_code, function(data) {
				$('#sendPopup').html(data);
				openDialog("SMS 발송 <span class='desc'></span>", "sendPopup", {"width":"600","height":"200"});
			});
		});

		// 직원추가
		$("#addManager").bind("click", function(){
			var addHTML	= '';
			addHTML	+= '<div>'+"\n";
			addHTML	+= '<input type="hidden" name="certify_seq[]" value="" size="10" class="line" />'+"\n";
			addHTML	+= '<input type="text" name="manager_name[]" value="" size="45" class="line" title="해당 확인코드를 사용하는 매장 정보를 입력하세요." />'+"\n";
			addHTML	+= '<input type="hidden" name="certify_code_chk[]" value="" /><input type="text" name="certify_code[]" value="" size="50"  class="line" title="확인코드 (6자리 이상. 16자리 이하 영문 또는 숫자)" />'+"\n";
			addHTML	+= '<span class="btn small black"><button type="button" class="certify_btn">인증</button></span>'+"\n";
			addHTML	+= '<span class="btn-minus btnplusminus"><button type="button" class="delManager"></button></span>'+"\n";
			addHTML	+= '<span class="btn small cyanblue"><button type="button" class="manager_sms_send">매장 담당자에게 SMS 보내기</button></span></div>'+"\n";

			$("#cerfify_manager").append(addHTML);
			setDefaultText();
		});

		// 직원 삭제
		$(".delManager").live('click', function(){
			$(this).parent().parent().remove();
		});

		// 인증
		$(".certify_btn").live('click', function(){
			var parent			= $(this).parent().parent();
			$(parent).find("input[name='certify_code_chk[]']").val('');//초기화
			var certify_seq		= $(parent).find("input[name='certify_seq[]']").val();
			var certify_code	= $(parent).find("input[name='certify_code[]']").val();
			var titles			= $(parent).find("input[name='certify_code[]']").attr('title');
			certify_code		= certify_code.replace(titles, '');

			if	(!certify_code){
				openDialogAlert("확인코드를 입력해주세요.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
				return;
			}
			if	(certify_code.length < 6 || certify_code.length > 16){
				openDialogAlert("확인코드는 6자리 이상 16자리 이하로 입력해주세요.", 400, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
				return;
			}
			if	(certify_code.search(/[^0-9a-zA-Z]/) != -1){
				openDialogAlert("확인코드는 영문 또는 숫자로 입력해주세요.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
				return;
			}
			var dup = false;
			var $inp = $("input[name='certify_code[]']");
			var certify_code_idx = $(".certify_btn").index(this);
			$inp.each(function() {
				var selidx = $("input[name='certify_code[]']").index(this);
				var codenew = $(this).val();
				var codetitle = $(this).attr('title');
				codenew = codenew.replace(codetitle, '');
				if( certify_code == codenew && certify_code_idx != selidx ) {
					dup = true;
					return false;
				}
			});

			if(dup){
				openDialogAlert("중복된 확인코드입니다.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
				return false;
			}

			$.ajax({
				type: "get",
				url: "chk_certify_code",
				data: "certify_code="+certify_code+"&certify_seq="+certify_seq,
				success: function(result){
					if	(result == 'ok')
						openDialogAlert("사용 가능한 확인코드입니다.", 300, 150, function(){$(parent).find("input[name='certify_code_chk[]']").val('ok')});
					else if	(result == 'duple')
						openDialogAlert("중복된 확인코드입니다.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
					else if	(result == 'error_1')
						openDialogAlert("확인코드를 입력해주세요.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
					else if	(result == 'error_2')
						openDialogAlert("확인코드는 6자리 이상 16자리 이하로 입력해주세요.", 400, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
					else if	(result == 'error_3')
						openDialogAlert("확인코드는 영문 또는 숫자로 입력해주세요.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
					else
						openDialogAlert("확인코드 인증에 실패하였습니다.", 400, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
				}
			});
		});


		/* 아이피 추가 */
		$("#ipViewTable button#ipAdd").live("click",function(){
			var html="";
			html = '<tr>';
			html += '	<td>';
			html += '	<input type="text" name="limit_ip1[]" value="" class="line limit_ip" size=4 maxlength=3 />.';
			html += '	<input type="text" name="limit_ip2[]" value="" class="line limit_ip" size=4 maxlength=3 />.';
			html += '	<input type="text" name="limit_ip3[]" value="" class="line limit_ip" size=4 maxlength=3 />.';
			html += '	<input type="text" name="limit_ip4[]" value="" class="line limit_ip" size=4 maxlength=3 />';
			html += '	<span class="btn-minus"><button type="button" id="ipDel"></button></span>';
			html += '	</td>';
			html += '</tr>';

			$("#ipViewTable").append(html);
			init_func();
		});

		/* 아이피 삭제 */
		$("#ipViewTable button#ipDel").live("click",function(){
			if($("#ipViewTable tr").length > 1) $(this).parent().parent().parent().remove();
		});


		$("input[name='ip_chk']").click(function(){
			init_func();
		});

		$("input[name='hp_chk']").click(function(){
			init_hp();
		});


		/******** /쿠폰사용 확인코드 관련 **********/

		set_calcu_day();
		init_func();
		init_hp();

		//check_account_period_type();


		$("input[name='sel_commission_type']").click(function(){
			$("input[name='sel_commission_type']:checked").siblings().attr('disabled',true);

			if(this.value == 'SACO'){
				now_val		= 'SACO';
				prev_val	= 'SUPPLY';
				$('.commission_type_confirm').text('수수료방식');
			}else{
				now_val		= 'SUPPLY';
				prev_val	= 'SACO';
				$('.commission_type_confirm').text('공급가방식');
			}
			$("input[name='sel_commission_type'][value='"+now_val+"']").siblings().attr('disabled',false);
			$("input[name='sel_commission_type'][value='"+prev_val+"']").siblings().attr('disabled',true);
			//$("input[name='sel_commission_type'][value='"+now_val+"']").parent().parent().css('color','black');
			//$("input[name='sel_commission_type'][value='"+prev_val+"']").parent().parent().css('color','gray');
		});

		$('select[name="supply_type"]').change(function(){

			$("input[name='supply_charge']").removeClass('onlyfloat');
			$("input[name='supply_charge']").removeClass('onlynumber');

			if(this.value == 'SUCO'){
				var supply_unit	= '%';
				var supply_mark	= 'X';
				var add_class	= 'onlyfloat';
			}else{
				var supply_unit	= '원';
				var supply_mark	= '';
				var add_class	= 'onlynumber';
			}

			$("input[name='supply_charge']").val('0');
			$("input[name='supply_charge']").addClass(add_class);
			$('.supply_unit').html(supply_unit);
			$('.supply_mark').html(supply_mark);
		});

		setContentsRadio("sel_commission_type", "<?php echo $TPL_VAR["sel_commission_type"]?>");
		
		//티켓 사용 확인 코드 추가(+)
		$(".plusBtn").on("click", function()
		{		
			var id = $(this).closest("table").attr("id");		
			var newClone = $("#cerfify_manager .cloneTr").eq(0).clone();	
			var trObj = $("#cerfify_manager > tbody > tr");
			newClone.find("input[type='text']").val("");
			trObj.parent().append(newClone);	
			newClone.find(".cloneTr").html("");			
		});

		$(".confirmPopupInfoBtn").on('click', function()
		{	
			var id = $(this).parent().parent().attr("id");			
			addhiddenText(id, id+"Container")
			closeDialog(id);
		});

		$(".btnLayClose").on('click',function()
		{	
			var id = $(this).parent().parent().attr("id");		
			closeDialog(id);		
		});
		
		// 이벤트 상세페이지 팝업
		$('.popupOpenBtn').on('click', function()
		{
			var name = $(this).data('name');
			var title;
			var option;

			switch (name) {
			
				case "detailPageSetting" :
					title = "상세 페이지 설정";
					option = {"width":"1000","height":"320","show" : "fade","hide" : "fade"};
					break;

				case "goodInfoStyle" :
					title = "상품 디스플레이";
					option = {"width":"1000","height":"730","show" : "fade","hide" : "fade"};
					break;		
			}

			openDialog(title, name,  option);
		});	

		$(".confirmPopupInfoBtn").trigger('click');	

		// 주소복사
		$('#url_copy').click(function()
		{
			clipboard_copy("<?php echo get_connet_protocol()?><?php echo $_SERVER["HTTP_HOST"]?><?php echo $TPL_VAR["mshop_url"]?>");
			alert("주소가 복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.");
		});
		
		//계좌 사본
		$('#bankBtn').createAjaxFileUpload(uploadConfig, uploadCallback);
<?php if($TPL_VAR["info_file"]){?>imgUploadEvent("#bankBtn", "", "/data/provider/", "<?php echo $TPL_VAR["calcu_file"]?>")<?php }?>	

		//사업자 등록증 사본
		$('#busiBtn').createAjaxFileUpload(uploadConfig, uploadCallback);
<?php if($TPL_VAR["info_file"]){?>imgUploadEvent("#busiBtn", "", "/data/provider/", "<?php echo $TPL_VAR["info_file"]?>")<?php }?>	

		//미니샵 소개 이미지	
		$('#mainVisualBtn').createAjaxFileUpload(uploadConfig, uploadCallback);
<?php if($TPL_VAR["main_visual"]){?>imgUploadEvent("#mainVisualBtn", "", "", "<?php echo $TPL_VAR["main_visual"]?>")<?php }?>	

<?php if($TPL_VAR["commission_type"]&&$TPL_VAR["charge"]){?> setCalcuSetInfo("<?php echo $TPL_VAR["commission_type"]?>", "<?php echo $TPL_VAR["charge"]?>")<?php }?>;
	});

	function setCalcuSetInfo(type, charge){
		var chargeType;
		var chargeUint = "%"
		switch(type){
			case	'SACO':					
				chargeType = "수수료, "
			break;
			case	'SUCO':				
				chargeType = "공급가, 정가 "
			break;
			case	'SUPR':				
				chargeType = "공급가, "
				chargeUint = "원"
			break;
		}

		$("#calcuSetInfo").html(chargeType+charge+chargeUint);
	}

	//티켓 사용 확인 코드 삭제(-)
	function trDel(tg)
	{
		var len = $(tg).closest("table").find("tr").length;
		if(len==2) return;
		$(tg).parent().parent().remove();		
	}


	function init_func(){

		if($("input[name='ip_chk']").attr("checked")){
			$(".limit_ip").attr("disabled",false);
		}else{
			$(".limit_ip").val('');
			$(".limit_ip").attr("disabled",true);
		}
	}


	function init_hp(){
		if($("input[name='hp_chk']").attr("checked")){
			$(".auth_hp").attr("disabled",false);
		}else{
			$("input[name='auth_hp']").val('');
			$(".auth_hp").attr("disabled",true);
		}
	}

	function getProviderStatistic(addParams){
		var pageType = $("select[name='provider_statistic'] option:selected").val();

		$(".statistics_area").html('');
		$(".statistics_area").show();

		$.ajax({
			type: "get",
			url: "provider_statistic",
			data: "pageType="+pageType+"&provider_seq=<?php echo $TPL_VAR["provider_seq"]?>"+addParams,
			success: function(result){
				$(".statistics_area").html(result);					
			}
		});
	}

	function calcuFileUpload(){
		var frm = $('#iconRegist');
		frm.attr("action","../provider_process/bankUpload?type=bank");
		frm.submit();
	}

	function busiFileUpload(){
		var frm = $('#iconRegist2');
		frm.attr("action","../provider_process/bankUpload?type=busi");
		frm.submit();
	}

	function bankHidden(str){
		$("input[name='calcu_file_hidden']").val(str);
		closeDialog("bankPopup");
		upload_btn_cont('bank');
	}

	function busiHidden(str){
		$("input[name='info_file_hidden']").val(str);
		closeDialog("busiPopup");
		upload_btn_cont('busi');
	}

	function upload_btn_cont(str){
		if(str=='bank'){
			if($("input[name='calcu_file_hidden']").val()){
				$("#b_cont_btn").show();
				$("#b_reg_btn").hide();
			}else{
				$("#b_cont_btn").hide();
				$("#b_reg_btn").show();
			}
		}else{
			if($("input[name='info_file_hidden']").val()){
				$("#b_cont_btn2").show();
				$("#b_reg_btn2").hide();
			}else{
				$("#b_cont_btn2").hide();
				$("#b_reg_btn2").show();
			}
		}
	}

	function deleteFile(str){
		if(!confirm("정말 삭제하시겠습니까?")) return;
		if(str=='bank'){
			$("input[name='calcu_file_hidden']").val('');
			upload_btn_cont('bank');
		}else{
			$("input[name='info_file_hidden']").val('');
			upload_btn_cont('busi');
		}
		alert("삭제되었습니다.");
	}

	function viewFile(str){
		var filenm = "";
		if(str=='bank'){
			filenm = $("input[name='calcu_file_hidden']").val();
		}else{
			filenm = $("input[name='info_file_hidden']").val();
		}
		if(!filenm) return;
		window.open("/data/provider/"+filenm,"","");
	}

	function selladmin_login(){
		document.selladminLoginForm.submit();
	}

	function set_calcu_day(){
		var select_obj = $("select[name='calcu_count']");
		var cnt = select_obj.find("option:selected").val();
		var td_obj = select_obj.closest("td").next();
		var calcu_day1 = '<?php echo $TPL_VAR["calcu_day"]?>';
		var calcu_day2 = '<?php echo $TPL_VAR["calcu_day2"]?>';
		var calcu_day3 = '<?php echo $TPL_VAR["calcu_day3"]?>';
		var calcu_day4 = '<?php echo $TPL_VAR["calcu_day4"]?>';
		td_obj.html('');
		if(cnt == 4){
			for(var i=0;i<cnt;i++){
				if(i==0){
					td_obj.append("<div><strong>1일 ~ 7일</strong> 사이의 정산금액을 <input type=\"text\" name=\"calcu_day[]\" value=\""+calcu_day1+"\" class=\"line\" maxlength=\"30\" size=\"30\" title=\"예시) 익월 00일에 지급합니다.\" /></div>");
				}
				if(i==1){
					td_obj.append("<div><strong>8일 ~ 14일</strong> 사이의 정산금액을 <input type=\"text\" name=\"calcu_day[]\" value=\""+calcu_day2+"\" class=\"line\" maxlength=\"30\" size=\"30\" title=\"예시) 익월 00일에 지급합니다.\" /></div>");
				}
				if(i==2){
					td_obj.append("<div><strong>15일 ~ 21일</strong> 사이의 정산금액을 <input type=\"text\" name=\"calcu_day[]\" value=\""+calcu_day3+"\" class=\"line\" maxlength=\"30\" size=\"30\" title=\"예시) 익월 00일에 지급합니다.\" /></div>");
				}
				if(i==3){
					td_obj.append("<div><strong>22일 ~ 말일</strong> 사이의 정산금액을 <input type=\"text\" name=\"calcu_day[]\" value=\""+calcu_day4+"\" class=\"line\" maxlength=\"30\" size=\"30\" title=\"예시) 익월 00일에 지급합니다.\" /></div>");
				}
			}
		}else if(cnt == 2){
			for(var i=0;i<cnt;i++){
				if(i==0){
					td_obj.append("<div><strong>1일 ~ 15일</strong> 사이의 정산금액을 <input type=\"text\" name=\"calcu_day[]\" value=\""+calcu_day1+"\" class=\"line\" maxlength=\"30\" size=\"30\" title=\"예시) 익월 00일에 지급합니다.\" /></div>");
				}
				if(i==1){
					td_obj.append("<div><strong>16일 ~ 말일</strong> 사이의 정산금액을 <input type=\"text\" name=\"calcu_day[]\" value=\""+calcu_day2+"\" class=\"line\" maxlength=\"30\" size=\"30\" title=\"예시) 익월 00일에 지급합니다.\" /></div>");
				}
			}
		}else if(cnt == 7){
			td_obj.append("<div><strong>월요일~일요일</strong> 사이의 정산금액을 <input type=\"text\" name=\"calcu_day[]\" value=\""+calcu_day1+"\" class=\"line\" maxlength=\"30\" size=\"30\" title=\"예시) 다다음주 수요일에 지급합니다.\" /></div>");
		}else{
			td_obj.append("<div><strong>1일 ~ 말일</strong> 사이의 정산금액을 <input type=\"text\" name=\"calcu_day[]\" value=\""+calcu_day1+"\" class=\"line\" maxlength=\"30\" size=\"30\" title=\"예시) 익월 00일에 지급합니다.\" /></div>");
		}

		apply_input_style();
		$("select[name='deli_group']").change(function(){
			get_provider_shipping();
		});
		get_provider_shipping();

	}

	function info_policy(){
		openDialog('안내) 개인정보 보호 법률','admin_policy_info',{'width':800,'height':380});
	}

	function confirm_first_goods(first_date,currency,hangul,nation,msg,func)
	{
		var params = {'yesMsg':'예','noMsg':'아니오'};
		var ph = 180;
		if( !first_date ){
			params = {'yesMsg':'저장','noMsg':'취소'};
			msg = '<div align="left">';
			msg	+= '현재 기본통화는 '+currency+'('+nation+', '+hangul+') 입니다.<br><br>';
			msg	+= '최초 입점사 상태를 ‘정상’ 등록한  이후에는 기본통화 변경이 불가능합니다.<br>';
			msg	+= '기본통화를 바꾸려면 설정><a href="../setting/multi"><span class="highlight-link">상점정보</span></a> 에서 하실 수 있습니다.<br>';
			msg	+= '(참고 : 입점사 상태를 ‘정상’ 으로 변경하면 입점사에서 설정된 기본통화로 상품을 등록할 수 있습니다. )<br>';
			msg	+= '현재 기본통화로 입점사 정보를 저장하려면 “저장’ 을 취소하려면 ‘취소’를 클릭해주세요</div>';
			ph = 300;
		}

		if(msg){
			openDialogConfirm(msg,400,ph,function(){
				eval( func );
			},function(){
			},params);
		}else{
				eval( func );
		}
	}

	function provider_save()
	{
		// reset
		var hangul = '', nation = '';

		var first_date		= '<?php echo $TPL_VAR["config_system"]["first_goods_date"]?>';
		var currency	= '<?php echo $TPL_VAR["config_system"]["basic_currency"]?>';
<?php if(is_array($TPL_R1=code_load('currency',$TPL_VAR["config_system"]["basic_currency"]))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		hangul		= '<?php echo $TPL_V1["value"]["hangul"]?>';
		nation			= '<?php echo $TPL_V1["value"]["nation"]?>';
<?php }}?>
		var func			= 'provider_submit();';

		var provider_status = $("select[name='provider_status'] option:selected").val();
		if(provider_status != '<?php echo $TPL_VAR["provider_status"]?>' && provider_status == 'Y'){
			confirm_first_goods(first_date, currency, hangul, nation, '', func);			
		}else{
			provider_submit();
		}
	}

	function provider_submit()
	{
		// 입력 옵션일 경우 form submit 이벤트를 에디터 이벤트로 호출
<?php if($TPL_VAR["provider_seq"]&&$TPL_VAR["operation_type"]=='light'){?>
			submitEditorForm($("form[name='settingForm']")[0]);
<?php }else{?>
			$("form[name='settingForm']")[0].submit();
<?php }?>
	}

	// 해당 input박스의 입력된 글자수를 계산
	function str_input_len(obj){
		var mobj	= $(obj).closest('td').find('span.view-len');
		var len	= $(obj).val().length;
		var max	= $(obj).attr('maxlength');
		mobj.removeClass('red');
		if(len < max){
			msg	= '<b>'+comma( len ) + '</b>/' + comma( max );
		}else{
			$(obj).val( $(obj).val().substring(0,max) );
			msg	= '<b>'+comma( max ) + '</b>/' + comma( max );
		}
		mobj.html( msg );
		if( len >= max ) mobj.find("b").addClass('red');
	}
</script>

<form name="selladminLoginForm" method="post" action="../../selleradmin/login_process/login" target="_blank">
	<input type="hidden" name="provider_seq" value="<?php echo $TPL_VAR["provider_seq"]?>"/>
	<input type="hidden" name="superadmin_login" value="1" />
	<input type="hidden" name="out_login" value="1" />
	<input type="hidden" name="main_id" value="<?php echo $TPL_VAR["provider_id"]?>" />
	<input type="hidden" name="main_pwd" value="-" />
</form>

<?php if($TPL_VAR["provider_seq"]){?>
<form name="settingForm" method="post" enctype="multipart/form-data" action="../provider_process/provider_modify" target="actionFrame">
<input type="hidden" name="provider_seq" value="<?php echo $TPL_VAR["provider_seq"]?>"/>
<?php }else{?>
<form name="settingForm" method="post" enctype="multipart/form-data" action="../provider_process/provider_reg" target="actionFrame">
<?php }?>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
<?php if($TPL_VAR["provider_id"]){?>
			<h2>입점사 수정</h2>
			<input type="hidden" name="provider_status_old" value="<?php echo $TPL_VAR["provider_status"]?>">
<?php }else{?>
			<h2>입점사 등록</h2>
			<input type="hidden" name="provider_status" value="N">
<?php }?>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><button type="button" onclick="document.location.href='catalog';" class="resp_btn v3 size_L">리스트 바로가기</button></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
<?php if($TPL_VAR["provider_id"]){?>
			<li><button type="button" onclick="selladmin_login()" class="resp_btn size_L">입점사 로그인</button></li>
<?php }?>
			<li><button type="button" onclick="provider_save();" class="resp_btn active2 size_L">저장</button></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">

<?php if($TPL_VAR["provider_seq"]){?>
	<div class="provider-statistic">	
		<div class="stati_title">
			<b>입점사 통계</b>
			<select name="provider_statistic">
				<option value="">선택</option>
				<option value="order">실매출</option>
				<option value="account">정산금액(예정+확정)</option>
				<option value="charge">수수료</option>
				<option value="mshop">단골미니샵</option>
			</select>
			<span class="head-rbtn hand"><img src="/admin/skin/default/images/common/icon_search_detail_open.png"></span>
		</div>
		<div class="statistics_area hide"></div>
	</div>
<?php }?>

	<div class="item-title">입점사 정보</div>

	
	<table class="table_basic thl">
		<tr>
			<th>입점사명<span class="required_chk"></span></th>
			<td <?php if($TPL_VAR["provider_seq"]){?>colspan="3"<?php }?>>
				<div class="resp_limit_text limitTextEvent">
					<input type="text" name="provider_name" value="<?php echo $TPL_VAR["provider_name"]?>"  size="40" maxlength="20" />
				</div>
			</td>
		</tr>

		<tr>
			<th>입점사 ID<span class="required_chk"></span></th>
			<td <?php if($TPL_VAR["provider_seq"]){?>colspan="3"<?php }?>>
<?php if($TPL_VAR["provider_id"]){?>
				<?php echo $TPL_VAR["provider_id"]?> (입점사 코드: <?php echo $TPL_VAR["provider_seq"]?>)
<?php }else{?>
				<input type="text" name="provider_id" value="<?php echo $TPL_VAR["provider_id"]?>"/>
				<button type="button" id="id_chk" class="resp_btn v2">중복확인</button>
<?php }?>
			</td>
		</tr>

<?php if($TPL_VAR["provider_id"]){?>	
		<tr>
			<th>
				비밀번호<span class="required_chk"></span>
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/manager', '#tip6', 'sizeM')"></span>
			</th>
			<td <?php if($TPL_VAR["provider_seq"]){?>colspan="3"<?php }?>><label class="resp_checkbox"><input type="checkbox" name="passwd_chg" value="Y" /> 변경</label></td>
		</tr>
<?php }?>	

		<tr id="r_pass" <?php if($TPL_VAR["provider_seq"]){?>style="display:none;"<?php }?>>
			<th>
				비밀번호 설정<span class="required_chk"></span>
<?php if(!$TPL_VAR["provider_seq"]){?><span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/manager', '#tip6', 'sizeM')"></span><?php }?>
			</th>
			<td <?php if($TPL_VAR["provider_seq"]){?>colspan="3"<?php }?>>
<?php if($TPL_VAR["provider_seq"]){?>			
				<dl class="change_password dl_list_01 w120">
					<dt>현재 비밀번호</dt>
					<dd><input type="password" name="manager_password" value="" class="line" /></dd>
				</dl>			
<?php }?>					

				<dl class="change_password dl_list_01 w120">
					<dt>비밀번호</dt>
					<dd><input type="password" name="provider_passwd" class="line" /></dd>
				</dl>

				<dl class="change_password dl_list_01 w120">
					<dt>비밀번호 확인</dt>
					<dd><input type="password" name="re_provider_passwd" class="line" /></dd>
				</dl>					
				
				<ul class="bullet_hyphen fx11">
					<li>영문 대소문자 또는 숫자, 특수문자 중 2가지 이상 조합으로 10-20자 미만</li>
					<li>사용 가능 특수문자 # $ % & ( ) * + - / : < = > ? @ [ ＼ ] ^ _ { | } ~</li>
				</ul>
			</td>
		</tr>

<?php if($TPL_VAR["provider_id"]){?>
		<tr>		
			<th>판매 상태 </th>
			<td <?php if($TPL_VAR["provider_seq"]){?>colspan="3"<?php }?>>			
				<select name="provider_status" class="status-isY">
					<option value="Y" class="status-isY">정상 (판매활동가능)</option>
					<option value="N" class="status-isN">종료 (판매활동불가)</option>
				</select>	
<?php if($TPL_VAR["update_date"]){?><span class="gray">(변경일: <?php echo $TPL_VAR["update_date"]?>)</span><?php }?>
			</td>
		</tr>

		<tr>		
			<th>판매 상품</th>
			<td <?php if($TPL_VAR["provider_seq"]){?>colspan="3"<?php }?>>				
				총 <span class="resp_btn_txt" id="goods_set" onclick="goods_set();"><?php echo $TPL_VAR["totalGoodsCount"]?></span>개의 상품			
			</td>
		</tr>
<?php }?>

		<tr>
			<th>판매 등급</th>
			<td <?php if($TPL_VAR["provider_seq"]){?>colspan="3"<?php }?>>
				<select name="pgroup_seq">
<?php if($TPL_pgroup_list_1){foreach($TPL_VAR["pgroup_list"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["pgroup_seq"]?>" <?php if($TPL_VAR["pgroup_seq"]==$TPL_V1["pgroup_seq"]||(!$TPL_VAR["pgroup_seq"]&&$TPL_V1["pgroup_seq"]== 1)){?>selected<?php }?>><?php echo $TPL_V1["pgroup_name"]?></option>
<?php }}?>
				</select>
<?php if($TPL_VAR["pgroup_date"]&&$TPL_VAR["pgroup_date"]!="0000-00-00 00:00:00"){?> <span class="gray">(변경일: <?php echo $TPL_VAR["pgroup_date"]?>)</span> <?php }?>
			</td>
		</tr>
		
		<tr>
			<th>구분</th>
			<td>
				<select class="hide" name="provider_gb">
					<option value="provider" selected>입점(업체)</option>
				</select>
				입점
			</td>
<?php if($TPL_VAR["provider_seq"]){?>
			<th>입점일</th>
			<td><?php echo $TPL_VAR["regdate"]?></td>
<?php }?>
		</tr>		
	</table>

<?php if($TPL_VAR["provider_seq"]){?>
	<div class="item-title">미니샵</div>
	<table class="table_basic thl">		
		<tr>
			<th>미니샵</th>
			<td>
<?php if(!$TPL_VAR["minishop_service_limit"]){?>				
				<button type="button" onclick="window.open('<?php echo $TPL_VAR["mshop_url"]?>');" class="resp_btn">보기</button>					
				<button type="button" id="url_copy" class="resp_btn v2">URL 복사</button>
<?php }?>
			</td>
		</tr>

		<tr>
			<th>미니샵 단골</th>
			<td><a href="../member/catalog?provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&provider_name=<?php echo $TPL_VAR["provider_name"]?>" target="_blank" class="resp_btn_txt v2"><?php echo number_format($TPL_VAR["mshop_cnt"])?>명</a></td>
		</tr>

		<tr>
			<th>미니샵 소개</th>
			<td>
<?php if($TPL_VAR["operation_type"]=='light'){?>
					<div class="resp_limit_text limitTextEvent">
						<input type="text" name="minishop_introdution" value="<?php echo $TPL_VAR["minishop_introdution"]?>" size="70" maxlength="30"/>
					</div>
<?php }else{?>
					<div class="webftpFormItem">									
						<label class="resp_btn v2"><input type="file" id="mainVisualBtn" accept="image/*">파일 선택</label>
						<input type="hidden" class="webftpFormItemInput" name="main_visual" value="<?php echo $TPL_VAR["main_visual"]?>" />									
						<div class="preview_image"></div>
					</div>
<?php }?>
			</td>
		</tr>
<?php if($TPL_VAR["operation_type"]=='light'){?>
		<tr>
			<th>추천 상품</th>
			<td class="clear">
				<ul class="ul_list_02">
					<li>
						<select name="auto_criteria_type" class="auto_criteria_type">
						<option value="AUTO" <?php if($TPL_VAR["auto_criteria_type"]=='AUTO'){?>selected<?php }?>>자동</option>
						<option value="MANUAL" <?php if($TPL_VAR["auto_criteria_type"]=='MANUAL'){?>selected<?php }?> >직접 선정</option>
						<option value="TEXT" <?php if($TPL_VAR["auto_criteria_type"]=='TEXT'){?>selected<?php }?> >입력</option>
						</select>
					</li>
					<li>
<?php $this->print_("condition",$TPL_SCP,1);?>

					</li>
				</ul>
			</td>
		</tr>

		<tr>
			<th>상세 페이지 설정</th>
			<td id="detailPageSettingContainer">
				<button type="button" class="popupOpenBtn resp_btn v2" data-name="detailPageSetting">설정</button>
			</td>
		</tr>

		<tr>
			<th>상품 디스플레이</th>
			<td id="goodInfoStyleContainer">
				<button type="button" class="popupOpenBtn resp_btn v2" data-name="goodInfoStyle">설정</button>				
			</td>
		</tr>
<?php }?>
	</table>
<?php }?>


	<div class="item-title">정산</div>
	
	<table class="table_basic thl">		
		<tr>
			<th>정산 기준 <span class="required_chk"></span></th>
			<td colspan="3">
				<input type="hidden" name="charge" value="<?php echo $TPL_VAR["charge"]?>"/>
				<input type="hidden" name="commission_type" value="<?php echo $TPL_VAR["commission_type"]?>"/>
				<button type="button" id="calcu_set" class="resp_btn v2">설정</button>
				<span id="calcuSetInfo"></span>
			</td>
		</tr>

		<tr>
			<th>배송비 수수료 <span class="required_chk"></span></th>
			<td><input type="text" name="shipping_charge" value="<?php echo $TPL_VAR["shipping_charge"]?>" size="5" /> %</td>
			<th>반품 배송비 수수료 <span class="required_chk"></span></th>
			<td><input type="text" name="return_shipping_charge" value="<?php echo $TPL_VAR["return_shipping_charge"]?>" size="5" /> %</td>
		</tr>

		<tr>
			<th>티켓상품 위약금 수수료 <span class="required_chk"></span></th>
			<td colspan="3"><input type="text" name="coupon_penalty_charge" value="<?php echo $TPL_VAR["coupon_penalty_charge"]?>" size="5" /> %</td>
		</tr>

		<tr>
			<th>정산 주기</th>
			<td>당월: 월 <?php echo $TPL_VAR["accountAllPeriodConfirm"]["nowPeriod"]?>회, 익월: 월 <?php echo $TPL_VAR["accountAllPeriodConfirm"]["nextPeriod"]?>회</td>
			<th>정산 마감</th>
			<td><?php echo $TPL_VAR["accountAllPeriodConfirm"]["nowConfirm"]?>, <?php echo $TPL_VAR["accountAllPeriodConfirm"]["nextConfirm"]?></td>
		</tr>

		<tr>
			<th>입금 계좌 정보</th>
			<td colspan="3" class="clear">
				<table class="table_basic v3 thl">
					<tr>
						<th>은행 / 예금주</th>
						<td>
							<input type="text" name="calcu_bank" value="<?php echo $TPL_VAR["calcu_bank"]?>" size="12"/> 
							/ 
							<input type="text" name="calcu_name" value="<?php echo $TPL_VAR["calcu_name"]?>" size="10"/>
						</td>
					</tr>
					<tr>
						<th>계좌번호</th>
						<td><input type="text" name="calcu_num" value="<?php echo $TPL_VAR["calcu_num"]?>" /></td>
					</tr>
					<tr>
						<th>계좌사본</th>
						<td>						
							<div class="webftpFormItem">									
								<label class="resp_btn v2"><input type="file" id="bankBtn" class="uploadify">파일 선택</label>
								<input type="hidden" class="webftpFormItemInput" name="calcu_file_hidden" value="<?php echo $TPL_VAR["calcu_file"]?>"/>									
								<div class="preview_image"></div>
							</div>
							
							<div class="resp_message v2">- 파일 형식 jpg, jpeg, gif, png</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>		
	</table>
	
	<div class="resp_message">
		- 정산 주기 및 정산 마감은 정산 > <a href="../accountall/accountall_setting" target="_blank" class="resp_btn_txt">정산 마감일 설정</a>에서 변경할 수 있습니다.
	</div>

	<div class="item-title">판매 처리</div>
	
	<table class="table_basic thl">		
		<tr>
			<th>상품 출고 시 운송장번호</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="check_delivery_code" value="N" <?php if($TPL_VAR["check_delivery_code"]=='N'||$TPL_VAR["check_delivery_code"]==''){?>checked<?php }?>> 운송장번호 입력 필수</label>
					<label><input type="radio" name="check_delivery_code" value="Y" <?php if($TPL_VAR["check_delivery_code"]=='Y'){?>checked<?php }?>> 운송장번호 입력 선택</label>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				티켓 사용 확인 코드
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/manager', '#tip5', 'sizeR')"></span>
			</th>
			<td>
				<table id="cerfify_manager" class="table_basic tdc wauto">
					<colgroup>
						<col width="30%" />					
						<col width="30%" />	
						<col width="13%" />	
						<col width="16%" />	
						<col width="11%" />	
					</colgroup>
					<tr>
						<th>매장 정보</th>
						<th>확인 코드</th>
						<th>인증</th>
						<th>SMS 전송 알림</th>
						<th><button type="button" class="btn_plus plusBtn"></button></th>
					</tr>
<?php if($TPL_VAR["certify"]){?>
<?php if($TPL_certify_1){foreach($TPL_VAR["certify"] as $TPL_V1){?>
					<tr class="cloneTr">
						<td>
							<input type="hidden" name="certify_seq[]" value="<?php echo $TPL_V1["seq"]?>" size="10"/>
							<input type="text" name="manager_name[]" value="<?php echo $TPL_V1["manager_name"]?>" size="45" />
						</td>
						<td>
							<input type="hidden" name="certify_code_chk[]" value="ok" />
							<input type="text" name="certify_code[]" value="<?php echo $TPL_V1["certify_code"]?>" size="45" title="6-16 자리 이하 영문 또는 숫자" />
						</td>
						<td><button type="button" class="certify_btn resp_btn v2">인증</button></td>
						<td><button type="button" class="manager_sms_send resp_btn">SMS 전송</button></td>
						<td><button type="button" onClick="trDel(this)" class="btn_minus"></button></td>
					</tr>					
<?php }}?>
<?php }else{?>
					<tr class="cloneTr">
						<td>
							<input type="hidden" name="certify_seq[]" value="" size="10"/>
							<input type="text" name="manager_name[]" value="" size="45"/>
						</td>
						<td>
							<input type="hidden" name="certify_code_chk[]" value="" />
							<input type="text" name="certify_code[]" value="" size="45"" title="6-16 자리 이하 영문 또는 숫자" />
						</td>
						<td><button type="button" class="certify_btn resp_btn v2">인증</button></td>
						<td><button type="button" class="manager_sms_send resp_btn">SMS 전송</button></td>
						<td><button type="button" onClick="trDel(this)" class="btn_minus"></button></td>						
					</tr>
<?php }?>
				</table>
				
			</td>			
		</tr>		
	</table>

	<div class="item-title">
		메뉴 상단 건수 표시
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/manager', '#tip2')"></span>
	</div>
	
	<table class="table_basic thl">		
		<tr>
			<th>
				주문
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/manager', '#tip3', 'sizeR')"></span>
			</th>
			<td>				
				최근
<?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'){?>
				<select name="noti_count_priod_order">
					<option value="1주일" <?php if($TPL_VAR["noti_acount_priod"]["order"]=='1주일'){?>selected<?php }?>>1주일</option>
					<option value="2주일" <?php if($TPL_VAR["noti_acount_priod"]["order"]=='2주일'){?>selected<?php }?>>2주일</option>
					<option value="1개월" <?php if($TPL_VAR["noti_acount_priod"]["order"]=='1개월'){?>selected<?php }?>>1개월</option>
					<option value="3개월" <?php if($TPL_VAR["noti_acount_priod"]["order"]=='3개월'){?>selected<?php }?>>3개월</option>
					<option value="6개월" <?php if($TPL_VAR["noti_acount_priod"]["order"]=='6개월'){?>selected<?php }?>>6개월</option>
				</select>				
<?php }else{?>
				<?php echo $TPL_VAR["noti_acount_priod"]["order"]?>

<?php }?>				
				동안 처리해야 할 주문 건수 표시
			</td>
		</tr>

		<tr>
			<th>게시판</th>
			<td>
				최근
<?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'){?>
				<select name="noti_count_priod_board" <?php if($TPL_VAR["is_provider_solution"]){?>colspan="3"<?php }?>>
					<option value="1주일" <?php if($TPL_VAR["noti_acount_priod"]["board"]=='1주일'){?>selected<?php }?>>1주일</option>
					<option value="2주일" <?php if($TPL_VAR["noti_acount_priod"]["board"]=='2주일'){?>selected<?php }?>>2주일</option>
					<option value="1개월" <?php if($TPL_VAR["noti_acount_priod"]["board"]=='1개월'){?>selected<?php }?>>1개월</option>
					<option value="3개월" <?php if($TPL_VAR["noti_acount_priod"]["board"]=='3개월'){?>selected<?php }?>>3개월</option>
					<option value="6개월" <?php if($TPL_VAR["noti_acount_priod"]["board"]=='6개월'){?>selected<?php }?>>6개월</option>
				</select>
<?php }else{?>
				<?php echo $TPL_VAR["noti_acount_priod"]["board"]?>

<?php }?>
				동안 답변이 미 완료된 상품 문의
				</div>
			</td>			
		</tr>	
<?php if($TPL_VAR["is_provider_solution"]){?>
		<tr>
			<th>정산</th>
			<td>
				최근
<?php if($TPL_VAR["managerInfo"]["manager_yn"]=='Y'){?>
				<select name="noti_count_priod_account">
					<option value="1주일" <?php if($TPL_VAR["noti_acount_priod"]["account"]=='1주일'){?>selected<?php }?>>1주일</option>
					<option value="2주일" <?php if($TPL_VAR["noti_acount_priod"]["account"]=='2주일'){?>selected<?php }?>>2주일</option>
					<option value="1개월" <?php if($TPL_VAR["noti_acount_priod"]["account"]=='1개월'){?>selected<?php }?>>1개월</option>
					<option value="3개월" <?php if($TPL_VAR["noti_acount_priod"]["account"]=='3개월'){?>selected<?php }?>>3개월</option>
					<option value="6개월" <?php if($TPL_VAR["noti_acount_priod"]["account"]=='6개월'){?>selected<?php }?>>6개월</option>
				</select>
<?php }else{?>
				<?php echo $TPL_VAR["noti_acount_priod"]["account"]?>

<?php }?>
				동안 정산 건 중 미 완료건
			</td>			
		</tr>
<?php }?>
	</table>
	
	<div class="item-title">판매자</div>

	<table class="table_basic thl">		
		<tr>
			<th>상호(회사명)</th>
			<td><input type="text" name="info_name" value="<?php echo $TPL_VAR["info_name"]?>"/></td>
			<th>대표자 이름</th>
			<td><input type="text" name="info_ceo" value="<?php echo $TPL_VAR["info_ceo"]?>"/></td>
		</tr>

		<tr>
			<th>사업자 번호</th>
			<td><input type="text" name="info_num" value="<?php echo $TPL_VAR["info_num"]?>"/></td>
			<th>주민/법인(법인등록번호)</th>
			<td>
				<div class="resp_radio">				
					<label><input type="radio" name="info_type" value="개인" <?php if($TPL_VAR["info_type"]=='개인'||$TPL_VAR["info_type"]==''){?>checked<?php }?>> 개인</label>
					<label><input type="radio" name="info_type" value="법인" <?php if($TPL_VAR["info_type"]=='법인'){?>checked<?php }?>> 법인</label>
				</div>
				<input type="text" name="info_type_num" value="<?php echo $TPL_VAR["info_type_num"]?>" class="ml15" /></td>
			</td>
		</tr>

		<tr>
			<th>업태/종목</th>
			<td><input type="text" name="info_item" value="<?php echo $TPL_VAR["info_item"]?>" class="line" size="10"/> / <input type="text" name="info_status" value="<?php echo $TPL_VAR["info_status"]?>" size="10"/></td>
			<th>통신 판매 신고번호</th>
			<td><input type="text" name="info_selling_license" value="<?php echo $TPL_VAR["info_selling_license"]?>"/></td>
		</tr>

		<tr>
			<th>사업자 등록증 사본</th>
			<td colspan="3">		
				<div class="webftpFormItem">									
					<label class="resp_btn v2"><input type="file" id="busiBtn" class="uploadify">파일선택</label>
					<input type="hidden" class="webftpFormItemInput" name="info_file_hidden" value="<?php echo $TPL_VAR["info_file"]?>"/>									
					<div class="preview_image"></div>
				</div>
			</td>
		</tr>	

		<tr>
			<th>사업장 주소</th>
			<td colspan="3" class="clear">
				<input type="hidden" name="info_address_type" value="<?php echo $TPL_VAR["info_address1_type"]?>" />

				<table class="table_basic thl v3">					
					<tr>
						<th>우편번호</th>
						<td>
							<input type="text" name="info_zipcode[]" value="<?php echo $TPL_VAR["info_zipcode"]?>" size="5" class="line" />
							<input type="button" id="infoZipcodeButton" value="우편번호" class="resp_btn v2"/>
						</td>
					</tr>
					<tr>
						<th>지번</th>
						<td><input type="text" name="info_address" value="<?php echo $TPL_VAR["info_address1"]?>" size="80" /></td>
					</tr>
					<tr>
						<th>도로명</th>
						<td><input type="text" name="info_address_street" value="<?php echo $TPL_VAR["info_address1_street"]?>" size="80"/></td>
					</tr>
					<tr>
						<th>상세 주소</th>
						<td><input type="text" name="info_address2" value="<?php echo $TPL_VAR["info_address2"]?>" size="80"/></td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			<th>전화</th>
			<td><input type="text" name="info_phone" value="<?php echo $TPL_VAR["info_phone"]?>"/></td>
			<th>메일</th>
			<td><input type="text" name="info_email" value="<?php echo $TPL_VAR["info_email"]?>"/></td>
		</tr>
		
		<tr>
			<th>팩스</th>
			<td colspan="3"><input type="text" name="info_fax" value="<?php echo $TPL_VAR["info_fax"]?>"/></td>
		</tr>
	</table>

	
	<div class="item-title">담당자</div>

	<table class="table_basic">	
		<colgroup>
			<col width="20%" />					
			<col width="20%" />	
			<col width="20%" />	
			<col width="20%" />
			<col width="20%" />
		</colgroup>
		<tr>
			<th>구분</th>
			<th>이름</th>
			<th>이메일</th>
			<th>전화번호</th>
			<th>
				휴대폰 번호
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/provider', '#tip4')"></span>
			</th>
		</tr>
		<tr>
			<th class="left">물류 담당자 (1)</th>
			<td><input type="text" name="ds1_name" value="<?php echo $TPL_VAR["ds1"]["name"]?>" class="wp95"/></td>
			<td><input type="text" name="ds1_email" value="<?php echo $TPL_VAR["ds1"]["email"]?>" class="wp95"/></td>
			<td><input type="text" name="ds1_phone" value="<?php echo $TPL_VAR["ds1"]["phone"]?>" class="wp95"/></td>
			<td><input type="text" name="ds1_mobile" value="<?php echo $TPL_VAR["ds1"]["mobile"]?>" class="wp95"/></td>
		</tr>
		<tr>
			<th class="left">물류 담당자 (2)</th>
			<td><input type="text" name="ds2_name" value="<?php echo $TPL_VAR["ds2"]["name"]?>" class="wp95"/></td>
			<td><input type="text" name="ds2_email" value="<?php echo $TPL_VAR["ds2"]["email"]?>" class="wp95"/></td>
			<td><input type="text" name="ds2_phone" value="<?php echo $TPL_VAR["ds2"]["phone"]?>" class="wp95"/></td>
			<td><input type="text" name="ds2_mobile" value="<?php echo $TPL_VAR["ds2"]["mobile"]?>" class="wp95"/></td>
		</tr>
		<tr>
			<th class="left">CS 담당자</th>
			<td><input type="text" name="cs_name" value="<?php echo $TPL_VAR["cs"]["name"]?>" class="wp95"/></td>
			<td><input type="text" name="cs_email" value="<?php echo $TPL_VAR["cs"]["email"]?>" class="wp95"/></td>
			<td><input type="text" name="cs_phone" value="<?php echo $TPL_VAR["cs"]["phone"]?>" class="wp95"/></td>
			<td>	<input type="text" name="cs_mobile" value="<?php echo $TPL_VAR["cs"]["mobile"]?>" class="wp95"/></td>
		</tr>
		<tr>
			<th class="left">담당 MD</th>
			<td><input type="text" name="md_name" value="<?php echo $TPL_VAR["md"]["name"]?>" class="wp95"/></td>
			<td><input type="text" name="md_email" value="<?php echo $TPL_VAR["md"]["email"]?>" class="wp95"/></td>
			<td><input type="text" name="md_phone" value="<?php echo $TPL_VAR["md"]["phone"]?>" class="wp95"/></td>
			<td><input type="text" name="md_mobile" value="<?php echo $TPL_VAR["md"]["mobile"]?>" class="wp95"/></td>
		</tr>
		<tr>
			<th class="left">정산 담당자</th>
			<td><input type="text" name="calcus_name" value="<?php echo $TPL_VAR["calcu"]["name"]?>" class="wp95"/></td>
			<td><input type="text" name="calcus_email" value="<?php echo $TPL_VAR["calcu"]["email"]?>" class="wp95"/></td>
			<td><input type="text" name="calcus_phone" value="<?php echo $TPL_VAR["calcu"]["phone"]?>" class="wp95"/></td>
			<td><input type="text" name="calcus_mobile" value="<?php echo $TPL_VAR["calcu"]["mobile"]?>" class="wp95"/>	</td>
		</tr>
	</table>

	<div class="item-title">처리 내역</div>

	<table class="table_basic">	
		<colgroup>
			<col width="50%" />					
			<col width="50%" />			
		</colgroup>
		<tr>
			<th>관리 메모 (본사용)</th>
			<th>처리 내역</th>
		</tr>
	
		<tr>
			<td valign="top" align="right" style="border:1px solid #cccccc; background:#f7f7f7">
				<textarea name="admin_memo" style="width:99%; padding:10px 0px; height:120px; border:0px;background-color:transparent"><?php echo $TPL_VAR["admin_memo"]?></textarea>
			</td>
			<td valign="top" align="right" style="border:1px solid #cccccc; background:#f7f7f7">
				<div style="overflow:auto;height:120px;width:98%;border:0;padding: 10px 5px;background:#f7f7f7;text-align:left;"><?php echo $TPL_VAR["provider_log"]?></div>
			</td>
		</tr>	
	</table>
</div>
</form>

<!-- 아이콘 선택 -->
<div id="calcuPopup" style="display:none;">
	<form name="calcuRegist" id="calcuRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">
	<input type="hidden" id="org_charge" value="<?php echo $TPL_VAR["charge"]?>" />
	<input type="hidden" id="org_commission_type" value="<?php echo $TPL_VAR["commission_type"]?>" />

	<div class="item-title">정산 기준</div>

	<table class="table_basic">		
		<tr>
			<th>정산 방식</th>
			<td>				
				<div class="resp_radio">
					<label <?php if($TPL_VAR["commission_type"]){?>class='disabled'<?php }?> ><input type="radio" name="sel_commission_type" value="SACO" <?php if($TPL_VAR["commission_type"]=="SUPPLY"){?>disabled<?php }?>/> 수수료</label>
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/provider', '#tip5', 'sizeM')"></span>
					<label <?php if($TPL_VAR["commission_type"]){?>class='disabled'<?php }?>><input type="radio" name="sel_commission_type" value="SUPPLY" <?php if($TPL_VAR["commission_type"]=="SACO"){?>disabled<?php }?>/> 공급가</label>
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/provider', '#tip6')"></span>
				</div>
			</td>
		</tr>

		<tr>
			<th>수수료율</th>
			<td class="sel_commission_type_SACO hide">				
				<input type="text" class="onlyfloat right" name="brand_charge" value="<?php if($TPL_VAR["charge"]){?><?php echo $TPL_VAR["charge"]?><?php }else{?>0<?php }?>" size="5" /> %
			</td>

			<td class="sel_commission_type_SUPPLY hide">
				<select name="supply_type">
					<option value="SUCO">정가</option>
					<option value="SUPR">직접입력</option>
				</select>
				<input type="text" class="onlyfloat" name="supply_charge" value="<?php if($TPL_VAR["charge"]){?><?php echo $TPL_VAR["charge"]?><?php }else{?>0<?php }?>" size="6" class="line" style="text-align:right"/> <span class="supply_unit">%</span>
			</td>
		</tr>
	</table>
	
	<div class="box_style_05 mt15">
		<div class="title">안내</div>
		<ul class="bullet_hyphen">							
			<li class="red">정산 방식은 최초 등록 후 변경이 불가하오니 유의하시기 바랍니다.</li>
			<li>해당 입점사 신규 판매상품은 설정된 기본값이 기본으로 입력되며 통신판매중계자(본사)만이 상품의 옵션별로 수수료율 또는 정산 금액을 조정할 수 있습니다.</li>
			<li>정산 대상 기준: 배송-구매 확정된 출고 건, 환불-환불 완료된 주문 건</li>
		</ul>
	</div>

	<div class="footer">
		<div class="mb20"><label class="resp_checkbox"><input type="checkbox" id="commission_type_comfirm_chk"/> 정산 기준에 동의합니다.</label></div>
		<input type="button" value="저장" id="calcu_select" class="resp_btn active size_XL"></button>
		<input type="button" value="취소" id="calcu_pop_close" class="resp_btn v3 size_XL"></button>
	</div>
	</form>
</div>

<div id="shippingModifyPopup" style="display:none"></div>

<div id="bankPopup" style="display:none;">
	<form name="iconRegist" id="iconRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">
	<input type="file" name="calcu_file" id="calcu_file" class="line"/>
	<div style="padding:10px;" class="center">
		<span class="btn large black"><input type="button" value="저장하기" onclick="calcuFileUpload();"/></button></span>
	</div>
	</form>
</div>

<div id="busiPopup" style="display:none;">
	<form name="iconRegist2" id="iconRegist2" method="post" action="" enctype="multipart/form-data"  target="actionFrame">
	<input type="file" name="busi_file" id="busi_file" class="line"/>
	<div style="padding:10px;" class="center">
	<span class="btn large black"><input type="button" value="저장하기" onclick="busiFileUpload();"/></button></span>
	</div>
	</form>
</div>
<div id="goodsPopup" style="display:none;">
	<table width="100%"class="info-table-style">
		<col width="33%">
		<col width="33%">
		<col width="33%">
		<tr>
			<th class="its-th-align">일반</th>
			<th class="its-th-align">티켓</th>
			<th class="its-th-align">패키지/복합</th>
		</tr>
		<tr>
			<td class="its-td-align center"><a href="/admin/goods/catalog?provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&provider_name
			=<?php echo $TPL_VAR["provider_name"]?>%28<?php echo $TPL_VAR["provider_id"]?>%29" class="blue" target="_blank"><?php echo $TPL_VAR["goodsCount"]["goods_default"]?> </a>개</td>
			<td class="its-td-align center"><a href="/admin/goods/social_catalog?provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&provider_name
			=<?php echo $TPL_VAR["provider_name"]?>%28<?php echo $TPL_VAR["provider_id"]?>%29" class="blue" target="_blank"><?php echo $TPL_VAR["goodsCount"]["goods_social"]?> </a>개</td>
			<td class="its-td-align center"><a href="/admin/goods/package_catalog?provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&provider_name
			=<?php echo $TPL_VAR["provider_name"]?>%28<?php echo $TPL_VAR["provider_id"]?>%29" class="blue" target="_blank"><?php echo $TPL_VAR["goodsCount"]["goods_package"]?> </a>개</td>
		</tr>
	</table>
</div>
<div id="sendPopup" class="hide"></div>
<div id="admin_policy_info" class="hide">
	개인정보의 기술적, 관리적 보호조치 기준에 의거(「정보통신망 이용촉진 및 정보보호 등에 관한 법률」(이하 “법”이라 한다) <br>
	제28조제1항 및 같은 법 시행령 제15조제6항)에 따른 방통위 고시 제2012-50호<br>
	<br>
	다음 각 목의 문자 종류 중 2종류 이상을 조합하여 최소 10자리 이상 또는 3종류 이상을 조합하여 최소 8자리 이상의 길이로 구성<br>
	가. 영문 대문자(26개)<br>
	나. 영문 소문자(26개)<br>
	다. 숫자(10개)<br>
	라. 특수문자(32개)<br>
	<br>
	<hr>
	<br>
	상기 정보통신망 이용촉진 및 정보보호 등에 관한 법률에 따른 방통위 시행령에 따라 <br>
	개인정보 보호 책임자의 비밀번호는 10자 이상의 영문 대소문자 또는 숫자, 특수문자 중 <br>
	2가지 이상을 조합해서 만들어야 하며 주기적(90일)으로 변경을 하셔야 합니다.
	<br><br>
	<div class="center">
		<span class="btn large black"><button type="button" onclick="closeDialog('admin_policy_info');">확인</button></span>
	</div>
</div>

<div id="detailPageSetting" class="hide">
	<table class="table_basic thl">
		<tr>
			<th>검색 필터</th>
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="minishop_search_filter[]" value="category" <?php if(in_array('category',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 카테고리</label>
					<label><input type="checkbox" name="minishop_search_filter[]" value="brand" <?php if(in_array('brand',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 브랜드</label>
					<label><input type="checkbox" name="minishop_search_filter[]" value="freeship" <?php if(in_array('freeship',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 무료배송</label>
					<label><input type="checkbox" name="minishop_search_filter[]" value="abroadship" <?php if(in_array('abroadship',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 해외배송</label>
					<label><input type="checkbox" name="minishop_search_filter[]" value="price" <?php if(in_array('price',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 가격</label>
					<label><input type="checkbox" name="minishop_search_filter[]" value="rekeyword" <?php if(in_array('rekeyword',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 재검색어</label>
					<label><input type="checkbox" name="minishop_search_filter[]" value="color" <?php if(in_array('color',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 색상</label>
				</div>
			</td>
		</tr>

		<tr>
			<th>상품 정렬</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="minishop_orderby" value="rank" <?php if($TPL_VAR["minishop_orderby"]=='rank'){?>checked<?php }?>/> 랭킹순</label>
					<label><input type="radio" name="minishop_orderby" value="new" <?php if($TPL_VAR["minishop_orderby"]=='new'){?>checked<?php }?>/> 신규등록순</label>
					<label><input type="radio" name="minishop_orderby" value="low" <?php if($TPL_VAR["minishop_orderby"]=='low'){?>checked<?php }?>/> 낮은가격순</label>
					<label><input type="radio" name="minishop_orderby" value="high" <?php if($TPL_VAR["minishop_orderby"]=='high'){?>checked<?php }?>/> 높은가격순</label>
					<label><input type="radio" name="minishop_orderby" value="review" <?php if($TPL_VAR["minishop_orderby"]=='review'){?>checked<?php }?>/> 상품평많은순</label>
					<label><input type="radio" name="minishop_orderby" value="sales" <?php if($TPL_VAR["minishop_orderby"]=='sales'){?>checked<?php }?>/> 판매량순</label>
				</div>
			</td>
		</tr>

		<tr>
			<th>노출할 상품의 상태</th>
			<td>
				<div class="resp_checkbox">
					<label><input type="checkbox" name="" value="runout" checked disabled/> 정상</label>
<?php if(preg_match('/runout/',$TPL_VAR["minishop_status"])){?>
					<label><input type="checkbox" name="minishop_status[]" value="runout" checked/> 품절</label>
<?php }else{?>
					<label><input type="checkbox" name="minishop_status[]" value="runout" /> 품절</label>
<?php }?>
<?php if(preg_match('/purchasing/',$TPL_VAR["minishop_status"])){?>
					<label><input type="checkbox" name="minishop_status[]" value="purchasing" checked/> 재고확보중</label>
<?php }else{?>
					<label><input type="checkbox" name="minishop_status[]" value="purchasing" /> 재고확보중</label>
<?php }?>
<?php if(preg_match('/unsold/',$TPL_VAR["minishop_status"])){?>
					<label><input type="checkbox" name="minishop_status[]" value="unsold" checked/> 판매중지</label>
<?php }else{?>
					<label><input type="checkbox" name="minishop_status[]" value="unsold" /> 판매중지</label>
<?php }?>
				</div>
			</td>
		</tr>

		<tr>
			<th>상품 이미지 사이즈</th>
			<td>
				<select name="minishop_goods_info_image">
<?php if(is_array($TPL_R1=config_load('goodsImageSize'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_VAR["minishop_goods_info_image"]==$TPL_K1){?>
					<option value="<?php echo $TPL_K1?>" selected><?php echo $TPL_V1["name"]?></option>
<?php }else{?>
					<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["name"]?></option>
<?php }?>
<?php }}?>
				</select>
			</td>
		</tr>	
	</table>

	<div class="footer">
		<button type="button" class="resp_btn active size_XL confirmPopupInfoBtn">확인</button>
		<button type="button" class="btnLayClose resp_btn v3 size_XL">취소</button>
	</div>
</div>

<div id="goodInfoStyle" class="hide" >
	<div class="item-title">상품 디스플레이</div>	
<?php $this->print_("goods_info_style",$TPL_SCP,1);?>

	<div class="resp_message">- 상품 노출 조건 <a href="https://www.firstmall.kr/customer/faq/1358" target="_blank" class="resp_btn_txt">자세히 보기</a></div>
	<div class="footer">
		<button type="button" class="confirmPopupInfoBtn resp_btn active size_XL">확인</button>
		<button type="button" class="btnLayClose resp_btn v3 size_XL">취소</button>
	</div>
</div>

<div id="lay_goods_select"></div><!-- 상품선택 레이어 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>