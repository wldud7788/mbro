<?php /* Template_ 2.2.6 2022/05/17 12:29:09 /www/music_brother_firstmall_kr/selleradmin/skin/default/goods/excel_form.html 000006263 */ 
$TPL_sorted_column_1=empty($TPL_VAR["sorted_column"])||!is_array($TPL_VAR["sorted_column"])?0:count($TPL_VAR["sorted_column"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<style type="text/css">
.excel-form-lay {padding-left:20px;}
.excel-form-lay .excel-form-cell {position:relative;margin-top:20px;margin-left:20px;width:30%;display:inline-block;vertical-align:top;}
.excel-form-table {border-left:1px solid #464646;border-top:1px solid #464646;}
.excel-form-table tr td {text-align:center;border-right:1px solid #464646;border-bottom:1px solid #464646;}
.excel-form-table tr td.checked-cell {background-color:#fffed9 !important;}
.excel-form-table tr td:last-child {padding:5px;text-align:left;}
.excel-form-table tr:nth-child(odd) td {background-color:#f5f5f5;}
.excel-form-table tr:nth-child(even) td {background-color:#d8d8d8;}
</style>
<script type="text/javascript">
$(document).ready(function(){

	// 전체 체크 상태 변경
	$('input.all_chk').bind('click', function(){
		var status	= ($(this).attr('checked') == 'checked') ? true : false;
		$(this).closest('div.excel-form-cell').find("input[name='chk_cell[]']").each(function(){
			chk_cell(this, status);
		});
	});

	// 체크 상태 변경에 따른 변경
	$("input[name='chk_cell[]']").bind('click', function(){
		var status	= ($(this).attr('checked') == 'checked') ? true : false;
		chk_cell(this, status);
	});

	// 항목 순서 변경 기능 on
	$("table.excel-form-table").sortable({items:'tr'});

<?php if($TPL_VAR["seq"]> 0){?>
	// 초기 체크에 따른 색상 변경
	$("input[name='chk_cell[]']").each(function(){
		if	($(this).attr('checked') == 'checked')	chk_cell(this, true);
	});
<?php }?>
});

// cell 선택에 따른 변화
function chk_cell(obj, status){
	$(obj).attr('checked', status);
	if	( status ){
		$(obj).closest('tr').find('td').addClass('checked-cell');
	}else{
		$(obj).closest('tr').find('td').removeClass('checked-cell');
	}
}

// 양식 저장
function edForm_chkSubmit(obj){
	var chkStatus	= false;
	$("input[name='chk_cell[]']").each(function(){
		if	($(this).attr('checked') == 'checked'){
			chkStatus	= true;
			return false;
		}
	});

	if	(!chkStatus){
		openDialogAlert('선택된 cell 없습니다.', '400', '150');
		return false;
	}

	loadingStart();
	return true;
}

// 순서 초기화
function reset_sorted_cell(obj){
	var tbody	= $(obj).closest('div.excel-form-cell').find('table tbody');
	var clone	= tbody.clone();
	var trArr	= new Array();
	clone.find('tr').each(function(){
		if	($(this).html()){
			trArr[$(this).attr('idx')]	= '<tr idx="' + $(this).attr('idx') + '">' + $(this).html() + '</tr>';
		}
	});
	clone		= '';

	// 다시 그리기
	tbody.find('tr').remove();
	for (var idx in trArr) {
		tbody.append(trArr[idx]);
	}
}

// 설명 sample 엑셀 다운로드
function download_sample(){
	window.open('http://interface.firstmall.kr/excel_sample/20181011/goodsexcel.seller.sample.xlsx');
}
</script>

<form id="edForm" name="edForm" method="post" action="../goods_process/save_excel_form" target="actionFrame" onsubmit="return edForm_chkSubmit(this);">
<input type="hidden" name="seq" value="<?php echo $TPL_VAR["seq"]?>" />
<input type="hidden" name="form_id" value="<?php echo $TPL_VAR["formData"]["form_id"]?>" />
<input type="hidden" name="form_name" value="<?php echo $TPL_VAR["formData"]["form_name"]?>" />
<input type="hidden" name="form_type" value="<?php echo $TPL_VAR["formData"]["form_type"]?>" />
<input type="hidden" name="provider_seq" value="<?php echo $TPL_VAR["provider_seq"]?>" />

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2><span class="bold fx16">실물 다운로드 항목 설정</span></h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span class="btn large icon"><button type="button" onclick="location.href='catalog';"><span class="arrowleft"></span>상품리스트</button></span></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large cyanblue"><button type="button" onclick="download_sample();">설명용 샘플파일 다운로드(실물-Seller)</button></span></li>
			<li><span class="btn large black"><button type="submit">저장하기</button></span></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="item-title">실물 다운로드 항목 설정</div>
<div class="excel-form-lay">
<?php if($TPL_sorted_column_1){$TPL_I1=-1;foreach($TPL_VAR["sorted_column"] as $TPL_V1){$TPL_I1++;?>
	<div class="excel-form-cell">
		<div style="margin-bottom:5px;"><label><input type="checkbox" class="all_chk" /> 전체</label></div>
		<div style="position:absolute;top:2px;right:0;color:#06c;cursor:pointer;" onclick="reset_sorted_cell(this);"><u>순서초기화</u></div>
		<table width="100%" cellpadding="0" cellspacing="0" class="excel-form-table">
<?php if(is_array($TPL_R2=$TPL_V1["list"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
		<tr idx="<?php if(isset($TPL_V2["idx"])){?><?php echo $TPL_V2["idx"]?><?php }else{?><?php echo $TPL_I2?><?php }?>">
			<td <?php if($TPL_V2['chk']=='y'){?>class="checked-cell"<?php }?>>
				<img src="/admin/skin/default/images/common/icon_move.gif" />
			</td>
			<td <?php if($TPL_V2['chk']=='y'){?>class="checked-cell"<?php }?>>
				<input type="checkbox" name="chk_cell[]" id="chk_cell_<?php echo $TPL_I1?>_<?php echo $TPL_I2?>" value="<?php echo $TPL_V2['code']?>" <?php if($TPL_V2['chk']=='y'){?>checked<?php }?> />
				<input type="hidden" name="sort_cell[<?php echo $TPL_I1?>][]" value="<?php echo $TPL_V2['code']?>" />
			</td>
			<td <?php if($TPL_V2['chk']=='y'){?>class="checked-cell"<?php }?>><label for="chk_cell_<?php echo $TPL_I1?>_<?php echo $TPL_I2?>"><?php echo $TPL_V2['title']?></label></td>
		</tr>
<?php }}?>
		</table>
	</div>
<?php }}?>
</div>

</form>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>