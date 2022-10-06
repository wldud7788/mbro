<?php /* Template_ 2.2.6 2022/05/17 12:36:56 /www/music_brother_firstmall_kr/admin/skin/default/setting/delivery_company.html 000058851 */ 
$TPL_selectedCompany_1=empty($TPL_VAR["selectedCompany"])||!is_array($TPL_VAR["selectedCompany"])?0:count($TPL_VAR["selectedCompany"]);
$TPL_deliveryCompany_1=empty($TPL_VAR["deliveryCompany"])||!is_array($TPL_VAR["deliveryCompany"])?0:count($TPL_VAR["deliveryCompany"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<style type="text/css">.ep_box { border:0px !important; }</style>
<script type="text/javascript">
	$(document).ready(function() {

		// 우체국택배 업무자동화 서비스 :: 2016-03-29 lwh
		$("#epostSetting").bind('click', function(){
			var epost_step = "<?php echo $TPL_VAR["config_epost"]["status"]?>";
			if(epost_step == '0' || epost_step == '1' || epost_step == '9'){
				DLstat_controller('ep_','ing',true);
				$(".chk_duple").closest('td').find('.btn').hide();
				$(".personInfo").hide();
			}else{
				DLstat_controller('ep_','open',true);
			}

			openDialog("택배 업무 자동화 연동 - 우체국택배", "epostSettingPopup", {"width":900, "height":700});

			setDefaultText();
		});

		// 우체국택배 중복체크 :: 2016-03-29 lwh
		$(".chk_duple").bind('click', function(){
			var that	= $(this);
			var chk_type= $(that).attr('chk_type');
			var obj		= $("input[name='"+chk_type+"']");
			var chk_val	= '';

			// 체크문자 조합
			if(chk_type == 'epost_num')
				chk_val = obj.val();
			else
				chk_val = (obj.eq(0).val() && obj.eq(1).val()) ? obj.eq(0).val() + '-' + obj.eq(1).val() : '';

			if(!chk_val || chk_val == ''){
				alert('중복 체크할 값을 먼저 입력해주세요.');
				obj.eq(0).focus();
				return false;
			}

			// 체크문자 검사
			var pattern = /^[0-9]*$/; //패턴검사 정규식
			if(obj.eq(0).val() && !pattern.test(obj.eq(0).val())){
				alert('숫자만 입력 가능합니다.');
				obj.eq(0).focus();
				return false;
			}
			if(obj.eq(1).val() && !pattern.test(obj.eq(1).val())){
				alert('숫자만 입력 가능합니다.');
				obj.eq(1).focus();
				return false;
			}

			// 고객번호 자릿수 검사
			if(chk_type == 'epost_num' && chk_val.length != 10){
				alert('우체국 고객번호는 10자 입니다.');
				obj.focus();
				return false;
			}

			// 우체국 승인번호 자릿수 검사
			if(chk_type == 'epost_auth_code[]' && chk_val.length != 11){
				alert('우체국 고객번호는 10자 입니다.');
				obj.eq(0).focus();
				return false;
			}

			// 중복체크 실행
			$.ajax({
				'url' : '../setting_process/epost_duple_chk',
				'type' : 'post',
				'data' : {'chk_type':chk_type, 'chk_val':chk_val},
				'dataType' : 'json',
				'success' : function(respons){
					if(respons.result){
						openDialogAlert('사용가능합니다.',400,155);
						$(that).closest('td').find('.btn').hide();
						$(that).closest('td').find('.duple_txt').show();
						$(that).closest('td').find('.duple_chk_use').val('Y');
					}else{
						openDialogAlert(respons.msg,400,180);
					}
				}
			});
		});

		// 우체국 택배 중복확인 무결성 체크 :: 2016-03-30 lwh
		$(".duple_input").bind('keyup', function(){
			$(this).closest('td').find('.btn').show();
			$(this).closest('td').find('.duple_txt').hide();
			$(this).closest('td').find('.duple_chk_use').val('');
		});

		// 우체국 택배 사용여부 저장 :: 2016-03-31 lwh
		$("#set_epostuse").bind('click', function(){
			var requestkey		= $("input[name='requestkey']").val();
			var epost_notuse	= $("input[name='epost_notuse']:checked").val();
		
			$.ajax({
				'url' : '../setting_process/epost_use_save',
				'type' : 'post',
				'data' : {'requestkey':requestkey, 'epost_notuse':epost_notuse},
				'dataType' : 'json',
				'success' : function(respons){
					if(respons){
						openDialogAlert(respons.msg,400,150);
					}
				}
			});
		});

		// 우체국 택배 신청취소 :: 2016-03-31 lwh
		$("#epost_cancel").bind('click', function(){
			$.ajax({
				'url' : '../setting_process/epost_cancel',
				'type' : 'post',
				'data' : {'requestkey' : "<?php echo $TPL_VAR["config_epost"]["requestkey"]?>", 'status' : "<?php echo $TPL_VAR["config_epost"]["status"]?>"},
				'dataType' : 'json',
				'success' : function(respons){
					if(respons.result){
						openDialogAlert(respons.msg,400,140,function(){location.reload();});
					}else{
						openDialogAlert(respons.msg,400,160);
					}
				}
			});
		});

		// 롯데택배 업무자동화 서비스
		$("#invoiceSetting").bind('click', function(){
			openDialog("택배 업무 자동화 연동 - 롯데택배", "invoiceSettingPopup", {"width":900, "height":600});

			setDefaultText();
		});

		// 굿스플로 업무자동화 서비스 :: 2015-06-11 lwh
		$("#goodsflowSetting").bind('click', function(){
			// 연동 신청중일 경우 데이터 수정 변경 금지 :: 2015-06-22 lwh
			var goodsflow_step = "<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']?>";
			if(goodsflow_step == '1'){
				DLstat_controller('gf_','complete',true);
			}else if(goodsflow_step == '2'){
				DLstat_controller('gf_','ing',true);
			}else{
				DLstat_controller('gf_','open',true);
			}

			openDialog("택배 업무 자동화 연동 - 굿스플로", "goodsflowSettingPopup", {"width":900, "height":650});

			setDefaultText();
		});

		// 굿스플로 신청취소 :: 2015-06-22 lwh
		$("#goodsflow_cancel").bind('click', function(){
			$.ajax({
				'url' : '../setting_process/goodsflow_cancel',
				'type' : 'post',
				'data' : {'requestKey' : "<?php echo $TPL_VAR["config_goodsflow"]["setting"]['requestKey']?>", 'provider_seq' : "<?php echo $TPL_VAR["provider_seq"]?>"},
				'dataType' : 'json',
				'success' : function(respons){
					if(respons.result){
						openDialogAlert('서비스 신청이 취소되었습니다.',400,140,function(){location.reload();});
					}else{
						openDialogAlert(respons.msg,400,140);
					}
				}
			});
		});

		// 굿스플로 정보수정 시 수정 불가 목록 해제 :: 2015-06-25
		$("form[name=goodsflowSettingForm]").submit(function(){
			DLstat_controller('gf_','ing',false);
			var goodsflow_use = $("input[name=goodsflow_notuse]:checked").length;
			var submit_flag = true;
			if(!goodsflow_use){
				var boxArr = $("select[name='boxSize[]']");
				$.each(boxArr, function(key, val){
					shFare_obj	= $("input[name='shFare[]']").eq(key);
					scFare_obj	= $("input[name='scFare[]']").eq(key);
					bhFare_obj	= $("input[name='bhFare[]']").eq(key);
					rtFare_obj	= $("input[name='rtFare[]']").eq(key);

					if(!shFare_obj.val() || !scFare_obj.val() || !bhFare_obj.val() || !rtFare_obj.val()){
						openDialogAlert('박스타입의 모든값은 필수입니다.',400,140);
						submit_flag = false;
					}
				});
			}

			return submit_flag;
		});

		// 굿스플로 충전 서비스 :: 2015-06-25 lwh
		$("#gf_charge").bind('click', function(){
			$.get('goodsflow_payment', function(data) {
				$('#goodsflow_payment').html(data);
				openDialog("굿스플로 서비스 충전 <span class='desc'>&nbsp;</span>", "goodsflow_payment", {"width":"700","height":"630"});
			});
		});

		// 굿스플로 사용현황 :: 2015-06-25 lwh
		$("#gf_log").bind('click', function(){
			openDialog("굿스플로 사용현황 <span class='desc'>&nbsp;</span>", "goodsflow_log_area", {"width":"1000","height":"700"});
		});

		// 자동화서비스 안내 차이점 :: 2015-06-12 lwh
		$("#infoDesc").bind('click', function(){
			openDialog("자동화 서비스 차이점 안내", "desc_popup_area", {"width":900});
		});

		// 요금정보 추가 :: 2015-06-12 lwh
		$(".add_price").bind('click', function(){
			var clone = $(this).closest('tr').find("td:eq(0)").clone();
			$("#goodsflow_form .price_list").append("<tr><td>"+clone.html()+"</td><td class='center'><input type='button' class='del_price btn_minus'/></td></tr>");
		});

		// 요금정보 삭제 :: 2015-06-12 lwh
		$(".del_price").live('click', function(){
			$(this).closest('tr').remove();
		});

		// 입점사 이용 설정 :: 2015-07-17 lwh
		$("#set_gf_use").bind('click', function(){
			var gf_use = 'N';
			var provider_seq = '<?php echo $_GET["provider_seq"]?>';
			if($("input[name='gf_use']:checked").val() == 'Y'){
				gf_use = $("input[name='gf_use']:checked").val();
			}		
			$.ajax({
				'url' : '../setting_process/goodsflow_provider_set',
				'type' : 'post',
				'data' : {'gf_use' : gf_use, 'provider_seq' : provider_seq},
				'dataType' : 'json',
				'success' : function(respons){
					if(respons.res == 'Y'){
						openDialogAlert('수정되었습니다.',400,140,function(){location.reload();});
					}else{
						openDialogAlert('수정에 실패하였습니다.',400,140,function(){location.reload();});
					}
				}
			});
		});

		// 굿스플로 입점사 이용설정 :: 2015-07-17 lwh
		$("#goodsflow_use_setting").bind('click', function(){
			openDialog("입점사 이용 여부", "goodsflow_use_area", {"width":600,"close":function(){
				$("input[name=goodsflow_use]:input[value='<?php echo $TPL_VAR["config_system"]["goodsflow_use"]?>']").prop("checked", true);
			}});
		});

		// 굿스플로 입점사 이용설정 저장 :: 2015-07-17 lwh
		$("#gf_setting_save").bind('click', function(){
			var data = {};
			var goodsflow_use	= $("input[name=goodsflow_use]:checked").val();
			data.goodsflow_use = goodsflow_use;
			var providerJson = $("#goodsflowProviderJson").val();
			if(typeof providerJson === 'string') {
			  data.provider_json = providerJson;
			}
			
			$.ajax({
				'url' : '../setting_process/goodsflow_use_save',
				'type' : 'post',
				'data' : data,
				'dataType' : 'json',
				'success' : function(result){
					if(result.res=='success'){
						openDialogAlert(result.msg,400,140,function(){location.reload();});
					}else{
						openDialogAlert(result.msg,400,140);
					}
				}
			});
		});

		$("input[name='invoice_notuse']").change(function(){
			if($(this).val() == "1"){
				$("#invoiceSettingAuthContainer *").attr("disabled",true);
				$("#invoiceSettingAuthContainer span.btn").addClass("gray");
				$("#invoiceSettingAuthContainer input.invoice_auth_code").val('');
			}else{
				$("#invoiceSettingAuthContainer *").removeAttr("disabled");
				$("#invoiceSettingAuthContainer span.btn").removeClass("gray");
			}
		}).change();


		$("form[name='invoiceSettingForm']").submit(function(){

			var returnValue = true;

			if($("input[name='invoice_notuse'][value='0']")){
				$("input.invoice_auth_code").each(function(){
					var that = this;
					if($(this).val()!='' && $(this).val()!=$(this).attr("auth_code")) {
						openDialogAlert("인증버튼을 클릭하여 인증을 완료해 주시기바랍니다.",400,140,function(){
							$(that).focus();
						});
						returnValue = false;
					}
				});
			}		

			return returnValue;
		});

		$("input.invoice_auth_code").bind('keyup change',function(){
			if($(this).val()!='' && $(this).val()==$(this).attr("auth_code")) {
				$(this).closest('div').children(".invoice_auth_code_desc").html("<span class='fx11 blue'>인증완료</span>");
			}else{
				$(this).closest('div').children(".invoice_auth_code_desc").html("");
			}
		}).change();

		$("#modifyShippingAdress").live("click",function(){
			openDialog("보내는 곳 주소 및 반송 주소", "modifyShippingAdressPopup", {"width":800});
			setDefaultText();
		});

		$("#senderZipcodeButton").live("click",function(){
			openDialogZipcode('sender');
		});
		$("#returnZipcodeButton").live("click",function(){
			openDialogZipcode('return');
		});
		// 굿스플로 우편번호 검색 :: 2015-07-07 lwh
		$("#goodsflowZipcodeButton").live("click",function(){
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']!='2'){?>
			openDialogZipcode('goodsflow');
<?php }?>
		});

		// 굿스플로 택배사 명 default 처리 :: 2015-07-09 lwh
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']!='1'){?>
		$("#deliveryName").val($("#deliveryCode option:selected").text());
<?php }?>

		// 항목 위로 이동
		$('#upMove').click(function() {
			fnselectMove('up');
		});

		// 항목 아래로 이동
		$('#downMove').click(function() {
			fnselectMove('down');
		});

		// 박스타입 기본 값지정 :: 2017-11-29 lwh
		set_terms();
	});

	// 우체국, 굿스플로 연동설정창 컨트롤 :: 2015-06-22 -> 2016-03-28 lwh
	function DLstat_controller(mode,step,flag){
		var className = mode+step;
		$("."+className).attr("disabled", flag);
	}

	// 굿스플로 택배사 선택 시 굿스플로 박스타입 지정 :: 2017-11-29 lwh
	function set_terms(){
		$("select[name='boxSize[]'] > option").remove();
		var delivery		= $("#deliveryCode").val();
		if(typeof delivery !== 'undefined' && delivery !== "") {
			var json_terms		= JSON.parse('<?php echo json_encode($TPL_VAR["config_goodsflow"]["terms"])?>');
			var box_type		= json_terms[delivery]['boxtype'];
			var box_name		= json_terms[delivery]['boxname'];
			$("#deliveryName").val($("#deliveryCode option:selected").text());
			$.each(box_type, function(idx, item){
				$("select[name='boxSize[]']").append("<option value='"+item+"'> "+box_name[idx]+" </option>");
			});
		}
		
<?php if(is_array($TPL_R1=$TPL_VAR["config_goodsflow"]["setting"]['boxSize'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
		var boxSize = "<?php echo $TPL_VAR["config_goodsflow"]["setting"]['boxSize'][$TPL_K1]?>";
		$("select[name='boxSize[]']").eq('<?php echo $TPL_K1?>').val(boxSize);
<?php }}?>
	}

	function hlc_auth(){
		var auth_code = $("input[name='auth_code[hlc]']").val();
		$.ajax({
			'url' : '../setting_process/hlc_auth',
			'type' : 'post',
			'data' : {'auth_code' : auth_code},
			'dataType' : 'json',
			'success' : function(result){
				if(result.code=='success'){
					$("input[name='auth_code[hlc]']").attr('auth_code',auth_code).change();
					openDialogAlert(result.msg,400,140);
				}else{
					openDialogAlert(result.msg,400,140,function(){
						$("input[name='auth_code[hlc]']").focus();
					});
				}
			}
		});
	}

	// 택배사 선택 팝업 열기
	function set_delivery_company(){
<?php if($TPL_VAR["service_limit"]=='Y'){?>
		openDialogAlert('권한이 없습니다.',400,150,'parent');
<?php }else{?>
		openDialog('택배사', 'delivery_set_lay', {'width':'550','height':'580'});
<?php }?>
	}

	// 택배사 선택 처리
	function select_company(){
		$("select[name='org_delivery_company[]'] option:selected").each(function(){
			$("select[name='selected_delivery_company[]']").append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
			$(this).remove();
		});
	}

	// 택배사 선택 해제 처리
	function remove_company(){
		$("select[name='selected_delivery_company[]'] option:selected").each(function(){
			$("select[name='org_delivery_company[]']").append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
			$(this).remove();
		});
	}

	// 선택된 택배사 저장
	function save_delivery_company(){
		$("select[name='selected_delivery_company[]'] option").attr('selected', true);
		$('form#selectedDeliveryCompany').submit();
	}

	function Menulist_isSelected(oMenu, idx) {
		return (oMenu.options[idx].selected==true);
	}

	function Menulist_downMenu(oMenu, index) {
		if (index < 0) return;
		if (index == oMenu.length-1) {
			return; // 더 이상 아래로 이동할 수 없을때
		}
		Menulist_moveMenu(oMenu, index, 1);
	}

	function Menulist_upMenu(oMenu, index) {
		if (index < 0) return;
		if (index == 0) {
			return; // 더 이상 위로 이동할 수 없을때
		}
		Menulist_downMenu(oMenu, index-1);
	}

	function Menulist_moveMenu(oMenu, index, distance) {
		var tmpOption = new Option(oMenu.options[index].text, oMenu.options[index].value, false,
		oMenu.options[index].selected);
		for (var i=index; i<index+distance; i++) {
			oMenu.options[i].text = oMenu.options[i+1].text;
			oMenu.options[i].value = oMenu.options[i+1].value;
			oMenu.options[i].selected = oMenu.options[i+1].selected;

		}
		oMenu.options[index+distance] = tmpOption;

	}

	// 멀티셀렉트 박스 이동
	function fnselectMove(type) {
		var oMenu = document.selectedDeliveryCompany.selected_delivery_company;

		switch(type){
			case 'up' :
				var i=0;
				for (i=0; i<oMenu.length; i++) {
					if (Menulist_isSelected(oMenu, i)) {
						if (i==0) return;
						Menulist_upMenu(oMenu, i);
					}
				}
				break;
			case 'down' :
				var i	= 0;
				for (i=oMenu.length-1; i>=0; i--) {
					if (Menulist_isSelected(oMenu, i)) {
						if (i==oMenu.length-1) return;
						Menulist_downMenu(oMenu, i);
					}
				}
				break;
		}
	}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
<?php if($TPL_VAR["view"]["provider_seq"]){?>
			<h2><?php echo $TPL_VAR["view"]["provider_name"]?> → 택배사</h2> <!-- 2022.01.05 12월 1차 패치 by 김혜진 -->
<?php }else{?>
			<h2>택배사</h2>
<?php }?>
		</div>

<?php if($TPL_VAR["sc"]["provider_seq"]){?>
		<!-- 좌측 버튼 -->
		<div class="page-buttons-left">			
			<button type="button" onclick="document.location.href='/admin/provider/catalog'" class="resp_btn v3 size_L">입점사 리스트</button>			
		</div>
<?php }?>

		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<button type="button"  class="resp_btn active2 size_L" onclick="set_delivery_company();">택배사 설정</button>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="contents_container">
	<!-- 서브메뉴 바디 : 시작-->
	<div class="contents_dvs">
		<div class="item-title">택배사 정보</div>
		<table class="table_basic">
			<colgroup>
				<col width="5%" />
				<col />
				<col width="10%" />
				<col />
				<col width="10%" />
				<col />
				<col />
			</colgroup>
			<thead>
				<tr>
					<th rowspan="2">번호</th>
					<th rowspan="2">택배사</th>
					<th rowspan="2">출고처리 시<br />선택 가능여부</th>
					<th colspan="4">택배 업무 자동화</th>
				</tr>
				<tr>
					<th>서비스명</th>
					<th>설정</th>
					<th>상태</th>
					<th>잔여 건수</th>
				</tr>
			</thead>
			<tbody>
<?php if($TPL_selectedCompany_1){$TPL_I1=-1;foreach($TPL_VAR["selectedCompany"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
<?php if(in_array($TPL_K1,array('code97','code98','code99'))){?>
<?php if(($TPL_K1=='code98'&&$TPL_VAR["config_goodsflow"]["setting"]['goodsflow_msg'])||($TPL_K1=='code99'&&$TPL_VAR["config_epost"]["status_msg"]&&$TPL_VAR["config_epost"]["epost_use"]!='N')||($TPL_K1=='code97'&&$TPL_VAR["config_invoice"]["hlc"]["use"]=='1')){?>
				<tr>
<?php }else{?>
				<tr>
<?php }?>
<?php }else{?>
				<tr>
<?php }?>
					<td class="center"><?php echo ($TPL_I1+ 1)?></td>
					<td><?php echo $TPL_V1["company"]?></td>
<?php if($TPL_K1=='code98'){?>
					<!-- 굿스플로 -->
					<td class="center">
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_msg']){?>
						YES
<?php }else{?>
						NO
<?php }?>
					</td>
					<td>굿스플로 업무 자동화</td>
					<td class="center">
<?php if($TPL_VAR["provider_seq"]> 1){?>
<?php if($TPL_VAR["config_system"]["goodsflow_use"]== 1){?>
						<button type="button" class="resp_btn v2" <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> id="goodsflowSetting" <?php }?>>설정</button>
						<br/>
						<label><input type="checkbox" name="gf_use" value="Y" <?php if($TPL_VAR["config_goodsflow"]["setting"]["gf_use"]=='Y'){?>checked<?php }?>/> 가능</label>
						&nbsp;
						<span class="btn small cyanblue"><button type="button" id="set_gf_use">저장</button></span>
<?php }else{?>
						<button type="button" class="resp_btn v2" <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }?>>설정</button>
						<label onclick="javascript:alert('\'본사만 가능\' 설정 시 입점사 이용 설정은 할 수 없습니다.');"><input type="checkbox" value="Y" disabled /> 가능</label>
<?php }?>
<?php }else{?>
						<button type="button" class="resp_btn v2" <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> id="goodsflowSetting" <?php }?>>설정</button>
<?php if(serviceLimit('H_AD')){?>
							<div style="padding-top:5px;"><input class="resp_btn active" type="button" <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> id="goodsflow_use_setting" <?php }?> value="입점사 설정" 
							/></div>
<?php }else{?>
<?php }?>
<?php }?>
					</td>
					<td>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['deliveryName']){?>
						[<?php echo $TPL_VAR["config_goodsflow"]["setting"]['deliveryName']?>]<br/>
<?php }?>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_msg']){?>
						<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflow_msg']?>

<?php }else{?>
						중지 - 연동 정보 미입력
<?php }?>
					</td>
					<td>
						<?php echo number_format($TPL_VAR["service_cnt"])?>건
<?php if($TPL_VAR["provider_seq"]== 1){?>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']=='1'){?>
						<input type="button" class="resp_btn" <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> id="gf_charge" <?php }?> value="충전" />
<?php }else{?>
						<input type="button" class="resp_btn" value="충전" <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> onclick="openDialogAlert('연동 완료 후 충전 가능합니다.',400,140);" <?php }?>/>
<?php }?>
<?php }?>
						<input type="button" class="resp_btn" <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> id="gf_log" <?php }?> value="사용현황"  />
					</td>

<?php }elseif($TPL_K1=='code99'){?>
					<!-- 우체국 택배 -->
					<td class="center">
<?php if($TPL_VAR["config_epost"]["status_msg"]&&$TPL_VAR["config_epost"]["epost_use"]!='N'){?>
						YES
<?php }else{?>
						NO
<?php }?>
					</td>
					<td>우체국택배 업무 자동화</td>
					<td class="center">
						<button type="button" class="resp_btn v2" <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> id="epostSetting" <?php }?>>설정</button>
					</td>
					<td>
<?php if($TPL_VAR["config_epost"]["status_msg"]){?>
<?php if($TPL_VAR["config_epost"]["epost_use"]=='N'){?>
							중지
<?php }else{?>
							<?php echo $TPL_VAR["config_epost"]["status_msg"]?>

<?php }?>
<?php }else{?>
						중지 - 연동 정보 미입력
<?php }?>
					</td>
					<td>무료</td>

<?php }elseif($TPL_K1=='code97'){?>
					<!-- 롯데택배 택배 -->
					<td class="center">
<?php if($TPL_VAR["config_invoice"]["hlc"]["use"]=='1'){?>
							YES
<?php }else{?>
							NO
<?php }?>
					</td>
					<td>롯데택배 업무 자동화</td>
					<td class="center">
						<button type="button" class="resp_btn v2" <?php if($TPL_VAR["functionLimit"]){?> onclick="servicedemoalert('use_f');" <?php }else{?> id="invoiceSetting" <?php }?>>설정</button>
					</td>
					<td>
<?php if($TPL_VAR["config_invoice"]["hlc"]["use"]=='1'){?>
							이용중
<?php }else{?>
							중지 - 관리자에 의해 중지
<?php }?>
					</td>
					<td>무료</td>
<?php }else{?>
					<td class="center">YES</td>
					<td class="center">-</td>
					<td class="center">-</td>
					<td class="center">-</td>
					<td class="center">-</td>
<?php }?>
				</tr>
<?php }}else{?>
				<tr>
					<td colspan="7">택배사 정보가 없습니다.</td>
				</tr>
<?php }?>
			</tbody>
		</table>
	</div>

	<div class="box_style_05 mt10">					
		<div class="title">안내</div>
		<ul class="bullet_circle">
			<li>배송추적URL 변경요청 및 택배사 추가 요청은 1:1문의 게시판을 통해 접수해 주시면 확인 후 처리되어집니다.</li>		
			<li>
				택배 업무 자동화를 이용하시면 택배사 시스템과 연동하여 운송장 출력부터 배송완료 까지 배송을 간단하게 처리할 수 있습니다.
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/delivery_company', '#tip1', 'sizeR')"></span>
			</li>		
				
		</ul>
	</div>		
</div>

<div id="delivery_set_lay" class="hide">
	<form name="selectedDeliveryCompany" id="selectedDeliveryCompany" method="post" action="../setting_process/save_delivery_company" target="actionFrame">
	<input type="hidden" name="provider_seq" value="<?php echo $TPL_VAR["provider_seq"]?>" />
	<table width="100%" height="85%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="40%">
				<select name="org_delivery_company[]" multiple="multiple" style="width:100%;height:430px;">
<?php if($TPL_deliveryCompany_1){foreach($TPL_VAR["deliveryCompany"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["company"]?></option>
<?php }}?>
				</select>
			</td>
			<td align="center">
				<span class="btn small cyanblue"><button type="button" onclick="select_company();">></button></span>
				<div style="padding-top:20px;"></div>
				<span class="btn small red"><button type="button" onclick="remove_company();"><</button></span>
			</td>
			<td width="40%">
				<select name="selected_delivery_company[]" id="selected_delivery_company" multiple="multiple"  style="width:100%;height:430px;">
<?php if($TPL_selectedCompany_1){foreach($TPL_VAR["selectedCompany"] as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["company"]?></option>
<?php }}?>
				</select>
			</td>
			<td width="5%" class="center">
				<span class="btn small gray"><button type="button" id="upMove" style="width:20px;">↑</button></span>
				<div style="padding-top:20px;"></div>
				<span class="btn small gray"><button type="button" id="downMove" style="width:20px;">↓</button></span>
			</td>
		</tr>
	</table>

	<div class="footer">
		<button type="button" onclick="save_delivery_company();" class="resp_btn active size_XL">적용</button>
		<button type="button" onclick="closeDialogEvent(this);" class="resp_btn v3 size_XL">취소</button>
	</div>
	</form>
</div>

<div id="invoiceSettingPopup" style="display:none">
	<form name="invoiceSettingForm" action="../setting_process/invoice_setting" target="actionFrame" method="post" class="hx100">
	<div class="content">
		<table class="table_basic thl" >	
			<tr>
				<th>사용여부</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="invoice_notuse" value="0" <?php if($TPL_VAR["config_invoice"]["hlc"]["use"]||$TPL_VAR["config_invoice"]["hlc"]["use"]==""){?>checked<?php }?> /> 사용함</label>
						<label><input type="radio" name="invoice_notuse" value="1" <?php if(!$TPL_VAR["config_invoice"]["hlc"]["use"]){?>checked<?php }?> /> 사용 안 함</label>
					</div>
				</td>
			</tr>
		</table>

		<div id="invoiceSettingAuthContainer">
			<div class="gabia-pannel" code="invoice_guide_lotte"></div>

			<!-- 롯데택배 : start -->
			<table class="table_basic thl">		
				<tr>
					<th>세팅비</th>
					<td>
						<strike class="gray">110,000원</strike> → 0원 (이벤트 적용)
					</td>
				</tr>
				<tr>
					<th>서비스 이용료</th>
					<td>
						0원
					</td>
				</tr>
				<tr>
					<th>계약 대리점명</th>
					<td>
						<input type="text" class="line" name="branch_name" value="<?php echo $TPL_VAR["config_invoice"]["hlc"]["branch_name"]?>" />
						<span class="desc">예) 서울남부지점</span>
					</td>
				</tr>
				<tr>
					<th>신용코드 인증</th>
					<td>
						<div>
							<input type="text" class="invoice_auth_code line" name="auth_code[hlc]" value="<?php echo $TPL_VAR["config_invoice"]["hlc"]["auth_code"]?>" auth_code="<?php echo $TPL_VAR["config_invoice"]["hlc"]["auth_code"]?>" /><button type="button" onclick="hlc_auth()"  class="resp_btn v2">인증</button>
							<span class="invoice_auth_code_desc"></span>
						</div>
					</td>
				</tr>
				<tr>
					<th>
						운송장 프린트 세팅
						<div class="gabia-pannel" code="invoice_print_setting_guide"></div>
					</th>
					<td>
						<table cellpadding="0" cellspacing="0" class="resp_radio">
							<tr>
								<td><label><input type="radio" name="print_type" value="label_a" id="print_type_label_a" checked /> 라벨프린트 A타입</label></td>
								<td width="15"></td>
								<td><label><input type="radio" name="print_type" value="label_b" id="print_type_label_b"/> 라벨프린트 B타입</label></td>
								<td width="15"></td>
								<td><label><input type="radio" name="print_type" value="label_c" id="print_type_label_c"/> 라벨프린트 C타입</label></td>
								<td width="15"></td>
								<td><label><input type="radio" name="print_type" value="a4" id="print_type_a4" /> 레이저프린트 A4용지</label></td>
							</tr>
							<tr>
								<td height="7" colspan="7"></td>
							</tr>
							<tr>
								<td valign="top" align="center"><label for="print_type_label_a"><img src="/admin/skin/default/images/common/img_dliv_label_a.gif" /></label></td>
								<td></td>
								<td valign="top" align="center"><label for="print_type_label_b"><img src="/admin/skin/default/images/common/img_dliv_label_b.gif" /></label></td>
								<td></td>
								<td valign="top" align="center"><label for="print_type_label_c"><img src="/admin/skin/default/images/common/img_dliv_label_c.gif" /></label></td>
								<td></td>
								<td valign="top" align="center" rowspan="4"><label for="print_type_a4"><img src="/admin/skin/default/images/common/img_dliv_a4.gif" /></label></td>
							</tr>
							<tr>
								<td><label><input type="radio" name="print_type" value="label_d" id="print_type_label_d"/> 라벨프린트 D타입</label></td>
								<td width="15"></td>
								<td><label><input type="radio" name="print_type" value="label_e" id="print_type_label_e"/> 라벨프린트 E타입</label></td>
								<td width="15" colspan="2"></td>
							</tr>
							<tr>
								<td height="7" colspan="6"></td>
							</tr>
							<tr>
								<td valign="top" align="center"><label for="print_type_label_d"><img src="/admin/skin/default/images/common/img_dliv_label_d.gif" /></label></td>
								<td></td>
								<td valign="top" align="center"><label for="print_type_label_e"><img src="/admin/skin/default/images/common/img_dliv_label_e.gif" /></label></td>
								<td width="15" colspan="2"></td>
							</tr>
						</table>
						<script>
							$("input[name='print_type'][value='<?php echo $TPL_VAR["config_invoice"]["hlc"]["print_type"]?>']").attr('checked',true);
						</script>
					</td>
				</tr>
			</table>
			<!-- 롯데택배 : end -->
		</div>
	</div>
	<div class="footer">
		<input class="resp_btn active size_XL" type="submit" value="적용" />
		<input class="resp_btn v3 size_XL" type="button" onclick="closeDialogEvent(this)" value="취소" />
	</div>
	</form>
</div>

<!-- 우체국택배 연동설정 팝업창 :: 2016-03-28 lwh -->
<div id="epostSettingPopup" style="display:none;">
	<div class="content">
	<div id="status_info_txt">
<?php if($TPL_VAR["config_epost"]["status_msg"]){?>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
		우체국 택배 연동 서비스 이용이 가능합니다.
		단, 운송장 출력은 우체국 관리자 에서 가능하오니 이점 유의하시기 바랍니다.
<?php }elseif($TPL_VAR["config_epost"]["status"]=='7'){?>
		우체국 택배 연동 서비스가 현재 ‘<B><?php echo $TPL_VAR["config_epost"]["status_msg"]?></B>’ 상태 입니다.<br/>
		승인보류 사유를 확인하신 후 다시 서비스 신청을 완료해주시기 바랍니다.<br/>
		서비스 신청 후 3 영업일 이내에 승인이 되지 않은 경우 고객센터(1544-3270)로 문의해 주시기 바랍니다.
<?php }else{?>
		우체국 택배 연동 서비스가 현재 ‘<B><?php echo $TPL_VAR["config_epost"]["status_msg"]?></B>’ 상태 입니다.<br/>
		서비스 신청 후 3 영업일 이내에 승인이 되지 않은 경우 고객센터(1544-3270)로 문의해 주시기 바랍니다.
<?php }?>
<?php }else{?>
		우체국 택배 업무 자동화 서비스는 지역 우체국에 방문하여 '기업택배' 계약 완료 및 인터넷 우체국 택배 회원가입을 완료하신 후 서비스 신청이 가능합니다.<br/>
		이미 계약 완료 후 이용 중이시라면 바로 서비스 신청 하시면 됩니다.
<?php }?>
	</div>
	<!-- 연동 설정 :: START -->
	<form name="epostSettingForm" action="../setting_process/epost_setting" target="actionFrame" method="post">
	<input type="hidden" name="requestkey" value="<?php echo $TPL_VAR["config_epost"]["requestkey"]?>" />
	<table width="100%" class="table_basic thl mt10" id="epost_form">
		<col width="18%"/>
		<col width="32%"/>
		<col width="18%"/>
		<col width="32%"/>
		<tr>
			<th>사용여부</th>
			<td colspan="3">	
				<div class="resp_radio">
					<label><input type="radio" name="epost_notuse"  value="Y" <?php if($TPL_VAR["config_epost"]["epost_use"]=="Y"){?>checked<?php }?> /> 사용함</label>
					<label><input type="radio" name="epost_notuse" value="N" <?php if($TPL_VAR["config_epost"]["epost_use"]=="N"||$TPL_VAR["config_epost"]["epost_use"]==""){?>checked<?php }?> /> 사용 안 함</label>	
				</div>
<?php if($TPL_VAR["config_epost"]["requestkey"]&&$TPL_VAR["config_epost"]["status"]!='7'){?>
				<input type="button" id="set_epostuse" class="btn_resp b_gray ml10" value="저장" />
<?php }?>
			</td>
		</tr>
		<tr>
			<th>연동상태</th>
			<td colspan="3">
<?php if($TPL_VAR["config_epost"]["status_msg"]){?>
					<?php echo $TPL_VAR["config_epost"]["status_msg"]?>

<?php }else{?>
				이용 중지 - 연동 정보 미입력
<?php }?>
			</td>
		</tr>
		<tr>
			<th>우체국 아이디<span class="required_chk"></span></th>
			<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
				*******
<?php }else{?>
				<input type="text" name="epost_id" value="<?php echo $TPL_VAR["config_epost"]["epost_id"]?>" class="line ep_ing" />
<?php }?>
			</td>
			<th>우체국 비밀번호<span class="required_chk"></span></th>
			<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
				*******
<?php }else{?>
				<input type="password" name="epost_pw" value="<?php echo $TPL_VAR["config_epost"]["epost_pw"]?>" class="line ep_ing" />
<?php }?>
			</td>
		</tr>
		<tr>
			<th>우체국 고객번호<span class="required_chk"></span></th>
			<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
				<?php echo getstrcut($TPL_VAR["config_epost"]["epost_num"], 7,'***')?>

<?php }else{?>
				<input type="hidden" class="duple_chk_use" name="duple_chk1" value="" />
				<input type="text" name="epost_num" value="<?php echo $TPL_VAR["config_epost"]["epost_num"]?>" class="line ep_ing duple_input" />
				<input type="button" class="chk_duple resp_btn" chk_type="epost_num" value="중복확인"/><br>
				<span class="red duple_txt hide">사용가능</span>
<?php }?>
			</td>
			<th>우체국 승인번호<span class="required_chk"></span></th>
			<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
				<?php echo $TPL_VAR["config_epost"]["epost_auth_code"][ 0]?> - <?php echo getstrcut($TPL_VAR["config_epost"]["epost_auth_code"][ 1], 1,'****')?>

<?php }else{?>
				<input type="hidden" class="duple_chk_use" name="duple_chk2" value="" />
				<input type="text" name="epost_auth_code[]" value="<?php echo $TPL_VAR["config_epost"]["epost_auth_code"][ 0]?>" class="line ep_ing duple_input" size="7" maxlength="5" /> -
				<input type="text" name="epost_auth_code[]" value="<?php echo $TPL_VAR["config_epost"]["epost_auth_code"][ 1]?>" class="line ep_ing duple_input" size="7" maxlength="5" />
				<input type="button" class="chk_duple resp_btn" chk_type="epost_auth_code[]" value="중복확인"/><br>
				<span class="red duple_txt hide">사용가능</span>
<?php }?>
			</td>
		</tr>
		<tr>
			<th>라벨프린터<span class="required_chk"></span></th>
			<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
<?php if($TPL_VAR["config_epost"]["label_printer"]=='N'){?>사용안함<?php }else{?><?php echo $TPL_VAR["config_epost"]["label_printer"]?><?php }?>
<?php }else{?>
				<select name="label_printer" class="line ep_ing">
					<option value="">선택</option>
					<option value="N">사용안함</option>
					<option value="DataMax">DataMax</option>
					<option value="Zebra">Zebra</option>
					<option value="LUKHAN">LUKHAN</option>
					<option value="BIXOLON-D420">BIXOLON-D420</option>
					<option value="TOSHIBA B-EX4T1-GS12">TOSHIBA B-EX4T1-GS12</option>
				</select>
<?php if($TPL_VAR["config_epost"]["label_printer"]){?>
				<script>
				$("select[name='label_printer'] option[value='<?php echo $TPL_VAR["config_epost"]["label_printer"]?>']").attr('selected',true).trigger('change');
				</script>
<?php }?>
<?php }?>
			</td>

			<th>집하국명<span class="required_chk"></span></th>
			<td>
				<input type="text" name="epost_central_name" value="<?php echo $TPL_VAR["config_epost"]["epost_central_name"]?>" class="line ep_ing" />
			</td>
		</tr>
		<tr>
			<th>담당자<span class="required_chk"></span></th>
			<td>
				<input type="text" name="epost_manager_name" value="<?php echo $TPL_VAR["config_epost"]["epost_manager_name"]?>" class="line ep_ing" />
			</td>
			<th>담당자 휴대폰<span class="required_chk"></span></th>
			<td>
				<input type="text" name="epost_manager_cellphone" value="<?php echo $TPL_VAR["config_epost"]["epost_manager_cellphone"]?>" class="line ep_ing" />
			</td>
		</tr>
		<tr>
			<th>상호명</th>
			<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
				<?php echo $TPL_VAR["config_epost"]["biz_name"]?>

<?php }else{?>
				<input type="text" name="biz_name" value="<?php echo $TPL_VAR["config_epost"]["biz_name"]?>" class="ep_ing ep_box" readonly />
<?php }?>
			</td>
			<th>대표자명</th>
			<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
				<?php echo $TPL_VAR["config_epost"]["biz_ceo"]?>

<?php }else{?>
				<input type="text" name="biz_ceo" value="<?php echo $TPL_VAR["config_epost"]["biz_ceo"]?>" class="ep_ing ep_box" readonly />
<?php }?>
			</td>
		</tr>
		<tr>
			<th>사업자등록번호</th>
			<td colspan="3">
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
				<?php echo $TPL_VAR["config_epost"]["biz_no"]?>

<?php }else{?>
				<input type="text" name="biz_no" value="<?php echo $TPL_VAR["config_epost"]["biz_no"]?>" class="ep_ing ep_box" readonly />
<?php }?>
			</td>
		</tr>
		<tr>
			<th>사업장주소</th>
			<td colspan="3">
				<table width="100%" cellspacing="0" cellpadding="0" border="0">
				<colgroup>
				<col width="55px" />
				<col width="10px" />
				<col />
				</colgroup>
				<tr>
					<td height="30px">우편번호</td>
					<td width="10px"> : </td>
					<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
						<?php echo $TPL_VAR["config_epost"]["biz_zipcode"]?>

<?php }else{?>
						<input type="text" name="biz_zipcode" value="<?php echo $TPL_VAR["config_epost"]["biz_zipcode"]?>" class="ep_ing ep_box" size="6" readonly />
<?php }?>
					</td>
				</tr>
				<tr>
					<td height="40px">주소</td>
					<td width="10px"> : </td>
					<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
						<?php echo $TPL_VAR["config_epost"]["biz_address"]?>

<?php }else{?>
						<input type="text" name="biz_address" value="<?php echo $TPL_VAR["config_epost"]["biz_address"]?>" size="80" class="ep_ing ep_box" readonly />
<?php }?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<th>전화번호</th>
			<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
				<?php echo $TPL_VAR["config_epost"]["biz_phone"]?>

<?php }else{?>
				<input type="text" name="biz_phone" value="<?php echo $TPL_VAR["config_epost"]["biz_phone"]?>" class=" ep_ing ep_box" readonly />
<?php }?>
			</td>
			<th>이메일</th>
			<td>
<?php if($TPL_VAR["config_epost"]["status"]=='9'){?>
				<?php echo $TPL_VAR["config_epost"]["biz_email"]?>

<?php }else{?>
				<input type="text" name="biz_email" value="<?php echo $TPL_VAR["config_epost"]["biz_email"]?>" class=" ep_ing ep_box" readonly />
<?php }?>
			</td>
		</tr>
	</table>
	<div class="personInfo resp_message">
		- 사업자정보 변경은 <a href="/admin/setting/basic" target="_blank" class="resp_btn_txt">설정>상점관리</a>에서 수정하세요.<br/>
		- 집하국명에는 계약하신 우체국명을 입력해주세요. 예) 등촌우체국
	</div>

	<div class="personInfo" style="padding-top:20px;">
		<div style="line-height:30px;">■ 개인정보 수집 이용 동의</div>
		<table width="100%" class="table_basic" id="epost_form">
			<colgroup>
				<col width="32%"/>
				<col width="32%"/>
				<col width="36%"/>
			</colgroup>
			<tr>
				<th class="its-th">수집/이용 항목</th>
				<th class="its-th">수집/이용 목적</th>
				<th class="its-th">보유 기간</th>
			</tr>
			<tr>
				<td class="its-td">우체국 아이디, 우체국 비밀번호</td>
				<td class="its-td">우체국 택배 연동 승인을 위한 처리</td>
				<td class="its-td">개인정보 수집 및 이용 목적 달성 후 즉시 파기</td>
			</tr>
			<tr>
				<td class="its-td">
					우체국 고객번호, 우체국 승인번호, 라벨 프린터, 상호명, 대표자명, 사업자등록번호, 사업장 주소, 전화번호, 이메일
				</td>
				<td class="its-td">
					우체국 택배 연동 승인 및 서비스 이용에 따른 민원 사항의 처리
				</td>
				<td class="its-td">
					민원처리를 위해 일정기간 보유할 수 있음.<br/>(단, 서비스 취소 시 즉시 파기)
				</td>
			</tr>
		</table>
		<div class="chk_area resp_radio mt10">
			<label><input name="personinfo" type="radio" value="Y" /> 개인정보 수집 및 이용에 동의합니다.</label>
			<label><input name="personinfo" type="radio" value="N" /> 동의하지 않습니다.</label>
		</div>
	</div>
	</div>

	<div class="footer">
<?php if($TPL_VAR["config_epost"]["status"]=='0'||$TPL_VAR["config_epost"]["status"]=='1'){?>
			<input type="button" class="resp_btn active size_XL" id="epost_cancel" value="신청 취소" />
<?php }elseif($TPL_VAR["config_epost"]["status"]=='9'){?>
			<input type="button" class="resp_btn active size_XL" id="epost_cancel" value="서비스 취소"/>
<?php }else{?>
			<input type="submit" class="resp_btn active size_XL" value="신청" />
<?php }?>

		<input type="button" class="resp_btn v3 size_XL" value="취소" onclick="closeDialogEvent(this);" />
	</div>
	</form>
</div>
<!-- 우체국택배 연동설정 팝업창 :: END -->

<!-- 굿스플로 연동설정 팝업창 :: 2015-07-28 lwh -->
<div id="goodsflowSettingPopup" style="display:none;">
	<!-- 굿스플로 설정 :: START -->
	<form name="goodsflowSettingForm" action="../setting_process/goodsflow_setting" target="actionFrame" method="post" class="hx100">
	<input type="hidden" name="requestKey" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['requestKey']?>" />
	
	<div class="content">
		<div>
			굿스플로 택배 업무 자동화 서비스를 이용하시려면 먼저 택배사와 계약을 하신 이후에 아래 정보를 기입해주세요.
			<p class="desc">연동 가능 택배:
<?php if(is_array($TPL_R1=$TPL_VAR["config_goodsflow"]["terms"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
			<?php echo $TPL_I1+ 1?>.<?php echo $TPL_V1["name"]?>

<?php }}?>
			</p>
		</div>

		<table width="100%" class="table_basic thl mt10" id="goodsflow_form">
			<colgroup>
				<col width="19%"/>
				<col />
			</colgroup>
			<tr>
				<th>연동상태</th>
				<td colspan="3">
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_msg']){?>
					<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflow_msg']?>

<?php }else{?>
					이용 중지 - 연동 정보 미입력
<?php }?>
				</td>
			</tr>
			<tr>
				<th>아이디<span class="required_chk"></span></th>
				<td>
					<input type="hidden" name="mallId" value="<?php echo $TPL_VAR["config_system"]["shopSno"]?>_<?php echo $TPL_VAR["provider_seq"]?>" />
					XXXXX
				</td>
				<th>쇼핑몰명<span class="required_chk"></span></th>
				<td>
					<input type="text" name="mallName" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['mallName']?>" class="line gf_ing" />
				</td>
			</tr>
			<tr>
				<th>대표자</th>
				<td>
					<input type="text" name="mallUserName" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['mallUserName']?>" class="line gf_ing" />
				</td>
				<th>발송지명<span class="required_chk"></span></th>
				<td>
					<input type="text" name="centerName" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['centerName']?>" class="line gf_ing" />
				</td>
			</tr>
			<tr>
				<th>발송지주소<span class="required_chk"></span></th>
				<td colspan="3">
					<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td height="30px">우편번호 : </td>
							<td colspan="3">
								<input type="text" name="goodsflowZipcode[]" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflowNewZipcode']?>" class="gf_ing" size="6" readonly />
								<span class="btn small"><input type="button" id="goodsflowZipcodeButton" value="우편번호" /></span>
							</td>
						</tr>
						<tr>
							<td height="30px">기본주소 : </td>
							<td>
								<input type="text" name="goodsflowAddress_type" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflowAddress_type']?>" class="line hide" />
								<input type="text" name="goodsflowAddress" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflowAddress']?>" size="40" class="line gf_ing" />
								<input type="text" name="goodsflowAddress_street" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflowAddress_street']?>" size="40" class="line hide" />
							</td>
							<td>상세주소</td>
							<td><input type="text" name="goodsflowAddressDetail" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['goodsflowAddressDetail']?>" size="30" class="line gf_ing" /></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<th>발송지전화1<span class="required_chk"></span></th>
				<td>
					<input type="text" name="centerTel1" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['centerTel1']?>" title="- 를 제외하고 입력" class="line gf_ing" />
				</td>
				<th>발송지전화2</th>
				<td>
					<input type="text" name="centerTel2" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['centerTel2']?>" title="- 를 제외하고 입력" class="line gf_ing" />
				</td>
			</tr>
			<tr>
				<th>사업자 번호<span class="required_chk"></span></th>
				<td>
					<input type="text" name="bizNo" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['bizNo']?>" title="- 를 제외하고 입력" class="line gf_ing gf_complete" />
				</td>
				<th>택배사<span class="required_chk"></span></th>
				<td>
					<input type="hidden" name="deliveryName" id="deliveryName" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['deliveryName']?>" />
					<select name="deliveryCode" id="deliveryCode" class="gf_ing gf_complete" onchange="set_terms();">
						<option value="">선택</option>
<?php if(is_array($TPL_R1=$TPL_VAR["config_goodsflow"]['terms'])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
						<option value="<?php echo $TPL_K1?>" <?php if($TPL_VAR["config_goodsflow"]["setting"]['deliveryCode']==$TPL_K1){?>selected<?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
					</select>
				</td>
			</tr>
			<tr>
				<th>택배사 계약코드<span class="required_chk"></span></th>
				<td>
					<input type="text" name="contractNo" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['contractNo']?>" class="line gf_ing gf_complete" />
				</td>
				<th>택배사 업체코드<br/>(우체국인 경우 필수)</th>
				<td>
					<input type="text" name="contractCustNo" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['contractCustNo']?>" class="line gf_ing gf_complete" />
				</td>
			</tr>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['boxSize']){?>
<?php if(is_array($TPL_R1=$TPL_VAR["config_goodsflow"]["setting"]['boxSize'])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
			<tr>
<?php if($TPL_I1== 0){?>
				<th>
					요금정보<span class="required_chk"></span>
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/delivery_company', '#tip2')"></span>				
				</th>
<?php }else{?>
				<th>
					<input class="del_price btn_minus" type="button" >
				</th>
<?php }?>
				<td colspan="3">
					<table class="table_basic v3 price_list">
						<col /><col width="80px" />
						<tr>
							<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>박스타입 :</td>
									<td colspan="7">
										<select name="boxSize[]" class="gf_ing">
											<option value="">박스타입 생성</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>선불배송 :</td>
									<td>
										<input type="text" name="shFare[]" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['shFare'][$TPL_K1]?>" size="10" class="line gf_ing" />
									</td>
									<td>신용배송 :</td>
									<td>
										<input type="text" name="scFare[]" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['scFare'][$TPL_K1]?>" size="10" class="line gf_ing" />
									</td>
									<td>착불배송 :</td>
									<td>
										<input type="text" name="bhFare[]" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['bhFare'][$TPL_K1]?>" size="10" class="line gf_ing" />
									</td>
									<td>반품배송 :</td>
									<td>
										<input type="text" name="rtFare[]" value="<?php echo $TPL_VAR["config_goodsflow"]["setting"]['rtFare'][$TPL_K1]?>" size="10" class="line gf_ing" />
									</td>
								</tr>
							</table>
						</td>

						<td class="btn_td">
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']!='2'){?>
							<input type="button" class="add_price btn_plus" />
<?php }?>
						</td>
					</tr>	
					</table>
				</td>		
			</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<th>
					요금정보<span class="required_chk"></span>
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/delivery_company', '#tip2')"></span>				
				</th>
				<td class="clear" colspan="3">				
					<table class="table_basic v3 price_list">
						<col /><col width="80px" />
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="30px">박스타입 :</td>
										<td colspan="7">
											<select name="boxSize[]">
												<option value="">박스타입 생성</option>
											</select>
										</td>
									</tr>
									<tr>
										<td height="30px">선불배송 :</td>
										<td>
											<input type="text" name="shFare[]" value="" size="10" class="line gf_ing" />
										</td>
										<td>신용배송 :</td>
										<td>
											<input type="text" name="scFare[]" value="" size="10" class="line gf_ing" />
										</td>
										<td>착불배송 :</td>
										<td>
											<input type="text" name="bhFare[]" value="" size="10" class="line gf_ing" />
										</td>
										<td>반품배송 :</td>
										<td>
											<input type="text" name="rtFare[]" value="" size="10" class="line gf_ing" />
										</td>
									</tr>
								</table>
							</td>
							<td class="center">
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']!='2'){?>
							<input type="button" class="add_price btn_plus"/>
<?php }?>
						</td>
						</tr>
					</table>
				

				</td>
				
			</tr>
<?php }?>
		</table>
	
<?php if($TPL_VAR["provider_seq"]== 1){?>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']=='1'){?>
		<input type="hidden" name="gf_mode" value="modify" />
		<span class="btn medium cyanblue"><input type="submit" value="정보수정"/></span>
		<div class="red" style="padding-top:30px;">
			* 사업자번호나 택배사 혹은 택배사 계약코드가  변경된 경우 연동 서비스를 취소하고 재신청을 해야 합니다. &nbsp;&nbsp;&nbsp;
			<input type="button" id="goodsflow_cancel" class="resp_btn active2 size_XL"  value="서비스 취소"/>
		</div>
<?php }elseif($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']=='2'){?>
		<div class="red" style="padding-bottom:30px;">
			연동 대기중입니다. 잠시만 기다려 주세요.
		</div>	
<?php }?>
<?php }else{?>
		<div class="red" style="padding-bottom:30px;">
			입점사 설정 입점사 로그인 후 변경 가능합니다.
		</div>
<?php }?>
	</div>
	
	<div class="footer">
<?php if($TPL_VAR["provider_seq"]== 1){?>
<?php if($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']=='1'){?>
<?php }elseif($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']=='2'){?>		
			<input type="button" class="resp_btn active2 size_XL"  id="goodsflow_cancel" value="신청취소" />
<?php }elseif($TPL_VAR["config_goodsflow"]["setting"]['goodsflow_step']=='3'){?>
			<input type="submit" class="resp_btn active size_XL" value="재신청" />
<?php }else{?>
			<input type="submit" class="resp_btn active size_XL" value="신청" />		
<?php }?>
			<input type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this)" value="취소" />		
<?php }?>
	</div>

	</form>
	<!-- 굿스플로 설정 :: END -->
</div>
<!-- 굿스플로 입점사 이용여부 -->
<div id="goodsflow_use_area" class="hide">
	<div class="item-title">굿스플로 자동화 서비스 이용유무 선택</div>
	<div class="resp_radio col">
		<label><input type="radio" name="goodsflow_use" id="use0" value="0" <?php if($TPL_VAR["config_system"]["goodsflow_use"]==='0'){?>checked<?php }?> /> 본사만 이용 가능(어떤 입점사도 이용할 수 없습니다.)</label><br>
		<label><input type="radio" name="goodsflow_use" id="use1" value="1" <?php if($TPL_VAR["config_system"]["goodsflow_use"]==='1'){?>checked<?php }?> />	본사와 입점사 모두 이용 가능(서비스 신청하고 충전 잔여 건수 있을때 이용 가능)</label>
	</div>
	<button id="goodsflowProviderBtn" type="button" class="resp_btn">입점사 선택</button>

	<div class="footer">
		<input type="button" id="gf_setting_save" class="resp_btn active size_XL" value="저장" />
		<input type="button" onclick="closeDialogEvent(this)" class="resp_btn v3 size_XL" value="닫기" />
	</div>
</div>
<!-- 굿스플로 결제 -->
<div id="goodsflow_payment" class="hide"></div>
<!-- 굿스플로 로그 -->
<div id="goodsflow_log_area" class="hide">
	<iframe name="goodsflow_log" id="goodsflow_log" src="./goodsflow_log" width="100%" height="550" frameborder="0"></iframe>
	<div class="footer">
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>

<!-- 택배업무자동화서비스 안내 팝업 :: 2015-07-07 lwh -->
<div id="desc_popup_area" class="hide">
	<table width="100%" class="info-table-style">
		<colgroup>
			<col width="15%"/>
			<col width="25%"/>
			<col width="25%"/>
			<col width="35%"/>
		</colgroup>
		<thead>
			<tr>
				<th class="its-th-align center">&nbsp;</th>
				<th class="its-th-align center">우체국 택배</th>
				<th class="its-th-align center">롯데 택배</th>
				<th class="its-th-align center">굿스플로</th>
			</tr>
		</thead>
		<tr>
			<td class="its-td">비용</td>
			<td class="its-td">무료</td>
			<td class="its-td">무료</td>
			<td class="its-td">유료</td>
		</tr>
		<tr>
			<td class="its-td">과금 방식 및 차감</td>
			<td class="its-td">-</td>
			<td class="its-td">-</td>
			<td class="its-td">
				선 충전 후 송장 출력시 차감<br/>
				(동일 출고번호당 1번 차감<br/>
				즉, 동일한 출고번호에 여러 번 출고하면 <br/>
				1번만 차감함)
			</td>
		</tr>
		<tr>
			<td class="its-td">지원택배</td>
			<td class="its-td">우체국 택배</td>
			<td class="its-td">롯데 택배</td>
			<td class="its-td">
				CJ/옐로우캡/로젠/동부/우체국/한진
			</td>
		</tr>
		<tr>
			<td class="its-td">출력 방법</td>
			<td class="its-td">우체국택배(자동) 출고 후<br/>우체국 택배 관리자에서 출력</td>
			<td class="its-td">롯데택배(자동) 출고 후<br/>출력 가능</td>
			<td class="its-td">
				굿스플로 자동화로 출고<br/>
				→ ‘송장 받기/출력‘ 으로 연동을 한 이후에 출력
			</td>
		</tr>
	</table>
</div>

<?php if(serviceLimit('H_AD')){?>
<!-- 굿스플로 입점사 설정 CSS -->
<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/goodsflow-provider.css?dummy=<?php echo uniqid()?>" />

<!-- 굿스플로 입점사 설정 JS -->
<script type="text/javascript" src="/app/javascript/js/admin-goodsflow-provider.js?dummy=<?php echo uniqid()?>"></script>

<!-- 굿스플로 입점사 선택 레이어 -->
<div id="goodsflowProviderLayer" class="hide">
<?php $this->print_("goodsflow_provider_layer",$TPL_SCP,1);?>

</div>
<?php }?>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>