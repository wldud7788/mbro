<?php /* Template_ 2.2.6 2022/05/17 12:31:02 /www/music_brother_firstmall_kr/admin/skin/default/common/qrcode_guide.html 000006141 */  $this->include_("qrcode");?>
<?php if($TPL_VAR["key"]){?>
<style>
.ul_list_01 {width:100%; display:table; border:1px solid #ccc;}
.ul_list_01 > li {display:table-cell; vertical-align:bottom;  line-height:2.5;  width:20%}
.ul_list_01  ul {display:table; margin-bottom:20px;}
.ul_list_01  ul > li{display:table-row; text-align:center;}
.ul_list_01  ul > li:first-child{height:230px; display:table-cell; vertical-align:middle; }
.resp_btn {vertical-align: top; border:1px #525f78 solid; background:#fff; border-radius:2px !important; letter-spacing: -1px; display:inline-block; font-size:13px; line-height:28px; outline: none; font-weight:400; padding:0 9px; box-sizing:border-box; text-align:center; color:#525f78; cursor:pointer;}
.footer{margin-top:20px; text-align:center; }

.table_basic {width:100%; line-height:2.4; border-collapse:collapse; border-top:1px solid #0f4897; border-bottom:1px solid #ccc; border-right:1px solid #ccc; color:#000;}
.table_basic > tbody > tr, .table_basic > thead > tr, .table_basic > tfoot > tr{border-top:1px solid #ccc;}
.table_basic > tbody > tr > th, .table_basic > thead > tr > th, .table_basic > tfoot > tr > th, .table_basic > tr > th {border-left:1px solid #ccc; text-align:center; padding:10px 15px; font-size:13px; background-color:#f9fafc; font-weight:normal; line-height:1.5}
.table_basic > tbody > tr > td, .table_basic > thead > tr > td, .table_basic > tfoot > tr > td {border-left:1px solid #ccc; padding:5px 15px 5px 15px; }
.table_basic > tbody:first-child > tr:first-child {border-top:0;}
.table_basic colgroup + tbody > tr:first-child {border-top:0;} 
</style>

<div class="item-title" style="margin-top:0;">QR 코드의 치환코드</div>
	
<ul class="ul_list_01">
<li>
	<li>
		<ul>
			<li><?php echo qrcode($TPL_VAR["key"],$TPL_VAR["value"], 2)?></li>	
			<li>(74 x 74)</li>	
			<li><button type="button" class="copy_qrcode_btn resp_btn" code="{=qrcode('<?php echo $TPL_VAR["key"]?>','<?php echo $TPL_VAR["value"]?>',2)}" onclick="copyContent($(this).attr('code'))">복사</button></li>
		</ul>
	</li>
	<li>
		<ul>
			<li><?php echo qrcode($TPL_VAR["key"],$TPL_VAR["value"], 3)?></li>
			<li>(111 x 111)</li>
			<li><button type="button" class="copy_qrcode_btn resp_btn" code="{=qrcode('<?php echo $TPL_VAR["key"]?>','<?php echo $TPL_VAR["value"]?>',3)}" onclick="copyContent($(this).attr('code'))">복사</button></li>
		</ul>
	</li>
	<li>
		<ul>
			<li><?php echo qrcode($TPL_VAR["key"],$TPL_VAR["value"], 4)?></li>
			<li>(148 x 148)</li>
			<li><button type="button" class="copy_qrcode_btn resp_btn" code="{=qrcode('<?php echo $TPL_VAR["key"]?>','<?php echo $TPL_VAR["value"]?>',4)}" onclick="copyContent($(this).attr('code'))">복사</button></li>	
		</ul>
	</li>
	<li>
		<ul>
			<li><?php echo qrcode($TPL_VAR["key"],$TPL_VAR["value"], 5)?></li>
			<li>(185 x 185)</li>
			<li><button type="button" class="copy_qrcode_btn resp_btn" code="{=qrcode('<?php echo $TPL_VAR["key"]?>','<?php echo $TPL_VAR["value"]?>',5)}" onclick="copyContent($(this).attr('code'))">복사</button></li>
		</ul>
	</li>
	<li>
		<ul>
			<li><?php echo qrcode($TPL_VAR["key"],$TPL_VAR["value"], 6)?></li>
			<li>(222 x 222)</li>
			<li><button type="button" class="copy_qrcode_btn resp_btn" code="{=qrcode('<?php echo $TPL_VAR["key"]?>','<?php echo $TPL_VAR["value"]?>',6)}" onclick="copyContent($(this).attr('code'))">복사</button></li>
		</ul>
	</li>
</ul>

<?php }?>

<div class="item-title">QR코드 안내</div>

<table class="table_basic thl">
	<colgroup>
		<col width="28%" />
		<col width="14%" />
		<col width="58%" />
	</colgroup>
	<tr>	
		<th>QR코드의 치환코드</th>
		<th>제공페이지</th>
		<th>안내</th>	
	</tr>
	<tr>
		
		<td>{=qrcode("shop",<font color=red>3</font>)}</td>
		<td>메인 페이지</td>
		<td>1) 모든 페이지 :  치환코드 삽입 → QR코드 보임</td>	
	</tr>
	<tr>	
		<td>{=qrcode("goods",goods.goods_seq,<font color=red>3</font>)}</td>
		<td>상품 상세 페이지</td>
		<td>
			1) 상품상세페이지 : 치환코드 삽입 → 해당 상품의 QR코드 보임<br />
			2) 그 외 페이지 : 상품고유번호를 넣은 치환코드 삽입 → 해당 상품의  QR코드 보임
		</td>	
	</tr>
	<tr>	
		<td>{=qrcode("category",categoryCode,<font color=red>3</font>)}</td>
		<td>카테고리 페이지</td>
		<td>
			1) 카테고리페이지 : 치환코드 삽입 → 해당 카테고리의 QR코드 보임<br />
			2) 그 외 페이지 : 카테고리고유번호를 넣은 치환코드 삽입 → 해당 카테고리의  QR코드 보임
		</td>
	</tr>
	<tr>	
		<td>{=qrcode("brand",brandCode,<font color=red>3</font>)}</td>
		<td>브랜드 페이지</td>
		<td>
			1) 브랜드페이지 : 치환코드 삽입 → 해당 브랜드의 QR코드 보임<br />
			2) 그 외 페이지 :  브랜드고유번호를 넣은 치환코드 삽입 → 해당 브랜드의  QR코드 보임
		</td>	
	</tr>
	<tr>	
		<td>{=qrcode("event",event_seq,<font color=red>3</font>)}</td>
		<td>이벤트 페이지</td>
		<td>
			1) 이벤트페이지 : 치환코드 삽입 → 해당 이벤트의 QR코드 보임<br />
			2) 그 외 페이지 : 이벤트고유번호를 넣은 치환코드 삽입 → 해당 이벤트의  QR코드 보임
		</td>	
	</tr>
	<!-- 
	<tr>
		<td class="its-td">배송추적 페이지에 삽입</td>
		<td class="its-td">{=qrcode("delivery","출고번호",<font color=red>3</font>)}</td>
		<td class="its-td lsp-1">
			1) 마이페이지 > 주문상세페이지 : 치환코드 삽입 → 해당 배송추적의 QR코드 보임<br />
			2) 그 외 페이지 : 출고고유번호를 넣은 치환코드 삽입 → 해당 배송추적의  QR코드 보임
		</td>
		<td class="its-td">
			<a href="">출고리스트</a>
		</td>
	</tr>
	 -->
</table>
<div class="footer">
	<button type="button" class="resp_btn v3 size_XL" onclick="closeDialog('qrcodeGuideLayer')">닫기</button>
</div>