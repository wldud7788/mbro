<?php /* Template_ 2.2.6 2022/05/17 12:29:26 /www/music_brother_firstmall_kr/selleradmin/skin/default/popup/zipcode.html 000014333 */ 
$TPL__GET_1=empty($_GET)||!is_array($_GET)?0:count($_GET);
$TPL_arrSido_1=empty($TPL_VAR["arrSido"])||!is_array($TPL_VAR["arrSido"])?0:count($TPL_VAR["arrSido"]);
$TPL_arrSigungu_1=empty($TPL_VAR["arrSigungu"])||!is_array($TPL_VAR["arrSigungu"])?0:count($TPL_VAR["arrSigungu"]);
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<script type="text/javascript">
function getZipcodeResult(zipcodeFlag,page){
	var url = '../popup/zipcode';
	$.get(url,{'keyword':$(':input[name=zipcode_keyword]',$("#<?php echo $TPL_VAR["zipcodeFlag"]?>Id<?php echo $_GET["goodsoption"]?>")).val(),'SIDO':$("select[name='SIDO']",$("#<?php echo $TPL_VAR["zipcodeFlag"]?>Id")).val(),'SIGUNGU':$("select[name='SIGUNGU']",$("#<?php echo $TPL_VAR["zipcodeFlag"]?>Id")).val(), 'zipcodeFlag':zipcodeFlag, 'page':page, 'idx':'<?php echo $_GET["idx"]?>', 'goodsoption':'<?php echo $_GET["goodsoption"]?>','zipcode_type':'<?php echo $TPL_VAR["zipcode_type"]?>','zipcode':'<?php echo $_GET["zipcode"]?>'} , function(data) {
		$("#"+zipcodeFlag+"Id<?php echo $_GET["goodsoption"]?>").html(data);
	});
}

function enterchk(){
	if(event.keyCode==13){
		getZipcodeResult('<?php echo $TPL_VAR["zipcodeFlag"]?>',1);
		event.returnValue=false;
	}
}


$(document).ready(function() {
	$("#zipcodeSearchButton",$("#<?php echo $TPL_VAR["zipcodeFlag"]?>Id<?php echo $_GET["goodsoption"]?>")).bind("click",function(){
		getZipcodeResult('<?php echo $TPL_VAR["zipcodeFlag"]?>',1);
	});

	$(".zipcodeResult",$("#<?php echo $TPL_VAR["zipcodeFlag"]?>Id<?php echo $_GET["goodsoption"]?>")).bind("click",function(){
		var zip = $(this).find(".zipcode").html();
		zip = zip.replace("-", "");
<?php if($TPL_VAR["zipcodeFlag"]=='order_multi'){?>
		$(":input[name='recipient_address_type'][idx='<?php echo $_GET["idx"]?>']").val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
		$(":input[name='recipient_address'][idx='<?php echo $_GET["idx"]?>']").val( $(this).find(".address").html() );
		$(":input[name='recipient_address_street'][idx='<?php echo $_GET["idx"]?>']").val( $(this).find(".address_street").html() );
		$(":input[name='recipient_zipcode[]'][idx='<?php echo $_GET["idx"]?>']").eq(0).val(zip);
<?php }elseif($TPL_VAR["zipcodeFlag"]=='windowLabel'||substr($TPL_VAR["zipcodeFlag"], 0, 11)=='windowLabel'){?>
			$(".windowLabelAddress_type<?php echo $_GET["idx"]?>").val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
			$(".windowLabelAddress<?php echo $_GET["idx"]?>").val( $(this).find(".address").html() );
			$(".windowLabelAddress_street<?php echo $_GET["idx"]?>").val( $(this).find(".address_street").html() );
			$(".windowLabelZipcode1<?php echo $_GET["idx"]?>").val(zip);

<?php }elseif(preg_match('/_/',$TPL_VAR["zipcodeFlag"])){?>
		$(":input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>address_type']").val( "<?php echo $TPL_VAR["zipcode_type"]?>" );
		$(":input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>address']").val( $(this).find(".address").html() );
		$(":input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>address_street']").val( $(this).find(".address_street").html() );
		$(":input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>zipcode'],:input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>zipcode[]']").val(zip);
<?php }else{?>
		$(":input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>Address_type']").val( "<?php echo $TPL_VAR["zipcode_type"]?>" );

		$(":input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>Address']").val( $(this).find(".address").html() );
		$(":input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>Address_street']").val( $(this).find(".address_street").html() );

		$(":input[name='<?php echo $TPL_VAR["zipcodeFlag"]?>Zipcode[]']").eq(0).val(zip);

<?php }?>
<?php if($TPL_VAR["zipcodeFlag"]=="recipient_"){?>
			try{opener.order_price_calculate();}catch(e){};
			try{order_price_calculate();}catch(e){};
<?php }?>
		closeDialog('<?php echo $TPL_VAR["zipcodeFlag"]?>Id<?php echo $_GET["goodsoption"]?>')
	});

});

</script>
<style>
.zipcodeResult {cursor:pointer; height:19px; line-height:19px;}
.zipcodeResult:hover {color:#3333ff; background-color:#fafafa}

.oldZipcodeResult {cursor:pointer; height:19px; line-height:19px;}
.oldZipcodeResult:hover {color:#3333ff; background-color:#fafafa}

ul.zipcodeSearchEx {width:400px; text-align:left;}

.zsfText {height:25px !important; line-height:25px !important; padding:0 5px; border:4px solid #666 !important}
.zsfSubmit {height:33px !important; padding:0 5px !important; border:4px solid #666 !important; background-color:#666; color:#fff; cursor:pointer; font-weight:bold;}

.tabBody {border:3px solid #ddd; padding:10px;}
.tabs {*zoom:1}
.tabs:after {content:"";display:block;clear:both;}
.tabs li {float:left;}
.tabs li a {display:inline-block; padding:5px 10px; background-color:#fff; border:1px solid #fff; border-bottom:0px; color:#666;}
.tabs li.on a { background-color:#eee; border-top:1px solid #ddd; border-right:1px solid #ddd; border-left:1px solid #ddd; color:#000; font-weight:bold; border-bottom:0px;}
</style>

<table id="wrap" width="100%" height="400" cellspacing="0" cellpadding="20">
<tr>
	<td valign="top">
		<ul class="tabs">
<?php if($TPL_VAR["cfg_zipcode"]["street_zipcode_5"]){?>
			<li <?php if($TPL_VAR["zipcode_type"]=="street"){?>class="on"<?php }?>><a href="javascript:openDialogZipcode<?php echo $_GET["goodsoption"]?>('<?php echo $TPL_VAR["zipcodeFlag"]?>','','street','','');">???????????????(5??????)??? ?????????(??????)?????? ??????</a></li>
<?php }?>
<?php if($TPL_VAR["cfg_zipcode"]["street_zipcode_6"]){?>
			<li <?php if($TPL_VAR["zipcode_type"]==""||$TPL_VAR["zipcode_type"]=="zibun"){?>class="on"<?php }?>><a href="javascript:openDialogZipcode<?php echo $_GET["goodsoption"]?>('<?php echo $TPL_VAR["zipcodeFlag"]?>','','zibun','','');">???????????????(6??????)??? ?????????(??????)?????? ??????</a></li>
<?php }?>
<?php if($TPL_VAR["cfg_zipcode"]["old_zipcode_lot_number"]){?>
			<li <?php if($TPL_VAR["zipcode_type"]=="oldzibun"){?>class="on"<?php }?>><a href="javascript:openDialogZipcode<?php echo $_GET["goodsoption"]?>('<?php echo $TPL_VAR["zipcodeFlag"]?>','','oldzibun','','');">???????????????(6??????)??? (???)?????? ??????</a></li>
<?php }?>
		</ul>

		<div class="tabBody">

			<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="90">
					<form name="zipForm" id="zipForm" method="get">
					<input type="hidden" name="zipcode_type" value="<?php echo $TPL_VAR["zipcode_type"]?>">
					<input type="hidden" name="old_zipcode" value="<?php echo $_GET["old_zipcode"]?>">
					<input type="text" name="addtext" value="" class="hide">
					<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" height="100%" >
					<tr><td height="5"></td></tr>
					<tr>
						<td align="center">

<?php if($TPL__GET_1){foreach($_GET as $TPL_K1=>$TPL_V1){?>
<?php if(!in_array($TPL_K1,array('page','keyword','SIDO','SIGUNGU'))){?><input type="hidden" name="<?php echo $TPL_K1?>" value="<?php echo $TPL_V1?>" /><?php }?>
<?php }}?>
						<input type="text" name="zipcode_keyword" value="<?php echo $TPL_VAR["keyword"]?>" size="45" class="zsfText" title="<?php if($TPL_VAR["zipcode_type"]=="oldzibun"){?>???/???/???<?php }elseif($TPL_VAR["zipcode_type"]=="zibun"){?>????????????<?php }else{?>???????????????<?php }?>" onkeydown="enterchk();" /> <input type="button" id="zipcodeSearchButton" value="??????" class="zsfSubmit" />

						</td>
					</tr>
					<tr><td height="10"></td></tr>
					<tr><td height="1" bgcolor="cccccc"></td></tr>
					<tr><td height="10"></td></tr>
					<tr>
						<td align="center">
<?php if($TPL_VAR["keyword"]&&$TPL_VAR["arrSido"]){?>
							<table width="50%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="50%">
									?????? :
									<select name="SIDO" id="SIDO" style="width:100px;"   onchange="getZipcodeResult('<?php echo $TPL_VAR["zipcodeFlag"]?>');">
									<option value="">??????</option>
<?php if($TPL_arrSido_1){foreach($TPL_VAR["arrSido"] as $TPL_V1){?>
										<option value="<?php echo $TPL_V1["SIDO"]?>" <?php if($_GET["SIDO"]==$TPL_V1["SIDO"]){?>selected<?php }?>><?php echo $TPL_V1["SIDO"]?></option>
<?php }}?>
									</select>
								</td>
								<td>
									????????? :
									<select name="SIGUNGU" style="width:120px;" onchange="getZipcodeResult('<?php echo $TPL_VAR["zipcodeFlag"]?>');">
									<option value="">??????</option>
<?php if($TPL_arrSigungu_1){foreach($TPL_VAR["arrSigungu"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1["SIGUNGU"]?>" <?php if($_GET["SIGUNGU"]==$TPL_V1["SIGUNGU"]){?>selected<?php }?>><?php echo $TPL_V1["SIGUNGU"]?></option>
<?php }}?>
									</select>
								</td>
							</tr>
							</table>
<?php }?>
						</td>
					</tr>
					<tr><td height="5"></td></tr>
					<tr>
						<td align="center">
							
							<table>
<?php if($TPL_VAR["zipcode_type"]=="zibun"){?>
							<tr>
								<td>
								????????? ?????? ???)
								</td>
								<td>
								????????? 670, ????????? 480-1
								</td>
							</tr>
<?php }elseif($TPL_VAR["zipcode_type"]=="street"){?>							
							<tr>
								<td>
								'????????????'??? ?????? ?????? ??????
								</td>
								<td>
								???) ???????????????123?????? ??? '???'????????? ??????
								</td>
							</tr>
							<tr>
								<td>
								'????????????'??? ?????? ?????? ??????
								</td>
								<td>
								???) ??????????????? 8 ??? '??????'??? ??????
								</td>
							</tr>
							<tr>
								<td>
								????????? ??????
								</td>
								<td>
								???) ???????????????, ????????????
								</td>
							</tr>
							<tr>
								<td colspan="2" class="desc pdt5">
								??????????????? ???????????? ?????????????????????.
								</td>
							</tr>
<?php }elseif($TPL_VAR["zipcode_type"]=="oldzibun"){?>
							<tr>
								<td>
								?????? ???????????????. 
								</td>
								<td>
								???) ????????????
								</td>
							</tr>
<?php }?>
							</table>
							
						</td>
					</tr>
					</table>
					</form>
				</td>
			</tr>
			<tr><td height="7"></td></tr>
<?php if($TPL_VAR["page"]["totalcount"]){?>
			<tr><td height="10" align="right">??? <?php echo number_format($TPL_VAR["page"]["totalcount"])?> ???</td></tr>
<?php }?>
			<tr><td height="3"></td></tr>
			<tr>
				<td style="padding:0px; background-color:#f9f9f9" align="center" >
					<div style="height:210px; padding:5px; overflow:auto;">

					<table width="100%" align="center" border="0">
					<col width="14%" />
					<col />
<?php if($TPL_VAR["zipcode_type"]!="oldzibun"){?>									
					<col width="36%" />
<?php }?>
					<tr>
						<th bgcolor="#eeeeee" height="20">????????????</th>
<?php if($TPL_VAR["zipcode_type"]=="oldzibun"){?>
						<th bgcolor="#eeeeee">?????? ??????</th>						
<?php }else{?>
						<th bgcolor="#eeeeee">????????? ??????</th>
						<th bgcolor="#eeeeee">?????? ??????</th>
<?php }?>
					</tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>					
					<tr class="zipcodeResult">					
						<th><div class="zipcode"><?php echo $TPL_V1["ZIPCODE"]?></div></th>
<?php if($TPL_VAR["zipcode_type"]=="oldzibun"){?>
						<td nowrap>
							<?php echo $TPL_V1["ADDRESSVIEW"]?>

							<div class="address hide"><?php echo $TPL_V1["ADDRESS"]?></div>
						</td>						
<?php }else{?>						
						<td align="left" ><?php echo $TPL_V1["ADDRESS_STREET"]?><div class="address_street hide"><?php echo $TPL_V1["ADDRESS_STREET"]?></div></td>
						<td align="left" ><?php echo $TPL_V1["ADDRESS"]?><div class="address hide"><?php echo $TPL_V1["ADDRESS"]?></div></td>
<?php }?>
					</tr>					
<?php }}?>
<?php if(!$TPL_VAR["loop"]){?>
					<tr>
						<td colspan="3" align="center" height="30">
<?php if($TPL_VAR["keyword"]){?>
								<br><br>
								?????? ????????? ????????????.
								<br><br><span class="desc">????????? ???????????? ?????? ????????? ??????????????? ????????????????????????<br>
								<a href="http://www.juso.go.kr" target="_blank">http://www.juso.go.kr</a> ?????? ??????????????? ????????????.</span>
<?php }else{?>
<?php if($TPL_VAR["zipcode_type"]=="zibun"||$TPL_VAR["zipcode_type"]=="oldzibun"){?>
								<strong>???/???/???</strong>??? ??????????????????.
<?php }else{?>
									<strong>?????????/?????????</strong>??? ????????? ?????????
<?php }?>
<?php }?>
						</td>
					</tr>
<?php }?>
					</table>					
<?php if($TPL_VAR["page"]["totalpage"]> 1){?>
					<table align="center" width="50%"  border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<div class="paging_navigation">
<?php if($TPL_VAR["page"]["first"]){?><a href="javascript:getZipcodeResult('<?php echo $TPL_VAR["zipcodeFlag"]?>','<?php echo $TPL_VAR["page"]["first"]?>');" class="first" ></a><?php }?>
<?php if($TPL_VAR["page"]["prev"]){?><a href="javascript:getZipcodeResult('<?php echo $TPL_VAR["zipcodeFlag"]?>','<?php echo $TPL_VAR["page"]["prev"]?>');" class="prev" ></a><?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["page"]["page"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_VAR["page"]["nowpage"]==$TPL_V1){?>
										<a href="javascript:getZipcodeResult('<?php echo $TPL_VAR["zipcodeFlag"]?>','<?php echo $TPL_V1?>');" class="on"><?php echo $TPL_V1?></a>
<?php }else{?>
										<a href="javascript:getZipcodeResult('<?php echo $TPL_VAR["zipcodeFlag"]?>','<?php echo $TPL_V1?>');"><?php echo $TPL_V1?></a>
<?php }?>
<?php }}?>
<?php if($TPL_VAR["page"]["next"]){?><a href="javascript:getZipcodeResult('<?php echo $TPL_VAR["zipcodeFlag"]?>','<?php echo $TPL_VAR["page"]["next"]?>');" class="next" ></a><?php }?>
<?php if($TPL_VAR["page"]["last"]){?><a href="javascript:getZipcodeResult('<?php echo $TPL_VAR["zipcodeFlag"]?>','<?php echo $TPL_VAR["page"]["last"]?>');" class="last" ></a><?php }?>
							</div>
						</td>
					</tr>
					</table>
<?php }?>

					</div>
				</td>
			</tr>
			</table>
		</div>

	</td>
</tr>
</table>