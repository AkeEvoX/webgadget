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
			
			$sql = "select pro.id ,CONCAT(cate.name,' ',model.name) as name";
			$sql .= ",pro.thumbnail,pro.price,pro.update_date ";
			$sql .= "from category_product pro ";
			$sql .= "inner join category_model cate_model on cate_model.id = pro.cate_model_id ";
			$sql .= "left join category_brand cate_brand on cate_brand.id = cate_model.cate_brand_id ";
			$sql .= "left join category cate on cate.id = cate_brand.cate_id ";
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
	
	function get_product_color($id){
		
		try{

			if($id=="") $id="-1";
			
			$sql = "SELECT ";
			$sql .= "	c.id, ";
			$sql .= "	c.title, ";
			$sql .= "	c.code ";
			$sql .= "FROM ";
			$sql .= "	product_color p ";
			$sql .= "INNER JOIN type_color c ON c.id = p.color_id ";
			$sql .= "WHERE ";
			$sql .= "	cate_pro_id = '$id'  ";
			$sql .= "And p.status=1 ;";	

			$result = $this->mysql->execute($sql);

			log_warning("get_product_color > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_product_color : ".$e->getMessage();
		}
		
	}
	
	function get_list_top_pro_brand(){
		
		try{

			$sql = "select * "; 
			$sql .= "from product_brand where status=1; ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_top_pro_brand > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_top_pro_brand : ".$e->getMessage();
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
			echo "Sorry, Can't call service get_list_pro_brand_model : ".$e->getMessage();
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
	
	function get_list_cate_model_by_id($pro_brand_id){
		
		try{

			$sql = "select pro.id as cate_pro_id,model.name as model_name,brand.name as brand_name "; 
			$sql .= ",pro.thumbnail,pro.price,pro.update_date ";
			$sql .= "from category_product pro ";
			$sql .= "inner join category_model model on pro.cate_model_id = model.id ";
			$sql .= "inner join category_brand brand on model.cate_brand_id = brand.id ";
			$sql .= "where pro_model_id='$pro_brand_id' ; ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_cate_model_by_id > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_cate_model_by_id : ".$e->getMessage();
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
	
	function get_list_pro_brand_of_category($cate_id){
		
		try{
			
			$sql = "select p_brand.id,p_brand.name from category_brand c_brand ";
			$sql .= "inner join category_model c_model on c_brand.id = c_model.cate_brand_id ";
			$sql .= "inner join category_product c_pro on c_model.id = c_pro.cate_model_id ";
			$sql .= "inner join product_model p_model on p_model.id = c_pro.pro_model_id ";
			$sql .= "inner join product_brand p_brand on p_brand.id = p_model.pro_brand_id ";
			$sql .= "where c_brand.cate_id='".$cate_id."' and p_brand.status=1 ";
			$sql .= "group by p_brand.name ; ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_pro_brand_of_category > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_pro_brand_of_category : ".$e->getMessage();
		}
		
	}
	
	function get_list_pro_model_cate($pro_brand_id,$pro_model_id){
		
		try{
			
		$sql = "SELECT "; 
		$sql .= "c_pro.id AS cate_pro_id, ";
		$sql .= "c_brand. NAME AS brand_name, ";
		$sql .= "c_model. NAME AS model_name, ";
		$sql .= "c_pro.thumbnail, ";
		$sql .= "c_pro.price, ";
		$sql .= "c_pro.update_date ";
		$sql .= "FROM ";
		$sql .= "category_product c_pro ";
		$sql .= "INNER JOIN category_model c_model ON c_pro.cate_model_id = c_model.id ";
		$sql .= "INNER JOIN category_brand c_brand ON c_model.cate_brand_id = c_brand.id ";
		$sql .= "INNER JOIN product_model p_model ON p_model.id = c_pro.pro_model_id ";
		$sql .= "INNER JOIN product_brand p_brand ON p_brand.id = p_model.pro_brand_id ";
		$sql .= "WHERE ";
		$sql .= "p_model.id = '$pro_model_id' ";
		$sql .= "AND p_brand.id = '$pro_brand_id' ";
		$sql .= "ORDER BY ";
		$sql .= "c_model. NAME; ";

			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_pro_model_cate > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_pro_model_cate : ".$e->getMessage();
		}
		
	}
	
	function get_list_model_of_category($cate_id,$pro_brand_id){
		
		try{

			if($cate_id=="") $cate_id="-1";
			if($pro_brand_id=="") $pro_brand_id="-1";
			
			$sql = "SELECT "; 
			$sql .= "	c_pro.id AS cate_pro_id, ";
			$sql .= "	p_model.id AS p_model_id, ";
			$sql .= "	c. NAME AS cate_name, ";
			$sql .= "	p_brand. NAME AS p_brand_name, ";
			$sql .= "	p_model. NAME AS p_model_name, ";
			$sql .= "	c_pro.price AS price, ";
			$sql .= "	c_pro.update_date ";
			$sql .= "FROM ";
			$sql .= "	category c ";
			$sql .= "INNER JOIN category_brand c_brand ON c_brand.cate_id = c.id ";
			$sql .= "INNER JOIN category_model c_model ON c_brand.id = c_model.cate_brand_id ";
			$sql .= "INNER JOIN category_product c_pro ON c_model.id = c_pro.cate_model_id ";
			$sql .= "INNER JOIN product_model p_model ON p_model.id = c_pro.pro_model_id ";
			$sql .= "INNER JOIN product_brand p_brand ON p_brand.id = p_model.pro_brand_id ";
			$sql .= "WHERE ";
			$sql .= "	p_brand.id = '$pro_brand_id' ";
			$sql .= "AND c.id = '$cate_id'; ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_list_model_of_category > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_model_of_category : ".$e->getMessage();
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
			$sql .= "where brand.id='$cate_brand_id' ";
			$sql .= "and cate.id = brand.cate_id ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_navi_cate_model > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_navi_cate_model : ".$e->getMessage();
		}
		
	}
	
	function get_navi_cate_model_by_id($pro_model_id,$pro_brand_id,$cate_id){
		
		try{
			
			$sql = "select c.id as lv1_id,c.name as lv1_name ";
			$sql .= ",p_brand.id as lv2_id,p_brand.name as lv2_name  ";
			$sql .= ",p_model.id as lv3_id,p_model.name as lv3_name ";
			$sql .= "from category c  ";
			$sql .= "inner join category_brand c_brand on c_brand.cate_id = c.id ";
			$sql .= "inner join category_model c_model on c_brand.id = c_model.cate_brand_id ";
			$sql .= "inner join category_product c_pro on c_model.id = c_pro.cate_model_id ";
			$sql .= "inner join product_model p_model on p_model.id = c_pro.pro_model_id ";
			$sql .= "inner join product_brand p_brand on p_brand.id = p_model.pro_brand_id ";
			$sql .= "where p_brand.id='".$pro_brand_id."' and c.id='".$cate_id."' and p_model.id='".$pro_model_id."' ";
			$sql .= "group by p_brand.name; ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_navi_cate_model_by_id > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_navi_cate_model_by_id : ".$e->getMessage();
		}
		
	}
	
	function get_navi_cate_pro($cate_model_id){
		
		try{

			if($cate_model_id=="") $cate_model_id="-1";
			
		
			$sql = "select c.id as lv1_id,c.name as lv1_name "; 
			$sql .=",p_brand.id as lv2_id,p_brand.name as lv2_name ";
			$sql .=",c_model.id as lv3_id,c_model.name as lv3_name ";
			$sql .=",p_model.id as lv4_id,p_model.name as lv4_name ";
			$sql .="from category c ";
			$sql .="inner join category_brand c_brand on c_brand.cate_id = c.id ";
			$sql .="inner join category_model c_model on c_brand.id = c_model.cate_brand_id ";
			$sql .="inner join category_product c_pro on c_model.id = c_pro.cate_model_id ";
			$sql .="left join product_model p_model on p_model.id = c_pro.pro_model_id ";
			$sql .="left join product_brand p_brand on p_brand.id = p_model.pro_brand_id ";
			$sql .="where c_pro.id='".$cate_model_id."'; ";

			
			$result = $this->mysql->execute($sql);

			log_warning("get_navi_cate_pro > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_navi_cate_pro : ".$e->getMessage();
		}
		
	}
	
	function get_navi_brand_model_cate_pro($cate_pro_id){
		
		try{

			if($cate_pro_id=="") $cate_pro_id="-1";
			
			$sql = "SELECT "; 
				$sql .="p_brand.id AS lv1_id, ";
				$sql .="p_brand. NAME AS lv1_name, ";
				$sql .="p_model.id AS lv2_id, ";
				$sql .="p_model. NAME AS lv2_name, ";
				$sql .="c_model.id AS lv3_id, ";
				$sql .="c_model. NAME AS lv3_name ";
			$sql .="FROM ";
				$sql .="category_product c_pro ";
			$sql .="INNER JOIN category_model c_model ON c_pro.cate_model_id = c_model.id ";
			$sql .="INNER JOIN category_brand c_brand ON c_model.cate_brand_id = c_brand.id ";
			$sql .="INNER JOIN product_model p_model ON p_model.id = c_pro.pro_model_id ";
			$sql .="INNER JOIN product_brand p_brand ON p_brand.id = p_model.pro_brand_id ";
			$sql .="WHERE ";
				$sql .="c_pro.id = '$cate_pro_id' ";
			$sql .="ORDER BY ";
				$sql .="c_model. NAME; ";
		
			$result = $this->mysql->execute($sql);

			log_warning("get_navi_brand_model_cate_pro > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_navi_brand_model_cate_pro : ".$e->getMessage();
		}
		
	}
	
	function get_navi_cate($cate_id){
		try{

			if($cate_id=="") $cate_id="-1";

			$sql = "select cate.id as lv1_id, cate.name as lv1_name ";
			$sql .= "from category cate ";
			$sql .= "where cate.id='$cate_id'  ;";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_navi_cate > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_navi_cate : ".$e->getMessage();
		}
	}
	
	function get_navi_brand($pro_brand_id){
		
		try{

			if($cate_id=="") $cate_id="-1";
			if($pro_brand_id=="") $pro_brand_id="-1";
			
			
			$sql = "select p_brand.id as lv1_id, p_brand.name as lv1_name ";
			$sql .= "from product_brand p_brand ";
			$sql .= "where p_brand.id='".$pro_brand_id."' ";

			$result = $this->mysql->execute($sql);

			log_warning("get_navi_brand > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_navi_brand : ".$e->getMessage();
		}
		
	}
	
	function get_navi_pro_brand($cate_id,$pro_brand_id){
		
		try{

			if($cate_id=="") $cate_id="-1";
			if($pro_brand_id=="") $pro_brand_id="-1";
			
			
			$sql = "select c.id as lv1_id,c.name as lv1_name ";
			$sql .= ",p_brand.id as lv2_id,p_brand.name as lv2_name ";
			$sql .= "from category c ";
			$sql .= "inner join category_brand c_brand on c_brand.cate_id = c.id ";
			$sql .= "inner join category_model c_model on c_brand.id = c_model.cate_brand_id ";
			$sql .= "inner join category_product c_pro on c_model.id = c_pro.cate_model_id ";
			$sql .= "inner join product_model p_model on p_model.id = c_pro.pro_model_id ";
			$sql .= "inner join product_brand p_brand on p_brand.id = p_model.pro_brand_id ";
			$sql .= "where p_brand.id='".$pro_brand_id."' and c.id='".$cate_id."' ";
			$sql .= "group by p_brand.name ; ";

			
			$result = $this->mysql->execute($sql);

			log_warning("get_navi_pro_brand > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_navi_pro_brand : ".$e->getMessage();
		}
		
	}
	
	function get_navi_pro_model($pro_brand_id,$pro_model_id){
		
		try{
			
			$sql = "select p_brand.id as lv1_id,p_brand.name as lv1_name ";
			$sql .= ",p_model.id as lv2_id,p_model.name as lv2_name ";
			$sql .= "from product_brand p_brand ";
			$sql .= "inner join product_model p_model on p_model.pro_brand_id = p_brand.id ";
			$sql .= "where p_brand.id='".$pro_brand_id."' and p_model.id='".$pro_model_id."' ";
			
			$result = $this->mysql->execute($sql);

			log_warning("get_navi_pro_model > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_navi_pro_model : ".$e->getMessage();
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