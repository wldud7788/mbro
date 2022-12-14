<?php /* Template_ 2.2.6 2022/01/25 10:32:11 /www/music_brother_firstmall_kr/admin/skin/default/broadcast/regist.html 000005536 */ ?>
<script>
	var bsSeq = "<?php echo $TPL_VAR["bs_seq"]?>";
	var pagemode = "regist";
</script>
<script type="text/javascript" src="/app/javascript/js/admin/gGoodsSelectList.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin/broadcastRegist.js?mm=<?php echo date('YmdH')?>"></script>

<div class="fullcontent hx100">
<form id="bs-write-form" method="post"  target="actionFrame" enctype="multipart/form-data" class="hx100">
	<input type="hidden" name="bs_seq" value="" />
	<input type="hidden" name="provider_seq" value="<?php echo $TPL_VAR["provider_seq"]?>" />
	<input type="hidden" name="manager_seq" value="<?php echo $TPL_VAR["managerInfo"]["manager_seq"]?>" />
	<input type="hidden" name="approval" value="apply" />
	<div class="content">

		<div class="item-title">
			신청 정보 <span class="regist_date sub-title gray"></span>
			<input type="button" value="예약 삭제" class="btn-drop-form resp_btn fr" style="display:none;" />
		</div>
		<table class="table_basic thl th120" width="100%" cellspacing="0" cellpadding="0" >
			<tbody>
<?php if(serviceLimit('H_AD')){?>
				<tr>
					<th>신청 입점사</th>
					<td class="provider_name">본사</td>

				</tr>
<?php }?>
				<tr>
					<th>신청자</th>
					<td class="manager_name"><?php echo $TPL_VAR["managerInfo"]["mname"]?>(<?php echo $TPL_VAR["managerInfo"]["manager_id"]?>)</td>
				</tr>
			</tbody>
		</table>

		<div class="item-title">예약 정보</div>
		<table class="table_basic thl th120" width="100%" cellspacing="0" cellpadding="0" >
			<tbody>
				<tr>
					<th>방송 제목<span class="required_chk"></span></th>
					<td>
						<div class="resp_limit_text limitTextEvent">
							<input type="text" name="title" size='50' class="resp_text" maxlength="30" value="" title="방송 제목을 입력하세요" />
						</div>
					</td>
				</tr>
				<tr>
					<th>방송일<span class="required_chk"></span></th>
					<td>
						<input type="text" name="start_date_day"  class="datepicker" options="fnDatepicker('aftertoday')"  maxlength="10" size="10" />
						<select name="start_date_hour" >
<?php if(is_array($TPL_R1=$TPL_VAR["default"]["hours"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?>시</option>
<?php }}?>
						</select>
						<select name="start_date_min" class="select_resp" required>
<?php if(is_array($TPL_R1=$TPL_VAR["default"]["minutes"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?>분</option>
<?php }}?>
						</select>
					</td>
				</tr>
				<tr>
					<th>대표 이미지<span class="required_chk"></span></th>
					<td>
						<div class="webftpFormItem">							
							<input type="hidden" class="webftpFormItemInput" name="image" size="30" maxlength="255" />
							<div class="preview_image"></div>
							<span class="btn_wrap">
								<label class="resp_btn v2"><input type="file" id="image" accept="image/*">파일선택</label>
								<div class="resp_message v2">- 권장 사이즈 : 720*1280</div>
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<th>방송 설명</th>
					<td>
						<div class="resp_limit_text limitTextEvent">
							<input type="text" name="summary"" size='50' class="resp_text" maxlength="100" value="" title="방송 설명을 입력하세요" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="item-title">
			상품 정보
			<input type="button" value="상품 선택" class="btn_select_goods resp_btn active fr"  />
		</div>
		<div class="" id="broadcastGoodsSelectContainer">
			<div class="goods_list_header">
			<table class="table_basic tdc">
				<colgroup>
					<col width="10%" />
					<col width="60%" />
					<col width="20%" />
					<col width="10%" />
				</colgroup>
				<tbody>
					<tr>
						<th>대표</th>
						<th>상품명</th>
						<th>판매가</th>
						<th>삭제</th>
					</tr>
				</tbody>
			</table>
			</div>
			<div class="goods_list" id="broadcastGoods">
				<table class="table_basic tdc fix">
					<colgroup>
						<col width="10%" />
						<col width="60%" />
						<col width="20%" />
						<col width="10%" />
					</colgroup>
					<tbody>
						<tr style="display:none"><td colspan="4"></td></tr>
						<tr rownum=0 <?php if(count($TPL_VAR["issuegoods"])== 0){?>class="show"<?php }else{?>class="hide"<?php }?>>
							<td colspan="4">상품을 선택하세요</td>
						</tr><!-- issueGoods, issueGoodsSeq  ==> select_goods_list -->
					</tbody>
				</table>
			</div>
			<div id="broadcastGoodsSelect"></div>
			<ul class="bullet_hyphen resp_message">
				<li>상품은 최대 10개까지 선택 가능합니다.</li>
			</ul>
		</div>
	</div>

	<div class="footer" >
		<button type="submit" class="resp_btn active size_XL">저장</button>
		<button type="button" class="btnLayClose resp_btn v3 size_XL" onclick="closeDialog('broadcast_regist_layout')">닫기</button>
	</div>
</form>
</div>

<div id="lay_goods_select" class="hide"></div><!-- 상품선택 레이어 -->