<?php
require_once(APPPATH.'/libraries/Spout/Autoloader/autoload.php'); //excel library

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;

class Excelmembermodel extends CI_Model {
	var $cell = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

	var $itemList = array(
		"number"			=> "*번호",
		"referer_name"	=> "*유입",
		"status_nm"		=> "*승인",
		"group_name"	=> "*등급",
		"type"				=> "*유형",
		"join_sns"			=> "연동",
		"userid"				=> "*아이디",
		"user_name"		=> "이름",
		"nickname"		=> "닉네임",
		"email"				=> "이메일",
		"mailing"			=> "이메일 수신",
		"cellphone"		=> "핸드폰",
		"sms"				=> "SMS 수신",
		"phone"				=> "전화번호",
		"address"			=> "주소",
		"birthday"			=> "생일",
		"anniversary"		=> "기념일",
		"sex_name"		=> "성별",
		"regist_date"		=> "가입일",
		"lastlogin_date"	=> "최종방문일",
		"coupon"			=> "보유쿠폰",
		"emoney"			=> "마일리지",
		"point"				=> "포인트",
		"cash"				=> "예치금",
		"member_order_price"	=> "주문금액",
		"member_order_cnt"		=> "주문",
		"review_cnt"		=> "리뷰",
		"login_cnt"			=> "방문",
		"member_recommend_cnt"	=> "추천",
		"member_invite_cnt"			=> "초대",
		"recommend"		=> "추천인",
		"bceo"				=> "대표자명",
		"bno"					=> "사업자등록번호",
		"bitem"				=> "업태",
		"bstatus"			=> "종목",
		"bperson"			=> "담당자명",
		"bpart"				=> "담당자 부서명",
		"bname"				=> "업체명",
		"baddress"			=> "사업장 주소",
		"bphone"			=> "담당자 전화번호",
		"bcellphone"		=> "담당자 핸드폰"
	);

	var $requireds = array(
		"number",
		"referer_name",
		"status_nm",
		"group_name",
		"type",
		"userid"
	);

	public function excel_cell($count){
		$cell =$count;
		$char = 26;
		for($i=0;$i<$cell;$i++) {
			if($i<$char) $alpha[] = $this->cell[$i];
			else {
				$idx1 = (int)($i-$char)/$char;
				$idx2 = ($i-$char)%$char;
				$alpha[] = $this->cell[$idx1].$this->cell[$idx2];
			}
		}
		return $alpha;
	}
	public function excel_num($column){
		$cell =100;
		$char = 26;
		for($i=0; $i<$cell; $i++) {
			if($i < $char){
				$alpha[] = $this->cell[$i];
				if($column==$this->cell[$i]) return $i;
			}else {
				$idx1 = (int)($i-$char)/$char;
				$idx2 = ($i-$char)%$char;
				$alpha[] = $this->cell[$idx1].$this->cell[$idx2];
				if($column==$this->cell[$idx1].$this->cell[$idx2]) return $i;
			}

		}
	}

	public function create_excel_list($gets){

		if(!is_dir(ROOTPATH."data/sms")){
			mkdir(ROOTPATH."data/sms");
			chmod(ROOTPATH."data/sms",0777);
		}
		###
		$title_items = array();

		$datas = get_data("fm_exceldownload",array("gb"=>"MEMBER"));
		if (!$datas) {
			$callback = "";
			openDialogAlert("항목설정을 해주세요",400,140,'parent',$callback);
			exit;
		}
		$title_items = explode("|",$datas[0]['item']);

		//회원 정보 다운로드 비밀번호 검증
		//$check_down_passwd = $this->check_down_passwd($gets['member_download_passwd']);
		if ($this->session->userdata['member_excel_download'] != "y") {
			$callback = "parent.openDialog('회원정보 다운로드','admin_member_download', {'width':550,'height':420});parent.$('input[name=member_download_passwd]').val('');parent.$('input[name=member_download_passwd]').focus();";
			openDialogAlert("잘못된 접근입니다.",400,140,'parent',$callback);
			exit;
		}

		$this->load->model('snsmember');
		$this->load->model('membermodel');
		$this->load->model('couponmodel');
		$this->load->model('Goodsreview','Boardmodel');//리뷰건

		if($gets['excel_type']=='search'){
			$_GET = $gets;
			$limittotalnum = 3000;
			###
			if($_GET['header_search_keyword']) $_GET['keyword'] = $_GET['header_search_keyword'];

			### SEARCH
			if ($_GET['keyword']=="이름, 아이디, 이메일, 전화번호, 핸드폰(뒷자리4), 주소, 닉네임") {
				unset($_GET['keyword']);
			}

			$sc = $_GET;
			$sc['orderby']			= (isset($_GET['orderby'])) ?	$_GET['orderby']:'A.member_seq';
			$sc['sort']				= (isset($_GET['sort'])) ?		$_GET['sort']:'desc';
			if($_GET['searchcount'] < $limittotalnum) $sc['nolimit']	= "y";

			// 판매환경
			if( $_GET['sitetype'] ){
				$sc['sitetype'] = implode('\',\'',$_GET['sitetype']);
			}

			// 가입방법
			if( $_GET['snsrute'] ) {
				foreach($_GET['snsrute'] as $key=>$val){$sc[$val] = 1;}
			}

			ini_set("memory_limit",-1);
			set_time_limit(0);

			//3천건 이상 3천건씩 파일생성 후  압축하여 다운로드
			if($_GET['searchcount'] >= $limittotalnum) {
				$arrSystem	= ($this->config_system)?$this->config_system:config_load('system');
				$arr_sub_domain = explode(".",$arrSystem['subDomain']);
				$name_sub_domain = sprintf("%s","{$arr_sub_domain['0']}");

				$count = $_GET['searchcount'] / $limittotalnum;
				$ceilcount = ceil($count);

				for($ii=0; $ii<$ceilcount; $ii++){

					unset($this->db->queries);
					unset($this->db->query_times);
					unset($result,$data);

					$sc['page'] = $ii * $limittotalnum;
					$sc['perpage'] = $limittotalnum;

					$data = $this->membermodel->admin_member_list($sc);
					$datas = array();
					$dcount = $data['count']; $idx = 1;
					for($kk=0;$kk<$data['count'];$kk++){
						if( !$data['result'][$kk]['member_seq'] ) continue;
						$this->_ck_data_result_init($title_items, $data, $kk, $idx, $sc);//회원데이타 가공 공통
						$dcount--;
						$idx++;
					}
					if( $data['result'] ) {
						$date_info1 = date("Y-m-d");
						$date_info2 = date("H:i:s");
						$date_info = str_replace("-","",$date_info1).str_replace(":","",$date_info2);
						$this->filenames = ($ii+1).".".$name_sub_domain."_member_list_".$date_info.".xls";
						$fp = @fopen($_SERVER['DOCUMENT_ROOT']."/data/sms/".$this->filenames, "w");// or die("Can't open file ".$this->filenames);
						if($fp === false) {
							$callback = "";
							openDialogAlert($this->filenames."<br/> 파일을 찾을수 없습니다.",400,140,'parent',$callback);
							exit;
						}
						$result = $this->excel_file_fwrite($data['result'], $title_items,$ii, $fp);
						fclose($fp);

						$downFileList[$ii] = $_SERVER['DOCUMENT_ROOT']."/data/sms/".$this->filenames;
					}
				}

				echo "<form name='downfrm' method='post' action='../batch_process/download_member_zipfile'>";
				foreach($downFileList as $filename){
					echo "<input type='text' name='downFileList[]' value='".$filename."'>";
				}
				echo "<form>";
				echo "<script>parent.loadingStop(); document.downfrm.submit();</script>";

				$date_info1 = date("Y-m-d");
				$date_info2 = date("H:i:s");

				// 회원정보 다운로드 로그기록
				$manager_id = $this->managerInfo['manager_id'];
				$insert_data = array();
				$insert_data['manager_seq'] = $this->managerInfo['manager_seq'];
				$insert_data['manager_id'] = $manager_id;
				$down_count = $_GET['searchcount'];
				$str_down_count = number_format($_GET['searchcount'])."명";
				$insert_data['manager_log'] = sprintf("%s %s %s (%s) %s", $date_info1, $date_info2 ,'관리자가('.$manager_id.')가 회원정보('.$str_down_count.')를 다운로드 하였습니다.', $_SERVER['REMOTE_ADDR'], implode(",",$downFileList) );
				$insert_data['ip'] = $_SERVER['REMOTE_ADDR'];
				$insert_data['down_count'] = $down_count;
				$insert_data['file_name'] = 'download_member_zipfile.zip';
				$insert_data['reg_date'] = sprintf("%s %s", $date_info1, $date_info2);
				$result = $this->db->insert('fm_log_member_download', $insert_data);

				/* 주요행위 기록 */
				$this->load->model('managermodel');
				$this->managermodel->insert_action_history($this->managerInfo['manager_seq'],'member_excel_download',number_format($_GET['searchcount']).'명, download_member_zipfile.zip');

			}else{
				$data = $this->membermodel->admin_member_list($sc);
				$datas = array();

				$dcount = $data['count'];
				for($kk=0;$kk<$data['count'];$kk++){
					unset($this->db->queries);
					unset($this->db->query_times);
					if( !$data['result'][$kk]['member_seq'] ) continue;
					$this->_ck_data_result_init( $title_items, $data, $kk, $dcount,false);//회원데이타 가공 공통
					$dcount--;
				}
				$this->excel_write($data['result'], $title_items);
			}
		}
	}

    function create_excel_list_spout($params){
		ini_set("memory_limit",-1);
		set_time_limit(0);

		$reg_date = date('Y-m-d H:i:s');
		$title_items = array();
		$datas = get_data("fm_exceldownload",array("gb"=>"MEMBER"));
		if (!$datas) {
			echo '항목 설정을 해 주세요.';
			exit;
		}

		$this->load->model('snsmember');
		$this->load->model('membermodel');
		$this->load->model('couponmodel');
		$this->load->model('Goodsreview','Boardmodel');//리뷰건

		$title_items = explode("|",$datas[0]['item']);

		$fileExe = 'xlsx';
		$writer = WriterFactory::create(Type::XLSX); // for XLSX files

		$border = (new BorderBuilder())
			->setBorderRight(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
			->build();

		$style_title = (new StyleBuilder())
		   ->setBorder($border)
           ->setFontBold()
           ->setFontSize(11)
           ->setFontColor(Color::BLACK)
           ->setShouldWrapText(false)
           ->setBackgroundColor(Color::rgb(221, 221, 221))
           ->build();

		$style_contents = (new StyleBuilder())
		   ->setBorder($border)
           ->setFontSize(11)
           ->setFontColor(Color::BLACK)
           ->setShouldWrapText(false)
           ->build();

		if($params['header_search_keyword']) $params['keyword'] = $params['header_search_keyword'];

		if ($params['keyword']=="이름, 아이디, 이메일, 전화번호, 핸드폰(뒷자리4), 주소, 닉네임") {
			unset($params['keyword']);
		}

		$sc = $params;
		$sc['nolimit'] = 'y';
		$sc['excel_spout_query'] = true; //쿼리 받아서 처리 프로세스

		// 판매환경
		if( $params['sitetype'] ){
			$sc['sitetype'] = implode('\',\'',$params['sitetype']);
		}

		// 가입방법
		if( $params['snsrute'] ) {
			foreach($params['snsrute'] as $key=>$val){$sc[$val] = 1;}
		}

		//항목 쓰기
		$columnNames = array();
		foreach($title_items as $name){
			if( is_null($this->itemList[$name]) ){
				$columnNames[] = $name;
			} else {
				$columnNames[] = $this->itemList[$name];
			}
		}

		$arrSystem	= ($this->config_system)?$this->config_system:config_load('system');
		$arr_sub_domain = explode(".",$arrSystem['subDomain']);
		$name_sub_domain = sprintf("%s","{$arr_sub_domain['0']}");

		//등급 & 방문경로 매핑 kmj
		$groupDB = $this->db->query("SELECT group_seq, group_name FROM fm_member_group");
		$groupArr = $groupDB->result_array();
		$groupInfo = array();
		foreach($groupArr as $k => $v){
			$groupInfo[$v['group_seq']] = $v['group_name'];
		}

		$refereDB = $this->db->query("SELECT referer_group_name, referer_group_url FROM fm_referer_group");
		$refereArr = $refereDB->result_array();
		$refereInfo = array();
		foreach($refereArr as $k => $v){
			$refereInfo[$v['referer_group_url']] = $v['referer_group_name'];
		}

		$echoPath = "member/" . date("Ymd") . "/";
		$downPath = ROOTPATH . "excel_download/" . $echoPath;
		if(!is_dir($downPath)){
			mkdir($downPath);
			chmod($downPath,0777);
		}

		$filename =  $name_sub_domain."_member_list_".date('YmdHis').".".$fileExe;
		$filepath = $downPath . $filename;
		$writer->openToFile($filepath);
		$writer->addRowWithStyle($columnNames, $style_title); 

		$query = $this->membermodel->admin_member_list_spout($sc);
		$queryDB = mysqli_query($this->db->conn_id, $query);
		
		$i = 1;
		while($v = mysqli_fetch_array($queryDB)){
			unset($this->db->queries);
			unset($this->db->query_times);

			if( !$v['member_seq'] ) continue;
			
			//등급 & 방문경로 매핑 kmj
			$v['group_name']	= $groupInfo[$v['group_seq']];
			$v['referer_name']	= $refereInfo[$v['referer_domain']];
			
			if($v['referer_name'] === NULL){
				if($v['referer_domain'] === NULL){
					$v['referer_name'] = "직접입력";
				} else {
					$v['referer_name'] = "기타";
				}
			}

			$writeData = array();
			$thisNum   = $i++;
			$writeData = $this->excel_write_spout($title_items, $v, $thisNum);
			$writer->addRowWithStyle($writeData, $style_contents);
		}

		$writer->close();

		$com_date		= date('Y-m-d H:i:s');
		$expired_date	= date('Y-m-d H:i:s', strtotime('+7 days', strtotime($com_date)));
		$setData = array(
			'id'			=> '',
			'provider_seq'	=> 1,
			'manager_id'	=> $this->managerInfo['manager_id'],
			'category'		=> 3, //1:goods, 2:order, 3:member
			'excel_type'	=> $params['excel_type'], 
			'context'		=> serialize($params),
			'count'			=> $params['searchcount'],
			'state'			=> 2,
			'file_name'		=> str_replace("member/", "", $echoPath.$filename),
			'limit_count'	=> $params['perpage'],
			'reg_date'		=> $reg_date,
			'com_date'		=> $com_date,
			'expired_date'	=> $expired_date
		);
		$this->db->insert('fm_queue', $setData);

		echo $echoPath.$filename;
		exit;
    }

	public function excel_write_spout($title_items, $v, $num){
		$writeData = array();

		foreach($title_items as $vv) {
			$writeData[$vv] = $v[$vv];
		}

		$writeData['number'] = $num;

		if( in_array('address', $title_items) ) {
			$tmp_address = "";
			if (!$v['zipcode'] || $v['zipcode'] == "-") {
				$tmp_address = "";
			} else {
				$tmp_address .= $v['zipcode'];
			}

			if ($v['address']) {
				$tmp_address .= sprintf("(지번) %s", $v['address']);
			}

			if ($v['address_street']) {
				$tmp_address .= sprintf("(도로명) %s", $v['address_street']);
			}

			if ($v['address_detail']) {
				$tmp_address .= sprintf("(공통상세) %s", $v['address_detail']);
			}

			$writeData['address'] = $tmp_address;
			unset($tmp_address);
		}

		if( in_array('baddress', $title_items) ) {
			$tmp_address = "";
			if (!$v['bzipcode'] || $v['bzipcode'] == "-") {
				$tmp_address = "";
			} else {
				$tmp_address .= $v['bzipcode'];
			}

			if ($v['baddress']) {
				$tmp_address .= sprintf("(지번) %s", $v['baddress']);
			}

			if ($v['baddress_street']) {
				$tmp_address .= sprintf("(도로명) %s", $v['baddress_street']);
			}

			if ($v['baddress_detail']) {
				$tmp_address .= sprintf("(공통상세) %s", $v['baddress_detail']);
			}

			$writeData['baddress'] = $tmp_address;
			unset($tmp_address);
		}

		if( in_array('type', $title_items) ){
			$writeData['type'] = $v['business_seq'] ? '기업' : '개인';
		}

		if( in_array('sex_name', $title_items) ){
			if ($v['sex'] == "female") {
				$writeData['sex_name'] = "여";
			} else if ($v['sex'] == "male") {
				$writeData['sex_name'] = "남";
			} else {
				$writeData['sex_name'] = "";
			}
		}

		// 보유쿠폰
		if( in_array('coupon', $title_items) ){
			$sc['whereis']			= " and use_status='unused' and member_seq='".$v['member_seq']."'";
			$writeData['coupon']	= $this->couponmodel->get_download_total_count($sc);
		}

		if( in_array('join_sns', $title_items) ){
			$snsmbsc = array();
			$snsmbsc['select'] = " * ";
			$snsmbsc['whereis'] = " and member_seq ='".$v['member_seq']."' ";
			$snslist = $this->snsmember->snsmb_list($snsmbsc);
		
			if($snslist['result'][0]) {
				$info_sns = array();
				//debug_var($snslist['result']);
				foreach ($snslist['result'] as $key => $key2) {
					if ($key2['rute']=="naver") $info_sns[]="N";
					if ($key2['rute']=="facebook") $info_sns[]="F";
					if ($key2['rute']=="cyworld") $info_sns[]="C";
					if ($key2['rute']=="twitter") $info_sns[]="T";
					if ($key2['rute']=="daum") $info_sns[]="D";
					if ($key2['rute']=="kakao") $info_sns[]="K";
					if ($key2['rute']=="apple") $info_sns[]="A";
				}
				$writeData['join_sns'] = join("/",$info_sns);
			}
		}

		return $writeData;
	}

	// 3천이상 회원이면3천씩 저장 후 전체 zip 다운 @2015-08-27
	public function excel_file_fwrite($data, $title_items,$number, $wfile) {
		if( !$this->pxl ) $this->load->library('pxl');

		$item_arr = $this->itemList;
		$fields = array();
		$item = array();
		foreach($title_items as $k){
			$item[] = $k;
			$fields[$k] = $item_arr[$k];
		}
		$cell_arr = $this->excel_cell(count($item));
		$cnt = count($fields);
		$t=2;
		unset($datas);
		foreach ($data as $k)
		{
			$items = array();
			for($i=0;$i<$cnt;$i++){
				$tmp = $item[$i];
				$items[$t][$i] = $k[$tmp];
			}
			$t++;

			$datas[] = $items;
		}
		$result = $this->pxl->excel_download_fwrite($datas, $fields, $this->filenames,'회원정보다운로드', $wfile);//file write


		return $result;
	}

	//3천이하 회원이면 파일 xls
	public function excel_write($data, $title_items) {

		$this->load->library('pxl');
		$arrSystem	= ($this->config_system)?$this->config_system:config_load('system');
		$arr_sub_domain = explode(".",$arrSystem['subDomain']);
		$name_sub_domain = sprintf("%s","{$arr_sub_domain['0']}");
		$date_info1 = date("Y-m-d");
		$date_info2 = date("H:i:s");
		$date_info = str_replace("-","",$date_info1).str_replace(":","",$date_info2);
		$filenames = $name_sub_domain."_member_list_".$date_info.".xls";

		$item_arr = $this->itemList;
		$fields = array();
		$item = array();
		foreach($title_items as $k){
			$item[] = $k;
			$fields[$k] = $item_arr[$k];
		}
		$cell_arr = $this->excel_cell(count($item));
		$cnt = count($fields);
		$t=2;

		foreach ($data as $k)
		{
			$items = array();
			for($i=0;$i<$cnt;$i++){
				$tmp = $item[$i];
				$items[$t][$i] = $k[$tmp];
			}
			$t++;

			$datas[] = $items;
		}

		// 회원정보 다운로드 로그기록
		$manager_id = $this->managerInfo['manager_id'];
		$insert_data = array();
		$insert_data['manager_seq'] = $this->managerInfo['manager_seq'];
		$insert_data['manager_id'] = $manager_id;
		$down_count = count($data);
		$str_down_count = number_format($down_count)."명";
		$insert_data['manager_log'] = sprintf("%s %s %s (%s) %s", $date_info1, $date_info2 ,'관리자가('.$manager_id.')가 회원정보('.$str_down_count.')를 다운로드 하였습니다.', $_SERVER['REMOTE_ADDR'], $filenames);
		$insert_data['ip'] = $_SERVER['REMOTE_ADDR'];
		$insert_data['down_count'] = $down_count;
		$insert_data['file_name'] = $filenames;
		$insert_data['reg_date'] = sprintf("%s %s", $date_info1, $date_info2);
		$this->db->insert('fm_log_member_download', $insert_data);

		/* 주요행위 기록 */
		$this->load->model('managermodel');
		$this->managermodel->insert_action_history($this->managerInfo['manager_seq'],'member_excel_download',number_format($down_count).'명, '.$filenames);

		$this->pxl->excel_download($datas, $fields, $filenames,'회원정보다운로드');
	}

	//회원 정보 다운로드 비밀번호 검증
	public function check_down_passwd($passwd){
		### 회원 정보 다운로드 비밀번호 검증
		$str_md5 = md5($passwd);
		$str_sha256_md5 = hash('sha256',$str_md5);
		$query = "SELECT * FROM fm_manager WHERE manager_id=? AND (member_download_passwd=? OR member_download_passwd=?)";
		$query = $this->db->query($query,array($this->managerInfo['manager_id'],$str_md5,$str_sha256_md5));
		$data = $query->row_array();
		if(!$data){
			return false;
		} else {
			return true;
		}
	}

	//회원데이타 가공 공통
	function _ck_data_result_init($title_items, &$data, $k, $idx, $sc=null) {
		$data['result'][$k]['number']			= ($sc)?$sc['page']+$idx:$idx;

		if( $data['result'][$k]['business_seq'] ) {
			$data['result'][$k]['user_name']		= $data['result'][$k]['bname'];
			$data['result'][$k]['cellphone']			= $data['result'][$k]['bcellphone'];
			$data['result'][$k]['phone']				= $data['result'][$k]['bphone'];
			$data['result'][$k]['zipcode']			= $data['result'][$k]['bzipcode'];
			$data['result'][$k]['address']			= $data['result'][$k]['baddress'];
			$data['result'][$k]['address_detail']	= $data['result'][$k]['baddress_detail'];
		}
		$tmp_address = "";
		if (!$data['result'][$k]['zipcode'] || $data['result'][$k]['zipcode'] == "-") {
			$tmp_address = "";
		} else {
			$tmp_address .= $data['result'][$k]['zipcode'];
		}

		if ($data['result'][$k]['address']) {
			$tmp_address .= "<br style='mso-data-placement: same-cell'>".sprintf("(지번) %s", $data['result'][$k]['address']);
		}

		if ($data['result'][$k]['address_street']) {
			$tmp_address .= "<br style='mso-data-placement: same-cell'>".sprintf("(도로명) %s", $data['result'][$k]['address_street']);
		}

		if ($data['result'][$k]['address_detail']) {
			$tmp_address .= "<br style='mso-data-placement: same-cell'>".sprintf("(공통상세) %s", $data['result'][$k]['address_detail']);
		}

		$data['result'][$k]['address'] = $tmp_address;
		unset($tmp_address);

		$data['result'][$k]['type']	= $data['result'][$k]['business_seq'] ? '기업' : '개인';

		if ($data['result'][$k]['sex']=="female") {
			$data['result'][$k]['sex_name'] = "여";
		} else if ($data['result'][$k]['sex']=="male") {
			$data['result'][$k]['sex_name'] = "남";
		} else {
			$data['result'][$k]['sex_name'] = "";
		}

		// 보유쿠폰
		$dsc['whereis'] = " and use_status='unused' and member_seq='".$data['result'][$k]['member_seq']."'";
		$data['result'][$k]['coupon']	= $this->couponmodel->get_download_total_count($dsc);

		if(in_array('join_sns',$title_items)){
			$snsmbsc = array();
			$snsmbsc['select'] = " * ";
			$snsmbsc['whereis'] = " and member_seq ='".$data['result'][$k]['member_seq']."' ";
			$snslist = $this->snsmember->snsmb_list($snsmbsc);
			if($snslist['result'][0]) {
				$info_sns = array();
				//debug_var($snslist['result']);
				foreach ($snslist['result'] as $key=>$key2) {
					if ($key2['rute']=="naver") $info_sns[]="N";
					if ($key2['rute']=="facebook") $info_sns[]="F";
					if ($key2['rute']=="cyworld") $info_sns[]="C";
					if ($key2['rute']=="twitter") $info_sns[]="T";
					if ($key2['rute']=="daum") $info_sns[]="D";
					if ($key2['rute']=="kakao") $info_sns[]="K";
					if ($key2['rute']=="apple") $info_sns[]="A";
				}
				$data['result'][$k]['join_sns'] = join("/",$info_sns);
			}
		}
	}

}
/* End of file excelmembermodel.php */
/* Location: .app/models/excelmembermodel */