<?php
  $conn = new mysqli('localhost', 'root', '', 'scrum_web_app_db');
  if($conn->connect_errno > 0)
  {
    die('Unable to connect to database [' . $conn->connect_error . ']');
  }
  if(isset($_POST['epic_name']))
  {
    $epic_name = $_POST['epic_name'];
    $epic_description = $_POST['epic_description'];
    $sql = 'INSERT INTO epic_table (epic_name, epic_description) VALUES ("'. $epic_name .'", "'. $epic_description .'")';
    if ($conn->query($sql) === TRUE) 
    {
     echo '<div class="alert alert-success"><strong>Success!</strong> Epic has been successfully created.</div>';
    } 
    else 
    {
      echo '<div class="alert alert-failure"><strong>Error!</strong> ' . $sql . '<br>' . $conn->error . '</div>';
    }
  }
?>