<?php
/* 팝업 출력*/
function showDesignPopup($popup_seq)
{
	$CI =& get_instance();
	$CI->load->helper('javascript');


	// heavy 형이 아닐 경우 블락
	if($CI->config_system['operation_type'] == 'light') return;

	$template_path = $CI->__tmp_template_path ? $CI->__tmp_template_path : $CI->template_path;

	$popup_key = "designPopup{$popup_seq}";
	
	$query  = $CI->db->query("select * from fm_design_popup where popup_seq = ?",$popup_seq);
	$data = $query->row_array();

	if(!$data) return;
	if($data['popup_condition']){
		$CI->load->model('goodsmodel');
		$goods_seq = $_GET['no'];
		$code = $_GET['code'];
		$popup_condition = unserialize($data['popup_condition']);

		switch($_SERVER['REDIRECT_URL']){
			case "/goods/view" :
				switch($popup_condition['view']){
					case "category":
						$goods_category = $CI->goodsmodel->get_goods_category($goods_seq);
						if(!$goods_category) return;
						$category_view = array();
						foreach($goods_category as $category) $category_view[] = $category['category_code'];
						if(sizeOf(array_intersect($category_view,$popup_condition['issueCategoryViewCode']))<1) return;
					break;
					case "brand":
						$goods_brand = $CI->goodsmodel->get_goods_brand($goods_seq);
						if(!$goods_brand) return;
						$brand_view = array();
						foreach($goods_brand as $brand) $brand_view[] = $brand['category_code'];
						if(sizeOf(array_intersect($brand_view,$popup_condition['issueBrandViewCode']))<1) return;
					break;
					case "goods":
						if(!in_array($goods_seq,$popup_condition['issueGoods'])) return;
					break;
				}
			break;
			case "/goods/catalog" :
				if($popup_condition['category'] != 'all' && !in_array($code,$popup_condition['issueCategoryCode'])) return;
			break;
			case "/goods/brand" :
				if($popup_condition['brand'] != 'all' && !in_array($code,$popup_condition['issueBrandCode'])) return;
			break;
			case "/goods/location" :
				if($popup_condition['location'] != 'all' && !in_array($code,$popup_condition['issueLocationCode'])) return;
			break;
		}
	}


	$now_time = time();
	$flag = $data['status']=='show' || ($data['status']=='period' && $now_time >= strtotime($data['period_s']) && $now_time <= strtotime($data['period_e'])) ? true : false;
	if($CI->input->cookie($popup_key)) {
		if($CI->input->cookie($popup_key)=='1' || time()-$CI->input->cookie($popup_key) < 86400){
			$flag = false; //창숨김처리 쿠키 체크
		}
	}
	
	if($CI->layout->is_design_mode() && $CI->input->cookie('designEditMode')) {
		if($data['status']=='show' || ($data['status']=='period' && $now_time <= strtotime($data['period_e']))){
			$flag = true; //디자인편집모드일땐 무조건 팝업 보여주기
		}
	}

	if($data['style']=='band' && $flag){
		$ilineCss = "";
		if($data['band_background_image']){
			$ilineCss .= "background-image:url(/data/popup/{$data['band_background_image']});";
			if($data['band_background_image_repeat']) $ilineCss .= "background-repeat:{$data['band_background_image_repeat']};";
			if($data['band_background_image_position']) $ilineCss .= "background-position:{$data['band_background_image_position']};";
		}elseif($data['band_background_color']){
			$ilineCss .= "background-color:{$data['band_background_color']};";
		}

		$html .= "<div class='designPopupBand relative hide' popupStyle='band' designElement='popup' templatePath='{$template_path}' popupSeq='{$popup_seq}' style='{$ilineCss}'>";
		$html .= "<div class='designPopupBody center'>";

		if($data['link']){
			$target = "_self";
			if($data['open'] == 1) $target = "_blank";
			$html .= "<a href='{$data['link']}' target='{$target}'>";
		}
		$html .= "<img src='/data/popup/{$data['image']}' />";
		if($data['link']) $html .= "</a>";
		
		$html .= "</div>";
		$html .= "<div class='designPopupClose absolute hand' style='right:{$data['band_right']}px;top:{$data['band_top']}px;'><img src='/data/icon/common/etc/band_btn_close.gif' /></div>";
		$html .= "</div>";
		
		$openBtn = '';
		if($flag) $openBtn = ' hide';

		$html .= "<div class='designPopupBandBtn absolute center hand{$openBtn}' style='top:0px; left:50%; width:200px; margin-left:-100px;z-index:12'><img src='/data/icon/common/etc/band_btn_open.gif' /></div>";
		echo $html;	
	}	

	if($flag){
		$html = "";
		if($data['style']=='layer'){
			$border = '';
			if($data['contents_type'] == 'pc_style_3' || $data['contents_type'] == 'pc_style_5') $border = 'border:1px solid #dddddd;';
			$html .= "<div class='designPopup' popupStyle='layer' designElement='popup' templatePath='{$template_path}' popupSeq='{$popup_seq}' style='left:{$data['loc_left']}px;top:{$data['loc_top']}px;{$border}'>";
			
			if($data['contents_type']=='image'){
				$html .= "<div class='designPopupBody'>";

				if($data['link']){
					$target = "_self";
					if($data['open'] == 1) $target = "_blank";
					$html .= "<a href='{$data['link']}' target='{$target}'>";
				}

				$html .= "<img src='/data/popup/{$data['image']}' />";	
				if($data['link'])  $html .= "</a>";
			}else if($data['contents_type']=='text'){
				
				/* 플래시매직 치환 */
				if(preg_match_all("/\{[\s]*=[\s]*showDesignFlash[\s]*\([\s]*([0-9]+)[\s]*\)[\s]*\}/",$data['contents'],$matches)){
					$CI->template->include_('showDesignFlash');
					foreach($matches[0] as $idx=>$val){
						$flash_seq = $matches[1][$idx];
						$replaceContents = showDesignFlash($flash_seq,true,'cach');
						$data['contents'] = str_replace($val,$replaceContents,$data['contents']);
					}
				}
				
				$html .= "<div class='designPopupBody' style='width:{$data['width']}px;height:{$data['height']}px;background-color:#fff;'>";
				$html .= $data['contents'];				
			}else{
				$banner_seq = $data['popup_banner_seq'];

				$query  = $CI->db->query("select * from fm_design_popup_banner where banner_seq = ?",array($banner_seq));

				$banner = $query->row_array();

				$query  = $CI->db->query("select * from fm_design_popup_banner_item where banner_seq = ?",array($banner_seq));
				$banner_item = $query->result_array();

				if(!$banner) return;

				$popupHtml = "";

				$skin = $CI->designWorkingSkin;

				if(BANNER_SCRIPT_LOADED!==true){
					// 한페이지에 여러 배너 노출할 때 스크립트는 1회만 로드
					define("BANNER_SCRIPT_LOADED",true);
					$popupHtml .= "<script type='text/javascript' src='/app/javascript/jquery/jquery.ui.touch-punch.min.js'></script>";
					$popupHtml .= "<script type='text/javascript' src='/app/javascript/plugin/anibanner/jquery.anibanner.js?v=20140808'></script>";
					$popupHtml .= "<link rel='stylesheet' type='text/css' href='/app/javascript/plugin/anibanner/anibanner.css' />";
				}

				if($banner['navigation_paging_style']=='custom'){
					/* 이미지가로세로 크기 */
					@list($customImageWidth, $customImageHeight) = @getimagesize(ROOTPATH."data/popup/{$banner_item[0]['tab_image_inactive']}");
					$banner['navigation_paging_height'] = $customImageHeight;
				}

				$popupHtml .= "<div class='designBannerPopup' templatePath='{$template_path}' bannerSeq='{$banner_seq}' style='height:{$banner['height']}px;'></div>";

				$popupHtml .= "<script>";
				$popupHtml .= "$(function(){";
				$popupHtml .= "var settings = {";
				$popupHtml .= "'platform' : '{$banner['platform']}',";
				$popupHtml .= "'modtime' : '{$banner['modtime']}',";
				$popupHtml .= "'style' : '{$banner['style']}',";
				$popupHtml .= "'height' : '{$banner['height']}',";
				$popupHtml .= "'background_color' : '{$banner['background_color']}',";
				$popupHtml .= "'background_image' : '/data/popup/{$banner['background_image']}',";
				$popupHtml .= "'background_repeat' : '{$banner['background_repeat']}',";
				$popupHtml .= "'background_position' : '{$banner['background_position']}',";
				$popupHtml .= "'image_border_use' : '{$banner['image_border_use']}',";
				$popupHtml .= "'image_border_width' : '{$banner['image_border_width']}',";
				$popupHtml .= "'image_border_color' : '{$banner['image_border_color']}',";
				$popupHtml .= "'image_opacity_use' : '{$banner['image_opacity_use']}',";
				$popupHtml .= "'image_opacity_percent' : '{$banner['image_opacity_percent']}',";
				$popupHtml .= "'image_top_margin' : '{$banner['image_top_margin']}',";
				$popupHtml .= "'image_side_margin' : '{$banner['image_side_margin']}',";
				$popupHtml .= "'image_width' : '{$banner['image_width']}',";
				$popupHtml .= "'image_height' : '{$banner['image_height']}',";
				$popupHtml .= "'navigation_btn_style' : '{$banner['navigation_btn_style']}',";
				$popupHtml .= "'navigation_btn_visible' : '{$banner['navigation_btn_visible']}',";
				$popupHtml .= "'navigation_paging_style' : '{$banner['navigation_paging_style']}',";
				$popupHtml .= "'navigation_paging_height' : '{$banner['navigation_paging_height']}',";
				$popupHtml .= "'navigation_paging_align' : '{$banner['navigation_paging_align']}',";
				$popupHtml .= "'navigation_paging_position' : '{$banner['navigation_paging_position']}',";
				$popupHtml .= "'navigation_paging_margin' : '{$banner['navigation_paging_margin']}',";
				$popupHtml .= "'navigation_paging_spacing' : '{$banner['navigation_paging_spacing']}',";
				$popupHtml .= "'slide_event' : '{$banner['slide_event']}',";
				$popupHtml .= "'images' : [";
				foreach($banner_item as $k=>$item){
					if($k) $popupHtml .= ",";
					$popupHtml .= "{'link':'{$item['link']}','target':'{$item['target']}','image':'/data/popup/{$item['image']}'}";
				}
				$popupHtml .= "],";
				$popupHtml .= "'navigation_paging_custom_images' : [";
				foreach($banner_item as $k=>$item){
					if($k) $popupHtml .= ",";
					$popupHtml .= "{'active':'/data/popup/popup_banner/{$banner_seq}/{$item['tab_image_active']}','inactive':'/data/popup/popup_banner/{$banner_seq}/{$item['tab_image_inactive']}'}";
				}
				$popupHtml .= "]";
				$popupHtml .= "};";	
				$popupHtml .= "$('.designBannerPopup[bannerSeq=\"{$banner_seq}\"]').anibanner(settings);";
				$popupHtml .= "});";
				$popupHtml .= "</script>";

				$popupHeight = $banner['height'];
				$popupWidth = $banner['image_width'];

				if($banner['image_side_margin'] > 0) $popupWidth = $popupWidth+($banner['image_side_margin']*2);

				$html .= "<div class='designPopupBody' style='width:{$popupWidth}px;height:{$popupHeight}px;background-color:#fff;'>";
				$html .= $popupHtml;
			}

			$designPopupTodaymsgCss = font_decoration_attr($data['bar_msg_today_decoration'],'css','style');
			$designPopupCloseCss = font_decoration_attr($data['bar_msg_close_decoration'],'css','style');
			
			$html .= "</div>";
			$html .= "<div class='designPopupBar' style='background-color:{$data['bar_background_color']}'>";
			$html .= "<div class='designPopupTodaymsg' {$designPopupTodaymsgCss}><label><input type='checkbox' /> {$data['bar_msg_today_text']}</label></div>";
			$html .= "<div class='designPopupClose' {$designPopupCloseCss}>{$data['bar_msg_close_text']}</div>";
			$html .= "</div>";
			$html .= "</div>";
		}

		if($data['style']=='mobile_layer'){

			/* 이미지가로세로 크기 */
			@list($imgWidth, $imgHeight) = @getimagesize(ROOTPATH."data/popup/{$data['image']}");
			
			$html .= "<div class='designPopup' popupStyle='layer' designElement='popup' templatePath='{$template_path}' popupSeq='{$popup_seq}' style='top:{$data['loc_top']}px;'>";
			
			if($data['contents_type']=='image'){
				$html .= "<div class='designPopupBody'>";
				if($data['link']){
					$target = "_self";
					if($data['open'] == 1) $target = "_blank";
					$html .= "<a href='{$data['link']}' target='{$target}'>";
				}


				$html .= "<img src='/data/popup/{$data['image']}' width='{$imgWidth}' height='{$imgHeight}' />";	
				if($data['link'])  $html .= "</a>";
			}
			
			if($data['contents_type']=='text'){
				
				/* 플래시매직 치환 */
				if(preg_match_all("/\{[\s]*=[\s]*showDesignFlash[\s]*\([\s]*([0-9]+)[\s]*\)[\s]*\}/",$data['contents'],$matches)){
					$CI->template->include_('showDesignFlash');
					foreach($matches[0] as $idx=>$val){
						$flash_seq = $matches[1][$idx];
						$replaceContents = showDesignFlash($flash_seq,true,'cach');
						$data['contents'] = str_replace($val,$replaceContents,$data['contents']);
					}
				}
				
				$html .= "<div class='designPopupBody' style='width:{$data['width']}px;height:{$data['height']}px;background-color:#fff;'>";
				$html .= $data['contents'];				
			}		
			
			$designPopupTodaymsgCss = font_decoration_attr($data['bar_msg_today_decoration'],'css','style');
			$designPopupCloseCss = font_decoration_attr($data['bar_msg_close_decoration'],'css','style');
			
			$html .= "</div>";
			$html .= "<div class='designPopupBar' style='background-color:{$data['bar_background_color']}'>";
			$html .= "<div class='designPopupTodaymsg' {$designPopupTodaymsgCss}><label><input type='checkbox' /> {$data['bar_msg_today_text']}</label></div>";
			$html .= "<div class='designPopupClose' {$designPopupCloseCss}>{$data['bar_msg_close_text']}</div>";
			$html .= "</div>";
			$html .= "</div>";
		}
		
		if($data['style']=='window'){
			$html .= "<div class='designPopupIcon hide' designElement='popup' templatePath='{$template_path}' popupSeq='{$popup_seq}' style='border:3px dashed gray; left:{$data['loc_left']}px;top:{$data['loc_top']}px;'><span class='btn small red'><input type='button' value='팝업[{$popup_seq}] 설정' /></span></div>";
			
			if($data['contents_type']=='image'){
				$imagePath = ROOTPATH.'/data/popup/'.$data['image'];
				list($imageWidth,$imageHeight) = @getimagesize($imagePath);
				$popupWidth = $imageWidth;
				$popupHeight+=$imageHeight+25;
			}else if($data['contents_type']=='text'){
				$popupWidth = $data['width'];
				$popupHeight = $data['height']+25;
			}else{
				$query  = $CI->db->query("select * from fm_design_popup_banner where banner_seq = ?",array($data['popup_banner_seq']));
				$banner = $query->row_array();
				if(!$banner) return;
				$popupWidth = $banner['image_width'];
				$popupHeight = $banner['height']+25;

				if($banner['image_side_margin'] > 0) $popupWidth = $popupWidth+($banner['image_side_margin']*2);
			}
			
			$html .= js("window.open('/popup/designpopup?seq={$popup_seq}&popup_key={$popup_key}','{$popup_key}','width={$popupWidth},height={$popupHeight},left={$data['loc_left']},top={$data['loc_top']},resizable=no,toolbar=no,menubar=no,status=no,scrollbars=no');");
		}

		if($data['style']=='mobile_band'){
			$ilineCss = "";
			if($data['band_background_image']){
				$ilineCss .= "background-image:url(/data/popup/{$data['band_background_image']});";
				if($data['band_background_image_repeat']) $ilineCss .= "background-repeat:{$data['band_background_image_repeat']};";
				if($data['band_background_image_position']) $ilineCss .= "background-position:{$data['band_background_image_position']};";
			}elseif($data['band_background_color']){
				$ilineCss .= "background-color:{$data['band_background_color']};";
			}

			$html .= "<div class='designPopupBandMobile hide' popupStyle='band' designElement='popup' templatePath='{$template_path}' popupSeq='{$popup_seq}' style='position:relative; {$ilineCss}'>";
			$html .= "<div class='designPopupBody center'>";

			if($data['link']){
				$target = "_self";
				if($data['open'] == 1) $target = "_blank";
				$html .= "<a href='{$data['link']}' target='{$target}'>";
			}
			$html .= "<img src='/data/popup/{$data['image']}' style='max-width:100%' />";	
			if($data['link']) $html .= "</a>";

			$html .= "</div>";
			$html .= "<div class='designPopupClose absolute hand' style='right:{$data['band_right']}px;top:{$data['band_top']}px;'><img src='/data/icon/common/etc/band_btn_close.gif' /></div>";
			$html .= "</div>";
		}
		echo $html;	
	}
	return;
}
?>