<?php 
include('includes/db.php');
include('functions/functions.php');
session_start() ;
if(isset($_SESSION['customer_email'])){
$email = $_SESSION['customer_email'];
$customer_query = "SELECT * FROM customers WHERE customer_email='$email'";
$run_customer_query = mysqli_query($con,$customer_query);
//if($run_customer_query){
while($customer = mysqli_fetch_array($run_customer_query)){
$customer_name = $customer['customer_name'];
$customer_email = $customer['customer_email'] ;
$customer_country = $customer['customer_country'] ;
$customer_city = $customer['customer_city'] ;
$customer_dob = $customer['customer_dob'];
$customer_contact = $customer['customer_contact'] ;
$customer_img = $customer['customer_image'] ;


?>

<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Social Media</title>
    <link rel="stylesheet" href="styles/style.css" media="all"/>
    
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
    </head>
    <body>
        <div align=center style="background-color:#0066aa;color:white;padding:5vw;width:100vw"><?php echo "$customer_name"; ?></div>
            
        <div id="cover">
        <img id="cover_photo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1K1hWttHpIgbv49ikeW1zTMdfWETJu6Qi0UIZFxX0wXURrkB1" width=100% height=auto style="min-width:110vw" >
        <img src="customer/customer_photos/<?php echo $customer_img;?> "width=120% height=300vw id="profile_pic"/>
        </div>
        <div align=center style="font-size:8vw;margin-top:55vw;width:100vw;"><?php echo "$customer_name"; ?></div>
        
        <div style="font-size:3vw;width:100vw;color:grey;margin-top:10vw;" align=center>Add bio to tell people more about yourself</div>
        <div align="center" style="margin-top:10vw;width:100vw;background-color:lightblue;border:3px solid blue;color:blue;padding:3vw;border-radius:5vw;margin-left:5%;">Add Bio</div>
        
        <ul style="margin-top:10px;" id="update_menu">
            <li><a href="#">Update info</a></li>
            
            <li><a href="#">Activity log</a></li>
            
            <li><a href="#">more..</a></li>
        </ul>
        
        
        <ul style="margin-top:20vw;">
            <li>Working at : <b>Not Yet Working</b></li>
            <li>Studied at :  <b>some college</b></li>
            <li>Went to : <b>some school</b></li>
            <li>Born on : <b><?php echo $customer_dob ;?></b></li>
            <li>Contact no. : <b><?php echo $customer_contact ;?></b></li>
            <li>Lives in : <b><?php echo $customer_city ;?></b></li>
            <li>From : <b><?php echo $customer_country ;?></b> </li>
            <li>email : <b><?php echo $customer_email ;?></b> </li>
            
        </ul>
        <ul style="margin-top:1vw;" id="about_menu">
            <li><a href="#">About</a></li>
            <li>|</li>
            <li><a href="#">Photos</a></li>
            <li>|</li>
            <li><a href="#">Friends</a></li>
        </ul>
        
       <?php getmyfeed($email) ;?>
       <br><br>
        <div>
        <form action='customer/logout.php' method='post'>
        <input type='submit' value='logout' style="height:5vw;width:50vw;font-size:3vw;">
        </form></div>
    </body>
</html>
<?php  }
}
//}
else{
header('Location:customer_login.php', true, 302);
exit;
//echo "<script>window.open('customer_login.php')</script>";
}

?>