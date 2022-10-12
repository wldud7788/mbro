<?php
/**
 * @author lgs
 * @version 1.0.0
 * @license copyright by GABIA_lgs
 * @since 12. 2. 1 10:10 ~
 */

// 설정로드
function layout_config_load($skin, $tpl_path = null) {
	$CI =& get_instance();
	$cache_item_id = sprintf('skin_%s%s', $skin, $tpl_path ? '_' . str_replace('/', '_', $tpl_path) : '');
	$returnArr = cache_load($cache_item_id);
	if ($returnArr === false) {
		$aWhere['skin'] = $skin;
		if ($tpl_path != null) {
			$aWhere['tpl_path'] = $tpl_path;
		}
		$query = $CI->db->select('tpl_folder, tpl_path, tpl_desc, value, tpl_page')
		->from('fm_config_layout')
		->where($aWhere)
		->order_by('regist_date ASC, tpl_path ASC')
		->get();
		$returnArr = array();
		foreach ($query->result_array() as $row){
			if(preg_match('/a:/',$row['value'])) $row['value'] = unserialize(strip_slashes($row['value']));
			$returnArr[$row['tpl_path']]['tpl_folder'] = $row['tpl_folder'];
			$returnArr[$row['tpl_path']]['tpl_path'] = $row['tpl_path'];
			$returnArr[$row['tpl_path']]['tpl_desc'] = $row['tpl_desc'];
			$returnArr[$row['tpl_path']]['tpl_page'] = $row['tpl_page'];
			if (is_array($row['value'])) {
				foreach ($row['value'] as $k=>$v) {
					$returnArr[$row['tpl_path']][$k] = $v;
				}
			}
			if ( ! empty($returnArr[$row['tpl_path']]['backgroundImage'])) {
				$imagePath = "data/skin/".$skin."/images/design";
				$returnArr[$row['tpl_path']]['backgroundImage'] = "/".$imagePath."/".basename($returnArr[$row['tpl_path']]['backgroundImage']);
			}

			if ( ! empty($returnArr[$row['tpl_path']]['bodyBackgroundImage'])) {
				$imagePath = "data/skin/".$skin."/images/design";
				$returnArr[$row['tpl_path']]['bodyBackgroundImage'] = "/".$imagePath."/".basename($returnArr[$row['tpl_path']]['bodyBackgroundImage']);
			}
		}
		if ( ! $returnArr && $tpl_path) {
			$returnArr[$tpl_path]['tpl_path'] = $tpl_path;
		}
		if ( ! is_cli()) {
			cache_save($cache_item_id, $returnArr);
		}
	}
	return $returnArr;
}

// 설정자동로드
function layout_config_autoload($skin,$tpl_path){
	$arrLayoutBasic = layout_config_load($skin,'basic');
	$arrLayout = layout_config_load($skin,$tpl_path);

	foreach($arrLayoutBasic['basic'] as $key=>$value){
		if(!in_array($key,array('tpl_folder','tpl_path','tpl_desc','tpl_page'))){
			if(!$arrLayout[$tpl_path][$key]){
				// 개별레이아웃에 bg관련 속성이 지정된 경우 개별레이아웃 우선
				if((in_array($key, array('backgroundColor', 'backgroundImage')) && !$arrLayout[$tpl_path]['backgroundColor'] && !$arrLayout[$tpl_path]['backgroundImage'])
					||!in_array($key, array('backgroundColor', 'backgroundImage'))) {
					$arrLayout[$tpl_path][$key] = $arrLayoutBasic['basic'][$key];
				}
			}
		}
	}

	return $arrLayout;
}

// 폴더별 설정 로드
function layout_config_folder_load($skin,$tpl_folder){
	$CI =& get_instance();

	$returnArr = array();

	$map = directory_map_list(directory_map(ROOTPATH."data/skin/".$skin."/".$tpl_folder,false,false));

	foreach($map as $item){
		$tpl_path = $tpl_folder.$item;
		$returnArr[$tpl_path]['tpl_folder'] = $tpl_folder;
		$returnArr[$tpl_path]['tpl_path'] = $tpl_path;
	}


	$query = "SELECT `tpl_folder`,`tpl_path`,`tpl_desc`,`value`,`tpl_page` FROM `fm_config_layout` WHERE `skin`=? and `tpl_folder`=? order by regist_date,tpl_path";
	$query = $CI->db->query($query,array($skin,$tpl_folder));
	foreach ($query->result_array() as $row){

		if(preg_match('/a:/',$row['value'])) $row['value'] = unserialize(strip_slashes($row['value']));

		$returnArr[$row['tpl_path']]['tpl_folder'] = $row['tpl_folder'];
		$returnArr[$row['tpl_path']]['tpl_path'] = $row['tpl_path'];
		$returnArr[$row['tpl_path']]['tpl_desc'] = $row['tpl_desc'];
		$returnArr[$row['tpl_path']]['tpl_page'] = $row['tpl_page'];

		if(is_array($row['value'])){
			foreach($row['value'] as $k=>$v){
				$returnArr[$row['tpl_path']][$k] = $v;
			}
		}

	}

	/*
	if(!$returnArr && $tpl_path){
		$returnArr[$tpl_path]['tpl_path'] = $tpl_path;
	}
	*/

	if(isset($returnArr)) return $returnArr;
}

// 설정저장
function layout_config_save($skin,$tpl_path='basic',$ar_data){
	$CI =& get_instance();
	$tmpTime = time();

	$rowData = array();
	$rowData['value'] = array();

	foreach($ar_data as $key=>$value){
		if(in_array($key,array('tpl_folder','tpl_path','tpl_desc','tpl_page','regist_date'))){
			$rowData[$key] = $value;
		}else{
			$rowData['value'][$key] = $value;
		}
	}

	if( is_array($rowData['value']) ) $rowData['value'] = serialize($rowData['value']);

	if( !isset($rowData['tpl_folder']) )
	{
		$tmp = explode('/',$tpl_path);
		$rowData['tpl_folder'] = $tmp[0];
	}

	if( !isset($ar_data['tpl_page']) )
	{
		$rowData['tpl_page'] = '0';
	}

	$rowData['tpl_page'] = (string)$rowData['tpl_page'];

//	$rowData['value'] = addslashes($rowData['value']);
	$date = date('Y-m-d H:i:s',$tmpTime);

	$query = $CI->db->query("select * from `fm_config_layout` where skin=? and tpl_path=?",array($skin,$tpl_path));
	$data = $query->row_array();
	if($data){
		$query = "update `fm_config_layout` set `skin`=?,`tpl_path`=?,`tpl_folder`=?,`tpl_desc`=?,`value`=?,`regist_date`=? where skin=? and tpl_path=?";
		$CI->db->query($query,array($skin,$tpl_path,$rowData['tpl_folder'],$rowData['tpl_desc'],$rowData['value'],$date,$skin,$tpl_path));

	}else{
		$query = "insert into `fm_config_layout` set `skin`=?,`tpl_path`=?,`tpl_folder`=?,`tpl_desc`=?,`value`=?,`tpl_page`=?,`regist_date`=?";
		$CI->db->query($query,array($skin,$tpl_path,$rowData['tpl_folder'],$rowData['tpl_desc'],$rowData['value'],$rowData['tpl_page'],$date));
	}

	// 파일이 없을경우 생성
	$skinPath = APPPATH."../data/skin/";
	$tplFilePath = $skinPath.$skin."/".$tpl_path;
	if(!file_exists($tplFilePath)){
		$CI->load->helper('file');
		write_file($tplFilePath, null);
		@chmod($tplFilePath,0777);
	}

	$tmpTime++;

	// skin cache clean
	cache_clean('skin');
}

// 설정초기화
function layout_config_delete($skin){
	$CI =& get_instance();
	$query = "DELETE FROM `fm_config_layout` WHERE `skin`=?";
	$query = $CI->db->query($query,array($skin));

	// skin cache clean
	cache_clean('skin');
}

// 파일경로 목록 반환
// directory_map_list(directory_map($skin_path,false,false));
function directory_map_list($array=array(),$path=''){
	$result = array();
	if(is_array($array)){
		foreach($array as $k=>$v){
			if(is_array($v)){
				$childPath = $path.'/'.$k;
				$result[] = $childPath;
			}else{
				$childPath = $path;
			}
			$result = array_merge($result,directory_map_list($v,$childPath));
		}
		return $result;
	}else{
		return array($path.'/'.$array);
	}
}

// 스킨디렉토리의 config 가져오기,저장하기
function skin_configuration($skin, $set_except = array()){
	$CI =& get_instance();
	$skinPath = APPPATH."../data/skin/";
	$configurationPath = $skinPath.$skin."/configuration/skin.ini";
	if	($CI->gl_skin_configuration[$skin]) {
		return $CI->gl_skin_configuration[$skin];
	}else{
		if	(file_exists($configurationPath)) {
			$configuration							= parse_ini_file($configurationPath);
			$configuration['skin']					= $skin;
			$configuration['regdate']				= date('Y-m-d H:i:s',filemtime($configurationPath));

			$design_layout_config					= layout_config_load($skin,'design');
			$col_except								= array('tpl_folder', 'tpl_path', 'tpl_desc');
			foreach($design_layout_config['design'] as $key => $val){
				if	(!empty($val) && !in_array($key,$col_except))
					$configuration[$key]			= $val;
			}

			$configuration							= set_skin_configuration($configuration, $set_except);

			$CI->gl_skin_configuration[$skin]		= $configuration;

			return $configuration;
		} else return array();
	}
}

//configuration 기본값 세팅 2017-10-12 jhr
function set_skin_configuration($configuration, $set_except = array()){
	$var_default = array(	'brand_type'						=> 'y_single',
							'brand_navigation_type'				=> 'single',
							'brand_navigation_count_w'			=> '4|4|4|4',
							'category_type'						=> 'y_single',
							'category_navigation_type'			=> 'single',
							'category_navigation_count_w'		=> '4|4|4|4',
							'category_navigation_brand_count_w'	=> '6',
							'location_type'						=> 'y_single',
							'location_navigation_type'			=> 'single',
							'location_navigation_count_w'		=> '4|4|4|4',
							'topbar'							=> 'topBar|1|5|1|1');

	foreach($var_default as $key => $val){
		if	(empty($configuration[$key]) && !in_array($key,$set_except))
			$configuration[$key]			= $val;
	}

	if	(!isset($configuration['platform'])) {
		$configuration['platform']			= 'pc';
		if	(preg_match('/(mobile|storemobile)_/', $configuration['originalSkin']))
			$configuration['platform']		= 'mobile';
	}

	if	(!isset($configuration['mim_skin'])) {
		$configuration['mim_skin']			= '0';
		if	(in_array(SERVICE_CODE,array('P_ADVA', 'P_ADSC', 'P_AREN', 'P_ARSC')) || $configuration['skin_version'] == 'multi')
			$configuration['mim_skin']		= '1';
	}

	if	(!isset($configuration['language'])) {
		switch(substr($configuration['originalSkin'],-2,2)){
			case 'cn':
				$configuration['language']	= 'CN';
				break;
			case 'en':
				$configuration['language']	= 'EN';
				break;
			case 'jp':
				$configuration['language']	= 'JP';
				break;
			case 'gl':
			default:
				$configuration['language']	= 'KR';
		}
	}

	return $configuration;
}

function skin_configuration_save($skin,$key,$value){
	$result			= false;

	// 검색필터 사용여부 추가 :: 2018-11-20 lwh
	// 싱글, 더블 차수 데이터 추가 :: 2018-12-03 pjw
	$db_save_list	= array('category_type', 'category_navigation_type', 'category_navigation_use',
							'category_navigation_count_w',	'category_navigation_brand_count_w',
							'category_navigation_count_single','category_navigation_count_double',
							'brand_type', 'brand_navigation_type', 'brand_navigation_use',
							'brand_navigation_count_w', 'brand_navigation_category_count_w',
							'brand_navigation_count_single', 'brand_navigation_category_count_double',
							'location_type', 'location_navigation_type', 'brand_navigation_use',
							'location_navigation_count_w', 'location_navigation_category_count_w',
							'location_navigation_count_single', 'location_navigation_category_count_double',
							'themecolor', 'iconcolor', 'skintheme', 'topbar');

	//카테고리, 브랜드, 지역, 모바일 퀵은 db로 저장한다 jhr 2017-10-11
	if	(in_array($key, $db_save_list)) {
		$rowConfigData			= layout_config_load($skin,'design');
		$rowSaveData			= $rowConfigData['design'];
		$rowSaveData['tpl_desc']= '디자인 공용';
		$rowSaveData[$key]		= $value;
		layout_config_save($skin,'design',$rowSaveData);
		$result		= true;
	}else{
		$skinPath	= APPPATH."../data/skin/";
		$configurationPath = $skinPath.$skin."/configuration/skin.ini";

		if	(file_exists($configurationPath)) {
			$skin_configuration = parse_ini_file($configurationPath);

			$skin_configuration['skin'] = $skin;
			$skin_configuration['regdate'] = date('Y-m-d H:i:s',filemtime($configurationPath));

			if	($key && $value) $skin_configuration[$key] = $value;

			//PC,모바일 여부 및 입접형 스킨 여부
			if	(!isset($skin_configuration['platform']) || !isset($skin_configuration['mim_skin']) || !isset($skin_configuration['language'])) {
				$skin_configuration['platform']			= 'pc';
				if	(preg_match('/(mobile|storemobile)_/', $skin_configuration['originalSkin'])) {
					$skin_configuration['platform']		= 'mobile';
				}
				$skin_configuration['mim_skin']			= '0';
				if	(in_array(SERVICE_CODE,array('P_ADVA', 'P_ADSC', 'P_AREN', 'P_ARSC')) || $skin_configuration['skin_version'] == 'multi') {
					$skin_configuration['mim_skin']		= '1';
				}

				switch(substr($skin_configuration['originalSkin'],-2,2)){
					case 'cn':
						$skin_configuration['language']	= 'CN';
						break;
					case 'en':
						$skin_configuration['language']	= 'EN';
						break;
					case 'jp':
						$skin_configuration['language']	= 'JP';
						break;
					case 'gl':
					default:
						$skin_configuration['language']	= 'KR';
				}
			}

			$result = set_ini_file($configurationPath,array('information'=>$skin_configuration),true);
		}
	}

	return $result;
}

/* 스킨파일 자동 백업 */
function backup_skin_file($skin,$tpl_path){

	$CI =& get_instance();

	$CI->load->helper('directory');
	$CI->load->helper('file');

	$tpl_realpath = "data/skin/".$skin."/".$tpl_path;
	$tpl_fileName = basename($tpl_realpath);

	$skinBackupPath = "data/skin_backup/".$skin."/".$tpl_path.date('.YmdHis');
	$skinBackupFileName = basename($skinBackupPath);
	$skinBackupDir = dirname($skinBackupPath);

	/* 백업파일생성 */
	make_dir($skinBackupPath,ROOTPATH);
	$result = copy(ROOTPATH.$tpl_realpath,ROOTPATH.$skinBackupPath);

	/* 백업파일 개수 초과 삭제 */
	$tpl_fileNameForReg = str_replace('.','\.',$tpl_fileName);
	$backupMax = 5;
	$backupCount = 0;
	$map = directory_map(ROOTPATH.$skinBackupDir,true);
	rsort($map);
	foreach($map as $k=>$v){
		if(is_file(ROOTPATH.$skinBackupDir.'/'.$v) && preg_match("/{$tpl_fileNameForReg}\.[0-9]{14}/",$v)){
			$backupCount++;
			if($backupCount>$backupMax){
				@unlink(ROOTPATH.$skinBackupDir.'/'.$v);
			}
		}
	}

	return $result ? true : false;
}

/* 파일 자동 백업 */
function backup_file($tpl_path){

	$CI =& get_instance();

	$CI->load->helper('directory');
	$CI->load->helper('file');

	$tpl_realpath = $tpl_path;
	$tpl_fileName = basename($tpl_realpath);

	$backupPath = "data/file_backup/".$tpl_path.date('.YmdHis');
	$backupDir = dirname($backupPath);

	/* 백업파일생성 */
	make_dir($backupPath,ROOTPATH);
	$result = copy(ROOTPATH.$tpl_realpath,ROOTPATH.$backupPath);

	/* 백업파일 개수 초과 삭제 */
	$tpl_fileNameForReg = str_replace('.','\.',$tpl_fileName);
	$backupMax = 5;
	$backupCount = 0;
	$map = directory_map(ROOTPATH.$backupDir,true);
	rsort($map);
	foreach($map as $k=>$v){
		if(is_file(ROOTPATH.$backupDir.'/'.$v) && preg_match("/{$tpl_fileNameForReg}\.[0-9]{14}/",$v)){
			$backupCount++;
			if($backupCount>$backupMax){
				@unlink(ROOTPATH.$backupDir.'/'.$v);
			}
		}
	}

	return $result ? true : false;
}

/*
	상품디스플레이 버젼체크
	2차원 배열
	단일 객체 disabled 일 경우 key, value에 해당 class 명 넣어주세요
	특정 select box는 key값에 class명 value에는 1개 disabled시 string 으로 value 값 넣고
	selectbox에서 2개 이상 disabled 시킬 시 배열로 value 값 넣어주세요
*/
function check_display_version($platform, $styles){
	$CI =& get_instance();
	$working_skin	= $CI->designWorkingSkin;
	$mobile			= '';
	if	($platform == 'mobile' || $CI->mobileMode) {
		$working_skin	= $CI->workingMobileSkin;
		$mobile			= 'mobile_';
	}
	$working_skin_path = ROOTPATH."data/skin/".$working_skin;

	$version['20170811'] = array(
		'img_opt_lattice_a'			=>	'img_opt_lattice_a',
		'img_padding_lattice_a'		=>	'img_padding_lattice_a',
		'displayImageIconPopupLimit'=>	'displayImageIconPopupLimit',
		'use_review_option_like'	=>	'use_review_option_like',
		'image_border_type'			=>	'all',
		'info_item_kind'			=>	array('shipping','pageview'),
		'insert_paging_2'			=>	'insert_paging_2',
		'insert_paging_3'			=>	'insert_paging_3',
		'use_image_zoom'			=>	'use_image_zoom',
		'use_image_3d'				=>	'use_image_3d '
	);

	foreach($styles as $key => $val){
		$tpl_path = $working_skin_path.'/_modules/display/goods_display_'.$mobile.$key.'.html';
		$version_bak = $version;
		if	(file_exists($tpl_path)) {
			$line = file($tpl_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			$get_ver = substr($line[0], strpos($line[0], '[')+1, 8);
			foreach($version_bak as $k => $v){
				if	($k <= $get_ver) unset($version_bak[$k]);
			}

			// 반응형 - 슬라이드형(크기고정) 페이징 사용 불가
			// 반응형 - 격자형(반응형) 페이징 사용 가능 2019-07-23 by hyem
			$version_key = array_keys($version_bak);
			$version_key = $version_key[0];
			if( $CI->config_system['operation_type'] == 'light' ) {
				if( in_array($key, array('sizeswipe')) ) {
					$version_bak[$version_key]['insert_paging_1'] = 'insert_paging_1';
					$version_bak[$version_key]['insert_paging_2'] = 'insert_paging_2';
					$version_bak[$version_key]['insert_paging_3'] = 'insert_paging_3';
				} else if( in_array($key, array('responsible')) ) {
					unset($version_bak[$version_key]['insert_paging_1']);
					unset($version_bak[$version_key]['insert_paging_2']);
					unset($version_bak[$version_key]['insert_paging_3']);
				}
			}

			if	(sizeOf($version_bak) > 0)	$styles[$key]['limit_func'] = base64_encode(json_encode($version_bak));
		}
	}

	return $styles;
}

# 자동노출조건 개별 상세 설명 문구 조합
function setAutoCondition($auto_criteria, $displayKind = ''){
	$CI =& get_instance();

	$is_light		= $CI->config_system['operation_type'] == 'light' ? true : false;
	$condition		= array(
		'admin'		=> '지정한',
		'view'		=> '본',
		'cart'		=> '장바구니에 담은',
		'wish'		=> '위시리스트에 찜한',
		'fblike'	=> '좋아요한',
		'order'		=> '구매한',
		'review'	=> '리뷰를 쓴',
		'search'	=> '검색한 결과 최상위',
		'restock'	=> '재입고알림 요청한',
	);

	$act			= array(
		'order_cnt'	=> '구매(횟수)량이 높은',
		'order_ea'	=> '구매(수량)량이 높은',
		'cart'		=> '많이 장바구니에 담음',
		'wish'		=> '많이 위시리스트에 찜한',
		'view'		=> '많이 본',
		'review'	=> '상품후기가 많이 작성된',
		'review_sum'=> '베스트 상품 후기가 많은 상품',
		'fblike'	=> '‘좋아요’가 많은 상품',
		'recently'	=> '최근에 등록한 상품'
	);

	$kind_standard = array(
		'relation'			=> '상품과',
		'relation_seller'	=> '상품과',
		'category'			=> '카테고리',
		'brand'				=> '브랜드',
		'location'			=> '지역',
		'mshop'				=> '판매자'
	);

	$return_descriptions	= array();
	$div					= explode('Φ', $auto_criteria);

	if($div[0]) foreach($div as $k => $v){
		$arr			= array();
		$descriptions	= array();
		$admin_arr		= array();
		$same_arr		= array();
		$etc_arr		= array();
		$isRecently		= false;


		$detail			= explode('∀', $v);
		$criteria		= explode(',', $detail[1]);
		$kind			= $detail[0];
		if($criteria == 'isFirst=1')	return false;

		// 바로 조건 설정으로 들어온게 아닐때만 순위 노출
		if($detail[0] != 'none'){
			$descriptions[]	= '<div><strong>['.($k+1).'순위]</strong></div>';
		}

		foreach($criteria as $c_key => $c_val){
			$s_div = explode('=', $c_val);

			if(!$is_light && strpos($s_div[0], 'each_age_') !== false){
				if	(!$arr['each_age']) $arr['each_age'] = array();
				$arr['each_age'] = $s_div[1] . '대';
			}else if(!$is_light && strpos($s_div[0], 'each_sex_') !== false){
				if	(!$arr['each_sex']) $arr['each_sex'] = Array();
				$sex = '성별 모름';
				if	($s_div[1] == 'male'){
					$sex = '남성';
				}else if($s_div[1] == 'female'){
					$sex = '여성';
				}
				$arr['each_sex'] = $sex;
			}else if(!$is_light && strpos($s_div[0], 'each_agent_') !== false){
				if	(!$arr['each_agent']) $arr['each_agent'] = array();
				$arr['each_agent'] = $s_div[1];
			}else{
				if	(!$arr[$s_div[0]]) $arr[$s_div[0]] = array();
				if	($s_div[0] == 'act'){

					if	(($displayKind == 'bigdata' || $displayKind == 'bigdata_catalog') && $s_div[1] == 'recently'){
						$s_div[1] = 'order_cnt';
					}

					if	($s_div[1] == 'recently'){
						$isRecently		= true;
					}

					$arr[$s_div[0]]  = $s_div[1];
				}else{
					$arr[$s_div[0]] = $s_div[2] ? $s_div[2] : urldecode($s_div[1]);
				}
			}
		}

		// ######################## 노출 기준 #############################

		// 기준 노출 설정
		$txt_standard = '';
		if($kind == 'none'){
			$txt_standard = '해당 ' . $kind_standard[$displayKind];

		}else if($kind == 'admin'){
			$txt_standard = '관리자가 지정한 기준';

		}else{
			$txt_standard = '○○○고객이 최근 본 상품과';

		}

		$descriptions[] = '<font class="kind_title" color="#0655f9">'. $txt_standard .'</font>';

		// 동일 항목 체크
		$txt_same	= '';
		if	($kind != 'admin' && ($kind != 'none' || $displayKind == 'relation' || $displayKind == 'relation_seller')){
			if	($arr['same_category'])		$txt_same .= '동일한 카테고리 ';
			if	($arr['same_brand'])		$txt_same .= '동일한 브랜드 ';
			if	($arr['same_location'])		$txt_same .= '동일한 지역 ';
			if	($arr['same_seller'])		$txt_same .= '동일한 판매자 ';
		}
		$descriptions[] = $txt_same;



		if	($arr['selectCategory1'] || $arr['selectCategory2'] || $arr['selectCategory3'] || $arr['selectCategory4']){
			$cartegory_str = '';
			if	($arr['selectCategory1'])
				$cartegory_str = $arr['selectCategory1'];
			if	($arr['selectCategory2'])
				$cartegory_str = $arr['selectCategory2'];
			if	($arr['selectCategory3'])
				$cartegory_str = $arr['selectCategory3'];
			if	($arr['selectCategory4'])
				$cartegory_str = $arr['selectCategory4'];
			$admin_arr[]	= $cartegory_str . ' 카테고리';
		}

		if	($arr['selectBrand1'] || $arr['selectBrand2'] || $arr['selectBrand3'] || $arr['selectBrand4']){
			$brand_str = '';
			if	($arr['selectBrand1'])
				$brand_str = $arr['selectBrand1'];
			if	($arr['selectBrand2'])
				$brand_str = $arr['selectBrand2'];
			if	($arr['selectBrand3'])
				$brand_str = $arr['selectBrand3'];
			if	($arr['selectBrand4'])
				$brand_str = $arr['selectBrand4'];
			$admin_arr[]	= $brand_str . ' 브랜드';
		}

		if	($arr['selectLocation1'] || $arr['selectLocation2'] || $arr['selectLocation3'] || $arr['selectLocation4']){
			$location_str = '';
			if	($arr['selectLocation1'])
				$location_str = $arr['selectLocation1'];
			if	($arr['selectLocation2'])
				$location_str = $arr['selectLocation1'];
			if	($arr['selectLocation3'])
				$location_str = $arr['selectLocation1'];
			if	($arr['selectLocation4'])
				$location_str = $arr['selectLocation1'];
			$admin_arr[]	= $location_str . ' 지역';
		}

		if	($arr['provider'] == 'all'){
			$admin_arr[]	= '전체 판매자';
		}else if($arr['provider'] == '1'){
			$admin_arr[]	= '본사';
		}else if($arr['provider'] == 'seller'){
			$admin_arr[]	= $arr['provider_name'] . ' 판매자';
		}

		if	(count($admin_arr) > 0)		$descriptions[]	= implode(', ', $admin_arr);

		$descriptions[]	= '상품 중에서 ';

		// 빅데이터 설정인 경우
		if	($displayKind == 'bigdata'){
			if ($arr['bigdata_month'] == null) $arr['bigdata_month'] = '1';
			$descriptions[] = '<br />이 상품을 최근 '+$arr['bigdata_month']+'개월 안에 <font class="act_title" color="#ff0000">' . $condition[$kind] . '</font> 다른 고객이</font>';
		}else{
			if	($isRecently)	$descriptions[]	= '<br />관리자가';
			else				$descriptions[]	= '<br />다른 고객이';
		}

		// ######################## 노출 기준 #############################

		// ######################## 통계대상기간 #############################
		$txt_date_sub	= $arr['act'] != null && $arr['act'] == 'review_sum' ? '<br/>누적 기간동안' : '<br />최근 ' . $arr['month'] . '개월 동안';
		$descriptions[]	= $txt_date_sub;
		// ######################## 통계대상기간 #############################


		// ######################## 통계대상연령,성별,환경 #############################
		if	(!$is_light && !$isRecently){
			if	($arr['age'] == 'all'){
				$etc_arr[] = '전체 연령';
			}else if($arr['age'] == 'each'){
				if	($arr['each_age'])		$etc_arr[] = $arr['each_age'];
			}else{
				$etc_arr[] = '같은 연령';
			}

			if	($arr['sex'] == 'all'){
				$etc_arr[] = '전체 성별';
			}else if($arr['sex'] == 'each'){
				if	($arr['each_sex'])		$etc_arr[] = $arr['each_sex'] . '이';
			}else{
				$etc_arr[] = '같은 성별';
			}

			if	($arr['agent'] == 'all'){
				$etc_arr[] = '전체 환경에서';
			}else if($arr['agent'] == 'each'){
				if	($arr['each_agent'])	$etc_arr[] = $arr['each_agent'] . '환경에서';
			}else{
				$etc_arr[] = '같은 환경에서';
			}

			if	(count($etc_arr) > 0)	$descriptions[] = implode(', ', $etc_arr);
		}

		$descriptions[] = '<br />';
		// ######################## 통계대상연령,성별,환경 #############################


		// ######################## 통계대상행동 #############################
		$descriptions[] = $act[$arr['act']] . '<br />';
		// ######################## 통계대상행동 #############################


		$descriptions[] = '승인, 노출, 정상 상태의 상품이 최소 ' . $arr['min_ea'] . '종 이상일 때 추천상품 노출';

		$return_descriptions[] = implode(' ', $descriptions);
	}

	if(count($return_descriptions) > 0){
		$return = implode('<div style="width:98%;border-top:1px solid #dadada;margin-top:5px;margin-bottom:5px;"></div>', $return_descriptions);
	}else{
		$return = '설정된 조건이 없습니다.';
	}

	return $return;
}

// 상품 정보 파일 치환 :: 2018-11-23 lwh
function design_file_override($contents, $params){
	foreach($params as $code => $val){
		$contents = str_replace($code, $val, $contents);
	}
	return $contents;
}

// 현재 스킨 버전 가져오기
// 전용스킨에 대응하여 모바일 여부에 따라 스킨버전 분기처리
// $is_work : 디자인작업 스킨버전을 가져올지 여부 (기본값 : false)
function get_skin_patch_version($is_work = false){
	$CI =& get_instance();

	// 기본 스킨값
	$target_skin = $CI->config_system['skin'];

	// 모바일일때 모바일 전용스킨 버전을 가져오게 분기처리
	if($CI->mobileMode){

		// 디자인 작업용 스킨을 가져올지 여부 판단
		if($is_work)	$target_skin = $CI->config_system['workingMobileSkin'];
		else			$target_skin = $CI->config_system['mobileSkin'];
	}else{

		// 디자인 작업용 스킨을 가져올지 여부 판단
		if($is_work)	$target_skin = $CI->config_system['workingSkin'];
		else			$target_skin = $CI->config_system['skin'];

	}

	$skin_config = skin_configuration($target_skin);
	return $skin_config['patch_version'];
}

// 스킨 버전 검사 후 메세지 출력 기능
// 전용스킨에서도 검사 가능하게 수정
// minimum : 최소 스킨 버전 (해당 버전 이상인지 체크)
// maximum : 최대 스킨 버전 (해당 버전 미만인지 체크)
function check_skin_version($minimum, $maximum=null){
	$CI =& get_instance();

	// 기본 결과값 설정
	$result = false;

	// 스킨 버전 체크
	$version_result = in_skin_version($minimum, $maximum);

	// 각 결과값에 맞는 메세지 출력 혹은 결과값 리턴
	switch($version_result){
		case 0:
			$result = true;
			break;
		case -1:
			break;
		case 1:
			openDialogAlert('<span class="red">반응형 스킨 '.$minimum.' 버전 이상부터 지원되는 기능입니다.</span><br/>기능 사용 방법 : [<a href="../design/skin_add" target="_blank">디자인 > 스킨 추가</a>] 메뉴에서 '.$minimum.' 버전을 추가 후<br/>[<a href="../design/skin" target="_blank">디자인 > 스킨 설정</a>] 메뉴에서 '.$minimum.' 버전을 설정 하십시오.',500,180,'parent',null);
			break;
		case 2:
			openDialogAlert('<span class="red">반응형 스킨 '.$maximum.' 버전 미만부터 지원되는 기능입니다.</span><br/>기능 사용 방법 : [<a href="../design/skin_add" target="_blank">디자인 > 스킨 추가</a>] 메뉴에서 '.$maximum.' 버전을 추가 후<br/>[<a href="../design/skin" target="_blank">디자인 > 스킨 설정</a>] 메뉴에서 '.$maximum.' 버전을 설정 하십시오.',500,180,'parent',null);
			break;
	}

	return $result;
}

// 스킨 버전 검사 함수
// minimum : 최소 스킨 버전 (해당 버전 이상인지 체크)
// maximum : 최대 스킨 버전 (해당 버전 미만인지 체크)
// @return : { -1: 스킨버전이 없음, 0: 범위 내에 있음, 1: 최소버전 이하, 2: 최대버전 이상 }
function in_skin_version($minimum, $maximum=null){
	$CI =& get_instance();

	// 현재 스킨 버전 가져옴
	$patch_version	= get_skin_patch_version();

	// 버전에 텍스트가 포함된 경우가 있으므로 숫자만 비교하기 위해 숫자를 제외한 나머지텍스트 제거
	$patch_version = preg_replace('/[^0-9]/', '', $patch_version);

	// patch_version 여부
	if(!empty($patch_version)){
		// 최소 스킨 버전 여부 확인
		if(!empty($minimum) && $minimum > $patch_version)		return 1;
		// 최대 스킨 버전 여부 확인
		if(!empty($maximum) && $maximum <= $patch_version)		return 2;

		return 0;
	}else{
		return -1;
	}
}

/* 노출용 스킨 파일 경로, 파일 체크 */
function check_display_skin_file($sSkin, $sTpl)
{
	$CI =& get_instance();
	$CI->load->helper('file');
	$sRealSkinPath = realpath(ROOTPATH . '/data/skin/' . $sSkin);
	$sRealPath = realpath($sRealSkinPath . '/' . $sTpl);
	$sLayoutPath = $sSkin . '/' . $sTpl;
	$sMimeExt = get_mime_by_extension($sRealPath);

	// 경로 벗어남 방지
	if (preg_match("/\.\./", $sTpl)) {
		return false;
	}

	// 스킨 경로 체크
	if ( ! $sRealSkinPath) { // 스킨 경로 체크
		return false;
	}

	// 경로 체크
	if ( ! $sTpl) {
		return false;
	}
	if ( ! $sRealPath) {
		return false;
	}
	if (strpos($sRealPath, $sRealSkinPath) === false) {
		return false;
	}

	// mime 체크
	if ($sMimeExt !== 'text/html') {
		return false;
	}

	return $sLayoutPath;
}

// END
/* End of file design_helper.php */
/* Location: ./app/helpers/design_helper.php */
