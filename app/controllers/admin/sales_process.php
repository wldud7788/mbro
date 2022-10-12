<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/base/admin_base".EXT);

class sales_process extends admin_base {

	public function __construct() {
		parent::__construct();
		//세금계산서/현금영수증
		$this->load->library('validation');
		$this->load->model('salesmodel');
		$this->load->library('cashtax');
	}

	/* 현금영수증신청 */
	public function cashreceipt_regist(){
		//$this->validation->set_rules('order_date', '거래일시', 'trim|required|numeric|xss_clean');
		$this->validation->set_rules('order_seq', '주문번호 ','trim|required|xss_clean');
		if	($_POST['cuse'] == '1'){
			$this->validation->set_rules('creceipt_number[1]', '사업자번호 ','trim|required|numeric|max_length[10]|xss_clean');
		}else{
			$this->validation->set_rules('creceipt_number[0]', '주민(휴대폰)번호', 'trim|required|numeric|max_length[13]|xss_clean');
		}
		$this->validation->set_rules('name', '주문자명 ','trim|required|xss_clean');
		$this->validation->set_rules('email', '이메일 ','trim|required|valid_email|xss_clean');
		$this->validation->set_rules('phone', '전화번호 ','trim|required|numeric|xss_clean');
		$this->validation->set_rules('goodsname', '상품명 ','trim|required|xss_clean');
		$this->validation->set_rules('amount', '발행액 ','trim|required|numeric|xss_clean');
		$this->validation->set_rules('supply', '공급액 ','trim|required|numeric|xss_clean');
		$this->validation->set_rules('surtax', '부가세 ','trim|required|numeric|xss_clean');
		if($this->validation->exec() === false){
			$err = $this->validation->error_array;
			$callback = "if(parent.document.cashreceiptform[\"{$err['key']}\"])
			parent.document.cashreceiptform[\"{$err['key']}\"].focus();";
			$callback .= "else if (parent.document.getElementsByName('{$err['key']}'))
			parent.document.getElementsByName('{$err['key']}').focus();";
			openDialogAlert($err['value'],400,140,'parent',$callback);
			exit;
		}

		$creceipt_number					= str_replace("-", "", $_POST['creceipt_number'][$_POST['cuse']]);
		$cashparams['typereceipt'		]	= 2;
		if	($_POST['mode'] == 'mod' && $_POST['seq']){
			$cashparams['seq']	= $_POST['seq'];
		}else{
			$cashparams['type'				]	= 1;//관리자수동
			if($_POST['order_seq'])
					$cashparams['order_seq']	= $_POST['order_seq'];
			else	$cashparams['order_seq']	= date('YmdHis').$result_id;
		}
		$cashparams['vat_type'			]	= $_POST['vat_type'];
		$cashparams['price'				]	= $_POST['amount'];
		$cashparams['supply'			]	= $_POST['supply'];
		$cashparams['surtax'			]	= $_POST['surtax'];
		$cashparams['person'			]	= $_POST['name'];
		$cashparams['email'				]	= $_POST['email'];
		$cashparams['phone'				]	= $_POST['phone'];
		$cashparams['cuse'				]	= $_POST['cuse'];
		$cashparams['goodsname'			]	= $_POST['goodsname'];
		$cashparams['order_date'		]	= date('Y-m-d H:i:s', strtotime($_POST['order_date']));
		$cashparams['creceipt_number'	]	= $creceipt_number;

		if	($_POST['mode'] == 'mod' && $_POST['seq']){
			$cashparams['up_date'	]		= date('Y-m-d H:i:s');
			$result	= $this->salesmodel->sales_modify($cashparams);
			if($result){
				$callback = "parent.document.location.reload();";
				openDialogAlert("현금영수증이 수정되었습니다.",400,140,'parent',$callback);
			}else{
				$callback = "parent.document.location.reload();";
				openDialogAlert("현금영수증 수정오류",400,140,'parent',$callback);
			}
		}else{
			$cashparams['regdate'			]	= date('Y-m-d H:i:s');
			$result	= $this->salesmodel->sales_write($cashparams);
			if($result){
				$this->order_for_sales($_POST['order_seq'],'2');
				$callback = "parent.document.location.reload();";
				openDialogAlert("관리자에 의해 현금영수증이 신청되었습니다.",400,140,'parent',$callback);
			}else{
				$callback = "parent.document.location.reload();";
				openDialogAlert("발급오류",400,140,'parent',$callback);
			}
		}
	}

	/* 세금계산서신청 */
	public function tax_regist()
	{

		try {
			$this->load->model('ordermodel');
	
			$aPostParam = $this->input->post();
			$orderInfo 	= $this->ordermodel->get_order($aPostParam['order_seq']);
	
			$this->validation->set_rules('order_seq', '주문번호 ','trim|required|xss_clean');
			$this->validation->set_rules('co_name', '상호명 ','trim|required|xss_clean');
			$this->validation->set_rules('busi_no', '사업자번호 ','trim|required|max_length[12]|regex_match[/[0-9]{3}\-[0-9]{2}-[0-9]{5}/]|xss_clean');
			$this->validation->set_rules('co_ceo', '대표자명 ','trim|required|xss_clean');
			$this->validation->set_rules('co_status', '업태 ','trim|required|xss_clean');
			$this->validation->set_rules('co_type', '업종','trim|required|xss_clean');
			$this->validation->set_rules('Zipcode[]', '주소','trim|xss_clean');
			$this->validation->set_rules('Address', '주소','trim|xss_clean');
			$this->validation->set_rules('person', '담당자이름','trim|xss_clean');
			$this->validation->set_rules('email', '담당자이메일','trim|valid_email|xss_clean');
			$this->validation->set_rules('phone', '전화번호','trim|xss_clean');
			$this->validation->set_rules('amount', '발행액','trim|numeric|xss_clean');
			//$this->validation->set_rules('supply', '공급액','trim|required|numeric|xss_clean');
			//$this->validation->set_rules('surtax', '부가세','trim|required|numeric|xss_clean');
	
			if($this->validation->exec()===false){
				throw new Exception($this->validation->error_array['value']);
			}
			
			if	($aPostParam['mode'] == 'mod' && $aPostParam['seq']){
				$cashparams['seq']	= $aPostParam['seq'];
			}else{
				$cashparams['typereceipt'	]		= 1;
				$cashparams['type'			]		= 1;//관리자수동
				$cashparams['tstep'			]		= 1;//신청
			}
			$cashparams['vat_type'		]		= $aPostParam['vat_type'];
			$cashparams['order_seq'		]		= $aPostParam['order_seq'];
			$cashparams['co_name'		]		= $aPostParam['co_name'];
			$cashparams['busi_no'		]		= $aPostParam['busi_no'];
			$cashparams['co_ceo'		]		= $aPostParam['co_ceo'];
			$cashparams['co_status'		]		= $aPostParam['co_status'];
			$cashparams['co_type'		]		= $aPostParam['co_type'];
			$cashparams['zipcode'		]		= implode("-",$aPostParam['Zipcode']);
			$cashparams['address_type'	]		= $aPostParam['Address_type'];
			$cashparams['address'		]		= $aPostParam['Address'];
			$cashparams['address_street']		= $aPostParam['Address_street'];
			$cashparams['address_detail']		= $aPostParam['Address_detail'];
			$cashparams['person'		]		= $aPostParam['person'];
			$cashparams['email'			]		= $aPostParam['email'];
			$cashparams['phone'			]		= $aPostParam['phone'];
			$cashparams['price'			]		= $aPostParam['amount'];
			$cashparams['supply'		]		= $aPostParam['supply'];
			$cashparams['surtax'		]		= $aPostParam['surtax'];
			$cashparams['order_name'	]		= $orderInfo['order_user_name'];

			if	($aPostParam['mode'] == 'mod' && $aPostParam['seq']){
				$cashparams['up_date'	]		= date('Y-m-d H:i:s');
				$result	= $this->salesmodel->sales_modify($cashparams);
				if($result){
					$callback = "parent.document.location.reload();";
					openDialogAlert("세금계산서가 수정되었습니다.",400,140,'parent',$callback);
				}else{
					throw new Exception("세금계산서 수정오류");
				}
			}else{
				$cashparams['order_date'	]		= date('Y-m-d H:i:s');
				$cashparams['regdate'		]		= date('Y-m-d H:i:s');
				$result	= $this->salesmodel->sales_write($cashparams);
				if($result){
					$this->order_for_sales($aPostParam['order_seq'],'1');
					$callback = "parent.document.location.reload();";
					openDialogAlert("관리자에 의해 세금계산서가 신청되었습니다.",400,140,'parent',$callback);
				}else{
					throw new Exception("세금계산서 신청오류");
				}
			}
		}
		catch (Exception $e) 
		{
			//$callback = "parent.document.location.reload();";
			$callback = '';
			openDialogAlert($e->getMessage(), 450, 150, 'parent',$callback);
			exit;
		}
	}


	/* 현금영수증발급 */
	public function cashreceiptwrite()
	{
		try {
			$aPostParam = $this->input->post();
			if	($aPostParam['cuse'] == '1'){
				$this->validation->set_rules('creceipt_number[1]', '사업자번호 ','trim|required|numeric|max_length[10]|xss_clean');
			}else{
				$this->validation->set_rules('creceipt_number[0]', '주민(휴대폰)번호','trim|required|numeric|max_length[13]|xss_clean');
			}
			$this->validation->set_rules('name', '주문자명 ','trim|required|xss_clean');
			$this->validation->set_rules('email', '이메일 ','trim|required|valid_email|xss_clean');
			$this->validation->set_rules('phone', '전화번호 ','trim|required|xss_clean');
			$this->validation->set_rules('goodsname', '상품명 ','trim|required|xss_clean');
			$this->validation->set_rules('amount', '발행액 ','trim|required|numeric|xss_clean');
			$this->validation->set_rules('supply', '공급액 ','trim|required|numeric|xss_clean');
			$this->validation->set_rules('surtax', '부가세 ','trim|required|numeric|xss_clean');
			if($this->validation->exec()===false){
				$err = $this->validation->error_array;
				$callback = "if(parent.document.cashreceiptform[\"{$err['key']}\"])
				parent.document.cashreceiptform[\"{$err['key']}\"].focus();";
				$callback .= "else if (parent.document.getElementsByName('{$err['key']}'))
				parent.document.getElementsByName('{$err['key']}').focus();";
				openDialogAlert($err['value'],400,140,'parent',$callback);
				exit;
			}

			$creceipt_number					= str_replace("-", "", $aPostParam['creceipt_number'][$aPostParam['cuse']]);
			$cashparams['typereceipt'		]	= 2;
			$cashparams['type'				]	= 1;//관리자수동
			$cashparams['price'				]	= $aPostParam['amount'];
			$cashparams['supply'			]	= $aPostParam['supply'];
			$cashparams['surtax'			]	= $aPostParam['surtax'];
			$cashparams['person'			]	= $aPostParam['name'];
			$cashparams['email'				]	= $aPostParam['email'];
			$cashparams['phone'				]	= $aPostParam['phone'];
			$cashparams['cuse'				]	= $aPostParam['cuse'];
			$cashparams['goodsname'			]	= $aPostParam['goodsname'];
			$cashparams['creceipt_number'	]	= $creceipt_number;
			$cashparams['regdate'			]	= date('Y-m-d H:i:s');
			$cashparams['order_seq'			]	= date('YmdHis').$result_id;

			$result_id	= $this->salesmodel->sales_write($cashparams);
			$result		= firstmall_typereceipt($cashparams['order_seq'], $result_id);

			if($result){
				$this->order_for_sales($aPostParam['order_seq'],'2');
				$callback = "parent.document.location.reload();";
				openDialogAlert("관리자에 의해 현금영수증이 신청되었습니다.",400,140,'parent',$callback);
			}else{
				throw new Exception("현금 영수증 발급신청 오류");
			}
		}
		catch (Exception $e) 
		{
			//$callback = "parent.document.location.reload();";
			$callback = '';
			openDialogAlert($e->getMessage(), 450, 150, 'parent',$callback);
			exit;
		}

	}

	// 주문번호 매출증빙 매칭 :: 2017-09-05 lwh
	public function order_for_sales($order_seq, $typereceipt){
		if($typereceipt && $order_seq){
			$sql = "UPDATE fm_order SET typereceipt = '{$typereceipt}' WHERE order_seq = '{$order_seq}'";
			$this->db->query($sql);
		}
	}

	// ajax 주문번호에 매칭된 매출증빙 건수 계산 :: 2017-09-05 lwh
	public function ajax_sales_list(){
		if($_GET['order_seq']){
			$sc['keyword']		= $_GET['order_seq'];
			$sc['tstep']		= array('1','2');
			$sc['action_mode']	= 'count';
			$query	= $this->salesmodel->sales_list($sc);
			$result	= $query->result_array();
			$return = $result[0]['cnt'];
		}else{
			$return = 0;
		}

		echo $return;
	}

	//현금영수증 발급취소
	public function cashreceiptcancel()
	{
		$delidar = @explode(",",$_POST['delidar']);
		$delnum = 0;
		for($i=0;$i<sizeof($delidar);$i++){ if(empty($delidar[$i]))continue;
			$upseq = $delidar[$i];

			$sc['whereis']	= ' and  seq="'.$upseq.'" ';
			$sc['select']		= '  *  ';
			$cashparams 		= $this->salesmodel->get_data($sc);
			if($cashparams){
				$upResult = $this->cashtax->getCashTax('mod', $cashparams);
				if (is_array($upResult) == true)
				{
					$upResult['seq']				= $cashparams['seq'];
					$upResult['issue_date']	= date('Y-m-d H:i:s');
					$upResult['tstep']			= 3;//발급취소
					//debug_var($upResult);
					$result = $this->salesmodel->sales_modify($upResult);

					if($result) {
						$delnum++;
					}
				}else{
					$return = array('result'=>true, 'msg'=>$upResult);
					echo json_encode($return);
					exit;
				}
			}
		}
		$return = array('result'=>true, 'msg'=>"[".$delnum."]건의 현금영수증의 발급이 취소되었습니다.");
		echo json_encode($return);
		exit;
	}


	public function taxwrite()
	{

		$cashparams['typereceipt']					= 1;
		$cashparams['type']							= 1;//관리자수동
		$cashparams['price']						= $_POST['amount'];
		$cashparams['supply']						= $_POST['supply'];
		$cashparams['surtax']						= $_POST['surtax'];
		$cashparams['person']						= $_POST['person'];
		$cashparams['email']						= $_POST['email'];
		$cashparams['phone']						= $_POST['phone'];
		$cashparams['busi_no']						= $_POST['busi_no'];
		$cashparams['co_name']						= $_POST['co_name'];
		$cashparams['co_ceo']						= $_POST['co_ceo'];
		$cashparams['co_status']					= $_POST['co_status'];
		$cashparams['co_type']						= $_POST['co_type'];
		$cashparams['zipcode']						= implode("-",$_POST['zipcode']);
		$cashparams['address']						= ($_POST['address_type'])?$_POST['address_type']:'zibun';
		$cashparams['address']						= $_POST['address'];
		$cashparams['address_street']			= $_POST['address_street'];
		$cashparams['address_detail']			= $_POST['address_detail'];
		//$cashparams['order_seq']					= $_POST['order_seq'];
		$cashparams['regdate']						= date('Y-m-d H:i:s');

		$arrBasic = ($this->config_basic)?$this->config_basic:config_load('basic');

		if(!preg_match("/(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)/", $_POST['email'], $regs)){
			openDialogAlert("이메일 형식이 올바르지 않습니다.",400,140,'parent',"");
			exit;
		}

		if($arrBasic["businessConditions"] == "" || $arrBasic["businessLine"] == ""){
			openDialogAlert("공급자 사업자 정보에 업태/종목이 작성되어 있지 않습니다.",400,140,'parent',"");
			exit;
		}

		$result_id = $this->salesmodel->sales_write($cashparams);

		$cashparams['order_seq']					= date('YmdHis').$result_id;
		$cashparams['paydt']						= $cashparams['regdate'];

		//$taxResult = $this->cashtax->getCashTax('pay', $cashparams);




		$taxResult = $this->salesmodel->hiworks_bill_send($cashparams);


		if ($taxResult['result'])
		{
			$taxResult['seq']						= $result_id;
			$taxResult['tstep']					= 2;//발급완료
			$taxResult['issue_date']			= date('Y-m-d H:i:s');
			$taxResult['order_seq']			= $cashparams['order_seq'];
			$this->salesmodel->sales_modify($taxResult);
			$callback = "parent.document.location.reload();";
			openDialogAlert("관리자에 의해 세금계산서가 신청되었습니다.",400,140,'parent',$callback);
		}
		else
		{
			$upResult['seq']					= $result_id;
			$upResult['tstep']				= 4;//발급실패
			$upResult['issue_date']		= date('Y-m-d H:i:s');
			$upResult['order_seq']		= $cashparams['order_seq'];
			$this->salesmodel->sales_modify($upResult);

			$this->cashtax->getCashTax('mod', $cashparams);
			$callback = "parent.document.location.reload();";
			openDialogAlert($taxResult["message"],400,140,'parent',$callback);
		}
	}



	//세금계산서 발급완료처리
	public function taxupdate()
	{
		$delidar = @explode(",",$_POST['delidar']);
		$delnum = 0;
		for($i=0;$i<sizeof($delidar);$i++){ if(empty($delidar[$i]))continue;

			$upResult['seq']				= $delidar[$i];
			$upResult['tstep']			= 2;//발급완료
			$upResult['pg_kind']		= $this->config_system['pgCompany'];
			$result = $this->salesmodel->sales_modify($upResult);
			if($result) {
				$delnum++;
			}
		}
		$return = array('result'=>true, 'msg'=>"[".$delnum."]건의 세금계산서가 발급완료되었습니다.");
		echo json_encode($return);
		exit;
	}


	public function tax_update()
	{
		$seq			= $_GET["seq"];
		$order_seq		= $_GET["order_seq"];

		$orders = config_load('order');
		$this->template->assign('orders',$orders);
		$arrBasic = ($this->config_basic)?$this->config_basic:config_load('basic');
		if($arrBasic["businessConditions"] == "" || $arrBasic["businessLine"] == ""){

			$return = array('result'=>false, 'msg'=>"공급자 사업자 정보에 업태/종목이 작성되어 있지 않습니다.");
			echo json_encode($return);
			exit;
		}

		if($orders['biztype']=='tax' && $orders['hiworks_use']=='Y'){
			if($this->config_system['webmail_admin_id'] && $this->config_system['webmail_domain'] && $this->config_system['webmail_key']){
				$sql	= "SELECT * FROM fm_sales WHERE seq = '{$seq}'";
				$query = $this->db->query($sql);
				$data = $query->result_array();

				if(!$data[0]['email'] && $data[0]['order_seq']){
					$sql	= "SELECT * FROM fm_order WHERE order_seq = '{$data[0]['order_seq']}'";
					$query = $this->db->query($sql);
					$order_data = $query->result_array();
					$data[0]['email'] = $order_data[0]['order_email'];
				}

				$result = $this->salesmodel->hiworks_bill_send($data[0]);
				if($result['result']){
					$return = array('result'=>true, 'msg'=>"처리 되었습니다.");
					echo json_encode($return);
					exit;
				}else{
					$return = array('result'=>false, 'msg'=>$result['message']);
					echo json_encode($return);
					exit;
				}
			}else{
				$return = array('result'=>false, 'msg'=>"하이웍스 정보가 올바르지 않습니다.\n설정> 매출증빙에서 하이웍스를 설정해 주세요.");
				echo json_encode($return);
				exit;
			}

		}else{
			$upResult['seq']			= $seq;
			$upResult['tstep']			= 2;//발급완료
			$upResult['pg_kind']		= $this->config_system['pgCompany'];
			$result = $this->salesmodel->sales_modify($upResult);

			$return = array('result'=>true, 'msg'=>"처리되었습니다.");
			echo json_encode($return);
			exit;
		}
	}


	public function tax_check(){
		$seq = $this->input->post("seq");

		$this->validation->set_rules('seq', '번호','trim|required|xss_clean|numeric');

		// 유효성 검증
		if ($this->validation->exec() === false) {
			$err = $this->validation->error_array;
			$return = array('result' => false, 'msg' => $err['value']);
			echo json_encode($return);
			exit;
		}

		/*
		$result = $this->salesmodel->hiworks_bill_check($seq);
		*/

		$this->db->where("seq", $seq);
		$query = $this->db->get('fm_sales');
		$data = $query->row_array();

		## 삭제대상. 
		## $this->salesmodel->sales_modify 부분이 정상적으로 update 시 
		## 아래와 같은 비정상적인 상태값은 발생할 수 없음.
		## 단, 기존 발급건 중 잔여 비정상 상태건이 있을 수 있으므로 당분간 유지 @2015-06-30 pjm
		if (!empty($data['hiworks_status']) && $data['hiworks_status']=='W' && $data['tstep']=='1') {
			$this->db->where('seq',$seq);
			$this->db->update('fm_sales',array('tstep'=>'2'));

			$message = "이미 발송한 정보입니다.";
			$return = array('result'=>false, 'msg'=>$message);
			echo json_encode($return);
			exit;
		}

		$taxResult = $this->salesmodel->hiworks_bill_send($data);

		if ($taxResult['result'])
		{
			$taxResult['seq']				= $seq;
			$taxResult['tstep']				= 2;//발급완료
			$upResult['up_date']			= date('Y-m-d H:i:s');
			$taxResult['issue_date']		= date('Y-m-d H:i:s');
			if($cashparams['order_seq']) $taxResult['order_seq']			= $cashparams['order_seq'];
			$this->salesmodel->sales_modify($taxResult);
			$log_msg	= '하이웍스로 전송성공';
			$this->salesmodel->sales_log_wirte($seq, $log_msg);
		}
		else
		{
			$upResult['seq']				= $seq;
			$upResult['tstep']				= 4;//발급실패
			$upResult['up_date']			= date('Y-m-d H:i:s');
			$upResult['issue_date']			= date('Y-m-d H:i:s');
			if($cashparams['order_seq']) $upResult['order_seq']			= $cashparams['order_seq'];
			$this->salesmodel->sales_modify($upResult);

			$this->cashtax->getCashTax('mod', $cashparams);
			$log_msg	= '하이웍스로 전송실패<br>'.$taxResult['message'];
			$this->salesmodel->sales_log_wirte($seq, $log_msg);
		}

		if($taxResult['message'] == "W"){
			$message = "처리되었습니다. 하이웍스에 로그인 하셔서 발급 하시면 세금계산서가 발행됩니다";
		}else{
			$message = "처리중 에러가 발생하였습니다.";
		}

		$return = array('result'=>$result['result'], 'msg'=>$message);
		echo json_encode($return);
		exit;
	}



	//신청서삭제
	public function sales_multi_delete()
	{
		$delidar = @explode(",",$_POST['delidar']);
		$delnum = 0;
		for($i=0;$i<sizeof($delidar);$i++){ if(empty($delidar[$i]))continue;
			$delseq = $delidar[$i];
			$sc['whereis']	= ' and  seq="'.$delseq.'" ';
			$sc['select']		= 'seq, type, order_seq';
			$sales 		= $this->salesmodel->get_data($sc);

			$result = $this->salesmodel->sales_delete($delseq);
			if($result) {
				if($sales['type'] != 1) {//수동발급이 아닌경우
					$this->db->where('order_seq',$sales['order_seq']);
					$this->db->update('fm_order',array('typereceipt'=>'0'));
				}
				$delnum++;
			}
		}

		$return = array('result'=>true, 'msg'=>"[".$delnum."]건의 신청서가 삭제되었습니다.");
		echo json_encode($return);
		exit;
	}


	### 수기등록
	public function manual_cash(){
		$seq = $_POST['seq'];
		$sql = "UPDATE fm_sales SET tstep = 2 WHERE seq = '{$seq}'";
		$result = $this->db->query($sql);
		echo json_encode($result);
		exit;
	}

	public function sales_unlink(){
		$seq = $_GET['seq'];
		$sql = "UPDATE fm_sales SET tstep = 2, approach = 'unlink', up_date = '".date("Y-m-d H:i:s")."' WHERE seq = '{$seq}'";
		$result = $this->db->query($sql);
		$callback = "parent.document.location.reload();";
		openDialogAlert("처리되었습니다.",400,140,'parent',$callback);
		exit;
	}

	public function sales_cancel(){
		$seq = $_GET['seq'];
		$order_seq = $_GET['order_seq'];
		$sql = "UPDATE fm_sales SET tstep = 3, approach = 'unlink', up_date = '".date("Y-m-d H:i:s")."' WHERE seq = '{$seq}'";
		$result = $this->db->query($sql);

		$sql = "UPDATE fm_order SET typereceipt = ''  WHERE order_seq = '{$order_seq}'";
		$result = $this->db->query($sql);


		$callback = "parent.document.location.reload();";
		openDialogAlert("처리되었습니다.",400,140,'parent',$callback);
		exit;
	}

	public function tax_send_log(){
		$seq = $this->input->post('seq');

		if ($seq){
			$result				= $this->salesmodel->get_sales_log((int)$seq);
			$result['result']	= true;
			echo json_encode($result);
			exit;
		}

		echo json_encode(array('result'=>false));
	}

	public function sales_memo(){
		$seq	= $_GET['seq'];
		$sql = "select admin_memo as memo from fm_sales  WHERE seq = '{$seq}'";
		$query = $this->db->query($sql);
		$result = $query->row_array();

		echo json_encode($result);
		exit;
	}

	public function memo_regist(){
		$seq	= $_POST['sales_seq'];
		$order_seq	= $_POST['order_seq'];

		$sales_memo	= str_replace("'", "''", $_POST['sales_memo']);

		$sql = "UPDATE fm_sales SET admin_memo = '{$sales_memo}'  WHERE seq = '{$seq}'";
		$query = $this->db->query($sql);

		$callback = "parent.sales_memo('{$seq}', '{$order_seq}');";
		openDialogAlert("저장되었습니다..",400,140,'parent',$callback);
		exit;
	}

	public function sales_excel_download(){
		$sc						= $_GET;
		$sc['orderby']			= (!empty($_GET['orderby'])) ?	$_GET['orderby']:'seq desc';
		$sc['no_limit'] = 1;
		if(!empty($_GET['keyword'])) $sc['keyword'] = $_GET['keyword'];
		if	($_GET['searchSelect'] == 'select' && $_GET['salesSeq']){
			$sc['chk_excel_down']	= '1';
			$sc['sales_seq']		= $_GET['salesSeq'];
		}

		//개인정보 마스킹 표시 권한 체크
		$private_masking = $this->authmodel->manager_limit_act('private_masking');
		if ( $private_masking ) {
			$msg = "마스킹(*) 처리된 개인정보 항목이 포함되어 있어 엑셀 다운로드를 할 수 없습니다.";
			$msg .= "<br/ >대표운영자에게 관리자 권한 수정을 요청해주시기 바랍니다.";
			openDialogAlert($msg, 600, 180, 'parent', '');
			exit;
		}

		$this->load->model('salesmodel');
		$this->load->model('ordermodel');
		$arr_payment = config_load('payment');
		$data = $this->salesmodel->sales_list($sc);

		$typereceipt = array(
			'0' => '매출전표','1' => '세금계산서','2' => '현금영수증',
		);

		$arr_tstep = array(
			'1' => '대기','2' => '완료','3' => '취소','4' => '완료(연동실패)','5' => '완료'
		);

		if(!is_dir(ROOTPATH."data/sales")){
			mkdir(ROOTPATH."data/sales");
			chmod(ROOTPATH."data/sales",0777);
		}

		$limittotalnum = 3000;
		ini_set("memory_limit",-1);

		//3천건 이상일시 3천건씩 나누어 압축하여 다운로드
		if($data['count'] > $limittotalnum){
			
			$count = $data['count'] / $limittotalnum;
			
			for($i=0; $i<ceil($count); $i++){
				
				unset($this->db->queries);
				unset($this->db->query_times);
				unset($result);
				
				$downfilename = $_SERVER['DOCUMENT_ROOT']."/data/sales/sales_down_".date("YmdHi")."_".$i.".xls";

				$fp = fopen($downfilename, "w") or die("Can't open file score.xls ");

				fwrite($fp, $this->get_default_excel_header());

				if($sc["keyword"] == "주문자, 주문번호, 담당자")
					$sc["keyword"] = "";

				$sc['page'] = $i * $limittotalnum;
				$sc['perpage'] = $limittotalnum;
				$sc['no_limit'] = 0;

				if($sc['searchSelect'] == 'select' && !empty($sc['sales_seq']))
					$sc['chk_excel_down'] = 1;

				$result = $this->salesmodel->sales_list($sc);

				foreach($result['record'] as $data){
					$street = "";
					if($data['address_street'])
						$street = "(".$data['address_street'].")";
					
					if( $data['typereceipt'] == 2) {
						$phone = $data['creceipt_number'];
					}else{
						$phone = $data['phone'];
					}

					$tstep = $data['typereceipt'] == 0 ? '완료' : $arr_tstep[$data['tstep']];
					if	(!$tstep) $tstep ='대기';

					$settleprice = $data['settleprice'] ? number_format($data['settleprice']) : '';

					$supply = (int)$data['supply'];
					$surtax = (int)$data['surtax'];
					$total_price = $data['price'];

					if($data['typereceipt'] == 1){
						$supply = $data['tax_supply'];
						$surtax = $data['tax_surtax'];
						$total_price = $data['tax_price'];
					}

					$row = '<Row ss:Height="33">
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['order_seq'].'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['order_date'].'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.$arr_payment[$data['payment']].'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.$settleprice.'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.$typereceipt[$data['typereceipt']].'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.number_format($supply).'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.number_format($surtax).'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.number_format($total_price).'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.$tstep.'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['co_name'].'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['busi_no'].'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['co_ceo'].'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['address'].' '.$street.' '.$data['address_detail'].'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['email'].'</Data></Cell>
						<Cell ss:StyleID="s62"><Data ss:Type="String">'.$phone.'</Data></Cell>
					</Row>';

					fwrite($fp, $row);
				}
				fwrite($fp, $this->get_default_excel_footer());
				fclose($fp);
				
				$downFileList[$i] = $downfilename;
				
			}
				
			echo "<form name='downfrm' method='post' action='/admin/sales_process/download_sales_zipfile'>";
			foreach($downFileList as $filename){
				echo "<input type='text' name='downFileList[]' value='".$filename."'>";
			}
			echo "<form>";
			echo "<script>document.downfrm.submit();</script>";
		//3천건 이하일때 xls 형태로 다운로드
		}else{
			unset($this->db->queries);
			unset($this->db->query_times);
			unset($result);

			header('Content-Type: application/vnd.ms-excel');
			header("Content-Disposition: attachment;filename=sales_down_".date("YmdHi").".xls");
			header('Cache-Control: max-age=0');

			echo $this->get_default_excel_header();

			if($sc["keyword"] == "주문자, 주문번호, 담당자")
				$sc["keyword"] = "";

			$sc['page'] = 0;
			$sc['perpage'] = $limittotalnum;
			if($sc['searchSelect'] == 'select' && !empty($sc['sales_seq']))
				$sc['chk_excel_down'] = 1;
			$result = $this->salesmodel->sales_list($sc);

			foreach($result['record'] as $data){
				$street = "";
				if($data['address_street'])
					$street = "(".$data['address_street'].")";

				if( $data['creceipt_number'] ) {
					$phone = $data['creceipt_number'];
				}else{
					$phone = $data['phone'];
				}

				$tstep = $data['typereceipt'] == 0 ? '완료' : $arr_tstep[$data['tstep']];
				if	(!$tstep) $tstep ='대기';

				$settleprice = $data['settleprice'] ? number_format($data['settleprice']) : '';

				$supply = $data['supply'];
				$surtax = $data['surtax'];
				$total_price = $data['price'];

				echo '<Row ss:Height="33">
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['order_seq'].'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['order_date'].'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.$arr_payment[$data['payment']].'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.$settleprice.'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.$typereceipt[$data['typereceipt']].'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.number_format($supply).'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.number_format($surtax).'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.number_format($total_price).'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.$tstep.'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['co_name'].'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['busi_no'].'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['co_ceo'].'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['address'].' '.$street.' '.$data['address_detail'].'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.$data['email'].'</Data></Cell>
					<Cell ss:StyleID="s62"><Data ss:Type="String">'.$phone.'</Data></Cell>
				</Row>';
			}
			echo $this->get_default_excel_footer();
		}
	}

	public function download_sales_zipfile(){

		$downFileList = $_POST['downFileList'];
		$backup_file_name = ($_POST['backup_file_name'])?$_POST['backup_file_name']:'download_sales_zipfile_'.date("YmdHi").'.zip';
		//크롬에서 다운안되는 문제 해결
		$this->load->library('zip'); 
		foreach($downFileList as $filename){
			$this->zip->read_file($filename);
		}
		foreach($downFileList as $filename){
			unlink($filename);
		}
		$this->zip->download($backup_file_name); 
		
	}

	// xml 형태 엑셀의 기본 header
	public function get_default_excel_header(){
		$excelXmlHeader	= '<?xml version="1.0"?>
					<?mso-application progid="Excel.Sheet"?>
					<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
						xmlns:o="urn:schemas-microsoft-com:office:office"
						xmlns:x="urn:schemas-microsoft-com:office:excel"
						xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
						xmlns:html="http://www.w3.org/TR/REC-html40">
					<Styles>
						<Style ss:ID="Default" ss:Name="Normal">
							<Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
							<Borders/>
							<Font ss:FontName="맑은 고딕" x:CharSet="129" x:Family="Modern" ss:Size="11" ss:Color="#000000"/>
							<Interior/>
							<NumberFormat/>
							<Protection/>
						</Style>
						<Style ss:ID="s62">
							<Alignment ss:Horizontal="Center" ss:Vertical="Center"  ss:WrapText="1"/>
						</Style>
						<Style ss:ID="s63">
							<Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
							<Interior ss:Color="#dfeaff" ss:Pattern="Solid"/>
							<Font ss:Size="11" ss:Color="#000000" ss:Bold="1" />
						</Style>
					</Styles>
					<Worksheet ss:Name="Sheet1">
						<Table>
							<Column ss:Index="1" ss:AutoFitWidth="0" ss:Width="120"/>
							<Column ss:Index="2" ss:AutoFitWidth="0" ss:Width="120"/>
							<Column ss:Index="5" ss:AutoFitWidth="0" ss:Width="80"/>
							<Column ss:Index="11" ss:AutoFitWidth="0" ss:Width="100"/>
							<Column ss:Index="14" ss:AutoFitWidth="0" ss:Width="120"/>
							<Column ss:Index="15" ss:AutoFitWidth="0" ss:Width="140"/>
						';
		$excelXmlHeader .= '<Row ss:Index="1" ss:Height="33">
								<Cell ss:StyleID="s63" ss:MergeAcross="3"><Data ss:Type="String">주문정보</Data></Cell>
								<Cell ss:StyleID="s63" ss:MergeAcross="4"><Data ss:Type="String">발행정보</Data></Cell>
								<Cell ss:StyleID="s63" ss:MergeAcross="4"><Data ss:Type="String">세금계산서 신청정보</Data></Cell>
								<Cell ss:StyleID="s63"><Data ss:Type="String">현금영수증 신청정보</Data></Cell>
							</Row>';
		$excelXmlHeader .= '<Row ss:Index="2" ss:Height="33">
								<Cell ss:StyleID="s62"><Data ss:Type="String">주문번호</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">주문일</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">결제수단</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">결제금액</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">증빙</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">공급가</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">부가세</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">합계</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">결과</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">상호</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">사업자번호</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">대표자</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">주소</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">수신</Data></Cell>
								<Cell ss:StyleID="s62"><Data ss:Type="String">휴대폰번호</Data></Cell>
							</Row>';
		return $excelXmlHeader;
	}

	public function get_default_excel_footer(){
		return '</Table></Worksheet></Workbook>';
	}
}

/* End of file sales_process.php */
/* Location: ./app/controllers/admin/sales_process.php */