<div class="row">
  <!-- PHP Code - 1.Insert new Story into the database -->
  <?php
    $story_name = $_POST['story_name'];
    $story_description = $_POST['story_description'];
    $story_priority = $_POST['story_priority'];
    $story_estimation = $_POST['story_estimation'];
    $story_epic = $_POST['story_epic'];
    $story_sprint_id = '0';
    $sql = 'INSERT INTO story_table (story_name, story_description, story_priority, story_estimation, epic_table_id) VALUES ("'. $story_name .'", "'. $story_description .'", "'. $story_priority .'", '. $story_estimation .', '. $story_epic .')';
    if ($conn->query($sql) === TRUE) 
    {
      echo '<div class="alert alert-success"><strong>Success!</strong> Story has been successfully created!</div>';
    } 
    else 
    {
      echo '<div class="alert alert-failure"><strong>Error!</strong> ' . $sql . '<br>' . $conn->error . '</div>';
    }
  ?>
</div>