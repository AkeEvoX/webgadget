<?php
session_start();
include("../../lib/logger.php");
include("../../lib/common.php");
//include("../managers/reserve_manager.php");

	//$receive = array("neosvargalok@hotmail.com"=>"customer");
	//$receive = array("werawat.limprasert@gmail.com"=>"customer");

	//$receive[] = array("email"=>"svargalok@gmail.com","alias"=>"customer gmail");
	$receive[] = array("email"=>"werawat.limprasert@gmail.com","alias"=>"customer gmail");

	//$receive="svargalok@gmail.com";
	$sender = "services@centeraccessories888.com";
	$sender_name = "Services System ".date("His");
	$subject = "แจ้งเลขที่ EMS จาก centeraccessories888.com";

	$message = file_get_contents("../ems_notify.html");
	
	//$orderid='123';
	//$ems='efj382azs92';
	$url='http://track.thailandpost.com/tracking/default.aspx?lang=en';
	
	$message = str_replace("{orderid}",$orderid,$message);
	$message = str_replace("{ems}",$ems,$message);
	$message = str_replace("{url}",$url,$message);
	
	SendMail($receive,$sender,$subject,$message,$sender_name);
	foreach($receive as $to){
		echo "send email complete." . $to['email']."</br>";
	}
?>