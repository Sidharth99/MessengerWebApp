<?php 
include('includes/db.php');
include('functions/functions.php');
session_start() ;
if(isset($_SESSION['customer_email'])){
$email = $_SESSION['customer_email'];


if(isset($_GET['accept'])){
$request_by_email = $_GET['accept'] ;

$update_request = "update requests set status='Friends' where requested_by_email='$request_by_email' AND requested_to_email='$email'";
$run_update_request = mysqli_query($con, $update_request) ;


}
if(isset($_GET['delete'])){
$delete_request_of = $_GET['delete'];
$delete_request = "delete from requests where requested_to_email='$email' AND requested_by_email='$delete_request_of'";
$run_delete_request = mysqli_query($con, $delete_request) ;
}

?>

<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Social Media</title>
    <link rel="stylesheet" href="styles/style.css" media="all"/>
    </head>
    
   <!-- <script src="https://code.jquery.com/jquery-3.1.1.js"></script>   
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> 
    
    
    <script>
    function accept(){
    
    /*$.ajax({
   url:'accept.php',
      dataType:'Text',
     // async:'false', 
      type:'POST',
      data:{
      request:accept,
       },
      success:function(data,status,xhr){
         //alert(data) ;
         document.getElementById("msg_container").innerHTML = data;  
         }
 })
    */
    }
     
    function delete(){
    
    }
    </script > -->
    <body>
    
     <div>
            <ul id="feed_menu">
                <li><a href="feed.php">Feed</a></li>
                <li><a href="requests.php">Requests</a></li>
                <li><a href="message.php">Messages</a></li>
                <li><a href="notifications.php">Notifications</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
            
          

        </div>
        <hr/>
    
    <h1>Friend requests:</h1>
<?php   
$request_query = "select * from requests where requested_to_email ='$email' AND status='Requested'";
$run_request = mysqli_query($con, $request_query) ;
$rows_run_request = mysqli_num_rows($run_request) ;
if($rows_run_request>0){

while($rows_request = mysqli_fetch_array($run_request)){
$requested_by = $rows_request['requested_by_email'] ;

//$requested_to_id = $rows_request['requested_to_id'];



$fetch_query = "select * from customers where customer_email ='$requested_by'";
$run_fetch_query = mysqli_query($con, $fetch_query);
while($data = mysqli_fetch_array($run_fetch_query)){
$requested_name = $data['customer_name'];
$requested_pic = $data['customer_image'] ;
$requested_id = $data['id'] ;



   ?>
    <div style="height:20vw;border-bottom:1px solid grey;margin-top:5vw;font-size:3vw;width:100vw;">
        <div style="width:100vw;">
            <span> <a href="others_profile.php?c_id=<?php echo $requested_id ;?>"><img src="customer/customer_photos/<?php echo $requested_pic; ?>" height="180vw" width="180vw" style="border-radius:; position:relative;float:left;"></a></span> 
            <span style="margin:10vw;">
               <a style="text-decoration:none;color:#000;" href="others_profile.php?c_id=<?php echo $requested_id ;?>"><b><?php echo $requested_name ;?></b></a>
            </span>
        
        </div>
        <div style="margin-top:8vw;width:100vw;">
            <span style="background-color:lightgreen;padding:2vw;border:1px solid blue;margin:10vw;border-radius:25%;">
                <a href="requests.php?accept=<?php echo $requested_by ;?>" style="text-decoration:none;color:#000;"id="accept" onclick="accept()">Accept</a>
            </span>
            <span style="background-color:lightblue;padding:2vw;border:1px solid green;border-radius:25%;">
                <a href="requests.php?delete=<?php echo $requested_by ;?>" style="text-decoration:none;color:#000;" id="delete" onclick="delete()">Delete</a>
            </span>
        </div>
        
    </div>
    
    
    
    
    
    </body>
</html>
<?php 
}
}



}else{
echo "<h1 style='color:grey;margin-top:25%;' align=center>No Friend Requests</h1>";
}



}
else{
header('Location:customer_login.php', true, 302);
exit;
//echo "<script>window.open('customer_login.php')</script>";
}

?>