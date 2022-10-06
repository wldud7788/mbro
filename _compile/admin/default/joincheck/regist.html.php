<?php /* Template_ 2.2.6 2022/05/17 12:36:14 /www/music_brother_firstmall_kr/admin/skin/default/joincheck/regist.html 000032911 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<link rel="stylesheet" type="text/css" href="/app/javascript/plugin/jquploadify/uploadify.css" />
<style type="text/css">
.stamp_img{display: inline-block; vertical-align: middle; padding-left: 10px; height: 30px;}
</style>

<script type="text/javascript" src="/app/javascript/plugin/jquery.colorpicker.min.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/custom-color-picker.js"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.ajax.form.js"></script>
<script type="text/javascript" src="/app/javascript/js/ajaxFileUpload.js"></script>

<script type="text/javascript">

	$(document).ready(function() {

		$(".colorpicker").customColorPicker();

<?php if($TPL_VAR["mode"]=="new"){?>
		//쿠폰신규생성 후 뒤로가기 시 리스트로 이동
		history.pushState(null, null, location.href);
			window.onpopstate = function () {
				document.location.href="/admin/joincheck/catalog";
		};
<?php }?>
		var opt				= {  };
		var callback_img	= function(res){
			var that	= this;
			var result	= eval(res);
			if(result.status){
				var $img_wrap = $('#image-preview-wrap').clone();
				$img_wrap.removeClass('hide');
				$img_wrap.addClass('image-preview-wrap');
				$img_wrap.find('.preview-img img').attr('src', result.filePath + result.fileInfo.file_name);
				$img_wrap.find('.preview-img a').attr('href', result.filePath + result.fileInfo.file_name);
				$img_wrap.find('.preview-del').click(function(){
					$(this).closest('.image-preview-wrap').remove();
					$(that).val('');
					$(that).closest('.webftpFormItem').find('.real_path').val('');
				});
				
				$(that).closest('.webftpFormItem').find('.webftpFormItemInput').attr('issample', 'n');
				$(that).closest('.webftpFormItem').find('.preview_image').html($img_wrap);
				$(that).closest('.webftpFormItem').find('.real_path').val(result.filePath + result.fileInfo.file_name);
			}else{ // 업로드 실패
				alert('[' + result.desc + '] ' + result.msg);
				return false;
			}
		};

		$('.ajaxImageFormInput').createAjaxFileUpload(opt, callback_img);

<?php if($TPL_VAR["joincheck"]["joincheck_banner"]){?>
		var $img_wrap = $('#image-preview-wrap').clone();
		$img_wrap.removeClass('hide');
		$img_wrap.addClass('image-preview-wrap');
		$img_wrap.find('.preview-img img').attr('src', '/data/joincheck/<?php echo $TPL_VAR["joincheck"]["joincheck_banner"]?>?<?php echo time()?>' );
		$img_wrap.find('.preview-img a').attr('href', '/data/joincheck/<?php echo $TPL_VAR["joincheck"]["joincheck_banner"]?>?<?php echo time()?>');
		
		$img_wrap.find('.preview-del').click(function(){
		$(this).closest('.image-preview-wrap').remove();
			$('.ajaxImageFormInput').val('');
			$('.ajaxImageFormInput').closest('.webftpFormItem').find('.real_path').val('');
		});
		$('.ajaxImageFormInput').closest('.webftpFormItem').find('.webftpFormItemInput').attr('issample', 'n');
		$('.ajaxImageFormInput').closest('.webftpFormItem').find('.preview_image').html($img_wrap);
		$('.ajaxImageFormInput').closest('.webftpFormItem').find('.real_path').val('<?php echo $TPL_VAR["joincheck"]["joincheck_banner"]?>');
<?php }?>

<?php if($TPL_VAR["joincheck"]["joincheck_seq"]){?>				
			addToggle("mode_stop", "<?php if($TPL_VAR["joincheck"]["status"]=='진행 중'||$TPL_VAR["joincheck"]["check_state"]=='ing'){?>ing<?php }else{?>stop<?php }?>");	
			setContentsRadio("ck_type", "<?php echo $TPL_VAR["joincheck"]["check_type"]?>");
			setContentsRadio("cl_type", "<?php echo $TPL_VAR["joincheck"]["check_clear_type"]?>");
			setContentsRadio("joincheck_view", "<?php echo $TPL_VAR["joincheck"]["joincheck_view"]?>");
<?php }else{?>
			setContentsRadio("ck_type", "stamp");
			setContentsRadio("cl_type", "count");
			setContentsRadio("joincheck_view", "Y");
<?php }?>

		setContentsDoubleRadio('reserve_limit_type', "<?php if($TPL_VAR["joincheck"]["reserve_select"]==""){?>N<?php }else{?>Y<?php }?>", 'reserve_select', '<?php if($TPL_VAR["joincheck"]["reserve_select"]==""){?>year<?php }else{?><?php echo $TPL_VAR["joincheck"]["reserve_select"]?><?php }?>');
		setContentsDoubleRadio('point_limit_type', "<?php if($TPL_VAR["joincheck"]["point_select"]==""){?>N<?php }else{?>Y<?php }?>", 'point_select', '<?php if($TPL_VAR["joincheck"]["point_select"]==""){?>year<?php }else{?><?php echo $TPL_VAR["joincheck"]["point_select"]?><?php }?>');
		
		setContentsCheckbox('add_benefits');		
		
		var shopName = "<?php echo $TPL_VAR["joincheck"]["shopName"]?>";

		//기본으로 1달선언
<?php if(!$TPL_VAR["joincheck"]["start_date"]){?>
			$("input[name='sdate']").val(getDate(0));
<?php }?>
		
<?php if(!$TPL_VAR["joincheck"]["end_date"]){?>
			$("input[name='edate']").val(getDate(-30));
<?php }?>
		
		$("select[name='reserve_year'], input[name='reserve_direct'], select[name='point_year'], input[name='point_direct']").on("click", function()
		{
			$(this).closest(".resp_radio").find("label").removeClass("on");
			$(this).prev().attr("checked", true);
			$(this).closest("label").addClass("on");
		})

			$(".select_date").click(function() {
				switch($(this).attr("id")) {
					case 'today' :
						$("input[name='sdate']").val(getDate(0));
						$("input[name='edate']").val(getDate(0));
						break;
					case '3day' :
						$("input[name='sdate']").val(getDate(0));
						$("input[name='edate']").val(getDate(-3));
						break;
					case '1week' :
						$("input[name='sdate']").val(getDate(0));
						$("input[name='edate']").val(getDate(-7));
						break;
					case '1month' :
						$("input[name='sdate']").val(getDate(0));
						$("input[name='edate']").val(getDate(-30));
						break;
					case '3month' :
						$("input[name='sdate']").val(getDate(0));
						$("input[name='edate']").val(getDate(-90));
						break;
					default :
						$("input[name='sdate']").val('');
						$("input[name='edate']").val('');
						break;
				}
			});

		$(".select_date").eq(2).trigger("click");

		$("form #imgDownload").on("click",function(){
			var src = $(this).attr("src");
			actionFrame.location.href = "../../common/download?downfile="+escape(src);
		});
		
		$('#reserve_year').val('<?php echo $TPL_VAR["joincheck"]["reserve_year"]?>');
		$('#point_year').val('<?php echo $TPL_VAR["joincheck"]["point_year"]?>');

		$("#joincheck_write_btn").on("click",function(){
			var frm = $("#jcRegist");
			frm.find("input[name='savemode']").val('modify');
			//frm.find("input[name='mode_stop']").attr("disabled",true);
			frm.submit();
		});
	});
		
	 //중단 or 재개 하기
	function changeStop_btn(str){
		 $("input[name='submode']").val('mode_stop');
		 $("input[name='mode_stop'][value='"+str+"']").prop("checked",true);
		 jcRegist.submit();
	}

	function image_insert(obj, type){
		$(obj).closest('.webftpFormItem').find('.' + type).click();
	}

	function jc_cpurl_btn(seq){
		var str= "://<?php echo $_SERVER["HTTP_HOST"]?>/joincheck/joincheck_view?seq="+seq;
		if(window.clipboardData){
			window.clipboardData.setData("TEXT",str);
			alert("복사되었습니다.");
		}else{
			temp = prompt("Ctrl+C를 눌러 복사하세요", str);
		}

	}
</script>

<!-- 서브메뉴 바디 : 시작-->
<form name="jcRegist" id="jcRegist" method="post" enctype="multipart/form-data" action='../joincheck_process' target="actionFrame">
<?php if($TPL_VAR["joincheck"]["joincheck_seq"]){?>
<input type="hidden" name="mode" value="joincheck_modify" />
<input type="hidden" name="joincheck_seq" value="<?php echo $TPL_VAR["joincheck"]["joincheck_seq"]?>" />
<?php }else{?>
<input type="hidden" name="mode" value="joincheck_write" />
<?php }?>
<input type="hidden" name="savemode" value="status" />
<input type="hidden" name="submode" value="" />

	<!-- 페이지 타이틀 바 : 시작 -->
	<div id="page-title-bar-area">
		<div id="page-title-bar">
			<!-- 타이틀 -->
			<div class="page-title">
			<h2>출석 체크 이벤트 <?php if($TPL_VAR["joincheck"]["joincheck_seq"]){?>수정<?php }else{?>등록<?php }?></h2>		
			</div>

			<!-- 좌측 버튼 -->
			<ul class="page-buttons-left">
			<li><button type="button" onclick="document.location.href='/admin/joincheck/catalog?<?php echo $TPL_VAR["query_string"]?>';" class="resp_btn v3 size_L">리스트 바로가기</button></li>			
			</ul>

			<!-- 우측 버튼 -->
		<ul class="page-buttons-right <?php if($TPL_VAR["joincheck"]["status"]=='진행완료'){?>hide<?php }?>">			
			<li>
			<button type="button" class="resp_btn active2 size_L" name="joincheck_write_btn" id="joincheck_write_btn">저장</button>
			</li>
			</ul>
		</div>
	</div>
	<!-- 페이지 타이틀 바 : 끝 -->
<div class="contents_container">
<?php if($TPL_VAR["joincheck"]["joincheck_seq"]){?>
	<div class="item-title">출석 체크 이벤트 현황</div>
	<table class="table_basic thl">		
		<tr>
			<th>상태</th>
			<td>			
<?php if($TPL_VAR["joincheck"]["check_state"]=='stop'||$TPL_VAR["joincheck"]["status"]=='진행 중'){?>
				<div class="resp_toggle">
					<label <?php if($TPL_VAR["joincheck"]["status"]=='진행 중'||$TPL_VAR["joincheck"]["check_state"]=='ing'){?>style="display:none;"<?php }?>><input type="radio" name="mode_stop" value="stop" onclick="changeStop_btn('ing')" />진행중지</label>
					<label <?php if(!($TPL_VAR["joincheck"]["status"]=='진행 중'||$TPL_VAR["joincheck"]["check_state"]=='ing')){?>style="display:none;"<?php }?>><input type="radio" name="mode_stop" value="ing" onclick="changeStop_btn('stop')"/>진행 중</label>										
				</div>		
<?php }else{?>
				<?php echo $TPL_VAR["joincheck"]["status"]?>

<?php }?>
			</td>
		</tr>	
		
		<tr>
			<th>진행 현황</th>
			<td>
				참여 <?php echo $TPL_VAR["page"]["totalcount"]?>건
				/ 달성 <?php echo $TPL_VAR["rc"]["sum_clear"]?>건
				/ 적립 <?php echo $TPL_VAR["rc"]["sum_emoney"]?>건
				<button type="button" class="resp_btn v2" onclick="window.open('memberlist?joincheck_seq=<?php echo $TPL_VAR["joincheck"]["joincheck_seq"]?>','window_name','width=1100,height=800,location=no,status=no,scrollbars=yes');">조회</button>
			</td>
		</tr>

		<tr>
			<th>이벤트 디자인</th>
			<td>
				<a href="http://<?php echo $_SERVER["HTTP_HOST"]?>/joincheck/joincheck_view?seq=<?php echo $TPL_VAR["joincheck"]["joincheck_seq"]?>" target="_blank" class="resp_btn">보기</a>						
				<input type="button" class="resp_btn v2" name="manager_cpurl_btn" value="URL 복사" onclick="jc_cpurl_btn(<?php echo $TPL_VAR["joincheck"]["joincheck_seq"]?>)" />				
			</td>
		</tr>
	</table>
<?php }?>
	
	<div class="item-title">기본 정보</div>
	
	<table class="table_basic thl">		
		<tr>
			<th>
				출석 체크 방법
				<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip1', '500')"></span>
			</th>
			<td>				
<?php if(!$TPL_VAR["joincheck"]["joincheck_seq"]||$TPL_VAR["joincheck"]["status"]=='진행 전'){?>
					<div class="resp_radio">
						<label><input type="radio" name="ck_type" id="ck_type1" value="stamp" checked/> 스탬프</label>
						<label><input type="radio" name="ck_type" id="ck_type2" value="comment" /> 댓글 작성</label>	
						<label><input type="radio" name="ck_type" id="ck_type3" value="login"/> 로그인</label>
					</div>	

<?php }else{?>				
<?php if($TPL_VAR["joincheck"]["check_type"]=='stamp'){?>스탬프<?php }?>
<?php if($TPL_VAR["joincheck"]["check_type"]=='comment'){?>댓글 작성<?php }?>
<?php if($TPL_VAR["joincheck"]["check_type"]=='login'){?>로그인<?php }?>	
					<input type="radio" name="ck_type" id="ck_type1" value="stamp" class="hide"/>
					<input type="radio" name="ck_type" id="ck_type2" value="comment" class="hide"/>
					<input type="radio" name="ck_type" id="ck_type3" value="login" class="hide"/>
<?php }?>
			</td>
		</tr>	

		<tr>
			<th>달성 조건</th>
			<td>
<?php if(!$TPL_VAR["joincheck"]["joincheck_seq"]||$TPL_VAR["joincheck"]["status"]=='진행 전'){?>
				<div class="resp_radio">
					<label><input type="radio" id="cl_type_c" name="cl_type" value="count" <?php if(!$TPL_VAR["joincheck"]["joincheck_seq"]||$TPL_VAR["joincheck"]["check_clear_type"]=='count'){?>checked <?php }else{?>  <?php }?>/> 목표 출석 횟수 달성</label>
					<label><input type="radio" id="cl_type_s" name="cl_type" value="straight" <?php if($TPL_VAR["joincheck"]["check_clear_type"]=='straight'){?>checked <?php }else{?> <?php }?>/> 연속 출석 횟수 달성</label>
				</div>
<?php }else{?>
<?php if($TPL_VAR["joincheck"]["check_clear_type"]=='count'){?>
					목표 출석 횟수 달성
<?php }?>
<?php if($TPL_VAR["joincheck"]["check_clear_type"]=='straight'){?>
					연속 출석 횟수 달성
<?php }?>
					<input type="radio" name="cl_type" value="count" class="hide">
					<input type="radio" name="cl_type" value="straight" class="hide">
<?php }?>
				</td>
			</tr>
		
		<tr class="cl_type_count hide" >
			<th>목표 출석 횟수 <span class="required_chk"></span></th>
			<td>				
				 기간 내
<?php if($TPL_VAR["joincheck"]["status"]=='진행완료'){?>
				 <strong><?php echo $TPL_VAR["joincheck"]["check_clear_count"]?></strong>
<?php }else{?>
				 <input type="text" name="cl_count_c" id="cl_count_c" class="line" size="4" value="<?php if($TPL_VAR["joincheck"]["check_clear_type"]=='count'){?><?php echo $TPL_VAR["joincheck"]["check_clear_count"]?><?php }else{?>10<?php }?>"/>
<?php }?>
				 회 출석
			</td>
		</tr>

		<tr class="cl_type_straight hide">
			<th>연속 출석 횟수 <span class="required_chk"></span></th>
			<td>
				기간 내
<?php if($TPL_VAR["joincheck"]["status"]=='진행완료'){?>
				<strong><?php echo $TPL_VAR["joincheck"]["check_clear_count"]?></strong>
<?php }else{?>
				<input type="text" name="cl_count_s" id="cl_count_s" class="line" size="4" value="<?php if($TPL_VAR["joincheck"]["check_clear_type"]=='straight'){?><?php echo $TPL_VAR["joincheck"]["check_clear_count"]?><?php }else{?>10<?php }?>"/>
<?php }?>
				회 연속 출석
				</td>
			</tr>
		<tr>
			<th>이벤트명 <span class="required_chk"></span></th>
			<td>
<?php if($TPL_VAR["joincheck"]["status"]=='진행완료'){?>
				<?php echo $TPL_VAR["joincheck"]["title"]?>

<?php }else{?>
				<div class="resp_limit_text limitTextEvent">
					<input type="text" name="ch_title" id="ch_title" size="50" maxlength="30" value="<?php if($TPL_VAR["joincheck"]["joincheck_seq"]){?><?php echo $TPL_VAR["joincheck"]["title"]?><?php }?>" class="resp_text" >	
				</div>
<?php }?>
			</td>
		</tr>		
<?php if($TPL_VAR["joincheck"]["joincheck_seq"]){?>
		<tr>
			<th>이벤트 기간</span></th>
			<td>
<?php if($TPL_VAR["joincheck"]["status"]=='진행 전'||$TPL_VAR["joincheck"]["start_date"]=='0000-00-00'){?>
				<input type="text" name="sdate" id="sdate" value="<?php echo $TPL_VAR["joincheck"]["start_date"]?>" class="datepicker line"  maxlength="10" size="10" readonly/>
<?php }else{?>
				<input type="hidden" name="sdate" id="sdate" value="<?php echo $TPL_VAR["joincheck"]["start_date"]?>">
				<?php echo $TPL_VAR["joincheck"]["start_date"]?>

<?php }?>
				~
<?php if($TPL_VAR["joincheck"]["status"]=='진행 전'||$TPL_VAR["joincheck"]["end_date"]=='0000-00-00'){?>
				<input type="text" name="edate" id="edate" value="<?php echo $TPL_VAR["joincheck"]["end_date"]?>" class="datepicker line" maxlength="10" size="10" readonly />
<?php }else{?>
				<input type="hidden" name="edate" id="edate" value="<?php echo $TPL_VAR["joincheck"]["end_date"]?>">
				<?php echo $TPL_VAR["joincheck"]["end_date"]?>

<?php }?>
			</td>
		</tr>	
<?php }else{?>
		<tr>
			<th>이벤트 기간 <span class="required_chk"></span></th>
			<td>
				<input type="text" name="sdate" id="sdate" value="<?php echo $TPL_VAR["joincheck"]["start_date"]?>" class="datepicker"  maxlength="10" size="10" readonly />
				-
				<input type="text" name="edate" id="edate" value="<?php echo $TPL_VAR["joincheck"]["end_date"]?>" class="datepicker" maxlength="10" size="10" readonly />
				
				<div class="resp_btn_wrap">
					<input type="button"  id="3day" value="3일간" class="select_date resp_btn" /></span>
					<input type="button"  id="1week" value="일주일" class="select_date resp_btn" /></span>
					<input type="button"  id="1month" value="1개월" class="select_date resp_btn" /></span>
				</div>				
			</td>
		</tr>
<?php }?>
	</table>

	<div class="item-title">혜택 설정</div>
	
	<table class="table_basic thl">		
			<tr>
			<th>지급 캐시 <span class="required_chk"></span></th>
			<td>
				달성 조건 충족 시
<?php if(!$TPL_VAR["joincheck"]["joincheck_seq"]||$TPL_VAR["joincheck"]["status"]=='진행 전'){?>
				<input type="text" name="emoney" size="8" id="emoney" class="right <?php echo $TPL_VAR["only_numberic_type"]?>" value="<?php if($TPL_VAR["joincheck"]["emoney"]){?><?php echo get_currency_price($TPL_VAR["joincheck"]["emoney"], 1)?><?php }else{?>0<?php }?>">	
<?php }else{?>
				<input type="hidden" name="emoney" class="line <?php echo $TPL_VAR["only_numberic_type"]?>" value="<?php if($TPL_VAR["joincheck"]["emoney"]){?><?php echo $TPL_VAR["joincheck"]["emoney"]?><?php }else{?>0<?php }?>">
				<strong><?php echo get_currency_price($TPL_VAR["joincheck"]["emoney"])?></strong>
<?php }?>
				<?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?> 지급
				</td>
			</tr>
			<tr>
			<th>캐시 유효기간 제한</th>
			<td>				
				<div class="resp_radio ">
					<label><input type="radio" name="reserve_limit_type" value="N" <?php if($TPL_VAR["joincheck"]["reserve_select"]==''){?>checked<?php }?>> 제한 없음</label>
					<label><input type="radio" name="reserve_limit_type" value="Y" <?php if($TPL_VAR["joincheck"]["reserve_select"]=='year'||$TPL_VAR["joincheck"]["reserve_select"]=='direct'){?>checked<?php }?>/> 제한</label>				
				</div>				
			</td>
		</tr>

		<tr class="reserve_limit_type_Y hide">
			<th>유효 기간 설정 <span class="required_chk"></span></th>
			<td>					
				<div class="resp_radio">
					<label>
						<input type="radio" name="reserve_select" value="year" <?php if($TPL_VAR["joincheck"]["reserve_select"]==''){?>checked<?php }?>>
						지급 년도 +
						<select name="reserve_year" id="reserve_year" class="sp_disabled">
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
						년 말일까지
					</label>

					<label>
						<input type="radio" name="reserve_select" value="direct" <?php if($TPL_VAR["joincheck"]["reserve_select"]=='year'||$TPL_VAR["joincheck"]["reserve_select"]=='direct'){?>checked<?php }?>/> 
						<input type="text" name="reserve_direct" class="resp_text onlynumber sp_disabled" size="3" value="<?php echo $TPL_VAR["joincheck"]["reserve_direct"]?>"/> 개월
					</label>
				</div>
			</td>
		</tr>
<?php if($TPL_VAR["isplusfreenot"]&&$TPL_VAR["isplusfreenot"]["ispoint"]){?>
		<tr <?php if($TPL_VAR["joincheck"]["point"]=='0'&&$TPL_VAR["joincheck"]["status"]=='진행완료'){?>class="hide"<?php }?>>
			<th>추가 혜택</th>
			<td>			
				<div class="resp_checkbox">
<?php if(!$TPL_VAR["joincheck"]["joincheck_seq"]||$TPL_VAR["joincheck"]["status"]=='진행 전'){?>
					<label><input type="checkbox" name="add_benefits" <?php if($TPL_VAR["joincheck"]["point"]> 0){?>checked<?php }?>/> 포인트 추가 적립</label>
<?php }else{?>					
<?php if($TPL_VAR["joincheck"]["point"]> 0){?> 포인트 추가 적립<?php }else{?>혜택없음<?php }?>
<?php }?>
				</div>

				<table class="table_basic thl mt5 add_benefits_contents <?php if(!$TPL_VAR["joincheck"]["point"]||$TPL_VAR["joincheck"]["point"]== 0){?>hide<?php }?> " <?php if(!$TPL_VAR["isplusfreenot"]||!$TPL_VAR["isplusfreenot"]["ispoint"]){?> readonly="readonly" disabled='disabled'  <?php }?> >	
					<tr>
						<th>지급 포인트 <span class="required_chk"></span></th>
						<td>
							달성 조건 충족 시
<?php if(!$TPL_VAR["joincheck"]["joincheck_seq"]||$TPL_VAR["joincheck"]["status"]=='진행 전'){?>
							<input type="text" name="point" size="8" id="point" class="resp_text right" value="<?php if($TPL_VAR["joincheck"]["point"]){?><?php echo get_currency_price($TPL_VAR["joincheck"]["point"], 1)?><?php }else{?>0<?php }?>"/>
<?php }else{?>
							<strong><?php echo get_currency_price($TPL_VAR["joincheck"]["point"], 1)?></strong>
							<input type="hidden" name="point" size="8" id="point" class="resp_text right" value="<?php if($TPL_VAR["joincheck"]["point"]){?><?php echo get_currency_price($TPL_VAR["joincheck"]["point"], 1)?><?php }else{?>0<?php }?>"/>
<?php }?>
							p 지급
						</td>
					</tr>

					<tr>
						<th>포인트 유효기간 제한</th>
						<td>							
<?php if(!$TPL_VAR["joincheck"]["joincheck_seq"]||$TPL_VAR["joincheck"]["status"]=='진행 전'){?>						
							<div class="resp_radio">
								<label><input type="radio" name="point_limit_type" value="N" <?php if($TPL_VAR["joincheck"]["point_select"]==''){?>checked<?php }?>/> 제한 없음</label>
								<label><input type="radio" name="point_limit_type" value="Y" <?php if($TPL_VAR["joincheck"]["point_select"]=='year'||$TPL_VAR["joincheck"]["point_select"]=='direct'){?>checked <?php }?>/> 제한</label>
							</div>
<?php }else{?>
<?php if($TPL_VAR["joincheck"]["point_select"]==''){?>제한 없음<?php }else{?>제한
							<input type="hidden" name="point_limit_type" value="Y" <?php if($TPL_VAR["joincheck"]["point_select"]!=''){?>checked<?php }?>/><?php }?>	
<?php }?>
						</td>
					</tr>						

					<tr class="point_limit_type_Y hide">
						<th>유효 기간 설정 <span class="required_chk"></span></th>
						<td>
<?php if(!$TPL_VAR["joincheck"]["joincheck_seq"]||$TPL_VAR["joincheck"]["status"]=='진행 전'){?>
							<div class="resp_radio">
								<label>
									<input type="radio" name="point_select" value="year" <?php if($TPL_VAR["joincheck"]["point_select"]==''){?>checked<?php }?>>
									지급 년도 +
									<select name="point_year" id="point_year" class="sp_disabled">
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
									년 말일까지
								</label>

								<label>
									<input type="radio" name="point_select" value="direct" <?php if($TPL_VAR["joincheck"]["point_select"]=='year'||$TPL_VAR["joincheck"]["point_select"]=='direct'){?>checked<?php }?>/> 
									<input type="text" name="point_direct" class="resp_text onlynumber sp_disabled" size="3" value="<?php echo $TPL_VAR["joincheck"]["point_direct"]?>"/> 개월
								</label>
							</div>
<?php }else{?>
<?php if($TPL_VAR["joincheck"]["point_select"]=='year'){?>
								지급 년도 + <strong><?php echo $TPL_VAR["joincheck"]["point_year"]?></strong> 년 말일까지
<?php }else{?>
								<strong><?php echo $TPL_VAR["joincheck"]["point_direct"]?></strong>개월 까지
<?php }?>	
<?php }?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
<?php }?>		
	</table>

<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
	
	<div class="table_group">
	<div class="item-title">
		전체 이벤트 페이지
		<span class="tooltip_btn" onClick="showTooltip(this, '/admin/tooltip/promotion_coupon', '#tip2')"></span>
	</div>

	<table class="table_basic thl">		
			<tr>
			<th>이벤트 노출 여부</th>
			<td>
				<div class="resp_radio">
					<label><input type="radio" name="joincheck_view" value="Y" <?php if($TPL_VAR["joincheck"]["joincheck_view"]==''||$TPL_VAR["joincheck"]["joincheck_view"]=='Y'){?>checked<?php }?> > 노출</label>
					<label><input type="radio" name="joincheck_view" value="N" <?php if($TPL_VAR["joincheck"]["joincheck_view"]=='N'){?>checked<?php }?> > 미노출</label>
				</div>
				</td>
			</tr>
		</table>

		<table class="table_basic thl joincheck_view_Y hide">		
			<tr>
			<th>이벤트 썸네일 설정</th>
				<td>
					<div class="webftpFormItem">
						<label class="resp_btn v2"><input type="file" class="ajaxImageFormInput"/>파일 선택</label>			
						<input type="hidden" class="real_path" name="joincheck_banner" value="" />
						<div class="preview_image"></div>
					</div>
				</td>
			</tr>

			<tr>
				<th>타이틀</th>
				<td>
					<div class="resp_limit_text limitTextEvent">
						<input type="text" name="joincheck_introduce" size="50"  maxlength="30" value="<?php echo $TPL_VAR["joincheck"]["joincheck_introduce"]?>" />
					</div>
					<input type="text" name="joincheck_introduce_color" value="<?php if($TPL_VAR["joincheck"]["joincheck_introduce_color"]){?><?php echo $TPL_VAR["joincheck"]["joincheck_introduce_color"]?><?php }else{?>#333333<?php }?>" class="colorpicker"/>
				</td>
			</tr>

			<tr>
				<th>썸네일 링크 연결</th>
				<td>이벤트 페이지</td>
			</tr>
		</table>
	</div>
<?php }?>	

	<div class="item-title">출석 체크 화면</div>

	<table class="table_basic thl">		
		<tr >
			<th>캘린더 디자인</th>
			<td class="ck_type_comment hide">

<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>											
				Basic 형
				<input type="button" class="resp_btn" onclick="jc_view_btn('/admin/skin/default/images/joincheck_comment.jpg','1000','433')" value="미리보기">
				<input type="hidden" name="chc_skin" value="comment_basic"/>
<?php }else{?>
				<div class="resp_radio">
					<label>									
						<input type="radio" name="chc_skin" id="comment_basic" value="comment_basic" <?php if($TPL_VAR["joincheck"]["skin"]=='comment_basic'||!$TPL_VAR["joincheck"]["skin"]){?>checked <?php }else{?>  <?php }?> />						
						Basic 형
					</label>
					<input type="button" class="resp_btn" onclick="jc_view_btn('/data/joincheck/skin/comment_basic.jpg','670','690')" value="미리보기">
					
					<label>
						<input type="radio" name="chc_skin" id="comment_simple" value="comment_simple" <?php if($TPL_VAR["joincheck"]["skin"]=='comment_simple'){?>checked <?php }else{?>  <?php }?> />
						Simple 
					</label>
					<input type="button" class="resp_btn" onclick="jc_view_btn('/data/joincheck/skin/comment_simple.jpg','670','690')" value="미리보기">					
				</div>		
<?php }?>									
							</td>

			<td class="ck_type_stamp ck_type_login hide">
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>				
				Basic 형				
				<input type="button" class="resp_btn" onclick="jc_view_btn('/admin/skin/default/images/joincheck_stamp.jpg','1000','516')" value="미리보기">		
				<input type="hidden" name="ch_skin" value="stamp_basic"  />
<?php }else{?>
				<div class="resp_radio">
					<label>										
						<input type="radio" name="ch_skin" id="stamp_basic" value="stamp_basic" <?php if($TPL_VAR["joincheck"]["skin"]=='stamp_basic'||!$TPL_VAR["joincheck"]["skin"]){?> checked <?php }else{?>  <?php }?> />
						Basic 형
					</label>
					<input type="button" class="resp_btn"  onclick="jc_view_btn('/data/joincheck/skin/stamp_basic.jpg','540','660')" value="미리보기">					
					
					<label>
						<input type="radio" name="ch_skin" id="stamp_simple" value="stamp_simple" <?php if($TPL_VAR["joincheck"]["skin"]=='stamp_simple'){?> checked <?php }else{?>  <?php }?> />
						Simple 
					</label>
					<input type="button" class="resp_btn" onclick="jc_view_btn('/data/joincheck/skin/stamp_simple.jpg','540','660')" value="미리보기">					
				</div>	
<?php }?>
			</td>
		</tr>

		<tr class="ck_type_stamp ck_type_login">
			<th>출석 체크 도장</th>
			<td>
				<div class="resp_radio">					
					<label>
						<input type="radio" name="stamp_skin" id="basic" value="basic" <?php if($TPL_VAR["joincheck"]["stamp_skin"]=='basic'||!$TPL_VAR["joincheck"]["stamp_skin"]){?> checked <?php }else{?>  <?php }?> /> Basic 형
						<span class="stamp_img">
							<img src="/data/joincheck/stamp/stamp_basic_attend.gif" name="basic" >
							<img src="/data/joincheck/stamp/stamp_basic_absent.gif" name="basic" >
						</span>
					</label>
					
					
					<label>
						<input type="radio" name="stamp_skin" id="simple" value="simple" <?php if($TPL_VAR["joincheck"]["stamp_skin"]=='simple'){?> checked <?php }else{?>  <?php }?> /> 
						Simple 형
						<span class="stamp_img">
							<img src="/data/joincheck/stamp/stamp_simple_attend.gif" name="basic" >
							<img src="/data/joincheck/stamp/stamp_simple_absent.gif" name="basic" >
						</span>	
					</label>								
				</div>				
			</td>
		</tr>

		<tr class="ck_type_comment hide">
			<th>댓글 노출 수</th>
			<td>
				한 페이지당
				 <select  class="resp_select" name="com_list"  id="display_quantity">
					<option id="dp_qty10" value="1" <?php if($TPL_VAR["joincheck"]["comment_list"]== 1){?> selected<?php }?> >1개</option>
					<option id="dp_qty50" value="3" <?php if($TPL_VAR["joincheck"]["comment_list"]== 3){?> selected<?php }?> >3개</option>
					<option id="dp_qty100" value="5" <?php if($TPL_VAR["joincheck"]["comment_list"]== 5){?> selected<?php }?> <?php if(!$TPL_VAR["joincheck"]["comment_list"]){?> selected <?php }?> >5개</option>
					<option id="dp_qty200" value="10" <?php if($TPL_VAR["joincheck"]["comment_list"]== 10){?> selected<?php }?>>10개</option>
					<option id="dp_qty200" value="20" <?php if($TPL_VAR["joincheck"]["comment_list"]== 20){?> selected<?php }?> >20개</option>
				</select>
				 노출 				
			</td>
		</tr>
	</table>

	<div class="item-title">출석 체크 메시지</div>

	<table class="table_basic thl">		
		<tr>
			<th>출석 체크 시</th>
			<td>
				<div class="resp_limit_text limitTextEvent">
					<input type="text" name="check_it" id="check_it"  class="resp_text" size="150" maxlength="100" <?php if($TPL_VAR["joincheck"]["check_it"]){?> value="<?php echo $TPL_VAR["joincheck"]["check_it"]?>" <?php }else{?>  value="감사합니다! 출석 체크를 하셨습니다. 내일 또 부탁드립니다."<?php }?> title="" />
				</div>
			</td>
		</tr>	
		<tr>
			<th>이미 출석체크 한 경우</th>
			<td>
				<div class="resp_limit_text limitTextEvent">
					<input type="text" name="check_already" id="check_already" class="resp_text" size="150" maxlength="100" <?php if($TPL_VAR["joincheck"]["check_already"]){?> value="<?php echo $TPL_VAR["joincheck"]["check_already"]?>" <?php }else{?>  value="오늘 이미 하셨습니다. 내일 참여 부탁드립니다."<?php }?> title="" />
				</div>
			</td>
		</tr>	
		<tr>
			<th>출석 체크 달성 시</th>
			<td class="clear">
				<ul class="ul_list_02">
					<li>
						<div class="resp_limit_text limitTextEvent">
							<input type="text" name="check_complete" id="check_complete" class="resp_text" maxlength="200" size="150" <?php if($TPL_VAR["joincheck"]["check_complete"]){?> value="<?php echo $TPL_VAR["joincheck"]["check_complete"]?>" <?php }else{?> value="[<?php echo $TPL_VAR["joincheck"]["shopName"]?>]출석체크 이벤트에 참여해 주셔서 감사합니다. 캐시{emoney}<?php echo $TPL_VAR["basic_currency_info"]['currency_symbol']?>, 포인트 {point}P을 지급해 드렸습니다." <?php }?> title="" />
						</div>
					</li>
					<li>
						<div class="resp_checkbox">
							<label>
							<input type="checkbox" name="check_SMS_yn" value="Y" <?php if($TPL_VAR["joincheck"]["check_SMS_yn"]=='Y'){?>checked<?php }?> /> 출석 체크 달성 시 문자 발송
							</label>
						</div><br>
						<div class="resp_limit_text limitTextByteEvent">
							<input type="text" name="check_SMS" id="check_SMS" class="resp_text" maxlength="100" size="150" maxByte="80"  value="<?php if($TPL_VAR["joincheck"]["check_SMS"]){?><?php echo $TPL_VAR["joincheck"]["check_SMS"]?><?php }else{?>[<?php echo $TPL_VAR["joincheck"]["shopName"]?>]출석체크 이벤트 혜택 지급. MY페이지 확인요망<?php }?>" />						
						</div>
					</li>
				</ul>
			</td>
		</tr>	
	</table>	
</div>
<!-- 서브메뉴 바디 : 끝-->
<!--### 필수옵션 미리보기 -->
<div id="popPreviewOpt" class="hide"></div>
</form>

<div style="height:15px"></div>

<div id="popup_condition_div"></div>
<div id="image-preview-wrap" class="hide">
	<a href="#" class="preview-del"></a>
	<input class="preview-data" type="hidden" name="image_path" value=""/>
	<div class="preview-img"><a href="" target="_blank"><img src=""/></a></div>
</div>


<?php $this->print_("layout_footer",$TPL_SCP,1);?>