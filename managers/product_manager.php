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
	
	function get_item($id){
		
		try{

			$sql = "select * ";
			$sql .= "from products where  id='$id' ";
			$result = $this->mysql->execute($sql);

			log_warning("get_item > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_item : ".$e->getMessage();
		}
		
	}
	
	function get_list_top_product(){
		
		try{

			$sql = "select * ";
			$sql .= "from products  order by views desc limit 3 ";
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
			$sql .= "from category_product where status=1;";
			$result = $this->mysql->execute($sql);

			log_warning("get_list_product_type > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_product_type : ".$e->getMessage();
		}
		
	}
	
	
	function get_product_gallery($pid){
		
		try{

			$sql = "select * ";
			$sql .= "from hardware_images where pro_type_id=$pid; ";
			$result = $this->mysql->execute($sql);

			log_warning("get_product_gallery > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_product_gallery : ".$e->getMessage();
		}
		
	}
	
	function get_list_brand(){
		
		try{

			$sql = "select * "; 
			$sql .= "from hardware_brands where active=1;";
			
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_brand > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_brand : ".$e->getMessage();
		}
		
	}
	
	
	function get_list_type_product($t_brand){
		try{
			
			
			$sql = "select type_pro_id, type_pro_name ,hw_brand_id,hw_brand_name ";
			$sql .= "from view_product where hw_brand_id=$t_brand  ";
			//$sql .= "group by hw_brand_name; ";
			
			/*
			$sql = "select cp.id,cp.name from products p ";
			$sql .= "inner join category_product cp on p.cate_product = cp.id ";
			$sql  .= "where p.cate_brand = $t_brand and status=1 ";
			$sql .= "group by p.cate_product ";*/

			$result = $this->mysql->execute($sql);

			log_warning("get_list_type_product > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_type_product : ".$e->getMessage();
		}
	}
	
	function get_list_product_filter($t_prod,$t_brand,$hw_brand,$hw_model){
		try{
			
			$groupBy = "";

			$sql = "select * from view_product "; 
			$sql .= "where  1=1 ";
			
			if($t_prod!="") {$sql .= "and type_pro_id=$t_prod ";  $groupBy = " group by type_pro_id " ; }
			if($t_brand!="")  {$sql .= "and type_brand_id=$t_brand ";  $groupBy = " group by type_brand_id "; }
			if($hw_brand!="null" && $hw_brand!="")  {$sql .= "and hw_brand_id=$hw_brand ";  $groupBy = " group by hw_brand_id "; }
			if($hw_model!="null" && $hw_model!="")  {$sql .= "and hw_model_id=$hw_model ";  $groupBy = " group by hw_model_id "; }
			
			
			$sql .= $groupBy;
			
			//$sql .= "group by p.cate_brand ";
			
			
			$result = $this->mysql->execute($sql);
			
			/*
			where p.cate_product=2
and p.cate_brand=1
and p.hardware_brand=6
and  p.hardware_model=1
			*/

			log_warning("get_list_product_filter > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_product_fillter : ".$e->getMessage();
		}
	}
	
	function get_list_type_brand($t_prod){
		try{

			$sql = "select b.id,b.name from products p "; 
			$sql .= "inner join category_brand b ";
			$sql .= "on p.cate_brand = b.id ";
			$sql .= "where cate_product=$t_prod ";
			$sql .= "group by p.cate_brand ";
			$result = $this->mysql->execute($sql);

			log_warning("get_list_type_brand > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_brand : ".$e->getMessage();
		}
	}
	
	function get_list_hardware_brand($t_prod,$t_brand){
		
		try{

			$sql = "select b.id,b.name from products p "; 
			$sql .= "inner join hardware_brands b ";
			$sql .= "on p.hardware_brand = b.id ";
			$sql .= "where cate_product=$t_prod ";
			$sql .= "and p.cate_brand=$t_brand ";
			$sql .= "group by p.hardware_brand ";
			$result = $this->mysql->execute($sql);

			log_warning("get_list_hardware_brand > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_hardware_brand : ".$e->getMessage();
		}
	}
	
	function get_list_hardware_modal($t_prod,$t_brand,$hw_brand){
	
		try{
			
			$sql = "select b.id,b.name from products p "; 
			$sql .= "inner join hardware_models b ";
			$sql .= "on p.hardware_model = b.id ";
			$sql .= "where cate_product=$t_prod ";
			$sql .= "and p.cate_brand=$t_brand ";
			$sql .= "and p.hardware_brand=$hw_brand ";
			$sql .= "group by p.hardware_model ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_hardware_modal > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_hardware_modal : ".$e->getMessage();
		}
		
	}
	
	function get_list_product($t_prod,$t_brand,$hw_brand,$hw_model){
		try{

			$sql = "select p.id as id,cp.name as category,cb.name as category_brand,hb.name as hw_brand,b.name as hw_model ";
			$sql .= ",p.title as name,p.detail,p.unit,p.price,p.thumbnail,p.views,p.active,p.update_date ";
			$sql .= "from products p ";
			$sql .= "left join hardware_models b on p.hardware_model = b.id ";
			$sql .= "left join hardware_brands hb on p.hardware_brand = hb.id ";
			$sql .= "left join category_brand cb on p.cate_brand = cb.id ";
			$sql .= "left join category_product cp on p.cate_product = cp.id ";
			$sql .= "where p.cate_product=$t_prod ";
			$sql .= "and p.cate_brand=$t_brand  ";
			$sql .= "and p.hardware_brand=$hw_brand  ";
			$sql .= "and  p.hardware_model=$hw_model ";
			$sql .= "group by p.hardware_model ";
			 
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_product > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_product : ".$e->getMessage();
		}
	}
	
}

?>