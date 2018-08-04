<?php
require_once("../../lib/database.php");
require_once("../../lib/logger.php");
class Config_Manager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial config manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	/* certficate */
	
	function modify_certificate($id,$detail,$thumbnail,$status){
			try{
			
			$update_by = "0";
			$update_date = "now()";
			
			$sql = "update page_config set ";
			$sql .= " detail='$detail' ";
			
			if($thumbnail!='')
				$sql .= ",val='$thumbnail'  ";
			
			$sql .= ",status='$status'  ";
			$sql .= " where id='".$id."'; ";
			
			log_warning("certificate > modify > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("certificate > modify > error > " . $e->getMessage());
		}
	}
	
	function get_certificate(){
			try{
			
			$sql = "select id,title,detail,val,status ";
			$sql .= "from page_config where type_conf='1';  ";
			
			log_warning("config > get certificate > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("user > get certificate > error > " . $e->getMessage());
		}
	}
	
	function modify_home_content($id,$detail,$status){
			try{
			
			$update_by = "0";
			$update_date = "now()";
			
			$sql = "update page_config set ";
			$sql .= " detail='$detail' ";
			$sql .= ",status='$status'  ";
			$sql .= " where id='".$id."'; ";
			
			log_warning("home content > modify > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("home content > modify > error > " . $e->getMessage());
		}
	}
	
	function get_home_content(){
			try{
			
			$sql = "select id,title,detail,val,status ";
			$sql .= "from page_config where type_conf='4';  ";
			
			log_warning("config > get home content > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("user > get home content > error > " . $e->getMessage());
		}
	}
	
	/* braner */
	function modify_braner($id,$thumbnail,$status){
		
		try{
			
			$update_by = "0";
			$update_date = "now()";
			
			$sql = "update page_config set ";
			$sql .= "status='$status'  ";
			if($thumbnail!='')
				$sql .= ",val='$thumbnail'  ";
			
			$sql .= " where id='".$id."'; ";
			
			log_warning("braner > modify > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("braner > modify > error > " . $e->getMessage());
		}
		
	}
	
	function get_braner(){
		try{
			
			$sql = "select id,title,detail,val,status ";
			$sql .= "from page_config where type_conf='3';  ";
			
			log_warning("config > get braner > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("user > get braner > error > " . $e->getMessage());
		}
	}
	/* picture slider */
	function create_picture_slide($val){
		try{
			
			$create_by = "0";
			$create_date = "now()";
			$sql = "insert into page_config (title,detail,val,status,type_conf,create_by,create_date ) ";
			$sql .= "values('picture slide','-','$val','1','2',$create_by,$create_date)  ";
			
			log_warning("picture slide > insert > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "INSERT SUCCESS.";
			}else{
				$result = "INSERT FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("picture slide > insert  > error > " . $e->getMessage());
			//echo "Cannot insert_room_type : ".$e->getMessage();
		}
	}
	
	function list_picture_slider(){
		try{
			
			
			
			$sql = " select * from page_config where type_conf=2; ";
			
			log_warning("picture slide > list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("picture slide > list > error > " . $e->getMessage());
		}
	}
	
	function item_picture_slider($id){
		try{
			
			
			
			$sql = " select * from page_config where type_conf=2 and id='".$id."'; ";
			
			log_warning("picture slide > item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("picture slide > item > error > " . $e->getMessage());
		}
	}
	
	function delete_picture_slider($id){
		try{
			
			
			
			$sql = " delete from page_config where type_conf=2 and id='".$id."'; ";
			
			log_warning("picture slide > delete > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("picture slide > delete > error > " . $e->getMessage());
		}
	}
	
}
?>