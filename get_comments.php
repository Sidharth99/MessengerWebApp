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

if(isset($_POST['get_comments'])){
$post_id = $_POST['get_comments'] ;

$get_comment = "select * from comments where post_id='$post_id'";
   $run_get_comment = mysqli_query($db, $get_comment) ;
   if(mysqli_num_rows($run_get_comment)>0){
   while($comment_data = mysqli_fetch_array($run_get_comment)){
   $comment = $comment_data['comment'] ;
   $commented_by_id = $comment_data['customer_id'] ;
   
   $commented_by_data_query = "select * from customers where id='$commented_by_id'";
   $run_commented_by_data = mysqli_query($db, $commented_by_data_query) ;
   while($commented_by_data=mysqli_fetch_array($run_commented_by_data)){
   $commented_by_name = $commented_by_data['customer_name'] ;
   $commented_by_pic = $commented_by_data['customer_image'] ;
  // $commented_by_name = $commented_by_data['customer_name'] ;
   
  
  
  echo "
                <div style=\"font-size:4vw;width:100vw\">
        <span> <img src=\"customer/customer_photos/$commented_by_pic\" height=\"100vw\" width=\"100vw\" style=\"border-radius:; position:relative;float:left;\"></span><span style=\"margin-left:5vw;\"><b>$commented_by_name</b></span><div style=\"margin-left:15vw;\">$comment</div>
       <br><hr>
   </div>";
  
  }
   
   }
   }
}
}
}
?>