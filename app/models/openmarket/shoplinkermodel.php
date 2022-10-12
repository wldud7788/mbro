<?php
class shoplinkermodel extends CI_Model {
	var $cdb;
	var $customer_id;
	var $shoplinker_id;

	function __construct() {
		parent::__construct();

		$this->cfg_shoplinker = config_load('shoplinker');
		if(!$this->cfg_shoplinker['use']) return;
		$this->load->helper('readurl');
	}

	/* XML출력 */
	function print_xml(){
		$method = $_GET['method'];
		$params = unserialize($_GET['params']);

		$function = $method."_xmldata";
		$xmldata = $this->$function($params);

		if($method=='shoplinker_category' || $method=='mallproduct'){
			$group = 'Shoplinker';
		}else{
			$group = 'openMarket';
		}

		header("Content-Type: application/xml;charset=utf-8");
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<'.$group.'>';
		echo '<MessageHeader>';
			echo '<sendID>1</sendID>';
			echo '<senddate>'.date('Ymd').'</senddate>';
		echo '</MessageHeader>';
		$this->_print_xml_loop($xmldata);
		echo '</'.$group.'>';
	}

	function _print_xml_loop($data,$key=''){
		if(is_array($data)){
			foreach($data as $k=>$v){
				$k_end = explode(" ",$k);
				$k_end = $k_end[0];

				$key_end = explode(" ",$key);
				$key_end = $key_end[0];

				if(is_numeric($k)){
					if($k) echo "</{$key}><{$key}>";
					$this->_print_xml_loop($v,$k);
				}else{
					echo "<{$k}>";
					$this->_print_xml_loop($v,$k);
					echo "</{$k_end}>";
				}
			}
		}else{
			echo $data;
		}
	}

	/* 문자열처리 */
	function cdata($params,$keys){
		foreach($keys as $key){
			if(isset($params[$key])) {
				$params[$key] = str_replace(array("'",'"'),'',$params[$key]);
				$params[$key] = "<![CDATA[".trim($params[$key])."]]>";
			}
		}
		return $params;
	}

	/* 전송 및 결과반환 */
	function send($url,$method,$params=array()){

		//@2016-01-20 한글도메인체크
		$shoplinkurl = ($this->config_system['domain'] && !preg_match("/[\xA1-\xFE\xA1-\xFE]/",$this->config_system['domain']))?$this->config_system['domain']:$this->config_system['subDomain'];
		$iteminfo_url = "http://".$shoplinkurl."/partner/shoplinker?method=".$method."&params=".urlencode(serialize($params));

		$cu = curl_init();
		curl_setopt($cu, CURLOPT_URL,$url); // 데이터를 보낼 URL 설정
		curl_setopt($cu, CURLOPT_HEADER, FALSE);
		curl_setopt($cu, CURLOPT_FAILONERROR, TRUE);
		curl_setopt($cu, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded;charset=UTF-8'));
		curl_setopt($cu, CURLOPT_POST, 1);
		curl_setopt($cu, CURLOPT_POSTFIELDS, "iteminfo_url=".urlencode($iteminfo_url));
		curl_setopt($cu, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($cu, CURLOPT_TIMEOUT,1800); // REQUEST 에 대한 결과값을 받는 시간 설정.
		curl_setopt($cu, CURLOPT_SSL_VERIFYPEER, 0); //
		curl_setopt($cu, CURLOPT_SSL_VERIFYHOST, 1); //
		$result = curl_exec($cu);

		return $result;
	}

	/* 로그기록 */
	function result_message_log($method,$ResultMessage){
		$logDir = ROOTPATH.'data/logs';
		if(!is_dir($logDir)){
			mkdir($logDir);@chmod($logDir,0777);
		}
		$logDir .= "/shoplinker";
		if(!is_dir($logDir)){
			mkdir($logDir);@chmod($logDir,0777);
		}
		$logDir .= "/".date('Ymd');
		if(!is_dir($logDir)){
			mkdir($logDir);@chmod($logDir,0777);
		}

		$logFilePath = $logDir."/".$method."_".date('Ym').".txt";

		$fp = fopen( $logFilePath, "a+" );
		fwrite($fp,"[".date('Y-m-d H:i:s')."]\r\n");
		fwrite($fp,"REMOTE_IP : ".$_SERVER['REMOTE_ADDR']."\r\n");
		ob_start();
		print_r($ResultMessage);
		$contents = ob_get_contents();
		$contents = str_replace("\n","\r\n",$contents);
		ob_clean();
		fwrite($fp,"{$contents}\r\n");
		/*
		foreach($ResultMessage as $k=>$v){
			fwrite($fp,"{$k} : {$v}\r\n");
		}
		*/
		fwrite($fp,"\r\n");
		fclose($fp);

		@chmod($logFilePath,0777);

		// 2016.06.09 로그 기록 후 3개월 지난 로그 파일 삭제 pjw
		$this->remove_old_logs();
	}

	/* 2016.06.09 3개월 지난 로그 삭제 pjw */
	function remove_old_logs(){
		$expire_date = date("Ymd", strtotime("-7 day"));
		$log_dir = ROOTPATH.'data/logs/shoplinker';
		$dh = @opendir($log_dir);
		while(($file = readdir($dh)) != false){
			
			if($file == "." || $file == "..")	continue;			

			if(date($file) < date($expire_date) && $file != "." && $file != ".."){
				$subdh = @opendir($log_dir.'/'.$file);
				while(($file2 = readdir($subdh)) != false){
					if($file2 == "." || $file2 == "..")	continue;		
					@unlink($log_dir.'/'.$file.'/'.$file2);
				}
				@rmdir($log_dir.'/'.$file);
				closedir($subdh);
			}
		}

        closedir($dh);
	}

	function update_order_receive($str)
	{
		$filePath = './data/shoplinker.order_receive.txt';
		$fp = fopen($filePath, 'w');
		fwrite($fp, $str);
		fclose($fp);
	}

	function select_order_receive(){
		$filePath = './data/shoplinker.order_receive.txt';
		$fileContents = 'end';
		if(file_exists($filePath)) {
			
			$handle	= fopen($filePath, "r");
			$fileContents = fread($handle, filesize($filePath));
			fclose($handle);
			
			if( $fileContents == 'ing' ){
				$ftime = (time() - filemtime($filePath)) / 60;
				if( $ftime >= 30 ){
					$fileContents = 'end';
				}
			}
		}
		return $fileContents;
	}

	/* 주문 수집 */
	function order_receive($mall_order_code,$mall_key){
		// 중복실행방지
		$order_receive_status = $this->select_order_receive();
		if( $order_receive_status == 'ing' ){
			return array();
			exit;
		}
		$this->update_order_receive('ing');

		$this->load->helper('readurl');

		$url = "http://apiweb.shoplinker.co.kr/ShoplinkerApi/Order/orderlist.php";
		$method = "order_receive";
		$params = array(
			'customer_id'=>$this->customer_id,
			'shoplinker_id'=>$this->shoplinker_id,
			'mall_order_code'=>$mall_order_code,
			'mall_key'=>$mall_key
		);
		if(preg_match("/[\xE0-\xFF][\x80-\xFF][\x80-\xFF]/", $mall_key)){
			unset($params['mall_key']);
		}

		$result = $this->send($url,$method,$params);

		$result = xml2array($result);

		$this->result_message_log($method."_start",array_merge($params,(array)$result));

		$loop = $result['Shoplinker']['order'];
		if($result['openMarket']['OrderInfo']['Order']) $loop = $result['openMarket']['OrderInfo']['Order'];

		$now = date('Y-m-d H:i:s');

		$arr_order_seq = array();

		if($loop){
			$this->load->model('goodsmodel');
			$this->load->model('ordermodel');
			$this->load->helper('shipping');
			$this->load->model('providermodel');
			if(!$loop[0]) $loop = array($loop);

			$chkGoodsSeqs = array();
			$provider = array();

			foreach($loop as $loop_idx=>$order){

				// 이미 수집된 주문이면 pass
				$query = $this->db->query("select item_seq from fm_order_item where linkage_order_id=?",$order['shoplinker_order_id']);
				$order_data = $query->row_array();
				if($order_data['item_seq']) continue;

				foreach($order as $k=>$v){
					if(is_array($v) && !$v){
						$order[$k] = '';
					}
				}

				// 같은 주문번호끼리 묶음
				if(!$loop_idx || $loop[$loop_idx]['shoplinker_order_id']!=$loop[$loop_idx-1]['shoplinker_order_id']) {
					$orderGroups = array($order);
				}else{
					$orderGroups[] = $order;
				}

				if($loop[$loop_idx+1] && $loop[$loop_idx]['shoplinker_order_id']==$loop[$loop_idx+1]['shoplinker_order_id']){
					continue;
				}

				// 결제금액
				$settleprice = 0;
				foreach($orderGroups as $order) {
					$settleprice += $order['order_price'];
				}

				$this->db->trans_begin();

				$order = $orderGroups[0];

				// 주문번호 생성
				$order_seq	= $this->ordermodel->get_order_seq();

				// 배송비
				$shipping_method = 'delivery';
				$shipping_cost = $order['baesong_bi'];
				switch($order['baesong_type'])
				{
					case "무료" :
						$shipping_cost = 0;
					break;

					case "착불" :
						$shipping_method = 'postpaid';
					break;
					
					case "선불" :
					case "착불 선결제" :
						$settleprice += $shipping_cost;
					break;

					default:
						//쿠팡이고 배송비가 있으면 결제금액에 무조건 합치도록 개선 @2016-10-12 ysm
						if( $mall_order_code == 'APISHOP_0184' && $shipping_cost ) {
							$settleprice += $shipping_cost;
						}
					break;
				}

				//주소
				$address=$order['receive_addr'];
				$address1='';
				$address2='';
				$tmp=explode(" ",$address);
				if(substr($tmp[2],strlen($tmp[2])-2,strlen($tmp[2])-1)=="구"){
					$address1.=$tmp[0]." ".$tmp[1]." ".$tmp[2]." ".$tmp[3];
					for($i=4;$i<count($tmp);$i++){
						$address2.=$tmp[$i]." ";
					}
				}
				else{
					$address1.=$tmp[0]." ".$tmp[1]." ".$tmp[2];
					for($i=3;$i<count($tmp);$i++){
						$address2.=$tmp[$i]." ";
					}

				}

				$insert_params = array();
				$insert_params['order_seq']					= $order_seq;
				$insert_params['settleprice']				= $settleprice;
				$insert_params['shipping_method']			= $shipping_method;
				$insert_params['shipping_cost']				= $shipping_cost;
				$insert_params['payment']					= 'bank';
				$insert_params['step']						= 25;
				$insert_params['deposit_yn']				= 'y';
				$insert_params['deposit_date']				= date('Y-m-d H:i:s');
				$insert_params['order_user_name']			= $order['order_name'];
				$insert_params['order_phone']				= $order['order_tel'];
				$insert_params['order_cellphone']			= $order['order_cel'];
				$insert_params['order_email']				= $order['order_email'];
				$insert_params['recipient_user_name']		= $order['receive'];
				$insert_params['recipient_phone']			= $order['receive_tel'];
				$insert_params['recipient_cellphone']		= $order['receive_cel'];
				$insert_params['recipient_zipcode']			= $order['receive_zipcode'];
				$insert_params['recipient_address']			= $address1;
				$insert_params['recipient_address_detail']	= $address2;
				$insert_params['memo']						= $order['delivery_msg'];
				$year	= substr($order['orderdate'],0,4);
				$month	= substr($order['orderdate'],4,2);
				$day	= substr($order['orderdate'],6,2);
				$hour	= substr($order['orderdate'],8,2) == 24 ? 00 : substr($order['orderdate'],8,2);
				$minute	= substr($order['orderdate'],10,2);
				$second	= substr($order['orderdate'],12,2);
				$insert_params['regist_date']				= $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second;
				$insert_params['linkage_id']				= 'shoplinker';
				$insert_params['linkage_order_id']			= $order['shoplinker_order_id'];
				$insert_params['linkage_mall_order_id']		= $order['mall_order_id'];
				$insert_params['linkage_mall_code']			= $mall_order_code;
				$insert_params['linkage_order_reg_date']	= date('Y-m-d H:i:s');

				$this->db->insert('fm_order', $insert_params);

				$arr_order_seq[] = $order_seq;

				$cnt_shipping = 0;

				foreach($orderGroups as $order){

					$goods_data = array();
					$goods_image = array();
					if($order['partner_product_id']){
						$query = $this->db->query("select * from fm_goods where goods_seq=?",$order['partner_product_id']);
						$goods_data = $query->row_array();

						$query = $this->db->query("select * from fm_goods_image where goods_seq=? and image_type='thumbView' order by cut_number limit 1",$order['partner_product_id']);
						$goods_image = $query->row_array();
					}

					$provider_seq = $goods_data['provider_seq'] ? $goods_data['provider_seq'] : 1;
					if(!$provider || $provider['provider_seq']!=$provider_seq) $provider = $this->providermodel->get_provider($provider_seq);
					if($provider['deli_group']=='company'){
						$shipping_provider_seq = 1;
					}else{
						$shipping_provider_seq = $provider_seq;
					}

					//배송정책 저장
					$query = $this->db->query("select * from fm_order_shipping where order_seq=? and provider_seq=?",array($order_seq,$shipping_provider_seq));
					$chk_shipping = $query->row_array();
					if($chk_shipping){
						$shipping_seq = $chk_shipping['shipping_seq'];
					}else{
						$cnt_shipping++;

						$data = use_shipping_method($shipping_provider_seq);
						$data = $data[0][0];

						$insert_params = array();
						$insert_params['order_seq'] 			= $order_seq;
						$insert_params['provider_seq']			= $shipping_provider_seq; // 업체배송이면 입점사의 코드, 본사배송이면 본사의 코드 1

						if($data['deliveryCostPolicy']=='free'){
							$insert_params['delivery_cost'] = 0;
						}
						if($data['deliveryCostPolicy']=='pay'){
							$insert_params['delivery_cost']			= $data['payDeliveryCost'];
							$insert_params['postpaid']				= $data['postpaidDeliveryCost_yn'] == 'y' ? $data['postpaid_delivery_cost'] : 0;
						}
						if($data['deliveryCostPolicy']=='ifpay'){
							$insert_params['delivery_if']			= $data['ifpayFreePrice'];
							$insert_params['delivery_cost']			= $data['ifpayDeliveryCost'];
							$insert_params['postpaid']				= $data['ifpostpaidDeliveryCost_yn'] == 'y' ? $data['ifpostpaid_delivery_cost'] : 0;
						}

						$insert_params['shipping_cost']		= $shipping_cost? $shipping_cost/$cnt_shipping : 0;
						$insert_params['shipping_method']	= 'delivery';
						$insert_params['shipping_group']	= 'delivery1';
						$this->db->insert('fm_order_shipping', $insert_params);
						$shipping_seq = $this->db->insert_id();
					}

					$insert_params = array();
					$insert_params['order_seq'] 	= $order_seq;
					$insert_params['goods_seq'] 	= $goods_data['goods_seq']?$goods_data['goods_seq']:'';
					if($goods_data) $insert_params['goods_code'] 	= $goods_data['goods_code'];
					if($goods_image) $insert_params['image'] 		= $goods_image['image'];
					$insert_params['goods_name'] 	= $order['product_name'];
					$insert_params['provider_seq']	= $provider_seq;
					$insert_params['shipping_seq']	= $shipping_seq;
					$insert_params['linkage_order_id']	= $order['shoplinker_order_id'];
					$this->db->insert('fm_order_item', $insert_params);
					$item_seq = $this->db->insert_id();

					if($goods_data['goods_seq'] && !in_array($goods_data['goods_seq'],$chkGoodsSeqs)) $chkGoodsSeqs[] = $goods_data['goods_seq'];

					$insert_params = array();
					$insert_params['order_seq'] 	= $order_seq;
					$insert_params['item_seq'] 		= $item_seq;
					$insert_params['step'] 			= 25;
					$insert_params['price'] 		= $order['order_price']/$order['quantity'];
					$insert_params['ori_price'] 	= $order['sale_price'];

					$insert_params['ea'] 			= $order['quantity'];
					$insert_params['provider_seq']	= $provider_seq;
					$insert_params['shipping_seq']	= $shipping_seq;

					$optionData = null;
					if($order['sku']){
						preg_match("/_([0-9]+)_/i",$order['sku'],$matches);
						if(is_null($matches[1])) preg_match("/^([0-9]+)_/i",$order['sku'],$matches);
						if(is_null($matches[1])) preg_match("/\[([0-9]+)\]/i",$order['sku'],$matches);
						if(is_null($matches[1])) preg_match("/([0-9]+)_/i",$order['sku'],$matches);// @2016-07-06 ysm
						$option_seq = $matches[1];
						if($option_seq){
							$query = $this->db->query("select a.*, b.supply_price from fm_goods_option a left join fm_goods_supply b on (a.goods_seq=b.goods_seq and a.option_seq=b.option_seq) where a.goods_seq=? and ifnull(a.fix_option_seq,a.option_seq)=?",array($goods_data['goods_seq'],$option_seq));
							$optionData = $query->row_array();

							$titles = explode(",",$optionData['option_title']);

							if($optionData){
								$insert_params['title1'] 		= $titles[0];
								$insert_params['option1'] 		= $optionData['option1'];
								$insert_params['title2'] 		= $titles[1];
								$insert_params['option2'] 		= $optionData['option2'];
								$insert_params['title3'] 		= $titles[2];
								$insert_params['option3'] 		= $optionData['option3'];
								$insert_params['title4'] 		= $titles[3];
								$insert_params['option4'] 		= $optionData['option4'];
								$insert_params['title5'] 		= $titles[4];
								$insert_params['option5'] 		= $optionData['option5'];

								$insert_params['optioncode1'] = $optionData['optioncode1'];
								$insert_params['optioncode2'] = $optionData['optioncode2'];
								$insert_params['optioncode3'] = $optionData['optioncode3'];
								$insert_params['optioncode4'] = $optionData['optioncode4'];
								$insert_params['optioncode5'] = $optionData['optioncode5'];

								$insert_params['goods_code'] = $goods_data['goods_code'].$optionData['optioncode1'].$optionData['optioncode2'].$optionData['optioncode3'].$optionData['optioncode4'].$optionData['optioncode5'];

								$insert_params['supply_price'] 		= $provider_seq=='1' ? $optionData['supply_price'] : 0;

								if($order['sale_price'] && $optionData['commission_rate'])
								$insert_params['commission_price']	= $order['sale_price']*(100-$optionData['commission_rate'])/100;
							}
						}
					}
					if(!$optionData){
						$insert_params['title1'] 		= $order['sku']?'옵션':'';
						$insert_params['option1'] 		= $order['sku'];
						
						//ESM &11번가&스마트스토어 : 정산예정금액, 그외 쇼핑몰 납품가&공급가 @2016-07-06 ysm
						$insert_params['supply_price'] 		= $order['supply_price'];
					}

					for($i=1;$i<=5;$i++){
						if(is_null($insert_params['title'.$i])) $insert_params['title'.$i] = '';
						if(is_null($insert_params['option'.$i])) $insert_params['option'.$i] = '';
					}

					$this->db->insert('fm_order_item_option', $insert_params);
				}

				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
				}
				else
				{
					$this->db->trans_commit();
				}

				// 주문 총주문수량 / 총상품종류 업데이트 @2016-12-05
				$this->ordermodel->update_order_total_info($order_seq);

			}

			foreach($chkGoodsSeqs as $goodsSeq){
				$this->goodsmodel->modify_reservation_real($goodsSeq);
			}

		}

		$this->result_message_log($method."_end",array_merge($params,(array)$result));
		$this->update_order_receive('end'); // 중복실행방지

		return $arr_order_seq;
	}

	function order_receive_xmldata($params){
		$data = array();

		$customer_id		= $params['customer_id'];
		$shoplinker_id		= $params['shoplinker_id'];
		$mall_order_code	= $params['mall_order_code'];
		$mall_user_id		= $params['mall_key'];

		$query = $this->db->query("select linkage_order_reg_date from fm_order where linkage_id='shoplinker' order by linkage_order_reg_date desc limit 1");
		$order_data = $query->row_array();

		$data["order_flag"]				= '000';
		$data["customer_id"]			= $customer_id;
		$data["shoplinker_id"]			= $shoplinker_id;
		$data["st_date"]				= $order_data['linkage_order_reg_date'] ? date('Ymd',strtotime('-7 day',strtotime($order_data['linkage_order_reg_date']))) : date('Ymd',strtotime('-7 day'));
		$data["ed_date"]				= date('Ymd');
		$data["mall_order_code"]		= $mall_order_code;
		$data["mall_user_id"]			= $mall_user_id;

		#debug_Var($data);

		$data = $this->cdata($data,array('shoplinker_id','mall_user_id'));

		return array('OrderInfo'=>array('Order'=>$data));
	}

	## 샵링커로 연동 마켓 정보 요청
	function send_mallproduct($goods_seq){
		$this->load->helper('readurl');

		$request_url		= 'http://apiweb.shoplinker.co.kr/ShoplinkerApi/Product/mall_product_list.php';
		$method				= 'mallproduct';
		$params				= array('customer_id'=>$this->customer_id,'goods_seq'=>$goods_seq);
		$result				= $this->send($request_url, $method, $params);
		$result				= xml2array($result);
		$this->result_message_log($method,array_merge($params,(array)$result));

		$return['count']	= $result['Shoplinker']['ProductInfo']['MessageHeader']['count_all'];
		if	($return['count'] > 0){
			$mallProduct	= $result['Shoplinker']['ProductInfo']['Product'];
			if( $return['count'] == 1 ) {
				$mallList[0]['mall_id']	= $mallProduct['mall_id'];
				$mallList[0]['mall_name']	= $mallProduct['mall_name']; 
			}else{
				foreach($mallProduct as $k => $product){
					$mallList[$k]['mall_id']	= $product['mall_id'];
					$mallList[$k]['mall_name']	= $product['mall_name'];
				}
			}

			$return['list']	= $mallList;
		}

		return $return;
	}

	## 샵링커 연동 마켓 정보 추출
	function mallproduct_xmldata($params){
		$customer_id	= $params['customer_id'];
		$goods_seq		= $params['goods_seq'];
		if	($goods_seq){
			if	($customer_id){
				$query		= $this->db->query("select * from fm_goods where goods_seq = ? ", array($goods_seq));
				$goods		= $query->row_array();
				$data["customer_id"]			= $customer_id;
				$data["st_date"]				= date('Ymd', strtotime($goods['regist_date']));
				$data["ed_date"]				= date('Ymd');
				$data["partner_product_id"]		= $goods_seq;

				return array('productInfo'=>array('Product'=>$data));
			}
		}
	}
}
?>