<?php
require_once("../lib/database.php");
require_once("../lib/logger.php");

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
	
	
	function get_content(){
			try{
			
			$sql = "select id,title,detail,val,status ";
			$sql .= "from page_config where type_conf='4' and status=1 ;  ";
			
			log_warning("config > get home content > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("user > get home content > error > " . $e->getMessage());
		}
	}
	
	
	function get_certificate(){
			try{
			
			$sql = "select id,title,detail,val,status ";
			$sql .= "from page_config where type_conf='1' and status=1 ;  ";
			
			log_warning("config > get certificate > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("user > get certificate > error > " . $e->getMessage());
		}
	}
	
	/* braner */
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
		
	function list_picture_slide(){
		try{
			
			$sql = " select * from page_config where type_conf=2; ";
			
			log_warning("picture slide > list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("picture slide > list > error > " . $e->getMessage());
		}
	}
	
}
?>