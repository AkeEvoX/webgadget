<?php
session_start();
include("../lib/common.php");
include("../managers/order_manager.php");

$service = GetParameter("type");
switch($service){
	case "confirm":
	
		$item = $_POST;
		$result = order_confirm($item);
	
	break;
	case "payment":
	
		$item = $_POST;
		$resul = order_payment($item);
		
	break;
}

function order_confirm($cust){
	
	$cart = $_SESSION["cart_list"];
	$summary = $_SESSION["cart_summary"];
	/* new order */
	$base = new Order_Manager();
	$running_no = $base->get_order_running()->fetch_object()->order_no;
	$order_no = (date('y')+43) . sprintf("%05d",$running_no); /*6000002*/
	
	$mobile = $cust["txtMobile"];
	$type_delivery = $summary["type_delivery"];
	$total_delivery = $summary["delivery"];
	$total_price = $summary["price"];
	$total_unit = $summary["unit"];
	$total_net = $summary["net"];
	
	$base->new_order($order_no,$mobile,$type_delivery,$total_delivery ,$total_price,$total_unit,$total_net);
	
	/*	insert order detail	*/	
	foreach($cart as $item){

		$base->new_order_detail(
		$order_no
		,$item["id"]
		,$item["price"]
		,$item["unit"]
		,$item["net"]
		,$item["color"]
		);
		
	} 
	
	$base->confirm_order(
		$order_no
		,$cust["txtFirstName"]
		,$cust["txtLastName"]
		,$cust["txtEmail"]
		,$cust["txtAddress"]
		,$cust["txtSoi"]
		,$cust["txtRoad"]
		,$cust["txtDistrict"]
		,$cust["txtSubDistrict"]
		,$cust["txtPostCode"]
		,$cust["ddlProvince"]
	); 
	
	/* get delivery type name */
	$data_delivery = $base->get_name_promotion($summary["type_delivery"]);
	$row_delivery = $data_delivery->fetch_object();
	
	$summary["delivery_name"] = $row_delivery->name;
	/* send email to confirm customer. */
	send_email_order($order_no,$cart,$cust,$summary);
	
	/*clear all session after order complete */
	session_destroy();
	
	header("Location: ../complete.html?id=".$order_no);
	
}

function order_payment($cust){
	
	$base = new Order_Manager();
	$order_id = $cust["txtOrder"];
	$verify = $base->verify_order_id($order_id);
	$verify_data= $verify->fetch_object();
	
	if($verify_data->result == "0"){
		echo "<script>alert('ขออภัย!! ไม่พบรหัสสั่งซื้อที่ทำการชำระ.'); window.history.back();</script>";
	}
	else if($verify_data->result =="1" && $verify_data->status == "1"){
		echo "<script>alert('ขออภัย!! รหัสสั่งซื้อนี้ทำการชำระเงินเรียบร้อยแล้ว.'); window.history.back();</script>";
	}
	else{
	
		$transfer_date =  date('Y-m-d H:i:00',strtotime(str_replace('/','-',$cust["txtDate"]))) ;
		$file_Instrument = "";
		
		if($_FILES['file_Instrument']['name']!=""){
			$name = $_FILES["file_Instrument"]["name"];
			$ext = end((explode(".", $name)));
			$file_Instrument = "images/instrument/".$cust["txtOrder"].".".$ext;
			$distination_th =  "../".$file_Instrument;
			$source_th = $_FILES['file_Instrument']['tmp_name'];
			upload_image($source_th,$distination_th);
			
			
			$base->payment_order(
				$order_id
				,$cust["txtCustName"]
				,$cust["txtMobile"]
				,$cust["txtAccount"]
				,$transfer_date
				,$cust["txtAmount"]
				,$file_Instrument
				,$cust["txtRemark"]
			); 
			//echo "<script>alert('ทำรายการเสร็จเรียบร้อย');</script>";
			header("Location: ../payment_success.html?id=".$order_id);
		}
		else{
			echo "<script>alert('ขออภัย!! กรุณาแนบหลักฐานการชำระเงิน.'); window.history.back();</script>";
		}
		
		
		
	}
	
}

function call_item($id){
	
	$base = new Product_Manager();
	$data = $base->get_item($id);
	$row = $data->fetch_object();
	$result = array(
		"code"=>$row->code
		,"title"=>$row->title
		,"price"=>$row->price
		,"active"=>$row->active
		,"update"=>$row->update_date
		,"detail"=>$row->detail
		);
	
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

function call_item_package($id,$money,$lang){
	
	$base = new Room_Manager();
	$data = $base->get_item_package($id,$lang);
	$row = $data->fetch_object();
	
	if($money==null){
		$money = $row->package_price;
	}
	
		$result = array(
			"id"=>$row->id,
			"title"=>$row->title,
			"price"=>$money,
			"food_service"=>$row->food_service,
			"cancel_room"=>$row->cancel_room,
			"payment_online"=>$row->payment_online,
			"max_person"=>$row->max_person,
			"extra_bed"=>$row->extra_bed,
			"extra_price_children"=>$row->extra_price_children,
			"extra_price_adults"=>$row->extra_price_adults,
			"detail"=>$row->detail,
			"conditions"=>$row->conditions);
	
	return $result;
}

//echo json_encode(array("data"=>$result));
function send_email_order($order_no,$cart, $cust,$summary){
	
	$customer_name = $cust["txtFirstName"] ." " .$cust["txtLastName"] ;
	
	$receive[] = array("email"=>$cust["txtEmail"],"alias"=>$customer_name);

	//$receive="svargalok@gmail.com";
	$sender = "services@centeraccessories888.com";
	$sender_name = "services@centeraccessories888.com";
	$subject = "แจ้งเลขที่สั่งซื้อ  ". $order_no;

	$message = file_get_contents("../order_notify.html");
	
	$message = str_replace("{order_no}",$order_no,$message);
	$message = str_replace("{customer_name}",$customer_name,$message);
	$message = str_replace("{customer_email}",$cust["txtEmail"] ,$message);
	$message = str_replace("{customer_addres}",$cust["txtAddress"] ,$message);
	$message = str_replace("{customer_soi}",$cust["txtSoi"] ,$message);
	$message = str_replace("{customer_road}",$cust["txtRoad"] ,$message);
	$message = str_replace("{customer_district}",$cust["txtDistrict"] ,$message);
	$message = str_replace("{customer_subdistrict}",$cust["txtSubDistrict"] ,$message);
	$message = str_replace("{customer_province}",$cust["txtPostCode"] ,$message);
	$message = str_replace("{customer_postcode}",$cust["ddlProvince"] ,$message);
	
	$message = str_replace("{total_price}",number_format((float)$summary["price"], 2, '.', ''),$message);
	$message = str_replace("{delivery_name}",$summary["delivery_name"] ,$message);
	$message = str_replace("{delivery_price}",$summary["delivery"] ,$message);
	$message = str_replace("{net_price}",number_format((float)$summary["net"], 2, '.', '') ,$message);
	
	//$cart[] = array("id"=>$id,"title"=>$title . $colorSelect ,"price"=>$price,"unit"=>$unit,"net"=>$net,"color"=>$color);	
	$order_list = "";
	foreach($cart as $item){
			$order_list .= "<tr><td >".$item["title"]."</td><td class='center'>".$item["unit"]."</td><td style='text-align:right;'>".number_format((float)$item["price"], 2, '.', '')."</td><td style='text-align:right;'>". number_format((float)$item["net"], 2, '.', '')."</td></tr>";
	}
	
	
	
	
	$message = str_replace("{order_list_detail}",$order_list,$message);
	
	SendMail($receive,$sender,$subject,$message,$sender_name);
	
}

?>