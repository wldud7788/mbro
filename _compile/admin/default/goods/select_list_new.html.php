<?php /* Template_ 2.2.6 2022/05/17 12:31:53 /www/music_brother_firstmall_kr/admin/skin/default/goods/select_list_new.html 000005738 */ 
$TPL_record_1=empty($TPL_VAR["record"])||!is_array($TPL_VAR["record"])?0:count($TPL_VAR["record"]);?>
<?php $this->print_("common_html_header",$TPL_SCP,1);?>


<style>
.pages {text-align:center;}
.pages .page { display:inline-block;border:1px solid #ddd; padding:2px; width:14px;height:14px; }
.pages a.page:link,.pages a.page:active,.pages a.page:visited {color:#666; text-decoration:none;}
.pages a.page:hover { background-color:#eee;color:#f63; text-decoration:none;}
.pages .page.sel { background-color:#eee; }
.pages a.page.first,.pages .page.prev,.pages .page.next { width:30px; }
.pages a.page.last { width:42px; }
</style>

<div id="sourceList" style="min-height:245px;">
	<!-- 주문리스트 테이블 : 시작 -->
	<table class="list-table-style" cellspacing="0" border=0>

	<colgroup>
		<col width="70" />
		<col />
		<col width="90" />
		<col width="90" />
		<col width="90" />
		<col width="70" />
		<col width="60" />
		<col width="60" />
	</colgroup>

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["record"]){?>
	<!-- <?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?> -->
		<tr class="list-row" style="height:30px;">
			<td align="center"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img class="small_goods_image" src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="30"></a></td>

			<td align="left" style="padding-left:5px;">

				<a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 80)?></a>

				<div>
<?php if($TPL_V1["adult_goods"]=='Y'){?>
					<img src="/admin/skin/default/images/common/auth_img.png" alt="성인" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V1["option_international_shipping_status"]=='y'){?>
					<img src="/admin/skin/default/images/common/icon/plane_on.png" alt="해외배송상품" style="vertical-align: middle;" height="19" />
<?php }?>
<?php if($TPL_V1["cancel_type"]=='1'){?>
					<img src="/admin/skin/default/images/common/icon/nocancellation.gif" alt="청약철회" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V1["tax"]=='exempt'){?>
					<img src="/admin/skin/default/images/common/icon/taxfree.gif" alt="비과세" style="vertical-align: middle;"/>
<?php }?>
<?php if($TPL_V1["provider_name"]){?>
					[<?php echo $TPL_V1["provider_name"]?>]
<?php }?>
<?php if($TPL_V1["goods_code"]){?>
					<a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank" class="fx11">[상품코드: <?php echo $TPL_V1["goods_code"]?>]</a>
<?php }?>
				</div>
			</td>
			<td align="right"><span class="fx11"><?php echo get_currency_price($TPL_V1["consumer_price"])?>&nbsp;&nbsp;</span></td>
			<td align="right"><span class="fx11"><?php echo get_currency_price($TPL_V1["price"])?>&nbsp;&nbsp;</span></td>
			<td align="right">
				<span class="fx11">
<?php if($TPL_V1["tot_stock"]< 0){?><span style='color:red'><?php echo number_format($TPL_V1["stock"])?></span>
<?php }else{?><?php echo number_format($TPL_V1["stock"])?><?php }?>
<?php if($TPL_V1["rstock"]< 0){?>/<span style='color:red'><?php echo number_format($TPL_V1["rstock"])?></span>
<?php }else{?>/<?php echo number_format($TPL_V1["rstock"])?><?php }?>
				</span>
				&nbsp;
			</td>
			<td align="center"><span class="fx12"><?php echo $TPL_V1["goods_status_text"]?></span></td>
			<td align="center"><span class="fx12"><?php echo $TPL_V1["goods_view_text"]?></span></td>
			<td align="center">
<?php if($TPL_V1["match_selectable"]=='Y'){?>
				<span class="btn small cyanblue">
					<button type="button" onclick="parent.get_option_select('<?php echo $_GET["cart_table"]?>','<?php echo $TPL_V1["goods_seq"]?>','','');">선택</button>
				</span>
<?php }else{?>
				<span class="btn small gray">
					<button type="button">불가</button>
				</span>
<?php }?>
			</td>

		</tr>
	<!-- <?php }}?> -->
<?php }else{?>
	<tr>
		<td colspan="8" class="center" style="height:40px;border-bottom:1px solid #ddd;">
			검색결과가 없습니다.
		</td>
	</tr>
<?php }?>
	</table>

	<div style="height:10px"></div>
	<div class="pages">
<?php if($TPL_VAR["page"]["first"]){?>
		<a href="select_list_new?page=<?php echo $TPL_VAR["page"]["first"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="page first">처음</a>
<?php }?>
<?php if($TPL_VAR["page"]["prev"]){?>
		<a href="select_list_new?page=<?php echo $TPL_VAR["page"]["prev"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="page prev">이전</a>
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
		<strong class="page sel"><?php echo $TPL_V1?></strong>
<?php }else{?>
		<a href="select_list_new?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="page page"><?php echo $TPL_V1?></a>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?>
		<a href="select_list_new?page=<?php echo $TPL_VAR["page"]["next"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="page next">다음</a>
<?php }?>
<?php if($TPL_VAR["page"]["last"]){?>
		<a href="select_list_new?page=<?php echo $TPL_VAR["page"]["last"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="page last">마지막</a>
<?php }?>
	</div>

</div>

<iframe name="hiddenFrame" width="100%" height="330" class="hide"></iframe>


<?php $this->print_("common_html_footer",$TPL_SCP,1);?>