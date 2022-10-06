<?php /* Template_ 2.2.6 2021/08/25 16:21:16 /www/music_brother_firstmall_kr/selleradmin/skin/default/setting/popup_print_setting.html 000010189 */ ?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>

<script src="/app/javascript/plugin/editor/js/editor_loader.js?dummy=20150930"></script>
<script src="/app/javascript/plugin/editor/js/daum_editor_loader.js?dummy=20150930"></script>
<script type="text/javascript">
$(document).ready(function() {
	DaumEditorLoader.init(".daumeditor");

	$("input[name='shopLogoText']").on("click",function(){
		$("input[name='shopLogoType']").each(function(){ $(this).attr('checked',false); });
		$("input[name='shopLogoType'][value='text']").attr('checked',true);
	});

	$("input[name='shopLogoImg']").on("click",function(){
		$("input[name='shopLogoType']").each(function(){ $(this).attr('checked',false); });
		$("input[name='shopLogoType'][value='img']").attr('checked',true);
	});

});

// 프린트 예시 팝업 오픈
function open_print_sample(){
	openDialog('프린트 예시', 'print_add_info_sample', {'width':900, 'height':450});
}

// 상위 radio 버튼 선택에 따른 하위 checkbox disable 처리
function chgSubCheckBox(obj){
	if	($(obj).val()){
		$(obj).closest('div').find('span.subCheckBox').find('input').attr('disabled', false);
	}else{
		$(obj).closest('div').find('span.subCheckBox').find('input').attr('disabled', true);
	}
}
</script>
<style>
ul {padding:0px 0px 0px 10px;}
ul li {padding-top:10px;}
ul li div {padding-top:3px;}
ul li div.input {padding-right:10px;}
li.tx-list div{
	padding-top:0px !important;
}
</style>
<form id="frm_print_setting" name="frm_print_setting" action="../setting_process/print_setting" method="post" enctype="multipart/form-data" target="actionFrame" >

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2><span class="icon-goods-kind-<?php echo $TPL_VAR["goods"]["goods_kind"]?>"></span>프린터 설정</h2>
		</div>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large black"><button type="button" onclick="submitEditorForm(document.frm_print_setting);">저장하기<span class="arrowright"></span></button></span></li>
		</ul>

	</div>
</div>
<div class="item-title">주문내역서</div>
<ul>
	<li>
		<span class="question fx12 black">▶
			주문내역서에 주문상품의
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>출고창고, 로케이션, <?php }?>
			재고, 불량재고, 상품코드, 패키지구성상품명, 추가구성상품의 연결상품명을 출력하시겠습니까?
		</span>
		<div class="input">
			<label><input type="radio" name="orderPrintAddInfo" value="1" <?php if($TPL_VAR["order_addinfo"]){?>checked<?php }?> onclick="chgSubCheckBox(this);" /> 예</label>
			(
			<span class="subCheckBox">
				<label><input type="checkbox" name="orderPrintPackage" value="1" <?php if($TPL_VAR["order_package"]){?>checked<?php }?> <?php if(!$TPL_VAR["orderPrintAddInfo"]){?>disabled<?php }?> /> 패키지구성상품명</label>
				&nbsp; <label><input type="checkbox" name="orderPrintSubRelation" value="1" <?php if($TPL_VAR["order_sub_relation"]){?>checked<?php }?> <?php if(!$TPL_VAR["orderPrintAddInfo"]){?>disabled<?php }?> /> 추가구성상품의 연결상품명</label>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
				&nbsp; <label><input type="checkbox" name="orderPrintWarehouse" value="1" <?php if($TPL_VAR["order_warehouse"]){?>checked<?php }?> <?php if(!$TPL_VAR["orderPrintAddInfo"]){?>disabled<?php }?> /> 출고창고/로케이션/재고/불량재고</label>
<?php }?>
				&nbsp; <label><input type="checkbox" name="orderPrintGoodsCode" value="1" <?php if($TPL_VAR["order_goods_code"]){?>checked<?php }?> <?php if(!$TPL_VAR["orderPrintAddInfo"]){?>disabled<?php }?> /> 상품코드</label>
			</span>
			)
 			&nbsp; <label><input type="radio" name="orderPrintAddInfo" value="" <?php if(!$TPL_VAR["order_addinfo"]){?>checked<?php }?> onclick="chgSubCheckBox(this);" /> 아니오</label>
		</div>
		<div class="btn-ex" style="margin-top:3px;">
			<span class="btn small orange"><button type="button" onclick="open_print_sample();">프린트 예시</button>
		</div>
	</li>
	<li>
		<span class="question fx12 black">▶ 주문내역서에 주문상품의 이미지를 출력하시겠습니까?</span>
		<div class="input">
			<label><input type="radio" name="orderPrintGoodsImage" value="1" <?php if($TPL_VAR["order_goods_image"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="orderPrintGoodsImage" value="" <?php if(!$TPL_VAR["order_goods_image"]){?>checked<?php }?> /> 아니오</label>
		</div>
	</li>
	<li>
		<span class="question fx12 black">▶ 주문내역서 하단에 정보를 출력하시겠습니까?</span>
		<div class="input">
			<label><input type="radio" name="orderPrintCenterInfo" value="1" <?php if($TPL_VAR["order_centerinfo"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="orderPrintCenterInfo" value="" <?php if(!$TPL_VAR["order_centerinfo"]){?>checked<?php }?> /> 아니오</label>
		</div>
		<div align="center" >
			<textarea rows="10" name="orderPrintCenterInfoInput" id="orderPrintCenterInfoInput"   class="daumeditor" contentHeight="100px"><?php echo $TPL_VAR["order_centerinfo_message"]?></textarea>
		</div>
	</li>
</ul>
<div class="item-title">발송(출고)내역서</div>
<ul>
	<li>
		<span class="question fx12 black">▶
			출고내역서에 출고상품의
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>출고창고, <?php }?>
			상품코드, 패키지구성상품명, 추가구성상품의 연결상품명을 출력하시겠습니까?
		</span>
		<div class="input">
			<label><input type="radio" name="exportPrintAddInfo" value="1" <?php if($TPL_VAR["export_addinfo"]){?>checked<?php }?> onclick="chgSubCheckBox(this);" /> 예</label>
			(
			<span class="subCheckBox">
				<label><input type="checkbox" name="exportPrintPackage" value="1" <?php if($TPL_VAR["export_package"]){?>checked<?php }?> <?php if(!$TPL_VAR["exportPrintAddInfo"]){?>disabled<?php }?> /> 패키지구성상품명</label>
				&nbsp; <label><input type="checkbox" name="exportPrintSubRelation" value="1" <?php if($TPL_VAR["export_sub_relation"]){?>checked<?php }?> <?php if(!$TPL_VAR["exportPrintAddInfo"]){?>disabled<?php }?> /> 추가구성상품의 연결상품명</label>
<?php if($TPL_VAR["scm_cfg"]['use']=='Y'){?>
				&nbsp; <label><input type="checkbox" name="exportPrintWarehouse" value="1" <?php if($TPL_VAR["export_warehouse"]){?>checked<?php }?> <?php if(!$TPL_VAR["exportPrintAddInfo"]){?>disabled<?php }?> /> 출고창고</label>
<?php }?>
				&nbsp; <label><input type="checkbox" name="exportPrintGoodsCode" value="1" <?php if($TPL_VAR["export_goods_code"]){?>checked<?php }?> <?php if(!$TPL_VAR["exportPrintAddInfo"]){?>disabled<?php }?> /> 상품코드</label>
			</span>
			)
 			&nbsp; <label><input type="radio" name="exportPrintAddInfo" value="" <?php if(!$TPL_VAR["export_addinfo"]){?>checked<?php }?> onclick="chgSubCheckBox(this);" /> 아니오</label>
		</div>
		<div class="btn-ex" style="margin-top:3px;">
			<span class="btn small orange"><button type="button" onclick="open_print_sample();">프린트 예시</button>
		</div>
	</li>
	<li>
		<span class="question fx12 black">▶ 출고내역서에 주문상품의 이미지를 출력하시겠습니까?</span>
		<div class="input">
			<label><input type="radio" name="exportPrintGoodsImage" value="1" <?php if($TPL_VAR["export_goods_image"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="exportPrintGoodsImage" value="" <?php if(!$TPL_VAR["export_goods_image"]){?>checked<?php }?> /> 아니오</label>
		</div>
	</li>
	<li>
		<span class="question fx12 black">▶ 출고내역서 하단에 정보를 출력하시겠습니까?</span>
		<div class="input">
			<label><input type="radio" name="exportPrintCenterInfo" value="1" <?php if($TPL_VAR["export_centerinfo"]){?>checked<?php }?> /> 예</label> &nbsp; <label><input type="radio" name="exportPrintCenterInfo" value="" <?php if(!$TPL_VAR["export_centerinfo"]){?>checked<?php }?> /> 아니오</label>
		</div>
		<div class="input" width="98%">
			<textarea style="width:100%;height:100px;" contentHeight="100" name="exportPrintCenterInfoInput" id="exportPrintCenterInfoInput" class="daumeditor"><?php echo $TPL_VAR["export_centerinfo_message"]?></textarea>
		</div>
	</li>
</ul>

<div class="item-title">공통</div>
<ul>
	<li>
	<span class="question fx12 black">내역서 타이틀 우측에 로고 또는 타이틀 삽입</span>
	<div class="input">
		<label>
			<input type="radio" name="shopLogoType" value="text" <?php if($TPL_VAR["shop_logo_type"]=='text'){?>checked<?php }?> onclick="" />
			<input name="shopLogoText" type="text" value="<?php echo $TPL_VAR["shop_logo_text"]?>" size="40" />
			<span class="desc">예시) 퍼스트몰</span>
		</label>
	</div>
	<div class="input">
		<label>
			<input type="radio" name="shopLogoType" value="img" <?php if($TPL_VAR["shop_logo_type"]=='img'){?>checked<?php }?> />
			<input type="file" name="shopLogoImg" style="letter-spacing:-1px !important" />
<?php if($TPL_VAR["shop_logo_img"]){?>
			<div style="padding:5px 0px 0px 20px;"><img src="<?php echo $TPL_VAR["shop_logo_img"]?>" border="0" style="max-width:50px;max-height:50px;"></div>
<?php }?>
		</label>
	</div>
	</li>
</ul>
<div style="padding:0px 0px 50px 0px;"></div>
</form>

<div id="print_add_info_sample" class="hide">
	<img src="/admin/skin/default/images/common/print_add_info_sample.gif" width="100%" />
</div>

<script type="text/javascript">
<?php if($TPL_VAR["order_addinfo"]){?> 
	var obj = $("input[name='orderPrintAddInfo'][value='1']");
	chgSubCheckBox(obj);
<?php }?>
<?php if($TPL_VAR["export_addinfo"]){?>
	var obj = $("input[name='exportPrintAddInfo'][value='1']");
	chgSubCheckBox(obj);
<?php }?>
</script>

<?php $this->print_("layout_footer_popup",$TPL_SCP,1);?>