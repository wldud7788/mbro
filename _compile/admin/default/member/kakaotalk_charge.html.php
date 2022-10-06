<?php /* Template_ 2.2.6 2022/05/17 12:36:27 /www/music_brother_firstmall_kr/admin/skin/default/member/kakaotalk_charge.html 000003742 */ 
$TPL_log_list_1=empty($TPL_VAR["log_list"])||!is_array($TPL_VAR["log_list"])?0:count($TPL_VAR["log_list"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	$(document).ready(function() {
		$('#kakaotalk_charge').on('click', function (){
			$.get('kakaotalk_payment', function(data) {
				$('#kakaotalkPopup').html(data);
				openDialog("SMS/카카오 알림톡 충전 <span class='desc'>&nbsp;</span>", "kakaotalkPopup", {"width":"1200","height":"800"});
			});
		});
	});
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>카카오 알림톡</h2>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">

<?php $this->print_("top_menu",$TPL_SCP,1);?>


	<!-- 서브 레이아웃 영역 : 시작 -->
	<!-- 알림톡충전 영역 :: START -->
	<div class="item-title">알림톡 현황</div>
	<table class="table_basic thl">		
		<tr>
			<th>현황</th>
			<td>알림톡 : <?php echo number_format($TPL_VAR["kakaotalk_count"])?> 건 / SMS : <?php echo number_format($TPL_VAR["sms_count"])?> 건</td>
		</tr>	
		
		<tr>
			<th>알림톡 충전</th>
			<td>
<?php if($TPL_VAR["kakaotalk_config"]["authKey"]){?>
				<button type="button" id="kakaotalk_charge" class="resp_btn active">충전</button>
<?php }else{?>
				<button type="button" onclick="alert('먼저 알림톡을 신청 후 충전 해 주세요.');" class="resp_btn active">충전</button>
<?php }?>
			</td>
		</tr>	
	</table>	
	<!-- 알림톡충전 영역 :: END -->

	<!-- 알림톡충전내역 영역 :: START -->
	<div class="title_dvs">
		<div class="item-title">충전 내역</div>
		<div class="resp_btn_dvs">
			<form name="srcFrm" id="srcFrm" action="./kakaotalk_charge" target="_self">
				<select name="src_year">
<?php if(is_array($TPL_R1=range(date('Y'),date('Y',strtotime("-4 year"))))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<option value="<?php echo $TPL_V1?>" <?php if($_GET["src_year"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?>년</option>
<?php }}?>
				</select>
				<button type="button" onclick="submit();" class="resp_btn active">검색</button>
			</form>
		</div>
	</div>

	<table class="table_basic tdc">
		<colgroup>
			<col width="5%"/>
			<col width="10%"/>
			<col width="15%"/>
			<col width="15%"/>
			<col width="15%"/>
			<col width="40%"/>
		</colgroup>
		<thead>
		<tr>
			<th>번호</th>
			<th>가격(1건)</th>
			<th>결제 가격</th>
			<th>충전 건수</th>
			<th>결제 일자</th>
			<th>충전 내용</th>
		</tr>
		</thead>
		<tbody>
<?php if($TPL_VAR["log_list"]){?>
<?php if($TPL_log_list_1){foreach($TPL_VAR["log_list"] as $TPL_K1=>$TPL_V1){?>
		<tr>
			<td><?php echo (count($TPL_VAR["log_list"])-$TPL_K1)?></td>
			<td><?php echo round($TPL_V1["charge_price"]/$TPL_V1["charge_cnt"], 2)?> 원</td>
			<td><?php echo number_format($TPL_V1["charge_price"])?> 원</td>
			<td><?php echo number_format($TPL_V1["charge_cnt"])?> 건</td>
			<td><?php echo $TPL_V1["regist_date"]?></td>
			<td><?php echo $TPL_V1["log_desc"]?></td>
		</tr>
<?php }}?>
<?php }else{?>
		<tr>
			<td colspan="6">검색된 내역이 없습니다.</td>
		</tr>
<?php }?>
		</tbody>
	</table>
</div>
	<!-- 알림톡충전내역 영역 :: END -->

	<!-- 서브 레이아웃 영역 : 끝 -->

	<div id="kakaotalkPopup" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>