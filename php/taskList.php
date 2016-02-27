<div class="row">
  <a class="btn btn-info" id="storyBacklogButton" href="storyBacklog.php" style="margin-bottom:10px;"><span class="glyphicon glyphicon-arrow-left"></span> Story Backlog
  </a>
</div>
<!-- List of Tasks in Backlog -->
<h2>Task Backlog</h2>
<div class="table-responsive">        
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Task Name</th>
        <th>Task Description</th>
        <th>Estimation (Hrs)</th>
        <th>User Story Owner</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <!-- PHP Code - 1.Grab list of Tasks from the database. -->    
    <?php
      if(isset($_GET['story_id']))
      {
        $sql = mysqli_query($conn, 'SELECT * FROM task_table WHERE story_table_id = '.$_GET['story_id']);
      }
      else
      {
        $sql = mysqli_query($conn, 'SELECT * FROM task_table');
      }
      while($row = mysqli_fetch_array($sql))          
      {
        ?>
          <tr>
            <td><?php echo $row['task_name'];?></td>
            <td><?php echo $row['task_description'];?></td>
            <td><?php echo $row['task_estimation'];?></td>
            <td><?php echo $row['story_table_id'];?></td>
            <td>
              <a class="btn btn-info" id="taskButton" href="taskBacklog.php?task_id=<?php echo $row['id'];?>">Go To <span class="glyphicon glyphicon-arrow-right"></span>
              </a>
            </td>
            <td>
              <a class="btn btn-danger" id="removeButton" href="taskBacklog.php?<?php if(isset($_GET['story_id'])){echo 'story_id='. $_GET["story_id"];}?>&remove=<?php echo $row['id'];?>">
                Remove <span class="glyphicon glyphicon-remove"></span>
              </a>
            </td>
            </tr>
        <?php
      }
    ?>
    </tbody>
  </table> 
</div>