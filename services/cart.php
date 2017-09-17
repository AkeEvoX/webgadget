<?php
session_start();
include("../lib/common.php");
//include("../managers/reserve_manager.php");

$cart = $_SESSION["cart_list"];
$summary = $_SESSION["cart_summary"];

$type =  GetParameter("type");

switch($type){
	case "add":
		
		$id = GetParameter("id"); 
		$title = GetParameter("title"); 
		$price = GetParameter('price');
		$unit = GetParameter('unit');
		$net = GetParameter('net');
		$cart[] = array("id"=>$id,"title"=>$title,"price"=>$price,"unit"=>$unit,"net"=>$net);
				
		$_SESSION["cart_list"] = $cart;
		resummary();
		header('Location: ../myorder.html');
		exit();
	break;
	case "info":
		$result = $summary;
		
	break;
	case "list":
		$result = $cart;
		
	break;
	case "remove" :
	
		$id = GetParameter("id"); 
		
		foreach($cart as $idx => $item){
			if($cart[$idx]["id"]==$id){
				unset($cart[$idx]);
			}
			
		}
		
		$_SESSION["cart_list"]  = $cart; 
		resummary();
		$result = "complete";
		//header('Location: ../myorder.html');
		
	break;
}

echo json_encode(array("items"=> $result ,"code"=>"0"));


function resummary(){
	//$summary 
	$count_unit = 0;
	$sum_price = 0;
	foreach($_SESSION["cart_list"] as $item){
		$count_unit+=1;
		$sum_price += round($item["price"],2);
	}
	
	$_SESSION["cart_summary"] = array("unit"=>$count_unit,"price"=>$sum_price);
	
}

?>