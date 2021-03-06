<?php
session_start();
include("../lib/common.php");
include("../managers/config_manager.php");

$response_code ="-1";
//$result = "not found";

$service = GetParameter("type");

switch($service){
	case "certificate":
		$result = get_certificate();
	break;
	case "braner":
		$result = get_braner();
	break;
	case "pic_slider":
		$result = get_pic_slider();
	break;
	case "content":
		$result = get_content();
	break;
	case "item":
		$id = GetParameter("id");
		$result = get_item($id);
		
	break;
}


/* return response */
echo json_encode(array("data"=>$result,"code"=>$response_code));

/* list function */


function get_list(){

	$base = new News_Manager();
	$data = $base->get_list();

//id,title,detail,thumbnail,update_date,type_name
	while($row = $data->fetch_object()){

		
		$result[] = array(
			"id"=>$row->id,
			"title"=>$row->title,
			"detail"=>$row->detail,
			"thumbnail"=>$row->thumbnail,
			"update"=>$row->update_date,
			"news_type"=>$row->type_name
		);
		

	}

	$response_code ="0";

	return $result;
}


function get_item($id){

	$base = new News_Manager();
	$data = $base->get_item($id);
	$row = $data->fetch_object();
	
	$result = array(
			"id"=>$row->id,
			"title"=>$row->title,
			"detail"=>$row->detail,
			"update"=>$row->update_date,
			"thumbnail"=>$row->thumbnail,
			"news_type"=>$row->type_name
		);

	$response_code ="0";
	
	return $result;

}

function get_content(){
	
	$base = new Config_Manager();
	$dataset = $base->get_content();
	$row = $dataset->fetch_object();
	
	$result = array(
		"detail"=>$row->detail,
	);

	return $result ;
	
}

function get_certificate(){
	
	
	$base = new Config_Manager();
	$dataset = $base->get_certificate();
	$row = $dataset->fetch_object();
	
	$img = "";
		if($row->val!="")
			$img = $row->val;
	

	$result = array(
		"detail"=>$row->detail,
		"thumbnail"=>$img
	);

	return $result ;
}

function get_braner(){
	
	
	$base = new Config_Manager();
	$dataset = $base->get_braner();
	$row = $dataset->fetch_object();
	
	$img = "";
		if($row->val!="")
			$img = $row->val;
	

	$result = array(
		"thumbnail"=>$img
	);

	return $result ;
}

function get_pic_slider(){
	
	
	$base = new Config_Manager();
	$dataset = $base->list_picture_slide();

	while($row = $dataset->fetch_object()){

		$result[] = array(
			"id"=>$row->id,
			"thumbnail"=>$row->val
		);

	}

	return $result ;
}

?>