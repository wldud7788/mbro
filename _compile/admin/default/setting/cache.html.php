<?php /* Template_ 2.2.6 2022/05/17 12:36:55 /www/music_brother_firstmall_kr/admin/skin/default/setting/cache.html 000004532 */ ?>
<?php $this->print_("layout_header",$TPL_SCP,1);?>

<script type="text/javascript" src="/app/javascript/js/admin/gSearchForm.js?mm=<?php echo date('Ymd')?>"></script>

<link rel="stylesheet" type="text/css" href="/admin/skin/default/css/searchform.css" />
<script type="text/javascript">
var gl_cache_area       = '<?php echo $TPL_VAR["cache_area"]?>';
var gl_platform         = '<?php echo $TPL_VAR["platform"]?>';
var gl_auto_generation  = '<?php echo $TPL_VAR["auto_generation"]?>';
var gl_cache_use        = '<?php echo $TPL_VAR["cache_use"]?>';
var gl_search_favorite  = '<?php echo $TPL_VAR["search_favorite"]?>';
</script>
<script type="text/javascript" src="/app/javascript/js/admin-settingCache.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	gSearchForm.init({'pageid':'cache', 'sc':<?php echo $TPL_VAR["scObj"]?>});

    if(gl_cache_area) $("input[name='cache_area']").each(function(){if($(this).val()==gl_cache_area) $(this).attr('checked', true);});    
    if(gl_platform) $("select[name='platform'] option[value="+gl_platform+"]").attr("selected", true);
    if(gl_auto_generation) $("select[name='auto_generation'] option[value="+gl_auto_generation+"]").attr("selected", true);    
    if(gl_cache_use) $("select[name='cache_use'] option[value='"+gl_cache_use+"']").attr("selected", true);    
    if(gl_search_favorite) $("select[name='search_favorite'] option[value="+gl_search_favorite+"]").attr("selected", true);

    set_availability();
    get_contents();
	setContentsRadio("cache_area","<?php echo $TPL_VAR["sc"]["cache_area"]?>")
});
</script>
<!-- 페이지 타이틀 바 : 시작 -->
<div id="page-title-bar-area">
	<div id="page-title-bar">
<?php $this->print_("require_info",$TPL_SCP,1);?>


		<!-- 타이틀 -->
		<div class="page-title">
			<h2>캐시</h2>
		</div>		
	</div>
</div>
<!-- 페이지 타이틀 바 : 끝 -->


<!-- 서브 레이아웃 영역 : 시작 -->
<div class="contents_container">
	<!-- 서브메뉴 바디 : 시작-->
	<div id="search_container" class="search_container">
		<form name=""  method="get" class='search_form' >						
		<table class="table_search">
			<tr>
				<th>캐시 영역</th>
				<td>	
					<input type="hidden" name="page" value="<?php echo $TPL_VAR["page"]?>" />
					<div class="resp_radio">
						<label><input type="radio" name="cache_area" value="display" checked > 상품디스플레이</label>					
						<label><input type="radio" name="cache_area" value="main" > 메인페이지</label>   
					</div>
				</td>
			</tr>				
			<tr class="cache_area_display hide">
				<th>검색어</th>
				<td>					
					<input type="text" name="keyword" value="<?php echo $_GET["keyword"]?>" title="" size="80"/>
				</td>
			</tr>
			<tr class="cache_area_display hide">
				<th>플랫폼</th>
				<td>
					<div class="resp_radio">
<?php if($TPL_VAR["config_system"]["operation_type"]=='light'){?>
						<label><input type="radio" name="platform" value="responsive" checked> 반응형</label>
<?php }else{?>       
						<label><input type="radio" name="platform" value="" checked> 전체	</label>
						<label><input type="radio" name="platform" value="pc"> 데스크탑</label>
						<label><input type="radio" name="platform" value="mobile"> 모바일</label>
<?php }?>   		
					</div>
				</td>
			</tr>			
			<tr class="cache_area_display hide">
				<th>상세 검색</th>
				<td>	
					<select name="auto_generation">
						<option value="">캐시파일 자동생성</option>                                
						<option value="y">생성</option>
						<option value="n">미생성</option>
					</select>                            
					<select name="cache_use">
						<option value="">캐시파일 사용</option>
						<option value="y">사용</option>
						<option value="n">미사용</option>
					</select>                            
					<select name="search_favorite">
						<option value="">즐겨찾기</option>
						<option value="y">선택됨</option>                                
					</select>       
				</td>
			</tr>
			
		</table>
		<div class="search_btn_lay"></div>
		</form>
	</div>

	<div class="contents_dvs">
		<div id="cacheListContents"></div> 
	</div>
	<!-- 서브메뉴 바디 : 끝 -->
</div>

<?php $this->print_("layout_footer",$TPL_SCP,1);?>