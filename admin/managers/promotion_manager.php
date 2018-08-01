<?php
require_once("../../lib/database.php");
require_once("../../lib/logger.php");
class Promotion_Manager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial Promotion manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function insert_item($name,$minimum_price,$discount,$status){
		
		try{
			
			$create_by = "0";
			$create_date = "now()";
			$sql = "insert into promotions (name,minimum_price,discount,status,create_by,create_date ) ";
			$sql .= "values('$name','$minimum_price','$discount','$status' ,$create_by,$create_date)  ";
			
			log_warning("promotion > insert item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "INSERT SUCCESS.";
			}else{
				$result = "INSERT FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("promotion > create item > error > " . $e->getMessage());
			//echo "Cannot insert_room_type : ".$e->getMessage();
		}
		
	}
	
	function edit_item($id,$name,$minimum_price,$discount,$status){
		
		try{

			$update_by = "0";
			$update_date = "now()";

			$sql = "update promotions set ";
			$sql .= " name='$name' ";
			$sql .= ",minimum_price='$minimum_price' ";
			$sql .= ",discount='$discount' ";
			$sql .= ",status='$status' ";
			$sql .= ",update_by=$update_by ";
			$sql .= ",update_date=$update_date ";
			$sql .= " where id='".$id."';";
			
			log_warning("promotion > edit item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("promotion > update item > error > " . $e->getMessage());
		}
		
	}
	
	
	function delete_item($id){
		
		try{
			
			$sql = "delete from promotions ";
			$sql .= " where id='".$id."' ;";
			
			log_warning("promotion > delete item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "DELETE SUCCESS.";
			}else{
				$result = "DELETE FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("promotion > delete item > error > " . $e->getMessage());
		}
		
	}
	
	function get_item($id){
		try{
			$sql = "select * from promotions ";
			$sql .=" where id='$id' ;" ; 

			log_warning("promotion > get item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("promotion > get item > error > " . $e->getMessage());
		}
	}

	function list_item(){
		try{
			
			$sql = "select * from promotions ";
			
			log_warning("promotion > get list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("promotion > get list > error > " . $e->getMessage());
		}
	}
}

?>