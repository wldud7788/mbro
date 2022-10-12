<?php

session_start();
$resArray=$_SESSION['reshash']; 
$flag=$_REQUEST['flag']; 
?>
<html>
<head>
<title>PayPal API Error--<?php echo $flag ?></title>
</head>
<body alink=#0000FF vlink=#0000FF>
<center>
<table width="280">
<tr><td colspan="2" class="header">The PayPal API has returned an error!</td></tr>
<?php  //it will print if any URL errors 
	if(isset($_SESSION['curl_error_no'])) { 
			$errorCode= $_SESSION['curl_error_no'] ;
			$errorMessage=$_SESSION['curl_error_msg'] ;	
			session_unset();	
?>
<tr><td>Error Number:</td><td><?= $errorCode ?></td></tr>
<tr><td>Error Message:</td><td><?= $errorMessage ?></td></tr>
</table>
</center>
<?php } else { ?>
<center>
	<font size=2 color=black face=Verdana><b></b></font>
	<br><br>
	<b> PayPal API Error--<?php echo $flag ?></b><br><br>
  <table width = "400">
     	<?php 
    		foreach($resArray as $key => $value) {
    			echo "<tr><td> $key:</td><td>$value</td>";
    			}	
 			?>
    </table>

	<a href="index.html">재결제</a>
    </center>		
<?php 
 }// end else 
?>
</table>
</center>
</body>
</html>

