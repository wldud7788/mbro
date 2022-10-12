<? php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	function alert($msg,$url) { 
		
		echo "<script type='text/javascript'>
					alert('".$msg."');
					location.replace('".$url."');
			  </script>";
	
	}	
?>
