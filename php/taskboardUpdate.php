<div class="row">
  <!-- PHP Code - 1.Insert new Task into the database -->
  <?php
  if(isset($_GET['update']))
  {
    $taskNumber = 0;
    $successUpdate = 0;
    foreach ($_POST as $key => $value)
    { 
      $taskNumber= $taskNumber + 1;   
      $updateStateSql = 'UPDATE task_table SET task_state = '. $value .' WHERE id = '. $key; 
      if ($conn->query($updateStateSql) === TRUE) 
      {
        $successUpdate = $successUpdate + 1;
      }
    }
    if($taskNumber == $successUpdate)
    {
      echo '<div class="alert alert-success"><strong>Success!</strong> Story states have been successfully updated</div>';
    } 
    else 
    {
      echo '<div class="alert alert-failure"><strong>There was an Error updating some of the story states!</strong> ' . $updateStateSql . '<br>' . $conn->error . '</div>';
    }
  }
  ?>
</div>