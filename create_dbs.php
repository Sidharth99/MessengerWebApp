<?php 
$servername = "localhost";
$username = "root"; 
$password = "";

// Creating a connection 
$conn = new mysqli($servername, $username, $password); // Check connection 
if ($conn->connect_error){
 die("Connection failed: " . $conn->connect_error); 
} 
 // Creating a database named newDB 
 $create_db = "CREATE DATABASE message_book"; 
 if ($conn->query($create_db) === TRUE){ 
 echo "Database created successfully with the name newDB"; 
 } else {
  echo "Error creating database: " . $conn->error;
  } 
 // closing connection 
 $conn->close();


?>