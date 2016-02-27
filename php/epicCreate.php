<!-- PHP Code - 1.Insert new Epic into the database -->
<?php
  $epic_name = $_POST['epic_name'];
  $epic_description = $_POST['epic_description'];
  $sql = 'INSERT INTO epic_table (epic_name, epic_description) VALUES ("'. $epic_name .'", "'. $epic_description .'")';
  if ($conn->query($sql) === TRUE) 
  {
   echo '<div class="alert alert-success"><strong>Success!</strong> Epic has been successfully created!</div>';
  } 
  else 
  {
    echo '<div class="alert alert-failure"><strong>Error!</strong> ' . $sql . '<br>' . $conn->error . '</div>';
  }
?>