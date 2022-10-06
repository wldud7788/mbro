<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/setting/goodsflow_log.html 000005353 */ 
$TPL_log_list_1=empty($TPL_VAR["log_list"])||!is_array($TPL_VAR["log_list"])?0:count($TPL_VAR["log_list"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">
$(document).ready(function() {
	gSearchForm.init({'pageid':'delivery_company', 'sc':<?php echo $TPL_VAR["scObj"]?>, "sellerAdminMode":true});	
});
</script>
<style>
body {background: #FFF;}
</style>

<div  id="search_container">
<form name="log_search_frm" action="./goodsflow_log" method="get" class='search_form'>
	<input type="hidden" name="no" value="<?php echo $_GET["no"]?>" />
	<table class="table_search">
		<tr>
			<th>검색어</th>
			<td>
				<select name="searchType" class="wx110">
					<option value="all">전체</option>		
					<option value="id">주문번호</option>			
					<option value="code">출고번호</option>
					<option value="code">주문자</option>
					<option value="code">수신인명</option>
				</select>
				<input type="text" name="keyword" value="<?php echo $_GET["keyword"]?>" title="" size="80"/>
			</td>
		</tr>
		<tr>
			<th>조회기간</th>
			<td>
				<div class="date_range_form">
					<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10" />
					-
					<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10" />
					
					<div class="resp_btn_wrap">
						<input type="button" range="today" value="오늘" class="select_date resp_btn"/>
						<input type="button" range="3day" value="3일간" class="select_date resp_btn"/>
						<input type="button" range="1week" value="일주일" class="select_date resp_btn"/>
						<input type="button" range="1month" value="1개월" class="select_date resp_btn"/>
						<input type="button" range="3month" value="3개월" class="select_date resp_btn"/>
						<input type="button" range="select_date_all"  value="전체" class="select_date resp_btn"/>
						<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden">
					</div>
				</div>		
			</td>
		</tr>
		<tr>
			<th>결과</th>
			<td>	
				<div class="resp_checkbox">
					<label><input type="checkbox" name="complete_respons[]" class="chkall" value="all"/> 전체</label>
					<label><input type="checkbox" name="complete_respons[]" value="Y"/> 성공</label>
					<label><input type="checkbox" name="complete_respons[]" value="N"/> 실패</label>	
				</div>
			</td>
		</tr>		
	</table>
	<div class="search_btn_lay"></div>
</form>
</div>

<table class="table_basic v7 mt30">
<colgroup>
	<col width="20%" />
	<col width="20%" />
	<col width="15%" />
	<col />
	<col width="15%" />	
</colgroup>
<tr>
	<th class="its-th center">날짜</th>
	<th class="its-th center">주문번호</th>
	<th class="its-th center">주문자명</th>
	<th class="its-th center">출고정보</th>
	<th class="its-th center">결과</th>
</tr>
<?php if($TPL_VAR["log_list"]){?>
<?php if($TPL_log_list_1){foreach($TPL_VAR["log_list"] as $TPL_V1){?>
<tr>
	<td class="its-td center"><?php echo $TPL_V1["complete_date"]?></td>
	<td class="its-td center"><?php echo $TPL_V1["order_seq"]?></td>
	<td class="its-td center"><?php echo $TPL_V1["order_user_name"]?></td>
	<td class="its-td center">
		<?php echo $TPL_V1["export_code"]?> <?php if($TPL_V1["delivery_number"]){?><br/>[<?php echo $TPL_VAR["gf_config"]['terms'][$TPL_V1["delivery_company_code"]]['name']?> <?php echo $TPL_V1["delivery_number"]?>]<?php }?>
	</td>
	<td class="its-td center">
<?php if($TPL_V1["complete_respons"]=='Y'){?><span class="blue">성공</span><?php }elseif($TPL_V1["complete_respons"]=='N'){?><span class="red">실패</span><?php }?>
	</td>
</tr>
<?php }}?>
<?php }else{?>
<tr>
	<td class="its-td center" colspan="5">검색된 결과가 없습니다.</td>
</tr>
<?php }?>
</table>

<?php if($TPL_VAR["pagin"]){?>
<div class="paging_navigation" style="margin:15px;"><?php echo $TPL_VAR["pagin"]?></div>
<?php }?>
<!--div style="padding-top:10px;">
	<table cellpadding="0" cellspacing="0" border="0" width="100%" class="info-table-style">
	<colgroup>
		<col width="20%" />
		<col />
		<col />
		<col />
		<col />		
	</colgroup>
	<tr>
		<th class="its-th">날짜</th>
		<th class="its-th">입점사명</th>
		<th class="its-th">주문번호</th>
		<th class="its-th">출고정보</th>
		<th class="its-th">결과</th>
	</tr>
	<tr>
		<td class="its-td left">2015-03-31 10:16:15</td>
		<td class="its-td left">TTHH (플로이드)</td>
		<td class="its-td left">212255555555</td>
		<td class="its-td left">D20155555555<br/>로젠 155555-22222</td>
		<td class="its-td left">성공</td>
	</tr>
	<tr>
		<td class="its-td left">2015-03-31 10:12:11</td>
		<td class="its-td left">본사</td>
		<td class="its-td left">255520225555</td>
		<td class="its-td left">D255520225555<br/>로젠 155555-22222</td>
		<td class="its-td left">실패</td>
	</tr>
	</table>
</div-->