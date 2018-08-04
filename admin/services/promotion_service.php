<?php
session_start();
include("../../lib/common.php");
include("../managers/promotion_manager.php");

#get parameter
$type = GetParameter("type");
$result_code = "-1";
//echo "type=".$type;
switch($type){
	case "list": 
		$result =  ListItem();
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

	$base = new Promotion_Manager();
	$name = GetParameter("promo_name");
	$minimum_price = GetParameter("minimum");
	$discount = GetParameter("discount");
	$price = GetParameter("price");
	$status = (GetParameter("status")=="on") ? "1" : "0" ;

	$result = $base->insert_item($name,$minimum_price,$discount,$price,$status);

	global $result_code; //call global variable
	$result_code="0";

	return $result;
}

function ModifyItem(){
	
	$base = new Promotion_Manager();
	$id = GetParameter("id");
	$name = GetParameter("promo_name");
	$minimum_price = GetParameter("minimum");
	$discount = GetParameter("discount");
	$price = GetParameter("price");
	$status = (GetParameter("status")=="on") ? "1" : "0" ;

	$result = $base->edit_item($id,$name,$minimum_price,$discount,$price,$status);
	global $result_code; //call global variable
	$result_code="0";
	return $result;
}

function DeleteItem(){
	$base = new Promotion_Manager();
	$id = GetParameter("id");
	$base->delete_item($id);
	$result = "delete success";
	global $result_code; //call global variable
	$result_code="0";
	return $result;
}

function ListItem(){
	
	$base = new Promotion_Manager();
	$dataset = $base->list_item();

	$result .= initial_column();

	if($dataset->num_rows===0){
		$result .= "<tr><td class='text-center' colspan='5'>ไม่พบข้อมูล</td></tr>";
	}
	else {
		
		while($row = $dataset->fetch_object()){
			
			$item_status = $row->status == 1? '<span class="glyphicon glyphicon-ok" style="color:green;" ></span>' : '<span class="glyphicon glyphicon-remove" style="color:red;" ></span>' ;
			$result .= "<tr>";
			$result .="<td>".$row->id."</td>";
			$result .="<td>".$row->name."</td>";
			$result .="<td>".$row->minimum_price."</td>";
			$result .="<td>".$row->discount."</td>";
			$result .="<td>".$row->price."</td>";
			$result .="<td>".$item_status."</td>";
			$result .="<td><button class='btn btn-warning' data-id='".$row->id."' data-item='services/promotion_service.php?type=item' data-page='promotion_edit.html' data-title='Modify' onclick='page.modify(this);' ><span class='glyphicon glyphicon-pencil'></span> แก้ไข</button> ";
			$result .="<button class='btn btn-danger' data-id='".$row->id."' data-item='services/promotion_service.php?type=item' data-page='promotion_del.html' data-title='Remove' onclick='page.remove(this);'><span class='glyphicon glyphicon-trash'></span> ลบ</button></td>";
			$result .= "</tr>";
			
		}
	}

	$result .= "</tbody>";
	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}

function GetItem(){
	
	$base = new Promotion_Manager();
	$id = GetParameter("id");
	$dataset = $base->get_item($id);
	$row = $dataset->fetch_object();

	$result = array(
		"id"=>$row->id,
		"promo_name"=>$row->name,
		"minimum"=>$row->minimum_price,
		"discount"=>$row->discount,
		"price"=>$row->price,
		"status"=>$row->status
	);

	global $result_code; //call global variable
	$result_code="0";
	return $result ;
}

function initial_column(){
	$column = "<thead><tr>";
	$column .= "<th class='col-md-1'>ลำดับ</th>";
	$column .= "<th  >โปรโมชั่น</th>";
	$column .= "<th  >ขั้นต่ำ</th>";
	$column .= "<th  >ส่วนลด</th>";
	$column .= "<th  >ราคา</th>";
	$column .= "<th class='col-md-1'>สถานะ</th>";
	$column .= "<th class='col-md-3'></th>";
	$column .= "</tr></thead><tbody>";
	return $column;
}

?>
