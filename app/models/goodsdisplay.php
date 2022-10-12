<?php
class Goodsdisplay extends CI_Model {

	var $title;				# 디스플레이 타이틀
	var $style;				# 리스트 스타일
	var $platform;			# 플랫폼(pc/mobile)
	var $count_w;			# 가로 출력수
	var $count_w_lattice_b;	# 격자형B 가로 출력수
	var $count_h_lattice_b;	# 격자형B 세로 출력수
	var $count_w_rolling_v; # 수직롤링형 세로 개수
	var $count_h_list;		# 리스트형 세로 출력수
	var $count_w_swipe;		# 모바일 스와이프형 가로 출력수
	var $count_h_swipe;		# 모바일 스와이프형 세로 출력수
	var $count_max_swipe;	# 모바일 스와이프형 최대 출력수
	var $count_h;			# 세로 출력수
	var $perpage;			# 출력상품수
	var $image_size;		# 이미지 사이즈
	var $mobile_h;			# 모바일 세로이미지 사이즈
	var $displayGoodsList;	# 상품 리스트
	var $displayTabsList;	# 탭 상품 리스트
	var $display_key;
	var $image_decorations;	# 이미지꾸미기 세팅값
	var $info_settings;		# 상품정보 세팅값
	var $text_align;		# 상품정보 정렬
	var $target;			# 링크 타겟
	var $tab_design_type;	# 탭 디자인타입
	var $navigation_paging_style ;	# 모바일 네비게이션 디자인타입
	var $is_bigdata_display;	# 빅데이터용 디스플레이 여부

	var $kind;			# 링크 타겟
	var $goods_video_type;			# 링크 타겟
	var $videosize_w;			# 링크 타겟
	var $videosize_h;			# 링크 타겟

	var $auto_use;			# 상품 자동노출 여부
	var $auto_order;		# 자동노출 순서
	var $auto_category_code;# 카테고리 조건
	var $auto_brand_code;	# 브랜드 조건
	var $auto_goods_status;	# 상품상태
	var $auto_term_type;	# 기간 타입(relative,absolute)
	var $auto_term;			# 기간 n일
	var $auto_start_date;	# 기간 시작일
	var $auto_end_date;		# 기간 종료일
	var $m_list_use;		#모바일 디스플레이 사용 여부
	var $isRecommend;		# 추천상품 영역
	var $paging_style;		# 페이징 종류
	var $ajax_call;			# ajax 호출여부
	var $hash_paging;		# 뒤로가기버튼 클릭시 전 페이지에서 불렀던 상품 모두 불러오기 위함

	var $displayCachDir	= 'data/display_cach/';	# 디스플레이 캐싱파일 저장 경로

	var $displayTitle;	#자동조건별 상품디스플레이 타이틀

	# 리스트 스타일 종류
	var $styles = array(
		'lattice_a'		=>	array('name'=>'격자형A','count_w'=>4, 'count_h'=>2),
		'lattice_b'		=>	array('name'=>'격자형B','count_w'=>2, 'count_h'=>2),
		'list'			=>	array('name'=>'리스트형','count_w'=>1, 'count_w'=>1,'count_w_fixed'=>true),
		'rolling_h'		=>	array('name'=>'수평롤링형','count_w'=>4, 'count_h'=>1),
		'rolling_v'		=>	array('name'=>'수직롤링형','count_w'=>2, 'count_h'=>1),
		'responsible'	=>	array('name'=>'격자형(반응형)'),
		'sizeswipe'		=>	array('name'=>'슬라이드형(크기고정)'),
		/*
		'scroll'		=>	array('name'=>'스크롤형'),
		'tab_h'			=>	array('name'=>'가로탭형'),
		'tab_v'			=>	array('name'=>'세로탭형')
		*/
	);

	# 모바일 스타일 종류
	var $mobilestyles = array(
		'newmatrix'			=>	array('name'=>'격자형(개수고정)','count_w'=>2),
		'newswipe'			=>	array('name'=>'슬라이드형(개수고정)','count_w'=>2),
		'responsible'		=>	array('name'=>'격자형(반응형)','count_w'=>4),
		'sizeswipe'			=>	array('name'=>'슬라이드형(크기고정)','count_w'=>4),
	);

	# 모바일 스타일 종류
	var $mobilestyles_list = array(
		'lattice_a'				=>	array('name'=>'격자형(개수고정)','count_w'=>2),
		'lattice_responsible'	=>	array('name'=>'격자형(반응형)','count_w'=>2),
	);

	# 동영상 스타일 종류
	var $videostyles = array(
		'video_lattice_a'		=>	array('name'=>'격자형A','count_w'=>4),
		'video_lattice_b'		=>	array('name'=>'격자형B','count_w'=>2,'count_w_fixed'=>true),
		'video_list'			=>	array('name'=>'리스트형','count_w'=>1,'count_w_fixed'=>true),
		'video_rolling_h'		=>	array('name'=>'수평롤링형','count_w'=>4)
	);


	# 리스트 정렬순서
	var $orders = array(
		'popular'		=> '인기순',
		'newly'			=> '최근등록순',
		'popular_sales'	=> '판매인기순',
		'low_price'		=> '낮은가격순',
		'high_price'	=> '높은가격순',
		'review'		=> '상품평많은순',
	);

	# 상품자동노출 타입
	var $auto_orders = array(
		'newly'			=> '최근등록순(신상품 순서)',
		'deposit_price'	=> '판매 인기순(구매금액)',
		'deposit'		=> '판매 인기순(구매횟수)',
		'review'		=> '상품평 많은순',
		'cart'			=> '장바구니 담기 많은순',
		'wish'			=> '위시리스트 담기 많은순',
		'discount'		=> '할인율 높은순',
		'view'			=> '상품조회 많은순',
	);

	var $h_rolling_type;	# 수평롤링디스플레이 롤링 타입
	var $v_rolling_type;	# 수직롤링디스플레이 롤링 타입
	var $remain;			# 롤링디스플레이 잔여DIV
	var $img_opt_lattice_a;	# lattica_a 최적화여부
	var $img_optimize;		# 이미지 최적화여부
	var $img_padding;		# 이미지 최적화 일때 이미지 여백

	function __construct() {
		parent::__construct();

		$list_arr	= getAlert('gv096');
		$list_arr	= explode('|',$list_arr);

		$this->orders = array(
			'popular'		=> $list_arr[0],
			'newly'			=> $list_arr[1],
			'popular_sales'	=> $list_arr[2],
			'low_price'		=> $list_arr[3],
			'high_price'	=> $list_arr[4],
			'review'		=> $list_arr[5]
		);
	}

	function set($k,$v){
		$this->$k = $v;
	}

	function make_display_key(){
		$this->display_key = "designDisplay_".uniqid();
		return $this->display_key;
	}

	function get_styles($type = null){
		$styles = $this->styles;
		$designWorkingSkin = $this->designWorkingSkin;
		if	($type == 'mobile') {
			$styles = $this->mobilestyles;
			$designWorkingSkin = $this->workingMobileSkin;
		}
		$working_skin_path = ROOTPATH."data/skin/".$designWorkingSkin;
		$files = directory_map($working_skin_path."/_modules/display",true,false);
		$custom_files = array();
		foreach($files as $file){
			if(!preg_match("/^goods_display_(.*).html$/i",$file)) continue;

			$chk_name = str_replace(array("goods_display_",".html"),"",$file);

			if($chk_name=='person' || strstr($chk_name,'video_') || strstr($chk_name,'mobile_') ) continue;

			if(!in_array($chk_name,array_keys($this->styles)) && preg_match("/^goods_display_/",$file)){
				$tmp = explode(".",$file);
				$style = preg_replace("/^goods_display_/","",$tmp[0]);
				$styles[$style] = array(
					'custom' => true,
					'name' => preg_replace("/^goods_display_/","",$style)
				);
			}
		}

		$styles = check_display_version('pc', $styles);

		return $styles;
	}

	function get_mobilestyles(){
		$styles = $this->mobilestyles;

		$working_skin_path = ROOTPATH."data/skin/".$this->designWorkingSkin;
		$files = directory_map($working_skin_path."/_modules/display",true,false);
		$custom_files = array();

		foreach($files as $file){
			if(!preg_match("/^goods_display_mobile_(.*).html$/i",$file)) continue;

			$chk_name = str_replace(array("goods_display_mobile_",".html"),"",$file);

			if(!in_array($chk_name,array_keys($this->mobilestyles)) && preg_match("/^goods_display_mobile_/",$file)){
				$tmp = explode(".",$file);
				$style = preg_replace("/^goods_display_mobile_/","",$tmp[0]);
				$styles[$style] = array(
					'custom' => true,
					'name' => preg_replace("/^goods_display_mobile_/","",$style)
				);
			}
		}

		$styles = check_display_version('mobile', $styles);

		return $styles;
	}

	function get_videostyles(){
		$styles = $this->videostyles;

		$working_skin_path = ROOTPATH."data/skin/".$this->designWorkingSkin;
		$files = directory_map($working_skin_path."/_modules/display",true,false);
		$custom_files = array();

		foreach($files as $file){
			if(!preg_match("/^goods_display_(.*).html$/i",$file)) continue;

			$chk_name = str_replace(array("goods_display_",".html"),"",$file);

			if($chk_name=='person' || $chk_name=='video_person') continue;

			if(!in_array($chk_name,array_keys($this->videostyles)) && preg_match("/^goods_display_/",$file) && strstr($chk_name,'video_')){
				$tmp = explode(".",$file);
				$style = preg_replace("/^goods_display_/","",$tmp[0]);
				$styles[$style] = array(
					'custom' => true,
					'name' => preg_replace("/^goods_display_/","",$style)
				);
			}
		}

		return $styles;
	}
	/* 상품디스플레이 이미지꾸미기 아이콘 목록 반환 */
	function get_image_icons($childDir=''){
		$this->load->helper('directory');
		$path = 'data/icon/goodsdisplay';
		if($childDir) $path .= '/'.$childDir;

		if(!is_dir($path)) {
			@mkdir($path);
			@chmod($path,0777);
		}

		$map = directory_map(ROOTPATH.$path, TRUE);
		$icons = array();
		foreach($map as $name){
			if(preg_match("/(.*)\.(gif|jpg|png|bmp|jpeg)$/",$name)) $icons[] = $name;
		}
		return $icons;
	}

	/* 디자인 상품디스플레이 정보 반환 */
	function get_display($display_seq, $setting = false){
		$query = $this->db->query("select * from fm_design_display where display_seq = ?",$display_seq);
		$result = $query->row_array();
		if($result){
			$result['auto_goods_status'] = explode('|',$result['auto_goods_status']);

			if	($result['image_decoration_type'] == 'favorite')
				$result['image_decorations'] = $result['image_decoration_favorite'];

			if	($result['goods_decoration_type'] == 'favorite')
				$result['info_settings'] = $result['goods_decoration_favorite'];
		}

		if	(!$setting) $result = $this->set_display_default($result);

		return $result;
	}

	/* 디스플레이 타입으로 디자인 상품디스플레이 정보 반환 */
	function get_display_type($type='relation', $platform = null){
		$sql		= "select * from fm_design_display where kind = ?";
		if	($platform) {
			$sql	.= " and platform = '{$platform}'";
		}
		//$sql		.= " order by display_seq desc";
		$query		= $this->db->query($sql,array($type));
		$display	= $query->row_array();
		if($display){
			$display['auto_goods_status'] = explode('|',$display['auto_goods_status']);

			if	($display['image_decoration_type'] == 'favorite')
				$display['image_decorations'] = $display['image_decoration_favorite'];

			if	($display['goods_decoration_type'] == 'favorite')
				$display['info_settings'] = $display['goods_decoration_favorite'];
		}
		$result		= $this->set_display_default($display);
		return $result;
	}

	/* 스타일별로 가로,세로 개수 / 이미지 사이즈 재정의 */
	function set_display_default($result){
		if	($result['style'] != 'lattice_a' && $result['platform'] == 'pc') {
			$default_style				= $this->styles[$result['style']];
			if	($default_style['count_w_fixed']!=1 && $result['count_w_'.$result['style']] > 0)
				$result['count_w']		= $result['count_w_'.$result['style']];
			if	($result['count_h_'.$result['style']] > 0)
				$result['count_h']		= $result['count_h_'.$result['style']];
			if	($result['image_size_'.$result['style']])
				$result['image_size']	= $result['image_size_'.$result['style']];
		}

		return $result;
	}

	/* 디자인 상품디스플레이 정보 반환 */
	function get_display_tab($display_seq,$tabIndex=null){
		$sql = "select a.style, a.platform, b.* from fm_design_display a left join fm_design_display_tab b on a.display_seq=b.display_seq where a.display_seq = ? ";
		if(!is_null($tabIndex)) $sql .= " and b.display_tab_index='".((int)$tabIndex)."'";
		$sql .= " order by b.display_tab_index asc";
		$query = $this->db->query($sql,$display_seq);
		$result = $query->result_array();
		return $result;
	}

	/* 디자인 상품디스플레이 상품목록 반환 */
	function get_display_item($display_seq,$display_tab_index=0){
		$display_item = array();

		// 상품 아이콘 서브쿼리
		$goods_icon_subquery = "
		select group_concat(c.codecd) from fm_goods_icon c where c.goods_seq=g.goods_seq and
		(
			(ifnull(start_date,'0000-00-00') = '0000-00-00' and ifnull(end_date,'0000-00-00') = '0000-00-00')
			or
			(curdate() between start_date and end_date)
			or
			(start_date <= curdate() and ifnull(end_date,'0000-00-00') = '0000-00-00')
		)
		";

		$query  = $this->db->query("
		select
			g.goods_seq,
			g.goods_name,
			g.summary,
			g.string_price_use,
			g.string_price,
			(select image from fm_goods_image where goods_seq=g.goods_seq and cut_number=1 and image_type=a.image_size limit 1) as image,
			o.consumer_price,
			o.price,
			o.reserve_rate,
			o.reserve_unit,
			o.reserve,
			({$goods_icon_subquery}) as icons,
			(select provider_name from fm_provider p where g.provider_seq = p.provider_seq) as provider_name
		from
			fm_design_display a
			inner join fm_design_display_tab_item d on a.display_seq=d.display_seq
			inner join fm_goods g on (d.goods_seq=g.goods_seq and g.goods_view='look')
			left join fm_goods_option o on (o.goods_seq=g.goods_seq and o.default_option ='y')
		where d.display_seq = ? and d.display_tab_index = ?
		order by d.display_tab_item_seq asc",array($display_seq,$display_tab_index));
		foreach ($query->result_array() as $row) $display_item[] = $row;

		return $display_item;
	}

	function decode_image_decorations($image_decorations_string){
		/* 이미지 꾸미기 값 파싱 */
		$image_decorations = json_decode(base64_decode($image_decorations_string));

		/* 이미지 사이즈 기본값 */
		if(!isset($image_decorations->image_size) || !$image_decorations->image_size){
			$image_decorations->image_size = "list1";
		}

		/* 이미지 테두리두께 기본값 */
		if(!isset($image_decorations->image_border_width) || !$image_decorations->image_border_width){
			$image_decorations->image_border_width = "1";
		}

		/* 이미지 오버레이 */
		if(isset($image_decorations->image_overay_plus1)){
			$image_decorations->image_overay_plus1_set = json_decode(base64_decode($image_decorations->image_overay_plus1),true);
		}

		if(isset($image_decorations->image_overay_plus1_main)){
			$image_decorations->image_overay_plus1_main_set = json_decode(base64_decode($image_decorations->image_overay_plus1_main),true);
		}

		if(isset($image_decorations->image_overay_plus2)){
			$image_decorations->image_overay_plus2_set = json_decode(base64_decode($image_decorations->image_overay_plus2),true);
		}

		if(isset($image_decorations->image_overay_plus2_main)){
			$image_decorations->image_overay_plus2_main_set = json_decode(base64_decode($image_decorations->image_overay_plus2_main),true);
		}
		return $image_decorations;
	}

	function info_settings_have_eventprice($info_settings){
		$info_settings = json_decode($info_settings);

		foreach((array)$info_settings as $k=>$v){
			if($v->kind=='event_text') return true;
		}

		return false;
	}

	function print_($return=false){

		//if(count($this->displayGoodsList)==0) return;

		if(!$this->goodsStatusImage){
			$data = code_load('goodsStatusImage');
			$this->goodsStatusImage = array();
			foreach($data as $row){
				$this->goodsStatusImage[$row['codecd']] = $row['value'];
			}
		}

		$display_key = $this->display_key ? $this->display_key : $this->make_display_key();

		if(!$this->style){
			echo '디스플레이 설정값이 누락되었습니다.';
			return;
		}

		if(!$this->count_w) $this->count_w = $this->styles['lattice_a']['count_w'];
		if(!$this->count_h) $this->count_h = 3;
		if(!$this->count_w_lattice_b) $this->count_w_lattice_b = $this->styles['lattice_b']['count_w'];
		if($this->count_w*$this->count_h < $this->perpage){
			$this->count_h = ceil($this->perpage / $this->count_w);
		}
		if(!$this->platform) $this->platform = 'pc';

		$goodsImageSize = config_load('goodsImageSize');
		/*
			같은 화면내에 디스플레이가 중첩되었을 경우
			display_skin assign값이 중첩됨 모바일 전용페이지에선 사용하지 않으므로 unset
			2016-03-21 jhr
		*/
		$isMobile = false;

		/* 모바일모드일 경우*/
		if($this->mobileMode || $this->storemobileMode){
			if($this->platform=='mobile'){
				if(!$this->style || (!$this->designMode && $this->realMobileSkinVersion < 3 && $this->style == 'responsible') || ($this->designMode && $this->workingMobileSkinVersion < 3 && $this->style == 'responsible'))
					$this->style = 'newmatrix';

				if((!$this->designMode && $this->realMobileSkinVersion < 3 && $this->style == 'sizeswipe') || ($this->designMode && $this->workingMobileSkinVersion < 3 && $this->style == 'sizeswipe'))
					$this->style = 'newswipe';

				if(!preg_match("/^mobile_/",$this->style))
					$this->style = 'mobile_'.$this->style;
				$isMobile = true;
			}else{

				if(in_array(uri_string(),array('goods/catalog','goods/brand','goods/location','goods/search'))){
					$style_str = 'mobile_lattice_a';
					if($this->realMobileSkinVersion > 2 && $this->m_list_use == 'y') $style_str = $this->style;
					$this->style = ($_GET['display_style'] && !$this->isRecommend) ? $_GET['display_style'] : $style_str;
					if	($this->isRecommend && !preg_match("/^mobile_/",$this->style))
						$this->style = 'mobile_'.$this->style;
				}else if($this->style!='person'){
					$this->style = $_GET['display_style'] ? $_GET['display_style'] : 'mobile_lattice_a';
					$_GET['display_style'] = $this->style;
				}

				if($this->count_w >= 3 && $this->style != 'mobile_lattice_a') {
					$this->count_h = ceil(($this->count_w*$this->count_h)/3);
					$this->count_w = '3';
				}

				$goodsImageSize[$this->image_size]['width'] = round(100/$this->count_w).'%';
			}
		}

		// 더보기 페이징을 위해 세로개수를 다시 구한다
		if(($this->style == 'lattice_a' && $this->paging_style == 'style2') || $this->hash_paging > 0){
			$this->count_h = ceil(count($this->displayTabsList[0]['record'])/$this->count_w);
		}

		if($this->style=='lattice_b'){
			$perpage = $this->count_w * $this->count_h;
			$this->count_w = $this->count_w_lattice_b;
			$this->count_h = $this->count_h_lattice_b > 0 ? $this->count_h_lattice_b : ceil($perpage/$this->count_w);
		}
		if($this->style=='list'){
			$perpage = $this->count_w * $this->count_h;
			$this->count_w = 1;
			$this->count_h = $this->count_h_list > 0 ? $this->count_h_list : ceil($perpage/$this->count_w);
		}

		/* 격자형 스타일 틀*/
		$grid = array();
		for($i=0;$i<$this->count_h;$i++){
			for($j=0;$j<$this->count_w;$j++){
				$idx = $i*$this->count_w+$j;

				if($idx < count($this->displayGoodsList)){
					$grid[$i][$j] = true;
				}else{
					$grid[$i][$j] = false;
				}
			}
			if($idx >= count($this->displayGoodsList)-1) break;
		}

		/* 격자형 스타일 탭별 틀 */
		foreach($this->displayTabsList as $k=>$v){
			$tabGrid = array();
			for($i=0;$i<$this->count_h;$i++){
				for($j=0;$j<$this->count_w;$j++){
					$idx = $i*$this->count_w+$j;

					if($idx < count($v['record'])){
						$tabGrid[$i][$j] = true;
					}else{
						$tabGrid[$i][$j] = false;
					}
				}
				if($idx >= count($v['record'])-1) break;
			}
			$this->displayTabsList[$k]['grid'] = $tabGrid;

			foreach($v['record'] as $k2=>$v2){
				if(!empty($v2['icons']) && !is_array($v2['icons'])){
					$this->displayTabsList[$k]['record'][$k2]['icons'] = explode(",",$v2['icons']);
				}

				if	($this->{img_opt_.$this->style} == 1) {
					if(!empty($v2['image1_large'])) $this->displayTabsList[$k]['record'][$k2]['image'] = $v2['image1_large'];
					if(!empty($v2['image2_large'])) $this->displayTabsList[$k]['record'][$k2]['image2'] = $v2['image2_large'];
				}
			}
		}

		foreach($this->displayGoodsList as $k=>$v){
			if(!empty($v['icons']) && !is_array($v['icons'])){
				$this->displayGoodsList[$k]['icons'] = explode(",",$v['icons']);
			}
			if	($this->{img_opt_.$this->style} == 1) {
				$this->displayGoodsList[$k]['image']	= $v['image1_large'];
				$this->displayGoodsList[$k]['image2']	= $v['image2_large'];
			}
		}

		if($this->info_settings){
			$this->info_settings = str_replace("\"{","{",$this->info_settings);
			$this->info_settings = str_replace("}\"","}",$this->info_settings);
			$this->info_settings = str_replace("\\","",$this->info_settings);
		}

		$this->info_settings = json_decode($this->info_settings);
		$this->info_settings_data = array();

		foreach((array)$this->info_settings as $k=>$info_setting){
			if(!empty($this->info_settings[$k]->font_decoration)){
				if(is_object($this->info_settings[$k]->font_decoration)){
					$this->info_settings[$k]->font_decoration = json_encode($this->info_settings[$k]->font_decoration);
				}

				if($this->info_settings[$k]->postfix == "symbol"){
					$this->info_settings[$k]->postfix = $this->config_currency[$this->config_system['basic_currency']]['currency_symbol'];
				}

				$this->info_settings[$k]->name_css = font_decoration_attr($this->info_settings[$k]->font_decoration,'css','style');

				//비교통화 font style
				if($this->info_settings[$k]->compare){
					if(is_object($this->info_settings[$k]->compare->font_decoration)){
						$this->info_settings[$k]->compare->font_decoration = json_encode($this->info_settings[$k]->compare->font_decoration);
					}
					$new_currency_symbols = array();
					if(is_object($this->info_settings[$k]->compare->currency_symbols)){
						foreach($this->info_settings[$k]->compare->currency_symbols as $currency_symbols){
							if(is_object($currency_symbols)){ $currency_symbols = (array)$currency_symbols; }
							if($currency_symbols['symbol_postfix'] == "symbol"){
								$currency_symbols['symbol_postfix'] = $this->config_currency[$currency_symbols['currency']]['currency_symbol'];
								$new_currency_symbols[] = (object) $currency_symbols;
							}else{
								$new_currency_symbols[] = $currency_symbols;
							}

						}
						if($new_currency_symbols){
							$this->info_settings[$k]->compare->currency_symbols = (object) $new_currency_symbols;
						}
					}
					$this->info_settings[$k]->compare->name_css = font_decoration_attr($this->info_settings[$k]->compare->font_decoration,'css','style');
				}
			}

			$this->info_settings_data[$info_setting->kind] = $this->info_settings[$k];
		}

		if($this->info_settings_data['color']){
			foreach($this->displayTabsList as $k=>$record){
				foreach($record['record'] as $j=>$row){
					if($row['colors']){
						$colors = array_notnull(array_unique(explode(",",$row['colors'])));
						$this->displayTabsList[$k]['record'][$j]['colors'] = $colors;
					}
				}
			}

			foreach($this->displayGoodsList as $k=>$row){
				if($row['colors']){
					$colors = array_notnull(array_unique(explode(",",$row['colors'])));
					$this->displayGoodsList[$k]['colors'] = $colors;
				}
			}
		}

		$goodsImageSize = array_merge($goodsImageSize,$goodsImageSize[$this->image_size]);

		if($this->perpage){
			$this->template->assign(array(
				'perpage'			=>$this->perpage,
				'orders'			=>$this->orders,
			));
		}

		$decorations_obj = $this->decode_image_decorations($this->image_decorations);
		$decorations = array();
		foreach($decorations_obj as $k=>$v) $decorations[$k] = $v;
		$decorations['quick_shopping_data'] = explode(",",str_replace(array("'","[","]"),"",$decorations['quick_shopping']));

		$assign_arr = array(
			'display_key'				=>$display_key,
			'displayGoodsList'			=>$this->displayGoodsList,
			'displayTabsList'			=>$this->displayTabsList,
			'grid'						=>$grid,
			'title'						=>$this->title,
			'count_w'					=>$this->count_w,
			'count_h'					=>$this->count_h,
			'mobile_h'					=>$this->mobile_h,
			'count_w_rolling_v'			=>$this->count_w_rolling_v,
			'text_align'				=>$this->text_align,
			'display_style'				=>$this->style,
			'kind'						=>$this->kind,
			'goods_video_type'			=>$this->goods_video_type,
			'videosize_w'				=>$this->videosize_w,
			'videosize_h'				=>$this->videosize_h,
			'image_decorations'			=>$this->image_decorations,
			'decorations'				=>$decorations,
			'target'					=>$this->target,
			'info_settings'				=>array('list'=>$this->info_settings,'data'=>$this->info_settings_data),
			'goodsImageSize'			=>$goodsImageSize,
			'goodsStatusImage'			=>$this->goodsStatusImage,
			'tab_design_type'			=>$this->tab_design_type,
			'navigation_paging_style'	=>$this->navigation_paging_style,
			'is_bigdata_display'		=>$this->is_bigdata_display,
			'h_rolling_type'			=>$this->h_rolling_type,
			'remain'					=>$this->remain,
			'displayTitle'				=>$this->displayTitle,
			'ajax_call'					=>$this->ajax_call,
			'img_optimize'				=>$this->img_optimize,
			'img_padding'				=>$this->img_padding,
			'v_rolling_type'			=>$this->v_rolling_type
		);

		if	($isMobile) {
			unset($assign_arr['display_style']);
			$assign_arr['m_display_style'] = $this->style;
		}

		$this->template->assign($assign_arr);

		$this->template->define(array($display_key=>$this->skin."/_modules/display/goods_display_{$this->style}.html"));

		if($return){
			return $this->template->fetch($display_key);
		}else{
			$this->template->print_($display_key);
		}
	}

	public function copy_display($display_seq){
		$query = $this->db->query("select * from fm_design_display where display_seq = ?",$display_seq);
		$data = $query->row_array();

		if($data){
			unset($data['display_seq']);
			$data['regdate'] = date('Y-m-d H:i:s');

			$query = $this->db->insert_string('fm_design_display', $data);
			$this->db->query($query);

			$new_display_seq = $this->db->insert_id();

			$this->db->query("delete from fm_design_display_tab where display_seq=?",$new_display_seq);
			$this->db->query("delete from fm_design_display_tab_item where display_seq=?",$new_display_seq);

			/* 상품탭 목록 */
            $query = $this->db->query("select display_seq,display_tab_index,auto_use,tab_title,tab_title_img,tab_title_img_on,contents_type,auto_criteria,tab_contents,tab_contents_mobile,auto_condition_use from fm_design_display_tab where display_seq=?",$display_seq);
			$display_list = $query->result_array();

			foreach($display_list as $k=>$row){
				$data = $row;
				$data['display_seq'] = $new_display_seq;

				$query = $this->db->insert_string('fm_design_display_tab', $data);
				$this->db->query($query);
			}

			/* 상품목록 */
			$query = $this->db->query("select * from fm_design_display_tab_item where display_seq=?",$display_seq);
			$display_list = $query->result_array();

			foreach($display_list as $k=>$row){
				$data = $row;

				unset($data['display_tab_item_seq']);
				$data['display_seq'] = $new_display_seq;

				$query = $this->db->insert_string('fm_design_display_tab_item', $data);
				$this->db->query($query);
			}

			return $new_display_seq;
		}

		return;
	}

	// 자동노출 검색조건 파라미터 가공
	public function search_condition($criteria, $sc, $kind='display'){
		$sc['auto_use']='y';

		if($kind=='recommend'){
			unset($sc['selectCategory1']);
			unset($sc['category']);
		}
		if($kind=='relation'){
			unset($sc['selectCategory1']);
			unset($sc['selectBrand1']);
			unset($sc['selectLocation1']);
			unset($sc['category']);
			unset($sc['brand']);
			unset($sc['location']);
		}

		foreach(explode(',',$criteria) as $v){
			list($k,$v) = explode('=',$v);
			if(preg_match("/(.*)\[\]$/",$k,$matches)){
				if($v!=='') $sc[$matches[1]][] = urldecode($v);
			}else{
				if($v!=='') $sc[$k] = urldecode($v);
			}
		}

		if($sc['selectGoodsName']){
			$sc['search_text'] = $sc['selectGoodsName'];
			unset($sc['selectGoodsName']);
		}

		if($sc['selectCategory1']){
			if($sc['selectCategory1']) $sc['category'] = $sc['selectCategory1'];
			if($sc['selectCategory2']) $sc['category'] = $sc['selectCategory2'];
			if($sc['selectCategory3']) $sc['category'] = $sc['selectCategory3'];
			if($sc['selectCategory4']) $sc['category'] = $sc['selectCategory4'];
			unset($sc['selectCategory1']);
			unset($sc['selectCategory2']);
			unset($sc['selectCategory3']);
			unset($sc['selectCategory4']);
		}

		if($sc['selectBrand1']){
			if($sc['selectBrand1']) $sc['brand'] = $sc['selectBrand1'];
			if($sc['selectBrand2']) $sc['brand'] = $sc['selectBrand2'];
			if($sc['selectBrand3']) $sc['auto_brand_code'] = $sc['selectBrand3'];
			if($sc['selectBrand4']) $sc['brand'] = $sc['selectBrand4'];
			unset($sc['selectBrand1']);
			unset($sc['selectBrand2']);
			unset($sc['selectBrand3']);
			unset($sc['selectBrand4']);
		}

		if($sc['selectLocation1']){
			if($sc['selectLocation1']) $sc['location'] = $sc['selectLocation1'];
			if($sc['selectLocation2']) $sc['location'] = $sc['selectLocation2'];
			if($sc['selectLocation3']) $sc['location'] = $sc['selectLocation3'];
			if($sc['selectLocation4']) $sc['location'] = $sc['selectLocation4'];
			unset($sc['selectLocation1']);
			unset($sc['selectLocation2']);
			unset($sc['selectLocation3']);
			unset($sc['selectLocation4']);
		}

		if($sc['selectGoodsStatus']){
			$sc['goods_status'] = $sc['selectGoodsStatus'];
			unset($sc['selectGoodsStatus']);
		}

		if(isset($sc['selectStartPrice'])){
			if($sc['selectStartPrice']>0) $sc['start_price'] = $sc['selectStartPrice'];
			unset($sc['selectStartPrice']);
		}

		if(isset($sc['selectEndPrice'])){
			if($sc['selectEndPrice']>0) $sc['end_price'] = $sc['selectEndPrice'];
			unset($sc['selectEndPrice']);
		}

		if($sc['file_key_w']){
			$sc['auto_file_key_w'] = $sc['file_key_w'];
			unset($sc['file_key_w']);
		}
		if($sc['video_use']){
			$sc['auto_video_use'] = $sc['video_use'];
			unset($sc['video_use']);
		}
		if($sc['videototal']){
			$sc['auto_videototal'] = $sc['videototal'];
			unset($sc['file_key_w']);
		}

		if(!$sc['auto_order']) {
			$sc['auto_order'] = 'newly';
			if(!$sc['auto_term_type']) $sc['auto_term_type'] = 'relative';
			if(!$sc['auto_term'] && !preg_match("/^selectEvent\=/",$criteria)) $sc['auto_term'] = '365';
		}

		return $sc;
	}

	## 개선된 자동검색 검색조건 파라메터 가공
	public function auto_select_condition($criteria, $sc, $kind='display'){
		$total_sc_arr = Array();
		$this->load->model('dailystatsmodel');
		$this->load->model('membermodel');

		$member_data = $this->membermodel->get_member_data($this->userInfo['member_seq']);
		if	($member_data['birthday'])
			$member_data['birthday'] = $this->dailystatsmodel->member_age_get($member_data['birthday']);

		$use_agent = $this->mobileMode ? 'mobile' : 'pc';

		$sc['auto_use']='y';

		if	(!$sc['page'])				$sc['page']			= 1;
		if	(!$sc['perpage'])			$sc['perpage']		= 10;
		if	(!$sc['image_size'])		$sc['image_size']	= 'view';

		// light일 경우 카테고리 설정은 유지 :: 2019-01-18 pjw
		if	($kind=='recommend' && $this->config_system['operation_type'] != 'light'){
			unset($sc['selectCategory1']);
			unset($sc['category']);
		}

		if	($this->userInfo['group_seq'] > 0)
			$member_group_seq = $this->userInfo['group_seq'];

		foreach(explode('Φ',$criteria) as $div){
			$temp = explode('∀',$div);
			if	(!$temp[0]) $temp[0] = 'admin';
			if	(!$total_sc_arr[$temp]) $total_sc_arr[$temp[0]] = Array();
			$sc_arr = Array();
			foreach(explode(',',$temp[1]) as $v){
				list($k,$v) = explode('=',$v);
				if($v!=='') $sc_arr[$k] = urldecode($v);
			}

			//최근등록순은 구매 횟수로 지정됨
			if	(!empty($sc['bigdata']) && $sc_arr['act'] == 'recently') $sc_arr['act'] = 'order_cnt';

			unset($sc_arr['type']);

			if	(!isset($sc_arr['month'])) $sc_arr['month'] = '1';
			if	(!isset($sc_arr['bigdata_month'])) $sc_arr['bigdata_month'] = '1';

			if	($sc_arr['selectCategory1']){
				if	($sc_arr['selectCategory1']) $sc_arr['category'] = $sc_arr['selectCategory1'];
				if	($sc_arr['selectCategory2']) $sc_arr['category'] = $sc_arr['selectCategory2'];
				if	($sc_arr['selectCategory3']) $sc_arr['category'] = $sc_arr['selectCategory3'];
				if	($sc_arr['selectCategory4']) $sc_arr['category'] = $sc_arr['selectCategory4'];
				unset($sc_arr['selectCategory1']);
				unset($sc_arr['selectCategory2']);
				unset($sc_arr['selectCategory3']);
				unset($sc_arr['selectCategory4']);
			}

			if	($sc_arr['selectBrand1']){
				if	($sc_arr['selectBrand1']) $sc_arr['brand'] = $sc_arr['selectBrand1'];
				if	($sc_arr['selectBrand2']) $sc_arr['brand'] = $sc_arr['selectBrand2'];
				if	($sc_arr['selectBrand3']) $sc_arr['auto_brand_code'] = $sc_arr['selectBrand3'];
				if	($sc_arr['selectBrand4']) $sc_arr['brand'] = $sc_arr['selectBrand4'];
				unset($sc_arr['selectBrand1']);
				unset($sc_arr['selectBrand2']);
				unset($sc_arr['selectBrand3']);
				unset($sc_arr['selectBrand4']);
			}

			if	($sc_arr['selectLocation1']){
				if	($sc_arr['selectLocation1']) $sc_arr['location'] = $sc_arr['selectLocation1'];
				if	($sc_arr['selectLocation2']) $sc_arr['location'] = $sc_arr['selectLocation2'];
				if	($sc_arr['selectLocation3']) $sc_arr['location'] = $sc_arr['selectLocation3'];
				if	($sc_arr['selectLocation4']) $sc_arr['location'] = $sc_arr['selectLocation4'];
				unset($sc_arr['selectLocation1']);
				unset($sc_arr['selectLocation2']);
				unset($sc_arr['selectLocation3']);
				unset($sc_arr['selectLocation4']);
			}

			$total_sc_arr[$temp[0]] = array_merge($sc_arr,$sc);
			$act = $total_sc_arr[$temp[0]]['act'];

			//최신등록순 추가
			if	(!$total_sc_arr[$temp[0]]['sort'] && $act == 'recently') $total_sc_arr[$temp[0]]['sort'] = 'recently';

			switch($act){
				case "order_cnt":
				case "order_ea": $act = 'order'; break;
				case "review_sum":
				case "review_cnt": $act = 'review'; break;
			}

			if	(!$act) $act = 'view';

			$total_sc_arr[$temp[0]]['display_title']	= $sc_arr['display_title'];
			if(!empty($sc['bigdata'])){
				$total_sc_arr[$temp[0]]['stats_table']		= $this->dailystatsmodel->view_arr['view_table_m_'.$sc_arr['bigdata_month']][$act];
			}else{
				$total_sc_arr[$temp[0]]['stats_table']		= $this->dailystatsmodel->view_table[$act];
			}

			$total_sc_arr[$temp[0]]['bigdata_table']	= $this->dailystatsmodel->view_arr['view_table_m_'.$sc_arr['bigdata_month']][$temp[0]];
			$total_sc_arr[$temp[0]]['member_age']		= $member_data['birthday'];
			$total_sc_arr[$temp[0]]['member_sex']		= $member_data['sex'];
			$total_sc_arr[$temp[0]]['member_agent']		= $use_agent;
			$total_sc_arr[$temp[0]]['member_group_seq'] = $member_group_seq;
		}

		return $total_sc_arr;
	}

	## 공통 사용 디스플레이 추출용 ( for kind )
	function get_design_display_kind($kind = 'design'){
		if	(!$kind)	$kind	= 'design';
		$sql	= "select * from fm_design_display where kind = ?";
		$query	= $this->db->query($sql, array($kind));

		return $query->row_array();
	}

	## 상품 자동노출 사용 여부
	function check_content_type($display_seq){
		$ret = false;
		$sql = "select count(*) as cnt from fm_design_display_tab where display_seq = ? and (contents_type = 'auto' or contents_type = 'auto_sub') ";
		$query = $this->db->query($sql,array($display_seq));
		$params = $query->row_array();
		if($params['cnt'] > 0) $ret = true;
		return $ret;
	}

    ## 상품 자동노출 사용 디스플레이
	function check_content_type_array($display_seqs){
        $result = false;
		$sql    = "select * from (select display_seq, count(*) as cnt from fm_design_display_tab where display_seq in (".implode(',', $display_seqs).") and (contents_type = 'auto' or contents_type = 'auto_sub') group by display_seq) t where t.cnt > 0";
		$query  = $this->db->query($sql);
        foreach($query->result_array() as $aData){
            $result[]   = $aData['display_seq'];
        }
        return $result;
	}

	## 상품 자동조건 유효 조건수 체크
	function check_criteria($condition,$kind = null){
		$ret = $condition;
		if	($kind == 'bigdata_catalog' || !preg_match('/Φ/', $condition)) return $ret;
		$limit = 3;
		if	(serviceLimit('H_FR')) $limit = 1;
		$condition = explode('Φ',$condition);

		if	($limit < count($condition)){
			$ret = array();
			for($i = 0; $i < $limit; $i++)
				$ret[] = $condition[$i];
			$ret = implode('Φ',$ret);
		}
		return $ret;
	}

    ## 디자인 디스플레이 목록
    function get_display_list_sql($aSerachParams){
        $sWhere = '';
        $aWhere = '';
        $sql	= "select *, "
                . "(select count(*) from fm_design_display_tab_item as b where a.display_seq = b.display_seq) as goodsCnt"
                . "from fm_design_display as a {sWhere} "
                . "order by display_seq desc";
        if( $aSerachParams ){
            foreach($aSerachParams as $sField => $sValue){
                $aWhere[]   = "`".$sField."` = '".$sValue."'";
            }
        }
        if($aWhere) $sWhere = ' WHERE ' . implode(' AND ',$aWhere);
        $sql    = str_replace('{sWhere}', $sWhere, $sql);
        return $sql;
    }

    ## 디자인 디스플레이 목록
    function get_display_count_sql($aSerachParams){
        $sWhere = '';
        $aWhere = '';
        $sql	= "select count(*) as cnt from fm_design_display {sWhere}";
        if( $aSerachParams ){
            foreach($aSerachParams as $sField => $sValue){
                $aWhere[]   = "`".$sField."` = '".$sValue."'";
            }
        }
        if($aWhere) $sWhere = ' WHERE ' . implode(' AND ',$aWhere);
        $sql    = str_replace('{sWhere}', $sWhere, $sql);
        return $sql;
    }

    ## 디자인 디스플레이 목록
	function get_display_tab_list_sql($aParams, $aSerachParams){
	    $sql	= "select * from ("
	        . "select ddt.display_tab_index, ddt.auto_use, dd.display_seq, dd.platform, dd.kind, dd.style, dd.admin_comment, dd.count_w, dd.count_w_swipe, dd.count_h_swipe, ddt.cache_use, ddt.auto_generation, ddt.favorite "
	            . "from fm_design_display_tab ddt, fm_design_display dd where ddt.display_seq = dd.display_seq and dd.kind='design' /*{sWhere}{sLike}*/ "
	                . ") tb "
	                    . "order by display_seq desc, display_tab_index asc";
	                    $sWhere = $aWhere = '';
	                    if( $aParams )  foreach($aParams as $sField => $sValue) $aWhere[]   = "".$sField." = '".$sValue."'";

	                    // 반응형 일경우
	                    if($this->config_system['operation_type']=='light'){
	                        $aWhere[]   = "dd.platform = 'responsive'";
	                    }else{
	                        $aWhere[]   = "dd.platform != 'responsive'";
	                    }

	                    if( $aWhere )   $sWhere = ' AND ' . implode(' AND ',$aWhere);
	                    $sql    = str_replace('/*{sWhere}', $sWhere, $sql);
	                    $sWhere = $aWhere = '';
	                    if( $aSerachParams )    foreach($aSerachParams as $sField => $sValue)   $aWhere[] = "".$sField." like '%".$sValue."%'";
	                    if( $aWhere )           $sWhere = ' AND (' . implode(' OR ',$aWhere).')';
	                    $sql    = str_replace('{sLike}*/', $sWhere, $sql);
	                    return $sql;
	}

    function get_display_tab_count($aWhereParams, $limit){

        $sTbSql = "select * from fm_design_display_tab";

        // 반응형 일경우
        if($this->config_system['operation_type'] == 'light'){
            $aWhereSql[]    = "display_seq in (select dd.display_seq from fm_design_display dd where dd.platform = 'responsive')";
        }else{
            $aWhereSql[]    = "display_seq in (select dd.display_seq from fm_design_display dd where dd.platform != 'responsive')";
        }

	    if($aWhereParams){
	        foreach( $aWhereParams as $sfield => $sValue ){
	            $aWhereSql[]    = $sfield . " = ?";
	            $aBind[]        = $sValue;
	        }
	    }

	    if($aWhereSql){
	        $sTbSql .= " where ".implode(" AND ", $aWhereSql);
	    }
	    if($aWhereParams){
	        $sTbSql .= " limit ?";
	        $aBind[] = $limit;
	    }
	    $sSql   = "select count(*) cnt from (".$sTbSql.") tb";

	    $query  = $this->db->query($sSql, $aBind);
	    $row    = $query->row_array();
	    return $row['cnt'];
	}

    function update_display_tab($aSetParams, $aWhereParams)
    {
        $this->db->set($aSetParams);
        $this->db->where($aWhereParams);
        $this->db->update('fm_design_display_tab');
    }

    function update_display_tab_faverites($aWhereParams, $bind)
	{
	    $sSql = "update fm_design_display_tab set favorite=? where ".implode(" OR ", $aWhereParams);
	    $this->db->query($sSql, $bind);
	}

    function delete_display($realMobileSkinVersion, $display_seqs)
	{
	    // 캐시 삭제
	    $query = "select ddt.display_tab_index, ddt.auto_use, dd.display_seq, dd.platform, dd.kind, dd.style, dd.admin_comment, dd.count_w, dd.count_w_swipe, dd.count_h_swipe, ddt.cache_use from fm_design_display dd,fm_design_display_tab ddt where dd.display_seq=ddt.display_seq and ddt.cache_use='y' and find_in_set(ddt.display_seq,'".$display_seqs."')";
	    $query = $this->db->query($query);
	    foreach($query->result_array() as $aData){
	        // 모바일전용 ver3 이상
	        if($realMobileSkinVersion >  2 && $aData['platform']=='mobile' && ($aData['style']=='newswipe' || $aData['style']=='sizeswipe')){
	            $aData['count_w'] = $aData['count_w_swipe'];
	            $aData['count_h'] = $aData['count_h_swipe'];
	        }
	        // 모바일전용 스와이프형 일때 ver2 이하
	        if($realMobileSkinVersion < 3 && $aData['platform']=='mobile' && $aData['style']=='newswipe'){
	            $aData['count_w'] = $aData['count_w_swipe'];
	            $aData['count_h'] = $aData['count_h_swipe'];
	        }
	        $aData['perpage']       = $aData['count_w'] * $aData['count_h'];
	        $this->rmDesignDisplayCach($aData['display_seq'], $aData['display_tab_index'], $aData['perpage'], $aData['kind']);
	    }
	    $this->db->query("delete from fm_design_display where find_in_set(display_seq,'".$display_seqs."')");
	    $this->db->query("delete from fm_design_display_item where find_in_set(display_seq,'".$display_seqs."')");
	    $this->db->query("delete from fm_design_display_tab where find_in_set(display_seq,'".$display_seqs."')");
	    $this->db->query("delete from fm_design_display_tab_item where find_in_set(display_seq,'".$display_seqs."')");
	}

	// 디스플레이 스타일이 없는 경우 기본 디스플레이 정의
	function default_display_setting($displayData) {

		if( $displayData['list_count_w'] == "" )			$displayData['list_count_w']			= 4;
		if( $displayData['list_count_w_lattice_b'] == "" )	$displayData['list_count_w_lattice_b']	= 2;
		if( $displayData['list_count_h'] == "" )			$displayData['list_count_h']			= 4;
		if( $displayData['list_style'] == "" )				$displayData['list_style']				= 'lattice_a';
		if( $displayData['list_image_size'] == "" )			$displayData['list_image_size']			= 'list2';
		if( $displayData['list_paging_use'] == "" )			$displayData['list_paging_use']			= 'y';
		if( $displayData['list_text_align'] == "" )			$displayData['list_text_align']			= 'center';
		if( $displayData['list_info_settings'] == "" )		$displayData['list_info_settings']		= '[{"kind":"summary", "font_decoration":"{\"color\":\"#000000\", \"font\":\"dotum\", \"bold\":\"normal\", \"underline\":\"none\"}"},{"kind":"goods_name", "font_decoration":"{\"color\":\"#666666\", \"font\":\"dotum\", \"bold\":\"normal\", \"underline\":\"none\"}"},{"kind":"consumer_price", "font_decoration":"{\"color\":\"#999999\", \"font\":\"dotum\", \"bold\":\"normal\", \"underline\":\"line-through\"}", "postfix":"won"},{"kind":"price", "font_decoration":"{\"color\":\"#000000\", \"font\":\"dotum\", \"bold\":\"bold\", \"underline\":\"none\"}", "postfix":"won"}]';
		if( $displayData['list_goods_status'] == "" )		$displayData['list_goods_status']		= 'normal';
		if( $displayData['m_list_count_w'] == "" )			$displayData['m_list_count_w']			= '4';
		if( $displayData['m_list_count_h'] == "" )			$displayData['m_list_count_h']			= '4';
		if( $displayData['m_list_image_size'] == "" )		$displayData['m_list_image_size']		= 'list1';
		if( $displayData['m_list_text_align'] == "" )		$displayData['m_list_text_align']		= 'center';
		if( ! $displayData['m_list_mobile_h'] )				$displayData['m_list_mobile_h']			= '100';

		return $displayData;
	}
}
?>
