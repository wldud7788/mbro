<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/statistic_sales/_sales_goods_search.html 000005547 */ ?>
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript">
	$(document).ready(function() {		
		gSearchForm.init({'pageid':'sales_sales','sc':<?php echo $TPL_VAR["scObj"]?>});			
	})
</script>
<div class="search_container">				
	<table class="table_search">
		<tr>
			<th>검색어</th>
			<td>
				<select name="searchType" class="wx110">
					<option value="all">전체</option>		
					<option value="id">상품명</option>			
					<option value="code">상품 코드</option>	
					<option value="code">매입용 상품명</option>	
				</select>
				<input type="text" name="keyword" value="<?php echo $_GET["keyword"]?>" size="80"/>
			</td>
		</tr>		
		<tr>
			<th>구분</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="sc_type" value="goods" <?php if($TPL_VAR["sc"]["sc_type"]=="goods"){?>checked<?php }?>/> 상품별</label>
					<label><input type="radio" name="sc_type" value="daily" <?php if($TPL_VAR["sc"]["sc_type"]=="month"){?>daily<?php }?>/> 일별</label>
				</div>
			</td>
		</tr>
		<tr>
			<th>결제확인 기간</th>
			<td>
				<span class="dateType sdaily <?php if($_GET["sc_type"]=='goods'){?>hide<?php }?> ">				
					<select name="year" class="wx80" defaultValue="<?php echo date('Y')?>">					
<?php if(is_array($TPL_R1=range(date('Y'), 2010))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option>
<?php }}?>
					</select>					
					
					<select name="month" class="wx80" defaultValue="<?php echo date('m')?>">					
<?php if(is_array($TPL_R1=range( 1, 12))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>					
						<option value="<?php if($TPL_V1< 10){?>0<?php echo $TPL_V1?><?php }else{?><?php echo $TPL_V1?><?php }?>" <?php if($TPL_VAR["sc"]["month"]==$TPL_V1){?>selected<?php }?>><?php if($TPL_V1< 10){?>0<?php echo $TPL_V1?><?php }else{?><?php echo $TPL_V1?><?php }?></option>
<?php }}?>
					</select>	
									
					<input type="button" value="이번달" class="resp_btn v3 thisMonthBtn"/>						
				</span>

				<span class="sgoods <?php if($_GET["sc_type"]=='daily'){?>hide<?php }?>">
					<div class="date_range_form" defaultValue="<?php echo date('Y')?>">
						<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10" />
						-
						<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10"  />

						<div class="resp_btn_wrap">
							<input type="button"  range="today" value="오늘" class="select_date resp_btn" />
							<input type="button"  range="3day" value="3일간" class="select_date resp_btn" />
							<input type="button"  range="1week" value="일주일" class="select_date resp_btn" />
							<input type="button"  range="1month" value="1개월" class="select_date resp_btn" />
							<input type="button"  range="3month" value="3개월" class="select_date resp_btn" />
							<input type="button"  range="thatmonth"  value="당월" class="select_date resp_btn"/>
							<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden">
						</div>
					</div>  
				</span>
			</td>
		</tr>
<?php if(serviceLimit('H_AD')){?>
		<tr <?php if(!in_array('sc_provider',$TPL_VAR["sc_form"]["default_field"])){?>class='hide'<?php }?> >
			<th><span>입점사</span><label class="resp_checkbox hide"><input type="checkbox" name="search_form_editor[]" value="sc_provider" class="hide"></label></th>
			<td>
				<div class="ui-widget">
					<select name="provider_seq_selector" style="vertical-align:middle;">
					</select>
					<input type="hidden" class="provider_seq" name="provider_seq" value="<?php echo $TPL_VAR["sc"]["provider_seq"]?>" />
				</div>
			</td>
		</tr>
<?php }?>
		<tr>
			<th>카테고리</th>
			<td>
				<select class="wx110" name="category1" size="1"><option value="">1차 분류</option></select>
				<select class="wx110" name="category2" size="1"><option value="">2차 분류</option></select>
				<select class="wx110" name="category3" size="1"><option value="">3차 분류</option></select>
				<select class="wx110" name="category4" size="1"><option value="">4차 분류</option></select>
			</td>
		</tr>
		<tr>
			<th>브랜드</th>
			<td>
				<select class="wx110" name="brands1" size="1"><option value="">1차 분류</option></select>
				<select class="wx110" name="brands2" size="1"><option value="">2차 분류</option></select>
				<select class="wx110" name="brands3" size="1"><option value="">3차 분류</option></select>
				<select class="wx110" name="brands4" size="1"><option value="">4차 분류</option></select>
			</td>
		</tr>
	</table>
	<div class="search_btn_lay"></div>
</div>

<script class="code" type="text/javascript">
	$(document).ready(function(){
		$("input[name='sc_type']").live('click', function(){
			chgSearchForm();
		});
	});
	function chgSearchForm(){
		if	($("input[name='sc_type']:checked").val() == 'daily'){
			$(".sgoods").addClass('hide');
			$(".sdaily").removeClass('hide');
		}else{
			$(".sgoods").removeClass('hide');
			$(".sdaily").addClass('hide');
		}
	}
</script>