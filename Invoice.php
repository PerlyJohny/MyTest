<?php
class Invoice{
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "mtqdb";   
	private $invoiceUserTable = 'invoice_user';	
    private $invoiceOrderTable = 'invoice_order';
	private $invoiceOrderItemTable = 'invoice_order_item';
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}
	
	public function loginUsers($email, $password){
		$sqlQuery = "SELECT id, email, first_name, address, mobile FROM ".$this->invoiceUserTable."	WHERE email='".$email."' AND password='".$password."'";
        return  $this->getData($sqlQuery);
	}	
	public function checkLoggedIn(){
		if(!$_SESSION['userid']) {
			header("Location:index.php");
		}
	}		
	public function saveInvoice($POST) {		
		$sqlInsert = "
			INSERT INTO ".$this->invoiceOrderTable."(user_id, order_receiver_name, order_receiver_address, order_total_before_tax, order_total_tax, order_dis_per, order_total_after_tax) 
			VALUES ('".$POST['userId']."', '".$POST['companyName']."', '".$POST['address']."', '".$POST['subTotal']."', '".$POST['totalAftertax']."', '".$POST['disAmount']."', '".$POST['tsubTotal']."')";		
		mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		for ($i = 0; $i < count($POST['productCode']); $i++) {
			$sqlInsertItem = "
			INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount, order_item_tax, order_item_subtotal) 
			VALUES ('".$lastInsertId."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."', '".$POST['tax'][$i]."', '".$POST['subtotal'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}  
		
		return $lastInsertId;
	}	
		
	
	public function getInvoice($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."' AND order_id = '$invoiceId'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}	
	public function getInvoiceItems($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '$invoiceId'";
		return  $this->getData($sqlQuery);	
	}
	
}
?>