
<!-- PHP Code - 1.Grab list of Tasks from the database. -->    
<?php
  if(isset($_GET['story_id']))
  {
    $sql = mysqli_query($conn, 'SELECT a.*, b.story_name FROM task_table a, story_table b WHERE a.story_table_id = b.id AND story_table_id = '.$_GET['story_id']);
  }
  else
  {
    $sql = mysqli_query($conn, 'SELECT a.*, b.story_name FROM task_table a, story_table b WHERE a.story_table_id = b.id');
  }
  while($row = mysqli_fetch_array($sql))          
  {
    $remaining_hours = $row['task_hours_estimation'];
    $remaining_task_hours = mysqli_query($conn, 'SELECT task_hours_remaining FROM change_table WHERE task_table_id = '. $row['id'] .' ORDER BY change_date DESC');
    if(mysqli_num_rows($remaining_task_hours) > 0)
      {
        $remaining_hours_array = mysqli_fetch_array($remaining_task_hours);
        $remaining_hours = $remaining_hours_array[0];
      }
    ?>
      <tr>
        <td><?php echo $row['task_name'];?></td>
        <td><?php echo $row['task_description'];?></td>
        <td><?php echo $row['story_name'];?></td>
        <td><?php echo $row['task_hours_estimation'];?></td>
        <td><?php echo $remaining_hours;?></td>
        <td>
          <a class="btn btn-danger" id="removeButton" href="taskBacklog.php?<?php if(isset($_GET['story_id'])){echo 'story_id='. $_GET["story_id"];}?>&remove=<?php echo $row['id'];?>">
            Remove <span class="glyphicon glyphicon-remove"></span>
          </a>
        </td>
        </tr>
    <?php
  }
?>