<?php 

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "message_book"; 

// checking connection 
$conn = new mysqli($servername, $username, $password, $dbname); 

// Check connection 
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); 
} 

// Drop all tables
$conn->query('SET foreign_key_checks = 0');
if ($result = $conn->query("SHOW TABLES")) { 
 while($row = $result->fetch_array(MYSQLI_NUM)){ 
 $conn->query('DROP TABLE IF EXISTS '.$row[0]); 
 } }

// sql code to create tables

$create_customer = "CREATE TABLE customers (id INT PRIMARY KEY AUTO_INCREMENT, customer_name VARCHAR(100) NOT NULL, customer_email VARCHAR(200), customer_pass VARCHAR(225), customer_country VARCHAR(100), customer_city VARCHAR(100), customer_contact VARCHAR(100), customer_address VARCHAR(255), customer_image VARCHAR(255), customer_ip VARCHAR(200), customer_dob VARCHAR(200))";

$create_feed = "CREATE TABLE customerfeed (sl_no INT PRIMARY KEY AUTO_INCREMENT, customer_id INT(2), customer_email VARCHAR(200), customer_name VARCHAR(100), customer_message VARCHAR(250), time TIMESTAMP, upload_photo VARCHAR(250), profile_photo VARCHAR(250))";

$create_request = "CREATE TABLE requests (sl_no INT PRIMARY KEY AUTO_INCREMENT, requested_by_email VARCHAR(200), requested_to_email VARCHAR(200), requested_to_id INT(2), status VARCHAR(200))";

$create_like = "CREATE TABLE likes (sl_no INT PRIMARY KEY AUTO_INCREMENT, customer_id INT(2), post_id INT(2), like_status VARCHAR(200))";

$create_comment = "CREATE TABLE comments (sl_no INT PRIMARY KEY AUTO_INCREMENT, customer_id INT(2), post_id INT(2), comment VARCHAR(255))";

$create_chatted_with = "CREATE TABLE chatted_with (sl_no INT PRIMARY KEY AUTO_INCREMENT, my_email VARCHAR(255), my_message VARCHAR(255), friends_id INT(2), friends_name VARCHAR(255), friends_email VARCHAR(255), friends_pic VARCHAR(255))";

$create_message = "CREATE TABLE customerMsgs (sl_no INT PRIMARY KEY AUTO_INCREMENT, my_email VARCHAR(255), my_message VARCHAR(255), friends_id INT(2), friends_name VARCHAR(255), friends_email VARCHAR(255), friends_pic VARCHAR(255))";

if ($conn->query($create_customer) === TRUE && $conn->query($create_feed) === TRUE && $conn->query($create_request) === TRUE && $conn->query($create_like) === TRUE && $conn->query($create_comment) === TRUE && $conn->query($create_message) === TRUE && $conn->query($create_chatted_with) === TRUE) { 
echo "Tables created successfully"; 
} else { 
echo "Error creating table: " . $conn->error; 
 } 

$conn->close();

?>