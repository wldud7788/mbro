<?php /* Template_ 2.2.6 2022/05/17 12:36:24 /www/music_brother_firstmall_kr/admin/skin/default/member/curation.html 000008735 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	function personal_use(el){
		var value = $(el).val();

		if(value == "y") {
			$(el).parents("tr").find(".user_yn_check").attr('disabled',false);
		} else {
			$(el).parents("tr").find(".user_yn_check").attr('disabled',true);
			$(el).parents("tr").find(".user_yn_check").attr('checked',false).trigger('change');
		}
	}

	function user_yn_check(el){
		var email = $(el).parents("td").find(".user_yn_email");

		if($(el).is(":checked")) {
			email.val('Y');
		} else {
			email.val('N');
		}
	}

	function smsRequire(obj){
		obj.checked = true;
	}

	$(document).ready(function() {

		$(".selectMail").on("click",function(){

<?php if(serviceLimit('H_FR')){?>
			if(($(this).val()) == "personal_timesale" ){
				$(".selectMail").eq(0).attr('checked',true);
				<?php echo serviceLimit('A1')?>

			}else{
				$("input[name='mail_form']").val($(this).val());
				//getMailForm($(this).val());
			}
<?php }else{?>
			$("input[name='mail_form']").val($(this).val());
			//getMailForm($(this).val());
<?php }?>
			});


			$("select[name='go_item_use']").change(function(){

				if($(this).val() == 'y'){
					$(".goodsnmlimit").show();
				}else{
					$(".goodsnmlimit").hide();
				}

			});

			// shorturl url 설정
			$(".shorturlConfig").click(function() {
				var winH = "235";
<?php if($TPL_VAR["sns"]["shorturl_app_key"]&&$TPL_VAR["sns"]["shorturl_app_id"]){?>	winH = 390; <?php }?>
					openDialog("짧은 URL 설정", "shorturl_help_lay", {"width":"600","height":winH,"show" : "fade","hide" : "fade"});
				});

				//짧은주소 관련
				$("input[name='shorturl_use']").click(function(){
					if( $("input[name='shorturl_use']:checked").val() == "Y" ) {
						$(".btnshorturl").show();
					}else{
						$(".btnshorturl").hide();
					}
				});

				//수정 버튼
				$(".modifyBtn").on("click", function(){
					var _mode = $(this).attr("mode");
					window.open('curation_contents_modify_pop?mode='+_mode,"send_email","menubar=no, toolbar=no, location=yes, status=no, resizble=yes, scrollbars=no,width=1050, height=900");
				});

				$(".personal_use").on("change", function(){
					personal_use($(this));
				}).trigger('change');

				$(".user_yn_check").on("change", function(){
					user_yn_check($(this));
				}).trigger('change');

			});

</script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js"></script>
<form name="memberForm" id="memberForm" method="post" target="actionFrame" action="../member_process/curation">
	<input type="hidden" name="mail_form" />

	<!-- 페이지 타이틀 바 : 시작 -->
	<div id="page-title-bar-area">
		<div id="page-title-bar">

			<!-- 타이틀 -->
			<div class="page-title"><h2>고객 리마인드</h2></div>

			<!-- 우측 버튼 -->
			<ul class="page-buttons-right">
				<li><button type="submit" class="resp_btn active2 size_L">저장</button></li>
			</ul>
		</div>
	</div>
	<!-- 페이지 타이틀 바 : 끝 -->

	<div class="contents_container">
		<!-- 상단 단계 링크 : 시작 -->
<?php $this->print_("top_menu",$TPL_SCP,1);?>

		<!-- 상단 단계 링크 : 끝 -->
		<!-- 서브 레이아웃 영역 : 시작 -->
		<div class="item-title">리마인드 공용</div>
		<table class="table_basic thl">
			<tr>
				<th>주소 URL</th>
				<td>
					<div class="resp_radio">
						<label ><input type="radio" name="shorturl_use" value="N" <?php if($TPL_VAR["sns"]["shorturl_use"]=='N'||!$TPL_VAR["sns"]["shorturl_use"]){?> checked="checked" <?php }?> /> URL 주소 정보 제공	</label>
						<label ><input type="radio" name="shorturl_use" id="shorturl_use" value="Y" <?php if($TPL_VAR["sns"]["shorturl_use"]=='Y'){?> checked="checked" <?php }?> > URL 주소 정보를 짧게 변환</label>
					</div>
					<span class="btnshorturl" <?php if($TPL_VAR["sns"]["shorturl_use"]=='N'||!$TPL_VAR["sns"]["shorturl_use"]){?>style="display:none;"<?php }?>><button type="button" class="shorturlConfig resp_btn v2">설정</button><?php if($TPL_VAR["set_string"]){?> <span class="red hide">(<?php echo $TPL_VAR["set_string"]?>)</span><?php }?></span>
				</td>
			</tr>
			<tr>
				<th>상품명 길이 제한</th>
				<td>
					<div class="resp_radio">
						<label >
							<input type="radio" name="go_item_use" value="y" <?php if($TPL_VAR["go_item_use"]=='y'){?> checked="checked" <?php }?> />
							제한 최대 <input type="text" name="go_item_limit" value="<?php echo $TPL_VAR["go_item_limit"]?>" id="" size="5" class="right goodsnmlimit"> 자
						</label>
						<label ><input type="radio" name="go_item_use" id="shorturl_use" value="n" <?php if($TPL_VAR["go_item_use"]=='n'){?> checked="checked" <?php }?> > 제한 하지 않음</label>
					</div>
				</td>
			</tr>
		</table>

		<div class="item-title">리마인드 종류</div>
		<table class="table_basic tdc">
			<colgroup>
				<col width="15%">
				<col width="12%">
				<col width="10%">
				<col width="10%">
				<col width="12%">
				<col />
				<col width="11%">
			</colgroup>
			<tr>
				<th>종류</th>
				<th>사용 여부</th>
				<th>SMS</th>
				<th>이메일</th>
				<th>알림톡</th>
				<th>발송 시간</th>
				<th>SMS/이메일 메시지</th>
			</tr>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
			<tr>
				<td class="left">
					<?php echo $TPL_V1["title"]?><input type="hidden" name="curation_name[]" value="<?php echo $TPL_V1["name"]?>" />
<?php if($TPL_V1["name"]=='personal_timesale'){?>
					<span class="tooltip_btn" onclick="showTooltip(this, '/admin/tooltip/member', '#tip33')"></span>
<?php }?>

<?php if($TPL_V1["name"]=='personal_review'){?>
					<span class="tooltip_btn" onclick="showTooltip(this, '/admin/tooltip/member', '#tip34')"></span>
<?php }?>
				</td>
				<td>
					<select name="personal_use[]" class="personal_use">
						<option value="n" style="color:#FF0000" <?php echo $TPL_V1["personal_use"]["n"]?>>사용안함</option>
						<option value="y" style="color:#0000ff" <?php echo $TPL_V1["personal_use"]["y"]?>>사용함</option>
					</select>
				</td>
				<td>발송<input type="hidden" name="user_yn_sms[]" value="Y" /></td>
				<td>
					<label class="resp_checkbox"><input type="checkbox" value="Y" <?php echo $TPL_V1["personal_email"]?> class="user_yn_check" /> <input type="hidden" name="user_yn_email[]" class="user_yn_email" />발송</label>
				</td>
				<td>
<?php if($TPL_V1["personal_talk"]){?>
					<a class="resp_btn_txt" href="/admin/member/kakaotalk_msg?no=4" target="_blank" ><?php echo $TPL_V1["personal_talk"]?></a>
<?php }else{?>
					-
<?php }?>
				</td>
				<td class="left">
					<?php echo $TPL_V1["etc"]?>

					<select name="personal_day[]" class="select_time <?php echo $TPL_V1["not_use_day"]?>">
<?php if($TPL_V1["name"]=='personal_timesale'){?>
						<option value="lastday" <?php echo $TPL_VAR["selected_day"][$TPL_V1["name"]]['lastday']?>>마지막날</option>
						<option value="before" <?php echo $TPL_VAR["selected_day"][$TPL_V1["name"]]['before']?>>종료 하루 전</option>
<?php }else{?>
<?php if(is_array($TPL_R2=$TPL_V1["loop_day"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<option value="<?php echo $TPL_V2?>" <?php echo $TPL_VAR["selected_day"][$TPL_V1["name"]][$TPL_V2]?>><?php echo $TPL_V2?> <?php echo $TPL_V1["day_txt"]?></option>
<?php }}?>
<?php }?>
					</select>
					<select name="personal_time[]" class="select_time">
<?php if(is_array($TPL_R2=$TPL_V1["loop_time"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<option value="<?php echo $TPL_V2?>" <?php echo $TPL_VAR["selected_time"][$TPL_V1["name"]][$TPL_V2]?>><?php echo $TPL_V2?> 시</option>
<?php }}?>
					</select>
				</td>
				<td><button type='button' class="resp_btn v2 modifyBtn" mode="<?php echo $TPL_V1["name"]?>">수정</button></td>
			</tr>
<?php }}?>
		</table>
	</div>
</form>

<div id="replace_pop" class="hide"></div>

<!--- include : snsconf_shorturl_setting -->
<?php $this->print_("shorturl_setting",$TPL_SCP,1);?>


<?php if($TPL_VAR["go_item_use"]=="n"){?>
<script type="text/javascript">
	//$(".goodsnmlimit").hide();
</script>
<?php }?>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>