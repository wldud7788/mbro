<?php /* Template_ 2.2.6 2021/02/03 14:26:20 /www/music_brother_firstmall_kr/selleradmin/skin/default/statistic_goods/goods_sales.html 000008679 */ 
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

<script type="text/javascript">
$(document).ready(function() {
	$("#order_by").live("change", function(){
		$("input[name='order_by']").val($(this).find("option:selected").val());
		$("form[name='sc']").submit();
	});
});

function set_date(start,end){
	$("input[name='sdate']").val(start);
	$("input[name='edate']").val(end);
}
</script>

<style type="text/css">
table.simpledata-table-style thead td.top_title {text-align:center;font-weight:bold;background-color:#eee;}
table.simpledata-table-style tbody td.ltd {text-align:left;padding-left:5px;}
table.simpledata-table-style tbody td.rtd {text-align:right;padding-right:5px;}
table.simpledata-table-style tbody td.nulltd {background-color:#e6e6e6;}
</style>

<!-- ????????? ????????? ??? : ?????? -->
<div id="page-title-bar-area">
	<div id="page-title-bar" class="gray-bar">
		<!-- ?????? ?????? -->
		<ul class="page-buttons-left"></ul>
		<!-- ????????? -->
		<div class="page-title"><h2>?????? ??????</h2></div>
		<!-- ?????? ?????? -->
		<ul class="page-buttons-right"></ul>
	</div>
</div>
<!-- ????????? ????????? ??? : ??? -->

<div class="sub-layout-container body-height-resizing">

<?php $this->print_("goods_menu",$TPL_SCP,1);?>


	<!-- ???????????? ?????? : ??????-->
	<div class='slc-body-wrap'>
		<div class="slc-body">
			<div class="clearbox">
				<div class="item-title fl" style="margin-left:25px;">???????????? - ????????????</div>
				<div class="fr pd20"></div>
			</div>

			<br style="line-height:10px" />

			<div style="width:800px; margin:auto;">
				<div class="search-form-container" style="background-color:#fff;">
					<form name="sc" method="get">
					<input type="hidden" name="order_by" value="<?php echo $TPL_VAR["sc"]["order_by"]?>" />
					<table class="search-form-table" id="search_detail_table">
					<tr>
						<td>
							<table class="sf-option-table">
							<tr>
								<td>
									<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker line"  maxlength="10" size="10" />
									&nbsp;&nbsp;<span class="gray">-</span>&nbsp;&nbsp;
									<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker line" maxlength="10" size="10" />
									&nbsp;&nbsp;
									<span class="btn small"><input type="button" value="??????" onclick="set_date('<?php echo date('Y-m-d')?>','<?php echo date('Y-m-d')?>')" /></span>
									<span class="btn small"><input type="button" value="3??????" onclick="set_date('<?php echo date('Y-m-d',strtotime("-3 day"))?>','<?php echo date('Y-m-d')?>')" /></span>
									<span class="btn small"><input type="button" value="?????????" onclick="set_date('<?php echo date('Y-m-d',strtotime("-7 day"))?>','<?php echo date('Y-m-d')?>')"/></span>
									<span class="btn small"><input type="button" value="1??????" onclick="set_date('<?php echo date('Y-m-d',strtotime("-1 month"))?>','<?php echo date('Y-m-d')?>')"/></span>
									<span class="btn small"><input type="button" value="3??????" onclick="set_date('<?php echo date('Y-m-d',strtotime("-3 month"))?>','<?php echo date('Y-m-d')?>')" /></span>
									<span class="btn small"><input type="button" value="??????" onclick="set_date('','')" /></span>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					</table>
					<table class="search-form-table">
					<tr>
						<td>
							<table>
							<tr>
								<td width="500">
									<table class="sf-keyword-table">
									<tr>
										<td class="sfk-td-txt"><input type="text" name="keyword" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" title="?????????" /></td>
										<td class="sfk-td-btn"><button type="submit"><span>??????</span></button></td>
									</tr>
									</table>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					</table>
					</form>
				</div>
			</div>

			<div style="width:96%; margin:auto;">

				<div class="fr">
					<div class="clearbox">
						<ul class="right-btns clearbox">
							<li>
								<select class="custom-select-box-multi" id="order_by">
									<option value="counts" <?php if($TPL_VAR["sc"]["order_by"]=='counts'){?>selected<?php }?>>??????????????????</option>
								</select>
							</li>
						</ul>
					</div>
				</div>

				<div id="goods_cart_list">
					<table width="100%" class="simpledata-table-style" style="margin:auto;">
					<colgroup>
						<col width="4%" />
						<col />
						<col width="7%" />

						<col width="8%" />
						<col width="7%" />
						<col width="6%" />
						<col width="6%" />
						<col width="6%" />
						<col width="7%" />
						<col width="6%" />
					</colgroup>
					<thead>
					<tr>
						<td class="top_title" colspan="3">?????? ?????? ???</td>
						<td class="top_title" colspan="8" bgcolor="#eeeeee">?????? ????????? ?????? ??????</td>
					</tr>
					<tr>
						<th>??????</th>
						<th>??????</th>
						<th>????????????</th>

						<th>??????/??????</th>
						<th>????????????</th>
						<th>????????????</th>
						<th>???????????????</th>
						<th>???????????????</th>
						<th>??????</th>
					</tr>
					</thead>
					<tbody>
					<!-- <?php if($TPL_VAR["statlist"]){?> -->
						<!-- <?php if($TPL_statlist_1){$TPL_I1=-1;foreach($TPL_VAR["statlist"] as $TPL_V1){$TPL_I1++;?> -->
					<tr>
						<td align="center"><?php echo $TPL_I1+ 1?></td>
						<td class="ltd">
							<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">
							<img class="small_goods_image" src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" onerror="this.src='/data/icon/error/noimage_list.gif';" width="50" align="absmiddle" />
							<span style="mragin-left:5px;"><?php echo $TPL_V1["stat_goods_name"]?></span>
							</a>
						</td>
						<td class="rtd"><?php echo number_format($TPL_V1["review_cnt"])?>???</td>
						<td class="rtd">
						<?php echo number_format($TPL_V1["tstock"])?>/
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 25){?>
							<?php echo number_format($TPL_V1["tstock"]-$TPL_V1["tbadstock"]-$TPL_V1["treservation25"])?>

<?php }else{?>
							<?php echo number_format($TPL_V1["tstock"]-$TPL_V1["tbadstock"]-$TPL_V1["treservation15"])?>

<?php }?>
						</td>
						<td class="rtd"><?php echo number_format($TPL_V1["page_view"])?></td>
						<td class="rtd"><?php echo number_format($TPL_V1["now_cart_cnt"])?></td>
						<td class="rtd"><?php echo number_format($TPL_V1["now_wish_cnt"])?></td>
						<td class="rtd"><?php echo number_format($TPL_V1["now_restock_cnt"])?></td>
						<td class="rtd"><?php echo number_format($TPL_V1["now_review_cnt"])?></td>
					</tr>
						<!-- <?php }}?> -->
					<!-- <?php }else{?> -->
					<tr>
						<td colspan="11" align="center">????????? ????????? ????????????.</td>
					</tr>
					<!-- <?php }?> -->
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>