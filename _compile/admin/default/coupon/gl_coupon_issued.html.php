<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/coupon/gl_coupon_issued.html 000004269 */ ?>
<!---
	회원 및 회원등급 지정하여 쿠폰 및 프로모션 발급 
	issued_type : promotion, coupon
-->
<script type="text/javascript" src="/app/javascript/js/admin/gMemberGradeSelectList.js?mm=20200601"></script>
<script type="text/javascript" src="/app/javascript/js/admin/gMemberSelectList.js?mm=202006011911"></script>

<style>
#target_container {width:95%; border: 1px dotted #2EA4C0; height: 150px; margin: 5px 0; padding: 5px 10px; overflow-y: auto; line-height:14px;}
</style>

<div style="height:500px;" class="content">
	<div class="item-title"><?php echo $TPL_VAR["issued_name"]?> 정보</div>
	<table class="table_basic thl">
	<tbody>
		<tr>
			<th><?php echo $TPL_VAR["issued_name"]?>명</th>
			<td class="bold issued_title_name"></td>
		</tr>
		<tr <?php if($TPL_VAR["issued_type"]!="promotion"){?>class="hide"<?php }?>>
			<th>발급 건수</th>
			<td><span id="dlwrite_4" ></span></td>			
		</tr>
		<tr>
			<th><?php if($TPL_VAR["issued_type"]!="promotion"){?>상품 <?php }?>최소 주문 금액</th>
			<td><span id="dlwrite_1" ></span></td>
		</tr>
		<tr>
			<th>유효 기간</th>
			<td><span id="dlwrite_2" ></span></td>
		</tr>
		<tr>
			<th>혜택</th>
			<td><span id="dlwrite_3" ></span></td>
		</tr>
	</tbody>
	</table>

	<form name="downloadwriteform" method="post">
	<input type="hidden" name="no"		value="<?php echo $TPL_VAR["issued_seq"]?>" >
	<input type="hidden" name="issued_title_name" value="" >
	<input type="hidden" name="search_type" id="search_type" value="" >
	<input type="hidden" name="serialize"	id="serialize" value="" >

	<div class="item-title">발급 대상</div>
	<table class="table_basic thl tb_target">
	<tbody>
		<tr>
			<th>발급대상선택</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="target_type" value="all" checked/> <span id="downloadmbtotalcountlay" >전체 회원 <?php echo $TPL_VAR["member_total_count"]?>명</span></label>
					<label><input type="radio" name="target_type" value="member_grade" /> 회원 등급</label>
					<label><input type="radio" name="target_type" value="member_select" /> 회원 선택</label>
				</div>
			</td>
		<tr>
		<tr class='t_target t_member_grade'>
			<th>회원 등급 선택</th>
			<td><input type="button" onClick="gMemberGradeSelect.open({'issued_seq':'<?php echo $TPL_VAR["issued_seq"]?>','issued_type':'<?php echo $TPL_VAR["issued_type"]?>','autoCloase':true,'divSelectLay':'lay_issued_member_grade','select_lists':'memberGroups[]','parentsDivLay':'lay_coupon_issued'},gCouponIssued.callbackSetMemberGrade)" class="resp_btn v2" value="선택" /></td>
		</tr>
		<tr class='t_target t_member_grade'>
			<th>선택 등급</td>
			<td><div id="groupsMsg">발급할 회원등급을 선택해 주세요.</div></td>
		</tr>
		<tr class='t_target t_member_select'>
			<th>회원 선택</td>
			<td><input type="button" class="resp_btn v2" onClick="gMemberSelect.open({'autoCloase':true,'issued_seq':'<?php echo $TPL_VAR["issued_seq"]?>','issued_type':'<?php echo $TPL_VAR["issued_type"]?>','divSelectLay':'lay_issued_member','parentsDivLay':'lay_<?php echo $TPL_VAR["issued_type"]?>_issued'})" value="회원 검색" /></td>
		</tr>
		<tr class='t_target t_member_select'>
			<th>선택 회원</td>
			<td><input type="hidden" name="target_member" id="target_member" value="">
				선택회원 : <span id="member_search_count">0</span> 명
				<div id="target_container"></div></td>
		</tr>
		</table>
		</td>
		</tr>
	</tbody>
	</table>
<?php if($TPL_VAR["issued_type"]=="promotion"){?>
	<div class="resp_message">- 프로모션 코드 발급 대상이 선착순인 경우 전체 회원, 회원 등급으로 회원 선택이 불가합니다. </div>
<?php }?>
	</form>
</div>

<div class="footer">
	<button type="button" class="confirmSelectIssued resp_btn active size_XL">발급</button>
	<button type="button" class="btnLayClose resp_btn v3 size_XL">취소</button>
</div>

<div id="lay_issued_member"></div>
<div id="lay_issued_member_grade"></div><!-- 회원 등급 선택 레이어 -->