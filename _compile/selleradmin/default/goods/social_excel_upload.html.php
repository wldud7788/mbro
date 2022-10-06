<?php /* Template_ 2.2.6 2021/08/25 16:21:02 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/social_excel_upload.html 000014645 */ 
$TPL_logs_1=empty($TPL_VAR["logs"])||!is_array($TPL_VAR["logs"])?0:count($TPL_VAR["logs"]);
$TPL_requires_1=empty($TPL_VAR["requires"])||!is_array($TPL_VAR["requires"])?0:count($TPL_VAR["requires"]);
$TPL_options_1=empty($TPL_VAR["options"])||!is_array($TPL_VAR["options"])?0:count($TPL_VAR["options"]);
$TPL_inputs_1=empty($TPL_VAR["inputs"])||!is_array($TPL_VAR["inputs"])?0:count($TPL_VAR["inputs"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<style type="text/css">
.upload-form	{ margin-bottom:30px;padding-left:35px; }
.upload-form .notice {color:red;margin-top:5px;}
.input-upload {margin-top:10px;}
.
.upload-log {margin-top:40px;width:100%;}
.upload-notice {margin-top:20px;width:100%;}
.excel-upload-table { width:100%;border-top:1px solid #dadada;border-left:1px solid #dadada; }
.excel-upload-table th {border-bottom:1px solid #dadada;border-right:1px solid #dadada; background-color:#f1f1f1;height:28px;line-height:28px;text-align:center;padding:0 5px;} 
.excel-upload-table td {border-bottom:1px solid #dadada;border-right:1px solid #dadada;background-color:#ffffff; height:25px;line-height:25px;text-align:left;padding-left:5px;}
.excel-upload-table td.provider_seltd {background-color:#cee1ff;}
.highlight-text {margin-top:15px;font-weight:bold;color:red;}
.amplify-text {margin-top:-8px;font-weight:normal;}
</style>
<script type="text/javascript">

// 구버전 업로드 폼
function open_old_excel_upload(){
	openDialog("상품일괄등록/수정 <span class='desc'></span>", "export_upload", {"width":"800","height":"500","show" : "fade","hide" : "fade"});
}

// 업로드 폼 submit
function excel_upload(){
	if	(!$("input#goods_excel_file").val()){
		openDialogAlert('업로드할 파일이 없습니다.', 400, 150);
		return false;
	}

	loadingStart();
	$("form#excelUpload").submit();
}

// upload 시 승인여부 선택
function chg_provider_choice(){
	if	($("input[name='provider_choice']").eq(0).attr('checked')){
		$('table.provider_choice').find('tr').eq(1).find('td').addClass('provider_seltd');
		$('table.provider_choice').find('tr').eq(2).find('td').addClass('provider_seltd');
		$('table.provider_choice').find('tr').eq(3).find('td').removeClass('provider_seltd');
		$('table.provider_choice').find('tr').eq(4).find('td').removeClass('provider_seltd');
	}else{
		$('table.provider_choice').find('tr').eq(1).find('td').removeClass('provider_seltd');
		$('table.provider_choice').find('tr').eq(2).find('td').removeClass('provider_seltd');
		$('table.provider_choice').find('tr').eq(3).find('td').addClass('provider_seltd');
		$('table.provider_choice').find('tr').eq(4).find('td').addClass('provider_seltd');
	}
}

// log 파일 다운로드
function download_log_file(obj){
	var f	= $(obj).text();
	if	(!f){
		openDialogAlert('로그파일명이 없습니다.', 400, 150);
		return false;
	}

	actionFrame.location.replace('../goods_process/download_excel_log?f=' + f);
}

// 설명 sample 엑셀 다운로드
function download_sample(){
	window.open('http://interface.firstmall.kr/excel_sample/20170427/couponexcel.seller.sample.xlsx');
}
</script>
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2><span class="icon-goods-kind-goods"></span>일괄 티켓상품등록/수정</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span class="btn large"><button type="button" onclick="location.href='social_catalog';">상품리스트</button></span></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large cyanblue"><button type="button" onclick="download_sample();">설명용 샘플파일 다운로드(티켓-Seller)</button></span></li>
			<li><span class="btn large black"><button type="button" onclick="excel_upload();">업로드</button></span></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->


<div class="upload-form">
	<form name="excelUpload" id="excelUpload" method="post" action="/cli/excel_up/create_goods" enctype="multipart/form-data"  target="actionFrame">
	<input type="hidden" name="goods_kind" value="<?php echo $TPL_VAR["kind"]?>" />
	<div class="item-title">.xlsx 형식으로 저장된 파일 업로드 → 티켓상품 일괄 등록/수정 </div>
	<div class="seller-goods-status-lay">
		<table class="excel-upload-table provider_choice" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th>실행타입</th>
			<th>구분</th>
			<th>승인여부(1개 열)</th>
			<th>상태(1개 열)</th>
			<th>노출(1개 열)</th>
			<th>상품명(1개 열)</th>
			<th>옵션(<?php echo count($TPL_VAR["options"])?>개 열)</th>
			<th>가격대체(3개 열)</th>
			<th>기타 모든 정보</th>
		</tr>
		<tr>
			<td class="provider_seltd" rowspan="2">
				<label><input type="radio" name="provider_choice" value="N" onclick="chg_provider_choice();" checked /> Type1</label>
			</td>
			<td class="provider_seltd">신규등록</td>
			<td class="provider_seltd">미승인</td>
			<td class="provider_seltd">판매중지</td>
			<td class="provider_seltd">미노출</td>
			<td class="provider_seltd">Insert YES</td>
			<td class="provider_seltd">Insert YES</td>
			<td class="provider_seltd">Insert YES</td>
			<td class="provider_seltd">Insert YES</td>
		</tr>
		<tr>
			<td class="provider_seltd">상품수정</td>
			<td class="provider_seltd red">기존 승인여부 유지</td>
			<td class="provider_seltd red">입력된 상태명<br/>※ 미입력 시 : 판매중지</td>
			<td class="provider_seltd red">입력된 노출여부<br/>※ 미입력 시 : 미노출</td>
			<td class="provider_seltd red">Update NO</td>
			<td class="provider_seltd red">Update NO</td>
			<td class="provider_seltd red">Update NO</td>
			<td class="provider_seltd">Update YES</td>
		</tr>
		<tr>
			<td rowspan="2">
				<label><input type="radio" name="provider_choice" value="Y" onclick="chg_provider_choice();" /> Type2</label>
			</td>
			<td>신규등록</td>
			<td>미승인</td>
			<td>판매중지</td>
			<td>미노출</td>
			<td>Insert YES</td>
			<td>Insert YES</td>
			<td>Insert YES</td>
			<td>Insert YES</td>
		</tr>
		<tr>
			<td>상품수정</td>
			<td class="red">미승인</td>
			<td class="red">판매중지</td>
			<td class="red">미노출</td>
			<td class="red">Update YES</td>
			<td class="red">Update YES</td>
			<td class="red">Update YES</td>
			<td>Update YES</td>
		</tr>
		</table>
	</div>
	<div class="notice" style="color:#000;">
		<div>실행타입 Type1 : 상품수정 시 상품명(1개 열), 옵션(<?php echo count($TPL_VAR["options"])?>개 열), 
							가격대체(3개 열)의 
							총 <?php echo (count($TPL_VAR["options"])+ 4)?>개 열의 정보가 
							업데이트되지 않습니다.</div>
		<div style="margin-left:180px;">단, 승인여부가 유지되고 상태 및 노출, 기타 모든 정보를 업데이트 할 수 있습니다.</div>
	</div>
	<div class="notice" style="color:#000;">
		<div>실행타입 Type2 : 상품수정 시 상품명(1개 열), 옵션(<?php echo count($TPL_VAR["options"])?>개 열), 
							가격대체(3개 열)의 
							총 <?php echo (count($TPL_VAR["options"])+ 4)?>개 열의 정보 및 
							기타 모든 정보를 업데이트할 수 있습니다.</div>
		<div style="margin-left:180px;">단, 승인여부는 미승인, 상태는 판매중지, 노출은 미노출로 업데이트 됩니다.</div>
	</div>

	<div class="input-upload"><input type="file" name="goods_excel_file" id="goods_excel_file" style="height:20px;" /></div>

	<div class="notice">[주의] 엑셀 파일 저장 시 <b>＇Excel 통합 문서‘ (.xlsx)</b> 를 선택해주세요. ‘xlsx’ 형식만 업로드가 가능합니다.</div>
</div>

<div class="upload-log">
	<div class="item-title">처리 로그 (최근 10개)</div>

	<table class="excel-upload-table" cellpadding="0" cellspacing="0" border="0">
	<colgroup>
		<col width="150" />
		<col width="100" />
		<col />
		<col />
		<col />
	</colgroup>
	<thead>
	<tr>
		<th>처리 일시</th>
		<th>아이피</th>
		<th>처리자</th>
		<th>실행 타입</th>
		<th>업로드 파일</th>
		<th>실패 로그</th>
		<th>성공 로그</th>
	</tr>
	</thead>
	<tbody>
<?php if($TPL_logs_1){foreach($TPL_VAR["logs"] as $TPL_V1){?>
	<tr>
		<td><?php echo $TPL_V1["upload_date"]?></td>
		<td><?php echo $TPL_V1["uploader_ip"]?></td>
		<td><?php echo $TPL_V1["uploader"]?></td>
		<td><?php echo $TPL_V1["seller_upload_type"]?></td>
		<td><?php echo $TPL_V1["upload_filename"]?></td>
		<td class="hand" onclick="download_log_file(this);"><?php echo $TPL_V1["result_failed"]?></td>
		<td class="hand" onclick="download_log_file(this);"><?php echo $TPL_V1["result_success"]?></td>
	</tr>
<?php }}else{?>
	<tr>
		<td colspan="6" style="text-align:center;">처리 로그가 없습니다.</td>
	</tr>
<?php }?>
	</tbody>
	</table>
</div>

<div class="upload-notice">
	<div class="item-title red">
		업로드 주의사항!  반드시 정독하시고 숙지해 주세요.
		<span class="btn small cyanblue"><button type="button" onclick="download_sample();">설명용 샘플파일 다운로드(티켓-Seller)</button></span>
	</div>

	<table class="excel-upload-table" cellpadding="0" cellspacing="0" border="0">
	<colgroup>
		<col />
	</colgroup>
	<tbody>
	<tr>
		<td>
			<div>1. 업로드 파일의 각각의 열 이름이 = 다운로드 파일의 각각의 열 이름과 동일해야 함 (다운로드 후 열 이름을 변경하지 마세요)</div>
			<br style="line-height:20px;" />

			<div>2. 업로드 파일에 반드시 있어야 하는 필수 열 <span class="red"><?php echo count($TPL_VAR["requires"])?></span>개</div>
			<div>- 필수 열 : <?php if($TPL_requires_1){$TPL_I1=-1;foreach($TPL_VAR["requires"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?>, <?php }?><?php echo $TPL_V1?><?php }}?></div>
			<br style="line-height:20px;" />

			<div>3. 업로드 파일로 보기만 가능한 열 <span class="red">2</span>개</div>
			<div>- 보기 열 : 승인여부, 수수료</div>
			<br style="line-height:20px;" />

			<div>4. 업로드 파일로 옵션 정보를 수정하고자 할 때 조건 (옵션 정보를 수정할 필요가 없으면 <?php echo count($TPL_VAR["options"])?>개 열을 모두 없애십시오)</div>
			<div>- 조건1) 아래의 <span class="red"><?php echo count($TPL_VAR["options"])?></span>개 열이 SET로 반드시 있어야 함</div>
			<div style="margin-left:13px;font-size:11px;"><?php if($TPL_options_1){$TPL_I1=-1;foreach($TPL_VAR["options"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?>, <?php }?><?php echo $TPL_V1?><?php }}?></div>
			<div>- 조건2)</div>
			<div style="margin-left:13px;">필수옵션이 있는 상품 : 필수옵션명이 있는 모든 필수옵션값의 행 수 = 재고의 행 수 = 수수료의 행 수 = 매입가의 행 수 = 정가의 행 수 = 할인가(판매가)의 행 수 = 마일리지의 행 수</div>
			<div style="margin-left:13px;">필수옵션이 없는 상품 : 재고 1행 = 수수료 1행 = 매입가 1행 = 정가 1행 = 할인가(판매가) 1행 = 마일리지 1행</div>
			<br style="line-height:20px;" />

			<div>5. 업로드 파일로 추가입력옵션 정보를 수정하고자 할 때 조건 (추가입력옵션 정보를 수정할 필요가 없으면 <?php echo count($TPL_VAR["inputs"])?>개의 열을 모두 없애십시오)</div>
			<div>- 조건1) 아래의 <span class="red"><?php echo count($TPL_VAR["inputs"])?></span>개 열이 SET로 반드시 있어야 함</div>
			<div style="margin-left:13px;"><?php if($TPL_inputs_1){$TPL_I1=-1;foreach($TPL_VAR["inputs"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?>, <?php }?><?php echo $TPL_V1?><?php }}?></div>
			<div>- 조건2)</div>
			<div style="margin-left:13px;">추가입력옵션명의 행 수 = 추가입력옵션형식의 행 수</div>
			<br style="line-height:20px;" />
		</td>
	</tr>
	</tbody>
	</table>
</div>


<div id="export_upload" class="hide">
<form name="excelRegist" id="excelRegist" method="post" action="../goods_process/excel_upload" enctype="multipart/form-data"  target="actionFrame">

	<div class="clearbox"></div>
	<div class="item-title">(구) 상품 일괄 등록 및 수정</div>
	<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="20%" />
		<col width="80%" />
	</colgroup>
	<tr>
		<th class="its-th-align center">일괄수정</th>
		<td class="its-td">
			<input type="file" name="excel_file" id="excel_file" style="height:20px;"/>
		</td>
	</tr>
	</table>

	<div style="width:100%;text-align:center;padding-top:10px;">
	<span class="btn large cyanblue"><button id="upload_submit">확인</button></span>
	</div>

	<div style="padding:15px;"></div>

	<div style="padding-left:10px;font-size:12px;">
		* 상품을 일괄 등록하거나 수정할 때 엑셀 양식을  먼저 다운로드 받은 후에 이용하면 됩니다.<br/>
		&nbsp;&nbsp; ( <span style="color:red;">필독! 엑셀파일 저장시 확장자가 XLS 인 엑셀 97~2003 양식으로 저장해 주세요</span> ) <br/>
		<div style="padding:3px;"></div>
		* 일괄 등록과 수정의 구분은 고유값 필드에 있는 값의 유무로 판단합니다.(고유값 필드에 값이 있으면 수정, 없으면 등록입니다.)<br/>
		<div style="padding:3px;"></div>
		* 상품 옵션은 옵션마다 1개의 행을 차지합니다.(옵션을 등록한 이후에 엑셀을 다운로드 받아서 보면 이해하기 편합니다.)<br/>
		<div style="padding:3px;"></div>
		* 옵션 항목에는 옵션값만 입력해야 하며 상품 공통 정보를 입력하면 안됩니다. 상품 공통 정보 항목도 옵션값을 입력하면 안됩니다. <br/>
		<div style="padding:3px;"></div>
		* 대표카테고리와 추가카테고리가 병합되었습니다. 맨마지막 카테고리번호가 대표카테고리로 등록됩니다.<br/>
		<div style="padding:3px;"></div>
		* 대표브랜드와 추가브랜드가 병합되었습니다. 맨마지막 브랜드번호가 대표브랜드로 등록됩니다.<br/>
	</div>

	<div style="padding:15px;"></div>


</form>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>