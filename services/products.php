<?php
session_start();
include("../lib/common.php");
include("../managers/product_manager.php");

$service = GetParameter("service");
switch($service){
	case "search":
		$find = GetParameter("find");
		$result = call_search_product($find);	
	break;
	case "list_top_product":
	$result = call_list_top_product();
	break;
	case "list":
		$result = call_list();
	break;
	case "list_pro_update":
		$result = call_list_pro_update();
	break;
	case "list_pro_brand":
		$result = call_list_pro_brand();
	break;
	case "gallery":
		$id = GetParameter("id");
		$result = call_gallery($id);
	break;
	case "item":
		$id = GetParameter("id");
		$result = call_item($id);
		$navi = call_navi_cate_pro($result["cate_model_id"]);
		
	break;
	case "view_cate" : 
		$result = call_view_cate();
	break;
	case "view_cate_brand" : 
		$cate_id = GetParameter("cate_id");
		$navi = call_navi_cate_brand($cate_id);
		$result = call_view_cate_brand($cate_id);
		
	break;
	case "view_cate_model" : 
		$cate_brand_id = GetParameter("cate_brand_id");
		$navi = call_navi_cate_model($cate_brand_id);
		$result = call_view_cate_model($cate_brand_id);
		
	break;
	case "view_cate_product" : 
		$cate_model_id = GetParameter("cate_model_id");
		$navi = call_navi_cate_pro($cate_model_id);
		$result = call_view_cate_product($cate_model_id);
		
	break;
	case "view_pro_brand" : 
		$pro_brand_id = GetParameter("pro_brand_id");
		$navi = call_pro_brand($pro_brand_id);
		$result = call_view_pro_brand($pro_brand_id);
	break;
	case "view_model_of_brand":
		$pro_brand_id = GetParameter("pro_brand_id");		
		$result = call_view_model_of_brand($pro_brand_id);
		
	break;
}

function call_item($id){
	
	$base = new Product_Manager();
	$data = $base->get_item($id);
	while($row = $data->fetch_object()){
		
		$result = array(
			"id"=>$row->id
			,"code"=>$row->code
			,"name"=>$row->name
			,"brand_name"=>$row->brand_name
			,"detail"=>$row->detail
			,"price"=>$row->price
			,"status"=>$row->status
			,"cate_model_id"=>$row->cate_model_id
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


function call_list_pro_update(){
	
	$base = new Product_Manager();
	$data = $base->get_list_pro_update();
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name,
			"thumbnail"=>$row->thumbnail,
			"price"=>$row->price,
			"update"=>$row->update_date
		);
	}

	return $result;
}

function call_list_top_product(){
	
	$base = new Product_Manager();
	$data = $base->get_list_top_product();
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name
		);
	}

	return $result;
}

function call_search_product($find){
	
	$base = new Product_Manager();
	$data = $base->get_search_product($find);
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name,
			"brand_name"=>$row->brand_name,
			"thumbnail"=>$row->thumbnail,
			"price"=>$row->price,
			"update"=>$row->update_date,
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

function call_list_pro_brand(){
	
	$base = new Product_Manager();
	$data = $base->get_list_pro_brand();
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name
		);
	}

	return $result;
}

function call_view_cate(){
	
	$base = new Product_Manager();
	$data = $base->get_list_cate();
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name
		);
	}

	return $result;
}

function call_view_cate_brand($cate_id){
	$base = new Product_Manager();
	$data = $base->get_list_cate_brand($cate_id);
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name
		);
	}

	return $result;
}

function call_navi_cate_brand($cate_id){
	
	$base = new Product_Manager();
	
	$navi_info = $base->get_navi_cate_brand($cate_id)->fetch_object();;
	$navi = array(
	"lv1_id"=>$navi_info->lv1_id,
	"lv1_name"=>$navi_info->lv1_name
	);
	
	return $navi;
}

function call_navi_cate_model($cate_brand_id){
	
	$base = new Product_Manager();
	
	$navi_info = $base->get_navi_cate_model($cate_brand_id)->fetch_object();;
	$navi = array(
	"lv1_id"=>$navi_info->lv1_id,
	"lv1_name"=>$navi_info->lv1_name,
	"lv2_id"=>$navi_info->lv2_id,
	"lv2_name"=>$navi_info->lv2_name
	);
	
	return $navi;
}

function call_view_cate_model($cate_brand_id){
	$base = new Product_Manager();
	
	$data = $base->get_list_cate_model($cate_brand_id);
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name
		);
	}

	return $result;
}

function call_navi_cate_pro($cate_model_id){
	
	$base = new Product_Manager();
	
	$navi_info = $base->get_navi_cate_pro($cate_model_id)->fetch_object();;
	$navi = array(
	"lv1_id"=>$navi_info->lv1_id,
	"lv1_name"=>$navi_info->lv1_name,
	"lv2_id"=>$navi_info->lv2_id,
	"lv2_name"=>$navi_info->lv2_name,
	"lv3_id"=>$navi_info->lv3_id,
	"lv3_name"=>$navi_info->lv3_name
	);
	
	return $navi;
}

function call_view_cate_product($cate_model_id){
	
	$base = new Product_Manager();
	
	$data = $base->get_list_cate_product($cate_model_id);
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name,
			"brand_name"=>$row->brand_name,
			"thumbnail"=>$row->thumbnail,
			"price"=>$row->price,
			"update"=>$row->update_date,
		);
	}

	return $result;
}

function call_view_pro_brand($pro_brand_id){
	
	$base = new Product_Manager();
	
	$data = $base->get_list_product_brand($pro_brand_id);
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name,
			"brand_name"=>$row->brand_name,
			"thumbnail"=>$row->thumbnail,
			"price"=>$row->price,
			"update"=>$row->update_date,
		);
	}

	return $result;
}

function call_view_model_of_brand($pro_brand_id){
	
	$base = new Product_Manager();
	
	$data = $base->get_list_pro_brand_model($pro_brand_id);
	while($row = $data->fetch_object()){
		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name,
			"update"=>$row->update_date,
		);
	}

	return $result;
}

function call_pro_brand($pro_brand_id){
	
	$base = new Product_Manager();
	
	$data = $base->get_product_brand($pro_brand_id);
	while($row = $data->fetch_object()){
		$result = array(
			"id"=>$row->id,
			"name"=>$row->name
		);
	}

	return $result;
	
}

echo json_encode(array("data"=>$result,"navi"=>$navi));

?>
