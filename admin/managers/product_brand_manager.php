<?php
require_once("../../lib/database.php");
require_once("../../lib/logger.php");
class Product_Brand_Manager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial product brand manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function insert_item($name,$status){
		
		try{
			
			$create_by = "0";
			$create_date = "now()";
			$sql = "insert into product_brand (name,status,create_by,create_date) ";
			$sql .= "values('$name','$status','$create_by','$create_date' )";
			
			log_warning("product brand > insert item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "INSERT SUCCESS.";
			}else{
				$result = "INSERT FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("product brand > insert item > error > " . $e->getMessage());
		}
		
	}
	
	function edit_item($id,$name,$status){
		
		try{

			$update_by = "0";
			$update_date = "now()";

			$sql = "update product_brand set ";
			$sql .= " name='$name' ";
			$sql .= ",status='$status' ";
			$sql .= ",update_by=$update_by ";
			$sql .= ",update_date=$update_date ";
			$sql .= " where id='".$id."';";
			
			log_warning("product brand > edit item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("product brand > edit item > error > " .  $e->getMessage());
		}
		
	}
	
	function delete_item($id){
		
		try{
			
			$sql = "delete from product_brand ";
			$sql .= " where id='".$id."' ";
			
			log_warning("product brand > delete item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "DELETE SUCCESS.";
			}else{
				$result = "DELETE FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("product brand > delete item > error > " . $e->getMessage());
		}
		
	}
	
	function get_item($id){
		try{
			
			$sql = "select * from  product_brand where id='".$id."' ";
			log_warning("product brand > get item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("product brand > get item > error > " . $e->getMessage());
		}
	}

	function list_item(){
		try{
			
			$sql = "select id,name,icon,status ";
			$sql .= " from product_brand; ";
			log_warning("product brand > get list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("product brand > get list > error > " . $e->getMessage());
		}
	}
}

?>