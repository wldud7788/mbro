<?php /* Template_ 2.2.6 2021/08/25 16:20:44 /www/music_brother_firstmall_kr/selleradmin/skin/default/banner/input.html 000002532 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


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
	.resp_btn{padding:10px 15px; margin-bottom: 20px;}
	.back_btn{padding:10px 15px;}
</style>

<div id="page-title-bar-area">
	<div id="page-title-bar">
		<div class="page-title">
			<h2>공지사항 배너 등록</h2>
		</div>
	</div>
</div>
<div>
	<center>
		<form name="banner" enctype="multipart/form-data" method="post" action="./process">
			<table class="table_search">
				<tbody>
					<tr>
						<td>
							
							<img src="<?php echo $TPL_VAR["banner_index"]["url"]?>">
							<table class="table_search margin_top_30">
								<tbody>
									<tr>
										<th>회사 이름</th>
										<td><input type="text" name="name" value="<?php echo $TPL_VAR["name"]?>" readonly></td>
									</tr>
									<tr>
										<th>공지사항 이름</th>
										<td><input type="text" name="title"></td>
									</tr>
									<tr>
										<th>공지사항 시작일자</th>
										<td><input type="date" name="start"></td>
									</tr>
									<tr>
										<th>공지사항 종료일자</th>
										<td><input type="date" name="end">
									<tr>
										<th>공지사항 배너</th>
										<td><input type="file" name="img"></td>
									</tr>
									<tr>
										<th>활성화 여부</th>
										<td><input type="checkbox" name="check"></td>
									</tr>
		
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
			<input type="submit" class="resp_btn" value="입력완료">
		</form>
		<button class="back_btn" onclick="location.replace('./index')">취소</button>
	</center>
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>