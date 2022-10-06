<?php /* Template_ 2.2.6 2022/05/17 12:36:19 /www/music_brother_firstmall_kr/admin/skin/default/market_connector/market_linkage.html 000009490 */  $this->include_("getGabiaOpenMarketBanner");?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript">
	function addNewAccount(market) {
		if (typeof market == 'undefined' || market == '')
			window.open('./account_add_popup','accountAdd','toolbar=no, scrollbars=yes, resizable=yes, width=800, height=600');
		else
			window.open('./account_add_popup?market=' + market,'accountAdd','toolbar=no, scrollbars=yes, resizable=yes, width=800, height=600');
	}

	function moveMenu(target) {window.location.href = target}
	
	$('document').ready(function(){
		$('.slc-body').resize(function(){
			alert('dd');
		});	
				
		$("#outSubmitBtn").click(function(){
			var nowShopCode = $('#nowShopcode').val();
			var openTarget = '';
			$('input[name*=targetLinkage]').each(function(){
				if($(this).prop('checked')){
					openTarget = $(this).val();
				}
			});

			var params	= $( '#marketLinkageForm' ).serialize();
			
			if(!$('#clauseAgree').prop('checked')){
				openDialogAlert('이용 약관에 동의 하여 주시기 바랍니다.', 0, 0);
				return false;			
			}
			
			if(openTarget == 'shoplinker'){
				if($('input[name=shoplinker_id]').val() == ''){
					
					openDialogAlert('샵링커 아이디를 입력해주세요.', 0, 0);
					return false;
				}
				
				if($('input[name=shoplinker_code]').val() == ''){
					
					openDialogAlert('샵링커 고객사 코드를 입력해주세요.', 0, 0);	
					return false;				
				}			
			}
			
			<!-- <?php if($TPL_VAR["MarketConnectorClause"]!='NOT_YET'){?> -->
				if(nowShopCode != openTarget){
					msg = '연동방법을 변경 시, 30일동안 연동방법을 다시 변경할 수 없습니다.또한 기존에 수집된 연동데이터(주문/취소/반품/교환)는 삭제됩니다.계속 진행하시겠습니까?';
					h = 180;
				}else{
					msg = '연동방법이 동일합니다. 계속 진행 하시겠습니까?';
					h = 150;
				}
			
				openDialogConfirm(msg,410,h,function(){		
					$.post('../market_connector_process/doSetLinkageTarget', params, function(response){
						
						if (response.success == 'FY') {
							openDialogAlert(response.agreeDate + ' 오픈마켓 연동 서비스<br/>이용약관에 동의하셨습니다.', 0, 0, function(){
								window.location.reload();
							});
							
						}else if(response.success == 'CY'){
							openDialogAlert('설정이 변경되었습니다.<br/>서비스 변경은 ' + response.changeAgreeDate + ' 이후 변경 가능합니다.', 0, 0, function(){
								window.location.reload();
							});				
						}else if(response.success == 'CN'){
							openDialogAlert('설정이 변경되었습니다.', 0, 0, function(){
								window.location.reload();
							});				
						}else{
							openDialogAlert('이용 약관에 동의 하여 주시기 바랍니다.', 0, 0);
							return false;				
						}
						
					}, 'json');	
				},function(){
				});
				
			<!-- <?php }else{?> -->
				$.post('../market_connector_process/doSetLinkageTarget', params, function(response){
					
					if (response.success == 'FY') {
						openDialogAlert(response.agreeDate + ' 오픈마켓 연동 서비스<br/>이용약관에 동의하셨습니다.', 0, 0, function(){
							window.location.reload();
						});
						
					}else if(response.success == 'CY'){
						openDialogAlert('설정이 변경되었습니다.<br/>서비스 변경은 ' + response.changeAgreeDate + ' 이후 변경 가능합니다.', 0, 0, function(){
							window.location.reload();
						});				
					}else{
						openDialogAlert('이용 약관에 동의 하여 주시기 바랍니다.', 0, 0);
						return false;				
					}
					
				}, 'json');			
			<!-- <?php }?> -->
		});				
		
		/*연동 설정 세팅 이벤트*/
		setContentsRadio("targetLinkage", "<?php if($TPL_VAR["MarketLinkage"]){?><?php echo $TPL_VAR["MarketLinkage"]["shopCode"]?><?php }else{?>firstmall<?php }?>");
		
		/*샵링커 설정 팝업*/
		$(".targetLinkageSettingBtn").on("click", function(){

			openDialog("샵링커 계정 관리", "targetLinkageSetting",  {"width":"600","height":"320","show" : "fade","hide" : "fade"});	
		});
		
		/* 샵링커 설정 팝업 확인 버튼 이벤트 - 확인클릭 시 저장으로 변경(2020.09.01) */
		$(".confirmPopupInfoBtn").on('click', function()
		{
			$("form[name='shoplinkerInfo']").submit();
		});
	
	});	
	
	
	function link(url){
		 window.open(url, '_blank');
	}
</script>


<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">
		<!-- 타이틀 -->
		<!-- <?php if($TPL_VAR["MarketLinkage"]["shopCode"]=='shoplinker'){?> -->
<?php $this->print_("scm_login",$TPL_SCP,1);?>

		<!-- <?php }?> -->
				
		<div class="page-title">
			<h2>연동 설정</h2>
		</div>
	</div>
</div>

<div class="search_container">
	<form name="marketLinkageForm" id="marketLinkageForm" method="post">
	<input type="hidden" id="nowShopcode" name="nowShopcode" value="<?php echo $TPL_VAR["MarketLinkage"]["shopCode"]?>"/>
	<div class="item-title">연동 설정</div>
	<table class="table_basic thl">		
		<tr>
			<th>연동 방법</th>
			<td>
				<div class="resp_radio">				
					<label <?php if($TPL_VAR["MarketLinkage"]["shopChangeDate"]>=date("Y-m-d")){?>class="disabled"<?php }?>><input type="radio" name="targetLinkage" id="dir" value="firstmall" <?php if($TPL_VAR["MarketLinkage"]["shopCode"]=="firstmall"||$TPL_VAR["MarketLinkage"]["shopCode"]==""){?> checked="checked" <?php }?> <?php if($TPL_VAR["MarketLinkage"]["shopChangeDate"]>=date("Y-m-d")){?> disabled="disabled" <?php }?>/> 직접 연동 (무료)</label>
					<label <?php if($TPL_VAR["MarketLinkage"]["shopChangeDate"]>=date("Y-m-d")){?> class="disabled" <?php }?>><input type="radio" name="targetLinkage" id="sl" value="shoplinker" <?php if($TPL_VAR["MarketLinkage"]["shopCode"]=="shoplinker"){?> checked="checked" <?php }?> <?php if($TPL_VAR["MarketLinkage"]["shopChangeDate"]>=date("Y-m-d")){?> disabled="disabled" <?php }?>/> 샵링커 연동 (유료)</label>				
				</div>

				<button type="button" onclick="link('https://www.shoplinker.co.kr/member/join?local=firstmall_v3')" class="resp_btn">샵링커 바로가기</button>
			</td>
		</tr>

		<tr class="targetLinkage_shoplinker hide">
			<th>샵링커 계정</th>
			<td>				
				<button type="button" class="targetLinkageSettingBtn resp_btn v2">설정</button>
			</td>
		</tr>
	</table>

	<div class="item-title">이용 약관</div>
<?php $this->print_("CLAUSE",$TPL_SCP,1);?>

	</form>
	
	<div class="footer">
	<!-- <?php if($TPL_VAR["MarketConnectorClause"]=='NOT_YET'){?>  -->
		<button type="button" id="outSubmitBtn" class="resp_btn size_XL active">신청</button>
	<!-- <?php }else{?> -->
		<!-- <?php if($TPL_VAR["MarketLinkage"]["shopChangeDate"]>=date("Y-m-d")){?> -->		
			
			<button type="button" class="resp_btn size_XL active disabled">변경 불가</button>
			<div class="mt10">(연동 방법 <?php echo $TPL_VAR["MarketLinkage"]["shopChangeDate"]?> 이후 변경 가능)</div>
		<!-- <?php }else{?> -->		
			<button type="button" id="outSubmitBtn" class="resp_btn size_XL active">변경</button>		
		<!-- <?php }?> -->
	<!-- <?php }?> -->
	</div>

	<div class="box_style_05 mt20">
		<div class="title">안내</div>
		<ul class="bullet_hyphen black">
			<li>오픈마켓 연동 판매 서비스 <a href="https://www.firstmall.kr/addservice/openmarket" target="_blank" class="resp_btn_txt">자세히 보기</a></li>
			<li>직접 연동, 샵링커 연동 안내 <a href="https://www.firstmall.kr/customer/faq/1254" target="_blank" class="resp_btn_txt">자세히 보기</a></li>
			<li>연동 방법 변경은 서비스 신청일로부터 30일 이후 가능합니다.</li>
		</ul>								
	</div>

	<!-- //배너 영역 -->
	<?php echo getGabiaOpenMarketBanner('multi')?>

	<!-- //배너 영역 -->
</div>

<div id="targetLinkageSetting" class="hide">
	<div class="content">
		<form name="shoplinkerInfo" method="post" action="../market_connector_process/doSetLinkageInfo" target="actionFrame">
		<table class="table_basic thl">
			<tr id="shoplinker_addinfo1">
				<th>샵링커 아이디 <span class="required_chk"></span></th>
				<td><input type="text" name="shoplinker_id" value="<?php echo $TPL_VAR["MarketLinkage"]["shoplinkerId"]?>" /></td>
			</tr>
			<tr id="shoplinker_addinfo2">
				<th>샵링커 고객사코드 <span class="required_chk"></span></th>
				<td><input type="text" name="shoplinker_code" value="<?php echo $TPL_VAR["MarketLinkage"]["shoplinkerCode"]?>" /></td>				
			</tr>	
		</table>

		<div class="box_style_05 resp_message pd10">
			<div class="title">안내</div>
			<ul class="bullet_hyphen">					
				<li>샵링커 신청 후 샵링커에서 발급 받은 정보를 입력해주세요. </li>			
			</ul>
		</div>
		</form>
	</div>

	<div class="footer">
		<button type="button" class="resp_btn active size_XL confirmPopupInfoBtn">확인</button>
		<button type="button" onClick="closeDialog('targetLinkageSetting');" class="resp_btn v3 size_XL" >취소</button>
	</div>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>