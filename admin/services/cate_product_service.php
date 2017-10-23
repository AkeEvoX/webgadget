<?php
session_start();
include("../../lib/common.php");
include("../managers/category_product_manager.php");

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
	case "item": 
		$result =  GetItem();
	break;
	case "create": 
		$result = CreateItem();
	break;
	case "create_multi": 
		$result = Create_Item_Multi();
	break;
	case "modify" :
		$result = ModifyItem();
	break;
	case "remove" :
		$result = DeleteItem();
	break;
	case "upload_gallery" :
		$result = call_upload_gallery($_POST);
	break;
	case "list_gallery" :
		$id = GetParameter("id");
		$result = ListGallery($id);
	break;
}

echo json_encode(array("result"=> $result ,"code"=>$result_code));

function CreateItem(){

	$base = new Category_Product_Manager();
	$code = GetParameter("code");
	$detail = GetParameter("detail");
	$unit = GetParameter("unit");
	$price = GetParameter("price");
	$cate_model_id = GetParameter("cate_model_type");
	$pro_model_id = GetParameter("pro_model_type");
	$status = (GetParameter("status")=="on") ? "1" : "0" ;


if($_FILES['thumbnail']['name']!=""){
	
	$dir = "images/products/thumbnail/" ; 
	$ext = pathinfo($_FILES['thumbnail']['name'],PATHINFO_EXTENSION);
	$filename = $dir.date('ymdhisu').".".$ext;
	$distination =  "../../".$filename;
	$source = $_FILES['thumbnail']['tmp_name'];  
	$thumbnail = $filename;
	upload_image($source,$distination);
}

	$result = $base->insert_item($code,$detail,$unit,$price,$cate_model_id,$pro_model_id,$thumbnail,$status);

	global $result_code; //call global variable
	$result_code="0";

	return $result;
}

function Create_Item_Multi(){
	
	$base = new Category_Product_Manager();
	$cate_model_id = GetParameter("cate_model_type");
	$pro_model_id = GetParameter("pro_model_type");
	
	
	foreach($pro_model_id as $id){
		
		$verify = $base->verify_duplicate($cate_model_id,$id);
		$check = $verify->fetch_object();
		if($check->found=="0"){
			//echo "new item > ".$cate_model_id."|".$id;
			$result = $base->insert_multi_item($cate_model_id,$id);
		}
		else{
			//echo "duplicate > ".$cate_model_id."|".$id;
		}
		
	}
	
	global $result_code; //call global variable
	$result_code="0";
	return $result;
	
}
function ModifyItem(){
	
	$base = new Category_Product_Manager();
	$id = GetParameter("id");
	$code = GetParameter("code");
	$detail = GetParameter("detail");
	$unit = GetParameter("unit");
	$price = GetParameter("price");
	$cate_model_id = GetParameter("cate_model_type");
	$pro_model_id = GetParameter("pro_model_type");
	$status = (GetParameter("status")=="on") ? "1" : "0" ;


if($_FILES['thumbnail']['name']!=""){
	
	$dir = "images/products/thumbnail/" ; 
	$ext = pathinfo($_FILES['thumbnail']['name'],PATHINFO_EXTENSION);
	$filename = $dir.date('ymdhisu').".".$ext;
	$distination =  "../../".$filename;
	$source = $_FILES['thumbnail']['tmp_name'];  
	$thumbnail = $filename;
	upload_image($source,$distination);
}

	$result = $base->edit_item($id,$code,$detail,$unit,$price,$cate_model_id,$pro_model_id,$thumbnail,$status);
	global $result_code; //call global variable
	$result_code="0";
	return $result;
}

function DeleteItem(){
	$base = new Category_Product_Manager();
	$id = GetParameter("id");
	$base->delete_item($id);
	$result = "delete success";
	global $result_code; //call global variable
	$result_code="0";
	return $result;
}

function Listobject(){

	$base = new Category_Product_Manager();
	$dataset = $base->list_item();
	if($dataset){
		
		while($row = $dataset->fetch_object()){
			$result[] = array("id"=>$row->id,"name"=>$row->name,"status"=>$row->status);
		}
	}

	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}


function call_upload_gallery($args){
	
	$base = new Category_Product_Manager();
	$total = count($_FILES['file_image']['name']);
	$id = $args["id"];
	
	for($i=0;$i<$total;$i++){
		
		$source  = $_FILES['file_image']['tmp_name'][$i];
		if($source!=""){
			
			$name = $_FILES['file_image']['name'][$i];
			$dir =  "images/products/".$id."/";
			createdir("../../".$dir);
			$ext = pathinfo($_FILES['file_image']['name'][$i],PATHINFO_EXTENSION);
			$filename = date("s").gettimeofday()["usec"].".".$ext;
			//$filename = date('ymdhisu').".".$ext;
			$distination =  "../../".$dir.$filename;
			
			upload_image($source,$distination);
			$result = $base->insert_gallery($id,$dir.$filename);
		}
	}
	
	return "upload complete";
	
}

function ListGallery($id){
	
	$base = new Category_Product_Manager();
	$dataset = $base->list_gallery($id);
	
	if($dataset->num_rows===0){
		$result .= "ไม่พบรูปภาพ";
	}
	else {
		while($row = $dataset->fetch_object()){
			$result.= "<div class='col-md-4'><img class='img-responsive' src='../".$row->url."' /></div>";
		}
	}
	
	return $result;
}

function ListItem(){
	
	$base = new Category_Product_Manager();
	$dataset = $base->list_item();

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
			$result .="<td>".$row->cate_model_name."</td>";
			$result .="<td>".$row->pro_model_name."</td>";
			$result .="<td>".$item_status."</td>";
			$result .="<td><button class='btn btn-warning' data-id='".$row->id."' data-item='services/cate_product_service.php?type=item' data-page='cate_pro_edit.html' data-title='Modify' onclick='page.modify(this);' ><span class='glyphicon glyphicon-pencil'></span> แก้ไข</button> ";
			$result .="<button class='btn btn-danger' data-id='".$row->id."' data-item='services/cate_product_service.php?type=item' data-page='cate_pro_del.html' data-title='Remove' onclick='page.remove(this);'><span class='glyphicon glyphicon-trash'></span> ลบ</button></td>";
			$result .= "</tr>";
			
		}
	}
	$result .= "</tbody>";
	
	global $result_code; //call global variable
	$result_code = "0";
	return $result;
}

function GetItem(){
	
	$base = new Category_Product_Manager();
	$id = GetParameter("id");
	$dataset = $base->get_item($id);
	$row = $dataset->fetch_object();

	$result = array(
		"id"=>$row->id,
		"code"=>$row->code,
		"detail"=>$row->detail,
		"thumbnail_view"=>$row->thumbnail,
		"unit"=>$row->unit,
		"price"=>$row->price,
		"product_gallery"=>ListGallery($row->id),
		"cate_type"=>$row->cate_id,
		"cate_name"=>$row->cate_name,
		"cate_model_type"=>$row->cate_model_id,
		"cate_model_name"=>$row->cate_model_name,
		"pro_model_type"=>$row->pro_model_id,
		"pro_model_name"=>$row->pro_model_name,
		"status"=>$row->status
	);

	global $result_code; //call global variable
	$result_code="0";
	return $result ;
}

function initial_column(){
	$column = "<thead><tr>";
	$column .= "<th class='col-md-1'>index</th>";
	$column .= "<th  >ประเภทสินค้า</th>";
	$column .= "<th  >สินค้า</th>";
	$column .= "<th  >อุปกรณ์</th>";
	$column .= "<th class='col-md-1'>สถานะ</th>";
	$column .= "<th class='col-md-2'></th>";
	$column .= "</tr></thead><tbody>";
	return $column;
}

?>