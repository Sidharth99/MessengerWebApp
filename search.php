<?php 
include('includes/db.php');
include('functions/functions.php');
session_start() ;
if(isset($_SESSION['customer_email'])){
$email = $_SESSION['customer_email'];

?>

<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Social Media</title>
    <link rel="stylesheet" href="styles/style.css" media="all"/>
    </head>
    <body>
    <ul id="feed_menu">
                <li><a href="feed.php">Feed</a></li>
                <li><a href="requests.php">Requests</a></li>
                <li><a href="message.php">Messages</a></li>
                <li><a href="notifications.php">Notifications</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
             <div id="form" style="height:6vw;width:100vw;">
			<form method="get" action="search.php" enctype="multipart/form-data">
				<span><input style="height:5vw;width:80vw;font-size:4vw;float:left;" type="text" name="user_query" placeholder="Search a Product"/></span>
			<span>	<input style="height:5vw;width:15vw;font-size:4vw;float:right;" type="submit" name="search" value="search"/></span>
					
			</form>
			 </div><br><br><hr>
			 
			<?php
			 if(isset($_GET['user_query'])){
 $user_keyword = $_GET['user_query'];
			
				$get_customers = "select * from customers where customer_name like '%$user_keyword%'";
					
					$run_get_customers = mysqli_query($con,$get_customers);
					
					while($row_search=mysqli_fetch_array($run_get_customers)){
	$search_id = $row_search['id'];
	$search_prof = $row_search['customer_image'] ;
	$search_name = $row_search['customer_name'];
	$search_country = $row_search['customer_country'] ;
	?>
	<a style="text-decoration:none;color:#000;" href="others_profile.php?c_id=<?php echo $search_id ;?>">
	<div style="font-size:4vw;width:100vw">
    
        <span> <img src="customer/customer_photos/<?php echo $search_prof ;?>" height="100vw" width="100vw" style="border-radius:; position:relative;float:left;"></span><span style="margin-left:5vw;"><b><?php echo $search_name ;?></b></span><div style="margin-left:15vw;"><?php echo $search_country ;?></div>
        <br><hr>
    </div>
    </a>
					
					<?php 
					}
 }
 ?>
			 
			 
			 
    
    
    
        
    </body>
</html>

    <?php
    
     } 
    else{
echo "<script>window.open('customer_login.php')</script>";
}
   ?>