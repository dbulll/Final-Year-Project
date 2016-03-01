<?php
	$change_date =  date('Y-m-d', strtotime($_POST['change_date']));
	$sqlQuery = 'INSERT INTO change_table (task_table_id, change_date, task_hours_remaining) VALUES ('. $_GET['updateTask'] .', "'. $change_date .'",'. $_POST['task_hours_remaining'].')';
	if ($conn->query($sqlQuery) === TRUE) 
    {
     echo '<div class="alert alert-success"><strong>Success!</strong> Change Table Appended!</div>';
    } 
    else 
    {
      echo '<div class="alert alert-failure"><strong>Error!</strong>' . $sql . '<br>' . $conn->error . '</div>';
    }

?>