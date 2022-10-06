<?php /* Template_ 2.2.6 2021/08/25 16:20:44 /www/music_brother_firstmall_kr/selleradmin/skin/default/banner/index.html 000004015 */ 
$TPL_banner_index_1=empty($TPL_VAR["banner_index"])||!is_array($TPL_VAR["banner_index"])?0:count($TPL_VAR["banner_index"]);?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<!-- 
<script type="text/javascript" src="/app/javascript/js/admin-board.js?v=20201120"></script>
<script type="text/javascript" src="/app/javascript/jquery/jquery.form.js"></script>
<script type="text/javascript" src="/app/javascript/plugin/editor/js/editor_loader.js"></script> -->
<!-- <script type="text/javascript" src="/app/javascript/plugin/editor/js/daum_editor_loader.js"></script>
 --><!-- <script type="text/javascript"> -->
<!-- </script> -->

<style type="text/css">
	.search_container{
		margin: 30px 20px 10px 20px;
	}
	.table_search{
		border-collapse: collapse; 
		width: 50%; 
		margin-bottom: 20px;
	}
	.table_search > tbody > tr > th {
	    width: 150px;
	    text-align: left;
	    padding: 7px 10px;
	    background: #f1f4fb;
	    border: 1px solid #ccc;
	    font-weight: 400;
	    box-sizing: border-box;
	}
	.table_search > tbody > tr > td {
	    padding: 7px 10px;

	    border: 1px solid #ccc;
	    box-sizing: border-box;
	    position: relative;
	}
	.table_search > tbody > tr > td button{padding:5px 15px;}
	.table_search > tbody > tr > td>img{max-width: 100%;}
	.banner_admin_btn_box{position: absolute;right: 10px; bottom: 10px;}
	.margin_top_30{margin-top: 30px;}
</style>

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
		<div class="page-title">
			<h2>공지사항 배너 등록</h2>
		</div>
	</div>
</div>
<!--해당 페이지부터 레이아웃 부탁드립니다-->
<div id="bboardmain" class="contents_container">

	
	<div class="search_container">

		<table class="table_search">
			<tbody>
				<tr>
					<th>배너 관리</th>
					<td>
						<button onclick="window.open('./input', 'input')">등록</button>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="table_search">
			<tbody>
				<!-- @ 여기부터 반복문 시작 @를 안넣으시면 정확한 결과값이 나오지 않고, 공백으로 뜹니다! = 꼭 넣어야한다는 뜻 by 김혜진 -->
<?php if($TPL_banner_index_1){foreach($TPL_VAR["banner_index"] as $TPL_V1){?>
				<tr>
					<th>배너 정보</th>
					<td>
						<div class="banner_admin_btn_box">
							<button onclick="window.open('./revise?no=<?php echo $TPL_V1["id"]?>', 'revise')">수정</button>
							<button onclick="javascript:banner_confirm(<?php echo $TPL_V1["id"]?>)">삭제</button>
						</div>
						<img src="<?php echo $TPL_V1["url"]?>">
						<table class="table_search margin_top_30">
							<tbody>
								<tr>
									<th>타이틀</th>
									<td><?php echo $TPL_V1["title"]?></td>
								</tr>
								<tr>
									<th>등록 날짜</th>
									<td><?php echo $TPL_V1["inputDate"]?></td>
								</tr>
								<tr>
									<th>시작 날짜</th>
									<td><?php echo $TPL_V1["startDate"]?></td>
								</tr>
								<tr>
									<th>종료 날짜</th>
									<td><?php echo $TPL_V1["endDate"]?></td>
								</tr>
								<tr>
									<th>노출 여부</th>
									<td><?php echo $TPL_V1["active"]?></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
<?php }}?>
			</tbody>
		</table>

	</div>


</div>

<script type="text/javascript">
	function banner_confirm(id) { 
		var result = confirm("삭제하시면 복구할 수 없습니다.");

		if(result) {  
			$.ajax({
				url : './bannerDelete?id='+id,
				success : function(data) { 
					alert(data); 
					location.reload();
				},
				error:function(request,status,error){
					console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				}
				
			});
		} else { 
			alert('삭제하지 않습니다.');
		} 
	} 
</script>
<!-- 페이지 타이틀 바 : 끝 -->

<?php $this->print_("layout_footer",$TPL_SCP,1);?>