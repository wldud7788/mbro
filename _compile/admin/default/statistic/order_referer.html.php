<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/statistic/order_referer.html 000000677 */ ?>
<div class="sub-wrap" style="position:relative;">
	<div class="stistic-data-div">
		<div style="padding:10px 0;text-align:center;font-size:14px;font-weight:bold;">
			위 유입경로의 최근 30일 주문 추이
		</div>
		<div id="chart1" class="sub-chart"></div>
	</div>
</div>
<script class="code" type="text/javascript">
$(document).ready(function(){
	var data	= [<?php echo json_encode($TPL_VAR["dataForChart"])?>];
	createChart('line', 'chart1', '<?php echo $TPL_VAR["maxValue"]?>', data, [], false);
});
</script>