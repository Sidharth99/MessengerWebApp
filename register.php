<?php
session_start();
include("includes/db.php");
include("functions/functions.php");
 ?>
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Hosting</title>
   
   <meta name="author" content="Sidharth">
  <meta name="viewport"content="width=device-width, initial-scale=1.0"> 
  
    <link rel="stylesheet" href="styles/style.css" media="all"/>
    </head>
    <style>
input{
width:400px;
height:45px;
font-size:38px;
}
</style>
    <body style="background-color:lightgreen;font-size:35px;">
    <!-- main container starts -->
        <div class="main_wrapper">
        
		
            <div id="products_box">
				<form action="register.php" method="post" enctype="multipart/form-data">
					<table align="center" width="1000px">
						
						<tr>
							<td colspan="2" align="center"><h2>Create an Account</h2></td>
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<tr>
							<td align="right"><b>Customer Name:</b></td>
							<td align="left"><input type="text" name="c_name" required /></td>
							
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<tr>
							<td align="right"><b>Customer Email:</b></td>
							<td align="left"><input type="email" name="c_email" required /></td>
							
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<tr>
							<td align="right"><b>Customer Password:</b></td>
							<td align="left"><input type="password" name="c_pass" required /></td>
							
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<tr>
							<td align="right"><b>Customer Country:</b></td>
							<td align="left">
								<select name="c_country">
									<option>Select a Category</option>
									<option>Afghanistan</option>
									<option>India</option>
									<option>Iran</option>
									<option>Japan</option>
									<option>China</option>
									<option>Pakistan</option>
									<option>US</option>
									<option>UK</option>
									<option>Saudi Arabia</option>
								</select>
							</td>
							
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<tr>
							<td align="right"><b>Customer City:</b></td>
							<td align="left">
								<select name="c_city">
									<option>Select a Category</option>
									<option>Afghanistan</option>
									<option>India</option>
									<option>Iran</option>
									<option>Japan</option>
									<option>China</option>
									<option>Pakistan</option>
									<option>US</option>
									<option>UK</option>
									<option>Saudi Arabia</option>
								</select>
							</td>
							
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<tr>
							<td align="right"><b>Customer Contact:</b></td>
							<td align="left"><input type="text" name="c_contact" required /></td>
							
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<tr>
							<td align="right"><b>Customer Address:</b></td>
							<td align="left"><input type="text" name="c_address" required /></td>
							
						</tr>
							<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<tr>
							<td align="right"><b>Customer DOB:</b></td>
							<td align="left"><input type="text" name="c_dob" required /></td>
							
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<tr>
							<td align="right"><b>Customer Image:</b></td>
							<td align="left"><input type="file" name="c_image" required /></td>
							
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" name="register" value="Submit" /></td>
						</tr>
						<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
					
					</table>
					
				</form>
				<h2 style="width:1000px;" align="center">Already have an account? <a href="customer_login.php" style="width:1000px;">Login here</a></h2>
			</div>	
			
            <div class="footer">
				<h1 style="color:#000;padding-top:30px;text-align:center;width:1000px;">&copy; 2018 - By Sidharth Jain</h1>
			</div>
        </div>
    <!-- main container ends -->
    </body>
</html>

<?php 
if(isset($_SESSION['customer_name'])){
 $c_name = $_SESSION['customer_name'];
 $myfile = "feed.php";
echo "<script>window.open('$myfile')</script>";
}else{
if(isset($_POST['register'])){
	$c_name = $_POST['c_name'];
	$c_email = $_POST['c_email'];
	$c_pass = $_POST['c_pass'];
	$c_country = $_POST['c_country'];
	$c_city = $_POST['c_city'];
	$c_contact = $_POST['c_contact'];
	$c_address = $_POST['c_address'];
	$c_dob = $_POST['c_dob'] ;
	$c_image = $_FILES['c_image']['name'];
	$c_image_tmp = $_FILES['c_image']['tmp_name'];
	$c_ip = getRealIPAddr();
	
	$insert_customer = "insert into customers (customer_name,customer_email,customer_pass,customer_country,customer_city,customer_contact,customer_address,customer_image,customer_ip,customer_dob) values ('$c_name','$c_email','$c_pass','$c_country','$c_city','$c_contact','$c_address','$c_image','$c_ip','$c_dob')";
	$run_customer = mysqli_query($con,$insert_customer);
	
	
	
	/*$sel_cart = "select * from cart where ip_add='$c_ip'";
	 $run_cart = mysqli_query($con,$sel_cart);
	 $check_cart = mysqli_num_rows($run_cart);*/
	 if($run_customer){
	 move_uploaded_file($c_image_tmp,"customer/customer_photos/$c_image");
		 $_SESSION['customer_email'] = $c_email ;
	 	$_SESSION['customer_name'] = $c_name ;
	 	
mkdir("customer/$c_email");
mkdir("customer/$c_email/images");

 
 
      echo "<script>window.open('feed.php')</script>";
	echo $_SESSION['customer_name'];
	 }
	  else{
		 echo "<script>alert('This email is already registered')</script>";
	 }
	 
	 //$name = $_SESSION['customer_name'];
	 //echo "<script>alert('$name')</script>";
	 /*if($check_cart>0){
		 
		 echo "<script>window.open('checkout.php','_self')</script>";
	 }else{
		 echo "<script>window.open('index.php','_self')</script>";
	 }*/
	}
}

?>
