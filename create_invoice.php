<?php 
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<?php
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_POST['companyName']) && $_POST['companyName']) {	
	$invoice_id=$invoice->saveInvoice($_POST);
	header('Location: print_invoice.php?invoice_id='.$invoice_id);
}
?>
<title>Invoice System</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
</head>
<body class="">
	
	<div class="container" style="min-height:500px;">
	<div class=''>
	</div>
<div class="container content-invoice">
	<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate=""> 
		<div class="load-animate animated fadeInUp">
			<div class="row">
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<h2 class="title">Invoice System</h2>
					<ul class="nav navbar-nav">

<?php 
if($_SESSION['userid']) { ?>
	<li class="dropdown">
		<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Logged in <?php echo $_SESSION['user']; ?>
		<span class="caret"></span></button>
		<ul class="dropdown-menu">
			
			<li><a href="logout.php?action=logout">Logout</a></li>		  
		</ul>
	</li>
<?php } ?>
</ul>
<br /><br /><br /><br />
				</div>		    		
			</div>
			<input id="currency" type="hidden" value="$">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<h3>From,</h3>
					<?php echo $_SESSION['user']; ?><br>	
					<?php echo $_SESSION['address']; ?><br>	
					<?php echo $_SESSION['mobile']; ?><br>
					<?php echo $_SESSION['email']; ?><br>	
				</div>      		
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
					<h3>To,</h3>
					<div class="form-group">
						<input type="text" class="form-control" name="companyName" id="companyName" required placeholder="Company Name" autocomplete="off">
					</div>
					<div class="form-group">
						<textarea class="form-control" rows="3" name="address" id="address" required placeholder="Your Address"></textarea>
					</div>
					
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered table-hover" id="invoiceItem">	
						<tr>
							<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
							<th width="10%">Item No</th>
							<th width="30%">Item Name</th>
							<th width="10%">Quantity</th>
							<th width="10%">Price($)</th>	
							<th width="10%">Sub Total($)</th>	
							<th width="10%">Tax</th>	
							<th width="15%">Total($)</th>
						</tr>							
						<tr>
							<td><input class="itemRow" type="checkbox"></td>
							<td><input type="text" name="productCode[]" id="productCode_1" class="form-control" autocomplete="off"></td>
							<td><input type="text" name="productName[]" id="productName_1" class="form-control" autocomplete="off"></td>			
							<td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off"></td>
							<td><input type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
							<td><input type="number" name="subtotal[]" id="subtotal_1" class="form-control subtotal" autocomplete="off"></td>
							<td><select name="tax[]" id="tax_1" class="form-control tax" autocomplete="off">
							<option value="0">0% </option>
							<option value="1">1% </option>
							<option value="5">5% </option>
							<option value="10">10% </option>
							</td>
							<td><input type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off"></td>
						</tr>						
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
					<button class="btn btn-success" id="addRows" type="button">+ Add More</button>
				</div>
			</div>
			<div class="row">	
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					
					<div class="form-group">
						<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
						<input data-loading-text="Saving Invoice..." type="submit" name="invoice_btn" value="Save Invoice" class="btn btn-success submit_btn invoice-save-btm">						
					</div>
					
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<span class="form-inline">
						<div class="form-group">
							<label>Subtotal without tax: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon currency">$</div>
								<input value="" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal">
							</div>
						</div>
						<div class="form-group">
							<label>Discount Amount: &nbsp;</label>
							<div class="input-group">
								<input value="" type="number" class="form-control" name="disAmount" id="disAmount" placeholder="Discount Amount">
								<div class="input-group-addon">%</div>
							</div>
						</div>
						<div class="form-group">
							<label>Subtotal including tax:&nbsp;</label>
							<div class="input-group">
							 	<div class="input-group-addon currency">$</div>
								<input value="" type="number" class="form-control" name="tsubTotal" id="tsubTotal" placeholder="subTotal with tax">
							</div>
						</div>
						<div class="form-group">
							<label>Total with discount & tax: &nbsp;</label>
							<div class="input-group">
								<div class="input-group-addon currency">$</div>
								<input value="" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total">
							</div>
						</div>
						
					</span>
				</div>
			</div>
			<div class="clearfix"></div>		      	
		</div>
	</form>			
</div>
</div>	
<div class="insert-post-ads1" style="margin-top:20px;">

</div>
</div>
</body></html>