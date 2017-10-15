<?php
session_start();
include("../../lib/common.php");
include("../managers/category_model_manager.php");

#get parameter
$type = GetParameter("type");
$result_code = "-1";
//echo "type=".$type;
switch($type){
	case "list": 
		$result =  ListItem();
	break;
	case "listobject": 
		$parentid = GetParameter("parentid");
		$result =  Listobject($parentid);
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

$base = new Category_Model_Manager();
$name = GetParameter("name");
$cate_type = GetParameter("cate_type");
$cate_brand_type = GetParameter("cate_brand_type");
$status = (GetParameter("status")=="on") ? "1" : "0" ;

$result = $base->insert_item($name,$cate_brand_type,$status);

global $result_code; //call global variable
$result_code="0";

return $result;
}

function ModifyItem(){
	
$base = new Category_Model_Manager();
$id = GetParameter("id");
$name = GetParameter("name");
$cate_type = GetParameter("cate_type");
$cate_brand_type = GetParameter("cate_brand_type");
$status = (GetParameter("status")=="on") ? "1" : "0" ;


$result = $base->edit_item($id,$name,$cate_brand_type,$status);
global $result_code; //call global variable
$result_code="0";
return $result;
}

function DeleteItem(){
	$base = new Category_Model_Manager();
	$id = GetParameter("id");
	$base->delete_item($id);
	$result = "delete success";
	global $result_code; //call global variable
	$result_code="0";
	return $result;
}

function Listobject($parentid){

	$base = new Category_Model_Manager();
	$dataset = $base->list_item($parentid);
	if($dataset){
		
		while($row = $dataset->fetch_object()){
			$result[] = array("id"=>$row->id,"name"=>$row->cate_brand_name .' '.$row->name,"status"=>$row->status);
		}
	}

	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}

function ListItem(){
	
	$base = new Category_Model_Manager();
	$dataset = $base->list_item("");

	$result .= initial_column();

	if($dataset->num_rows===0){
		$result .= "<tr><td class='text-center' colspan='6'>ไม่พบข้อมูล</td></tr>";
	}
	else {
		
		while($row = $dataset->fetch_object()){
			
			$item_status = $row->status == 1? '<span class="glyphicon glyphicon-ok" style="color:green;" ></span>' : '<span class="glyphicon glyphicon-remove" style="color:red;" ></span>' ;
			$result .= "<tr>";
			$result .="<td>".$row->id."</td>";
			$result .="<td>".$row->cate_name."</td>";
			$result .="<td>".$row->cate_brand_name."</td>";
			$result .="<td>".$row->name."</td>";
			$result .="<td>".$item_status."</td>";
			$result .="<td><button class='btn btn-warning' data-id='".$row->id."' data-item='services/cate_model_service.php?type=item' data-page='cate_model_edit.html' data-title='Modify' onclick='page.modify(this);' ><span class='glyphicon glyphicon-pencil'></span> แก้ไข</button> ";
			$result .="<button class='btn btn-danger' data-id='".$row->id."' data-item='services/cate_model_service.php?type=item' data-page='cate_model_del.html' data-title='Remove' onclick='page.remove(this);'><span class='glyphicon glyphicon-trash'></span> ลบ</button></td>";
			$result .= "</tr>";
			
		}
	}

	$result .= "</tbody>";
	
	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}

function GetItem(){
	
	$base = new Category_Model_Manager();
	$id = GetParameter("id");
	$dataset = $base->get_item($id);
	$row = $dataset->fetch_object();

	$result = array(
		"id"=>$row->id,
		"name"=>$row->name,
		"cate_type"=>$row->cate_id,
		"cate_name"=>$row->cate_name,
		"cate_brand_type"=>$row->cate_brand_id,
		"cate_brand_name"=>$row->cate_brand_name,
		"status"=>$row->status
	);

	global $result_code; //call global variable
	$result_code="0";
	return $result ;
}

function initial_column(){
	$column = "<thead><tr>";
	$column .= "<th class='col-md-1'>ลำดับ</th>";
	$column .= "<th  >รายการประเภทสินค้า</th>";
	$column .= "<th  >รายการยี่ห้อสินค้า</th>";
	$column .= "<th  >รายการผลิตภัณฑ์สินค้า</th>";
	$column .= "<th class='col-md-1'>สถานะ</th>";
	$column .= "<th class='col-md-3'></th>";
	$column .= "</tr></thead><tbody>";
	return $column;
}

?>