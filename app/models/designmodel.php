<?php

use App\libraries\Design\Skin\SkinNameValidationTrait;

class DesignModel extends CI_Model {

	use SkinNameValidationTrait;

	function __construct() {
		parent::__construct();

		$this->load->helper('design');
		$this->load->model('layout');
	}

	/* 보유한 스킨 목록 가져오기 */
	public function get_skin_list($skinPrefix=null){

		$skinList = array();
		$skinPath = ROOTPATH."data/skin/";


		$map = directory_map($skinPath,true,false);
		foreach($map as $dir){

			$configurationPath = $skinPath.$dir."/configuration/skin.ini";
			if(!file_exists($configurationPath) || in_array($dir,array('.','..'))) continue;

			$configuration = skin_configuration($dir);

			if($skinPrefix == 'mobile'){
				if($configuration['platform'] != 'mobile') continue;
			}else if($skinPrefix == 'responsive'){
				if($configuration['platform'] != 'responsive') continue;
			}else{
				if($configuration['platform'] != 'pc') continue;
			}

			$skinList[] = $configuration;
		}

		if(!function_exists('get_skin_list_cmp')){
			function get_skin_list_cmp ($a, $b) {   if ($a['regdate'] == $b['regdate']) return 0;   return ($a['regdate'] < $b['regdate']) ? 1 : -1;}
		}

		usort($skinList,"get_skin_list_cmp");

		return $skinList;
	}

	/* 모든 스킨 목록 가져오기 */
	public function get_all_skin_list($skinPrefix=null){

		$skinList = array();
		$skinPath = ROOTPATH."data/skin/";

		$map = directory_map($skinPath,true,false);
		foreach($map as $dir){

			$configurationPath = $skinPath.$dir."/configuration/skin.ini";
			if(!file_exists($configurationPath) || in_array($dir,array('.','..'))) continue;

			$configuration = skin_configuration($dir);

			$skinList[] = $configuration;

		}

		if(!function_exists('get_skin_list_cmp')){
			function get_skin_list_cmp ($a, $b) {   if ($a['regdate'] == $b['regdate']) return 0;   return ($a['regdate'] < $b['regdate']) ? 1 : -1;}
		}

		usort($skinList,"get_skin_list_cmp");

		return $skinList;
	}

	/* 스킨 압축 반환 */
	public function export_skin($skin){

		ini_set("memory_limit",-1);
		set_time_limit(0);

		$this->load->library('Zipfile');
		$this->load->helper('download');
		$this->load->helper('directory');
		$this->load->helper('file');
		$CI =& get_instance();

		$skin_path = ROOTPATH."data/skin/".$skin;

		//샘플데이터를 필요로 하는 스킨만 해당
		if(preg_match('/www\/skinsample/', ROOTPATH)){
			/* display.json 생성 */
			$json = array();
			$json['design_display'] = array();
			$json['relation_display'] = array();

			$skin_configuration = skin_configuration($skin);

			$query = "select * from fm_design_display where display_seq > 14";

			$query = $CI->db->query($query);
			foreach ($query->result_array() as $row){
				$kind		= 'design_display';
				$key		= $row['display_seq'];
				$display_seq = $row['display_seq'];

				$keys = "`".implode("`,`",array_keys($row))."`";
				$values = "'".implode("','",array_map("addslashes",$row))."'";
				$values	= preg_replace("/\r\n/", '', $values);
				$json[$kind][$key]['main'] = sprintf("INSERT INTO `fm_design_display` (%s) values (%s);",$keys,$values);

				$query2 = "select * from fm_design_display_tab where display_seq=?";
				$query2 = $CI->db->query($query2,array($display_seq));
				foreach ($query2->result_array() as $row2){
					$keys = "`".implode("`,`",array_keys($row2))."`";
					$values = "'".implode("','",array_map("addslashes",$row2))."'";
					$values	= preg_replace("/\r\n/", '', $values);
					$json[$kind][$key]['sub'][] = sprintf("INSERT INTO `fm_design_display_tab` (%s) values (%s);",$keys,$values);
				}

				$query3 = "select * from fm_design_display_tab_item where display_seq=? order by display_tab_item_seq";
				$query3 = $CI->db->query($query3,array($display_seq));
				foreach ($query3->result_array() as $row3){
					unset($row3['display_tab_item_seq']);
					$keys = "`".implode("`,`",array_keys($row3))."`";
					$values = "'".implode("','",array_map("addslashes",$row3))."'";
					$values	= preg_replace("/\r\n/", '', $values);
					$json[$kind][$key]['sub'][] = sprintf("INSERT INTO `fm_design_display_tab_item` (%s) values (%s);",$keys,$values);
				}
			}

			@unlink($skin_path."/configuration/display.json");

			if(!write_file($skin_path."/configuration/display.json",base64_encode(json_encode($json)))){
				openDialogAlert("display.json 생성에 실패하였습니다.",400,140,'parent');
				exit;
			}

			/* category.json 생성 */
			$json = array();
			$json['category'] = array();

			$query = "select * from fm_category order by id";
			$query = $CI->db->query($query);
			foreach ($query->result_array() as $row){
				$id = $row['id'];
				$row['node_banner'] = preg_replace('/\/data\/editor\//', 'http://interface.firstmall.kr/firstmall_plus/sample_img/'.$skin.'/', $row['node_banner']);
				$keys = "`".implode("`,`",array_keys($row))."`";
				$values = "'".implode("','",array_map("addslashes",$row))."'";
				$values	= preg_replace("/\r\n/", '', $values);
				$json['category'][$id]['main'] = sprintf("INSERT INTO `fm_category` (%s) values (%s);",$keys,$values);
			}

			@unlink($skin_path."/configuration/category.json");

			if(!write_file($skin_path."/configuration/category.json",base64_encode(json_encode($json)))){
				openDialogAlert("category.json 생성에 실패하였습니다.",400,140,'parent');
				exit;
			}

			/* brand.json 생성 */
			$json = array();
			$json['brand'] = array();

			$query = "select * from fm_brand order by id";
			$query = $CI->db->query($query);
			foreach ($query->result_array() as $row){
				$id = $row['id'];
				$keys = "`".implode("`,`",array_keys($row))."`";
				$values = "'".implode("','",array_map("addslashes",$row))."'";
				$values	= preg_replace("/\r\n/", '', $values);
				$json['brand'][$id]['main'] = sprintf("INSERT INTO `fm_brand` (%s) values (%s);",$keys,$values);
			}

			@unlink($skin_path."/configuration/brand.json");

			if(!write_file($skin_path."/configuration/brand.json",base64_encode(json_encode($json)))){
				openDialogAlert("brand.json 생성에 실패하였습니다.",400,140,'parent');
				exit;
			}

			/* location.json 생성 */
			$json = array();
			$json['location'] = array();

			$query = "select * from fm_location order by id";
			$query = $CI->db->query($query);
			foreach ($query->result_array() as $row){
				$id = $row['id'];
				$keys = "`".implode("`,`",array_keys($row))."`";
				$values = "'".implode("','",array_map("addslashes",$row))."'";
				$values	= preg_replace("/\r\n/", '', $values);
				$json['location'][$id]['main'] = sprintf("INSERT INTO `fm_location` (%s) values (%s);",$keys,$values);
			}

			@unlink($skin_path."/configuration/location.json");

			if(!write_file($skin_path."/configuration/location.json",base64_encode(json_encode($json)))){
				openDialogAlert("location.json 생성에 실패하였습니다.",400,140,'parent');
				exit;
			}

			/* count.json 생성 */
			$json = array();
			$json['count'] = array();

			$query = "select * from fm_count where kind = 'category' and code != ''";
			$query = $CI->db->query($query);
			foreach ($query->result_array() as $row){
				$id = $row['code'];
				$keys = "`".implode("`,`",array_keys($row))."`";
				$values = "'".implode("','",array_map("addslashes",$row))."'";
				$values	= preg_replace("/\r\n/", '', $values);
				$json['count'][$id]['main'] = "delete from `fm_count` where kind = 'category' and code = '".$id."';";
				$json['count'][$id]['sub'][] = sprintf("INSERT INTO `fm_count` (%s) values (%s);",$keys,$values);
			}

			@unlink($skin_path."/configuration/count.json");

			if(!write_file($skin_path."/configuration/count.json",base64_encode(json_encode($json)))){
				openDialogAlert("count.json 생성에 실패하였습니다.",400,140,'parent');
				exit;
			}

			/* goods.json 생성 */
			$json = array();
			$json['goods'] = array();

			$query = "select * from fm_goods";
			$query = $CI->db->query($query);
			foreach ($query->result_array() as $row){
				$goods_seq = $row['goods_seq'];

				$row['contents'] = '<p style="text-align: center;"><img src="http://interface.firstmall.kr/firstmall_plus/sample_img/common/pc.jpg" class="txc-image" style="clear:none;float:none;width:100%" /></p>';
				$row['mobile_contents'] = '<p style="text-align: center;"><img src="http://interface.firstmall.kr/firstmall_plus/sample_img/common/mobile.jpg" class="txc-image" style="clear:none;float:none;width:100%" /></p>';

				$keys = "`".implode("`,`",array_keys($row))."`";
				$values = "'".implode("','",array_map("addslashes",$row))."'";
				$json['goods'][$goods_seq]['main'] = sprintf("INSERT INTO `fm_goods` (%s) values (%s);",$keys,$values);

				$query2 = "select * from fm_goods_option where goods_seq=?";
				$query2 = $CI->db->query($query2,array($goods_seq));
				foreach ($query2->result_array() as $row2){
					$keys = "`".implode("`,`",array_keys($row2))."`";
					$values = "'".implode("','",array_map("addslashes",$row2))."'";
					$values	= preg_replace("/\r\n/", '', $values);
					$json['goods'][$goods_seq]['sub'][] = sprintf("INSERT INTO `fm_goods_option` (%s) values (%s);",$keys,$values);
				}

				$query3 = "select * from fm_goods_suboption where goods_seq=?";
				$query3 = $CI->db->query($query3,array($goods_seq));
				foreach ($query3->result_array() as $row3){
					$keys = "`".implode("`,`",array_keys($row3))."`";
					$values = "'".implode("','",array_map("addslashes",$row3))."'";
					$values	= preg_replace("/\r\n/", '', $values);
					$json['goods'][$goods_seq]['sub'][] = sprintf("INSERT INTO `fm_goods_suboption` (%s) values (%s);",$keys,$values);
				}

				$query4 = "select * from fm_goods_supply where goods_seq=?";
				$query4 = $CI->db->query($query4,array($goods_seq));
				foreach ($query4->result_array() as $row4){
					$keys = "`".implode("`,`",array_keys($row4))."`";
					$values = "'".implode("','",array_map("addslashes",$row4))."'";
					$values	= preg_replace("/\r\n/", '', $values);
					$json['goods'][$goods_seq]['sub'][] = sprintf("INSERT INTO `fm_goods_supply` (%s) values (%s);",$keys,$values);
				}

				$query5 = "select * from fm_goods_image where goods_seq=? order by image_seq";
				$query5 = $CI->db->query($query5,array($goods_seq));
				foreach ($query5->result_array() as $row5){
					unset($row5['image_seq']);
					$route = explode('/', $row5['image']);
					$row5['image'] = 'http://interface.firstmall.kr/firstmall_plus/sample_img/'.$skin.'/'.trim($route[6]);
					$keys = "`".implode("`,`",array_keys($row5))."`";
					$values = "'".implode("','",array_map("addslashes",$row5))."'";
					$values	= preg_replace("/\r\n/", '', $values);
					$json['goods'][$goods_seq]['sub'][] = sprintf("INSERT INTO `fm_goods_image` (%s) values (%s);",$keys,$values);
				}

				$query6 = "select * from fm_category_link where goods_seq=? order by category_link_seq";
				$query6 = $CI->db->query($query6,array($goods_seq));
				foreach ($query6->result_array() as $row6){
					unset($row6['category_link_seq']);
					$keys = "`".implode("`,`",array_keys($row6))."`";
					$values = "'".implode("','",array_map("addslashes",$row6))."'";
					$values	= preg_replace("/\r\n/", '', $values);
					$json['goods'][$goods_seq]['sub'][] = sprintf("INSERT INTO `fm_category_link` (%s) values (%s);",$keys,$values);
				}

				$query7 = "select * from fm_brand_link where goods_seq=? order by category_link_seq";
				$query7 = $CI->db->query($query7,array($goods_seq));
				foreach ($query7->result_array() as $row7){
					unset($row7['category_link_seq']);
					$keys = "`".implode("`,`",array_keys($row7))."`";
					$values = "'".implode("','",array_map("addslashes",$row7))."'";
					$values	= preg_replace("/\r\n/", '', $values);
					$json['goods'][$goods_seq]['sub'][] = sprintf("INSERT INTO `fm_brand_link` (%s) values (%s);",$keys,$values);
				}

				$query8 = "select * from fm_location_link where goods_seq=? order by location_link_seq";
				$query8 = $CI->db->query($query8,array($goods_seq));
				foreach ($query8->result_array() as $row8){
					unset($row8['location_link_seq']);
					$keys = "`".implode("`,`",array_keys($row8))."`";
					$values = "'".implode("','",array_map("addslashes",$row8))."'";
					$values	= preg_replace("/\r\n/", '', $values);
					$json['goods'][$goods_seq]['sub'][] = sprintf("INSERT INTO `fm_location_link` (%s) values (%s);",$keys,$values);
				}
			}

			@unlink($skin_path."/configuration/goods.json");

			if(!write_file($skin_path."/configuration/goods.json",base64_encode(json_encode($json)))){
				openDialogAlert("goods.json 생성에 실패하였습니다.",400,140,'parent');
				exit;
			}
		}

		/* layout.sql 생성 */
		$config_layout_queries = array();
		$query = "select * from fm_config_layout where skin=?";
		$query = $CI->db->query($query,$skin);
		foreach ($query->result_array() as $row){
			$row['skin'] = "{skin}";
			$keys = "`".implode("`,`",array_keys($row))."`";
			$values = "'".implode("','",array_map("addslashes",$row))."'";
			$values	= preg_replace("/\r\n/", '', $values);
			$config_layout_queries[] = sprintf("INSERT INTO `fm_config_layout` (%s) values (%s);",$keys,$values);
		}
		if(!write_file($skin_path."/configuration/layout.sql",implode("\r\n",$config_layout_queries))){
			openDialogAlert("layout.sql 생성에 실패하였습니다.",400,140,'parent');
			exit;
		}

		/* flash.sql 생성 */
		$design_flash_queries = array();
		$query = "select * from fm_design_flash where skin=?";
		$query = $CI->db->query($query,$skin);
		foreach ($query->result_array() as $row){
			$flash_seq = $row['flash_seq'];
			unset($row['flash_seq']);
			$row['skin'] = "{skin}";
			$keys = "`".implode("`,`",array_keys($row))."`";
			$values = "'".implode("','",array_map("addslashes",$row))."'";
			$values	= preg_replace("/\r\n/", '', $values);
			$design_flash_queries[] = sprintf("INSERT INTO `fm_design_flash` (%s) values (%s);",$keys,$values);

			$query2 = "select * from fm_design_flash_file where flash_seq=?";
			$query2 = $CI->db->query($query2,$flash_seq);
			foreach ($query2->result_array() as $row2){
				unset($row2['flash_file_seq']);
				$row2['flash_seq'] = "{flash_seq}";
				$keys = "`".implode("`,`",array_keys($row2))."`";
				$values = "'".implode("','",array_map("addslashes",$row2))."'";
				$values	= preg_replace("/\r\n/", '', $values);
				$design_flash_queries[] = sprintf("INSERT INTO `fm_design_flash_file` (%s) values (%s);",$keys,$values);
			}
		}
		if(!write_file($skin_path."/configuration/flash.sql",implode("\r\n",$design_flash_queries))){
			openDialogAlert("flash.sql 생성에 실패하였습니다.",400,140,'parent');
			exit;
		}

		/* banner.sql 생성 */
		$design_banner_queries = array();
		$query = "select * from fm_design_banner where skin=?";
		$query = $CI->db->query($query,$skin);
		foreach ($query->result_array() as $row){
			$banner_seq = $row['banner_seq'];
			$row['skin'] = "{skin}";
			$keys = "`".implode("`,`",array_keys($row))."`";
			$values = "'".implode("','",array_map("addslashes",$row))."'";
			$values	= preg_replace("/\r\n/", '', $values);
			$design_banner_queries[] = sprintf("INSERT INTO `fm_design_banner` (%s) values (%s);",$keys,$values);

			$query2 = "select * from fm_design_banner_item where skin=? and banner_seq=?";
			$query2 = $CI->db->query($query2,array($skin,$banner_seq));
			foreach ($query2->result_array() as $row2){
				unset($row2['banner_item_seq']);
				$row2['skin'] = "{skin}";
				$keys = "`".implode("`,`",array_keys($row2))."`";
				$values = "'".implode("','",array_map("addslashes",$row2))."'";
				$values	= preg_replace("/\r\n/", '', $values);
				$design_banner_queries[] = sprintf("INSERT INTO `fm_design_banner_item` (%s) values (%s);",$keys,$values);
			}
		}
		if(!write_file($skin_path."/configuration/banner.sql",implode("\r\n",$design_banner_queries))){
			openDialogAlert("banner.sql 생성에 실패하였습니다.",400,140,'parent');
			exit;
		}

		/* topbar.sql 생성 */
		$topbar_queries = array();
		$query = "select * from fm_topbar_style where skin=?";
		$query = $CI->db->query($query,$skin);
		foreach ($query->result_array() as $row){
			$tab_index = $row['tab_index'];
			unset($row['tab_index']);
			$row['skin'] = "{skin}";
			$keys = "`".implode("`,`",array_keys($row))."`";
			$values = "'".implode("','",array_map("addslashes",$row))."'";
			$values	= preg_replace("/\r\n/", '', $values);
			$topbar_queries[] = sprintf("INSERT INTO `fm_topbar_style` (%s) values (%s);",$keys,$values);

			$query2 = "select * from fm_topbar_file where style_index=?";
			$query2 = $CI->db->query($query2,$tab_index);
			foreach ($query2->result_array() as $row2){
				unset($row2['tab_idx']);
				$row2['style_index'] = "{style_index}";
				$keys = "`".implode("`,`",array_keys($row2))."`";
				$values = "'".implode("','",array_map("addslashes",$row2))."'";
				$values	= preg_replace("/\r\n/", '', $values);
				$topbar_queries[] = sprintf("INSERT INTO `fm_topbar_file` (%s) values (%s);",$keys,$values);
			}
		}
		if(!write_file($skin_path."/configuration/topbar.sql",implode("\r\n",$topbar_queries))){
			openDialogAlert("topbar.sql 생성에 실패하였습니다.",400,140,'parent');
			exit;
		}

		/* zip 생성 */
		$this->zipfile->reset();
		$map = directory_map_list(directory_map($skin_path,false,false));
		foreach($map as $k=>$v) {
			if(is_file($skin_path.$v)){
				$this->zipfile->addFile(read_file($skin_path.$v),$skin.$v);
			}
		}
		$backup_file_contents = $this->zipfile->file();


		if(!$backup_file_contents){
			openDialogAlert("ZIP 파일 생성에 실패하였습니다.",400,140,'parent');
			exit;
		}

		return $backup_file_contents;
	}

	public function zip_extract_skin($zip_path){
		$this->load->helper('directory');
		$this->load->helper('file');
		$this->load->model('usedmodel');

		$this->load->library('pclzip',array('p_zipname' => $zip_path));

		$tmp_path = ROOTPATH."data/tmp/".time();
		$extract = $this->pclzip->extract(PCLZIP_OPT_PATH, $tmp_path);

		$filename = array_column($extract, 'filename'); // $key = 1

		foreach($filename as $key => $value) {
			if (preg_match("/.htaccess/", $value) === 1) {
				openDialogAlert("허용하지 않는 파일이 포함되었습니다.",300,140,'parent');
				exit;
			}
		}

		if(!$extract)
		{
			openDialogAlert("압축해제 실패",300,140,'parent');
			exit;
		}

		/* 스킨명 */
		$map = array_keys(directory_map($tmp_path));
		$skin = $new_skin = $map[0];

		$checkResult = $this->skinNameValidation($new_skin);
		if ($checkResult['result'] === false) {
			openDialogAlert($checkResult['message'],300,175,'parent');
			exit;
		}

		$new_skin_path = ROOTPATH."data/skin/".$new_skin;
		$skin_idx = 0;
		while(is_dir($new_skin_path)){
			$skin_idx++;
			$new_skin = $skin."_".$skin_idx;
			$new_skin_path = ROOTPATH."data/skin/".$new_skin;
		}

		rename($tmp_path."/".$skin,$new_skin_path);
		rmdir($tmp_path);
		chmod($new_skin_path,0777);

		if(empty($_SERVER['WINDIR'])){
			@exec("chmod 777 {$new_skin_path} -R");
		}

		if(!file_exists($new_skin_path."/configuration/layout.sql")){
			openDialogAlert("스킨 업로드에 실패하였습니다.<br>레이아웃 설정파일이 존재하지 않습니다.",300,175,'parent');
			exit;
		}

		$this->db->trans_begin();

		/* layout config delete */
		$query = "delete from fm_config_layout where skin=?";
		$this->db->query($query,$new_skin);

		/* layout config insert */
		$success = true;
		$layout_sql_contents = explode("\r\n",read_file($new_skin_path."/configuration/layout.sql"));
		foreach($layout_sql_contents as $query){
			if(trim($query)){
				if(preg_match("/^INSERT INTO `fm_config_layout`/",$query) && substr_count($query,"');")==1){
					$query = str_replace("{skin}",$new_skin,$query);
					$this->db->query($query,$new_skin);
				}else{
					$success = false;
					openDialogAlert("스킨 업로드에 실패하였습니다.\\n레이아웃 설정파일에 문제가 있습니다.",300,150,'parent');
					break;
				}
			}
		}

		/* newskin flash delete */
		$query = "select * from fm_design_flash where skin=?";
		$query = $this->db->query($query,$new_skin);
		foreach ($query->result_array() as $row){
			$query = "delete from fm_design_flash_file where flash_seq=?";
			$this->db->query($query,$row['flash_seq']);
		}
		$query = "delete from fm_design_flash where skin=?";
		$this->db->query($query,$new_skin);

		/* flash insert */
		$success = true;
		$new_flash_seq = null;
		$flash_sql_contents = explode("\r\n",read_file($new_skin_path."/configuration/flash.sql"));
		foreach($flash_sql_contents as $query){
			if(trim($query)){
				if(preg_match("/^INSERT INTO `fm_design_flash`/",$query) && substr_count($query,"');")==1){
					$query = str_replace("{skin}",$new_skin,$query);
					$this->db->query($query);
					$new_flash_seq = $this->db->insert_id();
				}else if(preg_match("/^INSERT INTO `fm_design_flash_file`/",$query) && substr_count($query,"');")==1){
					$query = str_replace("{flash_seq}",$new_flash_seq,$query);
					$this->db->query($query);
				}else{
					$success = false;
					debug_var($query);
					openDialogAlert("스킨 업로드에 실패하였습니다.\\nflash.sql파일에 문제가 있습니다.",300,140,'parent');
					break;
				}
			}
		}

		/* newskin slide banner delete */
		$query = "select * from fm_design_banner where skin=?";
		$query = $this->db->query($query,$new_skin);
		foreach ($query->result_array() as $row){
			$query = "delete from fm_design_banner_item where skin=? and banner_seq=?";
			$this->db->query($query,array($new_skin,$row['banner_seq']));
		}
		$query = "delete from fm_design_banner where skin=?";
		$this->db->query($query,$new_skin);

		/* banner insert */
		$success = true;
		$banner_sql_contents = explode("\r\n",read_file($new_skin_path."/configuration/banner.sql"));
		foreach($banner_sql_contents as $query){
			if(trim($query)){
				if(preg_match("/^INSERT INTO `fm_design_banner`/",$query) && substr_count($query,"');")==1){
					$query = str_replace("{skin}",$new_skin,$query);
					$this->db->query($query);
				}else if(preg_match("/^INSERT INTO `fm_design_banner_item`/",$query) && substr_count($query,"');")==1){
					$query = str_replace("{skin}",$new_skin,$query);
					$this->db->query($query);
				}else{
					$success = false;
					openDialogAlert("스킨 업로드에 실패하였습니다.\\nbanner.sql파일에 문제가 있습니다.",300,140,'parent');
					break;
				}
			}
		}

		/* newskin topbar delete */
		$query = "select * from fm_topbar_style where skin=?";
		$query = $this->db->query($query,$new_skin);
		foreach ($query->result_array() as $row){
			$query = "delete from fm_topbar_file where style_index=?";
			$this->db->query($query,$row['tab_index']);
		}
		$query = "delete from fm_topbar_style where skin=?";
		$this->db->query($query,$new_skin);

		/* topbar insert */
		$success = true;
		$new_tab_index = null;
		$topbar_sql_contents = explode("\r\n",read_file($new_skin_path."/configuration/topbar.sql"));
		foreach($topbar_sql_contents as $query){
			if(trim($query)){
				if(preg_match("/^INSERT INTO `fm_topbar_style`/",$query) && substr_count($query,"');")==1){
					$query = str_replace("{skin}",$new_skin,$query);
					$this->db->query($query);
					$new_tab_index = $this->db->insert_id();
				}else if(preg_match("/^INSERT INTO `fm_topbar_file`/",$query) && substr_count($query,"');")==1){
					$query = str_replace("{style_index}",$new_tab_index,$query);
					$this->db->query($query);
				}else{
					$success = false;
					debug_var($query);
					openDialogAlert("스킨 업로드에 실패하였습니다.\\ntopbar.sql파일에 문제가 있습니다.",300,140,'parent');
					break;
				}
			}
		}

		/* 상품, 디스플레이 기본값 여부 */
		$display_json = read_file($new_skin_path."/configuration/display.json");
		$exist_default_set = false;

		if	($display_json) {
			$get_json = json_decode(base64_decode($display_json), true);
			foreach($get_json['design_display'] as $seq => $qry){
				$this->db->where(array('display_seq'=>$seq));
				$ret		= $this->db->get('fm_design_display');
				$qry_flag	= $ret->row_array();
				if	(!$qry_flag) {
					$main_qry = preg_replace('/INSERT INTO/i', 'INSERT IGNORE INTO', $qry['main']);
					$this->db->query($main_qry);
					if	($qry['sub']) {
						foreach($qry['sub'] as $sub_query) {
							$sub_query = preg_replace('/INSERT INTO/i', 'INSERT IGNORE INTO', $sub_query);
							$this->db->query($sub_query);
						}
					}
				}
			}

			$exist_default_set = $this->set_default_goods(true, $new_skin);
		}

		/* 실패했을경우 업로드중인 데이터 삭제 */
		if($success == false){
			$this->db->trans_rollback();

			/* layout config delete */
			#$query = "delete from fm_config_layout where skin=?";
			#$this->db->query($query,$new_skin);

			/* 스킨폴더 내 파일 및 디렉토리 삭제 */
			$map = directory_map_list(directory_map($new_skin_path,false,true));
			rsort($map);
			foreach($map as $k=>$v) {
				chmod($new_skin_path.$v,0777);
				if(is_file($new_skin_path.$v)){
					unlink($new_skin_path.$v);
				}else{
					rmdir($new_skin_path.$v);
				}
			}

			rmdir($new_skin_path);
		}

		/* 완료했을경우 layout.sql,flash.sql 삭제 */
		if($success){
			skin_configuration_save($new_skin,"skin",$new_skin);

			$this->db->trans_commit();

			@unlink($new_skin_path."/configuration/layout.sql");
			@unlink($new_skin_path."/configuration/flash.sql");
			@unlink($new_skin_path."/configuration/banner.sql");
			@unlink($new_skin_path."/configuration/topbar.sql");
		}

		return array($success,$new_skin,$exist_default_set);
	}

	// 모바일 Quick 디자인 css파일 경로 반환
	public function get_mobile_buttons_css_path(){
		if( serviceLimit('H_ST') ) {
			$skin = $this->workingStoremobileSkin;
		}else{
			$skin = $this->workingMobileSkin;
		}

		$cssPath = "/data/skin/".$skin."/css/quick_design.css";

		return file_exists(ROOTPATH.$cssPath) ? $cssPath : null;
	}

	// 모바일 Quick 디자인 테마
	public function get_mobile_themes(){
		if( serviceLimit('H_ST') ) {
			$skin = $this->workingStoremobileSkin;
		}else{
			$skin = $this->workingMobileSkin;
		}

		$skin_configuration = skin_configuration($skin);

		if($skin_configuration['mobile_version']=='2'){
			$array = array(
				'red'=> array(
					'name'	=> '레드',
					'color'	=> '#ad0005',
					'childs' => array('red1')
				),
				'pink'=> array(
					'name'	=> '핑크',
					'color'	=> '#ff87dc',
					'childs' => array('pink1')
				),
				'orange'=> array(
					'name'	=> '오렌지',
					'color'	=> '#ff7800',
					'childs' => array('orange1')
				),
				'yellow'=> array(
					'name'	=> '옐로우',
					'color'	=> '#fbab00',
					'childs' => array('yellow1')
				),
				'brown'=> array(
					'name'	=> '브라운',
					'color'	=> '#916345',
					'childs' => array('brown1','brown2')
				),
				'green'=> array(
					'name'	=> '그린',
					'color'	=> '#68a90b',
					'childs' => array('green1','green2')
				),
				'blue'=> array(
					'name'	=> '블루',
					'color'	=> '#2c5cc9',
					'childs' => array('blue1','blue2','blue3','blue4')
				),
				'violet'=> array(
					'name'	=> '바이올렛',
					'color'	=> '#8722c8',
					'childs' => array('violet1')
				),
			);
		}
		if($skin_configuration['mobile_version']=='3'){
			$array = array(
				'red'=> array(
					'name'	=> '레드',
					'color'	=> '#ad0005',
					'childs' => array('red1', 'red2')
				),
				'pink'=> array(
					'name'	=> '핑크',
					'color'	=> '#ff87dc',
					'childs' => array('pink1', 'pink2')
				),
				'orange'=> array(
					'name'	=> '오렌지',
					'color'	=> '#ff7800',
					'childs' => array('orange1', 'orange2')
				),
				'yellow'=> array(
					'name'	=> '옐로우',
					'color'	=> '#fbab00',
					'childs' => array('yellow1', 'yellow2')
				),
				'brown'=> array(
					'name'	=> '브라운',
					'color'	=> '#916345',
					'childs' => array('brown1','brown2')
				),
				'green'=> array(
					'name'	=> '그린',
					'color'	=> '#68a90b',
					'childs' => array('green1','green2')
				),
				'blue'=> array(
					'name'	=> '블루',
					'color'	=> '#2c5cc9',
					'childs' => array('blue1','blue2')
				),
				'violet'=> array(
					'name'	=> '바이올렛',
					'color'	=> '#8722c8',
					'childs' => array('violet1', 'violet2')
				),
				'black'=> array(
					'name'	=> '블랙',
					'color'	=> '#000000',
					'childs' => array('black1', 'black2')
				),
			);
		}
		return $array;
	}

	// 팝업 스타일
	public function get_popup_styles($key=null){
		if($this->config_system['operation_type'] == 'light'){
			$array = array(
				'layer'			=> '팝업',
				'band'			=> '띠배너',
			);
		}else{
			$array = array(
				'window'		=> 'PC용 → 윈도우 팝업',
				'layer'			=> 'PC용 → 레이어 팝업',
				'mobile_layer'	=> '모바일/태블릿용 → 레이어 팝업',
				'band'			=> 'PC용 → 띠배너',
				'mobile_band'	=> '모바일/태블릿용 → 띠배너'
			);
		}
		if(!is_null($key)) return $array[$key];
		return $array;
	}

	// 배너 스타일
	public  function get_banner_styles($platform=''){
		$array = array(
			'pc_style_1' => array(
				'platform' => 'pc',
				'name'	=> 'PC STYLE 1',
				'use_image_size' => true,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => false,
				'use_navigation_paging_custom' => false,
				'use_swipe' => false,
			),
			'pc_style_2' => array(
				'platform' => 'pc',
				'name'	=> 'PC STYLE 2',
				'use_image_size' => true,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => false,
				'use_swipe' => false,
			),
			'pc_style_3' => array(
				'platform' => 'pc',
				'name'	=> 'PC STYLE 3',
				'use_image_size' => true,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => false,
				'use_swipe' => false,
			),
			'pc_style_4' => array(
				'platform' => 'pc',
				'name'	=> 'PC STYLE 4',
				'use_image_size' => true,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => true,
				'use_swipe' => false,
			),
			'pc_style_5' => array(
				'platform' => 'pc',
				'name'	=> 'PC STYLE 5',
				'use_image_size' => true,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => true,
				'use_swipe' => false,
			),
			'mobile_style_1' => array(
				'platform' => 'mobile',
				'name'	=> 'MOBILE STYLE 1',
				'use_image_size' => true,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => false,
			),
			'mobile_style_2' => array(
				'platform' => 'mobile',
				'name'	=> 'MOBILE STYLE 2',
				'use_image_size' => false,
				'use_image_margin' => false,
				'use_background' => false,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => false,
			),
			'mobile_style_3' => array(
				'platform' => 'mobile',
				'name'	=> 'MOBILE STYLE 3',
				'use_image_size' => false,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => false,
			),
			'light_style_1' => array(
				'platform' => 'responsive',
				'name'	=> 'Light STYLE 1',
				'use_image_size' => false,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => false,
			),
			'light_style_2' => array(
				'platform' => 'responsive',
				'name'	=> 'Light STYLE 2',
				'use_image_size' => false,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => false,
			)
		);

		if($platform){
			foreach($array as $k=>$v){
				if($platform!=$v['platform']) unset($array[$k]);
			}
		}

		return $array;
	}

	// 배너 샘플
	public  function get_banner_sample($style){
		$array = array(
			'pc_style_1' => array(
				'name'	=> 'PC STYLE 1 샘플',
				'height' => "470",
				'background_color' => "#bbc2d2",
				'background_image' => "/admin/skin/default/images/design/banner/pc_style_1/st1_tit.jpg",
				'background_repeat' => "no-repeat",
				'background_position' => "center top",
				'image_border_use' => "n",
				'image_border_width' => "0",
				'image_border_color' => "#ffffff",
				'image_opacity_use' => "n",
				'image_opacity_percent' => "0",
				'image_top_margin' => "56",
				'image_side_margin' => "18",
				'image_width' => "290",
				'image_height' => "384",
				'navigation_btn_style' => "btn_style_2",
				'navigation_btn_visible' => "fixed",
				'navigation_paging_style' => "",
				'navigation_paging_align' => "center",
				'navigation_paging_position' => "bottom",
				'navigation_paging_margin' => "10",
				'slide_event' => "auto",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_1/st1_sample1.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_1/st1_sample2.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_1/st1_sample3.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_1/st1_sample4.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_1/st1_sample5.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_1/st1_sample6.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_1/st1_sample7.jpg"),
				)
			),
			'pc_style_2' => array(
				'name'	=> 'PC STYLE 2 샘플',
				'height' => "295",
				'background_color' => "#ffffff",
				'background_image' => "",
				'background_repeat' => "no-repeat",
				'background_position' => "left top",
				'image_border_use' => "n",
				'image_border_width' => "0",
				'image_border_color' => "#ffffff",
				'image_opacity_use' => "n",
				'image_opacity_percent' => "0",
				'image_top_margin' => "0",
				'image_side_margin' => "0",
				'image_width' => "852",
				'image_height' => "295",
				'navigation_btn_style' => "btn_style_3",
				'navigation_btn_visible' => "fixed",
				'navigation_paging_style' => "paging_style_1",
				'navigation_paging_align' => "right",
				'navigation_paging_position' => "over",
				'navigation_paging_margin' => "20",
				'slide_event' => "auto",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_2/st2_sample1.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_2/st2_sample2.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_2/st2_sample3.jpg"),
				)
			),
			'pc_style_3' => array(
				'name'	=> 'PC STYLE 3 샘플',
				'height' => "310",
				'background_color' => "#e5ebf8",
				'background_image' => "",
				'background_repeat' => "no-repeat",
				'background_position' => "left top",
				'image_border_use' => "n",
				'image_border_width' => "0",
				'image_border_color' => "#ffffff",
				'image_opacity_use' => "n",
				'image_opacity_percent' => "0",
				'image_top_margin' => "10",
				'image_side_margin' => "10",
				'image_width' => "832",
				'image_height' => "290",
				'navigation_btn_style' => "",
				'navigation_btn_visible' => "fixed",
				'navigation_paging_style' => "paging_style_1",
				'navigation_paging_align' => "center",
				'navigation_paging_position' => "bottom",
				'navigation_paging_margin' => "24",
				'slide_event' => "auto",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_3/st3_sample1.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_3/st3_sample2.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_3/st3_sample3.jpg"),
				)
			),
			'pc_style_4' => array(
				'name'	=> 'PC STYLE 4 샘플',
				'height' => "310",
				'background_color' => "#ffffff",
				'background_image' => "",
				'background_repeat' => "no-repeat",
				'background_position' => "left top",
				'image_border_use' => "n",
				'image_border_width' => "0",
				'image_border_color' => "#ffffff",
				'image_opacity_use' => "n",
				'image_opacity_percent' => "0",
				'image_top_margin' => "0",
				'image_side_margin' => "0",
				'image_width' => "852",
				'image_height' => "310",
				'navigation_btn_style' => "",
				'navigation_btn_visible' => "fixed",
				'navigation_paging_style' => "custom",
				'navigation_paging_align' => "center",
				'navigation_paging_position' => "over",
				'navigation_paging_margin' => "10",
				'navigation_paging_spacing' => "1",
				'slide_event' => "auto",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_4/st4_sample1.jpg","tab_image_inactive"=>"tab1.jpg","tab_image_active"=>"tab1_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_4/st4_sample2.jpg","tab_image_inactive"=>"tab2.jpg","tab_image_active"=>"tab2_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_4/st4_sample3.jpg","tab_image_inactive"=>"tab3.jpg","tab_image_active"=>"tab3_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_4/st4_sample4.jpg","tab_image_inactive"=>"tab4.jpg","tab_image_active"=>"tab4_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_4/st4_sample5.jpg","tab_image_inactive"=>"tab5.jpg","tab_image_active"=>"tab5_on.jpg"),
				)
			),
			'pc_style_5' => array(
				'name'	=> 'PC STYLE 5 샘플',
				'height' => "354",
				'background_color' => "#ffffff",
				'background_repeat' => "no-repeat",
				'background_position' => "left top",
				'background_position' => "",
				'image_border_use' => "n",
				'image_border_width' => "0",
				'image_border_color' => "#ffffff",
				'image_opacity_use' => "n",
				'image_opacity_percent' => "0",
				'image_top_margin' => "0",
				'image_side_margin' => "0",
				'image_width' => "490",
				'image_height' => "246",
				'navigation_btn_style' => "btn_style_3",
				'navigation_btn_visible' => "fixed",
				'navigation_paging_style' => "custom",
				'navigation_paging_align' => "center",
				'navigation_paging_position' => "bottom",
				'navigation_paging_margin' => "16",
				'navigation_paging_spacing' => "2",
				'slide_event' => "auto",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_5/st5_sample1_b.jpg","tab_image_inactive"=>"tab1.jpg","tab_image_active"=>"tab1_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_5/st5_sample2_b.jpg","tab_image_inactive"=>"tab2.jpg","tab_image_active"=>"tab2_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_5/st5_sample3_b.jpg","tab_image_inactive"=>"tab3.jpg","tab_image_active"=>"tab3_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_5/st5_sample4_b.jpg","tab_image_inactive"=>"tab4.jpg","tab_image_active"=>"tab4_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_5/st5_sample5_b.jpg","tab_image_inactive"=>"tab5.jpg","tab_image_active"=>"tab5_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/pc_style_5/st5_sample6_b.jpg","tab_image_inactive"=>"tab6.jpg","tab_image_active"=>"tab6_on.jpg"),
				)
			),
			'mobile_style_1' => array(
				'name'	=> 'MOBILE STYLE 1 샘플',
				'height' => "234",
				'background_color' => "#4a4c51",
				'background_image' => "/admin/skin/default/images/design/banner/mobile_style_1/st1_tit.jpg",
				'background_repeat' => "no-repeat",
				'background_position' => "10px 10px",
				'image_border_use' => "n",
				'image_border_width' => "0",
				'image_border_color' => "#ffffff",
				'image_opacity_use' => "n",
				'image_opacity_percent' => "0",
				'image_top_margin' => "36",
				'image_side_margin' => "10",
				'image_width' => "230",
				'image_height' => "168",
				'navigation_btn_style' => "",
				'navigation_btn_visible' => "fixed",
				'navigation_paging_style' => "paging_style_1",
				'navigation_paging_align' => "center",
				'navigation_paging_position' => "bottom",
				'navigation_paging_margin' => "10",
				'slide_event' => "auto",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/mobile_style_1/st1_sample1.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/mobile_style_1/st1_sample2.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/mobile_style_1/st1_sample3.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/mobile_style_1/st1_sample4.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/mobile_style_1/st1_sample5.jpg"),
				)
			),
			'mobile_style_2' => array(
				'name'	=> 'MOBILE STYLE 2 샘플',
				'height' => "",
				'background_color' => "#ffffff",
				'background_image' => "",
				'background_repeat' => "no-repeat",
				'background_position' => "left top",
				'image_border_use' => "n",
				'image_border_width' => "0",
				'image_border_color' => "#ffffff",
				'image_opacity_use' => "n",
				'image_opacity_percent' => "0",
				'image_top_margin' => "0",
				'image_side_margin' => "0",
				'image_width' => "",
				'image_height' => "",
				'navigation_btn_style' => "btn_style_3",
				'navigation_btn_visible' => "fixed",
				'navigation_paging_style' => "paging_style_1",
				'navigation_paging_align' => "right",
				'navigation_paging_position' => "over",
				'navigation_paging_margin' => "8",
				'slide_event' => "auto",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/mobile_style_2/st2_sample1.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/mobile_style_2/st2_sample2.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/mobile_style_2/st2_sample3.jpg"),
				)
			),
			'mobile_style_3' => array(
				'name'	=> 'MOBILE STYLE 3 샘플',
				'height' => "",
				'background_color' => "#e5ebf8",
				'background_image' => "",
				'background_repeat' => "no-repeat",
				'background_position' => "left top",
				'image_border_use' => "n",
				'image_border_width' => "0",
				'image_border_color' => "#ffffff",
				'image_opacity_use' => "n",
				'image_opacity_percent' => "0",
				'image_top_margin' => "10",
				'image_side_margin' => "10",
				'image_width' => "",
				'image_height' => "",
				'navigation_btn_style' => "",
				'navigation_btn_visible' => "fixed",
				'navigation_paging_style' => "paging_style_1",
				'navigation_paging_align' => "center",
				'navigation_paging_position' => "bottom",
				'navigation_paging_margin' => "10",
				'slide_event' => "auto",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/mobile_style_3/st3_sample1.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/mobile_style_3/st3_sample2.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/mobile_style_3/st3_sample3.jpg"),
				)
			),
			'light_style_1' => array(
				'name'	=> 'Light STYLE 1 샘플',
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/light_style_1/bnr_sample_01.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/light_style_1/bnr_sample_02.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/light_style_1/bnr_sample_03.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/light_style_1/bnr_sample_04.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/light_style_1/bnr_sample_05.jpg"),
				)
			),
			'light_style_2' => array(
				'name'	=> 'Light STYLE 2 샘플',
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/light_style_2/bg_sample_01.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/light_style_2/bg_sample_02.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/light_style_2/bg_sample_03.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/light_style_2/bg_sample_04.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/banner/light_style_2/bg_sample_05.jpg"),
				),
				'tag_ctrl' => array(
					array("html_tag"=>
							'<li class="text1">GET UP TO <strong class="st1">60%</strong> OFF</li>
<li class="text2">SUMMER SALE</li>
<li class="text3">Limited items available at this price.</li>
<li class="sbtns1"><a class="sbtn sbtn1" href="#">GOTO SHOP</a></li>'),
					array("html_tag"=>
							'<li class="text1">over <strong class="st1">200+</strong></li>
<li class="text2">GRATE DEALS</li>
<li class="text3">While they last!</li>
<li class="sbtns1"><a class="sbtn sbtn1" href="#">GOTO SHOP</a></li>'),
					array("html_tag"=>
							'<li class="text1">UP TO <strong class="st1">40%</strong> OFF</li>
<li class="text2">NEW ARRIVALS</li>
<li class="text3">Starting at 5,000￦</li>
<li class="sbtns1"><a class="sbtn sbtn1" href="#">GOTO SHOP</a></li>'),
					array("html_tag"=>
							'<li class="text1">GET UP TO <strong class="st1">60%</strong> OFF</li>
<li class="text2">SUMMER SALE</li>
<li class="text3">Limited items available at this price.</li>
<li class="sbtns1"><a class="sbtn sbtn1" href="#">GOTO SHOP</a></li>'),
					array("html_tag"=>
							'<li class="text1">over <strong class="st1">200+</strong></li>
<li class="text2">GRATE DEALS</li>
<li class="text3">While they last!</li>
<li class="sbtns1"><a class="sbtn sbtn1" href="#">GOTO SHOP</a></li>'),
				)
			)
		);
		return $array[$style];
	}

	//팝업 슬라이드 배너 스타일
	public  function get_popup_banner_styles($platform=''){
		$array = array(
			'pc_style_2' => array(
				'platform' => 'pc',
				'name'	=> 'PC POPUP STYLE 6',
				'use_image_size' => true,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => false,
				'use_swipe' => false,
			),
			'pc_style_3' => array(
				'platform' => 'pc',
				'name'	=> 'PC POPUP STYLE 5',
				'use_image_size' => true,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => false,
				'use_swipe' => false,
			),
			'pc_style_4' => array(
				'platform' => 'pc',
				'name'	=> 'PC POPUP STYLE 4',
				'use_image_size' => true,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => true,
				'use_swipe' => false,
			),
			'pc_style_5' => array(
				'platform' => 'pc',
				'name'	=> 'PC POPUP STYLE 3',
				'use_image_size' => true,
				'use_image_margin' => true,
				'use_background' => true,
				'use_navigation_paging' => true,
				'use_navigation_paging_custom' => true,
				'use_swipe' => false,
			),
			'slider' => array(
				'platform' => 'responsive',
				'name'	=> 'LIGHT STYLE POPUP',
			)
		);

		if($platform){
			foreach($array as $k=>$v){
				if($platform!=$v['platform']) unset($array[$k]);
			}
		}

		return $array;
	}

	//팝업 슬라이드 배너 샘플
	public  function get_popup_banner_sample($style){
		$array = array(
			'pc_style_2' => array(
				'name'	=> 'PC STYLE 6 샘플',
				'height' => "290",
				'background_color' => "#ffffff",
				'background_image' => "",
				'background_repeat' => "no-repeat",
				'background_position' => "left top",
				'image_border_use' => "n",
				'image_border_width' => "0",
				'image_border_color' => "#ffffff",
				'image_opacity_use' => "n",
				'image_opacity_percent' => "0",
				'image_top_margin' => "0",
				'image_side_margin' => "0",
				'image_width' => "480",
				'image_height' => "290",
				'navigation_btn_style' => "btn_style_3",
				'navigation_btn_visible' => "fixed",
				'navigation_paging_style' => "paging_style_1",
				'navigation_paging_align' => "right",
				'navigation_paging_position' => "over",
				'navigation_paging_margin' => "20",
				'slide_event' => "auto",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/pc_style_2/st2_sample1.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/pc_style_2/st2_sample2.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/pc_style_2/st2_sample3.jpg"),
				)
			),
			'pc_style_3' => array(
				'name'	=> 'PC STYLE 5 샘플',
				'height' => "360",
				'background_color' => "#dce3e8",
				'background_image' => "",
				'background_repeat' => "no-repeat",
				'background_position' => "left top",
				'image_border_use' => "n",
				'image_border_width' => "0",
				'image_border_color' => "#ffffff",
				'image_opacity_use' => "n",
				'image_opacity_percent' => "0",
				'image_top_margin' => "10",
				'image_side_margin' => "10",
				'image_width' => "480",
				'image_height' => "290",
				'navigation_btn_style' => "",
				'navigation_btn_visible' => "fixed",
				'navigation_paging_style' => "paging_style_1",
				'navigation_paging_align' => "center",
				'navigation_paging_position' => "bottom",
				'navigation_paging_margin' => "30",
				'slide_event' => "auto",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/pc_style_3/st3_sample1.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/pc_style_3/st3_sample2.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/pc_style_3/st3_sample3.jpg"),
				)
			),
			'pc_style_4' => array(
				'name'	=> 'PC STYLE 4 샘플',
				'height' => "334",
				'background_color' => "#ffffff",
				'background_image' => "",
				'background_repeat' => "no-repeat",
				'background_position' => "left top",
				'image_border_use' => "n",
				'image_border_width' => "0",
				'image_border_color' => "#ffffff",
				'image_opacity_use' => "n",
				'image_opacity_percent' => "0",
				'image_top_margin' => "0",
				'image_side_margin' => "0",
				'image_width' => "410",
				'image_height' => "334",
				'navigation_btn_style' => "btn_style_3",
				'navigation_btn_visible' => "fixed",
				'navigation_paging_style' => "custom",
				'navigation_paging_align' => "center",
				'navigation_paging_position' => "over",
				'navigation_paging_margin' => "10",
				'navigation_paging_spacing' => "0",
				'slide_event' => "auto",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/pc_style_4/st4_sample1.jpg","tab_image_inactive"=>"tab1.jpg","tab_image_active"=>"tab1_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/pc_style_4/st4_sample2.jpg","tab_image_inactive"=>"tab2.jpg","tab_image_active"=>"tab2_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/pc_style_4/st4_sample3.jpg","tab_image_inactive"=>"tab3.jpg","tab_image_active"=>"tab3_on.jpg")
				)
			),
			'pc_style_5' => array(
				'name'	=> 'PC STYLE 3 샘플',
				'height' => "376",
				'background_color' => "#ffffff",
				'background_repeat' => "no-repeat",
				'background_position' => "left top",
				'image_border_use' => "n",
				'image_border_width' => "0",
				'image_border_color' => "#ffffff",
				'image_opacity_use' => "n",
				'image_opacity_percent' => "0",
				'image_top_margin' => "15",
				'image_side_margin' => "15",
				'image_width' => "255",
				'image_height' => "255",
				'navigation_btn_style' => "btn_style_3",
				'navigation_btn_visible' => "fixed",
				'navigation_paging_style' => "custom",
				'navigation_paging_align' => "center",
				'navigation_paging_position' => "bottom",
				'navigation_paging_margin' => "10",
				'navigation_paging_spacing' => "6",
				'slide_event' => "auto",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/pc_style_5/st5_sample1_b.jpg","tab_image_inactive"=>"tab1.jpg","tab_image_active"=>"tab1_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/pc_style_5/st5_sample2_b.jpg","tab_image_inactive"=>"tab2.jpg","tab_image_active"=>"tab2_on.jpg"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/pc_style_5/st5_sample3_b.jpg","tab_image_inactive"=>"tab3.jpg","tab_image_active"=>"tab3_on.jpg"),
				)
			),
			'slider' => array(
				'name'	=> 'LIGHT STYLE POPUP',
				'image_width' => "410",
				'image_height' => "334",
				'images' => array(
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/light_popup/pop_slider_01.jpg","tab_title"=>"회원가입 이벤트"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/light_popup/pop_slider_02.jpg","tab_title"=>"신상품 할인전"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/light_popup/pop_slider_03.jpg","tab_title"=>"포토후기 이벤트"),
					array("target"=>"_blank","link"=>"/main/index","image"=>"/admin/skin/default/images/design/popup_banner/light_popup/pop_slider_04.jpg","tab_title"=>"브랜드 기획전"),
				)
			)
		);
		return $array[$style];
	}

	// 새로운 banner_seq 반환
	public function get_new_banner_seq($skin){
		$query = $this->db->query("select banner_seq from fm_design_banner where skin=? order by banner_seq desc limit 1",$skin);
		$result = $query->row_array();
		if($result){
			return $result['banner_seq']+1;
		}else{
			return 1;
		}
	}

	// 새로운 팝업 전용 banner_seq 반환 2015-10-05 jhr
	public function get_new_popup_banner_seq(){
		$query = $this->db->query("select banner_seq from fm_design_popup_banner order by banner_seq desc limit 1");
		$result = $query->row_array();
		if($result){
			return $result['banner_seq']+1;
		}else{
			return 1;
		}
	}

	// test아이디 list 불러오기
	public function mall_t_id_list() {
		/*	member_seq = 회원고유코드
		*	user_id = 아이디
		*	user_name = 성함
		*	status = 승인상태
		*	B.business_seq = 기업 코드 (회원유형 확인)
		*	group_name = 등급
		*/
		$query = $this->db->query("SELECT A.member_seq, A.userid, A.user_name, A.status, B.business_seq, CASE WHEN A.status = 'done' THEN '승인' WHEN A.status = 'hold' THEN '미승인' WHEN A.status = 'withdrawal' THEN '탈퇴'	WHEN A.status = 'dormancy' THEN '휴면' ELSE '' END AS status_nm, D.group_name FROM fm_member A LEFT JOIN fm_member_business B ON A.member_seq = B.member_seq LEFT JOIN fm_member_group D ON A.group_seq = D.group_seq WHERE A.mall_t_check = 'Y'");
		$result = $query->result_array();
		return $result;
	}

	public function favorite_decorations_save($params){
		switch($params['favorite_act']) {
			case 'insert':
				$insert_params['favorite_type']		= $params['favorite_type'];
				$insert_params['favorite_key']		= $params['key'];
				$insert_params['platform']			= $params['platform'];
				$insert_params['decoration']		= $params['decoration'];
				$insert_params['text_align']		= $params['text_align'];
				$insert_params['favorite_title']	= $params['favorite_title'];
				$insert_params['favorite_desc']		= $params['favorite_desc'];
				$insert_params['favorite_regist']	= $params['favorite_regist'];

				$this->db->insert('fm_design_display_favorite', $insert_params);
				break;
			case 'update':
				$update_params['favorite_title']	= $params['favorite_title'];
				$update_params['favorite_desc']		= $params['favorite_desc'];
				$update_params['favorite_update']	= $params['favorite_update'];
				$this->db->where(array('favorite_key'=>$params['key_fix']));
				$this->db->update('fm_design_display_favorite', $update_params);
				break;
			case 'delete':
				$this->db->where(array('favorite_key'=>$params['key_fix']));
				$this->db->delete('fm_design_display_favorite');
				break;
		}

		$ret = $this->get_favorite_decorations($params['favorite_type'], $params['platform']);

		return $ret;
	}

	public function get_favorite_decorations($type='image_decoration',$platform='pc',$key=null){
		$where = " where favorite_type = '".$type."' ";
		$where .= " and platform = '".$platform."' ";
		if	($key) $where .= " and favorite_key = '".$key."' ";
		$query	= $this->db->query("select * from fm_design_display_favorite {$where} order by favorite_regist desc");
		return $query->result_array();
	}

	// 상품, 카테고리 수정한 이력이 있으면 기본값은 넣지 않는다
	public function set_default_goods($chk_json = null, $new_skin_path = null){
		$json_list = array('goods','category','brand','location');
		$default_set_flag	= true;
		$this->load->helper('file');

		$rs = $this->db->query('select * from fm_goods limit 1');
		if	($rs->row_array()) $default_set_flag = false;

		//카테고리는 카테고리 수정 흔적이 없을 경우에만 넣어준다
		if	($default_set_flag) {
			$rs = $this->db->query('select * from fm_category where id > 1');
			$rs = $rs->result_array();
			if	(sizeOf($rs) == 15) {
				$chk_category = 0;
				foreach($rs as $category){
					if	(!in_array($category['update_date'], array('2017-01-01 20:59:27', '2017-01-01 21:28:21'))) {
						$chk_category++;
					}
				}
				if	($chk_category > 0)
					$default_set_flag = false;
			}else{
				$default_set_flag = false;
			}
		}

		//브랜드
		if	($default_set_flag) {
			$rs = $this->db->query('select * from fm_brand where id > 2');
			if	($rs->row_array()) $default_set_flag = false;
		}

		//지역
		if	($default_set_flag) {
			$rs = $this->db->query('select * from fm_location where id > 2');
			if	($rs->row_array()) $default_set_flag = false;
		}

		if	($default_set_flag && !$chk_json) {
			$this->db->query('truncate table fm_category');
			foreach($json_list as $kind){
				$json = read_file($new_skin_path."/configuration/".$kind.".json");
				$get_json = json_decode(base64_decode($json), true);
				foreach($get_json as $kind => $val){
					foreach($val as $seq => $qry){
						$this->db->query($qry['main']);
						if	($qry['sub']) foreach($qry['sub'] as $sub_query) $this->db->query($sub_query);
					}
				}
			}
		}

		return $default_set_flag;
	}

	/* [반응형스킨] 스킨 타입별 보유스킨 가져오기 :: 2018-10-31 pjw */
	public function get_skin_list_type($skinPrefix=null, $mode='list'){

		$skinList		= array();
		$skinPath		= ROOTPATH."data/skin/";
		// 2개의 반응형 스킨 사용 시 반응형으로 고정
		$tmpSkinPrefix	= $skinPrefix == 'responsive2' ? 'responsive' : $skinPrefix;


		$map = directory_map($skinPath,true,false);
		foreach($map as $dir){

			$configurationPath = $skinPath.$dir."/configuration/skin.ini";
			if(!file_exists($configurationPath) || in_array($dir,array('.','..'))) continue;

			$configuration = skin_configuration($dir);

			if($tmpSkinPrefix == 'responsive' && $tmpSkinPrefix != $configuration['platform']) continue;
			if($tmpSkinPrefix == 'fixed' && !in_array($configuration['platform'], array('pc', 'mobile'))) continue;

			$skinList[$configuration['platform']][] = $configuration;
		}

		if(!function_exists('get_skin_list_cmp')){
			function get_skin_list_cmp ($a, $b) {   if ($a['regdate'] == $b['regdate']) return 0;   return ($a['regdate'] < $b['regdate']) ? 1 : -1;}
		}

		// 각 스킨 데이터를 타입에 따라 리스트, 총합으로 가공
		if ( $mode=='cnt' ) {
			$skinTmpList = array(
				'pc' => array('cnt' => 0),
				'mobile' => array('cnt' => 0),
				'responsive' => array('cnt' => 0),
			);
		} else {
			$skinTmpList = array();
		}

		if(!empty($skinList)){
			foreach($skinList as $type => $skin){
				if($mode == 'cnt'){
					$skinTmpList[$type]['cnt']	= count($skin);
				}else{
					$skinTmpList[$type]			= $skin;
				}
			}
		}
		$skinList = $skinTmpList;

		return $skinList;
	}

	/* [반응형스킨] 스킨 타입 변경 :: 2018-10-31 pjw */
	function set_default_skintype($skin_type = ''){
		$this->load->helper('file');
		$skin_type		= $skin_type != '' ? $skin_type : 'fixed';
		$skin_type_prev = !empty($this->config_system['skin_type']) ? $this->config_system['skin_type'] : 'fixed';
		$cfg_system		= ($this->config_system) ? $this->config_system : config_load('system');
		$skin_list		= $this->get_skin_list_type($skin_type);

		$prev=[
			'operation_type'			=> !empty($this->config_system['operation_type']) ? $this->config_system['operation_type'] : 'fixed',
			'skin_type'					=> $skin_type_prev,
			'skin'						=> $cfg_system['skin'],
			'workingSkin'				=> $cfg_system['workingSkin'],
			'mobileSkin'				=> $cfg_system['mobileSkin'],
			'mobileSkinVersion'			=> $cfg_system['mobileSkinVersion'],
			'workingMobileSkin'			=> $cfg_system['workingMobileSkin'],
			'workingMobileSkinVersion'	=> $cfg_system['workingMobileSkinVersion'],
		];

		if($skin_type == 'responsive'){
			/* 이전에 사용했던 스킨이 있는 경우 적용. 없으면 종전대로 처리 */
			if(isset($this->config_system['prevSkinInfo']) && $this->config_system['prevSkinInfo']['skin_type'] == $skin_type) {
				$current = $this->config_system['prevSkinInfo'];
			}
			else {
				$current = array(
					'operation_type'			=> 'light',
					'skin_type'					=> $skin_type,
					'skin'						=> $skin_list['responsive'][0]['skin'],
					'workingSkin'				=> $skin_list['responsive'][0]['skin'],
					'mobileSkin'				=> $skin_list['responsive'][0]['skin'],
					'mobileSkinVersion'			=> '1',
					'workingMobileSkin'			=> $skin_list['responsive'][0]['skin'],
					'workingMobileSkinVersion'	=> '1',
				);
			}

			/**
			 * 전용스킨->반응형스킨으로 변경시 상품후기/상품문의 게시판 보기 타입도 페이지형으로 강제 변경
			 */
			$this->load->model('boardmanager');
			$this->boardmanager->manager_item_save(array('viewtype'=>'page'), 'goods_review');
			$this->boardmanager->manager_item_save(array('viewtype'=>'page'), 'goods_qna');

			$current['prevSkinInfo'] = $prev;
			$this->load->model('goodsmodel');
			// 모바일용 상품설명이 없는 상품 일괄적으로 모바일용상품으로 등록
			$this->goodsmodel->all_mobile_contents();

		}else{
			/* 이전에 사용했던 스킨이 있는 경우 적용. 없으면 종전대로 처리 */
			if(isset($this->config_system['prevSkinInfo']) && $this->config_system['prevSkinInfo']['skin_type'] == $skin_type) {
				$current = $this->config_system['prevSkinInfo'];
				$current['operation_type'] = $current['operation_type'] == 'fixed' ? 'heavy' : $current['operation_type'];
			}
			else {
				$current = array(
					'operation_type'			=> 'heavy',
					'skin_type'					=> $skin_type,
					'skin'						=> $skin_list['pc'][0]['skin'],
					'workingSkin'				=> $skin_list['pc'][0]['skin'],
					'mobileSkin'				=> $skin_list['mobile'][0]['skin'],
					'mobileSkinVersion'			=> $skin_list['mobile'][0]['mobile_version'],
					'workingMobileSkin'			=> $skin_list['mobile'][0]['skin'],
					'workingMobileSkinVersion'	=> $skin_list['mobile'][0]['mobile_version'],
				);
			}

			$current['prevSkinInfo'] = $prev;
		}

		// 로그메세지 생성
		$log_msg = array(
			'current'	=> $current,
			'previous'	=> $prev,
			'managerinfo'	=> $this->managerInfo,
			'ip'			=> $_SERVER['REMOTE_ADDR'],
			'updated'		=> date('Y-m-d H:i:s')
		);

		// 현재 스킨 정보 변경
		config_save('system', $current);
		write_file(ROOTPATH."data/logs/set_skin_type.log",json_encode($log_msg)."\r\n", 'a+');
	}

	// 반응형 선택 된 상품정보 스타일 정보 가져오기 :: 2019-05-15 pjw
	public function get_goods_info_style($type, $file_path){
		// 타입별로 나눔
		// display : 상품디스플레이 전용
		// search_list : 상품리스트 전용
		switch($type){
			case 'display':
				$dir_sub		= 'design';
				$sample_key		= 'goodsList';
				break;
			case 'search_list':
				$dir_sub		= 'design_list';
				$sample_key		= 'record';
				break;
			default:
				$dir_sub		= 'design';
				$sample_key		= 'goodsList';
				break;
		}

		// 선택 된 상품정보 존재 여부
		$is_select_favorite = empty($file_path) ? true : false;

		// 상품정보 파일 호출 :: 2018-11-23 lwh
		$dir	= 'data/'.$dir_sub.'/';
		if(is_dir(ROOTPATH.$dir)){

			############## 관리자 노출용 샘플 데이터 ##############
			$goods_status_list = array(
				'normal'	 => '',
				'runout'	 => '품절',
				'purchasing' => '재고확보중',
				'unsold'	 => '판매중지',
			);
			$sample_data	= array();
			$sample_data[]	= array(
				'goods_seq'			=> 1,
				'goods_status'		=> 'normal',
				'goods_status_txt'	=> $goods_status_list['normal'],
				'brand_title'		=> '나이키',
				'goods_name'		=> '나이키 이니시에이터 한정특가',
				'summary'			=> '따뜻한 코튼소재에 멋스럽고 스타일리쉬한 세련된 패딩 멋스럽고 스타일리쉬한 세련된 패딩',
				'sale_price'		=> 34000,
				'price'				=> 39000,
				'consumer_price'	=> 46000,
				'sale_per'			=> 6,
				'provider_seq'		=> 2,
				'provider_name'		=> '퍼스트몰',
				'pgroup_name'		=> '플래티넘',
				'pgroup_icon'		=> '779388.gif',
				'purchase_ea'		=> 45,
				'shipping_group'	=> array('free_shipping_use' => 'Y', 'gl_shipping_yn' => 'Y'),
				'icons'				=> array(1,2,3),
				'colors'			=> array('6b4d32','b89f88','ebd8c1','fff','444'),
				'color_pick'		=> '6b4d32,b89f88,ebd8c1,fff,444',
				'page_view'			=> 8465,
				'wish_count'		=> 1568,
				'review_count'		=> 3,
				'review_sum'		=> 10,
				'review_divide'		=> 3.3,
				'review_toprate'	=> 58,
				'review_usercnt'	=> 6,
				'review_info'		=> array(
					array('toplabel' => '적극추천', 'subject' => '적극 추천 합니다', 'contents' => '배송은 일주일 걸렸으나, 상품은 정말 좋습니다.'),
					array('toplabel' => '적극추천', 'subject' => '적극 추천 합니다', 'contents' => '배송은 일주일 걸렸으나, 상품은 정말 좋습니다.'),
				),
				'event_order_ea' => 0,
				'eventEnd'		=> array(
					'year'		=> date('Y'),
					'month'		=> date('m'),
					'day'		=> date('d', strtotime("+1 days")),
					'hour'		=> '23',
					'min'		=> '59',
					'second'	=> '59'
				)
			);

			// 임시로 template_ 경로를 프론트 설정으로 변경
			if(defined('__ADMIN__') === true || defined('__SELLERADMIN__') === true){
				$this->template->assign($sample_key, $sample_data);
				$this->template->assign('issample', true);
				$this->template->template_dir	= ROOTPATH.'data/skin';
				$this->template->compile_dir	= ROOTPATH.'_compile/data';
			}
			############## 관리자 노출용 샘플 데이터 ##############


			if($sdh = opendir($dir)){
				// 선택 된 데이터 없을 시 기본값 설정
				$default_origin_name	= 'goods_list_style1';
				$default_file_path		= '';
				$is_exist_select		= true;
				$is_checked				= true;

				// 파일 목록 결과값
				$fileList	= array();
				$idx		= 0;
				while(false !== ($file = readdir($sdh))){
					$idx++;
					if(in_array($file, array('.','..','.svn'))) continue;
					$fileTime	= filemtime($dir.$file).'_'.$idx;
					$tmpFile	= explode('.', $file);
					if	($tmpFile[1] != 'html')	continue;

					// 첫번째 값을 기본값으로 지정
					if($is_checked || $default_origin_name == $tmpFile[0]){
						$default_file_path	= $tmpFile[0];
						$is_checked			= false;
					}

					// 선택 된 파일명이 실제 폴더 파일 목록에 있는지 검사
					if($file_path == $tmpFile[0]){
						$is_exist_select = false;
					}

					// 파일 정보 세팅
					$fileList[$file]['name']		= $tmpFile[0];
					$fileList[$file]['patch']		= $dir.$file;
					$fileList[$file]['time']		= date("Y-m-d H:i:s", filemtime($dir.$file));

					// 파일 fetch 후 리턴
					$this->template->define('info_style', '../'.$dir_sub.'/'.$file);
					$fileList[$file]['contents']	= $this->template->fetch('info_style');

				}

				// 아무것도 선택되지 않았을때 첫번째 값으로 선택
				if	($is_select_favorite || $is_exist_select){
					$file_path = $default_file_path;
				}

				ksort($fileList);
				closedir($sdh);

				// template_ 경로 복원
				if(defined('__ADMIN__') === true){
					$this->template->template_dir	= ROOTPATH.'admin/skin';
					$this->template->compile_dir	= ROOTPATH.'_compile/admin';
					$this->template->assign('is_sample', true);
					$this->template->assign('fileList', $fileList);
				}else if(defined('__SELLERADMIN__') === true){
					$this->template->template_dir	= ROOTPATH.'selleradmin/skin';
					$this->template->compile_dir	= ROOTPATH.'_compile/selleradmin';
					$this->template->assign('is_sample', true);
					$this->template->assign('fileList', $fileList);
				}

			}
		}

		return $file_path;
	}

	// 반응형 퀵디자인 테마 색상값 가져오기 :: 2019-05-29 pjw
	public function get_responsive_theme(){

		// 퀵디자인 테마 기본키
		$default_theme	= 'basic';

		// 현재 정의 된 테마정보 가져옴
		$current_theme  = config_load('design', 'responsive_theme');
		$current_theme	= $current_theme['responsive_theme'];

		// 설정 된 테마 정보가 없는 경우 기본값으로 설정
		if(empty($current_theme)){
			$current_theme = array(
				'theme'		=> $default_theme,
				'colors'	=> $this->get_responsive_default_theme($default_theme),
			);
		}

		return $current_theme;
	}

	// 반응형 퀵디자인 테마 색상값 저장 :: 2019-05-30 pjw
	public function set_responsive_theme($key, $colors=null){

		// 퀵디자인 테마 기본키
		$default_theme	= 'basic';

		// 사용 할 테마키가 없으면 동작 안함
		if(!empty($key)){
			// 색상값 정보가 없는 경우 기본값에서 넣음
			if(empty($colors))	$colors = $this->get_responsive_default_theme($key);

			// 기본값이 없는 경우 키값이 잘못된 경우이므로 블락처리
			if(empty($colors))	return false;

			// 테마 설정 정보 저장
			$theme_info = array(
				'theme'		=> $key,
				'colors'	=> $colors,
			);

			config_save('design', array('responsive_theme' => $theme_info));
			return true;
		}else{
			return false;
		}
	}

	// 반응형 선택한 퀵디자인 테마, 변경한 색상에 맞게 색상배열 가져오기 :: 2019-06-05 pjw
	public function get_responsive_select_theme($key, $param){

		// 해당 테마의 기본 색상값 가져옴
		$colors			= $this->get_responsive_default_theme($key);
		$custom_color	= str_replace('#', '', $param['custom_color']);
		$select_colors	= $param['select_colors'];

		// 사용자 지정일 경우 선택 된 값으로 일괄 치환
		if($key == 'custom' && !empty($custom_color)){

			// #fff 고정값으로 쓸 변수 목록
			$white_list = array('solo_event_text','deatil_sale_rate_text','major_button_text','push_count_text','best_rank1_text','best_rank2_text','best_rank3_text');

			// $colors 배열 반복문에서 고정된 변수만 #fff 처리 나머지는 선택 된 색상으로 일괄설정
			foreach($colors as $key => $color){
				if(in_array($key, $white_list)){
					$colors[$key] = '#ffffff';
				}else{
					$colors[$key] = '#'.$custom_color;
				}
			}

		}

		// 상세설정에서 변경 된 항목의 색상만 업데이트
		foreach($colors as $key => $color){
			if(!empty($select_colors[$key])){
				$colors[$key] = $select_colors[$key];
			}
		}

		return $colors;
	}

	// 반응형 퀵디자인 테마 기본 색상값 :: 2019-05-30 pjw
	public function get_responsive_default_theme($key){

		// 색상값 결과
		$color = array();

		// 미리 정의된 테마 기본값
		$themes_default	= array(
			"basic"		  => array( "main_color" => "default", "gnb_active_line"=> "default",	"gnb_active_text"=> "default",	"gnb_submenu"=> "default",	"lnb_active_text"=> "default",	"sale_price"=> "default",	"basic_sale_rate"=> "default",	"solo_event_icon"=> "default",	"solo_event_bg"=> "default",	"solo_event_text"=> "default",	"review_score"=> "default",	"deatil_sale_rate_bg"=> "default",	"deatil_sale_rate_text"=> "default",	"coupon_btn"=> "default",	"major_button_line"=> "default",	"major_button_bg"=> "default",	"major_button_text"=> "default",	"push_count_bg"=> "default",	"push_count_text"=> "default",	"best_rank1_bg"=> "default",	"best_rank1_text"=> "default",	"best_rank2_bg"=> "default",	"best_rank2_text"=> "default",	"best_rank3_bg"=> "default",	"best_rank3_text"=> "default",	"best_rank4_bg"=> "default",	"best_rank4_text"=> "default", "board_list_active_line"=> "default",	"board_list_active_text"=> "default",	"paging_active_line"=> "default",	"paging_active_text"=> "default" ),
			"red"		  => array( "main_color" => "#df2929", "gnb_active_line"=> "#df2929",	"gnb_active_text"=> "#df2929",	"gnb_submenu"=> "#e86363",	"lnb_active_text"=> "#df2929",	"sale_price"=> "#df2929",	"basic_sale_rate"=> "#df2929",	"solo_event_icon"=> "#df2929",	"solo_event_bg"=> "#df2929",	"solo_event_text"=> "#ffffff",	"review_score"=> "#df2929",	"deatil_sale_rate_bg"=> "#e86363",	"deatil_sale_rate_text"=> "#ffffff",	"coupon_btn"=> "#df2929",	"major_button_line"=> "#df2929",	"major_button_bg"=> "#df2929",	"major_button_text"=> "#ffffff",	"push_count_bg"=> "#df2929",	"push_count_text"=> "#ffffff",	"best_rank1_bg"=> "#df2929",	"best_rank1_text"=> "#ffffff",	"best_rank2_bg"=> "#df2929",	"best_rank2_text"=> "#ffffff",	"best_rank3_bg"=> "#df2929",	"best_rank3_text"=> "#ffffff", "best_rank4_bg"=> "#df2929",	"best_rank4_text"=> "#ffffff",	"board_list_active_line"=> "#df2929",	"board_list_active_text"=> "#df2929",	"paging_active_line"=> "#df2929",	"paging_active_text"=> "#df2929"),
			"pink"		  => array( "main_color" => "#ff7e8f", "gnb_active_line"=> "#ff7e8f",	"gnb_active_text"=> "#ff7e8f",	"gnb_submenu"=> "#ff9daa",	"lnb_active_text"=> "#ff7e8f",	"sale_price"=> "#ff7e8f",	"basic_sale_rate"=> "#ff7e8f",	"solo_event_icon"=> "#ff7e8f",	"solo_event_bg"=> "#ff7e8f",	"solo_event_text"=> "#ffffff",	"review_score"=> "#ff7e8f",	"deatil_sale_rate_bg"=> "#ff9daa",	"deatil_sale_rate_text"=> "#ffffff",	"coupon_btn"=> "#ff7e8f",	"major_button_line"=> "#ff7e8f",	"major_button_bg"=> "#ff7e8f",	"major_button_text"=> "#ffffff",	"push_count_bg"=> "#ff7e8f",	"push_count_text"=> "#ffffff",	"best_rank1_bg"=> "#ff7e8f",	"best_rank1_text"=> "#ffffff",	"best_rank2_bg"=> "#ff7e8f",	"best_rank2_text"=> "#ffffff",	"best_rank3_bg"=> "#ff7e8f",	"best_rank3_text"=> "#ffffff", "best_rank4_bg"=> "#ff7e8f",	"best_rank4_text"=> "#ffffff",	"board_list_active_line"=> "#ff7e8f",	"board_list_active_text"=> "#ff7e8f",	"paging_active_line"=> "#ff7e8f",	"paging_active_text"=> "#ff7e8f"),
			"orange"	  => array( "main_color" => "#f7782c", "gnb_active_line"=> "#f7782c",	"gnb_active_text"=> "#f7782c",	"gnb_submenu"=> "#fd985c",	"lnb_active_text"=> "#f7782c",	"sale_price"=> "#f7782c",	"basic_sale_rate"=> "#f7782c",	"solo_event_icon"=> "#f7782c",	"solo_event_bg"=> "#f7782c",	"solo_event_text"=> "#ffffff",	"review_score"=> "#f7782c",	"deatil_sale_rate_bg"=> "#fd985c",	"deatil_sale_rate_text"=> "#ffffff",	"coupon_btn"=> "#f7782c",	"major_button_line"=> "#f7782c",	"major_button_bg"=> "#f7782c",	"major_button_text"=> "#ffffff",	"push_count_bg"=> "#f7782c",	"push_count_text"=> "#ffffff",	"best_rank1_bg"=> "#f7782c",	"best_rank1_text"=> "#ffffff",	"best_rank2_bg"=> "#f7782c",	"best_rank2_text"=> "#ffffff",	"best_rank3_bg"=> "#f7782c",	"best_rank3_text"=> "#ffffff", "best_rank4_bg"=> "#f7782c",	"best_rank4_text"=> "#ffffff",	"board_list_active_line"=> "#f7782c",	"board_list_active_text"=> "#f7782c",	"paging_active_line"=> "#f7782c",	"paging_active_text"=> "#f7782c"),
			"yellow"	  => array( "main_color" => "#F79F1F", "gnb_active_line"=> "#F79F1F",	"gnb_active_text"=> "#F79F1F",	"gnb_submenu"=> "#fbbb5f",	"lnb_active_text"=> "#F79F1F",	"sale_price"=> "#F79F1F",	"basic_sale_rate"=> "#F79F1F",	"solo_event_icon"=> "#F79F1F",	"solo_event_bg"=> "#F79F1F",	"solo_event_text"=> "#ffffff",	"review_score"=> "#F79F1F",	"deatil_sale_rate_bg"=> "#fbbb5f",	"deatil_sale_rate_text"=> "#ffffff",	"coupon_btn"=> "#F79F1F",	"major_button_line"=> "#F79F1F",	"major_button_bg"=> "#F79F1F",	"major_button_text"=> "#ffffff",	"push_count_bg"=> "#F79F1F",	"push_count_text"=> "#ffffff",	"best_rank1_bg"=> "#F79F1F",	"best_rank1_text"=> "#ffffff",	"best_rank2_bg"=> "#F79F1F",	"best_rank2_text"=> "#ffffff",	"best_rank3_bg"=> "#F79F1F",	"best_rank3_text"=> "#ffffff", "best_rank4_bg"=> "#F79F1F",	"best_rank4_text"=> "#ffffff",	"board_list_active_line"=> "#F79F1F",	"board_list_active_text"=> "#F79F1F",	"paging_active_line"=> "#F79F1F",	"paging_active_text"=> "#F79F1F"),
			"brown"		  => array( "main_color" => "#906240", "gnb_active_line"=> "#906240",	"gnb_active_text"=> "#906240",	"gnb_submenu"=> "#b87e53",	"lnb_active_text"=> "#906240",	"sale_price"=> "#906240",	"basic_sale_rate"=> "#906240",	"solo_event_icon"=> "#906240",	"solo_event_bg"=> "#906240",	"solo_event_text"=> "#ffffff",	"review_score"=> "#906240",	"deatil_sale_rate_bg"=> "#b87e53",	"deatil_sale_rate_text"=> "#ffffff",	"coupon_btn"=> "#906240",	"major_button_line"=> "#906240",	"major_button_bg"=> "#906240",	"major_button_text"=> "#ffffff",	"push_count_bg"=> "#906240",	"push_count_text"=> "#ffffff",	"best_rank1_bg"=> "#906240",	"best_rank1_text"=> "#ffffff",	"best_rank2_bg"=> "#906240",	"best_rank2_text"=> "#ffffff",	"best_rank3_bg"=> "#906240",	"best_rank3_text"=> "#ffffff", "best_rank4_bg"=> "#906240",	"best_rank4_text"=> "#ffffff",	"board_list_active_line"=> "#906240",	"board_list_active_text"=> "#906240",	"paging_active_line"=> "#906240",	"paging_active_text"=> "#906240"),
			"yellowgreen" => array( "main_color" => "#99b242", "gnb_active_line"=> "#99b242",	"gnb_active_text"=> "#99b242",	"gnb_submenu"=> "#b2c864",	"lnb_active_text"=> "#99b242",	"sale_price"=> "#99b242",	"basic_sale_rate"=> "#99b242",	"solo_event_icon"=> "#99b242",	"solo_event_bg"=> "#99b242",	"solo_event_text"=> "#ffffff",	"review_score"=> "#99b242",	"deatil_sale_rate_bg"=> "#b2c864",	"deatil_sale_rate_text"=> "#ffffff",	"coupon_btn"=> "#99b242",	"major_button_line"=> "#99b242",	"major_button_bg"=> "#99b242",	"major_button_text"=> "#ffffff",	"push_count_bg"=> "#99b242",	"push_count_text"=> "#ffffff",	"best_rank1_bg"=> "#99b242",	"best_rank1_text"=> "#ffffff",	"best_rank2_bg"=> "#99b242",	"best_rank2_text"=> "#ffffff",	"best_rank3_bg"=> "#99b242",	"best_rank3_text"=> "#ffffff", "best_rank4_bg"=> "#99b242",	"best_rank4_text"=> "#ffffff",	"board_list_active_line"=> "#99b242",	"board_list_active_text"=> "#99b242",	"paging_active_line"=> "#99b242",	"paging_active_text"=> "#99b242"),
			"green"		  => array( "main_color" => "#218c74", "gnb_active_line"=> "#218c74",	"gnb_active_text"=> "#218c74",	"gnb_submenu"=> "#2baf75",	"lnb_active_text"=> "#218c74",	"sale_price"=> "#218c74",	"basic_sale_rate"=> "#218c74",	"solo_event_icon"=> "#218c74",	"solo_event_bg"=> "#218c74",	"solo_event_text"=> "#ffffff",	"review_score"=> "#218c74",	"deatil_sale_rate_bg"=> "#2baf75",	"deatil_sale_rate_text"=> "#ffffff",	"coupon_btn"=> "#218c74",	"major_button_line"=> "#218c74",	"major_button_bg"=> "#218c74",	"major_button_text"=> "#ffffff",	"push_count_bg"=> "#218c74",	"push_count_text"=> "#ffffff",	"best_rank1_bg"=> "#218c74",	"best_rank1_text"=> "#ffffff",	"best_rank2_bg"=> "#218c74",	"best_rank2_text"=> "#ffffff",	"best_rank3_bg"=> "#218c74",	"best_rank3_text"=> "#ffffff", "best_rank4_bg"=> "#218c74",	"best_rank4_text"=> "#ffffff",	"board_list_active_line"=> "#218c74",	"board_list_active_text"=> "#218c74",	"paging_active_line"=> "#218c74",	"paging_active_text"=> "#218c74"),
			"bluegrey"    => array( "main_color" => "#778ca3", "gnb_active_line"=> "#778ca3",	"gnb_active_text"=> "#778ca3",	"gnb_submenu"=> "#8ba4bf",	"lnb_active_text"=> "#778ca3",	"sale_price"=> "#778ca3",	"basic_sale_rate"=> "#778ca3",	"solo_event_icon"=> "#778ca3",	"solo_event_bg"=> "#778ca3",	"solo_event_text"=> "#ffffff",	"review_score"=> "#778ca3",	"deatil_sale_rate_bg"=> "#8ba4bf",	"deatil_sale_rate_text"=> "#ffffff",	"coupon_btn"=> "#778ca3",	"major_button_line"=> "#778ca3",	"major_button_bg"=> "#778ca3",	"major_button_text"=> "#ffffff",	"push_count_bg"=> "#778ca3",	"push_count_text"=> "#ffffff",	"best_rank1_bg"=> "#778ca3",	"best_rank1_text"=> "#ffffff",	"best_rank2_bg"=> "#778ca3",	"best_rank2_text"=> "#ffffff",	"best_rank3_bg"=> "#778ca3",	"best_rank3_text"=> "#ffffff", "best_rank4_bg"=> "#778ca3",	"best_rank4_text"=> "#ffffff",	"board_list_active_line"=> "#778ca3",	"board_list_active_text"=> "#778ca3",	"paging_active_line"=> "#778ca3",	"paging_active_text"=> "#778ca3"),
			"blue"		  => array( "main_color" => "#0097e6", "gnb_active_line"=> "#0097e6",	"gnb_active_text"=> "#0097e6",	"gnb_submenu"=> "#3db5f3",	"lnb_active_text"=> "#0097e6",	"sale_price"=> "#0097e6",	"basic_sale_rate"=> "#0097e6",	"solo_event_icon"=> "#0097e6",	"solo_event_bg"=> "#0097e6",	"solo_event_text"=> "#ffffff",	"review_score"=> "#0097e6",	"deatil_sale_rate_bg"=> "#3db5f3",	"deatil_sale_rate_text"=> "#ffffff",	"coupon_btn"=> "#0097e6",	"major_button_line"=> "#0097e6",	"major_button_bg"=> "#0097e6",	"major_button_text"=> "#ffffff",	"push_count_bg"=> "#0097e6",	"push_count_text"=> "#ffffff",	"best_rank1_bg"=> "#0097e6",	"best_rank1_text"=> "#ffffff",	"best_rank2_bg"=> "#0097e6",	"best_rank2_text"=> "#ffffff",	"best_rank3_bg"=> "#0097e6",	"best_rank3_text"=> "#ffffff", "best_rank4_bg"=> "#0097e6",	"best_rank4_text"=> "#ffffff",	"board_list_active_line"=> "#0097e6",	"board_list_active_text"=> "#0097e6",	"paging_active_line"=> "#0097e6",	"paging_active_text"=> "#0097e6"),
			"navy"		  => array( "main_color" => "#273c75", "gnb_active_line"=> "#273c75",	"gnb_active_text"=> "#273c75",	"gnb_submenu"=> "#415ba2",	"lnb_active_text"=> "#273c75",	"sale_price"=> "#273c75",	"basic_sale_rate"=> "#273c75",	"solo_event_icon"=> "#273c75",	"solo_event_bg"=> "#273c75",	"solo_event_text"=> "#ffffff",	"review_score"=> "#273c75",	"deatil_sale_rate_bg"=> "#415ba2",	"deatil_sale_rate_text"=> "#ffffff",	"coupon_btn"=> "#273c75",	"major_button_line"=> "#273c75",	"major_button_bg"=> "#273c75",	"major_button_text"=> "#ffffff",	"push_count_bg"=> "#273c75",	"push_count_text"=> "#ffffff",	"best_rank1_bg"=> "#273c75",	"best_rank1_text"=> "#ffffff",	"best_rank2_bg"=> "#273c75",	"best_rank2_text"=> "#ffffff",	"best_rank3_bg"=> "#273c75",	"best_rank3_text"=> "#ffffff", "best_rank4_bg"=> "#273c75",	"best_rank4_text"=> "#ffffff",	"board_list_active_line"=> "#273c75",	"board_list_active_text"=> "#273c75",	"paging_active_line"=> "#273c75",	"paging_active_text"=> "#273c75"),
			"violet"	  => array( "main_color" => "#8854d0", "gnb_active_line"=> "#8854d0",	"gnb_active_text"=> "#8854d0",	"gnb_submenu"=> "#976ecf",	"lnb_active_text"=> "#8854d0",	"sale_price"=> "#8854d0",	"basic_sale_rate"=> "#8854d0",	"solo_event_icon"=> "#8854d0",	"solo_event_bg"=> "#8854d0",	"solo_event_text"=> "#ffffff",	"review_score"=> "#8854d0",	"deatil_sale_rate_bg"=> "#976ecf",	"deatil_sale_rate_text"=> "#ffffff",	"coupon_btn"=> "#8854d0",	"major_button_line"=> "#8854d0",	"major_button_bg"=> "#8854d0",	"major_button_text"=> "#ffffff",	"push_count_bg"=> "#8854d0",	"push_count_text"=> "#ffffff",	"best_rank1_bg"=> "#8854d0",	"best_rank1_text"=> "#ffffff",	"best_rank2_bg"=> "#8854d0",	"best_rank2_text"=> "#ffffff",	"best_rank3_bg"=> "#8854d0",	"best_rank3_text"=> "#ffffff", "best_rank4_bg"=> "#8854d0",	"best_rank4_text"=> "#ffffff",	"board_list_active_line"=> "#8854d0",	"board_list_active_text"=> "#8854d0",	"paging_active_line"=> "#8854d0",	"paging_active_text"=> "#8854d0"),
		);

		// custom 일 경우 basic을 기본값으로 설정
		if($key == 'custom'){
			$color = $themes_default['basic'];
		}else{
			$color = $themes_default[$key];
		}

		return $color;
	}

	public function get_design_banner($skin, $bannerSeq)
	{
		$query  = $this->db->select('*')
		->from('fm_design_banner')
		->where(
			array(
				'skin' => $skin,
				'banner_seq' => $bannerSeq
			)
		)
		->get();
		return $query;
	}

	public function get_design_banner_item($skin, $bannerSeq)
	{
		$query = $this->db->select('*')
		->from('fm_design_banner_item')
		->where(
			array(
				'skin' => $skin,
				'banner_seq' => $bannerSeq
			)
		)
		->get();
		return $query;
	}

	public function get_design_popup($popupSeq)
	{
		$query = $this->db->select('*')->from('fm_design_popup')->where(array('popup_seq' => $popupSeq))->get();
		return $query;
	}

	public function get_design_popup_banner($bannerSeq)
	{
		$query = $this->db->select('*')->from('fm_design_popup_banner')->where(array('banner_seq' => $bannerSeq))->get();
		return $query;
	}

	public function get_design_popup_banner_item($bannerSeq)
	{
		$query = $this->db->select('*')->from('fm_design_popup_banner_item')->where(array('banner_seq' => $bannerSeq))->get();
		return $query;
	}

	public function get_topbar($skin = '')
	{
		$this->db->select('*')
		->from('fm_topbar_style')
		->join('fm_topbar_file', 'tab_index = style_index', 'left');
		if ($skin) {
			$this->db->where(array('skin' => $skin));
		} else {
			$this->db->where('skin', '');
			$this->db->or_where('skin is null', null, false);
		}
		return $this->db->order_by('tab_seq', 'ASC')->get();
	}
}
?>
