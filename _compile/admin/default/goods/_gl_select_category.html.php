<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/admin/skin/default/goods/_gl_select_category.html 000003202 */ ?>
<script type="text/javascript">
document.addEventListener('keydown', function(event) {
  if (event.keyCode === 13) {
    gcategorySelect.searchCategory();
  };
}, true);

var categoryType 	= "<?php echo $TPL_VAR["sc"]["categoryType"]?>";
var categoryLay		= "div#<?php echo $TPL_VAR["sc"]["divSelectLay"]?>";

if(categoryType == "brand"){
//	_getBrand();	/* 브랜드 불러오기 */
	$("#provider_brand_container").hide();
	$("form[name='brandConnectFrm'] input[name='provider_seq']").val('');
	$("input[type='radio'][name='brandInputMethod'][value='select']").attr('checked',true);
	
}else if(categoryType == "location"){
//	_getLocation(); /* 지역 불러오기 */
}else{
//	_getCategory();	/* 카테고리 불러오기 */
}

</script>

<style>
.category_select select { width:100% !important;border:0px !important; height:200px !important; }
.category_select.brand select,.category_select.location select { height:170px !important; }
</style>

<!--카테고리 연결 레이어-->
<div class="category_select <?php echo $TPL_VAR["sc"]["categoryType"]?>">
<?php if($TPL_VAR["sc"]["openType"]=="popup"){?><div class="content"><?php }?>
	<table class="table_basic thl v7">
		<colgroup>
			<col width="25%" />
			<col width="25%" />
			<col width="25%" />
			<col width="25%" />
		</colgroup>
		<thead>
			<tr>
				<th>1차 <?php echo $TPL_VAR["sc"]["categoryTitle"]?></th>
				<th>2차 <?php echo $TPL_VAR["sc"]["categoryTitle"]?></th>
				<th>3차 <?php echo $TPL_VAR["sc"]["categoryTitle"]?></th>
				<th>4차 <?php echo $TPL_VAR["sc"]["categoryTitle"]?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="clear center">
					<select name="select_<?php echo $TPL_VAR["sc"]["categoryType"]?>1" multiple='multiple' no=1 ></select>
				</td>
				<td class="clear center">
					<select name="select_<?php echo $TPL_VAR["sc"]["categoryType"]?>2" multiple='multiple' no=2 ></select>
				</td>
				<td class="clear center">
					<select name="select_<?php echo $TPL_VAR["sc"]["categoryType"]?>3" multiple='multiple' no=3 ></select>
				</td>
				<td class="clear center">
					<select name="select_<?php echo $TPL_VAR["sc"]["categoryType"]?>4" multiple='multiple' no=4 ></select>
				</td>
			</tr>
		</tbody>
	</table>
<?php if($TPL_VAR["sc"]["categoryType"]!="category"){?>
	<ul class='bullet_hyphen resp_message'>
		<li>신규 <?php echo $TPL_VAR["sc"]["categoryTitle"]?> 생성은 <a href="/admin/<?php echo $TPL_VAR["sc"]["categoryType"]?>/catalog" target="_blank"><span class="underline blue"><?php echo $TPL_VAR["sc"]["categoryTitle"]?></span></a>에서 가능 합니다.</li>
	</ul>
<?php }?>
<?php if($TPL_VAR["sc"]["openType"]=="popup"){?></div><?php }?>

	<div class="footer">
		<button type="button" class="confirmSelectCategory resp_btn active size_XL" data-opt='<?php echo $TPL_VAR["scObj"]?>' >선택</button>
<?php if($TPL_VAR["sc"]["openType"]=="popup"){?>
		<button type="button" class="btnLayClose resp_btn v3 size_XL">닫기</button>
<?php }?>
	</div>
</div>