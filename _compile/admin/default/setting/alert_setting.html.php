<?php /* Template_ 2.2.6 2022/05/17 12:36:54 /www/music_brother_firstmall_kr/admin/skin/default/setting/alert_setting.html 000008775 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
	code_flag = false;

	$(function(){
<?php if($_GET["no"]){?>
		classCont('<?php echo $_GET["no"]?>');
<?php }else{?>
		classCont('1');
<?php }?>

		$('#alert_reset').click(function(){
			$('#result').html('');
		});
		$('#alert_submit').click(function(){
			$('.update_form').each(function(){
				$.ajax({
					url: "/admin/setting_process/set_alert",
					type: "post",
					data : $(this).serialize(),
					success : function(e){
					}
				});
			});
			openDialogAlert("설정이 저장되었습니다.",'400','160',function(){location.reload()});
		});
	});

	var add_alert = function(){
		$('#result').html('');
		openDialog("메시지 추가하기", "insert_popup", {"width":"900","height":"410","show" : "fade","hide" : "fade"});
	};

	function formMove(gb, no){
		classCont(no);
		$("form[name='alert_form'] input[name='gb']").val(gb);
		$("form[name='alert_form'] input[name='no']").val(no);
		$("form[name='alert_form']").attr('action','../setting/alert_setting');
		$("form[name='alert_form']").submit();
	}

	function classCont(no){		
		$(".tabEvent > li > a").removeClass("current");
		$(".tabEvent > li").eq(no-1).find("a").addClass("current");		
	}

</script>
<style type="text/css">
	.lang {position:relative}
	.lang li{margin-top:5px;};
	.lang li:first-child{margin-top:0px;}
	.lang input{width:88%;position:absolute;right:20px}
	.lang .bak_lang{border:0;}
	.info-table-style .its-th-align {padding:0 !important; border-bottom:0 !important; line-height:280%;}
	.table_basic.v5{margin-top:-1px;}
</style>

<div id="lang_wrap">
	<!-- 페이지 타이틀 바 : 시작 -->
	<div id="page-title-bar-area">
		<div id="page-title-bar">			
<?php $this->print_("require_info",$TPL_SCP,1);?>


			<!-- 타이틀 -->
			<div class="page-title">
				<h2>안내 메세지</h2>
			</div>

			<!-- 우측 버튼 -->
			<div class="page-buttons-right">
<?php if($_SERVER["REMOTE_ADDR"]=='61.35.204.100'||$_SERVER["REMOTE_ADDR"]=='106.246.242.226'){?>
				<!--<li><span class="btn large cyanblue"><button type="button" onclick="add_alert();">추가하기<span class="arrowright"></span></button></span></li>-->
<?php }?>
				<button class="resp_btn active2 size_L" type="button" id="alert_submit">저장</button>
			</div>

		</div>
	</div>
	<!-- 페이지 타이틀 바 : 끝 -->

	<!-- 서브 레이아웃 영역 : 시작 -->
	<div class="contents_container">
		<!-- 서브메뉴 바디 : 시작-->			
		<div class="contents_dvs">
			<!-- 상단 단계 링크 : 시작 -->
			<ul class="tab_01 v2 tabEvent">
				<li><a href="javascript:void(0);" onclick="formMove('gv',1);">상품상세</a></li>
				<li><a href="javascript:void(0);" onclick="formMove('mp',2);">마이페이지</a></li>
				<li><a href="javascript:void(0);" onclick="formMove('oc',3);">장바구니</a></li>
				<li><a href="javascript:void(0);" onclick="formMove('os',4);">주문/결제</a></li>
				<li><a href="javascript:void(0);" onclick="formMove('mo',5);">주문내역</a></li>
				<li><a href="javascript:void(0);" onclick="formMove('mb',6);">회원</a></li>
				<li><a href="javascript:void(0);" onclick="formMove('dv',7);">배송</a></li>
				<li><a href="javascript:void(0);" onclick="formMove('et',8);">기타</a></li>
			</ul>							
			<!-- 상단 단계 링크 : 끝 -->			
			<table width="100%" class="table_basic" style="border-top:1px solid #ccc;">
			<colgroup>
				<col width="18%" /><col width="18%" /><col width="64%" /><col/>
			</colgroup>			
			<tr>
				<th>구분</th>
				<th>설명</th>
				<th>안내 메세지 언어별 설정</th>
			</tr>			
			</table>
<?php if($TPL_VAR["loop"]){?>
<?php if($TPL_loop_1){$TPL_I1=-1;foreach($TPL_VAR["loop"] as $TPL_V1){$TPL_I1++;?>
				<form class="update_form" action="/admin/setting_process/set_alert" method="post" target="actionFrame">
				<table width="100%" class="table_basic v5 <?php echo $TPL_I1?>">
				<colgroup>
					<col width="18%" /><col width="18%" /><col width="64%" /><col/>
				</colgroup>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
				<tr>
					<td>
						<?php echo $TPL_V2["location"]?>

					</td>
					<td>
<?php if($TPL_V2["isTitle"]== 1){?><strong>[제목]</strong><?php }?> <?php echo $TPL_V2["comment"]?>

					</td>
					<td height="110px">
						<ul class="lang lang_<?php echo $TPL_I1?>">
							<li><strong>한국어</strong><input type="text" name="KR[<?php echo $TPL_V2["seq"]?>]" value="<?php echo htmlspecialchars($TPL_V2["KR"])?>" /></li>
							<li><span class="desc">원본</span><input type="text" class="bak_lang" value="<?php echo htmlspecialchars($TPL_V2["KR_ORI"])?>" readonly /></li>
							<li><strong>영&nbsp;&nbsp어</strong><input type="text" name="US[<?php echo $TPL_V2["seq"]?>]" value="<?php echo htmlspecialchars($TPL_V2["US"])?>" /></li>
							<li><span class="desc">원본</span><input type="text" class="bak_lang" value="<?php echo htmlspecialchars($TPL_V2["US_ORI"])?>" readonly /></li>
							<li><strong>중국어</strong><input type="text" name="CN[<?php echo $TPL_V2["seq"]?>]" value="<?php echo htmlspecialchars($TPL_V2["CN"])?>" /></li>
							<li><span class="desc">원본</span><input type="text" class="bak_lang" value="<?php echo htmlspecialchars($TPL_V2["CN_ORI"])?>" readonly /></li>
							<!--<li><strong>일본어</strong><input type="text" name="JP[<?php echo $TPL_V2["seq"]?>]" value="<?php echo htmlspecialchars($TPL_V2["JP"])?>" /></li>
							<li><span class="desc">원본</span><input type="text" class="bak_lang" value="<?php echo htmlspecialchars($TPL_V2["JP_ORI"])?>" readonly /></li>-->
						</ul>
					</td>
				</tr>
<?php }}?>
				</table>
				</form>
<?php }}?>
<?php }?>
			<br style="line-height:10px;" />
			<div class="paging_navigation" style="margin:auto;"><?php echo $TPL_VAR["page"]["html"]?></div>
		</div>
	</div>

	<form name="alert_form" id="alert_form" method="get" action="../setting/alert_setting">
		<input type="hidden" name="gb" />
		<input type="hidden" name="no" />
	</form>

	<div id="insert_popup" class="hide">
		<form id="insert_form" action="/admin/setting_process/insert_alert" method="post" target="actionFrame">
		<table width="100%" class="info-table-style">
		<colgroup>
		<col width="120" /><col/>
		</colgroup>
		<tbody>
		<tr>
			<th class="its-th">구분</th>
			<td class="its-td">
				<select name="location">
					<option value="gv">상품상세</option>
					<option value="mp">마이페이지</option>
					<option value="oc">장바구니</option>
					<option value="os">주문/결제</option>
					<option value="mo">주문내역</option>
					<option value="mb">회원</option>
					<option value="et">기타</option>
				</select>
			</td>
		</tr>
		<tr>
			<th class="its-th">상세설명</th>
			<td class="its-td">
				<input type="text" name="comment" size="80" />
			</td>
		</tr>
		<tr>
			<th class="its-th">제목 여부</th>
			<td class="its-td">
				<select name="isTitle" >
					<option value="0">제목아님</option>
					<option value="1">제목</option>
				</select>
			</td>
		</tr>
		<tr>
			<th class="its-th">메세지 종류</th>
			<td class="its-td">
				 <select name="alert_type">
					<option value="dialog">커스텀 팝업</option>
					<option value="alert">윈도우 팝업</option>
					<option value="confirm">윈도우 컨펌</option>
					<option value="dislog_popup">커스텀 팝업 컨펌</option>
				 </select>
			</td>
		</tr>
		<tr>
			<th class="its-th" height="110px">안내언어 설정</th>
			<td class="its-td">
				 <ul class="lang">
					<li><span>한국어</span><input type="text" name="KR" value="" /></li>
					<li><span>영&nbsp;&nbsp어</span><input type="text" name="US" value="" /></li>
					<li><span>중국어</span><input type="text" name="CN" value="" /></li>
					<li><span>일본어</span><input type="text" name="JP" value="" /></li>
				 </ul>
			</td>
		</tr>
		</tbody>
		</table>
		<div class="center mt10">
		<span class="btn large cyanblue" id="insert_alert"><button type="submit">저장<span class="arrowright"></span></button></span>
		<span class="btn large cyanblue" id="alert_reset"><button type="reset">초기화<span class="arrowright"></span></button></span>
		</div>
		</form>
	</div>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>