<?php
require_once("../lib/database.php");
require_once("../lib/logger.php");

class News_Manager{

	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial news manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}

	function get_list(){
		
		try{

			$sql = "select s.*,t.title as type_name from news s inner join type_news t on s.type_new = t.id "; 
			$sql .= "where s.status=1 ";
			$sql .= "order by s.update_date desc; ";

			$result = $this->mysql->execute($sql);

			log_warning("news > get_list > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list : ".$e->getMessage();
		}
		
	}
	
	function get_item($id){
		
		try{
			
			$sql = "select s.*,t.title as type_name from news s inner join type_news t on s.type_new = t.id "; 
			$sql .= "where s.id='$id' and s.status=1 ; ";
			

			$result = $this->mysql->execute($sql);

			log_warning("news > get_item > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_item : ".$e->getMessage();
		}
		
	}



}

?>