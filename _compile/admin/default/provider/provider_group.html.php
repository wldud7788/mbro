<?php /* Template_ 2.2.6 2022/05/17 12:36:50 /www/music_brother_firstmall_kr/admin/skin/default/provider/provider_group.html 000013027 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_list_month_1=empty($TPL_VAR["list_month"])||!is_array($TPL_VAR["list_month"])?0:count($TPL_VAR["list_month"]);
$TPL_list_term_1=empty($TPL_VAR["list_term"])||!is_array($TPL_VAR["list_term"])?0:count($TPL_VAR["list_term"]);
$TPL_list_day_1=empty($TPL_VAR["list_day"])||!is_array($TPL_VAR["list_day"])?0:count($TPL_VAR["list_day"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<style type="text/css">
.gray-title {background:#f9f9f9;}
</style>
<script type="text/javascript">

$(document).ready(function() {

	$(".modifyButton").click(function(){
		var seq = $(this).attr("seq");
		document.location.href = "provider_group_reg?pgroup_seq="+seq;
	});

	// 등급삭제
	$(".deleteButton").bind("click",function(){
		var checkedCount = $("input:[name='pgroup_seq[]']:checked").length;
		if ( checkedCount == 0 ) {
			alert('하나 이상을 체크하여 주십시오.');
			return false;
		} else {
			var tmp = 0;
			$("input:[name='pgroup_seq[]']").each(function(){
				if($(this).attr("checked")){
					if($(this).attr("member")>0) tmp++;
				}
			});
			if(tmp>0){
				alert("삭제하시려는 그룹에 입점사가 존재합니다.\n입점사 그룹 이동 후 삭제해 주세요.");
				return;
			}
			if(confirm('그룹을 삭제 하시겠습니까?')) {
				$("input[name='pgrade_mode']").val('deleteGrade');
				$("form[name='providerForm']").submit();
			}
		}
	});


	$(".chkAll").bind("click",function(e){
		var obj		= $(this).attr("val");

		if($(this).attr("checked") == "checked"){
			var chked = true;
		}else{
			var chked = false;
		}
		var list	= $("input:[name='"+obj+"[]']");
		$.each(list,function(idx,chk){ 
			if($(chk).attr("disabled") != "disabled") $(chk).attr("checked",chked); 
		});

	});	
	

	$("#grade_submit").click(function(){
		$("input[name='pgrade_mode']").val('autoGradeUpdate');
		$("form[name='providerForm']").submit();

	});


	$(".chgAutoGrade").change(function(){
		calcu_month();
	});

	/* 수동등급갱신 */
	$(".btnGroupChange").click(function(){
		if(confirm("다음 등급 조정일 기준으로 갱신 됩니다.")){
			$("input[name='pgrade_mode']").val('manual_group_update');
			$("form[name='providerForm']").submit();
		}
	});

	$("#chg_grade").click(function(){		
		if($(".content").css("display")=='table'){
			$(".content").hide();	
		}else{
			$(".content").show();		
		}		
	});
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
		},
		error: function(e){
			//debug(e.responseText);
		}
	});	
}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>입점사 등급</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">			
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->
<form name="providerForm" id="providerForm" method="post" action="../provider_process/provider_group_modify" target="actionFrame">
<input type="hidden" name="pgrade_mode"/>
<input type="hidden" name="gcount" id="gcount" value="<?php echo $TPL_VAR["gcount"]?>"/>

<div class="contents_container">
	
	<div class="item-title">
		등급 정책
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/provider', '#tip1')"></span>
	</div>		

	<div class="table_row_frame">	
		<div class="dvs_top">	
			<div class="dvs_left">
				<button type="button" class="deleteButton resp_btn v3">선택 삭제</button>	
			</div>
			<div class="dvs_right">	
				<button type="button" onclick="document.location.href='provider_group_reg'" class="resp_btn active fr">등급 등록</button>		
			</div>
		</div>
		<table class="table_row_basic">
		<colgroup>
			<col width="8%" />
			<col width="8%" />
			<col width="8%" />
			<col width="13%" />
			<col width="13%" />
			<col width="13%" />
			<col width="14%" />
			<col width="15%" />
			<col width="8%" />
		</colgroup>
		<thead>
		<tr>
			<th rowspan="2"><label class="resp_checkbox"><input type="checkbox" class="chkAll hand" val='pgroup_seq'></label></th>
			<th rowspan="2">자동관리</th>
			<th rowspan="2">등급</th>
			<th colspan="3">선정기준</th>
			<th rowspan="2">현재통계</th>
			<th rowspan="2">생성일시</th>
			<th rowspan="2">관리</th>
		</tr>
		<tr>
			<!-- 선정기준 -->
			<th class="bdr_top">누적 실 결제 금액</th>
			<th class="bdr_top">상품 구매 개수</th>
			<th class="bdr_top">주문 횟수</th>
		</tr>
		</thead>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td><label class="resp_checkbox"><input type="checkbox" value="<?php echo $TPL_V1["pgroup_seq"]?>" <?php if($TPL_V1["pgroup_seq"]== 1){?>disabled<?php }?> name="pgroup_seq[]" class="pgroup_seq" member="<?php echo $TPL_V1["count"]?>"></label></td>
			<td>
<?php if($TPL_V1["use_type"]=='auto1'||$TPL_V1["use_type"]=='auto2'){?><img src="/admin/skin/default/images/common/thumb_auto.gif" align="absmiddle"><?php }else{?><img src="/admin/skin/default/images/common/thumb_passive.gif" align="absmiddle"><?php }?>
			</td>
			<td><?php echo $TPL_V1["pgroup_name"]?></td>
<?php if($TPL_V1["use_type"]=='auto1'||$TPL_V1["use_type"]=='auto2'){?>
			<!-- 선정기준 -->
			<td>
				
<?php if(in_array('price1',$TPL_V1["order_sum_use"])||in_array('price2',$TPL_V1["order_sum_use"])){?>
					<?php echo number_format($TPL_V1["order_sum_price"])?>원 이상
<?php }else{?> - <?php }?>
				
			</td>
			<td>
				
<?php if(in_array('ea1',$TPL_V1["order_sum_use"])||in_array('ea2',$TPL_V1["order_sum_use"])){?>
					<?php echo number_format($TPL_V1["order_sum_ea"])?>개 이상
<?php }else{?> - <?php }?>
				
			</td>
			<td>
				
<?php if(in_array('cnt1',$TPL_V1["order_sum_use"])||in_array('cnt2',$TPL_V1["order_sum_use"])){?>
					<?php echo number_format($TPL_V1["order_sum_cnt"])?>회 이상
<?php }else{?> - <?php }?>
				
			</td>
<?php }else{?>
			<td colspan="3">수동으로 관리되는 등급</td>
<?php }?>
			<td><?php echo number_format($TPL_V1["count"])?>개 업체 (<?php if($TPL_V1["count"]){?><?php echo round($TPL_V1["count"]/$TPL_VAR["tot"]* 100, 2)?><?php }else{?>0<?php }?>%)</td>
			<td><?php echo $TPL_V1["update_date"]?></td>
			<td><button type="button" class="modifyButton resp_btn v2" seq="<?php echo $TPL_V1["pgroup_seq"]?>">수정</button></td>
		</tr>
<?php }}?>
<?php }else{?>
		<tr>
			<td colspan="9" >등록된 입점사 등급이 없습니다.</td>
		</tr>
<?php }?>
		</table>

		<div class="dvs_bottom">	
			<div class="dvs_left">
				<button type="button" class="deleteButton resp_btn v3">선택 삭제</button>	
			</div>
			<div class="dvs_right">	
				<button type="button" onclick="document.location.href='provider_group_reg'" class="resp_btn active fr">등급 등록</button>
			</div>
		</div>
	</div>


	<div class="title_dvs">		
		<div class="item-title">자동 등급조정(갱신) 설정</div>
		<div class="sub_message">현재 다음 등급 조정일은 <?php if($TPL_VAR["clone"]["start_month"]){?> <span class="bold"><?php echo $TPL_VAR["auto_result"]["next_grade_date"]?></span>입니다.<?php }else{?>다음 등급 조정일은 없습니다.<?php }?> 수동으로 관리하는 등급의 경우 자동으로 등급이 조정 되지 않습니다.</div>		
		<button type="button" id="grade_submit" class="resp_btn active">저장</button>
	</div>
	
	<table class="table_basic thl">		
		<tr>
			<th>등급 조정 (갱신)일</th>
			<td class="clear">
				<ul class="ul_list_04">
					<li>
						등급 기준 월 
						<select name="start_month" class="chgAutoGrade">
<?php if($TPL_list_month_1){foreach($TPL_VAR["list_month"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["clone"]["start_month"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?>월</option>
<?php }}?> 
						</select>						
					</li>
					<li>
						등급 조정 주기
						<select name="chg_term" class="chgAutoGrade">
<?php if($TPL_list_term_1){foreach($TPL_VAR["list_term"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["clone"]["chg_term"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?>개월마다</option>
<?php }}?>
						</select>
					</li>
					<li>
					해당 월 
					<select name="chg_day" class="chgAutoGrade">
<?php if($TPL_list_day_1){foreach($TPL_VAR["list_day"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["clone"]["chg_day"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?>일</option>
<?php }}?>
					</select>
					</li>
				</ul>

				<table class="table_02 content hide">
					<col width="50%" /> <col width="50%" />
					<tr>
						<td>
							<span id="chg_text">
								<ul>
<?php if(is_array($TPL_R1=$TPL_VAR["auto_result"]["chg_text"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
									<li><?php echo $TPL_V1?></li>
<?php }}?>
								</ul>
							</span>
						</td>
						<td>새벽 2시</td>
					</tr>
				</table>	
			</td>
		</tr>
		
		<tr>
			<th>
				선정 기간
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/provider', '#tip2')"></span>
			</th>
			<td  class="clear">
				<ul class="ul_list_04">
					<li>
						최근
						<select name="chk_term" class="chgAutoGrade">
<?php if($TPL_list_term_1){foreach($TPL_VAR["list_term"] as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["clone"]["chk_term"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?>개월간</option>
<?php }}?>
						</select>
					</li>
				</ul>

				<table class="table_02 content hide">
					<col width="50%" /> <col width="50%" />
					<tr>
						<td>
							<span id="chk_text">
								<ul>
<?php if(is_array($TPL_R1=$TPL_VAR["auto_result"]["chk_text"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
									<li><?php echo $TPL_V1?></li>
<?php }}?>
								</ul>
							</span>
						</td>
						<td>사이의 선정 기준 계산</td>
					</tr>
				</table>	
			</td>
		</tr>

		<tr>
			<th>등급 유지 보장 기간</th>
			<td  class="clear">
				<ul class="ul_list_04">
					<li>
						등급 조정일로부터
						<select name="keep_term" class="chgAutoGrade">
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
						<td>
							<span id="keep_text">
								<ul>
<?php if(is_array($TPL_R1=$TPL_VAR["auto_result"]["keep_text"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
									<li><?php echo $TPL_V1?></li>
<?php }}?>
								</ul>
							</span>
						</td>
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


</form>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>