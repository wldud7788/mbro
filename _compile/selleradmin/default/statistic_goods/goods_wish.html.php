<?php /* Template_ 2.2.6 2022/05/11 10:50:19 /www/music_brother_firstmall_kr/selleradmin/skin/default/statistic_goods/goods_wish.html 000007042 */ 
$TPL_statlist_1=empty($TPL_VAR["statlist"])||!is_array($TPL_VAR["statlist"])?0:count($TPL_VAR["statlist"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

  
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.donutRenderer.min.js"></script>    
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />
<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	gSearchForm.init({'pageid':'goods_wish', 'sc':<?php echo $TPL_VAR["scObj"]?>});
	
	$("#order_by").live("change", function(){
		$("input[name='order_by']").val($(this).find("option:selected").val());
		$("form[name='sc']").submit();
	});
});


</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 좌측 버튼 -->
		<div class="page-buttons-left"></div>
		<!-- 타이틀 -->
		<div class="page-title"><h2>위시리스트 통계</h2></div>
		<!-- 우측 버튼 -->
		<div class="page-buttons-right"></div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<?php $this->print_("goods_menu",$TPL_SCP,1);?>


<div id="search_container" class="search_container">
	<form class='search_form' name="sc">
	<input type="hidden" name="order_by" value="<?php echo $TPL_VAR["sc"]["order_by"]?>" />
	<table class="table_search">	
		<tr>
			<th>상품명</th>
			<td><input type="text" name="keyword" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" size="80" /></td>
		</tr>
		<tr>
			<th>기간</th>
			<td>
				<div class="date_range_form">
					<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10" />
					-
					<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10"  />

					<div class="resp_btn_wrap">
						<input type="button"  range="today" value="오늘" class="select_date resp_btn" />
						<input type="button"  range="3day" value="3일간" class="select_date resp_btn" />
						<input type="button"  range="1week" value="일주일" class="select_date resp_btn" />
						<input type="button"  range="1month" value="1개월" class="select_date resp_btn" />
						<input type="button"  range="3month" value="3개월" class="select_date resp_btn" />
						<input type="button"  range="all"  value="전체" class="select_date resp_btn"/>
						<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden">
					</div>
				</div>
			</td>
		</tr>				
	</table>
	<div class="search_btn_lay"></div>
	</form>
</div>

<!-- 서브메뉴 바디 : 시작-->
<div class="contents_dvs v2">
	<div class="title_dvs">
		<div class="item-title">위시리스트</div>
		<div class="resp_btn_dvs">
			<select id="order_by">
				<option value="counts" <?php if($TPL_VAR["sc"]["order_by"]=='counts'){?>selected<?php }?>>담은 횟수↑</option>
				<option value="users" <?php if($TPL_VAR["sc"]["order_by"]=='users'){?>selected<?php }?>>담은 회원↑</option>
			</select>
		</div>
	</div>

	<div id="goods_cart_list">
		<table class="table_row_basic">
		<colgroup>
			<col width="4%" />
			<col />
			<col width="7%" />
			<col width="6%" />

			<col width="8%" />
			<col width="7%" />
			<col width="6%" />
			<col width="6%" />
			<col width="6%" />
			<col width="7%" />				
		</colgroup>
		<thead>			
		<tr>
			<th>순위</th>
			<th>상품</th>
			<th>담은 횟수</th>
			<th>담은 회원</th>

			<th>재고/가용</th>
			<th>페이지뷰</th>
			<th>장바구니</th>
			<th>위시리스트</th>
			<th>재입고알림</th>
			<th>리뷰</th>
		</tr>
		</thead>
		<tbody>
		<!-- <?php if($TPL_VAR["statlist"]){?> -->
			<!-- <?php if($TPL_statlist_1){$TPL_I1=-1;foreach($TPL_VAR["statlist"] as $TPL_V1){$TPL_I1++;?> -->
		<tr>
			<td align="center"><?php echo $TPL_I1+ 1?></td>
			<td class="left">
				<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">
				<img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50" align="absmiddle" />
				<span style="mragin-left:5px;"><?php echo $TPL_V1["stat_goods_name"]?></span>
				</a>
			</td>
			<td class="right"><?php echo number_format($TPL_V1["goods_cnt"])?>회</td>
			<td class="right"><?php echo number_format($TPL_V1["user_cnt"])?>명</td>
			<td class="right">
			<?php echo number_format($TPL_V1["tstock"])?>/
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 25){?>
				<?php echo number_format($TPL_V1["tstock"]-$TPL_V1["tbadstock"]-$TPL_V1["treservation25"])?>

<?php }else{?>
				<?php echo number_format($TPL_V1["tstock"]-$TPL_V1["tbadstock"]-$TPL_V1["treservation15"])?>

<?php }?>
			</td>
			<td class="right"><?php echo number_format($TPL_V1["page_view"])?></td>
			<td class="right"><?php echo number_format($TPL_V1["now_cart_cnt"])?></td>
			<td class="right"><?php echo number_format($TPL_V1["now_wish_cnt"])?></td>
			<td class="right"><?php echo number_format($TPL_V1["now_restock_cnt"])?></td>
			<td class="right"><?php echo number_format($TPL_V1["now_review_cnt"])?></td>
		</tr>
			<!-- <?php }}?> -->
		<!-- <?php }else{?> -->
		<tr>
			<td colspan="10" align="center">검색된 통계가 없습니다.</td>
		</tr>
		<!-- <?php }?> -->
		</tbody>
		</table>
	</div>
</div>



<?php $this->print_("layout_footer",$TPL_SCP,1);?>