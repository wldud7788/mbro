<?php /* Template_ 2.2.6 2021/12/15 16:50:22 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/goods/restock_notify_apply.html 000005237 */  $this->include_("sslAction");
$TPL_options_1=empty($TPL_VAR["options"])||!is_array($TPL_VAR["options"])?0:count($TPL_VAR["options"]);?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 재입고 알림 @@
- 파일위치 : [스킨폴더]/goods/restock_notify_apply.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script>
$(function(){
	$("form[name='restockNofityApplyForm']").submit(function(){
		if(!$("input[name='agree']").is(":checked")){
			//개인정보 수집에 동의해주셔야 알림 신청이 가능합니다.
			openDialogAlert(getAlert('gv004'),400,150,function(){
				$("input[name='agree']").focus();
			});
			return false;
		}

		if ( $("select[name='viewOptionsReStock[]']").length > 0 &&  $("select[name='viewOptionsReStock[]']").val() == '' ){
			//옵션을 선택해 주세요.
			alert('옵션을 선택해 주세요');
			//openDialogAlert(getAlert('gv042'),400,140,'');
			return false;
		}
	});

	if( gl_option_view_type == 'divide' && gl_options_count ){
		$("select[name='viewOptionsReStock[]']").bind("change",function(){
			var n = parseInt($(this).attr('id')) + 1;
			set_option_ReStock(n);
		});
		set_option_ReStock(0);
	}
});
</script>
<p class="Pb10 gray_06">상품이 재입고될 경우 요청해 주신 휴대폰으로 SMS를 통해 알려드리겠습니다.</p>
<form name="restockNofityApplyForm" method="post" target="actionFrame" action="<?php echo sslAction('../goods_process/restock_notify_apply')?>">
<input type="hidden" name="goods_seq" value="<?php echo $TPL_VAR["goods"]["goods_seq"]?>" />
	<div class="resp_table_row th_size3">
		<ul>
			<li class="th">상품명</li>
			<li><?php echo $TPL_VAR["goods"]["goods_name"]?></li>
		</ul>
		<input type="hidden" name="optionType" value="<?php echo $TPL_VAR["goods"]["option_view_type"]?>" />
<?php if(count($TPL_VAR["options"])> 0&&$TPL_VAR["options"][ 0]["option_title"]){?>
<?php if($TPL_VAR["goods"]["option_view_type"]=='join'&&$TPL_VAR["options"]){?>
		<input type="hidden" name="title[]" value="<?php echo $TPL_VAR["options"][ 0]["option_title"]?>" />
		<ul>
			<li class="th"><?php echo $TPL_VAR["options"][ 0]["option_title"]?></li>
			<li>
				<select name="viewOptionsReStock[]">
				<option value="">- <?php echo $TPL_VAR["options"][ 0]["option_title"]?> 선택 -</option>
<?php if($TPL_options_1){foreach($TPL_VAR["options"] as $TPL_V1){?>
				<option value="<?php echo implode('/',$TPL_V1["opts"])?>" price="<?php echo $TPL_V1["price"]?>" opt1="<?php echo $TPL_V1["option1"]?>" opt2="<?php echo $TPL_V1["option2"]?>" opt3="<?php echo $TPL_V1["option3"]?>" opt4="<?php echo $TPL_V1["option4"]?>" opt5="<?php echo $TPL_V1["option5"]?>" infomation="<?php echo $TPL_V1["infomation"]?>" stock="<?php echo $TPL_V1["stock"]?>" <?php if($TPL_V1["stock"]> 0){?> disabled<?php }?> ><?php echo implode('/',$TPL_V1["opts"])?> <?php if($TPL_V1["stock"]<= 0){?> (품절)<?php }?></option>
<?php }}?>
				</select>
				<script type="text/javascript">//set_option_join();</script>
			</li>
		</ul>
<?php }?>
<?php if($TPL_VAR["goods"]["option_view_type"]=='divide'&&$TPL_VAR["options"]){?>
<?php if(is_array($TPL_R1=$TPL_VAR["goods"]["option_divide_title"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
			<input type="hidden" name="title[]" value="<?php echo $TPL_V1?>" />
		<ul>
			<li class="th"><?php echo $TPL_V1?></li>
			<li>
				<select name="viewOptionsReStock[]" id="<?php echo $TPL_K1?>" opttype="<?php echo $TPL_VAR["goods"]["divide_newtype"][$TPL_I1]?>" >
				<option value="">- <?php echo $TPL_V1?> 선택 -</option>
				</select>
			</li>
		</ul>
<?php }}?>
<?php }?>
<?php }?>
<?php if($TPL_VAR["memberData"]["userid"]){?>
		<ul>
			<li class="th">아이디</li>
			<li><?php echo $TPL_VAR["memberData"]["userid"]?></li>
		</ul>
<?php }?>
		<ul>
			<li class="th">휴대폰번호</li>
			<li>
				<input type="text" name="cellphone[]" value="<?php echo str_split_arr($TPL_VAR["memberData"]["cellphone"],'-', 0)?>" class="size_phone"  maxlength="4"/> - 
				<input type="text" name="cellphone[]" value="<?php echo str_split_arr($TPL_VAR["memberData"]["cellphone"],'-', 1)?>" class="size_phone"  maxlength="4"/> - 
				<input type="text" name="cellphone[]" value="<?php echo str_split_arr($TPL_VAR["memberData"]["cellphone"],'-', 2)?>" class="size_phone"  maxlength="4"/>
			</li>
		</ul>
	</div>

	<p class="Pt20 Pb5">개인정보 수집 및 이용 (필수)</p>
	<textarea style="width: 100%; height: 60px; overflow-y: auto; margin-bottom: 10px; color:#999;"><?php echo $TPL_VAR["policy_restock"]?></textarea>

	<div class="btn_area_a">
		<label class="label1"><input type="checkbox" name="agree"/> 개인정보 수집 및 이용에 동의합니다.</label> &nbsp; &nbsp;
	</div>

	<div class="btn_area_c Pb10">
		<input type="submit" value="알림등록" class="btn_resp size_c color2" />&nbsp;
		<input type="button" value="닫기" class="btn_resp size_c" onclick="hideCenterLayer()" />
	</div>
</form>