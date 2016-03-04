<div class="row">
  <!-- PHP Code - 1.Insert new Task into the database -->
  <?php
    $task_name = $_POST["task_name"];
    $task_description = $_POST["task_description"];
    $task_hours_estimation = $_POST["task_hours_estimation"];
    $task_story = $_POST["task_story"];
    $sql = 'INSERT INTO task_table (task_name, task_description, task_hours_estimation, story_table_id) VALUES ("'. $task_name .'", "'. $task_description. '", '. $task_hours_estimation .', '. $task_story .')';
    if ($conn->query($sql) === TRUE) 
    {
     echo '<div class="alert alert-success"><strong>Success!</strong> Task has been successfully created!</div>';
    } 
    else 
    {
      echo '<div class="alert alert-failure"><strong>Error!</strong>' . $sql . '<br>' . $conn->error . '</div>';
    }
  ?>
</div>