<?php /* Template_ 2.2.6 2022/01/24 10:32:01 /www/music_brother_firstmall_kr/broadcast/player.html 000013607 */  $this->include_("metaHeaderWrite","naverWcsScript","defaultScriptFunc","snslinkurl");?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"  xmlns:fb="http://ogp.me/ns/fb#"  xmlns:og="http://ogp.me/ns#">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# <?php if($TPL_VAR["APP_NAMES"]&&$TPL_VAR["APP_TYPE"]){?><?php echo $TPL_VAR["APP_NAMES"]?><?php }else{?>website<?php }?>: <?php if($TPL_VAR["APP_NAMES"]&&$TPL_VAR["APP_TYPE"]){?>http://ogp.me/ns/fb/<?php echo $TPL_VAR["APP_NAMES"]?><?php }else{?>http://ogp.me/ns/fb/website<?php }?>#">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="utf-8">
<?php echo metaHeaderWrite($TPL_VAR["add_meta_info"],true)?>

<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<title><?php echo $TPL_VAR["shopTitle"]?></title>
<?php echo $TPL_VAR["new_meta"]?>

<?php if($TPL_VAR["APP_USE"]=='f'){?>
<meta property="fb:app_id" content="<?php echo $TPL_VAR["APP_ID"]?>" />
<?php }?>
<meta property="og:image" content="https://<?php echo $_SERVER["HTTP_HOST"]?><?php echo $TPL_VAR["sch"]["image"]?>">
<!-- 자바스크립트 -->
<script src="/app/javascript/jquery/jquery.min.js"></script>
<script src="/app/javascript/jquery/jquery-ui.min.js"></script>
<script src="/app/javascript/plugin/jquery.cookie.js"></script>
<script src="/data/js/language/L10n_<?php echo $TPL_VAR["config_system"]["language"]?>.js?dummy=<?php echo date('YmdHis')?>"></script>
<script src="/app/javascript/js/common.js"></script>
<script src="/app/javascript/js/broadcast-player.js?dummy=<?php echo date('YmdH')?>" defer></script>
<link rel="stylesheet" href="/admin/skin/default/css/broadcast-player.css">
<?php if($TPL_VAR["config_basic"]["naver_wcs_use"]=='y'&&!$_GET["popup"]&&!$_GET["iframe"]){?>
<!--[ 네이버 공통유입 스크립트 ]-->
<?php echo naverWcsScript()?>

<?php }?>
<!-- /자바스크립트 -->
<?php if($TPL_VAR["config_system"]["favicon"]){?>
<!-- 파비콘 -->
<link rel="shortcut icon" href="//<?php echo $_SERVER["HTTP_HOST"]?>/<?php echo $TPL_VAR["config_system"]["favicon"]?>" />
<?php }?>
<?php if($TPL_VAR["config_system"]["androidicon"]||$TPL_VAR["config_system"]["iphoneicon"]){?>
<!-- 바로가기아이콘 -->
<link rel="apple-touch-icon" href="//<?php echo $_SERVER["HTTP_HOST"]?><?php echo $TPL_VAR["config_system"]["iphoneicon"]?>" />
<link rel="shortcut icon" href="//<?php echo $_SERVER["HTTP_HOST"]?><?php echo $TPL_VAR["config_system"]["androidicon"]?>" />
<?php }?>
<?php echo defaultScriptFunc()?></head>
<script type="text/javascript">
var schjs= <?php echo $TPL_VAR["schjs"]?>;
var chats= <?php echo $TPL_VAR["chats"]?>;
var is_vod = '<?php echo $TPL_VAR["vod"]?>';
var is_user = '<?php echo $TPL_VAR["is_user"]?>';
var is_admin = '<?php echo $TPL_VAR["is_admin"]?>';
</script>
<body>
	<div class="area_video">
		<div class="inner">			
			<span class="btn_close closeBtn"><img src="/admin/skin/default/images/broadcast/i_close.png"></span>
			<div class="click_area"></div>

			<div class="video_container">
				
				<!-- 헤더 : 시작 -->		
				<div class="head_wrap">
					<div class="tit_wrap">
<?php if($TPL_VAR["sch"]["status"]=='live'){?>
						<img src="/admin/skin/default/images/broadcast/i_live.png" class="i_live">
<?php }?>
						<span class="tit"><?php echo $TPL_VAR["sch"]["title"]?></span>
						<div class="right_dvs">
<?php if($TPL_VAR["ISADMIN"]&&$TPL_VAR["vod"]){?>
							<span class="downloadBtn actions" data-action="download"><img src="/admin/skin/default/images/broadcast/i_download.png"></span>
<?php }?>
							<span class="soundBtn">
								<img src="/admin/skin/default/images/broadcast/i_sound_off.png" class="soundOff ">
								<img src="/admin/skin/default/images/broadcast/i_sound_on.png" class="soundOn hide">
							</span>
							<span onclick="openPopup(this);" target="sharePopup"><img src="/admin/skin/default/images/broadcast/i_share.png"></span>
							<!--span><img src="/admin/skin/default/images/broadcast/i_notify.png"></span-->
						</div>
					</div>
					<div class="status_wrap">
<?php if(serviceLimit('H_AD')){?>
						<!-- <div class="summary"><a target="<?php echo $TPL_VAR["sch"]["link_target"]?>" href="/mshop?m=<?php echo $TPL_VAR["sch"]["provider_seq"]?>"><?php echo $TPL_VAR["sch"]["provider_name"]?></a></div> -->
<?php }?>
						<div class="status">
<?php if($TPL_VAR["sch"]["status"]!='create'){?>
							<img src="/admin/skin/default/images/broadcast/i_heart.png"><span class="heart_cnt"><?php echo number_format($TPL_VAR["sch"]["likes"])?></span>
							<img src="/admin/skin/default/images/broadcast/i_view.png"><span class="view_cnt"><?php echo number_format($TPL_VAR["sch"]["sumvisitors"])?></span>
<?php }?>
<?php if($TPL_VAR["sch"]["status"]=='end'){?>
							<img src="/admin/skin/default/images/broadcast/i_video.png"><span class="playtime"><?php echo $TPL_VAR["sch"]["real_time"]?></span>
<?php }?>
						</div>
					</div>					
				</div>
				<!-- 헤더 : 끝 -->
				
				<div class="video_wrap">
<?php if($TPL_VAR["sch"]["status"]=='create'){?>	
					<!-- 방송예정 : 시작 -->
					<div class="live_expected" style="background:url(<?php echo $TPL_VAR["sch"]["image"]?>) no-repeat center center/cover;">
						<div class="info">
							<h3>방송 시작 예정입니다.</h3>
							<?php echo $TPL_VAR["sch"]["start_date"]?>

						</div>	
						<div class="dim"></div>						
					</div>
					<!-- 방송예정 : 끝 -->
<?php }elseif($TPL_VAR["sch"]["status"]=='live'){?>
					<!-- 방송중 : 시작 -->
					<iframe src="about:blank" frameborder="0" id="player" data-status="<?php echo $TPL_VAR["sch"]["status"]?>" allow="autoplay" autoplay muted></iframe>
					<div style="background:url(<?php echo $TPL_VAR["sch"]["image"]?>) no-repeat center center/cover; display:none" id="end_wrap">
						<div class="info">
							<div class="end_mess">방송이 종료되었습니다.</div>
							<div class="retry_mess">
								<div>현재 방송 상태가 원활하지 않습니다.</br>잠시 후에 다시 시도해 주세요.</div>
								<img src="/admin/skin/default/images/broadcast/refresh.png" class="btn_refresh actions" data-action="refresh">
							</div>
						</div>					
						<div class="dim"></div>
					</div>
					<!-- 방송중 : 끝 -->
<?php }elseif($TPL_VAR["sch"]["status"]=='end'){?>
					<!-- 방송종료 : 시작 -->
<?php if($TPL_VAR["vod"]){?>
					<iframe src="about:blank" frameborder="0" id="player" data-status="<?php echo $TPL_VAR["sch"]["status"]?>" allow="autoplay" autoplay muted></iframe>
<?php }else{?>
					<div style="background:url(<?php echo $TPL_VAR["sch"]["image"]?>) no-repeat center center/cover;">
						<div class="info">
							<div>종료된 방송입니다.</div>
<?php if($TPL_VAR["sch"]["vod_key"]){?>
							<div class="btn_cast_end">방송 다시보기 <img src="/admin/skin/default/images/broadcast/i_arrow.png"></div>
<?php }?>
						</div>					
						<div class="dim"></div>
					</div>
<?php }?>
					<!-- 방송종료 : 끝 -->
<?php }?>
				</div>	
				
				<div class="area_community">
					<!-- 채팅 내용 : 시작 -->
					<div class="chatting_wrap">
						<ul class="chatting"><li></li></ul>
<?php if($TPL_VAR["sch"]["status"]=='live'){?>
						<div class="notice" ><?php echo $TPL_VAR["sch"]["notice"]?></div>
						<span class="more hide" onclick="openPopup(this);" target="noticePopup">더보기</span>
<?php }?>
<?php if($TPL_VAR["ISADMIN"]&&$TPL_VAR["sch"]["status"]=='live'){?>
						<button type="button" class="notice_del actions delnoti" data-action="delnoti"><img src="/admin/skin/default/images/broadcast/btn_del.png" alt="삭제"></button>				
<?php }?>						
					</div>
					<!-- 채팅 내용 : 끝 -->
					
					<!-- 상품 : 시작 -->
					<div class="content_wrap">
						<div class="product_wrap">
							<ul class="product" onclick="openPopup(this);" target="prodectListPopup">
								<li><div><img src="<?php echo $TPL_VAR["goodsMain"]["goods_img"]?>"/></div></li>
								<li class="prod_info">
									<div class="tit"><?php echo $TPL_VAR["goodsMain"]["goods_name"]?></div>
									<div class="price">
										<?php echo $TPL_VAR["goodsMain"]["default_price"]?>

									</div>
								</li>
							</ul>
							<span class="cnt"><?php echo count($TPL_VAR["sch"]["goodsData"])?></span>
						</div>
<?php if($TPL_VAR["sch"]["status"]=='live'||$TPL_VAR["sch"]["status"]=='end'){?>
						<div class="btn_wrap">
<?php if($TPL_VAR["sch"]["status"]=='live'){?>
							<span class="chattingOpenBtn" mode="close"><img src="/admin/skin/default/images/broadcast/input_open.png"></span>
<?php }?>
							<span class="btn_heart heartBtn actions" data-action="likes">
								<img src="/admin/skin/default/images/broadcast/i_heart2.png">
								<span class="love_mot">
									<img src="/admin/skin/default/images/broadcast/love.png">
									<img src="/admin/skin/default/images/broadcast/love.png">
									<img src="/admin/skin/default/images/broadcast/love.png">
								</span>
							</span>
						</div>
<?php }?>
					</div>
					<!-- 상품 : 끝 -->

					<!-- 채팅 입력 창 : 시작 -->
<?php if($TPL_VAR["sch"]["status"]=='live'){?>
					<div class="area_input hide">
						<form id="chattingfrm">
<?php if(!$TPL_VAR["ISADMIN"]){?>
							<input type="hidden" name="name" id="name" placeholder="사용자명" value="<?php echo $TPL_VAR["userInfo"]["userid"]?>" size="5" />
							<input type="hidden" name="seq" id="seq" placeholder="회원seq" value="<?php echo $TPL_VAR["userInfo"]["member_seq"]?>" size="5" />
							<input type="hidden" name="type" id="type" value="chat" />
<?php }else{?>
							<input type="hidden" name="name" id="name" placeholder="관리자명" value="관리자(<?php echo $TPL_VAR["managerInfo"]["mname"]?>)" size="5" />
							<input type="hidden" name="seq"  id="seq" placeholder="관리자seq" value="<?php echo $TPL_VAR["managerInfo"]["manager_seq"]?>" size="5"/>
							<input type="hidden"  name="type" id="type" value="admin" />
<?php }?>
							<ul>
								<li class="input_mess"><input type="text" name="msg" id="msg" placeholder="채팅을 입력해주세요."></li>
<?php if($TPL_VAR["ISADMIN"]){?>
								<li class="admin_mess adminMessBtn">
									<img src="/admin/skin/default/images/broadcast/i_fixing_off.png" class="adminMessOff">
									<img src="/admin/skin/default/images/broadcast/i_fixing_on.png" class="adminMessOn hide">
								</li>
<?php }?>
								<li class="btn_send"><button type="submit">입력</button></li>
							</ul>
						</form>
					</div>
<?php }?>
					<!-- 채팅 입력 창 : 끝 -->
				</div>
			</div>

			<div class="bg_gradation"></div>

			<!-- 상품리스트 팝업 : 시작 -->
			<div id="prodectListPopup"  class="popup hide">
				<div class="contents">
					<div class="header">
						<div class="tit">방송 상품</div>
						<span class="btn_close" onclick="closePopup(this);"><img src="/admin/skin/default/images/broadcast/i_close2.png"></span>	
					</div>
					<div class="container">
						<ul class="product_list">
<?php if(is_array($TPL_R1=$TPL_VAR["sch"]["goodsData"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
							<li data-seq="<?php echo $TPL_V1["goods_seq"]?>">
								<ul class="product">
									<li><div><img src="<?php echo $TPL_V1["goods_img"]?>"/></div></li>
									<li class="prod_info">
										<div class="brand"><?php echo $TPL_V1["provider_name"]?></div>
										<div class="tit"><?php echo $TPL_V1["goods_name"]?></div>
										<div class="price">
<?php if($TPL_V1["sale_rate"]> 0){?>
											<span class="percent"><?php echo $TPL_V1["sale_rate"]?>%</span>
<?php }?>
											<?php echo $TPL_V1["default_price"]?>

										</div>
									</li>
								</ul>
							</li>
<?php }}?>
						</ul>
					</div>	
				</div>
			</div>
			<!-- 상품리스트 팝업 : 끝 -->
			
			<!-- 공지사항 팝업 : 시작 -->		
			<div id="noticePopup"  class="popup hide">
				<div class="contents">
					<div class="header">
						<div class="tit">공지사항</div>
						<span class="btn_close" onclick="closePopup(this);"><img src="/admin/skin/default/images/broadcast/i_close2.png"></span>	
					</div>
					<div class="container">
						<div class="mess"><?php echo $TPL_VAR["sch"]["notice"]?></div>
					</div>
				</div>
			</div>
			<!-- 공지사항 팝업 : 끝 -->		

			<!-- 공유 팝업 : 시작 -->		
			<div id="sharePopup"  class="popup hide">	
				<div class="contents2">
					<div class="share_wrap">
						<div>
							<div class="hearder">
								<div>공유 하기</div>
								<span onclick="closePopup(this);" class="btn_close"><img src="/admin/skin/default/images/broadcast/i_close4.png"></span>
							</div>	
							<div class="btn_wrap">
								<?php echo snslinkurl('broadcast',$TPL_VAR["sch"]["title"])?>

								<span class="actions" data-action="copy"><img src="/admin/skin/default/images/broadcast/i_url.png"></span>	
							</div>
						</div>
					</div>	
				</div>
			</div>
			<!-- 공유 팝업 : 끝 -->		
		</div>
	</div>
</body>
</html>