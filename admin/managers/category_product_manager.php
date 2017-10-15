<?php
require_once("../../lib/database.php");
require_once("../../lib/logger.php");
class Category_Product_Manager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
		}
		catch(Exception $e)
		{
			die("initial category product manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function insert_item($code,$detail,$unit,$price,$cate_model_id,$pro_model_id,$thumbnail,$status){
		
		try{
			
			$create_by = "0";
			$create_date = "now()";

			$sql = "insert into category_product (code,detail,unit,price,cate_model_id,pro_model_id,thumbnail,status,create_by,create_date) ";
			$sql .= "values('$code','$detail','$unit','$price','$cate_model_id','$pro_model_id','$thumbnail','$status','$create_by',$create_date )";
			
			log_warning("category product > insert item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "INSERT SUCCESS.";
			}else{
				$result = "INSERT FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("category product > insert item > error > " . $e->getMessage());
		}
		
	}
	
	function edit_item($id,$code,$detail,$unit,$price,$cate_model_id,$pro_model_id,$thumbnail,$status){
		
		try{

			$update_by = "0";
			$update_date = "now()";

			$sql = "update category_product set ";
			$sql .= "code='$code' ";
			$sql .= ",detail='$detail' ";
			$sql .= ",unit='$unit' ";
			$sql .= ",price='$price' ";
			$sql .= ",cate_model_id='$cate_model_id' ";
			$sql .= ",pro_model_id='$pro_model_id' ";
			$sql .= ",status='$status' ";
			$sql .= ",update_by=$update_by ";
			$sql .= ",update_date=$update_date ";
			$sql .= " where id='".$id."';";
			 
			log_warning("category product > edit item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("category product > edit item > error > " .  $e->getMessage());
		}
		
	}
	
	function delete_item($id){
		
		try{
			
			$sql = "delete from category_product ";
			$sql .= " where id='".$id."' ";
			
			log_warning("category product > delete item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "DELETE SUCCESS.";
			}else{
				$result = "DELETE FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("category product > delete item > error > " . $e->getMessage());
		}
		
	}
	
	function get_item($id){
		
		try{

			$sql = " select pro.*,cate.id as cate_id,cate.name as cate_name,concat(cate_brand.name, ' ',cate_model.name) as cate_model_name ";
			$sql .= ",concat(pro_brand.name,' ',pro_model.name) as pro_model_name ";
			$sql .= "from category_product pro ";
			$sql .= "inner join category_model cate_model on cate_model.id = pro.cate_model_id ";
			$sql .= "left join category_brand cate_brand on cate_brand.id = cate_model.cate_brand_id ";
			$sql .= "left join category cate on cate.id = cate_brand.cate_id ";
			$sql .= "inner join product_model pro_model on pro_model.id = pro.pro_model_id ";
			$sql .= "left join product_brand pro_brand on pro_brand.id = pro_model.pro_brand_id ";
			$sql .= "where pro.id='".$id."' ;";

			log_warning("category product > get item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;

		}catch(Exception $e){
			log_debug("category product > get item > error > " . $e->getMessage());
		}
	}

	function list_item(){
		try{
			
			$sql = " select pro.*,cate.name as cate_name,concat(cate_brand.name, ' ',cate_model.name) as cate_model_name ";
			$sql .= ",concat(pro_brand.name,' ',pro_model.name) as pro_model_name ";
			$sql .= "from category_product pro ";
			$sql .= "inner join category_model cate_model on cate_model.id = pro.cate_model_id ";
			$sql .= "left join category_brand cate_brand on cate_brand.id = cate_model.cate_brand_id ";
			$sql .= "left join category cate on cate.id = cate_brand.cate_id ";
			$sql .= "inner join product_model pro_model on pro_model.id = pro.pro_model_id ";
			$sql .= "left join product_brand pro_brand on pro_brand.id = pro_model.pro_brand_id ;";

			log_warning("category product > get list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("category product > get list > error > " . $e->getMessage());
		}
	}
}

?>