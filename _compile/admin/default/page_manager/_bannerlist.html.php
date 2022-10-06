<?php /* Template_ 2.2.6 2022/05/17 12:36:47 /www/music_brother_firstmall_kr/admin/skin/default/page_manager/_bannerlist.html 000003383 */ ?>
<span class="btn medium default mt5 mb10"><button class="btnSlideBannerPopup" type="button" >슬라이드 배너</button></span>
<table width="50%" class="info-table-style">
	<colgroup>
		<col width="14%">
		<col width="*">
		<col width="30%">
		<col width="20%">
		<col width="10%">
	</colgroup>
	<tbody>
	<tr>
		<th class="its-th-align center">만든 날짜</th>
		<th class="its-th-align center">배너명</th>
		<th class="its-th-align center">스타일</th>
		<!--th class="its-th-align center">치환코드</th-->
		<th class="its-th-align center">관리</th>
	</tr>
<?php if($TPL_VAR["data"]["banner"]["banner_seq"]){?>
		<tr>
			<td class="its-td-align center"><?php echo substr($TPL_VAR["data"]["banner"]["regdate"], 0, 10)?></td>
			<td class="its-td-align center"><?php echo $TPL_VAR["data"]["banner"]["name"]?></td>
			<td class="its-td-align center"><?php echo $TPL_VAR["data"]["banner"]["styles"][$TPL_VAR["data"]["banner"]["style"]]["name"]?></td>
			<!--td class="its-td-align">{=showDesignBanner(<?php echo $TPL_VAR["data"]["banner"]["banner_seq"]?>)}</td-->
			<td class="its-td-align center">
				<!-- <input type="hidden" name="banner" value="<?php echo json_encode($TPL_VAR["data"]["banner"])?>" /> -->
				<span class="btn small red"><button type="button" onclick="del_banner('<?php echo $TPL_VAR["data"]["banner"]["banner_seq"]?>')">삭제</button></span>
			</td>
		</tr>
<?php }else{?>
	<tr>
		<th class="its-td-align" colspan="4">데이터가 없습니다.</th>
	</tr>
<?php }?>
</tbody></table>
<div id="banner_popup">
	<iframe id="banner_frame" src="" ></iframe>
</div>
<style type="text/css">
	#banner_popup { display: none; }
	#banner_frame { width: 100%; height: 100%; border: none; }
</style>
<script type="text/javascript">
	// 페이지 로딩 후 div의 값들을 serialize 후 전역변수로만 사용함 (부모 form 안에 있기때문)
	var url_params = '';
	$(document).ready(function(){
		$('.btnSlideBannerPopup').click(function(){
			showBannerControl();	
		});	

		url_params = $('#bannerFrm input').serialize();
		$('#bannerFrm').remove();
	});

	function showBannerControl(){
		var popup_url = '/admin/design/banner_edit?' + url_params;

		$('#banner_frame').attr('src', popup_url);
		openDialog('슬라이드 배너', "banner_popup", {"width":1000,"height":600});
	}

	// 슬라이드 배너 삭제
	function del_banner(seq){
		$.ajax({
			type	: 'POST',
			url		: '../page_manager_process/delete_design_banner',
			data	: {'mode':'ajax', 'banner_seq':seq},
			dataType: 'json',
			success	: function(res){
				alert(res.msg);
				document.location.reload();
			}
		});
	}
</script>
<div id="bannerFrm">
	<input type="hidden" name="setMode" value="responsive" />
	<input type="hidden" name="popup" value="1" />
	<input type="hidden" name="page" value="1" />
	<input type="hidden" name="platform" value="responsive" />
	<input type="hidden" name="template_path" value="" />
	<input type="hidden" name="direct" value="1" />
	<input type="hidden" name="banner_seq" value="<?php echo $TPL_VAR["data"]["banner"]["banner_seq"]?>" />
	<input type="hidden" name="page_type" value="<?php echo $_GET["cmd"]?>" />
</div>