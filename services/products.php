<?php
session_start();
include("../lib/common.php");
include("../managers/product_manager.php");

$service = GetParameter("service");
switch($service){
	case "top_list":
	$result = call_top_list();
	break;
	case "list":
		$result = call_list();
	break;
	case "list_brand":
		$result = call_list_brand();
	break;
	case "gallery":
		$id = GetParameter("id");
		$result = call_gallery($id);
	break;
	case "item":
		$id = GetParameter("id");
		$result = call_item($id);
	break;
}

function call_item($id){
	
	$base = new Product_Manager();
	$data = $base->get_item($id);
	while($row = $data->fetch_object()){
		
		$result = array(
			"id"=>$row->id
			,"code"=>$row->code
			,"title"=>$row->title
			,"detail"=>$row->detail
			,"price"=>$row->price
			,"active"=>$row->active
			,"update"=>$row->update_date
		);
	}

	return $result;
}

function call_gallery($id){
	
	$base = new Product_Manager();
	$data = $base->get_product_gallery($id);
	while($row = $data->fetch_object()){
		
		$result[] = array(
			"id"=>$row->id
			,"url"=>$row->url
			,"detail"=>$row->detail			
		);
	}

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

function call_list(){
	
	$base = new Product_Manager();
	$data = $base->get_list_product_type();
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"title"=>$row->title
		);
	}

	return $result;
}

function call_list_brand(){
	
	$base = new Product_Manager();
	$data = $base->get_list_brand();
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"title"=>$row->title
		);
	}

	return $result;
}
	
echo json_encode(array("data"=>$result));

?>
