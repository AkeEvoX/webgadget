<?php
session_start();
include("../../lib/common.php");
include("../managers/news_manager.php");

#get parameter
$type = GetParameter("type");
$result_code = "-1";
//echo "type=".$type;
switch($type){
	case "list": 
		$result =  ListItem();
	break;
	case "listobject": 
		$result =  Listobject();
	break;
	case "type_news_object": 
		$result =  TypeNewsObject();
	break;
	case "item": 
		$result =  GetItem();
	break;
	case "create": 
		$result = CreateItem();
	break;
	case "modify" :
		$result = ModifyItem();
	break;
	case "remove" :
		$result = DeleteItem();
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

function ModifyItem(){
	
$base = new News_Manager();
$id = GetParameter("id");
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


$result = $base->edit_item($id,$title,$detail,$thumbnail,$type_new,$status);
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

function TypeNewsObject(){
	$base = new News_Manager();
	$dataset = $base->list_type_news();
	if($dataset){
		
		while($row = $dataset->fetch_object()){
			$result[] = array("id"=>$row->id ,"name"=>$row->title);
		}
	}

	global $result_code; //call global variable
	$result_code = "0";
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

?>
