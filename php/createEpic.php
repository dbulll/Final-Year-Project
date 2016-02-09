<?php

//make the connection
$conn = new mysqli('localhost', 'root', '', 'tempdb'); //change user name to yours
if($conn->connect_errno > 0)
{
  die('Unable to connect to database [' . $conn->connect_error . ']');
}

//$first_name = "Nipan2";
//$last_name = "Maniar2";
//$email ="admin";
//$password = "test123";

$sql = "INSERT INTO tablethree(epicName, epicDescription) VALUES ('epictest134', 'epicsarecool')";
  if ($conn->query($sql) === TRUE) 
  {
   echo "New record created successfully";
  } 
  else 
  {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
$conn->close();


?>