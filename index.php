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
<!-- jQuery -->

<?php
$loginError = '';
if (!empty($_POST['email']) && !empty($_POST['pwd'])) {
	include 'Invoice.php';
	$invoice = new Invoice();
	$user = $invoice->loginUsers($_POST['email'], $_POST['pwd']); 
	if(!empty($user)) {
		$_SESSION['user'] = $user[0]['first_name'];
		$_SESSION['userid'] = $user[0]['id'];
		$_SESSION['email'] = $user[0]['email'];		
		$_SESSION['address'] = $user[0]['address'];
		$_SESSION['mobile'] = $user[0]['mobile'];
		header("Location:create_invoice.php");
	} else {
		$loginError = "Invalid email or password!";
	}
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
<div class="row">	
	<div class="demo-heading">
		<h2>Invoice System</h2>
	</div>
	<div class="login-form">		
		<h4>Invoice User Login:</h4>		
		<form method="post" action="">
			<div class="form-group">
			<?php if ($loginError ) { ?>
				<div class="alert alert-warning"><?php echo $loginError; ?></div>
			<?php } ?>
			</div>
			<div class="form-group">
				<input name="email" id="email" type="email" class="form-control" placeholder="Email address" autofocus="" required>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="pwd" placeholder="Password" required>
			</div>  
			<div class="form-group">
				<button type="submit" name="login" class="btn btn-info">Login</button>
			</div>
		</form>
		<br>
		
	</div>		
</div>		
</div>
<div class="insert-post-ads1" style="margin-top:20px;">

</div>
</div>
</body></html>

