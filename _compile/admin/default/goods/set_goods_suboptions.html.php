<?php /* Template_ 2.2.6 2022/05/17 12:31:53 /www/music_brother_firstmall_kr/admin/skin/default/goods/set_goods_suboptions.html 000004615 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin-goodsRegist.js?v=20190321"></script>
<script type="text/javascript" src="/app/javascript/js/admin-goodsaddlayer.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<style>
table.store-stock tr:first-child th {
	border-top:2px solid black !important ;
}
table.store-stock tr:nth-last-child(1) td {
	border-bottom:2px solid black !important ;
}
table.store-stock tr td:first-child {
	border-left:2px solid black !important ;
}
table.store-stock tr th:first-child {
	border-left:2px solid black !important ;
}
table.store-stock tr td:nth-last-child(2) {
	border-left:2px solid red !important ;
}
table.store-stock tr td:nth-last-child(1) {
	border-right:2px solid red !important ;
}
table.store-stock tr:last-child td:nth-last-child(2) {
	border-bottom:2px solid red !important ;
}
table.store-stock tr:last-child td:nth-last-child(1) {
	border-bottom:2px solid red !important ;
}
table.store-stock tr:first-child th:nth-last-child(2) {
	border-top:2px solid red !important ;
	border-left:2px solid red !important ;
}
table.store-stock tr:first-child th:nth-last-child(1) {
	border-top:2px solid red !important ;
	border-right:2px solid red !important ;
}
table.store-stock tr th,td {
	line-height:120% !important;
}
span.wh_option {color:#d13b00;}
</style>

<script>
$(window).on("beforeunload", function() { 
	parent.opener.freqOptionsReload('sub');
})
</script>

<?php if($TPL_VAR["mode"]=='view'||$TPL_VAR["mode"]=='chgPolicy'){?>
<?php $this->print_("view",$TPL_SCP,1);?>

<?php }else{?>
<?php $this->print_("modify",$TPL_SCP,1);?>

<?php }?>


<div id="special_newlist" class="hide">
	<img src="/admin/skin/default/images/design/img_speinfo.jpg" />
</div>

<div id="option_newlist" class="hide">
	<img src="/admin/skin/default/images/design/img_optinfo.jpg" />
</div>



<!-- 직접입력 > 색상, 지역, 날짜  -->
<div id="gdoptdirectmodifylay" class="hide">
	<!-- 직접입력 > 날짜 -->
	<div class="dayinputlay goodsoptiondirectlay hide">
		<span class="help">수동기간은 [생성 및 변경]에서 변경할 수 있습니다.</span>
	</div>

	<!-- 직접입력 > 날짜 -->
	<div class="dayautolay goodsoptiondirectlay hide">
	<span class="help">자동기간은 [생성 및 변경]에서 변경할 수 있습니다.</span>
	</div>

	<div class="goodsoptiondirectlay colordateaddresslay">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
		<tr>
			<td  valign="top" class="center">
				<div class="datelay">
					<input type="text" name="direct_codedate" value="" class="line datepicker"  maxlength="10" size="10" />
				</div>
				<div class="colorlay">
					<input type="text" name="direct_color" value="" class="line colorpickerreview colorpicker"  maxlength="10" size="10" />
				</div>
				<div class="addresslay">
					<input type="text" name="direct_zipcode[]" value="" size="5" class="line direct_zipcode1" /> - <input type="text" name="direct_zipcode[]"   value="" size="5" class="line direct_zipcode2" /> <span class="btn small"><input type="button" class="direct_zipcode_btn" value="우편번호" /></span><br/>
					<input type="text" name="direct_address" value="" size="40" class="line direct_address" /><br/>
					<input type="text" name="direct_addressdetail"  value="" size="40" class="line direct_addressdetail" /><br/>
					<input type="text" name="direct_biztel" value="" title="업체 연락처" size="40" class="line direct_biztel" />
					<!-- <div >map</div> -->
				</div>
			</td>
		</tr>
		</table>
	</div>

	<div class="center" style="padding:10px;">
		<span class="btn large black"><button type="button" id="goodsoptiondirectmodifybtn" newtype="" opttblidx="opttblidx">확인</button></span>
	</div>
</div>

<div class="hide" id="selectGoodsOptionsDialog"></div>
<div id="packageErrorDialog" class="hide"></div>
<iframe name="suboptionFrame" id="suboptionFrame" src="" width="100%" height="600" frameborder="0"   class="hide"></iframe>
<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>

<script>package_unit_ea_display_sub();</script>

<div id="helperMessageShow" class="hide"><span id="helperMessage"></div></div>