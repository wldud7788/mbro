<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$vendorPath = BASEPATH."../vendor/";
require_once($vendorPath."autoload.php"); //es library

use Elasticsearch\ClientBuilder;
class CI_Elasticsearch {

	public $esClient;
	private $isAdmin;
	private $cid;

    public function __construct(){
		$ci =& get_instance();
		$this->db	= $ci->db;
		$this->cid	= $ci->config_system['service']['cid'];

		if( $this->db->es_use === true ) {
			if( !trim($this->db->es_username) || !trim($this->db->es_password) ){
				$this->db->es_use = false;
				return false;
			}
		} else {
			$this->db->es_use = false;
			return false;
		}

		$this->esClientM = ClientBuilder::create()->setHosts([$this->db->es_username.":".$this->db->es_password."@".$this->db->es_master])->build();
		$this->esClientR = ClientBuilder::create()->setHosts([$this->db->es_username.":".$this->db->es_password."@".$this->db->es_slave])->build();

		$referer_path = parse_url($_SERVER['REQUEST_URI']);
		$referer_path = array_filter(explode("/", $referer_path['path']));

		if($referer_path[1] == "admin"){
			$this->isAdmin = "A"; //admin
		} else if($referer_path[1] == "selleradmin"){
			$this->isAdmin = "S"; //seller
		} else {
			$this->isAdmin = "N"; 
		}
    }  

	public function index_check($type){
		$index_name = $this->cid."_".$type;

		try{
			$response = $this->esClientM->indices()->exists([
				'index' => $index_name,
				 'client' => [
					'timeout' => 3,        //seconds timeout
					'connect_timeout' => 3
				]
			]);

			if(!$response) {
				$params['index'] = $index_name;

				switch($type){
					case 'stats_visitor':
						$params['body'] = [
							'mappings' => [ 
								'count' => [ 
									'properties' => [ 
										'ip' => [ 
											'type' => 'ip'
											]
										] 
									]
								] 
							];
					break;

					case 'stats_search':
						$params['body'] = [
							'settings' => [ 
								'index' => [ 
									'analysis' => [ 
										'analyzer' => [ 
											'korean' => [ 
												'type' => 'custom', 
												'tokenizer'=>'mecab_ko_standard_tokenizer'
											] 
										], 
										'tokenizer'=> [ 
											'mecab_ko_standard_tokenizer'=> [ 
												'index_eojeol'	=> 'true',
												'decompound'	=> 'true',
												'type'			=> 'seunjeon_tokenizer',
												'index_poses'	=> [ 'UNK', 'EP', 'I', 'J', 'M', 'N', 'SL', 'SH', 'SN', 'VCP', 'XP', 'XS', 'XR' ]
											] 
										] 
									] 
								] 
							], 
							'mappings' => [ 
								'count' => [ 
									'properties' => [ 
										'keyword' => [ 
											'type' => 'text',
											'analyzer' => 'korean'
											],
										'ip' => [
											'type' => 'ip'	
											]
										]
									]
								] 
							];
					break;

					case 'stats_view':
						$params['body'] = [
							'settings' => [ 
								'index' => [ 
									'analysis' => [ 
										'analyzer' => [ 
											'korean' => [ 
												'type' => 'custom', 
												'tokenizer'=>'mecab_ko_standard_tokenizer'
											] 
										], 
										'tokenizer'=> [ 
											'mecab_ko_standard_tokenizer'=> [ 
												'index_eojeol'	=> 'true',
												'decompound'	=> 'true',
												'type'			=> 'seunjeon_tokenizer',
												'index_poses'	=> [ 'UNK', 'EP', 'I', 'J', 'M', 'N', 'SL', 'SH', 'SN', 'VCP', 'XP', 'XS', 'XR' ]
											] 
										] 
									] 
								] 
							], 
							'mappings' => [ 
								'count' => [ 
									'properties' => [ 
										'goods_name' => [ 
											'type' => 'text',
											'analyzer' => 'korean'
											]
										]
									]
								] 
							];
					break;
					
					/*
					case 'goods':
						$params['body'] = [
							'settings' => [ 
								'index' => [ 
									'analysis' => [ 
										'analyzer' => [ 
											'korean' => [ 
												'type' => 'custom', 
												'tokenizer'=>'mecab_ko_standard_tokenizer'
											] 
										], 
										'tokenizer'=> [ 
											'mecab_ko_standard_tokenizer'=> [ 
												'index_eojeol'	=> 'true',
												'decompound'	=> 'true',
												'type'			=> 'seunjeon_tokenizer',
												'index_poses'	=> [ 'UNK', 'EP', 'I', 'J', 'M', 'N', 'SL', 'SH', 'SN', 'VCP', 'XP', 'XS', 'XR' ]
											] 
										] 
									] 
								] 
							], 
							'mappings' => [ 
								'search' => [ 
									'properties' => [ 
										'goods_name' => [ 
											'type' => 'text',
											'analyzer' => 'korean'
											],
										'summary' => [ 
											'type' => 'text',
											'analyzer' => 'korean'
											],
										'goods_seq' => [
												'type' => 'integer'	
											],
										'provider_seq' => [
												'type' => 'integer'	
											],
										'default_price' => [
												'type' => 'integer'	
											],
										'purchase_ea' => [
												'type' => 'integer'	
											],
										'review_count' => [
												'type' => 'integer'	
											],
										'page_view' => [
												'type' => 'integer'	
											],
										'shipping_group_seq' => [
												'type' => 'integer'	
											]
										]
									]
								] 
							];
					break;
					*/

					case 'stats_goods':
						$params['body'] = [
							'settings' => [ 
								'index' => [ 
									'analysis' => [ 
										'analyzer' => [ 
											'korean' => [ 
												'type' => 'custom', 
												'tokenizer'=>'mecab_ko_standard_tokenizer'
											] 
										], 
										'tokenizer'=> [ 
											'mecab_ko_standard_tokenizer'=> [ 
												'index_eojeol'	=> 'true',
												'decompound'	=> 'true',
												'type'			=> 'seunjeon_tokenizer',
												'index_poses'	=> [ 'UNK', 'EP', 'I', 'J', 'M', 'N', 'SL', 'SH', 'SN', 'VCP', 'XP', 'XS', 'XR' ]
											] 
										] 
									] 
								] 
							], 
							'mappings' => [ 
								'search' => [ 
									'properties' => [ 
										'goods_name' => [ 
											'type' => 'text',
											'analyzer' => 'korean'
											],
										'ip' => [
												'type' => 'ip'	
											]
										]
									]
								] 
							];
					break;
				}

				try {
					$this->esClientM->indices()->create($params);
				} catch(exception $e) {
					//ES index creation error
					if($this->isAdmin === "A"){
						alert('엘라스틱 서치 인덱스 생성 에러. 관리자에게 문의 하세요.');
					}
					return false;
				}
			}
		} catch(exception $e){
			//ES connetion error
			if($this->isAdmin === "A"){
				alert('엘라스틱 서치 접속 에러. 관리자에게 문의 하세요.');
			}
			return false;
		}

		return $this->cid;
    } 


	public function get_stats_params($index_type, $count_type, $datas, $userInfo=null){
		$params = array();

		if(!$count_type || !$index_type){
			return false;
		}

		switch($index_type){
			case "stats_goods";
				$goods_seq = $datas['goods_seq'];

				if(!$goods_seq){
					return false;
				}

				$options = array();
				if($datas['option1'] && $datas['option1'] != 'none'){
					$options[] = $datas['option1'];
				}

				if($datas['option2'] && $v['option2'] != 'none'){
					$options[] = $datas['option2'];
				}

				if($datas['option3'] && $datas['option3'] != 'none'){
					$options[] = $datas['option3'];
				}

				if($datas['option4'] && $datas['option4'] != 'none'){
					$options[] = $datas['option4'];
				}

				if($datas['option5'] && $datas['option5'] != 'none'){
					$options[] = $datas['option5'];
				}

				if(!$options){
					$options = ["none"];
				}

				//상품정보
				$goodsInfo		= $this->get_goods_info($goods_seq, $options, array('goods_name', 'provider_seq'), array('price'));
				$default_price	= $goodsInfo['price'];
				$goods_name		= $goodsInfo['goods_name'];
				$provider_seq	= $goodsInfo['provider_seq'];

				$params = [
					'index' => $this->cid.'_'.$index_type,
					'type'	=> 'search',
					'body'	=> [
						'count_type'	=> $count_type,
						'goods_seq' 	=> intval($goods_seq),
						'goods_name' 	=> $goods_name,
						'provider_seq' 	=> $provider_seq > 0 ? intval($provider_seq) : 0,
						'category_code' => $this->get_category_code($goods_seq),
						'brand_code'	=> $this->get_brand_code($goods_seq),
						'location_code'	=> $this->get_location_code($goods_seq),
						'options' 		=> $options,
						'ea'			=> $datas['ea'] > 0 ? intval($datas['ea']) : 1,
						'total_price'	=> $datas['ea'] > 0	? intval($datas['ea'] * $default_price)	: intval($default_price),
						//'userid'		=> 'none',
						//'age'			=> 0,
						//'sex'			=> 'none',
						'review_score'	=> $datas['review_score'] > 0	? intval($datas['review_score']) : 0,
						'referer_domain'=> $datas['referer_domain']		? $datas['referer_domain']  : 'none',
						'referer'		=> $datas['referer']			? $datas['referer']			: 'none',
						'ip'			=> $_SERVER['REMOTE_ADDR'],
						'platform'		=> $datas['platform']			? $datas['platform']		: 'none',	
						'post_date'		=> date('Y-m-d').'T'.date('H:i:s')
					]
				];
			break;
			
			case "stats_search";
				$keyword = $datas['keyword'];

				if(!$keyword){
					return false;
				}

				$params = [
					'index' => $this->cid.'_'.$index_type,
					'type'	=> 'count',
					'body'	=> [
						'keyword' 		=> $keyword,
						'keyword_raw' 	=> $keyword,
						'ip'			=> $_SERVER['REMOTE_ADDR'],
						'platform'		=> $datas['platform'] ? $datas['platform'] : 'none',	
						'post_date'		=> date('Y-m-d').'T'.date('H:i:s')
					]
				];
			break;

			default:
				return false;
			break;
		}

		if($userInfo){
			$params['body']['userid']	= $userInfo['userid'] && $userInfo['userid'] != 'none' ? $userInfo['userid'] : 'none';
			$params['body']['sex']		= $userInfo['sex'] && $userInfo['sex'] != 'none' ? $userInfo['sex'] : 'none';
			$params['body']['age']		= $userInfo['birthday'] && $userInfo['birthday'] != '0000-00-00' ? intval(date('Y') - substr($userInfo['birthday'], 0, 4) + 1) : 0;
		} else {
			if($datas['member_seq']){
				$query = "sELECT userid, sex, birthday fROM fm_member wHERE member_seq=?";
				$query = $this->db->query($query, $datas['member_seq'])->result_array();
			} else if($datas['userid']){
				$query = "sELECT userid, sex, birthday fROM fm_member wHERE userid=?";
				$query = $this->db->query($query, $datas['userid'])->result_array();
			}

			if($query){
				$params['body']['userid']	= $query[0]['userid'];
				$params['body']['sex']		= $query[0]['sex'];
				$params['body']['age']		= $query[0]['birthday'] !='0000-00-00' ? intval(date('Y') - substr($query[0]['birthday'], 0, 4) + 1) : 0;
			}
			unset($query);
		}

		return $params;
	}

	public function get_category_code($goods_seq){
		$query = "sELECT category_code fROM fm_category_link wHERE goods_seq=? oRDER BY category_code";
		$query = $this->db->query($query, $goods_seq)->result_array();
		if($query){
			foreach($query as $val){
				$res[] = $val['category_code']; 
			}
		} else {
			$res = ["none"];
		}
		
		return array_unique($res);
	}

	public function get_brand_code($goods_seq){
		$query = "sELECT category_code fROM fm_brand_link wHERE goods_seq=? oRDER BY category_code";
		$query = $this->db->query($query, $goods_seq)->result_array();
		if($query){
			foreach($query as $val){
				$res[] = $val['category_code']; 
			}
		} else {
			$res = ["none"];
		}
		
		return array_unique($res);
	}

	public function get_location_code($goods_seq){
		$query = "sELECT location_code fROM fm_location_link wHERE goods_seq=? oRDER BY location_code";
		$query = $this->db->query($query, $goods_seq)->result_array();
		if($query){
			foreach($query as $val){
				$res[] = $val['location_code']; 
			}
		} else {
			$res = ["none"];
		}
		
		return array_unique($res);
	}

	public function get_goods_info($goods_seq, $options=array(), $gfields=array(), $gofields=array()){
		$bind = array($goods_seq);

		$fiedls	= "";
		if( count($gfields) > 0 ){
			$gfields = preg_filter('/^/', 'g.', $gfields);
			$fiedls	.= join(',', $gfields);
		}

		if( count($gofields) > 0 ){
			$gofields = preg_filter('/^/', 'go.', $gofields);
			if(!is_null($fiedls)){
				$fiedls	.= ", ";
			}
			$fiedls	.= join(',', $gofields);
		}

		if(is_null($fiedls)){
			$fiedls = "g.*, go.*";
		}

		$query = "sELECT " . $fiedls . " fROM 
						fm_goods g
						LEFT JOIN fm_goods_option go ON g.goods_seq = go.goods_seq
					wHERE 
						g.goods_seq=?";

		if( count($options) > 0 && $options[0] !== "none" && $options !== "none" ){
			foreach($options as $k => $v){
				$i = $k+1;
				$query .= " AND go.option{$i}=?";
				$bind[] = $v;
			}
		}

		$query = $this->db->query($query, $bind)->result_array();
		if($query[0]){
			return $query[0];
		} else {
			return false;;
		}
	}
}