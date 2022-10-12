<?php

/* 스크립트배너 출력*/
function showDesignBanner($banner_seq,$return=false)
{
	$CI =& get_instance();
	$template_path = $CI->__tmp_template_path ? $CI->__tmp_template_path : $CI->template_path;

	$CI->load->model('layout');
	if($return){
		$skin = $CI->designWorkingSkin;
	}else{
		$skin = $CI->layout->get_view_skin();
	}

	$query  = $CI->db->query("select * from fm_design_banner where skin=? and banner_seq = ?",array($skin,$banner_seq));
	$banner = $query->row_array();

	$query  = $CI->db->query("select * from fm_design_banner_item where skin=? and banner_seq = ?",array($skin,$banner_seq));
	$banner_item = $query->result_array();

	if(!$banner) return;

	$html = "";

	$html .= "<link rel='stylesheet' type='text/css' href='/app/javascript/plugin/anibanner/anibanner.css' />";
	$html .= "<style>";
	$html .= ".bx-wrapper{position:relative;}";
	$html .= ".bx-prev{position:absolute; left:0;}";
	$html .= ".bx-next{position:absolute; right:0;}";
	$html .= ".bx-navi a{display:block; width:100%; height:100%; cursor:pointer;}";
	$html .= "</style>";
	
	if($banner['navigation_paging_style']=='custom'){
		/* 이미지가로세로 크기 */
		@list($customImageWidth, $customImageHeight) = @getimagesize(ROOTPATH."data/skin/{$skin}/images/banner/{$banner_seq}/{$banner_item[0]['tab_image_inactive']}");
		$banner['navigation_paging_height'] = $customImageHeight;
	}

	if	($banner['image_height'] > $banner['height'])	$banner['height']	= $banner['image_height'];
	if	($banner['navigation_paging_position'] == 'bottom'){
		$banner['bottom_paging_area_size']	= $banner['navigation_paging_margin'];
		switch ($banner['navigation_paging_style']){
			case 'paging_style_1':	$banner['bottom_paging_area_size']	+= 13;	break;
			case 'paging_style_2':	$banner['bottom_paging_area_size']	+= 12;	break;
			case 'paging_style_3':	$banner['bottom_paging_area_size']	+= 5;	break;
			case 'paging_style_4':	$banner['bottom_paging_area_size']	+= 20;	break;
			case 'paging_style_5':	$banner['bottom_paging_area_size']	+= 30;	break;
			case 'custom':			$banner['bottom_paging_area_size']	+= $banner['navigation_paging_height'];	break;
		}
	}

	$slider_height = $banner['height'];
	$slider_width = $banner['image_width'];
	$image_height = $banner['image_height'];
	$ul_style = "";
	$div_style = "";
	$img_style = "";

	if($banner['background_color']){
		$div_style .= "background-color:{$banner['background_color']};";
	}

	if($banner['background_image']){
		$div_style .= "background-image:url(/data/skin/{$skin}/{$banner['background_image']});";
	}

	if($banner['background_repeat']){
		$div_style .= "background-repeat:{$banner['background_repeat']};";
	}

	if($banner['background_position']){
		$div_style .= "background-position:{$banner['background_position']};";
	}

	if($banner['navigation_paging_margin']){
		$div_style .= "margin-bottom:{$banner['navigation_paging_margin']}px;";
	}

	if($banner['image_opacity_use'] == "y"){
		$opNum = 1 - ($banner['image_opacity_percent']/100);
		$img_style .= "opacity:{$opNum};";
	}

	switch ($banner['style']){
		case 'pc_style_1':
			$query  = $CI->db->query("select value from fm_config_layout where skin=? AND tpl_folder =  'basic'",array($skin));
			$basic_info = $query->result_array();
			$basic_info = unserialize($basic_info[0]['value']);
			$slider_width = $basic_info['width'];

			$img_default = 3;
			$img_min = floor($slider_width/($banner['image_width']+$banner['image_side_margin']));

			if($img_min < $img_default){
				if($img_min > 1){
					$img_default = $img_min - 1;
				} else {
					$img_default = 1;
				}
			}
			
			$banner_width	= ($banner['image_width'] * $img_default) + ($banner['image_side_margin'] * ($img_default + 1));

			if( $banner_width >= $slider_width ) {
				$left_fix		= ($slider_width - $banner_width)/2;
				$banner_width	= $slider_width;
				$margin_side	= 0;
			} else {
				$margin_side	= ($slider_width - $banner_width)/2;
				$left_fix		= 0;
			}

			if($banner['image_top_margin'] > 0){
				$margin_top = "padding-top: {$banner['image_top_margin']}px;";
			} else {
				$margin_top = "";
			}

			$imgHTML .= "<div id='bnr_slider_{$banner_seq}' style='{$margin_top} width:{$slider_width}px;'>";
			$imgHTML .= "<ul style='position:relative; margin-left:{$margin_side}px; margin-right:{$margin_side}px; left:{$left_fix}px;'>";

			if(count($banner_item)%$img_default == 0){
				$max_slides = count($banner_item);
				foreach($banner_item as $k => $ban){
					$data_index = $k+1;
					$imgHTML .= "<li class='li_{$banner_seq}_{$data_index}' style='float:left; list-style:none; position:absolute; cursor:pointer; margin-left:{$banner['image_side_margin']}px;'><a href='{$ban['link']}' target='{$ban['target']}'><img src='/data/skin/{$ban['skin']}/{$ban['image']}' style='{$img_style}' />";
					
					if($banner['image_border_use'] == "y"){
						$imgHTML .= "<span class='border_line' style='display:none; position:absolute; top:0; left:0; width:{$banner['image_width']}px; height:{$banner['image_height']}px; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; border: {$banner['image_border_width']}px solid {$banner['image_border_color']};'></span>";
					}
					$imgHTML .= "</a></li>";
				}
			} else {
				$max_slides = count($banner_item) * $img_default;
				for($i=0; $i<$img_default; $i++){
					foreach($banner_item as $k => $ban){
						$data_index = ($k+1)+($i*count($banner_item));
						$imgHTML .= "<li class='li_{$banner_seq}_{$data_index}' style='float: left; list-style: none; position: absolute; cursor:pointer; margin-left: {$banner['image_side_margin']}px;'><a href='{$ban['link']}' target='{$ban['target']}'><img src='/data/skin/{$ban['skin']}/{$ban['image']}' style='{$img_style}' />";
						
						if($banner['image_border_use'] == "y"){
							$imgHTML .= "<span class='border_line' style='display:none; position:absolute; top:0; left:0; width:{$banner['image_width']}px; height:{$banner['image_height']}px; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; border: {$banner['image_border_width']}px solid {$banner['image_border_color']};'></span>";
						}
						$imgHTML .= "</a></li>";
					}
				}
			}

			$imgHTML .= "</ul>";

			if($banner['navigation_btn_style']){
				switch ($banner['navigation_btn_style']){
					case 'btn_style_1':	$btn_top = (($banner['image_height']/2) - 36) + $banner['image_top_margin'];	break;
					case 'btn_style_2':	$btn_top = (($banner['image_height']/2) - 31) + $banner['image_top_margin'];	break;
					case 'btn_style_3':	$btn_top = (($banner['image_height']/2) - 39) + $banner['image_top_margin'];	break;
					case 'btn_style_4':	$btn_top = (($banner['image_height']/2) - 31) + $banner['image_top_margin'];	break;
				}

				if($banner['navigation_btn_visible'] == "mouseover"){
					$hidden = "display:none;";
				}

				switch ($banner['navigation_btn_style']){
					case 'btn_style_1':	if($margin_side > 26){ $pager_width = $banner_width + 52; $pager_left = ($slider_width - $pager_width )/2; }else{ $pager_width = $slider_width; $pager_left = 0; } break;
					case 'btn_style_2':	if($margin_side > 21){ $pager_width = $banner_width + 42; $pager_left = ($slider_width - $pager_width )/2; }else{ $pager_width = $slider_width; $pager_left = 0; } break;
					case 'btn_style_3':	if($margin_side > 14){ $pager_width = $banner_width + 28; $pager_left = ($slider_width - $pager_width )/2; }else{ $pager_width = $slider_width; $pager_left = 0; } break;
					case 'btn_style_4':	if($margin_side > 22){ $pager_width = $banner_width + 44; $pager_left = ($slider_width - $pager_width )/2; }else{ $pager_width = $slider_width; $pager_left = 0; } break;
				}
				
				$imgHTML .= "<div id='bx-pager-{$banner_seq}' style='position:absolute; top:{$btn_top}px; left: {$pager_left}px; width:{$pager_width}px; {$hidden}'>";
				$imgHTML .= "<a href='' class='bx-prev anibanner_navigation_btn_prev anibanner_navigation_{$banner['navigation_btn_style']}_prev'></a>";
				$imgHTML .= "<a href='' class='bx-next anibanner_navigation_btn_next anibanner_navigation_{$banner['navigation_btn_style']}_next'></a>";
				$imgHTML .= "</div>";
			}
			$imgHTML .= "</div>";

			$div_style .= "width:{$slider_width}px; height:{$slider_height}px;";
		break;
		case 'mobile_style_1':
			$img_default = 1;
			$img_min = 1;
			$margin_side = 0;
			
			$slider_width = "100%";
			$banner_width = "100%";

			if($banner['image_top_margin'] > 0){
				$padding_top = "padding-top: {$banner['image_top_margin']}px;";
			} else {
				$padding_top = "";
			}

			$imgHTML .= "<div id='bnr_slider_{$banner_seq}' style='{$padding_top} width:{$slider_width};'>";
			$imgHTML .= "<ul style='position:relative;'>";

			foreach($banner_item as $k => $ban){
				$data_index = $k+1;
				$imgHTML .= "<li class='li_{$banner_seq}_{$data_index}' style='float:left; list-style:none; position:absolute; cursor:pointer;'><a href='{$ban['link']}' target='{$ban['target']}'><img src='/data/skin/{$ban['skin']}/{$ban['image']}' style='{$img_style}' />";
				
				if($banner['image_border_use'] == "y"){
					$imgHTML .= "<span class='border_line' style='display:none; position:absolute; top:0; left:0; width:{$banner['image_width']}px; height:{$banner['image_height']}px; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; border: {$banner['image_border_width']}px solid {$banner['image_border_color']};'></span>";
				}
				$imgHTML .= "</a></li>";
			}

			$imgHTML .= "</ul>";

			if($banner['navigation_btn_style']){
				$btn_top = (($banner['image_height']/2) - 20) + $banner['image_top_margin'];

				if($banner['navigation_btn_visible'] == "mouseover"){
					$hidden = "display:none;";
				}

				switch ($banner['navigation_btn_style']){
					case 'btn_style_1':	$pager_width = $banner['image_width'] + ($banner['image_side_margin']*2) + 30;	break;
					case 'btn_style_2':	$pager_width = $banner['image_width'] + ($banner['image_side_margin']*2) + 30;	break;
					case 'btn_style_3':	$pager_width = $banner['image_width'] + ($banner['image_side_margin']*2) + 14;	break;
					case 'btn_style_4':	$pager_width = $banner['image_width'] + ($banner['image_side_margin']*2) + 16;	break;
				}
	
				$imgHTML .= "<div id='bx-pager-{$banner_seq}' style='position:absolute; display:inline; top:{$btn_top}px; left: 50%; width:{$pager_width}px; transform: translate(-50%, -50%); {$hidden}'>";
				$imgHTML .= "<a href='' class='bx-prev anibanner_navigation_btn_prev anibanner_navigation_{$banner['navigation_btn_style']}_prev'></a>";
				$imgHTML .= "<a href='' class='bx-next anibanner_navigation_btn_next anibanner_navigation_{$banner['navigation_btn_style']}_next'></a>";
				$imgHTML .= "</div>";
			}
			$imgHTML .= "</div>";

			if($banner['navigation_paging_style']){
	
				if($banner['navigation_paging_align'] == "center"){
					$navi_width = "width:100%;";
					$margin = 0;
				} else {
					$navi_location = $banner['navigation_paging_align'].":0;";
					$navi_location .= "margin-top:".$banner['navigation_paging_margin']."px;";
				}

				$imgHTML .= "<div id='bx-navi-{$banner_seq}' style='position:absolute;text-align:center;{$navi_width}{$navi_location}'>";
				$imgHTML .= "<ul class='bx-navi anibanner_navigation_{$banner['navigation_paging_style']}'>";

				if( $banner['style'] == "pc_style_4" || $banner['style'] == "pc_style_5" ){
					foreach($banner_item as $k => $item){
						if($k == 0){
							$class_name		= "current";
							$left_margin	= "";
						} else {
							$class_name		= "";
							$left_margin	= "margin-left:{$banner['navigation_paging_spacing']}px;";
						}

						$imgHTML .= "<li class='{$class_name}' style='{$left_margin}'><a data-slide-index='{$k}' href=''><img src='/data/skin/{$skin}/images/banner/{$banner_seq}/{$item['tab_image_inactive']}' class='inactiveImg'><img src='/data/skin/{$skin}/images/banner/{$banner_seq}/{$item['tab_image_active']}' class='activeImg'></a></li>";
					}
				} else {
					if($banner['navigation_paging_style']  == "paging_style_1" || $banner['navigation_paging_style']  == "paging_style_2" || $banner['navigation_paging_style']  == "paging_style_3"){
						foreach($banner_item as $k => $ban){
							$imgHTML .= "<li><a data-slide-index='{$k}' href=''></a></li>";
						}
					} else {
						$imgHTML .= "<li class='paging_btn_prev'></li>";
						$imgHTML .= "<li class='paging_btn_body'><span class='paging_btn_num_now'>1</span>/<span class='paging_btn_num_max'>".count($banner_item)."</span></li>";
						$imgHTML .= "<li class='paging_btn_next'></li>";
					}
				}

				$imgHTML .= "</ul>";
				$imgHTML .= "</div>";
			}

			$div_style .= "width:100%; height:100%;";
		break;
		case 'pc_style_2':
		case 'pc_style_3':
		case 'pc_style_4':
		case 'pc_style_5':
		case 'mobile_style_2':
		case 'mobile_style_3':

			if($banner['image_top_margin'] > 0){
				$slider_height += $banner['image_top_margin'] * 2;
				$ul_style .= "padding-top:{$banner['image_top_margin']}px; padding-bottom:{$banner['image_top_margin']}px;";
			}

			if($banner['image_side_margin'] > 0){
				$slider_width += $banner['image_side_margin'] * 2;
				$ul_style .= "padding-left:{$banner['image_side_margin']}px; padding-right:{$banner['image_side_margin']}px;";
			}

			if($banner['style'] == "mobile_style_2" || $banner['style'] == "mobile_style_3"){
				//$min_height = "min-height: 100vh;";
				$img_style .= "width:100%;";
			}

			$imgHTML = "<div id='bnr_slider_{$banner_seq}'>";
			$imgHTML .= "<ul style='position: relative;'>";
			foreach($banner_item as $ban){
				$imgHTML .= "<li style='float: left; list-style: none; position: absolute; cursor:pointer;{$min_height}'><a href='{$ban['link']}' target='{$ban['target']}'><img src='/data/skin/{$ban['skin']}/{$ban['image']}' style='{$ul_style}{$img_style}' />";
				
				if($banner['image_border_use'] == "y"){
					$imgHTML .= "<span class='border_line' style='display:none; position:absolute; top:{$banner['image_top_margin']}px; left:{$banner['image_side_margin']}px; width:{$banner['image_width']}px; height:{$banner['image_height']}px; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; border: {$banner['image_border_width']}px solid {$banner['image_border_color']}; {$ul_style}'></span>";
				}
				$imgHTML .= "</a></li>";
			}
			$imgHTML .= "</ul>";

			if($banner['navigation_btn_style']){
				if($banner['navigation_btn_visible'] == "mouseover"){
					$hidden = "display:none;";
				}

				if($banner['style'] == "mobile_style_2" || $banner['style'] == "mobile_style_3"){
					$btn_height = 40;

					$imgHTML .= "<div id='bx-pager-{$banner_seq}' style='position:absolute; top:50%; left:0; width:100%; height:{$btn_height}px; transform: translate(0, -50%); {$hidden}'>";
				} else {
					switch ($banner['navigation_btn_style']){
						case 'btn_style_1':	$btn_height = 72;	break;
						case 'btn_style_2':	$btn_height = 62;	break;
						case 'btn_style_3':	$btn_height = 87;	break;
						case 'btn_style_4':	$btn_height = 62;	break;
					}

					$imgHTML .= "<div id='bx-pager-{$banner_seq}' style='position:absolute; top:50%; left:0; width:{$slider_width}px; height:{$btn_height}px; transform: translate(0, -50%); {$hidden}'>";
				}

				$imgHTML .= "<a href='' class='bx-prev anibanner_navigation_btn_prev anibanner_navigation_{$banner['navigation_btn_style']}_prev'></a>";
				$imgHTML .= "<a href='' class='bx-next anibanner_navigation_btn_next anibanner_navigation_{$banner['navigation_btn_style']}_next'></a>";
				$imgHTML .= "</div>";
			}
			$imgHTML .= "</div>";

			if($banner['navigation_paging_style']){
				$navialign = 0;
				$margin = $banner['navigation_paging_margin'];

				if($banner['navigation_paging_position'] == "bottom"){
					$bottom_margin = "margin-top:{$banner['navigation_paging_margin']}px;";
				} else {
					$bottom_margin = "bottom:{$banner['navigation_paging_margin']}px;";
				}
				
				if($banner['navigation_paging_align'] == "center"){
					$navi_width = "width:100%;";
					$margin = 0;
				} else {
					switch ($banner['navigation_paging_style']){
						case 'paging_style_1':	$navialign = ($banner['image_width']/2) - (((count($banner_item)*13) + ((count($banner_item)-1)*8))/2);	break;
						case 'paging_style_2':	$navialign = ($banner['image_width']/2) - (((count($banner_item)*12) + ((count($banner_item)-1)*8))/2);	break;
						case 'paging_style_3':	$navialign = ($banner['image_width']/2) - ((count($banner_item)*30)/2);	break;
						case 'paging_style_4':	$navialign = ($banner['image_width']/2) - 55;	break;
						case 'paging_style_5':	$navialign = ($banner['image_width']/2) - 47;	break;
					}

					$navi_location = $banner['navigation_paging_align'].":".$navialign."px;";
				}


				$imgHTML .= "<div id='bx-navi-{$banner_seq}' style='position:absolute;{$bottom_margin}margin-right:{$margin}px;margin-left:{$margin}px;{$navi_width}{$navi_location}'>";
				$imgHTML .= "<ul class='bx-navi anibanner_navigation_{$banner['navigation_paging_style']}'>";

				if( $banner['style'] == "pc_style_4" || $banner['style'] == "pc_style_5" ){
					foreach($banner_item as $k => $item){
						if($k == 0){
							$class_name		= "current";
							$left_margin	= "";
						} else {
							$class_name		= "";
							$left_margin	= "margin-left:{$banner['navigation_paging_spacing']}px;";
						}

						$imgHTML .= "<li class='{$class_name}' style='{$left_margin}'><a data-slide-index='{$k}' href=''><img src='/data/skin/{$skin}/images/banner/{$banner_seq}/{$item['tab_image_inactive']}' class='inactiveImg'><img src='/data/skin/{$skin}/images/banner/{$banner_seq}/{$item['tab_image_active']}' class='activeImg'></a></li>";
					}
				} else {
					if($banner['navigation_paging_style']  == "paging_style_1" || $banner['navigation_paging_style']  == "paging_style_2" || $banner['navigation_paging_style']  == "paging_style_3"){
						foreach($banner_item as $k => $ban){
							$imgHTML .= "<li><a data-slide-index='{$k}' href=''></a></li>";
						}
					} else {
						$imgHTML .= "<li class='paging_btn_prev'></li>";
						$imgHTML .= "<li class='paging_btn_body'><span class='paging_btn_num_now'>1</span>/<span class='paging_btn_num_max'>".count($banner_item)."</span></li>";
						$imgHTML .= "<li class='paging_btn_next'></li>";
					}
				}

				$imgHTML .= "</ul>";
				$imgHTML .= "</div>";
			}

			if($banner['style'] != "mobile_style_2" && $banner['style'] != "mobile_style_3"){
				$div_style .= "width:{$slider_width}px; height:{$slider_height}px;";
			}

		break;
		default:
			$imgHTML	= '';
		break;
	}

	$html .= "<div class='designBanner' designElement='banner' templatePath='{$template_path}' bannerSeq='{$banner_seq}' style='position:relative; {$div_style}'>" . $imgHTML . "</div>";

	$html .= "<script>";
	
	$option = "pause: 3500, controls: false";
	$funcBefore = "";
	$funcAfter = "";
	$funcLoad = "";

	if($banner['slide_event'] == 'auto'){
		$option .= ", auto: true, autoHover: true";
	}

	if($banner['style'] == "pc_style_1"){
		$option		.= ", slideWidth: {$banner['image_width']}, minSlides: {$img_min}, maxSlides: {$max_slides}, moveSlides: {$img_default}";

		$funcBefore .= " $('*[class^=li_{$banner_seq}] img').css('opacity', '1'); $('*[class^=li_{$banner_seq}]').css('background-color', ''); ";

		$funcAfter	.= "var exceptions = ''; var exceptions_img = ''; var current = parseInt(slider{$banner_seq}.getCurrentSlide()+1); var nextNum = parseInt((current*{$img_default})); var preNum = parseInt((current*{$img_default})-{$img_default}) + 1; for(var i=preNum; i<=nextNum; i++){ exceptions = exceptions + ',  .li_{$banner_seq}_' + i; exceptions_img = exceptions_img + ',  .li_{$banner_seq}_' + i + ' img'; $('.li_{$banner_seq}_' + i + ' img').css('opacity', '1'); } $('*[class^=li_{$banner_seq}] img').not(exceptions_img).css('opacity', '0.5'); $('*[class^=li_{$banner_seq}]').not(exceptions).css('background-color', 'rgb(0, 0, 0)');";

		$funcLoad .= "var exceptions = ''; var exceptions_img = ''; for(var i=1; i<=3; i++){ exceptions = exceptions + ',  .li_{$banner_seq}_' + i; exceptions_img = exceptions_img + ',  .li_{$banner_seq}_' + i + ' img'; } $('*[class^=li_{$banner_seq}]').not(exceptions).css('background-color', 'rgb(0, 0, 0)'); $('*[class^=li_{$banner_seq}] img').not(exceptions_img).css('opacity', '0.5'); ";
	}

	if($banner['style'] == "mobile_style_1"){
		$marginSide = $banner['image_side_margin'];
		$option .= ", slideWidth: 230, minSlides: 1, maxSlides: 1, moveSlides: 1, slideMargin:{$marginSide}";

		$funcLoad = "var windowWidth = $(window).width(); $('.bx-wrapper').css({'max-width': windowWidth + 'px'}); $('.bx-wrapper').css({'display': 'inline-block'}); $('.bx-viewport').css({'overflow': 'visible'}); var imgWidth = parseInt($('#bnr_slider_{$banner_seq} img').width() + 10); var maxWidth = imgWidth + {$marginSide}; $('.bx-wrapper').css({'max-width': maxWidth + 'px', 'margin-left': parseInt({$marginSide}*2) + 'px'}); $('.designBanner[bannerSeq=\"".$banner_seq."\"]').css({'padding-bottom': parseInt({$banner['navigation_paging_margin']} + {$banner['bottom_paging_area_size']}) + 'px'});";
	}

	if($banner['image_border_use'] == "y"){
		$funcLoad .= "$('.designBanner[bannerSeq=\"".$banner_seq."\"] ul li a').hover( function(){ $(this).find('span').fadeIn(80); }, function(){ $(this).find('span').fadeOut(80); } ) }, function(){ $('#bx-navi-{$banner_seq} ul li a').hover( function(){ var index = $(this).attr('data-slide-index'); slider{$banner_seq}.goToSlide(index); }); ";
	}

	if( $banner['style'] == "pc_style_4" || $banner['style'] == "pc_style_5" ){
		$option		.= ", pagerCustom: '#bx-navi-{$banner_seq}'";
		$funcBefore .= " var current = parseInt(slider{$banner_seq}.getCurrentSlide()+1); $( '#bx-navi-{$banner_seq} ul li' ).attr('class', ''); $( '#bx-navi-{$banner_seq} ul li:nth-child('+current+')' ).attr('class', 'current'); ";
	}else{
		if($banner['navigation_paging_style']  == "paging_style_1" || $banner['navigation_paging_style']  == "paging_style_2" || $banner['navigation_paging_style']  == "paging_style_3"){
			$option		.= ", pagerCustom: '#bx-navi-{$banner_seq}'";
		}else if($banner['navigation_paging_style']  == "paging_style_4" || $banner['navigation_paging_style']  == "paging_style_5"){
			$option		.= ", pager:false";
			$funcBefore .= " $('.paging_btn_num_now').html( slider{$banner_seq}.getCurrentSlide()+1 ); ";
		} else {
			$option		.= ", pager:false";
		}

		if($banner['navigation_paging_style']  == "paging_style_4" || $banner['navigation_paging_style']  == "paging_style_5"){
			$html .= "$('#bx-navi-{$banner_seq} .paging_btn_prev').on('click', function(){var current = slider{$banner_seq}.getCurrentSlide(); slider{$banner_seq}.goToPrevSlide(current) - 1;});";
			$html .= "$('#bx-navi-{$banner_seq} .paging_btn_next').on('click', function(){var current = slider{$banner_seq}.getCurrentSlide(); slider{$banner_seq}.goToNextSlide(current) + 1;});";
		}
	}

	if($banner['navigation_btn_style']){
		$html .= "$('#bx-pager-{$banner_seq} .bx-prev').on('click', function(){var current = slider{$banner_seq}.getCurrentSlide(); slider{$banner_seq}.goToPrevSlide(current) - 1;return false;});";
		$html .= "$('#bx-pager-{$banner_seq} .bx-next').on('click', function(){var current = slider{$banner_seq}.getCurrentSlide(); slider{$banner_seq}.goToNextSlide(current) + 1;return false;});";

		if($banner['navigation_btn_visible'] == "mouseover"){
			$html .= "$('.designBanner[bannerSeq=\"".$banner_seq."\"]').hover( function(){ $('#bx-pager-{$banner_seq}').fadeIn(); }, function(){ $('#bx-pager-{$banner_seq}').fadeOut(); });";
		}
	}

	if($banner['style'] == "mobile_style_2"){
		$funcRe = "var windowWidth = $(window).width(), windowHeight = $('#bnr_slider_{$banner_seq} img').height(), adjHeight = windowHeight;	$('#bnr_slider_{$banner_seq}').css({'width': windowWidth + 'px', 'height': adjHeight + 'px'}); var spanHeight = $('#bnr_slider_{$banner_seq} img').height(); $('#bnr_slider_{$banner_seq} ul li span').css({'width': windowWidth + 'px', 'height': spanHeight + 'px'});";
		$html .= $funcRe." $(window).resize(function() {".$funcRe."});";
	}

	if($banner['style'] == "mobile_style_3"){
		$margin_top = $banner['image_top_margin'] * 2;
		$margin_side = $banner['image_side_margin'] * 2;

		$funcRe = "var windowWidth = $(window).width(), windowHeight = $('#bnr_slider_{$banner_seq} img').height(), adjHeight = windowHeight;	$('#bnr_slider_{$banner_seq}').css({'width': windowWidth + 'px', 'height': parseInt(adjHeight + {$margin_top}) + 'px'}); $('#bnr_slider_{$banner_seq} ul li img').css({'width': parseInt(windowWidth - {$margin_side}) + 'px', 'height': '100%'}); var spanHeight = $('#bnr_slider_{$banner_seq} img').height(); $('#bnr_slider_{$banner_seq} ul li span').css({'width': parseInt(windowWidth - {$margin_side}) + 'px', 'height': spanHeight + 'px'});";
		
		$html .= $funcRe." $(window).resize(function() {".$funcRe."});";
	}

	if($funcBefore){
		$funcBefore = ", onSlideBefore: function(){ " . $funcBefore . " } ";
	}

	if($funcAfter){
		$funcAfter	= ", onSlideAfter: function(){ " . $funcAfter . " } ";
	}

	if($funcLoad){
		$funcLoad	= ", onSliderLoad: function(){ " . $funcLoad . " } ";
	}

	$html .= "var slider{$banner_seq} = $('#bnr_slider_{$banner_seq} ul').bxSlider({".$option.$funcBefore.$funcAfter.$funcLoad."});";

	$html .= "</script>";

	if($return) return $html;
	else echo $html;

	return;

}
?>