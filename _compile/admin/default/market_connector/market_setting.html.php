<?php /* Template_ 2.2.6 2022/05/17 12:36:20 /www/music_brother_firstmall_kr/admin/skin/default/market_connector/market_setting.html 000002354 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript">
	var marketObj	= <?php echo $TPL_VAR["marketsObj"]?>;
	var searchObj	= <?php echo $TPL_VAR["search"]?>;

	//객체동결(변경금지)
	if(typeof marketObj == "object") Object.freeze(marketObj);
	if(typeof searchObj == "object") Object.freeze(searchObj);

	function addNewAccount(market) {
		if (typeof market == 'undefined' || market == '')
			window.open('./account_add_popup','accountAdd','toolbar=no, scrollbars=yes, resizable=yes, width=800, height=650');
		else
			window.open('./account_add_popup?market=' + market,'accountAdd','toolbar=no, scrollbars=yes, resizable=yes, width=800, height=650');
	}

	function moveMenu(target) {window.location.href = target}

	$('document').ready(function(){
		$('.slc-body').resize(function(){
			alert('dd');
		});	

		if($.inArray(searchObj.pageMode,['AccountSet','AddInfoListSet','CategoryMatchingListSet']) != -1){
			gSearchForm.init({'pageid':'market_'+searchObj.pageMode.toLowerCase(),'divSelectLayId':'distTop','searchFormId':'marketSerachFrom'});
		}
		//$('#rightContentLay').height($('.slc-body').height() - 90);
	});
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">
		<!-- <?php if($TPL_VAR["MarketLinkage"]["shopCode"]=='shoplinker'){?> -->
<?php $this->print_("scm_login",$TPL_SCP,1);?>

		<!-- <?php }?> -->
		
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>마켓 설정</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li>
				<!-- <?php if($TPL_VAR["MarketLinkage"]["shopCode"]=='firstmall'){?> -->
				<button type="button" onclick="addNewAccount('<?php echo $TPL_VAR["market"]?>');" class="resp_btn active size_L">마켓 등록</button>
				<!-- <?php }?> -->
			</li>			
		</ul>
	</div>
</div>
<div class="contents_container">			
<?php if($TPL_VAR["MarketConnectorClause"]=='NOT_YET'){?>
<?php $this->print_("CLAUSE",$TPL_SCP,1);?>

<?php }else{?>			
<?php $this->print_("CONTENT",$TPL_SCP,1);?>

	<!-- <?php }?> -->	
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>