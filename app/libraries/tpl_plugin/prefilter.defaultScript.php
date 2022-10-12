<?php
	function defaultScript($source, $tpl){
		global $__defaultScriptLoaded;

		$response = $source;

		$insert_tag = function($tag) use ($source) {
			if(false !== ($position = strpos($source, '</'.$tag))) {
				global $__defaultScriptLoaded;
				$__defaultScriptLoaded[$tag] = true;
				return substr($source, 0, $position)
					.($tag === 'head' ? '{=defaultScriptFunc()}' : '{=header_requires()}')
					.substr($source, $position);
			}
			return $source;
		};

		if(empty($__defaultScriptLoaded)) $__defaultScriptLoaded = [];

		if(!$__defaultScriptLoaded['head']) {
			$response = $insert_tag('head');
		}
		elseif(!$__defaultScriptLoaded['body']) {
			$response = $insert_tag('body');
		}

		return $response;
	}
