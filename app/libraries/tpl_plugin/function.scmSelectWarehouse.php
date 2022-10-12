<?php
/* 물류관리 창고 선택 selectBox
* options = {
* boxName					@selectbox name ( string )
* boxingTag					@해당 selectbox가 영향을 미칠 박스영역의 최 상위 tag ( string tagName )
* lineTag					@한줄 한줄을 구분할 tag명 ( string tagName )
* goodsinfoSelector			@상품정보 input용 selector명 ( enum #selector명, .selector명, @inputName )
* stockSelector				@창고 재고 input용 selector명 ( enum #selector명, .selector명, @selector명 )
* disStockSelector			@창고 재고 노출용 selector명 ( enum #selector명, .selector명 )
* supplyPriceSelector		@창고 매입가 input용 selector명 ( enum #selector명, .selector명, @selector명 )
* disSupplyPriceSelector	@창고 매입가 노출용 selector명 ( enum #selector명, .selector명 )
* eaSelector				@출고수량 input selector명 ( enum #selector명, .selector명, @inputName )
* eaDefaultValSelector		@출고수량 기본값 input selector명 ( enum #selector명, .selector명, @inputName )
* whNameSelector			@창고명 노출용 selector명 ( enum #selector명, .selector명 )
* locCodeSelector			@창고 로케이션 코드 노출용 selector명 ( enum #selector명, .selector명 )
* locCodeInputer			@창고 로케이션 코드 selector명 ( enum #selector명, .selector명, @inputName )
* locPositionSelector		@창고 로케이션 좌표 노출용 selector명 ( enum #selector명, .selector명 )
* locPositionInputer		@창고 로케이션 좌표 selector명 ( enum #selector명, .selector명, @inputName )
* badstockSelector			@불량재고 노출용 selector명 ( enum #selector명, .selector명 )
* showhideSelector
* showhideSelectorReverse
							@존재여부에 따른 show, hide처리용 selector명 ( enum #selector명, .selector명 )
* showhideSelectorLocation
* showhideSelectorReverseLocation
							@존재여부에 따른 show, hide처리용 selector명 ( enum #selector명, .selector명 )
* whInfoSelector			@창고 정보 영역 selector명 ( enum #selector명, .selector명 )
* whInfoSkinStr				@창고 정보 영역 String ( string )
								* 사용 가능한 치환문구
									- [:WH_NAME:]	: 창고명
									- [:LOC_CODE:]	: 로케이션 코드
									- [:LOC_POS:]	: 로케이션 좌표
									- [:STOCK:]		: 창고 재고
									- [:BAD_STOCK:]	: 창고 불량 재고
* preffixHTML				@selectbox 앞에 추가할 HTML ( string html )
* suffixHTML				@selectbox 뒤에 추가할 HTML ( string html )
* defaultValue				@초기 기본선택 값
* firstOptionTitle			@공백 옵션 추가 시 공백 옵션문구 ( 첫번째 옵션으로 추가됨 )
*/
function scmSelectWarehouse($shopSno, $options = array()){

	class scmSelectWarehouse{

		public function __construct(&$CI, $shopSno, $options = array()){

			$this->ci				= $CI;
			$this->shopSno			= $shopSno;
			$this->skin_file_path	= 'default/scm/select_warehouse.html';
			$this->load_scm_config();
			$this->mergeOptions($options);
		}

		// 넘어온 옵션과 기본값으로 최종 옵션 생성
		public function mergeOptions($options = array()){

			$defaultValue	= $this->scm_cfg['export_wh'];

			if	(!$options['boxName'])					$options['boxName']					= 'scmWarehouse';
			if	(!$options['boxingTag'])				$options['boxingTag']				= 'table';
			if	(!$options['lineTag'])					$options['lineTag']					= 'tr';
			if	(!$options['goodsinfoSelector'])		$options['goodsinfoSelector']		= '';
			if	(!$options['stockSelector'])			$options['stockSelector']			= '';
			if	(!$options['disStockSelector'])			$options['disStockSelector']		= '';
			if	(!$options['supplyPriceSelector'])		$options['supplyPriceSelector']		= '';
			if	(!$options['disSupplyPriceSelector'])	$options['disSupplyPriceSelector']	= '';
			if	(!$options['eaSelector'])				$options['eaSelector']				= '';
			if	(!$options['eaDefaultValSelector'])		$options['eaDefaultValSelector']	= '';
			if	(!$options['whNameSelector'])			$options['whNameSelector']			= '';
			if	(!$options['locCodeSelector'])			$options['locCodeSelector']			= '';
			if	(!$options['locCodeInputer'])			$options['locCodeInputer']			= '';
			if	(!$options['locPositionSelector'])		$options['locPositionSelector']		= '';
			if	(!$options['locPositionInputer'])		$options['locPositionInputer']		= '';
			if	(!$options['badstockSelector'])			$options['badstockSelector']		= '';
			if	(!$options['showhideSelector'])			$options['showhideSelector']		= '';
			if	(!$options['showhideSelectorReverse'])	$options['showhideSelectorReverse']	= '';
			if	(!$options['showhideSelectorLocation'])	$options['showhideSelectorLocation']= '';
			if	(!$options['showhideSelectorReverseLocation'])
				$options['showhideSelectorReverseLocation']									= '';
			if	(!$options['whInfoSelector'])			$options['whInfoSelector']			= '';
			if	(!$options['whInfoSkinStr'])			$options['whInfoSkinStr']			= '';
			if	(!$options['preffixHTML'])				$options['preffixHTML']				= '';
			if	(!$options['suffixHTML'])				$options['suffixHTML']				= '';
			if	(!$options['defaultValue'])				$options['defaultValue']			= $defaultValue;
			if	(!$options['firstOptionTitle'])			$options['firstOptionTitle']		= '';

			// inputName selector일 경우 치환 처리
			if	(preg_match('/^@/', $options['goodsinfoSelector'])){
				$options['goodsinfoSelector']		= str_replace('@', '', $options['goodsinfoSelector']);
				$options['goodsinfoSelector']		= 'input[name=\'' . $options['goodsinfoSelector'] . '\']';
			}
			if	(preg_match('/^@/', $options['eaSelector'])){
				$options['eaSelector']				= str_replace('@', '', $options['eaSelector']);
				$options['eaSelector']				= 'input[name=\'' . $options['eaSelector'] . '\']';
			}
			if	(preg_match('/^@/', $options['stockSelector'])){
				$options['stockSelector']			= str_replace('@', '', $options['stockSelector']);
				$options['stockSelector']			= 'input[name=\'' . $options['stockSelector'] . '\']';
			}
			if	(preg_match('/^@/', $options['supplyPriceSelector'])){
				$options['supplyPriceSelector']		= str_replace('@', '', $options['supplyPriceSelector']);
				$options['supplyPriceSelector']		= 'input[name=\'' . $options['supplyPriceSelector'] . '\']';
			}
			if	(preg_match('/^@/', $options['eaDefaultValSelector'])){
				$options['eaDefaultValSelector']	= str_replace('@', '', $options['eaDefaultValSelector']);
				$options['eaDefaultValSelector']	= 'input[name=\'' . $options['eaDefaultValSelector'] . '\']';
			}
			if	(preg_match('/^@/', $options['locCodeInputer'])){
				$options['locCodeInputer']	= str_replace('@', '', $options['locCodeInputer']);
				$options['locCodeInputer']	= 'input[name=\'' . $options['locCodeInputer'] . '\']';
			}
			if	(preg_match('/^@/', $options['locPositionInputer'])){
				$options['locPositionInputer']	= str_replace('@', '', $options['locPositionInputer']);
				$options['locPositionInputer']	= 'input[name=\'' . $options['locPositionInputer'] . '\']';
			}
			// 창고 정보 selector는 있는 skin string이 없을 시 기본 문구
			if	($options['whInfoSelector'] && !$options['whInfoSkinStr']){
				$options['whInfoSkinStr']	= '[:WH_NAME:] ([:LOC_CODE:]) : [:STOCK:]([:BAD_STOCK:])';
			}

			$this->options		= $options;
		}

		// scm 관련 설정 load
		public function load_scm_config(){
			$this->ci->load->helper('basic');
			$this->scm_cfg	= config_load('scm');
		}

		// 스킨에서 selectbox 불러오기
		public function call_template_html(){
			$result		= '';
			if	($this->scm_cfg['use'] == 'Y' && count($this->scm_cfg['use_warehouse']) > 0){
				$this->ci->template->assign($this->options);
				$this->ci->template->assign(array(
					'shopSno'		=> $this->shopSno, 
					'warehouses'	=> $this->scm_cfg['use_warehouse'], 
				));
				$this->ci->template->define(array('scmskin'=>$this->skin_file_path));
				$result		= $this->ci->template->fetch("scmskin");
			}

			return $result;
		}
	}
	
	if	($shopSno > 0){
		$sswObj	= new scmSelectWarehouse(get_instance(), $shopSno, $options);
		return $sswObj->call_template_html();
	}
}

?>