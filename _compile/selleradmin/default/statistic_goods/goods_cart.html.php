<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/selleradmin/skin/default/statistic_goods/goods_cart.html 000008891 */ 
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
		gSearchForm.init({'pageid':'goods_cart', 'sc':<?php echo $TPL_VAR["scObj"]?>});

<?php if(!$TPL_VAR["statistic_goods_detail_limit"]){?>
		$("#order_by").live("change", function(){
			$("input[name='order_by']").val($(this).find("option:selected").val());
			$("form[name='sc']").submit();
		});

<?php }else{?>
			openDialog("????????? ??????????????? ??????<span class='desc'></span>", "nofreeService", {"width":600,"height":200});
<?php }?>
	});

</script>

<!-- ????????? ????????? ??? : ?????? -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- ?????? ?????? -->
		<div class="page-buttons-left"></div>
		<!-- ????????? -->
		<div class="page-title"><h2>???????????? ??????</h2></div>
		<!-- ?????? ?????? -->
		<div class="page-buttons-right"></div>
	</div>
</div>
<!-- ????????? ????????? ??? : ??? -->

<!-- <?php if(!$TPL_VAR["statistic_goods_detail_limit"]){?> -->

<div id="search_container" class="search_container">
	<form class='search_form' name="sc">
	<input type="hidden" name="order_by" value="<?php echo $TPL_VAR["sc"]["order_by"]?>" />
	<table class="table_search">	
		<tr>
			<th>?????????</th>
			<td><input type="text" name="keyword" value="<?php echo $TPL_VAR["sc"]["keyword"]?>" size="80" /></td>
		</tr>
		<tr>
			<th>??????</th>
			<td>
				<div class="date_range_form">
					<input type="text" name="sdate" value="<?php echo $TPL_VAR["sc"]["sdate"]?>" class="datepicker sdate"  maxlength="10" />
					-
					<input type="text" name="edate" value="<?php echo $TPL_VAR["sc"]["edate"]?>" class="datepicker edate" maxlength="10"  />

					<div class="resp_btn_wrap">
						<input type="button"  range="today" value="??????" class="select_date resp_btn" />
						<input type="button"  range="3day" value="3??????" class="select_date resp_btn" />
						<input type="button"  range="1week" value="?????????" class="select_date resp_btn" />
						<input type="button"  range="1month" value="1??????" class="select_date resp_btn" />
						<input type="button"  range="3month" value="3??????" class="select_date resp_btn" />
						<input type="button"  range="all"  value="??????" class="select_date resp_btn"/>
						<input name="select_date_regist" value="<?php echo $TPL_VAR["sc"]["select_date_regist"]?>" class="select_date_input" type="hidden">
					</div>
				</div>
			</td>
		</tr>				
	</table>
	<div class="search_btn_lay"></div>
	</form>
</div>

<!-- ???????????? ?????? : ??????-->
<div class="contents_dvs v2">
	<div class="title_dvs">
		<div class="item-title">????????????</div>
		<div class="resp_btn_dvs">
			<select id="order_by">
				<option value="counts" <?php if($TPL_VAR["sc"]["order_by"]=='counts'){?>selected<?php }?>>?????? ?????????</option>
				<option value="users" <?php if($TPL_VAR["sc"]["order_by"]=='users'){?>selected<?php }?>>?????? ?????????</option>
			</select>
		</div>
	</div>

	<div id="goods_cart_list">
		<table class="table_row_basic">
			<colgroup>
				<col width="6%" />
				<col />
				<col width="8%" />
				<col width="8%" />
				<col width="8%" />
				<col width="8%" />
				<col width="8%" />
				<col width="8%" />
				<col width="8%" />
				<col width="8%" />					
			</colgroup>
			<thead>					
				<tr>
					<th>??????</th>
					<th>??????</th>
					<th>?????? ??????</th>
					<th>?????? ??????</th>
					<th>??????/??????</th>
					<th>????????????</th>
					<th>????????????</th>
					<th>???????????????</th>
					<th>???????????????</th>
					<th>??????</th>
				</tr>
			</thead>
			<tbody>			
<?php if($TPL_statlist_1){$TPL_I1=-1;foreach($TPL_VAR["statlist"] as $TPL_V1){$TPL_I1++;?>
				<tr>
					<td align="center"><?php echo ($TPL_I1+ 1)?></td>
					<td class="left">
						<a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank">
						<img class="small_goods_image" src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" onerror="this.src='/data/icon/error/noimage_list.gif';" width="50" align="absmiddle" />
						<span style="mragin-left:5px;"><?php echo $TPL_V1["goods_name"]?></span>
						</a>
					</td>
					<td class="right"><?php echo number_format($TPL_V1["goods_cnt"])?>???</td>
					<td class="right"><?php echo number_format($TPL_V1["goods_user_cnt"])?>???</td>
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
<?php if(is_array($TPL_R2=$TPL_V1["options"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["option1"]!=null||$TPL_V2["option2"]!=null||$TPL_V2["option3"]!=null||$TPL_V2["option4"]!=null||$TPL_V2["option5"]!=null){?>
				<tr>
					<td></td>
					<td class="left optiontd">
						<img src="/admin/skin/default/images/common/icon_option.gif" />
<?php if($TPL_V2["option1"]!=null){?><?php echo $TPL_V2["option1"]?> <?php }?>
<?php if($TPL_V2["option2"]!=null){?><?php echo $TPL_V2["option2"]?> <?php }?>
<?php if($TPL_V2["option3"]!=null){?><?php echo $TPL_V2["option3"]?> <?php }?>
<?php if($TPL_V2["option4"]!=null){?><?php echo $TPL_V2["option4"]?> <?php }?>
<?php if($TPL_V2["option5"]!=null){?><?php echo $TPL_V2["option5"]?> <?php }?>
					</td>
					<td class="right"><?php echo number_format($TPL_V2["option_cnt"])?>???</td>
					<td class="right"><?php echo number_format($TPL_V2["option_user_cnt"])?>???</td>
					<td class="right">
					<?php echo number_format($TPL_V2["stock"])?>/
<?php if($TPL_VAR["cfg_order"]["ableStockStep"]== 25){?>
						<?php echo number_format($TPL_V2["stock"]-$TPL_V2["badstock"]-$TPL_V2["reservation25"])?>

<?php }else{?>
						<?php echo number_format($TPL_V2["stock"]-$TPL_V2["badstock"]-$TPL_V2["reservation15"])?>

<?php }?>
					</td>
					<td class="nulltd">&nbsp;</td>
					<td class="nulltd">&nbsp;</td>
					<td class="nulltd">&nbsp;</td>
					<td class="nulltd">&nbsp;</td>
					<td class="nulltd">&nbsp;</td>				
				</tr>
<?php }?>
<?php }}?>
<?php }}else{?>
				<tr>
					<td colspan="10" align="center">????????? ????????? ????????????.</td>
				</tr>
<?php }?>
			</tbody>
		</table>
	</div>
</div>
<?php }?>	



<?php $this->print_("layout_footer",$TPL_SCP,1);?>