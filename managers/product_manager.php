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

			if($id=="") $id="-1";

			/*update view item */
			$sql = "update category_product set views=(case when views is null then 0 else views end)+1 where id='$id'; ";
			log_warning("update_view > " . $sql);
			$this->mysql->execute($sql);
			
			$sql = "select pro.id ,CONCAT(cate_model.name,' ',model.name) as name,brand.name as brand_name ";
			$sql .= ",pro.thumbnail,pro.price,pro.update_date,pro.cate_model_id,pro.code,pro.unit,pro.status,pro.detail ";
			$sql .= "from category_product pro ";
			$sql .= "inner join category_model cate_model on cate_model.id = pro.cate_model_id ";
			$sql .= "inner join product_model model on model.id = pro.pro_model_id ";
			$sql .= "inner join product_brand brand on brand.id = model.pro_brand_id ";
			$sql .= "where pro.id='$id'; ";
			

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

			$sql = "select pro.id ,CONCAT(cate_model.name,' ',model.name) as name,brand.name as brand_name ,views ";
			$sql .= "from category_product pro inner join category_model cate_model on cate_model.id = pro.cate_model_id ";
			$sql .= "inner join product_model model on model.id = pro.pro_model_id ";
			$sql .= "inner join product_brand brand on brand.id = model.pro_brand_id ";
			$sql .= "where pro.status=1 ";
			$sql .= "order by pro.views desc limit 3; ";
			/*
			$sql = "select pro.id as id ,model.name ";
			$sql .= "from category_product pro ";
			$sql .= "inner join category_model model on model.id = pro.cate_model_id ";
			$sql .= "group by pro.id ";
			$sql .= "order by views desc limit 3 ";*/
			$result = $this->mysql->execute($sql);

			log_warning("get_list_top_product > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_top_product : ".$e->getMessage();
		}
		
	}
	
	function get_list_pro_update(){
		
		try{
			
			$sql = "select pro.id ,CONCAT(cate_model.name,' ',model.name) as name";
			$sql .= ",pro.thumbnail,pro.price,pro.update_date ";
			$sql .= "from category_product pro ";
			$sql .= "inner join category_model cate_model on cate_model.id = pro.cate_model_id ";
			$sql .= "inner join product_model model on model.id = pro.pro_model_id ";
			$sql .= "where pro.status=1 ";
			$sql .= "order by pro.update_date desc  ";
			$result = $this->mysql->execute($sql);

			log_warning("get_list_pro_update > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_pro_update : ".$e->getMessage();
		}
		
	}
	//delete
	function get_list_product_type(){
		
		try{

			$sql = "select * ";
			$sql .= "from category_product where status=1; ";
			$result = $this->mysql->execute($sql);

			log_warning("get_list_product_type > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_product_type : ".$e->getMessage();
		}
		
	}
	//change
	function get_product_gallery($id){
		
		try{

			if($id=="") $id="-1";

			$sql = "select * ";
			$sql .= "from product_image where cate_pro_id=$id; ";
			$result = $this->mysql->execute($sql);

			log_warning("get_product_gallery > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_product_gallery : ".$e->getMessage();
		}
		
	}
	
	function get_list_pro_brand(){
		
		try{

			$sql = "select * "; 
			$sql .= "from product_brand where status=1; ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_pro_brand > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_pro_brand : ".$e->getMessage();
		}
		
	}
	
	function get_list_pro_brand_model($id){
		
		try{

			$sql = "select * "; 
			$sql .= "from product_model where pro_brand_id='$id' and status=1; ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_pro_brand_model > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_pro_brand : ".$e->getMessage();
		}
		
	}
	
	function get_list_cate(){
		
		try{

			$sql = "select * "; 
			$sql .= "from category where status=1 order by name;";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_cate > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_cate : ".$e->getMessage();
		}
		
	}
	
	function get_list_cate_brand($cate_id){
		
		try{

			$sql = "select * "; 
			$sql .= "from category_brand where cate_id=$cate_id order by name;";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_cate_brand > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_cate_brand : ".$e->getMessage();
		}
		
	}
	
	function get_list_cate_model($cate_brand_id){
		
		try{

			$sql = "select * "; 
			$sql .= "from category_model where cate_brand_id=$cate_brand_id order by name;";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_cate_model > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_cate_model : ".$e->getMessage();
		}
		
	}
	
	function get_list_cate_product($cate_model_id){
		
		try{

			$sql = "select pro.id ,CONCAT(cate_model.name,' ',model.name) as name,brand.name as brand_name ";
			$sql .= ",pro.thumbnail,pro.price,pro.update_date ";
			$sql .= "from category_product pro ";
			$sql .= "inner join category_model cate_model on cate_model.id = pro.cate_model_id ";
			$sql .= "inner join product_model model on model.id = pro.pro_model_id ";
			$sql .= "inner join product_brand brand on brand.id = model.pro_brand_id ";
			$sql .= "where pro.cate_model_id=$cate_model_id and pro.status=1 ";
			$sql .= "order by pro.update_date desc  ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_cate_product > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_cate_product : ".$e->getMessage();
		}
		
	}
	
	function get_list_product_brand($pro_brand_id){
		
		try{
			
			
			$sql = "select pro.id ,CONCAT(cate_model.name,' ',model.name) as name,brand.name as brand_name ";
			$sql .= ",pro.thumbnail,pro.price,pro.update_date,pro.cate_model_id,pro.code,pro.unit,pro.status ";
			$sql .= "from category_product pro ";
			$sql .= "inner join category_model cate_model on cate_model.id = pro.cate_model_id ";
			$sql .= "inner join product_model model on model.id = pro.pro_model_id ";
			$sql .= "inner join product_brand brand on brand.id = model.pro_brand_id ";
			$sql .= " where brand.id=$pro_brand_id  and pro.status=1 ;  ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_product_brand > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_product_brand : ".$e->getMessage();
		}
		
	}
	
	function get_navi_cate_brand($cate_id){
		
		try{
			
			$sql = "select cate.id as lv1_id, cate.name as lv1_name ";
			$sql .= "from  category cate ";
			$sql .= "where cate.id = $cate_id ";
						
			$result = $this->mysql->execute($sql);

			log_warning("get_navi_cate_brand > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_navi_cate_brand : ".$e->getMessage();
		}

	}
	
	function get_navi_cate_model($cate_brand_id){
		
		try{
			
			$sql = "select cate.id as lv1_id, cate.name as lv1_name ";
			$sql .= ",brand.id as lv2_id,brand.name as lv2_name ";
			$sql .= "from category_brand brand  ";
			$sql .= "cross join category cate ";
			$sql .= "where brand.id=$cate_brand_id ";
			$sql .= "and cate.id = brand.cate_id ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_navi_cate_model > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_navi_cate_model : ".$e->getMessage();
		}
		
	}
	
	function get_navi_cate_pro($cate_model_id){
		
		try{

			if($cate_model_id=="") $cate_model_id="-1";

			$sql = "select cate.id as lv1_id, cate.name as lv1_name ";
			$sql .= ",brand.id as lv2_id,brand.name as lv2_name ";
			$sql .= ",model.id as lv3_id,model.name as lv3_name ";
			$sql .= "from category_model model ";
			$sql .= "cross join category_brand brand  ";
			$sql .= "cross join category cate ";
			$sql .= "where model.id=$cate_model_id and model.cate_brand_id = brand.id ";
			$sql .= "and cate.id = brand.cate_id; ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_navi_cate_pro > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_navi_cate_pro : ".$e->getMessage();
		}
		
	}
	
	
	function get_product_brand($pro_brand_id){
		
		try{

			$sql = "select id,name ";
			$sql .= "from product_brand ";
			$sql .= "where id=$pro_brand_id ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_product_brand > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_product_brand : ".$e->getMessage();
		}
		
	}
	
	
	function get_search_product($find){
		
		try{
			
			
			$sql = "select * from ( ";
			$sql .= "select pro.id ,CONCAT(cate_model.name,' ',model.name) as name,brand.name as brand_name  ";
			$sql .= ",pro.thumbnail,pro.price,pro.update_date,pro.cate_model_id,pro.code,pro.unit,pro.status ";
			$sql .= ",concat_ws(' ',cate_brand.name COLLATE utf8_general_ci,' ',cate_model.name COLLATE utf8_general_ci,' ',model.name COLLATE utf8_general_ci,' ',brand.name COLLATE utf8_general_ci) as search ";
			 $sql .= "from category_product pro inner join category_model cate_model on cate_model.id = pro.cate_model_id  ";
			$sql .= "inner join category_brand cate_brand on cate_model.cate_brand_id = cate_brand.id  ";
			$sql .= "inner join product_model model on model.id = pro.pro_model_id  ";
			$sql .= "inner join product_brand brand on brand.id = model.pro_brand_id ";
			$sql .= ") pro ";
			$sql .= "where search like '%$find%' and pro.status=1 ";
			$sql .= "order by name; ";
	
			$result = $this->mysql->execute($sql);
			
			log_warning("get_search_product > " . $sql);


			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_search_product : ".$e->getMessage();
		}
		
		
	}
	
}

?>