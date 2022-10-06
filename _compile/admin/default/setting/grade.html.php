<?php /* Template_ 2.2.6 2022/05/17 12:36:56 /www/music_brother_firstmall_kr/admin/skin/default/setting/grade.html 000013701 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<!-- 회원설정 : 등급 -->
<script type="text/javascript">
$(document).ready(function() {
    // 등급만들기
    $("#reg_grade").bind("click",function(event){
		formMove('grade_write',4);
    });
	// 등급수정
	$(".modifyButton").bind("click",function(){
		location.href = "/admin/setting/member?grade=modify&seq="+$(this).attr('seq');
	});
	// 등급삭제
	$(".deleteButton").bind("click",function(){
		var checkedCount = $("input:[name='group_seq[]']:checked").length;
		if ( checkedCount == 0 ) {
			alert('하나 이상을 체크하여 주십시오.');
			return false;
		} else {
			var tmp = 0;
			$("input:[name='group_seq[]']").each(function(){
				if($(this).attr("checked")){
					if($(this).attr("member")>0) tmp++;
				}
			});
			if(tmp>0){
				alert("삭제하시려는 등급에 회원이 존재합니다.\n회원 이동 후 삭제해 주세요.");
				return;
			}
			if(confirm('등급을 삭제 하시겠습니까?')) {
				$("input[name='grade_mode']").val('deleteGrade');
				$("form[name='memberForm']").submit();
			}
		}
	});

	$("#grade_submit").click(function(){
		$("form[name='memberForm']").submit();
	});


	$("select[name='start_month']").change(function(){
		calcu_month();
	});
	$("select[name='chg_term']").change(function(){
		calcu_month();
	});
	$("select[name='chg_day']").change(function(){
		calcu_month();
	});
	$("select[name='chk_term']").change(function(){
		calcu_month();
	});
	$("select[name='keep_term']").change(function(){
		calcu_month();
	});

	
	$("#chg_grade").click(function(){		
		if($(".content").css("display")=='table'){
			$(".content").hide();	
		}else{
			$(".content").show();		
		}		
	});

	/*
	$("select[name='grade_chg_term']").val(['<?php echo $TPL_VAR["clone"]["chg_term"]?>']);
	$("select[name='grade_chg_day']").val(['<?php echo $TPL_VAR["clone"]["chg_day"]?>']);
	$("select[name='grade_chk_term']").val(['<?php echo $TPL_VAR["clone"]["chk_term"]?>']);
	$("select[name='grade_keep_term']").val(['<?php echo $TPL_VAR["clone"]["keep_term"]?>']);
	*/
});


function calcu_month(){
	var start_month		= $("select[name='start_month']").val();
	var chg_term		= $("select[name='chg_term']").val();
	var chg_day			= $("select[name='chg_day']").val();
	var chk_term		= $("select[name='chk_term']").val();
	var keep_term		= $("select[name='keep_term']").val();
	var chg_text		= "";
	var chk_text		= "";
	var keep_text		= "";
	var gdata = 'start_month='+start_month;
	gdata += '&chg_term='+chg_term;
	gdata += '&chg_day='+chg_day;
	gdata += '&chg_term='+chg_term;
	gdata += '&chk_term='+chk_term;
	gdata += '&keep_term='+keep_term;
	
	$.ajax({
		type: "get",
		url: "grade_ajax",
		data: gdata,
		dataType: 'json',
		success: function(data){
			$("#chg_text").html(data.chg_text);
			$("#chk_text").html(data.chk_text);
			$("#keep_text").html(data.keep_text);
			$("#keep_term_msg").html(keep_term);			
		}
	});
	
}
</script>

<?php if(serviceLimit('H_FR')){?>
<div class="box_style_02 mb15">	
	무료몰+ : 회원 등급(그룹)은 ‘4단계’까지 가능합니다.<br/>
	회원 등급이 5단계 이상인 쇼핑몰을 운영하시려면 프리미엄몰+ 또는 독립몰+로 업그레이드 하시길 바랍니다.	
	<a href="#" class="hand btn_resp" onclick="serviceUpgrade();">업그레이드</a>	
</div>
<?php }?>

<div class="contents_dvs">
	<div class="title_dvs">
		<div class="item-title">
			등급 정책
			<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip13')"></span>
		</div>	
<?php if($TPL_VAR["gcount"]>= 4&&serviceLimit('H_FR')){?>		
		<button type="button" class="resp_btn active <?php echo serviceLimit('C1')?>" onclick="<?php echo serviceLimit('A2')?>">등급 등록</button>		
<?php }else{?>	
		<button type="button" class="resp_btn active" id="reg_grade">등급 등록</button>	
<?php }?>
	</div>

	<input type="hidden" name="grade_mode"/>
	<input type="hidden" name="gcount" id="gcount" value="<?php echo $TPL_VAR["gcount"]?>"/>

	<table width="100%" class="table_basic">
		<col width="50" /><col /><col /><col /><col /><col/><col /><col /><col/><col /><col /><col /><col />
		<thead>
		<tr>
			<th rowspan="2"><input type="checkbox" onclick="chkAll(this,'group_seq');"></th>
			<th rowspan="2">자동관리</th>
			<th rowspan="2">등급</th>
			<th colspan="3">선정기준</th>
			<th rowspan="2">현재통계</th>
			<th rowspan="2">생성일시</th>
			<th rowspan="2">관리</th>
		</tr>
		
		<tr>
			<!-- 선정기준 -->
			<th>누적 실결제금액</th>
			<th>상품구매개수</th>
			<th>주문횟수</th>
			<!-- 혜택 -->
			<!--
			<th>마일리지</th>
			<th>배송비</th>
			-->
		</tr>
		</thead>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td class="center"><input type="checkbox" value="<?php echo $TPL_V1["group_seq"]?>" <?php if($TPL_V1["group_seq"]== 1){?>disabled<?php }?> name="group_seq[]" class="group_seq" member="<?php echo $TPL_V1["count"]?>"></td>
			<td class="center"><?php if($TPL_V1["use_type"]=='AUTO'||$TPL_V1["use_type"]=='AUTOPART'){?><img src="/admin/skin/default/images/common/thumb_auto.gif" align="absmiddle"><?php }else{?><img src="/admin/skin/default/images/common/thumb_passive.gif" align="absmiddle"><?php }?></td>
			<td><?php if($TPL_V1["icon"]){?><img class="icons" src="../../data/icon/common/<?php echo $TPL_V1["icon"]?>?dummy=<?php echo date('YmdHis')?>" align="absmiddle"><?php }?> <?php echo $TPL_V1["group_name"]?></td>
<?php if($TPL_V1["use_type"]=='AUTO'||$TPL_V1["use_type"]=='AUTOPART'){?>
			<!-- 선정기준 -->
			<td><?php if(in_array('price',$TPL_V1["order_sum_arr"])){?><?php echo number_format($TPL_V1["order_sum_price"])?>원 이상<?php }else{?>-<?php }?></td>
			<td><?php if(in_array('ea',$TPL_V1["order_sum_arr"])){?><?php echo number_format($TPL_V1["order_sum_ea"])?>건 이상<?php }else{?>-<?php }?></td>
			<td><?php if(in_array('cnt',$TPL_V1["order_sum_arr"])){?><?php echo number_format($TPL_V1["order_sum_cnt"])?>회 이상<?php }else{?>-<?php }?></td>
<?php }else{?>
			<td colspan="3"><?php if($TPL_V1["group_seq"]== 1){?>신규가입 시<?php }else{?>수동으로 관리되는 등급<?php }?></td>
<?php }?>
			<!-- 혜택 -->
			<!--
			<td class="center"><?php if($TPL_V1["add_point"]> 0){?>Y<?php }else{?>N<?php }?></td>
			<td class="center"><?php if($TPL_V1["add_delivery"]> 0){?>Y<?php }else{?>N<?php }?></td>
			-->
			<td class="center"><?php echo number_format($TPL_V1["count"])?>명 (<?php if($TPL_V1["count"]){?><?php echo round($TPL_V1["count"]/$TPL_VAR["tot"]* 100, 2)?><?php }else{?>0<?php }?>%)</td>
			<td class="center"><?php echo $TPL_V1["regist_date"]?></td>
			<td class=" center">				
				<button type="button" class="modifyButton resp_btn v2" seq="<?php echo $TPL_V1["group_seq"]?>">수정</button>					
			</td>
		</tr>
<?php }}?>
	</table>	
	<button type="button" class="deleteButton hand resp_btn v3 mt5">삭제</button>
</div>

<div class="contents_dvs">
	<div class="title_dvs">
		<div class="item-title">자동 등급조정(갱신) 설정</div>
		<div class="sub_message"><span>현재 다음 등급 조정일은<?php if($TPL_VAR["clone"]["start_month"]){?><b><?php echo $TPL_VAR["result"]["next_grade_date"]?></b><?php }else{?><?php }?>입니다. 수동으로 관리하는 등급의 경우 자동으로 등급이 조정 되지 않습니다.</span></div>	
		<button type="button" id="grade_submit" class="resp_btn active">저장</button>	
	</div>
	<table class="table_basic thl">
		<tr>
			<th>등급 조정 (갱신)일</th>
			<td class="clear">
				<ul class="ul_list_04">
					<li>
						등급 기준 월
						<select name="start_month" >
							<option value="1" <?php if($TPL_VAR["clone"]["start_month"]=='1'){?>selected<?php }?>>1월</option>
							<option value="2" <?php if($TPL_VAR["clone"]["start_month"]=='2'){?>selected<?php }?>>2월</option>
							<option value="3" <?php if($TPL_VAR["clone"]["start_month"]=='3'){?>selected<?php }?>>3월</option>
							<option value="4" <?php if($TPL_VAR["clone"]["start_month"]=='4'){?>selected<?php }?>>4월</option>
							<option value="5" <?php if($TPL_VAR["clone"]["start_month"]=='5'){?>selected<?php }?>>5월</option>
							<option value="6" <?php if($TPL_VAR["clone"]["start_month"]=='6'){?>selected<?php }?>>6월</option>
							<option value="7" <?php if($TPL_VAR["clone"]["start_month"]=='7'){?>selected<?php }?>>7월</option>
							<option value="8" <?php if($TPL_VAR["clone"]["start_month"]=='8'){?>selected<?php }?>>8월</option>
							<option value="9" <?php if($TPL_VAR["clone"]["start_month"]=='9'){?>selected<?php }?>>9월</option>
							<option value="10" <?php if($TPL_VAR["clone"]["start_month"]=='10'){?>selected<?php }?>>10월</option>
							<option value="11" <?php if($TPL_VAR["clone"]["start_month"]=='11'){?>selected<?php }?>>11월</option>
							<option value="12" <?php if($TPL_VAR["clone"]["start_month"]=='12'){?>selected<?php }?>>12월</option>
						</select>
					</li>
					<li>
						등급 조정 주기
						<select name="chg_term">
							<option value="1" <?php if($TPL_VAR["clone"]["chg_term"]=='1'){?>selected<?php }?>>1개월마다</option>
							<option value="3" <?php if($TPL_VAR["clone"]["chg_term"]=='3'){?>selected<?php }?>>3개월마다</option>
							<option value="6" <?php if($TPL_VAR["clone"]["chg_term"]=='6'){?>selected<?php }?>>6개월마다</option>
							<option value="12" <?php if($TPL_VAR["clone"]["chg_term"]=='12'){?>selected<?php }?>>12개월마다</option>
							<option value="18" <?php if($TPL_VAR["clone"]["chg_term"]=='18'){?>selected<?php }?>>18개월마다</option>
							<option value="24" <?php if($TPL_VAR["clone"]["chg_term"]=='24'){?>selected<?php }?>>24개월마다</option>
							<option value="36" <?php if($TPL_VAR["clone"]["chg_term"]=='36'){?>selected<?php }?>>36개월마다</option>
						</select>
					</li>
					<li>
						해당 월
						<select name="chg_day">
							<option value="1" <?php if($TPL_VAR["clone"]["chg_day"]=='1'){?>selected<?php }?>>1일</option>
							<option value="15" <?php if($TPL_VAR["clone"]["chg_day"]=='15'){?>selected<?php }?>>15일</option>
						</select>
					</li>
				</ul>

				<table class="table_02 content hide">
					<col width="50%" /> <col width="50%" />
					<tr>
						<td><div id="chg_text"><?php echo $TPL_VAR["result"]["chg_text"]?></div></td>
						<td>새벽 2시</td>
					</tr>
				</table>			
			</td>
		</tr>
		<tr>
			<th>
				선정 기간
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip28')"></span>
			</th>
			<td class="clear">
				<ul class="ul_list_04">
					<li>
						최근
						<select name="chk_term">
							<option value="1" <?php if($TPL_VAR["clone"]["chk_term"]=='1'){?>selected<?php }?>>1개월간</option>
							<option value="3" <?php if($TPL_VAR["clone"]["chk_term"]=='3'){?>selected<?php }?>>3개월간</option>
							<option value="6" <?php if($TPL_VAR["clone"]["chk_term"]=='6'){?>selected<?php }?>>6개월간</option>
							<option value="12" <?php if($TPL_VAR["clone"]["chk_term"]=='12'){?>selected<?php }?>>12개월간</option>
							<option value="18" <?php if($TPL_VAR["clone"]["chk_term"]=='18'){?>selected<?php }?>>18개월마다</option>
							<option value="24" <?php if($TPL_VAR["clone"]["chk_term"]=='24'){?>selected<?php }?>>24개월마다</option>
							<option value="36" <?php if($TPL_VAR["clone"]["chk_term"]=='36'){?>selected<?php }?>>36개월마다</option>
						</select>
					</li>
				</ul>

				<table class="table_02 content hide">
					<col width="50%" /> <col width="50%" />
					<tr>
						<td><span id="chk_text"><?php echo $TPL_VAR["result"]["chk_text"]?></span></td>
						<td>사이의 선정 기준 계산</td>
					</tr>
				</table>			
			</td>
		</tr>
		<tr>
			<th>등급 유지 보장 기간</th>
			<td class="clear">
				<ul class="ul_list_04">
					<li>
						등급 조정일부터
						<select name="keep_term">
							<option value="1" <?php if($TPL_VAR["clone"]["keep_term"]=='1'){?>selected<?php }?>>1개월간</option>
							<option value="3" <?php if($TPL_VAR["clone"]["keep_term"]=='3'){?>selected<?php }?>>3개월간</option>
							<option value="6" <?php if($TPL_VAR["clone"]["keep_term"]=='6'){?>selected<?php }?>>6개월간</option>
							<option value="12" <?php if($TPL_VAR["clone"]["keep_term"]=='12'){?>selected<?php }?>>12개월간</option>
							<option value="18" <?php if($TPL_VAR["clone"]["keep_term"]=='18'){?>selected<?php }?>>18개월마다</option>
							<option value="24" <?php if($TPL_VAR["clone"]["keep_term"]=='24'){?>selected<?php }?>>24개월마다</option>
							<option value="36" <?php if($TPL_VAR["clone"]["keep_term"]=='36'){?>selected<?php }?>>36개월마다</option>
						</select>	
					</li>
				</ul>

				<table class="table_02 content hide">
					<col width="50%" /> <col width="50%" />
					<tr>
						<td><span id="keep_text"><?php echo $TPL_VAR["result"]["keep_text"]?></span></td>
						<td>동안 유지</td>
					</tr>
				</table>			
			</td>
		</tr>
	</table>

	<div class="center mt15">
		<button type="button" id="chg_grade" class="resp_btn" >자세히보기</button>	
	</div>
</div>

<div id="gradePopup"></div>