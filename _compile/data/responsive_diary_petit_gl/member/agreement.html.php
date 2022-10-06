<?php /* Template_ 2.2.6 2021/03/17 10:51:36 /www/music_brother_firstmall_kr/data/skin/responsive_diary_petit_gl/member/agreement.html 000006399 */ ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++
@@ 회원가입 > 약관동의 @@
- 파일위치 : [스킨폴더]/member/agreement.html
++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<?php echo $TPL_VAR["is_file_kakao_tag"]?>


<!-- 타이틀 -->
<div class="title_container">
  <h2><span designElement="text" textIndex="1"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvYWdyZWVtZW50Lmh0bWw=" >약관 동의</span></h2>
  <h3 style="margin-top: 10px;">'입점신청'은 사업자회원가입 후 '하단의 입점문의 > 1:1 입점문의'를 이용해 주세요.</h3>
</div>

<div class="resp_login_wrap Mt0">
  <form name="agreeFrm" id="agreeFrm" target="actionFrame" method="post" action="../member_process/register">
  <input type="hidden" name="join_type" value="<?php echo $_GET["join_type"]?>"/>
    <div class="mem_agree_area">
      <label id="pilsuAgreeAll" class="pilsu_agree_all"><input type="checkbox"> <span class="pointcolor4" designElement="text" textIndex="2"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvYWdyZWVtZW50Lmh0bWw=" >필수</span> <span designElement="text" textIndex="3"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvYWdyZWVtZW50Lmh0bWw=" >약관 전체 동의</span></label>
      <ul id="agreeList" class="agree_list3">
        <li class="agree_section">
          <a class="agree_view" href="javascript:void(0)" onclick="showCenterLayer('#agreementDeatilLayer')"><span designElement="text" textIndex="4"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvYWdyZWVtZW50Lmh0bWw=" >보기</span></a>
          <label><input type="checkbox" name="agree" value="Y" class="pilsu" > <span designElement="text" textIndex="5"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvYWdyZWVtZW50Lmh0bWw=" >쇼핑몰 이용약관</span> <span class="desc pointcolor4 imp" designElement="text" textIndex="6"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvYWdyZWVtZW50Lmh0bWw=" >(필수)</span></label>
        </li>
        <li class="agree_section">
          <a class="agree_view" href="javascript:void(0)" onclick="showCenterLayer('#privacyDeatilLayer')"><span designElement="text" textIndex="7"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvYWdyZWVtZW50Lmh0bWw=" >보기</span></a>
          <label><input type="checkbox" name="agree2" value="Y" class="pilsu"> <span designElement="text" textIndex="8"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvYWdyZWVtZW50Lmh0bWw=" >개인정보 처리방침</span> <span class="desc pointcolor4 imp" designElement="text" textIndex="9"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvYWdyZWVtZW50Lmh0bWw=" >(필수)</span></label>
        </li>
      </ul>
    </div>

    <div class="btn_area_c">
      <button type="button" id="btn_submit" class="btn_resp size_c color2 Wmax"><span designElement="text" textIndex="10"  textTemplatePath="cmVzcG9uc2l2ZV9kaWFyeV9wZXRpdF9nbC9tZW1iZXIvYWdyZWVtZW50Lmh0bWw=" >다음 단계</span></button>
    </div>
  </form>
</div>

<div id="agreementDeatilLayer" class="resp_layer_pop hide">
  <h4 class="title">이용약관</h4>
  <div class="y_scroll_auto2">
    <div class="layer_pop_contents v5">
      <?php echo nl2br($TPL_VAR["agreement"])?>

    </div>
  </div>
  <div class="layer_bottom_btn_area2">
    <button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
  </div>
  <a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>

<div id="privacyDeatilLayer" class="resp_layer_pop hide">
  <h4 class="title">개인정보 처리방침</h4>
  <div class="y_scroll_auto2">
    <div class="layer_pop_contents v5">
      <?php echo nl2br($TPL_VAR["policy"])?>

    </div>
  </div>
  <div class="layer_bottom_btn_area2">
    <button type="button" class="btn_resp size_c color5 Wmax" onclick="hideCenterLayer()">확인</button>
  </div>
  <a href="javascript:void(0)" class="btn_pop_close" onclick="hideCenterLayer()"></a>
</div>



<script src="/app/javascript/js/skin-snslogin.js"></script>

<script type="text/javascript">
var return_url  = "../main/index";
<?php if($_GET["return_url"]){?>
return_url    = "<?php echo $_GET["return_url"]?>";
<?php }elseif($TPL_VAR["return_url"]){?>
return_url    = "<?php echo $TPL_VAR["return_url"]?>";
<?php }?>
var mobileapp = "<?php echo $TPL_VAR["mobileapp"]?>";
var m_device  = "<?php echo $TPL_VAR["m_device"]?>";
var fbuserauth  = "<?php echo $TPL_VAR["fbuserauth"]?>";
var snstype = '<?php echo substr($_GET["join_type"], 0, 2)?>';
var jointype = '<?php echo $_GET["join_type"]?>';
var apple_authurl = '<?php echo $TPL_VAR["apple_authurl"]?>';
</script>
<script type="text/javascript">
$(document).ready(function() {
  // 약관 전체동의
  $('#pilsuAgreeAll > input[type=checkbox]').on('change', function() {
    if ( $(this).prop('checked') ) {
      $(this).closest('.mem_agree_area').find('input[type=checkbox].pilsu').attr('checked', 'checked');
      $(this).closest('.mem_agree_area').find('input[type=checkbox].pilsu').closest('li').addClass('end');
    } else {
      $(this).closest('.mem_agree_area').find('input[type=checkbox].pilsu').removeAttr('checked');
      $(this).closest('.mem_agree_area').find('input[type=checkbox].pilsu').closest('li').removeClass('end');
    }
  });
  // 개별 약관 선택시
  $('#agreeList input[type=checkbox]').on('change', function() {
    if ( $(this).prop('checked') ) {
      $(this).closest('li').addClass('end');
    } else {
      $(this).closest('li').removeClass('end');
    }
  });


  $('#btn_submit').click(function() {
<?php if($_GET["join_type"]){?>
      if(!$("input[name='agree']").is(":checked")){
        //이용약관에 동의하셔야합니다.
        alert(getAlert('mb001'));
        return false;
      }
      if(!$("input[name='agree2']").is(":checked")){
        //개인정보처리방침에 동의하셔야합니다.
        alert(getAlert('mb002'));
        return false;
      }
<?php }?>

<?php if(!$_GET["join_type"]||$_GET["join_type"]=='member'||$_GET["join_type"]=='business'){?>
      $('#agreeFrm').submit();
<?php }else{?>
      joinwindowopen();
<?php }?>
  });
});
</script>