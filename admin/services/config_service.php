<?php
session_start();
include("../../lib/common.php");
include("../managers/config_manager.php");

#get parameter
$type = GetParameter("type");
$result_code = "-1";
//echo "type=".$type;
switch($type){
	case "load_certificate": 
		$result =  GetCertificate();
	break;
	case "modify_certificate": 
		$result =  ModifyCertificate();
	break;
	case "load_braner": 
		$result =  GetBraner();
	break;
	case "modify_braner": 
		$result =  ModifyBraner();
	break;
	case "load_home_content": 
		$result =  GetHomeContent();
	break;
	case "modify_home_content": 
		$result =  ModifyHomeContent();
	break;
	case "list_picture_slider": 
		$result = ListPictureSlider();
	break;
	case "item_pic_slider" :
		$result = GetItemPictureSlider();
	break;
	case "delete_pic_slider" :
		$result = DeletePicSlider();
	break;
	case "add_pic_slider" :
		$result = CreatePicSlider();
	break;
}

echo json_encode(array("result"=> $result ,"code"=>$result_code));

function CreateItem(){

$base = new News_Manager();
$title = GetParameter("title");
$detail = GetParameter("detail");
$type_new = GetParameter("type_new");
$status = (GetParameter("status")=="on") ? "1" : "0" ;


if($_FILES['thumbnail']['name']!=""){
	
	$dir = "images/news/thumbnail/" ; 
	$ext = pathinfo($_FILES['thumbnail']['name'],PATHINFO_EXTENSION);
	$filename = $dir.date('ymdhis').".".$ext;
	$distination =  "../../".$filename;
	$source = $_FILES['thumbnail']['tmp_name'];  
	$thumbnail = $filename;
	upload_image($source,$distination);
}


$result = $base->insert_item($title,$detail,$thumbnail,$type_new,$status);

global $result_code; //call global variable
$result_code="0";

return $result;
}

function CreatePicSlider(){

	$base = new Config_Manager();

	if($_FILES['file_image']['name']!=""){
		
		$dir = "images/logos/" ; 
		$ext = pathinfo($_FILES['file_image']['name'],PATHINFO_EXTENSION);
		$filename = $dir.date('ymdhis').".".$ext;
		$distination =  "../../".$filename;
		$source = $_FILES['file_image']['tmp_name'];  
		$thumbnail = $filename;
		upload_image($source,$distination);
	}


	$result = $base->create_picture_slide($thumbnail);

	global $result_code; //call global variable
	$result_code="0";

	return $result;
}

function ModifyCertificate(){
	
	$base = new Config_Manager();
	$id = GetParameter("id");
	$detail = GetParameter("detail");
	$status = (GetParameter("status")=="on") ? "1" : "0" ;


	if($_FILES['file_image']['name']!=""){
		
		$dir = "images/other/" ; 
		$ext = pathinfo($_FILES['file_image']['name'],PATHINFO_EXTENSION);
		$filename = $dir.date('ymdhis').".".$ext;
		$distination =  "../../".$filename;
		$source = $_FILES['file_image']['tmp_name'];  
		$thumbnail = $filename;
		upload_image($source,$distination);
	}


	$result = $base->modify_certificate($id,$detail,$thumbnail,$status);
	global $result_code; //call global variable
	$result_code="0";
	return $result;
}

function ModifyHomeContent(){
	$base = new Config_Manager();
	$id = GetParameter("id");
	$detail = GetParameter("detail");
	$status = (GetParameter("status")=="on") ? "1" : "0" ;

	$result = $base->modify_home_content($id,$detail,$status);
	global $result_code; //call global variable
	$result_code="0";
	return $result;
}


function ModifyBraner(){
	
	$base = new Config_Manager();
	$id = GetParameter("id");
	$detail = GetParameter("detail");
	$status = (GetParameter("status")=="on") ? "1" : "0" ;


	if($_FILES['file_image']['name']!=""){
		
		$dir = "images/logos/" ; 
		$ext = pathinfo($_FILES['file_image']['name'],PATHINFO_EXTENSION);
		$filename = $dir.date('ymdhis').".".$ext;
		$distination =  "../../".$filename;
		$source = $_FILES['file_image']['tmp_name'];  
		$thumbnail = $filename;
		upload_image($source,$distination);
	}


	$result = $base->modify_braner($id,$thumbnail,$status);
	global $result_code; //call global variable
	$result_code="0";
	return $result;
}


function DeleteItem(){
	$base = new News_Manager();
	$id = GetParameter("id");
	$base->delete_item($id);
	$result = "delete success";
	global $result_code; //call global variable
	$result_code="0";
	return $result;
}

function DeletePicSlider(){
	
	$base = new Config_Manager();
	$id = GetParameter("id");
	$base->delete_picture_slider($id);
	$result = "delete success";
	global $result_code; //call global variable
	$result_code="0";
	return $result;
	
}


function Listobject(){

	$base = new News_Manager();
	$dataset = $base->list_item();
	if($dataset){
		
		while($row = $dataset->fetch_object()){
			$result[] = array("id"=>$row->id
			,"title"=>$row->title
			,"detail"=>$row->detail
			,"thumbnail"=>$row->thumbnail
			,"status"=>$row->status
			,"status"=>$row->status);
		}
	}

	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}

function ListItem(){
	
	$base = new News_Manager();
	$dataset = $base->list_item();

	$result .= initial_column();

	if($dataset->num_rows===0){
		$result .= "<tr><td class='text-center' colspan='4'>ไม่พบข้อมูล</td></tr>";
	}
	else {
		
		while($row = $dataset->fetch_object()){
			
			$item_status = $row->status == 1? '<span class="glyphicon glyphicon-ok" style="color:green;" ></span>' : '<span class="glyphicon glyphicon-remove" style="color:red;" ></span>' ;
			$result .= "<tr>";
			$result .="<td>".$row->id."</td>";
			$result .="<td>".$row->title."</td>";
			$result .="<td>".$row->type_name."</td>";
			$result .="<td>".$item_status."</td>";
			$result .="<td><button class='btn btn-warning' data-id='".$row->id."' data-item='services/news_service.php?type=item' data-page='news_edit.html' data-title='Modify' onclick='page.modify(this);' ><span class='glyphicon glyphicon-pencil'></span> แก้ไข</button> ";
			$result .="<button class='btn btn-danger' data-id='".$row->id."' data-item='services/news_service.php?type=item' data-page='news_del.html' data-title='Remove' onclick='page.remove(this);'><span class='glyphicon glyphicon-trash'></span> ลบ</button></td>";
			$result .= "</tr>";
			
		}
	}

	$result .= "</tbody>";
	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}


function ListPictureSlider(){
	
	$base = new Config_Manager();
	$dataset = $base->list_picture_slider();

	$result .= initial_column_pic_slider();
	$index = 1;

	if($dataset->num_rows===0){
		$result .= "<tr><td class='text-center' colspan='3'>ไม่พบข้อมูล</td></tr>";
	}
	else {
		
		while($row = $dataset->fetch_object()){
			
			$item_status = $row->status == 1? '<span class="glyphicon glyphicon-ok" style="color:green;" ></span>' : '<span class="glyphicon glyphicon-remove" style="color:red;" ></span>' ;
			$result .= "<tr>";
			$result .="<td>".$index."</td>";
			$result .="<td><img src='../".$row->val."' style='width:100%;' /></td>";
			$result .="<td><button class='btn btn-danger' data-id='".$row->id."' data-item='services/config_service.php?type=item_pic_slider' data-page='pic_slider_del.html' data-title='Remove' onclick='page.remove(this);'><span class='glyphicon glyphicon-trash'></span> ลบ</button></td>";
			$result .= "</tr>";
			
			$index +=1;
		}
	}

	$result .= "</tbody>";
	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}


function GetItem(){
	
	$base = new News_Manager();
	$id = GetParameter("id");
	$dataset = $base->get_item($id);
	$row = $dataset->fetch_object();

	$result = array(
		"id"=>$row->id,
		"title"=>$row->title,
		"detail"=>$row->detail,
		"thumbnail"=>$row->thumbnail,
		"type_news"=>$row->type_name,
		"status"=>$row->status
	);

	global $result_code; //call global variable
	$result_code="0";
	return $result ;
}

function GetItemPictureSlider(){
	
	$base = new Config_Manager();
	$id = GetParameter("id");
	$dataset = $base->item_picture_slider($id);
	$row = $dataset->fetch_object();

	$result = array(
		"id"=>$row->id,
		"title"=>$row->title,
		"detail"=>$row->detail,
		"thumbnail"=>"../".$row->val,
		"status"=>$row->status
	);

	global $result_code; //call global variable
	$result_code="0";
	return $result ;
}



function GetCertificate(){
	
	$base = new Config_Manager();
	$dataset = $base->get_certificate();
	$row = $dataset->fetch_object();
	
	$img = "../images/other/image-not-found.png";
	if($row->val!="")
		$img = "../".$row->val;
	

	$result = array(
		"id"=>$row->id,
		"title"=>$row->title,
		"detail"=>$row->detail,
		"thumbnail"=>$img,
		"status"=>$row->status
	);

	global $result_code; //call global variable
	$result_code="0";
	return $result ;
}

function GetHomeContent(){
	
	$base = new Config_Manager();
	$dataset = $base->get_home_content();
	$row = $dataset->fetch_object();
	
	$result = array(
		"id"=>$row->id,
		"title"=>$row->title,
		"detail"=>$row->detail,
		"status"=>$row->status
	);

	global $result_code; //call global variable
	$result_code="0";
	return $result ;
	
}

function GetBraner(){
	
	$base = new Config_Manager();
	$dataset = $base->get_braner();
	$row = $dataset->fetch_object();
	
	$img = "../images/other/image-not-found.png";
	if($row->val!="")
		$img = "../".$row->val;
	

	$result = array(
		"id"=>$row->id,
		"thumbnail"=>$img,
		"status"=>$row->status
	);

	global $result_code; //call global variable
	$result_code="0";
	return $result ;
}

function initial_column(){
	$column = "<thead><tr>";
	$column .= "<th class='col-md-1'>ลำดับ</th>";
	$column .= "<th  >หัวข้อ</th>";
	$column .= "<th  >สถานะ</th>";
	$column .= "<th class='col-md-1'>สถานะ</th>";
	$column .= "<th class='col-md-3'></th>";
	$column .= "</tr></thead><tbody>";
	return $column;
}

function initial_column_pic_slider(){
	$column = "<thead><tr>";
	$column .= "<th class='col-md-1'>ลำดับ</th>";
	$column .= "<th  >picture</th>";
	$column .= "<th class='col-md-3'></th>";
	$column .= "</tr></thead><tbody>";
	return $column;
}



?>
