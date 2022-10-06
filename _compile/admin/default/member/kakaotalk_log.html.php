<?php /* Template_ 2.2.6 2022/05/30 15:15:23 /www/music_brother_firstmall_kr/admin/skin/default/member/kakaotalk_log.html 000006299 */ 
$TPL_templateList_1=empty($TPL_VAR["templateList"])||!is_array($TPL_VAR["templateList"])?0:count($TPL_VAR["templateList"]);
$TPL_sendList_1=empty($TPL_VAR["sendList"])||!is_array($TPL_VAR["sendList"])?0:count($TPL_VAR["sendList"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>

<style type="text/css">
	.talk_src { width:90%; margin:0 auto; }
	.talk_src_lay { border:solid 1px #d3d3d3; padding:5px 20px; margin-top:10px; }
	.talk_src_tb th { font-weight:bold; height:30px; }
	.talk_log_list { width:90%; margin:0 auto; margin-top:20px; }
	.lh15 { line-height:15px; }
	.footer.search_btn_lay button{width: auto;background-color: white; border: 1px solid gray; height: 30px;}
	.footer.search_btn_lay button span{color: #959595;}
	/*.resp_btn.active{color: #3090d6; border: 1px solid rgb(48, 144, 214) !important;}*/
	.search_btn_lay .sc_edit{position: relative;}
	.search_btn_lay .detail, .search_btn_lay .default{position: relative;}
	.resp_btn.size_XL{line-height: inherit;}
	.contents_container{width: 1400px; margin: auto;}
	.table_search{width: 1400px !important;}
	.footer.search_btn_lay{top: auto; left: calc(50% - 50px) !important;}
</style>
<script type="text/javascript">
	$(document).ready(function() {

		gSearchForm.init({'pageid':'kakaotalk_log','search_mode':'<?php echo $TPL_VAR["sc"]["search_mode"]?>','select_date':'<?php echo $TPL_VAR["sc"]["select_date"]?>'});

		$('#kakaotalk_charge').on('click', function (){
			$.get('kakaotalk_payment', function(data) {
				$('#kakaotalkPopup').html(data);
				openDialog("SMS/카카오 알림톡 충전 <span class='desc'>&nbsp;</span>", "kakaotalkPopup", {"width":"1200","height":"800"});
			});
		});		
	});

	// 발송 로그 상세
	function detail_pop(uid, date){
		$.ajax({
			type		: 'post',
			url			: 'kakaotalk_log_detail',
			dataType	: 'html',
			data		: {	'uid' : uid, 'date' : date },
			success: function(html){
				$("#sendLogPopup").html(html);
				openDialog("알림톡 발송결과 상세 <span class='desc'>&nbsp;</span>", "sendLogPopup", {"width":"600","height":"600"});
			}
		});
	}
</script>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2>카카오 알림톡</h2>
		</div>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">
	
<?php $this->print_("top_menu",$TPL_SCP,1);?>


	<div id="search_container" class="search_container">
		<form action="./kakaotalk_log" class='search_form' >
		<input type="hidden" name="searchcount" value="<?php echo $TPL_VAR["searchcount"]?>">
		<table class="table_search">
			<tr>
				<th>기간</th>
				<td>
					<input type="text" name="s_date" value="<?php echo $TPL_VAR["sc"]["s_date"]?>" class="datepicker" maxlength="10" />
					~
					<input type="text" name="e_date" value="<?php echo $TPL_VAR["sc"]["e_date"]?>" class="datepicker" maxlength="10" />
				</td>
			</tr>

			<tr>
				<th>전송 결과</th>
				<td>
					<select name="status_yn" class="wx110">
						<option value="">전체</option>
						<option value="Y" <?php if($TPL_VAR["sc"]["status_yn"]=='Y'){?>selected<?php }?>>성공</option>
						<option value="N" <?php if($TPL_VAR["sc"]["status_yn"]=='N'){?>selected<?php }?>>실패</option>
					</select>
				</td>
			</tr>

			<tr>
				<th>발송 상황</th>
				<td>
					<select name="kkoBizCode" class="wx110">
						<option value="">전체</option>
<?php if($TPL_VAR["templateList"]){?>
<?php if($TPL_templateList_1){foreach($TPL_VAR["templateList"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["kkoBizCode"]?>" <?php if($TPL_VAR["sc"]["kkoBizCode"]==$TPL_V1["kkoBizCode"]){?>selected<?php }?>><?php echo $TPL_V1["msg_txt"]?></option>
<?php }}?>
<?php }?>
					</select>
				</td>
			</tr>

			<tr>
				<th>수신 번호</th>
				<td>
					<input type="text" name="mobile" value="<?php echo $TPL_VAR["sc"]["mobile"]?>" size="40" />
					<span class="gray">(- 제외)</span>
				</td>
			</tr>
		</table>

		<div class="footer search_btn_lay"></div>
		</form>
	</div>
<!-- 서브 레이아웃 영역 : 시작 -->
<!-- 알림톡 리스트 영역 -->
	<div class="list_info_container">
		<div class="dvs_left">검색 <b><?php echo $TPL_VAR["total"]?></b>개</div>
		<div class="dvs_right">- 최근 1년 이내의 내역만 조회 가능, 검색 기간 최대 3개월</div>
	</div>
	
	<div class="table_row_frame">	
		<table class="table_row_basic">
			<colgroup>
				<col width="7%" />
				<col width="14%"/>
				<col width="23%"/>
				<col width="14%"/>
				<col width="14%"/>
				<col width="14%"/>
				<col width="14%"/>
			</colgroup>
			<thead>
			<tr>
				<th>번호</th>
				<th>발송 상황</th>	
				<th>발송 내용</th>
				<th>수신 번호</th>				
				<th>전송 결과</th>
				<th>발송 일시</th>
				<th>SMS 대체 발송</th>
			</tr>
			</thead>
			<tbody>
<?php if($TPL_VAR["sendList"]){?>
<?php if($TPL_sendList_1){foreach($TPL_VAR["sendList"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["no"]?></td>			
				<td><?php echo $TPL_VAR["msg_type_arr"][$TPL_V1["msg_code"]]?></td>
				<td class="left"><a onclick="detail_pop('<?php echo $TPL_V1["uid"]?>','<?php echo $TPL_V1["regist_date"]?>');" class="resp_btn_txt v2"><?php echo getstrcut($TPL_V1["message"],'40')?></a></td>
				<td><?php echo $TPL_V1["mobile"]?></td>			
				<td><?php if($TPL_V1["status_yn"]=='Y'){?>성공<?php }else{?>실패<?php }?></td>
				<td><?php echo $TPL_V1["regist_date"]?></td>
				<td><?php echo $TPL_V1["sms_send"]?></td>
			</tr>
<?php }}?>
<?php }else{?>
			<tr>
				<td colspan="7">조회된 결과가 없습니다.</td>
			</tr>
<?php }?>
			</tbody>
			</table>
		</div>
		<!-- 페이징 -->
		<div class="paging_navigation"><?php echo $TPL_VAR["pagin"]?></div>
	
</div>
<!-- 알림톡 발송내역 영역 :: END -->


<!-- 서브 레이아웃 영역 : 끝 -->

<!-- 알림톡 충전 -->
<div id="kakaotalkPopup" class="hide"></div>
<!-- 알림톡 상세 -->
<div id="sendLogPopup" class="hide"></div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>