<!-- PHP Code - 1.Grab list of Releases from the database. -->
<?php
  $sql = mysqli_query($conn, 'SELECT * FROM release_table');
  while($row = mysqli_fetch_array($sql))          
  {
    ?>
      <tr>
        <td><?php echo $row['release_name'];?></td>
        <td><?php echo $row['release_description'];?></td>
        <td><?php echo $row['release_start_date'];?></td>
        <td><?php echo $row['release_end_date'];?></td>
        <td><?php echo $row['release_sprint_length'];?></td>
        <td><?php echo $row['release_work_hours'];?></td>
        <td>
          <a class="btn btn-info" id="sprintsButton" href="sprintPlanning.php?release_id=<?php echo $row['id'];?>">
            Sprints <span class="glyphicon glyphicon-arrow-right"></span>
          </a>
        </td>
        <td>
          <a class="btn btn-danger" id="removeButton" href="releasePlanning.php?remove=<?php echo $row['id'];?>">
            Remove <span class="glyphicon glyphicon-remove"></span>
          </a>
        </td>
        </tr>
    <?php
  }
$conn->close();
?>