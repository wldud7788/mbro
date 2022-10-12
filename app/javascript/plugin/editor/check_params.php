<?php
function check_params($aParams, $config)
{
	$error = false;
	foreach ($aParams as $key => $val) {
		if (is_array($val)) {
			$error = check_params($val, $config);
		} else {
			if (preg_match($config['injection_pattern'], $val)) {
				return true;
			}
		}
	}
	return $error;
}
// end file