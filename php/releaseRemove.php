<!-- PHP Code - 1.Remove Release by the given id. -->
<?php
  $sql = 'DELETE FROM release_table WHERE id = ' . $_GET['remove'];
  if ($conn->query($sql) === TRUE) 
  {
   echo '<div class="alert alert-success"><strong>Success!</strong> Release has been successfully removed.</div>';
  } 
  else 
  {
    echo '<div class="alert alert-failure"><strong>Error!</strong> ' . $sql . '<br>' . $conn->error . '</div>';
  }
?>