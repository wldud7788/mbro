<?php /* Template_ 2.2.6 2022/05/17 12:36:24 /www/music_brother_firstmall_kr/admin/skin/default/member/amail.html 000003829 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>


<form name="memberForm" id="memberForm" method="post" target="actionFrame" action="../member_process/amail">

<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">

		<!-- 타이틀 -->
		<div class="page-title">
			<h2>이메일 대량 발송</h2>
		</div>

		<!-- 좌측 버튼 -->
		<ul class="page-buttons-left">
		<!--
			<li><span class="btn large icon"><button><span class="arrowleft"></span>이동버튼</button></span></li>
			<li><span class="btn large icon"><button><span class="arrowleft"></span>이동버튼</button></span></li>
		-->
		</ul>

		<!-- 우측 버튼 -->
		<ul class="page-buttons-right">
		<!--
			<li><span class="btn large black"><button type="submit">저장하기<span class="arrowright"></span></button></span></li>
		-->
			<li><button  <?php if($TPL_VAR["isdemo"]["isdemo"]){?>  type="button" <?php echo $TPL_VAR["isdemo"]["isdemojs1"]?> <?php }else{?> type="submit" <?php }?> class="resp_btn active2 size_L">저장</button></li>
		</ul>
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->

<div class="contents_container">

	<!-- 상단 단계 링크 : 시작 -->
	<ul class="tab_01 v2 tabEvent">
		<li><a href='amail'>대량 발송 설정</a></li>
		<li><a href='amail_send'>이메일 대량 발송</a></li>
	</ul>
	<!-- 상단 단계 링크 : 끝 -->

	<!-- 서브 레이아웃 영역 : 시작 -->
	<div class="item-title" style="width:92%">이메일 대량발송 설정</div>

	<table class="table_basic thl">
		<tr>
			<th>이름</th>
			<td>
				<input type="text" name="name" value="<?php echo $TPL_VAR["name"]?>" size="30"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?> >
			</td>
		</tr>
		<tr>
			<th>이메일</th>
			<td>
				<input type="text" name="email" value="<?php echo $TPL_VAR["email"]?>" size="30" <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?> >
			</td>
		</tr>
		<tr>
			<th>전화번호</th>
			<td>
				<input type="text" size="4" maxlength="4" name="phoneArr[0]" title=" " value="<?php echo $TPL_VAR["phoneArr"][ 0]?>"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>/>
				 -
				<input type="text" size="4" maxlength="4" name="phoneArr[1]" title=" " value="<?php echo $TPL_VAR["phoneArr"][ 1]?>"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>/>
				 -
				<input type="text" size="4" maxlength="4" name="phoneArr[2]" title=" " value="<?php echo $TPL_VAR["phoneArr"][ 2]?>"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>/>
			</td>
		</tr>
		<tr>
			<th>휴대폰</th>
			<td>
				<input type="text" size="4" maxlength="4" name="mobileArr[0]" title=" " value="<?php echo $TPL_VAR["mobileArr"][ 0]?>"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>/>
				 -
				<input type="text" size="4" maxlength="4" name="mobileArr[1]" title=" " value="<?php echo $TPL_VAR["mobileArr"][ 1]?>"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>/>
				 -
				<input type="text" size="4" maxlength="4" name="mobileArr[2]" title=" " value="<?php echo $TPL_VAR["mobileArr"][ 2]?>"  <?php if($TPL_VAR["isdemo"]["isdemo"]){?> <?php echo $TPL_VAR["isdemo"]["isdemodisabled"]?> <?php }?>/>
			</td>
		</tr>
	</table>
</div>

</form>




<?php $this->print_("layout_footer",$TPL_SCP,1);?>