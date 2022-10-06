<?php /* Template_ 2.2.6 2022/05/17 12:29:21 /www/music_brother_firstmall_kr/selleradmin/skin/default/order/download_list.html 000003165 */ 
$TPL_loop_1=empty($TPL_VAR["loop"])||!is_array($TPL_VAR["loop"])?0:count($TPL_VAR["loop"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<script type="text/javascript">
$(document).ready(function() {
	$(".modify").click(function(){
		var seq = $(this).attr("seq");
		document.location.href = "/selleradmin/order/download_write?seq="+seq;
	});

	$(".delete").click(function(){
		var seq = $(this).attr("seq");
		if(!confirm("삭제하시겠습니까?")) return;
		$("input[name='seq']").val(seq);
		$("#input_form").submit();
	});
});
</script>

<form id="input_form" name="input_form" method="post" action="../order_process/download_delete" target="actionFrame">
<input type="hidden" name="seq" />
</form>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<!-- 타이틀 -->
		<div class="page-title">
			<h2><span class="bold fx16">다운로드 항목설정</span></h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
			<li><span class="btn large icon"><button type="button" onclick="location.href='/selleradmin/order/catalog';"><span class="arrowleft"></span>주문리스트</button></span></li>
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
			<li><span class="btn large black"><button type="button" onclick="location.href='/selleradmin/order/download_write';">양식추가</button></span></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->


<div class="item-title">다운로드 항목설정 리스트</div>
<table class="info-table-style" style="width:100%">
	<colgroup>
		<col width="40%" />
		<col width="10%"/>
		<col width="20%" />
		<col width="20%"/>
		<col width="10%"/>
	</colgroup>
	<thead>
		<tr>
			<th class="its-th-align center">설정명</th>
			<th class="its-th-align center">항목수</th>
			<th class="its-th-align center">종류</th>
			<th class="its-th-align center">생성일</th>
			<th class="its-th-align center">관리</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_loop_1){foreach($TPL_VAR["loop"] as $TPL_V1){?>
		<tr>
			<td class="its-td-align center"><?php echo $TPL_V1["name"]?></td>
			<td class="its-td-align center"><?php echo $TPL_V1["count"]?></td>
			<td class="its-td-align pdl5"><?php if($TPL_V1["criteria"]=='ORDER'){?>주문기준 엑셀파일<?php }else{?>상품기준 엑셀파일<?php }?> ( <?php echo $TPL_V1["name"]?> )</td>
			<td class="its-td-align center"><?php echo $TPL_V1["regdate"]?></td>
			<td class="its-td-align center">
				<span class="btn small gray"><button type="button" class="modify" seq="<?php echo $TPL_V1["seq"]?>">수정</button></span>
<?php if($TPL_V1["seq"]== 1||$TPL_V1["seq"]== 2){?><?php }else{?>
				<span class="btn small gray"><button type="button" class="delete" seq="<?php echo $TPL_V1["seq"]?>">삭제</button></span>
<?php }?>
			</td>
		</tr>
<?php }}?>
	</tbody>
</table>




<?php $this->print_("layout_footer",$TPL_SCP,1);?>