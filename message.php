<?php 
include('includes/db.php');
include('functions/functions.php');
session_start() ;
if(isset($_SESSION['customer_email'])){
$my_email = $_SESSION['customer_email'];
if(isset($_GET['msg_id'])){
$message_to_id = $_GET['msg_id'];
$msg_query = "SELECT * from customers where id = '$message_to_id'";
$run_msg_query = mysqli_query($con, $msg_query);
while($rows_msg = mysqli_fetch_array($run_msg_query)){
$msg_to_name = $rows_msg['customer_name'];
$msg_to_pic = $rows_msg['customer_image'];
$msg_to_id = $rows_msg['id'];
$msg_to_email = $rows_msg['customer_email'];
?>

<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Social Media</title>
    <link rel="stylesheet" href="styles/style.css" media="all"/>
    </head>
   <script src="https://code.jquery.com/jquery-3.1.1.js"></script>   
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> 
        <script>
        window.onload = function(){
        var my_email = document.getElementById('my_email').innerHTML;
          var friends_email = document.getElementById('friends_email').innerHTML;
          //alert(my_email);
          //alert(friends_email);
          function ajax(){
   $.ajax({
   url:'get_messages.php',
      dataType:'Text',
     // async:'false', 
      type:'POST',
      data:{
      my_email:my_email,
      friends_email:friends_email },
      success:function(data,status,xhr){
         //alert(data) ;
         document.getElementById("msg_container").innerHTML = data;  
         }
 })
           }
           setInterval(function(){ajax();},1000);
    }
           /* function ajax(){
          
            $.ajax({
      url:'get_messages.php',
      dataType:'Text',
     // async:'false', 
      type:'POST',
      data:{
      my_email:my_email,
      friends_email:friends_email },
      success:function(data,status,xhr){
         alert(data) ;
         document.getElementById("msg_container").innerHTML = data;  }) 
                
            }
            setInterval(function(){ajax();},1000);*/
        </script> 
    <body style="font-size:4vw" >
    <div style="display:none;">
    <span id="my_email"><?php echo $my_email ;?></span>
    <span id="friends_email"><?php echo $msg_to_email ;?></span>
    </div>
    
    <div style="width:100vw;">
        <span> <a href="others_profile.php?c_id=<?php echo $message_to_id ;?>"> <img src="customer/customer_photos/<?php echo $msg_to_pic ;?>" height="100vw" width="100vw" style="border-radius:; position:relative;float:left;"></a></span><span style="margin-left:20px;"><a style="text-decoration:none;color:#000;" href="others_profile.php?c_id=<?php echo $message_to_id ;?>"><b ><?php echo $msg_to_name ;?></b><a/></span>
        <br><br><br><hr>
    </div>
    <div id="msg_container">
        <?php //get_messages($my_email,$msg_to_email) ; 
        ?>
      
    </div>
        
        <div style="margin-top:10vw;" width=1000px height=25px >
          <form method="post" action="message.php?msg_id=<?php echo $msg_to_id; ?>" enctype="multipart/form-data">
				<span><input style="height:5vw;width:80vw;font-size:4vw;float:left;" type="text" name="msg" placeholder="send message"/></span>
			<span>	<input style="height:5vw;width:15vw;font-size:4vw;float:right;" type="submit" name="send_msg" value="Send"/></span>
					
			</form>
          
        </div>
        
    </body>
</html>
<?php 

		if(isset($_POST['msg'])){
		$my_message = $_POST['msg'];
	$send_msg = "insert into customerMsgs (my_email, my_message, friends_id, friends_name, friends_email, friends_pic) values ('$my_email', '$my_message', '$msg_to_id', '$msg_to_name', '$msg_to_email', '$msg_to_pic')";
	$run_send_msg = mysqli_query($con,$send_msg);
	$chatted_with_query = "insert into chatted_with (my_email, my_message, friends_id, friends_name, friends_email, friends_pic) values ('$my_email', '$my_message', '$msg_to_id', '$msg_to_name', '$msg_to_email', '$msg_to_pic')";
	$run_chatted_with = mysqli_query($con, $chatted_with_query) ;
	if(!$run_chatted_with){
	$update_chatted_with = "update chatted_with set my_message='$my_message' where friends_email='$msg_to_email' AND my_email='$my_email'";
	}else{}
		}
		
		
		 }//while
}//isset msg_id
else{
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
    
    
   <?php chatted_with() ;?>
    
        
    </body>
</html>
<?php 
}
}//session
else{
header('Location:customer_login.php', true, 302);
exit;
//echo "<script>window.open('customer_login.php')</script>";
}
 ?>