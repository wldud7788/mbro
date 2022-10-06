<?php /* Template_ 2.2.6 2022/09/15 17:42:15 /www/music_brother_firstmall_kr/app/javascript/plugin/editor/_editor.html 000023628 */ ?>
<!-- 에디터 컨테이너 시작 -->
<div id="tx_trex_container<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-editor-container">
	<!-- 툴바 - 기본 시작 --><!--
	@decsription
	툴바 버튼의 그룹핑의 변경이 필요할 때는 위치(왼쪽, 가운데, 오른쪽) 에 따라 <li> 아래의 <div>의 클래스명을 변경하면 된다.
	tx-btn-lbg: 왼쪽, tx-btn-bg: 가운데, tx-btn-rbg: 오른쪽, tx-btn-lrbg: 독립적인 그룹
	드롭다운 버튼의 크기를 변경하고자 할 경우에는 넓이에 따라 <li> 아래의 <div>의 클래스명을 변경하면 된다.
	tx-slt-70bg, tx-slt-59bg, tx-slt-42bg, tx-btn-43lrbg, tx-btn-52lrbg, tx-btn-57lrbg, tx-btn-71lrbg
	tx-btn-48lbg, tx-btn-48rbg, tx-btn-30lrbg, tx-btn-46lrbg, tx-btn-67lrbg, tx-btn-49lbg, tx-btn-58bg, tx-btn-46bg, tx-btn-49rbg
	-->
	<div id="tx_toolbar_basic<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-toolbar tx-toolbar-basic" onmouseover="Editor.switchEditor('<?php echo $TPL_VAR["params"]['initializedId']?>');" onmouseenter="Editor.switchEditor('<?php echo $TPL_VAR["params"]['initializedId']?>');">
		<div class="tx-toolbar-boundary">
			<ul class="tx-bar tx-bar-left">
				<li class="tx-list">
					<div id="tx_fontfamily<?php echo $TPL_VAR["params"]['initializedId']?>" unselectable="on" class="tx-slt-70bg tx-fontfamily">
						<a href="javascript:;" title="글꼴">굴림</a>
					</div>
					<div id="tx_fontfamily_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-fontfamily-menu tx-menu" unselectable="on">
					</div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-left">
				<li class="tx-list">
					<div unselectable="on" class="tx-slt-42bg tx-fontsize" id="tx_fontsize<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" title="글자크기">9pt</a>
					</div>
					<div id="tx_fontsize_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-fontsize-menu tx-menu" unselectable="on">
					</div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-left tx-group-font">
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-lbg tx-bold" id="tx_bold<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="굵게 (Ctrl+B)">굵게</a>
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-bg tx-underline" id="tx_underline<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="밑줄 (Ctrl+U)">밑줄</a>
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-bg tx-italic" id="tx_italic<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="기울임 (Ctrl+I)">기울임</a>
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-bg tx-strike" id="tx_strike<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="취소선 (Ctrl+D)">취소선</a>
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="		 tx-slt-tbg tx-forecolor" id="tx_forecolor<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="글자색">글자색</a>
						<a href="javascript:;" class="tx-arrow" title="글자색 선택">글자색 선택</a>
					</div>
					<div id="tx_forecolor_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-menu tx-forecolor-menu tx-colorpallete" unselectable="on">
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="		 tx-slt-brbg tx-backcolor" id="tx_backcolor<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="글자 배경색">글자 배경색</a>
						<a href="javascript:;" class="tx-arrow" title="글자 배경색 선택">글자 배경색 선택</a>
					</div>
					<div id="tx_backcolor_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-menu tx-backcolor-menu tx-colorpallete" unselectable="on">
					</div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-left tx-group-align">
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-lbg tx-alignleft" id="tx_alignleft<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="왼쪽정렬 (Ctrl+,)">왼쪽정렬</a>
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-bg tx-aligncenter" id="tx_aligncenter<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="가운데정렬 (Ctrl+.)">가운데정렬</a>
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-bg tx-alignright" id="tx_alignright<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="오른쪽정렬 (Ctrl+/)">오른쪽정렬</a>
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-rbg tx-alignfull" id="tx_alignfull<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="양쪽정렬">양쪽정렬</a>
					</div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-left tx-group-tab">
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-lbg tx-indent" id="tx_indent<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" title="들여쓰기 (Tab)" class="tx-icon">들여쓰기</a>
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-rbg tx-outdent" id="tx_outdent<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" title="내어쓰기 (Shift+Tab)" class="tx-icon">내어쓰기</a>
					</div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-left tx-group-list">
				<li class="tx-list">
					<div unselectable="on" class="tx-slt-31lbg tx-lineheight" id="tx_lineheight<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="줄간격">줄간격</a>
						<a href="javascript:;" class="tx-arrow" title="줄간격">줄간격 선택</a>
					</div>
					<div id="tx_lineheight_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-lineheight-menu tx-menu" unselectable="on">
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-slt-31rbg tx-styledlist" id="tx_styledlist<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="리스트">리스트</a>
						<a href="javascript:;" class="tx-arrow" title="리스트">리스트 선택</a>
					</div>
					<div id="tx_styledlist_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-styledlist-menu tx-menu" unselectable="on">
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-bg 	tx-link" id="tx_link<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="링크 (Ctrl+K)">링크</a>
					</div>
					<div id="tx_link_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-link-menu tx-menu"></div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-bg tx-table" id="tx_table<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="표만들기">표만들기</a>
					</div>
					<div id="tx_table_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-table-menu tx-menu" unselectable="on">
						<div class="tx-menu-inner">
							<div class="tx-menu-preview">
							</div>
							<div class="tx-menu-rowcol">
							</div>
							<div class="tx-menu-deco">
							</div>
							<div class="tx-menu-enter">
							</div>
						</div>
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-rbg tx-horizontalrule" id="tx_horizontalrule<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="구분선">구분선</a>
					</div>
					<div id="tx_horizontalrule_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-horizontalrule-menu tx-menu" unselectable="on"></div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-left">
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-lbg tx-richtextbox" id="tx_richtextbox<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="글상자">글상자</a>
					</div>
					<div id="tx_richtextbox_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-richtextbox-menu tx-menu">
						<div class="tx-menu-header">
							<div class="tx-menu-preview-area">
								<div class="tx-menu-preview">
								</div>
							</div>
							<div class="tx-menu-switch">
								<div class="tx-menu-simple tx-selected">
									<a><span>간단 선택</span></a>
								</div>
								<div class="tx-menu-advanced">
									<a><span>직접 선택</span></a>
								</div>
							</div>
						</div>
						<div class="tx-menu-inner">
						</div>
						<div class="tx-menu-footer">
							<img class="tx-menu-confirm" src="/app/javascript/plugin/editor/images/icon/editor/btn_confirm.gif?rv=1.0.1" alt=""/><img class="tx-menu-cancel" hspace="3" src="/app/javascript/plugin/editor/images/icon/editor/btn_cancel.gif?rv=1.0.1" alt=""/>
						</div>
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-rbg tx-quote" id="tx_quote<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="인용구 (Ctrl+Q)">인용구</a>
					</div>
					<div id="tx_quote_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-quote-menu tx-menu" unselectable="on">
					</div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-left tx-group-undo">
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-lbg tx-undo" id="tx_undo<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="실행취소 (Ctrl+Z)">실행취소</a>
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-rbg tx-redo" id="tx_redo<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="다시실행 (Ctrl+Y)">다시실행</a>
					</div>
				</li>
			</ul>

			<ul class="tx-bar tx-bar-left tx-nav-attach">
				<!-- 이미지 첨부 버튼 시작 --><!--
				@decsription
				<li></li> 단위로 위치를 이동할 수 있다.
				-->
				<li class="tx-list">
<?php if($TPL_VAR["params"]['board_id']){?>
<?php if(!strstr($_SERVER['HTTP_REFERER'],"manager_write")){?>
<?php if($TPL_VAR["params"]['file_use']=='Y'){?>
								<div unselectable="on" id="tx_file<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-file tx-btn-trans hide1"  onmouseover="Editor.switchEditor('<?php echo $TPL_VAR["params"]['initializedId']?>');" onmouseenter="Editor.switchEditor('<?php echo $TPL_VAR["params"]['initializedId']?>');">
									<a href="javascript:;" title="파일" class="tx-text">파일</a>
								</div>
<?php }elseif($TPL_VAR["params"]['file_use']=='img'){?>
								<div unselectable="on" id="tx_image<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-image tx-btn-trans hide1"  onmouseover="Editor.switchEditor('<?php echo $TPL_VAR["params"]['initializedId']?>');" onmouseenter="Editor.switchEditor('<?php echo $TPL_VAR["params"]['initializedId']?>');">
									<a href="javascript:;" title="사진" class="tx-text">사진</a>
								</div>
<?php }?>
<?php }?>
<?php }else{?> 
						<div unselectable="on" id="tx_image<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-image tx-btn-trans hide1"  onmouseover="Editor.switchEditor('<?php echo $TPL_VAR["params"]['initializedId']?>');" onmouseenter="Editor.switchEditor('<?php echo $TPL_VAR["params"]['initializedId']?>');">
							<a href="javascript:;" title="사진" class="tx-text">사진</a>
						</div>
<?php }?>
				</li>
				<!-- 파일 첨부 버튼 끝 -->
<?php if(((strstr($_SERVER['HTTP_REFERER'],"/admin/")||strstr($_SERVER['HTTP_REFERER'],"/selleradmin/"))&&!strstr($_SERVER['HTTP_REFERER'],"manager_write"))){?>
<?php if(($TPL_VAR["params"]['board_id']&&$TPL_VAR["params"]['videouse']=='Y')||$TPL_VAR["params"]['videouse']=='Y'){?>
				<li class="tx-list">
					<div unselectable="on" id="tx-video<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-video">
						<a href="javascript:;" onclick="window.open('/admin/design/video_editor_insert','flashvideo','left=250,top=65,width=700,height=750')" title="동영상" class="tx-text">동영상</a>
					</div>
				</li>
<?php }?>

				
<?php }?>
			</ul>

			<!-- 사이드바 / 우측영역 -->
			<ul class="tx-bar tx-bar-right">
<?php if($TPL_VAR["params"]['fullMode']!="1"){?>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-lrbg tx-fullscreen" id="tx_fullscreen<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="넓게쓰기 (Ctrl+M)">넓게쓰기</a>
					</div>
				</li>
<?php }?>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-nlrbg tx-advanced" id="tx_advanced<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="툴바 더보기">툴바 더보기</a>
					</div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-right tx-nav-opt">
				<li class="tx-list">
					<div unselectable="on" class="tx-switchtoggle" id="tx_switchertoggle<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" title="에디터 타입">에디터</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- 툴바 - 기본 끝 --><!-- 툴바 - 더보기 시작 -->
	<div id="tx_toolbar_advanced<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-toolbar tx-toolbar-advanced">
		<div class="tx-toolbar-boundary">
			<ul class="tx-bar tx-bar-left">
				<li class="tx-list">
					<div class="tx-tableedit-title">
					</div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-left tx-group-align">
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-lbg tx-mergecells" id="tx_mergecells<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon2" title="병합">병합</a>
					</div>
					<div id="tx_mergecells_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-mergecells-menu tx-menu" unselectable="on">
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-bg tx-insertcells" id="tx_insertcells<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon2" title="삽입">삽입</a>
					</div>
					<div id="tx_insertcells_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-insertcells-menu tx-menu" unselectable="on">
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-rbg tx-deletecells" id="tx_deletecells<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon2" title="삭제">삭제</a>
					</div>
					<div id="tx_deletecells_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-deletecells-menu tx-menu" unselectable="on">
					</div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-left tx-group-align">
				<li class="tx-list">
					<div id="tx_cellslinepreview<?php echo $TPL_VAR["params"]['initializedId']?>" unselectable="on" class="tx-slt-70lbg tx-cellslinepreview">
						<a href="javascript:;" title="선 미리보기"></a>
					</div>
					<div id="tx_cellslinepreview_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-cellslinepreview-menu tx-menu" unselectable="on">
					</div>
				</li>
				<li class="tx-list">
					<div id="tx_cellslinecolor<?php echo $TPL_VAR["params"]['initializedId']?>" unselectable="on" class="tx-slt-tbg tx-cellslinecolor">
						<a href="javascript:;" class="tx-icon2" title="선색">선색</a>
						<div class="tx-colorpallete" unselectable="on">
						</div>
					</div>
					<div id="tx_cellslinecolor_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-cellslinecolor-menu tx-menu tx-colorpallete" unselectable="on">
					</div>
				</li>
				<li class="tx-list">
					<div id="tx_cellslineheight<?php echo $TPL_VAR["params"]['initializedId']?>" unselectable="on" class="tx-btn-bg tx-cellslineheight">
						<a href="javascript:;" class="tx-icon2" title="두께">두께</a>
					</div>
					<div id="tx_cellslineheight_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-cellslineheight-menu tx-menu" unselectable="on">
					</div>
				</li>
				<li class="tx-list">
					<div id="tx_cellslinestyle<?php echo $TPL_VAR["params"]['initializedId']?>" unselectable="on" class="tx-btn-bg tx-cellslinestyle">
						<a href="javascript:;" class="tx-icon2" title="스타일">스타일</a>
					</div>
					<div id="tx_cellslinestyle_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-cellslinestyle-menu tx-menu" unselectable="on">
					</div>
				</li>
				<li class="tx-list">
					<div id="tx_cellsoutline<?php echo $TPL_VAR["params"]['initializedId']?>" unselectable="on" class="tx-btn-rbg tx-cellsoutline">
						<a href="javascript:;" class="tx-icon2" title="테두리">테두리</a>
					</div>
					<div id="tx_cellsoutline_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-cellsoutline-menu tx-menu" unselectable="on">
					</div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-left">
				<li class="tx-list">
					<div id="tx_tablebackcolor<?php echo $TPL_VAR["params"]['initializedId']?>" unselectable="on" class="tx-btn-lrbg tx-tablebackcolor" style="background-color:#9aa5ea;">
						<a href="javascript:;" class="tx-icon2" title="테이블 배경색">테이블 배경색</a>
					</div>
					<div id="tx_tablebackcolor_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-tablebackcolor-menu tx-menu tx-colorpallete" unselectable="on">
					</div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-left">
				<li class="tx-list">
					<div id="tx_tabletemplate<?php echo $TPL_VAR["params"]['initializedId']?>" unselectable="on" class="tx-btn-lrbg tx-tabletemplate">
						<a href="javascript:;" class="tx-icon2" title="테이블 서식">테이블 서식</a>
					</div>
					<div id="tx_tabletemplate_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-tabletemplate-menu tx-menu tx-colorpallete" unselectable="on">
					</div>
				</li>
			</ul>
			<ul class="tx-bar tx-bar-left">
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-lbg tx-emoticon" id="tx_emoticon<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="이모티콘">이모티콘</a>
					</div>
					<div id="tx_emoticon_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-emoticon-menu tx-menu" unselectable="on">
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-bg tx-background" id="tx_background<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="배경색">배경색</a>
					</div>
					<div id="tx_background_menu<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-menu tx-background-menu tx-colorpallete" unselectable="on">
					</div>
				</li>
				<li class="tx-list">
					<div unselectable="on" class="tx-btn-rbg tx-dictionary" id="tx_dictionary<?php echo $TPL_VAR["params"]['initializedId']?>">
						<a href="javascript:;" class="tx-icon" title="사전">사전</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- 툴바 - 더보기 끝 --><!-- 편집영역 시작 -->
	<div id="tx_canvas<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-canvas">
		<div id="tx_loading<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-loading">
			<div>
				<img src="/app/javascript/plugin/editor/images/icon/editor/loading2.png" width="113" height="21" align="absmiddle"/>
			</div>
		</div>
		<div id="tx_canvas_wysiwyg_holder<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-holder" style="display:block;">
			<iframe id="tx_canvas_wysiwyg<?php echo $TPL_VAR["params"]['initializedId']?>" name="tx_canvas_wysiwyg<?php echo $TPL_VAR["params"]['initializedId']?>" allowtransparency="true" frameborder="0">
			</iframe>
		</div>
		<div class="tx-source-deco">
			<div id="tx_canvas_source_holder<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-holder">
				<textarea id="tx_canvas_source<?php echo $TPL_VAR["params"]['initializedId']?>" rows="30" cols="30">
				</textarea>
			</div>
		</div>
		<div id="tx_canvas_text_holder<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-holder">
			<textarea id="tx_canvas_text<?php echo $TPL_VAR["params"]['initializedId']?>" rows="30" cols="30">
			</textarea>
		</div>
	</div>
	<!-- 높이조절 Start -->
	<div id="tx_resizer<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-resize-bar">
		<div class="tx-resize-bar-bg">
		</div>
		<img id="tx_resize_holder<?php echo $TPL_VAR["params"]['initializedId']?>" src="/app/javascript/plugin/editor/images/icon/editor/skin/01/btn_drag01.gif" width="58" height="12" unselectable="on" alt="" />
	</div>
	<!-- 편집영역 끝 --><!-- 첨부박스 시작 --><!-- 파일첨부박스 Start -->
	<div id="tx_attach_div<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-attach-div">
			<div id="tx_attach_box<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-attach-box">
			<div class="tx-attach-box-inner">
				<div id="tx_attach_preview<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-attach-preview">
					<p>
					</p>
					<img src="/app/javascript/plugin/editor/images/icon/editor/pn_preview.gif" width="147" height="108" unselectable="on"/>
				</div>
				<div class="tx-attach-main">
					<div id="tx_upload_progress<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-upload-progress">
						<div>
							0%
						</div>
						<p>
							파일을 업로드하는 중입니다.
						</p>
					</div>
					<ul class="tx-attach-top">
						<li id="tx_attach_delete<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-attach-delete">
							<a><!-- 전체삭제 --></a>
						</li>
						<li id="tx_attach_size<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-attach-size">
							파일: <span id="tx_attach_up_size<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-attach-size-up"></span>/<span id="tx_attach_max_size<?php echo $TPL_VAR["params"]['initializedId']?>"></span>
						</li>
						<li id="tx_attach_tools<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-attach-tools">
						</li>
					</ul>
					<ul id="tx_attach_list<?php echo $TPL_VAR["params"]['initializedId']?>" class="tx-attach-list">
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- 첨부박스 끝 -->
</div>
<input type="hidden" name="daumedit" value="1">
<!-- 에디터 컨테이너 끝 -->