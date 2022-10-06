<?php /* Template_ 2.2.6 2022/05/17 12:37:03 /www/music_brother_firstmall_kr/admin/skin/default/setting/_goodsflow_provider_layer.html 000003533 */ ?>
<!-- 설정-택배사-굿스플로 업무자동화 입점사 설정 : 시작 -->
<style>
	.ul_list_01 .table_row_frame {border-left:1px solid #ccc;  border-right:1px solid #ccc; border-bottom:1px solid #ccc;  }
	.ul_list_01 .table_row_frame .table_basic > tbody > tr > th:first-child, .ul_list_01 .table_row_frame .table_basic > tbody > tr > td:first-child, .ul_list_01 .table_row_frame .table_basic > thead > tr > th:first-child, .ul_list_01 .table_row_frame .table_basic > thead > tr > td:first-child{border-left:0;}
	.ul_list_01 .table_row_frame .table_basic {border-right:0; }
	.ul_list_01 .table_row_frame .dvs_top {border-left:0;}
	.ul_list_01 .table_row_frame .scroll{overflow-y:auto; overflow-x:hidden; height:270px;}
</style>
<form name="goodsflowProviderForm" id="goodsflowProviderForm" method="post" target="actionFrame">
	<ul class="ul_list_01 providerList">
		<li class="wp45">
			<div class="list_info_container">
				<div class="dvs_left">	
					총 <span class="providerCount bold">0</span> 개												
				</div>
				<div class="dvs_right">
					<input type="text" name="provider_name" value="" />
					<button type="button" name="providerCountSelect" class="resp_btn active">검색</button>
				</div>
			</div>
		
			<div class="table_row_frame">					
				<div class="dvs_top">					
				</div>
				<!-- 굿스플로 미등록 입점사 리스트 : 시작 -->
				<div class="providerOriginalList scroll" id="providerOriginalList">
					<table class="table_basic providerOriginalListTable">
						<colgroup>
							<col width="20%" />
							<col width="80%" />
						</colgroup>
						<thead>
							<tr>
								<th><label class="resp_checkbox"><input type="checkbox" class="allCheckBtn"/></label></th>
								<th>입점사명</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<!-- 굿스플로 미등록 입점사 리스트 : 끝 -->
			</div>
		</li>
		<li class="wp10 center valign-middle"><span class="btn lightblue"><button type="button" name="providerSetPeriod">></button></span></li>
		<li class="wp45">
			<div class="list_info_container">
				<div class="dvs_left">	
					총 <span class="providerCount bold">0</span> 개												
				</div>			
			</div>
		
			<div class="table_row_frame">					
				<div class="dvs_top">
					<div class="dvs_right"><button type="button" name="delProvider" class="resp_btn v3">선택 삭제</button></div>
				</div>
				<!-- 굿스플로 등록 입점사 리스트 : 시작 -->
				<div class="providerSetList scroll">
					<table class="table_basic providerSetListTable">
						<colgroup>
							<col width="20%" />
							<col width="80%" />
						</colgroup>
						<thead>
							<tr>
								<th><label class="resp_checkbox"><input type="checkbox" class="allCheckBtn" /></label></th>
								<th>입점사명</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<!-- 굿스플로 등록 입점사 리스트 : 끝 -->
			</div>			
		</li>
	</ul>
	
	<div class="footer">
		<button type="button" name="periodSetSave" class="resp_btn active size_XL">확인</button>
		<button type="button" class="resp_btn v3 size_XL" onclick="closeDialogEvent(this);">취소</button>
	</div>

</form>
<!-- 설정-택배사-굿스플로 업무자동화 입점사 설정 : 끝 -->