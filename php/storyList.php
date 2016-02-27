<!-- PHP Code - 1.Grab list of Stories from the database. -->
<?php
  if(isset($_GET['epic_id']))
  {
    $sql = mysqli_query($conn, 'SELECT * FROM story_table WHERE epic_table_id = '.$_GET['epic_id']);
  }
  else
  {
    $sql = mysqli_query($conn, 'SELECT * FROM story_table');
  }
  while($row = mysqli_fetch_array($sql))          
  {
    $sql2 = mysqli_query($conn, 'SELECT COUNT(*) FROM task_table WHERE story_table_id = ' .$row['id']);
    $result = mysqli_fetch_array($sql2);
    ?>
      <tr>
        <td><?php echo $row['story_name'];?></td>
        <td><?php echo $row['story_description'];?></td>
        <td><?php echo $row['story_priority'];?></td>
        <td><?php echo $row['story_estimation'];?></td>
        <td><?php echo $row['epic_table_id'];?></td>
        <td><?php echo $result[0];?></td>
        <td>
          <a class="btn btn-info" id="tasksButton" href="taskBacklog.php?story_id=<?php echo $row['id'];?>">
            Tasks <span class="glyphicon glyphicon-arrow-right"></span>
          </a>
        </td>
        <td>
          <a class="btn btn-danger" id="removeButton" href="storyBacklog.php?<?php if(isset($_GET['epic_id'])){echo 'epic_id='. $_GET["epic_id"];}?>&remove=<?php echo $row['id'];?>">
            Remove <span class="glyphicon glyphicon-remove"></span>
          </a>
        </td>
        </tr>
    <?php
  }
?>