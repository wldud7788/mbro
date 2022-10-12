<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class statistic_goods_new extends admin_base {
	
	public function __construct() {
		parent::__construct();

		$this->admin_menu();
		$this->tempate_modules();
		$this->load->model('statsmodel');

		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('statistic_goods');
		if(!$auth){
			$callback = "history.go(-1);";
			$this->template->assign(array('auth_msg'=>$this->auth_msg,'callback'=>$callback));
			$this->template->define(array('denined'=>$this->skin.'/common/denined.html'));
			$this->template->print_("denined");
			exit;
		}
		/* 관리자 권한 체크 : 끝 */

		### SERVICE CHECK
		$this->load->model('usedmodel');
		$result = $this->usedmodel->used_service_check('statistic_goods_detail');
		if(!$result['type']){
			$this->template->assign('statistic_goods_detail_limit','Y');
		}

		$this->load->library('elasticsearch');	
		if($this->db->es_use === false){
			pageRedirect('/admin/statistic_goods/goods_cart', "엘라스틱 서치 아이디, 비번, 사용여부를 다시 한 번 확인 해 주세요.");
			exit;
		} else {
			$ci =& get_instance();
			$this->cid = $ci->config_system['service']['cid'];
			$this->esClient = $this->elasticsearch->esClientR;
		}

		$this->seriesColors = array("#445ebc", "#d33c34","#4bb2c5", "#c5b47f", "#EAA228", "#579575", "#839557", "#958c12",
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc", "#c3b8f3", "#EA28A2", "#8566cc");
		$this->template->assign(array('seriesColors'=>$this->seriesColors));

		/* 쇼핑몰분석통계 메뉴 */
		$goods_menu = $this->uri->rsegments[count($this->uri->rsegments)];
		$goods_menu = str_replace(array("_monthly","_daily"),"",$goods_menu);
		$this->template->assign(array('selected_goods_menu'=>$goods_menu));
		$this->template->assign(array('service_code' => $this->config_system['service']['code']));
	}

	public function index()
	{
		redirect("/admin/statistic_goods_new/goods_cart");		
	}

	public function goods_cart(){
		serviceLimit('H_FR','process');

		$cfg_order = config_load('order');
		$statlist	= array();

		if ($_SERVER["QUERY_STRING"] == null) {
			$_GET['year'] = date('Y');
			$_GET['month'] = date('m');

			$_GET['sdate'] = date('Y-m-01');
			$_GET['edate'] = date('Y-m-d');
		} else {
			$_GET['sdate'] = $_GET['year']."-".sprintf('%02d', $_GET['month'])."-01";
			$_GET['edate'] = date('Y-m-t', strtotime($_GET['sdate']));
		}

		$params['sdate']		= $_GET['sdate'];
		$params['edate']		= $_GET['edate'];
		$params['provider_seq']	= trim($_GET['provider_seq']);
		$params['keyword']		= trim($_GET['keyword']);
		$params['category1']	= trim($_GET['category1']);
		$params['category2']	= trim($_GET['category2']);
		$params['category3']	= trim($_GET['category3']);
		$params['category4']	= trim($_GET['category4']);
		$params['brands1']		= trim($_GET['brands1']);
		$params['brands2']		= trim($_GET['brands2']);
		$params['brands3']		= trim($_GET['brands3']);
		$params['brands4']		= trim($_GET['brands4']);
		$params['order_by']		= trim($_GET['order_by']);
		$params['perpage']		= $_GET['perpage'] ? $_GET['perpage'] : 100;

		$cid = $this->elasticsearch->index_check('stats_goods');
		if($cid !== false){
			$shouldNum = 0;
			$sholudList = array();

			$categoryList[0] = $params['category1'];
			$categoryList[1] = $params['category2'];
			$categoryList[2] = $params['category3'];
			$categoryList[3] = $params['category4'];
			$categoryList[4] = $params['brands1'];
			$categoryList[5] = $params['brands2'];
			$categoryList[6] = $params['brands3'];
			$categoryList[7] = $params['brands4'];
			$categoryList = array_filter($categoryList);

			if($categoryList){
				foreach($categoryList as $v){
					$sholudList[]['match']['category_code'] = $v;
					$shouldNum++;
				}
			}

			if($params['provider_seq']){
				$sholudList[]['match']['provider_seq'] = $params['provider_seq'];
				$shouldNum++;
			}

			if($params['keyword']){
				$sholudList[]['match']['goods_name'] = $params['keyword'];
				$shouldNum++;
			}

			if($params['sdate']){
				$filterList = array(
					'range' => array(
						'post_date' => array(
							'gte' => $params['sdate']."T00:00:00",
							'lte' => $params['edate']."T23:59:59"
						)	
					)	
				);
			} else {
				$filterList = array();
			}

			$paramsES = [
				'index' => $this->cid.'_stats_goods',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								//'match_all' => new \stdClass()
								'match' => ['count_type.keyword' => 'cart']
							],
							'should' => $sholudList,
							'minimum_should_match' => $shouldNum,
							'filter' => $filterList
						]
					],
					'aggs'=> [
						'good'=> [
							'terms'=> [
								'field'	=> 'goods_seq',
								'size'	=> $params['perpage']
							],
							'aggs'=> [
								'option'=> [
									'terms'=> [
										'field'=> 'options.keyword'
									],
									'aggs'=> [
										'user'=> [
											'cardinality'=> [
												'field'=> 'userid.keyword'
											]
										],
										'goods_name' => [
											'top_hits' => [
												'size'		=> 1,
												'_source'	=> [
													'include' => ['goods_name']
												]
											]	
										]
									]
								]
							]	
						]
					]
				]
			];

			$response = $this->esClient->search($paramsES);			
			$aggs = $response['aggregations']['good']['buckets'];

			$listAggsArr = array();
			foreach($aggs as $k => $v){
				$listAggsArr[$v['key']]['goods_seq']		= $v['key'];
				$listAggsArr[$v['key']]['goods_cnt']		= 0;
				$listAggsArr[$v['key']]['goods_user_cnt']	= 0;
				$listAggsArr[$v['key']]['tstock']			= 0;

				$listAggsArr[$v['key']]['options']			= array();
				$listAggsArr[$v['key']]['goods_cnt']		+= $v['doc_count'];

				//아이템별 갯수 합
				foreach($v['option']['buckets'] as $kk => $vv){
					$listAggsArr[$v['key']]['goods_name'] = $vv['goods_name']['hits']['hits'][0]['_source']['goods_name'];

					if($vv['key'] !== "none"){
						$listAggsArr[$v['key']]['options'][$kk]['option1'] = $vv['key'];
						$listAggsArr[$v['key']]['options'][$kk]['option_cnt'] = $vv['doc_count'];
						$listAggsArr[$v['key']]['options'][$kk]['option_user_cnt'] = $vv['user']['value'];

						$listAggsArr[$v['key']]['goods_user_cnt'] += $vv['user']['value'];
					}
				}
			}

			//담은 회원 순으로 정렬
			if($params['order_by'] == "users"){
				uasort($listAggsArr, function($a, $b) {
					return ($a['goods_user_cnt'] > $b['goods_user_cnt']) ? -1 : 1;
				});
			}

			unset($response, $hits, $aggs);
		}

		$this->load->model('providermodel');
		$provider = $this->providermodel->provider_goods_list();

		$this->template->assign(array('sc'=>$_GET));
		$this->template->assign(array('provider'=>$provider));
		$this->template->assign(array('cfg_order'=>$cfg_order));
		$this->template->assign(array('statlist'=>$listAggsArr));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function goods_wish(){
		serviceLimit('H_FR','process');

		$cfg_order = config_load('order');
		$statlist	= array();

		if ($_SERVER["QUERY_STRING"] == null) {
			$_GET['year'] = date('Y');
			$_GET['month'] = date('m');

			$_GET['sdate'] = date('Y-m-01');
			$_GET['edate'] = date('Y-m-d');
		} else {
			$_GET['sdate'] = $_GET['year']."-".sprintf('%02d', $_GET['month'])."-01";
			$_GET['edate'] = date('Y-m-t', strtotime($_GET['sdate']));
		}
		$params['sdate']		= ($_GET['sdate']);
		$params['edate']		= ($_GET['edate']);
		$params['provider_seq']	= trim($_GET['provider_seq']);
		$params['keyword']		= trim($_GET['keyword']);
		$params['category1']	= trim($_GET['category1']);
		$params['category2']	= trim($_GET['category2']);
		$params['category3']	= trim($_GET['category3']);
		$params['category4']	= trim($_GET['category4']);
		$params['brands1']		= trim($_GET['brands1']);
		$params['brands2']		= trim($_GET['brands2']);
		$params['brands3']		= trim($_GET['brands3']);
		$params['brands4']		= trim($_GET['brands4']);
		$params['order_by']		= trim($_GET['order_by']);
		$params['perpage']		= $_GET['perpage'] ? $_GET['perpage'] : 100;

		$cid = $this->elasticsearch->index_check('stats_goods');
		if($cid !== false){
			$shouldNum = 0;
			$sholudList = array();

			$categoryList[0] = $params['category1'];
			$categoryList[1] = $params['category2'];
			$categoryList[2] = $params['category3'];
			$categoryList[3] = $params['category4'];
			$categoryList = array_filter($categoryList);
			if($categoryList){
				foreach($categoryList as $v){
					$sholudList[]['match']['category_code'] = $v;
					$shouldNum++;
				}
			
			}

			$brandList[1] = $params['brands1'];
			$brandList[2] = $params['brands2'];
			$brandList[3] = $params['brands3'];
			$brandList[4] = $params['brands4'];
			$brandList = array_filter($brandList);
			if($brandList){
				foreach($brandList as $v){
					$sholudList[]['match']['brand_code'] = $v;
					$shouldNum++;
				}
			
			}

			if($params['provider_seq']){
				$sholudList[]['match']['provider_seq'] = $params['provider_seq'];
				$shouldNum++;
			}

			if($params['keyword']){
				$sholudList[]['match']['goods_name'] = $params['keyword'];
				$shouldNum++;
			}

			if($params['sdate']){
				$filterList = array(
					'range' => array(
						'post_date' => array(
							'gte' => $params['sdate']."T00:00:00",
							'lte' => $params['edate']."T23:59:59"
						)	
					)	
				);
			} else {
				$filterList = array();
			}
			
			//es process
			$paramsES = [
				'index' => $cid.'_stats_goods',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								//'match_all' => new \stdClass()
								'match' => ['count_type.keyword' => 'wish']
							],
							'should' => $sholudList,
							'minimum_should_match' => $shouldNum,
							'filter' => $filterList
						]
					],
					'aggs'=> [
						'good'=> [
							'terms'=> [
								'field'	=> 'goods_seq',
								'size'	=> $params['perpage']
							],
							'aggs'=> [
								'user'=> [
									'cardinality'=> [
										'field'=> 'userid.keyword'
									]
								],
								'goods_name' => [
									'top_hits' => [
										'size'		=> 1,
										'_source'	=> [
											'include' => ['goods_name']
										]
									]	
								]
							]
						]
					]
				]
			];
			
			$response = $this->esClient->search($paramsES);

			$hits = $response['hits']['hits'];
			$aggs = $response['aggregations']['good']['buckets'];

			$listAggsArr = array();
			foreach($aggs as $k => $v){
				$listAggsArr[$v['key']]['goods_seq']		= $v['key'];
				$listAggsArr[$v['key']]['goods_cnt']		= 0;
				$listAggsArr[$v['key']]['user_cnt']			= 0;

				$listAggsArr[$v['key']]['goods_cnt']		= $v['doc_count'];
				$listAggsArr[$v['key']]['stat_goods_name']	= $v['goods_name']['hits']['hits'][0]['_source']['goods_name'];
				$listAggsArr[$v['key']]['user_cnt']			= $v['user']['value'];
			}

			//담은 회원 순으로 정렬
			if($params['order_by'] == "users"){
				uasort($listAggsArr, function($a, $b) {
					return ($a['user_cnt'] > $b['user_cnt']) ? -1 : 1;
				});
			}

			unset($response, $hits, $aggs);
		}

		$this->load->model('providermodel');
		$provider = $this->providermodel->provider_goods_list();

		$this->template->assign(array('sc'=>$_GET));
		$this->template->assign(array('provider'=>$provider));
		$this->template->assign(array('cfg_order'=>$cfg_order));
		$this->template->assign(array('statlist'=>$listAggsArr));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function goods_search(){
		serviceLimit('H_FR','process');

		$cfg_order = config_load('order');

		if ($_SERVER["QUERY_STRING"] == null) {
			$_GET['year'] = date('Y');
			$_GET['month'] = date('m');

			$_GET['sdate'] = date('Y-m-01');
			$_GET['edate'] = date('Y-m-d');
		} else {
			$_GET['sdate'] = $_GET['year']."-".sprintf('%02d', $_GET['month'])."-01";
			$_GET['edate'] = date('Y-m-t', strtotime($_GET['sdate']));
		}
		$params['sdate']		= ($_GET['sdate']);
		$params['edate']		= ($_GET['edate']);
		$params['keyword']		= trim($_GET['keyword']);
		$params['perpage']		= $_GET['perpage'] ? $_GET['perpage'] : 100;

		$cid = $this->elasticsearch->index_check('stats_search');
		if($cid !== false){
			$esParam = array();
			if($params['sdate']){
				$esParam['filter']['range']['post_date']['gte'] = $params['sdate']."T00:00:00";
				$esParam['filter']['range']['post_date']['lte'] = $params['edate']."T23:59:59";
			}

			if($params['keyword']){
				$esParam['should'][]['match']['keyword'] = $params['keyword'];
				$esParam['minimum_should_match'] = 1;
			} else {
				$esParam['must']['match_all'] = new \stdClass();
			}
			
			//es process
			$paramsES = [
				'index' => $cid.'_stats_search',
				'body'	=> [
					'query' => [
						'bool' => $esParam
					],
					'aggs' => [
						'keyword' => [
							'terms' => [
								'field' => 'keyword_raw.keyword',
								'size' => $params['perpage']
							]
						]
					]
				]
			];

			$response = $this->esClient->search($paramsES);
			$aggs = $response['aggregations']['keyword']['buckets'];

			$statlist = array();
			foreach($aggs as $k => $v){
				$statlist[$k]['keyword'] = $v['key'];
				$statlist[$k]['keyword_cnt'] = $v['doc_count'];
			}
		}

		$this->template->assign(array('sc'=>$_GET));
		$this->template->assign(array('cfg_order'=>$cfg_order));
		$this->template->assign(array('statlist'=>$statlist));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function goods_search_view(){
		
		if(!$_GET['search_priod']) $_GET['search_priod'] = 30;

		$cid = $this->elasticsearch->index_check('stats_search');
		if($cid !== false){
			$params['sdate'] = date('Y-m-d', strtotime('-'.$_GET['search_priod'].' days'));
			$params['edate'] = date('Y-m-d');
			$params['perpage']		= $_GET['perpage'] ? $_GET['perpage'] : 100;

			//es process
			$paramsES = [
				'index' => $cid.'_stats_search',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								'term' => [
									'keyword_raw.keyword' => $_GET['keyword']
								]
							],
							'filter' => [
								'range' => [
									'post_date' => [
										'gte' => $params['sdate']."T00:00:00",
										'lte' => $params['edate']."T23:59:59"
									]	
								]	
							]
						]
					],
					'aggs' => [
						'regdate' => [
							'date_histogram' => [
								'field'		=> 'post_date',
								'interval'	=> '1d',
								'time_zone' => 'UTC',
								'order'		=> [ '_count' => 'asc' ]
							],
							'aggs' => [
								'none' => [ //비회원 검색
									'missing' => [
										'field' => 'userid.keyword'
									]
								],
								'sex' => [ //회원검색
									'terms' => [
										'field' => 'sex.keyword'
									],
									'aggs' => [
										'age' => [
											'range' => [
												'field' => 'age',
												'ranges' => [
													['from' => 0, 'to' => 1],
													['from' => 1, 'to' => 11],
													['from' => 11, 'to' => 21],
													['from' => 21, 'to' => 31],
													['from' => 31, 'to' => 41],
													['from' => 41, 'to' => 51],
													['from' => 51, 'to' => 61],
													['from' => 61, 'to' => 71],
													['from' => 71, 'to' => 81],
													['from' => 81, 'to' => 91],
													['from' => 91]
												]
											]
										]
									]
								]
							]
						]
					]
				]
			];

			$response = $this->esClient->search($paramsES);
			$aggs = $response['aggregations']['regdate']['buckets'];

			$dataForChartSex = array();
			$dataForChartDate = array();
			$dataForChartAge = array();

			foreach($aggs as $k => $v){
				$dataForChartDate[$k]['regist_date']	= substr($v['key_as_string'], 0, 10);
				$dataForChartDate[$k]['cnt']			= $v['doc_count'];

				//회원
				foreach($v['sex']['buckets'] as $kk => $vv){
					if($vv['key'] == "male"){
						$dataForChartSex[0][0] = '남성';
						$dataForChartSex[0][1] = $vv['doc_count'];
					} else if($vv['key'] == "female"){
						$dataForChartSex[1][0] = '여성';
						$dataForChartSex[1][1] = $vv['doc_count'];
					} else if($vv['key'] == "none"){
						$dataForChartSex[2][0] = '회원(정보없음)';
						$dataForChartSex[2][1] = $vv['doc_count'];
					}

					foreach($vv['age']['buckets'] as $kkk => $vvv){
						if($vvv['doc_count'] > 0){	
							if($kkk == 9){
								$dataForChartAge[$kkk][0] = "90대 이상";
							} else if($kkk == 0){
								$dataForChartAge[$kkk][0] = "회원(정보없음)";
							} else {
								$dataForChartAge[$kkk][0] = ($vvv['from']-1)."대";
							}
							$dataForChartAge[$kkk][1] = $vvv['doc_count'];
						}
					}
				}

				//비회원
				if($v['none']['doc_count'] > 0){
					$dataForChartSex[3][0] = "비회원";
					$dataForChartSex[3][1] = $v['none']['doc_count'];
						
					$dataForChartAge[11][0] = "비회원";
					$dataForChartAge[11][1] = $v['none']['doc_count'];
				}
			}
		} 

		$dataForChartAge	= array_values($dataForChartAge);
		$dataForChartSex	= array_values($dataForChartSex);
		$dataForChartDate	= array_values($dataForChartDate);
		unset($paramsES, $response, $aggs);

		$file_path	= $this->template_path();
		$this->template->assign(array('dataForChartAge'=>$dataForChartAge));
		$this->template->assign(array('dataForChartSex'=>$dataForChartSex));
		$this->template->assign(array('dataForChartDate'=>$dataForChartDate));
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function goods_review(){
		serviceLimit('H_FR','process');

		$cfg_order = config_load('order');
		$statlist	= array();

		if ($_SERVER["QUERY_STRING"] == null) {
			$_GET['year'] = date('Y');
			$_GET['month'] = date('m');

			$_GET['sdate'] = date('Y-m-01');
			$_GET['edate'] = date('Y-m-d');
		} else {
			$_GET['sdate'] = $_GET['year']."-".sprintf('%02d', $_GET['month'])."-01";
			$_GET['edate'] = date('Y-m-t', strtotime($_GET['sdate']));
		}
		$params['sdate']		= ($_GET['sdate']);
		$params['edate']		= ($_GET['edate']);
		$params['provider_seq']	= trim($_GET['provider_seq']);
		$params['keyword']		= trim($_GET['keyword']);
		$params['category1']	= trim($_GET['category1']);
		$params['category2']	= trim($_GET['category2']);
		$params['category3']	= trim($_GET['category3']);
		$params['category4']	= trim($_GET['category4']);
		$params['brands1']		= trim($_GET['brands1']);
		$params['brands2']		= trim($_GET['brands2']);
		$params['brands3']		= trim($_GET['brands3']);
		$params['brands4']		= trim($_GET['brands4']);
		$params['order_by']		= trim($_GET['order_by']);
		$params['perpage']		= $_GET['perpage'] ? $_GET['perpage'] : 100;

		$cid = $this->elasticsearch->index_check('stats_review');
		if($cid !== false){
			$shouldNum = 0;
			$sholudList = array();

			$categoryList[0] = $params['category1'];
			$categoryList[1] = $params['category2'];
			$categoryList[2] = $params['category3'];
			$categoryList[3] = $params['category4'];
			$categoryList = array_filter($categoryList);
			if($categoryList){
				foreach($categoryList as $v){
					$sholudList[]['match']['category_code'] = $v;
					$shouldNum++;
				}
			}

			$brandList[1] = $params['brands1'];
			$brandList[2] = $params['brands2'];
			$brandList[3] = $params['brands3'];
			$brandList[4] = $params['brands4'];
			$brandList = array_filter($brandList);
			if($brandList){
				foreach($brandList as $v){
					$sholudList[]['match']['brand_code'] = $v;
					$shouldNum++;
				}
			}

			if($params['provider_seq']){
				$sholudList[]['match']['provider_seq'] = $params['provider_seq'];
				$shouldNum++;
			}

			if($params['keyword']){
				$sholudList[]['match']['goods_name'] = $params['keyword'];
				$shouldNum++;
			}

			if($params['sdate']){
				$filterList = array(
					'range' => array(
						'post_date' => array(
							'gte' => $params['sdate']."T00:00:00",
							'lte' => $params['edate']."T23:59:59"
						)	
					)	
				);
			} else {
				$filterList = array();
			}
			
			//es process
			$paramsES = [
				'index' => $cid.'_stats_goods',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								//'match_all' => new \stdClass()
								'match' => ['count_type.keyword' => 'review']
							],
							'should' => $sholudList,
							'minimum_should_match' => $shouldNum,
							'filter' => $filterList
						]
					],
				'aggs' => [
					'good' => [
						'terms' => [
							'field' => 'goods_seq',
							'size' => $params['perpage']
							],
							'aggs' => [
								'goods_name' => [
									'top_hits' => [
										'size' => 1,
										'_source' => [
											'include' => ['goods_name']
										]
									]	
								]
							]
						]
					]
				]
			];
			$response = $this->esClient->search($paramsES);

			$hits = $response['hits']['hits'];
			$aggs = $response['aggregations']['good']['buckets'];
	
			$listAggsArr = array();
			foreach($aggs as $k => $v){
				$listAggsArr[$v['key']]['goods_seq']		= $v['key'];
				$listAggsArr[$v['key']]['stat_goods_name']	= $v['goods_name']['hits']['hits'][0]['_source']['goods_name'];
				$listAggsArr[$v['key']]['review_cnt']		= $v['doc_count'];
			}
		}

		$this->load->model('providermodel');
		$provider = $this->providermodel->provider_goods_list();

		$this->template->assign(array('sc'=>$_GET));
		$this->template->assign(array('provider'=>$provider));
		$this->template->assign(array('cfg_order'=>$cfg_order));
		$this->template->assign(array('statlist'=>$listAggsArr));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	public function goods_restock(){
		serviceLimit('H_FR','process');

		$cfg_order = config_load('order');
		$statlist	= array();

		if ($_SERVER["QUERY_STRING"] == null) {
			$_GET['year'] = date('Y');
			$_GET['month'] = date('m');

			$_GET['sdate'] = date('Y-m-01');
			$_GET['edate'] = date('Y-m-d');
		} else {
			$_GET['sdate'] = $_GET['year']."-".sprintf('%02d', $_GET['month'])."-01";
			$_GET['edate'] = date('Y-m-t', strtotime($_GET['sdate']));
		}
		$params['sdate']		= ($_GET['sdate']);
		$params['edate']		= ($_GET['edate']);
		$params['provider_seq']	= trim($_GET['provider_seq']);
		$params['keyword']		= trim($_GET['keyword']);
		$params['category1']	= trim($_GET['category1']);
		$params['category2']	= trim($_GET['category2']);
		$params['category3']	= trim($_GET['category3']);
		$params['category4']	= trim($_GET['category4']);
		$params['brands1']		= trim($_GET['brands1']);
		$params['brands2']		= trim($_GET['brands2']);
		$params['brands3']		= trim($_GET['brands3']);
		$params['brands4']		= trim($_GET['brands4']);
		$params['order_by']		= trim($_GET['order_by']);
		$params['perpage']		= $_GET['perpage'] ? $_GET['perpage'] : 100;
		
		
		$cid = $this->elasticsearch->index_check('stats_restock');
		if($cid !== false){
			$shouldNum = 0;
			$sholudList = array();

			$categoryList[0] = $params['category1'];
			$categoryList[1] = $params['category2'];
			$categoryList[2] = $params['category3'];
			$categoryList[3] = $params['category4'];
			$categoryList = array_filter($categoryList);
			if($categoryList){
				foreach($categoryList as $v){
					$sholudList[]['match']['category_code'] = $v;
					$shouldNum++;
				}
			}

			$brandList[1] = $params['brands1'];
			$brandList[2] = $params['brands2'];
			$brandList[3] = $params['brands3'];
			$brandList[4] = $params['brands4'];
			$brandList = array_filter($brandList);
			if($brandList){
				foreach($brandList as $v){
					$sholudList[]['match']['brand_code'] = $v;
					$shouldNum++;
				}
			}

			if($params['provider_seq']){
				$sholudList[]['match']['provider_seq'] = $params['provider_seq'];
				$shouldNum++;
			}

			if($params['keyword']){
				$sholudList[]['match']['goods_name'] = $params['keyword'];
				$shouldNum++;
			}

			if($params['sdate']){
				$filterList = array(
					'range' => array(
						'post_date' => array(
							'gte' => $params['sdate']."T00:00:00",
							'lte' => $params['edate']."T23:59:59"
						)	
					)	
				);
			} else {
				$filterList = array();
			}
			
			//es process
			$paramsES = [
				'index' => $cid.'_stats_goods',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								//'match_all' => new \stdClass()
								'match' => ['count_type.keyword' => 'restock']
							],
							'should' => $sholudList,
							'minimum_should_match' => $shouldNum,
							'filter' => $filterList
						]
					],
					'aggs' => [
						'good' => [
							'terms' => [
								'field' => 'goods_seq',
								'size' => $params['perpage']
							],
							'aggs' => [
								'goods_name' => [
									'top_hits' => [
										'size' => 1,
										'_source' => [
											'include' => ['goods_name']
										]
									]	
								]
							]
						]
					]
				]
			];
			
			$response = $this->esClient->search($paramsES);

			$hits = $response['hits']['hits'];
			$aggs = $response['aggregations']['good']['buckets'];

			$listAggsArr = array();
			foreach($aggs as $k => $v){
				$listAggsArr[$v['key']]['goods_seq']		= $v['key'];
				$listAggsArr[$v['key']]['stat_goods_name']	= $v['goods_name']['hits']['hits'][0]['_source']['goods_name'];
				$listAggsArr[$v['key']]['restock_cnt']		= $v['doc_count'];
			}
		}

		$this->load->model('providermodel');
		$provider			= $this->providermodel->provider_goods_list();
		$this->template->assign(array('sc'=>$_GET));
		$this->template->assign(array('provider'=>$provider));
		$this->template->assign(array('cfg_order'=>$cfg_order));
		$this->template->assign(array('statlist'=>$listAggsArr));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	// 상품 집계 오늘날짜 갱신
	public function renewal_goods($stats_date){
		// 장바구니 집계 갱신
		$this->statsmodel->delete_accumul_cart_stats($stats_date);
		$this->statsmodel->set_accumul_cart_stats($stats_date);
	}
}

/* End of file statistic_goods_new.php */
/* Location: ./app/controllers/admin/statistic_goods_new.php */