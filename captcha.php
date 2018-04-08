<?php

	session_start();
	include dirname(__FILE__ )."/phptextClass.php";	
	
	/*create class object*/
	$phptextObj = new phptextClass();	
	/*phptext function to genrate image with text*/
	$phptextObj->phpcaptcha('#162453','#fff',120,40,10,25);	
 ?>