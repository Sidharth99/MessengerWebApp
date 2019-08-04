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


if(isset($_POST['insert_like'])){
$post_id = $_POST['insert_like'] ;
if(!is_liked($post_id, $customer_id)){
$insert_like = "insert into likes (customer_id, post_id, like_status) values ('$customer_id', '$post_id', 'liked')";
$run_insert_like = mysqli_query($con, $insert_like) ;
//echo "liked";
}else{
$delete_like = "delete from likes where post_id ='$post_id' AND customer_id='$customer_id'";
$run_delete_like = mysqli_query($con, $delete_like) ;
}
}



if(isset($_POST['get_like'])){
$post_id = $_POST['get_like'] ;

$get_likes = "select * from likes where post_id='$post_id'";
$run_get_likes = mysqli_query($con, $get_likes) ;
$num_likes = mysqli_num_rows($run_get_likes) ;
if(!is_liked($post_id, $customer_id)){
echo "likes $num_likes";
}else{
echo "<span style=\"color:lightblue\">likes $num_likes</span>";
}
}
}
}