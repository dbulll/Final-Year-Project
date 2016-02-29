<!-- PHP Code - 1.Remove Epic by the given id. -->
<?php
  $sql = 'DELETE FROM epic_table WHERE id = ' . $_GET['remove'];
  if($conn->query($sql) === TRUE)
  {
    echo '<div class="alert alert-success"><strong>Success!</strong> The Epic and all associated User Stories have been successfully removed.</div>';
  } 
  else 
  {
    echo '<div class="alert alert-failure"><strong>Error!</strong> ' . $sql . '<br>' . $conn->error . '</div>';
  }
?>