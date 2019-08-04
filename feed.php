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
$customer_id = $customer['id'];
$customer_name = $customer['customer_name'];
$customer_email = $customer['customer_email'] ;
$customer_country = $customer['customer_country'] ;
$customer_city = $customer['customer_city'] ;
$customer_dob = $customer['customer_dob'];
$customer_contact = $customer['customer_contact'] ;
$customer_img = $customer['customer_image'] ;

if(isset($_POST['feedupload'])){
$uploadmsg = $_POST['uploadmsg'];
$c_image = $_FILES['file']['name'] ;
$c_image_tmp = $_FILES['file']['tmp_name'];
$feed_query = "insert into customerfeed (customer_id,customer_email,customer_name,customer_message,upload_photo,profile_photo) values ('$customer_id', '$email', '$customer_name','$uploadmsg', '$c_image', '$customer_img')";
$run_feed_query = mysqli_query($con, $feed_query);
move_uploaded_file($c_image_tmp,"customer/$email/images/$c_image");
}
if(isset($_POST['comment'])&&isset($_POST['post_id'])){
$post_id = $_POST['post_id'] ;
$comment = $_POST['comment'];
$insert_comment = "insert into comments (customer_id, post_id, comment) values ('$customer_id', '$post_id', '$comment')";
$run_insert_comment = mysqli_query($con, $insert_comment) ;
}

?><!DOCTYPE html>
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
        <div>
            <ul id="feed_menu">
                <li><a href="feed.php">Feed</a></li>
                <li><a href="requests.php">Requests</a></li>
                <li><a href="message.php">Messages</a></li>
                <li><a href="notifications.php">Notifications</a></li>
                <li><a href="search.php">Search</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
            <div style="height:5px; background-color:#ddd; margin-top:-10px;"></div>
           <span> <img src="customer/customer_photos/<?php echo $customer_img;?>" height="150vw" width="150vw" style="border-radius:50%; position:relative;float:left;margin-top:5vw;"></span> 
         
         <form action="feed.php" method = "post" enctype="multipart/form-data">
           <span><textarea name='uploadmsg' style="margin-left:25vw;  border-radius:10px; width:80vw; height:15vw; outline:none;margin-top:-15vw;font-size:3vw;" placeholder="Write Something Here.."></textarea></span>
           <input type=file name="file"><input type=submit value='Upload' name='feedupload' style="margin-top:5vw;font-size:3vw;" >
</form>

        </div>
        <hr/>
        <?php getfeed() ;?>
        
    </body>
</html>
<?php  



}
}
//}
else{
header('Location:customer_login.php', true, 302);
exit;
//echo "<script>window.open('customer_login.php')</script>";
}

?>
