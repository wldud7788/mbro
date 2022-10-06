<?php /* Template_ 2.2.6 2022/05/17 12:29:30 /www/music_brother_firstmall_kr/selleradmin/skin/default/setting/provider_reg.html 000067711 */ 
$TPL_charge_loop_1=empty($TPL_VAR["charge_loop"])||!is_array($TPL_VAR["charge_loop"])?0:count($TPL_VAR["charge_loop"]);
$TPL_brand_1=empty($TPL_VAR["brand"])||!is_array($TPL_VAR["brand"])?0:count($TPL_VAR["brand"]);
$TPL_certify_1=empty($TPL_VAR["certify"])||!is_array($TPL_VAR["certify"])?0:count($TPL_VAR["certify"]);
$TPL_limit_ip_1=empty($TPL_VAR["limit_ip"])||!is_array($TPL_VAR["limit_ip"])?0:count($TPL_VAR["limit_ip"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<!--[if IE]><script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/jquery.jqplot.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="/app/javascript/plugin/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<link class="include" rel="stylesheet" type="text/css" href="/app/javascript/plugin/jqplot/jquery.jqplot.min.css" />
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>
<script type="text/javascript" src="/app/javascript/js/admin-providershipping.js"></script>

<style type="text/css">
	.status-isY { background-color:blue;color:white; }
	.status-isN { background-color:red;color:white; }
</style>
<script type="text/javascript">
	$(document).ready(function() {
<?php if($TPL_VAR["provider_id"]){?>
		$("form[name='settingForm'] select[name='provider_status'] option[value='<?php echo $TPL_VAR["provider_status"]?>']").attr("selected",true);

		$("form[name='settingForm'] select[name='provider_gb'] option[value='<?php echo $TPL_VAR["provider_gb"]?>']").attr("selected",true);

		$("form[name='settingForm'] select[name='deli_group'] option[value='<?php echo $TPL_VAR["deli_group"]?>']").attr("selected",true);

		upload_btn_cont('bank');
		upload_btn_cont('busi');
<?php }?>


			$("#deliZipcodeButton").live("click",function(){
				openDialogZipcode('deli_');
			});

			$("#infoZipcodeButton").live("click",function(){
				openDialogZipcode('info_');
			});

			$("#senderZipcodeButton").live("click",function(){
				openDialogZipcode('sender');
			});
			$("#returnZipcodeButton").live("click",function(){
				openDialogZipcode('return');
			});

			$("input[name='passwd_chg']").bind("click",function(){
				if($(this).attr("checked")){
					$("#r_pass").show();
				}else{
					$("#r_pass").hide();
				}
			});


			$("#calcu_set").bind("click",function(){
				openDialog("수수료 세팅  <span class='desc'></span>", "calcuPopup", {"width":"350","height":"250","show" : "fade","hide" : "fade"});
			});

			$("#etcAdd").bind("click", function(){
				add_brand();
			});

			$("#calcu_select").bind("click",function(){
				if(!$("input[name='brand_charge']").val()){
					alert("기본 수수료는 필수입니다.");
					return;
				}
				var def = "<div>기본 : "+$("input[name='brand_charge']").val()+"%</div>";
				$("input[name='charge']").val($("input[name='brand_charge']").val());

				var brand = document.getElementsByName("brand[]");
				var brand_charge = document.getElementsByName("brand_charge[]");
				for(var i=0;i<brand.length;i++){
					if(brand[i].value && brand_charge[i].value){
						var temp_arr = brand[i].value.split("|");
						def += "<div>"+temp_arr[1]+"("+temp_arr[0]+") : "+brand_charge[i].value+"% <input type='hidden' name='brand_ch[]' value='"+brand[i].value+"'/><input type='hidden' name='brand_per[]' value='"+brand_charge[i].value+"'/></div>";
					}
				}

				$("#calcu_div").html(def);
				closeDialog("calcuPopup");
			});


			$("#set_shipping").live("click",function(){
				var seq = '<?php echo $TPL_VAR["provider_seq"]?>';
				if(seq){
					$.get('provider_shipping?code=delivery&seq='+seq, function(data) {
						$('#shippingModifyPopup').html(data);
					});
				}else{
					var params = "use_yn="+$("input[name='use_yn']").val();
					params += "&summary="+encodeURI($("input[name='summary']").val());
					params += "&company_name="+$("input[name='company_name']").val();
					params += "&company_code="+$("input[name='company_code']").val();
					params += "&delivery_type="+$("input[name='delivery_type']").val();
					params += "&if_free_price="+$("input[name='if_free_price']").val();
					params += "&delivery_price="+$("input[name='delivery_price']").val();
					params += "&post_yn="+$("input[name='post_yn']").val();
					params += "&post_price="+$("input[name='post_price']").val();
					params += "&add_delivery_cost="+$("input[name='add_delivery_cost']").val();
					$.get('provider_shipping?code=delivery&reg=Y&'+params, function(data) {
						$('#shippingModifyPopup').html(data);
					});
				}
				openDialog("택배 (선불 또는 착불) 설정", "shippingModifyPopup", {"width":"1000","height":700});
			});

			$("#set_international").live("click",function(){
				var seq = '<?php echo $TPL_VAR["provider_seq"]?>';
				$.get('shipping_international?code=regist&seq='+seq, function(data) {
					$('#shippingModifyPopup').html(data);
				});
				openDialog("해외 배송 설정", "shippingModifyPopup", {"width":"800","height":600});
			});

			$("#id_chk").click(function(){
				var id = $("input[name='provider_id']").val();
				if(!id){
					alert("입접사ID를 입력해 주세요.");
					$("input[name='provider_id']").focus();
					return;
				}
				$.post("../provider_process/provider_chk", { provider_id : id }, function(response){
					//debug(response);
					//var text = response.return_result;
					//var manager_id = response.manager_id;
					alert(response.return_result);
				},'json');
			});

<?php if($TPL_VAR["charge_loop"]){?>
			var temp_cnt = 0;
<?php if($TPL_charge_loop_1){foreach($TPL_VAR["charge_loop"] as $TPL_V1){?>
			//add_brand();
			$("#sel_"+temp_cnt+" option[value='<?php echo $TPL_V1["category_code"]?>|<?php echo $TPL_V1["title"]?>']").attr("selected",true);
			$("#text_"+temp_cnt).val(<?php echo $TPL_V1["charge"]?>);
			temp_cnt++;
<?php }}?>
<?php }?>

				// ICON
				$("button#bankBtn").live("click",function(){
					openDialog("계좌 사본", "bankPopup", {"width":"350","height":"180","show" : "fade","hide" : "fade"});
				});

				$("button#busiBtn").live("click",function(){
					openDialog("사업자등록증 사본", "busiPopup", {"width":"350","height":"180","show" : "fade","hide" : "fade"});
				});

				$(".registMshopVisualimage").live("click",function(){
					$provider_id	= <?php if($TPL_VAR["provider_id"]){?>'<?php echo $TPL_VAR["provider_id"]?>'<?php }else{?>$("input[name='provider_id']").val()<?php }?>;
						window.open('mshop_popup_image?id='+$provider_id+'&target=main_visual','','width=500,height=250');
					});

					$("#main_visual_name").live('mouseover',	function(){$('#preview_main_visual').show();});
					$("#main_visual_name").live('mouseout',		function(){$('#preview_main_visual').hide();});
<?php if($TPL_VAR["main_visual"]){?>
					$(".deleteVisual").live("click",function(){
						$("input[name='del_main_visual']").val('y');
						$("#btn_deletevidual").hide();
						$("#main_visual_name").html('');
						$("#preview_main_visual").html('');
					});
<?php }?>


						$("select[name='deli_group']").change(function(){
							get_provider_shipping();
						});


						//get_provider_shipping();

						/******** 티켓상품사용 확인코드 관련 **********/

						//SMS보내기
						$(".manager_sms_send").live("click",function(event){
							if( $(this).parent().parent().find("input[name='certify_code[]']").val() == $(this).parent().parent().find("input[name='certify_code[]']").attr('title') ){
								openDialogAlert("확인코드를 입력해주세요.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
								return false;
							}
							if(  $(this).parent().parent().find("input[name='certify_code_chk[]']").val() != 'ok' ){
								openDialogAlert("사용가능한 확인코드인지 [인증]해 주세요!", 350, 150, function(){});
								return false;
							}

							var certify_code = $(this).parent().parent().find("input[name='certify_code[]']").val();
							$.get('../member/sms_pop?certify_code='+certify_code, function(data) {
								$('#sendPopup').html(data);
								openDialog("SMS 발송 <span class='desc'></span>", "sendPopup", {"width":"600","height":"200"});
							});
						});

						// 직원추가
						$("#addManager").bind("click", function(){
							var addHTML	= '';
							addHTML	+= '<tr>'+"\n";
							addHTML	+= '<td><input type="hidden" name="certify_seq[]" value="" size="10" class="line" />'+"\n";
							addHTML	+= '<input type="text" name="manager_name[]" value="" size="45" class="line" title="해당 확인코드를 사용하는 매장 정보를 입력하세요." /></td>'+"\n";
							addHTML	+= '<td><input type="hidden" name="certify_code_chk[]" value="" /><input type="text" name="certify_code[]" value="" size="45" class="line" title="6-16 자리 이하 영문 또는 숫자" /></td>'+"\n";
							addHTML	+= '<td><button type="button" class="certify_btn btn_resp b_gray2">인증</button></td>'+"\n";
							addHTML	+= '<td><button type="button" class="manager_sms_send btn_resp">SMS 전송</button></td>'+"\n";
							addHTML	+= '<td><button type="button" class="delManager btn_minus btnplusminus"></button></td></tr>'+"\n";


							$("#cerfify_manager").append(addHTML);
							setDefaultText();
						});

						// 직원 삭제
						$(".delManager").live('click', function(){
							$(this).parent().parent().remove();
						});

						// 인증
						$(".certify_btn").live('click', function(){
							var parent			= $(this).parent().parent();
							$(parent).find("input[name='certify_code_chk[]']").val('');//초기화
							var certify_seq		= $(parent).find("input[name='certify_seq[]']").val();
							var certify_code	= $(parent).find("input[name='certify_code[]']").val();
							var titles			= $(parent).find("input[name='certify_code[]']").attr('title');
							certify_code		= certify_code.replace(titles, '');

							if	(!certify_code){
								openDialogAlert("확인코드를 입력해주세요.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
								return;
							}
							if	(certify_code.length < 6 || certify_code.length > 16){
								openDialogAlert("확인코드는 6자리 이상 16자리 이하로 입력해주세요.", 400, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
								return;
							}
							if	(certify_code.search(/[^0-9a-zA-Z]/) != -1){
								openDialogAlert("확인코드는 영문 또는 숫자로 입력해주세요.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
								return;
							}
							var dup = false;
							var $inp = $("input[name='certify_code[]']");
							var certify_code_idx = $(".certify_btn").index(this);
							$inp.each(function() {
								var selidx = $("input[name='certify_code[]']").index(this);
								var codenew = $(this).val();
								var codetitle = $(this).attr('title');
								codenew = codenew.replace(codetitle, '');
								if( certify_code == codenew && certify_code_idx != selidx ) {
									dup = true;
									return false;
								}
							});

							if(dup){
								openDialogAlert("중복된 확인코드입니다.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
								return false;
							}

							$.ajax({
								type: "get",
								url: "chk_certify_code",
								data: "certify_code="+certify_code+"&certify_seq="+certify_seq,
								success: function(result){
									if	(result == 'ok')
										openDialogAlert("사용 가능한 확인코드입니다.", 300, 150, function(){$(parent).find("input[name='certify_code_chk[]']").val('ok')});
									else if	(result == 'duple')
										openDialogAlert("중복된 확인코드입니다.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
									else if	(result == 'error_1')
										openDialogAlert("확인코드를 입력해주세요.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
									else if	(result == 'error_2')
										openDialogAlert("확인코드는 6자리 이상 16자리 이하로 입력해주세요.", 400, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
									else if	(result == 'error_3')
										openDialogAlert("확인코드는 영문 또는 숫자로 입력해주세요.", 300, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
									else
										openDialogAlert("확인코드 인증에 실패하였습니다.", 400, 150, function(){$(parent).find("input[name='certify_code[]']").focus()});
								}
							});
						});
						/******** /티켓상품사용 확인코드 관련 **********/

						$("input[name='re_provider_passwd']").keyup(function(){
							if(!check_password()){
								$("#msg_passwd").html('신규 비밀번호를 확인해 주세요!');
							}else{
								$("#msg_passwd").html('일치!');
							}
						});

						$("input[name='ip_chk']").click(function(){
							init_func();
						});

						/* 아이피 추가 */
						$("#ipViewTable button#ipAdd").bind("click",function(){
							var html="";
							html = '<tr>';
							html += '	<td>';
							html += '	<input type="text" name="limit_ip1[]" value="" class="line limit_ip" size=4 maxlength=3 />.';
							html += '	<input type="text" name="limit_ip2[]" value="" class="line limit_ip" size=4 maxlength=3 />.';
							html += '	<input type="text" name="limit_ip3[]" value="" class="line limit_ip" size=4 maxlength=3 />.';
							html += '	<input type="text" name="limit_ip4[]" value="" class="line limit_ip" size=4 maxlength=3 />';
							html += '	</td><td><button type="button" id="ipDel" onclick="del_ip(this)" class="btn_minus"></button>';
							html += '	</td>';
							html += '</tr>';

							$("#ipViewTable").append(html);
							init_func();
						});

						init_func();

						//계좌 사본
						$('#bankBtn').createAjaxFileUpload(uploadConfig, uploadCallback);
<?php if($TPL_VAR["info_file"]){?>imgUploadEvent("#bankBtn", "", "/data/provider/", "<?php echo $TPL_VAR["calcu_file"]?>")<?php }?>

						//사업자 등록증 사본
						$('#busiBtn').createAjaxFileUpload(uploadConfig, uploadCallback);
<?php if($TPL_VAR["info_file"]){?>imgUploadEvent("#busiBtn", "", "/data/provider/", "<?php echo $TPL_VAR["info_file"]?>")<?php }?>

							//미니샵 소개 이미지
							$('#mainVisualBtn').createAjaxFileUpload(uploadConfig, uploadCallback);
<?php if($TPL_VAR["main_visual"]){?>imgUploadEvent("#mainVisualBtn", "", "", "<?php echo $TPL_VAR["main_visual"]?>")<?php }?>

								// 주소복사
								$('#url_copy').click(function()
								{
									clipboard_copy("<?php echo get_connet_protocol()?><?php echo $_SERVER["HTTP_HOST"]?><?php echo $TPL_VAR["mshop_url"]?>");
									alert("주소가 복사되었습니다.\nHTML소스의 원하시는 위치에 Ctrl+V로 붙여넣기 하세요.");
								});

								// 이벤트 상세페이지 팝업
								$('.popupOpenBtn').on('click', function()
								{
									var name = $(this).data('name');
									var title;
									var option;

									switch (name) {

										case "detailPageSetting" :
											title = "상세 페이지 설정";
											option = {"width":"1000","height":"320","show" : "fade","hide" : "fade"};
											break;

										case "goodInfoStyle" :
											title = "상품 디스플레이";
											option = {"width":"1000","height":"730","show" : "fade","hide" : "fade"};
											break;
									}

									openDialog(title, name,  option);
								});

								$(".confirmPopupInfoBtn").on('click', function()
								{
									var id = $(this).parent().parent().attr("id");
									addhiddenText(id, id+"Container")
									closeDialog(id);
								});

<?php if($TPL_VAR["commission_type"]&&$TPL_VAR["charge"]){?> setCalcuSetInfo("<?php echo $TPL_VAR["commission_type"]?>", "<?php echo $TPL_VAR["charge"]?>")<?php }?>;

								});

								function setCalcuSetInfo(type, charge){
									var chargeType;
									var chargeUint = "%"
									switch(type){
										case	'SACO':
											chargeType = "수수료, "
											break;
										case	'SUCO':
											chargeType = "공급가, 정가 "
											break;
										case	'SUPR':
											chargeType = "공급가, "
											chargeUint = "원"
											break;
									}

									$("#calcuSetInfo").html(chargeType+charge+chargeUint);
								}

								function del_ip(obj){
									var bobj = $(obj);
									if($("#ipViewTable tr").length <= 2) return
									bobj.closest("tr").remove();
								}

								function init_func(){

									if($("input[name='ip_chk']").attr("checked")){
										$(".ip_view").show();
										$(".limit_ip").attr("disabled",false);
									}else{
										$(".limit_ip").val('');
										$(".ip_view").hide();
										$(".limit_ip").attr("disabled",true);
									}
								}

								var select_cnt = 0;
								function add_brand(){
									var table = document.getElementById("brand_table");
									var row = table.insertRow();
									row.onmouseover=function(){table.clickedRowIndex=this.rowIndex;};
									var cell1 = row.insertCell();

									var limit = '<?php echo $TPL_VAR["brand_cnt"]?>';

									var obj = document.getElementsByName("brand_charge[]");
									if(obj.length >= parseInt(limit)){
										alert(limit+"개 이상은 생성하실 수 없습니다.");
										return;
									}

									var html = "<span class=\"btn-minus\"><button type=\"button\" onclick=\"del_brand();\"></button></span>";
									html += "<select name=\"brand[]\" id='sel_"+select_cnt+"' onchange='option_check(this);'>";
									html += "<option value=''>= 선택해주세요 =</option>";
<?php if($TPL_brand_1){foreach($TPL_VAR["brand"] as $TPL_V1){?>
									html += "<option value=\"<?php echo $TPL_V1["category_code"]?>|<?php echo $TPL_V1["title"]?>\"><?php echo $TPL_V1["title"]?></option>";
<?php }}?>
									html += "</select>";
									html += "<input type=\"text\" id='text_"+select_cnt+"' name=\"brand_charge[]\" size=\"5\" class=\"line\"/>%";

									cell1.innerHTML = html;
									select_cnt++;
								}


								function del_brand(){
									var bum_table = document.getElementById("brand_table");
									var row_length = bum_table.rows.length;
									bum_table.deleteRow(bum_table.clickedRowIndex);
								}

								function option_check(sel){
									var obj = document.getElementsByName("brand[]");
									var cnt = 0;
									for(var i=0;i<obj.length;i++){
										if(sel.value==obj[i].value){
											cnt++;
										}
									}
									if(cnt>1){
										alert("브랜드가 중복되었습니다.");
										sel.value ='';
									}
								}

								function calcuFileUpload(){
									var frm = $('#iconRegist');
									frm.attr("action","../provider_process/bankUpload?type=bank");
									frm.submit();
								}

								function busiFileUpload(){
									var frm = $('#iconRegist2');
									frm.attr("action","../provider_process/bankUpload?type=busi");
									frm.submit();
								}

								function bankHidden(str){
									$("input[name='calcu_file_hidden']").val(str);
									closeDialog("bankPopup");
									upload_btn_cont('bank');
								}

								function busiHidden(str){
									$("input[name='info_file_hidden']").val(str);
									closeDialog("busiPopup");
									upload_btn_cont('busi');
								}

								function upload_btn_cont(str){
									if(str=='bank'){
										if($("input[name='calcu_file_hidden']").val()){
											$("#b_cont_btn").show();
											$("#b_reg_btn").hide();
										}else{
											$("#b_cont_btn").hide();
											$("#b_reg_btn").show();
										}
									}else{
										if($("input[name='info_file_hidden']").val()){
											$("#b_cont_btn2").show();
											$("#b_reg_btn2").hide();
										}else{
											$("#b_cont_btn2").hide();
											$("#b_reg_btn2").show();
										}
									}
								}

								function deleteFile(str){
									if(!confirm("정말 삭제하시겠습니까?")) return;
									if(str=='bank'){
										$("input[name='calcu_file_hidden']").val('');
										upload_btn_cont('bank');
									}else{
										$("input[name='info_file_hidden']").val('');
										upload_btn_cont('busi');
									}
									alert("삭제되었습니다.");
								}

								function viewFile(str){
									var filenm = "";
									if(str=='bank'){
										filenm = $("input[name='calcu_file_hidden']").val();
									}else{
										filenm = $("input[name='info_file_hidden']").val();
									}
									if(!filenm) return;
									window.open("/data/provider/"+filenm,"","");
								}

								function check_password()
								{
									var pass_text = $("input[name='provider_passwd']").val();
									var re_pass_text = $("input[name='re_provider_passwd']").val();
									if ( pass_text !=  re_pass_text) return false;
									return true;
								}

// 해당 input박스의 입력된 글자수를 계산
								function calculate_input_len(obj){
									var mobj	= $(obj).closest('td').find('span.view-len');
									var len	= $(obj).val().length;
									var max	= $(obj).attr('maxlength');
									mobj.removeClass('red');
									if(len < max){
										msg	= '<b>'+comma( len ) + '</b>/' + comma( max );
									}else{
										$(obj).val( $(obj).val().substring(0,max) );
										msg	= '<b>'+comma( max ) + '</b>/' + comma( max );
									}
									mobj.html( msg );
									if( len >= max ) mobj.find("b").addClass('red');
								}

								function provider_submit()
								{
									// 입력 옵션일 경우 form submit 이벤트를 에디터 이벤트로 호출
<?php if($TPL_VAR["provider_seq"]&&$TPL_VAR["operation_type"]=='light'){?>
									submitEditorForm($("form[name='settingForm']")[0]);
<?php }else{?>
									$("form[name='settingForm']")[0].submit();
<?php }?>
									}

// IP 필수 입력 확인
									function check_vaild_ip(){

										var ip1	= ip2 = ip3 = '';
										var chkStatus		= true;
										var errMsg			= '아이피 대역이 잘못되었습니다.<br />아이피 대역은 0~255 사이의 숫자만 입력해주세요.<br />아이피 3번째 자리까지는 필수 입력하셔야 합니다.';
										if	($("input[name='ip_chk']").attr('checked')){
											$("input[name='limit_ip1[]']").each(function(idx){
												ip1		= $(this).val();
												ip2		= $("input[name='limit_ip2[]']").eq(idx).val();
												ip3		= $("input[name='limit_ip3[]']").eq(idx).val();
												if	( !( ( ip1 > 0 && ip1 < 255 ) && ( ip2 > 0 && ip2 < 255 ) && ( ip3 > 0 && ip3 < 255 ) ) ){
													chkStatus	= false;
												}
											});
											if	(!chkStatus){
												openDialogAlert(errMsg, 400,180, function(){});
												return false;
											}
										}
										if	($("input[name='admin_ip_chk']").attr('checked')){
											$("input[name='admin_limit_ip1[]']").each(function(idx){
												ip1		= $(this).val();
												ip2		= $("input[name='admin_limit_ip2[]']").eq(idx).val();
												ip3		= $("input[name='admin_limit_ip3[]']").eq(idx).val();
												if	( !( ( ip1 > 0 && ip1 < 255 ) && ( ip2 > 0 && ip2 < 255 ) && ( ip3 > 0 && ip3 < 255 ) ) ){
													chkStatus	= false;
												}
											});
											if	(!chkStatus){
												openDialogAlert(errMsg, 400, 180, function(){});
												return false;
											}
										}

										return true;
									}

// 자신의 아이피를 허용하지 않았을 경우 경고 메시지처리
									function check_self_ip(){
										var self_ip = '<?php echo $_SERVER["REMOTE_ADDR"]?>';
										var apply_exist = false;
										var self_apply = false;
										var apply_exist_login = false;
										var self_apply_login = false;
										var ip = '';
										var patt = '';
										var result = '';
										var ips = '';
										var ips_login = '';
										var ip_num = 0;
										var ip_num_login = 0;

										if	(!check_vaild_ip())	return false;
										$("input[name='limit_ip1[]']").each(function(idx){
											if( $(this).val() ){
												apply_exist = true;
												ip = $(this).val();
												if( $("input[name='limit_ip2[]']").eq(idx).val() ){
													ip += '.'+$("input[name='limit_ip2[]']").eq(idx).val();
												}
												if( $("input[name='limit_ip3[]']").eq(idx).val() ){
													ip += '.'+$("input[name='limit_ip3[]']").eq(idx).val();
												}
												if( $("input[name='limit_ip4[]']").eq(idx).val() ){
													ip += '.'+$("input[name='limit_ip4[]']").eq(idx).val();
												}
												eval('patt = /^'+ip+'/i;');
												result =  patt.test(self_ip);
												if( result ){
													self_apply = true;
												}
												if( $("input[name='limit_ip4[]']").eq(idx).val() == '' ){
													ips += ip+'.1 ~ '+ip+'.255<br>';
												}else{
													ips += ip+'<br>';
												}
												ip_num++;
											}
										});
										$("input[name='admin_limit_ip1[]']").each(function(idx){
											if( $(this).val() ){
												apply_exist_login = true;
												ip = $(this).val();
												if( $("input[name='admin_limit_ip2[]']").eq(idx).val() ){
													ip += '.'+$("input[name='admin_limit_ip2[]']").eq(idx).val();
												}
												if( $("input[name='admin_limit_ip3[]']").eq(idx).val() ){
													ip += '.'+$("input[name='admin_limit_ip3[]']").eq(idx).val();
												}
												if( $("input[name='admin_limit_ip4[]']").eq(idx).val() ){
													ip += '.'+$("input[name='admin_limit_ip4[]']").eq(idx).val();
												}
												eval('patt = /^'+ip+'/i;');
												result =  patt.test(self_ip);
												if( result ){
													self_apply_login = true;
												}
												if( $("input[name='admin_limit_ip4[]']").eq(idx).val() == '' ){
													ips_login += ip+'.1 ~ '+ip+'.255<br>';
												}else{
													ips_login += ip+'<br>';
												}
												ip_num_login++;
											}
										});

										var height = 0;
										if( (!self_apply && apply_exist) || ( !self_apply_login && apply_exist_login ) ){
											var msg = '<div class="left">';
											if( !self_apply && apply_exist ){
												msg += '<b>[관리환경 관리페이지]</b><br>아래는 입력하신 접속허용 IP입니다.<br>'+ips+'<br>현재 접속 IP는 입력하신 접속허용 IP에는 포함되어 있지 않습니다.';
												msg += '<br>계속 진행하시면 현재 접속 IP에서는';
												msg += " 관리페이지";
												msg += '를 접속할 수 없게 됩니다.<br>';
												height += 6 + ip_num;
											}
											if( !self_apply_login && apply_exist_login ){
												if( !self_apply && apply_exist ){
													msg += '<br>';
												}
												msg += '<b>[관리환경 로그인페이지]</b><br>아래는 입력하신 접속허용 IP입니다.<br>'+ips_login+'<br>현재 접속 IP는 입력하신 접속허용 IP에는 포함되어 있지 않습니다.';
												msg += '<br>계속 진행하시면 현재 접속 IP에서는';
												msg += " 로그인페이지";
												msg += '를 접속할 수 없게 됩니다.';
												height += 7 + ip_num_login;
											}
											msg += '</div>';

											height = height * 20 + 100;
											openDialogConfirm(msg,550,height,function(){
												settingForm.submit();
												return true;
											},function(){
												return false;
											});
										}else{
											settingForm.submit();
										}
									}


</script>
<style type="text/css">
	#main_visual_name		{cursor:pointer;}
	#preview_main_visual	{position:absolute;border:1px solid #e4e4e4;
		z-index:1000;background-color:#ffffff;display:none;}
	table.change_password tr th {font-weight:normal;padding-right:10px;text-align:right;}
</style>
<!-- <?php if($TPL_VAR["provider_seq"]){?> -->
<form name="settingForm" method="post" enctype="multipart/form-data" action="../provider_process/provider_modify" target="actionFrame">
	<input type="hidden" name="provider_seq" value="<?php echo $TPL_VAR["provider_seq"]?>"/>
	<!-- <?php }else{?> -->
	<form name="settingForm" method="post" enctype="multipart/form-data" action="../provider_process/provider_reg" target="actionFrame">
		<!-- <?php }?> -->

		<!-- 페이지 타이틀 바 : 시작 -->
		<div id="page-title-bar-area">
			<div id="page-title-bar">

				<!-- 타이틀 -->
				<div class="page-title">
<?php if($TPL_VAR["provider_id"]){?>
					<h2><?php if($TPL_VAR["provider_gb"]=='provider'){?>입점(업체)<?php }else{?>입점(본사)<?php }?> – <?php echo $TPL_VAR["provider_id"]?></h2>
					<select name="provider_status" class="hide">
						<option value="Y">정상 (판매활동가능)</option>
						<option value="N">종료 (판매활동불가)</option>
					</select>
<?php }else{?>
					<h2>입점사 등록</h2>
					<input type="hidden" name="provider_status" value="N">
					<span>최초 등록 시 "종료" 상태</span>
<?php }?>
				</div>

				<!-- 좌측 버튼 -->
				<div class="page-buttons-left">
					<button type="button" onclick="document.location.href='manager';" class="resp_btn v3 size_L">리스트 바로가기</button>
				</div>

				<!-- 우측 버튼 -->
				<div class="page-buttons-right">
					<button type="button" class="resp_btn active2 size_L" onclick="if( check_password ) provider_submit();">저장</button>
				</div>
			</div>
		</div>
		<!-- 페이지 타이틀 바 : 끝 -->

		<!-- 서브 레이아웃 영역 : 시작 -->
		<div class="contents_container ">
			<!-- 서브메뉴 바디 : 시작-->
			<div class="contents_dvs">
				<div class="item-title">기본 정보</div>
				<table class="table_basic thl">
					<tr>
						<th>입점사(업체)명</th>
						<td>
							<div class="resp_limit_text limitTextEvent">
								<input type="text" name="provider_name" value="<?php echo $TPL_VAR["provider_name"]?>"  size="40" maxlength="20" />
							</div>
						</td>
					</tr>

					<tr>
						<th>아이디</th>
						<td>
<?php if($TPL_VAR["provider_id"]){?>
							<?php echo $TPL_VAR["provider_id"]?>

<?php }else{?>
							<input type="text" name="provider_id" value="<?php echo $TPL_VAR["provider_id"]?>" class="line" />
							<span class="btn small gray"><button type="button" id="id_chk">중복확인</button></span>
<?php }?>
						</td>
					</tr>
<?php if($TPL_VAR["provider_id"]){?>
					<tr>
						<th>
							비밀번호
							<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/manager', '#tip6', 'sizeM')"></span>
						</th>
						<td>
							<label class="resp_checkbox"><input type="checkbox" name="passwd_chg" value="Y" /> 변경</label>
						</td>
					</tr>
<?php }?>
					<tr id="r_pass" <?php if($TPL_VAR["provider_id"]){?>style="display:none;"<?php }else{?>style="display:block;"<?php }?>>
					<th>
						비밀번호 설정
<?php if(!$TPL_VAR["provider_id"]){?><span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/manager', '#tip6', 'sizeM')"></span><?php }?>
					</th>
					<td>
<?php if($TPL_VAR["provider_id"]){?>
						<dl class="change_password dl_list_01 w120">
							<dt>현재 비밀번호</dt>
							<dd><input type="password" name="current_password" value="" class="line" /></dd>
						</dl>
<?php }?>

						<dl class="change_password dl_list_01 w120">
							<dt>비밀번호</dt>
							<dd><input type="password" name="provider_passwd" class="line" /></dd>
						</dl>

						<dl class="change_password dl_list_01 w120">
							<dt>비밀번호 확인</dt>
							<dd><input type="password" name="re_provider_passwd" class="line" /></dd>
						</dl>

						<ul class="bullet_hyphen fx11">
							<li>영문 대소문자 또는 숫자, 특수문자 중 2가지 이상 조합으로 10-20자 미만</li>
							<li>사용 가능 특수문자 # $ % & ( ) * + - / : < = > ? @ [ ＼ ] ^ _ { | } ~</li>
						</ul>
					</td>
					</tr>
					<tr>
						<th>판매등급</th>
						<td>
<?php if($TPL_VAR["pgroup_name"]){?>
<?php if($TPL_VAR["pgroup_icon"]){?><img src="../../data/icon/provider/<?php echo $TPL_VAR["pgroup_icon"]?>" align="absmiddle"><?php }?> <?php echo $TPL_VAR["pgroup_name"]?>

<?php }else{?><?php }?>
<?php if($TPL_VAR["pgroup_date"]&&$TPL_VAR["pgroup_date"]!="0000-00-00 00:00:00"){?> <span class="gray">(변경일 : <?php echo $TPL_VAR["pgroup_date"]?>)</span> <?php }?>
						</td>
					</tr>
					<tr>
						<th>구분</th>
						<td>
<?php if($TPL_VAR["provider_gb"]=='provider'){?>입점<?php }else{?>입점(본사)<?php }?>
							<select name="provider_gb" class="hide">
								<option value="">= 선택하세요 =</option>
								<option value="provider">입점(업체)</option>
								<option value="company">입점(본사)</option>
							</select>
						</td>
					</tr>
					<tr>
						<th>최초 입점일</th>
						<td><?php echo $TPL_VAR["regdate"]?></td>
					</tr>
				</table>
			</div>

			<!-- <?php if($TPL_VAR["provider_seq"]){?> -->
			<div class="contents_dvs">
				<div class="item-title">미니샵</div>
				<table class="table_basic thl">
					<tr>
						<th>주소</th>
						<td>

<?php if(!$TPL_VAR["minishop_service_limit"]){?>
							<button type="button" onclick="window.open('<?php echo $TPL_VAR["mshop_url"]?>');" class="resp_btn">보기</button>
							<button type="button" id="url_copy" class="resp_btn v2">URL 복사</button>
<?php }?>
						</td>
					</tr>

					<tr>
						<th>미니샵 단골</th>
						<td>
							<a href="../member/catalog?provider_seq=<?php echo $TPL_VAR["provider_seq"]?>&provider_name=<?php echo $TPL_VAR["provider_name"]?>" target="_blank" class="resp_btn_txt v2"><?php echo number_format($TPL_VAR["mshop_cnt"])?>명</a>
						</td>
					</tr>

					<tr>
						<th>미니샵 소개</th>
						<td>
<?php if($TPL_VAR["operation_type"]=='light'){?>
							<div class="resp_limit_text limitTextEvent">
								<input type="text" name="minishop_introdution" value="<?php echo $TPL_VAR["minishop_introdution"]?>" size="70" maxlength="30"/>
							</div>
<?php }else{?>
							<div class="webftpFormItem">
								<label class="resp_btn v2"><input type="file" id="mainVisualBtn" accept="image/*">파일 선택</label>
								<input type="hidden" class="webftpFormItemInput" name="main_visual" value="<?php echo $TPL_VAR["main_visual"]?>" />
								<div class="preview_image"></div>
							</div>
<?php }?>
						</td>
					</tr>
<?php if($TPL_VAR["operation_type"]=='light'){?>
					<tr>
						<th>추천상품</th>
						<td class="clear">
							<ul class="ul_list_02">
								<li>
									<select name="auto_criteria_type" class="auto_criteria_type">
										<option value="AUTO" <?php if($TPL_VAR["auto_criteria_type"]=='AUTO'){?>selected<?php }?>>자동</option>
										<option value="MANUAL" <?php if($TPL_VAR["auto_criteria_type"]=='MANUAL'){?>selected<?php }?> >직접 선정</option>
										<option value="TEXT" <?php if($TPL_VAR["auto_criteria_type"]=='TEXT'){?>selected<?php }?> >입력</option>
									</select>
								</li>
								<li>
<?php $this->print_("condition",$TPL_SCP,1);?>

								</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th>상세 페이지 설정</th>
						<td id="detailPageSettingContainer">
							<button type="button" class="popupOpenBtn resp_btn v2" data-name="detailPageSetting">설정</button>
						</td>
					</tr>
					<tr>
						<th>상품 디스플레이</th>
						<td id="goodInfoStyleContainer">
							<button type="button" class="popupOpenBtn resp_btn v2" data-name="goodInfoStyle">설정</button>
						</td>
					</tr>
<?php }?>
				</table>
			</div>
			<!-- <?php }?> -->

			<div class="contents_dvs">
				<div class="item-title">정산</div>
				<table class="table_basic thl">
					<tr>
						<th>정산 기준 <span class="required_chk"></span></th>
						<td colspan="3">
							<input type="hidden" name="charge" value="<?php echo $TPL_VAR["charge"]?>"/>
							<input type="hidden" name="commission_type" value="<?php echo $TPL_VAR["commission_type"]?>"/>
							<span id="calcuSetInfo"></span>
						</td>
					</tr>

					<tr>
						<th>배송비 수수료 <span class="required_chk"></span></th>
						<td>
							<input type="hidden" name="shipping_charge" value="<?php echo $TPL_VAR["shipping_charge"]?>" size="5" />
							<?php echo $TPL_VAR["shipping_charge"]?>%
						</td>
						<th>반품 배송비 수수료 <span class="required_chk"></span></th>
						<td>
							<input type="hidden" name="return_shipping_charge" value="<?php echo $TPL_VAR["return_shipping_charge"]?>" size="5" />
							<?php echo $TPL_VAR["return_shipping_charge"]?>%
						</td>
					</tr>

					<tr>
						<th>정산 주기</th>
						<td>당월: 월 <?php echo $TPL_VAR["accountAllPeriodConfirm"]["nowPeriod"]?>회, 익월: 월 <?php echo $TPL_VAR["accountAllPeriodConfirm"]["nextPeriod"]?>회</td>
						<th>정산 마감</th>
						<td><?php echo $TPL_VAR["accountAllPeriodConfirm"]["nowConfirm"]?>, <?php echo $TPL_VAR["accountAllPeriodConfirm"]["nextConfirm"]?></td>
					</tr>

					<tr>
						<th>입금 계좌 정보</th>
						<td colspan="3" class="clear">
							<table class="table_basic v3 thl">
								<tr>
									<th>은행 / 예금주</th>
									<td>
										<input type="text" name="calcu_bank" value="<?php echo $TPL_VAR["calcu_bank"]?>" size="12"/>
										/
										<input type="text" name="calcu_name" value="<?php echo $TPL_VAR["calcu_name"]?>" size="10"/>
									</td>
								</tr>
								<tr>
									<th>계좌번호</th>
									<td><input type="text" name="calcu_num" value="<?php echo $TPL_VAR["calcu_num"]?>" /></td>
								</tr>
								<tr>
									<th>계좌사본</th>
									<td>
										<div class="webftpFormItem">
											<label class="resp_btn v2"><input type="file" id="bankBtn" class="uploadify">파일 선택</label>
											<input type="hidden" class="webftpFormItemInput" name="calcu_file_hidden" value="<?php echo $TPL_VAR["calcu_file"]?>"/>
											<div class="preview_image"></div>
										</div>

										<div class="resp_message v2">- 파일 형식 jpg, jpeg, gif, png</div>
									</td>
								</tr>
							</table>
						</td>
						</td>
					</tr>
				</table>
				<div class="resp_message">
					- 정산 주기 및 정산 마감은 정산 > <a href="../accountall/accountall_setting" target="_blank" class="resp_btn_txt">정산 마감일 설정</a>에서 변경할 수 있습니다.
				</div>
			</div>

			<div class="contents_dvs">
				<div class="item-title">판매 처리</div>
				<table class="table_basic thl">
					<tr>
						<th>
							티켓 사용 확인 코드
							<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/manager', '#tip5', 'sizeR')"></span>
						</th>
						<td>
							<table id="cerfify_manager" class="table_basic tdc wauto ">
								<colgroup>
									<col width="30%" />
									<col width="30%" />
									<col width="13%" />
									<col width="16%" />
									<col width="11%" />
								</colgroup>
								<thead>
								<th>매장 정보</th>
								<th>확인 코드</th>
								<th>인증</th>
								<th>SMS 전송 알림</th>
								<th><button type="button" id="addManager" class="btn_plus btnplusminus"></button></th>
								</thead>
<?php if($TPL_VAR["certify"]){?>
<?php if($TPL_certify_1){foreach($TPL_VAR["certify"] as $TPL_V1){?>
								<tr>
									<td>
										<input type="hidden" name="certify_seq[]" value="<?php echo $TPL_V1["seq"]?>" size="10" class="line" />
										<input type="text" name="manager_name[]" value="<?php echo $TPL_V1["manager_name"]?>" size="45" class="line" title="해당 확인코드를 사용하는 매장 정보를 입력하세요." />
									</td>
									<td>
										<input type="hidden" name="certify_code_chk[]" value="ok" />
										<input type="text" name="certify_code[]" value="<?php echo $TPL_V1["certify_code"]?>" size="45" class="line" title="6-16 자리 이하 영문 또는 숫자" />
									</td>
									<td><button type="button" class="resp_btn v2">인증</button></td>
									<td><button type="button" class="manager_sms_send resp_btn">SMS 전송</button></td>
									<td><button type="button" class="delManager btn_minus btnplusminus"></button></td>
								</tr>
<?php }}?>
<?php }else{?>
								<tr>
									<td>
										<input type="hidden" name="certify_seq[]" value="" size="10" class="line" />
										<input type="text" name="manager_name[]" value="" size="45" class="line" title="해당 확인코드를 사용하는 매장 정보를 입력하세요." />
									</td>
									<td>
										<input type="hidden" name="certify_code_chk[]" value="" />
										<input type="text" name="certify_code[]" value="" size="45"  class="line" title="6-16 자리 이하 영문 또는 숫자" />
									</td>
									<td><button type="button" class="certify_btn resp_btn v2">인증</button></td>
									<td><button type="button" class="manager_sms_send resp_btn">SMS 전송</button></td>
									<td><button type="button" class="delManager btn_minus btnplusminus"></button></td>
								</tr>
<?php }?>
							</table>
						</td>
					</tr>
				</table>
			</div>

			<div class="contents_dvs">
				<div class="item-title">로그인 보안</div>
				<table class="table_basic thl">
					<tr>
						<th>비밀번호 변경</th>
						<td>비밀번호 변경 후 90일 경과 시 비밀번호 변경 자동 안내	</td>
					</tr>

					<tr>
						<th>자동 로그아웃</th>
						<td>
<?php if($TPL_VAR["autoLogout"]["auto_logout"]=="Y"){?>
<?php if($TPL_VAR["autoLogout"]["until_time"]=="0.01"){?>36초<?php }else{?><?php echo $TPL_VAR["autoLogout"]["until_time"]?>시간<?php }?> 동안 액션이 없으면 자동 로그아웃
<?php }else{?>
							미사용
<?php }?>

							<div class="gray">- 관리자 리스트에 있는 자동로그아웃 설정 버튼을 클릭하여 설정 가능</div>
						</td>
					</tr>

					<tr>
						<th>
							접속 허용 IP
							<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/manager', '#tip7')"></span>
						</th>
						<td>
<?php if($TPL_VAR["providerInfo"]["manager_yn"]=='Y'){?>
							<div class="resp_radio">
								<label><input type="radio" name="ip_chk" value="Y" <?php if($TPL_VAR["limit_use"]=="Y"){?>checked<?php }?>> 사용함</label>
								<label><input type="radio"  name="ip_chk" value="N" <?php if($TPL_VAR["limit_ip"]==""||$TPL_VAR["limit_use"]=="N"){?>checked<?php }?>> 사용 안 함</label>
							</div>
<?php }else{?>
<?php if($TPL_VAR["limit_ip"]){?>
							해당 관리자는 아래의 IP에서만 관리페이지 접속 허용
<?php }else{?>
							관리환경 관리페이지 접속 제한 없음
<?php }?>
<?php }?>
						</td>
					</tr>

					<tr class="ip_view">
						<th>접속 IP 설정</th>
						<td>
<?php if($TPL_VAR["providerInfo"]["manager_yn"]=='Y'){?>
							<table id="ipViewTable" class="table_basic wauto">
								<tr>
									<th>IP</th>
									<th><button type="button" id="ipAdd" class="btn_plus"></button></th>
								</tr>
<?php if(!$TPL_VAR["limit_ip"]){?>
								<tr>
									<td>
										<input type="text" name="limit_ip1[]" value="" class="line limit_ip" size=4 maxlength=3/>.
										<input type="text" name="limit_ip2[]" value="" class="line limit_ip" size=4 maxlength=3/>.
										<input type="text" name="limit_ip3[]" value="" class="line limit_ip" size=4 maxlength=3/>.
										<input type="text" name="limit_ip4[]" value="" class="line limit_ip" size=4 maxlength=3/>
									</td>

									<td>
										<button type="button" id="ipDel"  onclick="del_ip(this)" class="btn_minus"></button>
									</td>
								</tr>
<?php }else{?>
<?php if($TPL_limit_ip_1){foreach($TPL_VAR["limit_ip"] as $TPL_V1){?>
								<tr>
									<td>
										<input type="text" name="limit_ip1[]" value="<?php echo $TPL_V1[ 0]?>" class="line limit_ip" size=4 maxlength=3/>.
										<input type="text" name="limit_ip2[]" value="<?php echo $TPL_V1[ 1]?>" class="line limit_ip" size=4 maxlength=3/>.
										<input type="text" name="limit_ip3[]" value="<?php echo $TPL_V1[ 2]?>" class="line limit_ip" size=4 maxlength=3/>.
										<input type="text" name="limit_ip4[]" value="<?php echo $TPL_V1[ 3]?>" class="line limit_ip" size=4 maxlength=3/>
									</td>

									<td>
										<button type="button" id="ipDel"  onclick="del_ip(this)" class="btn_minus"></button>
									</td>
								</tr>
<?php }}?>
<?php }?>
							</table>
<?php }else{?>

<?php if($TPL_limit_ip_1){foreach($TPL_VAR["limit_ip"] as $TPL_V1){?>
							<?php echo $TPL_V1[ 0]?>.<?php echo $TPL_V1[ 1]?>.<?php echo $TPL_V1[ 2]?><?php if($TPL_V1[ 3]){?>.<?php echo $TPL_V1[ 3]?><?php }else{?>.1 ~ <?php echo $TPL_V1[ 0]?>.<?php echo $TPL_V1[ 1]?>.<?php echo $TPL_V1[ 2]?>.255<?php }?>
							<br>
<?php }}?>

<?php }?>
						</td>
					</tr>

					<tr>
						<th>
							접속 허용 휴대폰
							<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/manager', '#tip8')"></span>
						</th>
						<td>
<?php if(!$TPL_VAR["auth_hp"]){?>
							관리환경 관리페이지 접속 제한 없음
<?php }else{?>
							해당 관리자는 아래의 휴대폰번호로 인증 시 관리페이지 접속 허용<br>
							<?php echo $TPL_VAR["auth_hp"]?>

<?php }?>
							<div class="gray">- 1일 1회 1기기에 한해 인증 필요, 문자 잔여건수가 없을 경우 미동작</div>
						</td>
					</tr>
				</table>
			</div>

			<div class="contents_dvs">
				<div class="item-title">
					메뉴 상단 건수 표기
					<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/manager', '#tip2')"></span>
				</div>

				<table class="table_basic thl">
					<tr>
						<th>주문
							<span class="tooltip_btn" onClick="showTooltip(this, '/selleradmin/tooltip/manager', '#tip3', 'sizeR')"></span>
						</th>
						<td>
							최근
							<select name="noti_count_priod_order">
								<option value="1주일" <?php if($TPL_VAR["noti_acount_priod"]["order"]=='1주일'){?>selected<?php }?>>1주일</option>
								<option value="2주일" <?php if($TPL_VAR["noti_acount_priod"]["order"]=='2주일'){?>selected<?php }?>>2주일</option>
								<option value="1개월" <?php if($TPL_VAR["noti_acount_priod"]["order"]=='1개월'){?>selected<?php }?>>1개월</option>
								<option value="3개월" <?php if($TPL_VAR["noti_acount_priod"]["order"]=='3개월'){?>selected<?php }?>>3개월</option>
								<option value="6개월" <?php if($TPL_VAR["noti_acount_priod"]["order"]=='6개월'){?>selected<?php }?>>6개월</option>
							</select>
							동안 처리해야 할 주문 건수
						</td>
					</tr>
					<tr>
						<th>게시판</th>
						<td>
							최근
							<select name="noti_count_priod_board">
								<option value="1주일" <?php if($TPL_VAR["noti_acount_priod"]["board"]=='1주일'){?>selected<?php }?>>1주일</option>
								<option value="2주일" <?php if($TPL_VAR["noti_acount_priod"]["board"]=='2주일'){?>selected<?php }?>>2주일</option>
								<option value="1개월" <?php if($TPL_VAR["noti_acount_priod"]["board"]=='1개월'){?>selected<?php }?>>1개월</option>
								<option value="3개월" <?php if($TPL_VAR["noti_acount_priod"]["board"]=='3개월'){?>selected<?php }?>>3개월</option>
								<option value="6개월" <?php if($TPL_VAR["noti_acount_priod"]["board"]=='6개월'){?>selected<?php }?>>6개월</option>
							</select>
							동안 처리해야 할 게시물 건수 <span class="fx11">(상품문의)</span>
						</td>
					</tr>

<?php if($TPL_VAR["is_provider_solution"]){?>
					<tr>
						<th>정산</th>
						<td>
							최근
							<select name="noti_count_priod_account">
								<option value="1주일" <?php if($TPL_VAR["noti_acount_priod"]["account"]=='1주일'){?>selected<?php }?>>1주일</option>
								<option value="2주일" <?php if($TPL_VAR["noti_acount_priod"]["account"]=='2주일'){?>selected<?php }?>>2주일</option>
								<option value="1개월" <?php if($TPL_VAR["noti_acount_priod"]["account"]=='1개월'){?>selected<?php }?>>1개월</option>
								<option value="3개월" <?php if($TPL_VAR["noti_acount_priod"]["account"]=='3개월'){?>selected<?php }?>>3개월</option>
								<option value="6개월" <?php if($TPL_VAR["noti_acount_priod"]["account"]=='6개월'){?>selected<?php }?>>6개월</option>
							</select>
							동안 처리해야 할 정산 건수
						</td>
					</tr>
<?php }?>
				</table>
			</div>

			<div class="contents_dvs">
				<div class="item-title">판매자</div>
				<table class="table_basic thl">
					<tr>
						<th>상호(회사명)</th>
						<td><input type="text" name="info_name" value="<?php echo $TPL_VAR["info_name"]?>"/></td>
						<th>대표자 이름</th>
						<td><input type="text" name="info_ceo" value="<?php echo $TPL_VAR["info_ceo"]?>"/></td>
					</tr>

					<tr>
						<th>사업자 번호</th>
						<td><input type="text" name="info_num" value="<?php echo $TPL_VAR["info_num"]?>"/></td>
						<th>주민/법인(법인등록번호)</th>
						<td>
							<div class="resp_radio">
								<label><input type="radio" name="info_type" value="개인" <?php if($TPL_VAR["info_type"]=='개인'||$TPL_VAR["info_type"]==''){?>checked<?php }?>> 개인</label>
								<label><input type="radio" name="info_type" value="법인" <?php if($TPL_VAR["info_type"]=='법인'){?>checked<?php }?>> 법인</label>
							</div>
							<input type="text" name="info_type_num" value="<?php echo $TPL_VAR["info_type_num"]?>" class="ml15" /></td>
						</td>
					</tr>

					<tr>
						<th>업태/종목</th>
						<td><input type="text" name="info_item" value="<?php echo $TPL_VAR["info_item"]?>" class="line" size="10"/> / <input type="text" name="info_status" value="<?php echo $TPL_VAR["info_status"]?>" size="10"/></td>
						<th>통신 판매 신고번호</th>
						<td><input type="text" name="info_selling_license" value="<?php echo $TPL_VAR["info_selling_license"]?>"/></td>
					</tr>

					<tr>
						<th>사업자 등록증 사본</th>
						<td colspan="3">
							<div class="webftpFormItem">
								<label class="resp_btn v2"><input type="file" id="busiBtn" class="uploadify">파일선택</label>
								<input type="hidden" class="webftpFormItemInput" name="info_file_hidden" value="<?php echo $TPL_VAR["info_file"]?>"/>
								<div class="preview_image"></div>
							</div>
						</td>
					</tr>

					<tr>
						<th>사업장 주소</th>
						<td colspan="3" class="clear">
							<input type="hidden" name="info_address_type" value="<?php echo $TPL_VAR["info_address1_type"]?>" />

							<table class="table_basic thl v3">
								<tr>
									<th>우편번호</th>
									<td>
										<input type="text" name="info_zipcode[]" value="<?php echo $TPL_VAR["info_zipcode"]?>" size="5" class="line" />
										<input type="button" id="infoZipcodeButton" value="우편번호" class="resp_btn v2"/>
									</td>
								</tr>
								<tr>
									<th>지번</th>
									<td><input type="text" name="info_address" value="<?php echo $TPL_VAR["info_address1"]?>" size="80" /></td>
								</tr>
								<tr>
									<th>도로명</th>
									<td><input type="text" name="info_address_street" value="<?php echo $TPL_VAR["info_address1_street"]?>" size="80"/></td>
								</tr>
								<tr>
									<th>상세 주소</th>
									<td><input type="text" name="info_address2" value="<?php echo $TPL_VAR["info_address2"]?>" size="80"/></td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<th>전화</th>
						<td><input type="text" name="info_phone" value="<?php echo $TPL_VAR["info_phone"]?>"/></td>
						<th>메일</th>
						<td><input type="text" name="info_email" value="<?php echo $TPL_VAR["info_email"]?>"/></td>
					</tr>

					<tr>
						<th>팩스</th>
						<td colspan="3"><input type="text" name="info_fax" value="<?php echo $TPL_VAR["info_fax"]?>"/></td>
					</tr>
				</table>
			</div>

			<div class="contents_dvs">
				<div class="item-title">담당자</div>
				<table class="table_basic">
					<colgroup>
						<col width="20%" />
						<col width="20%" />
						<col width="20%" />
						<col width="20%" />
						<col width="20%" />
					</colgroup>
					<tr>
						<th>구분</th>
						<th>이름</th>
						<th>이메일</th>
						<th>전화번호</th>
						<th>
							휴대폰 번호
							<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/provider', '#tip4')"></span>
						</th>
					</tr>
					<tr>
						<th class="left">물류 담당자 (1)</th>
						<td><input type="text" name="ds1_name" value="<?php echo $TPL_VAR["ds1"]["name"]?>" class="wp95"/></td>
						<td><input type="text" name="ds1_email" value="<?php echo $TPL_VAR["ds1"]["email"]?>" class="wp95"/></td>
						<td><input type="text" name="ds1_phone" value="<?php echo $TPL_VAR["ds1"]["phone"]?>" class="wp95"/></td>
						<td><input type="text" name="ds1_mobile" value="<?php echo $TPL_VAR["ds1"]["mobile"]?>" class="wp95"/></td>
					</tr>
					<tr>
						<th class="left">물류 담당자 (2)</th>
						<td><input type="text" name="ds2_name" value="<?php echo $TPL_VAR["ds2"]["name"]?>" class="wp95"/></td>
						<td><input type="text" name="ds2_email" value="<?php echo $TPL_VAR["ds2"]["email"]?>" class="wp95"/></td>
						<td><input type="text" name="ds2_phone" value="<?php echo $TPL_VAR["ds2"]["phone"]?>" class="wp95"/></td>
						<td><input type="text" name="ds2_mobile" value="<?php echo $TPL_VAR["ds2"]["mobile"]?>" class="wp95"/></td>
					</tr>
					<tr>
						<th class="left">CS 담당자</th>
						<td><input type="text" name="cs_name" value="<?php echo $TPL_VAR["cs"]["name"]?>" class="wp95"/></td>
						<td><input type="text" name="cs_email" value="<?php echo $TPL_VAR["cs"]["email"]?>" class="wp95"/></td>
						<td><input type="text" name="cs_phone" value="<?php echo $TPL_VAR["cs"]["phone"]?>" class="wp95"/></td>
						<td>	<input type="text" name="cs_mobile" value="<?php echo $TPL_VAR["cs"]["mobile"]?>" class="wp95"/></td>
					</tr>
					<tr>
						<th class="left">담당 MD</th>
						<td><input type="text" name="md_name" value="<?php echo $TPL_VAR["md"]["name"]?>" class="wp95"/></td>
						<td><input type="text" name="md_email" value="<?php echo $TPL_VAR["md"]["email"]?>" class="wp95"/></td>
						<td><input type="text" name="md_phone" value="<?php echo $TPL_VAR["md"]["phone"]?>" class="wp95"/></td>
						<td><input type="text" name="md_mobile" value="<?php echo $TPL_VAR["md"]["mobile"]?>" class="wp95"/></td>
					</tr>
					<tr>
						<th class="left">정산 담당자</th>
						<td><input type="text" name="calcus_name" value="<?php echo $TPL_VAR["calcu"]["name"]?>" class="wp95"/></td>
						<td><input type="text" name="calcus_email" value="<?php echo $TPL_VAR["calcu"]["email"]?>" class="wp95"/></td>
						<td><input type="text" name="calcus_phone" value="<?php echo $TPL_VAR["calcu"]["phone"]?>" class="wp95"/></td>
						<td><input type="text" name="calcus_mobile" value="<?php echo $TPL_VAR["calcu"]["mobile"]?>" class="wp95"/>	</td>
					</tr>
				</table>
			</div>

			<div class="contents_dvs">
				<div class="item-title">관리자 권한</div>
				<table class="table_basic thl">
					<col width="15%" /><col width="42%" /><col width="43%" />
					<tr>
						<th>판매상품</th>
						<td colspan="2">
							<label>판매상품 보기</label>
							<label>→ 판매상품 정보 등록/수정/삭제 (사은품,상품데이터 일괄업데이트,카테고리/브랜드/지역 관리 및 바코드 출력 포함)</label>
						</td>
					</tr>
					<tr>
						<th>주문</th>
						<td>
							<label>주문 보기</label>
							<label>→ 출고/배송 처리</label>
						</td>
						<td>
							<label>반품/환불보기</label>
							<label>→ 반품처리</label>
						</td>
					</tr>
					<tr>
						<th>게시판</th>
						<td colspan="2">
							<ul>
								<li>
									<label>고객상담 통합게시판 보기</label>
									<label>/ 고객상담 통합게시판 관리</label>
								</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th>프로모션/쿠폰</th>
						<td colspan="2">
							<label>포로모션/쿠폰 보기</label>
						</td>
					</tr>
					<tr>
						<th>통계</th>
						<td colspan="2">
							<label>상품</label>
						</td>
					</tr>
					<tr>
						<th>정산</th>
						<td colspan="2">
							<label>정산리스트 보기</label>
						</td>
					</tr>
					<tr>
						<th>배송/택배</th>
						<td colspan="2">
							<label>택배/배송비 보기</label>
							<label>→ 택배/배송비 설정 권한</label>
						</td>
					</tr>
					<tr>
						<th>관리자</th>
						<td colspan="2">
							<label>관리자리스트보기</label>
							<label>→ 관리자 등록/수정</label>
						</td>
					</tr>
				</table>
			</div>

			<div class="contents_dvs">
				<div class="item-title">처리 내역</div>
				<table class="table_basic">
					<colgroup>
						<col width="50%" />
						<col width="50%" />
					</colgroup>
					<tr>
						<th>관리 메모(입점사용)</th>
						<th>처리 내역</th>
					</tr>

					<tr>
						<td valign="top" align="right" style="border:1px solid #cccccc; background:#f7f7f7">
							<textarea name="selleradmin_memo" style="width:99%; padding:10px 0px; height:120px; border:0px;background-color:transparent"><?php echo $TPL_VAR["selleradmin_memo"]?></textarea>
						</td>
						<td valign="top" align="right" style="border:1px solid #cccccc; background:#f7f7f7">
							<div style="overflow:auto;height:120px;width:98%;border:0;padding: 10px 5px;background:#f7f7f7;text-align:left;"><?php echo $TPL_VAR["provider_log"]?></div>
						</td>
					</tr>
				</table>
			</div>
			<!-- 서브메뉴 바디 : 끝 -->
		</div>
		<!-- 서브 레이아웃 영역 : 끝 -->
	</form>


	<!-- 아이콘 선택 -->
	<div id="calcuPopup" style="display:none;">
		<form name="calcuRegist" id="calcuRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">

			<table width="100%" cellpadding="0" id="brand_table">
				<tr>
					<td>
						<span class="btn-plus"><button type="button" id="etcAdd"></button></span> 기본 <input type="text" name="brand_charge" value="<?php echo $TPL_VAR["charge"]?>" size="5" class="line"/>%</td>
				</tr>
				<!--
                <tr>
                    <td>
                        <span class="btn-minus"><button type="button" id="etcDel"></button></span>
                        <select name="brand[]">
                            <option value="">= 선택해주세요 =</option>
<?php if($TPL_brand_1){foreach($TPL_VAR["brand"] as $TPL_V1){?>
                            <option value="<?php echo $TPL_V1["category_code"]?>"><?php echo $TPL_V1["title"]?></option>
<?php }}?>
                        </select>
                        <input type="text" name="brand_charge[]" value="" size="5" class="line"/>%
                    </td>
                </tr>
                -->
			</table>
			<ul>
				<li style="text-align:center;padding-top:10px;"><span class="btn large cyanblue"><input type="button" value="저장하기" id="calcu_select"><span class="arrowright"></span></button></span></li>
				</li>
			</ul>
		</form>
	</div>


	<div id="shippingModifyPopup" style="display:none"></div>
	<div id="internationalShippingPopup" style="display:none"></div>


	<div id="bankPopup" style="display:none;">
		<form name="iconRegist" id="iconRegist" method="post" action="" enctype="multipart/form-data"  target="actionFrame">

			<input type="file" name="calcu_file" id="calcu_file" class="line"/>

			<div style="padding:10px;" class="center">
				<input type="button" value="저장" class="btn_resp b_gray size_a" onclick="calcuFileUpload();"/></button>
			</div>
		</form>
	</div>


	<div id="busiPopup" style="display:none;">
		<form name="iconRegist2" id="iconRegist2" method="post" action="" enctype="multipart/form-data"  target="actionFrame">

			<input type="file" name="busi_file" id="busi_file" class="line"/>

			<div style="padding:10px;" class="center">
				<input type="button" class="btn_resp b_gray size_a" value="저장" onclick="busiFileUpload();"/></button>
			</div>
		</form>
	</div>

	<div id="detailPageSetting" class="hide">
		<table class="table_basic thl">
			<tr>
				<th>검색 필터</th>
				<td>
					<div class="resp_checkbox">
						<label><input type="checkbox" name="minishop_search_filter[]" value="category" <?php if(in_array('category',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 카테고리</label>
						<label><input type="checkbox" name="minishop_search_filter[]" value="brand" <?php if(in_array('brand',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 브랜드</label>
						<label><input type="checkbox" name="minishop_search_filter[]" value="freeship" <?php if(in_array('freeship',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 무료배송</label>
						<label><input type="checkbox" name="minishop_search_filter[]" value="abroadship" <?php if(in_array('abroadship',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 해외배송</label>
						<label><input type="checkbox" name="minishop_search_filter[]" value="price" <?php if(in_array('price',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 가격</label>
						<label><input type="checkbox" name="minishop_search_filter[]" value="rekeyword" <?php if(in_array('rekeyword',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 재검색어</label>
						<label><input type="checkbox" name="minishop_search_filter[]" value="color" <?php if(in_array('color',$TPL_VAR["minishop_search_filter"])){?>checked<?php }?>/> 색상</label>
					</div>
				</td>
			</tr>

			<tr>
				<th>상품 정렬</th>
				<td>
					<div class="resp_radio">
						<label><input type="radio" name="minishop_orderby" value="rank" <?php if($TPL_VAR["minishop_orderby"]=='rank'){?>checked<?php }?>/> 랭킹순</label>
						<label><input type="radio" name="minishop_orderby" value="new" <?php if($TPL_VAR["minishop_orderby"]=='new'){?>checked<?php }?>/> 신규등록순</label>
						<label><input type="radio" name="minishop_orderby" value="low" <?php if($TPL_VAR["minishop_orderby"]=='low'){?>checked<?php }?>/> 낮은가격순</label>
						<label><input type="radio" name="minishop_orderby" value="high" <?php if($TPL_VAR["minishop_orderby"]=='high'){?>checked<?php }?>/> 높은가격순</label>
						<label><input type="radio" name="minishop_orderby" value="review" <?php if($TPL_VAR["minishop_orderby"]=='review'){?>checked<?php }?>/> 상품평많은순</label>
						<label><input type="radio" name="minishop_orderby" value="sales" <?php if($TPL_VAR["minishop_orderby"]=='sales'){?>checked<?php }?>/> 판매량순</label>
					</div>
				</td>
			</tr>

			<tr>
				<th>노출할 상품의 상태</th>
				<td>
					<div class="resp_checkbox">
						<label><input type="checkbox" name="" value="" checked disabled/> 정상</label>
						<label><input type="checkbox" name="minishop_status[]" value="runout" <?php if(in_array('runout',$TPL_VAR["minishop_status"])){?>checked<?php }?>/> 품절</label>
						<label><input type="checkbox" name="minishop_status[]" value="purchasing" <?php if(in_array('purchasing',$TPL_VAR["minishop_status"])){?>checked<?php }?>/> 재고확보중</label>
						<label><input type="checkbox" name="minishop_status[]" value="unsold" <?php if(in_array('unsold',$TPL_VAR["minishop_status"])){?>checked<?php }?>/> 판매중지</label>
					</div>
				</td>
			</tr>

			<tr>
				<th>상품 이미지 사이즈</th>
				<td>
					<select name="minishop_goods_info_image">
<?php if(is_array($TPL_R1=config_load('goodsImageSize'))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_VAR["minishop_goods_info_image"]==$TPL_K1){?>
						<option value="<?php echo $TPL_K1?>" selected><?php echo $TPL_V1["name"]?></option>
<?php }else{?>
						<option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1["name"]?></option>
<?php }?>
<?php }}?>
					</select>
				</td>
			</tr>
		</table>

		<div class="footer">
			<button type="button" class="resp_btn active size_XL confirmPopupInfoBtn">확인</button>
			<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this)">취소</button>
		</div>
	</div>

	<div id="goodInfoStyle" class="hide" >
		<div class="item-title">상품 디스플레이</div>
<?php $this->print_("goods_info_style",$TPL_SCP,1);?>

		<div class="resp_message">- 상품 노출 조건 <a href="https://www.firstmall.kr/customer/faq/1358" target="_blank" class="resp_btn_txt">자세히 보기</a></div>
		<div class="footer">
			<button type="button" class="confirmPopupInfoBtn resp_btn active size_XL">확인</button>
			<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this)">취소</button>
		</div>
	</div>


	<div id="sendPopup" class="hide"></div>

	<div id="lay_goods_select"></div><!-- 상품선택 레이어 -->
<?php $this->print_("layout_footer",$TPL_SCP,1);?>