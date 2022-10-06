<?php /* Template_ 2.2.6 2021/12/15 16:50:22 /www/music_brother_firstmall_kr/data/skin/responsive_sports_sporti_gl/goods/hop_calendar_pop.html 000005119 */ 
$TPL_calendar_1=empty($TPL_VAR["calendar"])||!is_array($TPL_VAR["calendar"])?0:count($TPL_VAR["calendar"]);?>
<script type="text/javascript">
var now_year		= <?php echo $TPL_VAR["sel_date"]["year"]?>;
var now_month		= <?php echo $TPL_VAR["sel_date"]["month"]?>;
var sel_day			= '<?php echo $TPL_VAR["required_day"]?>';
var hop_select_date = '<?php echo $TPL_VAR["hop_select_date"]?>';
$(document).ready(function(){
	// 이전 월
	$(".prev").bind('click',function(){
		var year = null;
		var month = null;
		if(now_month == 1){
			year	= now_year - 1;
			month	= 12;
		}else{
			year	= now_year;
			month	= now_month - 1;
		}
		move_calendar(year, month);
	});
	// 다음 월
	$(".next").bind('click',function(){
		var year = null;
		var month = null;
		if(now_month == 12){
			year	= now_year + 1;
			month	= 1;
		}else{
			year	= now_year;
			month	= now_month + 1;
		}
		move_calendar(year, month);
	});

	if(sel_day > 0){
		$(".day_"+sel_day).addClass('selected');
	}
});

// 년/월 변경
function move_calendar(year, month){
	$.ajax({
		'url' : '/goods/hop_calendar_pop',
		'data' : {'grp_seq':'<?php echo $TPL_VAR["set_info"]["shipping_group_seq"]?>','set_seq':'<?php echo $TPL_VAR["set_info"]["shipping_set_seq"]?>','hop_select_date':hop_select_date,'year':year,'month':month},
		'success' : function(html){
			if(html){
				$(".hopCalendarLayer").html(html);
			}
		}
	});
}

// 날짜 클릭시 동작
function click_day(day){
	$(".tbdate").removeClass('selected');
	$(".day_"+day).addClass('selected');
	sel_day = day;
}

// 최종 날짜 선택
function select_day(){
	if(sel_day > 0 || hop_select_date){
		var confirm_date = hop_select_date;
		if(sel_day > 0)	confirm_date = now_year + '-' + pad_zero(now_month,2,'left') + '-' + pad_zero(sel_day,2,'left');

		$("#hop_select_date").val(confirm_date);
		chg_hopdate(confirm_date);
		if($(".hop_date_txt").length > 0){
			$(".hop_date_txt").html('선택된 일자 : ' + confirm_date);
		}
		closeCalendar();
	}else{
		alert('선택된 날짜가 없습니다.');
	}
}

function chg_hopdate(hop_date){
	$("#hop_select_date").val(hop_date);
	var myDate = new Date(hop_date);
	$(".hop_view_date").html('(' + (myDate.getMonth()+1) + '/' + myDate.getDate() + ')');
}

// 날짜 선택 안함
function delete_day(){
	$(".tbdate").removeClass('selected');
	sel_day			= '';
	hop_select_date	= '';
	$("#hop_select_date").val('');
	$(".hop_view_date").html('(미선택)');
	if($(".hop_date_txt").length > 0){
		$(".hop_date_txt").html('미지정');
	}
	closeCalendar();
}

// 배송일 팝업 닫기
function closeCalendar(){
	$(".hopCalendarLayer").hide();
	var that = $(".calendarBtn");
	detail_contents_toggle(that,'deliverydateDetail');
}
</script>
<div class="layer_wrap">
	<div class="layer_inner">
		<div class="calendar_title">
			<span class="prev">◀</span> <span class="txt"><?php echo $TPL_VAR["sel_date"]["year"]?>년 <?php echo $TPL_VAR["sel_date"]["month"]?>월</span> <span class="next">▶</span>
		</div>
<?php if($TPL_VAR["calendar"]){?>
		<div class="calendar_lay">
			<table class="tb_timetable">
			<thead>
			<tr>
				<th class="center">일</th>
				<th class="center">월</th>
				<th class="center">화</th>
				<th class="center">수</th>
				<th class="center">목</th>
				<th class="center">금</th>
				<th class="center">토</th>
			</tr>
			</thead>
			<tbody>
			<tr>
<?php if($TPL_calendar_1){foreach($TPL_VAR["calendar"] as $TPL_K1=>$TPL_V1){?>
				<td class="tbdate day_<?php echo $TPL_V1["day"]?> <?php if($TPL_V1["pos"]=='Y'){?>selectable<?php }?>" <?php if($TPL_V1["pos"]=='Y'){?>onclick="click_day('<?php echo $TPL_V1["day"]?>');"<?php }?>>
					<span class="dateLay"><?php if($TPL_V1["day"]> 0){?><?php echo $TPL_V1["day"]?><?php }?></span>
				</td>
<?php if(($TPL_K1% 7)== 0&&$TPL_K1<count($TPL_VAR["calendar"])){?>
			</tr><tr>
<?php }?>
<?php }}?>
			</tr>
			</tbody>
			</table>
		</div>
<?php }?>
<?php if($TPL_VAR["set_info"]["hop_use"]=='Y'){?>
		<div class="pdt5">※ 배송가능일자를 선택하세요. <?php if($TPL_VAR["set_info"]["hopeday_required"]=='Y'){?>(필수사항)<?php }else{?>(선택사항)<?php }?></div>
<?php }?>
<?php if($TPL_VAR["set_info"]["today_use"]=='Y'){?>
		<div>
			<p>※ 오늘 <?php echo substr($TPL_VAR["set_info"]["hopeday_limit_val"], 0, 2)?>시<?php echo substr($TPL_VAR["set_info"]["hopeday_limit_val"], 2, 2)?>분 이전 주문 시 당일배송 가능</p>
		</div>
<?php }?>
		<div class="btn_area_a">
<?php if($TPL_VAR["set_info"]["hopeday_required"]=='N'){?>
			<button type="button" class="btn_style small" onclick="delete_day();">선택하지 않음</button>
<?php }?>
			<button type="button" class="btn_style small blue" onclick="select_day();">선택</button>
		</div>
	</div>
	<a href="javascript:;" onclick="closeCalendar();" class="btn_close_x">X</a>
</div>