<?php
session_start();
include("../../lib/common.php");
include("../managers/color_manager.php");

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
	case "type_color_object": 
		$result =  TypeColorObject();
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

$base = new Color_Manager();
$title = GetParameter("title");
$code = GetParameter("code");
$status = (GetParameter("status")=="on") ? "1" : "0" ;

$result = $base->insert_item($title,$code,$status);

global $result_code; //call global variable
$result_code="0";

return $result;
}

function ModifyItem(){
	
$base = new Color_Manager();
$id = GetParameter("id");
$title = GetParameter("title");
$code = GetParameter("code");
$status = (GetParameter("status")=="on") ? "1" : "0" ;

$result = $base->edit_item($id,$title,$code,$status);
global $result_code; //call global variable
$result_code="0";
return $result;
}

function DeleteItem(){
	$base = new Color_Manager();
	$id = GetParameter("id");
	$base->delete_item($id);
	$result = "delete success";
	global $result_code; //call global variable
	$result_code="0";
	return $result;
}

function TypeColorObject(){
	$base = new Color_Manager();
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

	$base = new Color_Manager();
	$dataset = $base->list_item();
	if($dataset){
		
		while($row = $dataset->fetch_object()){
			$result[] = array("id"=>$row->id
			,"title"=>$row->title
			,"code"=>$row->detail
			,"status"=>$row->status);
		}
	}

	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}

function ListItem(){
	
	$base = new Color_Manager();
	$dataset = $base->list_item();

	$result .= initial_column();

	if($dataset->num_rows===0){
		$result .= "<tr><td class='text-center' colspan='4'>ไม่พบข้อมูล</td></tr>";
	}
	else {
		
		while($row = $dataset->fetch_object()){
			
			$item_status = $row->active == 1? '<span class="glyphicon glyphicon-ok" style="color:green;" ></span>' : '<span class="glyphicon glyphicon-remove" style="color:red;" ></span>' ;
			$result .= "<tr>";
			$result .="<td>".$row->id."</td>";
			$result .="<td>".$row->title."</td>";
			$result .="<td><span class='circleBase' style='background-color:".$row->code."'>&nbsp;</span><span>".$row->code."</span></td>";
			$result .="<td>".$item_status."</td>";
			$result .="<td><button class='btn btn-warning' data-id='".$row->id."' data-item='services/color_service.php?type=item' data-page='color_edit.html' data-title='Modify' onclick='page.modify(this);' ><span class='glyphicon glyphicon-pencil'></span> แก้ไข</button> ";
			$result .="<button class='btn btn-danger' data-id='".$row->id."' data-item='services/color_service.php?type=item' data-page='color_del.html' data-title='Remove' onclick='page.remove(this);'><span class='glyphicon glyphicon-trash'></span> ลบ</button></td>";
			$result .= "</tr>";
			
		}
	}

	$result .= "</tbody>";
	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}

function GetItem(){
	
	$base = new Color_Manager();
	$id = GetParameter("id");
	$dataset = $base->get_item($id);
	$row = $dataset->fetch_object();

	//$status = $row->active == 1 ? true : false;

	$result = array(
		"id"=>$row->id,
		"title"=>$row->title,
		"code"=>$row->code,
		"update"=>$row->update_date,
		"status"=>$row->active 
	);

	global $result_code; //call global variable
	$result_code="0";
	return $result ;
}

function initial_column(){
	$column = "<thead><tr>";
	$column .= "<th class='col-md-1'>ลำดับ</th>";
	$column .= "<th  >ชื่อสี</th>";
	$column .= "<th  >รหัสสี</th>";
	$column .= "<th class='col-md-1'>สถานะ</th>";
	$column .= "<th class='col-md-3'></th>";
	$column .= "</tr></thead><tbody>";
	return $column;
}

?>
