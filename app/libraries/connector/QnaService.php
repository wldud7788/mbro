<?php

Class QnaService  extends ServiceBase
{

	protected $_ServiceName		= 'qna';
	public $orderStatus;
	
	public function __construct($params = array())
	{
		parent::__construct($params);
		$this->_CI->load->model('connectormodel');
		$this->orderStatus	= $this->getStatusCode('order');
		
		/*2017-12-06 샵링커 마켓 설정 추가*/
		$find			= $this->_CI->db->query("SELECT * FROM fm_market_account WHERE market LIKE 'API%' and delete_yn = 'N' and account_use = 'Y' group by market");
		$findRow		= $find->result();
		
		$this->_CI->load->model('connectormodel');
		$connectorModel		=& $this->_CI->connectormodel;
		foreach ($findRow as $val){
			$getParam['searchMarket'] = $val->market;
			$rtn = $connectorModel->getLinkageMarket($getParam);
			$this->_supportMarkets[$val->market]['name'] = $rtn[0]['marketName'];
			$this->_supportMarkets[$val->market]['productLink'] = '';
		}
		
		/*2017-12-06 샵링커 마켓 설정 추가*/
		
		// 주문 로그 생성을 위한 마켓 정보 얻기
		$_connectorBase	= $this->_CI->connector::getInstance();
		$this->_supportMarketNames	= $_connectorBase->getAllMarkets();
	}

	public function getServiceName(){ return $this->_ServiceName; }

	/* 마켓 Qna 등록 */
	public function marketQnaInsert($market, $sellerId, $qnaList)
	{
		$connectorModel		=& $this->_CI->connectormodel;
		$this->setMarketInfo($market, $sellerId);

		$qnaCompleteList	= array();
		$totalQna			= 0;
		$skipQna			= 0;
		$requestQna			= 0;

		foreach((array)$qnaList as $qnaRow) {

			$nowMarketQnaSeq		= 0;
			$totalQna++;

			$searchQna						= array();
			$searchQna['market']			= $market;
			$searchQna['marketQnaSeq']		= $qnaRow['marketQnaSeq'];
			$searchQna['withTotalCount']	= true;
			$checkList						= $connectorModel->getMarketQnaList($searchQna,'forInsertMode');

			if ($checkList['totalCount'] > 0) {
				$skipQna++;
				continue;
			}

			$qnaParams							= array();
			$qnaParams['market']				= $market;
			$qnaParams['seller_id']				= $sellerId;
			$qnaParams['market_qna_seq']		= $qnaRow['marketQnaSeq'];
			$qnaParams['market_qna_title']		= $qnaRow['qnaTitle'] ? $qnaRow['qnaTitle'] : '-';
			$qnaParams['market_conent']			= $qnaRow['qnaContent'];
			$qnaParams['market_qna_date']		= $qnaRow['qnaRegistDate'];
			$qnaParams['market_member_id']		= $qnaRow['qnaMemberId'];
			$qnaParams['market_name']			= $qnaRow['qnaMemberName'];
			$qnaParams['market_product_name']	= $qnaRow['qnaProductName'];
			$qnaParams['market_product_code']	= $qnaRow['qnaProductCode'];
			$qnaParams['market_order_no']		= $qnaRow['marketOrderNo'];
			$qnaParams['market_cs_yn']			= $qnaRow['qnaCSyn'];
			$qnaParams['last_result']			= "Y";
			$qnaParams['fm_save_date']			= date("Y-m-d H:i:s");
			$qnaParams['fm_delete_yn']			= "N";

			

			$result				= $this->_CI->db->insert('fm_market_qna', $qnaParams);
			$nowMarketQnaSeq	= $this->_CI->db->insert_id();

			//로그저장
			$logMessage		= "문의 수집 성공";
			$this->makeMarketQnaLog($nowMarketQnaSeq, $logMessage);

			$qnaCompleteList[]	= $nowMarketQnaSeq;
		}

		$requestQna		= count($qnaCompleteList);
		

		$return['success']	= 'Y';
		$return['message']	= '총 수집 문의'.number_format($totalQna).' 개 / ';
		$return['message']	.= '이전 수집된 문의 '.number_format($skipQna).' 개 / ';
		$return['message']	.= '수집 완료된 문의 '.number_format($requestQna).' 개';


		return $return;

	}

	/* qna 답변 후 처리 */
	function qnaAnswerComplete( $qnaInfo, $answerInfo, $success='yes' ) {

		$answerParams						= array();
		if ( $success  == 'yes' ) {
			$answerParams['market_answer_seq']	= $answerInfo['marketAnswerSeq'];
			$answerParams['answered_date']		= date('Y-m-d H:i:s');
			$answerParams['fm_answer_yn']		= 'Y';		// 한번이라도 답변을 등록하면 답변완료
			$answerParams['last_result']		= 'Y';
		} else if ( $success == 'no' ){
			$answerParams['last_result']		= 'N';
		}
		$answerParams['market_answer']			= $qnaInfo['marketAnswer'];
		$answerParams['last_distributed_time']	= date('Y-m-d H:i:s');
		$this->_CI->db->update('fm_market_qna', $answerParams, array('seq' => $qnaInfo['seq']));

	}

	/* 마켓 문의 로그 기록 */
	public function makeMarketQnaLog($fm_market_qna_seq, $log)
	{
		//로그저장
		$logParams['fm_market_qna_seq']		= $fm_market_qna_seq;
		$logParams['log_text']					= $log;
		$logParams['registered_time']			= date('Y-m-d H:i:s');
		$this->_CI->db->insert(' fm_market_qna_log', $logParams);
	}

}