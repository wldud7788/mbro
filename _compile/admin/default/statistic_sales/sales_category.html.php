<?php /* Template_ 2.2.6 2022/05/17 12:37:14 /www/music_brother_firstmall_kr/admin/skin/default/statistic_sales/sales_category.html 000011214 */ 
$TPL_table_title_1=empty($TPL_VAR["table_title"])||!is_array($TPL_VAR["table_title"])?0:count($TPL_VAR["table_title"]);
$TPL_statlist_1=empty($TPL_VAR["statlist"])||!is_array($TPL_VAR["statlist"])?0:count($TPL_VAR["statlist"]);
$TPL_dataForChart_1=empty($TPL_VAR["dataForChart"])||!is_array($TPL_VAR["dataForChart"])?0:count($TPL_VAR["dataForChart"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<!--[if IE]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />
<style type="text/css">
	table.simpledata-table-style td.ctd { text-align:center; }
	table.simpledata-table-style td.ltd { text-align:left; padding-left:5px; }
	table.simpledata-table-style td.rtd { text-align:right; padding-right:5px; }
	.chartBlock	{width:100%; margin:auto;}
	.tableBlock	{width:100%; margin:auto;}
	.sub_title	{width:100%;text-align:center;color:#000;margin:15px 0;font-size:15px;font-weight:bold;}
	span.add_info {font-size:11px;color:#838383;font-weight:normal;}
</style>

<div id="statsSettingLayer"></div>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
		</ul>

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>판매 통계</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">

		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="sub-layout-container body-height-resizing">

<?php $this->print_("sales_menu",$TPL_SCP,1);?>


	<!-- 서브메뉴 바디 : 시작-->
	<div class='slc-body-wrap'>
		<div class="slc-body">
			<div class="chartBlock">
				<div class="item-title">판매 통계 - 카테고리/브랜드</div>
				<br style="line-height:10px" />

				<div class="statistic_goods pd20">
					<form>
						<div align="center">
							<table align="center">
							<colgroup>
								<col />
							</colgroup>
							<tr>
								<td align="left">
									<label><input type="radio" name="sc_type" value="category" <?php if($TPL_VAR["sc"]["sc_type"]=='category'){?>checked<?php }?> /> 카테고리</label>
									<label><input type="radio" name="sc_type" value="brand" <?php if($TPL_VAR["sc"]["sc_type"]=='brand'){?>checked<?php }?> /> 브랜드</label>
								</td>
							</tr>
							<tr>
								<td>
									<label><input type="radio" name="dateSel_type" value="month" <?php if($TPL_VAR["sc"]["dateSel_type"]=='month'){?>checked<?php }?> /> 월별</label>
									<label><input type="radio" name="dateSel_type" value="daily" <?php if($TPL_VAR["sc"]["dateSel_type"]=='daily'){?>checked<?php }?> /> 일별</label>
									<select name="year">
									<option value="">= 연도 선택 =</option>
<?php if(is_array($TPL_R1=range(date('Y'), 2010))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
										<option value="<?php echo $TPL_V1?>" <?php if($_GET["year"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 년</option>
<?php }}?>
									</select>

									<span class="monthSpan <?php if($TPL_VAR["sc"]["dateSel_type"]=='month'){?>hide<?php }?>">
										<select name="month">
										<option value="">= 월 선택 =</option>
<?php if(is_array($TPL_R1=range( 1, 12))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
											<option value="<?php echo $TPL_V1?>" <?php if($_GET["month"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 월</option>
<?php }}?>
										</select>
									</span>

									<span class="btn medium cyanblue"><input type="submit" value="검색" /></span>
									<span class="monthSpan <?php if($TPL_VAR["sc"]["dateSel_type"]=='month'){?>hide<?php }?>">
										<span class="btn medium"><input type="button" value="이번달" class="setThisMonth normal" /></span>
									</span>
								</td>
							</tr>
							</table>
						</div>
					</form>
				</div>
			</div>

			<div class="chartBlock mt30">
				<div class="sub_title">판매금액<span class="add_info">(단위:천원, 결제완료 기준)</span></div>
				<br style="line-height:10px" />
				<div id="chart" style="margin:auto; height:250px; width:100%;"></div>
				<br style="line-height:20px" />
			</div>

			<div class="tableBlock">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="right" valign="bottom" class="pdt5 pdb10"><span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('<?php if($TPL_VAR["sc"]["dateSel_type"]=='daily'){?>일별<?php }else{?>월별<?php }?>_판매통계카테고리/브랜드통계_건수','#category_cnt_table')" /></span></td>
						<td align="right" valign="bottom" class="pdt5 pdb10">
							<span class="btn small orange"><button type="button" onclick='openDialog("안내) 네이버광고 유입경로", "layer_guide_category", {"width":"550","height":"180","show" : "fade","hide" : "fade","modal":false}); '>안내) 카테고리/브랜드 통계</button></span>
							<div class="hide" id="layer_guide_category">
								주문 상품의 대표 카테고리 또는 대표 브랜드를 기준으로 판매건수와 판매금액을 집계합니다. <br/>
								<br/>
								※ 주문 상품에 카테고리 또는 브랜드가 연결되어 있지 않은 경우 집계되지 않습니다.
							</div>
							<span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('<?php if($TPL_VAR["sc"]["dateSel_type"]=='daily'){?>일별<?php }else{?>월별<?php }?>_판매통계카테고리/브랜드통계_건수','#category_cnt_table')" /></span>
						</td>
					</tr>
				</table>

				<div id="category_cnt_table" style="width:100%;overflow:auto">
					<table <?php if($_GET["dateSel_type"]!="daily"){?>width="100%"<?php }?> class="simpledata-table-style" style="margin:auto;">
						<thead>
							<tr>
								<th <?php if($_GET["dateSel_type"]!="daily"){?>width="4%"<?php }else{?>style="width:40px"<?php }?> ></th>
								<th <?php if($_GET["dateSel_type"]=="daily"){?>style="width:150px"<?php }?>><?php if($_GET["sc_type"]=="category"){?>카테고리별 판매횟수<?php }else{?>브랜드별 판매횟수<?php }?></th>
<?php if($TPL_table_title_1){foreach($TPL_VAR["table_title"] as $TPL_V1){?>
								<th <?php if($_GET["dateSel_type"]!="daily"){?>width="{100/count(table_title)}%"<?php }else{?>style="width:60px"<?php }?>><?php echo $TPL_V1?></th>
<?php }}?>
								<th <?php if($_GET["dateSel_type"]!="daily"){?>width="7%"<?php }else{?>style="width:50px"<?php }?>>합계</th>
							</tr>
						</thead>
						<tbody>
<?php if($TPL_statlist_1){$TPL_I1=-1;foreach($TPL_VAR["statlist"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
							<tr>
								<td class="ctd"><input type="checkbox" name="category[]" value="<?php echo preg_replace('/[^0-9a-zA-Z가-힣]/','',$TPL_K1)?>" titleName="<?php echo $TPL_K1?>" <?php if($TPL_I1== 0){?>checked<?php }?> /></td>
								<td class="ctd"><?php echo $TPL_K1?></td>
<?php if(is_array($TPL_R2=$TPL_V1["list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<td class="rtd"><?php echo number_format($TPL_V2["cnt"])?></td>
<?php }}?>
								<td class="rtd"><?php echo number_format($TPL_V1["total_cnt"])?></td>
							</tr>
<?php }}else{?>
							<tr>
								<td colspan="15" class="center">검색된 통계가 없습니다.</td>
							</tr>
<?php }?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script class="code" type="text/javascript">
	$(document).ready(function(){

		makePlotPrice();

		$("input[name='dateSel_type']").live('click', function(){
			chgSearchForm();
		});

		$(".setThisMonth").live('click', function(){
			$("select[name='year']").val('<?php echo date('Y')?>');
			$("select[name='month']").val('<?php echo date('n')?>');
		});

		$("input[name='category[]']").each(function(){
			$(this).live('click', function(){
				if	(!(chkCheckCode() > 0)) {
					alert('1개 이상 체크되어야 합니다.');
					$(this).attr('checked', true);
				}
				makePlotPrice();
			});
		});
	});

	function chgSearchForm(){
		if	($("input[name='dateSel_type']:checked").val() == 'daily'){
			$(".monthSpan").removeClass('hide');
		}else{
			$(".monthSpan").addClass('hide');
		}
	}

	function chkCheckCode(){
		var retVal	= 0;
		$("input[name='category[]']").each(function(){
			if	($(this).attr('checked'))	retVal++;
		});

		return retVal;
	}

	function makePlotPrice(){

		var listData	= new Object();
<?php if($TPL_dataForChart_1){foreach($TPL_VAR["dataForChart"] as $TPL_K1=>$TPL_V1){?>
		listData['<?php echo preg_replace('/[^0-9a-zA-Z가-힣]/','',$TPL_K1)?>']	= <?php echo json_encode($TPL_V1)?>;
<?php }}?>

		var dataList	= [];
		var titles		= [];
		var cnt			= 0;
		$("input[name='category[]']").each(function(){
			if	($(this).attr('checked')){
				cnt++;
				dataList.push(listData[$(this).val()]);
				titles.push({'label':$(this).attr('titleName')});
			}
		});

		$("#chart").html('');

		if	(cnt > 0){
			var maxPrice		= '<?php echo $TPL_VAR["maxPrice"]?>';
			var gapPrice		= parseInt(maxPrice.toString().substring(0,1)) < 2 ? Math.pow(10,maxPrice.toString().length-2) : Math.pow(10,maxPrice.toString().length-1);
			var yaxisMaxPrice	= parseInt(maxPrice.toString().substring(0,1)) < 2 ? gapPrice * (parseInt(maxPrice.toString().substring(0,2))+2) : gapPrice * (parseInt(maxPrice.toString().substring(0,1))+2);
			yaxisMaxPrice = yaxisMaxPrice > 100 ? yaxisMaxPrice : 100;

			var pricePlot			= $.jqplot('chart', dataList, {
				seriesDefaults: {
					showMarker:true,
					pointLabels: { show:true }
				},
				seriesColors:<?php echo json_encode($TPL_VAR["seriesColors"])?>,
				series: titles,
				axes: {
					xaxis: {
						renderer: $.jqplot.CategoryAxisRenderer,
					},
					yaxis: {
						min: 0,
						max: yaxisMaxPrice,
						numberTicks: 11
					}
				},
				legend: {
					show:true,
					location: 'e',
					xoffset: 15,
					yoffset: 15,
					placement: 'outside'
				},
				grid: {
					drawGridLines: true,
					gridLineColor: '#dddddd',
					background: '#fffdf6',
					borderWidth: 0,
					shadow: false
				}
			});
		}
	}
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>