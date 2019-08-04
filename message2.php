<?php 
include('includes/db.php');
include('functions/functions.php');
session_start() ;
if(isset($_SESSION['customer_email'])){

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
else{
header('Location:customer_login.php', true, 302);
exit;
//echo "<script>window.open('customer_login.php')</script>";
}
 ?>