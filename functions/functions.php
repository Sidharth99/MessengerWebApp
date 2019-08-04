<?php
//establishing connection
$db = mysqli_connect("localhost","root","","socialnet");

//function for getting the IP address

function getRealIpAddr(){
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		//check ip from share internet
	 $ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		//check ip is pass from proxy
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function is_friends($my_email,$unknown_email){
global $db;
if($my_email == $unknown_email){
return True;
}else{
$is_friends = "select status from requests where (requested_by_email='$my_email' OR requested_by_email='$unknown_email')  AND (requested_to_email='$my_email' OR requested_to_email='$unknown_email')";
$run_is_friends = mysqli_query($db, $is_friends) ;
while($rows_is_friends = mysqli_fetch_array($run_is_friends)){
$status = $rows_is_friends['status'] ;
if($status=='Friends'){
return True;
}else{
return False;
}
}
}
}



function is_liked($post_id, $customer_id){
global $db;
$is_liked = "select * from likes where post_id='$post_id' and customer_id ='$customer_id'";
$run_is_liked = mysqli_query($db, $is_liked) ;
if(mysqli_num_rows($run_is_liked) < 1){
return false;
}else{ return true;}

}

function getfeed(){
$my_email = $_SESSION['customer_email'];
global $db;
  $getfeed = "select * from customerfeed order by sl_no desc";
  $runfeed = mysqli_query($db,$getfeed);
  while($feeddata = mysqli_fetch_array($runfeed)){
  $post_id = $feeddata['sl_no'] ;
  $feed_name = $feeddata['customer_name'] ;
  $feed_profile = $feeddata['profile_photo'] ;
  $feed_upload = $feeddata['upload_photo'] ;
  $feed_msg = $feeddata['customer_message'];
  $feed_time = $feeddata['time'] ;
  $feed_email = $feeddata['customer_email'] ;
  $feed_id = $feeddata['customer_id'] ;
  if(is_friends($my_email, $feed_email)){
  if(substr($feed_upload,-3)=="mp4"){
  echo "
  <div style=\"margin-top:18vw; background-color:#eee; padding:5vw;width:105vw; height:auto;margin-left:-5vw\"><span style=\"margin-left:5vw;font-size:4vw;\"> <a style=\"text-decoration:none;color:#000;\" href=\"others_profile.php?c_id=$feed_id \"> <b>$feed_name</b></a> uploaded a <b> video</b></span>";
  }else if(substr($feed_upload,-3)=="jpg"||substr($feed_upload,-3)=="png"){
  echo "
  <div style=\"margin-top:18vw; background-color:#eee; padding:5vw;width:105vw; height:auto;margin-left:-5vw\"><span style=\"margin-left:5vw;font-size:4vw;\"> <a style=\"text-decoration:none;color:#000;\" href=\"others_profile.php?c_id=$feed_id \"> <b>$feed_name</b></a> uploaded a <b> photo</b></span>";
  }else{
  echo "
  <div style=\"margin-top:18vw; background-color:#eee; padding:5vw;width:105vw; height:auto;margin-left:-5vw\"><span style=\"margin-left:5vw;font-size:4vw;\"> <a style=\"text-decoration:none;color:#000;\" href=\"others_profile.php?c_id=$feed_id \"> <b>$feed_name</b></a> uploaded a <b> status</b></span>";}
          echo " <span><a style=\"text-decoration:none;\" href=\"others_profile.php?c_id=$feed_id\"> <img src=\"customer/customer_photos/$feed_profile\" height=\"150vw\" width=\"150vw\" style=\"border-radius:50%; position:relative;float:left;\"></a></span>
           <div style=\"margin-left:20vw;color:grey;font-size:4vw;width:80vw\">$feed_time</div><div id=\"feed_message\" style=\"margin-top:10vw;width:100vw;font-size:3vw;\">$feed_msg</div>
           ";
           if(substr($feed_upload,-3)=="mp4"){
           echo "
           <div style=\"align:center;width:100vw;\"> <video controls autoplay loop width=80% height=auto style=\"min-width:80vw;margin-left:15%;margin-top:2vw;align:center;\">
   <source src=\"customer/$feed_email/images/$feed_upload\" type=\"video/mp4\">
   
   Video is not supported by your browser
</video></div>";
           }else if(substr($feed_upload,-3)=="jpg"||substr($feed_upload,-3)=="png"){
           echo "
           <div><img src=\"customer/$feed_email/images/$feed_upload\" width=100% height=auto style=\"min-width:110vw; margin-top:2vw;\"></div>";}
           
           echo "
            <ul id=\"like_menu\">
               <li onclick=insert_like($post_id) id=like_$post_id>Like</li>
               <li onclick=toggle($post_id)>Comment</li>
               <li>Share</li>
           </ul>
           
           
           
           <div style=\"display:none;min-height:30vw;max-height:100vw;width:100vw;overflow:scroll;\" class=\"comment\" id=$post_id>
           
           
           <input id=comment_$post_id style=\"font-size:4vw;width:75vw;height:6vw;\" type=\"text\" placeholder=\"write comment here\">
           <input onclick=insert_comment($post_id) name='comment' style=\"font-size:4vw;width:20vw;height:6vw;\" type=\"submit\" value=\"Submit\">
              
               <br/><br><br>
               
               <div id=comment_section_$post_id>";
               
 echo "<script> get_likes($post_id) ;
               </script>";
   /*            
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
               
   */
   
   echo "
</div>
    </div>
   
   
      </div>
  ";
  
  }
  
  }
}


/*
function getfeed(){
$my_email = $_SESSION['customer_email'] ;
global $db;
$check_friends = "select * from requests where status = 'Friends'";
$run_check_friends = mysqli_query($db, $check_friends);
while($checking = mysqli_fetch_array($run_check_friends)){
$email_one = $checking['requested_by_email'] ;
$email_two = $checking['requested_to_email'];
if($my_email == $email_one){
$friends_email = $email_two;
}
else{
$friends_email = $email_one;
}

  $getfeed = "select * from customerfeed where (customer_email = '$friends_email') order by sl_no desc";
  $runfeed = mysqli_query($db,$getfeed);
  while($feeddata = mysqli_fetch_array($runfeed)){
  $feed_name = $feeddata['customer_name'] ;
  $feed_profile = $feeddata['profile_photo'] ;
  $feed_upload = $feeddata['upload_photo'] ;
  $feed_msg = $feeddata['customer_message'];
  $feed_time = $feeddata['time'] ;
  $feed_email = $feeddata['customer_email'] ;
  
  echo "
  <div style=\"margin-top:18vw; background-color:#eee; padding:5vw;width:105vw; height:auto;margin-left:-5vw\"><span style=\"margin-left:5vw;font-size:4vw;\">  <b>$feed_name</b> uploaded a <b> photo</b></span>
           <span> <img src=\"customer/customer_photos/$feed_profile\" height=\"150vw\" width=\"150vw\" style=\"border-radius:50%; position:relative;float:left;\"></span>
           <div style=\"margin-left:20vw;color:grey;font-size:4vw;width:80vw\">$feed_time</div><div id=\"feed_message\" style=\"margin-top:10vw;width:100vw;font-size:3vw;\">$feed_msg</div>
           <div><img src=\"customer/$feed_email/images/$feed_upload\" width=100% height=auto style=\"min-width:110vw; margin-top:2vw;\"></div>
           <ul id=\"like_menu\">
              <li>Like</li>
              <li>Comment</li>
              <li>Share</li>
          </ul>
       </div>
  ";
  }
}
}

*/

function getmyfeed($myemail){
//$myemail = $_SESSION['customer_email'] ;
global $db;
  $getfeed = "select * from customerfeed where customer_email = '$myemail' order by sl_no desc";
  $runfeed = mysqli_query($db,$getfeed);
  while($feeddata = mysqli_fetch_array($runfeed)){
  $post_id = $feeddata['sl_no'] ;
  $feed_name = $feeddata['customer_name'] ;
  $feed_profile = $feeddata['profile_photo'] ;
  $feed_upload = $feeddata['upload_photo'] ;
  $feed_msg = $feeddata['customer_message'];
  $feed_time = $feeddata['time'] ;
  $feed_email = $feeddata['customer_email'] ;
  
  if(substr($feed_upload,-3)=="mp4"){
  echo "
  <div style=\"margin-top:18vw; background-color:#eee; padding:5vw;width:105vw; height:auto;margin-left:-5vw\"><span style=\"margin-left:5vw;font-size:4vw;\"> <b>$feed_name</b> uploaded a <b> video</b></span>";
  }else if(substr($feed_upload,-3)=="jpg"||substr($feed_upload,-3)=="png"){
  echo "
  <div style=\"margin-top:18vw; background-color:#eee; padding:5vw;width:105vw; height:auto;margin-left:-5vw\"><span style=\"margin-left:5vw;font-size:4vw;\">  <b>$feed_name</b> uploaded a <b> photo</b></span>";
  }else{
  echo "
  <div style=\"margin-top:18vw; background-color:#eee; padding:5vw;width:105vw; height:auto;margin-left:-5vw\"><span style=\"margin-left:5vw;font-size:4vw;\">  <b>$feed_name</b> uploaded a <b> status</b></span>";}
  echo "
           <span> <img src=\"customer/customer_photos/$feed_profile\" height=\"150vw\" width=\"150vw\" style=\"border-radius:50%; position:relative;float:left;\"></span>
           <div style=\"margin-left:20vw;color:grey;font-size:4vw;width:80vw\">$feed_time</div><div id=\"feed_message\" style=\"margin-top:10vw;width:100vw;font-size:3vw;\">$feed_msg</div>";
           if(substr($feed_upload,-3)=="mp4"){
           echo "
           <div style=\"align:center;width:100vw;\"> <video controls autoplay loop width=80% height=auto style=\"min-width:80vw;margin-left:15%;margin-top:2vw;align:center;\">
   <source src=\"customer/$feed_email/images/$feed_upload\" type=\"video/mp4\">
   
   Video is not supported by your browser
</video></div>";
           }else if(substr($feed_upload,-3)=="jpg"||substr($feed_upload,-3)=="png"){
           echo "
           <div><img src=\"customer/$feed_email/images/$feed_upload\" width=100% height=auto style=\"min-width:110vw; margin-top:2vw;\"></div>";}
           
           echo "
            <ul id=\"like_menu\">
               <li onclick=insert_like($post_id) id=like_$post_id>Like</li>
               <li onclick=toggle($post_id)>Comment</li>
               <li>Share</li>
           </ul>
           
           
           
           <div style=\"display:none;min-height:30vw;max-height:100vw;width:100vw;overflow:scroll;\" class=\"comment\" id=$post_id>
           
           
           <input id=comment_$post_id style=\"font-size:4vw;width:75vw;height:6vw;\" type=\"text\" placeholder=\"write comment here\">
           <input onclick=insert_comment($post_id) name='comment' style=\"font-size:4vw;width:20vw;height:6vw;\" type=\"submit\" value=\"Submit\">
              
               <br/><br><br>
               
               <div id=comment_section_$post_id>";
               
 echo "<script> get_likes($post_id) ;
               </script>";
   
   
   echo "
</div>
    </div>
   
   
      </div>
  ";
  }
}


					
function get_messages($my_email, $friends_email){
global $db;
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


function chatted_with(){
global $db;
$my_id = getmyid() ;
$email = $_SESSION['customer_email'];
$name_array = array();
$id_array = array();
$pic_array = array();
$msg_array = array();
$chatted_with_q = "select * from customerMsgs where my_email='$email' or friends_email='$email' order by sl_no ";
$run_chatted = mysqli_query($db, $chatted_with_q) ;
$count = 0;
while($chatted = mysqli_fetch_array($run_chatted)){
$my_email_array[$count] = $chatted['my_email'] ;
  $name_array[$count] = $chatted['friends_name'];
  $pic_array[$count] = $chatted['friends_pic'];
  $msg_array[$count] = $chatted['my_message'];
  $id_array[$count] = $chatted['friends_id'] ;
  //echo $name_array[$count];
  $count++;
  
  }
  $new_array=array() ;
  $new_id_array = $id_array;
  for($x=0;$x<sizeof($id_array);$x++){
  $new_array[$id_array[$x]] = array($id_array[$x],$name_array[$x], $pic_array[$x], $msg_array[$x], $my_email_array[$x]);
 
  }
  
  for($k=0;$k<sizeof($id_array);$k++){
    for($l=0;$l<sizeof($id_array)-1;$l++){
    // for ascending order '<' and descending order '>'
        if($id_array[$k] > $id_array[$l]){
            $temp = $id_array[$k];
            $id_array[$k] = $id_array[$l];
            $id_array[$l] = $temp;
        }
    }
}

  
  
  if(sizeof($id_array)>0){
 
 /*$chatted_with_name = $name_array[sizeof($id_array)-1];
  $chatted_with_pic = $pic_array[sizeof($id_array)-1];
  $chatted_with_msg = $msg_array[sizeof($id_array)-1];
  $chatted_with_id = $new_id_array[sizeof($id_array)-1] ;
  
  echo "<a style=\"text-decoration:none;color:#000;\" href=\"message.php?msg_id=$chatted_with_id\"><div style=\"font-size:4vw;width:100vw\">
        <span> <img src=\"customer/customer_photos/$chatted_with_pic\" height=\"100vw\" width=\"100vw\" style=\"border-radius:; position:relative;float:left;\"></span><span style=\"margin-left:5vw;\"><b>$chatted_with_name</b></span><div style=\"margin-left:15vw;\">$chatted_with_msg</div>
       <br><hr>
   </div></a>" ;*/
  for($j=0;$j<sizeof($id_array);$j++){
 if($j<sizeof($id_array)-1){
  if($id_array[$j] != $id_array[$j+1]){
  $chatted_with_name = $new_array[$id_array[$j]][1];
  $chatted_with_pic = $new_array[$id_array[$j]] [2];
  $chatted_with_msg = $new_array[$id_array[$j]][3];
  $chatted_with_id = $new_array[$id_array[$j]][0] ;
  $chatted_with_myemail = $new_array[$id_array[$j]][4] ;
  /*
  if($chatted_with_myemail == $email){
  $fetch_customer_query = "select * from customers where customer_email='$chatted_with_myemail'";
  $run_fetch = mysqli_query($db, $fetch_customer_query) ;
  while($fetch_chatted=mysqli_fetch_array($run_fetch)){
  $chatted_name = $fetch_chatted['customer_name'] ;
  $chatted_email = $fetch_chatted['customer_email'] ;
  $chatted_pic = $fetch_chatted['customer_image'] ;
  $chatted_id = $fetch_chatted['id'] ;
   echo "<a style=\"text-decoration:none;color:#000;\" href=\"message.php?msg_id=$chatted_with_id\"><div style=\"font-size:4vw;width:100vw\">
        <span> <img src=\"customer/customer_photos/$chatted_pic\" height=\"100vw\" width=\"100vw\" style=\"border-radius:; position:relative;float:left;\"></span><span style=\"margin-left:5vw;\"><b>$chatted_name</b></span><div style=\"margin-left:15vw;\">$chatted_with_msg</div>
       <br><hr>
   </div></a>" ;
  }
  
  }else{*/
  
  if($my_id == $chatted_with_id){
  
  
  $fetch_customer_query = "select * from customers where customer_email='$chatted_with_myemail'";
  $run_fetch = mysqli_query($db, $fetch_customer_query) ;
  while($fetch_chatted=mysqli_fetch_array($run_fetch)){
  $chatted_name = $fetch_chatted['customer_name'] ;
  $chatted_email = $fetch_chatted['customer_email'] ;
  $chatted_pic = $fetch_chatted['customer_image'] ;
  $chatted_id = $fetch_chatted['id'] ;
   echo "<a style=\"text-decoration:none;color:#000;\" href=\"message.php?msg_id=$chatted_id\"><div style=\"font-size:4vw;width:100vw\">
        <span> <img src=\"customer/customer_photos/$chatted_pic\" height=\"100vw\" width=\"100vw\" style=\"border-radius:; position:relative;float:left;\"></span><span style=\"margin-left:5vw;\"><b>$chatted_name</b></span><div style=\"margin-left:15vw;\">$chatted_with_msg</div>
       <br><hr>
   </div></a>" ;
  }
  
  
  
  
  
  }
  else{
  echo "<a style=\"text-decoration:none;color:#000;\" href=\"message.php?msg_id=$chatted_with_id\"><div style=\"font-size:4vw;width:100vw\">
        <span> <img src=\"customer/customer_photos/$chatted_with_pic\" height=\"100vw\" width=\"100vw\" style=\"border-radius:; position:relative;float:left;\"></span><span style=\"margin-left:5vw;\"><b>$chatted_with_name</b></span><div style=\"margin-left:15vw;\">$chatted_with_msg</div>
       <br><hr>
   </div></a>" ;
  }
  //}
        }
  }
        else{
  $chatted_with_name = $new_array[$id_array[$j]][1];
  $chatted_with_pic = $new_array[$id_array[$j]] [2];
  $chatted_with_msg = $new_array[$id_array[$j]][3];
  $chatted_with_id = $new_array[$id_array[$j]][0] ;
   $chatted_with_myemail = $new_array[$id_array[$j]][4] ;
   

/*if($chatted_with_myemail == $email){
  $fetch_customer_query = "select * from customers where customer_email='$email'";
  $run_fetch = mysqli_query($db, $fetch_customer_query) ;
  while($fetch_chatted=mysqli_fetch_array($run_fetch)){
  $chatted_name = $fetch_chatted['customer_name'] ;
  $chatted_email = $fetch_chatted['customer_email'] ;
  $chatted_pic = $fetch_chatted['customer_image'] ;
  $chatted_id = $fetch_chatted['id'] ;
   echo "<a style=\"text-decoration:none;color:#000;\" href=\"message.php?msg_id=$chatted_with_id\"><div style=\"font-size:4vw;width:100vw\">
        <span> <img src=\"customer/customer_photos/$chatted_pic\" height=\"100vw\" width=\"100vw\" style=\"border-radius:; position:relative;float:left;\"></span><span style=\"margin-left:5vw;\"><b>$chatted_name</b></span><div style=\"margin-left:15vw;\">$chatted_with_msg</div>
       <br><hr>
   </div></a>" ;
  }
  
  }else{*/
   if($my_id == $chatted_with_id){
   
   
   
   $fetch_customer_query = "select * from customers where customer_email='$chatted_with_myemail'";
  $run_fetch = mysqli_query($db, $fetch_customer_query) ;
  while($fetch_chatted=mysqli_fetch_array($run_fetch)){
  $chatted_name = $fetch_chatted['customer_name'] ;
  $chatted_email = $fetch_chatted['customer_email'] ;
  $chatted_pic = $fetch_chatted['customer_image'] ;
  $chatted_id = $fetch_chatted['id'] ;
   echo "<a style=\"text-decoration:none;color:#000;\" href=\"message.php?msg_id=$chatted_id\"><div style=\"font-size:4vw;width:100vw\">
        <span> <img src=\"customer/customer_photos/$chatted_pic\" height=\"100vw\" width=\"100vw\" style=\"border-radius:; position:relative;float:left;\"></span><span style=\"margin-left:5vw;\"><b>$chatted_name</b></span><div style=\"margin-left:15vw;\">$chatted_with_msg</div>
       <br><hr>
   </div></a>" ;
  }
   
   
   
   
   
   
   
   
   }
   else{
   echo "<a style=\"text-decoration:none;color:#000;\" href=\"message.php?msg_id=$chatted_with_id\"><div style=\"font-size:4vw;width:100vw\">
        <span> <img src=\"customer/customer_photos/$chatted_with_pic\" height=\"100vw\" width=\"100vw\" style=\"border-radius:; position:relative;float:left;\"></span><span style=\"margin-left:5vw;\"><b>$chatted_with_name</b></span><div style=\"margin-left:15vw;\">$chatted_with_msg</div>
       <br><hr>
   </div></a>" ;
  }
 //}
        }
  }
 
 }
 else{
 echo "<br><br><br><br><h2 style='font-size:4vw;text-align:center;'>No Messages Yet!!</h2>";
 }
  

}

/*function chatted_with(){

global $db;
$email = $_SESSION['customer_email'];
$name_array = array();
$id_array = array();
$pic_array = array();
$msg_array = array();
$chatted_with_q = "select * from customerMsgs where (my_email='$email' OR friends_email='$email') order by sl_no desc";
$run_chatted = mysqli_query($db, $chatted_with_q) ;

$count = 0;
while($chatted = mysqli_fetch_array($run_chatted)){
  $id_array[$count] = $chatted['friends_id'] ;
  $count++;
  }
if(sizeof($id_array)>0){
   for($k=0;$k<sizeof($id_array);$k++){
    for($l=0;$l<sizeof($id_array)-1;$l++){
    // for ascending order '<' and descending order '>'
        if($id_array[$k] > $id_array[$l]){
            $temp = $id_array[$k];
            $id_array[$k] = $id_array[$l];
            $id_array[$l] = $temp;
        }
    }
}
$count_two = 0;
$id_array_two = array() ;
for($j=0;$j<sizeof($id_array)-1;$j++){
  if($id_array[$j] != $id_array[$j+1]){
  $id_array_two[$count_two] = $id_array[$j] ;
  $count_two++;
  }
}
$id_array_two[sizeof($id_array_two)] = $id_array[sizeof($id_array) - 1] ;
for($m=0;$m<sizeof($id_array_two);$m++){

$test_name_array = array() ;
$test_pic_array = array() ;
$test_id_array = array() ;
$count_three = 0 ;

$test_query = "select * from customerMsgs where friends_id = '$id_array_two[$m]' AND (my_email = '$email') ";
$run_test_query = mysqli_query($db, $test_query) ;
while($test = mysqli_fetch_array($run_test_query)){
$test_name_array[$count_three] =  $test['friends_name'];
$test_pic_array[$count_three]  =  $test['friends_pic'] ;
$test_id_array[$count_three] = $test['friends_id'] ;
$test_msg_array[$count_three] = $test['my_message'] ;
$count_three++;
}
if(sizeof($test_name_array)-1 > 0){
 $chatted_with_name = $test_name_array[sizeof($test_name_array)-1];
  $chatted_with_pic = $test_pic_array[sizeof($test_name_array)-1];
  $chatted_with_msg = $test_msg_array[sizeof($test_name_array)-1];
  $chatted_with_id = $test_id_array[sizeof($test_name_array)-1] ;
  
  echo "<a style=\"text-decoration:none;color:#000;\" href=\"message.php?msg_id=$chatted_with_id\"><div style=\"font-size:4vw;width:100vw\">
        <span> <img src=\"customer/customer_photos/$chatted_with_pic\" height=\"100vw\" width=\"100vw\" style=\"border-radius:; position:relative;float:left;\"></span><span style=\"margin-left:5vw;\"><b>$chatted_with_name</b></span><div style=\"margin-left:15vw;\">$chatted_with_msg</div>
       <br><hr>
   </div></a>" ;
}
}
  }
  else{
 echo "<br><br><br><br><h2 style='font-size:4vw;text-align:center;'>No Messages Yet!!</h2>";
 }
}
*/
function getmyid(){
global $db;
$my_email = $_SESSION['customer_email'] ;
$getid = "select id from customers where customer_email='$my_email'";
$run_getid = mysqli_query($db, $getid) ;
while($det = mysqli_fetch_array($run_getid)){
$id = $det['id'] ;
return $id;
}
}


/*function chatted_with(){
global $db;
$my_email = $_SESSION['customer_email'] ;
$chatted_with = "select * from chatted_with where (my_email = '$my_email' or friends_email='$my_email') ";
$run_chatted_with = mysqli_query($db, $chatted_with) ;
while($chatted = mysqli_fetch_array($run_chatted_with)){


}

}*/
?>