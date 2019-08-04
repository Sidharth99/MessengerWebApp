<?php 
include('includes/db.php');
include('functions/functions.php');
session_start() ;
if(isset($_SESSION['customer_email'])){
$email = $_SESSION['customer_email'];

if(isset($_GET['c_id'])){
$c_id = $_GET['c_id'];
$others_query = "select * from customers where id=$c_id";
$run_others_query = mysqli_query($con,$others_query);
while($prof_details = mysqli_fetch_array($run_others_query)){
$prof_name = $prof_details['customer_name'];
$prof_email = $prof_details['customer_email'];
$prof_dob = $prof_details['customer_dob'];
$prof_contact = $prof_details['customer_contact'];
$prof_city = $prof_details['customer_city'];
$prof_country = $prof_details['customer_country'];
$prof_pic = $prof_details['customer_image'];
$prof_id = $prof_details['id'];
}
if($prof_email == $email){

echo "<script>window.open('profile.php')</script>";
exit();
}



$my_id = getmyid() ;
//echo $my_id;
$request_status = "select * from requests where (requested_by_email='$email' OR requested_by_email='$prof_email') AND (requested_to_id='$prof_id' OR requested_to_id='$my_id')";
$run_request_status = mysqli_query($con, $request_status);
$rows = mysqli_num_rows($run_request_status);
      //echo $rows ;
        if($rows>0){
while($run_status = mysqli_fetch_array($run_request_status)){
$status_requested_by = $run_status['requested_by_email'] ;
$status = $run_status['status'];
}
}
else{
$status = "Request";
}

if($status == "Request"){
//echo "<script>alert($status)</script>";
if(isset($_GET['request'])){
/*$request_status = "select * from requests where requested_by='$email' AND request_to=''";*/

$insert_request = "insert into requests (requested_by_email, requested_to_email, requested_to_id, status) values ('$email','$prof_email', '$prof_id', 'Requested')";
$run_insert_request = mysqli_query($con, $insert_request);
//$_SESSION['is_requested'] = 'requested';
}
}


   
if($status=="Requested"){
if($email!=$status_requested_by){
$color_status = "<span style=\"color:lightblue;\">Pending</span>";
$follow = "<span style=\"color:blue;\">Follow</span>";

}else{
$color_status = "<span style=\"color:lightblue;\">$status</span>";
$follow = "<span style=\"color:blue;\">Follow</span>";
}
}else if($status=="Friends"){
$follow = "<span style=\"color:green;\">Following</span>";
$color_status = "<span style=\"color:green;\">$status</span>";
}else{
$color_status = "<span style=\"color:red;\">$status</span>";
$follow = "<span style=\"color:blue;\">Follow</span>";
}
//echo "<script>window.open('others_profile.php?c_id=$c_id')</script>";
//header("Location:others_profile.php?c_id=$c_id");
?>
<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Social Media</title>
    <link rel="stylesheet" href="styles/style.css" media="all"/>
    <script>
     <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> 
        <script>
        function insert_like(post_id){
        $.ajax({
   url:'likes.php',
      dataType:'Text',
     // async:'false', 
      type:'POST',
      data:{
      
      insert_like:post_id},
      success:function(data,status,xhr){
        // alert(data) ;
        
         }
 })
        get_likes(post_id);}
        
        function get_likes(post_id){
        $.ajax({
   url:'likes.php',
      dataType:'Text',
     // async:'false', 
      type:'POST',
      data:{
      
      get_like:post_id},
      success:function(data,status,xhr){
         //alert(data) ;
         $("#like_"+post_id).html(data);
         }
 })
        }
        
        function get_comments(post_id){
        $.ajax({
   url:'get_comments.php',
      dataType:'Text',
     // async:'false', 
      type:'POST',
      data:{
      
      get_comments:post_id},
      success:function(data,status,xhr){
         //alert(data) ;
         $("#comment_section_"+post_id).html(data);
         }
 })
        }
       /*setInterval(function(){
       get_comments();
       },15000)*/
        
        function insert_comment(post_id){
        var comment = $("#comment_"+post_id).val();
       // alert(comment) ;
       // alert(post_id) 
        $.ajax({
   url:'feed.php',
      dataType:'Text',
     // async:'false', 
      type:'POST',
      data:{
      post_id:post_id,
      comment:comment },
      success:function(status,xhr){
         alert("commented successfully") ;
         //window.open('feed.php', '_self') ;
         }
 })
 $("#comment_"+post_id).val("");
//$("#"+post_id).toggle("slide");
get_comments(post_id);
        }
        
           
    
    
    
    function toggle(id){
    $("#"+id).toggle("slide")
    get_comments(id);
}
    </script >
    </script>
    </head>
    <body>
        <div align=center style="background-color:#0066aa;color:white;padding:5vw;width:100vw"><?php echo $prof_name ;?></div>
            
        <div id="cover">
        <img id="cover_photo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1K1hWttHpIgbv49ikeW1zTMdfWETJu6Qi0UIZFxX0wXURrkB1" width=100% height=auto style="min-width:110vw" >
        <img src="customer/customer_photos/<?php echo $prof_pic ; ?>" width=120% height=300vw id="profile_pic"/>
        </div>
        <div align=center style="font-size:8vw;margin-top:55vw;width:100vw;"><?php echo $prof_name ;?></div>
        <div style="font-size:5vw;color:grey;"><ul style="margin-top:8vw;width:100vw;" id="req_menu">
            <li><a href="others_profile.php?c_id=<?php  echo $prof_id;?>&&request=<?php  echo $prof_id;          ?>"><?php echo $color_status;?></a></li>
            
            <li><?php echo $follow;?></li>
            
            <li><a href="message.php?msg_id=<?php echo $prof_id ;?>">Message</a></li>
            
             <li><a href="#">more</a></li>
        </ul></div>
        
        
        
        <ul style="margin-top:20vw;">
            <li>Working at : <b>Not Yet Working</b></li>
            <li>Studied at :  <b>some college</b></li>
            <li>Went to : <b>some school</b></li>
            <li>Born on : <b><?php echo $prof_dob ;?></b></li>
            <li>Contact no. : <b><?php echo $prof_contact ;?></b></li>
            <li>Lives in : <b><?php echo $prof_city ;?></b></li>
            <li>From : <b><?php echo $prof_country ;?></b> </li>
            <li>email : <b id="unknown_email"><?php echo $prof_email ;?></b> </li>
            
        </ul>
        <ul style="margin-top:1vw;" id="about_menu">
            <li><a href="#">About</a></li>
            <li>|</li>
            <li><a href="#">Photos</a></li>
            <li>|</li>
            <li><a href="#">Friends</a></li>
        </ul>
        
       <?php getmyfeed($prof_email) ;?>
        
    </body>
</html>


<?php 

}
}
else{
header('Location:customer_login.php', true, 302);
exit;
//echo "<script>window.open('customer_login.php')</script>";
}
 ?>