<?php 
require_once('class.phpmailer.php');
require_once('logger.php');
date_default_timezone_set('Asia/Bangkok');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_CORE_ERROR | E_COMPILE_ERROR | E_PARSE) ;
/*E_PARSE | E_WARNING | E_NOTICE , E_ALL | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR*/


/*define variable globle for client;*/
$base_dir = "../";

function SendMail($receive,$sender,$subject,$message,$sender_name)
{
		$mail = new PHPMailer();
	
		$mail->Subject = $subject;
		$mail->MsgHTML($message);//body mail
		$mail->CharSet = "utf-8";
		$mail->SMTPAuth = true;
		$mail->IsSMTP();
		$mail->SMTPDebug = 1;
		$mail->SMTPSecure = "tls";
		$mail->Host="smtp.gmail.com";//smtp.gmail.com
		$mail->Port="587";//ssl :: 465 or tls :: 587
		//$mail->IsHTML(true);
		$mail->Username = "svargalok@gmail.com"; 
		$mail->Password = "trinity@59"; 
		
		$mail->SetFrom($sender, $sender_name);

		//list send email 
		foreach($receive as $to){
			$mail->AddAddress($to["email"],$to["alias"]);
		}
		
		if(!$mail->Send()) {
			//echo "Mailer Error: " . $mail->ErrorInfo;
			if($_SESSION["lang"]!="en")
				echo "<script>alert('Sorry!! Email Communication has interrupt');</script>";
			else 
				echo "<script>alert('Sorry !! Can't Send email .');</script>";
		} else {
			if($_SESSION["lang"]!="en"){
				foreach($receive as $to){
					log_info("Send Email is complete: " . $to["email"]);
				}
			}
				//echo "<script>alert('ข้อมูลของคุณส่งเรียบร้อยแล้วค่ะ');</script>";
			else 
				echo "<script>alert('Send email complete, Thankyou.');</script>";
		}
		
		//echo "<script>window.location.href='".$redirect."';</script>";
}

function replace_specialtext($message){
	
	$result = str_replace("'","\'",$message);
	
	return $result;
}

function GetParameter($id){
	
	$result = "";
	if(isset($_POST)){
		if(isset($_POST[$id]))
		{
			$result =$_POST[$id];
		}
	}
	
	if(isset($_GET)){
		if(isset($_GET[$id]))
		{
			$result =$_GET[$id];
		}
	}
	return $result;
}

function upload_image($source,$distination){
	
	if($source=="") return;
	
	if(file_exists($distination)){
		log_debug('exists file upload > '.$distination);
		return ;
	}
	
	if(move_uploaded_file($source,$distination))
	{
		chmod($distination, 0775);
		log_debug('upload image success. > '.$distination);
	}
	else{
		log_debug('upload image Failed. >'.$distination);
	}
}

function full_date_format($date,$lang){


	switch($lang){
	case "en":

		$month = date("m",strtotime($date));
		$day =  date("d",strtotime($date));
		$year = date("Y",strtotime($date));
		$month_str = array("01"=>"January","02"=>"Faburary","03"=>"March","04"=>"May","05"=>"June","06"=>"June","07"=>"July","08"=>"August","09"=>"Sebtember","10"=>"Octuber","11"=>"November","12"=>"December");
		$month = $month_str[$month];
		$result = $day." ".$month." ".$year;

	break;
	case "th":
		$month = date("m",strtotime($date));
		$day =  date("d",strtotime($date));
		$year = date("Y",strtotime($date)) + 543;
		$time = date('h:i:s',strtotime($date));
		$month_str = array("01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฏาคม","08"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");
		$month = $month_str[$month];
		$result = $day." ".$month." ".$year . " " .$time;
	break;
	}

	return $result;

}

function datediff($startdate,$enddate){
	return (strtotime($enddate) - strtotime($startdate))/  ( 60 * 60 * 24 );
}

function createdir($directory)
{
		/*
		$parts = explode('/', $directory);
        $file = array_pop($parts);
        $dir = '';
		
        foreach($parts as $part)
		{
			/*
			if($part=="..")
				$dir="..";
			else
				$dir .= "/$part";
		
			$checkDir = $dir;
			if(!is_dir($checkDir)) 
			{
				mkdir($checkDir,0777,true);
			}
			mkdir($checkDir,0777,true);
		}*/
		
		if(!is_dir($directory))  //validate found directory
			mkdir($directory,0777,true);
}

?>
