<?php
require_once("../../lib/database.php");
require_once("../../lib/logger.php");
class Order_Manager{
	
	protected $mysql;
	function __construct(){

		try{

			$this->mysql = new database();
			$this->mysql->connect();
			//echo "initial database.";
		}
		catch(Exception $e)
		{
			die("initial cate manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}


	function edit_item($id,$status_type,$deliver_id){
		
		try{

			$update_by = "0";
			$update_date = "now()";

			$sql = "update orders set ";
			$sql .= " status='$status_type' ";
			$sql .= ",delivery_id='$deliver_id' ";
			$sql .= ",update_by=$update_by ";
			$sql .= ",update_date=$update_date ";
			$sql .= " where id='".$id."';";
			
			log_warning("order > edit item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			if($result=="true"){
				$result = "MODIFY SUCCESS.";
			}else{
				$result = "MODIFY FAILURE.";
			}
			
			return $result;
		}catch(Exception $e){
			log_debug("order > edit item > error >" . $e->getMessage());
		}
		
	}
	
	function get_item($id){
		try{
			
			
			$sql = "select od.*,concat(oc.firstname ,' ',oc.lastname) customer_name ,td.name as deliver_by,ts.name as status_name ";
			$sql .= ",oc.email as customer_email ";
			$sql .= "from orders od ";
			$sql .= "inner join orders_customer oc on od.id = oc.order_id ";
			$sql .= "inner join type_deliver td on od.type_deliver = td.id ";
			$sql .= "inner join type_status ts on ts.id = od.status ";
			$sql .= "where od.id=$id ";

			log_warning("order > get item > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("order > get item > error >" . $e->getMessage());
		}
	}

	function get_status(){
		try{
			
			
			$sql = "select * from type_status ";

			log_warning("order > get status > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("order > get status > error >" . $e->getMessage());
		}
	}

	function get_payment($id){
		try{
			
			
			$sql = "select * ";
			$sql .= "from orders_payment  ";
			$sql .= "where order_id=$id ";

			log_warning("order > get payment > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("order > get payment > error >" . $e->getMessage());
		}
	}

	function list_confirm(){
		try{
			
			$sql = "select od.*,concat(oc.firstname ,' ',oc.lastname) customer_name ,td.name as deliver_by,ts.name as status_name ";
			$sql .= "from orders od ";
			$sql .= "inner join orders_customer oc on od.id = oc.order_id ";
			$sql .= "inner join type_deliver td on od.type_deliver = td.id ";
			$sql .= "inner join type_status ts on ts.id = od.status ";
			$sql .= "where od.status=0 ";
			$sql .= "order by od.create_date desc ";

			log_warning("order confirm > get list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("order confirm > get list > error > " . $e->getMessage());
		}
	}

	function list_payment(){
		try{
			
			$sql = "select od.*,concat(oc.firstname ,' ',oc.lastname) customer_name ,td.name as deliver_by,ts.name as status_name ";
			$sql .= "from orders od ";
			$sql .= "inner join orders_customer oc on od.id = oc.order_id ";
			$sql .= "inner join type_deliver td on od.type_deliver = td.id ";
			$sql .= "inner join type_status ts on ts.id = od.status ";
			$sql .= "where od.status=1 ";
			$sql .= "order by od.create_date desc ";


			log_warning("order peyment > get list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("order payment > get list > error > " + $e->getMessage());
		}
	}

	function list_order(){
		try{


			$sql = "select od.*,concat(oc.firstname ,' ',oc.lastname) customer_name ,td.name as deliver_by,ts.name as status_name ";
			$sql .= "from orders od ";
			$sql .= "inner join orders_customer oc on od.id = oc.order_id ";
			$sql .= "inner join type_deliver td on od.type_deliver = td.id ";
			$sql .= "inner join type_status ts on ts.id = od.status ";
			$sql .= "order by od.create_date desc ";

			log_warning("order list > get list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("order list > get list > error > " + $e->getMessage());
		}
	}

	function list_detail($id){
		try{
			$sql = "select od.*,pro.code,pro.price,pro.cate_name,pro.cate_model_name,pro.pro_model_name ";
			$sql .= "from orders_detail od ";
			$sql .= "inner join view_product pro on od.prod_type=pro.id ";
			$sql .= "where od.order_id='$id' ";
			$sql .= "order by pro.cate_model_name ";

			log_warning("order detail > get list > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
		}catch(Exception $e){
			log_debug("order detail > get list > error > " + $e->getMessage());
		}
	}

}

?>