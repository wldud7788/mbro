<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ssllib {
	protected $CI;
	public $sslRequestUrl					= 'https://www.firstmall.kr/myshop/index.php';	// 보안서버 신청 페이지 링크
	public $sslConfigName					= 'ssl_multi_domain';						// SSL 설정이 담긴 변수명
	public $sslRedicertName					= 'cert_redirect';						// SSL 리다이렉션 설정이 담긴 변수명
	// ssl 설정에서 사용할 각 필드 명칭, key : 솔루션의 명칭, value : 서비스환경저장으로 저장될 명칭
	public $sslConfigColumn = array(
		'domainList'			=> 'domains',							// 도메인 목록
		'certSeq'				=> 'cert_seq',							// 인증서 신청 고유키
		'certName'				=> 'cert_name',							// 인증서명
		'certPaid'				=> 'cert_paid',							// 유료 인증서 여부
		'certOut'				=> 'cert_out',							// 외부 인증서 여부
		'certStatus'			=> 'cert_status',						// 인증서 상태코드
		'certStatusText'		=> 'cert_status_text',					// 인증서 상태명
		'certPeriod'			=> 'cert_period',						// 인증서 유효기간
		'certPeriodSt'			=> 'cert_period_st',					// 인증서 유효기간-시작
		'certPeriodEd'			=> 'cert_period_ed',					// 인증서 유효기간-종료
		'certRedirect'			=> 'cert_redirect',						// 리다이렉션 여부
		'certRedirectText'		=> 'cert_redirect_text',				// 리다이렉션 여부명
	);
	public $codeSslConfigCertPaid			= array('N' => '무료', 'Y' => '유료');			// 유료 여부명 코드
	public $codeSslConfigCertOut			= array('N' => '내부', 'Y' => '외부');			// 외부 여부명 코드
	public $codeSslConfigCertRedirect		= array('N' => '미설정', 'Y' => '설정완료');		// 리다이렉션 여부명 코드
	
	public $codeSslConfigCertStatusReady	= array('00' => '준비중');				// 신인증후 상태 : 준비
	public $codeSslConfigCertStatusDone		= array('10' => '설치완료');				// 신인증후 상태 : 서비스 중
	public $codeSslConfigCertStatusCancel	= array('20' => '해지', '30' => '해지');	// 신인증후 상태 : 만기해지, 중도해지
	public $codeSslConfigCertStatus;
	public $valueSslConfigCertStatus;	// 코드값만 갖는 배열, 검색조건용 | 'ready', 'done', 'cancel', 'install'
	
	public $block = 20;	// 한 페이지당 출력 갯수
	public function __construct()
	{
		$this->CI = & get_instance();
		
		// 각 키와 텍스트 조합
		$this->codeSslConfigCertStatus = $this->codeSslConfigCertStatusReady + $this->codeSslConfigCertStatusDone + $this->codeSslConfigCertStatusCancel;
		$this->valueSslConfigCertStatus['ready'] = array_keys($this->codeSslConfigCertStatusReady);
		$this->valueSslConfigCertStatus['done'] = array_keys($this->codeSslConfigCertStatusDone);
		$this->valueSslConfigCertStatus['cancel'] = array_keys($this->codeSslConfigCertStatusCancel);
		$this->valueSslConfigCertStatus['install'] = array_merge($this->valueSslConfigCertStatus['ready'], $this->valueSslConfigCertStatus['done']);
		$this->valueSslConfigCertStatus['disable'] = array_merge($this->valueSslConfigCertStatus['ready'], $this->valueSslConfigCertStatus['cancel']);
	}
	
	// 기존에 선언되어 사용되던 ssl 관련 변수를 각 도메인의 인증서 값에 맞춰 재선언
	public function init_ssl_config(&$config_system){
		// 도메인에 매칭되는 인증서가 있는지 확인
		unset($params);
		$params[$this->sslConfigColumn['domainList']]	= $_SERVER['HTTP_HOST'];
		$params[$this->sslConfigColumn['certStatus']]	= $this->valueSslConfigCertStatus['done'];
		$params[$this->sslConfigColumn['certRedirect']]	= 'Y';
		$ssl_config = $this->getSslEnvironment($params, 'unlimited', $config_system);
		
		// 설정된 멀티 인증서 데이터가 있을 때만, 없을 경우 비활성화 처리 
		// config_system 오버라이드
		$this->setOriginSslEnvironment($ssl_config['data'][0], $config_system);
	}
	
	// config_system에 데이터 저장 - DB에는 저장하지 않음.
	protected function setOriginSslEnvironment($ssl_config, &$config_system){
		// 기본 값은 SSL 비활성화
		$ssl_use					 = '0';
		$ssl_pay					 = '0';
		$ssl_kind					 = '';
		$ssl_status					 = '0';
		$ssl_period_start			 = '';
		$ssl_period_expire			 = '';
		$ssl_port					 = '';
		$ssl_domain					 = '';
		$ssl_external				 = '0';
		$ssl_ex_domain				 = '';
		$ssl_ex_port				 = '';
		$ssl_page					 = '0';
		
		
		// 인증서 사용 상태일때
		// config에 저장되어 있는 인증서 만료값도 체크
		$certPeriodEd = $ssl_config[$this->sslConfigColumn['certPeriodEd']];
		$certPeriodEd = str_replace('.', '', $certPeriodEd);
		$certPeriodEd = str_replace('-', '', $certPeriodEd);
		if(
			!empty($ssl_config)													// 인증서 정보가 있을 때
			&& ($ssl_config[$this->sslConfigColumn['certRedirect']] == 'Y')		// 인증서 사용 상태
			&& (
				(
					!(empty($ssl_config[$this->sslConfigColumn['certPeriodEd']]))	// 만료일이 있을 때
					&& ( $certPeriodEd >= date('Ymd'))								// 만료일이 지나지 않았을 때
				) || (empty($ssl_config[$this->sslConfigColumn['certPeriodEd']]))	// 무료 SSL의 경우 만기일이 없음
			)
			){
			$ssl_use					 = '1';
			$ssl_pay					 = '1';
			$ssl_kind					 = $ssl_config[$this->sslConfigColumn['certName']];
			$ssl_status					 = '1';
			$ssl_period_start			 = $ssl_config[$this->sslConfigColumn['certPeriodSt']];
			$ssl_period_expire			 = $ssl_config[$this->sslConfigColumn['certPeriodEd']];
			$ssl_port					 = '443';		// 외부 포트 이용은 지원하지 않음.
			$ssl_domain					 = $_SERVER['HTTP_HOST'];	// 현재 도메인
			$ssl_external				 = '';		// 외부 사용은 지원하지 않음
			$ssl_ex_domain				 = '';		// 외부 사용은 지원하지 않음
			$ssl_ex_port				 = '';		// 외부 사용은 지원하지 않음
			$ssl_page					 = '1';
		}else{
			// 활성화된 인증서 정보가 없을 경우 
			// 기존 인증서 설정을 유지,
			// 단, 유료 인증서 사용 중일 땐 유료 인증서의 만료여부를 확인하여 활성화
			$oriCertPeriodEd = $config_system['ssl_period_expire'];
			$oriCertPeriodEd = str_replace('.', '', $oriCertPeriodEd);
			$oriCertPeriodEd = str_replace('-', '', $oriCertPeriodEd);
			
			if(
				( $config_system['ssl_use'] == '1' )			// 기존 인증서 : 인증서 사용
				&& ( $config_system['ssl_pay'] == '1' )			// 기존 인증서 : 유료 인증서
				&& (empty($oriCertPeriodEd))					// 기존 인증서 : 만료일이 없거나
				&& ( $oriCertPeriodEd <= date('Ymd') )			// 기존 인증서 : 만료일이 지났을 경우
			){
				$config_system['ssl_use'] = $ssl_use;			// '0' : 기본값
				$config_system['ssl_pay'] = $ssl_pay;			// '0' : 기본값
			}
			
			// 올드버전 인증서 사용 여부
			if(
				( $config_system['ssl_use'] == '1' )			// 기존 인증서 : 인증서 사용
				&& ( $config_system['ssl_pay'] == '1' )			// 기존 인증서 : 유료 인증서
				&& !(empty($oriCertPeriodEd))					// 기존 인증서 : 만료일이 있고
				&& ( $oriCertPeriodEd >= date('Ymd') )			// 기존 인증서 : 만료일이 남아있을 경우
			){
				$config_system['ssl_old'] = '1';
			}
			
			$ssl_use					 = $config_system['ssl_use'];
			$ssl_pay					 = $config_system['ssl_pay'];
			$ssl_kind					 = $config_system['ssl_kind'];
			$ssl_status					 = $config_system['ssl_status'];
			$ssl_period_start			 = $config_system['ssl_period_start'];
			$ssl_period_expire			 = $config_system['ssl_period_expire'];
			$ssl_port					 = $config_system['ssl_port'];
			$ssl_domain					 = $config_system['ssl_domain'];
			$ssl_external				 = $config_system['ssl_external'];
			$ssl_ex_domain				 = $config_system['ssl_ex_domain'];
			$ssl_ex_port				 = $config_system['ssl_ex_port'];
			$ssl_page					 = $config_system['ssl_page'];
		}
		
		$config_system['ssl_use']					= $ssl_use;
		$config_system['ssl_pay']					= $ssl_pay;
		$config_system['ssl_kind']					= $ssl_kind;
		$config_system['ssl_status']				= $ssl_status;
		$config_system['ssl_period_start']			= $ssl_period_start;
		$config_system['ssl_period_expire']			= $ssl_period_expire;
		$config_system['ssl_port']					= $ssl_port;
		$config_system['ssl_domain']				= $ssl_domain;
		$config_system['ssl_external']				= $ssl_external;
		$config_system['ssl_ex_domain']				= $ssl_ex_domain;
		$config_system['ssl_ex_port']				= $ssl_ex_port;
		$config_system['ssl_page']					= $ssl_page;
	}
	
	// config 에 저장된 데이터 확인
	public function getSslEnvironment($params=array(), $page='unlimited', $config_system=null){
		$result							= array();
		$result['data']					= array();
		$result['total_page']			= 0;
		$result['block_pages']			= 0;
		$result['using_redicert_seq']	= array();
		
		$all_ssl_config = array();
		if($config_system[$this->sslConfigName]){
			$all_ssl_config = $config_system[$this->sslConfigName];
		}elseif($this->CI->config_system[$this->sslConfigName]){
			$all_ssl_config = $this->CI->config_system[$this->sslConfigName];
		}
		$cert_redirect = config_load($this->sslRedicertName);
		// 인증후에서 데이터 수신시 초기 설계와 구조가 맞지 않을 수 있으므로 컨버팅 및 필터링 처리.
		
		// 데이터가 없을 경우 반환 처리
		if(empty($all_ssl_config)){
			return $result;
		}
		
		
		/*
		// ===========================================================
		// 환경변수에 저장된 데이터 임시 설정 시작
		// ===========================================================
		unset($all_ssl_config);
		$all_ssl_config = array();
		$all_ssl_config[] = array(
			$this->sslConfigColumn['domainList']		=> array(
																'm.hed.firstmall.kr',
																'hed.firstmall.kr',
																'www.hed.firstmall.kr',
															),
			$this->sslConfigColumn['certName']			=> 'Let\'s Encrypt',
			$this->sslConfigColumn['certSeq']			=> '1',
			$this->sslConfigColumn['certPaid']			=> 'n',
			$this->sslConfigColumn['certOut']			=> 'n',
			$this->sslConfigColumn['certStatus']		=> '10',
			$this->sslConfigColumn['certPeriodSt']		=> '2018.11.11',
			$this->sslConfigColumn['certPeriodEd']		=> '2018.11.11',
		);
		$all_ssl_config[] = array(
			$this->sslConfigColumn['domainList']		=> array(
																'm.hedpaid.co.kr',
																'hedpaid.co.kr',
																'www.hedpaid.co.kr',
															),
			$this->sslConfigColumn['certName']			=> '유료인증서',
			$this->sslConfigColumn['certSeq']			=> '2',
			$this->sslConfigColumn['certPaid']			=> 'y',
			$this->sslConfigColumn['certOut']			=> 'n',
			$this->sslConfigColumn['certStatus']		=> '00',
			$this->sslConfigColumn['certPeriodSt']		=> '2018.11.11',
			$this->sslConfigColumn['certPeriodEd']		=> '2018.11.11',
		);
		$all_ssl_config[] = array(
			$this->sslConfigColumn['domainList']		=> array(
																'm.hedpaid2.co.kr',
																'hedpaid2.co.kr',
																'www.hedpaid2.co.kr',
															),
			$this->sslConfigColumn['certName']			=> '유료인증서',
			$this->sslConfigColumn['certSeq']			=> '3',
			$this->sslConfigColumn['certPaid']			=> 'y',
			$this->sslConfigColumn['certOut']			=> 'n',
			$this->sslConfigColumn['certStatus']		=> '10',
			$this->sslConfigColumn['certPeriodSt']		=> '2018.11.11',
			$this->sslConfigColumn['certPeriodEd']		=> '2018.11.11',
		);
		$all_ssl_config[] = array(
			$this->sslConfigColumn['domainList']		=> array(
																'm.hedcancel.co.kr',
																'hedcancel.co.kr',
																'www.hedcancel.co.kr',
															),
			$this->sslConfigColumn['certName']			=> '해지인증서',
			$this->sslConfigColumn['certSeq']			=> '4',
			$this->sslConfigColumn['certPaid']			=> 'y',
			$this->sslConfigColumn['certOut']			=> 'n',
			$this->sslConfigColumn['certStatus']		=> '30',
			$this->sslConfigColumn['certPeriodSt']		=> '2018.11.11',
			$this->sslConfigColumn['certPeriodEd']		=> '2018.11.11',
		);
		$all_ssl_config[] = array(
			$this->sslConfigColumn['domainList']		=> array(
																'm.hedout.co.kr',
																'hedout.co.kr',
																'www.hedout.co.kr',
															),
			$this->sslConfigColumn['certName']			=> '외부인증서',
			$this->sslConfigColumn['certSeq']			=> '5',
			$this->sslConfigColumn['certPaid']			=> 'y',
			$this->sslConfigColumn['certOut']			=> 'y',
			$this->sslConfigColumn['certStatus']		=> '10',
			$this->sslConfigColumn['certPeriodSt']		=> '2018.11.11',
			$this->sslConfigColumn['certPeriodEd']		=> '2018.11.11',
		);
		// ===========================================================
		// 환경변수에 저장된 데이터 임시 설정 종료
		// ===========================================================
		*/
		
		// 컨버팅
		$tmp_all_ssl_config = array();
		$arrUsingRedicertSeq = array();
		foreach($all_ssl_config as $key=>$ssl_row){
			$ssl_row[$this->sslConfigColumn['certPaid']]			= strtoupper($ssl_row[$this->sslConfigColumn['certPaid']]);
			$ssl_row[$this->sslConfigColumn['certOut']]				= strtoupper($ssl_row[$this->sslConfigColumn['certOut']]);
			
			$ssl_row[$this->sslConfigColumn['certStatusText']] = $this->codeSslConfigCertStatus[$ssl_row[$this->sslConfigColumn['certStatus']]];
			$ssl_row[$this->sslConfigColumn['certPeriod']] = $ssl_row[$this->sslConfigColumn['certPeriodSt']].'~'.$ssl_row[$this->sslConfigColumn['certPeriodEd']];
			
			// 리다이렉션 설정 조합
			$ssl_row[$this->sslConfigColumn['certRedirect']] = 'N';	// 기본적으로 리다이렉션 설정 비활성화
			if(!empty($cert_redirect[$ssl_row[$this->sslConfigColumn['certSeq']]])){
				$arrUsingRedicertSeq[] = $ssl_row[$this->sslConfigColumn['certSeq']];
				$ssl_row[$this->sslConfigColumn['certRedirect']] = $cert_redirect[$ssl_row[$this->sslConfigColumn['certSeq']]];
			}
			$ssl_row[$this->sslConfigColumn['certRedirectText']] = $this->codeSslConfigCertRedirect[$ssl_row[$this->sslConfigColumn['certRedirect']]];
			$tmp_all_ssl_config[] = $ssl_row;
		}
		$all_ssl_config = $tmp_all_ssl_config;
		
		// 필터링
		$tmp_all_ssl_config = array();
		foreach($all_ssl_config as $key=>$ssl_row){
			// 조건에 어긋나는 경우에만 데이터 제거
			$pass_filter = false;
			$filter_count = 0;	// 필터 숫자와 매칭 숫자가 일치해야함
			$checked_count = 0;	// 매칭 횟수 숫자
			foreach($this->sslConfigColumn as $column){ 
				// 필터 조건의 형식을 배열로 통일
				unset($filters);
				unset($checked_target);
				$filters = array();
				if(!empty($params[$column])){
					if(is_array($params[$column])){
						foreach($params[$column] as $v){
							$filters[] = "".$v;
						}
					}else{
						$filters[] = "".$params[$column];
					}
					$filter_count++;
				}
				
				if(!empty($filters)){
					$checked_target = array();
					if(is_array($ssl_row[$column])){
						foreach($ssl_row[$column] as $v){
							$checked_target[] = "".$v;
						}
					}else{
						$checked_target[] = "".$ssl_row[$column];
					}
					
					if(!empty($checked_target)){
						foreach($checked_target as $target){
							if(in_array($target, $filters)){
								$checked_count++;
							}
						}
					}
				}
			}
			if($checked_count >= $filter_count){
				$pass_filter = true;
			}
			if($pass_filter){
				$tmp_all_ssl_config[] = $ssl_row;
			}
		}
		$all_ssl_config = $tmp_all_ssl_config;
		$total_count = count($all_ssl_config);
		$total_page = ceil($total_count / $this->block);
		
		// 페이징
		$tmp_all_ssl_config = array();
		$block_pages = array();
		if($page == 'unlimited'){
			$tmp_all_ssl_config = $all_ssl_config;
		}else{
			// 페이징 범위
			if($page=='') $page = 1;
			$page = (int) $page;
			$start_limit = $this->block * ($page-1);
			$end_limit = ($this->block * ($page-1)) + $this->block;
			foreach($all_ssl_config as $key=>$ssl_row){
				if($start_limit <= $key && $end_limit > $key){
					$tmp_all_ssl_config[] = $ssl_row;
				}
			}
			for($i=1;$i<=$total_page;$i++){
				$block_pages[] = $i;
			}
		}
		$all_ssl_config = $tmp_all_ssl_config;
		
		// 반환
		$result['data'] = $all_ssl_config;
		$result['total_page'] = $total_page;
		$result['block_pages'] = $block_pages;
		$result['using_redicert_seq'] = $arrUsingRedicertSeq;
		return $result;
	}
	
	/**
	 * 전체 리다이렉션 설정을 조회하여 현재 사용중이지 않은 리다이렉션 설정 제거 
	 */
	public function setSslEnvironment(){
		// 객체에 담겨있는 config정보가 아닌 신규 값을 기준으로 처리
		$CI =& get_instance();
		$CI->config_system = config_load('system');
		
		// 현재 사용중인 인증서의 도메인과 일치하는 멀티도메인 인증서 정보 수신시
		// 데이터 마이그레이션 및 기존 정보 폐기
		// 데이터 마이그레이션 기준
		//  - 도메인 일치
		//  - 기존 인증서 : ssl_use = 1, ssl_pay = 1, ssl_page = 1
		// 데이터 마이그레이션 결과
		//  - 기존 인증서 : ssl_use = 0, ssl_pay = 0, ssl_page = 0
		//  - 멀티 인증서 : cert_redirect = Y
		if(
			$CI->config_system['ssl_use'] == '1'
			&& $CI->config_system['ssl_pay'] == '1'
		){
			// 데이터 마이그레이션을 위한 멀티 인증서 조회
			$search_domain = '';
			if($CI->config_system['ssl_external'] == '1'){
				// 외부 인증서 사용 시 
				$search_domain = $CI->config_system['ssl_ex_domain'];
			}else{
				$search_domain = $CI->config_system['ssl_domain'];
			}
			
			if($search_domain){
				unset($params);
				$params = array();
				$params[$this->sslConfigColumn['domainList']]	= $search_domain;
				$same_domain_ssl_config = $this->getSslEnvironment($params, 'unlimited', $CI->config_system);

				if($same_domain_ssl_config['data'][0]){
					$certSeq = $same_domain_ssl_config['data'][0][$this->sslConfigColumn['certSeq']];
					if($certSeq){
						// 멀티 인증서 리다이렉션 활성화 마이그레이션
						if($CI->config_system['ssl_page'] == '1'){
							$this->activeSslRedirect($certSeq);
						}

						// 기존 인증서 정보 폐기
						config_save('system', array('ssl_use' => '0', 'ssl_pay' => '0', 'ssl_page' => '0'));
					}
				}
			}
		}
		
		// 전체 리다이렉션 중인 설정 조회
		unset($params);
		$params = array();
		$params[$this->sslConfigColumn['certRedirect']]	= 'Y';
		$enable_ssl_config = $this->getSslEnvironment($params);
		
		$delete_redirect = array();
		$cert_redirect = config_load($this->sslRedicertName);
		// 더 이상 존재하지 않은(비활성화)된 인증서의 경우 리다이렉션 설정 삭제
		foreach($cert_redirect as $setSeq=>$redirect){
			$notUsing = true;
			foreach($enable_ssl_config['using_redicert_seq'] as $key=>$usingSeq){
				if($setSeq==$usingSeq){
					$notUsing = false;
				}
			}
			if($notUsing){
				$delete_redirect[] = $setSeq;
			}
		}
		foreach($delete_redirect as $sKey=>$ssl_seq){
			config_save($this->sslRedicertName, array($ssl_seq => null));
		}
	}
	
	// 인증서 리다이렉션 비활성화 
	public function disableSslRedirect($ssl_seq){
		$this->changeSslRedirect($ssl_seq, 'N');
	}
	// 인증서 리다이렉션 활성화 
	public function activeSslRedirect($ssl_seq){
		$this->changeSslRedirect($ssl_seq, 'Y');
	}
	// 인증서 리다이렉션 변경 
	public function changeSslRedirect($ssl_seq, $redirect){
		config_save($this->sslRedicertName, array($ssl_seq => $redirect));
	}
}