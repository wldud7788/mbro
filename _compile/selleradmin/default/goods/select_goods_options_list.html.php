<?php /* Template_ 2.2.6 2022/05/17 12:29:12 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/select_goods_options_list.html 000004867 */ 
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
<script>
function package_toggle_goods(bobj){
	var objtr = $(bobj);
	$("div#sourceList table tr.list-row").each(function(){
		$(this).css("background-color","#fff");
	});
	objtr.css("background-color","#EBF1DE");
}

$(document).ready(function() {
	package_toggle_goods( $("table#selectPackageGoodsList tr.list-row").eq(0) );
	parent.package_select_goods(<?php echo $TPL_VAR["record"][ 0]["goods_seq"]?>);
});
</script>
<div id="sourceList" style="min-height:245px;">
	<table class="info-table-style" id="selectPackageGoodsList" cellspacing="0" width="100%">
	<colgroup>
		<col />
		<col width="90" />
		<col width="90" />
	</colgroup>
	<thead class="lth">
		<tr>
			<th class="its-th-align center">상품명</th>
			<th class="its-th-align center">상태</th>
			<th class="its-th-align center">노출</th>
		</tr>
	</thead>
	<tbody class="ltb">
<?php if($TPL_VAR["record"]){?>
<?php if($TPL_record_1){foreach($TPL_VAR["record"] as $TPL_V1){?>
		<tr class="list-row hand" style="height:65px;" onclick="package_toggle_goods(this); parent.package_select_goods(<?php echo $TPL_V1["goods_seq"]?>);">
			<td class="its-td-align left">
				<table>
					<col width="70" />
					<col />
					<tr>
						<td align="center"><img class="small_goods_image" src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="40"></td>
						<td>
							<?php echo getstrcut(strip_tags($TPL_V1["goods_name"]), 18)?>

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
							</div>
<?php if($TPL_V1["goods_code"]){?>
							<div>
								[상품코드: <?php echo $TPL_V1["goods_code"]?>]
							</div>
<?php }?>
						</td>
					</tr>
				</table>
			</td>
			<td class="its-td-align center"><span class="fx12"><?php echo $TPL_V1["goods_status_text"]?></span></td>
			<td class="its-td-align center"><span class="fx12"><?php echo $TPL_V1["goods_view_text"]?></span></td>
		</tr>
<?php }}?>
<?php }else{?>
		<tr>
			<td colspan="4" class="its-td-align center">
				검색결과가 없습니다.
			</td>
		</tr>
<?php }?>
	</tbody>
	</table>

	<div style="height:10px"></div>
	<div class="pages">
<?php if($TPL_VAR["page"]["first"]){?>
		<a href="?page=<?php echo $TPL_VAR["page"]["first"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="page first">처음</a>
<?php }?>
<?php if($TPL_VAR["page"]["prev"]){?>
		<a href="?page=<?php echo $TPL_VAR["page"]["prev"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="page prev">이전</a>
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
		<strong class="page sel"><?php echo $TPL_V1?></strong>
<?php }else{?>
		<a href="?page=<?php echo $TPL_V1?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="page page"><?php echo $TPL_V1?></a>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?>
		<a href="?page=<?php echo $TPL_VAR["page"]["next"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="page next">다음</a>
<?php }?>
<?php if($TPL_VAR["page"]["last"]){?>
		<a href="?page=<?php echo $TPL_VAR["page"]["last"]?>&amp;<?php echo $TPL_VAR["page"]["querystring"]?>" class="page last">마지막</a>
<?php }?>
	</div>
</div>
<div></div>
<?php $this->print_("common_html_footer",$TPL_SCP,1);?>