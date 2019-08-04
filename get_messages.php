<?php 
include('includes/db.php');
include('functions/functions.php');
session_start() ;
if(isset($_SESSION['customer_email'])){
if(isset($_POST['my_email']) && isset($_POST['friends_email'])){
$my_email = $_POST['my_email'] ;
$friends_email = $_POST['friends_email'];
$get_message_q = "select * from customerMsgs where (my_email = '$my_email' or my_email='$friends_email') AND (friends_email = '$friends_email' OR friends_email = '$my_email') order by sl_no desc LIMIT 10";

$run_get_message_q = mysqli_query($db,$get_message_q);

while($messages = mysqli_fetch_array($run_get_message_q)){
$messages_my_email = $messages['my_email'];

$message = $messages['my_message'];

if($messages_my_email == $my_email){
echo "<div class=\"user_msg\">".$message. "</div><br><br><br><br>";
}
else{
echo "<div class=\"frnd_msg\">".$message."</div><br><br><br><br>";
}
}
    }   
}
else{
header('Location:customer_login.php', true, 302);
exit;
//echo "<script>window.open('customer_login.php')</script>";
}
?>