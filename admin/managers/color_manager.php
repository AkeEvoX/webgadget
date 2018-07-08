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
			die("initial News manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function insert_item($title,$detail,$thumbnail,$type_new,$status){
		
		try{
			
			$create_by = "0";
			$create_date = "now()";
			$sql = "insert into news (title,detail,thumbnail,type_new,status,create_by,create_date ) ";
			$sql .= "values('$title','$detail','$thumbnail','$type_new','$status' ,$create_by,$create_date)  ";
			
			log_warning("news > insert item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "INSERT SUCCESS.";
			}else{
				$result = "INSERT FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("news > create item > error > " . $e->getMessage());
			//echo "Cannot insert_room_type : ".$e->getMessage();
		}
		
	}
	
	function edit_item($id,$title,$detail,$thumbnail,$type_new,$status){
		
		try{

			$update_by = "0";
			$update_date = "now()";

			$sql = "update news set ";
			$sql .= " title='$title' ";
			$sql .= ",detail='$detail' ";
			$sql .= ",thumbnail='$thumbnail' ";
			$sql .= ",type_new='$type_new' ";
			$sql .= ",status='$status' ";
			$sql .= ",update_by=$update_by ";
			$sql .= ",update_date=$update_date ";
			$sql .= " where id='".$id."';";
			
			log_warning("news > edit item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("news > update item > error > " . $e->getMessage());
		}
		
	}
	
	
	function delete_item($id){
		
		try{
			
			$sql = "delete from news ";
			$sql .= " where id='".$id."' ;";
			
			log_warning("news > delete item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "DELETE SUCCESS.";
			}else{
				$result = "DELETE FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("news > delete item > error > " . $e->getMessage());
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
	
	
	function list_type_news(){
		try{
			
			$sql = "select * from type_news ";;
			
			log_warning("news > get list type news> " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("news > get list type news > error > " . $e->getMessage());
		}
	}
}

?>