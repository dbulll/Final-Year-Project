<!-- PHP Code - 1.Grab list of Stories from the database. -->
<?php
  if(isset($_GET['epic_id']))
  {
    $sql = mysqli_query($conn, 'SELECT a.*, b.epic_name FROM story_table a, epic_table b WHERE a.epic_table_id = b.id AND epic_table_id = '.$_GET['epic_id']);
  }
  else
  {
    $sql = mysqli_query($conn, 'SELECT a.*, b.epic_name FROM story_table a, epic_table b WHERE a.epic_table_id = b.id');
  }
  while($row = mysqli_fetch_array($sql))          
  {
    $sql2 = mysqli_query($conn, 'SELECT * FROM task_table WHERE story_table_id = ' .$row['id']);
    $story_estimation = mysqli_query($conn, 'SELECT SUM(task_estimation) AS story_estimation FROM task_table WHERE story_table_id = '.$row['id']);
    $row2 = mysqli_fetch_array($story_estimation);
    ?>
      <tr>
        <td><?php echo $row['story_name'];?></td>
        <td><?php echo $row['story_description'];?></td>
        <td><?php echo $row['story_priority'];?></td>
        <td><?php echo $row2['story_estimation'];?></td>
        <td><?php echo $row['epic_name'];?></td>
        <td><?php echo mysqli_num_rows($sql2);?></td>
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