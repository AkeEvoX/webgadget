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
			
			$sql = "select pro.id ,CONCAT(cate_model.name,' ',model.name) as name,brand.name as brand_name ";
			$sql .= ",pro.thumbnail,pro.price,pro.update_date,pro.cate_model_id,pro.code,pro.unit,pro.status,pro.detail ";
			$sql .= "from category_product pro ";
			$sql .= "inner join category_model cate_model on cate_model.id = pro.cate_model_id ";
			$sql .= "inner join product_model model on model.id = pro.pro_model_id ";
			$sql .= "inner join product_brand brand on brand.id = model.pro_brand_id ";
			$sql .= "where pro.id='$id' ";
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
			
			$sql = "select pro.id as id ,model.name ";
			$sql .= "from category_product pro ";
			$sql .= "inner join category_model model on model.id = pro.cate_model_id ";
			$sql .= "group by cate_model_id ";
			$sql .= "order by views desc limit 3 ";
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
			$sql .= "from category_product where status=1;";
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
			$sql .= "where pro.cate_model_id=$cate_model_id ";
			$sql .= "order by pro.update_date desc  ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_cate_product > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_cate_product : ".$e->getMessage();
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
		
	//delete
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