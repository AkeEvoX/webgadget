<?php
session_start();
include("../../lib/common.php");
include("../managers/order_manager.php");

#get parameter
$type = GetParameter("type");
$result_code = "-1";

switch($type){
	case "list": 
		$result =  ListItem();
	break;
	case "list_payment": 
		$result =  ListPayment();
	break;
	case "list_confirm": 
		$result =  ListConfirm();
	break;
	case "list_status": 
		$result =  ListStatus();
	break;
	case "detail": 
		$result =  ListDetail();
	break;
	case "modify" :
		$result = ModifyItem();
	break;
	case "item" :
		$result = GetItem();
	break;
	case "payment" :
		$result = GetPayment();
	break;

}

echo json_encode(array("result"=> $result ,"code"=>$result_code));

function ModifyItem(){
	
	$base = new Order_Manager();
	$id = GetParameter("id");
	$status_type = GetParameter("status_type");
	$deliver_id = GetParameter("deliver_id");
	$result = $base->edit_item($id,$status_type,$deliver_id);

	if($deliver_id!=""){
		//send mail notify id ems or thai post
		
	}

	global $result_code; //call global variable
	$result_code="0";
	return $result;
}
function ListConfirm(){
	
	$base = new Order_Manager();
	$dataset = $base->list_confirm();

	$result .= initial_column();

	if($dataset->num_rows===0){
		$result .= "<tr><td class='text-center' colspan='8'>ไม่พบข้อมูล</td></tr>";
	}
	else {
		
		while($row = $dataset->fetch_object()){
			
			$result .= "<tr>";
			$result .="<td>".$row->id."</td>";
			$result .="<td>".full_date_format($row->create_date,'th')."</td>";
			$result .="<td>".$row->customer_name."</td>";
			$result .="<td>".$row->customer_mobile."</td>";
			$result .="<td>".$row->deliver_by."</td>";
			$result .="<td>".$row->total_net."</td>";
			$result .="<td>".$row->status_name."</td>";
			$result .="<td><button class='btn btn-warning' data-id='".$row->id."' data-item='services/order_service.php?type=item' data-page='order_view.html' data-title='ข้อมูลสั่งซื้อ' onclick='page.modify(this);' ><span class='glyphicon glyphicon-pencil'></span> ดูข้อมูล</button></td> ";
			//$result .="<button class='btn btn-danger' data-id='".$row->id."' data-item='services/bed_service.php?type=item' data-page='bed_del.html' data-title='Remove' onclick='page.remove(this);'><span class='glyphicon glyphicon-trash'></span> Del</button></td>";
			$result .= "</tr>";
			
		}
	}
	$result .= "</tbody>";
	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}
function ListPayment(){
	
	$base = new Order_Manager();
	$dataset = $base->list_payment();

	$result .= initial_column();

	if($dataset->num_rows===0){
		$result .= "<tr><td class='text-center' colspan='8'>ไม่พบข้อมูล</td></tr>";
	}
	else {
		
		while($row = $dataset->fetch_object()){
			
			$result .= "<tr>";
			$result .="<td>".$row->id."</td>";
			$result .="<td>".full_date_format($row->create_date,'th')."</td>";
			$result .="<td>".$row->customer_name."</td>";
			$result .="<td>".$row->customer_mobile."</td>";
			$result .="<td>".$row->deliver_by."</td>";
			$result .="<td>".$row->total_net."</td>";
			$result .="<td>".$row->status_name."</td>";
			$result .="<td><button class='btn btn-warning' data-id='".$row->id."' data-item='services/order_service.php?type=item' data-page='order_view.html' data-title='ข้อมูลสั่งซื้อ' onclick='page.modify(this);' ><span class='glyphicon glyphicon-pencil'></span> ดูข้อมูล</button></td> ";
			//$result .="<button class='btn btn-danger' data-id='".$row->id."' data-item='services/bed_service.php?type=item' data-page='bed_del.html' data-title='Remove' onclick='page.remove(this);'><span class='glyphicon glyphicon-trash'></span> Del</button></td>";
			$result .= "</tr>";
			
		}
	}

	$result .= "</tbody>";
	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}

function ListItem(){
	
	$base = new Order_Manager();
	$dataset = $base->list_order();

	$result .= initial_column();

	if($dataset->num_rows===0){
		$result .= "<tr><td class='text-center' colspan='8'>ไม่พบข้อมูล</td></tr>";
	}
	else {
		
		while($row = $dataset->fetch_object()){
			
			$result .= "<tr>";
			$result .="<td>".$row->id."</td>";
			$result .="<td>".full_date_format($row->create_date,'th')."</td>";
			$result .="<td>".$row->customer_name."</td>";
			$result .="<td>".$row->customer_mobile."</td>";
			$result .="<td>".$row->deliver_by."</td>";
			$result .="<td>".$row->total_net."</td>";
			$result .="<td>".$row->status_name."</td>";
			$result .="<td><button class='btn btn-warning' data-id='".$row->id."' data-item='services/order_service.php?type=item' data-page='order_view.html' data-title='ข้อมูลสั่งซื้อ' onclick='page.modify(this);' ><span class='glyphicon glyphicon-pencil'></span> ดูข้อมูล</button></td> ";
			//$result .="<button class='btn btn-danger' data-id='".$row->id."' data-item='services/bed_service.php?type=item' data-page='bed_del.html' data-title='Remove' onclick='page.remove(this);'><span class='glyphicon glyphicon-trash'></span> Del</button></td>";
			$result .= "</tr>";
			
		}
	}

	$result .= "</tbody>";

	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}

function ListDetail(){
	$id = GetParameter('id');
	$base = new Order_Manager();
	$dataset = $base->list_detail($id);

	$result .= initial_column_detail();


	if($dataset->num_rows===0){
		$result .= "<tr><td class='text-center' colspan='8'>ไม่พบข้อมูล</td></tr>";
	}
	else {
		
		while($row = $dataset->fetch_object()){

			$result .= "<tr>";
			$result .="<td>".$row->code."</td>";
			$result .="<td>".$row->cate_name."</td>";
			$result .="<td>".$row->cate_model_name."</td>";
			$result .="<td>".$row->pro_model_name."</td>";
			$result .="<td>".$row->prod_price."</td>";
			$result .="<td>".$row->prod_unit."</td>";
			$result .="<td>".$row->prod_net."</td>";
			$result .= "</tr>";
			
		}

	}

	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}

function GetItem(){
	
	$base = new Order_Manager();
	$id = GetParameter("id");
	$dataset = $base->get_item($id);
	$row = $dataset->fetch_object();
	$result = array(
		"id"=>$row->id,
		"unit"=>$row->unit,
		"total_price"=>$row->total_price,
		"total_deliver"=>$row->total_deliver,
		"total_net"=>$row->total_net,
		"customer_mobile"=>$row->customer_mobile,
		"customer_name"=>$row->customer_name,
		"deliver_id"=>$row->deliver_id,
		"deliver_by"=>$row->deliver_by,
		"status_type"=>$row->status,
		"order_date"=>full_date_format($row->create_date,'th')
	);
	global $result_code; //call global variable
	$result_code="0";
	return $result ;
}

function GetPayment(){

	$base = new Order_Manager();
	$id = GetParameter("id");
	$dataset = $base->get_payment($id);
	$row = $dataset->fetch_object();
	$result = array(
		"payer_name"=>$row->customer_name,
		"payer_mobile"=>$row->mobile,
		"additional"=>$row->additional,
		"transfer_account"=>$row->transfer_account,
		"transfer_date"=>full_date_format($row->transfer_date,'th'),
		"transfer_amount"=>$row->transfer_amount,
		"transfer_instrument"=>"../".$row->transfer_Instrument
	);
	global $result_code; //call global variable
	$result_code="0";
	return $result ;
}

function ListStatus(){
	
	$base = new Order_Manager();
	$dataset = $base->get_status();

	while($row = $dataset->fetch_object()){

		$result[] = array(
			"id"=>$row->id,
			"name"=>$row->name
		);
	}


	global $result_code; //call global variable
	$result_code="0";
	return $result ;
}

function initial_column(){
	$column = "<thead><tr>";
	$column .= "<th class='col-md-1'>รหัสสั่งซื้อ</th>";
	$column .= "<th class='col-md-3'>วันที่</th>";
	$column .= "<th class='col-md-2'>ชื่อลูกค้า</th>";
	$column .= "<th class='col-md-1'>เบอร์โทร</th>";
	$column .= "<th class='col-md-3'>ประเภทจัดส่ง</th>";
	$column .= "<th class='col-md-1'>รวมราคา</th>";
	$column .= "<th class='col-md-2'>สถานะ</th>";
	$column .= "<th></th>";
	$column .= "</tr></thead><tbody>";
	return $column;
}

function initial_column_detail(){
	$column = "<tr>";
	$column .= "<th class='col-md-2'>รหัสสินค้า</th>";
	$column .= "<th class='col-md-2'>ประเภท</th>";
	$column .= "<th class='col-md-2'>สินค้า</th>";
	$column .= "<th class='col-md-2'>อุปกรณ์</th>";
	$column .= "<th class='col-md-1'>ราคา</th>";
	$column .= "<th class='col-md-1'>จำนวน</th>";
	$column .= "<th class='col-md-2'>รวมราคา</th>";
	$column .= "<th></th>";
	$column .= "</tr>";
	return $column;
}

?>