<?php
require_once("../../lib/database.php");
require_once("../../lib/logger.php");
class Category_Manager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial cate manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function insert_item($name,$status){
		
		try{
			
			$create_by = "0";
			$create_date = "now()";
			$sql = "insert into category (name,status,create_by,create_date) ";
			$sql .= "values('$name','$status','$create_by','$create_date' )";
			
			log_warning("category > insert item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "INSERT SUCCESS.";
			}else{
				$result = "INSERT FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("category > insert item > error > " . $e->getMessage());
		}
		
	}
	
	function edit_item($id,$name,$status){
		
		try{

			$update_by = "0";
			$update_date = "now()";

			$sql = "update category set ";
			$sql .= " name='$name' ";
			$sql .= ",status='$status' ";
			$sql .= ",update_by=$update_by ";
			$sql .= ",update_date=$update_date ";
			$sql .= " where id='".$id."';";
			
			log_warning("category > edit item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("category > edit item > error > " .  $e->getMessage());
		}
		
	}
	
	function delete_item($id){
		
		try{
			
			$sql = "delete from category ";
			$sql .= " where id='".$id."' ";
			
			log_warning("category > delete item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "DELETE SUCCESS.";
			}else{
				$result = "DELETE FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("category > delete item > error > " . $e->getMessage());
			//echo "Cannot insert_room_type : ".$e->getMessage();
		}
		
	}
	
	function get_item($id){
		try{
			
			$sql = "select * from  category where id='".$id."' ";
			log_warning("category > get item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("category > get item > error > " . $e->getMessage());
		}
	}

	function list_item(){
		try{
			
			$sql = "select id,name,status ";
			$sql .= " from category; ";
			log_warning("category > get list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("category > get list > error > " . $e->getMessage());
			//echo "Cannot insert_room_type : ".$e->getMessage();
		}
	}
}

?>