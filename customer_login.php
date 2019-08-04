<?php
@session_start();
include("includes/db.php");

function getIpAddr(){
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		//check ip from share internet
	 $ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		//check ip is pass from proxy
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else{
		$ip=$_SERVER['REMOTE_ADDR'];
	}

	return $ip;
}


 ?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<style>
input{
width:400px;
height:45px;
font-size:38px;
}
</style>
</head>
<body style="font-size:38px;">
<div style="background-color:#66CCCC;margin-top:30%;">

	<form action="customer_login.php" method="post" enctype="multipart/form-data">
	
	<table width="1000px"  align="center">
	
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	
	<tr>
			<td colspan="2" align="center"><h2 align="center">Login or Register</h2></td>
		</tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		
		<tr>
			<td align="right"><b>Your email:</b></td>
			
			<td align="left"><input type="email" name="c_email" placeholder="Enter email address"/></td>
		</tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		
		<tr>
			<td align="right"><b>Your Password:</b></td>
			
			<td align="left"><input type="password" name="c_pass" placeholder="Enter Password"/></td>
		</tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		
		<tr>
			<td colspan="2" align="center"><a href="#">Forgot Password?</a></td>
		</tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" name="c_login" value="Login"/></td>
		</tr>
		
		
		
		
	</table><br/><br/>
	<h2 align="right"><a href="register.php">NEW? REGISTER HERE</a></h2>
	</form>


<?php
if(isset($_SESSION['customer_email'])){echo "<script>window.open('feed.php')</script>";}else{
 if(isset($_POST['c_login'])){
	 $customer_email = $_POST['c_email'];
	  $customer_pass = $_POST['c_pass'];
	  
	  $sel_customer = "select * from customers where customer_email='$customer_email' AND customer_pass='$customer_pass'";
	  $run_customer = mysqli_query($con,$sel_customer);
	  
	  $check_customer = mysqli_num_rows($run_customer);
	  while($find_cust = mysqli_fetch_array($run_customer)){
		  $customer_name = $find_cust['customer_name'];
		  $customer_id = $find_cust['id'] ;
	  }
	  $ip = getIpAddr();
	  
	  
	 // echo "<script>alert($ip)</script>";
	  /*$sel_cart = "select * from cart where ip_add = '$ip'";
	  //echo "<script>alert($sel_cart)</script>";
	  $run_cart = mysqli_query($con, $sel_cart);
	  //echo "<script>alert($run_cart)</script>";
	  $check_cart = mysqli_num_rows($run_cart);
	  */
	  if($check_customer == 0){
		 
		  echo "<script>alert(Password or Email is not correct ,try again)</script>";
		exit();  
	  }
	  if($check_customer==1){
		  $_SESSION['customer_email'] = $customer_email;
		  $_SESSION['customer_name'] = $customer_name;
		  $_SESSION['customer_id'] = $customer_id;
		  $c_name = $_SESSION['customer_name'];
		  //$myfile = "customer/$c_name/index.php";
     $myfile = "feed.php";
      echo "<script>window.open('$myfile')</script>";
		  //echo "<script>window.open('customer/my_account.php')</script>";
	  }else{
	  //echo "<script>alert('customer error')</script>";
	  } 
 }else{
	  //echo "<script>alert('c_login not set')</script>";
	  } 
}
 ?>



</div>
</body>
</html>