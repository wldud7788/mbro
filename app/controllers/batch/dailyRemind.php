<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH ."controllers/batch/dailyStats".EXT);
class dailyRemind extends dailyStats {
    public function __construct() {
        parent::__construct();            
    }
    
    ## 고객리마인드서비스 : 이번주 만료될 할인쿠폰 알림 : 매주 월요일 관리자 {지정시간} 발송
    public function remind_coupon(){
        list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
        try{
            $this->load->helper('reservation');
            # mode 값 : view(내용확인), send(발송), logview = y 일때 로그보이기

            $personal_use		= config_load('personal_use');		//알림 사용여부 불러옴
            $sms_personal		= config_load('sms_personal');
            $reserve_time		= $sms_personal['personal_coupon_time'];

            if($personal_use['personal_coupon_use']=='y'){

                $emode		= 'send';
                $smode		= 'send';
                $logview	= '';

                # 오늘이 월요일 일때, 예약시간이 현재 시간보다 이후일때
                if(date("w",mktime()) == 1 && date("Y-m-d {$reserve_time}:00:00", mktime()) > date("Y-m-d H:i:s",mktime())){
                    # mode 값 : view(내용확인), send(발송), logview = y 일때 로그보이기
                    $res = send_reserv_coupon($emode,$smode,$logview);                    
                    if( !$res ){                    
                        throw new Exception('Err(Send)');
                    }
                }else{
                    throw new Exception('Err(Today is not monday)');
                }
            }else{                
                throw new Exception('Err(Disabled)');
            }
        } catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');

	}
    
    ## 고객리마인드서비스 : 다음달 소멸 마일리지 안내 : 전월 {지정날짜} , {지정시간}에 발송
	public function remind_emoney(){
		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->helper('reservation');
            $personal_use		= config_load('personal_use');		//알림 사용여부 불러옴
            if($personal_use['personal_emoney_use'] == 'y'){

                # mode 값 : view(내용확인), send(발송), logview = y 일때 로그보이기
                $emode		= 'send';
                $smode		= 'send';
                $logview	= '';

                ## 지정 예약일
                $sms_personal		= config_load('sms_personal');
                $reserve_day		= $sms_personal['personal_emoney_day'];

                # 오늘이 지정 예약일 일때.
                if(date("d",mktime()) == $reserve_day){
                    $res = send_reserv_emoney($emode,$smode,$logview);                   
                    if( !$res ){                    
                        throw new Exception('Err(Send)');
                    }
                }else{                    
                    throw new Exception('Err(Today is not monday)');
                }
            }else{                
                throw new Exception('Err(Disabled)');
            }			
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
    
    ## 고객리마인드서비스 : 장바구니/위시리스트 상품 안내 : 마지막 담은 상품이 지정예약 조건에 충족시
	public function remind_cart(){
		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->helper('reservation');

            ## 지정 예약일 : 없음. 어제 장바구니/위시리스트 조회해서 발송.
            $personal_use		= config_load('personal_use');		//알림 사용여부 불러옴

            //personal_review_menu();

            if($personal_use['personal_cart_use'] == 'y'){

                # mode 값 : view(내용확인), send(발송), logview = y 일때 로그보이기
                $emode		= 'send';
                $smode		= 'send';
                $logview	= '';

                # 오늘이 지정 예약일 일때.               
                $res = send_reserv_cart($emode,$smode,$logview);
                if( !$res ){                    
                    throw new Exception('Err(Send)');
                }
            }else{                
                throw new Exception('Err(Disabled)');
            }
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
    
    ## 고객리마인드서비스 : 회원등급 혜택 안내
	public function remind_membership(){
		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->helper('reservation');

            $personal_use		= config_load('personal_use');		//알림 사용여부 불러옴

            //personal_review_menu();

            if($personal_use['personal_membership_use'] == 'y' ){

                # mode 값 : view(내용확인), send(발송), logview = y 일때 로그보이기
                $emode		= 'send';
                $smode		= 'send';
                $logview	= '';

                # 오늘이 지정 예약일 일때.
                $res = send_reserv_membership($emode,$smode,$logview);                
                if( !$res ){                    
                    throw new Exception('Err(Send)');
                }

            }else{
                throw new Exception('Err(Disabled)');
            }
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
    ## 고객리마인드서비스 : 장바구니/위시리스트에 담긴 타임세일 종료 상품 안내
	public function remind_timesale(){
		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
                $this->load->helper('reservation');
                $personal_use		= config_load('personal_use');		//알림 사용여부 불러옴
                //personal_review_menu();

                if($personal_use['personal_timesale_use'] == 'y'){

                    # mode 값 : view(내용확인), send(발송), logview = y 일때 로그보이기
                    $emode		= 'send';
                    $smode		= 'send';
                    $logview	= '';

                    $res = send_reserv_timesale($emode,$smode,$logview);
                    if( !$res ){                    
                        throw new Exception('Err(Send)');
                    }
                }else{
                    throw new Exception('Err(Disabled)');
                }
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
    
    ## 고객리마인드서비스 : 배송완료고객 배송완료일 +{지정일수} 상품 리뷰 작성 안내
	public function remind_review(){
		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->helper('reservation');
            $personal_use		= config_load('personal_use');		//알림 사용여부 불러옴

            //personal_review_menu();

            if($personal_use['personal_review_use'] == 'y'){

                # mode 값 : view(내용확인), send(발송), logview = y 일때 로그보이기
                $emode		= 'send';
                $smode		= 'send';
                $logview	= '';

                $res = send_reserv_review($emode,$smode,$logview);                
                if( !$res ){                    
                    throw new Exception('Err(Send)');
                }

            }else{                
                throw new Exception('Err(Disabled)');
            }            
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
    
    ## 고객리마인드서비스 : 생일 축하
	public function remind_birthday(){
		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->helper('reservation');

            $personal_use		= config_load('personal_use');		//알림 사용여부 불러옴

            //personal_review_menu();

            if($personal_use['personal_birthday_use'] == 'y'){

                # mode 값 : view(내용확인), send(발송), logview = y 일때 로그보이기
                $emode		= 'send';
                $smode		= 'send';
                $logview	= '';

                $res = send_reserv_birthday($emode,$smode,$logview);                
                if( !$res ){                    
                    throw new Exception('Err(Send)');
                }
            }else{                
                throw new Exception('Err(Disabled)');
            }
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
    
    ## 고객리마인드서비스 : 기념일 축하
	public function remind_anniversary(){
		
		list($aFunc, $aNextFunc)	= $this->batchlib->_getNextFunc(__FUNCTION__);
		try{
			$this->load->helper('reservation');

            $personal_use		= config_load('personal_use');		//알림 사용여부 불러옴

            //personal_review_menu();

            if($personal_use['personal_anniversary_use'] == 'y'){

                # mode 값 : view(내용확인), send(발송), logview = y 일때 로그보이기
                $emode		= 'send';
                $smode		= 'send';
                $logview	= '';

                $res = send_reserv_anniversary($emode,$smode,$logview);                
                if( !$res ){                    
                    throw new Exception('Err(Send)');
                }
            }else{                
                throw new Exception('Err(Disabled)');
            }
		} catch (Exception $e) {			
			if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ') - ' . $e->getMessage());
		}
        if( $aNextFunc )	$this->{$aNextFunc['sFunctionName']}();
        if( $aFunc )		$this->batchlib->_cronFileLog($aFunc['sLogFile'], $aFunc['sMsg'] . '(' . $aFunc['sFunctionName'] . ')');
	}
}