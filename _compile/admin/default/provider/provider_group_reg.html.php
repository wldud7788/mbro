<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/provider/provider_group_reg.html 000008954 */ 
$TPL_icons_1=empty($TPL_VAR["icons"])||!is_array($TPL_VAR["icons"])?0:count($TPL_VAR["icons"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>

<script type="text/javascript">
	function useTypeCont(id, name){
		if(!$(id).attr("checked")){
			$("#"+name).attr('disabled',true);
		}else{
			$("#"+name).attr('disabled',false);
			$("#"+name).focus();
		}
	}
	
	$(document).ready(function() {

		$(".onlynumber").bind("blur focus",(function(e){
			if(e.type == "blur"){
				if($(this).val()!='0' && $(this).val().length)
				$(this).val(comma($(this).val()));
			}else{
				if($(this).val()!='0' && $(this).val().length)
				$(this).val(uncomma($(this).val()));
			}
		}));

		setContentsRadio("use_type",  "<?php if($TPL_VAR["data"]["use_type"]=='auto1'){?>1<?php }elseif($TPL_VAR["data"]["use_type"]=='auto2'){?>2<?php }elseif($TPL_VAR["data"]["use_type"]=='manual'||!$TPL_VAR["data"]["use_type"]){?>3<?php }?>");

	
		$('#iconBtn').createAjaxFileUpload(uploadConfig, uploadCallback);	
		console.log("<?php echo $TPL_VAR["data"]["pgroup_icon"]?>");
<?php if($TPL_VAR["data"]["pgroup_icon"]){?>imgUploadEvent("#iconBtn", "", "/data/icon/provider/", "<?php echo $TPL_VAR["data"]["pgroup_icon"]?>")<?php }?>

	});

	function icon_click(img)
	{
		var imgname = $(img).attr("filenm");
		var html = "<img src=\""+$(img).attr('src')+"\" align='absmiddle'>";
		$("#imgHtml").html(html);
		$("input[name='pgroup_icon']").val(imgname);
		closeDialog("iconPopup");
	}

	function iconFileUpload(str){
		if(str > 0) {
			alert('아이콘을 선택해 주세요.');
			return false;
		}
		//파일전송
		var frm = $('#iconRegist');
		frm.attr("action","../provider_process/iconUpload");
		frm.submit();
	}

	function iconDisplay(filenm){
		var html = "<img src=\"../../data/icon/provider/"+filenm+"\" class=\"hand icons\" filenm=\""+filenm+"\" onload=\"icon_click(this);\">";
		$("#iconDisplay").html(html);
	}

	function iconBtn_click()
	{
		openDialog("아이콘 선택  <span class='desc'>아이콘으로 사용할 이미지를 등록해 주세요.</span>", "iconPopup", {"width":"350","height":"250","show" : "fade","hide" : "fade"});
	}
</script>


<form name="gradeFrm" id="gradeFrm" method="post" target="actionFrame" action="../provider_process/provider_group_write">
<?php if($TPL_VAR["data"]["pgroup_seq"]){?>
<input type="hidden" name="pgroup_seq" value="<?php echo $TPL_VAR["data"]["pgroup_seq"]?>">
<input type="hidden" name="mode" value="modify">
<?php }?>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>입점사 등급 등록</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><button type="button" onclick="document.location.href='provider_group';" class="resp_btn v3 size_L">리스트 바로가기</button></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button type="submit" class="resp_btn active2 size_L">저장</button></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">
	<div class="item-title">입점사 등급 정보</div>
	
	<table class="table_basic thl">		
		<tr>
			<th>명칭</th>
			<td colspan="3">	
				<div class="resp_limit_text limitTextEvent">
					<input type="text" name="pgroup_name" size="40" maxlength="15"   value="<?php echo $TPL_VAR["data"]["pgroup_name"]?>"/>
				</div>
			</td>
		</tr>
		
		<tr>
			<th>등급 아이콘</th>
			<td colspan="3">
				<div class="webftpFormItem">									
					<label class="resp_btn v2"><input type="file" id="iconBtn" class="uploadify">파일 선택</label>
					<input type="hidden" class="webftpFormItemInput" name="pgroup_icon" value="<?php echo $TPL_VAR["data"]["pgroup_icon"]?>"/>									
					<div class="preview_image"></div>
				</div>
				<div class="resp_message v2">- 파일 형식 jpg, gif, png, ico, 이미지 사이즈 15px*16px</div>
			</td>
		</tr>	

		<tr>
			<th>산정 기준</th>
			<td colspan="3">				
<?php if($TPL_VAR["data"]["pgroup_seq"]== 1){?>
				<div class="red">입점사 등록 시 자동으로 부여되는 등급입니다. (선정기준 변경 불가)</div>
<?php }else{?>
				<div class="resp_radio">
					<label><input type="radio" name="use_type" <?php if($TPL_VAR["data"]["use_type"]=="auto1"){?>checked<?php }?> value="1"/> 자동 관리 (모든 조건 만족)</label> 			
					<label><input type="radio" name="use_type" <?php if($TPL_VAR["data"]["use_type"]=="auto2"){?>checked<?php }?> value="2"/> 자동 승인 (1가지 이상 조건 만족)</label> 			
					<label><input type="radio" name="use_type" value="3" <?php if($TPL_VAR["data"]["use_type"]=="manual"||!$TPL_VAR["data"]["use_type"]){?>checked<?php }?>/>수동 승인</label>
				</div>
<?php }?>
			
			</td>
		</tr>
<?php if($TPL_VAR["data"]["pgroup_seq"]!= 1){?>
		<tr class="use_type_1 use_type_2 hide">
			<th>산정 기준 상세</th>
			<td colspan="3">
				<div class="use_type_1 hide">
					<div class="resp_checkbox">
						<label>
							<input type="checkbox" name="order_sum_use1[]" class="chkUse hide" <?php echo $TPL_VAR["selected"]["order_sum_price1_use"]?>  value="price1" /> 총 판매 금액
							<input type="text" name="order_sum_price1" id="order_sum_price1" value="<?php echo number_format($TPL_VAR["data"]["order_sum_price1"])?>" class="onlynumber right" size="6"/>원 이상(필수)
						</label> 
							
						<label>
							<input type="checkbox" name="order_sum_use1[]" class="chkUse"  <?php echo $TPL_VAR["selected"]["order_sum_ea1_use"]?>  value="ea1"/> 총 판매 개수
							<input type="text" name="order_sum_ea1" id="order_sum_ea1" value="<?php echo number_format($TPL_VAR["data"]["order_sum_ea1"])?>"  class="onlynumber right" size="6"/>개 이상
						</label>
						
						<label>
							<input type="checkbox" name="order_sum_use1[]" class="chkUse" <?php echo $TPL_VAR["selected"]['order_sum_cnt1_use']?>  value="cnt1"/> 총 판매 횟수 
							<input type="text" name="order_sum_cnt1" id="order_sum_cnt1" value="<?php echo number_format($TPL_VAR["data"]["order_sum_cnt1"])?>"  class="onlynumber right" size="6"/>회 이상
						</label>
					</div>					
				</div>
				<div class="use_type_2 hide">
					<div class="resp_checkbox">
						<label>
							<input type="checkbox" name="order_sum_use2[]" class="chkUse hide" value="price2" <?php echo $TPL_VAR["selected"]['order_sum_price2_use']?>/> 총 판매 금액
							<input type="text" name="order_sum_price2" id="order_sum_price2" value="<?php echo number_format($TPL_VAR["data"]["order_sum_price2"])?>"  class="onlynumber right" size="6"/>원 이상(필수)
						</label> 
						
						<label>
							<input type="checkbox" name="order_sum_use2[]" class="chkUse" value="ea2" <?php echo $TPL_VAR["selected"]['order_sum_ea2_use']?>/> 총 판매 개수
							<input type="text" name="order_sum_ea2" id="order_sum_ea2" value="<?php echo number_format($TPL_VAR["data"]["order_sum_ea2"])?>"  class="onlynumber right" size="6"/>개 이상
						</label>
						
						<label>
							<input type="checkbox" name="order_sum_use2[]" class="chkUse" value="cnt2" <?php echo $TPL_VAR["selected"]['order_sum_cnt2_use']?>/> 총 판매 횟수
							<input type="text" name="order_sum_cnt2" id="order_sum_cnt2" value="<?php echo number_format($TPL_VAR["data"]["order_sum_cnt2"])?>"  class="onlynumber right" size="6"/>회 이상	
						</label>
					</div>
				</div>
			</td>
		</tr>
<?php }?>

<?php if($TPL_VAR["data"]["pgroup_seq"]){?>
		<tr>
			<th>등록일</th>
			<td><?php echo $TPL_VAR["data"]["regist_date"]?></td>
			<th>수정일</th>
			<td><?php echo $TPL_VAR["data"]["update_date"]?></td>
		</tr>
<?php }?>
	</table>
</div>

</form>

<!-- 아이콘 선택 -->
<div id="iconPopup" style="display:none;">
	<form name="iconRegist" id="iconRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">
	<ul>
		<li>
<?php if($TPL_icons_1){foreach($TPL_VAR["icons"] as $TPL_V1){?>
		<img src="../../data/icon/provider/<?php echo $TPL_V1?>" class="hand icons" filenm="<?php echo $TPL_V1?>" onclick="icon_click(this);">
<?php }}?>
		<span id="iconDisplay"></span>
		</li>
		<li style="float:left;width:100px;height:30px;text-align:center" ><input type="file" name="pgrade_icon" id="pgrade_icon" onChange="iconFileUpload();" /></li>
	</ul>
	</form>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>