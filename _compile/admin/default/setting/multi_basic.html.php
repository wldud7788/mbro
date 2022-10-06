<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/setting/multi_basic.html 000046878 */ 
$TPL_systemmobiles_1=empty($TPL_VAR["systemmobiles"])||!is_array($TPL_VAR["systemmobiles"])?0:count($TPL_VAR["systemmobiles"]);
$TPL_language_codes_1=empty($TPL_VAR["language_codes"])||!is_array($TPL_VAR["language_codes"])?0:count($TPL_VAR["language_codes"]);
$TPL_currency_codes_1=empty($TPL_VAR["currency_codes"])||!is_array($TPL_VAR["currency_codes"])?0:count($TPL_VAR["currency_codes"]);
$TPL_shopBranch_1=empty($TPL_VAR["shopBranch"])||!is_array($TPL_VAR["shopBranch"])?0:count($TPL_VAR["shopBranch"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<script type="text/javascript" src="/app/javascript/jquery/jquery.tablednd.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript">
	function add_mobile_sale(price1,price2,sale,emoney,point){

		var trObj = $("#add_info_table > tbody");
		var addtr = "";
		var trLen = trObj.children("tr").length;

		if(trLen > 0) $(".add_mess").hide();
		
		addtr += "<tr>";
		addtr += "<td class='clear'>";
		addtr += "<table class='table_basic thl v3'>";
		addtr += "	<colgroup>";
		addtr += "		<col width='15%' />";					
		addtr += "		<col width='85%' />";
		addtr += "	</colgroup>";
		addtr += "		<tr>";
		addtr += "			<th class='left'>혜택 <span class='count'>" + (trLen) + "</span></th>";
		addtr += "			<td class='clear'>";
		addtr += "				<table class='table_basic thl v3'>";
		addtr += "					<colgroup>";
		addtr += "						<col width='20%' />";					
		addtr += "						<col width='80%' />";
		addtr += "					</colgroup>";
		addtr += "					<tr>";
		addtr += "						<th>금액</th>";
		addtr += "						<td>&#123;상품 할인가(판매가) x 수량&#125;+&#123;좌동&#125;+&#123;좌동&#125;…이";				
		addtr += "							<input type='text' name='mobile_price1[]' value='"+price1+"' size='6' class='line onlynumber input-box-default-text' /> ~";
		addtr += "							<input type='text' name='mobile_price2[]' value='"+price2+"' size='6' class='line onlynumber input-box-default-text' /> 일 때"; 		
		addtr += "						</td>";
		addtr += "					</tr>";
		addtr += "					<tr>";
		addtr += "					<th>추가 할인</th>";
		addtr += "						<td>상품 할인가(판매가) X 수량의";								
		addtr += "							<input type='text' name='mobile_sale_price[]' value='"+sale+"' size='3' class='line onlynumber input-box-default-text' /> % 할인";			
		addtr += "						</td>";
		addtr += "					</tr>";
		addtr += "					<tr>";
		addtr += "						<th>마일리지</th>";
		addtr += "						<td>";
		addtr += "							<ul class='ul_list_08'>"
		addtr += "								<li class='wx230'>";
		addtr += "								실 결제 금액의";
		addtr += "								<input type='text' name='mobile_sale_emoney[]' value='"+emoney+"' size='3' class='line onlynumber input-box-default-text' />";
		addtr += "								%  추가 지급";
		addtr += "								</li>";
		addtr += "								<li>유효기간 : <b><?php echo $TPL_VAR["reservetitle"]?></b>";
		addtr += "								</li></ul>";
		addtr += "						</td>";
		addtr += "					</tr>";
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
		addtr += "					<tr>";
		addtr += "						<th>포인트</th>";
		addtr += "						<td>";		
		addtr += "							<ul class='ul_list_08'><li class='wx230'>";
		addtr += "								실 결제 금액의 <input type='text' name='mobile_sale_point[]' value='"+point+"' size='3' class='line onlynumber input-box-default-text' />";
		addtr += "								%  추가 지급"; 
		addtr += "							</li>";
		addtr += "							<li>유효기간 : <b><?php echo $TPL_VAR["pointtitle"]?></b></li></ul>";		
		addtr += "						</td>";
		addtr += "					</tr>";
<?php }?>
		addtr += "				</table>";
		addtr += "			</td>";
		addtr += "		</tr>";
		addtr += "	</table>";
		addtr += "	</td>";
		addtr += "	<td class='center'>";
		addtr += "		<button class='btn_minus' type='button' onclick='del_mobile_sale(this);'></button>";
		addtr += "	</td>";	
		addtr += "</tr>";

		trObj.append(addtr);		
	}

	function del_mobile_sale(obj)
	{	
		if($(obj).closest("tr").siblings().length == 1) $(obj).closest("table").find(".add_mess").show();
		$(obj).closest("tr").remove();
		
		var len = $("#add_info_table > tbody > tr").length;
		
		for(var i=0; i<len; i++)
		{			
			$("#add_info_table > tbody > tr").eq(1+i).find(".count").html(i+1);
		}
	}

	function span_controller(name,type){
		if(type=='mobile')	type_name = type+'_';
		else				type_name = '';

		var reserve_y = $("span[name='"+type_name+name+"_y']");
		var reserve_d = $("span[name='"+type_name+name+"_d']");
		var value = $("select[name='"+type+"_"+name+"_select'] option:selected").val();
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

	function newNaverApiUse(){
		$("input[name='naverMapKey'][value='API']").click().prop('checked',true);
		$('#newNaverPopup').dialog('close');
	}

	function admin_auth_info(){
		openDialog("대표자 인증 관련법령", "adminAuthInfoPopup", {"width":400,"height":200});
	}

	var imgUploadConfig = {'overwrite' : true, 'allowed_types' : 'jpg|gif|png|ico'};
	var icoImgUploadConfig = {'overwrite' : true, 'allowed_types' : 'ico'};

	$(document).ready(function() 
	{
		//파비콘
		$('#ex_file').createAjaxFileUpload(icoImgUploadConfig, uploadCallback);
<?php if($TPL_VAR["data_admin_env"]["favicon"]){?>imgUploadEvent("#ex_file", "", "", "<?php echo $TPL_VAR["data_admin_env"]["favicon"]?>")<?php }?>	

		//인감 이미지
		$('#signatureicon').createAjaxFileUpload(uploadConfig, uploadCallback);
<?php if($TPL_VAR["config_system"]["signatureicon"]){?>imgUploadEvent("#signatureicon", "", "", "<?php echo $TPL_VAR["config_system"]["signatureicon"]?>")<?php }?>	

		//아이폰 이미지
		$('#iphoneicon').createAjaxFileUpload(imgUploadConfig, uploadCallback);
<?php if($TPL_VAR["config_system"]["iphoneicon"]){?>imgUploadEvent("#iphoneicon", "", "", "<?php echo $TPL_VAR["config_system"]["iphoneicon"]?>")<?php }?>	

		//안드로이드 이미지
		$('#androidicon').createAjaxFileUpload(imgUploadConfig, uploadCallback);
<?php if($TPL_VAR["config_system"]["androidicon"]){?>imgUploadEvent("#androidicon", "", "", "<?php echo $TPL_VAR["config_system"]["androidicon"]?>")<?php }?>	
		
<?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>
		//본사 미니샵 이미지
		$('#vidualBtn').createAjaxFileUpload(uploadConfig, uploadCallback);
<?php if($TPL_VAR["providerdatainfo"]["main_visual"]){?>imgUploadEvent("#vidualBtn", "", "", "<?php echo $TPL_VAR["providerdatainfo"]["main_visual"]?>")<?php }?>
<?php }?>
		

		// 우편번호 검색
		$("#companyZipcodeButton").live("click",function(){
			openDialogZipcode('company');
		});

		// 메일
		$("select[name=emailList]").live("change",function(){
			$(this).parent().children(".emailListInput").val($(this).val());
		});

		$(".tablednd").tableDnD({onDragClass: "dragRow"});

		// 쇼핑몰 분류 2차 불러오기
		$("select[name='shopBranchSel']").live("change",function(){
			$("select[name='shopBranchSub'] option:gt(0)").remove();
			$("select[name='shopBranchSub'] option:eq(0)").attr('selected','selected');

			if($(this).val()){
				var url = '../../common/code2json?groupcd=shopBranch'+$(this).val();
				$.getJSON(url, function(data) {
				
					for(var i=0;i<data.length;i++){
						$("select[name='shopBranchSub']").append("<option value='"+data[i].codecd+"'>"+data[i].value+"</option>");
					}
				});
			}
		});
		

		$(".branchDelete").live("click",function(){
			$(this).parent().remove();
		});

		
		$("#shopBranchButton").live("click",function(){
			var sel1_val = $("select[name='shopBranchSel']").val();
			var sel2_val = $("select[name='shopBranchSub']").val();
			var sel1_opt = $("select[name='shopBranchSel'] option:selected").text();
			var sel2_opt = $("select[name='shopBranchSub'] option:selected").text();

			if(sel2_val == ''){
				alert( sel2_opt );
				return false;
			}

			if($("input[name='shopBranch[]'][value='"+sel2_val+"']").length >= 1) {
				alert('이미 등록된 분류입니다!');
				return false;
			}

			$("#shopBranchLayer").append("<div>"+sel1_opt+" > "+sel2_opt+"<input type='hidden' name='shopBranch[]' value='"+sel2_val+"'/> <a class='hand branchDelete'><img src='/admin/skin/default/images/common/icon_del.gif' align='absmiddle' /></a></div>");

		
		});

		$(":input[name=shopBranchChoice]").bind("click",function(){
			openDialog("쇼핑몰 분류 <span class='desc'>쇼핑몰 분류를 선택합니다.</span>", "shopBranchPopup", {"width":500});
		});

		// 즐겨찾기 관련 기능 :: 2016-01-04 lwh
		$("select[name='book_reserve_select']").bind("change",function(){
			span_controller('reserve','book');
		});
		$("select[name='book_point_select']").bind("change",function(){
			span_controller('point','book');
		});

		span_controller('reserve','book');
		span_controller('point','book');

		$('#book_reserve_year').val('<?php echo $TPL_VAR["reserve"]["book_reserve_year"]?>');
		$('#book_point_year').val('<?php echo $TPL_VAR["reserve"]["book_point_year"]?>');

		$(".registMshopVisualimage").live("click",function(){
			$provider_id	= '<?php echo $TPL_VAR["providerdatainfo"]["provider_id"]?>';
			window.open('../setting/mshop_popup_image?id='+$provider_id+'&target=main_visual','','width=500,height=250');
		});

		$("#main_visual_name").live('mouseover',	function(){$('#preview_main_visual').show();});
		$("#main_visual_name").live('mouseout',		function(){$('#preview_main_visual').hide();});
<?php if($TPL_VAR["providerdatainfo"]["main_visual"]){?>
		$(".deleteVisual").live("click",function(){
			$("input[name='del_main_visual']").val('y');
			$("#btn_deletevidual").hide();
			$("#main_visual_name").html('');
			$("#preview_main_visual").html('');
		});
<?php }?>

		$("input[name='naverMapKey']").click(function(){
			if($(this).val() == 'Client')
				openDialog("알림", 'newNaverPopup', {'width':400,'height':170});
			$(".naverMapSelect").hide();
			if($(this).val()){
				$("#naverMap_"+$(this).val()).show();
			}
		}).eq(0).click();
		$(".naver_map_key").click(function(){
			get_sns_guide_ajax("navermap","네이버 지도 Client ID 발급 안내","naverMapKeyPopup",800,700);
		});	
<?php if($TPL_VAR["systemmobiles"]){?>
<?php if($TPL_systemmobiles_1){foreach($TPL_VAR["systemmobiles"] as $TPL_V1){?>
				add_mobile_sale(<?php echo $TPL_V1["price1"]?>,<?php echo $TPL_V1["price2"]?>,<?php echo $TPL_V1["sale_price"]?>,<?php echo $TPL_V1["sale_emoney"]?>,<?php echo $TPL_V1["sale_point"]?>);
<?php }}?>
<?php }?>

		$("input[name='provider_chk']").bind("click",function(){
			if($(this).attr("checked")){
				$("#p_num").hide();
				$("input[name='providerNumber[]']").val('');
			}else{
				$("#p_num").show();
			}
		});
	});

	// 아이콘 삭제 :: 2016-01-06 lwh
	function itemDelect(){
			var _icontype = $(this).closest("div").attr('icontype');
			var icon	= (_icontype) ? _icontype : 'favicon';
			var url		= '../setting_process/icon_delete?icontype='+icon;
			var obj		= $(this);
			console.log(_icontype);
			
			// 인감 이미지일 경우 다른 메세지 :: 2019-08-28 pjw
			var alerttopic	= icon == 'signatureicon' ? '인감이미지' : '아이콘';
			var alertmsg	= icon == 'signatureicon' ? '인감이미지가 변경되었습니다.' : '아이콘(파비콘)이 삭제 되었습니다.';

			$.getJSON(url, function(data) {
				if(data['result'] == 'ok'){
					openDialogAlert(alertmsg, 0, 0, function(){
						obj.parent('.iconspan').remove();
					});
				}else{
					alert( alerttopic + ' 삭제중 오류가 발생하였습니다\n새로고침 후 다시 시도해주세요.');
				}
			});
		};

</script>
 
<style type="text/css">
	#main_visual_name {
		cursor: pointer;
	}
	#preview_main_visual {
		position: absolute;
		border: 1px solid #e4e4e4;
		z-index: 1000;
		background-color: #ffffff;
		display: none;
	}
	table.change_password tr th {
		font-weight:normal;
		padding-right:10px;
		text-align:right;
	}
	div.basic-info ul li {
		float:left;
		padding-left:5px;
		width:49%;
	}
	.link_color {
		color: rgb(205, 80, 11) !important;
	}
	span.reference_mark {
		display:inline-block;
		font-weight:bold;
		font-family:tahoma;
		vetical-align:top;
		padding-bottom:4px;
	}
</style>

<form name="settingForm" method="post" enctype="multipart/form-data" action="../setting_process/multi_basic" target="actionFrame">
<!--구 스킨 meta 노출용 제거하지 마세요-->
<input type="hidden" name="metaTagUse" value="<?php echo $TPL_VAR["metaTagUse"]?>"/>
<input name="admin_env_seq" type="hidden" value="<?php echo $TPL_VAR["data_admin_env"]["admin_env_seq"]?>" />

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
			<h2>상점 정보</h2>
		</div>

		<!-- 우측 버튼 -->
		<div class="page-buttons-right">
			<button class="resp_btn active size_L" type="submit">저장</button>
		</div>

	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<!-- 서브 레이아웃 영역 : 시작 -->	
<!-- 기본정보 시작 ----->
<div class="contents_dvs">
	<div class="item-title">기본 정보</div>
	<table class="table_basic thl">		
		<tr>
			<th>
				쇼핑몰명<span class="required_chk"></span>
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip17')"></span>
			</th>
			<td><input class="wx250" type="text" name="admin_env_name" size="20" maxlength="20" value="<?php echo $TPL_VAR["data_admin_env"]["admin_env_name"]?>" /></td>
		</tr>	
		
		<tr>
			<th>
				관리 도메인
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip16')"></span>
			</th>
			<td>						
				<?php echo $TPL_VAR["data_admin_env"]["temp_domain"]?>

				<input name="temp_domain" type="hidden" value="<?php echo $TPL_VAR["data_admin_env"]["temp_domain"]?>" />
			</td>
		</tr>
		
		<tr>
			<th>
				대표 도메인
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip1')"></span>
			</th>
			<td>
				<input class="wx250" type="text" name="domain" value="http://<?php echo $TPL_VAR["data_admin_env"]["domain"]?>" />
				<div class="resp_message v2">
					- <a href="https://firstmall.kr/myshop/index.php" class="link_blue_01" target="_blank">MY퍼스트몰</a>에서 연결한 대표 도메인을 입력해주세요.<br />
					- 도메연 연결/변경 방법 <a href="https://www.firstmall.kr/customer/faq/10" class="link_blue_01" target="_blank">자세히 보기</a>
				</div>

			</td>
		</tr>			

		<tr>
			<th>설치일</th>
			<td><?php echo $TPL_VAR["config_system"]["service"]["setting_date"]?></td>
		</tr>

		<tr>
			<th>종료일</th>
			<td>						
<?php if(solutionServiceCheck( 1)){?>
				평생 <span class="gray">(단, 관리자 미접속 30일 차단, 60일 삭제)</span>
<?php }elseif($TPL_VAR["expireDay"]&&(solutionServiceCheck( 6790)||solutionServiceCheck( 32)||(solutionServiceCheck( 1304)&&$TPL_VAR["config_system"]["service"]["hosting_code"]!='F_SH_X'))){?>
				<?php echo $TPL_VAR["expireDay"]?>

<?php }else{?>
				없음
<?php }?>
			</td>
		</tr>

	</table>
</div>

<!----------- 기본정보 끝 ------------------------------------------------------------------>

<!----------- 통화 및 환율 시작 -------------------------------------------------------------->
<div class="contents_dvs">
	<div class="item-title">언어/화폐</div>
	<div class="dvs_box">
		<ul class="tab_01 v2 w160 tabEvent ">
			<li><a href="javascript:void(0);" data-showcontent="tabCon1" class="current">언어/화폐</a></li>
			<li>
				<a href="javascript:void(0);" data-showcontent="tabCon2">
					비교 화폐 및 환율
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/skin/default/tooltip/multi.html', '#tip4')"></span>
				</a>					
			</li>
			<li>
				<a href="javascript:void(0);" data-showcontent="tabCon3">
					화폐 절사 기준
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/skin/default/tooltip/multi.html', '#tip5')"></span>
				</a>					
			</li>												
		</ul>

		<table class="table_basic thl" id="tabCon1" >
			<tr>
				<th>
					안내 언어
					<span class="tooltip_btn" onClick="showTooltip(this, '/admin/skin/default/tooltip/multi.html', '#tip2')"></span>
				</th>
				<td>
					<select name="language">
<?php if($TPL_language_codes_1){foreach($TPL_VAR["language_codes"] as $TPL_K1=>$TPL_V1){?>
						<option value="<?php echo $TPL_K1?>" <?php if($TPL_VAR["data_admin_env"]["language"]==$TPL_K1){?>selected<?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
					</select>
				</td>
			</tr>
		
			<tr>
				<th>
				기본 화폐
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/skin/default/tooltip/multi.html', '#tip3')"></span>
				</th>
				<td>
					<select name="basic_currency" <?php if($TPL_VAR["data_admin_env"]["first_goods_date"]){?>disabled<?php }?>>
<?php if($TPL_currency_codes_1){foreach($TPL_VAR["currency_codes"] as $TPL_K1=>$TPL_V1){?>
						<option value="<?php echo $TPL_K1?>" <?php if($TPL_K1==$TPL_VAR["data_admin_env"]["currency"]){?>selected<?php }?>><?php echo $TPL_K1?></option>
<?php }}?>
					</select>
					<span class="red ml5">최초 상품 등록 이후부터는 기본 화폐를 변경할 수 없습니다.</span> 
				</td>
			</tr>
		</table>
		
		<table class="table_basic tdc tablednd hide v7" id="tabCon2">				
			<colgroup>
				<col width="10%" />					
				<col width="10%" />
				<col width="80%" />								
			</colgroup>
			<thead>
				<tr class="nodrag nodrop">
					<th>순서</th>						
					<th>비교 화폐</th>
					<th>
						환율
<?php if(is_array($TPL_R1=$TPL_VAR["data_admin_env"]["currency_loop"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["currency"]==$TPL_VAR["data_admin_env"]["currency"]){?>									
<?php if(is_array($TPL_R2=code_load('currency_amout',$TPL_VAR["data_admin_env"]["currency"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						(<?php echo $TPL_V2["value"]?><span class="basic_currency"> <?php echo $TPL_VAR["data_admin_env"]["currency"]?></span> 기준)
<?php }}?>
<?php }?>
<?php }}?>
					</th>							
				</tr>	
			</thead>
			
<?php if(is_array($TPL_R1=$TPL_VAR["data_admin_env"]["compare_currencys"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>						
<?php if(is_array($TPL_R2=code_load('currency'))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V1==$TPL_V2["codecd"]){?>						
			<tr>								
				<td><img src="/admin/skin/default/images/common/icon_move.png" /></td>					
				<td>					
					<label class="resp_checkbox mr5"><input type="checkbox" id="<?php echo $TPL_V2["codecd"]?>" name="compare_currency[]" value="<?php echo $TPL_V2["codecd"]?>" checked ></label>					
					<img src='/admin/skin/default/images/common/<?php echo $TPL_V2["codecd"]?>.jpg' align="absmiddle" /></td>
				<td class="left">
<?php if(is_array($TPL_R3=$TPL_VAR["data_admin_env"]["currency_loop"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
<?php if($TPL_V3["currency"]!=$TPL_VAR["data_admin_env"]["currency"]&&$TPL_V3["currency"]==$TPL_V2["codecd"]){?>						
							<input type="hidden" name="currency_exchange_seq[]" value="<?php echo $TPL_V3["currency_seq"]?>" />
							<input type="text" name="currency_exchange[]" size="30" value="<?php echo $TPL_V3["currency_exchange"]?>">
							<label> <?php echo $TPL_V3["currency"]?></label>	
<?php }?>
<?php }}?>										
				</td>
			</tr>
<?php }?>
<?php }}?>
<?php }}?>

<?php if(is_array($TPL_R1=code_load('currency'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(!in_array($TPL_V1["codecd"],$TPL_VAR["data_admin_env"]["compare_currencys"])&&$TPL_V1["codecd"]!=$TPL_VAR["data_admin_env"]["currency"]){?>	
			
			<tr>
				<td><img src="/admin/skin/default/images/common/icon_move.png" /></td>
				<td>					
					<label class="resp_checkbox mr5"><input type="checkbox" id="<?php echo $TPL_V1["codecd"]?>" name="compare_currency[]" value="<?php echo $TPL_V1["codecd"]?>" ></label>					
					<img src='/admin/skin/default/images/common/<?php echo $TPL_V1["codecd"]?>.jpg' align="absmiddle" />
				</td>					
				<td class="left">		
<?php if(is_array($TPL_R2=$TPL_VAR["data_admin_env"]["currency_loop"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["currency"]!=$TPL_VAR["data_admin_env"]["currency"]&&$TPL_V2["currency"]==$TPL_V1["codecd"]){?>						
							<input type="hidden" name="currency_exchange_seq[]" value="<?php echo $TPL_V2["currency_seq"]?>" />
							<input type="text" name="currency_exchange[]" size="30" value="<?php echo $TPL_V2["currency_exchange"]?>">
							<label > <?php echo $TPL_V2["currency"]?></label>	
<?php }?>
<?php }}?>
				</td>
			</tr>
<?php }?>
<?php }}?>
		</table>
		
		<table class="table_basic thl hide" id="tabCon3">
						
<?php if(is_array($TPL_R1=$TPL_VAR["data_admin_env"]["currency_loop"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
			<tr>
				<th class="center">
					<input type="hidden" name="currency_seq[]" value="<?php echo $TPL_V1["currency_seq"]?>" />
					<input type="hidden" name="currency_kind[]" value="<?php echo $TPL_V1["currency"]?>" />
					<img src='/admin/skin/default/images/common/<?php echo $TPL_V1["currency"]?>.jpg' align="absmiddle" />
					<?php echo $TPL_V1["currency"]?>

				</th>								
				<td >
					<select name="currency_symbol_position[]">
<?php if(is_array($TPL_R2=code_load('currency_symbol_position'))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<option value="<?php echo $TPL_V2["codecd"]?>" <?php if($TPL_V1["currency_symbol_position"]==$TPL_V2["codecd"]){?>selected<?php }?>><?php echo $TPL_V2["value"]?></option>
<?php }}?>
					</select>

					<select name="currency_symbol[]" class="wx70" >
<?php if(is_array($TPL_R2=code_load('currency_symbol',$TPL_V1["currency"]))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if(is_array($TPL_R3=$TPL_V2["value"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
						<option value="<?php echo htmlspecialchars($TPL_V3)?>" <?php if($TPL_V1["currency_symbol"]==$TPL_V3){?>selected<?php }?>><?php echo $TPL_V3?></option>
<?php }}?>
<?php }}?>
					</select>

					<select name="cutting_price[]">
<?php if(is_array($TPL_R2=code_load('cutting_price'))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<option value="<?php echo $TPL_V2["codecd"]?>" <?php if($TPL_V1["cutting_price"]==$TPL_V2["codecd"]){?>selected<?php }?>><?php echo $TPL_V2["value"]?></option>
<?php }}?>
					</select>

					<select name="cutting_action[]">
<?php if(is_array($TPL_R2=code_load('cutting_action'))&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<option value="<?php echo $TPL_V2["codecd"]?>" <?php if($TPL_V1["cutting_action"]==$TPL_V2["codecd"]){?>selected<?php }?>><?php echo $TPL_V2["value"]?></option>
<?php }}?>
					</select>
				</td>							
			</tr>
<?php }}?>
		</table>
	</div>
</div>
<!--------------- 통화 및 환율 끝 ------------------------------------------------------------>			

<!--------------- 사업자 정보 시작 ------------------------------------------------------------>
<div class="contents_dvs">
	<div class="item-title">
		사업자 정보
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip6')"></span>
	</div>

	<table class="table_basic thl">
		<tr>
			<th>상호(회사명)<span class="required_chk"></span></th>
			<td><input type="text" name="companyName" value="<?php echo $TPL_VAR["companyName"]?>" size="45" class="line" /></td>
		</tr>

		<tr>
			<th>
				사업자 번호
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip7')"></span>
			</th>
			<td>
				<input type="text" name="businessLicense[]" value="<?php echo $TPL_VAR["businessLicense"][ 0]?>" size='4' class="line" /> - 
				<input type="text" name="businessLicense[]" value="<?php echo $TPL_VAR["businessLicense"][ 1]?>" size='3' class="line" /> - 
				<input type="text" name="businessLicense[]" value="<?php echo $TPL_VAR["businessLicense"][ 2]?>" size='6' class="line" />
			</td>
		</tr>

		<tr>
			<th>대표자 이름</th>
			<td><input type="text" name="ceo" value="<?php echo $TPL_VAR["ceo"]?>" size="45 class="line" /></td>
		</tr>
		
		<tr>
			<th>
				대표자 인증
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip8')"></span>
			</th>
			<td>					
				<button class="resp_btn" type="button" onclick="window.open('https://firstmall.kr/myshop/spec/manager_information.php?num=<?php echo $TPL_VAR["config_system"]["shopSno"]?>');">대표자 인증</button>
				<span class="hide">
<?php if($TPL_VAR["config_system"]["mall_auth_yn"]!='y'){?>
					(미인증)
<?php }else{?>
					(인증됨)
<?php }?>
				</span>
			</td>
		</tr>

		<tr>
			<th>업태/종목</th>
			<td>
				<input type="text" name="businessConditions" value="<?php echo $TPL_VAR["businessConditions"]?>" title="예) 도소매" /> / <input type="text" name="businessLine" value="<?php echo $TPL_VAR["businessLine"]?>" title="예) 전자상거래" />
			</td>
		</tr>

		<tr>
			<th>사업장 주소</th>
			<td>											
				<dl class="dl_list_01 w70">
					<dt>우편번호</dt>
					<dd>
						<input type="hidden" name="companyAddress_type" value="<?php echo $TPL_VAR["companyAddress_type"]?>" />
						<input type="text" name="companyZipcode[]" value="<?php echo $TPL_VAR["companyZipcode"]?>" size="7" />
						<input class="resp_btn" type="button" id="companyZipcodeButton" value="주소찾기" />
					</dd>
				</dl>
				<dl class="dl_list_01 w70 mt3">
					<dt>지번</dt>
					<dd><input type="text" name="companyAddress" value="<?php echo $TPL_VAR["companyAddress"]?>" class="wx500" /></dd>
				</dl>
				<dl class="dl_list_01 w70 mt3">							
					<dt>도로명</dt>
					<dd><input type="text" name="companyAddress_street" value="<?php echo $TPL_VAR["companyAddress_street"]?>" class="wx500" /></dd>
				</dl>
				<dl class="dl_list_01 w70 mt3">							
					<dt>상세주소</dt>
					<dd><input type="text" name="companyAddressDetail" value="<?php echo $TPL_VAR["companyAddressDetail"]?>" class="wx500" /></dd>
				</dl>
			</td>
		</tr>

		<tr>
			<th>대표 전화번호</th>
			<td>
				<input type="text" name="area_number" value="<?php echo $TPL_VAR["companyPhone"][ 0]?>" size="5" class="line" /> - 
				<input type="text" name="companyPhone[1]" value="<?php echo $TPL_VAR["companyPhone"][ 1]?>" size="5" class="line" /> - 
				<input type="text" name="companyPhone[2]" value="<?php echo $TPL_VAR["companyPhone"][ 2]?>" size="5" class="line" />
<?php if(serviceLimit('H_AD')==true){?>
				<label class="resp_checkbox"><input type="checkbox" name="provider_chk" value="Y" <?php if($TPL_VAR["providerNumber"]){?> <?php }else{?> checked="checked"<?php }?>/> 입점사 안내용 전화번호와 동일</label>
<?php }?>
			</td>
		</tr>
<?php if(serviceLimit('H_AD')==true){?>
		<tr id="p_num" <?php if($TPL_VAR["providerNumber"]){?> <?php }else{?> style="display : none" <?php }?>>
			<th>입점사 안내용 전화번호<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip18')"></span></th>
			<td>
				<input type="text" name="providerNumber[]" value="<?php echo $TPL_VAR["providerNumber"][ 0]?>" size="5" class="line" /> - 
				<input type="text" name="providerNumber[]" value="<?php echo $TPL_VAR["providerNumber"][ 1]?>" size="5" class="line" /> - 
				<input type="text" name="providerNumber[]" value="<?php echo $TPL_VAR["providerNumber"][ 2]?>" size="5" class="line" />
			</td>
		</tr>
<?php }?>
		<tr>
			<th>대표 팩스번호</th>
			<td>
				<input type="text" name="companyFax[]" value="<?php echo $TPL_VAR["companyFax"][ 0]?>" size="5" class="line" /> - 
				<input type="text" name="companyFax[]" value="<?php echo $TPL_VAR["companyFax"][ 1]?>" size="5" class="line" /> - 
				<input type="text" name="companyFax[]" value="<?php echo $TPL_VAR["companyFax"][ 2]?>" size="5" class="line" />
			</td>
		</tr>

		<tr>
			<th>대표 이메일</th>
			<td>
				<input type="text" name="companyEmail[]" value="<?php echo $TPL_VAR["companyEmail"][ 0]?>" size="15" class="line" /> @
				<input type="text" name="companyEmail[]" value="<?php echo $TPL_VAR["companyEmail"][ 1]?>" size="15" class="emailListInput line" />
				<select class="line" name="emailList">
					<option value="">직접입력</option>
<?php if(is_array($TPL_R1=code_load('email'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["codecd"]?>"><?php echo $TPL_V1["value"]?></option>
<?php }}?>
				</select>
				<div class="resp_message v2">
					-  대표 이메일은 자사 도메인 이메일 주소를 사용하길 권장합니다.</br>
					-  대표 이메일 주소가 포털 사이트 주소인 경우(예. 구글, 네이버, 다음 등), 메일 발송 시 스팸 메일로 분류되거나 별도의 리턴 메일이 발생할 수 있습니다.
				</div>
			</td>
		</tr>
<?php if(serviceLimit('H_AD')){?>
		<tr>
			<th>입점문의 수신 이메일</th>
			<td>
				<input type="text" name="partnershipEmail[]" value="<?php echo $TPL_VAR["partnershipEmail"][ 0]?>" size="15" class="line" /> @
				<input type="text" name="partnershipEmail[]" value="<?php echo $TPL_VAR["partnershipEmail"][ 1]?>" size="15" class="emailListInput line" />
				<select class="line" name="emailList">
					<option value="">직접입력</option>
<?php if(is_array($TPL_R1=code_load('email'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["codecd"]?>"><?php echo $TPL_V1["value"]?></option>
<?php }}?>
				</select>
			</td>
		<tr>
	
<?php if($TPL_VAR["config_system"]["operation_type"]!='light'){?>
		<tr>
			<th>본사 미니샵 이미지</th>
			<td>
				<div class="webftpFormItem">									
					<label class="resp_btn v2"><input type="file" id="vidualBtn" accept="image/*"/>파일선택</label>
					<input type="hidden" class="webftpFormItemInput" name="main_visual" value="<?php echo $TPL_VAR["providerdatainfo"]["main_visual"]?>" />
					<input type="hidden" name="del_main_visual" value="n" />
					<input type="hidden" name="org_main_visual" value="<?php echo $TPL_VAR["providerdatainfo"]["main_visual"]?>" />														
					<div class="preview_image"></div>
				</div>					
			</td>
		</tr>
<?php }?>
<?php }?>
			<th>개인정보 보호책임자</th>
			<td><input type="text" name="member_info_manager" value="<?php echo $TPL_VAR["member_info_manager"]?>" size="45" class="line" /></td>
		</tr>

		<tr>
			<th>
				통신판매업 신고번호
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip9')"></span>
			</th>
			<td><input type="text" name="mailsellingLicense" value="<?php echo $TPL_VAR["mailsellingLicense"]?>" size="45" class="line" /></td>
		</tr>
	</table>
</div>
<!--------------- 사업자 정보 끝 ------------------------------------------------------------>

<!--------------- 거래 명세서 및 견적서 시작 ------------------------------------------------------------>
<div class="contents_dvs">
	<div class="item-title">거래 명세서 및 견적서</div>
	<table class="table_basic thl">		
		<tr>
			<th>인감이미지</th>
			<td>					
				<div class="webftpFormItem" icontype="signatureicon">									
					<label class="resp_btn v2"><input type="file" id="signatureicon" accept="image/*"/>파일선택</label>
					<input type="hidden" class="webftpFormItemInput" name="signatureicon" value="<?php echo $TPL_VAR["config_system"]["signatureicon"]?>" />									
					<div class="preview_image"></div>
				</div>					
				<div class="resp_message v2">- 파일 형식 jpg, gif, png</div>
			</td>
		</tr>

		<tr>
			<th>
				견적서
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip10')"></span>
			</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="useestimate" id="useestimate" value="Y" <?php if($TPL_VAR["useestimate"]=="Y"){?>checked="checked"<?php }?>> 사용함</label>
					<label><input type="radio" name="useestimate" id="useestimate2" value="N" <?php if($TPL_VAR["useestimate"]=="N"||$TPL_VAR["useestimate"]==""){?>checked="checked"<?php }?>> 사용 안 함</label>			
				</div>		
			</td>
		</tr>

		<tr>
			<th>
				거래명세서
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip11')"></span>
			</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="usetradeinfo" id="usetradeinfo" value="Y" <?php if($TPL_VAR["usetradeinfo"]=="Y"){?>checked="checked"<?php }?>> 사용함</label>
					<label><input type="radio" name="usetradeinfo" id="usetradeinfo2" value="N" <?php if($TPL_VAR["usetradeinfo"]=="N"||$TPL_VAR["usetradeinfo"]==""){?>checked="checked"<?php }?>> 사용 안 함</label>	
				</div>
			</td>
		</tr>

	</table>
</div>
<!--------------- 거래 명세서 및 견적서 끝 ------------------------------------------------------------>

<!--------------- 추가 정보 시작 ------------------------------------------------------------>
<div class="contents_dvs">
	<div class="item-title">추가 정보</div>
	<table class="table_basic thl">
		<tr>
			<th>
				쇼핑몰 분류						
			</th>
			<td>
				<input type="button" class="resp_btn v2" name="shopBranchChoice" value="선택" />
				<div id="shopBranchLayer">
<?php if($TPL_shopBranch_1){foreach($TPL_VAR["shopBranch"] as $TPL_V1){?>
					<div><?php echo $TPL_V1["groupcd1"]?> > <?php echo $TPL_V1["groupcd2"]?><input type='hidden' name='shopBranch[]' value='<?php echo $TPL_V1["codecd"]?>'/> <a class='hand branchDelete'><img src="/admin/skin/default/images/common/icon_del.gif" align="absmiddle" /></a></div>
<?php }}?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				파비콘
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip13')" />
			</th>
			<td>
				<div class="webftpFormItem">									
					<label class="resp_btn v2"><input type="file" id="ex_file" accept=".ico"/>파일선택</label>						
					<input type="hidden" class="webftpFormItemInput" name="faviconFile" value="<?php echo $TPL_VAR["data_admin_env"]["favicon"]?>" />									
					<div class="preview_image"></div>
				</div>
				
				<div class="resp_message v2">- 파일 형식 ico, 이미지 사이즈 16px*16px</div>
			</td>
		</tr>

		<tr>
			<th>
				모바일 바탕화면 아이콘
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip12')"></span>
			</th>
			<td class="clear">
				<table class="table_basic thl v3" width="100%">			
					<tr>
						<th>아이폰</th>								
						<td>
							<div class="webftpFormItem">									
								<label class="resp_btn v2"><input type="file" id="iphoneicon" accept=".jpg, .gif, .png, .ico"/>파일선택</label>
								<input type="hidden" class="webftpFormItemInput" name="iphoneicon" value="<?php echo $TPL_VAR["config_system"]["iphoneicon"]?>" />									
								<div class="preview_image" icontype="iphoneicon"></div>
							</div>									
							<div class="resp_message v2">- 파일 형식 jpg, gif, png, ico, 이미지 사이즈 114px*114px </div>
						</td>
					</tr>							
					<tr>
						<th>안드로이드</th>
						<td>
							<div class="webftpFormItem" >									
								<label class="resp_btn v2"><input type="file" id="androidicon" accept=".jpg, .gif, .png, .ico"/>파일선택</label>
								<input type="hidden" class="webftpFormItemInput" name="androidicon" value="<?php echo $TPL_VAR["config_system"]["androidicon"]?>" />									
								<div class="preview_image" icontype="androidicon"></div>
							</div>	
							<div class="resp_message v2">- 파일 형식 jpg, gif, png, ico, 이미지 사이즈 129px*129px</div>
						</td>
					</tr>							
				</table>
			</td>
		</tr>			
	</table>
</div>
<!--------------- 추가 정보 끝 ------------------------------------------------------------>

<!--------------- 즐겨 찾기 혜택 시작 ------------------------------------------------------------>
<div class="contents_dvs">
	<div class="item-title">회원 혜택 설정</div>	
	<table class="table_basic thl">
<?php if(serviceLimit('H_NFR')){?>
		<tr>
			<th>
				즐겨찾기
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip14')"></span>
			</th>
			<td class="clear">
				<table class="table_basic thl v3">
				<tr>
					<th>마일리지</th>
					<td>
						<ul class="ul_list_08">
							<li class="wx180">								
								<input type="text" name="default_reserve_bookmark" style="text-align:right" size="10" class="line onlynumber" value="<?php echo $TPL_VAR["reserve"]["default_reserve_bookmark"]?>" />
									<?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 지급								
							</li>

							<li>							
								유효기간 :
								<select name="book_reserve_select">
									<option value="">제한하지 않음</option>
									<option value="year" <?php if($TPL_VAR["reserve"]["book_reserve_select"]=='year'){?>selected<?php }?>>제한</option>
									<option value="direct" <?php if($TPL_VAR["reserve"]["book_reserve_select"]=='direct'){?>selected<?php }?>>제한(직접입력)</option>
								</select>
								<span name="reserve_y" class="hide">
									 지급연도 +
									<select name="book_reserve_year" id="book_reserve_year">
										<option value="0">0년</option>
										<option value="1">1년</option>
										<option value="2">2년</option>
										<option value="3">3년</option>
										<option value="4">4년</option>
										<option value="5">5년</option>
										<option value="6">6년</option>
										<option value="7">7년</option>
										<option value="8">8년</option>
										<option value="9">9년</option>
										<option value="10">10년</option>
									</select>
									년도 12월 31일
								</span>
								<span name="reserve_d" class="hide">→ <input type="text" name="book_reserve_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["reserve"]["book_reserve_direct"]?>" />개월</span>
							</li>
						</ul>						
					</td>
				</tr>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
				<tr>
					<th>포인트</th>
					<td>
						<ul class="ul_list_08">
							<li class="wx180">						
								<input type="text" name="default_point_bookmark" style="text-align:right" size="10" class="line onlynumber" value="<?php echo $TPL_VAR["reserve"]["default_point_bookmark"]?>" /> P 지급
							</li>
							<li>
								유효기간 :
								<select name="book_point_select" <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly="readonly" disabled='disabled'  class="gray readonly"  <?php }?>  >
									<option value="">제한하지 않음</option>
									<option value="year" <?php if($TPL_VAR["reserve"]["book_point_select"]=='year'){?>selected<?php }?>>제한</option>
									<option value="direct" <?php if($TPL_VAR["reserve"]["book_point_select"]=='direct'){?>selected<?php }?>>제한(직접입력)</option>
								</select>
								<span name="point_y" class="hide">
									 지급연도 +
									<select name="book_point_year" id="book_point_year">
										<option value="0">0년</option>
										<option value="1">1년</option>
										<option value="2">2년</option>
										<option value="3">3년</option>
										<option value="4">4년</option>
										<option value="5">5년</option>
										<option value="6">6년</option>
										<option value="7">7년</option>
										<option value="8">8년</option>
										<option value="9">9년</option>
										<option value="10">10년</option>
									</select>
									년도 12월 31일
								</span>
								<span name="point_d" class="hide">→ <input type="text" name="book_point_direct" class="line onlynumber" style="text-align:right" size="3" value="<?php echo $TPL_VAR["reserve"]["book_point_direct"]?>" />개월</span>
							</li>
						</ul>
					</td>
				</tr>
<?php }?>
				</table>
			</td>
		</tr>

<?php }?>

		<tr>
			<th>
				모바일
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip15')"></span>
			</th>
			<td>
				<table class="table_basic wx900" id="add_info_table">			
					<colgroup>
						<col width="93%" />
						<col width="7%" />									
					</colgroup>

					<thead>
						<tr>
							<th>내용</th>
							<th class="center">					
								<button type="button" class="btn_plus" onclick="add_mobile_sale(0,0,0,0,0);"></button>					
							</th>
						</tr>
					</thead>
					
					<tbody>
						<tr class="add_mess">
							<td colspan="2" class="center">혜택을 추가해주세요.</td>					
						</tr>
					</tbody>

				</table>
			</td>
		</tr>
	</table>

	<ul class="bullet_hyphen resp_message">
		<li>마일리지 및 포인트 설정은 <a class="link_blue_01" href="/admin/setting/reserve">마일리지/포인트/예치금</a>에 따릅니다.</li>				
	</ul>
</div>

<!--------------- 즐겨 찾기 혜택 끝 ------------------------------------------------------------>


<!--------------- 네이버 맵 키 시작 ------------------------------------------------------------>
<div class="contents_dvs hide">
	<div class="item-title ">
		네이버 맵 키
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/multi', '#tip16')"></span>
	</div>

	<table class="table_basic thl ">
		<tr>
			<th>키 발급</th>
			<td>						
				<button class="btn_resp" type="button" onclick="window.open('https://developers.naver.com/register?defaultScope=map');">키 발급</button>						
			</td>
		</tr>

		<tr>
			<th>키 설정</th>
			<td class="clear">
				<table class="table_basic thl v3" width="100%">					
					<tr>
						<th>Client ID</th>								
						<td><input type="text" name="map_client_id" value="<?php echo $TPL_VAR["map_client_id"]?>" size="45" class="line" title="Client ID 값 입력" /></td>
					</tr>

					<tr>
						<th>Client Secret</th>								
						<td><input type="text" name="map_client_secret" value="<?php echo $TPL_VAR["map_client_secret"]?>" size="45" class="line" title="Client Secret 값 입력" /></td>
					</tr>

				</table>
			</td>
		</tr>

		<tr>
			<th>거리 설정</th>
			<td>
				<div class="radio">
					<input type="radio" name="map_client_zoom" value="11" id="map_client_zoom1" <?php if(!$TPL_VAR["map_client_zoom"]||$TPL_VAR["map_client_zoom"]=='11'){?>checked<?php }?>> 
					<label class="mr15" for="map_client_zoom1">기본</label>						
					<input type="radio" name="map_client_zoom" value="9" id="map_client_zoom2" <?php if($TPL_VAR["map_client_zoom"]=='9'){?>checked<?php }?>> 
					<label class="mr15" for="map_client_zoom2">읍,면,동</label>						
					<input type="radio" name="map_client_zoom" value="6" id="map_client_zoom3" <?php if($TPL_VAR["map_client_zoom"]=='6'){?>checked<?php }?>> 
					<label class="mr15" for="map_client_zoom3">시,군,구</label>							
					<input type="radio" name="map_client_zoom" value="3" id="map_client_zoom4" <?php if($TPL_VAR["map_client_zoom"]=='3'){?>checked<?php }?>> 
					<label for="map_client_zoom4">시,도</label>		
				<div>									
			</td>
		</tr>

	</table>
</div>		
<!--------------- 네이버 맵 키 끝 ------------------------------------------------------------>
</form>

<!--대표자 인증 안내 팝업 2016.04.01 pjw-->
<div id="adminAuthInfoPopup" class="hide">
	<ul>
		<li><span class="reference_mark">※</span> 전자상거래법 제 9조 3항 및 제 11조 2항에 의거 ‘호스팅 사업자의 신원확인의무’에 의해 개인정보를 수집할 의무가 있습니다.</li>
		<li><span class="reference_mark">※</span> 퍼스트몰은 공정한 거래와 안전한 온라인 서비스 제공을 위해 대표자의 개인정보를 실명인증을 통해 수집합니다.</li>
		<li><span class="reference_mark">※</span> 대표자 변경 시 재인증해 주십시오.</li>
	</ul>
</div>
<!--/대표자 인증 안내 팝업 2016.04.01 pjw-->

<div id="shopBranchPopup" style="display: none">
	<div align="center">
	<select name="shopBranchSel">
		<option value="">쇼핑몰 분류1을 선택하세요.</option>
<?php if(is_array($TPL_R1=code_load('shopBranch'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<option value='<?php echo $TPL_V1["codecd"]?>'><?php echo $TPL_V1["value"]?></option>
<?php }}?>
	</select>
	<select name="shopBranchSub">
		<option value="">쇼핑몰 분류2를 선택하세요.</option>
	</select>
	</div>

	<div class="footer">
		<input type="button" class="resp_btn active size_XL" value="추가" id="shopBranchButton" />
		<input type="button" class="resp_btn v3 size_XL" value="취소" onclick="closeDialogEvent(this)" />
	</div>
</div>

<div id="naverMapKeyPopup" style="display:none"></div>

<div id="newNaverPopup" class="hide">
	<p>네이버지도를 Client ID방식으로 변경하시겠습니까?</p>
	<p>Client ID로 변경 시 API key 방식 사용이 불가합니다.</p>
	<div class="center mt10">
		<span class="btn medium"><input type="button" value="예" onclick="$('#newNaverPopup').dialog('close');" /></span>
		<span class="btn medium"><input type="button" value="아니오" onclick="newNaverApiUse();" /></span>
	</div>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>