<?php /* Template_ 2.2.6 2022/05/17 12:36:56 /www/music_brother_firstmall_kr/admin/skin/default/setting/goods.html 000054199 */ 
$TPL_goodsaddinfoloop_1=empty($TPL_VAR["goodsaddinfoloop"])||!is_array($TPL_VAR["goodsaddinfoloop"])?0:count($TPL_VAR["goodsaddinfoloop"]);
$TPL_goodsoptionloop_1=empty($TPL_VAR["goodsoptionloop"])||!is_array($TPL_VAR["goodsoptionloop"])?0:count($TPL_VAR["goodsoptionloop"]);
$TPL_goodssuboptionloop_1=empty($TPL_VAR["goodssuboptionloop"])||!is_array($TPL_VAR["goodssuboptionloop"])?0:count($TPL_VAR["goodssuboptionloop"]);
$TPL_goodscolorloop_1=empty($TPL_VAR["goodscolorloop"])||!is_array($TPL_VAR["goodscolorloop"])?0:count($TPL_VAR["goodscolorloop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/jquery/jquery.tablednd.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-goodsaddlayer.js?v=20140309"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>


<script type="text/javascript">
	$(document).ready(function() {

		/* 컬러피커 */
		//$(".colorpicker").customColorPicker();

		$("#labelcodetypeuse").on("click",function(){

			var windowLabelNametitle = "";
			var windowLabelValuetitle = "";
			var windowLabelCodetitle = "";
			
			if( $(this).attr("checked") ) {
				labelcodedisplay('color');
			}else{
				labelcodedisplay('');
			}
		});

		$(".labelcodetypech, .labelcodetypech_s").on("click",function() {
			if( $(this).attr("checked") ) {
				labelcodedisplay($(this).val());
			}else{
				labelcodedisplay('');
			}
		});

		$(".goodscodesettingBtn").click(function(){
			openDialog('자동생성 규칙 설정',"goodscodesettingDiv",{"width":"650","height":"650"});
		});

		$(".goodscodebatchBtn").click(function(){
<?php if($TPL_VAR["setting_goodscd_act_auth"]){?>
			if(confirm("상품 기본코드 자동생성규칙에 의해 상품의 기본코드를 일괄 업데이트 합니다.\n상품이 많을 경우 시간이 오래 소요됩니다. 일괄 업데이트를 실행하시겠습니까?")){
				openDialog("일괄 업데이트 실행 <span class='desc'>규칙에 따라 상품코드를 일괄 업데이트 합니다.</span>", "goodscodebatchlay", {"width":400,"height":200});
				goodscode_update('1');
			}
<?php }else{?>
				alert("권한이 없습니다.");
<?php }?>
		});

		//$(".labelList_goodsaddinfo").sortable({items:'tr'});
		//$(".labelList_goodsoption").sortable({items:'tr'});
		//$(".labelList_goodssuboption").sortable({items:'tr'});
		//$(".goods-color-modify-tbody").sortable({items:'tr'});
		$(".tablednd").tableDnD({onDragClass: "dragRow"});
		//$(".labelList_goodscode").disableSelection();

		/* 크롬 브라우저 팝업창 띄운 후 sortable 드래그 오류로 추가 leewh 2014-10-01 */
		if (navigator.userAgent.match(/Chrome/)) {
			//$('html, body').css('overflowY', 'auto');
		}
	});


	//옵션코드 기간, 날짜, 지역(주소), 색상표 추가작업
	function labelcodedisplay(codetype) {	
		var codesplit = codetype;
		var codetitle = "";
		var labelplushide = '';
		$(".labelcodetypech").removeAttr("readonly");
		$(".labelcodetypech").removeAttr("disabled");
		$(".labelcodetypech").removeAttr("checked");
		$(".labelcodetypehelp").removeClass("red");
		$(".windowlabelnew").hide();
		$("#labelTable tr th").eq(5).show();
		$("#labelTable tr td").eq(5).show();
		$("#labelTable colgroup col").eq(3).css("width", "30%")

		switch(codetype) {
			case 'date':
				codetitle = "날짜";
			break;
			case 'address':
				codetitle = "지역";
				windowLabelNametitle = "예시) 제조사";
				windowLabelValuetitle = "예시) 프랑스";
				windowLabelCodetitle = "예시) french";
			break;
			case 'color':
				codetitle = "색상표";
				windowLabelNametitle = "예시) 색상";
				windowLabelValuetitle = "예시) dark blue";
				windowLabelCodetitle = "예시) dblue";
			break;
			case 'dayauto':
				labelplushide = 'hide';
				codetitle = "기간 자동 결정";
				$("#labelTable tr th").eq(5).hide();
				$("#labelTable tr td").eq(5).hide()
				$("#labelTable colgroup col").eq(3).css("width", "38%")
				$("#labelTable tr ")
			break;
			case 'dayinput':
				labelplushide = 'hide';
				codetitle = "기간 수동 결정";
				$("#labelTable tr th").eq(5).hide();
				$("#labelTable tr td").eq(5).hide()
				$("#labelTable colgroup col").eq(3).css("width", "38%")
			break;
		}		

		if( $("input[name=windowLabelSeq]").val() ) {
			$("#labelcodetypeuse").attr("readonly","readonly");
			$("#labelcodetypeuse").attr("disabled","disabled");

			if(codetype){
				$("#labelcodetype_"+codesplit).removeAttr("readonly");
				$("#labelcodetype_"+codesplit).removeAttr("disabled");
				$("#labelcodetype_"+codesplit).attr("checked",'checked');
				
				$("#windowlabelnewtitle").text(codetitle);
				$(".windowlabelnew"+codesplit).show();
				
				if(labelplushide == 'hide') 
				{
					$("#labelTable tr th").eq(5).hide();
					$("#labelTable tr td").eq(5).hide()
				}

				$(".labelcodetypech").attr("readonly","readonly");
				$(".labelcodetypech").attr("disabled","disabled");
				$(".labelcodetypech_s").attr("readonly","readonly");
				$(".labelcodetypech_s").attr("disabled","disabled");
			}else{
				$("#windowlabelnewtitle").text("없음");
				$(".labelcodetypech").attr("readonly","readonly");
				$(".labelcodetypech").attr("disabled","disabled");
				$(".labelcodetypech").removeAttr("checked");
				$(".labelcodetypech_s").attr("readonly","readonly");
				$(".labelcodetypech_s").attr("disabled","disabled");
				$(".labelcodetypech_s").removeAttr("checked");
			}
		}else{
			$("#labelcodetypeuse").removeAttr("readonly");
			$("#labelcodetypeuse").removeAttr("disabled");
			if(codetype){
				$("#labelcodetype_"+codesplit).removeAttr("readonly");
				$("#labelcodetype_"+codesplit).removeAttr("disabled");
				$("#labelcodetype_"+codesplit).attr("checked",'checked');
				
				$("#windowlabelnewtitle").text(codetitle);
				$(".windowlabelnew"+codesplit).show();
				
				if(labelplushide == 'hide') 
				{					
					$("#labelTable tr th").eq(5).hide();
					$("#labelTable tr td").eq(5).hide()
				}
			}else{
				$("#windowlabelnewtitle").text("없음");
				$(".labelcodetypech").attr("readonly","readonly");
				$(".labelcodetypech").attr("disabled","disabled");
				$(".labelcodetypech").removeAttr("checked");
				$(".labelcodetypech_s").attr("readonly","readonly");
				$(".labelcodetypech_s").attr("disabled","disabled");
				$(".labelcodetypech_s").removeAttr("checked");
			}
		}
	}

	function img_view(str){
		if(str != ""){
			$("#imgView").html("<img src='"+str+"'>");
			$("#imgView").show();
		}
	}

	function colorpickerlay(){
		/* 컬러피커 */
		$(".colorpicker").customColorPicker();
	}

	var remainsec = 3;
	function refresh()
	{
		remainsec--;
		if (remainsec == 0)
		{
			var nextpage		= $('#nextpage').val();

			if(parseInt(nextpage) > 0) {
				getAjaxOfflineList(nextpage);
				remainsec= 3;
				refresh();
			}else{
				clearTimeout(timerid);
				$("#totalpagelayer").hide();
				$("#offlinelayfinish").show();
				//$("#totalcountlay").html(" 총 "+ setComma(data.totalcount) +" 건 ");
			}
			return false;
		}
		$('#sec_layer').html(remainsec);
		timerid = setTimeout("refresh()" , 1000);
	}

	// 상품코드 일괄 업데이트
	function goodscode_update(page){
		$.ajax({
			url : '../goods_process/batch_goodscode_all',
		   'data' : {'page':page},
			'type' : 'get',
			'dataType': 'json',
			'success' : function(data){
				if(data.status == 'FINISH'){
					openDialogAlert("일괄 업데이트가 완료되었습니다.",'400','140',function(){$(".totalpagelayer").hide();
					$(".goodscodefinish").show();
					document.location.reload();});
				}else if(data.status == 'NEXT'){
					setTimeout("goodscode_update("+data.nextpage+")" , 1000);
				}
				$("#nowpage").text(page);
			}
		});
	}

	//기본코드 자동생성 원리 팝업 2016.04.22 pjw
	function popupBarcodeInfo(){
		openDialog('기본코드 자동생성 원리', 'code_auto_popup', {'width':900, 'height':300})
	}
</script>
<style>
	/*레이어팝업*/
	.layer_pop {border:3px solid #618298; background:#fff;}
	.layer_pop .tit {height:45px; font:14px Dotum; letter-spacing:-1px; font-weight:bold; color:#003775; background:#ebf4f2; border-bottom:1px solid #d8dee3; padding:0 10px; border-right:0;}
	.layer_pop .search_input {border:1px solid #cecece; height:17px;}
	.layer_pop .left {text-align:left;}

	div.color-item-lay {display:inline-block;margin:0 5px;line-height:27px;}
	div.color-item-lay li.color-name {display:inline-block;vertical-align:top;padding-top:1px;}
	div.color-item-lay li.color-code {display:inline-block;vertical-align:top;padding-top:1px;}
	.color-box {display:inline-block;border:1px solid #ccc; width:18px; height:18px; }

</style>

<div id="goodscodebatchlay" class="hide">
<ul class="left-btns clearbox">
	<li class="left"><div style="margin-top:rpx;">
	총 <span id="totalcount" style="color:#000000; font-size:11px; font-weight: bold"><?php echo $TPL_VAR["totalcount"]?></span>개(현재 <span id="nowpage" >1</span>/총 <span id="totalpage" ><?php echo $TPL_VAR["totalpage"]?></span>페이지)</div></li>
</ul>
<div id="totalpagelayer" class="hidea" >
<table  style="width:100%">
<tr height=23><td>&nbsp;&nbsp;&nbsp;<font color=blue><u>창을 닫으면 상품코드 일괄 업데이트가 중단됩니다..</u></font></td></tr>
<tr height=5><td></td></tr></table>
</div>
<div id="goodscodefinish"  class="hide" ><font size=2 color=red><b> 상품코드 일괄 업데이트가 <span id='totalcountlay'></span>완료되었습니다.</b></font>
</div>

<!-- 서브 레이아웃 영역 : 끝 -->
</form>
</div>
<form name="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/goods" target="actionFrame">
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>상품 코드/정보</h2>
		</div>

		<!-- 우측 버튼 -->
		<div class="page-buttons-right">			
			<button class="resp_btn active2 size_L" type="submit">저장</button>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->
<div class="contents_container">
	<!-- 서브메뉴 바디 : 시작-->
	<div class="contents_dvs">
		<div class="item-title">
			상품 기본코드
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#tip1', 'sizeR')"></span>
		</div>

		<table class="joinform-user-table table_basic thl">
			<tr>
				<th>기본 코드 규칙</th>
				<td class=" red">
<?php if(!$TPL_VAR["isplusfreenot"]){?>
						<img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand" onclick="serviceUpgrade();" align="absmiddle" />
<?php }else{?>
						<button type="button" class="goodscodesettingBtn resp_btn active" code="goodscodesetting" title="자동생성 규칙 설정" >규칙 설정</button>						
<?php }?>
					
<?php if($TPL_VAR["goodscodesettingview"]){?>
						<?php echo $TPL_VAR["goodscodesettingview"]?>

<?php }else{?>
						<span class="goodscodesettinglay desc" style="font-weight:normal;" >상품코드 자동생성 규칙이 세팅되지 않았습니다. 세팅해 주십시오.</span>
<?php }?>
				</td>
			</tr>

<?php if($TPL_VAR["isplusfreenot"]){?>
			<tr>
				<th>
					기본 코드 적용
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#tip11')"></span>
				</th>
				<td>					
					<button type="button" class="goodscodebatchBtn resp_btn active2" code="goodscodebatch" title="기본코드 일괄 업데이트 실행" >일괄 업데이트</button>					
				</td>
			</tr>
<?php }?>
		</table>
	</div>
	
	<input type="hidden"  id="optcoloraddruse" value="<?php echo $TPL_VAR["optcoloraddruse"]?>">
	<input type="hidden" name="windowLabelmaxSeq"  id="windowLabelmaxSeq" value="<?php if($TPL_VAR["maxseq"]){?><?php echo $TPL_VAR["maxseq"]?><?php }else{?>0<?php }?>">
	<input type="hidden" name="windowLabelSeq"  id="windowLabelSeq" value="">
	<input type="hidden" name="windowLabelId"  id="windowLabelId" value="">
	<input type="hidden" name="windowLabelnewtype"  id="windowLabelnewtype" value="">
	<input type="hidden" name="windowLabelNewtypeuse"  id="windowLabelNewtypeuse" value="">
	
	<div class="contents_dvs">
		<div class="title_dvs">
			<div class="item-title">
				자주 쓰는 추가정보
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#tip2', 'sizeM')"></span>
			</div>
<?php if(!$TPL_VAR["isplusfreenot"]){?>
				<img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand r_dvs" onclick="serviceUpgrade();" align="absmiddle" />
<?php }else{?>
				<button type="button" class="goodscodeBtn resp_btn active" code="goodsaddinfo" title="자주 쓰는 추가 정보 생성" windowlabeltitle="추가" >정보 생성</button>
<?php }?>			
		</div>

		<table class="joinform-user-table table_basic tdc tablednd" id="labelAddInfoTable">
			<col width="7%" /><col width="15%" /><col width="61%" /><col width="10%" /><col width="7%" />
			<thead>
				<tr>
					<th>순서</th>
					<th>추가정보</th>
					<th>정보값[코드값]</th>
					<th>수정</th>
					<th>삭제</th>
				</tr>
			</thead>
			<tbody class="labelList_goodsaddinfo">
			
<?php if($TPL_VAR["goodsaddinfoloop"]){?>
<?php if($TPL_goodsaddinfoloop_1){$TPL_I1=-1;foreach($TPL_VAR["goodsaddinfoloop"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_V1["base_type"]=='1'&&($TPL_goodsaddinfoloop_1==($TPL_I1+ 1))){?>
						<tr class="mess"><td colspan="5">자주 쓰는 정보를 추가해주세요.</td></tr>
<?php }?>
					<tr class="layer<?php echo $TPL_V1["codeform_seq"]?> hand <?php if($TPL_V1["base_type"]=='1'){?>hide<?php }?>">
						<td><img src="/admin/skin/default/images/common/icon_move.png" style="cursor:pointer"> </td>
						<td class="left <?php if($TPL_V1["codesetting"]== 1){?> red <?php }?>"><?php echo $TPL_V1["label_title"]?><!-- (<?php echo $TPL_V1["label_id"]?>) --> </td>
						<td class="left"><?php echo $TPL_V1["label_view"]?></td>
						<td>
<?php if($TPL_V1["base_type"]=='0'){?>
							<button type="button" class="listJoinBtn resp_btn v2" typeid="goodsaddinfo" value="<?php echo $TPL_V1["codeform_seq"]?>"  title="추가정보 정보값 및 코드값 수정하기" windowlabeltitle="추가" >수정</button>
<?php }?>
							<input type="hidden" class="codeform_seq" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][codeform_seq]" value="<?php echo $TPL_V1["codeform_seq"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][base_type]" value="<?php echo $TPL_V1["base_type"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][type]" value="<?php echo $TPL_V1["label_type"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][id]" value="<?php echo $TPL_V1["label_id"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][name]" value="<?php echo $TPL_V1["label_title"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][value]" value="<?php echo $TPL_V1["label_value"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][code]" value="<?php echo $TPL_V1["label_code"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][default]" value="<?php echo $TPL_V1["label_default"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][codesetting]" value="<?php echo $TPL_V1["codesetting"]?>">

							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][newtypeuse]" value="<?php echo $TPL_V1["label_newtypeuse"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][newtype]" value="<?php echo $TPL_V1["label_newtype"]?>">

							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][color]" value="<?php echo $TPL_V1["label_color"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][zipcode]" value="<?php echo $TPL_V1["label_zipcode"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][address_type]" value="<?php echo $TPL_V1["label_address_type"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][address]" value="<?php echo $TPL_V1["label_address"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][address_street]" value="<?php echo $TPL_V1["label_address_street"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][addressdetail]" value="<?php echo $TPL_V1["label_addressdetail"]?>">
							<input type="hidden" name="labelItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][biztel]" value="<?php echo $TPL_V1["label_biztel"]?>">								
						</td>
						<td>
<?php if($TPL_V1["base_type"]=='0'){?>
							<button type="button" title="삭제" class="btn_minus"  onclick="if(confirm('정말로 삭제하시겠습니까?') ) {deleteRow(this);}" ></button>
<?php }?>
						</td>
					</tr>
<?php }}?>
<?php }?>
			
			</tbody>
		</table>
	</div>
	
	<div class="contents_dvs">
		<div class="title_dvs">
			<div class="item-title">
				자주 쓰는 필수옵션
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#tip3')"></span>
			</div>
<?php if(!$TPL_VAR["isplusfreenot"]){?>
			<img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand r_dvs" onclick="serviceUpgrade();" align="absmiddle" />
<?php }else{?>
			<button type="button"  class="goodscodeBtn resp_btn active" code="goodsoption" title="자주 쓰는 필수옵션 생성" windowlabeltitle="필수옵션" >옵션 생성</button>
<?php }?>
		</div>

		<table width="100%" class="joinform-user-table table_basic tdc tablednd">
			<col width="7%" /><col width="15%" /><col width="61%" /><col width="10%" /><col width="7%" />
			<thead>
				<tr>
					<th>순서</th>
					<th>추가정보</th>
					<th>정보값[코드값]</th>
					<th>수정</th>
					<th>삭제</th>
				</tr>
			</thead>
			<tbody class="labelList_goodsoption">
			
<?php if($TPL_VAR["goodsoptionloop"]){?>
<?php if($TPL_goodsoptionloop_1){foreach($TPL_VAR["goodsoptionloop"] as $TPL_V1){?>
				<tr class="layer<?php echo $TPL_V1["codeform_seq"]?> hand">
					<td><img src="/admin/skin/default/images/common/icon_move.png" style="cursor:pointer"></td>
					<td class="left <?php if($TPL_V1["codesetting"]== 1){?> red <?php }?>"><?php echo $TPL_V1["label_title"]?><!-- (<?php echo $TPL_V1["label_id"]?>) --> </td>
					<td class="left"><?php echo $TPL_V1["label_view"]?> </td>
					<td>
						<button type="button" class="listJoinBtn resp_btn v2"  typeid="goodsoption"  value="<?php echo $TPL_V1["codeform_seq"]?>"   title="필수옵션 정보값 및 코드값 수정하기" windowlabeltitle="필수옵션" >수정</button>
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][codeform_seq]" value="<?php echo $TPL_V1["codeform_seq"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][type]" value="<?php echo $TPL_V1["label_type"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][id]" value="<?php echo $TPL_V1["label_id"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][name]" value="<?php echo $TPL_V1["label_title"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][value]" value="<?php echo $TPL_V1["label_value"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][code]" value="<?php echo $TPL_V1["label_code"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][default]" value="<?php echo $TPL_V1["label_default"]?>">

						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][newtypeuse]" value="<?php echo $TPL_V1["label_newtypeuse"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][newtype]" value="<?php echo $TPL_V1["label_newtype"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][color]" value="<?php echo $TPL_V1["label_color"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][zipcode]" value="<?php echo $TPL_V1["label_zipcode"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][address_type]" value="<?php echo $TPL_V1["label_address_type"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][address]" value="<?php echo $TPL_V1["label_address"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][address_street]" value="<?php echo $TPL_V1["label_address_street"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][addressdetail]" value="<?php echo $TPL_V1["label_addressdetail"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][biztel]" value="<?php echo $TPL_V1["label_biztel"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][address_commission]" value="<?php echo $TPL_V1["label_address_commission"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][date]" value="<?php echo $TPL_V1["label_date"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][sdayinput]" value="<?php echo $TPL_V1["label_sdayinput"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][fdayinput]" value="<?php echo $TPL_V1["label_fdayinput"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][dayauto_type]" value="<?php echo $TPL_V1["label_dayauto_type"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][sdayauto]" value="<?php echo $TPL_V1["label_sdayauto"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][fdayauto]" value="<?php echo $TPL_V1["label_fdayauto"]?>">
						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][dayauto_day]" value="<?php echo $TPL_V1["label_dayauto_day"]?>">

						<input type="hidden" name="labelItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][codesetting]" value="<?php echo $TPL_V1["codesetting"]?>">							
					</td>
					<td>
						<button class="btn_minus" type="button" title="삭제" onclick="if(confirm('정말로 삭제하시겠습니까?') ) {deleteRow(this);}" ></button>
					</td>
				</tr>
<?php }}?>
<?php }?>
<?php if($TPL_goodsoptionloop_1== 0){?>
				<tr class="mess"><td colspan="5">자주 쓰는 정보를 추가해주세요.</td></tr>
<?php }?>
			</tbody>
		</table>
	</div>
	
	<div class="contents_dvs">
		<div class="title_dvs">
			<div class="item-title">
				자주 쓰는 추가구성옵션
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#tip4')"></span>
			</div>
<?php if(!$TPL_VAR["isplusfreenot"]){?>
			<img src="/admin/skin/default/images/common/btn_upgrade.gif" class="hand dvs_r" onclick="serviceUpgrade();" align="absmiddle" />
<?php }else{?>
			<button type="button" class="goodscodeBtn resp_btn active" code="goodssuboption" title="자주 쓰는 추가구성옵션 생성" windowlabeltitle="추가구성옵션" >옵션 생성</button>
<?php }?>
		</div>

		<table width="100%" class="joinform-user-table table_basic tdc tablednd">
			<col width="7%" /><col width="15%" /><col width="61%" /><col width="10%" /><col width="7%" />
			
			<thead>
				<tr>
					<th>순서</th>
					<th>추가정보</th>
					<th>정보값[코드값]</th>
					<th>수정</th>
					<th>삭제</th>
				</tr>
			</thead>

			<tbody class="labelList_goodssuboption">
<?php if($TPL_VAR["goodssuboptionloop"]){?>
<?php if($TPL_goodssuboptionloop_1){foreach($TPL_VAR["goodssuboptionloop"] as $TPL_V1){?>
				<tr class="layer<?php echo $TPL_V1["codeform_seq"]?> hand">
					<td><img src="/admin/skin/default/images/common/icon_move.png" style="cursor:pointer"></td>
					<td class="left <?php if($TPL_V1["codesetting"]== 1){?> red <?php }?>"><?php echo $TPL_V1["label_title"]?><!-- (<?php echo $TPL_V1["label_id"]?>)  --></td>
					<td class="left"><?php echo $TPL_V1["label_view"]?></td>
					<td>
						<button type="button" class="listJoinBtn resp_btn v2"  typeid="goodssuboption"  value="<?php echo $TPL_V1["codeform_seq"]?>"  title="추가구성옵션 정보값 및 코드값 수정하기" windowlabeltitle="필수옵션" >수정</button>
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][codeform_seq]" value="<?php echo $TPL_V1["codeform_seq"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][type]" value="<?php echo $TPL_V1["label_type"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][id]" value="<?php echo $TPL_V1["label_id"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][name]" value="<?php echo $TPL_V1["label_title"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][value]" value="<?php echo $TPL_V1["label_value"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][code]" value="<?php echo $TPL_V1["label_code"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][default]" value="<?php echo $TPL_V1["label_default"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][codesetting]" value="<?php echo $TPL_V1["codesetting"]?>">

						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][newtypeuse]" value="<?php echo $TPL_V1["label_newtypeuse"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][newtype]" value="<?php echo $TPL_V1["label_newtype"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][color]" value="<?php echo $TPL_V1["label_color"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][zipcode]" value="<?php echo $TPL_V1["label_zipcode"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][address_type]" value="<?php echo $TPL_V1["label_address_type"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][address]" value="<?php echo $TPL_V1["label_address"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][address_street]" value="<?php echo $TPL_V1["label_address_street"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][addressdetail]" value="<?php echo $TPL_V1["label_addressdetail"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][biztel]" value="<?php echo $TPL_V1["label_biztel"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][date]" value="<?php echo $TPL_V1["label_date"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][sdayinput]" value="<?php echo $TPL_V1["label_sdayinput"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][fdayinput]" value="<?php echo $TPL_V1["label_fdayinput"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][dayauto_type]" value="<?php echo $TPL_V1["label_dayauto_type"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][sdayauto]" value="<?php echo $TPL_V1["label_sdayauto"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][fdayauto]" value="<?php echo $TPL_V1["label_fdayauto"]?>">
						<input type="hidden" name="labelItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][dayauto_day]" value="<?php echo $TPL_V1["label_dayauto_day"]?>">							
					</td>
					<td><button type="button" class="btn_minus" title="삭제" onclick="if(confirm('정말로 삭제하시겠습니까?') ) {deleteRow(this);}"></button></td>
				</tr>
<?php }}?>
<?php }?>
			
<?php if($TPL_goodssuboptionloop_1== 0){?>
				<tr class="mess"><td colspan="5">자주 쓰는 정보를 추가해주세요.</td></tr>
<?php }?>
			</tbody>
		</table>
	</div>

	<div class="contents_dvs">
		<div class="title_dvs">
			<div class="item-title">
				상품 검색용 색상
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#tip5')"></span>
			</div>
			<button type="button" class="resp_btn active" onclick="openModifyGoodsColor(this);">색상 생성</button>
		</div>			
		
		<table width="100%" class="joinform-user-table table_basic ">					
			<tr>
				<th>색상명/색상값/색상코드값</th>				
			</tr>				
			<tbody>
				<tr>					
					<td class="color-list-lay">
						
<?php if($TPL_goodscolorloop_1){foreach($TPL_VAR["goodscolorloop"] as $TPL_V1){?>				
						<div class="color-item-lay">
							<ul>
								<li class="color-name"><?php echo $TPL_V1["label_value"]?></li>
								<li style="background-color:#<?php echo $TPL_V1["label_color"]?>" class="color-box"></li>
								<li class="color-code">#<?php echo $TPL_V1["label_color"]?></li>

								<input type="hidden" name="labelItem[goodscolor][<?php echo $TPL_V1["codeform_seq"]?>][codeform_seq]" value="<?php echo $TPL_V1["codeform_seq"]?>" class="color_seq" />
								<input type="hidden" name="labelItem[goodscolor][<?php echo $TPL_V1["codeform_seq"]?>][value]" value="<?php echo $TPL_V1["label_value"]?>" class="color_name" />
								<input type="hidden" name="labelItem[goodscolor][<?php echo $TPL_V1["codeform_seq"]?>][color]" value="<?php echo $TPL_V1["label_color"]?>" class="color_value" />

								<input type="hidden" name="labelItem[goodscolor][<?php echo $TPL_V1["codeform_seq"]?>][type]" value="goodscolor">
								<input type="hidden" name="labelItem[goodscolor][<?php echo $TPL_V1["codeform_seq"]?>][name]" value="검색용 색상">
								<input type="hidden" name="labelItem[goodscolor][<?php echo $TPL_V1["codeform_seq"]?>][default]" value="">
								<input type="hidden" name="labelItem[goodscolor][<?php echo $TPL_V1["codeform_seq"]?>][code]" value="">
							</ul>
						</div>
<?php }}else{?>
						<div class="center">
							상품 검색용 색상을 생성해주세요.
						</div>					
<?php }?>					
					</td>					
				</tr>
			</tbody>
		</table>
	</div>

	<div id="html_error"></div>
	<!-- 서브메뉴 바디 : 끝 -->
</div>
<!-- 서브 레이아웃 영역 : 끝 -->
</form>

<div id="goodscolorDiv" class="hide" >
	<div class="content">
		<table class="table_basic tdc" width="100%">
		<colgroup>
			<col width="10%" />
			<col width="40%" />
			<col width="15%"/>
			<col width="25%" />
			<col width="10%" />
		</colgroup>
		<thead>
		<tr>
			<th>순서</th>		
			<th>색상명</th>
			<th>색상값</th>
			<th>코드값</th>
			<th><button type="button" class="btn_plus" onclick="addGoodsColor();"></button></th>
		</tr>
		</thead>
		<tbody class="goods-color-modify-tbody tablednd">
		</tbody>
		</table>
	</div>
	
	<div class="footer">
		<button type="button" alt="확인" class="resp_btn active size_XL" onclick="applyGoodsColor();" >확인</button>
		<button type="button" alt="취소" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);" >취소</button>
	</div>
</div>

<div id="goodscodeDiv" class="layer_pop hide" >
	<div class="content">
		<!--입력폼 -->
		<?php echo $TPL_VAR["goodscodeoptionnew"]?>


		<table  class="joinform-user-table table_basic thl">		
			<tr>
				<th>정보명</th>
				<td>
					<input type="text" name="windowLabelName" value="" title="예시) 제조사" size="30" style="height:18px;" class="windowLabelName line">				
				</td>
			</tr>
			<tr class="goodscodeoptionnew">
				<th>특수정보</th>
				<td class="clear">
					<ul class="ul_list_02">
						<li>
							<label class="resp_checkbox"><input type="checkbox" name="labelcodetypeuse"  id="labelcodetypeuse" value="1" > 특수 정보 사용</label>
						</li>
						<li>
							<ul class="ul_list_08 resp_radio">
								<li class="labelcodetypechlay">
									<label class="resp_radio">
										<input type="radio" name="labelcodetype"  id="labelcodetype_dayinput" class="labelcodetypech"  value="dayinput"  readonly="readonly" disabled="disabled" >	<span class="labelcodetypehelp">수동기간<!-- (또는 실물 상품의 기간 정보가 필요할 때) --></span>
										<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#tip6', '300')"></span>
									</label>
								</li>
								<li class="labelcodetypechlay">
									<label>
										<input type="radio" name="labelcodetype"  id="labelcodetype_dayauto"  class="labelcodetypech"  value="dayauto"  readonly="readonly" disabled="disabled" > 
										<span class="labelcodetypehelp">자동기간<!-- (또는 실물 상품의 기간 정보가 필요할 때) --></span>
										<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#tip7', '300')"></span>
									</label>
								</li>
								<li class="labelcodetypechlay">
									<label>
										<input type="radio" name="labelcodetype"  id="labelcodetype_date"  class="labelcodetypech"  value="date"  readonly="readonly" disabled="disabled" >
										<span class="labelcodetypehelp">날짜<!-- (또는 실물 상품의 날짜 정보가 필요할 때) --></span>
										<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#tip8', '270')"></span>
									</label>
								</li>
								<li class="labelcodetypechlay">
									<label>
										<input type="radio" name="labelcodetype"  id="labelcodetype_address"  class="labelcodetypech"  value="address"   readonly="readonly" disabled="disabled" > <span class="labelcodetypehelp">지역<!-- (또는 실물 상품의 지역 정보가 필요할 때) --></span>
										<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#tip9', '260')"></span>
									</label>
								</li>
								<li>
									<label>
										<input type="radio" name="labelcodetype" id="labelcodetype_color"  class="labelcodetypech_s"  value="color"  readonly="readonly" disabled="disabled" > 
										<span class="labelcodetypehelp">색상</span> 
										<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/goods', '#tip10', '280')"></span>
									</label>
								</li>
							</ul>
						</li>
					</ul>				
				</td>
			</tr>
		</table>

		<table  width="100%" class="joinform-user-table table_basic tdc mt15 " id="labelTable">
			<col width="8%" /><col width="8%" /><col width="23%" /><col class="info_cell"  width="30%" /><col  width="23%" /><col  width="8%" />
			
			<thead>
				<tr>
					<th id="labelTh">순서</th>
					<th id="labelTh">기본값</th>	
					<th id="labelTh">텍스트</th>				
<?php if($TPL_VAR["optcoloraddruse"]== 1){?><th id="labelTh" class="info_cell"> 특수 정보 : <span id="windowlabelnewtitle" class="red">없음</span> </th> <?php }?>
					<th id="labelTh"><span class="windowlabeltitle"></span> 정보값의 코드값</th>	
					<th id="labelTh"><button type="button" class="pointer labelAddbtn btn_plus" onclick="labelAdd()"  ></button></th>	
				</tr>
			</thead>
			
			<tbody class="labelList_goodscode tablednd" >			
			</tbody>
		</table>
	</div>

	<!--버튼 -->
	<div class="footer">
		<input type="submit" value="확인" alt="확인" class="labelWriteBtn resp_btn active size_XL" />
		<input type="button" value="취소" alt="취소" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);"/>
	</div>
	<!--//버튼 -->
	<!--//입력폼 -->
</div>

<div id="goodscodesettingDiv" class="hide" >
	<form name="GoodscodesettingForm" method="post" enctype="multipart/form-data" action="../setting_process/goodssetting" target="actionFrame">	
		<div class="content">
			<div class="item-title">상품 기본코드</div>			
			<table width="100%" class="table_basic tdc" >
				<col width="12%" /><col width="12%" /><col  width="50%" /><col  width="14%" /><col   width="12%"/>
				<thead>
					<tr>
						<th>순서</th>
						<th>조합</th>
						<th colspan="2">기본정보</th>
						<th>삭제</th>
					</tr>
				</thead>
				<tbody class="labelList_goodsinfo tablednd">
<?php if($TPL_VAR["goodsaddinfoloop"]){?>
<?php if($TPL_goodsaddinfoloop_1){foreach($TPL_VAR["goodsaddinfoloop"] as $TPL_V1){?>				
<?php if($TPL_V1["base_type"]== 1){?>
					<tr class="settinglayer<?php echo $TPL_V1["codeform_seq"]?> hand">
						<td><img src="/admin/skin/default/images/common/icon_move.png"></td>
						<td>
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][codeform_seq]" value="<?php echo $TPL_V1["codeform_seq"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][base_type]" value="<?php echo $TPL_V1["base_type"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][type]" value="<?php echo $TPL_V1["label_type"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][id]" value="<?php echo $TPL_V1["label_id"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][name]" value="<?php echo $TPL_V1["label_title"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][value]" value="<?php echo $TPL_V1["label_value"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][code]" value="<?php echo $TPL_V1["label_code"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][default]" value="<?php echo $TPL_V1["label_default"]?>">

							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][newtypeuse]" value="<?php echo $TPL_V1["label_newtypeuse"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][newtype]" value="<?php echo $TPL_V1["label_newtype"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][color]" value="<?php echo $TPL_V1["label_color"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][zipcode]" value="<?php echo $TPL_V1["label_zipcode"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][address_type]" value="<?php echo $TPL_V1["label_address_type"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][address]" value="<?php echo $TPL_V1["label_address"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][address_street]" value="<?php echo $TPL_V1["label_address_street"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][addressdetail]" value="<?php echo $TPL_V1["label_addressdetail"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][biztel]" value="<?php echo $TPL_V1["label_biztel"]?>">

							<label class="resp_checkbox"><input type="checkbox" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][codesetting]" value="1" <?php echo $TPL_V1["label_codesetting"]?>/></label>
						</td>				
						<td colspan="2" class="left"><?php echo $TPL_V1["label_title"]?></td>
						<td></td>
					</tr>
<?php }?>
<?php }}?>
<?php }else{?>
					<tr><td colspan="5"><span class="desc">먼저 코드값을 생성하세요.</span></td></tr>
<?php }?>
				</tbody>
			</table>

			<div class="item-title">추가 정보</div>	

			<table width="100%" class="table_basic tdc" >
				<col width="12%" /><col width="12%" /><col  width="50%" /><col  width="14%" /><col   width="12%"/>
				<thead>
					<tr>
						<th>순서</th>
						<th >조합</th>		
						<th colspan="2">추가정보</th>
						<th>삭제</th>
					</tr>
				</thead>
				<tbody class="labelList_goodsaddinfo tablednd">
<?php if($TPL_VAR["goodsaddinfoloop"]){?>
<?php if($TPL_goodsaddinfoloop_1){$TPL_I1=-1;foreach($TPL_VAR["goodsaddinfoloop"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_V1["base_type"]=='1'&&($TPL_goodsaddinfoloop_1==($TPL_I1+ 1))){?>
								<tr class="mess"><td colspan="5">자주 쓰는 정보를 추가해주세요.</td></tr>
<?php }?>
<?php if($TPL_V1["base_type"]!= 1){?>

					<tr class="settinglayer<?php echo $TPL_V1["codeform_seq"]?> hand">
						<td><img src="/admin/skin/default/images/common/icon_move.png" style="cursor:pointer"></td>
						<td>
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][codeform_seq]" value="<?php echo $TPL_V1["codeform_seq"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][base_type]" value="<?php echo $TPL_V1["base_type"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][type]" value="<?php echo $TPL_V1["label_type"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][id]" value="<?php echo $TPL_V1["label_id"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][name]" value="<?php echo $TPL_V1["label_title"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][value]" value="<?php echo $TPL_V1["label_value"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][code]" value="<?php echo $TPL_V1["label_code"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][default]" value="<?php echo $TPL_V1["label_default"]?>">

							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][newtypeuse]" value="<?php echo $TPL_V1["label_newtypeuse"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][newtype]" value="<?php echo $TPL_V1["label_newtype"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][color]" value="<?php echo $TPL_V1["label_color"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][zipcode]" value="<?php echo $TPL_V1["label_zipcode"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][address_type]" value="<?php echo $TPL_V1["label_address_type"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][address]" value="<?php echo $TPL_V1["label_address"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][address_street]" value="<?php echo $TPL_V1["label_address_street"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][addressdetail]" value="<?php echo $TPL_V1["label_addressdetail"]?>">
							<input type="hidden" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][biztel]" value="<?php echo $TPL_V1["label_biztel"]?>">

							<label class="resp_checkbox"><input type="checkbox" name="SettingItem[goodsaddinfo][<?php echo $TPL_V1["codeform_seq"]?>][codesetting]" value="1" <?php echo $TPL_V1["label_codesetting"]?>/></label>
						</td>				
						<td colspan="2" class="left"><?php echo $TPL_V1["label_title"]?></td>
						<td></td>
					</tr>
<?php }?>
<?php }}?>
<?php }else{?>
					<tr><td colspan="5"  class="center"><span class="desc">먼저 코드값을 생성하세요.</span></td></tr>
<?php }?>
				</tbody>
			</table>

			<div class="hide">
			<table width="100%" class="joinform-user-table info-table-style">
				<col width="50" /><col width="50" /><col  />
				<thead>
					<tr>
						<th class="its-th-align center">순서</th>
						<th class="its-th-align center " >조합</th>				
						<th class="its-th-align center">필수옵션</th>
					</tr>
				</thead>
				<tbody class="labelList_goodsoption">
<?php if($TPL_VAR["goodsoptionloop"]){?>
<?php if($TPL_goodsoptionloop_1){foreach($TPL_VAR["goodsoptionloop"] as $TPL_V1){?>
					<tr class="settinglayer<?php echo $TPL_V1["codeform_seq"]?> hand">
						<td class="its-td-align">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][codeform_seq]" value="<?php echo $TPL_V1["codeform_seq"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][type]" value="<?php echo $TPL_V1["label_type"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][id]" value="<?php echo $TPL_V1["label_id"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][name]" value="<?php echo $TPL_V1["label_title"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][value]" value="<?php echo $TPL_V1["label_value"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][code]" value="<?php echo $TPL_V1["label_code"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][default]" value="<?php echo $TPL_V1["label_default"]?>">

						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][newtypeuse]" value="<?php echo $TPL_V1["label_newtypeuse"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][newtype]" value="<?php echo $TPL_V1["label_newtype"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][color]" value="<?php echo $TPL_V1["label_color"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][zipcode]" value="<?php echo $TPL_V1["label_zipcode"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][address_type]" value="<?php echo $TPL_V1["label_address_type"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][address]" value="<?php echo $TPL_V1["label_address"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][address_street]" value="<?php echo $TPL_V1["label_address_street"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][addressdetail]" value="<?php echo $TPL_V1["label_addressdetail"]?>">
						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][biztel]" value="<?php echo $TPL_V1["label_biztel"]?>">

						<input type="hidden" name="SettingItem[goodsoption][<?php echo $TPL_V1["codeform_seq"]?>][codesetting]" value="0">
						<label class="resp_checkbox"><input type="checkbox"  checked="checked"  readonly="readonly" disabled="disabled" /></label>
						</td>
						<td class="its-td-align"><img src="/admin/skin/default/images/common/icon_move.gif" style="cursor:pointer"></td>
						<td class="its-td left"><?php echo $TPL_V1["label_title"]?></td>
					</tr>
<?php }}?>
<?php }else{?>
					<tr><td colspan="3"  class="its-td"><span class="desc">먼저 필수옵션용 코드값을 생성하세요.</span></td></tr>
<?php }?>
				</tbody>
				</table>

				<br style="line-height:10px;" />

				<table width="100%" class="info-table-style">
				<col width="50" /><col width="50" /><col  />
				<tr>
					<th class="its-th-align center " >조합</th>
					<th class="its-th-align center">순서</th>
					<th class="its-th-align center">추가구성옵션</th>
				</tr>
				<tbody class="labelList_goodssuboption">
<?php if($TPL_VAR["goodssuboptionloop"]){?>
<?php if($TPL_goodssuboptionloop_1){foreach($TPL_VAR["goodssuboptionloop"] as $TPL_V1){?>
					<tr class="settinglayer<?php echo $TPL_V1["codeform_seq"]?> hand">
						<td class="its-td-align">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][codeform_seq]" value="<?php echo $TPL_V1["codeform_seq"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][type]" value="<?php echo $TPL_V1["label_type"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][id]" value="<?php echo $TPL_V1["label_id"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][name]" value="<?php echo $TPL_V1["label_title"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][value]" value="<?php echo $TPL_V1["label_value"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][code]" value="<?php echo $TPL_V1["label_code"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][default]" value="<?php echo $TPL_V1["label_default"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][codesetting]" value="0">
						<label class="resp_checkbox"><input type="checkbox"  checked="checked"  readonly="readonly" disabled="disabled" /></label>

						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][newtypeuse]" value="<?php echo $TPL_V1["label_newtypeuse"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][newtype]" value="<?php echo $TPL_V1["label_newtype"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][color]" value="<?php echo $TPL_V1["label_color"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][zipcode]" value="<?php echo $TPL_V1["label_zipcode"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][address_type]" value="<?php echo $TPL_V1["label_address_type"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][address]" value="<?php echo $TPL_V1["label_address"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][address_street]" value="<?php echo $TPL_V1["label_address_street"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][addressdetail]" value="<?php echo $TPL_V1["label_addressdetail"]?>">
						<input type="hidden" name="SettingItem[goodssuboption][<?php echo $TPL_V1["codeform_seq"]?>][biztel]" value="<?php echo $TPL_V1["label_biztel"]?>">
						</td>
						<td class="its-td-align"><img src="/admin/skin/default/images/common/icon_move.gif" style="cursor:pointer"></td>
						<td class="its-td left"><?php echo $TPL_V1["label_title"]?></td>
					</tr>
<?php }}?>
<?php }else{?>
					<tr><td colspan="3"  class="its-td"><span class="desc">먼저 추가구성옵션용 코드값을 생성하세요.</span></td></tr>
<?php }?>
				</tbody>
				</table>
				</div>
			</div>
		
			<!--버튼 -->
			<div class="footer">
				<input type="submit" alt="저장" class="SettingWriteBtn resp_btn active size_XL" value="저장"/>
				<input type="button" alt="취소" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this)" value="취소"/>
			</div>
			<!--//버튼 -->
	</form>
</div>

<div id="imgView" style="position:absolute; top:50%; left:30%; display:none; cursor:pointer" onclick="this.style.display = 'none'"></div>
<div id="code_auto_popup" class="hide"><img src="/admin/skin/default/images/common/img_goods_code.gif" style="width: 100%"/></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>