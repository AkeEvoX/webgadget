<?php
require_once("../lib/database.php");
require_once("../lib/logger.php");
class Product_Manager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial product manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function get_list_top_product(){
		
		try{

			$sql = "select * ";
			$sql .= "from product_types  order by views desc limit 3 ";
			$result = $this->mysql->execute($sql);

			log_warning("get_list_top_product > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_top_product : ".$e->getMessage();
		}
		
	}
	
	function get_list_product_type(){
		
		try{

			$sql = "select * ";
			$sql .= "from type_product where active=1;";
			$result = $this->mysql->execute($sql);

			log_warning("get_list_product_type > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_product_type : ".$e->getMessage();
		}
		
	}
	
	function get_list_brand(){
		
		try{

			$sql = "select * ";
			$sql .= "from product_brands where active=1;";
			$result = $this->mysql->execute($sql);

			log_warning("get_list_brand > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_brand : ".$e->getMessage();
		}
		
	}
	
	function insert_options($unique_key,$option_key,$price){
		try{
			$sql = "insert into reserve_options(unique_key,option_key,option_price)";
			$sql .= "values('$unique_key','$option_key','$price'); ";
			
			log_warning("insert_options > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
			
		}catch(Exception $e){
			echo "Cannot insert_options : ".$e->getMessage();
		}
	}
	
	function insert_rooms($unique_key,$room_key,$price){
		
		try{
			
			$sql = "insert into reserve_rooms(unique_key,room_key,room_price)";
			$sql .= "values('$unique_key','$room_key','$price'); ";
			
			log_warning("insert_rooms > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			echo "Cannot insert_rooms : ".$e->getMessage();
		}
		
	}

	//## command date add on my sql
	//select reserve_startdate ,DATE_ADD(reserve_startdate, INTERVAL 2 day) as enddate from reserve_info limit 1 ;
	/*
	##filter room by date##
	select a.*,COALESCE(r.reserve_unit, 0) as reserve_unit from room_types a
		left join (
 			select b.room_key,count(b.room_key) as reserve_unit from reserve_info as info 
 			left join reserve_rooms b on info.unique_key = b.unique_key 
 			where info.create_date between '2017-04-01 :00:00:00' and '2017-04-30 :00:00:00'
 			group by b.room_key
 		) r on a.id = r.room_key
	where COALESCE(r.reserve_unit, 0)  <= unit 
;

	*/
}

?>