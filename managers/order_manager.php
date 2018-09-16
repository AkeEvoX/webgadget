<?php
require_once("../lib/database.php");
require_once("../lib/logger.php");
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
			die("initial order manager error : ". $e->getMessage());
		}
	}

	function __destruct(){ //page end
		$this->mysql->disconnect();
	}
	
	function get_order_running(){
		
		try{
			
			//update running & get last running
			$sql = "update orders_running set order_no=order_no+1; ";
			$result = $this->mysql->execute($sql);
			$sql = "select order_no from orders_running ; ";
			$result = $this->mysql->execute($sql);
			
			log_warning("get_order_running > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_order_running : ".$e->getMessage();
		}
	}
	
	function new_order($orderid,$mobile,$type_deliver,$delivery,$price,$unit,$net){
		
		try{
			
			
			$status='0'; //wait payment
			$sql = "insert into orders (id,customer_mobile,type_deliver,status,total_price,total_unit,total_deliver,total_net,create_date)";
			$sql .= "values('$orderid','$mobile','$type_deliver',0,'$price','$unit','$delivery','$net',now()); ";
			
			log_warning("new_order > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
			
		}catch(Exception $e){
			echo "Cannot new_order : ".$e->getMessage();
		}
		
	}
	
	function new_order_detail($orderid,$prod_type_id,$price,$unit,$net,$color){
		try{
			
			$sql = "insert into orders_detail (order_id,prod_type,prod_price,prod_unit,prod_net,prod_color,create_date)";
			$sql .= "values('$orderid','$prod_type_id','$price','$unit','$net','$color',now()); ";
			
			log_warning("new_order_detail > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
			
		}catch(Exception $e){
			echo "Cannot new_order_detail : ".$e->getMessage();
		}
	}
	
	function confirm_order($ordre_no,$firstname,$lastname,$email,$address,$soi,$road,$district,$subdistrict,$postcode,$province){		
	
		try{
			$sql = "insert into orders_customer (order_id,firstname,lastname,email,address,soi,road,district,subdistrict,postcode,province)";
			$sql .= "values('$ordre_no','$firstname','$lastname','$email','$address','$soi','$road','$district','$subdistrict','$postcode','$province'); ";
			
			log_warning("confirm_order > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
			
		}catch(Exception $e){
			echo "Cannot confirm_order : ".$e->getMessage();
		}
		
	}
	
	function payment_order($orderid,$customer_name,$mobile,$account,$transfer_date,$amount,$instrument_file,$additional){
		
		try{
			$sql = "insert into orders_payment (order_id,customer_name,mobile,transfer_account,transfer_date,transfer_amount,transfer_instrument,additional)";
			$sql .= "values('$orderid','$customer_name','$mobile','$account','$transfer_date','$amount','$instrument_file','$additional'); ";
			
			log_warning("payment_order > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			//payment success.
			$sql = "update orders set status='1',update_date=now() ";
			$sql .= "where id='$orderid' ";
			
			log_warning("update_order > " . $sql);
			$result = $this->mysql->execute($sql);
			
			return $result;
			
		}catch(Exception $e){
			echo "Cannot payment_order : ".$e->getMessage();
		}
		
	}
	
	function verify_order_id($orderid){
		
		try{
			$sql = "select count(1) as result";
			$sql .= " ,case when status is null then -1 else status end as status ";
			$sql .= " from orders  where id ='$orderid' ;";
			
			log_warning("verify_order_id > " . $sql);
			
			$result = $this->mysql->execute($sql);
			
			return $result;
			
		}catch(Exception $e){
			echo "Cannot verify_order_id : ".$e->getMessage();
		}
		
	}
	
	function get_list_promotion(){
		
		try{

			$sql = "select * from promotions where status='1'  ";
			$result = $this->mysql->execute($sql);

			log_warning("get_list_promotion > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_list_promotion : ".$e->getMessage();
		}
		
	}
	
	function get_name_promotion($id){
		try{

			$sql = "select id,name from promotions where status='1' and id='$id' ";
			$result = $this->mysql->execute($sql);

			log_warning("get_name_promotion > " . $sql);
			
			return  $result;
		}
		catch(Exception $e){
			echo "Sorry, Can't call service get_name_promotion : ".$e->getMessage();
		}
	}
}

?>