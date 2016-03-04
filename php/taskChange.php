<?php
  $update_total_spent = 'UPDATE task_table SET task_hours_spent = '. $_POST['task_hours_spent'] .' WHERE id = '. $_GET['updateTask'];
  $change_date =  date('Y-m-d', strtotime($_POST['change_date']));
  $check_entry = mysqli_query($conn, 'SELECT * FROM change_table WHERE change_date = "'. $change_date .'" AND task_table_id = '. $_GET['updateTask']);
  if(mysqli_num_rows($check_entry) == 0)
  {
    $sqlQuery = 'INSERT INTO change_table (task_table_id, change_date, task_hours_remaining) VALUES ('. $_GET['updateTask'] .', "'. $change_date .'",'. $_POST['task_hours_remaining'].')';
  }
  else
  {
    $sqlQuery = 'UPDATE change_table SET task_hours_remaining = '. $_POST['task_hours_remaining'] .' WHERE task_table_id = '. $_GET['updateTask'] .' AND change_date = "'. $change_date.'"';
  }
  $success_count = 0;
  if ($conn->query($update_total_spent) == TRUE) 
  {
    $success_count = $success_count + 1;
  }
  else
  {
    echo '<div class="alert alert-failure"><strong>Error!</strong>updatehours' . $update_total_spent . '<br>' . $conn->error . '</div>';
  }
	if ($conn->query($sqlQuery) === TRUE) 
  {
    $success_count = $success_count + 1;
  } 
  else 
  {
    echo '<div class="alert alert-failure"><strong>Error!</strong>change add' . $sqlQuery . '<br>' . $conn->error . '</div>';
  }
  if($success_count == 2)
  {
    echo '<div class="alert alert-success"><strong>Success!</strong> Changes have been made successfully!</div>';
  }

?>