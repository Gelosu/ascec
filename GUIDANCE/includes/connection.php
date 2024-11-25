<?php
$server = "127.0.0.1";
$username = "root";
$password = "12345";
$database = "hms_db";
$connection = mysqli_connect("$server","$username","$password");
$select_db = mysqli_select_db($connection, $database);
if(!$select_db)
{
	echo("connection terminated");
}
?>