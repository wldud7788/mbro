<?php /* Template_ 2.2.6 2020/12/01 09:20:51 /www/music_brother_firstmall_kr/admin/skin/default/member/delivery_address.html 000022704 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header_popup",$TPL_SCP,1);?>


<script>
function check_shipping_method(){

	var idx = $("select[name='international'] option:selected").val();
	$("div.shipping_method_radio").each(function(){
		$(this).hide();
	});
	if(!idx)idx = 0;
	$("div.shipping_method_radio").eq(idx).show();

	if(idx == 0){
		$(".domestic").show();
		$(".international").hide();
	}else{
		$(".international").show();
		$(".domestic").hide();
	}
}

function opener_shipping_method(){

	var idx = opener.$("select[name='international'] option:selected").val();

	opener.$("div.shipping_method_radio").each(function(){
		$(this).hide();
	});
	if(!idx)idx=0;

	opener.$("div.shipping_method_radio").eq(idx).show();

	if(idx == 0){

		opener.$(".domestic").show();
		opener.$(".international").hide();
	}else{
		opener.$(".international").show();
		opener.$(".domestic").hide();
	}
}

function delete_address_btn(seq){
	var chk = confirm('정말 삭제하시겠습니까?');
	if(chk == true){
	var str="../mypage_process/delete_address?address_seq=" + seq + "&popup=<?php echo $_GET["popup"]?>";
	$("iframe[name='actionFrame']").attr('src',str);
	}else{
		return;
	}
}

function change_address_btn(seq){
	var chk = confirm('자주쓰는 배송지로 등록하시겠습니까?');
	if(chk == true){
	var str="../mypage_process/change_address?address_seq=" + seq + "&popup=<?php echo $_GET["popup"]?>";
	$("iframe[name='actionFrame']").attr('src',str);
	}else{
		return;
	}
}

$(function() {
	// IFRAME RESIZING
	parent.$("#container").css("height","0px");
	$("#container", parent.document).height($(document).height()+10);

	// 해외/국내 배송 선택
	$("select[name='international']").bind("change",function(){
		check_shipping_method();
	});

	// 해외배송 방법 선택 시
	$("input[name='shipping_method_international']").bind("click",function(){
		var region = new Array();
<?php if(is_array($TPL_R1=$TPL_VAR["shipping_policy"]["policy"][ 1])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
		region[<?php echo $TPL_K1?>] = new Array();
<?php if(is_array($TPL_R2=$TPL_V1["region"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_K2=>$TPL_V2){?>
		region[<?php echo $TPL_K1?>][<?php echo $TPL_K2?>] = "<?php echo $TPL_V2?>";
<?php }}?>
<?php }}?>
		$("select[name='region'] option").remove();
		var idx = $(this).val();
		for(var i=0;i<region[idx].length;i++){
			$("select[name='region']").append("<option value='"+i+"'>"+region[idx][i]+"</option>");
		}
	});

	check_shipping_method();
<?php if($TPL_VAR["shipping_policy"]["count"]&&array_sum($TPL_VAR["shipping_policy"]["count"])> 1){?>
	$("tr.shipping_tr").show();
<?php }else{?>
	$("tr.shipping_tr").hide();
<?php }?>
<?php if($TPL_VAR["shipping_policy"]["count"][ 0]&&$TPL_VAR["shipping_policy"]["count"][ 1]){?>
	$("div.international_layer").show();
<?php }?>

	$(".addAddress").bind("click",function(){

		$("input[name='insert_mode']").val('insert');
		// 배송지 정보 초기화
		$("input[name='address_description']").val('');
		$("input[name='recipient_zipcode[]']").each(function(idx){
				$("input[name='recipient_zipcode[]']").eq(idx).val("");
			});
		$("input[name='recipient_address']").val("");
		$("input[name='recipient_address_street']").val("");
		$("input[name='recipient_address_detail']").val("");
		$("input[name='recipient_user_name']").val("");
		$("input[name='recipient_phone[]']").each(function(idx){
			$("input[name='recipient_phone[]']").eq(idx).val("");
		});
		$("input[name='recipient_cellphone[]']").each(function(idx){
			$("input[name='recipient_cellphone[]']").eq(idx).val("");
		});

		openDialog("배송지 등록 하기", "inAddress", {"width":500,"height":350});
	});

	$(".updateaddress").bind("click",function(){
		var seq = $(this).attr('seq');
		$.ajax({
		  url: '/mypage/delivery_address_ajax',
		  data : {
			  'address_seq':seq
		  },
		  dataType : 'json',
		  success: function(data) {

			  if(data.international =='domestic'){
				 $("select[name='international']").val('0');
				 $("input[name='address_description']").val(data.address_description);
				 $("input[name='recipient_user_name']").val(data.recipient_user_name);
				 $("input[name='recipient_address']").val(data.recipient_address);
				 $("input[name='recipient_address_street']").val(data.recipient_address_street);
				 $("input[name='recipient_address_detail']").val(data.recipient_address_detail);
				 zipcode = new Array();
				 zipcode = data.recipient_zipcode.split('-');
				 $("input[name='recipient_zipcode[]']").each(function(idx){
					 $("input[name='recipient_zipcode[]']").eq(idx).val(zipcode[idx]);
				 });
			  }else{
				  	$("select[name='international']").val('1');
				  	$("input[name='address_description']").val(data.address_description);
					$("input[name='recipient_user_name']").val(data.recipient_user_name);
					$("select[name='region']").val(data.region);
					$("input[name='international_county']").val(data.international_county);
					$("input[name='international_address']").val(data.international_address);
					$("input[name='international_town_city']").val(data.international_town_city);
					$("input[name='international_postcode']").val(data.international_postcode);
					$("input[name='international_country']").val(data.international_country);
			  }
			  phone = new Array();
			  phone = data.recipient_phone.split('-');
			  $("input[name='recipient_phone[]']").each(function(idx){
					 $("input[name='recipient_phone[]']").eq(idx).val(phone[idx]);
				 });

			  cellphone = new Array();
			  cellphone = data.recipient_cellphone.split('-');
			  $("input[name='recipient_cellphone[]']").each(function(idx){
					 $("input[name='recipient_cellphone[]']").eq(idx).val(cellphone[idx]);
				 });

			  $("input[name='insert_mode']").val('update');
			  $("input[name='address_seq']").val(seq);
			  check_shipping_method();
			openDialog("배송지 수정 하기", "inAddress", {"width":500,"height":350});
		  }
		});


	});

	$("#insert_address").bind("click",function(){
		var f = $("form#in_Address");
		f.attr("action","../mypage_process/delivery_address");
		f.attr("target","actionFrame");
		f[0].submit();
	});

	$("#change_desc").bind("click",function(){
		var order = "<?php echo $_GET["order"]?>";
		if( order == '' || order != "desc_up"){
		document.location.href = "delivery_address?tab=<?php echo $_GET["tab"]?>&popup=<?php echo $_GET["popup"]?>&order=desc_up";
		}else if( order != "desc_dn"){
		document.location.href = "delivery_address?tab=<?php echo $_GET["tab"]?>&popup=<?php echo $_GET["popup"]?>&order=desc_dn";
		}
	});

	$("#change_name").bind("click",function(){
		var order = "<?php echo $_GET["order"]?>";
		if( order == '' || order != "name_up"){
		document.location.href = "/mypage/delivery_address?tab=<?php echo $_GET["tab"]?>&popup=<?php echo $_GET["popup"]?>&order=name_up";
		}else if( order != "name_dn"){
		document.location.href = "/mypage/delivery_address?tab=<?php echo $_GET["tab"]?>&popup=<?php echo $_GET["popup"]?>&oorder=name_dn";
		}
	});


	$(".addressResult").bind("click",function(){
		var seq = $(this).attr('seq');

		$.ajax({
			  url: '/mypage/delivery_address_ajax',
			  data : {
				  'address_seq':seq
			  },
			  dataType : 'json',
			  success: function(data) {
				var check_internal = '<?php echo $TPL_VAR["shipping_policy"]["policy"][ 1]?>' ;

				if(!check_internal){
					if(data.international =='domestic'){
						opener.$("select[name='international']").val('0');
						opener.$("input[name='address_description']").val(data.address_description);
						opener.$("input[name='recipient_user_name']").val(data.recipient_user_name);
						opener.$("input[name='recipient_address']").val(data.recipient_address);
						opener.$("input[name='recipient_address_street']").val(data.recipient_address_street);
						opener.$("input[name='recipient_address_detail']").val(data.recipient_address_detail);
						zipcode = new Array();
						zipcode = data.recipient_zipcode.split('-');
						opener.$("input[name='recipient_zipcode[]']").each(function(idx){
						opener.$("input[name='recipient_zipcode[]']").eq(idx).val(zipcode[idx]);
						 });
						 phone = new Array();
						  phone = data.recipient_phone.split('-');
						  opener.$("input[name='recipient_phone[]']").each(function(idx){
							  opener.$("input[name='recipient_phone[]']").eq(idx).val(phone[idx]);
							 });

						  cellphone = new Array();
						  cellphone = data.recipient_cellphone.split('-');
						  opener.$("input[name='recipient_cellphone[]']").each(function(idx){
							  opener.$("input[name='recipient_cellphone[]']").eq(idx).val(cellphone[idx]);
							 });
						  window.close();
					}else{
					openDialogAlert('현재 해외배송은 불가능합니다.',400,150);
					}
				}else{

			  	if(data.international =='domestic'){
					opener.$("select[name='international']").val('0');
					opener.$("input[name='address_description']").val(data.address_description);
					opener.$("input[name='recipient_user_name']").val(data.recipient_user_name);
					opener.$("input[name='recipient_address']").val(data.recipient_address);
					opener.$("input[name='recipient_address_street']").val(data.recipient_address_street);
					opener.$("input[name='recipient_address_detail']").val(data.recipient_address_detail);
					zipcode = new Array();
					zipcode = data.recipient_zipcode.split('-');
					opener.$("input[name='recipient_zipcode[]']").each(function(idx){
					opener.$("input[name='recipient_zipcode[]']").eq(idx).val(zipcode[idx]);
					 });
				  }else{
					opener.$("select[name='international']").val('1');
					opener.$("input[name='address_description']").val(data.address_description);
					opener.$("input[name='recipient_user_name']").val(data.recipient_user_name);
					opener.$("select[name='region']").val(data.region);
					opener.$("input[name='international_county']").val(data.international_county);
					opener.$("input[name='international_address']").val(data.international_address);
					opener.$("input[name='international_town_city']").val(data.international_town_city);
					opener.$("input[name='international_postcode']").val(data.international_postcode);
					opener.$("input[name='international_country']").val(data.international_country);
				  }
				  phone = new Array();
				  phone = data.recipient_phone.split('-');
				  opener.$("input[name='recipient_phone[]']").each(function(idx){
					  opener.$("input[name='recipient_phone[]']").eq(idx).val(phone[idx]);
					 });

				  cellphone = new Array();
				  cellphone = data.recipient_cellphone.split('-');
				  opener.$("input[name='recipient_cellphone[]']").each(function(idx){
					  opener.$("input[name='recipient_cellphone[]']").eq(idx).val(cellphone[idx]);
					 });

				  opener_shipping_method();
				  window.close();
				}
			  }

		});
	});

	$("select[name='orderby']").change(function(){

	var order = $(this).val();
	document.location.href = "delivery_address?tab=<?php echo $_GET["tab"]?>&member_seq=<?php echo $TPL_VAR["member_seq"]?>&popup=<?php echo $_GET["popup"]?>&order="+order;
	});

});



</script>
<style>
.ud-line{border:0px; border-bottom:2px solid #333; text-align:center;}
.selected-tab { border:2px solid #333; border-bottom:2px; text-align:center; padding:2px;}


table.in-delivery {border:1px solid #f1f1f1; border-collapse: collapse; }
table.in-delivery td.list-name { text-align:center; background-color:#f1f1f1; padding:5px;}
table.in-delivery td.down-line  {border-bottom:1px solid #f1f1f1 }
</style>



<table width="100%" border="0" cellpadding="0" cellspacing="0" >
<tr height="30">
	<td class="ud-line" width="10%"></td>
	<td <?php if($_GET["tab"]=='1'||!$_GET["tab"]){?> class="selected-tab"<?php }else{?>class="ud-line"<?php }?>  width="20%"><a href="./delivery_address?tab=1&member_seq=<?php echo $TPL_VAR["member_seq"]?>">자주쓰는 배송지</a></td>
	<td <?php if($_GET["tab"]=='2'){?> class="selected-tab"<?php }else{?>class="ud-line" <?php }?> width="20%" ><a href="./delivery_address?tab=2&member_seq=<?php echo $TPL_VAR["member_seq"]?>">최근배송지</a></td>
	<td class="ud-line" width="50%"></td>
</tr>
</table>


<table width="100%" cellpadding="5px">
<tr>
	<td>
	<ul class="left-btns clearbox">
		<li><select class="custom-select-box-multi" name="orderby" >
			<option value="ads" <?php if($_GET["order"]=='ads'||!$_GET["order"]){?>selected<?php }?>>최근등록순</option>
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
			<option value="desc_dn" <?php if($_GET["order"]=='desc_dn'){?>selected<?php }?>>배송지설명↓</option>
			<option value="desc_up" <?php if($_GET["order"]=='desc_up'){?>selected<?php }?>>배송지설명↑</option>
<?php }?>
			<option value="name_dn" <?php if($_GET["order"]=='name_dn'){?>selected<?php }?>>받는분↓</option>
			<option value="name_up" <?php if($_GET["order"]=='name_up'){?>selected<?php }?>>받는분↑</option>
		</select></li>
	</ul>
	</td>
	<td align="right" height="20px">
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
		<!--span class="btn small"><input type="button" class="addAddress" value="등록" /></span-->
<?php }?>
	</td>
</tr>
</table>


<table class="info_table_style" width="98%" style="text-align:center; margin-bottom:20px;" align="center" >
<tr>
	<th class="its_th_center">해외/국내</th>
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?><th class="its_th_center"><span id="change_desc" style="cursor:pointer">배송지설명 <?php if($_GET["order"]=='desc_dn'){?>▼<?php }elseif($_GET["order"]=='desc_up'){?>▲<?php }?></span> </th><?php }?>
	<th class="its_th_center"><span id="change_name" style="cursor:pointer">받는분 <?php if($_GET["order"]=='name_dn'){?>▼<?php }elseif($_GET["order"]=='name_up'){?>▲<?php }?></span></th>
	<th class="its_th_center">주소</th>
	<th class="its_th_center">유선전화</th>
	<th class="its_th_center">휴대폰</th>
	<!--th class="its_th_center">관리</th-->
</tr>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
<?php if($TPL_V1["international"]=='domestic'){?>
		<tr>
			<td class="its_td_center"><?php echo $TPL_V1["international_show"]?></td>
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?><td class="its_td_center"><?php echo $TPL_V1["address_description"]?></td><?php }?>
			<td class="its_td_center"><?php echo $TPL_V1["recipient_user_name"]?></td>
			<td  class="its_td_center addressResult" style="padding-left:10px; text-align:left" seq="<?php echo $TPL_V1["address_seq"]?>">
<?php if($_GET["popup"]){?><span style="cursor:pointer;"><?php }?>
				(우편번호) <?php echo implode('-',$TPL_V1["recipient_zipcode"])?><br>
				<span <?php if($TPL_V1["recipient_address_type"]!="street"){?>style="font-weight:bold;"<?php }?>>(지번)</span> <?php echo $TPL_V1["recipient_address"]?> <br>
				<span <?php if($TPL_V1["recipient_address_type"]=="street"){?>style="font-weight:bold;"<?php }?>>(도로명)</span> <?php echo $TPL_V1["recipient_address_street"]?> <br>
				(공통상세) <?php echo $TPL_V1["recipient_address_detail"]?><?php if($_GET["popup"]){?></span><?php }?>
			</td>
			<td class="its_td_center"><?php echo $TPL_V1["recipient_phone"]?></td>
			<td class="its_td_center"><?php echo $TPL_V1["recipient_cellphone"]?></td>
			<!--td class="its_td_center"><?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
				<span class="btn small"><input type="button" class="updateaddress" value="수정" seq="<?php echo $TPL_V1["address_seq"]?>" ></span>
<?php }else{?>
				<span class="btn small"><input type="button" value="자주쓰는 배송지" onclick="change_address_btn(<?php echo $TPL_V1["address_seq"]?>)"></span>
<?php }?>
				<span class="btn small"><input type="button" value="삭제" onclick="delete_address_btn(<?php echo $TPL_V1["address_seq"]?>)"></span>
			</td-->
		</tr>
<?php }else{?>
		<tr>
			<td class="its_td_center"><?php echo $TPL_V1["international_show"]?></td>
<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?><td class="its_td_center"><?php echo $TPL_V1["address_description"]?></td><?php }?>
			<td class="its_td_center"><?php echo $TPL_V1["recipient_user_name"]?></td>
			<td class="its_td_center addressResult" style="padding-left:10px; text-align:left;" seq="<?php echo $TPL_V1["address_seq"]?>">
<?php if($_GET["popup"]){?><span style="cursor:pointer;"><?php }?><?php echo $TPL_V1["international_address"]?>,
				<br/><?php echo $TPL_V1["international_town_city"]?>,<?php echo $TPL_V1["international_county"]?>,<br/><?php echo $TPL_V1["international_postcode"]?>,<?php echo $TPL_V1["international_country"]?></span>
			</td>
			<td class="its_td_center"><?php echo $TPL_V1["recipient_phone"]?></td>
			<td class="its_td_center"><?php echo $TPL_V1["recipient_cellphone"]?></td>
			<!--td class="its_td_center"><?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
				<span class="btn small"><input type="button" class="updateaddress" value="수정" seq="<?php echo $TPL_V1["address_seq"]?>" ></span>
<?php }else{?>
				<span class="btn small"><input type="button" value="자주쓰는 배송지" onclick="change_address_btn(<?php echo $TPL_V1["address_seq"]?>)"></span>
<?php }?>
				<span class="btn small"><input type="button" value="삭제" onclick="delete_address_btn(<?php echo $TPL_V1["address_seq"]?>)"></span>
			</td-->
		</tr>
<?php }?>
<?php }}?>
<?php }else{?>
<tr>

<?php if($_GET["tab"]=='1'||!$_GET["tab"]){?>
	<td class="its_td_center" colspan="6" align="center" style="padding:20px 0px 20px 0px;">
		등록하신 자주쓰는 배송지가 없습니다.
<?php }elseif($_GET["tab"]=='2'){?>
	<td class="its_td_center" colspan="5" align="center" style="padding:20px 0px 20px 0px;">
		최근 배송지가 없습니다.
<?php }?>
	</td>
</tr>
<?php }?>
</table>
<!-- 페이징 -->


<div class="paging_navigation"><?php echo $TPL_VAR["page"]["html"]?></div>

<!-- 배송지등록 -->
<div id="inAddress" style="display:none;">
<form id="in_Address" method="post" >
<input type="hidden" name="insert_mode">
<input type="hidden" name="address_seq">
<table width="100%" class="in-delivery" border="0" cellpadding="5" cellspacing="0">
	<col width="90" />
	<tr>
		<td class="list-name">배송지 설명</td>
		<td class="fx12"><input type="text" name="address_description" value="" size="40" /></td>
	</tr>
	<tr>
		<td class="list-name">받는분</td>
		<td class="fx12"><input type="text" name="recipient_user_name" value="" size="15" /></td>
	</tr>

	<tr class="shipping_tr">

		<td class="list-name">배송국가</td>
		<td class="fx12">
		<div style="float:left;padding-right:10px;display:none;" class="international_layer">
			<select name="international">
<?php if($TPL_VAR["shipping_policy"]["count"][ 0]){?>
				<option value="0">국내</option>
<?php }?>
<?php if($TPL_VAR["shipping_policy"]["count"][ 1]){?>
				<option value="1">해외</option>
<?php }?>
			</select>
		</div>
		</td>
	</tr>

	<tr class="domestic">
		<td rowspan="3"  class="list-name">주소</td>
		<td class="fx12"">
			<input type="text" name="recipient_zipcode[]" value="" size="10" /> -
			<input type="text" name="recipient_zipcode[]" value="" size="10" />
			<img src="/admin/skin/default/images/design/btn_zipsearch.gif" hspace="1" class="hand" onclick="window.open('../popup/zipcode?mtype=order','popup_zipcode','width=500,height=350')" />
			<!--<img src="/admin/skin/default/images/design/btn_delivery_address.gif" hspace="1" class="hand" onclick="window.open('../popup/addressbook','popup_zipcode','width=700,height=450')" />-->
		</td>
	</tr>

	<tr class="domestic">
		<td class="fx12">
		<span class="desc">(지번주소)</span><input type="text" name="recipient_address" value="" size="45" /><br/>
		<span class="desc">(도로명주소)</span><input type="text" name="recipient_address_street" value="" size="45" /> <br/>
		</td>
	</tr>
	<tr class="domestic">
		<td class="fx12"><input type="text" name="recipient_address_detail" value="" size="45" /> <span class="desc">나머지주소</span></td>
	</tr>
	<tr class="international">
		<td rowspan="6"  class="list-name">주소</td>
		<td class="fx12">
			<span id="region">
				<select name="region">
<?php if(is_array($TPL_R1=$TPL_VAR["shipping_policy"]["policy"][ 1][ 0]["region"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
					<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option>
<?php }}?>
				</select>
			</span>
			</td>
	</tr>

	<tr class="international">
		<td class="fx12"><input type="text" name="international_address" value="" size="45" /> <span class="desc">주소</span></td>
	</tr>

	<tr class="international">
		<td class="fx12"><input type="text" name="international_town_city" value="" size="30" /> <span class="desc">시도</span></td>
	</tr>

	<tr class="international">
		<td class="fx12"><input type="text" name="international_county" value="" size="22" /> <span class="desc">주</span></td>
	</tr>

	<tr class="international">
		<td class="fx12"><input type="text" name="international_postcode" value="" size="15" /> <span class="desc">우편번호</span></td>
	</tr>

	<tr class="international">
		<td class="fx12"><input type="text" name="international_country" value="" size="30" /> <span class="desc">국가</span></td>
	</tr>

	<tr>
		<td  class="list-name">유선전화</td>
		<td class="fx12"><input type="text" name="recipient_phone[]" value="" size="10" /> - <input type="text" name="recipient_phone[]" value="" size="10" /> - <input type="text" name="recipient_phone[]" value="" size="10" /></td>
	</tr>

	<tr>
		<td  class="list-name">휴대폰</td>
		<td class="fx12"><input type="text" name="recipient_cellphone[]" value="" size="10" /> - <input type="text" name="recipient_cellphone[]" value="" size="10" /> - <input type="text" name="recipient_cellphone[]" value="" size="10" /></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><span class="btn small"><button id="insert_address" type="button">확인</button></span></td>
	</tr>
</table>
</form>
</div>