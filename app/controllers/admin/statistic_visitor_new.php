<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class statistic_visitor_new extends admin_base {

	public function __construct() {
		parent::__construct();

		$this->admin_menu();
		$this->tempate_modules();

		/* 관리자 권한 체크 : 시작 */
		$auth = $this->authmodel->manager_limit_act('statistic_visitor');
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
		$result = $this->usedmodel->used_service_check('statistic_visitor_detail');
		if(!$result['type']){
			$this->template->assign('statistic_visitor_detail_limit','Y');
		}

		$this->load->library('elasticsearch');	
		if($this->db->es_use === false){
			pageRedirect('/admin/statistic_visitor/visitor_basic', "엘라스틱 서치 아이디, 비번, 사용여부를 다시 한 번 확인 해 주세요.");
			exit;
		} else {
			$ci =& get_instance();
			$this->cid = $ci->config_system['service']['cid'];
			$this->esClient = $this->elasticsearch->esClientR;
		}

		$this->seriesColors = array("#445ebc", "#d33c34","#4bb2c5", "#c5b47f", "#EAA228", "#579575", "#839557", "#958c12",
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc", "#c3b8f3", "#EA28A2", "#8566cc");
		$this->template->assign(array('seriesColors'=>$this->seriesColors));

		/* 방문자통계 메뉴 */
		$visitor_menu = $this->uri->rsegments[count($this->uri->rsegments)];
		if($visitor_menu=='visitor_hourly') $visitor_menu = 'visitor_hourly';
		$this->template->assign(array('selected_visitor_menu'=>$visitor_menu));

		$this->template->assign(array(
			'service_code' => $this->config_system['service']['code'],
			'sitetype'=>$_GET['sitetype'],
			'sitetypeloop'=>$this->sitetypeloop
		));
	}

	public function index(){
		redirect("/admin/statistic_visitor_new/visitor_basic");
	}

	/* 월/일/시간별 방문 통계 */
	public function visitor_basic(){

		if	(!$_GET['date_type'])	$_GET['date_type']	= 'month';
		//$file_path	= $this->template_path();
		$file_path	= "default/statistic_visitor/visitor_basic.html";

		switch($_GET['date_type']){
			case 'daily':
				$this->visitor_daily_es(); 
				$file_path	= str_replace('visitor_basic.html', 'visitor_daily.html', $file_path);
			break;
			case 'hour':
				$this->visitor_hourly_es();
				$file_path	= str_replace('visitor_basic.html', 'visitor_hourly.html', $file_path);
			break;
			case 'month':
			default:
				$this->visitor_monthly_es();
				$file_path	= str_replace('visitor_basic.html', 'visitor_monthly.html', $file_path);
			break;
		}

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/* 시간별 방문자 통계 */
	//elasticsearch kmj
	public function visitor_hourly_es(){
		/* 날짜 파라미터 */
		$_GET['year']	= !empty($_GET['year']) ? $_GET['year'] : date('Y');
		$_GET['month']	= !empty($_GET['month']) ? $_GET['month'] : date('m');
		$_GET['day']	= !empty($_GET['day']) ? $_GET['day'] : date('d');

		$thisDate	 = $_GET['year'].'-'.sprintf('%02d', $_GET['month']).'-'.sprintf('%02d', $_GET['day']);

		$dataForChart = array();
		$dataForTable = array();
		$maxValue = 0;

		$dataForTableSum['pv'] = 0;
		$dataForTableSum['visit'] = 0;

		for($i=0;$i<24;$i++){
			$dataForChart['방문자수'][$i][0] = sprintf('%02d', $i).'시';
			$dataForChart['방문자수'][$i][1] = 0;

			$dataForChart['페이지뷰'][$i][0] = sprintf('%02d', $i).'시';
			$dataForChart['페이지뷰'][$i][1] = 0;

			$dataForTable[$i] = array(
				'pv'			=> 0,
				'visit'			=> 0,
				'pvPerVisit'	=> 0
			);
		}

		//kmj

		$res = $this->elasticsearch->index_check($this->cid, 'stats_visitor');
		if($res){
			//daily Aggregation - visit
			$params = [
				'index' => $this->cid.'_stats_visitor',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								'match' => ['count_type' => 'visit']
							],
							'filter' => [
								'range' => [
									'post_date' => [
											'gte' => $thisDate.'T00:00:00',
											'lte' => $thisDate.'T23:59:59'
									]	
								]
							]
						]
					],
					'aggs' => [
						'visit_monthly' => [
							'date_histogram' => [
								'field'		=> 'post_date',
								'interval'	=> '60m'
							]
						]
					]
				]
			];

			$response = $this->esClient->search($params);
			$resVisitor = $response['aggregations']['visit_monthly']['buckets'];

			foreach($resVisitor as $v){
				$tmpArr = explode("T", $v['key_as_string']);
				$tmpArr = explode(":", $tmpArr[1]);
				$tmpKey = sprintf('%01d', $tmpArr[0]);

				$dataForChart['방문자수'][$tmpKey][1] = $v['doc_count'];
				$maxValue = $maxValue < $v['doc_count'] ? $v['doc_count'] : $maxValue;

				$dataForTable[$tmpKey]['visit'] = $v['doc_count'];
				$dataForTableSum['visit'] += $v['doc_count'];
			}
		
			//daily Aggregation - pv
			$params = [
				'index' => $this->cid.'_stats_visitor',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								'match' => ['count_type' => 'pv']
							],
							'filter' => [
								'range' => [
									'post_date' => [
											'gte' => $thisDate.'T00:00:00',
											'lte' => $thisDate.'T23:59:59'
									]	
								]
							]
						]
					],
					'aggs' => [
						'visit_monthly' => [
							'date_histogram' => [
								'field'		=> 'post_date',
								'interval'	=> '60m'
							]
						]
					]
				]
			];

			$response = $this->esClient->search($params);
			$resPV= $response['aggregations']['visit_monthly']['buckets'];
			foreach($resPV as $v){
				$tmpArr = explode("T", $v['key_as_string']);
				$tmpArr = explode(":", $tmpArr[1]);
				$tmpKey = sprintf('%01d', $tmpArr[0]);

				$dataForChart['페이지뷰'][$tmpKey][1] = $v['doc_count'];
				$maxValue = $maxValue < $v['doc_count'] ? $v['doc_count'] : $maxValue;

				$dataForTable[$tmpKey]['pv'] = $v['doc_count'];
				$dataForTableSum['pv'] += $v['doc_count'];
			}

			//daily Aggregation - visit
			$params = [
				'index' => $this->cid.'_stats_visitor',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								'match' => ['count_type' => 'visit']
							],
							'filter' => [
								'range' => [
									'post_date' => [
											'gte' => $thisDate.'T00:00:00',
											'lte' => $thisDate.'T23:59:59'
									]	
								]
							]
						]
					],
					'aggs' => [
						'referer' => [
							'terms' => [
								'field' => 'referer_sitecd.keyword'
							]
						]
					]
				]
			];

			$response = $this->esClient->search($params);
			$resReferer = $response['aggregations']['referer']['buckets'];
			foreach($resReferer as $k => $v){
				$refererData[$k]['referer_sitecd'] = $v['key'];
				$refererData[$k]['count'] = $v['doc_count'];
			}
		}

		$this->template->assign(array(
			'dataForChart'	=> $dataForChart,
			'maxValue'		=> $maxValue
		));
		$dataForTableSum['pvPerVisit'] = $dataForTableSum['visit'] ? round($dataForTableSum['pv']/$dataForTableSum['visit'],1) : 0;

		$this->template->assign(array(
			'dataForTable'	=> $dataForTable,
			'dataForTableSum' => $dataForTableSum,
		));
		$this->template->define(array('visitor_hourly_table'=>$this->skin."/statistic_visitor/_visitor_hourly_table.html"));
		$this->template->assign(array('refererData'	=> $refererData));
		$this->template->define(array('visitor_referer_table'=>$this->skin."/statistic_visitor/_visitor_referer_table.html"));
	}

	/* 일별 방문자 통계 */
	//elasticsearch kmj
	public function visitor_daily_es(){
		/* 날짜 파라미터 */
		$_GET['year'] = !empty($_GET['year']) ? $_GET['year'] : date('Y');
		$_GET['month'] = !empty($_GET['month']) ? $_GET['month'] : date('m');

		//kmj
		$startDate	= $_GET['year'].'-'.sprintf('%02d', $_GET['month']).'-01';
		$lastDay	=  date('t',strtotime($startDate));
		$lastDate	=  $_GET['year'].'-'.sprintf('%02d', $_GET['month']).'-'.$lastDay;
		$startDatePre = date('Y-m-d',strtotime("-1 days", strtotime($startDate)));

		$dataForChart = array();
		$dataForTable = array();
		$maxValue = 0;

		$dataForTableSum['pv'] = 0;
		$dataForTableSum['visit'] = 0;

		for($i=0;$i<$lastDay;$i++){
			$dataForChart['방문자수'][$i][0] = ($i+1).'일';
			$dataForChart['방문자수'][$i][1] = 0;

			$dataForChart['페이지뷰'][$i][0] = ($i+1).'일';
			$dataForChart['페이지뷰'][$i][1] = 0;

			$dataForTable[$i] = array(
				'pv'			=> 0,
				'pvGrowth'		=> 0,
				'visit'			=> 0,
				'visitGrowth'	=> 0,
				'pvPerVisit'	=> 0
			);
		}

		$res = $this->elasticsearch->index_check($this->cid, 'stats_visitor');
		if($res){
			//daily Aggregation - visit
			$params = [
				'index' => $this->cid.'_stats_visitor',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								'match' => ['count_type' => 'visit']
							],
							'filter' => [
								'range' => [
									'post_date' => [
											'gte' => $startDatePre.'T00:00:00',
											'lte' => $lastDate.'T23:59:59'
									]	
								]
							]
						]
					],
					'aggs' => [
						'visit_monthly' => [
							'date_histogram' => [
								'field'		=> 'post_date',
								'interval'	=> 'day'
							]
						]
					]
				]
			];

			$response = $this->esClient->search($params);
			$resVisitor = $response['aggregations']['visit_monthly']['buckets'];

			foreach($resVisitor as $v){
				$tmpArr = explode("-", $v['key_as_string']);
				$tmpKey = $tmpArr[2]-1;

				if($tmpArr[1] == $_GET['month']){
					$dataForChart['방문자수'][$tmpKey][1] = $v['doc_count'];
					$maxValue = $maxValue < $v['doc_count'] ? $v['doc_count'] : $maxValue;

					$dataForTable[$tmpKey]['visit'] = $v['doc_count'];

					if($dataForTable[$tmpKey-1]['visit'] > 0){
						$dataForTable[$tmpKey]['visitGrowth'] = ($v['doc_count'] - $dataForTable[$tmpKey-1]['visit']) / $dataForTable[$tmpKey-1]['visit'] * 100;
					} else {
						if($dataForTable[$tmpKey]['visit'] > 0){
							$dataForTable[$tmpKey]['visitGrowth'] = 100;
						}
					}

					$dataForTableSum['visit'] += $v['doc_count'];
				} else {
					$visitPre = $v['doc_count'];
				}
			}
			//방문자 전달 전일 데이터는 따로 계산
			if($visitPre > 0){
				$dataForTable[0]['visitGrowth'] = ($dataForTable[0]['visit'] - $visitPre) / $visitPre * 100;
			} else {
				if($dataForTable[0]['visit'] > 0){
					$dataForTable[0]['visitGrowth'] = 100;
				}
			}


			//daily Aggregation - pv
			$params = [
				'index' => $this->cid.'_stats_visitor',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								'match' => ['count_type' => 'pv']
							],
							'filter' => [
								'range' => [
									'post_date' => [
											'gte' => $startDate.'T00:00:00',
											'lte' => $lastDate.'T23:59:59'
									]	
								]
							]
						]
					],
					'aggs' => [
						'visit_monthly' => [
							'date_histogram' => [
								'field'		=> 'post_date',
								'interval'	=> 'day'
							]
						]
					]
				]
			];

			$response = $this->esClient->search($params);
			$resPV= $response['aggregations']['visit_monthly']['buckets'];
			foreach($resPV as $v){
				$tmpArr = explode("-", $v['key_as_string']);
				$tmpKey = $tmpArr[2]-1;

				if($tmpArr[1] == $_GET['month']){
					$dataForChart['페이지뷰'][$tmpKey][1] = $v['doc_count'];
					$maxValue = $maxValue < $v['doc_count'] ? $v['doc_count'] : $maxValue;

					$dataForTable[$tmpKey]['pv'] = $v['doc_count'];

					if($dataForTable[$tmpKey-1]['pv'] > 0){
						$dataForTable[$tmpKey]['pvGrowth'] = ($v['doc_count'] - $dataForTable[$tmpKey-1]['pv']) / $dataForTable[$tmpKey-1]['pv'] * 100;
					} else {
						if($dataForTable[$tmpKey]['pv'] > 0){
							$dataForTable[$tmpKey]['pvGrowth'] = 100;
						}
					}

					$dataForTableSum['pv'] += $v['doc_count'];
				} else {
					$pvPre = $v['doc_count'];
				}
			}
			//페이지뷰 전달 전일 데이터는 따로 계산
			if($pvPre > 0){
				$dataForTable[0]['pvGrowth'] = ($dataForTable[0]['pv'] - $pvPre) / $pvPre * 100;
			} else {
				if($dataForTable[0]['pv'] > 0){
					$dataForTable[0]['pvGrowth'] = 100;
				}
			}
		}

		$this->template->assign(array(
			'dataForChart'	=> $dataForChart,
			'maxValue'		=> $maxValue
		));

		/* 일별 데이터 달력용 */
		$c_start_idx = date('w',strtotime($startDate));
		$c_end_idx = date('t',strtotime($lastDate));
		$c_row = ceil(($c_start_idx+$c_end_idx)/7);

		$this->template->assign(array(
			'c_start_idx'	=> $c_start_idx,
			'c_end_idx'		=> $c_end_idx,
			'c_row'			=> $c_row,
		));
		$this->template->define(array('visitor_daily_calendar'=>$this->skin."/statistic_visitor/_visitor_daily_calendar.html"));


		$dataForTableSum['pvPerVisit'] = $dataForTableSum['visit'] ? round($dataForTableSum['pv']/$dataForTableSum['visit'],1) : 0;

		$this->template->assign(array(
			'dataForTable'	=> $dataForTable,
			'dataForTableSum' => $dataForTableSum,
		));
		$this->template->define(array('visitor_daily_table'=>$this->skin."/statistic_visitor/_visitor_daily_table.html"));
	}

	/* 월별 방문자 통계 */
	//elasticsearch kmj
	public function visitor_monthly_es(){
		// 날짜 파라미터 
		$_GET['year'] = !empty($_GET['year']) ? $_GET['year'] : date('Y');

		$startDate	= $_GET['year'].'-01-01';
		$lastDate	= $_GET['year'].'-12-31';
		$startDatePre = date('Y-m-d',strtotime("-1 month", strtotime($startDate)));
		
		$dataForChart = array();
		$dataForTable = array();
		$maxValue = 0;

		$dataForTableSum['pv'] = 0;
		$dataForTableSum['visit'] = 0;

		for($i=0;$i<12;$i++){
			$dataForChart['방문자수'][$i][0] = ($i+1).'월';
			$dataForChart['방문자수'][$i][1] = 0;

			$dataForChart['페이지뷰'][$i][0] = ($i+1).'월';
			$dataForChart['페이지뷰'][$i][1] = 0;

			$dataForTable[$i] = array(
				'pv'			=> 0,
				'pvGrowth'		=> 0,
				'visit'			=> 0,
				'visitGrowth'	=> 0,
				'pvPerVisit'	=> 0
			);
		}

		$res = $this->elasticsearch->index_check($this->cid, 'stats_visitor');
		if($res){
			//daily Aggregation - visit
			$params = [
				'index' => $this->cid.'_stats_visitor',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								'match' => ['count_type' => 'visit']
							],
							'filter' => [
								'range' => [
									'post_date' => [
											'gte' => $startDatePre.'T00:00:00',
											'lte' => $lastDate.'T23:59:59'
									]	
								]
							]
						]
					],
					'aggs' => [
						'visit_monthly' => [
							'date_histogram' => [
								'field'		=> 'post_date',
								'interval'	=> 'month'
							]
						]
					]
				]
			];

			$response = $this->esClient->search($params);
			$resVisitor = $response['aggregations']['visit_monthly']['buckets'];

			foreach($resVisitor as $v){
				$tmpArr = explode("-", $v['key_as_string']);
				$tmpKey = $tmpArr[1]-1;

				if($tmpArr[0] == $_GET['year']){
					$dataForChart['방문자수'][$tmpKey][1] = $v['doc_count'];
					$maxValue = $maxValue < $v['doc_count'] ? $v['doc_count'] : $maxValue;

					$dataForTable[$tmpKey]['visit'] = $v['doc_count'];

					if($dataForTable[$tmpKey-1]['visit'] > 0){
						$dataForTable[$tmpKey]['visitGrowth'] = ($v['doc_count'] - $dataForTable[$tmpKey-1]['visit']) / $dataForTable[$tmpKey-1]['visit'] * 100;
					} else {
						if($dataForTable[$tmpKey]['visit'] > 0){
							$dataForTable[$tmpKey]['visitGrowth'] = 100;
						}
					}
					$dataForTableSum['visit'] += $v['doc_count'];
				} else {
					$visitPre = $v['doc_count'];
				}
			}
			//방문자 전달 전일 데이터는 따로 계산
			if($visitPre > 0){
				$dataForTable[0]['visitGrowth'] = ($dataForTable[0]['visit'] - $visitPre) / $visitPre * 100;
			} else {
				if($dataForTable[0]['visit'] > 0){
					$dataForTable[0]['visitGrowth'] = 100;
				}
			}

			//daily Aggregation - pv
			$params = [
				'index' => $this->cid.'_stats_visitor',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								'match' => ['count_type' => 'pv']
							],
							'filter' => [
								'range' => [
									'post_date' => [
											'gte' => $startDatePre.'T00:00:00',
											'lte' => $lastDate.'T23:59:59'
									]	
								]
							]
						]
					],
					'aggs' => [
						'visit_monthly' => [
							'date_histogram' => [
								'field'		=> 'post_date',
								'interval'	=> 'month'
							]
						]
					]
				]
			];

			$response = $this->esClient->search($params);
			$resPV= $response['aggregations']['visit_monthly']['buckets'];
			foreach($resPV as $v){
				$tmpArr = explode("-", $v['key_as_string']);
				$tmpKey = $tmpArr[1]-1;

				if($tmpArr[0] == $_GET['year']){
					$dataForChart['페이지뷰'][$tmpKey][1] = $v['doc_count'];
					$maxValue = $maxValue < $v['doc_count'] ? $v['doc_count'] : $maxValue;

					$dataForTable[$tmpKey]['pv'] = $v['doc_count'];

					if($dataForTable[$tmpKey-1]['pv'] > 0){
						$dataForTable[$tmpKey]['pvGrowth'] = ($v['doc_count'] - $dataForTable[$tmpKey-1]['pv']) / $dataForTable[$tmpKey-1]['pv'] * 100;
					} else {
						if($dataForTable[$tmpKey]['pv'] > 0){
							$dataForTable[$tmpKey]['pvGrowth'] = 100;
						}
					}

					$dataForTableSum['pv'] += $v['doc_count'];
				} else {
					$pvPre = $v['doc_count'];
				}
			}
			//페이지뷰 전달 전일 데이터는 따로 계산
			if($pvPre > 0){
				$dataForTable[0]['pvGrowth'] = ($dataForTable[0]['pv'] - $pvPre) / $pvPre * 100;
			} else {
				if($dataForTable[0]['pv'] > 0){
					$dataForTable[0]['pvGrowth'] = 100;
				}
			}
		}

		$this->template->assign(array(
			'dataForChart'	=> $dataForChart,
			'maxValue'		=> $maxValue
		));

		$dataForTableSum['pvPerVisit'] = $dataForTableSum['visit'] ? round($dataForTableSum['pv']/$dataForTableSum['visit'],1) : 0;

		$this->template->assign(array(
			'dataForTable'	=> $dataForTable,
			'dataForTableSum' => $dataForTableSum,
		));

		$this->template->define(array('visitor_monthly_table'=>$this->skin."/statistic_visitor/_visitor_monthly_table.html"));
	}


	/* 방문자 유입경로 통계 설정 */
	public function visitor_referer(){
		$_GET['year']		= !empty($_GET['year'])			? $_GET['year']			: date('Y');
		$_GET['month']		= !empty($_GET['month'])		? $_GET['month']		: date('m');
		$_GET['date_type']	= !empty($_GET['date_type'])	? $_GET['date_type']	: 'month';

		if	($_GET['date_type'] == 'daily'){
			$startDate = $_GET['year']."-".sprintf("%02d", $_GET['month'])."-01";
			$lastDate = date("Y-m-t", strtotime($startDate));
			$interval = "day";
			$dateFormat = "dd";
			$maxChart = date("t", strtotime($startDate));
			$dateFormatKR = "일";
		}else{
			$startDate = $_GET['year']."-01-01";
			$lastDate = $_GET['year']."-12-31";
			$interval = "month";
			$dateFormat = "MM";
			$maxChart = 12;
			$dateFormatKR = "월";
		}

		for($i=1; $i<=$maxChart; $i++){
			$table_title[] = $i.$dateFormatKR;
		}

		//------es start
		//referer 코드 정보
		$sql = "sELECT referer_group_cd, referer_group_name fROM fm_referer_group;";
		$res = $this->db->query($sql)->result_array();

		$refererCode = array();
		foreach($res as $k => $v){
			$refererCode[$v['referer_group_cd']] = $v['referer_group_name'];
		}

		$res = $this->elasticsearch->index_check($this->cid, 'stats_visitor');
		if($res){
			$statlist = array();
			$dataForChart = array();
			$total_referer = array();
			$maxCnt = 0;

			//daily Aggregation - visit
			$paramsES = [
				'index' => $this->cid.'_stats_visitor',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								'match' => ['count_type' => 'pv']
							],
							'filter' => [
								'range' => [
									'post_date' => [
											'gte' => $startDate.'T00:00:00',
											'lte' => $lastDate.'T23:59:59'
									]	
								]
							]
						]
					],
					'aggs' => [
						'1' => [
							'date_histogram' => [
								'field'		=> 'post_date',
								'interval'	=> $interval,
								'format'	=> $dateFormat
							],
							'aggs' => [
								'2' => [
									'terms' => ['field' => 'referer_sitecd.keyword']
								]
							]
						]
					]
				]
			];

			$response = $this->esClient->search($paramsES);
			$aggs = $response['aggregations'][1]['buckets'];

			foreach($aggs as $v){
				foreach($v[2]['buckets'] as $vv){
					if($refererCode[$vv['key']]){
						$keyName = $refererCode[$vv['key']];
					} else {
						$keyName = "기타";
					}

					$keyNum = sprintf('%01d', $v['key_as_string']);

					$stat[$keyName][$keyNum ] = $vv['doc_count'];

					$statlist[$keyName]['list'][$keyNum ]['refer_name'] = $keyName;
					$statlist[$keyName]['list'][$keyNum ]['cnt'] = $vv['doc_count'];
					$statlist[$keyName]['total_cnt'] += $vv['doc_count'];

					$dataForChart[$keyName][($keyNum-1)][0] = $keyNum.$dateFormatKR;
					$dataForChart[$keyName][($keyNum-1)][1] = $vv['doc_count'];
				}
			}

			//빈 챠트 채우기 & 재배열 
			foreach($statlist as $k => $v){
				if(count($v['list']) < $maxChart){
					$tmpList = array();
					$tmpChart = array();
					for($i=1; $i<=$maxChart; $i++){
						if(empty($v['list'][$i])){
							$tmpList[$i]['refer_name'] = $k;
							$tmpList[$i]['cnt'] = 0;

							$tmpChart[$i-1][0] = $i.$dateFormatKR;
							$tmpChart[$i-1][1] = 0;
						} else {
							$tmpList[$i]['refer_name'] = $v['list'][$i]['refer_name'];
							$tmpList[$i]['cnt'] = $v['list'][$i]['cnt'];

							$tmpChart[$i-1][0] = $i.$dateFormatKR;
							$tmpChart[$i-1][1] = $v['list'][$i]['cnt'];
						}
					}
					
					$statlist[$k]['list'] = $tmpList;
					$dataForChart[$k] = $tmpChart;
					unset($tmpList, $tmpChart);
				}

				$total_referer[$k] = $v['total_cnt'];

				if($maxCnt < $v['total_cnt']){
					$maxCnt = $v['total_cnt'];
				}
			}
		}

		$this->template->assign(array('sc'=>$_GET));
		$this->template->assign(array('table_title'=>$table_title));
		$this->template->assign(array('dataForChart'=>$dataForChart));
		$this->template->assign(array('total_referer'=>$total_referer));
		$this->template->assign(array('statlist'=>$statlist));
		$this->template->assign(array('maxCnt'=>$maxCnt));

		//$file_path	= $this->template_path();
		$file_path	= "default/statistic_visitor/visitor_referer.html";

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}

	/* 방문자 유입경로 통계 설정 */
	public function visitor_platform(){

		$_GET['year']		= !empty($_GET['year'])			? $_GET['year']			: date('Y');

		//판매환경
		$sitetypeloop = sitetype('', 'image', 'array');

		if	($_GET['month']){
			$startDate = $_GET['year']."-".sprintf("%02d", $_GET['month'])."-01";
			$lastDate = date("Y-m-t", strtotime($startDate));
			$interval = "month";
			$dateFormat = "MM";
		}else{
			$startDate = $_GET['year']."-01-01";
			$lastDate = $_GET['year']."-12-31";
			$interval = "year";
			$dateFormat = "yyyy";
		}

		$res = $this->elasticsearch->index_check($this->cid, 'stats_visitor');
		if($res){
			$statlist = array();
			$dataForChart = array();
			$totalCnt = 0;

			//daily Aggregation - visit
			$paramsES = [
				'index' => $this->cid.'_stats_visitor',
				'body'	=> [
					'query' => [
						'bool' => [
							'must' => [
								'match' => ['count_type' => 'pv']
							],
							'filter' => [
								'range' => [
									'post_date' => [
											'gte' => $startDate.'T00:00:00',
											'lte' => $lastDate.'T23:59:59'
									]	
								]
							]
						]
					],
					'aggs' => [
						'1' => [
							'date_histogram' => [
								'field'		=> 'post_date',
								'interval'	=> $interval,
								'format'	=> $dateFormat
							],
							'aggs' => [
								'2' => [
									'terms' => ['field' => 'platform.keyword']
								]
							]
						]
					]
				]
			];

			$response = $this->esClient->search($paramsES);
			$aggs = $response['aggregations'][1]['buckets'];

			foreach($aggs as $v){
				foreach($v[2]['buckets'] as $kk => $vv){
					if($vv['key'] == "P"){
						$platformName = "PC";
					} else {
						$platformName = "타블렛/모바일";
					}

					$dataForChart[$kk][0] = $platformName;
					$dataForChart[$kk][1] = $vv['doc_count'];

					$totalCnt += $vv['doc_count'];
				}
			}

			foreach($dataForChart as $v){
				$statlist[$v[0]]['cnt'] = $v[1];
				$statlist[$v[0]]['percent'] = ($v[1]/$totalCnt) * 100;
			}
		}

		$this->template->assign(array('sc'=>$_GET));
		$this->template->assign(array('dataForChart'=>$dataForChart));
		$this->template->assign(array('statlist'=>$statlist));

		//$file_path	= $this->template_path();
		$file_path	= "default/statistic_visitor/visitor_platform.html";

		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");

	}

	/* 방문자 통계 설정 */
	public function visitor_setting(){
		$statisticExcludeIp = !empty($this->config_system['statisticExcludeIp']) ? $this->config_system['statisticExcludeIp'] : "";
		$statisticExcludeIp = $statisticExcludeIp ? explode("\n",$statisticExcludeIp) : array();
		$this->template->assign(array('statisticExcludeIp'=>$statisticExcludeIp));

		$file_path	= $this->template_path();
		$this->template->define(array('tpl'=>$file_path));
		$this->template->print_("tpl");
	}
}

/* End of file statistic_visitor_new.php */
/* Location: ./app/controllers/admin/statistic_visitor_new.php */