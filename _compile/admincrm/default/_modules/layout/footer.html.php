<?php /* Template_ 2.2.6 2022/05/17 12:05:26 /www/music_brother_firstmall_kr/admincrm/skin/default/_modules/layout/footer.html 000003461 */ ?>
<!--[ 레이아웃 바디(본문) : 끝 ]-->
					</td>
<?php if(uri_string()!="admincrm/main/index"){?>
					<td width="240" class="pdl20">
						<!--[ 우측 상담 관리 : 시작 ]-->
<?php $this->print_("layout_right",$TPL_SCP,1);?>

						<!--[ 우측 상담 관리 : 시작 ]-->
					</td>
<?php }?>
				</tr>
			</table>
		</div>
	</div>

	<iframe name="actionFrame" id="actionFrame" src="/main/blank" frameborder="0" width="100%" <?php if($_GET["debug"]== 1){?>height="600"<?php }else{?>height="0"<?php }?>></iframe>
</div>

<div id="openDialogLayer" class="hide">
	<div align="center" id="openDialogLayerMsg"></div>
</div>
<div id="ajaxLoadingLayer" class="hide"></div>
</body>

<?php if($TPL_VAR["autoLogout"]["auto_logout"]=="Y"&&$TPL_VAR["managerInfo"]){?>
<script type="text/javascipt">
	Lpad=function(str, len){
		str = str + "";
		while(str.length < len){
			str = "0"+str;
		}
		return str;
	}

	// 자동로그아웃 시간 셋팅
	var iMinute = "<?php echo $TPL_VAR["autoLogout"]["until_time"]* 60?>";
	var noticeSecond = 1;

	var iSecond = iMinute * 60 ;
	var timerchecker = null;

	initTimer=function(){
<?php if($_GET["debug"]){?>
		timer.style.visibility='visible';  // 자동로그아웃 확인용
<?php }?>

		//이벤트 발생 체크
		if(window.event){
			iSecond = iMinute * 60 ;;
			clearTimeout(timerchecker);
		}
		rMinute = parseInt(iSecond / 60);
		rSecond = iSecond % 60;
		if(iSecond > 0){
		//지정한 시간동안 마우스, 키보드 이벤트가 발생되지 않았을 경우
			timer.innerHTML =  "<font family=tahoma style='font-size:70;'>AUTO LOG OUT</font> </h1> <font color=red>" + Lpad(rMinute, 2)+":"+Lpad(rSecond, 2) ;
			iSecond--;
			timerchecker = setTimeout("initTimer()", 1000); // 1초 간격으로 체크
		}else{
			clearTimeout(timerchecker);
			openDialog("관리자 자동 로그아웃 알림", "autoLogoutMsg", {"width":"600","height":"220"});
			actionFrame.location.href = "../login_process/logout?mode=autoLogout"; // 로그아웃 처리
		}
	}
	onload = initTimer;///현재 페이지 대기시간
	document.onclick = initTimer; /// 현재 페이지의 사용자 마우스 클릭이벤트 캡춰
	document.onkeypress = initTimer;/// 현재 페이지의 키보트 입력이벤트 캡춰
</script>

<!-- 비활성화 시키는 레이어-->
<!-- 자동로그아웃시까지 남은 시간을 보여주는 레이어-->
<div id="timer" style="position:absolute; right:10px; bottom:20px; width:200px; visibility:hidden; border:0;  color:black; font-family:tahoma; font-size:150;font-weight:bold;text-align:center"></div>
<div id="autoLogoutMsg" class="hide">
	<center><h2>자동으로 로그아웃 되었습니다.</h2></center>
	<div style="height:20px;"></div>
	- 안전한 관리를 위하여 <?php echo $TPL_VAR["autoLogout"]["until_time"]?>시간 동안 사용이 없어 자동로그아웃 되었습니다.
	<div style="height:5px;"></div>
	- 다시 로그인 하시려면 [로그인]버튼을 클릭하십시오.
	<div style="height:20px;"></div>
	<div align="center">
		<span class="btn large gray"><input type="button" value="로그인" onclick="location.href='../login/index'"></span>
	</div>
</div>
<?php }?>

<?php $this->print_("common_html_footer",$TPL_SCP,1);?>