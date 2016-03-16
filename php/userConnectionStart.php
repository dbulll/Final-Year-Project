<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'scrum_web_app_db');
if($conn->connect_errno > 0)
{
	die('Unable to connect to database [' . $conn->connect_error . ']');
}
?>