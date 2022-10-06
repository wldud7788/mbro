<?php /* Template_ 2.2.6 2022/05/17 12:37:19 /www/music_brother_firstmall_kr/admin/skin/default/statistic_visitor/visitor_referer.html 000010381 */ 
$TPL_table_title_1=empty($TPL_VAR["table_title"])||!is_array($TPL_VAR["table_title"])?0:count($TPL_VAR["table_title"]);
$TPL_total_referer_1=empty($TPL_VAR["total_referer"])||!is_array($TPL_VAR["total_referer"])?0:count($TPL_VAR["total_referer"]);
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
	.chartBlock	{width:1000px; margin:auto;}
	.tableBlock	{width:1200px; margin:auto;}
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
			<h2>방문 통계</h2>
		</div>
		
		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large black"><input type="button" value="설정" onclick="openStatsSettingLayer()" /></span></li>
		</ul>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="sub-layout-container body-height-resizing">	
<?php $this->print_("visitor_menu",$TPL_SCP,1);?>

	
	<!-- 서브메뉴 바디 : 시작-->
	<div class='slc-body-wrap'>
		<div class="slc-body">					
			<div style="width:100%; margin:auto;">				
				<div class="item-title">방문 통계 - 유입경로</div>				
				<br style="line-height:10px" />
				
				<form>
					<div class="statistic_goods pd20 center">
						<label><input type="radio" name="date_type" value="month" <?php if($TPL_VAR["sc"]["date_type"]=='month'){?>checked<?php }?>/> 월별</label>
						<label><input type="radio" name="date_type" value="daily" <?php if($TPL_VAR["sc"]["date_type"]=='daily'){?>checked<?php }?>/> 일별</label>

						<select name="year">
						<option value="">= 연도 선택 =</option>
<?php if(is_array($TPL_R1=range(date('Y'), 2010))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["year"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 년</option>
<?php }}?>
						</select>
						
						<span class="scMonth <?php if($TPL_VAR["sc"]["date_type"]=='month'){?>hide<?php }?>">
						<select name="month">
						<option value="">= 월 선택 =</option>
<?php if(is_array($TPL_R1=range( 1, 12))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<option value="<?php echo $TPL_V1?>" <?php if($_GET["month"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?> 월</option>
<?php }}?>
						</select>
						</span>
				
						<span class="btn medium cyanblue"><input type="submit" value="검색" /></span>
						<span class="btn_scMonth <?php if($TPL_VAR["sc"]["date_type"]=='month'){?>hide<?php }?>">
						<span class="btn medium"><input type="button" value="이번달" class="normal" onclick="this.form.year.value='';this.form.month.value='';this.form.submit()" /></span>
						</span>
					</div>
				</form>				
				<br style="line-height:10px" />
				
				<div id="chart1" style="margin:auto; height:250px; width:1000px;"></div>				
				<br style="line-height:20px" />
					
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="right" valign="bottom" class="pdb10">
							<span class="btn small orange"><input type="button" value="안내) 네이버광고 유입경로"  class="guide_naver_referer" /></span>
							<span class="btn small"><input type="button" value="엑셀출력" onclick="divExcelDownload('유입경로_방문통계','#visitor_referer')" /></span>
						</td>
					</tr>
				</table>				
				<div id="visitor_referer">
					<table width="100%" class="simpledata-table-style" style="margin:auto;">
						<thead>
							<tr>
								<th width="3%"></th>
								<th>유입경로별 방문횟수</th>
<?php if($TPL_table_title_1){foreach($TPL_VAR["table_title"] as $TPL_V1){?>
								<th <?php if($_GET["date_type"]!='daily'){?>width="6%"<?php }?>><?php echo $TPL_V1?></th>
<?php }}?>
								<th width="7%">합계</th>
							</tr>
						</thead>
						<tbody>
<?php if($TPL_total_referer_1){$TPL_I1=-1;foreach($TPL_VAR["total_referer"] as $TPL_K1=>$TPL_V1){$TPL_I1++;?>
							<tr>
								<td class="ctd"><input type="checkbox" name="cntCode[]" value="<?php echo $TPL_K1?>" titleName="<?php echo $TPL_K1?>" <?php if($TPL_I1== 0){?>checked<?php }?> /></td>
								<td class="ctd"><?php echo $TPL_K1?></td>
<?php if(is_array($TPL_R2=$TPL_VAR["statlist"][$TPL_K1]["list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<td class="rtd"><?php echo number_format($TPL_V2["cnt"])?></td>
<?php }}?>
								<td class="rtd"><?php echo number_format($TPL_VAR["statlist"][$TPL_K1]["total_cnt"])?></td>
							</tr>
<?php }}?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="layer_guide_naver_referer" class="fx12 hide">
	<div>
		네이버 광고를 통한 유입 분석(방문/가입/구매)이 가능하기 위해서는 네이버 광고 시 반드시 추적 URL을 설정해 주셔야 합니다.<br />
		네이버 광고 시 추적 URL을 설정하지 않으면 네이버 광고를 통한 유입을 알 수 없습니다.<br />
		자세한 내용은 네이버 고객센터의 도움말을 확인해 주십시오.
		
	</div>
	<div class="mt20 center">
		<a href="https://saedu.naver.com/help/faq/ncc/list.nhn?categorySeq=23" target="_blank"><span class="btn medium black"><input type="button" value="네이버 검색광고 > 고객센터 > 도움말 > 추적URL"  class="guide_naver_referer" /></span></a>
	</div>
</div>

<script class="code" type="text/javascript">
	$(document).ready(function(){
		$("input[name='date_type']").each(function(){
			$(this).live('click', function(){
				if	($(this).val() == 'daily'){
					$(".scMonth").removeClass('hide');
					$(".btn_scMonth").removeClass('hide');
				}else{
					$(".scMonth").addClass('hide');
					$(".btn_scMonth").addClass('hide');
				}
			});
		});

		$("input[name='cntCode[]']").each(function(){
			$(this).live('click', function(){
				if	(!(chkCheckCode('cnt') > 0)) {
					alert('1개 이상 체크되어야 합니다.');
					$(this).attr('checked', true);
				}
				makePlotCnt();
			});
		});

		$(".guide_naver_referer").click(function(){
			openDialog("안내) 네이버광고 유입경로", "layer_guide_naver_referer", {"width":"530","height":"210","show" : "fade","hide" : "fade","modal":false}); 
		});

		makePlotCnt();
	});

	function chkCheckCode(type){
		var retVal	= 0;
		if	(type == 'cnt'){
			$("input[name='cntCode[]']").each(function(){
				if	($(this).attr('checked'))	retVal++;
			});
		}else{
			$("input[name='priceCode[]']").each(function(){
				if	($(this).attr('checked'))	retVal++;
			});
		}

		return retVal;
	}

	function makePlotCnt(){

		var listData	= new Object();
<?php if($TPL_dataForChart_1){foreach($TPL_VAR["dataForChart"] as $TPL_K1=>$TPL_V1){?>
		listData['<?php echo $TPL_K1?>']	= <?php echo json_encode($TPL_V1)?>;
<?php }}?>

		var dataList	= [];
		var titles		= [];
		var cnt			= 0;
		$("input[name='cntCode[]']").each(function(){
			if	($(this).attr('checked')){
				cnt++;
				dataList.push(listData[$(this).val()]);
				titles.push({'label':$(this).attr('titleName')});
			}
		});

		$("#chart1").html('');
		if	(cnt > 0){
			var maxCnt		= '<?php echo $TPL_VAR["maxCnt"]?>';
			var gapCnt		= parseInt(maxCnt.toString().substring(0,1)) < 2 ? Math.pow(10,maxCnt.toString().length-2) : Math.pow(10,maxCnt.toString().length-1);
			var yaxisMaxCnt	= parseInt(maxCnt.toString().substring(0,1)) < 2 ? gapCnt * (parseInt(maxCnt.toString().substring(0,2))+2) : gapCnt * (parseInt(maxCnt.toString().substring(0,1))+2);
			yaxisMaxCnt = yaxisMaxCnt > 100 ? yaxisMaxCnt : 100;
			var cntPlot		= $.jqplot('chart1', dataList, {
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
						max: yaxisMaxCnt,
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

	function openStatsSettingLayer(){
		$.ajax({
			type: "get",
			url: "../statistic_visitor/visitor_setting",
			success: function(result){	
				$("div#statsSettingLayer").html(result);
			}
		});
		openDialog("방문자 통계 설정", "statsSettingLayer", {"width":"900","height":"370","show" : "fade","hide" : "fade"});
	}
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>