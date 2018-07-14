<?php
require_once("../../lib/database.php");
require_once("../../lib/logger.php");
class Color_Manager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial Color manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function insert_item($title,$code,$status){
		
		try{
			
			$create_by = "0";
			$create_date = "now()";
			
			$sql = "insert into type_color (title,code,active,create_by,create_date ) ";
			$sql .= "values('$title','$code','$status' ,$create_by,$create_date)  ";
			
			log_warning("color > insert item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "INSERT SUCCESS.";
			}else{
				$result = "INSERT FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("color > create item > error > " . $e->getMessage());
		}
		
	}
	
	function edit_item($id,$title,$code,$status){
		
		try{

			$update_by = "0";
			$update_date = "now()";
			
			$sql ="UPDATE type_color ";
			$sql .= "SET title = '$title', ";
			$sql .= "CODE = '$code', ";
			$sql .= "active = '$status',  ";
			$sql .= "update_by = '$update_by',  ";
			$sql .= "update_date = '".$update_date."' ";
			$sql .= "WHERE ";
			$sql .= "id ='".$id."' ; ";

			log_warning("color > edit item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("color > update item > error > " . $e->getMessage());
		}
		
	}
	
	
	function delete_item($id){
		
		try{
			
			$sql = "delete from type_color ";
			$sql .= " where id='".$id."' ;";
			
			log_warning("color > delete item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "DELETE SUCCESS.";
			}else{
				$result = "DELETE FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("color > delete item > error > " . $e->getMessage());
		}
		
	}
	
	function get_item($id){
		try{
			$sql = "select * from type_color ";
			$sql .=" where id='$id' ;" ; 

			log_warning("color > get item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("color > get item > error > " . $e->getMessage());
		}
	}

	function list_item(){
		try{
			
			$sql = "select * from type_color ";
			
			log_warning("color > get list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("color > get list > error > " . $e->getMessage());
		}
	}
	
}

?>