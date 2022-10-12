<?php
# 비교통화 노출
function showCompareCurrency($data=null,$default_price=0,$mode='',$options=array()){
	$CI =& get_instance();

	# 디스플레이 설정 외 상품상세,장바구니,주문장접수 등에서의 비교통화 노출
	if(($mode == "return" || $mode == "return_array") && $data == null ){
		$data =  $CI->config_currency;
	}

	$compare_view		= true;	//비교통화 노출
	$compare_currency	= "";

	if(is_object($data)) $data = (array)$data;

	if($mode == "return" || $mode == "return_array"){
		$kind				= '';
		$position			= ($options['position'])?$options['position']:'side';
		$type				= ($options['type'])?$options['type']:'()';
		$font_decoration	= '';
		$name_css			= '';
		$currency_symbols	= array();
		foreach($data as $currency=>$curr_data){
			$curr_tmp = array();
			$curr_tmp['currency']			= $currency;

			if($curr_tmp['currency'] != $CI->config_system['basic_currency']){
				$curr_tmp['symbol_view']		= 'view';
			}else{
				$curr_tmp['symbol_view']		= 'hide';
			}
			$curr_tmp['symbol_position']	= $curr_data['currency_symbol_position'];
			$curr_tmp['symbol_postfix']		= $curr_data['currency_symbol'];
			$currency_symbols[] = $curr_tmp;
		}
	}else{
		//$data				= json_decode($data);
		$kind				= $data['kind'];
		$position			= $data['position'];
		$type				= $data['type'];
		$font_decoration	= $data['font_decoration'];
		$name_css			= $data['name_css'];
		$currency_symbols	= (array)$data['currency_symbols'];
	}

	if	($font_decoration){
		$font_decoration	= json_decode($font_decoration, true);
		if	($font_decoration) foreach($font_decoration as $decoType => $decoVal){
			switch($decoType){
				case 'color':
					$addStyle	.= 'color:' . $decoVal . ' !important;';
				break;
				case 'bold':
					$addStyle	.= 'font-weight:' . $decoVal . ' !important;';
				break;
				case 'underline':
					$addStyle	.= 'text-decoration:' . $decoVal . ' !important;';
				break;
			}
		}
	}

	$price_list = array();

	$key_i = 0;
	foreach($currency_symbols as $key=>$curr_data){

		$curr_data = (array)$curr_data;

		if($curr_data['symbol_view'] == "view"){

			$price = get_currency_exchange($default_price,$curr_data['currency']);
			$price = get_currency_price($price,'',$curr_data['currency']);

			$price_tmp = "";
			if($curr_data['symbol_position'] == "before"){
				$price_tmp = $curr_data['symbol_postfix']."<span>".$price."</span>";
			}elseif($curr_data['symbol_position'] == "after"){
				$price_tmp = "<span>".$price."</span>".$curr_data['symbol_postfix'];
			}

			$price_list[] = $price_tmp;

			$key_i++;
		}

	}

	if(array_filter($price_list)){

		$compare_list = '<ul class="currency_list">';
		foreach($price_list as $k=>$price){

			//if($k == 0 && !$CI->mobileMode) $price .= "&nbsp;▼";
			if(!$CI->mobileMode){
				if($k > 0) $compare_list .= '<li>'.$price.'</li>';
			}else{
				$compare_list .= '<li>'.$price.'</li>';
			}
		}
		$compare_list .= '</ul>';

		$compare_currency_arr	= array();
		if($position == "side"){
			$compare_currency_arr[] = '<span style="display:inline-block; position:relative;' . $addStyle. '" class="currency_compare_lay">';
		}elseif($position == "down" || $position == "bottom"){
			$compare_currency_arr[] = '<div style="position:relative;' . $addStyle. '" class="currency_compare_lay">';
		}else{
			$compare_currency_arr[] = '<span style="display:inline-block; position:relative;' . $addStyle. '" class="currency_compare_lay">';
		}

		$style = "z-index:9999;";
		if($options['width']){
			$style .= "min-width:".$options['width'].";";
		}else{
			if	($CI->mobileMode)
				$style .= "min-width:80px;";
			else
				$style .= "min-width:100px;";
		}
		if($options['color']){
			$style .= "color:".$options['color'].";";
		}

		if(!$CI->mobileMode){

			if(count($price_list) > 1){
				$compare_currency_arr[] = '<span class="currency_open detailDescriptionLayerBtn over"'.$name_css.'>';
				$price_first			= $price_list[0]."&nbsp;▼";
			}else{
				$compare_list			= "";
				$price_first			= $price_list[0];
			}

			if($type == "()"){
				$price_first			= "(".$price_first.")";
			}else{
				$price_first			= $price_first;
			}

			$compare_currency_arr[]		= "&nbsp;".$price_first;

			if(count($price_list) > 1){
				$compare_currency_arr[] = '	</span>';
			}

			if(count($price_list) > 1 && $compare_list){
				$compare_list	= '<div class="detailDescriptionLayer hide '.$options['layClass'].'" style="'.$style.';"><div class="layer_wrap2 pd10">'.$compare_list.'</div></div>';
			}

		}else{

			$price_first			= "";
			$compare_currency_arr[] = '<span class="currency_open detailDescriptionLayerBtn"'.$name_css.'>';
			$compare_currency_arr[] = '	<img src="/admin/skin/default/images/main/sts_btn_chg.gif" class="pd5">';
			$compare_currency_arr[] = '</span>';

			if($compare_list){
				$left				= 'left:-20px;';
				if	($position != 'side') $left = 'left:26px;';
				$style			.= "top:-80px;margin:0px;{$left}";
				$compare_list	= '<div class="detailDescriptionLayer hide '.$options['layClass'].'" style="'.$style.'"><div class="layer_wrap2 pd10">'.$compare_list.'</div></div>';
			}
		}

		if($mode == "return_array"){
			if($price_first) $price_list[0] = $price_first;
		}

		if($compare_list){
			$compare_currency_arr[] = $compare_list;
		}else{
		}

		if($position == "side"){
			$compare_currency_arr[] = '</span>';
		}elseif($position == "down" || $position == "bottom"){
			$compare_currency_arr[] = '</div>';
		}else{
			$compare_currency_arr[] = '</span>';
		}

		if($compare_view){
			$compare_currency = implode("",$compare_currency_arr);
		}
	}else{
		$compare_currency = "";
	}

	if($mode == 'return'){
		return $compare_currency;
	}elseif($mode == 'return_array'){
		return $price_list;
	}else{
		echo $compare_currency;
	}
}

?>