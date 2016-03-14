<?php
  // PHP Code - 1.Grab list of Epics from the database. 2.Count user child user stories. -->
  $sql = mysqli_query($conn, 'SELECT * FROM epic_table');
  while($row = mysqli_fetch_array($sql))          
  {
    $sql2 = mysqli_query($conn, "SELECT COUNT(*) FROM `story_table` WHERE `epic_table_id` = ".$row['id']);
    $result = mysqli_fetch_array($sql2); ?>
      <tr>
        <td><?php echo $row['epic_name']; ?></td>
        <td><?php echo $row['epic_description']; ?></td>
        <td>
          <?php echo $result[0]; ?>
        </td>
        <td>
          <a class="btn btn-info" id="storiesButton" href="storyBacklog.php?epic_id=<?php echo $row['id'];?>">
            Stories <span class="glyphicon glyphicon-arrow-right"></span>
          </a>
        </td>
        <td>
          <a class="btn btn-danger" id="removeButton" href="epicBacklog.php?remove=<?php echo $row['id'];?>">
            <span class="glyphicon glyphicon-remove"></span>Remove 
          </a>
        </td>
        </tr>
    <?php
  }
  $conn->close();
?>