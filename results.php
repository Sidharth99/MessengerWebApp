<?php
include("includes/db.php");
include("functions/functions.php");
 ?>
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Social Media</title>
    <link rel="stylesheet" href="styles/style.css" media="all"/>
    </head>
    <body>
 <div id="navbar">
			<ul id="menu">
			 <li><a href="index.php">Home</a></li>
			 <li><a href="frnd_req.php">Friend requests</a></li>
			 <li><a href="customer/my_account.php">My Account</a></li>
			 <li><a href="user_register.php">Sign UP</a></li>
			 <li><a href="chat.php">Messages</a></li>
			 
			</ul>
			<div id="form">
			<form method="get" action="results.php" enctype="multipart/form-data">
				<input type="text" name="user_query" placeholder="Search a Product"/>
				<input type="submit" name="search" value="search"/>
					
			</form>
			 </div>
			</div>
		<!-- Navigation bar ends -->
		
            <div class="content_wrapper">
			 <div id="left_sidebar">
				<div id="sidebar_title">Do something</div>
				<ul  id="cats">
					
				</ul>
				
				<div id="sidebar_title">Do something</div>
				<ul  id="cats">
				
				</ul>
				
			 </div>
			 <div id="right_content">
				<div id="headlin">
					<div id="headline_content">
						<b>Welcome Guest!</b>
						<b style="color:yellow;">Shopping Cart:</b>
						<span>- Items: - Price: </span>
					</div>
				</div>
			<div id="products_box">
				<?php

		if(isset($_GET['search'])){
			$user_keyword = $_GET['user_query'];
			
				$get_customers = "select * from customers where customer_name like '%$user_keyword%'";
					
					$run_products = mysqli_query($con,$get_customers);
					
					while($row_products=mysqli_fetch_array($run_products)){
						//$pro_id = $row_products['id'];
						$pro_title = $row_products['customer_name'];
						/*$pro_cat = $row_products['cat_id'];
						$pro_brand = $row_products['brand_id'];
						$pro_desc = $row_products['product_desc'];
						$pro_price = $row_products['product_price'];
						*/
					 $pro_image = $row_products['customer_image'];
						
						echo "
						<div id='single_product'>
						<h3>$pro_title</h3>
						<img src='customer/customer_photos/$pro_image' width='180' height='180'/></br>
						<p><b>  </b></p>
						
						</div>
						";
				}
		}	
					?>
			</div>	
			 </div>
			</div>
            <div class="footer">
				<h1 style="color:#000;padding-top:30px;text-align:center;">&copy; 2018 - By Sidharth Jain</h1>
			</div>
        </div>
    <!-- main container ends -->
    </body>
</html>