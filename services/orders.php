<?php
session_start();
include("../lib/common.php");
include("../managers/order_manager.php");

$service = GetParameter("type");
switch($service){
	case "confirm":
	
		$item = $_POST;
		$result = order_confirm($item);
	
	break;
	case "payment":
	
		$item = $_POST;
		$resul = order_payment($item);
		
	break;
}

function order_confirm($cust){
	
	$cart = $_SESSION["cart_list"];
	$summary = $_SESSION["cart_summary"];
	/* new order */
	$base = new Order_Manager();
	$running_no = $base->get_order_running()->fetch_object()->order_no;
	$order_no = (date('y')+43) . sprintf("%05d",$running_no); /*6000002*/
	
	$mobile = $cust["txtMobile"];
	$type_delivery = $summary["type_delivery"];
	$total_delivery = $summary["delivery"];
	$total_price = $summary["price"];
	$total_unit = $summary["unit"];
	$total_net = $summary["net"];
	
	$base->new_order($order_no,$mobile,$type_delivery,$total_delivery ,$total_price,$total_unit,$total_net);
	
	/*	insert order detail	*/	
	foreach($cart as $item){

		$base->new_order_detail(
		$order_no
		,$item["id"]
		,$item["price"]
		,$item["unit"]
		,$item["net"]
		);
		
	} 
	
	$base->confirm_order(
		$order_no
		,$cust["txtFirstName"]
		,$cust["txtLastName"]
		,$cust["txtEmail"]
		,$cust["txtAddress"]
		,$cust["txtSoi"]
		,$cust["txtRoad"]
		,$cust["txtDistrict"]
		,$cust["txtSubDistrict"]
		,$cust["txtPostCode"]
		,$cust["ddlProvince"]
	); 
	
	/*clear all session after order complete */
	session_destroy();
	
	header("Location: ../complete.html?id=".$order_no);
	
}

function order_payment($cust){
	
	// update evidance
	
	/*
	txtOrder
	txtCustName
	txtMobile
	txtAccount
	txtDate
	txtAmount
	fileEvidence
	txtRemark
	*/
	
	$file_Instrument = "";
	//$cust["fileEvidence"]
	
	if($_FILES['file_Instrument']['name']!=""){
		
		$name = $_FILES["file"]["name"];
		$ext = end((explode(".", $name)));
		$file_Instrument = "images/instrument/".$cust["txtOrder"].".".$ext;
		$distination_th =  "../../".$file_Instrument;
		$source_th = $_FILES['file_Instrument']['tmp_name'];
	}
	
	$base->payment_order(
		$cust["txtOrder"]
		,$cust["txtCustName"]
		,$cust["txtMobile"]
		,$cust["txtAccount"]
		,$cust["txtDate"]
		,$cust["txtAmount"]
		,$file_Instrument
		,$cust["txtRemark"]
	); 
	
	
	header("Location: ../success.html?id=".$order_no);
	
}

function call_item($id){
	
	$base = new Product_Manager();
	$data = $base->get_item($id);
	$row = $data->fetch_object();
	$result = array(
		"code"=>$row->code
		,"title"=>$row->title
		,"price"=>$row->price
		,"active"=>$row->active
		,"update"=>$row->update_date
		,"detail"=>$row->detail
		);
	
	return $result;
	
}

function call_top_list(){
	
	$base = new Product_Manager();
	$data = $base->get_list_top_product();
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"title"=>$row->title
		);
	}

	return $result;
}

function call_item_package($id,$money,$lang){
	
	$base = new Room_Manager();
	$data = $base->get_item_package($id,$lang);
	$row = $data->fetch_object();
	
	if($money==null){
		$money = $row->package_price;
	}
	
		$result = array(
			"id"=>$row->id,
			"title"=>$row->title,
			"price"=>$money,
			"food_service"=>$row->food_service,
			"cancel_room"=>$row->cancel_room,
			"payment_online"=>$row->payment_online,
			"max_person"=>$row->max_person,
			"extra_bed"=>$row->extra_bed,
			"extra_price_children"=>$row->extra_price_children,
			"extra_price_adults"=>$row->extra_price_adults,
			"detail"=>$row->detail,
			"conditions"=>$row->conditions);
	
	return $result;
}

echo json_encode(array("data"=>$result));

?>