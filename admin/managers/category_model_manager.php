<?php
require_once("../../lib/database.php");
require_once("../../lib/logger.php");
class Category_Model_Manager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
		}
		catch(Exception $e)
		{
			die("initial category model manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function insert_item($name,$cate_brand_type,$status){
		
		try{
			
			$create_by = "0";
			$create_date = "now()";
			$sql = "insert into category_model (name,cate_brand_id,status,create_by,create_date) ";
			$sql .= "values('$name','$cate_brand_type','$status','$create_by',$create_date )";
			
			log_warning("category model> insert item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "INSERT SUCCESS.";
			}else{
				$result = "INSERT FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("category model > insert item > error > " . $e->getMessage());
		}
		
	}
	
	function edit_item($id,$name,$cate_brand_type,$status){
		
		try{

			$update_by = "0";
			$update_date = "now()";

			$sql = "update category_model set ";
			$sql .= " name='$name' ";
			$sql .= ",cate_brand_id='$cate_brand_type' ";
			$sql .= ",status='$status' ";
			$sql .= ",update_by=$update_by ";
			$sql .= ",update_date=$update_date ";
			$sql .= " where id='".$id."';";
			 
			log_warning("category model > edit item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("category model > edit item > error > " .  $e->getMessage());
		}
		
	}
	
	function delete_item($id){
		
		try{
			
			$sql = "delete from category_model ";
			$sql .= " where id='".$id."' ";
			
			log_warning("category model > delete item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "DELETE SUCCESS.";
			}else{
				$result = "DELETE FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("category model > delete item > error > " . $e->getMessage());
		}
		
	}
	
	function get_item($id){
		try{

			$sql = " select cate.id as cate_id , cate.name as cate_name ,brand.name as cate_brand_name, model.* ";
			$sql .= "from category_model model ";
			$sql .= "inner join category_brand brand on model.cate_brand_id = brand.id ";
			$sql .= "inner join category cate on brand.cate_id = cate.id ";
			$sql .= "where model.id='".$id."' ";
			$sql .= "order by cate_name,cate_brand_name,name ";

			log_warning("category model > get item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("category model > get item > error > " . $e->getMessage());
		}
	}

	function list_item($parentid){
		try{
			

			$sql = " select cate.id as cate_id , cate.name as cate_name ,brand.name as cate_brand_name, model.* ";
			$sql .= "from category_model model ";
			$sql .= "inner join category_brand brand on model.cate_brand_id = brand.id ";
			$sql .= "inner join category cate on brand.cate_id = cate.id ";

			if($parentid!=""){
				$sql .= "where cate.id='$parentid' ";
			}

			$sql .= "order by cate_name,cate_brand_name,name ";

			log_warning("category model > get list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("category model > get list > error > " . $e->getMessage());
		}
	}
}

?>