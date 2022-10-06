<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/statistic/statistic_order.html 000001490 */ ?>
<div class="sub-wrap" style="position:relative;">
<?php if($TPL_VAR["advanced_statistic_limit"]=='y'){?>
	<div class="upgrade-for-free-graph"></div>
	<div class="upgrade-for-free-graph_btn">
		<img src="/admin/skin/default/images/common/btn_upgrade_free.png" style="cursor:pointer;" onclick="window.open('https://firstmall.kr/ec_hosting/addservice/frelocate.php?p=upgrade&s=P_FREE');" />
	</div>
<?php }?>
	<div class="sub-select-bar">
		<select name="date_term" class="sub-selectbox">
			<option value="yesterday" <?php if($_GET["date_term"]=='yesterday'){?>selected<?php }?>>어제</option>
			<option value="today" <?php if($_GET["date_term"]=='today'){?>selected<?php }?>>오늘</option>
			<option value="7days" <?php if($_GET["date_term"]=='7days'){?>selected<?php }?>>최근 7일</option>
			<option value="30days" <?php if($_GET["date_term"]=='30days'){?>selected<?php }?>>30일</option>
		</select>
	</div>

	<div class="stistic-data-div">
		<div id="chart1" class="sub-chart"></div>
	</div>
</div>

<script class="code" type="text/javascript">
$(document).ready(function(){
	var data	= [];
	var label	= [];
	var line1	= <?php echo json_encode($TPL_VAR["dataForChart"])?>;
	data		= [line1];
	label		= [];
	createChart('line', 'chart1', '<?php echo $TPL_VAR["maxValue"]?>', data, label, false);
});
</script>