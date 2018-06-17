<?php
require_once("../../lib/database.php");
require_once("../../lib/logger.php");
class Product_Model_Manager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial product model manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function insert_item($name,$brand_type,$status){
		
		try{
			
			$create_by = "0";
			$create_date = "now()";
			$sql = "insert into product_model (name,pro_brand_id,status,create_by,create_date) ";
			$sql .= "values('$name','$brand_type','$status','$create_by','$create_date' )";
			
			log_warning("product model > insert item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "INSERT SUCCESS.";
			}else{
				$result = "INSERT FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("product model > insert item > error > " . $e->getMessage());
		}
		
	}
	
	function edit_item($id,$name,$pro_brand_id,$status){
		
		try{

			$update_by = "0";
			$update_date = "now()";

			$sql = "update product_model set ";
			$sql .= " name='$name' ";
			$sql .= ",pro_brand_id='$pro_brand_id' ";
			$sql .= ",status='$status' ";
			$sql .= ",update_by=$update_by ";
			$sql .= ",update_date=$update_date ";
			$sql .= " where id='".$id."';";
			 
			log_warning("product model > edit item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("product model > edit item > error > " .  $e->getMessage());
		}
		
	}
	
	function delete_item($id){
		
		try{
			
			$sql = "delete from product_model ";
			$sql .= " where id='".$id."' ";
			
			log_warning("product model > delete item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "DELETE SUCCESS.";
			}else{
				$result = "DELETE FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("product model > delete item > error > " . $e->getMessage());
			
		}
		
	}
	
	function get_item($id){
		try{

			$sql = "select model.*,brand.`name` as brand_name from product_model model ";
			$sql .= " left join product_brand brand on model.pro_brand_id = brand.id ";
			$sql .= "where model.id='".$id."' ";
			log_warning("product model > get item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("product model > get item > error > " . $e->getMessage());
		}
	}

	function list_item(){
		try{
			

			$sql = "select model.*,brand.`name` as brand_name from product_model model ";
			$sql .= " left join product_brand brand on model.pro_brand_id = brand.id ";
			log_warning("product model > get list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("product model > get list > error > " . $e->getMessage());
			
		}
	}
}

?>