<?php
session_start();
include("../lib/common.php");
include("../managers/order_manager.php");

$cart = $_SESSION["cart_list"];
$summary = $_SESSION["cart_summary"];

$type =  GetParameter("type");

switch($type){
	case "add":
		
		$id = GetParameter("id"); 
		$title = GetParameter("title"); 
		$price = GetParameter('price');
		$unit = GetParameter('unit');
		$color = GetParameter('color');
		$colorName = GetParameter('colorName');
		$net = $price * $unit;
		
		/*check duplicate.*/
		$idx = find_product_duplicate($id);
		
		if($idx == -1){
			log_info("cart > insert order id : " . $id);

			/*verify color*/
			if($color!="-1")
				$colorSelect = " (" . $colorName . ")";


			$cart[] = array("id"=>$id,"title"=>$title . $colorSelect ,"price"=>$price,"unit"=>$unit,"net"=>$net,"color"=>$color);	
			$_SESSION["cart_list"] = $cart;
		}
		else {
			log_info("cart > update order idx : " . $idx);
			update_product_duplicate($idx,$unit,$price);
		}
		
		resummary();
		header('Location: ../myorder.html');
		exit();
	break;
	case "order":
		$item = $_POST;
		$summary = $_SESSION["cart_summary"];
		$mobile = $item["cust_mobile"];
		$type_deliver = $item["type_delivery"];
		$total_price = $item["total_price"];
		$total_unit = $item["total_unit"];
		$total_delivery = $item["total_delivery"];
		$total_net = $item["total_net"];
		//$_SESSION["cart_summary"]=>"type_delivery" = "";
		
		$summary["price"] = $total_price;
		$summary["unit"]= $total_unit;
		$summary["delivery"] = $total_delivery;
		$summary["type_delivery"] = $type_deliver;
		$summary["net"] = $total_net;
		$summary["mobile"] = $mobile;
		
		/*redirect to my order*/
		$_SESSION["cart_summary"] = $summary;
		
		header('Location: ../confirm.html?mobile='.$mobile);
	break;
	case "info":
		$result = $summary;
		
	break;
	case "list":
		$result = $cart;
		
	break;
	case "promotion":
	
		$result = call_list_promotion();
	
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

function find_product_duplicate($id){
	
	$result = -1;

	if(!isset($_SESSION["cart_list"])) return $result;
	
	foreach($_SESSION["cart_list"] as $idx =>$item){

		if($item["id"]==$id){
			$result = $idx;
			break;
		}
	}
	
	return $result;
}

function update_product_duplicate($idx,$unit,$price){
	//retrive cart of session
	$cart =$_SESSION["cart_list"] ; 
	//update unit and net price
	$update_unit = round($cart[$idx]["unit"]) + round($unit);
	$update_net = round($update_unit) * $price;
	$cart[$idx]["unit"] = $update_unit;
	$cart[$idx]["net"] = $update_net;
	//storing cart to session
	$_SESSION["cart_list"] = $cart;
	
}

function resummary(){
	//$summary 
	$count_unit = 0;
	$sum_price = 0;
	foreach($_SESSION["cart_list"] as $item){
		$count_unit+=round($item["unit"]);
		$sum_price += round($item["net"],2);
	}
	
	$_SESSION["cart_summary"] = array("unit"=>$count_unit,"price"=>$sum_price);
	
}

function call_list_promotion(){
	
	$base = new Order_Manager();
	$data = $base->get_list_promotion();
	
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name,
			"minimum"=>$row->minimum_price,
			"discount"=>$row->discount,
			"price"=>$row->price
		);
	}

	return $result;
}

?>