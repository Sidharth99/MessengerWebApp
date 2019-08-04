<?php
session_start();


session_destroy();

echo "<script>window.open('../customer_login.php','_self')</script>";

?>