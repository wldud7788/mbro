<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/setting/grade_modify.html 000028130 */ 
$TPL_icons_1=empty($TPL_VAR["icons"])||!is_array($TPL_VAR["icons"])?0:count($TPL_VAR["icons"]);
$TPL_myicons_1=empty($TPL_VAR["myicons"])||!is_array($TPL_VAR["myicons"])?0:count($TPL_VAR["myicons"]);?>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript">
function useTypeCont(id, name){
	if(!$(id).attr("checked")){
		$("#"+name).attr('disabled',true);
	}else{
		$("#"+name).attr('disabled',false);
	}
}

function chkUseType(value){
	if(value=='AUTO'){
		$("input:checkbox[name='order_sum_use[]']").attr('disabled',false);
		$("input:[name='add_point']").attr("disabled",false);
		//useTypeCont("#osu0","order_sum_price");
		$("input[name='order_sum_price']").attr('disabled',false);
		//AUTOPART
		reset_input_box('autopart');
		$("input:checkbox[name='order_sum_use2[]']").attr('disabled',true);
		$("input[name='order_sum_price2']").attr('disabled',true);
		$("input[name='order_sum_ea2']").attr('disabled',true);
		$("input[name='order_sum_cnt2']").attr('disabled',true);
		useTypeCont("#osu1","order_sum_ea");
		useTypeCont("#osu2","order_sum_cnt");
		$(".content2").show();
		$(".auto").show();	
		$(".autopart").hide();	
	}else if(value=='AUTOPART'){
		$("input:checkbox[name='order_sum_use2[]']").attr('disabled',false);
		$("input:[name='add_point']").attr("disabled",false);
		$("input[name='order_sum_price2']").attr('disabled',false);
		//AUTO
		reset_input_box('auto');
		$("input:checkbox[name='order_sum_use[]']").attr('disabled',true);
		$("input[name='order_sum_price']").attr('disabled',true);
		$("input[name='order_sum_ea']").attr('disabled',true);
		$("input[name='order_sum_cnt']").attr('disabled',true);
		useTypeCont("#osup1","order_sum_ea2");
		useTypeCont("#osup2","order_sum_cnt2");
		$(".content2").show();
		$(".autopart").show();	
		$(".auto").hide();	
	}else{
		$("input:[name='add_point']").attr("disabled",true);
		//AUTO
		reset_input_box('auto');
		$("input:checkbox[name='order_sum_use[]']").attr('disabled',true);
		$("input[name='order_sum_price']").attr('disabled',true);
		$("input[name='order_sum_ea']").attr('disabled',true);
		$("input[name='order_sum_cnt']").attr('disabled',true);
		//AUTOPART
		reset_input_box('autopart');
		$("input:checkbox[name='order_sum_use2[]']").attr('disabled',true);
		$("input[name='order_sum_price2']").attr('disabled',true);
		$("input[name='order_sum_ea2']").attr('disabled',true);
		$("input[name='order_sum_cnt2']").attr('disabled',true);
		$(".content2").hide();
	
	}

}

function reset_input_box(type) {
	if (type == 'autopart') {
		$("input:checkbox[name='order_sum_use2[]']").attr('checked',false);
		$("input[name='order_sum_price2']").val('');
		$("input[name='order_sum_ea2']").val('');
		$("input[name='order_sum_cnt2']").val('');
	} else if (type == 'auto') {
		$("input:checkbox[name='order_sum_use[]']").attr('checked',false);
		$("input[name='order_sum_price']").val('');
		$("input[name='order_sum_ea']").val('');
		$("input[name='order_sum_cnt']").val('');
	}
}

$(document).ready(function() {
	// 산정기준
	$("input:radio[name='use_type']").click(function(){
		chkUseType($(this).val());
	});
	// 산정기준:조건
	$("#osu0").click(function(){
		//useTypeCont("#osu0","order_sum_price");
	});
	$("#osu1").click(function(){
		useTypeCont("#osu1","order_sum_ea");
	});
	$("#osu2").click(function(){
		useTypeCont("#osu2","order_sum_cnt");
	});

	$("#osup0").click(function(){
		//useTypeCont("#osu0","order_sum_price");
	});
	$("#osup1").click(function(){
		useTypeCont("#osup1","order_sum_ea2");
	});
	$("#osup2").click(function(){
		useTypeCont("#osup2","order_sum_cnt2");
	});

	//
<?php if($TPL_VAR["data"]["use_type"]){?>
		$("input:radio[name='use_type']").val(['<?php echo $TPL_VAR["data"]["use_type"]?>']);
		$("input:radio[name='sale_use']").val(['<?php echo $TPL_VAR["data"]["sale_use"]?>']);
		$("select[name='sale_price_type']").val(['<?php echo $TPL_VAR["data"]["sale_price_type"]?>']);
		$("select[name='sale_target']").val(['<?php echo $TPL_VAR["data"]["sale_target"]?>']);
		$("input:radio[name='point_use']").val(['<?php echo $TPL_VAR["data"]["point_use"]?>']);
		$("select[name='point_price_type']").val(['<?php echo $TPL_VAR["data"]["point_price_type"]?>']);
		$("select[name='point_target']").val(['<?php echo $TPL_VAR["data"]["point_target"]?>']);
<?php if(is_array($TPL_R1=$TPL_VAR["data"]["order_sum_arr"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		$("input[name='order_sum_use[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
		$("input[name='order_sum_use2[]'][value='<?php echo $TPL_V1?>']").attr('checked',true);
<?php }}?>
<?php }else{?>
		$("input:radio[name='use_type']").val(['MANUAL']);
		$("input:radio[name='sale_use']").val(['N']);
		$("input:radio[name='point_use']").val(['N']);
<?php }?>

	if ("<?php echo $TPL_VAR["data"]["use_type"]?>"=="AUTO") {
		reset_input_box("autopart");
	} else if ("<?php echo $TPL_VAR["data"]["use_type"]?>"=="AUTOPART") {
		reset_input_box("auto");
	} else {
		reset_input_box("auto");
		reset_input_box("autopart");
	}

<?php if($TPL_VAR["data"]["group_seq"]> 1){?>
		useTypeCont("#osu0","order_sum_price");
		useTypeCont("#osu1","order_sum_ea");
		useTypeCont("#osu2","order_sum_cnt");
		useTypeCont("#osup0","order_sum_price2");
		useTypeCont("#osup1","order_sum_ea2");
		useTypeCont("#osup2","order_sum_cnt2");
<?php }elseif($TPL_VAR["data"]["group_seq"]== 1){?>
		useTypeCont("#osu1","order_sum_ea");
		useTypeCont("#osu2","order_sum_cnt");
		useTypeCont("#osup1","order_sum_ea2");
		useTypeCont("#osup2","order_sum_cnt2");
<?php }?>

	
	
<?php if($TPL_VAR["data"]["group_seq"]> 1){?>chkUseType('<?php echo $TPL_VAR["data"]["use_type"]?>');<?php }?>

	$("input[name='sale_use']").click(function(){
		if($(this).val()=='Y'){
			$("input[name='sale_limit_price']").attr("disabled",false);
			//$("input[name='sale_price']").attr("disabled",false);
			//$("#issueGoods").show();
			//$("#issueCategory").show();
		}else{
			$("input[name='sale_limit_price']").attr("disabled",true);
			//$("input[name='sale_price']").attr("disabled",true);
			//$("#issueGoods").hide();
			//$("#issueCategory").hide();
		}
	});

	if($("input:radio[name='sale_use']:checked").val()=='Y'){
		$("input[name='sale_limit_price']").attr("disabled",false);
		//$("input[name='sale_price']").attr("disabled",false);
	}else{
		$("input[name='sale_limit_price']").attr("disabled",true);
		//$("input[name='sale_price']").attr("disabled",true);
	}

	$("input[name='point_use']").click(function(){
		if($(this).val()=='Y'){
			$("input[name='point_limit_price']").attr("disabled",false);
			//$("input[name='point_price']").attr("disabled",false);
			//$("#exceptIssueGoods").show();
			//$("#exceptIssueCategory").show();
		}else{
			$("input[name='point_limit_price']").attr("disabled",true);
			//$("input[name='point_price']").attr("disabled",true);
			//$("#exceptIssueGoods").hide();
			//$("#exceptIssueCategory").hide();
		}
	});

	if($("input:radio[name='point_use']:checked").val()=='Y'){
		$("input[name='point_limit_price']").attr("disabled",false);
		//$("input[name='point_price']").attr("disabled",false);
	}else{
		$("input[name='point_limit_price']").attr("disabled",true);
		//$("input[name='point_price']").attr("disabled",true);
	}

	$("select[name='sale_target']").live("change",function(){
		if($(this).val()=='GOODS'){
			$("#sale_select_goods").show();
			$("#sale_select_category").hide();
		}else if($(this).val()=='CATEGORY'){
			$("#sale_select_goods").hide();
			$("#sale_select_category").show();
		}else{
			$("#sale_select_goods").hide();
			$("#sale_select_category").hide();
		}
	});

	$("select[name='point_target']").live("change",function(){
		if($(this).val()=='GOODS'){
			$("#point_select_goods").show();
			$("#point_select_category").hide();
		}else if($(this).val()=='CATEGORY'){
			$("#point_select_goods").hide();
			$("#point_select_category").show();
		}else{
			$("#point_select_goods").hide();
			$("#point_select_category").hide();
		}
	});

	$("form#gradeFrm button#exceptIssueGoodsButton").bind("click",function(){
		//if($("input:radio[name='point_use']:checked").val()=='N') return;
		set_goods_list("exceptIssueGoodsSelect","exceptIssueGoods");
	});
	$("#exceptIssueGoods").sortable();
	$("#exceptIssueGoods").disableSelection();

	// SALE
	$("form#gradeFrm button#issueGoodsButton").bind("click",function(){
		//if($("input:radio[name='sale_use']:checked").val()=='N') return;
		set_goods_list("issueGoodsSelect","issueGoods");
	});
	$("#issueGoods").sortable();
	$("#issueGoods").disableSelection();


	// ICON	
	$("button#iconBtn").live("click",function(){
		
		openDialog("아이콘 선택  <span class='desc'>아이콘으로 사용할 이미지를 등록해 주세요.</span>", "iconPopup", {"width":"350","height":"300","show" : "fade","hide" : "fade"});
	});
	
	// MYICON	
	$("button#myiconBtn").live("click",function(){
		
		openDialog("아이콘 선택  <span class='desc'>아이콘으로 사용할 이미지를 등록해 주세요.</span>", "myiconPopup", {"width":"350","height":"400","show" : "fade","hide" : "fade"});
	});
	

	$(".icons").live("click",function(){
		var img		= $(this).attr("filenm");
		var html	= "<img class='icons' src=\""+$(this).attr('src')+"\" align='absmiddle'>";
		$("#imgHtml").html(html);
		$("#iconPreview").show();
		$("input[name='icon']").val(img);
		closeDialog("iconPopup");
	});

	$(".myicons").live("click",function(){
		var img = $(this).attr("filenm");
		var html = "<img class='myicons' src=\""+$(this).attr('src')+"\" align='absmiddle'>";
		$("#myimgHtml").html(html);
		$("#myIconPreview").show();
		$("input[name='myicon']").val(img);
		closeDialog("myiconPopup");
	});
	
	$("#removeIcon").live("click", function() {
		$("#gradeFrm #imgHtml").html('');	
		$("#iconPreview").hide();
		$("#gradeFrm input[name='icon']").val('');
		openDialogAlert('삭제되었습니다.','400','140',function(){},[]);
	});
	
	$("#removeMyicon").live("click", function() {
		$("#gradeFrm #myimgHtml").html('');
		$("#myIconPreview").hide();
		$("#gradeFrm input[name='myicon']").val('');
		openDialogAlert('삭제되었습니다.','400','140',function(){},[]);
	});

	apply_input_style();	


});

function myiconDisplay(filenm){
	var html = "<img src=\"../../data/icon/mypage/"+filenm+"\" class=\"hand hide myicons\" filenm=\""+filenm+"\" onload='myicon_click(this);'>";
	$("#myiconDisplay").html(html);
}

function set_goods_list(displayId,inputGoods){
	$.ajax({
		type: "get",
		url: "../goods/select",
		data: "page=1&inputGoods="+inputGoods+"&displayId="+displayId,
		success: function(result){
			$("div#"+displayId).html(result);
		}
	});
	openDialog("상품 검색", displayId, {"width":"1000","height":"700","show" : "fade","hide" : "fade"});
}

$(function () {
	/* 카테고리 불러오기 */
	category_admin_select_load('','category1','');
	$("select[name='category1']").bind("change",function(){
		category_admin_select_load('category1','category2',$(this).val());
		category_admin_select_load('category2','category3',"");
		category_admin_select_load('category3','category4',"");
	});
	$("select[name='category2']").bind("change",function(){
		category_admin_select_load('category2','category3',$(this).val());
		category_admin_select_load('category3','category4',"");
	});
	$("select[name='category3']").bind("change",function(){
		category_admin_select_load('category3','category4',$(this).val());
	});

	$("button#issueCategoryButton").bind("click",function(){
		//if($("input:radio[name='sale_use']:checked").val()=='N') return;
		var obj;
		var category;
		var categoryCode;

		obj = $("select[name='category1']");
		if(obj.val()){
			category = $("select[name='category1'] option[value='"+obj.val()+"']").html();
			categoryCode = obj.val();
		}
		obj = $("select[name='category2']");
		if(obj.val()){
			category += " > " + $("select[name='category2'] option[value='"+obj.val()+"']").html();
			categoryCode = obj.val();
		}
		obj = $("select[name='category3']");
		if(obj.val()){
			category += " > " + $("select[name='category3'] option[value='"+obj.val()+"']").html();
			categoryCode = obj.val();
		}
		var obj = $("select[name='category4']");
		if(obj.val()){
			category += " > " + $("select[name='category4'] option[value='"+obj.val()+"']").html();
			categoryCode = obj.val();
		}

		if(category){
			if($("input[name='issueCategoryCode[]'][value='"+categoryCode+"']").length == 0){
				var tag = "<div style='padding:5px;'><span style='display:inline-block;width:300px'>"+category+"</span>";
				tag += "<span class='btn-minus'><button type='button' class='delCategory'></button></span>";
				tag += "<input type='hidden' name='issueCategoryCode[]' value='"+categoryCode+"' /></div>";
				$("div#issueCategory").append(tag);
			}
		}
	});

	category_admin_select_load('','exceptCategory1','');
	$("select[name='exceptCategory1']").bind("change",function(){
		category_admin_select_load('exceptCategory1','exceptCategory2',$(this).val());
		category_admin_select_load('exceptCategory2','exceptCategory3',"");
		category_admin_select_load('exceptCategory3','exceptCategory4',"");
	});
	$("select[name='exceptCategory2']").bind("change",function(){
		category_admin_select_load('exceptCategory2','exceptCategory3',$(this).val());
		category_admin_select_load('exceptCategory3','exceptCategory4',"");
	});
	$("select[name='exceptCategory3']").bind("change",function(){
		category_admin_select_load('exceptCategory3','exceptCategory4',$(this).val());
	});

	$("button#exceptIssueCategoryButton").bind("click",function(){
		//if($("input:radio[name='point_use']:checked").val()=='N') return;
		var obj;
		var category;
		var categoryCode;

		obj = $("select[name='exceptCategory1']");
		if(obj.val()){
			category = $("select[name='exceptCategory1'] option[value='"+obj.val()+"']").html();
			categoryCode = obj.val();
		}
		obj = $("select[name='exceptCategory2']");
		if(obj.val()){
			category += " > " + $("select[name='exceptCategory2'] option[value='"+obj.val()+"']").html();
			categoryCode = obj.val();
		}
		obj = $("select[name='exceptCategory3']");
		if(obj.val()){
			category += " > " + $("select[name='exceptCategory3'] option[value='"+obj.val()+"']").html();
			categoryCode = obj.val();
		}
		var obj = $("select[name='exceptCategory4']");
		if(obj.val()){
			category += " > " + $("select[name='exceptCategory4'] option[value='"+obj.val()+"']").html();
			categoryCode = obj.val();
		}

		if(category){
			if($("input[name='exceptIssueCategoryCode[]'][value='"+categoryCode+"']").length == 0){
				var tag = "<div style='padding:5px;'><span style='display:inline-block;width:300px'>"+category+"</span>";
				tag += "<span class='btn-minus'><button type='button' class='delCategory'></button></span>";
				tag += "<input type='hidden' name='exceptIssueCategoryCode[]' value='"+categoryCode+"' /></div>";
				$("div#exceptIssueCategory").append(tag);
			}
		}
	});

	$("form#gradeFrm button.delCategory").live("click",function(){
		$(this).parent().parent().remove();
	});

	$("select[name='sale_price_type']").live("change",function(){
		cutting_price();
	});

	cutting_price();

	$("select[name='reserve_select']").live("change",function(){
		span_controller('reserve');
	});

	$("select[name='point_select']").live("change",function(){
		span_controller('point');
	});

	span_controller('reserve');
	span_controller('point');
});


function iconFileUpload(str){
	if(str > 0) {
		alert('아이콘을 선택해 주세요.');
		return false;
	}
	//파일전송
	var frm = $('#iconRegist');
	frm.attr("action","../member_process/iconUpload");
	frm.submit();
}


function myiconFileUpload(str){
	if(str > 0) {
		alert('아이콘을 선택해 주세요.');
		return false;
	}
	//파일전송
	var frm = $('#myiconRegist');
	frm.attr("action","../member_process/myiconUpload");
	frm.submit();
}

function icon_click(img)
{
	var imgname = $(img).attr("filenm");
	var html = "<img class=\"icons\" src=\""+$(img).attr('src')+"\" align='absmiddle'>";
	$("#imgHtml").html(html);
	$("#iconPreview").show();
	$("input[name='icon']").val(imgname);
	closeDialog("iconPopup");
}

function myicon_click(img)
{
	var imgname = $(img).attr("filenm");
	var html = "<img class=\"myicons\" src=\""+$(img).attr('src')+"\" align='absmiddle'>";
	$("#myimgHtml").html(html);
	$("#myIconPreview").show();
	$("input[name='myicon']").val(imgname);
	closeDialog("myiconPopup");
}

function iconDisplay(filenm){
	var html = "<img src=\"../../data/icon/common/"+filenm+"\" class=\"hand icons\" filenm=\""+filenm+"\" onload='icon_click(this);'>&nbsp;";
	$("#iconDisplay").append(html);
}

function myiconDisplay(filenm){
	var html = "<img src=\"../../data/icon/mypage/"+filenm+"\" class=\"hand hide myicons\" filenm=\""+filenm+"\" onload='myicon_click(this);'>";
	$("#myiconDisplay").html(html);
}

function cutting_price(){
	if( $("select[name='sale_price_type'] option:selected").val() == 'PER' ){
		$("#cutting_price_guide").removeClass("hide");
	}else{
		$("#cutting_price_guide").addClass("hide");
	}
}

function iconDelete(icon, icon_type){

	if(icon == null || icon == '') {
		alert('아이콘을 선택해 주세요.');
		return false;
	}

	if(icon_type == null || icon_type == '') {
		alert('타입값이 없습니다.');
		return false;
	}
	
	$.ajax({
		'url' : '../member_process/iconDelete',
		'type' : 'post',
		'dataType' : 'json',
		'data' : 'icon_type='+icon_type+'&icon='+icon,
		'success': function(data){
			alert(data.msg);
			
			if(data.result){
				$('img[filenm="'+icon+'"]').closest('span').remove();
			}
		}
	});
}

function span_controller(name){
	var reserve_y = $("span[name='"+name+"_y']");
	var reserve_d = $("span[name='"+name+"_d']");
	var value = $("select[name='"+name+"_select'] option:selected").val();
	if(value==""){
		reserve_y.hide();
		reserve_d.hide();
	}else if(value=="year"){
		reserve_y.show();
		reserve_d.hide();
	}else if(value=="direct"){
		reserve_y.hide();
		reserve_d.show();
	}
}
</script>

<?php if($TPL_VAR["data"]["group_seq"]){?>
<form name="gradeFrm" id="gradeFrm" method="post" target="actionFrame" action="../member_process/grade_modify">
<input type="hidden" name="seq" value="<?php echo $TPL_VAR["data"]["group_seq"]?>">
<?php }else{?>
<form name="gradeFrm" id="gradeFrm" method="post" target="actionFrame" action="../member_process/grade_write">
<?php }?>

<div class="contents_dvs">
	<div class="item-title">회원 등급 정보</div>
	<table width="100%" class="table_basic thl">
		<tr>
			<th>명칭</th>
			<td colspan="3">
				<input type="text" name="group_name" size="60" class="line" value="<?php echo $TPL_VAR["data"]["group_name"]?>"/>
			</td>
		</tr>

		<tr>
			<th>등급 아이콘</th>
			<td class="clear" colspan="3">
				<table width="100%" class="table_basic v3 thl">	
					<tr>
						<th>기본아이콘</th>
						<td>							
							<button type="button" id="iconBtn" class="resp_btn active" >등록</button>							
							<div class="preview_image <?php if($TPL_VAR["data"]["icon"]==''){?>hide<?php }?>" id="iconPreview">
								<div class="image-preview-wrap">
									<div class="bg">
										<a href="#" class="preview-del" id="removeIcon"></a>
										<input type="hidden" name="icon" value="<?php echo $TPL_VAR["data"]["icon"]?>">									
										<span class="preview-img" id="imgHtml"><?php if($TPL_VAR["data"]["icon"]){?><img class="icons" src="../../data/icon/common/<?php echo $TPL_VAR["data"]["icon"]?>"><?php }?></span>									
									</div>
								</div>
							</div>
							<ul class="bullet_hyphen resp_message v2">
								<li>파일 형식 jpg, gif, png, ico, 이미지 사이즈 15px*15px</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th>MY페이지용</th>
						<td>							
							<button type="button" id="myiconBtn" class="resp_btn active">등록</button>
							<div class="preview_image <?php if($TPL_VAR["data"]["myicon"]==''){?>hide<?php }?>" id="myIconPreview">
								<div class="image-preview-wrap">
									<div class="bg">
										<a href="#" class="preview-del" id="removeMyicon"></a>
										<input type="hidden" name="myicon" value="<?php echo $TPL_VAR["data"]["myicon"]?>">									
										<span class="preview-img" id="myimgHtml"><?php if($TPL_VAR["data"]["myicon"]){?><img class="myicons" src="../../data/icon/mypage/<?php echo $TPL_VAR["data"]["myicon"]?>"><?php }?></span>									
									</div>
								</div>
							</div>			
							<ul class="bullet_hyphen resp_message v2">
								<li>파일 형식 jpg, gif, png, ico, 이미지 사이즈 60px*60px</li>
							</ul>
						</td>
					</tr>
				</table>			
			</td>
		</tr>
		<tr>
			<th>
				산정기준
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/member', '#tip14')"></span>
			</th>
			
<?php if($TPL_VAR["data"]["group_seq"]== 1){?>
			<td class="manual content2 " colspan="3">								
				<div style="color:#ff0000;">회원 가입시 자동으로 부여되는 등급입니다. (선정기준  변경 불가)</div>				
			</td>
<?php }else{?>
			<td colspan="3">
				<div class="resp_radio">
					<label><input type="radio" name="use_type" value="AUTO" <?php if($TPL_VAR["data"]["group_seq"]== 1){?>disabled<?php }?> /> 자동관리(모든 조건 만족)</label>
					<label><input type="radio" name="use_type" value="AUTOPART" <?php if($TPL_VAR["data"]["group_seq"]== 1){?>disabled<?php }?>/> 자동관리(1가지 이상 조건 만족)</label>
					<label><input type="radio" name="use_type" value="MANUAL"  <?php if($TPL_VAR["data"]["group_seq"]== 1){?>disabled<?php }else{?>checked<?php }?>/> 수동관리</label>
				</div>
			</td>	
<?php }?>		
		</tr>
		<tr class="content2 hide" >
			
<?php if($TPL_VAR["data"]["group_seq"]!= 1){?>
			<th>산정 기준 설정</th>
			
			<td class="auto hide" colspan="3">
				<input type="hidden" name="order_sum_use[]" id="osu0" value="price" /> 
				실 결제 금액 
				<input type="text" name="order_sum_price" id="order_sum_price" class="line onlyfloat right" size="6" value="<?php echo $TPL_VAR["data"]["order_sum_price"]?>" <?php if($TPL_VAR["data"]["group_seq"]== 1){?>disabled<?php }?>/> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상,  
				<label class="resp_checkbox"><input type="checkbox" name="order_sum_use[]" id="osu1" value="ea" <?php if($TPL_VAR["data"]["group_seq"]== 1){?>disabled<?php }?> />
				총 상품 구매 개수</label> 
				<input type="text" name="order_sum_ea" id="order_sum_ea" class="line onlynumber right" size="6" value="<?php echo $TPL_VAR["data"]["order_sum_ea"]?>" disabled/>개 이상,  
				<input type="checkbox" name="order_sum_use[]" id="osu2" value="cnt" <?php if($TPL_VAR["data"]["group_seq"]== 1){?>disabled<?php }?> />
				<label for="osu2">총 주문 횟수</label>
				<input type="text" name="order_sum_cnt" id="order_sum_cnt" class="line onlynumber right" size="6" value="<?php echo $TPL_VAR["data"]["order_sum_cnt"]?>" disabled/>회 이상
			</td>
			<td class="autopart hide" colspan="3">	
				<div class="resp_checkbox">
					<input type="hidden" name="order_sum_use2[]" id="osup0" value="price" /> 
					실 결제 금액 <input type="text" name="order_sum_price2" id="order_sum_price2" class="line onlyfloat right" size="6" value="<?php echo $TPL_VAR["data"]["order_sum_price"]?>"/> <?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 이상,
					<label><input type="checkbox" name="order_sum_use2[]" id="osup1" value="ea"  <?php if($TPL_VAR["data"]["group_seq"]== 1){?>disabled<?php }?> /> 총 상품 구매 개수</label>
					<input type="text" name="order_sum_ea2" id="order_sum_ea2" class="line onlynumber right" size="6" value="<?php echo $TPL_VAR["data"]["order_sum_ea"]?>" disabled/>개 이상, 
					<label><input type="checkbox" name="order_sum_use2[]" id="osup2" value="cnt"  <?php if($TPL_VAR["data"]["group_seq"]== 1){?>disabled<?php }?> /> 총 주문 횟수</label>
					<input type="text" name="order_sum_cnt2" id="order_sum_cnt2" class="line onlynumber right" size="6" value="<?php echo $TPL_VAR["data"]["order_sum_cnt"]?>" disabled/>회 이상	
				</div>
			</td>
		
<?php }?>	
		</tr>
		
<?php if($TPL_VAR["data"]["group_seq"]){?>
		<tr>
			<th>등록일</th>
			<td>
				<?php echo $TPL_VAR["data"]["regist_date"]?>

			</td>

<?php if($TPL_VAR["data"]["update_date"]!='0000-00-00 00:00:00'){?>
			<th>수정일</th>
			<td>
				<?php echo $TPL_VAR["data"]["update_date"]?>

			</td>
<?php }?>
		</tr>
<?php }?>
	</table>
</div>
</form>

<div class="box_style_05 mt10">					
	<div class="title">안내</div>
	<ul class="bullet_circle">
		<li>상품 구매 시 금액 조건 및 추가 할인 / 마일리지 / 포인트는 설정 > 회원 > <a href="/admin/member?gb=member_sale " class="link_blue_01" >등급별 구매 혜택</a>에서도 설정이 가능합니다.</li>
		<li>이외의 추가 혜택은 프로모션 / 쿠폰 > <a href="/admin/coupon/catalog" class="link_blue_01">할인 쿠폰</a>에서 등급별 할인 쿠폰을 발행할 수 있습니다.</li>		
	</ul>						
</div>

<!-- 아이콘 선택 -->
<div id="iconPopup" class="hide">
	<div class="content">
		<form name="iconRegist" id="iconRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">
		<label class="resp_btn v2 mb10"><input type="file" name="grade_icon" id="grade_icon" onChange="iconFileUpload();"  accept="image/gif, image/jpeg, image/png"/>파일선택</label>	
		<ul>
			<li>
<?php if($TPL_icons_1){foreach($TPL_VAR["icons"] as $TPL_V1){?>
			<span style="display: inline-block;vertical-align: top; text-align: center;">
				<img src="../../data/icon/common/<?php echo $TPL_V1?>" class="hand icons" filenm="<?php echo $TPL_V1?>">
				<br/>
<?php if(!in_array($TPL_V1,$TPL_VAR["default_icons"])){?><a href="javascript:iconDelete('<?php echo $TPL_V1?>', 'default');" class="resp_btn_txt v2">삭제</a>
<?php }?>
			</span>
<?php }}?>
			<span id="iconDisplay"></span>
			</li>			
		</ul>	
		
		</form>
	</div>

	<div class="footer">
		<button type="button" class="resp_btn v3 size_L" onclick="closeDialogEvent(this);">닫기</button>
	</div>	
</div>

<!-- 아이콘 선택 -->
<div id="myiconPopup" class="hide">
	<div class="content">
		<form name="myiconRegist" id="myiconRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">
		<label class="resp_btn v2 mb10"><input type="file" name="my_grade_icon" id="my_grade_icon" onChange="myiconFileUpload();" accept="image/gif, image/jpeg, image/png" />파일선택</label>	
		<ul>
			<li>
<?php if($TPL_myicons_1){foreach($TPL_VAR["myicons"] as $TPL_V1){?>
			<span style="display: inline-block;vertical-align: top; text-align: center;">
				<img src="../../data/icon/mypage/<?php echo $TPL_V1?>" class="myicons hand " filenm="<?php echo $TPL_V1?>">
<?php if(!in_array($TPL_V1,$TPL_VAR["default_icons"])){?><br/>
				<a href="javascript:iconDelete('<?php echo $TPL_V1?>', 'mypage');" class="resp_btn_txt v2">삭제</a>
<?php }?>
			</span>
<?php }}?>
			<span id="myiconDisplay"></span>
			</li>		
		</ul>
		
		</form>
	</div>

	<div class="footer">
		<button type="button" class="resp_btn v3 size_L" onclick="closeDialogEvent(this);">닫기</button>
	</div>
</div>