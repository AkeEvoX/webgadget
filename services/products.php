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
	case "view" :
	
		$view = GetParameter("view");
		$t_prod = GetParameter("t_prod");//type product
		$t_brand = GetParameter("t_brand");//type brand
		$hw_brand = GetParameter("hw_brand");//hardware brand
		$hw_model = GetParameter("hw_model");//hardware model
		
		switch($view) {
			case "type_product":
				//$result = call_list_type_product($t_brand);
				$result = call_list_product_filter($t_prod,$t_brand,$hw_brand,$hw_model);
			break;
			case "type_brand":
				//$result = call_list_type_brand($t_prod);
				$result = call_list_product_filter($t_prod,$t_brand,$hw_brand,$hw_model);
			break;
			case "hardware_brand":
				//$result = call_list_hardware_brand($t_prod,$t_brand);
				$result = call_list_product_filter($t_prod,$t_brand,$hw_brand,$hw_model);
			break;
			case "hardward_modal":
				$result = call_list_product_filter($t_prod,$t_brand,$hw_brand,$hw_model);
				//$result = call_list_hardware_modal($t_prod,$t_brand,$hw_brand);
			break;
			case "product":
				$result = call_list_product_filter($t_prod,$t_brand,$hw_brand,$hw_model);
				//$result = call_list_product($t_prod,$t_brand,$hw_brand,$hw_model);
			break;
		}
	
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
			"name"=>$row->name
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
			"name"=>$row->name
		);
	}

	return $result;
}

function call_list_product_filter($t_prod,$t_brand,$hw_brand,$hw_model){
	
	$base = new Product_manager();
	$data = $base->get_list_product_filter($t_prod,$t_brand,$hw_brand,$hw_model);
	while($row = $data->fetch_object()){
		$result[] = array(
		"type_pro_id"=>$row->type_pro_id
		,"type_pro_name"=>$row->type_pro_name
		,"type_brand_id"=>$row->type_brand_id
		,"type_brand_name"=>$row->type_brand_name
		,"hw_brand_id"=>$row->hw_brand_id
		,"hw_brand_name"=>$row->hw_brand_name
		,"hw_model_id"=>$row->hw_model_id
		,"hw_model_name"=>$row->hw_model_name
		,"pro_id"=>$row->pro_id
		,"pro_name"=>$row->pro_name
		,"pro_detail"=>$row->pro_detail
		,"unit"=>$row->unit
		,"price"=>$row->price
		,"thumbnail"=>$row->thumbnail
		,"views"=>$row->views
		,"active"=>$row->active
		,"update_date"=>$row->update_date
		);
	}
	
	return $result;
	
}

//

function call_list_type_product($t_brand){
	
	//type_pro_id, type_pro_name ,hw_brand_id,hw_brand_name
	
	$base = new Product_Manager();
	$data = $base->get_list_type_product($t_brand);
	while($row = $data->fetch_object()){
		$result[] = array(
			"type_pro_id"=>$row->type_pro_id
			,"type_pro_name"=>$row->type_pro_name
			,"hw_brand_id"=>$row->hw_brand_id
			,"hw_brand_name"=>$row->hw_brand_name
		);
	}

	return $result;
}

function call_list_type_brand($t_prod){
	$base = new Product_Manager();
	$data = $base->get_list_type_brand($t_prod);
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name
		);
	}

	return $result;
}
function call_list_hardware_brand($t_prod,$t_brand){
	$base = new Product_Manager();
	$data = $base->get_list_hardware_brand($t_prod,$t_brand);
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name
		);
	}

	return $result;
}
function call_list_hardware_modal($t_prod,$t_brand,$hw_brand){
	$base = new Product_Manager();
	$data = $base->get_list_hardware_modal($t_prod,$t_brand,$hw_brand);
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name
		);
	}

	return $result;
}
function call_list_product($t_prod,$t_brand,$hw_brand,$hw_model){
	$base = new Product_Manager();
	$data = $base->get_list_product($t_prod,$t_brand,$hw_brand,$hw_model);
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name,
			"price"=>$row->price
		);
	}

	return $result;
}
	
echo json_encode(array("data"=>$result));

?>
