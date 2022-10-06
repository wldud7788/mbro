<?php /* Template_ 2.2.6 2022/05/30 15:19:31 /www/music_brother_firstmall_kr/admin/skin/default/member/curation_stat.html 000014164 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);
$TPL_dataKind_1=empty($TPL_VAR["dataKind"])||!is_array($TPL_VAR["dataKind"])?0:count($TPL_VAR["dataKind"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.donutRenderer.min.js"></script>   
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>
<style>
	span.detail{color:#0638a2;}
	.footer.search_btn_lay{top: auto; left: calc(50% - 50px);}
</style>

<script type="text/javascript">
	$(document).ready(function() {
		
		gSearchForm.init({'pageid':'curation_stat','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>'});

		$(".detail").on("click",function(){
			//loadingStart("body",{segments: 12, width: 15.5, space: 6, length: 13, color: '#000000', speed: 1.5});
			var inflow_kind = $(this).attr("inflow_kind");
			var inflow_type = $(this).attr("inflow_type");
			$("#detailFrame").attr("src","../member/curation_stat_detail?sc_kind="+inflow_kind+"&sc_type="+inflow_type+"&start_date=<?php echo $_GET['start_date']?>&end_date=<?php echo $_GET['end_date']?>&first=1");
			openDialog("유입로그 상세보기","curation_stat_detail", {"width":"1200","height":"800"});
		});		
	
		$("#btn_submit").click(function(){
			$("#gabiaFrm").submit();
		});
	});
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>고객 리마인드</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<!--
			<li><span class="btn large icon"><button><span class="arrowleft"></span>이동버튼</button></span></li>
			<li><span class="btn large icon"><button><span class="arrowleft"></span>이동버튼</button></span></li>
			-->
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><button type="submit" onclick="submitEditorForm(document.memberForm)" class="resp_btn active2 size_L">저장</button></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">

	<!-- 상단 단계 링크 : 시작 -->
<?php $this->print_("top_menu",$TPL_SCP,1);?>

	<!-- 상단 단계 링크 : 끝 -->

	<div id="curation_stat_detail" class="hide">
	<iframe name="detailFrame" id="detailFrame" src="" style="width:100%;height:100%;border:0px;"></iframe>
	</div>

	<!-- 서브 레이아웃 영역 : 시작 -->
	<div id="search_container"  class="search_container">
		<form name="gabiaFrm" id="gabiaFrm" class='search_form'>
		<table class="table_search">	
			<tr>
				<th>발송일</th>
				<td>
					<div class="date_range_form">
						<input type="text" name="start_date" value="<?php echo $TPL_VAR["sc"]["start_date"]?>" class="datepicker sdate"  maxlength="10" size="10" />
						-
						<input type="text" name="end_date" value="<?php echo $TPL_VAR["sc"]["end_date"]?>" class="datepicker edate" maxlength="10" size="10" />
							
						<div class="resp_btn_wrap">
							<input type="button" range="today" value="오늘" class="select_date resp_btn" />
							<input type="button" range="3day" value="3일간" class="select_date resp_btn" />
							<input type="button" range="1week" value="일주일" class="select_date resp_btn" />
							<input type="button" range="1month" value="1개월" class="select_date resp_btn" />
							<input type="button" range="3month" value="3개월" class="select_date resp_btn" />
							<input type="button" range="all"  value="전체" class="select_date resp_btn"/>
							<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden" />
						</div>
					</div>
				</td>
			</tr>		
		</table>
		<div class="footer search_btn_lay"></div>
		</form>
	</div>


	<br style="line-height:16px;" />
	<style>
		.info {display:inline-block; height:200px; width:250px;font-size:11px;color:#696969;margin:5px;}
		.jqplot-xaxis-label {font-size:12px;color:#000;font-weight:bold;}
		.jqplot-pie-series.jqplot-data-label {color:#fff;}
		.jqplot-table-legend.jqplot-table-legend-label {text-align:left;}
	</style>
<?php if($TPL_VAR["dataKind"]['coupon']||$TPL_VAR["dataKind"]['emoney']||$TPL_VAR["dataKind"]['cart']||$TPL_VAR["dataKind"]['timesale']||$TPL_VAR["dataKind"]['membership']||$TPL_VAR["dataKind"]['review']||$TPL_VAR["dataKind"]['birthday']||$TPL_VAR["dataKind"]['anniversary']){?>
	<div style="width:95%;margin:auto;text-align:center;">
		<div id="chart_coupon" class="info"></div>
		<div id="chart_emoney" class="info"></div>
		<div id="chart_cart" class="info"></div>
		<div id="chart_birthday" class="info"></div>
	</div>
	<div style="width:95%;margin:15px auto;text-align:center;">
		<div id="chart_timesale" class="info"></div>
		<div id="chart_membership" class="info"></div>
		<div id="chart_review" class="info"></div>
		<div id="chart_anniversary" class="info"></div>
	</div>
<?php }?>

<?php if(count($TPL_VAR["dataInflowChart"])> 0||count($TPL_VAR["dataLoginChart"])> 0||count($TPL_VAR["dataOrderChart"])> 0){?>
	<br style="line-height:40px;" />
	<div style="width:95%;margin:auto;text-align:center;padding-top:25px;border:2px solid #dddddd;border-radius:10px;">

		<div id="chart_inflow" style="display:inline-block;text-align:center; height:250px; width:250px; ">
			<div style="display:inline-block;color:#000;height:30px;text-align:center;font-weight:bold;">유입률</div>
		</div>
		<div id="chart_login" style="display:inline-block;height:250px; width:250px; ">
			<div style="display:inline-block;color:#000;height:30px; text-align:center;font-weight:bold;">로그인</div>
		</div>
		<div id="chart_order" style="display:inline-block;height:250px; width:250px;margin-right:170px; ">
			<div style="display:inline-block;color:#000;height:30px; text-align:center;font-weight:bold;">구매</div>
		</div>

	</div>
<?php }?>


	<!-- 주문리스트 테이블 : 시작 -->
	<table class="table_row_basic tdc mt20">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="20%" />
		<col width="10%" />
		<col width="10%" />
		<col width="10%" />
		<col width="10%" />
		<col width="10%" />
		<col width="10%" />
		<col width="10%" />
		<col width="10%" />
	</colgroup>
	<thead class="lth">
	<tr>
		<th rowspan="2">종류</th>
		<th colspan="2">유입(율) / 발송</th>
		<th colspan="5">유입 후 2일 동안 활동 내역</th>
		<th rowspan="2">상세 내역</th>
	</tr>
	<tr>
		<th>SMS</th>
		<th>Email</th>
		<th>로그인</th>
		<th>상품뷰</th>
		<th>장바구니</th>
		<th>위시리스트</th>
		<th>구매</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->
		<tbody class="ltb otb" >
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr>
				<td class="left"><?php echo $TPL_V1["kind_name"]?></td>
				<td class="resp_btn_txt v2"><span class="detail" inflow_kind="<?php echo $TPL_V1["inflow_kind"]?>" inflow_type="SMS"><?php echo $TPL_V1["inflow_sms_total"]?>(<?php echo $TPL_V1["sms_stat_per"]?>%)</span>/<?php echo $TPL_V1["send_sms_total"]?></td>
				<td class="resp_btn_txt v2"><span class="detail" inflow_kind="<?php echo $TPL_V1["inflow_kind"]?>" inflow_type="EMAIL"><?php echo $TPL_V1["inflow_email_total"]?>(<?php echo $TPL_V1["email_stat_per"]?>%)</span>/<?php echo $TPL_V1["send_email_total"]?></td>
				<td><?php echo $TPL_V1["login_cnt"]?>회</td>
				<td><?php echo $TPL_V1["goodsview_cnt"]?>회</td>
				<td><?php echo $TPL_V1["cart_cnt"]?>회</td>
				<td><?php echo $TPL_V1["wish_cnt"]?>회</td>
				<td><?php echo $TPL_V1["order_cnt"]?>회</td>
				<td><button type="button" inflow_kind="<?php echo $TPL_V1["inflow_kind"]?>" inflow_type="all" class="detail resp_btn v2">상세 내역</button></td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }}?>
<?php }else{?>
			<!-- 리스트타이틀(주문상태 및 버튼) : 시작 -->
			<tr class="list-row">
				<td class="its-td-align center" colspan="11">
<?php if($TPL_VAR["search_text"]){?>
						'<?php echo $TPL_VAR["search_text"]?>' 검색된 데이터가 없습니다.
<?php }else{?>
						데이터가 없습니다.
<?php }?>
				</td>
			</tr>
			<!-- 리스트데이터 : 끝 -->
<?php }?>
		</tbody>
		<!-- 리스트 : 끝 -->

	</table>
</div>

<!-- 주문리스트 테이블 : 끝 -->
<script class="code" type="text/javascript">
$(document).ready(function(){

<?php if($TPL_dataKind_1){foreach($TPL_VAR["dataKind"] as $TPL_K1=>$TPL_V1){?>
	
	var maxValue = <?php echo $TPL_V1["max"]?>;

	var gap = parseInt(maxValue.toString().substring(0,1)) < 2 ? Math.pow(10,maxValue.toString().length-2) : Math.pow(10,maxValue.toString().length-1);
	var yaxisMax = parseInt(maxValue.toString().substring(0,1)) < 2 ? gap * (parseInt(maxValue.toString().substring(0,2))+2) : gap * (parseInt(maxValue.toString().substring(0,1))+2);
	yaxisMax = yaxisMax > 100 ? yaxisMax : 100;

	var lineArr = new Array();
	
<?php if(is_array($TPL_R2=$TPL_V1["data"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>lineArr[<?php echo $TPL_K2?>] = [[<?php echo $TPL_V2?>,""]];<?php }}?>

	var plot1 = $.jqplot('chart_<?php echo $TPL_K1?>', [lineArr[5],lineArr[4],lineArr[3],lineArr[2],lineArr[1],lineArr[0]], {
		animate: !$.jqplot.use_excanvas,
		stackSeries: false,
		seriesDefaults: { 
			renderer:$.jqplot.BarRenderer,
			shadowAngle: 0,
			rendererOptions: {
				barMargin: 10,
				highlightMouseDown: true   
			},
            rendererOptions: {
                barDirection: 'horizontal'
            },
			pointLabels: {show: true},
			showMarker:true
		},
		axes: {      
			xaxis: {      
				label : '<?php echo $TPL_V1["lable"]?>',
				adMin: 0  ,
			},      
			yaxis: {     
				renderer: $.jqplot.CategoryAxisRenderer,    
			}    
		},   
		legend: {      
			show: <?php if($TPL_K1=='anniversary'){?>true<?php }else{?>false<?php }?>,
			location: 'e',      
			placement: 'outside'    
		},
		seriesColors:<?php echo json_encode($TPL_VAR["seriesColors2"])?>,
		series:[
			{'label':'구매'},
			{'label':'위시리스트'},
			{'label':'장바구니'},
			{'label':'상품 뷰'},
			{'label':'로그인'},
			{'label':'접속'},
		], 
		grid: {
	        drawGridLines: true,
	        gridLineColor: '#dddddd',
	        background: '#fffdf6',
	        borderWidth: 0,
	        shadow: false
	    }
	});
	
	
<?php }}?>


	$(".jqplot-point-label").each(function(){
		$(this).html(setComma($(this).html()));
	});

	$(".jqplot-table-legend tbody").children().each(function(i, tr){
		$(".jqplot-table-legend tbody").prepend(tr);
	});


<?php if(count($TPL_VAR["dataInflowChart"])> 0||count($TPL_VAR["dataLoginChart"])> 0||count($TPL_VAR["dataOrderChart"])> 0){?>
	var data = <?php echo preg_replace("/\"([0-9]+)\"/","$1",json_encode($TPL_VAR["dataInflowChart"]))?>;
	var plot1 = $.jqplot ('chart_inflow', [data], 
		{ 
			seriesDefaults: {
				// Make this a pie chart.
				renderer: jQuery.jqplot.PieRenderer, 
				rendererOptions: {
					// Put data labels on the pie slices.
					// By default, labels show the percentage of the slice.
					showDataLabels: true,
					sliceMargin: 8, 
					startAngle: 0,
					dataLabels: 'percent'
				}
			}, 
			seriesColors:<?php echo json_encode($TPL_VAR["seriesColors2"])?>,
			legend: {      
				show: false,      
				location: 'e',      
				placement: 'outside'    
			},
			grid: {
		        background: 'transparent',
		        borderWidth: 0,
		        shadow: false
		    }
		}
	);

	var data = <?php echo preg_replace("/\"([0-9]+)\"/","$1",json_encode($TPL_VAR["dataLoginChart"]))?>;
	var plot1 = jQuery.jqplot ('chart_login', [data], 
		{ 
			seriesDefaults: {
				// Make this a pie chart.
				renderer: jQuery.jqplot.PieRenderer, 
				rendererOptions: {
					// Put data labels on the pie slices.
					// By default, labels show the percentage of the slice.
					showDataLabels: true,
					sliceMargin: 8, 
					startAngle: 0,
					dataLabels: 'percent'
				}
			}, 
			seriesColors:<?php echo json_encode($TPL_VAR["seriesColors2"])?>,
			legend: {      
				show: false,      
				location: 'e',      
				placement: 'outside'    
			},
			grid: {
		        background: 'transparent',
		        borderWidth: 0,
		        shadow: false
		    }
		}
	);

	var data = <?php echo preg_replace("/\"([0-9]+)\"/","$1",json_encode($TPL_VAR["dataOrderChart"]))?>;
	var plot1 = $.jqplot ('chart_order', [data], 
		{ 
			seriesDefaults: {
				// Make this a pie chart.
				renderer: jQuery.jqplot.PieRenderer, 
				rendererOptions: {
					// Put data labels on the pie slices.
					// By default, labels show the percentage of the slice.
					showDataLabels: true,
					sliceMargin: 8, 
					startAngle: 0,
					dataLabels: 'percent'
				}
			}, 
			seriesColors:<?php echo json_encode($TPL_VAR["seriesColors2"])?>,
			legend: {      
				show: true,      
				location: 'e',      
				placement: 'outside'    
			},
			grid: {
		        background: 'transparent',
		        borderWidth: 0,
		        shadow: false
		    }
		}
	);
<?php }?>
});
</script>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>