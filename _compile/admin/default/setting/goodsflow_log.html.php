<?php /* Template_ 2.2.6 2022/05/17 12:36:56 /www/music_brother_firstmall_kr/admin/skin/default/setting/goodsflow_log.html 000006666 */ 
$TPL_log_list_1=empty($TPL_VAR["log_list"])||!is_array($TPL_VAR["log_list"])?0:count($TPL_VAR["log_list"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>

<script type="text/javascript">
$(document).ready(function() {

	gSearchForm.init({'pageid':'delivery_company', 'sc':<?php echo $TPL_VAR["scObj"]?>, "sellerAdminMode":true});	

	$("input[name=shipping_provider_seq]").bind('click', function(){	
		$(this).val() == 'N' ? $(".ui-combobox").show() : $(".ui-combobox").hide();
	});

<?php if($_GET["shipping_provider_seq"]=='Y'||$_GET["shipping_provider_seq"]==''){?>
		$(".ui-combobox").hide();
<?php }?>

	$(".search_reset").on("click", function(){
		$(".ui-combobox").hide();
	});

});

function set_date(start,end){
	$("input[name='regist_date[]']").eq(0).val(start);
	$("input[name='regist_date[]']").eq(1).val(end);
}
</script>

<div id="search_container" class="search_container v2">
	<form name="log_search_frm" action="./goodsflow_log" method="get" class='search_form' >					
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
					<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10" style="width:80px" />
					-
					<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10" style="width:80px" />
					
					<div class="resp_btn_warp">
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
<?php if($TPL_VAR["provider"]){?>
		<tr>
			<th>주문상품</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="shipping_provider_seq" value="Y"/>본사</label>		
					<label><input type="radio" name="shipping_provider_seq" value="N"/>입점사</label>
				</div>
				<select name="provider_seq_selector" disabled class="deliver_provider_seq_selector">					
				</select>					
				<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $_GET["provider_seq"]?>" />
				<label class="resp_checkbox ml15"><input type="checkbox" name="admin_ship" value="1" <?php if($_GET["admin_ship"]=='1'){?>checked<?php }?>/> 본사배송그룹</label>	
			</td>
		</tr>
<?php }?>
		<tr>
			<th>결과</th>
			<td>	
				<div class="resp_checkbox">
					<label><input type="checkbox" name="complete_respons[]" class="chkall" value="all" /> 전체</label>
					<label><input type="checkbox" name="complete_respons[]" value="Y"/> 성공</label>
					<label><input type="checkbox" name="complete_respons[]" value="N"/> 실패</label>	
				</div>
			</td>
		</tr>		
	</table>
	<div class="search_btn_lay"></div>
	</form>
</div>

<table class="table_basic tdc sub_info mt30">
<colgroup>
	<col width="150px" />
	<col width="70px" />
	<col width="100px" />
	<col width="150px" />
	<col />
	<col />
	<col width="60px"/>	
</colgroup>
<tr>
	<th>날짜</th>
	<th>구분</th>
	<th>입점사명</th>
	<th>주문번호</th>
	<th>주문자명</th>
	<th>출고정보</th>
	<th>결과</th>
</tr>
<?php if($TPL_VAR["log_list"]){?>
<?php if($TPL_log_list_1){foreach($TPL_VAR["log_list"] as $TPL_V1){?>
<tr>
	<td><?php echo $TPL_V1["complete_date"]?></td>
	<td>
<?php if($TPL_V1["provider_seq"]!= 1&&$TPL_V1["shipping_provider_seq"]== 1){?>본사배송<?php }else{?>-<?php }?>
	</td>
	<td>
<?php if($TPL_V1["provider_seq"]== 1){?>본사<?php }else{?><?php echo $TPL_V1["provider_id"]?><br/>(<?php echo $TPL_V1["provider_name"]?>)<?php }?>
	</td>
	<td><?php echo $TPL_V1["order_seq"]?></td>
	<td><?php echo $TPL_V1["order_user_name"]?></td>
	<td>
		<?php echo $TPL_V1["export_code"]?> <?php if($TPL_V1["delivery_number"]){?><br/>[<?php echo $TPL_VAR["gf_config"]['terms'][$TPL_V1["delivery_company_code"]]['name']?> <?php echo $TPL_V1["delivery_number"]?>]<?php }?>
	</td>
	<td>
<?php if($TPL_V1["complete_respons"]=='Y'){?><span class="blue">성공</span><?php }elseif($TPL_V1["complete_respons"]=='N'){?><span class="red">실패</span><?php }?>
	</td>
</tr>
<?php }}?>
<?php }else{?>
<tr>
	<td colspan="7">검색된 결과가 없습니다.</td>
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