<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/goods/_batch_modify_imagehosting.html 000008274 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
$(document).ready(function() {
	 
	// 바로열기
	$(".btn-direct-open").toggle(function(){
		var nextTr = $(this).parent().parent().next();
		var goods_seq = $(this).parent().parent().find("input[type='checkbox']").val();
		$.get('batch_option_view_imagehosting?mode=view&no='+goods_seq, function(data) {
			nextTr.find('div.option_info').html(data);
			nextTr.find('div.option_info table').addClass('bg-dot-line');
			nextTr.prev().find('td').addClass('border-bottom-none');
		});
		nextTr.removeClass('hide');
		$(this).addClass("opened");

		$(this).parent().parent().find(".option_td input,select").each(function(){
			$(this).attr('disabled',true);
			$(this).attr('readonly',true);
		});

	},function(){
		var nextTr = $(this).parent().parent().next();
		nextTr.find('div.order_info').html('');
		nextTr.prev().find('td').removeClass('border-bottom-none');
		nextTr.addClass('hide');
		$(this).removeClass("opened");

		$(this).parent().parent().find(".option_td input,select").each(function(){
			$(this).attr('disabled',false);
			$(this).attr('readonly',false);
		});
	});	
});
</script>
<br class="table-gap" />

<table class="list-table-style" cellspacing="0">
	<colgroup>
		<col width="15%" /><!--대상 상품-->
		<col /><!--아래와 같이 업데이트-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th>대상 상품</th>
		<th>아래와 같이 업데이트</th>
	</tr>
	</thead>
</table>
<table cellspacing="0" width="100%">
	<col width="15%" /><!--대상 상품-->
	<col /><!--아래와 같이 업데이트-->
	<tbody class="ltb if_category">
		<tr class="list-row" style="height:70px;">
			<td align="center" class="td">
			검색된 상품에서  →
			<select name="modify_list"  class="modify_list">
				<option value="choice">선택 </option>
				<option value="all">전체 </option>
			</select>
			</td>
			<td>
			<table width="100%">
			<col width="30%"/>
			<col />
			<tr>
			<td valign="top"> 
				<div style="padding-top:10px">
				상품 설명 이미지를 이미지 호스팅에 일괄 업로드(<?php echo $TPL_VAR["imagehostingftp"]["imagehostingdir"]?> 디렉토리) 합니다.<br/>
				상품 설명 이미지의 주소(URL)을 이미지 호스팅 주소로 일괄 업데이트 합니다.
				</div>
			</td> 
			</tr>
			</table>
			</td>
		</tr>

	</tbody>
</table>
<script type="text/javascript">
<?php if($TPL_VAR["config_watermark"]["watermark_type"]){?>
$("input[name='watermark_type'][value='<?php echo $TPL_VAR["config_watermark"]["watermark_type"]?>']").attr('checked',true);
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["config_watermark"]["watermark_position"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
$("input[name='watermark_position[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>
</script>

<br class="table-gap" />

<ul class="left-btns clearbox">
	<li>
		<div style="margin-top:rpx;" id="search_count" class="hide">
			총 <b>0</b> 개
		</div>
	</li>
	<li><span class="desc">※ 이용방법 : [검색하기]버튼으로 검색 후 상품정보를 조건 업데이트 하세요!</span></li>
</ul>

<div class="fr">
	<div class="clearbox">
		<ul class="right-btns clearbox">
		<li><select class="custom-select-box-multi" name="orderby">
			<option value="goods_seq" <?php if($TPL_VAR["orderby"]=='goods_seq'){?>selected<?php }?>>최근등록순</option>
			<option value="goods_name" <?php if($TPL_VAR["orderby"]=='goods_name'){?>selected<?php }?>>상품명순</option>
			<option value="page_view" <?php if($TPL_VAR["orderby"]=='page_view'){?>selected<?php }?>>페이지뷰순</option>
		</select></li>
		<li><select  class="custom-select-box-multi" name="perpage">
			<option id="dp_qty10" value="10" <?php if($TPL_VAR["perpage"]== 10){?> selected<?php }?> >10개씩</option>
		</select></li>
	</ul>
	</div>
</div>
<br style="line-height:2px;" />
<table class="list-table-style" cellspacing="0">
	<!-- 테이블 헤더 : 시작 -->
	<colgroup>
		<col width="30" /><!--체크-->   
		<col width="60" /><!--상품이미지-->
		<col  /><!--상품명-->
		<col width="40" /><!--옵션--> 
		<col width="140" /><!--할인가(판매가)--> 
		<col width="140" /><!--재고(가용)--> 
		<col width="140" /><!--이미지 호스팅 변환-->
	</colgroup>
	<thead class="lth">
	<tr>
		<th><input type="checkbox" id="chkAll" /></th> 
		<th colspan="2">상품명</th>
		<th>옵션</th>
		<th>할인가(판매가)</th>
		<th>재고 (가용)</th>
		<th>
			변환일
		</th>
	</tr>
	</thead>
	<!-- 테이블 헤더 : 끝 -->

	<!-- 리스트 : 시작 -->
	<tbody class="ltb">
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr class="list-row" style="height:70px;">
			<td align="center"><input type="checkbox" class="chk" name="goods_seq[]" value="<?php echo $TPL_V1["goods_seq"]?>" /></td>
			<td align="center"><a href="/goods/view?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><img src="<?php echo viewImg($TPL_V1["goods_seq"],'thumbView')?>" width="50"></a></td>
			<td align="left" style="padding-left:10px;">
<?php if($TPL_V1["tax"]=='exempt'&&$TPL_V1["cancel_type"]=='1'){?>
					<div>
					<span style="color:red;" class="left" >[비과세]</span>
					<span class="order-item-cancel-type left" >[청약철회불가]</span>
					</div>
<?php }elseif($TPL_V1["tax"]=='exempt'){?>
					<div>
					<span style="color:red;" class="left" >[비과세]</span>
					</div>
<?php }elseif($TPL_V1["cancel_type"]=='1'){?>
					<div>
					<span class="order-item-cancel-type left" >[청약철회불가]</span>
					</div>
<?php }?>
<?php if($TPL_V1["goods_code"]){?><div class="goods_option fx11 goods_code_icon">[상품코드: <?php echo $TPL_V1["goods_code"]?>]</div><?php }?>
			<a href="../goods/regist?no=<?php echo $TPL_V1["goods_seq"]?>" target="_blank"><?php echo getstrcut($TPL_V1["goods_name"], 80)?></a> <div style="padding-top:5px;"><?php echo $TPL_V1["catename"]?></div>
			</td> 
			<td align="center"><span class="btn-direct-open"><span class="hide">바로열기</span></span></td>
			<td class="option_td" style="text-align:right;padding-right:5px;"><?php echo number_format($TPL_V1["price"])?></td>
			<td class="option_td" align="center"><?php echo number_format($TPL_V1["stock"])?> (<?php echo $TPL_V1["able_stock"]?>)</td>
			<td style="padding-left:15px;" align="center">
<?php if($TPL_V1["convert_image_date"]){?>
				<div><?php echo substr($TPL_V1["convert_image_date"], 0, 10)?></div>
				<div><?php echo substr($TPL_V1["convert_image_date"], 10)?></div>
<?php }else{?>
				<span class="gray">한적없음</span>
<?php }?>
			</td>
		</tr>
		<tr class="order-list-summary-row hide">
			<td colspan="7" class="order-list-summary-row-td option_info_td"><div class="option_info"></div></td>
		</tr>
<?php }}?>
<?php }else{?>
	<tr class="list-row">
		<td align="center" colspan="7">
<?php if($TPL_VAR["search_text"]){?>
				'<?php echo $TPL_VAR["search_text"]?>' 검색된 상품이 없습니다.
<?php }else{?>
				등록된 상품이 없습니다.
<?php }?>
		</td>
	</tr>
<?php }?>
	</tbody>
	<!-- 리스트 : 끝 -->

</table>
<!-- 주문리스트 테이블 : 끝 -->


<?php if($TPL_VAR["openmarketuse"]){?>
<div id="openmarketimghostinglay" class="hide"><?php $this->print_("openmarketimghosting",$TPL_SCP,1);?></div>
<?php }?>

<script type="text/javascript">
<?php if($TPL_VAR["config_system"]["goods_count"]< 10000){?>
$.ajax({
	type: "get",
	url: "./count",
	data: "param=<?php echo $TPL_VAR["param_count"]?>",
	dataType : "json",
	success: function(obj){
		$("div#search_count").removeClass("hide");
		$("div#search_count b").html(comma(obj.cnt));
		var first	= obj.cnt - <?php echo ($_GET["perpage"]*($_GET["page"]- 1))?>;
		$(".page_no").each(function(idx){
			$(this).html(first-idx);
		});
	}
});
<?php }?>
</script>