<?php
require_once("../../lib/database.php");
require_once("../../lib/logger.php");
class Category_Brand_Manager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial cate brand manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function insert_item($name,$cate_type,$status){
		
		try{
			
			$create_by = "0";
			$create_date = "now()";
			$sql = "insert into category_brand (name,cate_id,status,create_by,create_date) ";
			$sql .= "values('$name','$cate_type','$status','$create_by',$create_date )";
			
			log_warning("category brand> insert item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "INSERT SUCCESS.";
			}else{
				$result = "INSERT FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("category brand > insert item > error > " . $e->getMessage());
		}
		
	}
	
	function edit_item($id,$name,$cate_type,$status){
		
		try{

			$update_by = "0";
			$update_date = "now()";

			$sql = "update category_brand set ";
			$sql .= " name='$name' ";
			$sql .= ",cate_id='$cate_type' ";
			$sql .= ",status='$status' ";
			$sql .= ",update_by=$update_by ";
			$sql .= ",update_date=$update_date ";
			$sql .= " where id='".$id."';";
			 
			log_warning("category brand > edit item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("category brand > edit item > error > " .  $e->getMessage());
		}
		
	}
	
	function delete_item($id){
		
		try{
			
			$sql = "delete from category_brand ";
			$sql .= " where id='".$id."' ";
			
			log_warning("category brand> delete item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "DELETE SUCCESS.";
			}else{
				$result = "DELETE FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("category brand > delete item > error > " . $e->getMessage());
			//echo "Cannot insert_room_type : ".$e->getMessage();
		}
		
	}
	
	function get_item($id){
		try{
			
			
			$sql = "select brand.*,cate.name as cate_name from category_brand brand  ";
			$sql .= " inner join category cate on brand.cate_id = cate.id ";
			$sql .= "where brand.id='".$id."' ";
			log_warning("category brand > get item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("category brand > get item > error > " . $e->getMessage());
		}
	}

	function list_item($parentid){
		try{
			

			$sql = "select brand.*,cate.name as cate_name from category_brand brand  ";
			$sql .= "inner join category cate on brand.cate_id = cate.id ";
			
			if($parentid!=""){
				$sql .= " where brand.status=1 and cate_id=$parentid ";
			}

			log_warning("category brand > get list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("category brand > get list > error > " . $e->getMessage());
			//echo "Cannot insert_room_type : ".$e->getMessage();
		}
	}
}

?>